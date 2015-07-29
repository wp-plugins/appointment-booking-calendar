<?php

if ( !is_admin() )
{
    echo 'Direct access not allowed.';
    exit;
}

if (!defined('CP_CALENDAR_ID'))
    define ('CP_CALENDAR_ID',intval($_GET["cal"]));

global $wpdb;

$message = "";

$records_per_page = 50;                                                                                  


if (isset($_GET['delmark']) && $_GET['delmark'] != '')
{
    for ($i=0; $i<=$records_per_page; $i++)
    if (isset($_GET['c'.$i]) && $_GET['c'.$i] != '')   
        $wpdb->query('DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` WHERE id='.intval($_GET['c'.$i]));       
    $message = "Marked items deleted";
}
else if (isset($_GET['ld']) && $_GET['ld'] != '')
{
    $wpdb->query('DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` WHERE id='.intval($_GET['ld']));       
    $message = "Item deleted";
} 
else if (isset($_GET['del']) && $_GET['del'] == 'all')
{    
    $wpdb->query('DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` WHERE appointment_calendar_id='.CP_CALENDAR_ID);           
    $message = "All items deleted";
}


$mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME .' WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.CP_CALENDAR_ID);

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['cpabc_appointments_post_options'] ) )
    echo "<div id='setting-error-settings_updated' class='updated settings-error'> <p><strong>Settings saved.</strong></p></div>";

$current_user = wp_get_current_user();

if (cpabc_appointment_is_administrator() || $mycalendarrows[0]->conwer == $current_user->ID) {

$current_page = intval($_GET["p"]);
if (!$current_page) $current_page = 1;

$cond = '';
if ($_GET["search"] != '') $cond .= " AND (title like '%".esc_sql($_GET["search"])."%' OR description LIKE '%".esc_sql($_GET["search"])."%')";
if ($_GET["dfrom"] != '') $cond .= " AND (datatime >= '".esc_sql($_GET["dfrom"])."')";
if ($_GET["dto"] != '') $cond .= " AND (datatime <= '".esc_sql($_GET["dto"])." 23:59:59')";


$events = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME." WHERE appointment_calendar_id=".CP_CALENDAR_ID.$cond." ORDER BY datatime DESC" );
$total_pages = ceil(count($events) / $records_per_page);

if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>
<script type="text/javascript">
 function cp_deleteMessageItem(id)
 {
    if (confirm('Are you sure that you want to delete this item?'))
    {        
        document.location = 'admin.php?page=cpabc_appointments&cal=<?php echo $_GET["cal"]; ?>&list=1&ld='+id+'&r='+Math.random();
    }
 }
 function do_dexapp_deleteall()
 {
    if (confirm('Are you sure that you want to delete ALL bookings for this calendar?'))
    {        
        document.location = 'admin.php?page=cpabc_appointments&cal=<?php echo $_GET["cal"]; ?>&list=1&del=all&r='+Math.random();
    }    
 }
</script>
<div class="wrap">
<h2>Appointment Booking Calendar - Bookings List</h2>

<input type="button" name="backbtn" value="Back to items list..." onclick="document.location='admin.php?page=cpabc_appointments';">


<div id="normal-sortables" class="meta-box-sortables">
 <hr />
 <h3>This booking list applies only to: <?php echo $mycalendarrows[0]->uname; ?></h3>
</div>


<form action="admin.php" method="get">
 <input type="hidden" name="page" value="cpabc_appointments" />
 <input type="hidden" name="cal" value="<?php echo CP_CALENDAR_ID; ?>" />
 <input type="hidden" name="list" value="1" />
 Search for: <input type="text" name="search" value="<?php echo esc_attr($_GET["search"]); ?>" /> &nbsp; &nbsp; &nbsp; 
 From: <input type="text" id="dfrom" name="dfrom" value="<?php echo esc_attr($_GET["dfrom"]); ?>" /> &nbsp; &nbsp; &nbsp; 
 To: <input type="text" id="dto" name="dto" value="<?php echo esc_attr($_GET["dto"]); ?>" /> &nbsp; &nbsp; &nbsp;  
<nobr><span class="submit"><input type="submit" name="ds" value="Filter" /></span> &nbsp; &nbsp; &nbsp; 
 <span class="submit"><input type="submit" name="cpabc_appointments_csv" value="Export to CSV" /></span></nobr>
  
</form>

<br />
                             
<?php


echo paginate_links(  array(
    'base'         => 'admin.php?page=cpabc_appointments&cal='.CP_CALENDAR_ID.'&list=1%_%&dfrom='.urlencode($_GET["dfrom"]).'&dto='.urlencode($_GET["dto"]).'&search='.urlencode($_GET["search"]),
    'format'       => '&p=%#%',
    'total'        => $total_pages,
    'current'      => $current_page,
    'show_all'     => False,
    'end_size'     => 1,
    'mid_size'     => 2,
    'prev_next'    => True,
    'prev_text'    => '&laquo; '.__('Previous','cpabc'),
    'next_text'    => __('Next','cpabc').' &raquo;',
    'type'         => 'plain',
    'add_args'     => False
    ) );

?>

<div id="cpabc_printable_contents">
<form name="dex_table_form" id="dex_table_form" action="admin.php" method="get">
 <input type="hidden" name="page" value="cpabc_appointments" />
 <input type="hidden" name="cal" value="<?php echo $_GET["cal"]; ?>" />
 <input type="hidden" name="list" value="1" />
 <input type="hidden" name="delmark" value="1" />
<table class="wp-list-table widefat fixed pages" cellspacing="0">
	<thead>
	<tr>
	  <th width="30"></th>
	  <th style="padding-left:7px;font-weight:bold;">Date</th>
	  <th style="padding-left:7px;font-weight:bold;">Title</th>
	  <th style="padding-left:7px;font-weight:bold;">Description</th>
	  <th style="padding-left:7px;font-weight:bold;">Quantity</th>
	  <th style="padding-left:7px;font-weight:bold;">Options</th>
	</tr>
	</thead>
	<tbody id="the-list">
	 <?php for ($i=($current_page-1)*$records_per_page; $i<$current_page*$records_per_page; $i++) if (isset($events[$i])) { ?>
	  <tr class='<?php if (!($i%2)) { ?>alternate <?php } ?>author-self status-draft format-default iedit' valign="top">
	    <td width="1%"><input type="checkbox" name="c<?php echo $i-($current_page-1)*$records_per_page; ?>" value="<?php echo $events[$i]->id; ?>" /></td>
		<td><?php echo substr($events[$i]->datatime,0,16); ?></td>
		<td><?php echo str_replace('<','&lt;',$events[$i]->title); ?></td>
		<td><?php echo str_replace('--br />','<br />',str_replace('<','&lt;',str_replace('<br />','--br />',$events[$i]->description))); ?></td>
		<td><?php echo $events[$i]->quantity; ?></td>
		<td>
		  <input type="button" name="caldelete_<?php echo $events[$i]->id; ?>" value="Delete" onclick="cp_deleteMessageItem(<?php echo $events[$i]->id; ?>);" />                             
		</td>		
      </tr>
     <?php } ?>
	</tbody>
</table>
</form>
</div>

<br /><input type="button" name="pbutton" value="Print" onclick="do_dexapp_print();" />
<div style="clear:both"></div>
<p class="submit" style="float:left;"><input type="button" name="pbutton" value="Delete marked items" onclick="do_dexapp_deletemarked();" /> &nbsp; &nbsp; &nbsp; </p>

<p class="submit" style="float:left;"><input type="button" name="pbutton" value="Delete All Bookings" onclick="do_dexapp_deleteall();" /></p>


</div>


<script type="text/javascript">
 function do_dexapp_print()
 {
      w=window.open();
      w.document.write("<style>table{border:2px solid black;width:100%;}th{border-bottom:2px solid black;text-align:left}td{padding-left:10px;border-bottom:1px solid black;}</style>"+document.getElementById('cpabc_printable_contents').innerHTML);
      w.print();     
 }
 function do_dexapp_deletemarked()
 {
    document.dex_table_form.submit();
 }  
 var $j = jQuery.noConflict();
 $j(function() {
 	$j("#dfrom").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 });
 	$j("#dto").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 });
 });
 
</script>




<?php } else { ?>
  <br />
  The current user logged in doesn't have enough permissions to edit this calendar. This user can edit only his/her own calendars. Please log in as administrator to get access to all calendars.

<?php } ?>











