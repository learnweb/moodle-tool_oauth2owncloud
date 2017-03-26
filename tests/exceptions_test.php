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
 * Exception tests for the oauth2owncloud admin tool.
 *
 * @package    tool_oauth2owncloud
 * @group      tool_oauth2owncloud
 * @copyright  2017 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class tool_oauth2owncloud_exceptions_testcase extends advanced_testcase {

    public function test_auth() {
        $auth = new \tool_oauth2owncloud\authentication_exception('message');

        $this->assertEquals('authentication', $auth->errorcode);
        $this->assertEquals('tool_oauth2owncloud', $auth->module);
        $this->assertEquals('message', $auth->a);
    }

    public function test_socket() {
        $auth = new \tool_oauth2owncloud\socket_exception('message');

        $this->assertEquals('socket', $auth->errorcode);
        $this->assertEquals('tool_oauth2owncloud', $auth->module);
        $this->assertEquals('message', $auth->a);
    }

    public function test_config() {
        $auth = new \tool_oauth2owncloud\configuration_exception('message');

        $this->assertEquals('config', $auth->errorcode);
        $this->assertEquals('tool_oauth2owncloud', $auth->module);
        $this->assertEquals('message', $auth->a);
    }

    public function test_webdav() {
        $auth = new \tool_oauth2owncloud\webdav_response_exception('message');

        $this->assertEquals('response', $auth->errorcode);
        $this->assertEquals('tool_oauth2owncloud', $auth->module);
        $this->assertEquals('message', $auth->a);
    }

}
