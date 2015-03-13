<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 13.03.15
 * Time: 19:51
 */
print "<div class=bold>Last updated:</div>";
print "<div><span class=bold>User: </span><span class=text>$form_data[user]</span></div>";
print "<div><span class=bold>Date: </span><span class=text>$form_data[date]</span></div>";
print "<div class=bold>Deceases info:</div>";
//var_dump($curr_decease_multi);
print "<table>";
print "<tr><td><center><b>Діагноз</b></td><td><center><b>Сум. вірог.</b></td><td><center><b>Кільк. відп. \"Так\"</b></td></tr>";
foreach ($curr_decease_multi as $decease_id=>$dec_symmary) {
    print "<tr><td><center><b>$decease_id</b></td><td><center>$dec_symmary[py]</td><td><center>$dec_symmary[count]</td></tr>";
}
print "</table>";

?>