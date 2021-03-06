<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");



  class DiseasesSymptOpt_Model {
    // we define attributes
    // they are public so that we can access them using $symptoms->cat_name directly
        var $id;
        var $id_diseases;
	    var $id_sympt_opt;
	    var $py;
        var $pn;

    public function __construct($id, $id_diseases, $id_sympt_opt, $py=0, $pn=0) {
        $this->id  = $id;
        $this->id_diseases  = $id_diseases;
        $this->id_sympt_opt  = $id_sympt_opt;
        $this->py  = $py;
        $this->pn  = $pn;
    }

    public static function all() {
        $list = [];
        //PDO:
        //$db = Db::getInstance();
        //$req = $db->query('SELECT * FROM '.DECEASESSYMPTOMOPTIONS_DBTABLE);
        
        //ADODB:
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.DISEASESSYMPTOMOPTIONS_DBTABLE.'ORDER BY id_diseases');
//print_r("SymptOptions_Model::all");
//var_dump($req);
        // we create a list of DiseasesSymptOpt_Model objects from the database results
        //PDO:
        //foreach($req->fetchAll() as $decsymptopt) {
        //ADODB:
        foreach($req as $decsymptopt) {
            $list[] = new DiseasesSymptOpt_Model($decsymptopt['id'], $decsymptopt['id_diseases'], $decsymptopt['id_sympt_opt'], $decsymptopt['py'], $decsymptopt['pn']);
        }
//var_dump($list);
        return $list;
    }

    public static function findbysymptopt($id_symptopt) {
        $list = [];
        // we make sure $id_category is an integer
        $id_symptopt = intval($id_symptopt);
        //PDO:
        //$db = Db::getInstance();
        //$req = $db->prepare('SELECT * FROM '.DECEASESSYMPTOMOPTIONS_DBTABLE.' WHERE id_symptom = :id_symptom');
        // the query was prepared, now we replace :id_category with our actual $id_category value
        //$req->execute(array('id_symptom' => $id_symptom));
        //$decsymptopt = $req->fetch();
        //return new DiseasesSymptOpt_Model($decsymptopt['id'], $decsymptopt['cat_name'], $decsymptopt['content']);
        //ADODB:
//print_r("Symptoms_Model::all");
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.DISEASESSYMPTOMOPTIONS_DBTABLE.' WHERE id_sympt_opt = '.$id_symptopt.' ORDER BY id');
        foreach($req as $decsymptopt) {
            $list[] = new DiseasesSymptOpt_Model($decsymptopt['id'], $decsymptopt['id_diseases'], $decsymptopt['id_sympt_opt'], $decsymptopt['py'], $decsymptopt['pn']);
        }
//var_dump($list);
        return $list;
    }
  }
?>