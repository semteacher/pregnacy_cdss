<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");

include_once("$srcdir/adodb/adodb-active-record.inc.php");

include_once("config.inc.php");

require ("/Controller/PatientExam_Form_Controller.class.php");

$c = new PatientExam_Form_Controller();
echo $c->view_action($_GET['id']);
?>
