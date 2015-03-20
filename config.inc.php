<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 22.02.15
 * Time: 11:31
 */
//define path
define ('DS', DIRECTORY_SEPARATOR);
define ('HOME', dirname(__FILE__));

define('VIEW_DIR', HOME . DS.'View'.DS);
define('MODEL_DIR', HOME . DS.'Model'.DS);

//define form general
define("FORM_NAME", "Pregnacy CDSS (test) Form");
define("FORM_FOLDER", "pregnacy_cdss");

//define database table names
define("SYMPTCATEGORY_DBTABLE", "form_pregnacycdss_sympt_category");
define("SYMPTOMS_DBTABLE", "form_pregnacycdss_symptoms");
define("SYMPTOPTIONS_DBTABLE", "form_pregnacycdss_sympt_options");
define("SYMPTBYPATIENT_DBTABLE", "form_pregnacycdss_symptopt_by_patient");
define("PATIENTEXAM_DBTABLE", "form_pregnacycdss_patient_exam");

define("DECEASESSYMPTOMOPTIONS_DBTABLE", "form_pregnacycdss_deceases_sympt_opt");
define("DECEASES_DBTABLE", "form_pregnacycdss_deceaces");

define("FIRSTPREGNACYTXT","Перша");
define("NEXTPREGNACYTXT","Повторна");

define("UNDEFINED","Не вказано!");
//print_r('<br>DB connect througt ADOdb_Active_Record');
//establish persistent database connection
include_once("$srcdir/adodb/adodb-active-record.inc.php");
$form_db = get_db();
ADOdb_Active_Record::SetDatabaseAdapter($form_db);

ADODB_Active_Record::$_changeNames = FALSE;//??????? but required