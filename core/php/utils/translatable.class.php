<?php

class Translatable
{
    protected static $table_suffix = "_langues";
    protected $idLangue            = null;
    public $tableName              = null;
    public $keyColumnName          = null;
    public $idItem;
    public $translatableStrings    = null;

    public function __construct($idLangue = null)
    {
        global $config;

        if ($idLangue == null)
        {
            $this->idLangue = self::GetDefaultLangue();
        }
        elseif ($idLangue == 'uk')
        {
            $this->idLangue = 'en';
        }
        else
        {
            $this->idLangue = $idLangue;
        }
    }

    public function SetLangue($idLangue)
    {
        $this->idLangue = $idLangue;
        $this->Load();
    }

    public function SetTranslatableStrings($strings)
    {
        $this->translatableStrings = $strings;
    }

    public function SaveStrings($tabString)
    {
        global $db;

        if (is_array($tabString) && count($tabString) > 0)
        {
            foreach ($tabString as $langue => $strings)
            {
                foreach ($strings as $column => $string)
                {
                    if (!in_array($column, $this->translatableStrings))
                    {
                        continue;
                    }

                    $req  = "SELECT t.*
                             FROM   " . $this->tableName . self::$table_suffix . " t
                             WHERE  t." . $this->keyColumnName . " = " . $db->quote($this->idItem) . "
                             AND    t.id_langue = " . $db->quote($langue);
                    $data = $db->queryRow($req);

                    if ($data != false)
                    {
                        $req = "UPDATE " . $this->tableName . self::$table_suffix . "
                                SET " . $column . " = " . $db->quote($string) . "
                                WHERE " . $this->keyColumnName . " = " . $db->quote($this->idItem) . "
                                AND id_langue = " . $db->quote($langue);
                        $res = $db->exec($req);
                    }
                    else
                    {
                        $req = "INSERT INTO " . $this->tableName . self::$table_suffix . "(" . $this->keyColumnName . ", id_langue, " . $column . ")
                                VALUES(" . $db->quote($this->idItem) . "," . $db->quote($langue) . "," . $db->quote($string) . ")";
                        $res = $db->exec($req);
                    }
                }
            }
        }
    }

    public function GetStrings()
    {
        global $config, $db;

        $strings = array();

        $allLangues = $config["multilang"];
        foreach ($allLangues as $key => $langue)
        {
            $req  = "SELECT t.*
                     FROM   " . $this->tableName . self::$table_suffix . " t
                     WHERE  t." . $this->keyColumnName . " = " . $db->quote($this->idItem) . "
                     AND    t.id_langue = " . $db->quote($langue);


            $data = $db->queryRow($req);

            if ($data != false) $strings[$langue] = $data;
        }
        return $strings;
    }

    public static function GetDefaultLangue()
    {
        global $config;
        return "fr";
    }

}
