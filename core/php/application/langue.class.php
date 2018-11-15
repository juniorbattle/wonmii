<?php

class LANGUE
{
    public $idLangue     = null;
    public $libelle      = null;
    public $mainLang 	   = null;
    public $active	 	   = null;


    function __construct($idLangue = null, $libelle = null)
    {
        global $db;

        if ($idLangue != null || $libelle != null)
        {
            $req  = "SELECT l.*
                     FROM   langues l
                     WHERE  l.id_langue = " . $db->quote($idLangue) . "
                     OR    l.libelle = " . $db->quote($libelle);
            $data = $db->queryRow($req);
            if (count($data) > 0) $this->SetObjFromTable($data);
        }
    }

    public function Save()
    {
		global $db;

		$req = "UPDATE  langues
				    SET     libelle      = " . $db->quote($this->libelle) . ",
        						main	   	   = " . $db->quote($this->mainLang) . ",
        						active   	   = " . $db->quote($this->active) . "
    				WHERE   id_langue     = " . $db->quote($this->idLangue);
		$res = $db->exec($req);

        return true;
    }

    public function SetObjFromTable($data, $loadInfos = true)
    {
        $this->idLangue         = Secure::GetValue($data, "id_langue");
        $this->libelle         	= Secure::GetValue($data, "libelle");
        $this->mainLang      	  = Secure::GetValue($data, "main");
        $this->active	      	  = Secure::GetValue($data, "active");
    }

	public function SetMain()
	{
		global $db;

		$this->SetInitMain();

		$req = "UPDATE  langues
    				SET     main   = 1
    				WHERE 	id_langue = " . $db->quote($this->idLangue) . "
            OR      libelle = " . $db->quote($this->libelle);

		$res = $db->exec($req);

		return true;

	}


	public function SetInitMain()
	{
		global $db;

		$req = "UPDATE  langues
				    SET     main   = 0 ";

		$res = $db->exec($req);
	}


	public static function GetLangueMain()
	{
		global $db;

		$req  = "SELECT l.*
    				 FROM   langues l
    				 WHERE  l.main = 1";
		$data = $db->queryRow($req);

		if (count($data) > 0) return $data;

		return false;
	}

	public static function GetLanguesActives()
	{
		global $db;

		$req  = "SELECT l.*
				 FROM   langues l
				 WHERE  l.active = 1";
		$data = $db->queryAll($req);

		if (count($data) > 0) return $data;

		return false;
	}

  public static function GetAll($clause=array())
  {
      global $db;

      $clause["main"]  = (Secure::GetValue($clause, "main") != null) ? " AND main = " . $db->quote($clause["main"]) : "";
      $clause["active"]  = (Secure::GetValue($clause, "active") != null) ? " AND active = " . $db->quote($clause["active"]) : "";

      $req = "SELECT  l.*
              FROM    langues l
              WHERE   1=1"
  		. $clause["main"]
  		. $clause["active"];

      switch (Secure::GetValue($clause, "return"))
      {
          default :
          case "data" :
              $data = $db->queryAll($req);
              return $data;
              break;
      }

      return false;
  }

  public static function GetLibellesLangues($clause=array())
  {
    global $db;

    $clause["main"]  = (Secure::GetValue($clause, "main") != null) ? " AND main = " . $db->quote($clause["main"]) : "";
    $clause["active"]  = (Secure::GetValue($clause, "active") != null) ? " AND active = " . $db->quote($clause["active"]) : "";

    $req = "SELECT  l.*
            FROM    langues l
            WHERE   1=1"
    . $clause["main"]
    . $clause["active"];

    $langues = $db->queryAll($req);

    if(!empty($langues))
    {
      foreach ($langues as $key => $langue) {
        $tabLangues[$langue['libelle']] = $langue['libelle'];
      }

      return $tabLangues;
    }

    return false;
  }

}
?>
