ip2langlist

ip2langlist is a rest webservice which takes public IPv4 as input and return a list of languages with their locales of the country, queried IP belongs to. It uses IP Geolocation mechanism to determine country.

This webservice could be consumed to cater websites in country specific languages using i18n methods.
Or, to narrow the search results.
Or, to be specific while providing services, so on ... 

Currently no API-Key is required. 

XML
http://api.cloudptr.com/langlist/ip/196.1.113.0 

JSON
http://api.cloudptr.com/langlist/json/ip/196.1.113.0 

Webservice exception message is returned upon reaching access limit of 10,000 hits per 24 hrs
Or, an invalid IPv4.
