<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");



  class SymptByPatient_Model {
    // we define attributes
    // they are public so that we can access them using $symptbypatient->id directly
	var $id;
    var $id_exam;
	var $pid;
	var $user;
    var $id_symptom;
    var $id_sympt_opt;
    var $id_diseases;
    var $p_val;
    var $id_sympt_cat;
    var $id_order;

    public function __construct($id, $id_exam, $pid, $user, $id_symptom, $id_sympt_opt, $id_diseases, $py, $pn, $id_sympt_cat, $id_order) {
        $this->id   = $id;
        $this->id_exam   = $id_exam;
        $this->pid  = $pid;
        $this->user = $user;
        $this->id_symptom = $id_symptom;
        $this->id_sympt_opt = $id_sympt_opt;
        $this->id_diseases = $id_diseases;
        $this->py = $py;
        $this->pn = $pn;
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
            $list[$symptbypt['id']] = new SymptByPatient_Model($symptbypt['id'], $symptbypt['id_exam'], $symptbypt['pid'], $symptbypt['user'], $symptbypt['id_symptom'], $symptbypt['id_sympt_opt'], $symptbypt['id_diseases'], $symptbypt['py'], $symptbypt['pn'], $symptbypt['id_sympt_cat'], $symptbypt['id_order'], $symptbypt['content']);
        }
//var_dump($list);

        return $list;
    }

    public static function find($form_idexam) {
        $list = [];
        // we make sure $id is an integer
        $form_idexam = intval($form_idexam);
        //print_r("SymptByPatient_Model::find");
        //var_dump($form_id);

        //PDO:
        //$db = Db::getInstance();
        //$req = $db->prepare('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE.' WHERE form_id = '.$form_id);
        //$req->Execute(array('form_id' => $form_id));
        //$symptbypt = $req->fetch();

        //ADODB:
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE.' WHERE id_exam = '.$form_idexam.' ORDER BY id_sympt_cat, id_symptom, id_sympt_opt');
//var_dump($req);
        // the query was prepared, now we replace :id_category with our actual $id_category value
        foreach($req as $symptbypt) {
            $list[$symptbypt['id']] = new SymptByPatient_Model($symptbypt['id'], $symptbypt['id_exam'], $symptbypt['pid'], $symptbypt['user'], $symptbypt['id_symptom'], $symptbypt['id_sympt_opt'], $symptbypt['id_diseases'], $symptbypt['py'], $symptbypt['pn'], $symptbypt['id_sympt_cat'], $symptbypt['id_order'], $symptbypt['content']);
        }
//var_dump($list);
        return $list;      
    }

      //Check is it symptom option is selected in given form for given patient
      public static function isselected($form_idexam, $pid, $id_symptom, $id_symp_option) {
          unset($req);
          // we make sure $id is an integer
          $form_idexam = intval($form_idexam);
          $pid = intval($pid);
          $id_symp_option = intval($id_symp_option);
          $id_symptom = intval($id_symptom);
//var_dump($form_id,$pid,$id_symp_option,$id_symptom);
          //ADODB:
          $db = get_db();
          $req = $db->Execute('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE.' WHERE (id_exam = '.$form_idexam.')AND(pid = '.$pid.')AND(id_sympt_opt = '.$id_symp_option.')AND(id_symptom = '.$id_symptom.')');

          if ($req->RecordCount()>0){
              return TRUE;
          }else{
              return False;
          }
        //  var_dump($req);
        //  if (isset($req)){
        //      return TRUE;
        //  }else {
        //      return False;
        //  }
      }
      public static function selectedOptionsCount($form_idexam, $pid, $id_symptom) {
          unset($req);
          // we make sure $id is an integer
          $form_idexam = intval($form_idexam);
          $pid = intval($pid);
          //$id_symp_option = intval($id_symp_option);
          $id_symptom = intval($id_symptom);

          //ADODB:
          $db = get_db();
          $req = $db->Execute('SELECT * FROM '.SYMPTBYPATIENT_DBTABLE.' WHERE (id_exam = '.$form_idexam.')AND(pid = '.$pid.')AND(id_symptom = '.$id_symptom.')');
          return $req->RecordCount();
      }
  }
?>