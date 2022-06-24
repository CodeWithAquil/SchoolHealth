<?php
require_once($rootPath.'include/classes/class_core.php');
class regestration extends core
{
	function __construct(){}

    var $studentTable="sh_students";

    var $studentField=array('st_key','st_ragestration_id','st_ragestration_time','st_salutation','st_first_name','st_middle_name','st_last_name','st_gender','st_birth_date','st_age_year','st_age_month','st_age_day','st_father_name','st_father_mobile','st_mother_name','st_mother_mobile','st_guardian_name','st_guardian_mobile','st_status','st_created_time','st_created_id','st_modified_time','st_modified_id','st_history');

    function _useStudent()
    {
        $this->coretable=$this->studentTable;
        $this->ref_array=$this->studentField;
    }

    function SaveStudentFromDataArray($postedData)
    {
        global $con,$_SESSION;
        $this->date=date('Y-m-d H:i:s');
        $this->userId=$_SESSION['sess_userid'];
        $this->_useStudent();
	    $this->data_array=$postedData;
        $this->data_array['st_ragestration_time']=$this->date;
        $this->data_array['st_created_time']=$this->date;
        $this->data_array['st_created_id']=$this->userId;
	    $this->data_array['st_history']="Student Ragestred: on $this->date by $this->userId\n";
	    $this->insertDataFromInternalArray();
        return $con->Insert_ID();
    }

    function UpdateStudentFromDataArray($key,$postedData,$where="")
    {
        global $_SESSION;
        $this->date=date('Y-m-d H:i:s');
        $this->userId=$_SESSION['sess_userid'];
        $this->date=date('Y-m-d H:i:s');
        $this->_useStudent();
        $this->where=$where;
	    $this->data_array=$postedData;
        $this->data_array['st_modified_time']=$this->date;
        $this->data_array['st_modified_id']=$this->userId;
	    $this->data_array['st_history']="Update Student Details: on $this->date by $this->userId\n";
	    return $this->updateDataFromInternalArray($key);
    }

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