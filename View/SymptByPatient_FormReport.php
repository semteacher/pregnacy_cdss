<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 13.03.15
 * Time: 19:51
 */
print "<style>.borderedtable, .borderedtable th, .borderedtable td { border: 1px solid black; }</style>";
print "<style>.centertext { text-align: center; }</style>";

print "<div class=bold>Анкету створено:</div>";
print "<div><span class=bold>- Користувач: </span><span class=text>$form_data[createuser]</span></div>";
print "<div><span class=bold>- Дата і час: </span><span class=text>$form_data[createdate]</span></div>";
print "<br>";
print "<div class=bold>Анкету востаннє змінювали:</div>";
print "<div><span class=bold>- Користувач: </span><span class=text>$form_data[user]</span></div>";
print "<div><span class=bold>- Дата і час: </span><span class=text>$form_data[date]</span></div>";
print "<br>";
print "<div class=bold>Діагностичні дані:</div>";
print "<table class=borderedtable>";
print "<tr><th>Діагноз</th><th>Кільк. значущих симптомів</th></tr>";
foreach ($curr_deceases_multi as $decease_id=>$dec_symmary) {
    print "<tr><td class=bold>$dec_symmary[dec_name]</td><td class='text centertext'>$dec_symmary[count]</td></tr>";
}
print "</table>";

?>