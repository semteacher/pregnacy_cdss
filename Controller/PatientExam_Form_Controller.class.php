<?php

//require_once ($GLOBALS['fileroot'] . "/library/classes/Controller.class.php");
require_once ($GLOBALS['fileroot'] . "/library/forms.inc");

//require_once("/../config.inc.php");


require_once(MODEL_DIR."SymptByPatient_Model.class.php");
//require_once(MODEL_DIR."SymptByPatient2_Model.class.php");
require_once(MODEL_DIR."SymptCategory_Model.class.php");
require_once(MODEL_DIR."Symptoms_Model.class.php");
require_once(MODEL_DIR."SymptOptions_Model.class.php");

require_once(MODEL_DIR."Symptoms2Patients_Model.class.php");

/** CHANGE THIS name to the name of your form **/
//$form_name = "Pregnacy CDSS (test) Form1";

/** CHANGE THIS to match the folder you created for this form **/
//$form_folder = "pregnacy_cdss";

//formHeader("Form: ".$form_name);
//$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';

class PatientExam_Form_Controller {

	//public $template_dir;
    //public $template_mod;
    public $form_folder;
    public $form_name;
    //public $form_id;
    public $form_idexam;
    public $form_pid;
    public $returnurl;
    public $form_mode;
    public $table_name;
    public $form_encounter;
    public $form_userauthorized;

    public $symptbypatient;

    function PatientExam_Form_Controller() {
        $this->form_folder = FORM_FOLDER;
        $this->form_name = FORM_NAME;
        $this->table_name = PATIENTEXAM_DBTABLE;
        $this->form_encounter = $_SESSION['encounter'];
        $this->form_pid = $_SESSION['pid'];
        $this->form_userauthorized = $_SESSION['userauthorized'];
        $this->returnurl =$GLOBALS['form_exit_url'];
        //formHeader("Form: ".$this->form_name);//?????
        //$this->returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
    }
    
    public function default_action() {
        $SymptCategory = SymptCategory_Model::all();
        $this->form_name = "Pregnacy CDSS (default) Form";

        require_once(VIEW_DIR.'SymptByPatient_Form.html');
        return;
	}

    public function new_action() {
        $SymptCategory = SymptCategory_Model::all();
        $this->form_name = "Pregnacy CDSS (new) Form";
        $this->form_mode = "new";

        require_once(VIEW_DIR.'SymptByPatient_Form.html');
        return;
    }

	public function view_action($form_idexam) {
        //var_dump($form_id);
		if (is_numeric($form_idexam)) {
            //$this->form_id = $form_idexam;
            $this->form_idexam = $form_idexam;
            $this->form_pid = $_SESSION['pid'];
            //get paient form data
            //$SymptByPatient = SymptByPatient_Model::find($form_id);
            //$this->symptbypatient=$SymptByPatient;
    	}
    	else {
    		//error
            //$SymptCategory = SymptByPatient_Model::all();
    	}
        $this->form_name = "Pregnacy CDSS (view) Form";
        $this->form_mode = "update";
        //get all form options (nested mode)
    	$SymptCategory = SymptCategory_Model::all();

        //display form
        require_once(VIEW_DIR.'SymptByPatient_Form.html');
        return;

	}
	
	public function default_action_process() {
        //var_dump($GLOBALS);
        var_dump($_POST);

		if ($_POST['process'] != "true"){
            return;
        }

        $this->form_idexam = $_POST['id'];
        if ($_POST['pid']) {$this->form_pid = $_POST['pid'];}else{$this->form_pid = $_SESSION['pid'];}
        $this->form_encounter = $_SESSION['encounter'];
        $this->form_userauthorized = $_SESSION['userauthorized'];

        //prepare default deceases array
        $curr_decease = array();
        $decease = new Deceases2_Model();
        $deceases_arr = $decease->Find('');
        foreach ($deceases_arr as $dec){
            $curr_decease[$dec->id]=1; ///default - each decease probability =1
        }

        print_r('<br>default - each decease probability =1:');
        var_dump($curr_decease);

        //process form submissions
        $deceasesymptopt = new DeceasesSymptOpt2_Model();
        foreach ($_POST['symptom_options'] as $sympt_id=>$sympt_options) {
            foreach ($sympt_options as $key=>$id_sympt_opt) {
                $deceasesymptopt->Load('id_sympt_opt='.$id_sympt_opt);
                $curr_decease[$deceasesymptopt->id_deceaces]=$curr_decease[$deceasesymptopt->id_deceaces]*$deceasesymptopt->py;
            }
        }

        print_r('<br>each decease probability after processing:');
        var_dump($curr_decease);

        //if ($encounter == "") $encounter = date("Ymd");
        if ($_GET["mode"] == "new") {

            /* NOTE - for customization you can replace $_POST with your own array
             * of key=>value pairs where 'key' is the table field name and
             * 'value' is whatever it should be set to
             * ex)   $newrecord['parent_sig'] = $_POST['sig'];
             *       $newid = formSubmit($table_name, $newrecord, $_GET["id"], $userauthorized);
             */

            /* save the data into the form's own table */
            //TODO: replace array(2,$curr_decease[2]) with highest value!!!!
            $newid = formSubmit($this->table_name, array('id_deceases'=>2,'p'=>$curr_decease[2]), $_GET["id"], $this->form_userauthorized);
            print_r('<br>form new id:');
            var_dump($newid);
            $this->form_idexam = $newid;
            /* link the form to the encounter in the 'forms' table */
            addForm($this->form_encounter, $this->form_name, $newid, $this->form_folder, $this->form_pid, $this->form_userauthorized);
        }
        elseif ($_GET["mode"] == "update") {
            /* update existing record */
            $success = formUpdate($this->table_name, array('id_deceases'=>2,'p'=>$curr_decease[2]), $_GET["id"], $this->form_userauthorized);
        }

        //  $this->SymptByPatient = new SymptByPatient_Model($_POST['id']);
        //  parent::populate_object($this->SymptByPatient);


       // print_r('<br>DB conncct througt ADOdb_Active_Record');
       // $db = get_db();
       // ADOdb_Active_Record::SetDatabaseAdapter($db);
        print_r('<br>form data:');
        var_dump($this->form_idexam);
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
                        if (!SymptByPatient_Model::isselected($this->form_idexam, $this->form_pid, $Symptom->id, $SympOption->id)) {
                            //print_r($opt_name.' will be added/updated<br>');

                        } else {
                            //print_r($opt_name.' will be skipped<br>');
                        }

                    }
                } else {
                    //Symptom can have only single option
                    print_r('<br>multi-NO');
                    //Is this symptom in database?
                    //get record count
                    //$currSelectedOptionsCount = SymptByPatient_Model::selectedOptionsCount($this->form_id, $this->form_pid, $Symptom->id);
                    $symptoptbyperson = new SymptByPatient2_Model();
                    $currSelectedOptionsCount = $symptoptbyperson->Find('(id_exam=?)AND(pid=?)AND(id_symptom=?)',array($this->form_idexam, $this->form_pid, $Symptom->id));
                    //print_r('<br>found records:'.$currSelectedOptionsCount);
                    print_r('<br>found records:'.sizeof($currSelectedOptionsCount));
                    if (sizeof($currSelectedOptionsCount) ==1) {
                        //Update single record
                        print_r('<br>Update single record:');
                        //$symptoptbyperson = new SymptByPatient2_Model();
                        $symptoptbyperson->Load('(id_exam='.$this->form_idexam.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')');
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
                        //$symptoptbyperson->form_id   = $this->form_id;
                        $symptoptbyperson->id_exam = $this->form_idexam;
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
                        //$symptoptbyperson->form_id   = $this->form_id;
                        $symptoptbyperson->id_exam = $this->form_idexam;
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
		//if ($GLOBALS['encounter'] == "") {
		//	$GLOBALS['encounter'] = date("Ymd");
		//}
		///addForm($GLOBALS['encounter'], $this->form_name, $_POST['id'], $this->form_folder, $GLOBALS['pid'], $_SESSION['userauthorized']);
		$_POST['process'] = "";
		return;
	}
    
}



?>