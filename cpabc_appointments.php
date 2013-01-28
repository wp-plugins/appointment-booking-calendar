<?php
/*
Plugin Name: Appointment Booking Calendar
Plugin URI: http://wordpress.dwbooster.com/calendars/appointment-booking-calendar
Description: This plugin allows you to easily insert appointments forms into your WP website.
Version: 1.01
Author: CodePeople.net
Author URI: http://codepeople.net
License: GPL
*/


/* initialization / install / uninstall functions */


define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_LANGUAGE', 'EN');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT', '0');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME', '1');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_WEEKDAY', '0');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MINDATE', 'today');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MAXDATE', '');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_PAGES', 3);

define('CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL', 1);
define('CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL','put_your@email_here.com');
define('CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME','Consultation');
define('CPABC_APPOINTMENTS_DEFAULT_COST','25');
define('CPABC_APPOINTMENTS_DEFAULT_OK_URL',get_site_url());
define('CPABC_APPOINTMENTS_DEFAULT_CANCEL_URL',get_site_url());
define('CPABC_APPOINTMENTS_DEFAULT_CURRENCY','USD');
define('CPABC_APPOINTMENTS_DEFAULT_PAYPAL_LANGUAGE','EN');

define('CPABC_APPOINTMENTS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL', 'Thank you for your request...');
define('CPABC_APPOINTMENTS_DEFAULT_CONFIRMATION_EMAIL', "We have received your request with the following information:\n\n%INFORMATION%\n\nThank you.\n\nBest regards.");
define('CPABC_APPOINTMENTS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL','New appointment requested...');
define('CPABC_APPOINTMENTS_DEFAULT_NOTIFICATION_EMAIL', "New appointment made with the following information:\n\n%INFORMATION%\n\nBest regards.");

define('CPABC_APPOINTMENTS_DEFAULT_CP_CAL_CHECKBOXES',"");
define('CPABC_APPOINTMENTS_DEFAULT_EXPLAIN_CP_CAL_CHECKBOXES',"1.00 | Service 1 for us$1.00\n5.00 | Service 2 for us$5.00\n10.00 | Service 3 for us$10.00");


// tables

define('CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX', "cpabc_appointments");
define('CPABC_APPOINTMENTS_TABLE_NAME', $wpdb->prefix . CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX);

define('CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX', "cpabc_appointment_calendars_data");
define('CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME', $wpdb->prefix ."cpabc_appointment_calendars_data");

define('CPABC_APPOINTMENTS_CONFIG_TABLE_NAME_NO_PREFIX', "cpabc_appointment_calendars");
define('CPABC_APPOINTMENTS_CONFIG_TABLE_NAME', $wpdb->prefix ."cpabc_appointment_calendars");

define('CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX', "cpabc_appointments_discount_codes");
define('CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME', $wpdb->prefix ."cpabc_appointments_discount_codes");

// calendar constants

define("CPABC_TDEAPP_DEFAULT_CALENDAR_ID","1");
define("CPABC_TDEAPP_DEFAULT_CALENDAR_LANGUAGE","EN");

define("CPABC_TDEAPP_CAL_PREFIX", "cal");
define("CPABC_TDEAPP_CONFIG",CPABC_APPOINTMENTS_CONFIG_TABLE_NAME);
define("CPABC_TDEAPP_CONFIG_ID","id");
define("CPABC_TDEAPP_CONFIG_TITLE","title");
define("CPABC_TDEAPP_CONFIG_USER","uname");
define("CPABC_TDEAPP_CONFIG_PASS","passwd");
define("CPABC_TDEAPP_CONFIG_LANG","lang");
define("CPABC_TDEAPP_CONFIG_CPAGES","cpages");
define("CPABC_TDEAPP_CONFIG_TYPE","ctype");
define("CPABC_TDEAPP_CONFIG_MSG","msg");
define("CPABC_TDEAPP_CONFIG_WORKINGDATES","workingDates");
define("CPABC_TDEAPP_CONFIG_RESTRICTEDDATES","restrictedDates");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0","timeWorkingDates0");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1","timeWorkingDates1");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2","timeWorkingDates2");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3","timeWorkingDates3");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4","timeWorkingDates4");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5","timeWorkingDates5");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6","timeWorkingDates6");
define("CPABC_TDEAPP_CALDELETED_FIELD","caldeleted");

define("CPABC_TDEAPP_CALENDAR_DATA_TABLE",CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME);
define("CPABC_TDEAPP_DATA_ID","id");
define("CPABC_TDEAPP_DATA_IDCALENDAR","appointment_calendar_id");
define("CPABC_TDEAPP_DATA_DATETIME","datatime");
define("CPABC_TDEAPP_DATA_TITLE","title");
define("CPABC_TDEAPP_DATA_DESCRIPTION","description");
// end calendar constants

define('CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha', 'true');
define('CPABC_TDEAPP_DEFAULT_dexcv_width', '180');
define('CPABC_TDEAPP_DEFAULT_dexcv_height', '60');
define('CPABC_TDEAPP_DEFAULT_dexcv_chars', '5');
define('CPABC_TDEAPP_DEFAULT_dexcv_font', 'font-1.ttf');
define('CPABC_TDEAPP_DEFAULT_dexcv_min_font_size', '25');
define('CPABC_TDEAPP_DEFAULT_dexcv_max_font_size', '35');
define('CPABC_TDEAPP_DEFAULT_dexcv_noise', '200');
define('CPABC_TDEAPP_DEFAULT_dexcv_noise_length', '4');
define('CPABC_TDEAPP_DEFAULT_dexcv_background', 'ffffff');
define('CPABC_TDEAPP_DEFAULT_dexcv_border', '000000');
define('CPABC_TDEAPP_DEFAULT_dexcv_text_enter_valid_captcha', 'Please enter a valid captcha code.');




register_activation_hook(__FILE__,'cpabc_appointments_install');
register_deactivation_hook( __FILE__, 'cpabc_appointments_remove' );

function cpabc_appointments_install($networkwide)  {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
	                $old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				_cpabc_appointments_install();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	_cpabc_appointments_install();
}

function _cpabc_appointments_install() {
    global $wpdb;


    $table_name = $wpdb->prefix . CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX;

    $sql = "DROP TABLE IF EXISTS".$table_name.";";
    $wpdb->query($sql);
    $sql = "DROP TABLE IF EXISTS".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.";";
    $wpdb->query($sql);
    $sql = "DROP TABLE IF EXISTS".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.";";
    $wpdb->query($sql);
    $sql = "DROP TABLE IF EXISTS".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.";";
    $wpdb->query($sql);
    
    $sql = "CREATE TABLE ".$wpdb->prefix.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX." (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         cal_id mediumint(9) NOT NULL DEFAULT 1,
         code VARCHAR(250) DEFAULT '' NOT NULL,
         discount VARCHAR(250) DEFAULT '' NOT NULL,
         expires datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,       
         availability int(10) unsigned NOT NULL DEFAULT 0,
         used int(10) unsigned NOT NULL DEFAULT 0,
         UNIQUE KEY id (id)
         );";             
    $wpdb->query($sql); 

    $sql = "CREATE TABLE $table_name (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         booked_time VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_unformatted VARCHAR(250) DEFAULT '' NOT NULL,
         name VARCHAR(250) DEFAULT '' NOT NULL,
         email VARCHAR(250) DEFAULT '' NOT NULL,
         phone VARCHAR(250) DEFAULT '' NOT NULL,
         question text DEFAULT '' NOT NULL,
         buffered_date text DEFAULT '' NOT NULL,
         UNIQUE KEY id (id)
         );";
    $wpdb->query($sql);
    $sql = "ALTER TABLE  $table_name ADD `calendar` INT NOT NULL AFTER  `id`;";
    $wpdb->query($sql);

    $sql = "CREATE TABLE `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` (`".CPABC_TDEAPP_CONFIG_ID."` int(10) unsigned NOT NULL auto_increment, `".CPABC_TDEAPP_CONFIG_TITLE."` varchar(255) NOT NULL default '',`".CPABC_TDEAPP_CONFIG_USER."` varchar(100) default NULL,`".CPABC_TDEAPP_CONFIG_PASS."` varchar(100) default NULL,`".CPABC_TDEAPP_CONFIG_LANG."` varchar(5) default NULL,`".CPABC_TDEAPP_CONFIG_CPAGES."` tinyint(3) unsigned default NULL,`".CPABC_TDEAPP_CONFIG_TYPE."` tinyint(3) unsigned default NULL,`".CPABC_TDEAPP_CONFIG_MSG."` varchar(255) NOT NULL default '',`".CPABC_TDEAPP_CONFIG_WORKINGDATES."` varchar(255) NOT NULL default '',`".CPABC_TDEAPP_CONFIG_RESTRICTEDDATES."` text default '' NOT NULL,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0."` text NOT NULL default '',`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1."` text NOT NULL default '',`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2."` text NOT NULL default '',`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3."` text NOT NULL default '',`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4."` text NOT NULL default '',`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5."` text NOT NULL default '',`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6."` text NOT NULL default '',`".CPABC_TDEAPP_CALDELETED_FIELD."` tinyint(3) unsigned default NULL,PRIMARY KEY (`".CPABC_TDEAPP_CONFIG_ID."`)); ";
    $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `conwer` INT NOT NULL AFTER  `id`;";


    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `conwer` INT NOT NULL AFTER  `id`;";     $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_language` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_dateformat` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_pages` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_militarytime` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_weekday` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_mindate` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `calendar_maxdate` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `enable_paypal` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `paypal_email` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `request_cost` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `paypal_product_name` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `currency` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `url_ok` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `url_cancel` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `paypal_language` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `notification_from_email` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `notification_destination_email` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `email_subject_confirmation_to_user` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `email_confirmation_to_user` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `email_subject_notification_to_admin` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `email_notification_to_admin` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);

    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_enable_captcha` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_width` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_height` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_chars` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_min_font_size` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_max_font_size` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_noise` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_noise_length` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_background` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_border` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `dexcv_font` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD `cp_cal_checkboxes` text DEFAULT '' NOT NULL AFTER  `timeWorkingDates6`;"; $wpdb->query($sql);
    

    $sql = "CREATE TABLE `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME."` (`".CPABC_TDEAPP_DATA_ID."` int(10) unsigned NOT NULL auto_increment,`".CPABC_TDEAPP_DATA_IDCALENDAR."` int(10) unsigned default NULL,`".CPABC_TDEAPP_DATA_DATETIME."`datetime NOT NULL default '0000-00-00 00:00:00',`".CPABC_TDEAPP_DATA_TITLE."` varchar(250) default NULL,`".CPABC_TDEAPP_DATA_DESCRIPTION."` text,PRIMARY KEY (`".CPABC_TDEAPP_DATA_ID."`)) ;";
    $wpdb->query($sql);
    $sql = 'INSERT INTO `'.$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` (`'.CPABC_TDEAPP_CONFIG_ID.'`,`'.CPABC_TDEAPP_CONFIG_TITLE.'`,`'.CPABC_TDEAPP_CONFIG_USER.'`,`'.CPABC_TDEAPP_CONFIG_PASS.'`,`'.CPABC_TDEAPP_CONFIG_LANG.'`,`'.CPABC_TDEAPP_CONFIG_CPAGES.'`,`'.CPABC_TDEAPP_CONFIG_TYPE.'`,`'.CPABC_TDEAPP_CONFIG_MSG.'`,`'.CPABC_TDEAPP_CONFIG_WORKINGDATES.'`,`'.CPABC_TDEAPP_CONFIG_RESTRICTEDDATES.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6.'`,`'.CPABC_TDEAPP_CALDELETED_FIELD.'`) VALUES("1","cal1","Calendar Item 1","","ENG","1","3","Please, select your appointment.","1,2,3,4,5","","","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","","0");';
    $wpdb->query($sql);

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    //dbDelta($sql);

    add_option("cpabc_appointments_data", 'Default', '', 'yes'); // Creates new database field
}

function cpabc_appointments_remove() {
    delete_option('cpabc_appointments_data'); // Deletes the database field
}


/* Filter for placing the maps into the contents */

add_filter('the_content','cpabc_appointments_filter_content');

function cpabc_appointments_filter_content($content) {

    global $wpdb;

    if (strpos($content, "[CPABC_APPOINTMENT_CALENDAR") !== false)
    {

        $shorttag =  "[CPABC_APPOINTMENT_CALENDAR]";
        $shorttag_sel =  "[CPABC_APPOINTMENT_CALENDAR]";
        if (strpos($content, $shorttag) !== false)
            define ('CPABC_CALENDAR_USER',0);
        else
        {
            $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->prefix."users ORDER BY ID DESC" );
            foreach ($users as $user)
            {
                $shorttag =  "[CPABC_APPOINTMENT_CALENDAR user=\"".$user->user_login."\"]";
                if (strpos($content, $shorttag) !== false)
                {
                    $shorttag_sel =  "[CPABC_APPOINTMENT_CALENDAR user=\"".$user->user_login."\"]";
                    define ('CPABC_CALENDAR_USER',$user->ID);
                }
                else
                {
                    $shorttag =  "[CPABC_APPOINTMENT_CALENDAR user=".$user->user_login."]";
                    if (strpos($content, $shorttag) !== false)
                    {
                        $shorttag_sel =  "[CPABC_APPOINTMENT_CALENDAR user=".$user->user_login."]";
                        define ('CPABC_CALENDAR_USER',$user->ID);
                    }
                }
            }

            // if no calendar tag found, try to find it by calendar id
            if (!defined('CPABC_CALENDAR_USER'))
            {
                $calendars = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME );
                foreach ($calendars as $calendar)
                {
                    $shorttag =  "[CPABC_APPOINTMENT_CALENDAR calendar=\"".$calendar->id."\"]";
                    if (strpos($content, $shorttag) !== false)
                    {
                        $shorttag_sel =  "[CPABC_APPOINTMENT_CALENDAR calendar=\"".$calendar->id."\"]";
                        define ('CPABC_CALENDAR_FIXED_ID',$calendar->id);
                    }
                    else
                    {
                        $shorttag =  "[CPABC_APPOINTMENT_CALENDAR calendar=".$calendar->id."]";
                        if (strpos($content, $shorttag) !== false)
                        {
                            $shorttag_sel =  "[CPABC_APPOINTMENT_CALENDAR calendar=".$calendar->id."]";
                            define ('CPABC_CALENDAR_FIXED_ID',$calendar->id);
                        }
                    }
                }
            }


        }

        ob_start();
        define('CPABC_AUTH_INCLUDE', true);
        @include dirname( __FILE__ ) . '/cpabc_scheduler.inc.php';
        $buffered_contents = ob_get_contents();
        ob_end_clean();

        $content = str_replace($shorttag_sel, $buffered_contents, $content);
    }
    return $content;
}


function cpabc_appointments_show_booking_form($id = "")
{
    if ($id != '')
        define ('CPABC_CALENDAR_FIXED_ID',$id);
    define('CPABC_AUTH_INCLUDE', true);
    @include dirname( __FILE__ ) . '/cpabc_scheduler.inc.php';    
}

/* Code for the admin area */

if ( is_admin() ) {
    add_action('media_buttons', 'set_cpabc_apps_insert_button', 100);
    add_action('admin_enqueue_scripts', 'set_cpabc_apps_insert_adminScripts', 1);
    add_action('admin_menu', 'cpabc_appointments_admin_menu');    

    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_".$plugin, 'cpabc_customAdjustmentsLink');
    add_filter("plugin_action_links_".$plugin, 'cpabc_settingsLink');
    add_filter("plugin_action_links_".$plugin, 'cpabc_helpLink');

    function cpabc_appointments_admin_menu() {
        add_options_page('Appointment Booking Calendar Options', 'Appointment Booking Calendar', 'manage_options', 'cpabc_appointments', 'cpabc_appointments_html_post_page' );
        add_menu_page( 'Appointment Booking Calendar Options', 'Appointment Booking Calendar', 'edit_pages', 'cpabc_appointments', 'cpabc_appointments_html_post_page' );
    }
}
else
{
    add_action('wp_enqueue_scripts', 'set_cpabc_apps_insert_publicScripts');
}

function cpabc_settingsLink($links) {
    $settings_link = '<a href="options-general.php?page=cpabc_appointments">'.__('Settings').'</a>';
	array_unshift($links, $settings_link);
	return $links;
}


function cpabc_helpLink($links) {
    $help_link = '<a href="http://wordpress.dwbooster.com/calendars/appointment-booking-calendar">'.__('Help').'</a>';
	array_unshift($links, $help_link);
	return $links;
}

function cpabc_customAdjustmentsLink($links) {
    $customAdjustments_link = '<a href="http://wordpress.dwbooster.com/contact-us">'.__('Request custom changes').'</a>';
	array_unshift($links, $customAdjustments_link);
	return $links;
}

function cpabc_appointments_html_post_page() {
    if ($_GET["cal"] != '')
    {
        if ($_GET["list"] == '1')
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int_bookings_list.inc.php';
        else
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int.inc.php';
    }
    else
        @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int_calendar_list.inc.php';
}

function set_cpabc_apps_insert_button() {    
    global $wpdb;
    $options = '';
    $calendars = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME_NO_PREFIX);     
    foreach($calendars as $item)
        $options .= '<option value="'.$item->id.'">'.$item->uname.'</option>';    
        
    wp_enqueue_style('wp-jquery-ui-dialog');
    wp_enqueue_script('jquery-ui-dialog');    
    ?>
    <script type="text/javascript">     
      var cpabc_appointments_fpanel = function($){
        var cpabc_counter = 0;
      	function loadWindow(){
      	    cpabc_counter++;
      		$(' <div title="Appointment Booking Calendar"><div style="padding:20px;">'+
      		   'Select Calendar:<br /><select id="cpabc_calendar_sel'+cpabc_counter+'" name="cpabc_calendar_sel'+cpabc_counter+'"><?php echo $options; ?></select>'+      		   
      		   '</div></div>'
      		  ).dialog({
      			dialogClass: 'wp-dialog',
                  modal: true,
                  closeOnEscape: true,
                  buttons: [
                      {text: "Insert", click: function() {
      						if(send_to_editor){
      							var id = $('#cpabc_calendar_sel'+cpabc_counter)[0].options[$('#cpabc_calendar_sel'+cpabc_counter)[0].options.selectedIndex].value;
                                send_to_editor('[CPABC_APPOINTMENT_CALENDAR calendar="'+id+'"]');
      						}
      						$(this).dialog("close"); 
      				}}
                  ]
              });
      	}
      	var obj = {};
      	obj.open = loadWindow;
      	return obj;
      }(jQuery);  
     </script>   
    <?php

    print '<a href="javascript:cpabc_appointments_fpanel.open()" title="'.__('Insert Appointment Booking Calendar').'"><img hspace="5" src="'.plugins_url('/images/cpabc_apps.gif', __FILE__).'" alt="'.__('Insert  Appointment Booking Calendar').'" /></a>';    
}

function set_cpabc_apps_insert_adminScripts($hook) {
    if ($_GET["cal"] != '')
    {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-datepicker' );        
        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    }
    if( 'post.php' != $hook  && 'post-new.php' != $hook )
        return; 
}

function set_cpabc_apps_insert_publicScripts($hook) {
    wp_enqueue_script( 'jquery' );
}


function cpabc_export_iCal() {
    global $wpdb;
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=events".date("Y-M-D_H.i.s").".ics");

    define('CPABC_CAL_TIME_ZONE_MODIFY'," -2 hours");
    define('CPABC_CAL_TIME_SLOT_SIZE'," +15 minutes");

    echo "BEGIN:VCALENDAR\n";
    echo "PRODID:-//CodePeople//Appointment Booking Calendar for WordPress//EN\n";
    echo "VERSION:2.0\n";
    echo "CALSCALE:GREGORIAN\n";
    echo "METHOD:PUBLISH\n";
    echo "X-WR-CALNAME:Bookings\n";
    echo "X-WR-TIMEZONE:Europe/London\n";
    echo "BEGIN:VTIMEZONE\n";
    echo "TZID:Europe/Stockholm\n";
    echo "X-LIC-LOCATION:Europe/London\n";
    echo "BEGIN:DAYLIGHT\n";
    echo "TZOFFSETFROM:+0000\n";
    echo "TZOFFSETTO:+0100\n";
    echo "TZNAME:CEST\n";
    echo "DTSTART:19700329T020000\n";
    echo "RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU\n";
    echo "END:DAYLIGHT\n";
    echo "BEGIN:STANDARD\n";
    echo "TZOFFSETFROM:+0100\n";
    echo "TZOFFSETTO:+0000\n";
    echo "TZNAME:CET\n";
    echo "DTSTART:19701025T030000\n";
    echo "RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU\n";
    echo "END:STANDARD\n";
    echo "END:VTIMEZONE\n";

    $events = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME." WHERE appointment_calendar_id=".$_GET["id"]." ORDER BY datatime ASC" );
    foreach ($events as $event)
    {
        echo "BEGIN:VEVENT\n";
        echo "DTSTART:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "DTEND:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY.CPABC_CAL_TIME_SLOT_SIZE))."Z\n";
        echo "DTSTAMP:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "UID:uid".$event->id."@".$_SERVER["SERVER_NAME"]."\n";
        echo "CREATED:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "DESCRIPTION:".str_replace("<br>",'\n',str_replace("<br />",'\n',str_replace("\n",'\n',$event->description)))."\n";
        echo "LAST-MODIFIED:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "LOCATION:\n";
        echo "SEQUENCE:0\n";
        echo "STATUS:CONFIRMED\n";
        echo "SUMMARY:Booking from ".str_replace("\n",'\n',$event->title)."\n";
        echo "TRANSP:OPAQUE\n";
        echo "END:VEVENT\n";


    }
    echo 'END:VCALENDAR';
    exit;
}


/* hook for checking posted data for the admin area */


add_action( 'init', 'cpabc_appointments_check_posted_data', 11 );

function cpabc_appointments_check_posted_data()
{
    global $wpdb;

    if(isset($_GET) && array_key_exists('cpabc_app',$_GET)) {
        if ( $_GET["cpabc_app"] == 'calfeed')
            cpabc_export_iCal();

        if ( $_GET["cpabc_app"] == 'cpabc_loadcoupons')
            cpabc_appointments_load_discount_codes();
    } 
       

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['cpabc_appointments_post_options'] ) && is_admin() )
    {
        cpabc_appointments_save_options();
        return;
    }

    // if this isn't the expected post and isn't the captcha verification then nothing to do
	if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['cpabc_appointments_post'] ) )
		if ( 'GET' != $_SERVER['REQUEST_METHOD'] || !isset( $_GET['hdcaptcha'] ) )
		    return;

    if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',1);

    session_start();
    if ($_GET['hdcaptcha'] == '') $_GET['hdcaptcha'] = $_POST['hdcaptcha'];
    if (
           (cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') &&
           ( ($_GET['hdcaptcha'] != $_SESSION['rand_code']) ||
             ($_SESSION['rand_code'] == '')
           )
       )
    {
        $_SESSION['rand_code'] = '';
        echo 'captchafailed';
        exit;
    }

	// if this isn't the real post (it was the captcha verification) then echo ok and exit
    if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['cpabc_appointments_post'] ) )
	{
	    echo 'ok';
        exit;
	}

    $_SESSION['rand_code'] = '';

    $selectedCalendar = $_POST["cpabc_item"];

    $_POST["dateAndTime"] =  $_POST["selYearcal".$selectedCalendar]."-".$_POST["selMonthcal".$selectedCalendar]."-".$_POST["selDaycal".$selectedCalendar]." ".$_POST["selHourcal".$selectedCalendar].":".$_POST["selMinutecal".$selectedCalendar];

    $military_time = cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME);
    if (cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME) == '0') $format = "g:i A"; else $format = "H:i";  
    if (cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT) == '0') $format = "m/d/Y ".$format; else $format = "d/m/Y ".$format;  
    $_POST["Date"] = date($format,strtotime($_POST["dateAndTime"]));

    $services_formatted = explode("|",$_POST["services"]);

    $price = ($_POST["services"]?trim($services_formatted[0]):cpabc_get_option('request_cost', CPABC_APPOINTMENTS_DEFAULT_COST));
 
    $discount_note = "";
    $coupon = false;    
    

    $buffer = $_POST["selYearcal".$selectedCalendar].",".$_POST["selMonthcal".$selectedCalendar].",".$_POST["selDaycal".$selectedCalendar]."\n".
    $_POST["selHourcal".$selectedCalendar].":".($_POST["selMinutecal".$selectedCalendar]<10?"0":"").$_POST["selMinutecal".$selectedCalendar]."\n".
    "Name: ".$_POST["name"]."\n".
    "Email: ".$_POST["email"]."\n".
    "Phone: ".$_POST["phone"]."\n".
    "Question: ".$_POST["question"]."\n".
            ($_POST["services"]?"\nService:".trim($services_formatted[1])."\n":"").
            ($coupon?"\nCoupon code:".$coupon->code.$discount_note."\n":"").
    "*-*\n";
    
    

    $rows_affected = $wpdb->insert( CPABC_APPOINTMENTS_TABLE_NAME, array( 'calendar' => $selectedCalendar,
                                                                        'time' => current_time('mysql'),
                                                                        'booked_time' => $_POST["Date"],
                                                                        'booked_time_unformatted' => $_POST["dateAndTime"],
                                                                        'name' => $_POST["name"],
                                                                        'email' => $_POST["email"],
                                                                        'phone' => $_POST["phone"],
                                                                        'question' => $_POST["question"]
                                                                           .($_POST["services"]?"\nService:".trim($services_formatted[1]):"")
                                                                           .($coupon?"\nCoupon code:".$coupon->code.$discount_note:"")
                                                                           ,
                                                                        'buffered_date' => $buffer
                                                                         ) );
    if (!$rows_affected)
    {
        echo 'Error saving data! Please try again.';
        echo '<br /><br />Error debug information: '.mysql_error();
        $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX."` ADD `booked_time_unformatted` text DEFAULT '' NOT NULL;"; $wpdb->query($sql);
        exit;
    }


    $myrows = $wpdb->get_results( "SELECT MAX(id) as max_id FROM ".CPABC_APPOINTMENTS_TABLE_NAME );

 	// save data here
    $item_number = $myrows[0]->max_id;

?>
<html>
<head><title>Redirecting to Paypal...</title></head>
<body>
<form action="https://www.paypal.com/cgi-bin/webscr" name="ppform3" method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo cpabc_get_option('paypal_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL); ?>" />
<input type="hidden" name="item_name" value="<?php echo cpabc_get_option('paypal_product_name', CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME).($_POST["services"]?": ".trim($services_formatted[1]):"").$discount_note; ?>" />
<input type="hidden" name="item_number" value="<?php echo $item_number; ?>" />
<input type="hidden" name="amount" value="<?php echo $price; ?>" />
<input type="hidden" name="page_style" value="Primary" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="return" value="<?php echo cpabc_get_option('url_ok', CPABC_APPOINTMENTS_DEFAULT_OK_URL); ?>">
<input type="hidden" name="cancel_return" value="<?php echo cpabc_get_option('url_cancel', CPABC_APPOINTMENTS_DEFAULT_CANCEL_URL); ?>" />
<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="currency_code" value="<?php echo strtoupper(cpabc_get_option('currency', CPABC_APPOINTMENTS_DEFAULT_CURRENCY)); ?>" />
<input type="hidden" name="lc" value="<?php echo cpabc_get_option('paypal_language', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_LANGUAGE); ?>" />
<input type="hidden" name="bn" value="PP-BuyNowBF" />
<input type="hidden" name="notify_url" value="<?php echo cpabc_appointment_get_FULL_site_url(); ?>/?cpabc_ipncheck=1&itemnumber=<?php echo $item_number; ?>" />
<input type="hidden" name="ipn_test" value="1" />
<input class="pbutton" type="hidden" value="Buy Now" /></div>
</form>
<script type="text/javascript">
document.ppform3.submit();
</script>
</body>
</html>
<?php
        exit();

}

add_action( 'init', 'cpabc_appointments_check_IPN_verification', 11 );

function cpabc_appointments_check_IPN_verification() {

    global $wpdb;

	if ( ! isset( $_GET['cpabc_ipncheck'] ) || $_GET['cpabc_ipncheck'] != '1' ||  ! isset( $_GET["itemnumber"] ) )
		return;

    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $payment_type = $_POST['payment_type'];


	if ($payment_status != 'Completed' && $payment_type != 'echeck')
	    return;

	if ($payment_type == 'echeck' && $payment_status == 'Completed')
	    return;

    cpabc_process_ready_to_go_appointment($_GET["itemnumber"], $payer_email);

    echo 'OK';

    exit();

}

function cpabc_process_ready_to_go_appointment($itemnumber, $payer_email = "")
{
   global $wpdb;

   $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_TABLE_NAME." WHERE id=".$itemnumber );

   $mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME .' WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.$myrows[0]->calendar);

   if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',1);

   $SYSTEM_EMAIL = cpabc_get_option('notification_from_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL);
   $SYSTEM_RCPT_EMAIL = cpabc_get_option('notification_destination_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL);


   $email_subject1 = cpabc_get_option('email_subject_confirmation_to_user', CPABC_APPOINTMENTS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL);
   $email_content1 = cpabc_get_option('email_confirmation_to_user', CPABC_APPOINTMENTS_DEFAULT_CONFIRMATION_EMAIL);
   $email_subject2 = cpabc_get_option('email_subject_notification_to_admin', CPABC_APPOINTMENTS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL);
   $email_content2 = cpabc_get_option('email_notification_to_admin', CPABC_APPOINTMENTS_DEFAULT_NOTIFICATION_EMAIL);

   $information = $mycalendarrows[0]->uname."\n".
                  $myrows[0]->booked_time."\n".
                  $myrows[0]->name."\n".
                  $myrows[0]->email."\n".
                  $myrows[0]->phone."\n".
                  $myrows[0]->question."\n";

   $email_content1 = str_replace("%INFORMATION%", $information, $email_content1);
   $email_content2 = str_replace("%INFORMATION%", $information, $email_content2);

   // SEND EMAIL TO USER
   wp_mail($myrows[0]->email, $email_subject1, $email_content1,
            "From: \"$SYSTEM_EMAIL\" <".$SYSTEM_EMAIL.">\r\n".
            "Content-Type: text/plain; charset=utf-8\n".
            "X-Mailer: PHP/" . phpversion());

   if ($payer_email && $payer_email != $myrows[0]->email)
       wp_mail($payer_email , $email_subject1, $email_content1,
                "From: \"$SYSTEM_EMAIL\" <".$SYSTEM_EMAIL.">\r\n".
                "Content-Type: text/plain; charset=utf-8\n".
                "X-Mailer: PHP/" . phpversion());

   // SEND EMAIL TO ADMIN
   $to = explode(",",$SYSTEM_RCPT_EMAIL);
   foreach ($to as $item)
        if (trim($item) != '')
        {
            wp_mail(trim($item), $email_subject2, $email_content2,
                "From: \"$SYSTEM_EMAIL\" <".$SYSTEM_EMAIL.">\r\n".
                "Content-Type: text/plain; charset=utf-8\n".
                "X-Mailer: PHP/" . phpversion());
        }        


    $rows_affected = $wpdb->insert( CPABC_TDEAPP_CALENDAR_DATA_TABLE, array( 'appointment_calendar_id' => $myrows[0]->calendar,
                                                                        'datatime' => date("Y-m-d H:i:s", strtotime($myrows[0]->booked_time_unformatted)),
                                                                        'title' => $myrows[0]->name,
                                                                        'description' => str_replace("\n","<br />", $information)
                                                                         ) );

   // $fp = fopen(dirname( __FILE__ ) .'/TDE_AppCalendar/admin/database/cal1data.txt', 'a');
   // fwrite($fp, $myrows[0]->buffered_date);
   // fclose($fp);


}

function cpabc_appointments_save_options()
{
    global $wpdb;
    if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',1);

    $data = array(
         'calendar_language' => $_POST["calendar_language"],
         'calendar_dateformat' => $_POST["calendar_dateformat"],
         'calendar_pages' => $_POST["calendar_pages"],
         'calendar_militarytime' => $_POST["calendar_militarytime"],
         'calendar_weekday' => $_POST["calendar_weekday"],
         'calendar_mindate' => $_POST["calendar_mindate"],
         'calendar_maxdate' => $_POST["calendar_maxdate"],

         'enable_paypal' => $_POST["enable_paypal"],
         'paypal_email' => $_POST["paypal_email"],
         'request_cost' => $_POST["request_cost"],
         'paypal_product_name' => $_POST["paypal_product_name"],
         'currency' => $_POST["currency"],
         'url_ok' => $_POST["url_ok"],
         'url_cancel' => $_POST["url_cancel"],
         'paypal_language' => $_POST["paypal_language"],

         'notification_from_email' => $_POST["notification_from_email"],
         'notification_destination_email' => $_POST["notification_destination_email"],
         'email_subject_confirmation_to_user' => $_POST["email_subject_confirmation_to_user"],
         'email_confirmation_to_user' => $_POST["email_confirmation_to_user"],
         'email_subject_notification_to_admin' => $_POST["email_subject_notification_to_admin"],
         'email_notification_to_admin' => $_POST["email_notification_to_admin"],

         'dexcv_enable_captcha' => $_POST["dexcv_enable_captcha"],
         'dexcv_width' => $_POST["dexcv_width"],
         'dexcv_height' => $_POST["dexcv_height"],
         'dexcv_chars' => $_POST["dexcv_chars"],
         'dexcv_min_font_size' => $_POST["dexcv_min_font_size"],
         'dexcv_max_font_size' => $_POST["dexcv_max_font_size"],
         'dexcv_noise' => $_POST["dexcv_noise"],
         'dexcv_noise_length' => $_POST["dexcv_noise_length"],
         'dexcv_background' => $_POST["dexcv_background"],
         'dexcv_border' => $_POST["dexcv_border"],
         'dexcv_font' => $_POST["dexcv_font"],
         'cp_cal_checkboxes' => $_POST["cp_cal_checkboxes"]
	);
    $wpdb->update ( CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, $data, array( 'id' => CP_CALENDAR_ID ));
}


add_action( 'init', 'cpabc_appointments_calendar_load', 11 );
add_action( 'init', 'cpabc_appointments_calendar_load2', 11 );
add_action( 'init', 'cpabc_appointments_calendar_update', 11 );
add_action( 'init', 'cpabc_appointments_calendar_update2', 11 );

function cpabc_appointments_calendar_load() {
    global $wpdb;
	if ( ! isset( $_GET['cpabc_calendar_load'] ) || $_GET['cpabc_calendar_load'] != '1' )
		return;
    ob_end_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
    $query = "SELECT * FROM ".CPABC_TDEAPP_CONFIG." where ".CPABC_TDEAPP_CONFIG_ID."='".$calid."'";
    $row = $wpdb->get_results($query,ARRAY_A);
    if ($row[0])
    {
        echo $row[0][CPABC_TDEAPP_CONFIG_WORKINGDATES].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_RESTRICTEDDATES].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6].";";
    }

    exit();
}

function cpabc_appointments_calendar_load2() {
    global $wpdb;
	if ( ! isset( $_GET['cpabc_calendar_load2'] ) || $_GET['cpabc_calendar_load2'] != '1' )
		return;
    ob_end_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
    $query = "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." where ".CPABC_TDEAPP_DATA_IDCALENDAR."='".$calid."'";
    $row_array = $wpdb->get_results($query,ARRAY_A);
    foreach ($row_array as $row)
    {
        echo $row[CPABC_TDEAPP_DATA_ID]."\n";
        $dn =  explode(" ", $row[CPABC_TDEAPP_DATA_DATETIME]);
        $d1 =  explode("-", $dn[0]);
        $d2 =  explode(":", $dn[1]);

        echo intval($d1[0]).",".intval($d1[1]).",".intval($d1[2])."\n";
        echo intval($d2[0]).":".($d2[1])."\n";
        echo $row[CPABC_TDEAPP_DATA_TITLE]."\n";
        echo $row[CPABC_TDEAPP_DATA_DESCRIPTION]."\n*-*\n";
    }

    exit();
}

function cpabc_appointments_calendar_update() {
    global $wpdb, $user_ID;

    if ( ! current_user_can('edit_pages') )
        return;

	if ( ! isset( $_GET['cpabc_calendar_update'] ) || $_GET['cpabc_calendar_update'] != '1' )
		return;
    ob_end_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    if ( $user_ID )
    {
        $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
        $wpdb->query("update  ".CPABC_TDEAPP_CONFIG." set ".CPABC_TDEAPP_CONFIG_WORKINGDATES."='".$_POST["workingDates"]."',".CPABC_TDEAPP_CONFIG_RESTRICTEDDATES."='".$_POST["restrictedDates"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0."='".$_POST["timeWorkingDates0"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1."='".$_POST["timeWorkingDates1"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2."='".$_POST["timeWorkingDates2"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3."='".$_POST["timeWorkingDates3"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4."='".$_POST["timeWorkingDates4"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5."='".$_POST["timeWorkingDates5"]."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6."='".$_POST["timeWorkingDates6"]."'  where ".CPABC_TDEAPP_CONFIG_ID."=".$calid);
    }

    exit();
}

function cpabc_appointments_calendar_update2() {
    global $wpdb, $user_ID;

    if ( ! current_user_can('edit_pages') )
        return;

	if ( ! isset( $_GET['cpabc_calendar_update2'] ) || $_GET['cpabc_calendar_update2'] != '1' )
		return;
    ob_end_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    if ( $user_ID )
    {
        if ($_GET["act"]=='del')
        {
            $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
            $wpdb->query("delete from ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." where ".CPABC_TDEAPP_DATA_IDCALENDAR."=".$calid." and ".CPABC_TDEAPP_DATA_ID."=".$_POST["sqlId"]);

        }
        else if ($_GET["act"]=='edit')
        {
            $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
            $data = explode("\n", $_POST["appoiments"]);
            $d1 =  explode(",", $data[0]);
            $d2 =  explode(":", $data[1]);
	        $datetime = $d1[0]."-".$d1[1]."-".$d1[2]." ".$d2[0].":".$d2[1];
	        $title = $data[2];
            $description = "";
            for ($j=3;$j<count($data);$j++)
            {
                $description .= $data[$j];
                if ($j!=count($data)-1)
                    $description .= "\n";
            }
            $wpdb->query("update  ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." set ".CPABC_TDEAPP_DATA_DATETIME."='".$datetime."',".CPABC_TDEAPP_DATA_TITLE."='".$wpdb->escape($title)."',".CPABC_TDEAPP_DATA_DESCRIPTION."='".$wpdb->escape($description)."'  where ".CPABC_TDEAPP_DATA_IDCALENDAR."=".$calid." and ".CPABC_TDEAPP_DATA_ID."=".$_POST["sqlId"]);
        }
        else if ($_GET["act"]=='add')
        {
            $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
            $data = explode("\n", $_POST["appoiments"]);
            $d1 =  explode(",", $data[0]);
            $d2 =  explode(":", $data[1]);
	        $datetime = $d1[0]."-".$d1[1]."-".$d1[2]." ".$d2[0].":".$d2[1];
	        $title = $data[2];
            $description = "";
            for ($j=3;$j<count($data);$j++)
            {
                $description .= $data[$j];
                if ($j!=count($data)-1)
                    $description .= "\n";
            }
            $wpdb->query("insert into ".CPABC_TDEAPP_CALENDAR_DATA_TABLE."(".CPABC_TDEAPP_DATA_IDCALENDAR.",".CPABC_TDEAPP_DATA_DATETIME.",".CPABC_TDEAPP_DATA_TITLE.",".CPABC_TDEAPP_DATA_DESCRIPTION.") values(".$calid.",'".$datetime."','".$wpdb->escape($title)."','".$wpdb->escape($description)."') ");
            echo  $wpdb->insert_id;

        }
    }

    exit();
}


function cpabc_appointment_get_site_url()
{
    $url = parse_url(get_site_url());
    $url = rtrim($url["path"],"/");
    return $url;
}


function cpabc_appointment_get_FULL_site_url()
{
    $url = parse_url(get_site_url());
    $url = rtrim($url["path"],"/");
    $pos = strpos($url, "://");    
    if ($pos === false)
        $url = 'http://'.$_SERVER["HTTP_HOST"].$url;
    return $url;
}


// cpabc_cpabc_get_option:
$cpabc_option_buffered_item = false;
$cpabc_option_buffered_id = -1;

function cpabc_get_option ($field, $default_value)
{
    global $wpdb, $cpabc_option_buffered_item;
    if ($cpabc_option_buffered_id == CP_CALENDAR_ID)
        $value = $cpabc_option_buffered_item->$field;
    else
    {
       $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE id=".CP_CALENDAR_ID );
       $value = $myrows[0]->$field;
       $cpabc_option_buffered_item = $myrows[0];
       $cpabc_option_buffered_id  = CP_CALENDAR_ID;
    }
    if ($value == '' && $cpabc_option_buffered_item->calendar_language == '')
        $value = $default_value;
    return $value;
}

function cpabc_appointment_is_administrator()
{
    return current_user_can('manage_options');
}


// WIDGET CODE BELOW

class CPABC_App_Widget extends WP_Widget
{
  function CPABC_App_Widget()
  {
    $widget_ops = array('classname' => 'CPABC_App_Widget', 'description' => 'Displays a booking form' );
    $this->WP_Widget('CPABC_App_Widget', 'Appointment Booking Calendar', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

    if (!empty($title))
      echo $before_title . $title . $after_title;;

    // WIDGET CODE GOES HERE
    define('CPABC_AUTH_INCLUDE', true);
    @include_once dirname( __FILE__ ) . '/cpabc_scheduler.inc.php';

    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("CPABC_App_Widget");') );


?>