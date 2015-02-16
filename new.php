<?php
/*
 * The page shown when the user requests a new form
 */

include_once("../../globals.php");
include_once("$srcdir/api.inc");

/** CHANGE THIS name to the name of your form **/
$form_name = "CDSS \"Вагітність 2.0\"(new)";

/** CHANGE THIS to match the folder you created for this form **/
$form_folder = "pregnacy_cdss";

formHeader("Form: ".$forn_name);

$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';
?>

<html><head>
<?php html_header_show();?>

<!-- other supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>

<!-- page styles -->
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
<link rel="stylesheet" href="../../forms/<?php echo $form_folder; ?>/style.css" type="text/css">

<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>

<script language="JavaScript">
// this line is to assist the calendar text boxes
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';
</script>

</head>

<body class="body_top">

<?php echo date("F d, Y", time()); ?>

<form method=post action="<?php echo $rootdir;?>/forms/<?php echo $form_folder; ?>/save.php?mode=new" name="my_form">
<span class="title"><?php xl($form_name, 'e'); ?></span><br>

<!-- Save/Cancel buttons -->
<input type="button" class="save" value="<?php xl('Save','e'); ?>"> &nbsp; 
<input type="button" class="dontsave" value="<?php xl('Don\'t Save','e'); ?>"> &nbsp; 

<!-- container for the main body of the form -->
<div id="form_container">

<div id="general">
<table>
<tr><td>
Date: 
   <input type='text' size='10' name='form_date' id='form_date'
    value='<?php echo date('Y-m-d', time()); ?>'
    title='<?php xl('yyyy-mm-dd','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
   <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_form_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
</td></tr>
<tr><td>
Name: <input id="name" name="name" type="text" size="50" maxlength="250">
Date of Birth:
   <input type='text' size='10' name='dob' id='dob'
    value='<?php echo $date ?>'
    title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' />
   <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_dob' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
</td></tr>
<tr><td>
Phone: <input name="phone" id="phone" type="text" size="15" maxlength="15">
</td></tr>
<tr><td>
Address: <input name="address" id="address" type="text" size="80" maxlength="250">
</td></tr>
</table>
</div>

<div id="bottom">
Use this space to express notes <br>
<textarea name="notes" id="notes" cols="80" rows="4"></textarea>
<br><br>
<div style="text-align:right;">
Signature?
<input type="radio" id="sig" name="sig" value="y">Yes
/
<input type="radio" id="sig" name="sig" value="n">No
&nbsp;&nbsp;
Date of signature:
   <input type='text' size='10' name='sig_date' id='sig_date'
    value='<?php echo date('Y-m-d', time()); ?>'
    title='<?php xl('yyyy-mm-dd','e'); ?>'
    onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
   <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
    id='img_sig_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
    title='<?php xl('Click here to choose a date','e'); ?>'>
</div>

<div style="text-align:center;">
<h3>Анкетні дані вагітної</h3>
<h4>1.1. Вік жінки</h4>
<input type="radio" id="sig" name="qst11_age" value="1">1. до 18 років
/
<input type="radio" id="sig" name="qst11_age" value="2">2. 19-25
/
<input type="radio" id="sig" name="qst11_age" value="3">3. 26-30
/
<input type="radio" id="sig" name="qst11_age" value="4">4. 31-35
/
<input type="radio" id="sig" name="qst11_age" value="5">5. 36-40
/
<input type="radio" id="sig" name="qst11_age" value="6">6. 40>
<h4>1.2. Сезон року</h4>
<input type="radio" id="sig" name="qst12_season" value="1">1. Зима
/
<input type="radio" id="sig" name="qst12_season" value="2">2. Весна
/
<input type="radio" id="sig" name="qst12_season" value="3">3. Літо
/
<input type="radio" id="sig" name="qst12_season" value="4">4. Осінь

</div>


</div>

</div> <!-- end form_container -->

<!-- Save/Cancel buttons -->
<input type="button" class="save" value="<?php xl('Save','e'); ?>"> &nbsp; 
<input type="button" class="dontsave" value="<?php xl('Don\'t Save','e'); ?>"> &nbsp; 
</form>

</body>

<script language="javascript">
/* required for popup calendar */
Calendar.setup({inputField:"dob", ifFormat:"%Y-%m-%d", button:"img_dob"});
Calendar.setup({inputField:"form_date", ifFormat:"%Y-%m-%d", button:"img_form_date"});
Calendar.setup({inputField:"sig_date", ifFormat:"%Y-%m-%d", button:"img_sig_date"});

// jQuery stuff to make the page a little easier to use

$(document).ready(function(){
    $(".save").click(function() { top.restoreSession(); document.my_form.submit(); });
    $(".dontsave").click(function() { location.href='<?php echo "$rootdir/patient_file/encounter/$returnurl";?>'; });
});
</script>

</html>

