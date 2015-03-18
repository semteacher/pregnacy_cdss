<?php
include_once("../../globals.php");
include_once($GLOBALS["srcdir"]."/api.inc");
require_once ($GLOBALS["fileroot"] . "/library/forms.inc");
require_once ($GLOBALS["fileroot"] . "/library/translation.inc.php");
//var_dump(xl('Save Changes','e'));
//require_once(MODEL_DIR."SymptByPatient_Model.class.php");

class SymptByPatient_Form {
    public function __construct($PatientExam_Form, $SymptCategory)
    {
//        var_dump($GLOBALS["srcdir"]);
//        var_dump($GLOBALS["fileroot"]);
//        var_dump($GLOBALS["webroot"]);
//        var_dump($css_header);
//        var_dump($rootdir);

        echo '<!DOCTYPE html>';
        echo '<meta charset="UTF-8">';
        echo '<html>';
        echo '<head>';
        //<!-- supporting javascript code -->
        echo '<script type="text/javascript" src="/library/js/jquery-1.9.1.min.js"></script>';
        echo '<script type="text/javascript" src="/library/textformat.js"></script>';
        //<!-- page styles -->

        echo '<link rel="stylesheet" href="/interface/themes/style_oemr.css" type="text/css">';
        echo '<link rel="stylesheet" href="/interface/forms/'.$PatientExam_Form->form_folder.'/style.css" type="text/css">';
        echo '</head>';
        echo '<body class="body_top">';
        echo date("F d, Y", time());

echo '<form method=post action="/interface/forms/'.$PatientExam_Form->form_folder.'/save.php?mode='.$PatientExam_Form->form_mode.'&id='.$_GET["id"].'" name="pregnacy_cdss_form">';
echo '<span class="title">'.xl($PatientExam_Form->form_name,"e").'</span><br>';

echo '<input type="hidden" name="id" value="'.$PatientExam_Form->form_idexam.'" />';
echo '<input type="hidden" name="pid" value="'.$PatientExam_Form->form_pid.'"/>';
echo '<input type="hidden" name="process" value="true"/>';
echo '<input type="hidden" class="isfirstpregnacyhd" name="isfirstpregnacyhd" value="'.$PatientExam_Form->is_firstpregnacy.'">';

//<!-- Save/Cancel links -->
        $sss=xl('Save Changes','e');
        var_dump($sss);
//echo '<input type="button" class="save" value="'.$sss.'"> &nbsp;';
        echo '<input type="button" class="save" value="Save Changes"> &nbsp;';
echo '<input type="button" class="dontsave" value="'.xl("Don\'t Save Changes","e").'"> &nbsp;';
echo '<input type="button" class="printform" value="'.xl("Print","e").'"> &nbsp;';

//<!-- container for the main body of the form -->
echo '<div id="form_container">';

echo '<div id="general">';
echo '<div id="isfirspregcheck">';
echo '<input type="checkbox" class="isfirstpregnacy" id="firstpregnacyconfirm" name="is_firstpregnacy" value="<'.$PatientExam_Form->is_firstpregnacy.'"'.(($this->is_firstpregnacy == 1) ? 'checked="checked"' : '').'/>Is firts pregnacy?';
        echo '</div>';
        echo '<div id="isfirspregbtn">';
            echo '<span><strong>Вагітність:&nbsp;</strong></span> <span id="firstpregbtnansw"></span>';
            echo '<input type="button" class="firspregbtn" value="Це перша вагітність?">';
        echo '</div>';


//var_dump($rootdir);
foreach ($SymptCategory as $key=>$SymptCat)
{
    //begin category
    echo '<div class="symptcategory" id="'.$SymptCat->id.'">';
    echo '<strong>'.$SymptCat->id.'. '.$SymptCat->cat_name.'</strong>';

    foreach ($SymptCat->symptoms as $key=>$Symptoms)
    {
        //begin symptom
        echo '<div class="symptom" id="'.$Symptoms->id.'">';
        echo $Symptoms->symp_name;

        foreach ($Symptoms->symptoptions as $key=>$SymptOptions)
        {
            //begin symptom option
            echo '<div class="symptoption" id="'.$SymptOptions->id.'">';
            if ($Symptoms->is_multi) { $sel_type = 'checkbox'; } else { $sel_type = 'radio'; }
            $selection = '';
            if (SymptByPatient_Model::isselected($PatientExam_Form->form_idexam, $PatientExam_Form->form_pid, $Symptoms->id, $SymptOptions->id)) { $selection = 'checked'; } else { $selection = ''; }
            echo '<input type="'.$sel_type.'" id="'.$SymptOptions->id.'" name="symptom_options['.$Symptoms->id.'][]" value="'.$SymptOptions->id.'" '.$selection.' />'.$SymptOptions->opt_name;
            //end symptom option
            echo '</div>';
        }
        //end symptom
        echo '</div>';
    }
    //end category
    echo '</div>';
}

        echo '</div>';
        echo '</div>'; //<!-- end form_container -->
        //<!-- Save/Cancel links -->
        echo '<input type="button" class="save" value="'.xl("Save Changes","e").'"> &nbsp;';
        echo '<input type="button" class="dontsave" value="'.xl("Don\'t Save Changes","e").'"> &nbsp;';
        echo '<input type="button" class="printform" value="'.xl("Print","e").'"> &nbsp;';
        echo '</form>';



        //<!-- pop up calendar -->
        echo '<style type="text/css">@import url('.$GLOBALS['webroot'].'/library/dynarch_calendar.css);</style>';
        echo '<script type="text/javascript" src="'.$GLOBALS['webroot'].'/library/dynarch_calendar.js"></script>';
        echo '<script type="text/javascript" src="'.$GLOBALS['webroot'].'/library/dynarch_calendar_en.js"></script>';
        echo '<script type="text/javascript" src="'.$GLOBALS['webroot'].'/library/dynarch_calendar_setup.js"></script>';

        echo '<script type="text/javascript" language="javascript">';
        // this line is to assist the calendar text boxes
        echo 'var mypcc = '.$GLOBALS["phone_country_code"].';';
        echo 'function PrintForm() {';
        echo 'newwin = window.open("http://'.$_SERVER['SERVER_NAME'].$rootdir.'/interface/forms/'.$PatientExam_Form->form_folder.'/print.php?id='.$_GET["id"].'","mywin");';
        echo '}';
        echo '</script>';

        echo '<script type="text/javascript" language="javascript">';
echo '$(document).ready(function(){';
echo '$(".save").click(function() { top.restoreSession(); document.pregnacy_cdss_form.submit(); });';
echo '$(".dontsave").click(function() { location.href="'.$PatientExam_Form->returnurl.'"; });';
echo '$(".printform").click(function() { PrintForm(); });';
        echo '}';
        echo '</script>';

        echo '</body>';
        echo '</html>';


    }
}
