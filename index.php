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
 * index.php for oauth2owncloud admin tool. The client settings are managed in here. The main advantage of this is, that the
 * required settings are checked by the moodleform before saving them in the Admin Tree.
 *
 * @package    tool_oauth2owncloud
 * @copyright  2017 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(__FILE__) . '/../../../config.php');

require_once($CFG->libdir.'/adminlib.php');


$PAGE->set_context(context_system::instance());
$context = context_system::instance();
// Check permissions.
require_login();
require_capability('moodle/site:config', $context);

admin_externalpage_setup('oauth2owncloud');

$pagetitle = get_string('pluginname', 'tool_oauth2owncloud');
$PAGE->set_title(get_string('pluginname', 'tool_oauth2owncloud'));
$PAGE->set_heading(get_string('pluginname', 'tool_oauth2owncloud'));
$PAGE->set_pagelayout('standard');
$content = '';

echo $OUTPUT->header();

echo $content;

echo $OUTPUT->footer();
