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
 * Settings.php for oauth2owncloud admin tool. Registrates the redirection to the external setting page.
 *
 * @package    tool_oauth2owncloud
 * @copyright  2017 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die('moodle_internal not defined');

if ($hassiteconfig) {

    $url = $CFG->wwwroot . '/' . $CFG->admin . '/tool/oauth2owncloud/settings.php';

    $settings = new admin_settingpage('oauth2owncloud', 'ownCloud OAuth 2.0 Configuration',
        'moodle/site:config', false);

    // Link to the OAuth 2.0 ownCloud App repository on github.
    $link = 'https://github.com/owncloud/oauth2';

    // Generates a netification to remind the administrator of the ownCloud App.
    $output = $OUTPUT->notification(get_string('oauth2app', 'tool_oauth2owncloud',
            '<a href="'.$link.'" target="_blank" rel="noopener noreferrer">OAuth 2.0 App</a>'), 'warning');

    $setting = new admin_setting_heading('tool_oauth2owncloud/oauth2app', $output, '');
    $settings->add($setting);

    $setting = new admin_setting_heading('tool_oauth2owncloud/oauth2', get_string('oauthlegend', 'tool_oauth2owncloud'),
            get_string('oauthinfo', 'tool_oauth2owncloud'));
    $settings->add($setting);

    $setting = new admin_setting_configtext('tool_oauth2owncloud/clientid',
            get_string('clientid', 'tool_oauth2owncloud'),
            get_string('help_oauth_param', 'tool_oauth2owncloud', 'client identifier'), '', PARAM_ALPHANUM, '64');
    $settings->add($setting);

    $setting = new admin_setting_configpasswordunmask('tool_oauth2owncloud/secret',
        get_string('secret', 'tool_oauth2owncloud'),
        get_string('help_oauth_param', 'tool_oauth2owncloud', 'secret'), '', PARAM_ALPHANUM, '64');
    $settings->add($setting);

    $setting = new admin_setting_heading('tool_oauth2owncloud/webdav', get_string('webdavlegend', 'tool_oauth2owncloud'),
            get_string('webdavinfo', 'tool_oauth2owncloud'));
    $settings->add($setting);

    $setting = new admin_setting_configtext('tool_oauth2owncloud/server',
        get_string('server', 'tool_oauth2owncloud'),
            get_string('help_server', 'tool_oauth2owncloud'), '', PARAM_HOST, '64');
    $settings->add($setting);

    $setting = new admin_setting_configtext('tool_oauth2owncloud/path',
        get_string('path', 'tool_oauth2owncloud'),
        get_string('help_path', 'tool_oauth2owncloud'), 'remote.php/webdav/', PARAM_PATH, '64');
    $settings->add($setting);

    $setting = new admin_setting_configselect('tool_oauth2owncloud/protocol',
        get_string('protocol', 'tool_oauth2owncloud'),
        get_string('help_protocol', 'tool_oauth2owncloud'), 'https', array('http' => 'HTTP', 'https' => 'HTTPS'));
    $settings->add($setting);

    // Port of server.
    $setting = new admin_setting_configtext('tool_oauth2owncloud/port',
        get_string('port', 'tool_oauth2owncloud'), get_string('help_port', 'tool_oauth2owncloud'), 443, PARAM_INT, '8');
    $settings->add($setting);

    $ADMIN->add('tools', $settings);
}
