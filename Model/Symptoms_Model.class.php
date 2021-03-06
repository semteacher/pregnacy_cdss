<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");



  class Symptoms_Model {
    // we define attributes
    // they are public so that we can access them using $symptoms->cat_name directly
    var $id;
	var $symp_name;
	var $symp_notes;
    var $id_order;
    var $id_category;
    var $is_multi;
    var $is_selected;
    var $symptoptions;


    public function __construct($id, $symp_name, $symp_notes, $id_order, $id_category, $is_multi, $is_selected) {
        $this->id  = $id;
        $this->symp_name  = $symp_name;
        $this->symp_notes = $symp_notes;
        $this->id_order  = $id_order;
        $this->id_category  = $id_category;
        $this->is_multi = $is_multi;
        $this->is_selected = $is_selected;
        $this->symptoptions = SymptOptions_Model::find($id);
    }

    public static function all() {
        $list = [];
        //PDO:
        //$db = Db::getInstance();
        //$req = $db->query('SELECT * FROM '.SYMPTOMS_DBTABLE);
        
        //ADODB:
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.SYMPTOMS_DBTABLE.' ORDER BY id_order');
//print_r("Symptoms_Model::all");
//var_dump($req);
        // we create a list of SymptCategory_Model objects from the database results
        //PDO:
        //foreach($req->fetchAll() as $sympcategory) {
        //ADODB:
        foreach($req as $symptoms) {
            $list[] = new Symptoms_Model($symptoms['id'], $symptoms['symp_name'], $symptoms['symp_notes'], $symptoms['id_order'], $symptoms['id_category'], $symptoms['is_multi'], $symptoms['is_selected']);
        }
//var_dump($list);
        return $list;
    }

    public static function find($id_category) {
        $list = [];
        // we make sure $id_category is an integer
        $id_category = intval($id_category);
        //PDO:
        //$db = Db::getInstance();
        //$req = $db->prepare('SELECT * FROM '.SYMPTOMS_DBTABLE.' WHERE id_category = :id_category');
        // the query was prepared, now we replace :id_category with our actual $id_category value
        //$req->execute(array('id_category' => $id_category));
        //$sympcategory = $req->fetch();
        //return new SymptCategory_Model($sympcategory['id_category'], $sympcategory['cat_name'], $sympcategory['content']);
        //ADODB:
//print_r("Symptoms_Model::all");
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.SYMPTOMS_DBTABLE.' WHERE id_category = '.$id_category.' ORDER BY id_order');
        foreach($req as $symptoms) {
            $list[] = new Symptoms_Model($symptoms['id'], $symptoms['symp_name'], $symptoms['symp_notes'], $symptoms['id_order'], $symptoms['id_category'], $symptoms['is_multi'], $symptoms['is_selected']);
        }
//var_dump($list);
        return $list;
    }

    public static function is_multy($id) {
        // we make sure $id_symptom is an integer
        $id_symptoms = intval($id);
        $db = get_db();
        $req = $db->Execute('SELECT is_multi FROM '.SYMPTOMS_DBTABLE.' WHERE id = '.$id);
        return $req->fields('is_multi');

    }
  }
?>