=== Appointment Booking Calendar ===
Contributors: codepeople
Donate link: http://wordpress.dwbooster.com/calendars/appointment-booking-calendar
Tags: booking form,booking calendar,appointment,appointment calendar,paypal calendar,paypal bookings,paypal appointments,booking,bookings,meeting,meet
Requires at least: 3.0.5
Tested up to: 3.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Appointment Booking Calendar allows you to accept online bookings from a set of available time-slots in a calendar.

== Description ==

Appointment Booking Calendar is a plugin for **accepting online bookings** from a set of **available time-slots in a calendar**. The booking form is linked to a **PayPal** payment process.

You can use it to accept bookings for medical consultation, classrooms, events, transportation and other activities where a specific time from a defined set must be selected, allowing you to define the maximum number of bookings that can be accepted for each time-slot.

Features:

* The customer can **book an available time slot** from a defined set.
* The booking form is connected to a **PayPal** payment page
* You can define the **appointment booking capacity** for each time-slot. 
* A **notification** email is sent to the specified email addresses (one or more) after completed the booking payment.
* A **confirmation** email with the appointment data is sent to the user after completing the booking payment.
* You can **assign a user** to the appointment booking calendar. Users with "Editor Access Level" will get access to the appointment calendar only if it has been assigned previously.
* Exports the appointments to **iCal** format (Google Calendar, Outlook).
* Includes **captcha** validation for preventing spam from the appointment calendar form.
* The appointment calendar has a **printable list** of bookings.
* You can edit the text of the notification/confirmation emails.
* Allows defining the product name at PayPal, the currency, the PayPal language and amount to pay for an appointment booking (you can set zero to let the user pay/donate the desired amount).
* Allows defining the working days, the exact time slots available and the appointment capacity of each time slot.
* **Multi-page calendar:** You can setup it to show many months at once.
* Configurable date format: mm/dd/yyyy or dd/mm/yyyy
* Supports both am/pm and military time.
* You can define the **start day** of the week on the appointment calendar.
* You can define the **minimum** available date and the **maximum** available date for the bookings.
* You can block specific dates.
* Pretty modern administration interface.

Please note that this is a plugin originally designed to accept appointment bookings linked to PayPal payments. The feature for accepting appointments without PayPal is implemented/available in the Pro version: http://wordpress.dwbooster.com/calendars/appointment-booking-calendar#download

== Installation ==

To install **Appointment Booking Calendar**, follow these steps:

1.	Download and unzip the Appointment Booking Calendar plugin
2.	Upload the entire appointment-booking-calendar/ directory to the /wp-content/plugins/ directory
3.	Activate the Appointment Booking Calendar plugin through the Plugins menu in WordPress
4.	Configure the settings at the administration menu >> Settings >> Appointment Booking Calendar. 
5.	To insert the appointment calendar form into some content or post use the icon that will appear when editing contents

== Frequently Asked Questions ==

= Q: What means each field in the appointment calendar settings area? =

A: The product's page contains detailed information about each appointment calendar field and customization:

http://wordpress.dwbooster.com/calendars/appointment-booking-calendar


= Q: How can I center the appointment calendar into the page? =

A: For centering the calendar open the CSS file "TDE_AppCalendar\all-css.css" in any text editor and add these CSS rules into that file:

    .appContainer{text-align:center;}
    .appContainer2{margin-left:auto;margin-right:auto;width:200px}

After that be sure to refresh the page that contains the appointment scheduler form or clear your browser cache to be sure that the browser is loading the updated CCS styles file.


= Q: How can I cancel/delete an appointment to make its time slot available again? =

A: To delete an appointment locate it into the appointment calendar in the settings area, clear the title (there is a button for that) and save it. This action will delete the appointment (even if the content wasn't cleared).


= Q: How can I change the calendar's width and height? =

A: You can specify the size of the appointment calendar's cells, that way the complete appointment calendar width and height can be controlled.

Open the file "appointment-booking-calendar\TDE_AppCalendar\all-css.css" and about line #139 modify the "padding" applied to the cells:

    .yui-calendar td.calcell {
        padding:.3em .4em;
        border:1px solid #E0E0E0;
        text-align:center;
        vertical-align: top;
    }

= Q: Can I put an "acknowledgment / thank you message" after submitting an appointment and completing the PayPal payment? =

The "acknowledgment / thank you message" shown to the user after submitting the appointment form should be placed at the page indicated in the field "URL to return after successful payment". Note that after the submission the user is redirected first to PayPal and then to the "thank you" page once the payment for the booking has been completed.


= Q: How do I change the background color of the selected date on the appointment calendar? =

A: Open the file "wp-content/plugins/appointment-booking-calendar/TDE_AppCalendar/all-css.css" ... find this CSS rule:

    .yui-calendar td.calcell.reserveddate { background-color:#B6EA59; }

...and replace the background color that appears there.


= Q: After booking appointment I'm not receiving the emails with the appointment data. =

Please check if after the completing the payment at Paypal the appointment appears registered in the appointment calendar (some time slot unavailable):

* **If the appointment purchase is registered**, then the problem is that you server has some additional configuration requirements to send emails from PHP. The Appointment Booking Calendar plugin uses the settings specified into the WordPress website to deliver the emails, if your hosting has some specific requirements like a fixed "from" address or a custom "SMTP" server those settings must be configured into the WordPress website.

* **If the appointment purchase isn't registered**, first check if you are testing the appointment booking form on a local website or in an online website. Note you should test this feature into an online website (local websites cannot receive PayPal IPN connections).

* **If the appointment purchase isn't registered and you are testing it on an online website**, then check if the payment appears as "completed" at the Paypal seller account (no red flags, no pending mark). Check also if your Paypal account is setup to automatically accept payments in the selected currency. The payment must be "accepted" and "completed" in the PayPal seller account.


== Screenshots ==

1. Appointment booking form.
2. Inserting an appointment calendar into a page.
3. Managing the appointment calendar.
4. Defining time-slots on the appointment calendar
5. Appointment Booking Calendar settings.

== Changelog ==

= 1.0 =
* First stable version released.
* More configuration options added.

== Upgrade Notice ==

= 1.0.1 =
* Interface modifications.