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

use tool_oauth2sciebo\sciebo_client;

class sciebo extends \oauth2_client {

    /**
     * Create the DropBox API Client.
     *
     * @param   string      $key        The API key
     * @param   string      $secret     The API secret
     * @param   string      $callback   The callback URL
     */
    public function __construct($callback) {
        parent::__construct(get_config('tool_oauth2sciebo', 'clientid'),
            get_config('tool_oauth2sciebo', 'secret'), $callback, '');

        // Entered WebDav configuration.
        // The required data is now fetched from the oauth2sciebo Admin tool.
        if (empty(get_config('tool_oauth2sciebo', 'server'))) {
            return;
        }
        if (empty(get_config('tool_oauth2sciebo', 'type'))) {
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
            get_config('tool_oauth2sciebo', 'user'), get_config('tool_oauth2sciebo', 'pass'),
            get_config('tool_oauth2sciebo', 'auth'), $this->webdav_type);
        $this->dav->port = $this->webdav_port;
        $this->dav->debug = false;
    }

    /**
     * Returns the auth url for OAuth 2.0 request
     * @return string the auth url
     */
    protected function auth_url() {
        // Dynamically generated from the admin tool settings.
        return get_config('tool_oauth2sciebo', 'auth_url');
    }

    /**
     * Returns the token url for OAuth 2.0 request
     * @return string the auth url
     */
    protected function token_url() {
        return get_config('tool_oauth2sciebo', 'token_url');
    }

    /**
     * The WebDav listing function is encapsulated into this helper function.
     * @param $path
     * @return array
     */
    public function get_listing($path) {
        // The WebDav client needs to be able to hold an access token in order to enable
        // authentification trough OAuth2.
        $this->dav->set_token($this->get_accesstoken()->token);
        return $this->dav->ls($path);
    }

    public function get_file($arg1, $arg2) {
        $this->dav->set_token($this->get_accesstoken()->token);
        return $this->dav->get_file($arg1, $arg2);
    }

    public function callback() {
        $this->log_out();
        $this->is_logged_in();
    }

    public function post($url, $params = '', $options = array())
    {
        // A basic auth header has to be added to the request in order to provide the necessary user
        // credentials to the ownCloud interface.
        $this->setHeader(array(
            'Authorization: Basic ' . base64_encode($this->get_clientid() . ':' . $this->get_clientsecret())
        ));

        return parent::post($url, $params, $options);
    }
}