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
 * French strings for local_moofactory_notification.
 *
 * @package     local_moofactory_notification
 * @copyright   2020 Patrick ROCHET <patrick.r@lmsfactory.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Moo Factory Notification';
$string['notifications_category'] = 'Notifications';
$string['settings'] = 'Modifier les paramètres';
$string['managenotif'] = 'Gestion des notifications';
$string['enabled'] = 'Notifications activées';
$string['enabled_desc'] = 'Activation des notifications';
$string['eventstypes'] = 'Types d\'évènements activés';
$string['siteevents'] = 'Evènements de type site';
$string['siteevents_desc'] = 'Notifications des évènements de type site';
$string['coursesevents'] = 'Evènements de type cours';
$string['coursesevents_desc'] = 'Notifications des évènements de type cours';
$string['courseseventsnotification_desc'] = 'Choix du modèle de notification à utiliser pour les évènements de type cours';
$string['coursesenrollmentsnotification_desc'] = 'Choix du modèle de notification à utiliser pour les inscriptions à un cours';
$string['usersevents'] = 'Evènements de type utilisateur';
$string['usersevents_desc'] = 'Notifications des évènements de type utilisateur';
$string['coursesenrollments'] = 'Inscriptions aux cours';
$string['coursesenrollments_desc'] = 'Notifications suite à l\'inscription à un cours';
$string['coursesenrollmentstime'] = 'Delai';
$string['coursesenrollmentstime_desc'] = 'Délai avant l\'envoi de la notification (en minutes)';
$string['courseenrollments'] = 'Inscriptions à ce cours';
$string['courseenrollmentstime'] = 'Delai';
$string['courseenrollmentstime_desc'] = 'minute(s) après l\'inscription à ce cours';
$string['courseevents'] = 'Evènements liés à ce cours';
$string['courseeventscheckavailability'] = 'Tenir compte des restrictions d\'accès aux activités';
$string['usednotification'] = 'Notification utilisée';

$string['daysbeforeevents1'] = 'Premier rappel';
$string['daysbeforeevents1_desc'] = 'jour(s) avant les évènements';
$string['hoursbeforeevents1'] = 'et/ou';
$string['hoursbeforeevents1_desc'] = 'heure(s) avant les évènements';
$string['daysbeforeevents2'] = 'Deuxième rappel';
$string['daysbeforeevents2_desc'] = 'jour(s) avant les évènements';
$string['hoursbeforeevents2'] = 'et/ou';
$string['hoursbeforeevents2_desc'] = 'heure(s) avant les évènements';
$string['daysbeforeevents3'] = 'Troisième rappel';
$string['daysbeforeevents3_desc'] = 'jour(s) avant les évènements';
$string['hoursbeforeevents3'] = 'et/ou';
$string['hoursbeforeevents3_desc'] = 'heure(s) avant les évènements';
$string['menuitem'] = 'Activation des notifications';
$string['module'] = 'Activation des notifications pour ';
$string['moduleevents'] = 'Evènements liés à cette activité';
$string['modulecheckavailability'] = 'Tenir compte des restrictions d\'accès à cette activité';
$string['modulereset'] = 'Pour réinitialiser ces valeurs avec celles sauvegardées au niveau du cours, saisir 999 dans les champs concernés ci-dessus.';
$string['notanumber'] = 'La valeur saisie doit être un nombre';

$string['sendcourseseventsnotification'] = 'Envoi des notifications pour les évènements de type cours';
$string['sendcourseenrollmentsnotifications'] = 'Envoi des notifications lors des inscriptions aux cours';
$string['choose'] = 'Choisir une notification';
$string['notifications'] = 'Notifications';
$string['duplicate'] = 'Dupliquer';
$string['delete'] = 'Supprimer';
$string['add'] = 'Ajouter une notification';
$string['params'] = 'Paramètres';
$string['deletenotification'] = 'Supprimer une notification';
$string['deleteconfirm'] = 'Confirmer la suppression de la notification {$a}';
$string['required'] = 'Ce champ est requis';
$string['name'] = 'Nom';
$string['type'] = 'Type';
$string['subject'] = 'Objet';
$string['bodyhtml'] = 'Contenu';


// Capabilities.
$string['moofactory_notification:managenotifications']  = 'Gestion des notifications';
