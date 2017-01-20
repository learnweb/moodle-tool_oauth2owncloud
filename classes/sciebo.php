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
 * Sciebo Class for oauth2sciebo admin tool
 *
 * @package    tool_oauth2sciebo
 * @copyright  2016 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_oauth2sciebo;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/oauthlib.php');

class sciebo extends \oauth2_client {

    /**
     * Create the ownCloud OAuth 2.0 and WebDAV clients. The required data for both clients is fetched from the
     * oauth2sciebo admin settings entered before by the user.
     *
     * @param   string      $key        The API key
     * @param   string      $secret     The API secret
     * @param   string      $callback   The callback URL
     */
    public function __construct($callback) {
        parent::__construct(get_config('tool_oauth2sciebo', 'clientid'),
            get_config('tool_oauth2sciebo', 'secret'), $callback, '');

        if (empty(get_config('tool_oauth2sciebo', 'server'))) {
            return;
        }
        if ('http' == (get_config('tool_oauth2sciebo', 'type'))) {
            $this->webdav_type = '';
        } else {
            $this->webdav_type = 'ssl://';
        }
        if (empty(get_config('tool_oauth2sciebo', 'port'))) {
            if (empty($this->webdav_type)) {
                $this->webdav_port = 80;
            } else {
                $this->webdav_port = 443;
            }
        } else {
            $this->webdav_port = get_config('tool_oauth2sciebo', 'port');
        }

        $this->dav = new sciebo_client(get_config('tool_oauth2sciebo', 'server'),
            '', '', 'bearer', $this->webdav_type);
        $this->dav->port = $this->webdav_port;
        $this->dav->debug = false;
    }

    /**
     * Helper method, that checks the admin settings regarding the OAuth 2.0 and WebDAV clients required for this
     * plugin. If at least one of the settings is empty, a warning is printed with a link which redirects to the
     * external setting page of the plugin.
     */
    public function check_data() {
        if (empty(get_config('tool_oauth2sciebo', 'clientid')) ||
                empty(get_config('tool_oauth2sciebo', 'secret')) ||
                empty(get_config('tool_oauth2sciebo', 'server')) ||
                empty(get_config('tool_oauth2sciebo', 'path')) ||
                empty(get_config('tool_oauth2sciebo', 'type'))) {

            global $CFG, $OUTPUT;
            $link = $CFG->wwwroot.'/'.$CFG->admin.'/tool/oauth2sciebo/index.php';

            // Generates a link to the external admin setting page.
            echo $OUTPUT->notification('<a href="'.$link.'" target="_blank">
            '.get_string('missing_settings', 'tool_oauth2sciebo').'</a>', 'warning');
        }
    }

    /**
     * Returns the auth url for OAuth 2.0 request
     * @return string the auth url
     */
    protected function auth_url() {
        // Dynamically generated from the admin tool settings.
        $path = str_replace('remote.php/webdav/', '', get_config('tool_oauth2sciebo', 'path'));
        return get_config('tool_oauth2sciebo', 'type') . '://' . get_config('tool_oauth2sciebo', 'server') . '/' . $path
               . 'index.php/apps/oauth2/authorize';
    }

    /**
     * Returns the token url for OAuth 2.0 request
     * @return string the token url
     */
    protected function token_url() {
        $path = str_replace('remote.php/webdav/', '', get_config('tool_oauth2sciebo', 'path'));
        return get_config('tool_oauth2sciebo', 'type') . '://' . get_config('tool_oauth2sciebo', 'server')  . '/' . $path
               . 'index.php/apps/oauth2/api/v1/token';
    }

    /**
     * Setter method for the Access Token.
     * @param $token \stdClass which is to be stored inside the Client.
     */
    public function set_access_token($token) {
        $this->store_token($token);
    }

    /**
     * Sets up a new Access Token after redirection from ownCloud. Therefore the old Token has to be discarded and a
     * new one requested with the authorization code.
     */
    public function callback() {
        $this->log_out();
        $this->is_logged_in();
    }

    /**
     * The WebDav listing function is encapsulated into this helper function. Before the WebDAV function is called,
     * an Access Token is set within the Client to enable OAuth 2.0 authentication.
     * @param $path string relative path to the file or directory.
     * @return array information about the file or directory.
     */
    public function get_listing($path) {
        $this->dav->set_token($this->get_accesstoken()->token);
        return $this->dav->ls($path);
    }

    /**
     * The WebDav function get_file is encapsulated into this helper function. Before the WebDAV function is called,
     * an Access Token is set within the Client to enable OAuth 2.0 authentication.
     * @param $source string sourcepath of the file.
     * @param $local string local path in which the file shall be stored.
     * @return bool true on success, false otherwise.
     */
    public function get_file($source, $local) {
        $this->dav->set_token($this->get_accesstoken()->token);
        return $this->dav->get_file($source, $local);
    }

    /**
     * The WebDav function mkcol is encapsulated into this helper function. Before the WebDAV function is called,
     * an Access Token is set within the Client to enable OAuth 2.0 authentication.
     * @param $path string path in which the collection shall be created.
     * @return int status code retrieved from server response.
     */
    public function make_folder($path) {
        $this->dav->set_token($this->get_accesstoken()->token);
        return $this->dav->mkcol($path);
    }

    /**
     * The WebDav function get_file is encapsulated into this helper function. Before the WebDAV function is called,
     * an Access Token is set within the Client to enable OAuth 2.0 authentication.
     * @param $path string path to the folder which shall be deleted.
     * @return int status code retrieved from the server response.
     */
    public function delete_folder($path) {
        $this->dav->set_token($this->get_accesstoken()->token);
        return $this->dav->delete($path);
    }

    /**
     * This function fetches a link to a specific folder or file in ownCloud through the OCS Share API. Therefore the
     * API had to be extended to support authentication via an Access Token.
     * @param $path string path to the file or folder in ownCloud.
     * @param null $user string specific user to be shared with (optional).
     * @return bool
     */
    public function get_link($path, $user = null) {
        if (get_config('tool_oauth2sciebo', 'path') === 'http') {
            $pref = 'http://';
        } else {
            $pref = 'https://';
        }

        if($user == null) {
            $query = http_build_query(array('path' => $path,
                                            'shareType' => 3,
                                            'publicUpload' => false,
                                            'permissions' => 31,
                                            'token' => $this->get_stored_token()
                                            ), null, "&");
        } else {
            $query = http_build_query(array('path' => $path,
                                            'shareType' => 0,
                                            'shareWith' => $user,
                                            'publicUpload' => true,
                                            'permissions' => 4,
                                            'token' => $this->get_stored_token()
                                            ), null, "&");
        }

        return $this->post($pref . get_config('tool_oauth2sciebo', 'server') . '/ocs/v1.php/apps/files_sharing/api/v1/shares',
                $query);
    }

    public function post($url, $params = '', $options = array()) {
        // A basic auth header has to be added to the request for client authentication in ownCloud.
        $this->setHeader(array(
            'Authorization: Basic ' . base64_encode($this->get_clientid() . ':' . $this->get_clientsecret())
        ));

        return parent::post($url, $params, $options);
    }
}