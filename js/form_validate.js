function SubmitMyForm(FormName,redirectUrl,callbackMode) 
{
    let FormObject=document.getElementById(FormName);
    if(FormObject.save){FormObject.save.setAttribute("disabled","disabled");}
    if(FormObject.update){FormObject.update.setAttribute("disabled","disabled");}
    if(FormObject.search){FormObject.search.setAttribute("disabled","disabled");}
    if(validateForm(FormName)==true)
    {
        FormObject.mode.value=callbackMode;
        FormObject.action=redirectUrl;
        FormObject.submit();
        return true;
    }
    else
    {
        if(FormObject.save){FormObject.save.removeAttribute("disabled","disabled");}
        if(FormObject.update){FormObject.update.removeAttribute("disabled","disabled");}
        if(FormObject.search){FormObject.search.removeAttribute("disabled","disabled");}
        return false;
    }
}

function validateForm(FormName)
{
    inputs=eval('document.'+FormName+'.elements');
    var IsFullyValidated=true;
    for(i=0;i<inputs.length;i++)
    {
        var validateAttribute=inputs[i].getAttribute('validate');
        if(validateAttribute!=null)
        {
            //var FieldType=inputs[i].type;
            //var FieldName=inputs[i].nmae;
            var FieldId=inputs[i].id;
            var AttributeDetails=inputs[i].getAttribute('validate').split(",");
            if(AttributeDetails[2]=="yes")
            {
                if(validateThisField(FieldId)==false){var IsFullyValidated=false}
            }
        }
    }
    return IsFullyValidated;
}

function validateThisField(id)
{
    var FieldObj=document.getElementById(id);
    var FieldVal=FieldObj.value
    if((FieldVal=='') || (FieldVal<=0) || (FieldVal<=0.00)){FieldObj.value="";document.getElementById(id).style.border="1px solid red";return false;}
    else{document.getElementById(id).style.border="";return true;}
}