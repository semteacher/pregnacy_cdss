<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 01.03.15
 * Time: 20:52
 */
require_once(MODEL_DIR."SymptByPatient2_Model.class.php");

ADODB_Active_Record::TableKeyBelongsTo(SYMPTOMS_DBTABLE, 'id_symptoms', SYMPTCATEGORY_DBTABLE, 'id_category', 'id_category', 'SymptCategory2_Model');

class Symptoms2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTOMS_DBTABLE;
}
?>