<?php
$rootPath="./../../";
include($rootPath."include/required-collection.php");
include($rootPath."include/classes/class_registration.php");
$ObjRagestration = new regestration;
$thisFile=basename(__FILE__);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php echo $rootPath;?>images/favicon.ico">
    <title>Ragestration</title><?php
    include($rootPath."css-collection-master.php");
    $GenderArray=$ObjRagestration->GetGenders();
    $SalutationArray=$ObjRagestration->GetSalutation();

    ?>
</head>
<body>
    <div class="container">
        <form action="<?php echo $thisFile;?>" id="regestration" name="regestration" method="post">
            <div class="shadow-lg p-3 mb-5 bg-body rounded">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="salutation">Salutation</label>
                        <select name="salutation" id="salutation" class="form-select" required>
                            <option value="">Select salutation</option><?php
                            if($SalutationArray)
                            {
                                while($SalutationData=$SalutationArray->FetchRow())
                                {
                                    echo '<option value="'.$SalutationData['sa_key'].'"';if($Salutation==$SalutationData['sa_key']){echo "selected";}echo '>'.$SalutationData['sa_value'].'</option>';
                                }
                            }?>
                        </select>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo $first_name; ?>" required>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" placeholder="Middle Name" name="middle_name" value="<?php echo $middle_name; ?>" aquil="hii">
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo $last_name; ?>">
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="">Select Gender</option><?php
                            if($GenderArray)
                            {
                                while($GenderData=$GenderArray->FetchRow())
                                {
                                    echo '<option value="'.$GenderData['gn_key'].'"';if($gender==$GenderData['gn_key']){echo "selected";}echo '>'.$GenderData['gn_value'].'</option>';
                                }
                            }?>
                        </select>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label for="submission"></label>
                        <input type="submit" id="submission" class="form-control btn btn-md btn-primary" id="submission"  name="submission" value="submission">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<?php include($rootPath."js-collection-master.php");?>
<script type="text/javascript">
    let FormObject=document.getElementById("regestration");
    FormObject.addEventListener("submit",(e)=>
    {
        e.preventDefault();
        formName=FormObject.name;
        inputs=eval('document.'+formName+'.elements');
        for(i=0;i<inputs.length;i++)
        {
            console.log(inputs[i].name);
        }
    });
</script>
</html>