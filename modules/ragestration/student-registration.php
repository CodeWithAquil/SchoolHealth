<?php
$rootPath="./../../";
include($rootPath."include/required-collection.php");
include($rootPath."include/classes/class_registration.php");
$ObjRagestration = new regestration;
$thisFile=basename(__FILE__);

if($_POST['mode']=="save")
{
    $checked=true;
	begin();
    if(!$stid=$ObjRagestration->SaveStudentFromDataArray($_POST)){$checked=true;}
    #echo "CheckProcess";exit;
    if($checked==true){commit();header("Location:student-registration-list.php?stid=$stid");exit;}
    rollback();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="<?php echo $rootPath;?>assets/favicon.ico">
    <title>Ragestration</title><?php
    $GenderArray=$ObjRagestration->GetGenders();
    $SalutationArray=$ObjRagestration->GetSalutation();?>
</head>
<body>
    <?php include($rootPath."main/master_header.php");?>
    <div class="container">
        <form action="<?php echo $thisFile;?>" id="regestration" name="regestration" method="post" autocomplete="off">
            <div class="shadow-lg p-3 mb-5 bg-body rounded">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="st_salutation">Salutation</label>
                        <select name="st_salutation" id="st_salutation" class="form-select" validate="Salutation,,yes">
                            <option value="">Select salutation</option><?php
                            if($SalutationArray)
                            {
                                while($SalutationData=$SalutationArray->FetchRow())
                                {
                                    echo '<option value="'.$SalutationData['sa_key'].'"';if($st_salutation==$SalutationData['sa_key']){echo "selected";}echo '>'.$SalutationData['sa_value'].'</option>';
                                }
                            }?>
                        </select>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="st_first_name">First Name</label>
                        <input type="text" class="form-control" id="st_first_name" placeholder="First Name" name="st_first_name" value="<?php echo $st_first_name?>" validate="First Name,,yes">
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="st_middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="st_middle_name" placeholder="Middle Name" name="st_middle_name" value="<?php echo $st_middle_name?>" validate="Middle Name,,yes">
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="st_last_name">Last Name</label>
                        <input type="text" class="form-control" id="st_last_name" placeholder="Last Name" name="st_last_name" value="<?php echo $st_last_name?>" validate="Last Name,,yes">
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="st_gender">Gender</label>
                        <select name="st_gender" id="st_gender" class="form-select" validate="Gender,,yes">
                            <option value="">Select Gender</option><?php
                            if($GenderArray)
                            {
                                while($GenderData=$GenderArray->FetchRow())
                                {

                                    echo "<pre>";print_r($GenderData['gn_key']); echo "</pre>";
                                    echo '<option value="'.$GenderData['gn_key'].'"';if($st_gender==$GenderData['gn_key']){echo "selected";}echo '>'.$GenderData['gn_value'].'</option>';
                                }
                            }?>
                        </select>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="save"></label>
                        <input type="button" id="save" class="form-control btn btn-md btn-primary" id="save"  name="save" value="submission" onClick="SubmitMyForm('regestration','<?php echo $thisFile;?>','save');">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="mode" id="mode" value="">
                </div>
            </div>
        </form>
    </div>
    <?php include($rootPath."main/master_footer.php");?>
</body>
</html>