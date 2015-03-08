<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");



  class SymptOptions_Model {
    // we define attributes
    // they are public so that we can access them using $symptoms->cat_name directly
        var $id;
        var $id_symptom;
	    var $opt_name;
	    var $id_order;
        var $is_selected;

    public function __construct($id, $id_symptom, $opt_name, $id_order, $is_selected) {
        $this->id  = $id;
        $this->id_symptom  = $id_symptom;
        $this->opt_name  = $opt_name;
        $this->id_order  = $id_order;
        $this->is_selected  = $is_selected;
    }

    public static function all() {
        $list = [];
        //PDO:
        //$db = Db::getInstance();
        //$req = $db->query('SELECT * FROM '.SYMPTOPTIONS_DBTABLE);
        
        //ADODB:
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.SYMPTOPTIONS_DBTABLE.'ORDER BY id_order');
//print_r("SymptOptions_Model::all");
//var_dump($req);
        // we create a list of SymptOptions_Model objects from the database results
        //PDO:
        //foreach($req->fetchAll() as $sympcategory) {
        //ADODB:
        foreach($req as $symptopt) {
            $list[] = new SymptOptions_Model($symptopt['id'], $symptopt['id_symptom'], $symptopt['opt_name'], $symptopt['id_order'], $symptopt['is_selected']);
        }
//var_dump($list);
        return $list;
    }

    public static function find($id_symptom) {
        $list = [];
        // we make sure $id_category is an integer
        $id_symptom = intval($id_symptom);
        //PDO:
        //$db = Db::getInstance();
        //$req = $db->prepare('SELECT * FROM '.SYMPTOPTIONS_DBTABLE.' WHERE id_symptom = :id_symptom');
        // the query was prepared, now we replace :id_category with our actual $id_category value
        //$req->execute(array('id_symptom' => $id_symptom));
        //$sympcategory = $req->fetch();
        //return new SymptOptions_Model($sympcategory['id_category'], $sympcategory['cat_name'], $sympcategory['content']);
        //ADODB:
//print_r("Symptoms_Model::all");
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.SYMPTOPTIONS_DBTABLE.' WHERE id_symptom = '.$id_symptom.' ORDER BY id_order');
        foreach($req as $symptopt) {
            $list[] = new SymptOptions_Model($symptopt['id'], $symptopt['id_symptom'], $symptopt['opt_name'], $symptopt['id_order'], $symptopt['is_selected']);
        }
//var_dump($list);
        return $list;
    }
  }
?>