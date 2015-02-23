<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");

define("SYMPTBYPATIENT_DBTABLE", "pregnacy_cdssform_symptoms_by_patient");

  class SymptByPatient_Model {
    // we define attributes
    // they are public so that we can access them using $symptbypatient->id directly
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
        //$req = $db->query('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE);
        
        //ADODB:
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE);
//print_r("SymptByPatient_Model::all");
//var_dump($req);
        // we create a list of SymptByPatient_Model objects from the database results
        //PDO:
        //foreach($req->fetchAll() as $symptbypt) {
        //ADODB:
        foreach($req as $symptbypt) {
            $list[] = new SymptByPatient_Model($symptbypt['id'], $symptbypt['form_id'], $symptbypt['pid'], $symptbypt['user'], $symptbypt['id_symptom'], $symptbypt['id_sympt_opt'], $symptbypt['id_deceases'], $symptbypt['p'], $symptbypt['id_sympt_cat'], $symptbypt['id_order'], $symptbypt['content']);
        }
//var_dump($list);

        return $list;
    }

    public static function find($form_id) {
        $list = [];
        // we make sure $id is an integer
        $form_id = intval($form_id);
        //PDO:
        //$db = Db::getInstance();
        //$req = $db->prepare('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE.' WHERE form_id = '.$form_id);
        //$req->Execute(array('form_id' => $form_id));
        //$symptbypt = $req->fetch();
        
        //ADODB:
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE.' WHERE form_id = '.$form_id);
//print_r("SymptByPatient_Model::find");
//var_dump($form_id);
     
        // the query was prepared, now we replace :id_category with our actual $id_category value
        foreach($req as $symptbypt) {
            $list[] = new SymptByPatient_Model($symptbypt['id'], $symptbypt['form_id'], $symptbypt['pid'], $symptbypt['user'], $symptbypt['id_symptom'], $symptbypt['id_sympt_opt'], $symptbypt['id_deceases'], $symptbypt['p'], $symptbypt['id_sympt_cat'], $symptbypt['id_order'], $symptbypt['content']);
        }
//var_dump($list);
        return $list;      
    }

      //Check is it symptom option is selected in given form for given patient
      public static function isselected($form_id, $pid, $id_symptom, $id_symp_option) {
          unset($req);
          // we make sure $id is an integer
          $form_id = intval($form_id);
          $pid = intval($pid);
          $id_symp_option = intval($id_symp_option);
          $id_symptom = intval($id_symptom);

          //ADODB:
          $db = get_db();
          $req = $db->Execute('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE.' WHERE (form_id = '.$form_id.')AND(pid = '.$pid.')AND(id_sympt_opt = '.$id_symp_option.')AND(id_symptom = '.$id_symptom.')');

          if ($req->RecordCount()>0){
              return TRUE;
          }else{
              return False;
          }
      }
  }
?>