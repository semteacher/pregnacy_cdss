<?php

require_once ($GLOBALS['fileroot'] . "/library/classes/Controller.class.php");
require_once ($GLOBALS['fileroot'] . "/library/forms.inc");
//require_once("SymptByPatient_Model.class.php");
require_once("/../Model/SymptByPatient_Model.class.php");

class SymptByPatient_Form_Controller extends Controller {

	var $template_dir;
	
    function SymptByPatient_Form_Controller($template_mod = "SymptByPatient_Form") {
    	parent::Controller();
    	$this->template_mod = $template_mod;
        //var_dump($template_mod);
    	//$this->template_dir = dirname(__FILE__) . "/../View/";
        $this->template_dir = VIEW_DIR;
    	$this->assign("FORM_ACTION", $GLOBALS['web_root']);
    	$this->assign("DONT_SAVE_LINK", $GLOBALS['form_exit_url']);
    	$this->assign("STYLE", $GLOBALS['style']);
    }
    
    function default_action() {
    	$SymptByPatient = new SymptByPatient_Model();
        var_dump($this->template_dir);        
    	$this->assign("SymptByPatient",$SymptByPatient);
    	$this->assign("checks",$SymptByPatient->_form_layout());
		//return $this->fetch($this->template_dir . $this->template_mod . "_new.html");
        return $this->fetch($this->template_dir . $this->template_mod. ".html");
	}
	
	function view_action($form_id) {
		if (is_numeric($form_id)) {
    		$SymptByPatient = new SymptByPatient_Model($form_id);
    	}
    	else {
    		$SymptByPatient = new SymptByPatient_Model();
    	}
    	
    	$this->assign("SymptByPatient",$SymptByPatient);
    	$this->assign("checks",$SymptByPatient->_form_layout());
    	$this->assign("VIEW",true);
		//return $this->fetch($this->template_dir . $this->template_mod . "_new.html");
        return $this->fetch($this->template_dir . $this->template_mod. ".html");

	}
	
	function default_action_process() {
		if ($_POST['process'] != "true")
			return;
		$this->SymptByPatient = new SymptByPatient_Model($_POST['id']);
		parent::populate_object($this->SymptByPatient);
		
		$this->SymptByPatient->persist();
		if ($GLOBALS['encounter'] == "") {
			$GLOBALS['encounter'] = date("Ymd");
		}
		addForm($GLOBALS['encounter'], "Head Pain TJE", $this->SymptByPatient->id, "hp_tje_primary", $GLOBALS['pid'], $_SESSION['userauthorized']);
		$_POST['process'] = "";
		return;
	}
    
}



?>