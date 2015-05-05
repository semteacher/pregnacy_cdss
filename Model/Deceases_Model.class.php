<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");



  class Deceases_Model {
    // we define attributes
        var $id;
        var $dec_name;
	    var $dec_note;
	    var $dec_icd10;

    public function __construct($id, $dec_name, $dec_note, $dec_icd10) {
        $this->id  = $id;
        $this->dec_name  = $dec_name;
        $this->dec_note  = $dec_note;
        $this->dec_icd10  = $dec_icd10;
    }

    public static function all() {
        $list = [];
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.DECEASES_DBTABLE);
        // we create a list of Deceases_Model objects from the database results
        foreach($req as $decease) {
            $list[] = new Deceases_Model($decease['id'], $decease['dec_name'], $decease['dec_note'], $decease['dec_icd10']);
        }
        return $list;
    }


  }
?>