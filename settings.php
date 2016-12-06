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

    $image = '<a href="http://www.sciebo.de" target="_new"><img src="' .
        $OUTPUT->pix_url('icon', 'tool_oauth2sciebo') . '" /></a>&nbsp;&nbsp;&nbsp;';


    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/clientid',
        get_string('clientid', 'tool_oauth2sciebo'),
        '', ''
        ));

    $sth = 'sth';
    $temp->add(new admin_setting_configtext('tool_oauth2sciebo/secret',
        get_string('secret', 'tool_oauth2sciebo'),
        get_string('oauthsciebo' , 'tool_oauth2sciebo', $sth),
        ''
        ));

    $ADMIN->add('authsettings', $temp);
}

