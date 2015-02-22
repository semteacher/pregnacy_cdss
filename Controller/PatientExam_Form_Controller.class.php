<?php

//require_once ($GLOBALS['fileroot'] . "/library/classes/Controller.class.php");
require_once ($GLOBALS['fileroot'] . "/library/forms.inc");

//require_once("/../config.inc.php");

require_once("/../Model/SymptByPatient_Model.class.php");
require_once("/../Model/SymptCategory_Model.class.php");

//define("VIEW_DIR", dirname(__FILE__) . "\..\View\\");
/** CHANGE THIS name to the name of your form **/
//$form_name = "Pregnacy CDSS (test) Form1";

/** CHANGE THIS to match the folder you created for this form **/
//$form_folder = "pregnacy_cdss";

//formHeader("Form: ".$form_name);
//$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';

class PatientExam_Form_Controller {

	var $template_dir;
    var $template_mod;
    var $form_folder;
	var $form_name;
    var $returnurl;
    
    function PatientExam_Form_Controller() {
    	//parent::Controller();
        $this->form_folder = "pregnacy_cdss";
        $this->form_name = "Pregnacy CDSS (test) Form";
        
        formHeader("Form: ".$form_name);
        $this->returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
        
    	//$this->template_mod = $template_mod;
        //var_dump($template_mod);
    	//$this->template_dir = dirname(__FILE__) . "/../View/";
        //$this->template_dir = VIEW_DIR;
    	//$this->assign("FORM_ACTION", $GLOBALS['web_root']);
    	//$this->assign("DONT_SAVE_LINK", $GLOBALS['form_exit_url']);
    	//$this->assign("STYLE", $GLOBALS['style']);
    }
    
    public function default_action() {
    	//$SymptByPatient = new SymptByPatient_Model();
        $SymptCategory = SymptCategory_Model::all();
        $this->form_name = "Pregnacy CDSS (new) Form";
    //var_dump($this->template_dir);        
    	//$this->assign("SymptByPatient",$SymptByPatient1);
    	//$this->assign("checks",$SymptByPatient1->_form_layout());
		//return $this->fetch($this->template_dir . $this->template_mod . "_new.html");
        //return $this->fetch($this->template_dir . $this->template_mod. ".html");
        require_once(VIEW_DIR.'SymptByPatient_Form.html');
        return; //????
	}
	
	public function view_action($form_id) {
    //var_dump($form_id);
		if (is_numeric($form_id)) {
    		//$SymptByPatient = new SymptByPatient_Model($form_id);
            $SymptByPatient = SymptByPatient_Model::find($form_id);
    	}
    	else {
    		//error
            //$SymptCategory = SymptByPatient_Model::all();
    	}
        $this->form_name = "Pregnacy CDSS (view) Form";
        //get all form models (nested mode)
    	$SymptCategory = SymptCategory_Model::all();
    //print_r('back to controller ...');
    //var_dump($SymptCategory);
    	//$this->assign("SymptByPatient",$SymptByPatient);
    	//$this->assign("checks",$SymptByPatient->_form_layout());
    	//$this->assign("VIEW",true);
		//return $this->fetch($this->template_dir . $this->template_mod . "_new.html");
        //return $this->fetch($this->template_dir . $this->template_mod. ".html");
        require_once(VIEW_DIR.'SymptByPatient_Form.html');
        return;//???

	}
	
	public function default_action_process() {
		if ($_POST['process'] != "true")
			return;
		$this->SymptByPatient = new SymptByPatient_Model($_POST['id']);
		parent::populate_object($this->SymptByPatient);
		
		//$this->SymptByPatient->persist();
		if ($GLOBALS['encounter'] == "") {
			$GLOBALS['encounter'] = date("Ymd");
		}
		addForm($GLOBALS['encounter'], $this->form_name, $this->SymptByPatient->id, $this->form_folder, $GLOBALS['pid'], $_SESSION['userauthorized']);
		$_POST['process'] = "";
		return;
	}
    
}



?>