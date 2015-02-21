<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");

define("SYMPTBYPATIENT_DBTABLE", "pregnacy_cdssform_symptoms_by_patient");

  class SymptByPatient1_Model {
    // we define attributes
    // they are public so that we can access them using $sympcategory1->cat_name directly
	var $id;
    var $form_id;
	var $pid;
	var $user;
    var $id_symptom;
    var $id_sympt_opt;
    var $id_deceases;
    var $p_val;
    var $id_sympt_cat;
    var $id_order;

    public function __construct($id, $form_id, $pid, $user, $id_symptom, $id_sympt_opt, $id_deceases, $p_val, $id_sympt_cat, $id_order) {
      $this->id   = $id;
      $this->form_id   = $form_id;
      $this->pid  = $pid;
      $this->user = $user;
      $this->id_symptom = $id_symptom;
      $this->id_sympt_opt = $id_sympt_opt;
      $this->id_deceases = $id_deceases;
      $this->p_val = $p_val;
      $this->id_sympt_cat = $id_sympt_cat;
      $this->id_order = $id_order;
    }

    public static function all() {
      $list = [];
      //PDO:
      //$db = Db::getInstance();
      //$req = $db->query('SELECT * FROM pregnacy_cdssform_symptoms_by_patient');
      //ADODB:
      $db = get_db();
      $req = $db->Execute('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE);
print_r("SymptByPatient1_Model::all");
var_dump($req);
      // we create a list of SymptByPatient1_Model objects from the database results
      //foreach($req->fetchAll() as $symptbypt1) {
      foreach($req as $symptbypt1) {
        $list[] = new SymptByPatient1_Model($symptbypt1['id'], $symptbypt1['form_id'], $symptbypt1['pid'], $symptbypt1['user'], $symptbypt1['id_symptom'], $symptbypt1['id_sympt_opt'], $symptbypt1['id_deceases'], $symptbypt1['p'], $symptbypt1['id_sympt_cat'], $symptbypt1['id_order'], $symptbypt1['content']);
      }
var_dump($list);
      return $list;
    }

    public static function find($form_id) {
        $list = [];
        // we make sure $id is an integer
        $form_id = intval($form_id);
      //$db = Db::getInstance();
      //$req = $db->prepare('SELECT * FROM posts WHERE id = :id');
      $db = get_db();

        $sql = 'SELECT * FROM '.SYMPTBYPATIENT_DBTABLE.' WHERE form_id = '.$form_id;
        
      $req = $db->Execute($sql);
print_r("SymptByPatient1_Model::find");
var_dump($form_id);
var_dump($sql);
//var_dump($req);      
      // the query was prepared, now we replace :id_category with our actual $id_category value
      //$req->Execute(array('id_category' => $id_category));
      //$symptbypt1 = $req->fetch();
        foreach($req as $symptbypt1) {
            $list[] = new SymptByPatient1_Model($symptbypt1['id'], $symptbypt1['form_id'], $symptbypt1['pid'], $symptbypt1['user'], $symptbypt1['id_symptom'], $symptbypt1['id_sympt_opt'], $symptbypt1['id_deceases'], $symptbypt1['p'], $symptbypt1['id_sympt_cat'], $symptbypt1['id_order'], $symptbypt1['content']);
      }
        var_dump($list);
        return $list;      
    }
  }
?>