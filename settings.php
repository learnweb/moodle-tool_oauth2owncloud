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

//if (has_capability('moodle/site:config', $systemcontext)) {
// Settings for the OAuth 2.0 and WebDAV clients are managed on an external page.
//    $ADMIN->add('tools', new admin_externalpage('tool_oauth2owncloud/auth',
//        'owncloud OAuth 2.0 Configuration',
//        "$CFG->wwwroot/$CFG->admin/tool/oauth2owncloud/index.php"));
// Load the full tree of settings.
if ($ADMIN->fulltree) {
    /*// Secret.
    $mform->addElement('passwordunmask', 'secret', get_string('secret', 'tool_oauth2owncloud'), array('size' => '64'));
    $mform->addRule('secret', get_string('required'), 'required', null, 'client');
    $mform->addRule('secret', get_string('err_alphanumeric', 'form'), 'alphanumeric', null, 'client');
    $mform->setDefault('secret', $this->_customdata['secret']);
    $mform->setType('secret', PARAM_ALPHANUM);

    // Second block of webdav specific options.
    $mform->addElement('header', 'webdav', get_string('webdavlegend', 'tool_oauth2owncloud'));
    // Server Address.
    $mform->addElement('text', 'server', get_string('server', 'tool_oauth2owncloud'), array('size' => '64'));
    $mform->addRule('server', get_string('required'), 'required', null, 'client');
    $mform->setDefault('server', $this->_customdata['server']);
    $mform->setType('server', PARAM_HOST);
    // Path to webdav.
    $mform->addElement('text', 'path', get_string('path', 'tool_oauth2owncloud'), array('size' => '64'));
    $mform->addRule('path', get_string('required'), 'required', null, 'client');
    $mform->setDefault('path', $this->_customdata['path']);
    $mform->setType('path', PARAM_PATH);
    // Type of server.

    $mform->addElement('select', 'protocol', get_string('protocol', 'tool_oauth2owncloud'), array('http' => 'HTTP', 'https' => 'HTTPS'));
    $mform->addRule('protocol', get_string('required'), 'required', null, 'client');
    $mform->setDefault('protocol', $this->_customdata['protocol']);

    // For some reason the 'formnovalidate' attribute does not work.
    $mform->addElement('submit', 'reset', 'Reset', 'formnovalidate=""');

    $this->add_action_buttons();*/
    $settings = new admin_settingpage('oauth2owncloud', 'owncloud OAuth 2.0 Configuration',
        'moodle/site:config', false);
    $ADMIN->add('tools', $settings);
    $setting = new admin_setting_configtext('clientid',
        get_string('clientid', 'tool_oauth2owncloud'),
        get_string('clientid', 'tool_oauth2owncloud'), '', PARAM_TEXT, '64');
    $settings->add($setting);
    $setting = new admin_setting_configtext('secret',
        get_string('secret', 'tool_oauth2owncloud'),
        get_string('secret', 'tool_oauth2owncloud'), '', PARAM_TEXT, '64');
    $settings->add($setting);
    $setting = new admin_setting_configtext('server',
        get_string('server', 'tool_oauth2owncloud'),
        get_string('server', 'tool_oauth2owncloud'), '', PARAM_TEXT, '64');
    $settings->add($setting);
    $setting = new admin_setting_configtext('path',
        get_string('path', 'tool_oauth2owncloud'),
        get_string('path', 'tool_oauth2owncloud'), '', PARAM_TEXT, '64');
    $settings->add($setting);
    // $name, $visiblename, $description, $defaultsetting, $choices
    $setting = new admin_setting_configselect('protocol',
        get_string('protocol', 'tool_oauth2owncloud'),
        get_string('protocol', 'tool_oauth2owncloud'), 'https', array('http' => 'HTTP', 'https' => 'HTTPS'));
    $settings->add($setting);
    // Port of server.
    /*$mform->addElement('text', 'port', get_string('port', 'tool_oauth2owncloud'), array('size' => '8'));
    $mform->addRule('port', get_string('err_numeric', 'form'), 'numeric', null, 'client');
    $mform->setDefault('port', $this->_customdata['port']);
    $mform->setType('port', PARAM_INT);*/
    $setting = new admin_setting_configtext('port',
        get_string('err_numeric', 'form'), 'numeric', '', PARAM_TEXT, '8');
    $settings->add($setting);
}
