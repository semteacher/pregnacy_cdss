<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 08.03.15
 * Time: 12:23
 */

class SymptCategory2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTCATEGORY_DBTABLE;
}

class Symptoms2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTOMS_DBTABLE;
}

class SymptOptions2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTOPTIONS_DBTABLE;
}

class DiseasesSymptOpt2_Model extends ADOdb_Active_Record {
    var $_table = DISEASESSYMPTOMOPTIONS_DBTABLE;
}

class Diseases2_Model extends ADOdb_Active_Record {
    var $_table = DISEASES_DBTABLE;
}

class SymptByPatient2_Model extends ADOdb_Active_Record {
    var $_table = SYMPTBYPATIENT_DBTABLE;
}

?>