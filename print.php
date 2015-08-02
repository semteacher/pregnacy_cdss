<?php
include_once("../../globals.php");
include_once($GLOBALS["srcdir"]."/api.inc");
require_once($GLOBALS['srcdir'].'/patient.inc');

include_once("config.inc.php");

//var_dump($css_header);
//var_dump($rootdir);
//string '/interface/themes/style_oemr.css' (length=32)
//string '/interface' (length=10)

require_once ("Controller/PatientExam_Form_Controller.class.php");

$c = new PatientExam_Form_Controller();
echo $c->print_action($_GET['id']);
?>