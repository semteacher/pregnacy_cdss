<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 01.03.15
 * Time: 20:08
 */
require_once(MODEL_DIR."Symptoms2_Model.class.php");

ADODB_Active_Record::TableKeyHasMany(SYMPTCATEGORY_DBTABLE, 'id_category', SYMPTOMS_DBTABLE, 'id_category', 'Symptoms2_Model');

class SymptCategory2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTCATEGORY_DBTABLE;
}

?>