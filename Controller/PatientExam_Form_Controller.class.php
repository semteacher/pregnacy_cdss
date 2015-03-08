<?php

//require_once ($GLOBALS['fileroot'] . "/library/classes/Controller.class.php");
require_once ($GLOBALS['fileroot'] . "/library/forms.inc");

//require_once("/../config.inc.php");


require_once(MODEL_DIR."SymptByPatient_Model.class.php");
require_once(MODEL_DIR."SymptByPatient2_Model.class.php");
require_once(MODEL_DIR."SymptCategory_Model.class.php");
//require_once(MODEL_DIR."SymptCategory2_Model.class.php");
require_once(MODEL_DIR."Symptoms_Model.class.php");
//require_once(MODEL_DIR."Symptoms2_Model.class.php");
require_once(MODEL_DIR."SymptOptions_Model.class.php");
require_once(MODEL_DIR."SymptomsTree_Model.class.php");
//require_once(MODEL_DIR."SymptTree.php");
//define("VIEW_DIR", dirname(__FILE__) . "\..\View\\");
/** CHANGE THIS name to the name of your form **/
//$form_name = "Pregnacy CDSS (test) Form1";

/** CHANGE THIS to match the folder you created for this form **/
//$form_folder = "pregnacy_cdss";

//formHeader("Form: ".$form_name);
//$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';

class PatientExam_Form_Controller {

	public $template_dir;
    public $template_mod;
    public $form_folder;
    public $form_name;
    public $form_id;
    public $form_pid;
    public $returnurl;

    public $symptbypatient;

    function PatientExam_Form_Controller() {
    	//parent::Controller();
        $this->form_folder = "pregnacy_cdss";
        $this->form_name = "Pregnacy CDSS (test) Form";
        $this->returnurl =$GLOBALS['form_exit_url'];
        formHeader("Form: ".$this->form_name);//?????
        //$this->returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';

    	//$this->template_mod = $template_mod;
        //var_dump($template_mod);
    	//$this->template_dir = dirname(__FILE__) . "/../View/";
        //$this->template_dir = VIEW_DIR;
    	//$this->assign("FORM_ACTION", $GLOBALS['web_root']);
    	//$this->assign("DONT_SAVE_LINK", $GLOBALS['form_exit_url']);
    	//$this->assign("STYLE", $GLOBALS['style']);
    }
    
    public function default_action() {
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
            $this->form_id = $form_id;
            $this->form_pid = $GLOBALS['pid'];
            //get paient form data
            $SymptByPatient = SymptByPatient_Model::find($form_id);
            $this->symptbypatient=$SymptByPatient;
    	}
    	else {
    		//error
            //$SymptCategory = SymptByPatient_Model::all();
    	}
        $this->form_name = "Pregnacy CDSS (view) Form";
        //get all form options (nested mode)
    	$SymptCategory = SymptCategory_Model::all();

        //$SymptCategory2 = new SymptCategory2_Model();
        //$symptcat2arr = $SymptCategory2->Find("");
        //var_dump($symptcat2arr);

        $SymptCategory3 = new SymptCategory2_Model();
        ////$SymptCategory3->HasMany(SYMPTOMS_DBTABLE,'id_category');
        $SymptCategory3->Load("id=1");
        var_dump($SymptCategory3->cat_name);
        //var_dump($SymptCategory3);
        //var_dump($SymptCategory3->form_pregnacycdss_symptoms);

        //$SymptCategory4 = new form_pregnacycdss_sympt_category();
        //$SymptCategory4->Load("id=1");
        //var_dump($SymptCategory4->cat_name);
        //var_dump($SymptCategory4);
        //var_dump($SymptCategory3->SYMPTOMS_DBTABLE);
        //$Symptoms3 = new Symptoms2_Model();
        //$Symptoms3->Load("id=1");
        //var_dump($Symptoms3);
    //print_r('back to controller ...');
    //var_dump($SymptCategory);
    	//$this->assign("SymptByPatient",$SymptByPatient);
    	//$this->assign("checks",$SymptByPatient->_form_layout());
    	//$this->assign("VIEW",true);
		//return $this->fetch($this->template_dir . $this->template_mod . "_new.html");
        //return $this->fetch($this->template_dir . $this->template_mod. ".html");
        //display form
        require_once(VIEW_DIR.'SymptByPatient_Form.html');
        return;//???

	}
	
	public function default_action_process() {
        var_dump($_POST['process']);
        //var_dump($_SESSION);
        var_dump($_POST['symptom_options']);
		if ($_POST['process'] != "true"){
            return;
        }

        //  $this->SymptByPatient = new SymptByPatient_Model($_POST['id']);
        //  parent::populate_object($this->SymptByPatient);

        $this->form_id = $_POST['id'];
        $this->form_pid = $_POST['pid'];
       // print_r('<br>DB conncct througt ADOdb_Active_Record');
       // $db = get_db();
       // ADOdb_Active_Record::SetDatabaseAdapter($db);
        print_r('<br>form data:');
        var_dump($this->form_id);
        var_dump($_GET["id"]);
        var_dump($this->form_pid);
        //var_dump($this->symptbypatient);

        print_r('<br>load and process all symptoms:');
        $Symptoms = Symptoms_Model::all();
        //process all symptoms:
        foreach ($Symptoms as $key=>$Symptom) {
            print_r('<br>Is it this symptom in POST?:');
            if (array_key_exists($Symptom->id,$_POST['symptom_options'])){
                //Symptom is selected!
                if (Symptoms_Model::is_multy($Symptom->id)) {
                    //Symptom can have multiple options
                    print_r('<br>multi-YES');
                    foreach ($Symptom->symptoptions as $optkey=>$SympOption) {
                        if (!SymptByPatient_Model::isselected($this->form_id, $this->form_pid, $Symptom->id, $SympOption->id)) {
                            //print_r($opt_name.' will be added/updated<br>');

                        } else {
                            //print_r($opt_name.' will be skipped<br>');
                        }

                    }
                } else {
                    //Symptom can have only single option
                    print_r('<br>multi-NO');
                    //Create new SymptByPatient_Model object instance
                    /////$SymptByPatient = new SymptByPatient_Model($_POST['id']);
                    //Is this symptom in database?
                    //get record count
                    //$currSelectedOptionsCount = SymptByPatient_Model::selectedOptionsCount($this->form_id, $this->form_pid, $Symptom->id);
                    $symptoptbyperson = new SymptByPatient2_Model();
                    $currSelectedOptionsCount = $symptoptbyperson->Find('(form_id=?)AND(pid=?)AND(id_symptom=?)',array($this->form_id, $this->form_pid, $Symptom->id));
                    //print_r('<br>found records:'.$currSelectedOptionsCount);
                    print_r('<br>found records:'.sizeof($currSelectedOptionsCount));
                    if (sizeof($currSelectedOptionsCount) ==1) {
                        //Update single record
                        print_r('<br>Update single record:');
                        //$symptoptbyperson = new SymptByPatient2_Model();
                        $symptoptbyperson->Load('(form_id='.$this->form_id.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')');
                       // var_dump($symptoptbyperson);
                        if ($symptoptbyperson->id_sympt_opt != intval($_POST['symptom_options'][$Symptom->id][0])){
                            $symptoptbyperson->id_sympt_opt = $_POST['symptom_options'][$Symptom->id][0];
                            $symptoptbyperson->save();
                        }

                    } elseif (sizeof($currSelectedOptionsCount) >1) {
                        //TODO: delete all and insert new one
                        foreach ($currSelectedOptionsCount as $tmpsymptoptbyperson) {
                            $tmpsymptoptbyperson->delete();
                        }
                        //Insert one new record
                        //$symptoptbyperson = new SymptByPatient2_Model();//?????????????
                        $symptoptbyperson->form_id   = $this->form_id;
                        $symptoptbyperson->pid  = $this->form_pid;
                        $symptoptbyperson->user = $_SESSION['authUser'];
                        $symptoptbyperson->id_symptom = $Symptom->id;
                        $symptoptbyperson->id_sympt_cat = $Symptom->id_category;
                        $symptoptbyperson->id_order = $Symptom->id_order;
                        $symptoptbyperson->id_sympt_opt = $_POST['symptom_options'][$Symptom->id][0];

                        //$symptoptbyperson->id_deceases = $id_deceases;
                        // $symptoptbyperson->p_val = $p_val;
                        $symptoptbyperson->save();
                        //print_r($opt_name.' will be skipped<br>');
                    } else {
                        //Insert one new record
                        //$symptoptbyperson = new SymptByPatient2_Model();
                        $symptoptbyperson->form_id   = $this->form_id;
                        $symptoptbyperson->pid  = $this->form_pid;
                        $symptoptbyperson->user = $_SESSION['authUser'];
                        $symptoptbyperson->id_symptom = $Symptom->id;
                        $symptoptbyperson->id_sympt_cat = $Symptom->id_category;
                        $symptoptbyperson->id_order = $Symptom->id_order;
                        $symptoptbyperson->id_sympt_opt = $_POST['symptom_options'][$Symptom->id][0];

                        //$symptoptbyperson->id_deceases = $id_deceases;
                       // $symptoptbyperson->p_val = $p_val;
                        $symptoptbyperson->save();
                    }

                    // if (SymptByPatient_Model:: getfirstbysympt($this->form_id, $this->form_pid, $symptid));


                }
            } else {
                foreach ($Symptom->symptoptions as $optkey=>$SympOption) {
                //TODO:remove symptom from patient table in DB??
                }
            }
        }
		$this->SymptByPatient = new SymptByPatient_Model($_POST['id']);
		parent::populate_object($this->SymptByPatient);
		
		//$this->SymptByPatient->persist();
		if ($GLOBALS['encounter'] == "") {
			$GLOBALS['encounter'] = date("Ymd");
		}
		///addForm($GLOBALS['encounter'], $this->form_name, $_POST['id'], $this->form_folder, $GLOBALS['pid'], $_SESSION['userauthorized']);
		$_POST['process'] = "";
		return;
	}
    
}



?>