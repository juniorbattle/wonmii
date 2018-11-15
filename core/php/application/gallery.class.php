<?php

class GALLERY extends Translatable
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
            $req  = "SELECT g.*
                     FROM   gallery g
                     WHERE  g.id = " . $db->quote($id);
                     $data = $db->queryRow($req);
            if (count($data) > 0) $this->SetObjFromTable($data);
        }
    }

    public function Save()
    {
    		global $db;

        if($this->update)
        {
      		$req = "UPDATE  gallery
      				    SET     active   	   = " . $db->quote($this->active) . ",
                          display   	   = " . $db->quote($this->display) . "
          				WHERE   id           = " . $db->quote($this->id);
      		$res = $db->exec($req);
        } else {
          $req = "INSERT gallery (page, display) VALUES(" . $db->quote($this->page) . ", " . $db->quote($this->display) . ")";
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
        $this->tableName           = 'gallery';
        $this->translatableStrings = array("name");
        $this->keyColumnName       = 'id';
    }

	public static function GetGalleryPage($clause=array())
	{
		global $db, $config;

    $clause["active"]  = (Secure::GetValue($clause, "active") != null) ? " AND g.active = " . $db->quote($clause["active"]) : "";

		$req  = "SELECT g.*
				 FROM   gallery g
				 WHERE  g.page =  " . $db->quote(Secure::GetValue($config, "actvSsPage"))
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
            foreach ($data as $key => $gallery)
            {
                $galleryObj = new GALLERY();
                $galleryObj->SetObjFromTable($gallery);
                $returnTab[]    = $galleryObj;
            }
            return $returnTab;
            break;
    }

		return false;
	}

  public static function GetAll($clause=array())
  {
      global $db;

      $clause["active"]  = (Secure::GetValue($clause, "active") != null) ? " AND g.active = " . $db->quote($clause["active"]) : "";

      $req  = "SELECT g.*
  				 FROM   gallery g
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
              foreach ($data as $key => $gallery)
              {
                  $galleryObj = new GALLERY();
                  $galleryObj->SetObjFromTable($gallery);
                  $returnTab[]    = $galleryObj;
              }
              return $returnTab;
              break;
      }

      return false;
  }

}
?>
