<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

$current_user = wp_get_current_user();

global $wpdb;
$message = "";
if (isset($_GET['u']) && $_GET['u'] != '')
{
    $wpdb->query('UPDATE `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` SET conwer='.intval($_GET["owner"]).',`'.CPABC_TDEAPP_CONFIG_USER.'`="'.$_GET["name"].'" WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.intval($_GET['u']));           
    $message = "Item updated";        
}
else if (isset($_GET['ac']) && $_GET['ac'] == 'st')
{   
    update_option( 'CPABC_CAL_TIME_ZONE_MODIFY_SET', $_GET["ict"] );
    update_option( 'CPABC_CAL_TIME_SLOT_SIZE_SET', $_GET["ics"] );
    
    update_option( 'CPABC_APPOINTMENTS_LOAD_SCRIPTS', ($_GET["scr"]=="1"?"1":"2") );   
    update_option( 'CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR', "1" );
    if ($_GET["chs"] != '')
    {
        $target_charset = esc_sql($_GET["chs"]);
        $tables = array( $wpdb->prefix.CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX, $wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX
                         , $wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME_NO_PREFIX, $wpdb->prefix.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX );                
        foreach ($tables as $tab)
        {  
            $myrows = $wpdb->get_results( "DESCRIBE {$tab}" );                                                                                 
            foreach ($myrows as $item)
	        {
	            $name = $item->Field;
		        $type = $item->Type;
		        if (preg_match("/^varchar\((\d+)\)$/i", $type, $mat) || !strcasecmp($type, "CHAR") || !strcasecmp($type, "TEXT") || !strcasecmp($type, "MEDIUMTEXT"))
		        {
	                $wpdb->query("ALTER TABLE {$tab} CHANGE {$name} {$name} {$type} COLLATE {$target_charset}");	            
	            }
	        }
        }
    }
    $message = "Troubleshoot settings updated";
}


if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>
<div class="wrap">
<h2>Appointment Booking Calendar</h2>

<script type="text/javascript">
 function cp_addItem()
 {
    var calname = document.getElementById("cp_itemname").value;
    document.location = 'admin.php?page=cpabc_appointments&a=1&r='+Math.random()+'&name='+encodeURIComponent(calname);       
 }
 
 function cp_updateItem(id)
 {
    var calname = document.getElementById("calname_"+id).value;
    var owner = document.getElementById("calowner_"+id).options[document.getElementById("calowner_"+id).options.selectedIndex].value;    
    if (owner == '')
        owner = 0;
    document.location = 'admin.php?page=cpabc_appointments&u='+id+'&r='+Math.random()+'&owner='+owner+'&name='+encodeURIComponent(calname);    
 }
 
 function cp_manageSettings(id)
 {
    document.location = 'admin.php?page=cpabc_appointments&cal='+id+'&r='+Math.random();
 }
 
 function cp_cloneItem(id)
 {
    document.location = 'admin.php?page=cpabc_appointments&c='+id+'&r='+Math.random();  
 }  
 
 function cp_BookingsList(id)
 {
    document.location = 'admin.php?page=cpabc_appointments&cal='+id+'&list=1&r='+Math.random();
 }
 
 function cp_deleteItem(id)
 {
    if (confirm('Are you sure that you want to delete this item?'))
    {        
        document.location = 'admin.php?page=cpabc_appointments&d='+id+'&r='+Math.random();
    }
 }
 
 function cp_updateConfig()
 {
    if (confirm('Are you sure that you want to update these settings?'))
    {        
        var scr = document.getElementById("ccscriptload").value;    
        var chs = document.getElementById("cccharsets").value;    
        var ccf = document.getElementById("ccformrender").value; 
        var ict = document.getElementById("icaltimediff").value; 
        var ics = document.getElementById("icaltimeslotsize").value; 
        document.location = 'admin.php?page=cpabc_appointments&ac=st&scr='+scr+'&chs='+chs+'&ccf='+ccf+'&ict='+ict+'&ics='+ics+'&r='+Math.random();
    }    
 } 
 
</script>


<div id="normal-sortables" class="meta-box-sortables">


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar List / Items List</span></h3>
  <div class="inside">
  
  
  <table cellspacing="2"> 
   <tr>
    <th align="left">ID</th><th align="left">Calendar Name</th><th align="left">Owner</th><th align="left">iCal Link</th><th align="left">&nbsp; &nbsp; Options</th><th align="left">Shortcode</th>    
   </tr> 
<?php  

  $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." ORDER BY ID DESC" );                                                                     

  $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME );                                                                     
  foreach ($myrows as $item)   
      if (cpabc_appointment_is_administrator() || ($current_user->ID == $item->conwer))
      {
?>
   <tr> 
    <td nowrap><?php echo $item->id; ?></td>
    <td nowrap><input type="text" <?php if (!cpabc_appointment_is_administrator()) echo ' readonly '; ?>name="calname_<?php echo $item->id; ?>" id="calname_<?php echo $item->id; ?>" value="<?php echo esc_attr($item->uname); ?>" /></td>
    
    <?php if (cpabc_appointment_is_administrator()) { ?>
    <td nowrap>
      <select name="calowner_<?php echo $item->id; ?>" id="calowner_<?php echo $item->id; ?>">
       <option value="0"<?php if (!$item->conwer) echo ' selected'; ?>></option>
       <?php foreach ($users as $user) { 
       ?>
          <option value="<?php echo $user->ID; ?>"<?php if ($user->ID."" == $item->conwer) echo ' selected'; ?>><?php echo $user->user_login; ?></option>
       <?php  } ?>
      </select>
    </td>    
    <?php } else { ?>
        <td nowrap>
        <?php echo $current_user->user_login; ?>
        </td>
    <?php }  ?>
       
    <td nowrap><a href="<?php get_site_url(); ?>?cpabc_app=calfeed&id=<?php echo $item->id; ?>&verify=<?php echo substr(md5($item->id.$_SERVER["DOCUMENT_ROOT"]),0,10); ?>">iCal Feed</a></td>
    <td nowrap>&nbsp; &nbsp; 
                             <?php if (cpabc_appointment_is_administrator()) { ?> 
                               <input style="font-size:11px;" type="button" name="calupdate_<?php echo $item->id; ?>" value="Update" onclick="cp_updateItem(<?php echo $item->id; ?>);" /> &nbsp; 
                             <?php } ?>    
                             <input style="font-size:11px;" type="button" name="calmanage_<?php echo $item->id; ?>" value="Manage Settings" onclick="cp_manageSettings(<?php echo $item->id; ?>);" /> &nbsp; 
                             <input style="font-size:11px;" type="button" name="calbookings_<?php echo $item->id; ?>" value="Bookings List" onclick="cp_BookingsList(<?php echo $item->id; ?>);" /> &nbsp;  
    </td>
     <td nowrap style="font-size:10px;">[CPABC_APPOINTMENT_CALENDAR calendar="<?php echo $item->id; ?>"]</td>
   </tr>
<?php  
      } 
?>   
     
  </table> 
    
    
   
  </div>    
 </div> 
 
<?php if (cpabc_appointment_is_administrator()) { ?> 
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>New Calendar / Item</span></h3>
  <div class="inside"> 
   
       This version supports one calendar.

  </div>    
 </div>



 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Form Builder Settings & Troubleshoot Area</span></h3>
  <div class="inside"> 
    <p><strong>Important!</strong>: Use this area <strong>only</strong> if you want to activate the form builder or if you are experiencing conflicts with third party plugins, with the theme scripts or with the character encoding.</p>
    <form name="updatesettings">
    
      Form rendering:<br />
       <select id="ccformrender" name="ccformrender">
        <option value="1" selected>Use classic predefined form</option>        
       </select><br />
       <em>* The <strong>Visual Form Builder</strong> is available only in the <a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar#download">pro version</a>. To edit the form in this basic version you should manually edit the file 'cpabc_scheduler.inc.php'.</em>
      
      <br /><br />
          
    
      Script load method:<br />
       <select id="ccscriptload" name="ccscriptload">
        <option value="1" <?php if (get_option('CPABC_APPOINTMENTS_LOAD_SCRIPTS',"1") == "1") echo 'selected'; ?>>Classic (Recommended)</option>
        <option value="2" <?php if (get_option('CPABC_APPOINTMENTS_LOAD_SCRIPTS',"1") != "1") echo 'selected'; ?>>Direct</option>
       </select><br />
       <em>* Change the script load method if the form doesn't appear in the public website.</em>
      
      <br /><br />
      Character encoding:<br />
       <select id="cccharsets" name="cccharsets">
        <option value="">Keep current charset (Recommended)</option>
        <option value="utf8_general_ci">UTF-8 (try this first)</option>
        <option value="latin1_swedish_ci">latin1_swedish_ci</option>
       </select><br />
       <em>* Update the charset if you are getting problems displaying special/non-latin characters. After updated you need to edit the special characters again.</em>
             
       <br /><br />
       iCal timezone difference vs server time:<br />
       <select id="icaltimediff" name="icaltimediff">
        <?php for ($i=-23;$i<24; $i++) { ?>        
        <option value="<?php $text = " ".($i<0?"":"+").$i." hours"; echo urlencode($text); ?>" <?php if (get_option('CPABC_CAL_TIME_ZONE_MODIFY_SET'," +2 hours") == $text) echo ' selected'; ?>><?php echo $text; ?></option>
        <?php } ?>
       </select><br />
       <em>* Update this, if needed, to match the desired timezone. The difference is calculated referred to the server time.</em>
       
       <br /><br />
       iCal timeslot size in minutes:<br />
        <input type="text" size="2" name="icaltimeslotsize" id="icaltimeslotsize" value="<?php echo get_option('CPABC_CAL_TIME_SLOT_SIZE_SET',"15"); ?>" /> minutes
        <br />
       <em>* Update this, if needed, to have a specific slot time in the exported iCal file.</em>
      
        <br /><br />         
       <input type="button" onclick="cp_updateConfig();" name="gobtn" value="UPDATE" />
      <br /><br />      
    </form>

  </div>    
 </div> 

  
<?php } ?>  
  
</div> 


[<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar" target="_blank">Help</a>]
</form>
</div>