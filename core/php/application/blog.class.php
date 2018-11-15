<?php

class BLOG extends Translatable
{
    public $id        = null;
    public $page      = null;
    public $display   = null;
    public $active	 	= null;
    public $update	 	= null;


    function __construct($id = null)
    {
        global $db;

        if ($id != null)
        {
            $req  = "SELECT b.*
                     FROM   blog b
                     WHERE  b.id = " . $db->quote($id);
                     $data = $db->queryRow($req);
            if (count($data) > 0) $this->SetObjFromTable($data);
        }
    }

    public function Save()
    {
    		global $db;

        if($this->update)
        {
      		$req = "UPDATE  blog
      				    SET     active   	   = " . $db->quote($this->active) . ",
                          display   	   = " . $db->quote($this->display) . "
          				WHERE   id           = " . $db->quote($this->id);
      		$res = $db->exec($req);
        } else {
          $req = "INSERT blog (page, display) VALUES(" . $db->quote($this->page) . ", " . $db->quote($this->display) . ")";
          $res = $db->exec($req);
          $this->id = $db->lastInsertId();
        }

        $this->InitTanslatableVars();

        return true;
    }

    public function SetObjFromTable($data, $loadInfos = true)
    {
        $this->id        = Secure::GetValue($data, "id");
        $this->page      = Secure::GetValue($data, "page");
        $this->display   = Secure::GetValue($data, "display");
        $this->active	   = Secure::GetValue($data, "active");
        $this->update    = true;

        $this->InitTanslatableVars();
    }

    public function InitTanslatableVars()
    {
        $this->idItem              = $this->id;
        $this->tableName           = 'blog';
        $this->translatableStrings = array("name", "content");
        $this->keyColumnName       = 'id';
    }

	public static function GetBlogPage($clause=array())
	{
		global $db, $config;

    $clause["active"]  = (Secure::GetValue($clause, "active") != null) ? " AND b.active = " . $db->quote($clause["active"]) : "";

		$req  = "SELECT b.*
				 FROM   blog b
				 WHERE  b.page =  " . $db->quote(Secure::GetValue($config, "actvSsPage"))
         . $clause["active"];
		$data = $db->queryAll($req);

    switch (Secure::GetValue($clause, "return"))
    {
        default :
        case "data" :
            $data = $db->queryAll($req);
            return $data;
            break;
        case "count":
            break;
        case "object":
            $data      = $db->queryAll($req);
            $returnTab = array();
            foreach ($data as $key => $blog)
            {
                $blogObj = new BLOG();
                $blogObj->SetObjFromTable($blog);
                $returnTab[]    = $blogObj;
            }
            return $returnTab;
            break;
    }

		return false;
	}

  public static function GetAll($clause=array())
  {
      global $db;

      $clause["active"]  = (Secure::GetValue($clause, "active") != null) ? " AND b.active = " . $db->quote($clause["active"]) : "";

      $req  = "SELECT b.*
  				 FROM   blog b
  				 WHERE  1=1 "
           . $clause["active"];


      switch (Secure::GetValue($clause, "return"))
      {
          default :
          case "data" :
              $data = $db->queryAll($req);
              return $data;
              break;
          case "count":
              break;
          case "object":
              $data      = $db->queryAll($req);
              $returnTab = array();
              foreach ($data as $key => $blog)
              {
                  $blogObj = new BLOG();
                  $blogObj->SetObjFromTable($blog);
                  $returnTab[]    = $blogObj;
              }
              return $returnTab;
              break;
      }

      return false;
  }

}
?>
