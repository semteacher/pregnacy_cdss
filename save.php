<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");

include_once("config.inc.php");

require ("/Controller/PatientExam_Form_Controller.class.php");

$c = new PatientExam_Form_Controller();
echo $c->default_action_process($_POST);
@formJump();
?>
