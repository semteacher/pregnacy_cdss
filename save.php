<?php
/*
 * This saves the submitted form
 */
include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("$srcdir/forms.inc");

/** CHANGE THIS - name of the database table associated with this form **/
$table_name = "pregnacy_cdss_patient_data";

/** CHANGE THIS name to the name of your form **/
$form_name = "CDSS \"Вагітність 2.0\"(save)";

/** CHANGE THIS to match the folder you created for this form **/
$form_folder = "pregnacy_cdss";


if ($encounter == "") $encounter = date("Ymd");

if ($_GET["mode"] == "new") {
    
    /* NOTE - for customization you can replace $_POST with your own array
     * of key=>value pairs where 'key' is the table field name and 
     * 'value' is whatever it should be set to
     * ex)   $newrecord['parent_sig'] = $_POST['sig'];
     *       $newid = formSubmit($table_name, $newrecord, $_GET["id"], $userauthorized);
     */
    
    /* save the data into the form's own table */
    $newid = formSubmit($table_name, $_POST, $_GET["id"], $userauthorized);
    
    /* link the form to the encounter in the 'forms' table */
    addForm($encounter, $form_name, $newid, $form_folder, $pid, $userauthorized);
} 
elseif ($_GET["mode"] == "update") {
    /* update existing record */
    $success = formUpdate($table_name, $_POST, $_GET["id"], $userauthorized);
}

$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
?>
