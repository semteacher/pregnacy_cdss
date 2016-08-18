<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");



  class Diseases_Model {
    // we define attributes
        var $id;
        var $dis_name;
	    var $dis_note;
	    var $dis_icd10;

    public function __construct($id, $dis_name, $dis_note, $dis_icd10) {
        $this->id  = $id;
        $this->dis_name  = $dis_name;
        $this->dis_note  = $dis_note;
        $this->dis_icd10  = $dis_icd10;
    }

    public static function all() {
        $list = [];
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.DISEASES_DBTABLE);
        // we create a list of Diseases_Model objects from the database results
        foreach($req as $disease) {
            $list[] = new Diseases_Model($disease['id'], $disease['dis_name'], $disease['dis_note'], $disease['dis_icd10']);
        }
        return $list;
    }


  }
?>