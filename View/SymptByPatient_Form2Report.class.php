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

        print "<div class=bold>Діагностичні дані:";
        print "<br>";
        $isfirstpregtext = ($form_data[is_firstpregnacy] == 1) ? 'Перша' : 'Повторна';
        print "<div><span>Вагітність: </span><span class='bold warningtext'>$isfirstpregtext</span></div>";
        print "<div><span>Вірогідний діагноз: </span><span class='bold warningtext'>$form_data[expect_decease]</span></div>";
        print "<br>";

        print "<span class=bold>Детальніше про вірогідні діагнози:</span>";
        print "<table class=borderedtable>";
        print "<tr><th>Діагноз</th><th>Кільк. значущих симптомів</th></tr>";
        foreach ($curr_deceases_multi as $decease_id=>$dec_symmary) {
            print "<tr><td class=bold>$dec_symmary[dec_name]</td><td class='text centertext'>$dec_symmary[count]</td></tr>";
        }
        print "</table>";
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