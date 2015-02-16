<?php
include_once("../../globals.php");
include_once("$srcdir/api.inc");

require ("/Controller/SymptByPatient_Form_Controller.class.php");

$c = new SymptByPatient_Form_Controller();
echo $c->default_action();
?>
