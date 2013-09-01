<?php

// INCLUDE FILES
include("geoip.inc");

// GLOBAL VARIABLES
$GLOBALS['COUNTRY_DB'] = "GeoIP.dat";
$GLOBALS['LOCALE_DB'] = "countryLang.pair";
$GLOBALS['LANG_DB'] = "locale.pair";

// GET COUNTRY-CODE FOR GIVEN IP

function getCountryCode($queryip)
{
	$gi = geoip_open($GLOBALS['COUNTRY_DB'],GEOIP_STANDARD);
	$country_code = geoip_country_code_by_addr($gi, $queryip);
	geoip_close($gi);
	
	return $country_code;
}

// GET LANG-LIST OF GIVEN COUNTRY-CODE

function getLocaleList($queryip)
{
	$countryCode = getCountryCode($queryip);
	$file = fopen($GLOBALS['LOCALE_DB'], "r");
	while(!feof($file))
  	{
  		$tmp = fgets($file);
		if(substr($tmp,0,2) == $countryCode)
		$return = substr($tmp,3);
  	}
	fclose($file);
	return $return;
}

function getLang($locale)
{
	$file = fopen($GLOBALS['LANG_DB'], "r");
	while(!feof($file))
  	{
  		$tmp = fgets($file);
		if($locale == substr($tmp,0,strpos($tmp, "="))) $return = trim($tmp);
  	}
	fclose($file);
	return $return;
}

function getLangList($queryip)
{
	$locale_list = getLocaleList($queryip);
	$locale_array =	explode(",", $locale_list);
	
	$lang_list = array();
	
	foreach ($locale_array as $value)
	{
		$tmp = getLang(trim($value));
		if($tmp) array_push($lang_list,$tmp);
		else array_push($lang_list,trim($value));
	}
	
	return $lang_list;
}

// RENDERING RESPONSE

function getResponse($ip, $format) {

if($format == 'json') 
{
	header('Content-type: application/json');
	echo json_encode(getLangList($ip));
}
else
	{
		header('Content-type: text/xml');
		echo "<langlist CountryCode='".getCountryCode($ip)."'>";
		foreach(getLangList($ip) as $key => $value)
		{
			$tmp = $value;
			if(strpos($tmp,"="))
			{
				$locale = substr($tmp,0,strpos($tmp,"="));
				$lang = substr($tmp,strpos($tmp,"=")+1);
			}
			else $locale = $lang = $tmp;
	
			echo "<lang locale='".$locale."' >".$lang."</lang>";
		}
		echo '</langlist>';
	}

}

?>