
 function validateFileType(event){
    var file=$('#profile_photo');
    var fileName = document.getElementById("profile_photo").value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" ||extFile=="jfif"){    

       $('#profile_preview_image').attr('src',URL.createObjectURL(event.target.files[0]));
    }else{
        $('#profile_photo').value="";
        alert("Only jpg/jpeg and png files are allowed.");
       document.getElementById("profile_photo").value="";
    }   
}

function validateCSVFileType(event,upload_file_id){
   var element=document.getElementById(upload_file_id);
    var fileName = document.getElementById(upload_file_id).value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="csv" ){  
       
       // alert('filesize='+element.files[0].size);
        if (element.files[0].size > 2097152) {
            alert("Try to upload csv file less than 2MB!");
            document.getElementById(upload_file_id).value="";
        }

    }else{
        
        alert("Only CSV files are allowed.");
        document.getElementById(upload_file_id).value="";
    }   
}
//fade out message
setTimeout(function() {
    $('#success-msg').fadeOut('fast');
}, 3000);
        //fade out message
setTimeout(function() {
    $('#fail-msg').fadeOut('fast');
}, 3000);






