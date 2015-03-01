<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 01.03.15
 * Time: 14:04
 */
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");

define("SYMPTBYPATIENT_DBTABLE", "pregnacy_cdssform_symptoms_by_patient");
print_r('<br>DB conncct througt ADOdb_Active_Record');
$db = get_db();
ADOdb_Active_Record::SetDatabaseAdapter($db);

class SymptByPatient2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTBYPATIENT_DBTABLE;
}
?>