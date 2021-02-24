<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * English strings for local_moofactory_notification.
 *
 * @package     local_moofactory_notification
 * @copyright   2020 Patrick ROCHET <patrick.r@lmsfactory.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Moo Factory Notification';
$string['notifications_category'] = 'Notifications';
$string['settings'] = 'Settings';
$string['managenotif'] = 'Manage notifications';
$string['enabled'] = 'Notifications activated';
$string['enabled_desc'] = 'Notifications activation';
$string['eventstypes'] = 'Types of events enabled';
$string['siteevents'] = 'Site events';
$string['siteevents_desc'] = 'Site events notifications';
$string['coursesevents'] = 'Courses events';
$string['coursesevents_desc'] = 'Courses events notifications';
$string['courseseventsnotification_desc'] = 'Choice of the notification template to use for courses events';
$string['coursesenrollmentsnotification_desc'] = 'Choice of the notification template to use for courses enrollments';
$string['usersevents'] = 'Users events';
$string['usersevents_desc'] = 'Users events notifications';
$string['coursesenrollments'] = 'Courses enrollments';
$string['coursesenrollments_desc'] = 'Notifications when a course enrollment occurs';
$string['coursesenrollmentstime'] = 'Time';
$string['coursesenrollmentstime_desc'] = 'Time before notification is sent (in minutes)';
$string['courseenrollments'] = 'Enrollments to this course';
$string['courseenrollmentstime'] = 'Time';
$string['courseenrollmentstime_desc'] = 'minute(s) after enrollment to this course';
$string['courseevents'] = 'Events link to this course';
$string['courseeventscheckavailability'] = 'Take into account access restrictions to activities';
$string['usednotification'] = 'Notification used';

$string['daysbeforeevents1'] = 'First reminder';
$string['daysbeforeevents1_desc'] = 'day(s) before the events';
$string['hoursbeforeevents1'] = 'and/or';
$string['hoursbeforeevents1_desc'] = 'hour(s) before the events';
$string['daysbeforeevents2'] = 'Second reminder';
$string['daysbeforeevents2_desc'] = 'day(s) before the events';
$string['hoursbeforeevents2'] = 'and/or';
$string['hoursbeforeevents2_desc'] = 'hour(s) before the events';
$string['daysbeforeevents3'] = 'Third reminder';
$string['daysbeforeevents3_desc'] = 'day(s) before the events';
$string['hoursbeforeevents3'] = 'and/or';
$string['hoursbeforeevents3_desc'] = 'hour(s) before the events';
$string['menuitem'] = 'Activate notifications';
$string['module'] = 'Activate notifications for ';
$string['moduleevents'] = 'Events link to this activity';
$string['modulecheckavailability'] = 'Take into account access restrictions to this activity';
$string['modulereset'] = 'To reset these values ​​with those saved at the course level, enter 999 in the fields concerned above.';
$string['notanumber'] = 'The value entered must be a number';

$string['sendcourseseventsnotification'] = 'Sending notifications for courses events';
$string['sendcourseenrollmentsnotifications'] = 'Sending notifications for courses enrollments';
$string['choose'] = 'Choose a notification';
$string['notifications'] = 'Notifications';
$string['duplicate'] = 'Duplicate';
$string['delete'] = 'Delete';
$string['add'] = 'Add a notification';
$string['params'] = 'Parameters';
$string['deletenotification'] = 'Delete a notification';
$string['deleteconfirm'] = 'Confirm the deletion of the notification {$a}';
$string['required'] = 'This field is required';
$string['name'] = 'Name';
$string['type'] = 'Type';
$string['subject'] = 'Subject';
$string['bodyhtml'] = 'Content';


// Capabilities.
$string['moofactory_notification:managenotifications']  = 'Manage notifications';
