<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 13.03.15
 * Time: 19:51
 */
class SymptByPatient_Form2Print {

    public function __construct($PatientExam_Form, $patient, $form_data, $curr_diseases_multi, $symptbypatientarr)
    {
        echo '<!DOCTYPE html>';
        echo '<html>';
        echo '<head>';
        echo '<meta charset="UTF-8">';

        //<!-- page styles -->
        echo '<link rel="stylesheet" href="/openemr/interface/forms/'.$PatientExam_Form->form_folder.'/style.css" type="text/css">';
        echo '</head>';
        echo '<body id="print_general">';
        echo '<div class=centertext><span class="title">'.$PatientExam_Form->form_name.'</span><br></div>';

        print "<div>";
        print "<div class=display-inline-block><span class=bold>Пацієнт:</span>";
        print "<div><span class=text>Код:&nbsp;</span><span class=bold>$patient[pid]</span>&nbsp;";
        print "<span class=text>Прізвище:&nbsp;</span><span class=bold>$patient[lname]</span>&nbsp;";
        print "<span class=text>І\"мя:&nbsp;</span><span class=bold>$patient[fname]</span>&nbsp;";
        print "<span class=text>По-батькові:&nbsp;</span><span class=bold>$patient[mname]</span></div>";
        print "<div><span class=text>Дата народження:&nbsp;</span><span class=bold>$patient[DOB_TS]</span></div>";
        print "<div><span class=text>Адреса:&nbsp;</span><span class=bold>$patient[country_code]</span>&nbsp;";
        print "<span class=bold>$patient[state]</span>&nbsp;<span class=bold>$patient[city]</span>&nbsp;<span class=bold>$patient[street]</span></div>";
        print "<div><span class=text>Телефони:&nbsp;</span><span class=bold>$patient[phone_home]</span>&nbsp;<span class=bold>$patient[phone_cell]</span></div>";
        print "</div>";
        print "<div class='bold display-inline-block'>Діагностичні дані:";
       // print "<span class=bold>Діагностичні дані:</span>";
       // print "<br>";
        if (!is_null($form_data[is_firstpregnancy])) {
            $isfirstpregtext = ($form_data[is_firstpregnancy] == 1) ? FIRSTPREGNACYTXT : NEXTPREGNACYTXT;
        } else {
            $isfirstpregtext = UNDEFINED;
        }

        print "<div class=bold><span>Вагітність: </span><span class=warningtext>$isfirstpregtext</span></div>";
        print "<div class=bold><span>Остаточний діагноз: </span><span class='bold warningtext'>$form_data[finaldisease]</span></div>";
        
        print "</div>";
        print "</div>";
        print "<div>";
        
        print "<div class='bold display-inline-block'>Вірогіднісна (кількісна) оцінка:";
        print "<div class=bold><span>Вірогідний діагноз: </span><span class=warningtext>$form_data[expect_disease]</span></div>";
        print "<div>Детальніше:</div>";
       // print "<span class=bold>Детальніше про вірогідні діагнози:</span>";
        print "<table class=borderedtable>";
        print "<tr><th>Діагноз</th><th>Кільк. значущих симптомів</th></tr>";
        foreach ($curr_diseases_multi as $disease_id=>$dis_symmary) {
            print "<tr><td class=bold>$dis_symmary[dis_name]</td><td class='text centertext'>$dis_symmary[count]</td></tr>";
        }
        print "</table>";
        print "</div>";
        print "</div>";
        
        print "<hr><div>";
        print "<div class=centertext><span class=bold>Дані анкетування:</span></div>";
        print "<hr>";

        print "<table width='100%' class=borderedtable>";
        print "<tr><th width='35%'>Параметр</th><th width='30%'>Значення</th><th width='35%'>Вірог. діагноз</th></tr>";
        //main data out
        $curr_id_category='';
        foreach ($symptbypatientarr as $key=>$exam_opt_symmary) {
            if ($curr_id_category <> $exam_opt_symmary[id_sympt_cat]){
                //print category header
                $curr_id_category = $exam_opt_symmary[id_sympt_cat];
                print "<tr><td colspan='3' class=bold>$exam_opt_symmary[id_sympt_cat]. $exam_opt_symmary[sympt_cat_name]</td></tr>";
            } 
            //print symptom
            print "<tr><td class=text>$exam_opt_symmary[symptom_name]</td>";
            print "<td class=text>$exam_opt_symmary[sympt_opt_name]</td>";
            print "<td class=bold>$exam_opt_symmary[dis_name]</td></tr>";            
        }
        print "</table>";

        print "<hr>";
        print "<div>";
        print "<div class='bold display-inline-block'>Анкету створено:";
        print "<div><span class=bold>- Користувач: </span><span class=text>$form_data[createuser]</span></div>";
        print "<div><span class=bold>- Дата і час: </span><span class=text>$form_data[createdate]</span></div>";
        print "</div>";
        print "<div class='bold display-inline-block'>Анкету востаннє змінювали:";
        print "<div><span class=bold>- Користувач: </span><span class=text>$form_data[user]</span></div>";
        print "<div><span class=bold>- Дата і час: </span><span class=text>$form_data[date]</span></div>";
        print "</div>";
        print "</div>";
        print "<hr>";

        print "</div>";

        echo '</body>';
        echo '</html>';
    }
}
?>