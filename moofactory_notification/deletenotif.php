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
 * Delete notification.
 *
 * @package     local_moofactory_notification
 * @copyright   2020 Patrick ROCHET <patrick.r@lmsfactory.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once($CFG->libdir . '/adminlib.php');
require_once('deletenotif_form.php');

admin_externalpage_setup('local_moofactory_notification_managenotif');

$id = optional_param('id', 0, PARAM_INT); // Id de la notification à supprimer.

$returnurl = new moodle_url($CFG->wwwroot . '/local/moofactory_notification/managenotif.php', array('id' => $id));
$nexturl = new moodle_url($CFG->wwwroot . '/local/moofactory_notification/managenotif.php');

if (!empty($id)) {
    $mform = new deletenotif_form( null, array('id' => $id));
} else {
    redirect($nexturl);
}

if ($mform->is_cancelled()) {
    redirect($returnurl);

} else if ($fromform = $mform->get_data()) {
    $DB->delete_records('local_mf_notification', array('id' => $fromform->id));

    // Typically you finish up by redirecting to somewhere where the user can see what they did.
    redirect($nexturl);
}

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('deletenotification', 'local_moofactory_notification'), 2);
$mform->display();

echo $OUTPUT->footer();
