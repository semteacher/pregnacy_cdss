<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 13.03.15
 * Time: 19:51
 */
class SymptByPatient_Form2Report {

    public function __construct($form_data, $curr_diseases_multi, $form_folder)
    {
        print "<style>.borderedtable, .borderedtable th, .borderedtable td { border: 1px solid black; }</style>";
        print "<style>.centertext { text-align: center; }</style>";
        print "<style>.warningtext { background-color: gold; }</style>";
        print "<style>.display-flex { display: flex; }</style>";
        print "<style>.display-margin { margin: 5px; }</style>";
        
        print "<div class='navigateLink'>";
		print "<form method='post' action='../../forms/pregnancy_cdss/decisiontreegae.php' onsubmit='return top.restoreSession()'>"; 
		print "<input type='hidden' name='id' value='". attr($form_data[id]) . "'>";
		print "<input type='submit' name='decisiontreegae' value='" . xla('Submit this form to GAE Decision Tree Service') . "' />";
		print "</form>";
        print "</div>"; // end hide for report
    
        print "<div class=bold>Діагностичні дані:";
        print "<br>";
        if (!is_null($form_data[is_firstpregnancy])) {
            $isfirstpregtext = ($form_data[is_firstpregnancy] == 1) ? FIRSTPREGNACYTXT : NEXTPREGNACYTXT;
        } else {
            $isfirstpregtext = UNDEFINED;
        }

        print "<div><span>Вагітність: </span><span class='bold warningtext'>$isfirstpregtext</span></div>";
        print "<div><span>Остаточний діагноз: </span><span class='bold warningtext'>$form_data[finaldisease]</span></div>";
        print "<br>";
        
        print "<div>";
        print "<div><span class='bold'>Вірогіднісна (кількісна) оцінка</span></div>";
        print "<div><span>Вірогідний діагноз: </span><span class='bold warningtext'>$form_data[expect_disease]</span></div>";
        print "<span class=bold>Детальніше:</span>";
        print "<table class=borderedtable>";
        print "<tr><th>Діагноз</th><th>Кільк. значущих симптомів</th></tr>";
        foreach ($curr_diseases_multi as $disease_id=>$dis_symmary) {
            print "<tr><td class=bold>$dis_symmary[dis_name]</td><td class='text centertext'>$dis_symmary[count]</td></tr>";
        }
        print "</table>";
        print "</div>";
        print "</div>";

        print "<hr>";
        print "<div class='display-margin display-flex'>";
        print "<div class='display-margin bold'>Анкету створено:";
        print "<div><span class=bold>- Користувач: </span><span class=text>$form_data[createuser]</span></div>";
        print "<div><span class=bold>- Дата і час: </span><span class=text>$form_data[createdate]</span></div>";
        print "</div>";
        print "<br>";
        print "<div class='display-margin bold'>Анкету востаннє змінювали:";
        print "<div><span class=bold>- Користувач: </span><span class=text>$form_data[user]</span></div>";
        print "<div><span class=bold>- Дата і час: </span><span class=text>$form_data[date]</span></div>";
        print "</div>";
        print "</div>";
        print "<hr>";
        print "<script type='text/javascript' src='/openemr/interface/forms/".$form_folder."/gaeprocess.js'></script>";
    }
}
?>