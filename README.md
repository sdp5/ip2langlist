ip2langlist
-----------

ip2langlist is a rest webservice which takes public IPv4 as input and return a list of languages with their locales of the country, queried IP belongs to. It uses IP Geolocation mechanism to determine country.

This webservice could be consumed to cater websites in country specific languages using i18n methods.
Or, to narrow the search results.
Or, to be specific while providing services, so on ... 

Currently no API-Key is required. 

Response Format Supported: XML and JSON

Webservice exception message is returned upon reaching access limit of 10,000 hits per 24 hrs
Or, an invalid IPv4.
