    function submitData2GAE(formData){
        alert('formData='+JSON.stringify(formData));
        jQuery.ajax({  
            type : 'POST',   
            url : 'http://contactmgr.loc/site/yii2curltest',   
            data : formData,  
            dataType : 'json',
            success : function(response) {
                var mystr = JSON.stringify(response);
                console.log(response);
                console.log(mystr);
                alert(mystr);
                //return response;
            },  
            error : function(e) {  
                alert('Error: ' + e);
                //return null;
            }  
        }); 
    }
    function gaeDecisionTreeSubmitFormFunction(formId, formFolder, scriptName){
        jQuery.ajax({  
            type : 'POST',   
            //url : '../../forms/'+formFolder+'/decisiontreegae.php',
            url : '../../forms/'+formFolder+'/'+scriptName,
            data : 'formId=' + formId,  
            dataType : 'json',
            success : function(response) {
                submitData2GAE(response);
            },  
            error : function(e) {  
                alert('Error: ' + e);
            }  
        }); 
    }