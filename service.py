# Copyright 2016 sundeep.co.in@gmail.com.
# All Rights Reserved.
#
# Licensed under the Apache License, Version 2.0 (the "License"); you may
# not use this file except in compliance with the License. You may obtain
# a copy of the License at
#
# http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
# WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
# License for the specific language governing permissions and limitations
# under the License.

import os
from flask import jsonify
from flask import Flask
import maxminddb

application = Flask(__name__)
cur_dir = os.path.dirname(__file__)

reader = maxminddb.open_database(
    os.path.join(cur_dir, 'GeoLite2-Country.mmdb')
)


@application.route("/ip/<ip_address>")
def home(ip_address):
    locales = []
    response_json = {}
    geo_info = reader.get(ip_address)
    if geo_info:
        country_code = geo_info.get('country', {}).get('iso_code', '')
        response_json['country'] = {"country_code": country_code}
        if country_code:
            with open(os.path.join(cur_dir, 'countryLang.pair')) as f1:
                for line in f1:
                    if line.startswith(country_code):
                        locales.extend(line.strip().split("=")[1].split(","))
                        break
        if locales:
            response_json['languages'] = {}
            with open(os.path.join(cur_dir, 'locale.pair')) as f2:
                langs = f2.readlines()
                response_json['languages'].update({lang.strip().split("=")[0]: lang.strip().split("=")[1]
                                                   for lang in langs if lang.split("=")[0] in locales})
    else:
        response_json.update({"Error": "Something unexpected Happened."})
    return jsonify(response_json)


if __name__ == "__main__":
    application.run(host='0.0.0.0')
