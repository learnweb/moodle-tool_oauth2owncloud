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
     * TODO: Handle missing or false settings, since they are not checked when filled out by the user.
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
     * The WebDav listing function is encapsulated into this helper function. Before the WebDAV function is called,
     * an Access Token is set within the Client to enable data transmission.
     * @param $path relative path to the file or directory.
     * @return array information about the file or directory.
     */
    public function get_listing($path) {
        $this->dav->set_token($this->get_accesstoken()->token);
        return $this->dav->ls($path);
    }

    /**
     * The WebDav function get_file is encapsulated into this helper function. Before the WebDAV function is called,
     * an Access Token is set within the Client to enable data transmission.
     * @param $source sourcepath of the file.
     * @param $local local path in which the file shall be stored.
     * @return bool true on success, false otherwise.
     */
    public function get_file($source, $local) {
        $this->dav->set_token($this->get_accesstoken()->token);
        return $this->dav->get_file($source, $local);
    }

    /**
     * Sets up a new Access Token after redirection from ownCloud. Therefore the old Token has to be discarded and a
     * new one requested with the authorization code.
     */
    public function callback() {
        $this->log_out();
        $this->is_logged_in();
    }

    public function post($url, $params = '', $options = array()) {
        // A basic auth header has to be added to the request for client authentication in ownCloud.
        $this->setHeader(array(
            'Authorization: Basic ' . base64_encode($this->get_clientid() . ':' . $this->get_clientsecret())
        ));

        return parent::post($url, $params, $options);
    }
}