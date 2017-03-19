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
 * OAuth 2.0 and WebDAV API tests for the oauth2owncloud admin tool.
 *
 * @package    tool_oauth2owncloud
 * @copyright  2017 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class tool_oauth2owncloud_client_testcase extends advanced_testcase {

    /** @var null \tool_oauth2owncloud\owncloud OAuth 2.0 ownCloud client */
    private $client = null;

    /** @var null \moodle_url dummy return URL.*/
    private $returnurl = null;

    /** @var null \stdClass example Access Token. */
    private $accesstoken = null;

    /**
     * The owncloud class is initialized and the required settings are set beforehand.
     */
    protected function setUp() {
        $this->resetAfterTest(true);

        // Setup some settings required for the Client.
        set_config('clientid', 'testid', 'tool_oauth2owncloud');
        set_config('secret', 'testsecret', 'tool_oauth2owncloud');
        set_config('server', 'localhost', 'tool_oauth2owncloud');
        set_config('path', 'owncloud/remote.php/webdav/', 'tool_oauth2owncloud');
        set_config('type', 'https', 'tool_oauth2owncloud');
        set_config('port', 1000, 'tool_oauth2owncloud');

        // Dummy callback URL.
        $this->returnurl = new moodle_url('/repository/repository_callback.php', [
                'callback'  => 'yes',
                'repo_id'   => 0,
                'sesskey'   => sesskey(),
        ]);

        $this->client = new \tool_oauth2owncloud\owncloud($this->returnurl);

        $expiry = (time() + (3600 - 10));

        $this->accesstoken = new \stdClass();
        $this->accesstoken->token = 'example';
        $this->accesstoken->expires = $expiry;
        $this->accesstoken->user_id = 'testuser';
        $this->accesstoken->refresh_token = 'refresh';
    }

    /**
     * The addition of the basic auth. header for the curl request is checked.
     */
    public function test_post_header() {
        $this->resetAfterTest(true);

        // An Access Token is set and the cURL post method called.
        $this->client->set_access_token($this->accesstoken);
        $this->client->post('https://somepath.com/token');

        // Since the method parameter auth by dafault is set to false, a basic auth.
        // header with the client credentials is expected to be created and sent via cURL.
        $header = $this->client->header[0];
        $expected = 'Authorization: Basic '. base64_encode($this->client->get_clientid() .
                        ':' . $this->client->get_clientsecret());

        $this->assertEquals($expected, $header);
        // In case of such a request, the current Access Tokens needs to be removed. This is checked
        // in the following assertion.
        $this->assertEquals($this->client->get_accesstoken(), null);

        // Now the same method call is tested with auth set to true.
        $this->client->resetHeader();

        $this->client->set_access_token($this->accesstoken);
        $this->client->post('https://somepath.com/token', '', array(), true);

        // Since auth was set to true, the current Access Token is kept and instead of a
        // basic auth. header a bearer auth. header, containing the given Access Token, is
        // expected to be created.
        $header = $this->client->header[0];
        $expected = 'Authorization: Bearer '. $this->accesstoken->token;

        // In this case the Access Token should be the same that was given to the client
        // before the request.
        $this->assertEquals($expected, $header);
        $this->assertEquals($this->client->get_accesstoken(), $this->accesstoken);
    }

    /**
     * This method tests the addition of the basic auth. header for curl requests in
     * case of an upgrade from an Authorization Code or Refresh Token.
     *
     * The header assertion is the same as in test_post_header.
     */
    public function test_upgrade_token() {
        $this->resetAfterTest(true);

        $code = 'code';

        $this->client->set_access_token($this->accesstoken);
        $this->client->upgrade_token($code);

        $header = $this->client->header[0];
        $expected = 'Authorization: Basic '. base64_encode($this->client->get_clientid() .
                        ':' . $this->client->get_clientsecret());

        $this->assertEquals($expected, $header);
        $this->assertEquals($this->client->get_accesstoken(), null);

        $this->client->resetHeader();

        $this->client->set_access_token($this->accesstoken);
        $this->client->upgrade_token($code, true);

        $header = $this->client->header[0];
        $expected = 'Authorization: Basic '. base64_encode($this->client->get_clientid() .
                        ':' . $this->client->get_clientsecret());

        $this->assertEquals($expected, $header);
        $this->assertEquals($this->client->get_accesstoken(), null);
    }

    /**
     * This method tests the addition of the bearer auth. header for curl requests in
     * case of an OCS Share API request (generating a private or public link).
     *
     * The header assertion is the same as in test_post_header.
     */
    public function test_get_link() {
        $this->resetAfterTest(true);

        $this->client->set_access_token($this->accesstoken);
        try {
            $this->client->get_link('path');
        } catch (Exception $e) {
            // An exception is thrown, bacause the response from ownCloud is empty.
            // Since only the auth. header is tested, this exception is not relevant.
        }

        $header = $this->client->header[0];
        $expected = 'Authorization: Bearer '. $this->accesstoken->token;

        $this->assertEquals($expected, $header);
        $this->assertEquals($this->client->get_accesstoken(), $this->accesstoken);

        $this->client->resetHeader();

        $this->client->set_access_token($this->accesstoken);
        try {
            $this->client->get_link('path', $this->accesstoken->user_id);
        } catch (Exception $e) {
            // An exception is thrown, bacause the response from ownCloud is empty.
            // Since only the auth. header is tested, this exception is not relevant.
        }

        $header = $this->client->header[0];
        $expected = 'Authorization: Bearer '. $this->accesstoken->token;

        $this->assertEquals($expected, $header);
        $this->assertEquals($this->client->get_accesstoken(), $this->accesstoken);
    }

    /**
     * The dynamic generation of auth_url and token_url is tested.
     */
    public function test_urls() {
        $this->resetAfterTest(true);

        $this->assertEquals('https://localhost:'. get_config('tool_oauth2owncloud', 'port') .
                '/owncloud/index.php/apps/oauth2/authorize',
                $this->get_method_owncloud('auth_url')->invokeArgs($this->client, array()));
        $this->assertEquals('https://localhost:'. get_config('tool_oauth2owncloud', 'port') .
                '/owncloud/index.php/apps/oauth2/api/v1/token',
                $this->get_method_owncloud('token_url')->invokeArgs($this->client, array()));
    }

    /**
     * Test for the check_data method, which should tell the user, if configuration data for
     * the client is missing.
     *
     * Global variables (and methods) seem to not work with PHPUnit tests. Therefore the output
     * of the check_data method cannot be captured properly.
     */
    public function test_check_data() {
        $this->resetAfterTest(true);

        // Since all the required data was entered at the setup, check_data should return true.
        // $this->assertEquals($this->client->check_data(), true);

        $params = array(
                'clientid' => 'testid',
                'secret' => 'testsecret',
                'server' => 'localhost',
                'path' => 'owncloud/remote.php/webdav/',
                'type' => 'https');

        // Now every required data field is removed individually. The check_data method should
        // return false every time.
        foreach ($params as $key => $value) {
            unset_config($key, 'tool_oauth2owncloud');
            // $this->assertEquals($this->client->check_data(), false);
            set_config($key, $value, 'tool_oauth2owncloud');
        }

        // Now all configuration data is removed.
        unset_all_config_for_plugin('tool_oauth2owncloud');

        // $checkclient = new \tool_oauth2owncloud\owncloud($this->returnurl);

        // Since no data is available, false should be returned.
        // $this->assertEquals($checkclient->check_data(), false);

        foreach ($params as $key => $value) {
            set_config($key, $value, 'tool_oauth2owncloud');
        }

        // All parameters are now set again, except port. The port should be generated automatically
        // from a default value for each protocol type.
        // $this->assertEquals($checkclient->check_data(), true);
    }

    /**
     * The set_access_token method of the client is tested here. This needs to be done to make sure,
     * that any further complications are not caused by this method.
     */
    public function test_set_acces_token() {
        $this->resetAfterTest(true);
        // No Access Token has been set at the moment.
        $this->assertEquals($this->client->get_accesstoken(), null);

        // Now Access Token is set and retrieved from the client to make sure
        // it does not get changed on the way.
        $this->client->set_access_token($this->accesstoken);
        $this->assertEquals($this->client->get_accesstoken(), $this->accesstoken);
    }

    /**
     * The check_login function of the client is tested here.
     */
    public function test_check_login() {
        $this->resetAfterTest(true);

        $personal = $this->client->check_login();
        $technical = $this->client->check_login('mod_assign');

        // Since both, the personal and the technical token, have not been set yet,
        // both function calls should return false.
        $this->assertEquals($personal, false);
        $this->assertEquals($technical, false);

        $expiry = (time() + (3600 - 10));

        $toktech = new \stdClass();
        $toktech->token = 'examplefortechnical';
        $toktech->expires = $expiry;
        $toktech->user_id = 'tecnical';
        $toktech->refresh_token = 'refresh';

        // Now both, the personal and the technical token, are set. The tokens are different
        // in order to test, if they get changed properly.
        set_user_preference('oC_token', serialize($this->accesstoken));
        set_config('token', serialize($toktech), 'mod_assign');

        // Now, since the personal token is set, the check_login method should return true.
        $personalnew = $this->client->check_login();
        $this->assertEquals($personalnew, true);
        $this->assertEquals($this->client->get_accesstoken(), $this->accesstoken);

        $technicalnew = $this->client->check_login('mod_assign');
        $this->assertEquals($technicalnew, true);
        $this->assertEquals($this->client->get_accesstoken(), $toktech);

        // An expired token is created in order to check, if the method notices it and
        // resets the internal client token and the technical user's token.
        $toktech->expires = (time() - 10);
        set_config('token', serialize($toktech), 'mod_assign');

        // The technical user's token, as well as the clients internal token, should be reset
        // to null.
        $technicalold = $this->client->check_login('mod_assign');
        $this->assertEquals($technicalold, false);
        $this->assertEquals($this->client->get_accesstoken(), null);
        $this->assertEquals(get_config('mod_assign', 'token'), null);
    }

    /**
     * Test the path generation of shared file and folders by the OAuth 2.0 ownCloud client.
     */
    public function test_get_path() {
        $this->resetAfterTest(true);

        $exampleid = '123';

        $expublic = 'https://localhost:1000/owncloud/public.php?service=files&t=' . $exampleid . '&download';
        $exprivate = 'https://localhost:1000/owncloud/index.php/apps/files/?dir=' . $exampleid;

        $this->assertEquals($expublic, $this->client->get_path('public', $exampleid));
        $this->assertEquals($exprivate, $this->client->get_path('private', $exampleid));

        // Other methods than public or private are not allowed.
        $this->assertEquals(false, $this->client->get_path('something', $exampleid));
    }

    /**
     * Helper method to access a specific protected or private method from the class owncloud.
     *
     * @param $name string name of the method.
     * @return ReflectionMethod exact method.
     */
    protected function get_method_owncloud($name) {
        $tmp = new ReflectionClass(\tool_oauth2owncloud\owncloud::class);
        $method = $tmp->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}