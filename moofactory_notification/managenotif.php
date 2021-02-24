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

require_once("../../config.php");
require_once($CFG->libdir . '/adminlib.php');

require_once('managenotif_form.php');

admin_externalpage_setup('local_moofactory_notification_managenotif');

$id = optional_param('id', 0, PARAM_INT); // Id de la notification.

$returnurl = new moodle_url($CFG->wwwroot . '/admin/category.php?category=moofactory_notification');

if (!empty($id)) {
    $mform = new managenotif_form(null, array('id' => $id), 'post', '', array(id => 'notificationsform'));
} else {
    $mform = new managenotif_form(null, null, 'post', '', array(id => 'notificationsform'));
}

if ($mform->is_cancelled()) {
    redirect($returnurl);
} else if ($fromform = $mform->get_data()) {
    if (!empty($fromform->submitbutton)) {
        // Update de la notification.
        $data = new stdClass;
        $data->id = $fromform->selectnotifications;
        $data->type = $fromform->notificationtype;
        $data->name = $fromform->notificationname;
        $data->subject = $fromform->notificationsubject;
        $data->bodyhtml = $fromform->notificationbodyhtml['text'];
        $DB->update_record('local_mf_notification', $data);
    }

    $nexturl = new moodle_url($CFG->wwwroot . '/local/moofactory_notification/managenotif.php', array('id' => $fromform->selectnotifications));
    // Typically you finish up by redirecting to somewhere where the user
    // can see what they did.
    redirect($nexturl);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('managenotif', 'local_moofactory_notification'), 2);

$mform->display();

echo $OUTPUT->footer();
