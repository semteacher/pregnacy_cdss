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

//define database table names
define("SYMPTCATEGORY_DBTABLE", "pregnacy_cdssform_sympt_category");
define("SYMPTOMS_DBTABLE", "pregnacy_cdssform_symptoms");
define("SYMPTOPTIONS_DBTABLE", "pregnacy_cdssform_sympt_options");
define("SYMPTBYPATIENT_DBTABLE", "pregnacy_cdssform_symptoms_by_patient");




//print_r('<br>DB connect througt ADOdb_Active_Record');
//establish persistent database connection
include_once("$srcdir/adodb/adodb-active-record.inc.php");
$form_db = get_db();
ADOdb_Active_Record::SetDatabaseAdapter($form_db);

ADODB_Active_Record::$_changeNames = FALSE;//???????