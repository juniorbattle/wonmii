<?php

abstract class Date
{

    /**
     * @function : Renvoie la date d'aujourd'hui, sous format écrit
     */
    public static function GetNowDateChaine($langue = "fr", $GETH = false)
    {
        $jour    = date("d");
        $nommois = date("m");
        $annee   = date("Y");
        $heure   = ($GETH) ? date("H:i:s") : "";

        switch ($langue) :
            case "fr":
                $now     = $jour . " " . ucfirst(Date::MonthNumToMonthChaine($nommois, $langue)) . " " . $annee . " " . $heure;
                break;
            case "uk":
                $suffixe = date("S");
                $now     = ucfirst(Date::MonthNumToMonthChaine($nommois, $langue)) . " " . $jour . $suffixe . " " . $annee . " " . $heure;
                break;
        endswitch;

        return $now;
    }

    public static function DatimeToDateChaine($datetime, $langue = "fr", $GETH = false)
    {
        $dateExpl = explode(" ", $datetime);
        $date     = explode("-", $dateExpl[0]);

        $jour    = $date[2];
        $nommois = $date[1];
        $annee   = $date[0];
        $heure   = ($GETH) ? $dateExpl[1] : "";

        switch ($langue) :
            case "fr":
                $now     = $jour . " " . ucfirst(Date::MonthNumToMonthChaine($nommois, $langue)) . " " . $annee . " " . $heure;
                break;
            case "en":
            case "uk":
                $suffixe = date("S");
                $now     = ucfirst(Date::MonthNumToMonthChaine($nommois, $langue)) . " " . $jour . $suffixe . " " . $annee . " " . $heure;
                break;
        endswitch;

        return $now;
    }

    /**
     * @function : Renvoie la datetime d'aujourd'hui
     */
    public static function GetNowDatetime()
    {
        return date("Y-m-d H:i:s");
    }

    public static function GetNowTimestamp()
    {
        $date = new DateTime();
        return $date->getTimestamp();
    }

    public static function GetDateTimeDetails($datetime)
    {
        $expFdate = explode(" ", $datetime);
        $date     = explode("-", $expFdate[0]);
        $time     = explode(":", $expFdate[1]);
        return array(
            "date" => array(
                "year"  => $date[0],
                "month" => $date[1],
                "day"   => $date[2]),
            "time" => array(
                "hour" => $time[0],
                "min"  => $time[1],
                "sec"  => $time[2]
            )
        );
    }

    public static function DateFrToDateMysql($dateFr)
    {
        if ($dateFr != null)
        {
            $date = explode("/", $dateFr);
            return $date[2] . "-" . $date[1] . "-" . $date[0];
        }
        else
        {
            return false;
        }
    }

    /** === BEGIN FONCTION DATE MYSQL === ** */
    public static function DatetimeToDateFr($datetime)
    {
        $date    = explode(" ", $datetime);
        $dateJMA = Date::DateMysqlToDateFr($date[0]);
        return $dateJMA;
    }

    public static function DateMysqlToDateFr($dateMysql)
    {
        if ($dateMysql != null)
        {
            $date = explode("-", $dateMysql);
            return $date[2] . "/" . $date[1] . "/" . $date[0];
        }
        else
        {
            return false;
        }
    }

    public static function DateMysqlToDateFr2($dateMysql)
    {
        if ($dateMysql != null)
        {
            $dateExpl = explode(" ", $dateMysql);
            $date     = explode("/", Date::DateMysqlToDateFr($dateExpl[0]));
            return $date[0] . " " . Date::MonthNumToMonthChaine($date[1]) . " " . $date[2];
        }
        else return false;
    }

    public static function DateMysqlToDateFr3($dateMysql, $time = true)
    {
        if ($dateMysql != null)
        {
            $dateExpl = explode(" ", $dateMysql);
            $date     = explode("-", $dateExpl[0]);
            $dtime    = ($time) ? " " . $dateExpl[1] : "";
            return $date[2] . "/" . $date[1] . "/" . $date[0] . $dtime;
        }
        else
        {
            return false;
        }
    }

    public static function DatetimeToDateFormat($datetime, $langue = "fr")
    {
        if ($datetime != null)
        {
            $dateExpl = explode(" ", $datetime);
            $date     = explode("-", $dateExpl[0]);

            switch ($langue)
            {
                default:
                case "fr":
                    return $date[0] . " " . Date::MonthNumToMonthChaine($date[1], $langue) . " " . $date[2];
                    break;

                case "en":
                case "uk":
                    return ucfirst(Date::MonthNumToMonthChaine($date[1], $langue)) . " " . $date[2] . date("S", mktime(0, 0, 0, 0, $date[2], 0)) . " " . $date[0];
                    break;
            }
        }
        else return false;
    }
    
    public static function DatetimeToFormatDate($datetime, $langue = "fr")
    {
        $date = explode(" ", $datetime);
        switch ($langue)
        {
            case "fr":
                $dateJMA = Date::DatetimeToDateFormat($date[0], $langue);
                $dateHMS = $date[1];
                return "Le " . $dateJMA . " à " . $dateHMS;
                break;
            case "en":
            case "uk" :
                break;
        }
        return false;
    }

    /** === END FONCTION DATETIME MYSQL === ** */
    public static function MonthNumToMonthChaine($numMonth, $langue = "fr")
    {
        switch ($langue) :
            case "fr":
                $mois = array("01" => "janvier",
                    "02" => "février",
                    "03" => "mars",
                    "04" => "avril",
                    "05" => "mai",
                    "06" => "juin",
                    "07" => "juillet",
                    "08" => "août",
                    "09" => "septembre",
                    "10" => "octobre",
                    "11" => "novembre",
                    "12" => "décembre");
                break;

            case "en":
            case "uk":
                $mois = array("01" => "january",
                    "02" => "february",
                    "03" => "march",
                    "04" => "april",
                    "05" => "may",
                    "06" => "june",
                    "07" => "july",
                    "08" => "august",
                    "09" => "september",
                    "10" => "october",
                    "11" => "november",
                    "12" => "december");
                break;
        endswitch;

        return $mois[$numMonth];
    }

    public static function DateToTimestamp($date)
    {
        return preg_match('/^\s*(\d\d\d\d)-(\d\d)-(\d\d)\s*(\d\d):(\d\d):(\d\d)/', $date, $m) ? mktime($m[4], $m[5], $m[6], $m[2], $m[3], $m[1]) : 0;
    }

    public static function DateDiff($recent, $old, $retour = null)
    {
        $diffTimestamp = Date::DateToTimestamp($recent) - Date::DateToTimestamp($old);
        switch ($retour)
        {
            default :
                return $diffTimestamp;
                break;
            case "minutes" :
                return $diffTimestamp / 60;
                break;
            case "jours" :
                return $diffTimestamp / 86400;
                break;
        }
    }

    /**
     * @function : Retourne l'âge à partir d'une date française
     * */
    public static function Age($date_naissance)
    {
        $arr1 = explode('/', $date_naissance);
        $arr2 = explode('/', date('d/m/Y'));

        if (($arr1[1] < $arr2[1]) || (($arr1[1] == $arr2[1]) && ($arr1[0] <= $arr2[0]))) return $arr2[2] - $arr1[2];

        return $arr2[2] - $arr1[2] - 1;
    }

    public static function FormatDate($date, $langue)
    {
        if ($langue == "fr")
        {
            $date  = explode(' ', $date);
            $tab   = explode('-', $date[0]);
            $annee = $tab[0];
            $mois  = $tab[1];
            $jour  = $tab[2];
            return $jour . "/" . $mois . "/" . $annee;
        }
        elseif ($langue == "uk")
        {
            $date  = explode(' ', $date);
            $tab   = explode('-', $date[0]);
            $annee = $tab[0];
            $mois  = $tab[1];
            $jour  = $tab[2];
            return $mois . "/" . $jour . "/" . $annee;
        }
    }

    public static function GetListeMY($order = "DESC", $debutMois, $debutYear)
    {
        $list = array();

        $i = 0;
        for ($y = $debutYear; $y <= date("Y"); $y++)
        {
            if ($y == $debutYear && $debutYear != date("Y"))
            {
                for ($m = $debutMois; $m <= 12; $m++)
                {
                    $list[$i]["display"]     = Date::MonthNumToMonthChaine(sprintf("%02d", $m)) . " " . $y;
                    $list[$i]["mysql_value"] = $y . "-" . sprintf("%02d", $m);
                    $i++;
                }
            }
            elseif ($y == date("Y") && $debutYear != date("Y"))
            {
                for ($m = 1; $m <= date("m"); $m++)
                {
                    $list[$i]["display"]     = Date::MonthNumToMonthChaine(sprintf("%02d", $m)) . " " . $y;
                    $list[$i]["mysql_value"] = $y . "-" . sprintf("%02d", $m);
                    $i++;
                }
            }
            elseif ($debutYear == date("Y"))
            {
                for ($m = $debutMois; $m <= date("m"); $m++)
                {
                    $list[$i]["display"]     = Date::MonthNumToMonthChaine(sprintf("%02d", $m)) . " " . $y;
                    $list[$i]["mysql_value"] = $y . "-" . sprintf("%02d", $m);
                    $i++;
                }
            }
            else
            {
                for ($m = 1; $m <= 12; $m++)
                {
                    $list[$i]["display"]     = Date::MonthNumToMonthChaine(sprintf("%02d", $m)) . " " . $y;
                    $list[$i]["mysql_value"] = $y . "-" . sprintf("%02d", $m);
                    $i++;
                }
            }
        }

        if ($order == "DESC")
        {
            return array_reverse($list);
        }

        return $list;
    }

    /**
     * @function : Retourne les mois d'une année possible pour les filtres 
     */
    public static function GetMonthsForSearch($langue = "fr")
    {
        $mois = array();
        switch ($langue)
        {
            case "fr":
                $mois = array("01" => "janvier",
                    "02" => "février",
                    "03" => "mars",
                    "04" => "avril",
                    "05" => "mai",
                    "06" => "juin",
                    "07" => "juillet",
                    "08" => "août",
                    "09" => "septembre",
                    "10" => "octobre",
                    "11" => "novembre",
                    "12" => "décembre");
                return $mois;
                break;

            case "uk":
                $mois = array("01" => "january",
                    "02" => "february",
                    "03" => "march",
                    "04" => "april",
                    "05" => "may",
                    "06" => "june",
                    "07" => "july",
                    "08" => "august",
                    "09" => "september",
                    "10" => "october",
                    "11" => "november",
                    "12" => "december");
                return $mois;
                break;
        }
    }

    public static function GetYearsForSearch()
    {
        $listYear = array();
        $start    = 2012;
        $end      = date("Y");
        $i        = 0;
        for ($y = $end; $y >= $start; $y--)
        {
            $listYear[$i] = $y;
            $i++;
        }
        return $listYear;
    }

    /**
     * @function : Retourne la date minimum disponible pour un enlevement, en ayant pour date de départ la date d'aujourd'hui.
     */
    public static function GetDateMinForEnlevement()
    {
        $nowDay = date("N");
        switch ($nowDay)
        {
            case 1: $minDayToAdd = "2";
                break; //LUNDI
            case 2: $minDayToAdd = "2";
                break; //MARDI
            case 3: $minDayToAdd = "2";
                break; //MERCREDI
            case 4: $minDayToAdd = "4";
                break; //JEUDI
            case 5: $minDayToAdd = "4";
                break; //VENDREDI
            case 6: $minDayToAdd = "4";
                break; //SAMEDI
            case 7: $minDayToAdd = "3";
                break; //DIMANCHE
        }
        $dateMinForEnlevement = new DateTime("now +" . $minDayToAdd . "day", new DateTimezone("Europe/Paris"));
        return $dateMinForEnlevement->format('d/m/Y');
    }

}
?>