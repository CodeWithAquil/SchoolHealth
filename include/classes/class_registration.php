<?php
require_once($rootPath.'include/classes/class_core.php');
class regestration extends core
{
	function __construct(){}

    function GetGenders()
    {
        global $con;
        $GenderData="select gn_key,gn_id,gn_value from sh_gender where gn_status='1' order by gn_order asc";
        #echo $GenderData."<br>";
        if($Result=$con->Execute($GenderData))
        {
            if($Result->recordCount())
            {
                return $Result;
            }else{return false;}
        }else{return false;}
    }

    function GetSalutation()
    {
        global $con;
        $GenderData="select sa_key,sa_id,sa_value from sh_salutation where sa_status='1' order by sa_order asc";
        #echo $GenderData."<br>";
        if($Result=$con->Execute($GenderData))
        {
            if($Result->recordCount())
            {
                return $Result;
            }else{return false;}
        }else{return false;}
    }
}
?>