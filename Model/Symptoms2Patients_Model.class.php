<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 08.03.15
 * Time: 12:23
 */

//ADODB_Active_Record::TableKeyHasMany(SYMPTCATEGORY_DBTABLE, 'id', SYMPTOMS_DBTABLE, 'id_category');
//ADODB_Active_Record::TableKeyBelongsTo(SYMPTOMS_DBTABLE, 'id', SYMPTCATEGORY_DBTABLE, 'id_category', 'id');

class SymptCategory2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTCATEGORY_DBTABLE;
}

class Symptoms2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTOMS_DBTABLE;
}

class DeceasesSymptOpt2_Model extends ADOdb_Active_Record {
    var $_table = DECEASESSYMPTOMOPTIONS_DBTABLE;
}

class Deceases2_Model extends ADOdb_Active_Record {
    var $_table = DECEASES_DBTABLE;
}

class SymptByPatient2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTBYPATIENT_DBTABLE;
}

//ADODB_Active_Record::ClassHasMany('SymptCategory2_Model', SYMPTOMS_DBTABLE,'id_category', 'Symptoms2_Model');
//ADODB_Active_Record::ClassHasMany('SymptCategory2_Model', 'Symptoms2_Model','id_category');
//ADODB_Active_Record::ClassBelongsTo('Symptoms2_Model','SymptCategory2_Model','id_category','id');
?>