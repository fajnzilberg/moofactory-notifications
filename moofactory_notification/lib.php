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


function test(){
    set_config('test', 2000, 'local_moofactory_notification');
}

function local_moofactory_notification_extend_navigation_course($navigation, $course, $context) {
    global $OUTPUT, $PAGE, $DB;

    if(has_capability('moodle/course:configurecustomfields', $context)){
        $js = "";
        $path = $PAGE->url->get_path();
        $enabled = get_config('local_moofactory_notification', 'enabled');
        $coursesenrollments = get_config('local_moofactory_notification', 'coursesenrollments');
        $coursesevents = get_config('local_moofactory_notification', 'coursesevents');
        $coursesenrollmentstime = get_config('local_moofactory_notification', 'coursesenrollmentstime');

        // Actualisation de la valeur par défaut du champs notification des inscriptions aux cours en fonction de la valeur de définie au niveau du plugin
        $array = Array();
        $record = $DB->get_record('local_mf_notification', array('id'=>get_config('local_moofactory_notification', 'coursesenrollmentsnotification')));
        $notifdefaultvalue = $record->name;
        $id = $DB->get_field('customfield_field', 'id', array('shortname' => 'courseenrollmentsnotification'));
        if ($id) {
            $field = \core_customfield\field_controller::create($id);
            $handler = $field->get_handler();
            require_login();
            if (!$handler->can_configure()) {
                print_error('nopermissionconfigure', 'core_customfield');
            }

            $records = $DB->get_records('local_mf_notification', array('type'=>'courseenroll'));
            foreach($records as $record) {
                $array[] = $record->name;
            }
            $options = implode("\n", $array);
            
            $data = new stdClass();
            $data->configdata = array("required" => "0", "uniquevalues" => "0", "options" => $options, "defaultvalue" => $notifdefaultvalue, "checkbydefault" => "0",  "locked" => "0",  "visibility" => "2");
            
            $handler->save_field_configuration($field, $data);
        }

        // Actualisation de la valeur par défaut du champs notification des évènements de cours en fonction de la valeur de définie au niveau du plugin
        $array = Array();
        $record = $DB->get_record('local_mf_notification', array('id'=>get_config('local_moofactory_notification', 'courseseventsnotification')));
        $notifdefaultvalue = $record->name;
        $id = $DB->get_field('customfield_field', 'id', array('shortname' => 'courseeventsnotification'));
        if ($id) {
            $field = \core_customfield\field_controller::create($id);
            $handler = $field->get_handler();
            require_login();
            if (!$handler->can_configure()) {
                print_error('nopermissionconfigure', 'core_customfield');
            }

            $records = $DB->get_records('local_mf_notification', array('type'=>'courseevent'));
            foreach($records as $record) {
                $array[] = $record->name;
            }
            $options = implode("\n", $array);
            
            $data = new stdClass();
            $data->configdata = array("required" => "0", "uniquevalues" => "0", "options" => $options, "defaultvalue" => $notifdefaultvalue, "checkbydefault" => "0",  "locked" => "0",  "visibility" => "2");
            
            $handler->save_field_configuration($field, $data);
        }

        if($path == "/course/edit.php"){
            $courseid = $PAGE->url->get_param("id");
            $courseenrollmentstime = local_moofactory_notification_getCustomfield($courseid, 'courseenrollmentstime', 'text');
            
            $js .= "$('#id_customfield_courseenrollmentsnotification option[value=\"0\"]').remove();";
            $js .= "$('#id_customfield_courseeventsnotification option[value=\"0\"]').remove();";
            $configvars = ['daysbeforeevents1', 'hoursbeforeevents1', 'daysbeforeevents2', 'hoursbeforeevents2', 'daysbeforeevents3', 'hoursbeforeevents3'];
            if(!$enabled){
                $js .= "$('#id_customfield_courseenrollments').attr('disabled', 'disabled');";
                $js .= "$('#id_customfield_courseenrollmentstime').attr('disabled', 'disabled');";
                $js .= "$('#id_customfield_courseenrollmentsnotification').attr('disabled', 'disabled');";
                $js .= "$('#id_customfield_courseevents').attr('disabled', 'disabled');";
                $js .= "$('#id_customfield_courseeventscheckavailability').attr('disabled', 'disabled');";
                $js .= "$('#id_customfield_courseeventsnotification').attr('disabled', 'disabled');";
                foreach($configvars as $configvar){
                    $name = 'id_customfield_'.$configvar;
                    $js .= "$('#$name').attr('disabled', 'disabled');";
                }
            }
            else{
                if(!$coursesenrollments){
                    $js .= "$('#id_customfield_courseenrollments').attr('disabled', 'disabled');";
                    $js .= "$('#id_customfield_courseenrollmentstime').attr('disabled', 'disabled');";
                    $js .= "$('#id_customfield_courseenrollmentsnotification').attr('disabled', 'disabled');";
                }
                if(!$coursesevents){
                    $js .= "$('#id_customfield_courseevents').attr('disabled', 'disabled');";
                    $js .= "$('#id_customfield_courseeventscheckavailability').attr('disabled', 'disabled');";
                    $js .= "$('#id_customfield_courseeventsnotification').attr('disabled', 'disabled');";
                    foreach($configvars as $configvar){
                        $name = 'id_customfield_'.$configvar;
                        $js .= "$('#$name').attr('disabled', 'disabled');";
                    }
                }
            }

            if(is_null($courseenrollmentstime)){
                $js .= "$('#id_customfield_courseenrollmentstime').val($coursesenrollmentstime);";
            }

            $configvars[] = 'courseenrollmentstime';
            foreach($configvars as $configvar){
                $name = 'id_customfield_'.$configvar;
                $msg = get_string('notanumber', 'local_moofactory_notification');
                $js .= "$('#$name').blur(function(){";
                $js .= "    if(isNaN($('#$name').val())){";
                $js .= "        $('#id_saveanddisplay').attr('disabled', 'disabled');";
                $js .= "        $('#$name').addClass('is-invalid');";
                $js .= "        $('#id_error_customfield_$configvar').html('$msg');";
                $js .= "    }";
                $js .= "    else{";
                $js .= "        $('#$name').removeClass('is-invalid');";
                $js .= "        $('#id_error_customfield_$configvar').html('');";
                $js .= "        ret = checkValues();";
                $js .= "        if(ret){";
                $js .= "            $('#id_saveanddisplay').removeAttr('disabled');";
                $js .= "        }";
                $js .= "    }";
                $js .= "});";
            }

            $js .= "function checkValues(){";
            $js .= "    var configvars = ['courseenrollmentstime', 'daysbeforeevents1', 'hoursbeforeevents1', 'daysbeforeevents2', 'hoursbeforeevents2', 'daysbeforeevents3', 'hoursbeforeevents3'];";
            $js .= "    var ret = true;";
            $js .= "    for(i=0;i<configvars.length;i++){";
            $js .= "        if(isNaN($('#id_customfield_'+configvars[i]).val())){";
            $js .= "            ret &= false;";
            $js .= "        }";
            $js .= "    }";
            $js .= "    return ret;";
            $js .= "}";
        }



        // Ajout de l'item "Activation des notifications" dans le menu "Modifier"" des activités
        if($path == "/course/view.php"){
            if($enabled && $coursesevents){
                $courseid = $PAGE->url->get_param("id");

                $courseevents = local_moofactory_notification_getCustomfield($courseid, 'courseevents', 'checkbox');

                if(empty($courseevents) && $coursesevents){
                    $menuitem = '<a class="dropdown-item editing_mfnotification menu-action cm-edit-action"';
                    $menuitem .= ' data-action="mfnotification" role="menuitem"';
                    $menuitem .= ' href="' . new moodle_url('/local/moofactory_notification/module.php', array('courseid' => $courseid, 'id' => 'moduleid')) . '"';
                    $menuitem .= ' title="' . get_string('menuitem', 'local_moofactory_notification') . '">';
                    $menuitem .= $OUTPUT->pix_icon('t/email', get_string('menuitem', 'local_moofactory_notification'));
                    $menuitem .= '<span class="menu-action-text">' . get_string('menuitem', 'local_moofactory_notification') . '</span>';
                    $menuitem .= '</a>';

                    $js .= "gmenuitem = '$menuitem';";
                    $js .= "$('.activity .dropdown-menu.dropdown-menu-right').each(function(index, element ){";
                    $js .= "    $(element).parents().each(function(index, element){";
                    $js .= "        if($(element).attr('data-owner') != undefined){";
                    $js .= "            owner = $(element).attr('data-owner');";
                    $js .= "            owner = owner.replace('#module-', '');";
                    $js .= "            menuitem = gmenuitem.replace('moduleid', owner);";
                    $js .= "        }";
                    $js .= "    });";
                    $js .= "    $(element).append(menuitem);";
                    $js .= "});";

                }
            }
        }

        $PAGE->requires->js_init_code($js, true);
}

}

function local_moofactory_notification_user_enrolment_created($event) : bool {
    global $DB;

    if(!empty($event)){
        $courseid = $event->courseid;
        $userid = $event->relateduserid;
    }
    else{
        $courseid = get_config('local_moofactory_notification', 'enrollcourseid');
        $userid = get_config('local_moofactory_notification', 'enrolluserid');
    }
    $user = $DB->get_record('user', array('id'=>$userid));

    // Activation des notifications
    $enabled = get_config('local_moofactory_notification', 'enabled');
    // Activation des inscriptions aux cours
    $coursesenrollments = get_config('local_moofactory_notification', 'coursesenrollments');
    // Tableau des notification de type courseenroll
    $courseenrollmentsnotifications = $DB->get_records('local_mf_notification', array('type'=>'courseenroll'));

    // si les notifications sont activées
    if(!empty($enabled)){
        // si les notifications d'inscriptions aux cours sont activées
        if(!empty($coursesenrollments)){
            $courseenrollments = local_moofactory_notification_getCustomfield($courseid, 'courseenrollments', 'checkbox');
            // si les notifications d'inscriptions au cours courant sont activées
            if(!empty($courseenrollments)){
                $courseenrollmentstime = local_moofactory_notification_getCustomfield($courseid, 'courseenrollmentstime', 'text');
                // S'il n'y a pas de délai programmé, envoi immédiat
                if(empty($courseenrollmentstime)){
                    // message
                    local_moofactory_notification_prepare_email($user, $courseid, $courseenrollmentsnotifications);
                }
                // Sinon, mise en liste d'attente dans la table 'local_mf_enrollnotif'
                else{
                    $notificationtime = $courseenrollmentstime * 60;
                    $record = new stdclass();
                    $record->userid = $userid;
                    $record->courseid = $courseid;
                    $record->notificationtime = $notificationtime + time();

                    $id = $DB->insert_record('local_mf_enrollnotif', $record);
                }
            }
        }
    }
    return true;
}

function local_moofactory_notification_send_coursesenroll_notification(){
    global $DB;

    // Maintenant
    $time = time();
    var_dump(date("d/m/Y H:i:s", $time));

    // La dernière fois que la tâche s'est exécutée
    $previouscourseenrolltasktime = get_config('local_moofactory_notification', 'previouscourseenrolltasktime');
    if(empty($previouscourseenrolltasktime)){
        set_config('previouscourseenrolltasktime', $time, 'local_moofactory_notification');
        return;
    }
    else{
        set_config('previouscourseenrolltasktime', $time, 'local_moofactory_notification');
    }

    $sql = "SELECT * FROM {local_mf_enrollnotif} ";
    $sql .= "WHERE notificationtime > ? AND notificationtime <= ?";
    $records = $DB->get_records_sql(
        $sql,
        array($previouscourseenrolltasktime, $time));

    if(!empty($records)){
        foreach($records as $record){
            $courseid = $record->courseid;
            $userid = $record->userid;
            $enrolled = is_enrolled(context_course::instance($courseid), $userid);

            // Si le user courant est bien inscrit au cours coorespondant
            if($enrolled){
                $user = $DB->get_record('user', array('id'=>$userid));
                // Activation des notifications
                $enabled = get_config('local_moofactory_notification', 'enabled');
                // Activation des inscriptions aux cours
                $coursesenrollments = get_config('local_moofactory_notification', 'coursesenrollments');
                // Tableau des notification de type courseenroll
                $courseenrollmentsnotifications = $DB->get_records('local_mf_notification', array('type'=>'courseenroll'));

                // Si les notifications sont activées
                if(!empty($enabled)){
                    // si les notifications d'inscriptions aux cours sont activées
                    if(!empty($coursesenrollments)){
                        $courseenrollments = local_moofactory_notification_getCustomfield($courseid, 'courseenrollments', 'checkbox');
                        // si les notifications d'inscriptions au cours courant sont activées
                        if(!empty($courseenrollments)){
                        // message
                        local_moofactory_notification_prepare_email($user, $courseid, $courseenrollmentsnotifications);
                        }
                    }
                }
            }
            // Suppression de la ligne correspondant à l'envoi qui vient d'être effectué dans la table 'local_mf_enrollnotif'
            $DB->delete_records('local_mf_enrollnotif', array('userid'=>$userid, 'courseid'=>$courseid, 'notificationtime'=>$record->notificationtime));
        }
    }
}

function local_moofactory_notification_send_coursesevents_notification(){
    global $CFG, $DB;
    
    require_once($CFG->dirroot.'/calendar/lib.php');

    // Activation des notifications
    $enabled = get_config('local_moofactory_notification', 'enabled');
    // Activation évènements de type cours 
    $coursesevents = get_config('local_moofactory_notification', 'coursesevents');
    // Tableau des notification de type courseevent
    $courseeventsnotifications = $DB->get_records('local_mf_notification', array('type'=>'courseevent'));

    // Maintenant
    $time = time();

    // La dernière fois que la tâche s'est exécutée
    $previouscourseeventstasktime = get_config('local_moofactory_notification', 'previouscourseeventstasktime');
    if(empty($previouscourseeventstasktime)){
        set_config('previouscourseeventstasktime', $time, 'local_moofactory_notification');
        return;
    }
    else{
        set_config('previouscourseeventstasktime', $time, 'local_moofactory_notification');
    }

    // si les notifications sont activées
    if(!empty($enabled)){
        // si les évènements de type cours sont activées
        if(!empty($coursesevents)){
            // Tous les évènements à venir
            $events = calendar_get_legacy_events($previouscourseeventstasktime, 0, false, false, true, true, false);

            foreach($events as $event) {
                $courseid = $event->courseid;
                $coursecontext = \context_course::instance($courseid);
                // 'moodle/course:isincompletionreports' - this capability is allowed to only students
                $enrolledusers = get_enrolled_users($coursecontext, 'moodle/course:isincompletionreports');

                if (!empty($event->modulename)) {
                    $instances = get_fast_modinfo($event->courseid, $event->userid)->get_instances_of($event->modulename);
                    if (array_key_exists($event->instance, $instances)) {
                        $module = $instances[$event->instance];

                        $moduleid = $module->id;
                        $modulename = $module->name;
                        // Visibilité
                        $modulevisible = $module->visible;

                        // Restriction
                        $modulecheckavailabilityname = 'modulecheckavailability_'.$courseid.'_'.$moduleid;
                        $value = get_config('local_moofactory_notification', $modulecheckavailabilityname);
                        if($value === false){
                            $value = local_moofactory_notification_getCustomfield($courseid, 'courseeventscheckavailability', 'checkbox');
                        }
                        if(empty($value)){
                            $moduleavailable = true;
                        }
                        else{
                            $moduleavailable = $module->available;
                        }
                    }
                }
                
                // Pour l'évènement courant, on cherche les delais des trois rappels (cours ou activité)
                // Evènements liés au cours $courseid  
                $courseevents = local_moofactory_notification_getCustomfield($courseid, 'courseevents', 'checkbox');
                if(!empty($courseevents)){
                    // Valeurs des rappels liés au cours $courseid
                    $delays = local_moofactory_notification_get_delays('course', $courseid);
                }
                else{
                    // Evènements liés à l'activité $moduleid  
                    $moduleevents = get_config('local_moofactory_notification', 'moduleevents_'.$courseid.'_'.$moduleid.'');
                    echo("<br>moduleevents $courseid $moduleid<br>");
                    if(!empty($moduleevents)){
                        // Valeurs des rappels liés à l'activité $moduleid
                        $delays = local_moofactory_notification_get_delays('module', $courseid, $moduleid);
                    }
                }

                // Envoi des notifications si l'évènement est prévu à l'issue d'un des délais, au moment de la tâche courante.
                if(!empty($delays)){
                    foreach($delays as $delay) {
                        $targetedevents = calendar_get_legacy_events($previouscourseeventstasktime + $delay, $time + $delay, false, false, $courseid, true, false);
                        foreach($targetedevents as $targetedevent) {
                            if($targetedevent->id == $event->id){
                                // message
                                $notifvalue = (int)local_moofactory_notification_getCustomfield($courseid, 'courseeventsnotification', 'select');
                                if(!empty($notifvalue)){
                                    $courseeventsnotifications = array_values($courseeventsnotifications);
                                    $notifvalue--;
                                }
                                else{
                                    $notifvalue = get_config('local_moofactory_notification', 'courseseventsnotification');
                                }
                                $notif = $courseeventsnotifications[$notifvalue];
                                $bodyhtml = urldecode($notif->bodyhtml);
                                $find = $CFG->wwwroot."/";
                                $bodyhtml = str_replace($find,"",$bodyhtml);

                                $variables = local_moofactory_notification_fetch_variables($bodyhtml);

                                foreach ($enrolledusers as $user) {
                                    if(!is_siteadmin($user) && $modulevisible && $moduleavailable){
                                        $data = new stdClass();
                                        $data->firstname = $user->firstname;
                                        $data->lastname = $user->lastname;
                                        $data->username = $user->username;
                                        $data->eventdate = date("d/m/Y à H:i", $targetedevent->timestart);
                                        $data->eventname = $targetedevent->name;
                                        $course = $DB->get_record('course', array('id' => $courseid), 'fullname');
                                        $data->coursename = $course->fullname;
                                        $data->courseurl = $CFG->wwwroot . '/course/view.php?id=' . $courseid;
                                        $data->activityname = $modulename;
                                        $data->lmsurl = $CFG->wwwroot;
                                        $data->lmsname = $SITE->fullname;

                                        $bodyhtml = local_moofactory_notification_replace_variables($variables, $bodyhtml, $data);

                                        $msg = new stdClass();
                                        $msg->subject = $notif->subject;
                                        $msg->from = "moofactory";
                                        $msg->bodytext = "";
                                        $msg->bodyhtml = $bodyhtml;

                                        var_dump($bodyhtml);
                                        $ret = local_moofactory_notification_send_email($user, $msg, $courseid);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function local_moofactory_notification_getCustomfield($courseid, $name, $type){
    global $DB;

    switch($type){
        case "select" :
        case "checkbox" :
            $fieldvalue = "intvalue";
            break;
        case "text" :
            $fieldvalue = "charvalue";
            break;
        }
    $sql = "SELECT cd.$fieldvalue FROM {customfield_data} cd ";
    $sql .= "LEFT JOIN {customfield_field} cf ON cf.id = cd.fieldid ";
    $sql .= "WHERE cd.instanceid = ? AND cf.shortname = ?";
    $record = $DB->get_record_sql(
        $sql,
        array($courseid, $name));
    $value = $record->$fieldvalue;

    return $value ;
}

function local_moofactory_notification_replace_variables($variables, $html, $data) {
    
    foreach($variables as $variable){
        $find = "{{".$variable."}}";
        switch($variable){
            case "firstname" :
                $html = str_replace($find,$data->firstname,$html);
                break;
            case "lastname" :
                $html = str_replace($find,$data->lastname,$html);
                break;
            case "username" :
                $html = str_replace($find,$data->username,$html);
                break;
            case "eventdate" :
                $html = str_replace($find,$data->eventdate,$html);
                break;
            case "eventname" :
                $html = str_replace($find,$data->eventname,$html);
                break;
            case "coursename" :
                $html = str_replace($find,$data->coursename,$html);
                break;
            case "courseurl" :
                $html = str_replace($find,$data->courseurl,$html);
                break;
            case "activityname" :
                $html = str_replace($find,$data->activityname,$html);
                break;
            case "lmsurl" :
                $html = str_replace($find,$data->lmsurl,$html);
                break;
            case "lmsname" :
                $html = str_replace($find,$data->lmsname,$html);
                break;
        }
    }
    return $html;
}

function local_moofactory_notification_prepare_email($user, $courseid, $courseenrollmentsnotifications) {
    global $DB, $CFG, $SITE;

    $notifvalue = (int)local_moofactory_notification_getCustomfield($courseid, 'courseenrollmentsnotification', 'select');
    if(!empty($notifvalue)){
        $courseenrollmentsnotifications = array_values($courseenrollmentsnotifications);
        $notifvalue--;
    }
    else{
        $notifvalue = get_config('local_moofactory_notification', 'coursesenrollmentsnotification');
    }
    $notif = $courseenrollmentsnotifications[$notifvalue];
    $bodyhtml = urldecode($notif->bodyhtml);
    $find = $CFG->wwwroot."/";
    $bodyhtml = str_replace($find,"",$bodyhtml);
    
    $variables = local_moofactory_notification_fetch_variables($bodyhtml);
    
    $data = new stdClass();
    $data->firstname = $user->firstname;
    $data->lastname = $user->lastname;
    $data->username = $user->username;
    $data->eventdate = "";
    $data->eventname = "";
    $course = $DB->get_record('course', array('id' => $courseid), 'fullname');
    $data->coursename = $course->fullname;
    $data->courseurl = $CFG->wwwroot . '/course/view.php?id=' . $courseid;
    $data->activityname = "";
    $data->lmsurl = $CFG->wwwroot;
    $data->lmsname = $SITE->fullname;
    
    $bodyhtml = local_moofactory_notification_replace_variables($variables, $bodyhtml, $data);
    
    $msg = new stdClass();
    $msg->subject = $notif->subject;
    $msg->from = "moofactory";
    $msg->bodytext = "";
    $msg->bodyhtml = $bodyhtml;
    
    $ret = local_moofactory_notification_send_email($user, $msg, $courseid);
}

function local_moofactory_notification_send_email($user, $msg, $courseid) {
        global $USER;

    if (!isset($user->email) && empty($user->email)) {
        return false;
    }

    $message = new \core\message\message();
    $message->courseid = $courseid; // This is required in recent versions, use it from 3.2 on https://tracker.moodle.org/browse/MDL-47162
    $message->component = 'local_moofactory_notification';
    $message->name = 'coursesevents_notification';
    $message->userfrom = core_user::get_noreply_user();
    $message->userto = $user;
    $message->subject = $msg->subject;
    $message->fullmessage = $msg->bodytext;
    $message->fullmessagehtml = $msg->bodyhtml;
    // With FORMAT_HTML, most outputs will use fullmessagehtml, and convert it to plain text if necessary.
    // but some output plugins will behave differently (airnotifier only uses fullmessage)
    $message->fullmessageformat = FORMAT_HTML;
    // If smallmessage is not empty,
    // it will have priority over the 2 other fields, with a hard coded FORMAT_PLAIN.
    // But some output plugins may need it, as jabber currently does.
    $message->smallmessage = '';
    $message->notification = '1';
    $message->contexturl = new moodle_url('/course/view.php', array('id' => $courseid));
    $message->contexturlname = 'Your course';

    $messageid = message_send($message);
    return $messageid;
}

function local_moofactory_notification_get_delays($type, $courseid, $moduleid = 0){
    $configvars = ['daysbeforeevents1', 'hoursbeforeevents1', 'daysbeforeevents2', 'hoursbeforeevents2', 'daysbeforeevents3', 'hoursbeforeevents3'];

    foreach($configvars as $configvar){
        if($type == 'course'){
            $value = local_moofactory_notification_getCustomfield($courseid, $configvar, 'text');
        }
        else{
            $configvarid = 'module'.$configvar.'_'.$courseid.'_'.$moduleid;
            $value = get_config('local_moofactory_notification', $configvarid);

        }

        $idrappel = (int)substr($configvar, -1);
        switch($idrappel){
            case 1:
                if(strpos($configvar, 'days')!==false){
                    $daysvalue1 = $value;
                }
                if(strpos($configvar, 'hours')!==false){
                    $hoursvalue1 = $value;
                }
                break;
            case 2:
                if(strpos($configvar, 'days')!==false){
                    $daysvalue2 = $value;
                }
                if(strpos($configvar, 'hours')!==false){
                    $hoursvalue2 = $value;
                }
                break;
            case 3:
                if(strpos($configvar, 'days')!==false){
                    $daysvalue3 = $value;
                }
                if(strpos($configvar, 'hours')!==false){
                    $hoursvalue3 = $value;
                }
                break;
        }
    }

    $delays = array();
    if(!($daysvalue1 == "") || !($hoursvalue1 == "")){
        $delay1 = (int)$daysvalue1 * 60 * 60 * 24 + (int)$hoursvalue1 * 60 * 60;
        $delays[] = $delay1;
    }
    if(!($daysvalue2 == "") || !($hoursvalue2 == "")){
        $delay2 = (int)$daysvalue2 * 60 * 60 * 24 + (int)$hoursvalue2 * 60 * 60;
        $delays[] = $delay2;
    }
    if(!($daysvalue3 == "") || !($hoursvalue3 == "")){
        $delay3 = (int)$daysvalue3 * 60 * 60 * 24 + (int)$hoursvalue3 * 60 * 60;
        $delays[] = $delay3;
    }
    return $delays;
}

/**
 * Return an array of variable names
 * @param string template containing {{variable}} variables 
 * @return array of variable names parsed from template string
 */
function local_moofactory_notification_fetch_variables($html){
	$matches = array();
	$t = preg_match_all('/{{(.*?)}}/', $html, $matches);
	if(count($matches)>1){
        $uniquearray= array_unique($matches[1]);
		return array_values($uniquearray);
	}else{
		return array();
	}
}
