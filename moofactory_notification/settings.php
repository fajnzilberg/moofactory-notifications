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
 * local_moofactory_notification plugin
 *
 * @package     local_moofactory_notification
 * @copyright   2020 Patrick ROCHET <patrick.r@lmsfactory.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 * This file generates the site admin settings page using Moodles
 * standard admin_settingpage class.
 */

defined('MOODLE_INTERNAL') || die;

$context = context_system::instance();

$settings = new admin_settingpage('local_moofactory_notification',  get_string('settings', 'local_moofactory_notification'));

// Settings
$name = 'local_moofactory_notification/enabled';
$title = get_string('enabled', 'local_moofactory_notification');
$description = get_string('enabled_desc', 'local_moofactory_notification');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$settings->add($setting);

$name = 'local_moofactory_notification/events';
$heading = get_string('eventstypes', 'local_moofactory_notification');
$information = '';
$setting = new admin_setting_heading($name, $heading, $information);
$settings->add($setting);

$name = 'local_moofactory_notification/siteevents';
$title = get_string('siteevents', 'local_moofactory_notification');
$description = get_string('siteevents_desc', 'local_moofactory_notification');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$settings->add($setting);

$name = 'local_moofactory_notification/coursesenrollments';
$title = get_string('coursesenrollments', 'local_moofactory_notification');
$description = get_string('coursesenrollments_desc', 'local_moofactory_notification');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$settings->add($setting);

$name = 'local_moofactory_notification/coursesenrollmentstime';
$title = get_string('coursesenrollmentstime', 'local_moofactory_notification');
$description = get_string('coursesenrollmentstime_desc', 'local_moofactory_notification');
$default = 0;
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT, '3');
$settings->add($setting);

$name = 'local_moofactory_notification/coursesenrollmentsnotification';
$title = get_string('usednotification', 'local_moofactory_notification');
$description = get_string('coursesenrollmentsnotification_desc', 'local_moofactory_notification');
$options = Array();
$records = $DB->get_records('local_mf_notification', array('type'=>'courseenroll'));
foreach($records as $record) {
    $options[$record->id] = $record->name;
}
$setting = new admin_setting_configselect($name, $title, $description, '', $options);
$settings->add($setting);

$name = 'local_moofactory_notification/coursesevents';
$title = get_string('coursesevents', 'local_moofactory_notification');
$description = get_string('coursesevents_desc', 'local_moofactory_notification');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$settings->add($setting);

$name = 'local_moofactory_notification/courseseventsnotification';
$title = get_string('usednotification', 'local_moofactory_notification');
$description = get_string('courseseventsnotification_desc', 'local_moofactory_notification');
$options = Array();
$records = $DB->get_records('local_mf_notification', array('type'=>'courseevent'));
foreach($records as $record) {
    $options[$record->id] = $record->name;
}
$setting = new admin_setting_configselect($name, $title, $description, '', $options);
$settings->add($setting);

$name = 'local_moofactory_notification/usersevents';
$title = get_string('usersevents', 'local_moofactory_notification');
$description = get_string('usersevents_desc', 'local_moofactory_notification');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$settings->add($setting);


if (has_capability('local/moofactory_notification:managenotifications', $context)) {
    $ADMIN->add('localplugins', new admin_category('moofactory_notification', get_string('pluginname', 'local_moofactory_notification')));
    $ADMIN->add('moofactory_notification', $settings);

    $ADMIN->add('moofactory_notification', new admin_externalpage('local_moofactory_notification_managenotif',
    get_string('managenotif', 'local_moofactory_notification'),
    new moodle_url('/local/moofactory_notification/managenotif.php')));
}
