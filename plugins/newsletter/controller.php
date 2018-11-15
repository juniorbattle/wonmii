<?php

$action		= Secure::GetValue($_GET, 'action');

switch($action)
{
	default:
		
		$filesJS .= '<script src="' . $config["url_base"] . '/core/js/validate/jquery.validate.js"></script>';
		
		$pluginObj =  new PLUGIN(null,'newsletter');
		$pluginSocialsNetworksObj =  new PLUGIN(null,'socialsnetworks');
		
		break;

}

?>