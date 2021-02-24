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
 * Delete notification form.
 *
 * @package     local_moofactory_notification
 * @copyright   2020 Patrick ROCHET <patrick.r@lmsfactory.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');

class deletenotif_form extends moodleform {
    public function definition() {
        global $CFG, $DB;

        $mform = $this->_form;
        $id = $this->_customdata['id'];

        $mform->addElement('hidden', 'id', $id);
        $mform->setType('id', PARAM_RAW);

        $name = $DB->get_field('local_mf_notification', 'name', array('id' => $id));
        
        $mform->addElement('html', '<fieldset class="clearfix">');
        $mform->addElement('html', '<h5 style="margin-top:20px">'.get_string('deleteconfirm', 'local_moofactory_notification', '"'.$name.'"').'</h5>');
        $mform->addElement('html', '</fieldset>');

        $this->add_action_buttons();
    }
}