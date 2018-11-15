<?php

class PAGE extends Translatable
{
    public $id           = null;
    public $name         = null;
    public $display      = null;
    public $inMenu       = null;
    public $active     	 = null;
    public $ordre        = null;
    public $plugins      = null;


    function __construct($id = null, $name = null)
    {
        global $db;

        if ($id != null || $name != null)
        {
            $req  = "SELECT p.*
                     FROM   pages p
                     WHERE  p.id = " . $db->quote($id) . "
                     OR     p.name = " . $db->quote($name);
            $data = $db->queryRow($req);
            if ($data && !empty($data)) $this->SetObjFromTable($data);
        }
    }

    public function Save()
    {
        global $db;

    		$plugins        = (is_array($this->plugins)) ? Utils::JsonEncodeUnicode($this->plugins) : null;

        if(!$this->id){
          $req = "INSERT INTO pages(name, ordre) VALUES(" . $db->quote($this->name) . ", " . $this->SetNewOrdre() . ")";
      		$res = $db->exec($req);

          $this->id = $db->lastInsertId();
        }

    		$req = "UPDATE  pages
  				      SET
                display    = " . $db->quote($this->display) . ",
                active    = " . $db->quote($this->active) . ",
                in_menu   = " . $db->quote($this->inMenu) . ",
    						plugins  	= " . $db->quote($plugins) . "
    				WHERE   id    = " . $db->quote($this->id);
    		$res = $db->exec($req);

        $this->InitTanslatableVars();

        return true;
    }

    public function SetObjFromTable($data, $loadInfos = true)
    {
        $this->id         = Secure::GetValue($data, "id");
        $this->display    = Secure::GetValue($data, "display");
        $this->name       = Secure::GetValue($data, "name");
        $this->active     = Secure::GetValue($data, "active");
        $this->inMenu     = Secure::GetValue($data, "in_menu");
        $this->ordre      = Secure::GetValue($data, "ordre");
        $this->plugins    = Utils::JsonDecode(Secure::GetValue($data, "plugins"));

        $this->InitTanslatableVars();
    }

    public function InitTanslatableVars()
    {
        $this->idItem              = $this->id;
        $this->tableName           = 'pages';
        $this->translatableStrings = array("name", "description", "content");
        $this->keyColumnName       = 'id';
    }

    public function SetNewOrdre()
    {
      return $this::GetAll(array('return' => 'count')) + 1;
    }

    public function setOrdreUp()
    {
        global $db;

        $req = "UPDATE  pages
                SET
                ordre   	= " . $db->quote($this->ordre) . "
                WHERE   ordre    = " . $db->quote($this->ordre-1);

        $res = $db->exec($req);

        $req = "UPDATE  pages
                SET
                ordre   	= " . $db->quote($this->ordre-1) . "
                WHERE   id    = " . $db->quote($this->id);

        $res = $db->exec($req);

        return true;
    }

    public function setOrdreDown()
    {
        global $db;

        $req = "UPDATE  pages
                SET
                ordre   	= " . $db->quote($this->ordre) . "
                WHERE   ordre    = " . $db->quote($this->ordre+1);
        $res = $db->exec($req);

        $req = "UPDATE  pages
                SET
                ordre   	= " . $db->quote($this->ordre+1) . "
                WHERE   id    = " . $db->quote($this->id);
        $res = $db->exec($req);

        return true;
    }

    public function isOrdreFirst()
    {
      return ($this->ordre <= 1)? true : false;
    }

    public function isOrdreLast()
    {
      return ($this->ordre >= $this::GetAll(array('return' => 'count')))? true : false;
    }

    public static function GetAll($clause=array())
    {
        global $db;

        $clause["active"]  = (Secure::GetValue($clause, "active")) ? " AND p.active = 1" : "";

        $req = "SELECT p.*
                FROM    pages p
                WHERE   1=1
                " . $clause["active"] . "
                ORDER BY p.ordre ASC";

        switch (Secure::GetValue($clause, "return"))
        {
            default :
            case "data" :
                $data = $db->queryAll($req);
                return $data;
                break;

            case "count":
                $data = $db->queryAll($req);
                return count($data);
                break;

            case "object":
                $data      = $db->queryAll($req);
                $returnTab = array();
                foreach ($data as $key => $page)
                {
                    $pageObj = new PAGE();
                    $pageObj->SetObjFromTable($page);
                    $returnTab[]    = $pageObj;
                }
                return $returnTab;
                break;
        }

        return false;
    }


}
?>
