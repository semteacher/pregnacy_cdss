<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 08.03.15
 * Time: 19:59
 */
class form_pregnacycdss_sympt_category extends ADOdb_Active_Record{}
ADODB_Active_Record::ClassHasMany('form_pregnacycdss_sympt_category', 'form_pregnacycdss_symptoms','id_category');


?>