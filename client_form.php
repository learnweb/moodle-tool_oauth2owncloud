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
 * Form class for the required client settings for the oauth2sciebo admin tool.
 *
 * @package    tool_oauth2sciebo
 * @copyright  2016 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require('../../../lib/formslib.php');

class tool_oauth2sciebo_client_form extends moodleform {

    function definition() {
        global $CFG;

        $mform = $this->_form;

        // First block of oauth2 specific options.
        $mform->addElement('header', 'oauth', get_string('oauthlegend', 'tool_oauth2sciebo'));
        // Client ID:
        $mform->addElement('text', 'clientid', get_string('clientid', 'tool_oauth2sciebo'), array('size' => '64'));
        $mform->addRule('clientid', get_string('required'), 'required', null, 'client');
        $mform->addRule('clientid', get_string('err_alphanumeric'), 'alphanumeric', null, 'client');
        $mform->setDefault('clientid', $this->_customdata['clientid']);
        $mform->setType('clientid', PARAM_ALPHANUM);
        // Secret:
        $mform->addElement('passwordunmask', 'secret', get_string('secret', 'tool_oauth2sciebo'), array('size' => '64'));
        $mform->addRule('secret', get_string('required'), 'required', null, 'client');
        $mform->addRule('secret', get_string('err_alphanumeric'), 'alphanumeric', null, 'client');
        $mform->setDefault('secret', $this->_customdata['secret']);
        $mform->setType('secret', PARAM_ALPHANUM);

        // Second block of webdav specific options.
        $mform->addElement('header', 'webdav', get_string('webdavlegend', 'tool_oauth2sciebo'));
        // Server Address:
        $mform->addElement('text', 'server', get_string('server', 'tool_oauth2sciebo'), array('size' => '64'));
        $mform->addRule('server', get_string('required'), 'required', null, 'client');
        $mform->setDefault('server', $this->_customdata['server']);
        $mform->setType('server', PARAM_HOST);
        // Path to webdav:
        $mform->addElement('text', 'path', get_string('path', 'tool_oauth2sciebo'), array('size' => '64'));
        $mform->addRule('path', get_string('required'), 'required', null, 'client');
        $mform->setDefault('path', $this->_customdata['path']);
        $mform->setType('path', PARAM_PATH);
        // Type of server:
        $mform->addElement('select', 'type', get_string('type', 'tool_oauth2sciebo'), array('http' => 'HTTP', 'https' => 'HTTPS'));
        $mform->addRule('type', get_string('required'), 'required', null, 'client');
        $mform->setDefault('type', $this->_customdata['type']);
        // Port of server:
        $mform->addElement('text', 'port', get_string('port', 'tool_oauth2sciebo'), array('size' => '8'));
        $mform->addRule('port', get_string('err_numeric'), 'numeric', null, 'client');
        $mform->setDefault('port', $this->_customdata['port']);
        $mform->setType('port', PARAM_INT);

        $mform->addElement('submit', 'reset', 'Reset');

        $this->add_action_buttons();
    }
}