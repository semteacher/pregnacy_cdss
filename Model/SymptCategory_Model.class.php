<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");



  class SymptCategory_Model {
    // we define attributes
    // they are public so that we can access them using $sympcategory->cat_name directly
	var $id_category;
	var $cat_name;
	var $cat_notes;
    var $is_selected;
    var $symptoms;


    public function __construct($id, $cat_name, $cat_notes, $is_selected) {
        $this->id  = $id;
        $this->cat_name  = $cat_name;
        $this->cat_notes = $cat_notes;
        $this->is_selected = $is_selected;
        $this->symptoms = Symptoms_Model::find($id);
    }

    public static function all() {
        $list = [];
        //PDO:
        //$db = Db::getInstance();
        //$req = $db->query('SELECT * FROM '.SYMPTCATEGORY_DBTABLE);
        
        //ADODB:
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.SYMPTCATEGORY_DBTABLE);
//print_r("SymptCategory_Model::all");
//var_dump($req);
        // we create a list of SymptCategory_Model objects from the database results
        //PDO:
        //foreach($req->fetchAll() as $sympcategory) {
        //ADODB:
        foreach($req as $sympcategory) {
            $list[] = new SymptCategory_Model($sympcategory['id'], $sympcategory['cat_name'], $sympcategory['cat_notes'], $sympcategory['is_selected']);
        }
//var_dump($list);
        return $list;
    }

    public static function find($id) {
        $list = [];
        // we make sure $id_category is an integer
        $id_category = intval($id_category);
        //PDO:
        //$db = Db::getInstance();
        //$req = $db->prepare('SELECT * FROM '.SYMPTCATEGORY_DBTABLE.' WHERE id_category = :id_category');
        // the query was prepared, now we replace :id_category with our actual $id_category value
        //$req->execute(array('id_category' => $id_category));
        //$sympcategory = $req->fetch();
        //return new SymptCategory_Model($sympcategory['id_category'], $sympcategory['cat_name'], $sympcategory['content']);
        //ADODB:
        $db = get_db();
        $req = $db->Execute('SELECT * FROM '.SYMPTCATEGORY_DBTABLE.' WHERE id = '.$id);
        foreach($req as $sympcategory) {
            $list[] = new SymptCategory_Model($sympcategory['id'], $sympcategory['cat_name'], $sympcategory['cat_notes'], $sympcategory['is_selected']);
        }
//var_dump($list);
        return $list;
    }
  }
?>