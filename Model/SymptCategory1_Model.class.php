<?php
require_once (dirname(__FILE__) ."/../../../../library/sql.inc");
  class SymptCategory1_Model {
    // we define 3 attributes
    // they are public so that we can access them using $sympcategory1->cat_name directly
	var $id_category;
	var $cat_name;
	var $cat_notes;

    public function __construct($id_category, $cat_name, $content) {
      $this->id_category      = $id_category;
      $this->cat_name  = $cat_name;
      $this->content = $content;
      //$this->_table = "pregnacy_cdssform_sympt_category";
    }

    public static function all() {
      $list = [];
      //$db = Db::getInstance();
      //$req = $db->query('SELECT * FROM pregnacy_cdssform_sympt_category');
      $db = get_db();
      $req = $db->Execute('SELECT * FROM pregnacy_cdssform_sympt_category');
print_r("SymptCategory1_Model::all");
//var_dump($req);
      // we create a list of SymptCategory1_Model objects from the database results
      //foreach($req->fetchAll() as $sympcategory1) {
      foreach($req as $sympcategory1) {
        $list[] = new SymptCategory1_Model($sympcategory1['id_category'], $sympcategory1['cat_name'], $sympcategory1['content']);
      }
var_dump($list);
      return $list;
    }

    public static function find($id_category) {
      //$db = Db::getInstance();
      $db = get_db();
      // we make sure $id_category is an integer
      $id_category = intval($id_category);
      $req = $db->prepare('SELECT * FROM pregnacy_cdssform_sympt_category WHERE id_category = :id_category');
      // the query was prepared, now we replace :id_category with our actual $id_category value
      $req->execute(array('id_category' => $id_category));
      $sympcategory1 = $req->fetch();

      return new SymptCategory1_Model($sympcategory1['id_category'], $sympcategory1['cat_name'], $sympcategory1['content']);
    }
  }
?>