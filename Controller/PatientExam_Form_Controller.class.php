<?php

require_once ($GLOBALS['fileroot'] . "/library/forms.inc");

require_once(MODEL_DIR."SymptByPatient_Model.class.php");
require_once(MODEL_DIR."SymptCategory_Model.class.php");
require_once(MODEL_DIR."Symptoms_Model.class.php");
require_once(MODEL_DIR."SymptOptions_Model.class.php");
require_once(MODEL_DIR."DeceasesSymptOpt_Model.class.php");

require_once(MODEL_DIR."Symptoms2Patients_Model.class.php");

require_once(VIEW_DIR."SymptByPatient_Form2Report.class.php");

//main controller class
class PatientExam_Form_Controller {

    public $form_folder;
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
        $this->form_name = "Pregnacy CDSS (default) Form";
        //get all form options (nested mode)
        $SymptCategory = SymptCategory_Model::all();
        //display form
        require_once(VIEW_DIR.'SymptByPatient_Form.html');
        return;
	}

    public function new_action() {
        //check gender
        $gender = getPatientData($_SESSION['pid'], 'sex');
        if ($gender[sex]=='Female'){
            $this->form_name = "Pregnacy CDSS (new) Form";
            $this->form_mode = "new";
            //get all form options (nested mode)
            $SymptCategory = SymptCategory_Model::all();
            //display form
            require_once(VIEW_DIR.'SymptByPatient_Form.html');
        } else{
            //error message
            echo '<script language="javascript">alert("Дана форма не може бути застосована до осіб чоловічої статі!")</script>';
            //redirect to encounter
            @formJump();
        }
        return;
    }

	public function view_action($form_idexam) {
        //var_dump($form_id);
		if (is_numeric($form_idexam)) {
            //$this->form_id = $form_idexam;
            $this->form_idexam = $form_idexam;
           // $this->form_pid = $_SESSION['pid'];
    	}
    	else {
    		//error??
    	}
        $this->form_name = "Pregnacy CDSS (view) Form";
        $this->form_mode = "update";
        //get all form options (nested mode)
    	$SymptCategory = SymptCategory_Model::all();
        //display form
        require_once(VIEW_DIR.'SymptByPatient_Form.html');
        return;

	}

    public function report_action($form_idexam) {
        //show form report on the encounter page
        if (is_numeric($form_idexam)) {
            $this->form_idexam = $form_idexam;
        }
        else {
            //error??
        }
        //fetch form data
        $form_data = formFetch($this->table_name, $form_idexam);
        $curr_deceases_multi = array();
        $curr_deceases_multi = unserialize($form_data[deceases]);
        //set deceases names
        $deceases = new Deceases2_Model();
        foreach ($curr_deceases_multi as $decease_id=>$dec_symmary) {
            if ($deceases->Load('id='.$decease_id)){
                $dec_symmary[dec_name] = $deceases->dec_name;
                $curr_deceases_multi[$decease_id][dec_name] = $deceases->dec_name;
            } else {
                $dec_symmary[dec_name] = "Інший діагноз";
                $curr_deceases_multi[$decease_id][dec_name] = "Інший діагноз";
            }
        }
        //display form
        if ($form_data) {
            //require(VIEW_DIR.'SymptByPatient_FormReport.php');
            $report_form = new SymptByPatient_Form2Report($form_data, $curr_deceases_multi);
        }
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
        $curr_decease_multi = array();
        $decease = new Deceases2_Model();
        $deceases_arr = $decease->Find('');

        foreach ($deceases_arr as $dec){
            //default - each decease probability =1
            $curr_decease_multi[$dec->id][py]=1;
            $curr_decease_multi[$dec->id][pn]=1;
            $curr_decease_multi[$dec->id][count]=0;
        }

        var_dump($deceases_arr);
        var_dump($curr_decease_multi);

        //process form submissions
        $deceasesymptopt = new DeceasesSymptOpt2_Model();
        foreach ($_POST['symptom_options'] as $sympt_id=>$sympt_options) {
            foreach ($sympt_options as $key=>$id_sympt_opt) {
                if ($deceasesymptopt->Load('id_sympt_opt='.$id_sympt_opt))
                {
                    $curr_decease_multi[$deceasesymptopt->id_deceaces][py]=$curr_decease_multi[$deceasesymptopt->id_deceaces][py]*$deceasesymptopt->py;
                    $curr_decease_multi[$deceasesymptopt->id_deceaces][pn]=$curr_decease_multi[$deceasesymptopt->id_deceaces][pn]*$deceasesymptopt->pn;
                    $curr_decease_multi[$deceasesymptopt->id_deceaces][count]=$curr_decease_multi[$deceasesymptopt->id_deceaces][count]+1;
                }
            }
        }

        print_r('<br>each decease probability after processing:');
        var_dump($curr_decease_multi);
        $ser_curr_decease_multi=serialize($curr_decease_multi);
        var_dump($ser_curr_decease_multi);

        //save new/update patient form data
        if ($_GET["mode"] == "new") {

            /* NOTE - for customization you can replace $_POST with your own array
             * of key=>value pairs where 'key' is the table field name and
             * 'value' is whatever it should be set to
             * ex)   $newrecord['parent_sig'] = $_POST['sig'];
             *       $newid = formSubmit($table_name, $newrecord, $_GET["id"], $userauthorized);
             */

            /* save the data into the form's own table */
            //TODO: replace array(2,$curr_decease[2]) with highest value!!!!
            $newid = formSubmit($this->table_name, array('createuser'=>$_SESSION['authUser'], 'createdate'=>date("Y-m-d H:i:s"),'deceases'=>$ser_curr_decease_multi), $_GET["id"], $this->form_userauthorized);
            print_r('<br>form new id:');
            var_dump($newid);
            $this->form_idexam = $newid;
            /* link the form to the encounter in the 'forms' table */
            addForm($this->form_encounter, $this->form_name, $newid, $this->form_folder, $this->form_pid, $this->form_userauthorized);
        }
        elseif ($_GET["mode"] == "update") {
            /* update existing record */
            $success = formUpdate($this->table_name, array('deceases'=>$ser_curr_decease_multi), $_GET["id"], $this->form_userauthorized);
        }

        print_r('<br>form data:');
        var_dump($this->form_idexam);
        var_dump($_GET["id"]);
        var_dump($this->form_pid);
        //var_dump($this->symptbypatient);
        var_dump(unserialize($ser_curr_decease_multi));
//die;
        print_r('<br>load and process all symptoms:');
        //save new/update patient details
        $Symptoms = Symptoms_Model::all();
        //process all symptoms:
        foreach ($Symptoms as $key=>$Symptom) {
            print_r('<br>Is it this symptom in POST?:');
            //check is it symptom selected is?
            if (array_key_exists($Symptom->id,$_POST['symptom_options'])){
                //Symptom is selected!
                //check symptom type:
                if (Symptoms_Model::is_multy($Symptom->id)) {
                    //Symptom can have multiple options
                    print_r('<br>multi-YES');
                    foreach ($Symptom->symptoptions as $optkey=>$SympOption) {
                        //is it symptom option in POST?
                        $key = array_search($SympOption->id,$_POST['symptom_options'][$Symptom->id]);
                        var_dump($key);
                        //is it symptom option in database?
                        if (SymptByPatient_Model::isselected($this->form_idexam, $this->form_pid, $Symptom->id, $SympOption->id)) {
                            if ($key === false){
                                //symptom option is in database but not in POST:it is unchecked and will be deleted
                                print_r($SympOption->opt_name.' will be deleted<br>');
                                $symptoptbyperson = new SymptByPatient2_Model();//prepare tmp record
                                $symptoptbyperson->Load('(id_exam='.$this->form_idexam.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')AND(id_sympt_opt='.$SympOption->id.')');
                                $symptoptbyperson->delete();
                            }

                        } else {
                            if ($key !== false) {
                                print_r($SympOption->opt_name.' will be added<br>');
                                var_dump($_POST['symptom_options'][$Symptom->id][$key]);
                                //Insert one new record
                                $symptoptbyperson = new SymptByPatient2_Model();
                                $symptoptbyperson->id_exam = $this->form_idexam;
                                $symptoptbyperson->pid  = $this->form_pid;
                                $symptoptbyperson->user = $_SESSION['authUser'];
                                $symptoptbyperson->id_symptom = $Symptom->id;
                                $symptoptbyperson->id_sympt_cat = $Symptom->id_category;
                                $symptoptbyperson->id_order = $Symptom->id_order;
                                $symptoptbyperson->id_sympt_opt = $_POST['symptom_options'][$Symptom->id][$key];

                                $deceasesymptopt->Load('id_sympt_opt='.$symptoptbyperson->id_sympt_opt);
                                $symptoptbyperson->id_deceases = $deceasesymptopt->id_deceaces;
                                $symptoptbyperson->py = $deceasesymptopt->py;
                                $symptoptbyperson->pn = $deceasesymptopt->pn;

                                $symptoptbyperson->save();
                            }
                        }
                    }
                } else {
                    //Symptom can have only single option
                    print_r('<br>multi-NO');
                    //Is this symptom in database?
                    //get record count
                    //$currSelectedOptionsCount = SymptByPatient_Model::selectedOptionsCount($this->form_id, $this->form_pid, $Symptom->id);
                    $symptoptbyperson = new SymptByPatient2_Model();//prepare tmp record
                    $currSelectedOptionsCount = $symptoptbyperson->Find('(id_exam=?)AND(pid=?)AND(id_symptom=?)',array($this->form_idexam, $this->form_pid, $Symptom->id));
                    //print_r('<br>found records:'.$currSelectedOptionsCount);
                    print_r('<br>found records:'.sizeof($currSelectedOptionsCount));
                    if (sizeof($currSelectedOptionsCount) ==1) {
                        //Update single record
                        print_r('<br>Update single record:');
                        $symptoptbyperson = new SymptByPatient2_Model();
                        $symptoptbyperson->Load('(id_exam='.$this->form_idexam.')AND(pid='.$this->form_pid.')AND(id_symptom='.$Symptom->id.')');
                       // var_dump($symptoptbyperson);
                        if ($symptoptbyperson->id_sympt_opt != intval($_POST['symptom_options'][$Symptom->id][0])){
                            $symptoptbyperson->id_sympt_opt = $_POST['symptom_options'][$Symptom->id][0];
                            //load decease info
                            if ($deceasesymptopt->Load('id_sympt_opt='.$symptoptbyperson->id_sympt_opt)){
                                $symptoptbyperson->id_deceases = $deceasesymptopt->id_deceaces;
                                $symptoptbyperson->py = $deceasesymptopt->py;
                                $symptoptbyperson->pn = $deceasesymptopt->pn;
                            }
                            $symptoptbyperson->save();
                        }

                    } elseif (sizeof($currSelectedOptionsCount) >1) {
                        //delete all and insert new one
                        foreach ($currSelectedOptionsCount as $tmpsymptoptbyperson) {
                            $tmpsymptoptbyperson->delete();
                        }
                        //Insert one new record
                        $symptoptbyperson = new SymptByPatient2_Model();
                        $symptoptbyperson->id_exam = $this->form_idexam;
                        $symptoptbyperson->pid  = $this->form_pid;
                        $symptoptbyperson->user = $_SESSION['authUser'];
                        $symptoptbyperson->id_symptom = $Symptom->id;
                        $symptoptbyperson->id_sympt_cat = $Symptom->id_category;
                        $symptoptbyperson->id_order = $Symptom->id_order;
                        $symptoptbyperson->id_sympt_opt = $_POST['symptom_options'][$Symptom->id][0];
                        //load decease info
                        if ($deceasesymptopt->Load('id_sympt_opt='.$symptoptbyperson->id_sympt_opt)){
                            $symptoptbyperson->id_deceases = $deceasesymptopt->id_deceaces;
                            $symptoptbyperson->py = $deceasesymptopt->py;
                            $symptoptbyperson->pn = $deceasesymptopt->pn;
                        }
                        $symptoptbyperson->save();
                        //print_r($opt_name.' will be skipped<br>');
                    } else {
                        //Insert one new record
                        $symptoptbyperson = new SymptByPatient2_Model();
                        $symptoptbyperson->id_exam = $this->form_idexam;
                        $symptoptbyperson->pid  = $this->form_pid;
                        $symptoptbyperson->user = $_SESSION['authUser'];
                        $symptoptbyperson->id_symptom = $Symptom->id;
                        $symptoptbyperson->id_sympt_cat = $Symptom->id_category;
                        $symptoptbyperson->id_order = $Symptom->id_order;
                        $symptoptbyperson->id_sympt_opt = $_POST['symptom_options'][$Symptom->id][0];

                        //load decease info
                        if ($deceasesymptopt->Load('id_sympt_opt='.$symptoptbyperson->id_sympt_opt)){
                            $symptoptbyperson->id_deceases = $deceasesymptopt->id_deceaces;
                            $symptoptbyperson->py = $deceasesymptopt->py;
                            $symptoptbyperson->pn = $deceasesymptopt->pn;
                        }
                        $symptoptbyperson->save();
                    }
                }
            } else {
                foreach ($Symptom->symptoptions as $optkey=>$SympOption) {
                //TODO:remove symptom from patient table in DB??
                }
            }
        }
die;

		$_POST['process'] = "";
		return;
	}
    
}

?>