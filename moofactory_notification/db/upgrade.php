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
 * Upgrade scripts for the notification local plugin
 *
 * @package    local_moofactory_notification
 * @copyright  2020 Patrick ROCHET <patrick.r@lmsfactory.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade script for format_moofactory
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_local_moofactory_notification_upgrade($oldversion) {
    global $CFG, $DB;
    require_login();

    // Création des champs personnalisés de cours dans la catégorie 'Notifications'.
    $categoryid = $DB->get_field('customfield_category', 'id', array('name' => get_string('notifications_category', 'local_moofactory_notification')));

    if(empty($categoryid)){
        $handler = core_course\customfield\course_handler::create();
        $categoryid = $handler->create_category(get_string('notifications_category', 'local_moofactory_notification'));
    }

    // ********** Peut être utile ***********
    //$handler->move_field(field_controller $field, int $categoryid, int $beforeid = 0)


    if ($categoryid) {
        $category = \core_customfield\category_controller::create($categoryid);

        // Champ 'Inscriptions à ce cours'
        $id = $DB->get_field('customfield_field', 'id', array('shortname' => 'courseenrollments'));
        if(empty($id)){
            $type = "checkbox";
            $field = \core_customfield\field_controller::create(0, (object)['type' => $type], $category);

            $handler = $field->get_handler();
            if (!$handler->can_configure()) {
                print_error('nopermissionconfigure', 'core_customfield');
            }

            $data = new stdClass();
            $data->name = get_string('courseenrollments', 'local_moofactory_notification');
            $data->shortname = 'courseenrollments';
            $data->configdata = array("required" => "0", "uniquevalues" => "0", "checkbydefault" => "0",  "locked" => "0",  "visibility" => "2");
            $data->mform_isexpanded_id_header_specificsettings = 1;
            $data->mform_isexpanded_id_course_handler_header = 1;
            $data->categoryid = $categoryid;
            $data->type = $type;
            $data->id = 0;
    
            $handler->save_field_configuration($field, $data);
        }

        // Champ 'Delai'
        $id = $DB->get_field('customfield_field', 'id', array('shortname' => 'courseenrollmentstime'));
        if(empty($id)){
            $type = "text";
            $field = \core_customfield\field_controller::create(0, (object)['type' => $type], $category);

            $handler = $field->get_handler();
            if (!$handler->can_configure()) {
                print_error('nopermissionconfigure', 'core_customfield');
            }

            $data = new stdClass();
            $data->name = get_string('courseenrollmentstime', 'local_moofactory_notification');
            $data->shortname = 'courseenrollmentstime';
            $data->configdata = array("required" => "0", "uniquevalues" => "0", "defaultvalue" => "", "displaysize" => 3, "maxlength" => 6, "ispassword" => "0", "link" => "",  "locked" => "0",  "visibility" => "2");
            $data->description_editor = array("text" => get_string('courseenrollmentstime_desc', 'local_moofactory_notification'), "format" => "1", "itemid" => 123);
            $data->mform_isexpanded_id_header_specificsettings = 1;
            $data->mform_isexpanded_id_course_handler_header = 1;
            $data->categoryid = $categoryid;
            $data->type = $type;
            $data->id = 0;
    
            $handler->save_field_configuration($field, $data);
        }

        // Select choix de la notification
        $id = $DB->get_field('customfield_field', 'id', array('shortname' => 'courseenrollmentsnotification'));
        if(empty($id)){
            $type = "select";
            $field = \core_customfield\field_controller::create(0, (object)['type' => $type], $category);

            $handler = $field->get_handler();
            if (!$handler->can_configure()) {
                print_error('nopermissionconfigure', 'core_customfield');
            }

            $array = Array();
            $records = $DB->get_records('local_mf_notification', array('type'=>'courseenroll'));
            foreach($records as $record) {
                $array[] = $record->name;
            }
            $options = implode("\n", $array);
            $record = $DB->get_record('local_mf_notification', array('id'=>get_config('local_moofactory_notification', 'coursesenrollmentsnotification')));
            $defaultvalue = $record->name;
            
            $data = new stdClass();
            $data->name = get_string('usednotification', 'local_moofactory_notification');
            $data->shortname = 'courseenrollmentsnotification';
            $data->configdata = array("required" => "0", "uniquevalues" => "0", "options" => $options, "defaultvalue" => $defaultvalue, "checkbydefault" => "0",  "locked" => "0",  "visibility" => "2");
            $data->mform_isexpanded_id_header_specificsettings = 1;
            $data->mform_isexpanded_id_course_handler_header = 1;
            $data->categoryid = $categoryid;
            $data->type = $type;
            $data->id = 0;
    
            $handler->save_field_configuration($field, $data);
        }

        // Champ 'Evènements liés à ce cours'
        $id = $DB->get_field('customfield_field', 'id', array('shortname' => 'courseevents'));
        if(empty($id)){
            $type = "checkbox";
            $field = \core_customfield\field_controller::create(0, (object)['type' => $type], $category);

            $handler = $field->get_handler();
            if (!$handler->can_configure()) {
                print_error('nopermissionconfigure', 'core_customfield');
            }

            $data = new stdClass();
            $data->name = get_string('courseevents', 'local_moofactory_notification');
            $data->shortname = 'courseevents';
            $data->configdata = array("required" => "0", "uniquevalues" => "0", "checkbydefault" => "0",  "locked" => "0",  "visibility" => "2");
            $data->mform_isexpanded_id_header_specificsettings = 1;
            $data->mform_isexpanded_id_course_handler_header = 1;
            $data->categoryid = $categoryid;
            $data->type = $type;
            $data->id = 0;
    
            $handler->save_field_configuration($field, $data);
        }

        // Champ 'Tenir compte des restrictions d'accès aux activités'
        $id = $DB->get_field('customfield_field', 'id', array('shortname' => 'courseeventscheckavailability'));
        if(empty($id)){
            $type = "checkbox";
            $field = \core_customfield\field_controller::create(0, (object)['type' => $type], $category);

            $handler = $field->get_handler();
            if (!$handler->can_configure()) {
                print_error('nopermissionconfigure', 'core_customfield');
            }

            $data = new stdClass();
            $data->name = get_string('courseeventscheckavailability', 'local_moofactory_notification');
            $data->shortname = 'courseeventscheckavailability';
            $data->configdata = array("required" => "0", "uniquevalues" => "0", "checkbydefault" => "0",  "locked" => "0",  "visibility" => "2");
            $data->mform_isexpanded_id_header_specificsettings = 1;
            $data->mform_isexpanded_id_course_handler_header = 1;
            $data->categoryid = $categoryid;
            $data->type = $type;
            $data->id = 0;
    
            $handler->save_field_configuration($field, $data);
        }

        // Select choix de la notification
        $id = $DB->get_field('customfield_field', 'id', array('shortname' => 'courseeventsnotification'));
        if(empty($id)){
            $type = "select";
            $field = \core_customfield\field_controller::create(0, (object)['type' => $type], $category);

            $handler = $field->get_handler();
            if (!$handler->can_configure()) {
                print_error('nopermissionconfigure', 'core_customfield');
            }

            $array = Array();
            $records = $DB->get_records('local_mf_notification', array('type'=>'courseevent'));
            foreach($records as $record) {
                $array[] = $record->name;
            }
            $options = implode("\n", $array);
            $record = $DB->get_record('local_mf_notification', array('id'=>get_config('local_moofactory_notification', 'courseseventsnotification')));
            $defaultvalue = $record->name;
            
            $data = new stdClass();
            $data->name = get_string('usednotification', 'local_moofactory_notification');
            $data->shortname = 'courseeventsnotification';
            $data->configdata = array("required" => "0", "uniquevalues" => "0", "options" => $options, "defaultvalue" => $defaultvalue, "checkbydefault" => "0",  "locked" => "0",  "visibility" => "2");
            $data->mform_isexpanded_id_header_specificsettings = 1;
            $data->mform_isexpanded_id_course_handler_header = 1;
            $data->categoryid = $categoryid;
            $data->type = $type;
            $data->id = 0;
    
            $handler->save_field_configuration($field, $data);
        }

        // Champs rappels
        $configvars = ['daysbeforeevents1', 'hoursbeforeevents1', 'daysbeforeevents2', 'hoursbeforeevents2', 'daysbeforeevents3', 'hoursbeforeevents3'];
        foreach($configvars as $configvar){
            $name = $configvar;
            $id = $DB->get_field('customfield_field', 'id', array('shortname' => $name));
            if(empty($id)){
                $type = "text";
                $field = \core_customfield\field_controller::create(0, (object)['type' => $type], $category);
    
                $handler = $field->get_handler();
                if (!$handler->can_configure()) {
                    print_error('nopermissionconfigure', 'core_customfield');
                }
    
                $data = new stdClass();
                $data->name = get_string($name, 'local_moofactory_notification');
                $data->shortname = $name;
                $data->configdata = array("required" => "0", "uniquevalues" => "0", "defaultvalue" => "", "displaysize" => 3, "maxlength" => 3, "ispassword" => "0", "link" => "",  "locked" => "0",  "visibility" => "2");
                $data->description_editor = array("text" => get_string($name.'_desc', 'local_moofactory_notification'), "format" => "1", "itemid" => 123);
                $data->mform_isexpanded_id_header_specificsettings = 1;
                $data->mform_isexpanded_id_course_handler_header = 1;
                $data->categoryid = $categoryid;
                $data->type = $type;
                $data->id = 0;
        
                $handler->save_field_configuration($field, $data);
            }
        }
    }

    return true;
}
