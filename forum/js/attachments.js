var upload_field_array = new Array();

var upload_field_html = '<input type="file" name="userfile[]" id="userfile[]" class="bhinputtext" value="" size="40" dir="ltr" />';

function add_upload_field()
{
    var upload_fields_obj;

    if (document.getElementById) {
        upload_fields_obj = eval("document.getElementById('upload_fields')");
    }else if (document.all) {
        upload_fields_obj = eval("document.all.upload_fields");
    }else if (document.layer) {
        upload_fields_obj = eval("document.upload_fields");
    }else {
        return false;
    }
    
    if (upload_field_array.length < 9) {
    
        upload_field_array.push(upload_field_html);
        upload_fields_obj.innerHTML = upload_field_array.join("<br />");
    
    }else {

        alert('You can only upload a maximum of 10 files at a time');
    }
}