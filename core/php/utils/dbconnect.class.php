<?php 
/**
**  class DbConnect extension du PDO, permet de se connecter a la base de donn�es
**
**/
class DbConnect extends PDO 
{
	public function __construct($dsn, $user = NULL, $pass = NULL, $options = NULL) 
	{
		parent::__construct($dsn, $user, $pass, $options);
		$this->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);	// -- Permet d'afficher les divers erreurs -- //
	}
	
	/**
	**  Permet de retourner un tableau de donn�es
	**	@params $sql -> requete sql
	**/
	public function queryAll($sql) 
	{	
		//echo ($sql);echo "<br/><hr/><br/>";
		$res = parent::query($sql);	
			
		$res->setFetchMode(PDO::FETCH_ASSOC);
		$data = $res->fetchAll();
	
		return $data;
	}
	
	/**
	** 	Permet de retourner la premiere ligne d'un tableau de donn�es
	**	@params $sql -> requete sql
	**/
	public function queryRow($sql) 
	{
		//echo ($sql);echo "<br/><hr/><br/>";
		$res = parent::query($sql);
		
		$res->setFetchMode(PDO::FETCH_ASSOC);
		$data = $res->fetchAll();
		
		if(count($data) > 0) return $data[0];
		else return false;
	}
	
	/**
	 * 	G�n�re les apostrophe automatiquement en fonction du param�tre
	 **/
	public function quote($chaine, $parameter_type = PDO::PARAM_STR) 
	{
		if($chaine != NULL || is_numeric($chaine)) return $res = parent::quote($chaine, $parameter_type);
		else return "NULL";
		/*if($chaine != null || is_numeric($chaine)) 
		{
			# Non utilisation du quote natif de PDO
			# A cause des apostrophes (A REVOIR)
			$chaine = ($chaine != "" && $chaine != null && !is_array($chaine)) ? stripslashes($chaine) : $chaine;
			$chaine = str_replace("\\", "", $chaine);
			$chaine = str_replace("'", "''", $chaine);
			$res = "'".$chaine."'";
			return $res;
		}
		else return "NULL";*/
	}
	
	public function exec($sql)
	{
		//echo ($sql);echo "<br/>";echo "<br/>";
		$res = parent::exec($sql);

		if($res == 1) return true;
		else return false;
	}
}
?>