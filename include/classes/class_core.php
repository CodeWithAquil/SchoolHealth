<?php
class Core
{
    public $coretable;
    public $sql='';
    public $ref_array=array();
    public $data_array=array();
    public $buffer_array=array();
    public $result;
    public $buffer;
    public $res=array();
    private $ok;
    public $is_preloaded=false;
    public $error_msg='';
    public $dead_stat="'deleted','hidden','inactive','void'";
    public $normal_stat="'','normal'";
    
    function setTable($table)
    {
        $this->coretable=$table;
    }

    function setRefArray($array)
    {
        if(!is_array($array)){return false;}
        else
        {
            $this->ref_array=$array;
            return true;
        }
    }

    function setDataArray($array)
    {
        $this->data_array=$array;
    }
   
    function _RecordExists($cond='')
    {
        global $con;
        if(empty($cond)){return false;}
        $SqlExist="SELECT create_time FROM $this->coretable WHERE $cond";
        if($this->result=$con->Execute($SqlExist))
        {
            if($this->result->RecordCount())
            {
                return true;
            }else{return false;}
        }else{return false;}
    }

    function setSQL($sql)
    {
        $this->sql=$sql;
    }
    
    function Transact($sql='')
    {
        global $con;
        if(empty($sql)){return false;}
        $con->BeginTrans();
        $this->ok=$con->Execute($sql);
        if($this->ok)
        {
            $con->CommitTrans();
            return true;
        }
        else
        {
            $con->RollbackTrans();
            return false;
        }
    }
   
    function _prepSaveArray()
    {
        $v='';
        reset($this->ref_array);
        reset($this->data_array);
        foreach($this->ref_array as $v)
        {
            if(isset($this->data_array[$v]) )
            {
                $this->buffer_array[$v]=$this->data_array[$v];
                if($v=='created_time' && $this->data['created_time']!=''){$this->buffer_array[$v] = date('Y-m-d H:i:s');}
            }
        }
        reset($this->ref_array);
        return sizeof($this->buffer_array);
    }

    function insertDataFromInternalArray()
    {
        $this->_prepSaveArray();
        return $this->insertDataFromArray($this->buffer_array);
    }

    function getAllItemsObject($items)
    {
        global $con;
        $this->sql="SELECT $items FROM $this->coretable";
        if($this->res=$con->Execute($this->sql))
        {
            if($this->rec_count=$this->res->RecordCount())
            {
                return $this->res;
            }else{return false;}
        }else{return false;}
    }

    function getAllDataObject()
    {
        global $con;
        $this->sql="SELECT * FROM $this->coretable";
        if($this->res=$con->Execute($this->sql))
        {
            if($this->rec_count=$this->res->RecordCount())
            {
                return $this->res;
            }else{return false;}
        }else{return false;}
    }

    function getAllItemsArray($items)
    {
        global $con;
        $this->sql="SELECT $items FROM $this->coretable";
        if($this->result=$con->Execute($this->sql))
        {
            if($this->result->RecordCount())
            {
                return $this->result->GetArray();
            }else{return false;}
        }else{return false;}
    }

    function getAllDataArray()
    {
        global $con;
        $this->sql="SELECT * FROM $this->coretable";
        if($this->result=$con->Execute($this->sql))
        {
            if($this->result->RecordCount())
            {
                while($this->ref_array=$this->result->FetchRow());
                return $this->ref_array;
            }else{return false;}
        }else{return false;}
    }

    function insertDataFromArray($array)
    {
        $x=$v=$index=$values='';
        $concatfx='concat';
        if(!is_array($array)){return false;}
        foreach($array as $x => $v)
        {
            $index.="`$x`,";
            if(stristr($v,$concatfx) || (stristr($v,'null') && strlen($v)===4)){$values.=" $v,";}else{$values.="'$v',";}
        }
        reset($array);
        $index=substr_replace($index,'',(strlen($index))-1);
        $values=substr_replace($values,'',(strlen($values))-1);
        $this->sql="INSERT INTO $this->coretable ($index) VALUES ($values)";
        reset($array);
        return $this->Transact();
    }

    function updateDataFromArray($array,$item_nr,$isnum)
    {
        $x=$v=$elems='';
        $concatfx='concat';
        if(empty($array) || empty($item_nr) || ($isnum && !is_numeric($item_nr))){return false;}
        foreach($array as $x => $v)
        {
            $elems.="`$x`=";
            if(stristr($v,$concatfx) || (stristr($v,'null') && strlen($v)===4)){$elems.=" $v,";}else $elems.="'$v',";
        }
        reset($array);
        $elems=substr_replace($elems,'',(strlen($elems))-1);
        if(empty($this->where)){$this->where="nr=$item_nr";}
        $this->sql="UPDATE $this->coretable SET $elems WHERE $this->where";
        $this->where='';
        return $this->Transact();
    }

    function updateDataFromInternalArray($item_nr,$isnum)
    {
        if(empty($item_nr) || ($isnum && !is_numeric($item_nr))){return false;}
        $this->_prepSaveArray();
        return $this->updateDataFromArray($this->buffer_array,$item_nr,$isnum);
    }

    function getLastQuery()
    {
        return $this->sql;
    }

    function getResult()
    {
        return $this->result;
    }

    function getErrorMsg()
    {
        return $this->error_msg;
    }

    function setWhereCondition($cond)
    {
        $this->where=$cond;
    }

    function isPreLoaded()
    {
        return $this->is_preloaded;
    }

    function LastRecordCount()
    {
        return $this->rec_count;
    }

    function saveDBCache($id,$data,$bin)
    {
        if($bin){$elem='cbinary';}else{$elem='ctext';}
        $this->sql="INSERT INTO sh_cache (id,$elem,tstamp) VALUES ('$id','$data','".date('YmdHis')."')";
        return $this->Transact();
    }
    
    function getDBCache($id,$data,$bin)
    {
        global $con;
        if($bin){$elem='cbinary';}else{$elem='ctext';}
        $this->sql="SELECT $elem FROM sh_cache WHERE id='$id'";
        if($buf=$con->Execute($this->sql))
        {
            if($buf->RecordCount())
            {
                $row=$buf->FetchRow();
                $data=$row[$elem];
                return true;
            }else{return false;}
        }else{return false;}
    }

    function deleteDBCache($id)
    {
        if(empty($id)){return false;}
        $this->sql="DELETE FROM sh_cache WHERE id='$id'";
        return $this->Transact();
    }

    function deleteOldValues($batch_nr,$encounter_nr)
    {
        if(empty($batch_nr) || empty($encounter_nr)){return false;}
        $this->sql="DELETE  FROM $this->coretable WHERE batch_nr = '$batch_nr' AND encounter_nr = '$encounter_nr'";
        return $this->Transact();
    }	

    function coreFieldNames()
    {
        return $this->ref_array;
    }

    function FilesListArray($path='',$filter='',$sort='ASC')
    {
        $localpath=$path.'/.';
        $this->res=array();
        if(file_exists($localpath))
        {
            $handle=opendir($path);
            $count=0;
            while (false!==($file=readdir($handle)))
            {
                if($file!="." && $file!="..")
                {
                    if(!empty($filter))
                    {
                        if(stristr($file,$filter))
                        {
                            $this->res[$count]=$file;
                            $count++;
                        }
                    }
                    else
                    {
                        $this->res[$count]=$file;
                        $count++;
                    }
                }
            }
            closedir($handle);
            if($count)
            {
                $this->rec_count=$count;
                if($sort=='ASC'){sort($this->res);}
                elseif($sort=='DESC'){rsort($this->res);}
                else{return $this->res;}
            }
        }else{return false;}
    }

    function postgre_Insert_ID($table,$pk,$oid=0)
    {
        global $con;
        if(empty($oid)){return 0;}
        else
        {
            $this->sql="SELECT $pk FROM $table WHERE oid=$oid";
            if($result=$con->Execute($this->sql))
            {
                if($result->RecordCount())
                {
                    $buf=$result->FetchRow();
                    return $buf[$pk];
                }else{return 0;}
            }else{return 0;}
        }
    }

    function LastInsertPK($pk='',$oid=0)
    {
        if(empty($pk) || empty($oid)){return $oid;}
        else{return $oid;}
    }

    function ConcatFieldString($fieldname,$str='')
    {
        return "CONCAT($fieldname,'$str')";
    }

    function ConcatHistory($str='')
    {
        return $this->ConcatFieldString('history',$str);
    }

    function ConcatNotes($str='')
    {
        return $this->ConcatFieldString('notes',$str);
    }

    function ReplaceFieldString($fieldname,$str1='',$str2='')
    {
        return "REPLACE($fieldname,'$str1','$str2')";
    }
}
?>