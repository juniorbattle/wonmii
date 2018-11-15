<?php

class Secure
{
	public static function GetValue(&$var) 
	{
		$args = func_get_args();
		
		$indexName = isset($args[1]) && !is_bool($args[1]) ? $args[1] : null;
		$toHTML = isset($args[1]) && is_bool($args[1]) ? $args[1] : (isset($args[2]) && is_bool($args[2]) ? $args[2] : null);
	
		$valReturn = null;
		if(isset($var)) 
		{
			if( !is_array($var) && !is_object($var)) $valReturn = ($toHTML ? htmlentities($var, ENT_QUOTES, 'UTF-8') : $var);
			elseif(!is_array($var) && is_object($var) && $indexName != null) $valReturn = ($toHTML ? htmlentities($var->$indexName, ENT_QUOTES, 'UTF-8') : $var->$indexName);
			elseif(is_array($var) && $indexName != null && isset($var[$indexName])) $valReturn = ( is_array($var[$indexName]) ? $var[$indexName] : ($toHTML ? htmlentities(stripslashes($var[$indexName]), ENT_QUOTES, 'UTF-8') : stripslashes($var[$indexName])));
		}
		return $valReturn;
	}	
}

?>
