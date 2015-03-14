<?php

include_once("../../globals.php");
include_once($GLOBALS["srcdir"]."/api.inc");
//include_once("$srcdir/api.inc");

//include_once("$srcdir/adodb/adodb-active-record.inc.php");

include_once("config.inc.php");

require ("/Controller/PatientExam_Form_Controller.class.php");

function pregnacy_cdss_report( $pid, $encounter, $cols, $id) {

    $c = new PatientExam_Form_Controller();
    echo $c->report_action($id);

}

?> 
