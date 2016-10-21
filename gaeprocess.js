    function submitData2GAE(formData){
        alert('formData='+JSON.stringify(formData));
        jQuery.ajax({  
            type : 'GET',   
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
    function gaeDecisionTreeSubmitFormFunction(examId,encounterId,patientId){
        alert('examId='+examId+', encounterId='+encounterId+', patientId='+patientId);
        jQuery.ajax({  
            type : 'GET',   
            url : '/module/pregnancycdss/gAEDecisionTree/single.json',   
            data : 'examId=' + examId + '&encounterId=' + encounterId + '&patientId=' + patientId,  
            dataType : 'json',
            success : function(response) {
                var mystr = JSON.stringify(response);
                console.log(response);
                console.log(mystr);
                //alert(mystr);
                submitData2GAE(response);
            },  
            error : function(e) {  
                alert('Error: ' + e);
            }  
        }); 
    }