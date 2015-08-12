<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 13.03.15
 * Time: 19:51
 */
class SymptByPatient_Form2Report {

    public function __construct($form_data, $curr_deceases_multi)
    {
        print "<style>.borderedtable, .borderedtable th, .borderedtable td { border: 1px solid black; }</style>";
        print "<style>.centertext { text-align: center; }</style>";
        print "<style>.warningtext { background-color: gold; }</style>";
        
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
        print "<div><span>Остаточний діагноз: </span><span class='bold warningtext'>$form_data[finaldecease]</span></div>";
        print "<br>";
        
        print "<div>";
        print "<div><span class='bold'>Кількісна оцінка</span></div>";
        print "<div><span>Вірогідний діагноз: </span><span class='bold warningtext'>$form_data[expect_decease]</span></div>";
        print "<span class=bold>Детальніше:</span>";
        print "<table class=borderedtable>";
        print "<tr><th>Діагноз</th><th>Кільк. значущих симптомів</th></tr>";
        foreach ($curr_deceases_multi as $decease_id=>$dec_symmary) {
            print "<tr><td class=bold>$dec_symmary[dec_name]</td><td class='text centertext'>$dec_symmary[count]</td></tr>";
        }
        print "</table>";
        print "</div>";
        print "</div>";

        print "<hr>";
        print "<div class=bold>Анкету створено:";
        print "<div><span class=bold>- Користувач: </span><span class=text>$form_data[createuser]</span></div>";
        print "<div><span class=bold>- Дата і час: </span><span class=text>$form_data[createdate]</span></div>";
        print "</div>";
        print "<br>";
        print "<div class=bold>Анкету востаннє змінювали:";
        print "<div><span class=bold>- Користувач: </span><span class=text>$form_data[user]</span></div>";
        print "<div><span class=bold>- Дата і час: </span><span class=text>$form_data[date]</span></div>";
        print "</div>";
        print "<hr>";

    }
}
?>