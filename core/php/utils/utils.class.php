<?php

abstract class Utils
{

    /**
     * @function UrlAnalyser, retourne le module à charger selon l'url
     * @param $params, parametre retourner par l'htacces
     */
    public static function UrlAnalyser($params = null)
    {
        global $pageMetas, $config;

        $params = explode("/", $params);

        if ($params[0] == "AdminEfashion")
        {
            $request["interface"] = "AdminEfashion";
            $request["module"]    = (isset($params[1])) ? $params[1] : "identification";
            $request["action"]    = (isset($params[2])) ? $params[2] : null;
        }
        elseif ($params[0] == "AdminVendeur")
        {
            $request["interface"] = "AdminVendeur";
            $request["module"]    = (isset($params[1])) ? $params[1] : "identification";
            $request["action"]    = (isset($params[2])) ? $params[2] : null;
        }
        else
        {
            $request["interface"] = "front";
            #GESTION DU MULTILANGUE
            if (in_array($params[0], $config["multilang"]))
            {
                $request["module"] = (isset($params[1])) ? $params[1] : null;
                $request["action"] = (isset($params[2])) ? $params[2] : null;
                $request["langue"] = $params[0];
            }
            else
            {
                $request["module"] = $params[0];
                $request["action"] = (isset($params[1])) ? $params[1] : null;
                $request["langue"] = "fr";
            }
        }
        return $request;
    }

    public static function SetLangue()
    {
        global $config;

        $requestURI = Secure::GetValue($_SERVER, "REQUEST_URI");
        $lang       = "fr";

        #URL : http://www.efashion-paris.com/en/
        if (preg_match("/\/en\//i", $requestURI)) $lang = "en";
        elseif (preg_match("/\/es\//i", $requestURI)) $lang = "es";
        elseif (preg_match("/\/it\//i", $requestURI)) $lang = "it";

        switch ($lang)
        {
            default:
                $config["langue"]     = $lang;
                $config["langue_abs"] = "uk";
                break;
            case "fr":
                $config["langue"]     = "fr";
                $config["langue_abs"] = "fr";
                break;
            case "en":
                $config["langue"]     = "uk";
                $config["langue_abs"] = "uk";
                break;
        }

        return $config["langue"];
    }

    public static function GetRequestURIFormat()
    {
        $requestURI = Secure::GetValue($_SERVER, "REQUEST_URI");
        $return     = str_replace("/en/", "", $requestURI);

        if (isset($return[0]) && $return[0] == "/")
        {
            $return = substr($return, 1);
        }

        if ($return != "/")
        {
            return $return;
        }
        else
        {
            return "";
        }
    }

    /**
     * @function : GetQueryStringForPagination, retourne le $_SERVER["REQUEST_URI"] clean, sans la variable $_GET["currentPage"]
     */
    public static function GetQueryStringForPagination()
    {
        $requestURI = explode("?", Secure::GetValue($_SERVER, "REQUEST_URI"));
        if (count($requestURI) > 1)
        {
            $queryString = "";
            $params      = explode("&", $requestURI[1]);
            foreach ($params as $key => $param)
            {
                if (!preg_match('/currentPage=/', $param) && !preg_match('/btnSubmit=/', $param))
                {
                    $queryString .= ($key != 0) ? "&" . $param : $param;
                }
            }
            $queryString = ($queryString != "") ? "?" . $queryString : "";

            return $queryString;
        }
        return false;
    }

    /**
     * @function : récupére les cases contenant le prefix donné, et retourne une table sans ses prefix
     * @comments : Utiliser pour les fonctions SetObjFromTable() des différentes classes existantes
     */
    public static function GetDataTableSSPrefix($data, $prefix)
    {
        if (count($data) > 0)
        {
            $returnTab = array();
            foreach ($data as $key => $case)
            {
                if (substr($key, 0, strlen($prefix)) == $prefix)
                {
                    $returnTab[str_replace($prefix, "", $key)] = $case;
                }
            }
            return $returnTab;
        }
    }

    /**
     * @function : ChampsToAttr, convertit les champs de la table en variable de l'objet
     * @param : champ, champ de la table
     */
    public static function ChampsToAttr($champ)
    {
        $champ = explode("_", $champ);
        $attr  = $champ[0];

        if (count($champ) > 1) for ($i = 1; $i < count($champ); $i++) $attr .= ucfirst($champ[$i]);

        return $attr;
    }

    /**
     * @function Redirect, fonction de redirection d'url
     * @param $path, adresse url de redirection
     */
    public static function Redirect($path, $type = null)
    {
        if ($type != null)
        {
            switch ($type)
            {
                case "301": header("Status: 301 Moved Permanently", false, 301);
                    break;
            }

            header("Location: " . $path);
            exit();
        }
        else
        {
            echo '<script>window.location = "' . $path . '";</script>';
            exit();
        }
    }

    /**
     * @function GetExtension, retourne l'extension de chaque fichier
     * @param $fileName, nom du ficher en question
     */
    public static function GetExtension($fileName)
    {
        $name = explode(".", $fileName);
        $ext  = $name[count($name) - 1];

        return $ext;
    }

    /**
     * @function : permet de générer un tableau multidimensionnel en fonction d'une chaine de caractère
     * @sample : $string = 110101, cette fonctionnalité nous retournera un tableau array['11']['01']['01']
     * @param $value : Affecte la valeur de la case final
     */
    public static function GenArrayKeyBySplit($string, $value = null, $key = 0)
    {
        $tabCategories                   = str_split($string, "2");
        $tabReturn                       = array($tabCategories[$key] => array());
        if ($key + 1 < count($tabCategories)) $tabReturn[$tabCategories[$key]] = Utils::GenArrayKeyBySplit($string, $value, $key + 1);
        else $tabReturn[$tabCategories[$key]] = $value;
        return $tabReturn;
    }

    /**
     * @function : Permet de fusionner un tableau en gardant le contenu de chacune d'elle, sans renommer les key
     * @param type $tableTomerge, le tableau multidimensionnels
     * @return array
     */
    public static function MergeArray($tableTomerge)
    {
        $tabReturn = array();

        foreach ($tableTomerge as $key => $niveau)
        {
            foreach ($niveau as $key2 => $case)
            {
                if (!array_key_exists($key2, $tabReturn)) $tabReturn[$key2] = array();
                $tabReturn[$key2] = array_merge_recursive($tabReturn[$key2], $case);
            }
        }

        return $tabReturn;
    }

    public static function GenString($longueur)
    {
        $str    = "";
        $chaine = "0123456789abcdefghijklmnpqrstuvwxyz";
        srand((double) microtime() * 1000);

        for ($i = 0; $i < $longueur; $i++)
        {
            $str .= $chaine[rand() % strlen($chaine)];
        }

        return $str;
    }

    public static function FileRename($chaine)
    {
        $chaine = Utils::ReplaceAccents($chaine);
        $chaine = Utils::ReplaceCaractereSpeciaux($chaine);
        $chaine = str_replace(" ", "", $chaine);
        $chaine = strtolower($chaine);

        return $chaine;
    }

    public static function ReplaceAccents($chaine)
    {
        $from   = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
        $to     = "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn";
        $chaine = strtr(utf8_decode($chaine), utf8_decode($from), utf8_decode($to));

        return $chaine;
    }

    /**
     * @function : les caracètres spéciaux autres que les chiffres et les lettres sont supprimés
     */
    public static function ReplaceCaractereSpeciaux($chaine, $withSpace = true)
    {
        $pattern = ($withSpace) ? '/([^.a-z0-9]+)/i' : '/([^.a-z0-9 ]+)/i';
        $chaine  = preg_replace($pattern, '', $chaine);
        return $chaine;
    }

    /**
     * @function : nettoie une chaine de caractere
     */
    public static function CleanString($chaine, $usetrim = true)
    {
        $return = ($usetrim) ? Utils::ReplaceAccents(Utils::ReplaceCaractereSpeciaux($chaine)) : Utils::ReplaceAccents(Utils::ReplaceCaractereSpeciaux($chaine, false));
        return strtoupper($return);
    }

    /**
     * @function : nettoie une chaine de caractère en ne gardant que les chiffres
     */
    public static function CleanNumberString($chaine)
    {
        return preg_replace("/([^.0-9]+)/i", "", $chaine);
    }

    public static function CropTexte($txt, $length)
    {
        return (strlen($txt) > $length) ? substr($txt, 0, $length) . "..." : $txt;
    }

    public static function IsMail($adresse)
    {
        $Syntaxe = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
        if (preg_match($Syntaxe, $adresse) == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @function ArrayMapRecursive : Parcours l'ensemble d'un tableau $array, et lui applique la fonction souhaitée $callback
     * @param $callback : fonction appeler pour chaque valeurs du tableau
     * @param $array : tableau à traiter
     */
    public static function ArrayMapRecursive($callback, $array)
    {
        if (is_array($array))
        {
            foreach ($array as $key => $value)
            {
                if (is_array($array[$key])) $array[$key] = Utils::ArrayMapRecursive($callback, $array[$key]);
                else $array[$key] = call_user_func($callback, $array[$key]);
            }
            return $array;
        }
        return false;
    }

    /**
     * @function JsonEncodeUnicode : json_encode améliorer pour l'enregistrement en base de données
     * @param $array : tableau à traiter
     */
    public static function JsonEncodeUnicode($array)
    {
        $func = function($value)
        {
            return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
        };
        $array = Utils::ArrayMapRecursive($func, $array);
        $str   = json_encode($array);
		$str   = str_replace('\r\n','',$str);
        $str   = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', function ($matches)
        {
            $sym = mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UTF-16');
            return $sym;
        }, $str
        );
        return $str . PHP_EOL;
    }

    /**
     * @function JsonDecode : json_decode améliorer pour le retour en array
     * @param $array : tableau à traiter
     */
    public static function JsonDecode($string)
    {
        if ($string != null && is_string($string))
        {
            $array = json_decode($string, true);
            $func  = function($value)
            {
                return htmlspecialchars_decode($value, ENT_QUOTES);
            };
            return Utils::ArrayMapRecursive($func, $array);
        }
        return false;
    }

    /**
     * @function : Récupére la bonne TVA en fonction d'une période donnée
     * @param $fdate : sous ce format 2013-12
     * @comment : ( date<2013-12 = 19.6% ) ( date>2014-01 = 20% )
     */
    public static function TVA($fdate = null)
    {
        if ($fdate != null) $fdate = substr($fdate, 0, 7);
        else $fdate = date("Y-m");
        //$fdate = "2014-01";
        if ($fdate <= '2013-12') return 0.196;
        if ($fdate >= '2014-01') return 0.2;
    }

    /**
     * @function : Retourne le TTC d'un montant en fonction de la TVA
     * @param $fdate : sous ce format 2013-12
     */
    public static function TTC($montant, $fdate = null)
    {
        return round($montant * (1 + Utils::TVA($fdate)), 2);
    }

    public static function UTF8toISO($text)
    {
        return utf8_decode($text);
    }

    public static function GetLabelLimit($string, $length)
    {
        $limitReachSymbol = "...";
        $res              = (strlen($string) > $length) ? utf8_encode(substr(utf8_decode($string), 0, $length - 3)) . $limitReachSymbol : $string;
        return $res;
    }

    public static function ASCIIToENTITIES($str)
    {
        $count = 1;
        $out   = '';
        $temp  = array();

        for ($i = 0, $s = strlen($str); $i < $s; $i++)
        {
            $ordinal = ord($str[$i]);

            if ($ordinal < 128)
            {
                if (count($temp) == 1)
                {
                    $out .= '&#' . array_shift($temp) . ';';
                    $count = 1;
                }

                $out .= $str[$i];
            }
            else
            {
                if (count($temp) == 0)
                {
                    $count = ($ordinal < 224) ? 2 : 3;
                }

                $temp[] = $ordinal;

                if (count($temp) == $count)
                {
                    $number = ($count == 3) ? (($temp['0'] % 16) * 4096) + (($temp['1'] % 64) * 64) + ($temp['2'] % 64) : (($temp['0'] % 32) * 64) + ($temp['1'] % 64);

                    $out .= '&#' . $number . ';';
                    $count = 1;
                    $temp  = array();
                }
            }
        }

        return $out;
    }

    public static function TABLEASCIIToENTITIES($table)
    {
        foreach ($table as $key => $ssnv1)
        {
            if (is_array($ssnv1)) foreach ($ssnv1 as $key2 => $ssnv2) $table[Utils::ASCIIToENTITIES($key)][Utils::ASCIIToENTITIES($key2)] = Utils::ASCIIToENTITIES($ssnv1);
            else $table[Utils::ASCIIToENTITIES($key)]                                = Utils::ASCIIToENTITIES($ssnv1);
        }

        return $table;
    }

    public static function GetRequestURI($withSlug = false)
    {
        $returnRequest = $_SERVER["REQUEST_URI"];
        if (!$withSlug)
        {
            $returnRequest = str_replace("en/", "", $_SERVER["REQUEST_URI"]);
        }
        return $returnRequest;
    }

    public static function GetSlug($string)
    {
        $maxlen       = 0;
        $newStringTab = array();
        $string       = strtolower(Utils::noDiacritics($string));
        if (function_exists('str_split'))
        {
            $stringTab = str_split($string);
        }
        else
        {
            $stringTab = my_str_split($string);
        }

        $numbers = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-");
        //$numbers=array("0","1","2","3","4","5","6","7","8","9");

        foreach ($stringTab as $letter)
        {
            if (in_array($letter, range("a", "z")) || in_array($letter, $numbers))
            {
                $newStringTab[] = $letter;
                //print($letter);
            }
            elseif ($letter == " ")
            {
                $newStringTab[] = "-";
            }
        }

        if (count($newStringTab))
        {
            $newString = implode($newStringTab);
            if ($maxlen > 0)
            {
                $newString = substr($newString, 0, $maxlen);
            }

            $newString = Utils::removeDuplicates('--', '-', $newString);
        }
        else
        {
            $newString = '';
        }

        return $newString;
    }

    public static function my_str_split($string)
    {
        $slen = strlen($string);
        for ($i = 0; $i < $slen; $i++)
        {
            $sArray[$i] = $string{$i};
        }
        return $sArray;
    }

    public static function noDiacritics($string)
    {
        //cyrylic transcription
        $cyrylicFrom = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $cyrylicTo   = array('A', 'B', 'W', 'G', 'D', 'Ie', 'Io', 'Z', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Ch', 'C', 'Tch', 'Sh', 'Shtch', '', 'Y', '', 'E', 'Iu', 'Ia', 'a', 'b', 'w', 'g', 'd', 'ie', 'io', 'z', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ch', 'c', 'tch', 'sh', 'shtch', '', 'y', '', 'e', 'iu', 'ia');


        $from = array("Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
        $to   = array("A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");


        $from = array_merge($from, $cyrylicFrom);
        $to   = array_merge($to, $cyrylicTo);

        $newstring = str_replace($from, $to, $string);
        return $newstring;
    }

    public static function checkSlug($sSlug)
    {
        if (ereg("^[a-zA-Z0-9]+[a-zA-Z0-9\_\-]*$", $sSlug))
        {
            return true;
        }

        return false;
    }

    public static function removeDuplicates($sSearch, $sReplace, $sSubject)
    {
        $i = 0;
        do
        {
            $sSubject = str_replace($sSearch, $sReplace, $sSubject);
            $pos      = strpos($sSubject, $sSearch);

            $i++;
            if ($i > 100)
            {
                die('removeDuplicates() loop error');
            }
        }
        while ($pos !== false);

        return $sSubject;
    }

    public static function GetSignature($commandesGroupeObj)
    {
        global $config;
        $GROUPE                        = $commandesGroupeObj->GetTotalCommandes();
        $FINALPRICE                    = ($commandesGroupeObj->acheteurObj->isEtranger) ? $GROUPE["totalHT"] : $GROUPE["totalTTC"];
        $certif_key                    = $config["vads"]["certif_key"];
        #INITIALITSATION DES PARAMETRES
        $params                        = array();                       #tableau des paramètres du formulaire
        $params['vads_site_id']        = "12194596";
        $params['vads_amount']         = 100 * round($FINALPRICE, 2);   #en cents
        $params['vads_currency']       = "978";                         #devise norme ISO 4217
        $params['vads_page_action']    = "PAYMENT";
        $params['vads_action_mode']    = "INTERACTIVE";                 #saisie de carte réalisée par la plateforme
        $params['vads_payment_config'] = "SINGLE";
        $params['vads_version']        = "V2";
        $params['vads_order_id']       = $commandesGroupeObj->idCommandeGroupeName;

        #MODE
        $params['vads_ctx_mode']     = $config["vads"]["vads_ctx_mode"];
        #REDIRECTION AVANT PAIEMENT
        $params['vads_url_cancel']   = $config["vads"]["vads_url_cancel"];
        #REDIRECTION EN CAS DE REFUS DE LA CARTE
        $params['vads_url_refused']  = $config["vads"]["vads_url_refused"];
        #REDIRECTION REFUSE MAIS IL FAUT "CONTACTER L'EMETTEUR DE LA CARTE"
        $params['vads_url_referral'] = $config["vads"]["vads_url_referral"];
        #REDIRECTION ACCEPTE
        $params['vads_url_success']  = $config["vads"]["vads_url_success"];
        #ERREUR DE LA PLATEFORME DE PAIEMENT
        $params['vads_url_error']    = $config["vads"]["vads_url_error"];

        #CALCUL DELAI
        $timestamp = time();
        $jour      = date('w', $timestamp);
        $heure     = date('G', $timestamp);
        
        #Remise en banque
        switch ($jour)
        {
            default:
                $delai = 2;
                break;

            case 0: #Lundi -> Mercredi
            case 1: #Mardi -> Jeudi
            case 2: #Mercredi -> Vendredi
            case 6: #Dimanche -> Mardi
                $delai = 2;
                break;
            
            case 3: #Jeudi -> Lundi
            case 4: #Vendredi -> Mardi
                $delai = 4;
                break;
            
            case 5: #Samedi -> Mardi
                $delai = 3;
                break;
        }
        $params['vads_capture_delay'] = $delai;

        #INFOS acheteur
        $params['vads_cust_phone'] = $commandesGroupeObj->tabAdresseObj["facturation"]->telephone;
        $params['vads_cust_name']  = Utils::GetStringFormatTransac($commandesGroupeObj->acheteurObj->nomSociete);
        $params['vads_cust_email'] = Utils::GetStringFormatTransac($commandesGroupeObj->acheteurObj->email);
        $params['vads_cust_id']    = $commandesGroupeObj->acheteurObj->idAcheteur;

        #ADRESSE de facturation
        $params['vads_cust_address'] = Utils::GetStringFormatTransac($commandesGroupeObj->tabAdresseObj["facturation"]->adresse);
        $params['vads_cust_zip']     = $commandesGroupeObj->tabAdresseObj["facturation"]->codePostal;
        $params['vads_cust_city']    = Utils::GetStringFormatTransac($commandesGroupeObj->tabAdresseObj["facturation"]->ville);
        $params['vads_cust_country'] = $commandesGroupeObj->tabAdresseObj["facturation"]->code_pays;

        #ADRESSE de livraison
        $params['vads_ship_to_name']      = Utils::GetStringFormatTransac($commandesGroupeObj->acheteurObj->nomSociete);
        $params['vads_ship_to_phone_num'] = $commandesGroupeObj->tabAdresseObj["livraison"]->telephone;
        $params['vads_ship_to_street']    = Utils::GetStringFormatTransac($commandesGroupeObj->tabAdresseObj["livraison"]->adresse);
        $params['vads_ship_to_zip']       = $commandesGroupeObj->tabAdresseObj["livraison"]->codePostal;
        $params['vads_ship_to_city']      = Utils::GetStringFormatTransac($commandesGroupeObj->tabAdresseObj["livraison"]->ville);
        $params['vads_ship_to_country']   = $commandesGroupeObj->tabAdresseObj["livraison"]->code_pays;

        #EXEMPLE de génération de trans_id basé sur l'horodatage
        $ts                        = time();
        $params['vads_trans_date'] = gmdate("YmdHis", $ts);
        $params['vads_trans_id']   = gmdate("His", $ts);

        #GENERATION de la signature
        ksort($params); // tri des paramètres par ordre alphabétique
        $contenu_signature = "";
        foreach ($params as $nom => $valeur)
        {
            $contenu_signature .= $valeur . "+";
        }
        $contenu_signature .= $certif_key; // On ajoute le certificat à la fin
        $params['signature'] = sha1($contenu_signature);

        return $params;
    }

    public static function GetStringFormatTransac($chaine)
    {
        $ch = str_replace("'", "", $chaine);
        $ch = trim($ch);
        return $ch;
    }

    /**
     * @function : Retourne le numéro de téléphone en fonction du pays de l'adresse sans l'indicatif
     */
    public function GetTelephonePays($phone, $codePays)
    {
        switch ($codePays)
        {
            case "DZ":
            case "DE":
            case "CA":
            case "ES":
            case "GR":
            case "AU":
                $numberForPhone = 10;
                break;

            case "BE":
            case "FI":
            case "FR":
            case "IT":
            case "NL":
            case "PL":
            case "PT":
            case "CZ":
            case "RO":
            case "GB":
            case "SK":
            case "CH":
            case "UA":
            case "BG":
            case "AE":
            case "IQ":
            case "IE":
            case "MC":
            case "SI":
                $numberForPhone = 9;
                break;

            case "BJ":
            case "HR":
            case "DK":
            case "HU":
            case "LV":
            case "NO":
            case "SE":
            case "TN":
            case "CY":
            case "LT":
            case "MT":
            case "NZ":
                $numberForPhone = 8;
                break;

            case "AT":
            case "EE":
            case "LB":
            case "IS":
                $numberForPhone = 7;
                break;

            case "AD":
            case "LU":
                $numberForPhone = 6;
                break;
        }

        return substr(Utils::CleanNumberString($phone), -$numberForPhone);
    }

    /**
     * @function : Récupére l'url de base en fonction de la lanque souhaité
     * @params $langue : la langgue par défaut est "fr"
     */
    public static function GetUrlBase($langue = "fr")
    {
        global $config;

        switch (strtolower($langue))
        {
            case "uk" :
                return $config["url_base_clean"] . "/en";
                break;
            case "fr":
                return $config["url_base_clean"];
                break;
            default:
                return $config["url_base_clean"] . "/" . $langue;
                break;
        }
    }

    public static function GetBOBreadcrumbs($array)
    {
        global $config;

        $return = "";
        if (count($array) > 0)
        {
            $return = '	<ul id="breadcrumbs">
							<li><a href="index.php">Accueil</a></li>';
            foreach ($array as $key => $link)
            {
                $return .= '<li><a href="' . $link . '">' . $key . '</a></li>';
            }
            $return .= '</ul>';
        }
        return $return;
    }

    /**
     * @function : Récupére des noms de fichiers présent dans un dossier
     */
    public static function GetFiles($dir, $type)
    {
        global $config;

        $array = null;

        $pointeur = opendir($config["dir_base"] . $dir);
        $i        = 0;
        while ($entree   = readdir($pointeur))
        {
            if ($type != NULL)
            {
                if ($entree != "." && $entree != "..")
                {
                    if (strpos($entree, "." . $type))
                    {
                        $array[$i]['name'] = $entree;
                        $array[$i]['link'] = $config["dir_base"] . $dir . "/" . $entree;
                    }
                    $i++;
                }
            }
            else
            {
                if ($entree != "." && $entree != "..")
                {
                    $array[$i]['name'] = $entree;
                    $array[$i]['link'] = $config["dir_base"] . $dir . "/" . $entree;
                    //echo "<span style='color:red;'>".$entree."</span><br/>";
                    $i++;
                }
            }
        }
        closedir($pointeur);

        return $array;
    }

    /**
     * @function GetSQLLocateOnJSON : Génére une colonne en fonction d'une donnée JSON, et affiche la donnée correspondante
     * @params $columnDB : noùm de la colonne ou est stocké la donnée JSON
     * @params $svalue : nom de la colonne recherché
     * @params $tbl : prefix de la table en question
     */
    public static function GetSQLLocateOnJSON($columnDB, $svalue, $tbl)
    {
        $jsonColumn = '"' . $svalue . '":';
        $rlength    = strlen($jsonColumn) + 1;
        return trim("IF( 
                    ( LOCATE('" . $jsonColumn . "', " . $tbl . "." . $columnDB . ") > 0 
                      AND LOCATE('\"', " . $tbl . "." . $columnDB . ", LOCATE('" . $jsonColumn . "', " . $tbl . "." . $columnDB . " )+" . $rlength . ") > LOCATE('" . $jsonColumn . "', " . $tbl . "." . $columnDB . " )+" . $rlength . "),
                    SUBSTRING(" . $tbl . "." . $columnDB . ", 
                    LOCATE('" . $jsonColumn . "', " . $tbl . "." . $columnDB . ")+" . $rlength . ", 
                    ( LOCATE('\"', " . $tbl . "." . $columnDB . ", LOCATE('" . $jsonColumn . "', " . $tbl . "." . $columnDB . " )+" . $rlength . ") )-( LOCATE('" . $jsonColumn . "', " . $tbl . "." . $columnDB . " )+" . $rlength . " ) ),
                    NULL) AS " . $columnDB . "_" . $svalue);
    }

    public static function TrackingToken($tokenkey, $libelleToken = null, $varGet = null)
    {
        global $db;

        $connect = false; #NON CONNEXION DU CLIENT SI NON ENREGISTRER
        if (isset($varGet["idDatabase"]))
        {
            $req  = "SELECT 	ad.*
					FROM 	admin_database ad
					WHERE 	ad.id_database = " . $db->quote($varGet["idDatabase"]) . "
					AND		ad.secure_key = " . $db->quote($tokenkey);
            $data = $db->queryRow($req);
        }
        else
        {
            $req     = "SELECT 	a.*
					FROM 	acheteurs a
					WHERE 	a.secure_key = " . $db->quote($tokenkey);
            $data    = $db->queryRow($req);
            $connect = true; #CONNEXION DU CLIENT
        }

        if (count($data) > 0)
        {
            if ($connect)
            {
                $_SESSION['id']     = $data['id_acheteur'];
                $_SESSION['type']   = "acheteur";
                $_SESSION['email']  = $data['email'];
                $_SESSION['nom']    = $data['nomContact'];
                $_SESSION['prenom'] = $data['prenomContact'];
            }

            $idAcheteur    = (isset($data["id_acheteur"])) ? $data["id_acheteur"] : null;
            $emailTracking = (isset($data["email"])) ? $data["email"] : null;
            $idDatabase    = (isset($data["id_database"])) ? $data["id_database"] : null;

            $urlVisiting = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $httpReferer = Secure::GetValue($_SERVER, "HTTP_REFERER");
            $req         = "INSERT INTO tracking_com(id_acheteur, email_tracking, id_database, libelle_token, url_visiting, http_referer, date_tracking)
					VALUES(" . $db->quote($idAcheteur) . ",
						   " . $db->quote($emailTracking) . ",
						   " . $db->quote($idDatabase) . ",	
						   " . $db->quote($libelleToken) . ",
						   " . $db->quote($urlVisiting) . ",
						   " . $db->quote($httpReferer) . ",
						   NOW())";
            $res         = $db->exec($req);
            return $res;
        }

        return false;
    }

    /**
     * @function : Autorisation de l'accès à l'admin efashion
     */
    public static function AdminefashionAccess()
    {
        if (!isset($_SESSION['AdminEfashion']))
        {
            Utils::Redirect("index.php");
            exit();
        }
        return true;
    }

    /**
     * @function : Autorisation de l'accès d'un client au différentes partie du FRONT
     */
    public static function CustomerAccess($module = null)
    {
        global $config, $session;
        if ($session->Exist("id")) return true;
        Utils::Redirect($config["url_base"] . "/" . $module);
        exit();
    }

    public static function isEmail($email)
    {
        return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $email);
    }

    public static function formatDate($date, $langue)
    {
        if ($langue == "fr")
        {
            $tab   = explode('-', $date);
            $annee = $tab[0];
            $mois  = $tab[1];
            $jour  = $tab[2];
            return $jour . "/" . $mois . "/" . $annee;
        }
        elseif ($langue == "uk")
        {
            $tab   = explode('-', $date);
            $annee = $tab[0];
            $mois  = $tab[1];
            $jour  = $tab[2];
            return $mois . "/" . $jour . "/" . $annee;
        }
    }

    public static function FormatNoTVA($numeroTVA, $idPays)
    {
        global $db, $session;

        $formatTVA = $numeroTVA;

        if ($idPays != "10")
        {
            #Optimisation de ressources
            if (!$session->Exist("pays"))
            {
                $req           = "SELECT p.*
                                  FROM pays p";
                $session->pays = $db->queryAll($req);
            }

            foreach ($session->pays as $key => $p) if ($idPays === $p["id_pays"]) $pays = $p;

            $formatTVA = str_replace(" ", "", $formatTVA);
            $formatTVA = str_replace(".", "", $formatTVA);

            if (strtolower(substr($formatTVA, 0, 2)) == strtolower($pays["code"])) return strtoupper($formatTVA);

            $formatTVA = $pays["code"] . $formatTVA;
        }

        return strtoupper($formatTVA);
    }

    public static function GetCommission($idContrat, $type, $montant = null, $tva = null)
    {
        global $config, $session;

        Cache::Settings("contrats");

        foreach ($session->contrats as $key => $contrat)
        {
            if ($contrat['id_contrat'] == $idContrat)
            {
                $commission    = 0;
                $tabCommission = Utils::JsonDecode($contrat['commission']);

                switch ($type)
                {
                    default:
                        $commission = $tabCommission[$type]['value'];
                        break;

                    case "efashion":

                        if (array_key_exists("degressif", $tabCommission["efashion"]))
                        {
                            foreach ($tabCommission["efashion"]["degressif"] as $degressif)
                            {
                                if ($montant > floatval($degressif["minimum"]))
                                {
                                    $commission = $degressif["value"];
                                }
                            }
                        }
                        else
                        {
                            $commission = $tabCommission["efashion"]['value'];
                        }

                        break;
                }

                if (!is_null($tva)) return round(($montant * $commission) * (1 + $tva) / 100, 2);

                return round(($montant * $commission) / 100, 2);
            }
        }

        return false;
    }

    public static function GetCommissionPourcentage($contrat, $type, $montant = null)
    {
        $percent    = false;
        $commission = Utils::JsonDecode($contrat['commission']);

        switch ($type)
        {
            default :
                $percent = $commission[$type]['value'];
                break;

            case "efashion" :
                if (array_key_exists("degressif", $commission["efashion"]))
                {
                    foreach ($commission["efashion"]['degressif'] as $key => $degressif)
                    {
                        if ($montant >= $degressif['minimum']) $percent = $degressif['value'];
                    }
                }
                else
                {
                    $percent = $commission[$type]['value'];
                }

                break;
        }

        return $percent;
    }

    public static function GetCharges($idContrat, $type = null)
    {
        global $config, $session;

        Cache::Settings("contrats");


        foreach ($session->contrats as $key => $contrat)
        {
            if ($contrat['id_contrat'] == $idContrat && !is_null($contrat['charge']))
            {
                if ($type != null)
                {
                    $tabCharges = Utils::JsonDecode($contrat['charge']);
                    return $tabCharges[$type]['value'];
                }

                return Utils::JsonDecode($contrat["charge"]);
            }
        }


        return array();
    }

    /**
     * @function : Suppimer un fiche si il n'est pas nul
     */
    public static function Rrmdir($dir)
    {
        if (is_dir($dir))
        {
            $objects = scandir($dir);
            foreach ($objects as $object)
            {
                if ($object != "." && $object != "..")
                {
                    if (filetype($dir . "/" . $object) == "dir") rmdir($dir . "/" . $object);
                    else unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    /**
     * @function : File Download 1.3.1, Visit http://www.zubrag.com/scripts/ for updates
     */
    public static function Download($filename, $path)
    {
        global $config;
        ini_set('memory_limit', -1);
        // Allow direct file download (hotlinking)?
        // Empty - allow hotlinking
        // If set to nonempty value (Example: example.com) will only allow downloads when referrer contains this text
        define('ALLOWED_REFERRER', '');
        define('BASE_DIR', '/home/user/downloads/'); // Download folder, i.e. folder where you keep all files for download. // MUST end with slash (i.e. "/" )
        define('LOG_DOWNLOADS', false); // log downloads?  true/false
        define('LOG_FILE', '/front/files/downloads.log'); // log file name
        // Allowed extensions list in format 'extension' => 'mime type'
        // If myme type is set to empty string then script will try to detect mime type 
        // itself, which would only work if you have Mimetype or Fileinfo extensions
        // installed on server.
        $allowed_ext = array(
            // archives
            'zip'  => 'application/zip',
            // documents
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'xls'  => 'application/vnd.ms-excel',
            'ppt'  => 'application/vnd.ms-powerpoint',
            // executables
            'exe'  => 'application/octet-stream',
            // images
            'gif'  => 'image/gif',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            // audio
            'mp3'  => 'audio/mpeg',
            'wav'  => 'audio/x-wav',
            // video
            'mpeg' => 'video/mpeg',
            'mpg'  => 'video/mpeg',
            'mpe'  => 'video/mpeg',
            'mov'  => 'video/quicktime',
            'avi'  => 'video/x-msvideo'
        );

        ####################################################################
        ###  DO NOT CHANGE BELOW
        ####################################################################
        // If hotlinking not allowed then make hackers think there are some server problems
        if (ALLOWED_REFERRER !== '' && (!isset($_SERVER['HTTP_REFERER']) || strpos(strtoupper($_SERVER['HTTP_REFERER']), strtoupper(ALLOWED_REFERRER)) === false))
        {
            die("Internal server error. Please contact system administrator.");
        }

        // Make sure program execution doesn't time out
        // Set maximum script execution time in seconds (0 means no limit)
        set_time_limit(0);

        if (!isset($filename) || empty($filename))
        {
            die("Please specify file name for download.");
        }

        // Nullbyte hack fix
        if (strpos($filename, "\0") !== FALSE) die('');

        // Get real file name.
        // Remove any path info to avoid hacking by adding relative path, etc.
        $fname     = basename($filename);
        $file_path = $config["dir_base"] . $path . $filename;

        if (!is_file($file_path))
        {
            die("File does not exist. Make sure you specified correct file name.");
        }

        // file size in bytes
        $fsize = filesize($file_path);

        // file extension
        $fext = strtolower(substr(strrchr($fname, "."), 1));

        // check if allowed extension
        if (!array_key_exists($fext, $allowed_ext))
        {
            die("Not allowed file type.");
        }

        // get mime type
        if ($allowed_ext[$fext] == '')
        {
            $mtype = '';
            // mime type is not set, get from server settings
            if (function_exists('mime_content_type'))
            {
                $mtype = mime_content_type($file_path);
            }
            else if (function_exists('finfo_file'))
            {
                $finfo = finfo_open(FILEINFO_MIME); // return mime type
                $mtype = finfo_file($finfo, $file_path);
                finfo_close($finfo);
            }
            if ($mtype == '')
            {
                $mtype = "application/force-download";
            }
        }
        else
        {
            // get mime type defined by admin
            $mtype = $allowed_ext[$fext];
        }
        // Browser will try to save file with this filename, regardless original filename.
        // You can override it if needed.
        if (!isset($_GET['fc']) || empty($_GET['fc']))
        {
            $asfname = $fname;
        }
        else
        {
            // remove some bad chars
            $asfname = str_replace(array('"', "'", '\\', '/'), '', $_GET['fc']);
            if ($asfname === '') $asfname = 'NoName';
        }
        // set headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: $mtype");
        header("Content-Disposition: attachment; filename=\"$asfname\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);
        //download
        //readfile($file_path);
        $file = @fopen($file_path, "rb");
        if ($file)
        {
            while (!feof($file))
            {
                print(fread($file, 1024 * 8));
                flush();
                if (connection_status() != 0)
                {
                    @fclose($file);
                    die();
                }
            }
            @fclose($file);
        }
        // log downloads
        if (!LOG_DOWNLOADS) die();
        $f = @fopen(LOG_FILE, 'a+');
        if ($f)
        {
            @fputs($f, date("m.d.Y g:ia") . "  " . $_SERVER['REMOTE_ADDR'] . "  " . $fname . "\n");
            @fclose($f);
        }
    }

    /**
     * @function : retourne true si le pays est CEE 
     */
    public static function isCEE($idPays)
    {
        $tabCEE = array("id_pays" =>
            array(
                1, #Allemagne
                3, #Belgique
                4, #Bulgarie
                5, #Chypre
                6, #Danemark
                7, #Espagne
                8, #Estonie
                9, #Finlande
                11, #Grèce
                12, #Hongrie
                13, #Irlande
                14, #Italie
                15, #Lettonie
                16, #Lituanie
                17, #Luxembourg
                18, #Malte
                19, #Pays-Bas
                20, #Pologne
                21, #Portugal
                22, #République tchèque
                23, #Roumanie
                24, #Royaume-Uni
                25, #Slovaquie
                26, #Slovénie
                27  #Suède
        ));

        if (in_array($idPays, $tabCEE['id_pays'])) return true;
        return false;
    }

    /**
     * @function : retourne true si le pays est HCEE 
     */
    public static function isHCEE($idPays)
    {
        $tabHCEE = array("id_pays" =>
            array(
                2, #Autriche
                28, #Suisse
                29, #Norvège
                30, #Andorre
                32, #Islande
                33, #Ukraine
                34, #Croatie
                35, #Canada
                36, #Bénin
                37, #Iraq
                38, #Algérie
                39, #Liban
                40, #Emirats arabes unis
                41, #Tunisie
                43, #Australie
                44  #Nouvelle Zélande
        ));

        #FRANCE METROPOLITAINE ET #MONACO SONT FRANÇAIS
        #ANDORRE sont des étrangers
        if (in_array($idPays, $tabHCEE['id_pays'])) return true;
        return false;
    }

    /**
     * @function isDOMTOM : retourne true si le code postal represente un DOM TOM
     */
    public static function isDOMTOM($codePostal)
    {
        $tabDOMTOM = array("code_postal" =>
            array(
                971, #Guadeloupe
                972, #Martinique
                973, #Guyane
                974, #Réunion
                975, #Saint-Pierre-et-Miquelon
                976, #Mayotte
                988, #Nouvelle-Calédonie
                987, #Polynésie Française
                986, #Iles Wallis-et-Futuna
                984 #Terres Australes et Antartiques Françaises
        ));
        if (in_array(substr($codePostal, 0, 3), $tabDOMTOM["code_postal"])) return true;
        return false;
    }

    /**
     * @function : retourne true si nous sommes sur l'aperçu vendeur
     */
    public static function IsApercuVendeur($module)
    {
        global $session;
        return ( ($module == "apercu-liste" || $module == "apercu-fiche") && $session->Exist("id_vendeur") );
    }

    /**
     * @function : retourne true si nous sommes sur l'aperçu vendeur
     */
    public static function IsApercuVendeurByAjax($module, $vendeurs)
    {
        global $session;

        if ($module != null && $vendeurs != null && $session->Exist("id_vendeur")                            #Vérifie si un grossiste est connecté
            && array_key_exists(0, $vendeurs)                           #Si un grossiste est dans le filtre
            && count($vendeurs) === 1                                   #Seulement un grossiste est filtré
            && $vendeurs[0] == $session->id_vendeur                     #Si le grossiste filtré est celui qui est connecté
            && ($module == "apercu-liste" || $module == "apercu-fiche") #Si nous sommes sur la page d'aperçu grossiste
        ) return true;


        return false;
        return ( ($module == "apercu-liste" || $module == "apercu-fiche") && $session->Exist("id_vendeur") );
    }

    /**
     * @function GetFolders : Récupére tout les dossiers et fichiers d'un dossier
     */
    public static function GetFolders($dir, $fkey = null, $dirtoexclude=array())
    {        
        $folders = null;
        if ($dossier = opendir($dir))
        {
            while (false !== ($fichier = readdir($dossier)))
            {
                if ($fichier != '.' && $fichier != '..' && $fichier != '.svn' && !in_array($fichier,$dirtoexclude))
                {
                    if (is_dir($dir . $fichier))
                    {

                        $folders[$fichier] = Utils::GetFolders($dir . $fichier . "/", $fichier);
                    }
                    elseif ($fkey != null)
                    {
                        $folders[] = $fichier;
                    }
                }
            }
            closedir($dossier);
            return $folders;
        }
        return false;
    }
    
    /**
     * @function GetFolders : récupération de tous les fichiers d'un dossier sélectionné
     */
    public static function IncludeModuleEntire($module,$var=null)
    {
        global $session, $config;
        
        $textHTML = null;
        $content = null;
        $fileCSS = null;
        $fileJS = null;
        if(is_null($var)) $var = array( "url" => $config["front_url"]["modules"], "dir" => $config["front_dir"]["modules"]);
        $modules = Utils::GetFolders($var["dir"]);
        
        foreach($modules[$module] as $key => $fichier)
        {
            $infoFileObj = new SplFileInfo($fichier);
            switch($infoFileObj->getExtension()){
                case 'css':
                    $fileCSS .= '<link href="' . $var["url"] . $module . '/' . $fichier . '" rel="stylesheet" type="text/css" media="all">';
                    break;
                case 'js':
                    $fileJS .= '<script src="' . $var["url"] . $module . '/' . $fichier . '"></script>';
                    break;
                default: 
                    ob_start();
                    require_once($var["dir"] . $module . '/' . $fichier);
                    $content .= ob_get_clean();
            }
        }
        
        $textHTML .= '<div id="' . $module . '">';
        $textHTML .= $fileCSS;
        $textHTML .= $content;
        $textHTML .= $fileJS;
        $textHTML .= '</div>';
        
        return $textHTML;
    }

    /**
     * @function GetKeysArray : Récupére toutes les clés d'un tableau
     */
    public static function GetKeysArray($array, $parent = null)
    {
        $listeKeys = null;
        foreach ($array as $key => $case)
        {
            if (!is_int($key)) $listeKeys[] = $key;
            if (is_array($case))
            {
                $toBrowse = Utils::GetKeysArray($case, $key);
                if ($toBrowse != null)
                {
                    foreach ($toBrowse as $key2 => $c)
                    {
                        if (!is_int($key) && $c != "AdminVendeur" && $c != "AdminEfashion") $listeKeys[] = $key . "-" . $c;
                    }
                }
            }
        }

        return $listeKeys;
    }

    /**
     * @function SearchPattern : Récupére toutes les occurence rechercher, retourne un tableau des occurences recherchées
     */
    public static function SearchPattern($content, $apattern)
    {
        #TEXTE
        $spattern             = '/\$TXT_([A-Za-z0-9]*)/';
        $TXTs                 = null;
        preg_match_all($spattern, $content, $TXTs, PREG_SET_ORDER);
        if (count($TXTs) > 0) foreach ($TXTs as $key => $TXT) if (!(array_key_exists("TXT", $apattern) && is_array($apattern["TXT"]) && in_array($TXT, $apattern["TXT"]))) $apattern["TXT"][]    = $TXT;
        #TEXTAREA
        $spattern             = '/\$TAREA_([A-Za-z0-9]*)/';
        $TAREAs               = null;
        preg_match_all($spattern, $content, $TAREAs, PREG_SET_ORDER);
        if (count($TAREAs) > 0) foreach ($TAREAs as $key => $TAREA) if (!(array_key_exists("TAREA", $apattern) && is_array($apattern["TAREA"]) && in_array($TAREA, $apattern["TAREA"]))) $apattern["TAREA"][]  = $TAREA;
        #TEXTE JAVASCRIPT
        $spattern             = '/\TJS_([A-Za-z0-9]*)/';
        $TJSs                 = null;
        preg_match_all($spattern, $content, $TJSs, PREG_SET_ORDER);
        if (count($TJSs) > 0) foreach ($TJSs as $key => $TJS) if (!(array_key_exists("TJS", $apattern) && is_array($apattern["TJS"]) && in_array($TJS, $apattern["TJS"]))) $apattern["TJS"][]    = $TJS;
        #TEXTE POPUP
        $spattern             = '/\$TPOPUP_([A-Za-z0-9]*)/';
        $TPOPUPs              = null;
        preg_match_all($spattern, $content, $TPOPUPs, PREG_SET_ORDER);
        if (count($TPOPUPs) > 0) foreach ($TPOPUPs as $key => $TPOPUP) if (!(array_key_exists("TPOPUP", $apattern) && is_array($apattern["TPOPUP"]) && in_array($TPOPUP, $apattern["TPOPUP"]))) $apattern["TPOPUP"][] = $TPOPUP;

        return $apattern;
    }

    /**
     * @function : Décode le mot de passe d'un acheteur
     */
    public static function DecodePassword($password)
    {
        return base64_decode($password);
    }

    /**
     * @function : recherche et retourne la ligne d'un tableau corresspondant au termes de recherche donnée
     */
    public static function ArrayGetRow($array, $skey, $svalue)
    {
        foreach ($array as $key => $value)
        {
            if (( is_object($value) && $value->$skey == $svalue ) || ( is_array($value) && $value[$skey] == $svalue ))
            {
                return $array[$key];
            }
        }
    }

    public static function NumberFormat($number)
    {
        return number_format($number, 2, ".", "");
    }

    /**
     * @function : vérifie si une URL retourne bien un fichier existant
     */
    public static function RemoteFileExists($url)
    {
        if (@fclose(@fopen($url, 'r'))) return true;
        else return false;
    }

    public static function ArraySortMultiple($array, $on, $order = SORT_ASC)
    {
        $new_array      = array();
        $sortable_array = array();

        if (count($array) > 0)
        {
            foreach ($array as $k => $v)
            {
                if (is_array($v))
                {
                    foreach ($v as $k2 => $v2)
                    {
                        if ($k2 == $on)
                        {
                            $sortable_array[$k] = $v2;
                        }
                    }
                }
                else
                {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order)
            {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v)
            {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
    
    
    public static function SendEmail($nomFrom,$nomTo,$mailTo,$sujet,$message)
    {
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mailTo)) // On filtre les serveurs qui présentent des bogues.

        {

            $passage_ligne = "\r\n";

        }

        else

        {

            $passage_ligne = "\n";

        }
        
        
        $message_txt = $message;
        $message_html = "<html><head></head><body>". $message . "</body></html>";




        //=====Lecture et mise en forme de la pièce jointe.
        /*
        $fichier   = fopen("image.jpg", "r");

        $attachement = fread($fichier, filesize("image.jpg"));

        $attachement = chunk_split(base64_encode($attachement));

        fclose($fichier);
        */

        $attachement = null;

        //==========



        //=====Création de la boundary.

        $boundary = "-----=".md5(rand());

        $boundary_alt = "-----=".md5(rand());

        //==========



        //=====Création du header de l'e-mail.

        $header = "From: \"" . $nomFrom . "\"<weaponsb@mail.fr>".$passage_ligne;

        $header.= "Reply-to: \"" . $nomFrom . "\" <weaponsb@mail.fr>".$passage_ligne;

        $header.= "MIME-Version: 1.0".$passage_ligne;

        $header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

        //==========



        //=====Création du message.

        $message = $passage_ligne."--".$boundary.$passage_ligne;

        $message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;

        $message.= $passage_ligne."--".$boundary_alt.$passage_ligne;

        //=====Ajout du message au format texte.

        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;

        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;

        $message.= $passage_ligne.$message_txt.$passage_ligne;

        //==========



        $message.= $passage_ligne."--".$boundary_alt.$passage_ligne;



        //=====Ajout du message au format HTML.

        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;

        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;

        $message.= $passage_ligne.$message_html.$passage_ligne;

        //==========



        //=====On ferme la boundary alternative.

        $message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;

        //==========







        $message.= $passage_ligne."--".$boundary.$passage_ligne;



        //=====Ajout de la pièce jointe.
        /*
        $message.= "Content-Type: image/jpeg; name=\"image.jpg\"".$passage_ligne;

        $message.= "Content-Transfer-Encoding: base64".$passage_ligne;

        $message.= "Content-Disposition: attachment; filename=\"image.jpg\"".$passage_ligne;

        $message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;

        $message.= $passage_ligne."--".$boundary."--".$passage_ligne; 
        */

        //========== 

        //=====Envoi de l'e-mail.

        mail($mailTo,$sujet,$message,$header);

        //==========
    }
	
	public static function DeleteDirectory($dir) {
		if (!file_exists($dir)) {
			return true;
		}

		if (!is_dir($dir)) {
			return unlink($dir);
		}

		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') {
				continue;
			}

			if (Utils::DeleteDirectory($dir . DIRECTORY_SEPARATOR . $item) === false) {
				return false;
			}

		}

		return rmdir($dir);
	}

}
?>
