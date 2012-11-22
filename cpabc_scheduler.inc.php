<?php

if ( !defined('CPABC_AUTH_INCLUDE') )
{
    echo 'Direct access not allowed.';
    exit;
}

global $wpdb;
if (defined('CPABC_CALENDAR_USER') && CPABC_CALENDAR_USER != 0)
    $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE conwer=".CPABC_CALENDAR_USER." AND caldeleted=0" );
else if (defined('CPABC_CALENDAR_FIXED_ID'))   
    $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE id=".CPABC_CALENDAR_FIXED_ID." AND caldeleted=0" );
else
    $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE caldeleted=0" );

define ('CP_CALENDAR_ID',1);

?>
</p> <!-- this p tag fixes a IE bug -->
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('TDE_AppCalendar/all-css.css', __FILE__); ?>" />
<script>
var pathCalendar = "<?php echo cpabc_appointment_get_site_url(); ?>";
var cpabc_global_date_format = '<?php echo cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT); ?>';
var cpabc_global_military_time = '<?php echo cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME); ?>';
var cpabc_global_start_weekday = '<?php echo cpabc_get_option('calendar_weekday', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_WEEKDAY); ?>';
var cpabc_global_mindate = '<?php $value = cpabc_get_option('calendar_mindate', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MINDATE); if ($value != '') echo date("n/j/Y", strtotime($value)); ?>';
var cpabc_global_maxdate = '<?php $value = cpabc_get_option('calendar_maxdate', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MAXDATE); if ($value != '') echo date("n/j/Y",strtotime($value)); ?>';
</script>
<script type="text/javascript" src="<?php echo plugins_url('TDE_AppCalendar/all-scripts.js', __FILE__); ?>"></script>


<form name="FormEdit" action="<?php get_site_url(); ?>" method="post" onsubmit="return doValidate(this);">
 <input name="cpabc_appointments_post" type="hidden" id="1" />


<?php if (count($myrows) < 2) { ?>
  <div style="display:none">
<?php } else {?>
  <div>
<?php } ?>
<?php
  echo __("Calendar").":";
?>
<br />
<select name="cpabc_item" id="cpabc_item" onchange="cpabc_updateItem()">
<?php
  foreach ($myrows as $item)
  {
      echo '<option value='.$item->id.'>'.$item->uname.'</option>';
  }
?>
</select>

<br /><br />
</div>

<?php
  echo __("Select date and time").":";
?>

<?php
  foreach ($myrows as $item)
  {
?>

<div id="calarea_<?php echo $item->id; ?>" style="display:none">
<input name="selDaycal<?php echo $item->id; ?>" type="hidden" id="selDaycal<?php echo $item->id; ?>" /><input name="selMonthcal<?php echo $item->id; ?>" type="hidden" id="selMonthcal<?php echo $item->id; ?>" /><input name="selYearcal<?php echo $item->id; ?>" type="hidden" id="selYearcal<?php echo $item->id; ?>" /><input name="selHourcal<?php echo $item->id; ?>" type="hidden" id="selHourcal<?php echo $item->id; ?>" /><input name="selMinutecal<?php echo $item->id; ?>" type="hidden" id="selMinutecal<?php echo $item->id; ?>" />
 <div style="z-index:1000;">
   <div id="cal<?php echo $item->id; ?>Container"></div>
 </div>
 <div style="clear:both;"></div>
</div>
<?php
  }
?>

<div id="selddiv" style="font-weight: bold;margin-top:5px;padding:3px;"></div>

<script type="text/javascript">
 var cpabc_current_calendar_item;
 function cpabc_updateItem()
 {
    document.getElementById("calarea_"+cpabc_current_calendar_item).style.display = "none";
    var i = document.FormEdit.cpabc_item.options.selectedIndex;
    var selecteditem = document.FormEdit.cpabc_item.options[i].value;
    cpabc_do_init(selecteditem);
 }
 function cpabc_do_init(id)
 {
    cpabc_current_calendar_item = id;
    document.getElementById("calarea_"+cpabc_current_calendar_item).style.display = "";
    initAppCalendar("cal"+cpabc_current_calendar_item,<?php echo cpabc_get_option('calendar_pages', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_PAGES); ?>,2,"<?php echo cpabc_get_option('calendar_language', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_LANGUAGE); ?>",{m1:"<?php _e('Please select the appointment time.'); ?>"});
    document.getElementById("selddiv").innerHTML = "";
 }
 cpabc_do_init(<?php echo $myrows[0]->id; ?>);
 function updatedate()
 {
    if (document.getElementById("selDaycal"+cpabc_current_calendar_item ).value != '')
    {
        var timead = "";
        var hour = document.getElementById("selHourcal"+cpabc_current_calendar_item ).value;
        if (cpabc_global_military_time == '0')
        {
            if (parseInt(hour) > 12)
            {
                timead = " pm";
                hour = parseInt(hour)-12;
            }
            else
            {
                timead = " am";
            }
        }
        var minute = document.getElementById("selMinutecal"+cpabc_current_calendar_item ).value;
        if (minute.length == 1)
            minute = "0"+minute;
        minute = hour + ":" + minute + timead;
        if (cpabc_global_date_format == '1')
            selected_date = document.getElementById("selDaycal"+cpabc_current_calendar_item ).value+"/"
                                                      +document.getElementById("selMonthcal"+cpabc_current_calendar_item ).value+"/"
                                                      +document.getElementById("selYearcal"+cpabc_current_calendar_item ).value+", "                                                      
                                                      +minute;
        else
            selected_date = document.getElementById("selMonthcal"+cpabc_current_calendar_item ).value+"/"
                                                      +document.getElementById("selDaycal"+cpabc_current_calendar_item ).value+"/"
                                                      +document.getElementById("selYearcal"+cpabc_current_calendar_item ).value+", "                                                      
                                                      +minute;
        document.getElementById("selddiv").innerHTML = "<?php echo _e("Selected date"); ?>: "+selected_date;
    }
 }
 setInterval('updatedate()',200);
 function doValidate(form)
 {
    if (form.phone.value == '')
    {
        alert('<?php _e('Please enter a valid phone number'); ?>.');
        return false;
    }
    if (form.email.value == '')
    {
        alert('<?php _e('Please enter a valid email address'); ?>.');
        return false;
    }
    if (form.name.value == '')
    {
        alert('<?php _e('Please write your name'); ?>.');
        return false;
    }
    if (document.getElementById("selDaycal"+cpabc_current_calendar_item).value == '')
    {
        alert('<?php _e('Please select date and time'); ?>.');
        return false;
    }
    <?php if (cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') { ?> if (form.hdcaptcha.value == '')
    {
        alert('<?php _e('Please enter the captcha verification code'); ?>.');
        return false;
    }        
    // check captcha
    $dexQuery = jQuery.noConflict();
    var result = $dexQuery.ajax({
        type: "GET",
        url: "<?php echo cpabc_appointment_get_site_url(); ?>?hdcaptcha="+form.hdcaptcha.value,
        async: false,
    }).responseText;
    if (result == "captchafailed")
    {
        $dexQuery("#captchaimg").attr('src', $dexQuery("#captchaimg").attr('src')+'&'+Date());
        alert('Incorrect captcha code. Please try again.');
        return false;
    }
    else <?php } ?>
        return true;
 }
</script>

<br />

<?php _e('Your phone number'); ?>:<br />
<input type="text" name="phone" value=""><br />

<?php _e('Your name'); ?>:<br />
<input type="text" name="name" value=""><br />

<?php _e('Your email'); ?>:<br />
<input type="text" name="email" value=""><br />

<?php _e('Comments/Questions'); ?>:<br />
<textarea name="question" style="width:100%"></textarea><br />


<?php if (cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') { ?>
  Please enter the security code:<br />
  <img src="<?php echo plugins_url('/captcha/captcha.php?width='.cpabc_get_option('dexcv_width', CPABC_TDEAPP_DEFAULT_dexcv_width).'&height='.cpabc_get_option('dexcv_height', CPABC_TDEAPP_DEFAULT_dexcv_height).'&letter_count='.cpabc_get_option('dexcv_chars', CPABC_TDEAPP_DEFAULT_dexcv_chars).'&min_size='.cpabc_get_option('dexcv_min_font_size', CPABC_TDEAPP_DEFAULT_dexcv_min_font_size).'&max_size='.cpabc_get_option('dexcv_max_font_size', CPABC_TDEAPP_DEFAULT_dexcv_max_font_size).'&noise='.cpabc_get_option('dexcv_noise', CPABC_TDEAPP_DEFAULT_dexcv_noise).'&noiselength='.cpabc_get_option('dexcv_noise_length', CPABC_TDEAPP_DEFAULT_dexcv_noise_length).'&bcolor='.cpabc_get_option('dexcv_background', CPABC_TDEAPP_DEFAULT_dexcv_background).'&border='.cpabc_get_option('dexcv_border', CPABC_TDEAPP_DEFAULT_dexcv_border).'&font='.cpabc_get_option('dexcv_font', CPABC_TDEAPP_DEFAULT_dexcv_font), __FILE__); ?>"  id="captchaimg" alt="security code" border="0"  />
  <br />
  Security Code (lowercase letters):<br />
  <div class="dfield">
  <input type="text" size="20" name="hdcaptcha" id="hdcaptcha" value="" />
  <div class="error message" id="hdcaptcha_error" generated="true" style="display:none;position: absolute; left: 0px; top: 25px;"></div>
  </div>
  <br />
<?php } ?>

<input type="submit" name="subbtn" value="<?php _e("Continue"); ?>">
</form>


