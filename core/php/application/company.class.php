<?php

class COMPANY
{
    public $name		     	      = null;
    public $domain	     	      = null;
    public $email     		      = null;
    public $email2     		      = null;
    public $emailForContact     = null;
    public $phone               = null;
    public $mailingAddress      = null;
    public $description	        = null;
    public $keywords	          = null;
    public $socialsNetworks     = null;
    public $loginWoncreative    = null;
    public $passwordWoncreative = null;
    public $statusWebsite	      = null;
    public $update     		      = null;

    function __construct()
    {
        global $db;

    		$req  = "SELECT c.*
    				 FROM   company c";
    		$data = $db->queryRow($req);

    		if ($data && !empty($data)) $this->SetObjFromTable($data);
    }

    public function Save()
    {
        global $db;

        $socialsNetworks = (is_array($this->socialsNetworks)) ? Utils::JsonEncodeUnicode($this->socialsNetworks) : null;

        if ($this->update == null)
        {
            $req = "INSERT INTO company (`name`, `domain`, `email`, `email2`, `email_for_contact`, `phone`, `mailing_address`, `socials_networks`, `description`, `keywords`)
                    VALUES (" . $db->quote($this->name) . ", " . $db->quote($this->domain) . ", " . $db->quote($this->email) . ", " . $db->quote($this->email2) . ", " . $db->quote($this->emailForContact) . ", " . $db->quote($this->phone) . ", " . $db->quote($this->mailing_address) . ", " . $db->quote($socialsNetworks) . ", " . $db->quote($this->description) . ", " . $db->quote($this->keywords) . ")";
            $res = $db->exec($req);
        }
        else
        {

            $req = "UPDATE  company
                    SET     name	= " . $db->quote($this->name) . ",
                            domain	= " . $db->quote($this->domain) . ",
                            email	= " . $db->quote($this->email) . ",
              							email2	= " . $db->quote($this->email2) . ",
                            email_for_contact	= " . $db->quote($this->emailForContact) . ",
              							phone	= " . $db->quote($this->phone) . ",
              							mailing_address	= " . $db->quote($this->mailingAddress) . ",
                            socials_networks	= " . $db->quote($socialsNetworks) . ",
              							description	= " . $db->quote($this->description) . ",
              							keywords	= " . $db->quote($this->keywords) . ",
              							login_woncreative	= " . $db->quote($this->loginWoncreative) . ",
              							password_woncreative	= " . $db->quote($this->passwordWoncreative) . ",
                            status_website	= " . $db->quote($this->statusWebsite);

            $res = $db->exec($req);
        }

        return true;
    }

    public function SetObjFromTable($data, $loadInfos = true)
    {
        $this->name     	          = Secure::GetValue($data, "name");
        $this->domain               = Secure::GetValue($data, "domain");
        $this->email                = Secure::GetValue($data, "email");
        $this->email2               = Secure::GetValue($data, "email2");
        $this->emailForContact      = Secure::GetValue($data, "email_for_contact");
        $this->phone                = Secure::GetValue($data, "phone");
        $this->mailingAddress       = Secure::GetValue($data, "mailing_address");
        $this->socialsNetworks      = Utils::JsonDecode(Secure::GetValue($data, "socials_networks"));
        $this->description          = Secure::GetValue($data, "description");
        $this->keywords             = Secure::GetValue($data, "keywords");
        $this->loginWoncreative     = Secure::GetValue($data, "login_woncreative");
        $this->passwordWoncreative  = Secure::GetValue($data, "password_woncreative");
        $this->statusWebsite        = Secure::GetValue($data, "status_website");
        $this->update               = true;
    }

    public function SetLog()
    {
      global $db;

      $req  = "SELECT c.*
           FROM  company c
           WHERE c.login_woncreative = " . $db->quote($this->loginWoncreative) . "
           AND   c.password_woncreative = " . $db->quote($this->passwordWoncreative);

      $data = $db->queryRow($req);

      if ($data && !empty($data)) {
          $this->SetObjFromTable($data);
          
          return true;
      }

      return false;
    }

    public static function GetAll($clause=array())
    {
        global $db;

        $req = "SELECT  c.*
				FROM company c";

        switch (Secure::GetValue($clause, "return"))
        {
            default :
            case "data" :
                $data = $db->queryRow($req);
                return $data;
                break;

            case "count":

                break;

            case "object":
                $data      = $db->queryAll($req);
                $returnTab = array();
                foreach ($data as $key => $company)
                {
                    $companyObj = new COMPANY();
                    $companyObj->SetObjFromTable($company);
                    $returnTab[]    = $companyObj;
                }
                return $returnTab;
                break;
        }

        return false;
    }


}
?>
