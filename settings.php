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
 * Version.php for oauth2sciebo admin tool
 *
 * @package    tool_oauth2sciebo
 * @copyright  2016 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die('moodle_internal not defined');

if ($hassiteconfig) {
    $temp = new admin_settingpage('oauth2sciebo', new lang_string('pluginname', 'tool_oauth2sciebo'));

    $temp->add(new admin_setting_heading('coursebank_proxy_head',
        get_string('configplugin', 'tool_oauth2sciebo'),
        ''
        ));

    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/clientid',
        get_string('clientid', 'tool_oauth2sciebo'),
        '', ''
        ));

    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/secret',
        get_string('secret', 'tool_oauth2sciebo'),
        '', ''
        ));

    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/auth_url',
        get_string('auth_url', 'tool_oauth2sciebo'),
        '', ''
    ));

    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/token_url',
        get_string('token_url', 'tool_oauth2sciebo'),
        '', ''
    ));

    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/server',
        get_string('server', 'tool_oauth2sciebo'),
        '', ''
    ));

    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/path',
        get_string('path', 'tool_oauth2sciebo'),
        '', ''
    ));

    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/user',
        get_string('user', 'tool_oauth2sciebo'),
        '', ''
    ));

    $temp->add(new admin_setting_configpasswordunmask('tool_oauth2sciebo/pass',
        get_string('pass', 'tool_oauth2sciebo'),
        '', ''
    ));

    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/port',
        get_string('port', 'tool_oauth2sciebo'),
        '', ''
    ));


    $temp->add(new admin_setting_configselect('tool_oauth2sciebo/auth',
        get_string('auth', 'tool_oauth2sciebo'),
        '', '', array('basic' => 'Basic', 'bearer' => 'Bearer')
    ));

    $temp->add(new admin_setting_configselect('tool_oauth2sciebo/type',
        get_string('type', 'tool_oauth2sciebo'),
        '', '', array('http' => 'HTTP', 'https' => 'HTTPS')
    ));

    // Where shall the settings be visible? Authsettings.
    $ADMIN->add('authsettings', $temp);
}

