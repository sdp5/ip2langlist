<?php

//  this will serve xml/json response

require_once("service.php");

// GLOBAL VARS

$GLOBALS['PID_LOCATION'] = "breadth/";
$GLOBALS['ACCESS_LIMIT'] = 11520;

// VALIDATE IP

function validateIP($ip)
{
	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE))
	{
    	return true;
	}
	return false;
}

// VALIDATE PID

function validatePID($from)
{
	$return = false;
	$file = $GLOBALS['PID_LOCATION'].$from;
	
	if(file_exists($file))
	{
		$handle = fopen($file,'r');
		$data = fread($handle,filesize($file));
		if($data > 0) 
		{
			$data = $data-1;
			$return = true;
		}
		fclose($handle);
		
		$handle = fopen($file,'w');
		fwrite($handle, $data);
		fclose($handle);
	}
	else
	{
		$handle = fopen($GLOBALS['PID_LOCATION'].$from, 'w');
		fwrite($handle, $GLOBALS['ACCESS_LIMIT']-1);
		$return = true;
	}
	
	return $return;
}

// SERVE REQUEST

if(validateIP($_GET['ip']))
{
	if(validatePID(md5($_SERVER['REMOTE_ADDR'])))
	{
		$ip = $_GET['ip'];
		$format = $_GET['format'];		
		getResponse($ip, $format);
	}
	else
	{
		if($format == 'json') 
		{
			header('Content-type: application/json');
			echo json_encode(array("access limit reached"));
		}
		else
			{
				header('Content-type: text/xml');
				echo "<error>access limit reached</error>";
			}
	}
	
}
else
	{
		if($format == 'json') 
		{
			header('Content-type: application/json');
			echo json_encode(array("invalid ip"));
		}
		else
			{
				header('Content-type: text/xml');
				echo "<error>invalid ip</error>";
			}
	}

?>
