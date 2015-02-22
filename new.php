<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");

require_once("config.inc.php");

require ("/Controller/PatientExam_Form_Controller.class.php");

define("VIEW_DIR", dirname(__FILE__) . "\View\\");

$c = new PatientExam_Form_Controller();
echo $c->default_action();
?>
