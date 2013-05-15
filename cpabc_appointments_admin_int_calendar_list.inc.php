<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

$current_user = wp_get_current_user();

global $wpdb;
$message = "";
if (isset($_GET['a']) && $_GET['a'] == '1')
{
    $sql .= 'INSERT INTO `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` (conwer,`'.CPABC_TDEAPP_CONFIG_TITLE.'`,`'.CPABC_TDEAPP_CONFIG_USER.'`,`'.CPABC_TDEAPP_CONFIG_PASS.'`,`'.CPABC_TDEAPP_CONFIG_LANG.'`,`'.CPABC_TDEAPP_CONFIG_CPAGES.'`,`'.CPABC_TDEAPP_CONFIG_TYPE.'`,`'.CPABC_TDEAPP_CONFIG_MSG.'`,`'.CPABC_TDEAPP_CONFIG_WORKINGDATES.'`,`'.CPABC_TDEAPP_CONFIG_RESTRICTEDDATES.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6.'`,`'.CPABC_TDEAPP_CALDELETED_FIELD.'`) '.
            ' VALUES(0,"","'.$_GET["name"].'","","ENG","1","3","Please, select your appointment.","1,2,3,4,5","","","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","","0");';
            
    $wpdb->query($sql);       
    $results = $wpdb->get_results('SELECT `'.CPABC_TDEAPP_CONFIG_ID.'` FROM `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` ORDER BY `'.CPABC_TDEAPP_CONFIG_ID.'` DESC LIMIT 0,1');        
    $wpdb->query('UPDATE `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` SET `'.CPABC_TDEAPP_CONFIG_TITLE.'`="cal'.$results[0]->id.'" WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.$results[0]->id);           
    $message = "Item added";
} 
else if (isset($_GET['u']) && $_GET['u'] != '')
{
    $wpdb->query('UPDATE `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` SET conwer='.$_GET["owner"].',`'.CPABC_TDEAPP_CALDELETED_FIELD.'`='.$_GET["public"].',`'.CPABC_TDEAPP_CONFIG_USER.'`="'.$_GET["name"].'" WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.$_GET['u']);           
    $message = "Item updated";        
}
else if (isset($_GET['d']) && $_GET['d'] != '')
{
    $wpdb->query('DELETE FROM `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.$_GET['d']);       
    $message = "Item deleted";
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
    var is_public = (document.getElementById("calpublic_"+id).checked?"0":"1");
    document.location = 'admin.php?page=cpabc_appointments&u='+id+'&r='+Math.random()+'&public='+is_public+'&owner='+owner+'&name='+encodeURIComponent(calname);    
 }
 
 function cp_manageSettings(id)
 {
    document.location = 'admin.php?page=cpabc_appointments&cal='+id+'&r='+Math.random();
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
 
</script>


<div id="normal-sortables" class="meta-box-sortables">


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar List / Items List</span></h3>
  <div class="inside">
  
  
  <table cellspacing="10"> 
   <tr>
    <th align="left">ID</th><th align="left">Calendar Name</th><th align="left">Owner</th><th align="left">&nbsp; &nbsp; Published?</th><th align="left">iCal Link</th><th align="left">&nbsp; &nbsp; Options</th>
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
    <?php } ?>
    
    <td nowrap align="center">
       <?php if (cpabc_appointment_is_administrator()) { ?> 
         &nbsp; &nbsp; <input type="checkbox" name="calpublic_<?php echo $item->id; ?>" id="calpublic_<?php echo $item->id; ?>" value="1" <?php if (!$item->caldeleted) echo " checked "; ?> />
       <?php } else { ?>  
         <?php if (!$item->caldeleted) echo "Yes"; else echo "No"; ?> 
       <?php } ?>   
    </td>
    <td nowrap><a href="<?php get_site_url(); ?>?cpabc_app=calfeed&id=<?php echo $item->id; ?>">iCal Feed</a></td>
    <td nowrap>&nbsp; &nbsp; 
                             <?php if (cpabc_appointment_is_administrator()) { ?> 
                               <input type="button" name="calupdate_<?php echo $item->id; ?>" value="Update" onclick="cp_updateItem(<?php echo $item->id; ?>);" /> &nbsp; 
                             <?php } ?>    
                             <input type="button" name="calmanage_<?php echo $item->id; ?>" value="Manage Settings" onclick="cp_manageSettings(<?php echo $item->id; ?>);" /> &nbsp; 
                             <input type="button" name="calbookings_<?php echo $item->id; ?>" value="Bookings List" onclick="cp_BookingsList(<?php echo $item->id; ?>);" /> &nbsp; 
    </td>
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

<?php } ?> 

  
</div> 


[<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar" target="_blank">Help</a>]
</form>
</div>














