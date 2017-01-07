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
 * OAuth 2.0 and WebDAV API tests for the oauth2sciebo admin tool.
 *
 * @package    tool_oauth2sciebo
 * @copyright  2016 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class tool_oauth2sciebo_client_testcase extends advanced_testcase {

    /**
     * The sciebo class is initialized and the required settings are set beforehand.
     */
    protected function setUp() {
        $this->resetAfterTest(true);

        // Setup some settings required for the Client.
        set_config('clientid', 'testid', 'tool_oauth2sciebo');
        set_config('secret', 'testsecret', 'tool_oauth2sciebo');
        set_config('server', 'localhost', 'tool_oauth2sciebo');
        set_config('path', 'owncloud/remote.php/webdav/', 'tool_oauth2sciebo');
        set_config('port', '', 'tool_oauth2sciebo');
        set_config('type', 'https', 'tool_oauth2sciebo');

        // Dummy callback URL.
        $returnurl = new moodle_url('/repository/repository_callback.php', [
                'callback'  => 'yes',
                'repo_id'   => 0,
                'sesskey'   => sesskey(),
        ]);

        $this->client = new \tool_oauth2sciebo\sciebo($returnurl);
    }

    /**
     * The addition of the basic auth. header for the curl request is checked.
     */
    public function test_post_header() {
        $this->resetAfterTest(true);

        $this->client->post('https://somepath.com/token');

        $header = $this->client->header[0];
        $expected = 'Authorization: Basic ' . base64_encode($this->client->get_clientid() . ':' . $this->client->get_clientsecret());

        $this->assertEquals($header, $expected);
    }

    /**
     * The dynamic generation of auth_url and token_url is tested.
     */
    public function test_urls() {
        $this->resetAfterTest(true);

        $this->assertEquals('https://localhost/owncloud/index.php/apps/oauth2/authorize',
                $this->get_method_sciebo('auth_url')->invokeArgs($this->client, array()));
        $this->assertEquals('https://localhost/owncloud/index.php/apps/oauth2/api/v1/token',
                $this->get_method_sciebo('token_url')->invokeArgs($this->client, array()));
    }

    /**
     * It is tested, whether the client configuration settings are appropriate and as expected.
     * TODO: Implement the test.
     */
    public function test_settings_checker() {
        $this->assertEquals(1, 1);
    }

    /**
     * The addition of the bearer auth. header for token based authentication is tested.
     * TODO: Implement the test.
     * TODO: Maybe Reflections could work?
     */
    public function test_webdav_changes() {
        // Create reflection and initialize object -> call create_basic_request ->
        // check the request headers for bearer auth header.
        $this->assertEquals(1, 1);
    }

    /**
     * Helper method to access a specific pretected or private method from the class sciebo.
     * @param $name name of the method.
     * @return ReflectionMethod exact method.
     */
    protected function get_method_sciebo($name) {
        $tmp = new ReflectionClass(\tool_oauth2sciebo\sciebo::class);
        $method = $tmp->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}