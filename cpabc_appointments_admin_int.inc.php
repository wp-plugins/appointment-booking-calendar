<?php

if ( !is_admin() && !defined('CPABC_CALENDAR_ON_PUBLIC_WEBSITE')) 
{
    echo 'Direct access not allowed.';
    exit;
}

if (!defined('CP_CALENDAR_ID'))
    define ('CP_CALENDAR_ID',1);

global $wpdb; 
$mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME .' WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.CP_CALENDAR_ID); 


if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['cpabc_appointments_post_options'] ) )
    echo "<div id='setting-error-settings_updated' class='updated settings-error'> <p><strong>Settings saved.</strong></p></div>";

$current_user = wp_get_current_user();

if (cpabc_appointment_is_administrator() || $mycalendarrows[0]->conwer == $current_user->ID) { 

$request_costs = explode(";",cpabc_get_option('request_cost',CPABC_APPOINTMENTS_DEFAULT_COST));
if (!count($request_costs)) $request_costs[0] = CPABC_APPOINTMENTS_DEFAULT_COST;

$request_costs_exploded = "'".str_replace("'","\'",$request_costs[0])."'";
for ($k=1;$k<100;$k++)
   if (isset($request_costs[$k]))
       $request_costs_exploded .= ",'".str_replace("'","\'",$request_costs[$k])."'";
   else
       $request_costs_exploded .= ",'".str_replace("'","\'",$request_costs[0]*($k+1))."'";

?>

<?php if (!CPABC_APPOINTMENTS_DEFAULT_DEFER_SCRIPTS_LOADING) { ?>
<script type='text/javascript' src='../wp-content/plugins/appointment-booking-calendar/js/jQuery.stringify.js'></script>
<script type='text/javascript' src='../wp-content/plugins/appointment-booking-calendar/js/fbuilder-pro.jquery.js'></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />   
<?php } ?>

<div class="wrap">
<h2>Appointment Booking Calendar - Manage Calendar Availability</h2>

<?php if (!defined('CPABC_CALENDAR_ON_PUBLIC_WEBSITE')) { ?>
<input type="button" name="backbtn" value="Back to items list..." onclick="document.location='admin.php?page=cpabc_appointments';">
<?php } ?>

<form method="post" name="dexconfigofrm" action=""> 
<input name="cpabc_appointments_post_options" type="hidden" id="1" />
<input name="cpabc_item" type="hidden" value="<?php echo CP_CALENDAR_ID; ?>" />
   
<div id="normal-sortables" class="meta-box-sortables">

 <hr />
 <h3>These calendar settings apply only to: <?php echo $mycalendarrows[0]->uname; ?></h3>

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar Configuration / Administration</span></h3>
  <div class="inside">
  
   <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('TDE_AppCalendar/all-css.css', __FILE__); ?>" />
   <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('TDE_AppCalendar/simpleeditor.css', __FILE__); ?>" />
   <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('TDE_AppCalendar/tabview.css', __FILE__); ?>" />
   <script>
   var pathCalendar = "<?php echo cpabc_appointment_get_site_url(true); ?>";
   var cpabc_global_start_weekday = '<?php echo cpabc_get_option('calendar_weekday', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_WEEKDAY); ?>';
   </script>
   <script type="text/javascript" src="<?php echo plugins_url('TDE_AppCalendar/all-scripts.js', __FILE__); ?>"></script>
   <script type="text/javascript" language="JavaScript" src="<?php echo plugins_url('TDE_AppCalendar/tabview.js', __FILE__); ?>"></script>
   <script type="text/javascript" language="JavaScript" src="<?php echo plugins_url('TDE_AppCalendar/simpleeditor-beta-min.js', __FILE__); ?>"></script>
   
   <script>initAppCalendar("cal<?php echo CP_CALENDAR_ID; ?>","3","1","<?php echo CPABC_TDEAPP_DEFAULT_CALENDAR_LANGUAGE; ?>",{m1:"Please, select your appointment."});</script>
   
   <div style="padding:10px"><div id="caladmin"><div id="cal<?php echo CP_CALENDAR_ID; ?>Container"></div></div></div>
   <div style="clear:both;height:20px" ></div>
   <div id="demo" class="yui-navset" style="padding-left:10px;width:690px;"></div>
   <div style="clear:both;height:20px" ></div>      
   
  </div>    
 </div> 
 
 <hr />
   
 <input type="hidden" name="quantity_field" value="<?php echo esc_attr(cpabc_get_option('quantity_field','1')); ?>" />  
   
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Public Calendar Settings</span></h3>
  <div class="inside"> 
   
   <table class="form-table">
        <tr valign="top">        
        <th scope="row">Calendar language</th>
        <td>
             <?php $value = cpabc_get_option('calendar_language',CPABC_APPOINTMENTS_DEFAULT_CALENDAR_LANGUAGE); ?>
             <select name="calendar_language">               
               <option value="CZ" <?php if ($value == 'CZ') echo ' selected="selected"'; ?>>Czech</option>
               <option value="DE" <?php if ($value == 'DE') echo ' selected="selected"'; ?>>German</option>
               <option value="DA" <?php if ($value == 'DA') echo ' selected="selected"'; ?>>Danish</option>
               <option value="DU" <?php if ($value == 'DU') echo ' selected="selected"'; ?>>Dutch</option>
               <option value="EN" <?php if ($value == 'EN') echo ' selected="selected"'; ?>>English</option>
               <option value="FR" <?php if ($value == 'FR') echo ' selected="selected"'; ?>>French</option>
               <option value="IT" <?php if ($value == 'IT') echo ' selected="selected"'; ?>>Italian</option>
               <option value="JP" <?php if ($value == 'JP') echo ' selected="selected"'; ?>>Japanese</option>
               <option value="PL" <?php if ($value == 'PL') echo ' selected="selected"'; ?>>Polish</option>
               <option value="PT" <?php if ($value == 'PT') echo ' selected="selected"'; ?>>Portuguese</option>
               <option value="RU" <?php if ($value == 'RU') echo ' selected="selected"'; ?>>Russian</option>
               <option value="SP" <?php if ($value == 'SP') echo ' selected="selected"'; ?>>Spanish</option>
               <option value="SK" <?php if ($value == 'SK') echo ' selected="selected"'; ?>>Slovak</option>
               <option value="SE" <?php if ($value == 'SE') echo ' selected="selected"'; ?>>Swedish</option>
               <option value="TR" <?php if ($value == 'TR') echo ' selected="selected"'; ?>>Turkish</option>
            </select><br />
            * Note that this "Calendar language" setting will affect the calendar area, 
              but the rest of the form texts are translated in the MO/PO files located in the "<em>appointment-booking-calendar/languages</em>" folder.
              The <em>WP_LANG</em> constant into your config.php file must match the suffix of the MO/PO file to apply.
        </td>
        </tr>
        
        <tr valign="top">        
        <th scope="row">Calendar visual theme</th>
        <td>
             <?php $value = cpabc_get_option('calendar_theme',''); ?>
             <select name="calendar_theme">               
               <option value="" <?php if ($value == '') echo ' selected="selected"'; ?>>Default - Classic</option>
               <option value="light/" <?php if ($value == 'light/') echo ' selected="selected"'; ?>>Light</option>
               <option value="blue/" <?php if ($value == 'blue/') echo ' selected="selected"'; ?>>Blue</option>
            </select><br />
            * This will modify the calendar appearance in the public website. For other appearance modifications <a target="_blank" href="http://wordpress.dwbooster.com/faq/appointment-booking-calendar">check the FAQ</a>.
        </td>
        </tr>        
        
        <tr valign="top">        
        <th scope="row">Date format</th>
        <td>           
             <?php $value = cpabc_get_option('calendar_dateformat',CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT); ?>
             <select name="calendar_dateformat">               
               <option value="0" <?php if ($value == '0') echo ' selected="selected"'; ?>>mm/dd/yyyy</option>
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>dd/mm/yyyy</option>  
               <option value="2" <?php if ($value == '2') echo ' selected="selected"'; ?>>dd.mm.yyyy</option>       
             </select>           
        </td>
        </tr>
        
        <tr valign="top">        
        <th scope="row">Calendar Pages</th>
        <td>           
             <?php $value = cpabc_get_option('calendar_pages',CPABC_APPOINTMENTS_DEFAULT_CALENDAR_PAGES); ?>
             <select name="calendar_pages">               
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>1</option>
               <option value="2" <?php if ($value == '2') echo ' selected="selected"'; ?>>2</option>         
               <option value="3" <?php if ($value == '3') echo ' selected="selected"'; ?>>3</option>         
               <option value="4" <?php if ($value == '4') echo ' selected="selected"'; ?>>4</option>         
               <option value="5" <?php if ($value == '5') echo ' selected="selected"'; ?>>5</option>         
               <option value="6" <?php if ($value == '6') echo ' selected="selected"'; ?>>6</option>         
               <option value="7" <?php if ($value == '7') echo ' selected="selected"'; ?>>7</option>         
               <option value="8" <?php if ($value == '8') echo ' selected="selected"'; ?>>8</option>         
               <option value="9" <?php if ($value == '9') echo ' selected="selected"'; ?>>9</option>         
               <option value="10" <?php if ($value == '10') echo ' selected="selected"'; ?>>10</option>         
               <option value="11" <?php if ($value == '11') echo ' selected="selected"'; ?>>11</option>         
               <option value="12" <?php if ($value == '12') echo ' selected="selected"'; ?>>12</option>         
             </select>           
        </td>
        </tr>        
        
        <tr valign="top">        
        <th scope="row">Military time</th>
        <td>
             <?php $value = cpabc_get_option('calendar_militarytime',CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME); ?>
             <select name="calendar_militarytime">               
               <option value="0" <?php if ($value == '0') echo ' selected="selected"'; ?>>No</option>
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>Yes</option>         
             </select>         
        </td>
        </tr>
        
        <tr valign="top">        
        <th scope="row">Start weekday</th>
        <td>
             <?php $value = cpabc_get_option('calendar_weekday',CPABC_APPOINTMENTS_DEFAULT_CALENDAR_WEEKDAY); ?>
             <select name="calendar_weekday">               
               <option value="0" <?php if ($value == '0') echo ' selected="selected"'; ?>>Sunday</option>
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>Monday</option>
               <option value="2" <?php if ($value == '2') echo ' selected="selected"'; ?>>Tuesday</option>         
               <option value="3" <?php if ($value == '3') echo ' selected="selected"'; ?>>Wednesday</option>         
               <option value="4" <?php if ($value == '4') echo ' selected="selected"'; ?>>Thursday</option>         
               <option value="5" <?php if ($value == '5') echo ' selected="selected"'; ?>>Friday</option>         
               <option value="6" <?php if ($value == '6') echo ' selected="selected"'; ?>>Saturday</option>
             </select>         
        </td>
        </tr>              
        
        <tr valign="top">        
        <th scope="row">Minimum  available date</th>
        <td><input type="text" name="calendar_mindate" size="40" value="<?php echo esc_attr(cpabc_get_option('calendar_mindate',CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MINDATE)); ?>" /><br />
         <em style="font-size:11px;">Examples: 2012-10-25, today, today +3 days</em>
        </td>
        </tr>
        
        <tr valign="top">        
        <th scope="row">Maximum available date</th>
        <td>
         <input type="text" name="calendar_maxdate" size="40" value="<?php echo esc_attr(cpabc_get_option('calendar_maxdate',CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MAXDATE)); ?>" /><br />
         <em style="font-size:11px;">Examples: 2012-10-25, today, today +3 days</em>
        </td>
        </tr>
        
        <tr valign="top">        
        <th scope="row">Open calendar in this initial month/year</th>
        <td>
             <?php $value = cpabc_get_option('calendar_startmonth','0'); ?>
             <select name="calendar_startmonth">                                                          
               <option value="0" <?php if ($value == '0') echo ' selected="selected"'; ?>>Current month</option>
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>January</option>
               <option value="2" <?php if ($value == '2') echo ' selected="selected"'; ?>>February</option>
               <option value="3" <?php if ($value == '3') echo ' selected="selected"'; ?>>March</option>         
               <option value="4" <?php if ($value == '4') echo ' selected="selected"'; ?>>April</option>         
               <option value="5" <?php if ($value == '5') echo ' selected="selected"'; ?>>May</option>         
               <option value="6" <?php if ($value == '6') echo ' selected="selected"'; ?>>June</option>         
               <option value="7" <?php if ($value == '7') echo ' selected="selected"'; ?>>July</option>
               <option value="8" <?php if ($value == '8') echo ' selected="selected"'; ?>>August</option>
               <option value="9" <?php if ($value == '9') echo ' selected="selected"'; ?>>September</option>
               <option value="10" <?php if ($value == '10') echo ' selected="selected"'; ?>>October</option>
               <option value="11" <?php if ($value == '11') echo ' selected="selected"'; ?>>November</option>
               <option value="12" <?php if ($value == '12') echo ' selected="selected"'; ?>>December</option>
             </select>   
             /
             <?php $value = cpabc_get_option('calendar_startyear','0'); ?>
             <select name="calendar_startyear">  
              <option value="0" <?php if ($value == '0') echo ' selected="selected"'; ?>>Current year</option>
              <?php for ($y=date("Y")-3;$y<date("Y")+30;$y++) { ?>                                                                       
               <option value="<?php echo $y; ?>" <?php if ($value == "".$y) echo ' selected="selected"'; ?>><?php echo $y; ?></option>
              <?php } ?>  
             </select> 
                     
        </td>
        </tr>        
        
        <tr valign="top">        
        <th scope="row">Minimum slots to be selected</th>
        <td>
          <?php $option = @intval (cpabc_get_option('min_slots', '1')); if ($option=='') $option = 1; ?>
          <select name="min_slots">
           <?php for ($k=1; $k<=22; $k++) { ?>
           <option value="<?php echo $k; ?>"<?php if ($option == $k) echo ' selected'; ?>><?php echo $k; ?></option>
           <?php } ?>
          </select>
         <em style="font-size:11px;">This is the minimum number of slots that the customer must select in the booking form.</em>
        </td>
        </tr>
        
        <tr valign="top">        
        <th scope="row">Maximum slots to be selected</th>
        <td>
         <?php $option = @intval (cpabc_get_option('max_slots', '1')); if ($option=='') $option = 1;  ?>
          <select name="max_slots" onchange="cpabc_updatemaxslots();">
           <?php for ($k=1; $k<=22; $k++) { ?>
           <option value="<?php echo $k; ?>"<?php if ($option == $k) echo ' selected'; ?>><?php echo $k; ?></option>
           <?php } ?>
          </select>
         <em style="font-size:11px;">This is the maximum number of slots that the customer can select in the booking form.</em>
        </td>
        </tr>
        
        <tr valign="top">        
        <th scope="row">Close floating panel after selecting a time-slot?</th>
        <td>
         <?php $option = cpabc_get_option('close_fpanel', 'yes'); if ($option=='') $option = 'yes';  ?>
          <select name="close_fpanel">           
            <option value="yes"<?php if ($option == 'yes') echo ' selected'; ?>>Yes</option>           
            <option value="no"<?php if ($option == 'no') echo ' selected'; ?>>No</option>           
          </select>
         <em style="font-size:11px;">Default: "Yes". Set to "No" in the case the user have to select various slots in the same date. The price should be set for each total number of slots below (request cost setting).</em>
        </td>
        </tr>           
        
   </table>   

  </div>    
 </div>

 
 <input type="hidden" name="form_structure" id="form_structure" size="180" value="<?php echo str_replace("\r","",str_replace("\n","",esc_attr(cpabc_appointment_cleanJSON(cpabc_get_option('form_structure', CPABC_APPOINTMENTS_DEFAULT_form_structure))))); ?>" />
 
 <input type="hidden" name="vs_use_validation" value="1" />
 <input type="hidden" name="vs_text_is_required" value="<?php echo esc_attr(cpabc_get_option('vs_text_is_required', CPABC_APPOINTMENTS_DEFAULT_vs_text_is_required)); ?>" />
 <input type="hidden" name="vs_text_is_email" value="<?php echo esc_attr(cpabc_get_option('vs_text_is_email', CPABC_APPOINTMENTS_DEFAULT_vs_text_is_email)); ?>" />
 <input type="hidden" name="cv_text_enter_valid_captcha" value="<?php echo esc_attr(cpabc_get_option('cv_text_enter_valid_captcha', CPABC_TDEAPP_DEFAULT_dexcv_text_enter_valid_captcha)); ?>" />
 <input type="hidden" name="vs_text_datemmddyyyy" value="<?php echo esc_attr(cpabc_get_option('vs_text_datemmddyyyy', CPABC_APPOINTMENTS_DEFAULT_vs_text_datemmddyyyy)); ?>" />
 <input type="hidden" name="vs_text_dateddmmyyyy" value="<?php echo esc_attr(cpabc_get_option('vs_text_dateddmmyyyy', CPABC_APPOINTMENTS_DEFAULT_vs_text_dateddmmyyyy)); ?>" />
 <input type="hidden" name="vs_text_number" value="<?php echo esc_attr(cpabc_get_option('vs_text_number', CPABC_APPOINTMENTS_DEFAULT_vs_text_number)); ?>" />
 <input type="hidden" name="vs_text_digits" value="<?php echo esc_attr(cpabc_get_option('vs_text_digits', CPABC_APPOINTMENTS_DEFAULT_vs_text_digits)); ?>" />
 <input type="hidden" name="vs_text_max" value="<?php echo esc_attr(cpabc_get_option('vs_text_max', CPABC_APPOINTMENTS_DEFAULT_vs_text_max)); ?>" />
 <input type="hidden" name="vs_text_min" value="<?php echo esc_attr(cpabc_get_option('vs_text_min', CPABC_APPOINTMENTS_DEFAULT_vs_text_min)); ?>" />



 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Submit Button</span></h3>
  <div class="inside">   
     <table class="form-table">    
        <tr valign="top">
        <th scope="row">Submit button label (text):</th>
        <td><input type="text" name="vs_text_submitbtn" size="40" value="<?php $label = esc_attr(cpabc_get_option('vs_text_submitbtn', 'Continue')); echo ($label==''?'Continue':$label); ?>" /></td>
        </tr>    
        <tr valign="top">
        <td colspan="2"> - The  <em>class="<?php if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") != "1") { ?>pbSubmit<?php } else { ?>cp_subbtn<?php } ?>"</em> can be used to modify the button styles. <br />
        - The styles can be applied into any of the CSS files of your theme or into the CSS file <em>"appointment-booking-calendar\TDE_AppCalendar\all-css.css"</em>. <br />
        - For further modifications, the submit button is located at the end of the file <em>"<?php if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") != "1") echo 'cpabc_internal.inc.php'; else echo 'cpabc_scheduler.inc.php'; ?>"</em>.<br />
        <?php if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") != "1") { ?>
        - For general CSS styles modifications to the form and samples <a href="http://wordpress.dwbooster.com/faq/appointment-booking-calendar#q113" target="_blank">check this FAQ</a>.
        <?php } ?>
        </tr>
     </table>
  </div>    
 </div> 
  

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Paypal Payment Configuration</span></h3>
  <div class="inside">

    <table class="form-table">
        <tr valign="top">        
        <th scope="row">Enable Paypal Payments?</th>
        <td><input type="checkbox" readonly disabled name="enable_paypal" size="40" value="1" checked /> <em>The feature for working without PayPal is implemented/available in the <a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar#download">pro version</a>.</em>
        </td>
        </tr>                   
    
        <tr valign="top">        
        <th scope="row">Paypal email</th>
        <td><input type="text" name="paypal_email" size="40" value="<?php echo esc_attr(cpabc_get_option('paypal_email',$current_user->user_email)); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Request cost for each number of time slots</th>
        <td>
           <div id="cpabcslots">
             <div id="cpabccost1" style="float:left;width:70px;">
              1 slot:<br />
              <input type="text" name="request_cost_1" style="width:40px;" value="<?php echo esc_attr(cpabc_get_option('request_cost',CPABC_APPOINTMENTS_DEFAULT_COST)); ?>" />
             </div>            
           </div>
           <div style="clear:both"></div>
           <em>Note: Each box should contain the TOTAL cost for the N slots related. Ex: 1 slot for $25, 2 slots for $50, 3 slots for $75, ...</em>
        </td>
        </tr>
        
        
        <tr valign="top">
        <th scope="row">Paypal product name</th>
        <td><input type="text" name="paypal_product_name" size="50" value="<?php echo esc_attr(cpabc_get_option('paypal_product_name',CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME)); ?>" /></td>
        </tr>        
        
        <tr valign="top">        
        <th scope="row">Currency</th>
        <td><input type="text" name="currency" value="<?php echo esc_attr(cpabc_get_option('currency',CPABC_APPOINTMENTS_DEFAULT_CURRENCY)); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">URL to return after successful  payment</th>
        <td><input type="text" name="url_ok" size="70" value="<?php echo esc_attr(cpabc_get_option('url_ok',CPABC_APPOINTMENTS_DEFAULT_OK_URL)); ?>" /></td>
        </tr>        
        
        <tr valign="top">
        <th scope="row">URL to return after an incomplete or cancelled payment</th>
        <td><input type="text" name="url_cancel" size="70" value="<?php echo esc_attr(cpabc_get_option('url_cancel',CPABC_APPOINTMENTS_DEFAULT_CANCEL_URL)); ?>" /></td>
        </tr>        
        
        
        <tr valign="top">
        <th scope="row">Paypal language</th>
        <td><input type="text" name="paypal_language" value="<?php echo esc_attr(cpabc_get_option('paypal_language',CPABC_APPOINTMENTS_DEFAULT_PAYPAL_LANGUAGE)); ?>" /></td>
        </tr>  
        
        <tr valign="top">        
        <th scope="row">Paypal Mode</th>
        <td><select name="paypal_mode">
             <option value="production" <?php if (cpabc_get_option('paypal_mode','production') != 'sandbox') echo 'selected'; ?>>Production - real payments processed</option> 
             <option value="sandbox" <?php if (cpabc_get_option('paypal_mode','production') == 'sandbox') echo 'selected'; ?>>SandBox - PayPal testing sandbox area</option> 
            </select>
            <br />
           <em> * Note that if you are testing it in a <strong>localhost</strong> site the PayPal IPN notification won't reach to your website and the appointment won't be processed.</em>
        </td>
        </tr>          
        
        <tr valign="top">
        <th scope="row">Discount Codes</th>
        <td> 
           <em>The -discount codes- feature is available in the <a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar#download">pro version</a>.</em>
        </td>
        </tr>  
                   
     </table>  

  </div>    
 </div>    
 
 
  
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Notification Settings to Administrators</span></h3>
  <div class="inside">
     <table class="form-table">    
        <tr valign="top">
        <th scope="row">Notification "from" email</th>
        <td><input type="text" name="notification_from_email" size="40" value="<?php echo esc_attr(cpabc_get_option('notification_from_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL)); ?>" /></td>
        </tr>             
        <tr valign="top">
        <th scope="row">Send notification to email</th>
        <td><input type="text" name="notification_destination_email" size="40" value="<?php echo esc_attr(cpabc_get_option('notification_destination_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL)); ?>" />
          <br />
          <em>Note: Comma separated list for adding more than one email address<em>
        </td>
        </tr>
        <tr valign="top">
        <th scope="row">Email subject notification to admin</th>
        <td><input type="text" name="email_subject_notification_to_admin" size="70" value="<?php echo esc_attr(cpabc_get_option('email_subject_notification_to_admin', CPABC_APPOINTMENTS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email format?</th>
        <td>
          <?php $option = cpabc_get_option('nadmin_emailformat', CPABC_APPOINTMENTS_DEFAULT_email_format); ?>
          <select name="nadmin_emailformat">
           <option value="text"<?php if ($option != 'html') echo ' selected'; ?>>Plain Text (default)</option>
           <option value="html"<?php if ($option == 'html') echo ' selected'; ?>>HTML (use html in the textarea below)</option>
          </select>
        </td>
        </tr>          
        <tr valign="top">
        <th scope="row">Email notification to admin</th>
        <td><textarea cols="70" rows="5" name="email_notification_to_admin"><?php echo cpabc_get_option('email_notification_to_admin', CPABC_APPOINTMENTS_DEFAULT_NOTIFICATION_EMAIL); ?></textarea></td>
        </tr>
     </table>  
  </div>    
 </div>
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Email Copy to User / Auto-reply</span></h3>
  <div class="inside">
     <table class="form-table">            
<?php if (get_option('CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR',"1") != "1") { ?>
        <tr valign="top">
        <th scope="row">Email field on the form</th>
        <td><select id="cu_user_email_field" name="cu_user_email_field" def="<?php echo esc_attr(cpabc_get_option('cu_user_email_field', CPABC_APPOINTMENTS_DEFAULT_cu_user_email_field)); ?>"></select></td>
        </tr>                
<?php } ?>        
        <tr valign="top">
        <th scope="row">Email subject confirmation to user</th>
        <td><input type="text" name="email_subject_confirmation_to_user" size="70" value="<?php echo esc_attr(cpabc_get_option('email_subject_confirmation_to_user', CPABC_APPOINTMENTS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email format?</th>
        <td>
          <?php $option = cpabc_get_option('nuser_emailformat', CPABC_APPOINTMENTS_DEFAULT_email_format); ?>
          <select name="nuser_emailformat">
           <option value="text"<?php if ($option != 'html') echo ' selected'; ?>>Plain Text (default)</option>
           <option value="html"<?php if ($option == 'html') echo ' selected'; ?>>HTML (use html in the textarea below)</option>
          </select>
        </td>
        </tr>          
        <tr valign="top">
        <th scope="row">Email confirmation to user</th>
        <td><textarea cols="70" rows="5" name="email_confirmation_to_user"><?php echo cpabc_get_option('email_confirmation_to_user', CPABC_APPOINTMENTS_DEFAULT_CONFIRMATION_EMAIL); ?></textarea></td>
        </tr>                                                
     </table>  
  </div>    
 </div>
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Captcha Verification</span></h3>
  <div class="inside">
     <table class="form-table">    
        <tr valign="top">
        <th scope="row">Use Captcha Verification?</th>
        <td colspan="5">
          <?php $option = cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha); ?>
          <select name="dexcv_enable_captcha">           
           <option value="true"<?php if ($option == 'true') echo ' selected'; ?>>Yes</option>
           <option value="false"<?php if ($option == 'false') echo ' selected'; ?>>No</option>
          </select>
        </td>
        </tr>
        
        <tr valign="top">
         <th scope="row">Width:</th>
         <td><input type="text" name="dexcv_width" size="10" value="<?php echo esc_attr(cpabc_get_option('dexcv_width', CPABC_TDEAPP_DEFAULT_dexcv_width)); ?>"  onblur="generateCaptcha();"  /></td>
         <th scope="row">Height:</th>
         <td><input type="text" name="dexcv_height" size="10" value="<?php echo esc_attr(cpabc_get_option('dexcv_height', CPABC_TDEAPP_DEFAULT_dexcv_height)); ?>" onblur="generateCaptcha();"  /></td>
         <th scope="row">Chars:</th>
         <td><input type="text" name="dexcv_chars" size="10" value="<?php echo esc_attr(cpabc_get_option('dexcv_chars', CPABC_TDEAPP_DEFAULT_dexcv_chars)); ?>" onblur="generateCaptcha();"  /></td>
        </tr>             

        <tr valign="top">
         <th scope="row">Min font size:</th>
         <td><input type="text" name="dexcv_min_font_size" size="10" value="<?php echo esc_attr(cpabc_get_option('dexcv_min_font_size', CPABC_TDEAPP_DEFAULT_dexcv_min_font_size)); ?>" onblur="generateCaptcha();"  /></td>
         <th scope="row">Max font size:</th>
         <td><input type="text" name="dexcv_max_font_size" size="10" value="<?php echo esc_attr(cpabc_get_option('dexcv_max_font_size', CPABC_TDEAPP_DEFAULT_dexcv_max_font_size)); ?>" onblur="generateCaptcha();"  /></td>        
         <td colspan="2" rowspan="">
           Preview:<br />
             <br />
            <img src="<?php echo cpabc_appointment_get_site_url(true); ?>/?cpabc_app=captcha&inAdmin=1"  id="captchaimg" alt="security code" border="0"  />            
         </td> 
        </tr>             
                

        <tr valign="top">
         <th scope="row">Noise:</th>
         <td><input type="text" name="dexcv_noise" size="10" value="<?php echo esc_attr(cpabc_get_option('dexcv_noise', CPABC_TDEAPP_DEFAULT_dexcv_noise)); ?>" onblur="generateCaptcha();" /></td>
         <th scope="row">Noise Length:</th>
         <td><input type="text" name="dexcv_noise_length" size="10" value="<?php echo esc_attr(cpabc_get_option('dexcv_noise_length', CPABC_TDEAPP_DEFAULT_dexcv_noise_length)); ?>" onblur="generateCaptcha();" /></td>        
        </tr>          
        

        <tr valign="top">
         <th scope="row">Background:</th>
         <td><input type="text" name="dexcv_background" size="10" value="<?php echo esc_attr(cpabc_get_option('dexcv_background', CPABC_TDEAPP_DEFAULT_dexcv_background)); ?>" onblur="generateCaptcha();" /></td>
         <th scope="row">Border:</th>
         <td><input type="text" name="dexcv_border" size="10" value="<?php echo esc_attr(cpabc_get_option('dexcv_border', CPABC_TDEAPP_DEFAULT_dexcv_border)); ?>" onblur="generateCaptcha();" /></td>        
        </tr>    
        
        <tr valign="top">
         <th scope="row">Font:</th>
         <td>
            <select name="dexcv_font" onchange="generateCaptcha();" >
              <option value="font-1.ttf"<?php if ("font-1.ttf" == cpabc_get_option('dexcv_font', CPABC_TDEAPP_DEFAULT_dexcv_font)) echo " selected"; ?>>Font 1</option>
              <option value="font-2.ttf"<?php if ("font-2.ttf" == cpabc_get_option('dexcv_font', CPABC_TDEAPP_DEFAULT_dexcv_font)) echo " selected"; ?>>Font 2</option>
              <option value="font-3.ttf"<?php if ("font-3.ttf" == cpabc_get_option('dexcv_font', CPABC_TDEAPP_DEFAULT_dexcv_font)) echo " selected"; ?>>Font 3</option>
              <option value="font-4.ttf"<?php if ("font-4.ttf" == cpabc_get_option('dexcv_font', CPABC_TDEAPP_DEFAULT_dexcv_font)) echo " selected"; ?>>Font 4</option>
            </select>            
         </td>              
        </tr>                          
           
        
     </table>  
  </div>    
 </div>     
 
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Email Reminder Settings  - Available only in Pro version</span></h3>
  <div class="inside">  
     <table class="form-table">    
        <tr valign="top">
        <th scope="row">Enable e-mail reminder?</th>
        <td><input type="checkbox" name="enable_reminder" disabled readonly size="40" value="1" <?php if (cpabc_get_option('enable_reminder',CPABC_APPOINTMENTS_DEFAULT_ENABLE_REMINDER)) echo 'checked'; ?> /> * This feature is available in the <a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar#download">pro version</a>.</td>
        </tr>              
        <tr valign="top">
        <th scope="row">Send reminder:</th>        
        <td><input type="text" name="reminder_hours"  disabled readonly size="2" value="<?php echo esc_attr(cpabc_get_option('reminder_hours', CPABC_APPOINTMENTS_DEFAULT_REMINDER_HOURS)); ?>" /> hours before the appointment        
        <br /><em>Note: Hours date based in server time. Server time now is <?php echo date("Y-m-d H:i"); ?></em>
        </td>
        </tr>
        <tr valign="top">
        <th scope="row">Remainder email subject</th>
        <td><input type="text" name="reminder_subject"  disabled readonly size="70" value="<?php echo esc_attr(cpabc_get_option('reminder_subject', CPABC_APPOINTMENTS_DEFAULT_REMINDER_SUBJECT)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email format?</th>
        <td>
          <?php $option = cpabc_get_option('nremind_emailformat', CPABC_APPOINTMENTS_DEFAULT_email_format); ?>
          <select name="nremind_emailformat">
           <option value="text"<?php if ($option != 'html') echo ' selected'; ?>>Plain Text (default)</option>
           <option value="html"<?php if ($option == 'html') echo ' selected'; ?>>HTML (use html in the textarea below)</option>
          </select>
        </td>
        </tr>          
        <tr valign="top">
        <th scope="row">Remainder email message</th>
        <td><textarea cols="70" rows="3"  disabled readonly name="reminder_content"><?php echo cpabc_get_option('reminder_content', CPABC_APPOINTMENTS_DEFAULT_REMINDER_CONTENT); ?></textarea></td>
        </tr>                                                
     </table>
  </div>
</div>  

 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Custom Settings - Available only in Pro version</span></h3>
  <div class="inside">
     <table class="form-table">    
        <tr valign="top">
        <th scope="row">Options (drop-down select, one item per line with format: <span style="color:#ff0000">price | title</span>)<br />                
        <ul>Sample Format:</ul>
        <?php echo str_replace("\n", "<br />", CPABC_APPOINTMENTS_DEFAULT_EXPLAIN_CP_CAL_CHECKBOXES); ?>
        </th>
        <td>
            <em>This feature is available only in the <a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar#download">pro version</a>.</em>
        </td>
        </tr>             
     </table>  
  </div>    
 </div>    
 
<?php if (!defined('CPABC_CALENDAR_ON_PUBLIC_WEBSITE')) { ?> 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Note</span></h3>
  <div class="inside">
   To insert the calendar booking form in a post/page, use the dedicated icon 
   <?php print '<img hspace="5" src="'.plugins_url('/images/cpabc_apps.gif', __FILE__).'" alt="'.__('Insert Appointment Booking Calendar','cpabc').'" />';     ?>
   which has been added to your Upload/Insert Menu, just below the title of your Post/Page.
   <br /><br />
  </div>
</div>   
<?php } ?>
  
</div> 


<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"  /></p>

<?php if (!defined('CPABC_CALENDAR_ON_PUBLIC_WEBSITE')) { ?> 
[<a href="http://wordpress.dwbooster.com/support?product=appointment-booking-calendar&ref=dashboard" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar" target="_blank">Help</a>]
<?php } ?>

</form>
</div>
<script type="text/javascript">
 function generateCaptcha()
 {            
    var d=new Date();
    var f = document.dexconfigofrm;    
    var qs = "?width="+f.dexcv_width.value;
    qs += "&height="+f.dexcv_height.value;
    qs += "&letter_count="+f.dexcv_chars.value;
    qs += "&min_size="+f.dexcv_min_font_size.value;
    qs += "&max_size="+f.dexcv_max_font_size.value;
    qs += "&noise="+f.dexcv_noise.value;
    qs += "&noiselength="+f.dexcv_noise_length.value;
    qs += "&bcolor="+f.dexcv_background.value;
    qs += "&border="+f.dexcv_border.value;
    qs += "&font="+f.dexcv_font.options[f.dexcv_font.selectedIndex].value;
    qs += "&rand="+d;
         
    document.getElementById("captchaimg").src= "<?php echo cpabc_appointment_get_site_url(true); ?>/?cpabc_app=captcha&inAdmin=1&"+qs;
 }       
         
 generateCaptcha();
         
 var $j = jQuery.noConflict();
 $j(function() {
 	$j("#cpabc_dc_expires").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 }); 	
 });
 $j('#cpabc_nocodes_availmsg').load('<?php echo cpabc_appointment_get_site_url(true); ?>/?cpabc_app=cpabc_loadcoupons&inAdmin=1&cpabc_item=<?php echo CP_CALENDAR_ID; ?>');
 $j('#cpabc_dc_subccode').click (function() {
                               var code = $j('#cpabc_dc_code').val();
                               var discount = $j('#cpabc_dc_discount').val();
                               var expires = $j('#cpabc_dc_expires').val();
                               if (code == '') { alert('Please enter a code'); return; }
                               if (parseInt(discount)+"" != discount) { alert('Please numeric discount percent'); return; }
                               if (expires == '') { alert('Please enter an expiration date for the code'); return; }
                               var params = '&add=1&expires='+encodeURI(expires)+'&discount='+encodeURI(discount)+'&code='+encodeURI(code);
                               $j('#cpabc_nocodes_availmsg').load('<?php echo cpabc_appointment_get_site_url(true); ?>/?cpabc_app=cpabc_loadcoupons&inAdmin=1&cpabc_item=<?php echo CP_CALENDAR_ID; ?>'+params);
                               $j('#cpabc_dc_code').val();
                             });
                             
  function cpabc_delete_coupon(id)                             
  {
     $j('#cpabc_nocodes_availmsg').load('<?php echo cpabc_appointment_get_site_url(true); ?>/?cpabc_app=cpabc_loadcoupons&inAdmin=1&cpabc_item=<?php echo CP_CALENDAR_ID; ?>&delete=1&code='+id);
  }
  
  function cpabc_updatemaxslots()
  {
      try
      {
          var default_request_cost = new Array(<?php echo $request_costs_exploded; ?>);
          var f = document.dexconfigofrm;  
          var slots = f.max_slots.options[f.max_slots.selectedIndex].value;  
          var buffer = "";
          for(var i=1; i<=slots; i++)
              buffer += '<div id="cpabccost'+i+'" style="float:left;width:70px;font-size:10px;">'+i+' slot'+(i>1?'s':'')+':<br />'+
                         '<input type="text" name="request_cost_'+i+'" style="width:40px;" value="'+default_request_cost[i-1]+'" /></div>';
          document.getElementById("cpabcslots").innerHTML = buffer;
      }
      catch(e)
      {
      }
  }
  cpabc_updatemaxslots();
         
</script>



<?php } else { ?>
  <br /> 
  The current user logged in doesn't have enough permissions to edit this calendar. This user can edit only his/her own calendars. Please log in as administrator to get access to all calendars.

<?php } ?>