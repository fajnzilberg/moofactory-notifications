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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot .'/local/local_moofactory_notification/lib.php');

class local_moofactory_observer
{
    public static function user_enrolment_created(\core\event\user_enrolment_created $event){
        global $CFG, $DB;
        //$event->courseid
        //$event->relateduserid
        //set_config('test', 1000, 'local_moofactory_notification');
        test();
        /*$record = new stdclass();
        $record->userid = 1;
        $record->courseid = 2;
        $record->notificationtime = 1000;

        $id = $DB->insert_record('local_mf_enrollnotif', $record);*/
    }
}
