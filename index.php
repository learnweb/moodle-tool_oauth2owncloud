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

require('../../../config.php');
require($CFG->libdir . '/adminlib.php');
require(__DIR__ . '/client_form.php');

admin_externalpage_setup('tool_oauth2owncloud/auth');

echo $OUTPUT->header();

// The default form values are initialized.
$elements = array("clientid", "secret", "server", "path");
$arr = array();

foreach ($elements as $e) {

    $def = get_config('tool_oauth2owncloud', $e);

    if ($def == null) {
        $arr[$e] = '';
    } else {
        $arr[$e] = $def;
    }
}

if (get_config('tool_oauth2owncloud', 'protocol') == null) {
    $arr['protocol'] = 'https';
} else {
    $arr['protocol'] = get_config('tool_oauth2owncloud', 'protocol');
}

if (get_config('tool_oauth2owncloud', 'port') == null || empty(get_config('tool_oauth2owncloud', 'port'))) {
    if ($arr['protocol'] == 'http') {
        $arr['port'] = 80;
    } else {
        $arr['port'] = 443;
    }
} else {
    $arr['port'] = get_config('tool_oauth2owncloud', 'port');
}

$mform = new tool_oauth2owncloud_client_form(null, $arr);


// If the cancel button has been pressed, the setting page is left.
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/my/'));
} else if ($fromform = $mform->get_data()) {
    if (isset($fromform->submitbutton)) {
        // If the settings were submitted and validated, they are saved into the Admin Tree to be accessible by the client.
        set_config('clientid', $fromform->clientid, 'tool_oauth2owncloud');
        set_config('secret', $fromform->secret, 'tool_oauth2owncloud');
        set_config('server', $fromform->server, 'tool_oauth2owncloud');
        set_config('path', $fromform->path, 'tool_oauth2owncloud');
        set_config('port', $fromform->port, 'tool_oauth2owncloud');
        set_config('protocol', $fromform->protocol, 'tool_oauth2owncloud');
    } else if (isset($fromform->reset)) {
        // If the reset button has been pressed, all settings are reset in the Admin Tree.
        set_config('clientid', '', 'tool_oauth2owncloud');
        set_config('secret', '', 'tool_oauth2owncloud');
        set_config('server', '', 'tool_oauth2owncloud');
        set_config('path', '', 'tool_oauth2owncloud');
        set_config('port', '', 'tool_oauth2owncloud');
        set_config('protocol', '', 'tool_oauth2owncloud');
        redirect(new moodle_url('/my/'));
    }
}

$mform->display();

echo $OUTPUT->footer();