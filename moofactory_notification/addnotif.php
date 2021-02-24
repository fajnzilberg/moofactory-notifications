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
 * Add notification.
 *
 * @package     local_moofactory_notification
 * @copyright   2020 Patrick ROCHET <patrick.r@lmsfactory.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
global $DB;

$number = rand(1, 999);

$data = new stdClass;
$data->base = 0;
$data->type = "courseevent";
$data->name = "Notification_$number";
$data->subject = "Notification_$number";
$data->bodyhtml = "";

$newid = $DB->insert_record('local_mf_notification', $data);
$nexturl = new moodle_url($CFG->wwwroot . '/local/moofactory_notification/managenotif.php', array('id' => $newid));
redirect($nexturl);
