<?php
include_once("../../globals.php");
include_once($GLOBALS["srcdir"]."/api.inc");
//include_once("$srcdir/api.inc");

include_once("config.inc.php");

require_once ("Controller/PatientExam_Form_Controller.class.php");

//echo $c->default_action_process($_POST);
if ($_POST['process'] == "true") {
    $c = new PatientExam_Form_Controller();
    echo $c->save_action_process($_POST);
    $_POST['process'] = "";
}

@formJump();
?>
