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
 * index.php for oauth2sciebo admin tool. The client settings are managed in here. The main advantage of this is, that the
 * required settings are checked by the moodleform before saving them in the Admin Tree.
 *
 * @package    tool_oauth2sciebo
 * @copyright  2016 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../../config.php');
require('../../../lib/adminlib.php');
require(__DIR__ . '/client_form.php');

admin_externalpage_setup('tool_oauth2sciebo/auth');

echo $OUTPUT->header();

$mform = new tool_oauth2sciebo_client_form();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/my/'));
} else if ($fromform = $mform->get_data()) {
    // If the settings were submitted and validated, they are saved into the Admin Tree to be accessible by the client.
    set_config('clientid', $fromform->clientid, 'tool_oauth2sciebo');
    set_config('secret', $fromform->secret, 'tool_oauth2sciebo');
    set_config('server', $fromform->server, 'tool_oauth2sciebo');
    set_config('path', $fromform->path, 'tool_oauth2sciebo');
    set_config('port', $fromform->port, 'tool_oauth2sciebo');
    set_config('type', $fromform->type, 'tool_oauth2sciebo');
    redirect(new moodle_url('/my/'));
}

$mform->display();

echo $OUTPUT->footer();