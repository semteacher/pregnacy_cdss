<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 01.03.15
 * Time: 14:04
 */
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");

class SymptByPatient2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTBYPATIENT_DBTABLE;
}
?>