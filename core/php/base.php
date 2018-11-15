<?php

function __autoload($className)
{
    global $config;

    #EFASHION
    $classFileName = strtolower($className) . ".class.php";
    $dir           = $config["dir"] . "core/php/";
    $classFolder   = scandir($dir);

    foreach ($classFolder as $key => $folder)
    {
        if ($folder != "." && $folder != ".." && is_dir($dir . $folder))
        {
            $classPath = $dir . $folder . "/" . $classFileName;
            if (file_exists($classPath)) require_once($classPath);
        }
    }
}

try
{
    $db = new DbConnect(DSN_MYSQL, DB_LOGIN, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));

    #Encodage UTF-8
    $db->query("SET NAMES utf8");
    $db->query("SET CHARACTER SET 'utf8'");
    $db->exec('SET CHARACTER SET utf8');
}
catch (Exception $e)
{
    echo 'Erreur : ' . $e->getMessage() . '<br />';
    echo 'N° : ' . $e->getCode();
	die;
}
?>
