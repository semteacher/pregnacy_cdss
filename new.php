<?php
include_once("../../globals.php");
include_once($GLOBALS["srcdir"]."/api.inc");
require_once($GLOBALS['srcdir'].'/patient.inc');

include_once("config.inc.php");

require_once ("Controller/PatientExam_Form_Controller.class.php");

$c = new PatientExam_Form_Controller();
echo $c->new_action();
?>
