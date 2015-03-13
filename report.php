<?php
//include_once("../../globals.php");
//include_once($GLOBALS["srcdir"]."/api.inc");

include_once("../../globals.php");
include_once("$srcdir/api.inc");

include_once("$srcdir/adodb/adodb-active-record.inc.php");

include_once("config.inc.php");

require ("/Controller/PatientExam_Form_Controller.class.php");


/** CHANGE THIS, the name of the function is significant and  **
 **              must be changed to match the folder name     **/
function pregnacy_cdss_report( $pid, $encounter, $cols, $id) {

    $c = new PatientExam_Form_Controller();
    echo $c->report_action($id);
//    var_dump($pid);
//    var_dump($encounter);
//    var_dump($cols);
//    var_dump($id);
    /** CHANGE THIS - name of the database table associated with this form **/
//    $table_name = PATIENTEXAM_DBTABLE;

//    $count = 0;
//    $data = formFetch($table_name, $id);

//   if ($data) {
//    var_dump($data);
 
//        print "<table><tr>";
//       print "<td><span class=bold>$id: </span><span class=text>$data</span></td>";

//        foreach($data as $key => $value) {
//            if ($key == "id" || $key == "pid" || $key == "user" || 
//                $key == "groupname" || $key == "authorized" || 
//                $key == "activity" || $key == "date" || 
//                $value == "" || $value == "0000-00-00 00:00:00" || 
//                $value == "n") 
//            {
                // skip certain fields and blank data
//	        continue;
//            }

//            $key=ucwords(str_replace("_"," ",$key));
//            print("<tr>\n");  
//            print("<tr>\n");  
//            print "<td><span class=bold>$key: </span><span class=text>$value</span></td>";
//            $count++;
//            if ($count == $cols) {
//                $count = 0;
//                print "</tr><tr>\n";
//            }
//        }

//    }
//    print "</tr></table>";
}

?> 
