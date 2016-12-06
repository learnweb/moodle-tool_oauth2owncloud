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

namespace tool_oauth2sciebo;

defined('MOODLE_INTERNAL') || die();

/**
 * The observer class for incoming Events from different plugins which use
 * the OAuth2 authentication method with ownCloud.
 *
 * @package tool_oauth2sciebo
 * @copyright  2016 Westfälische Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class observer {

    public static function login_requested(\repository_sciebo\event\sciebo_loggedin $event) {

        // Just a test for Events. The username and password of the login attempt to Sciebo
        // are bypassed to the admin tool and here they are written into the user preferences.
        if ((get_user_preferences('webdav_user') == null) || (get_user_preferences('webdav_pass') == null)) {
            set_user_preference('webdav_user', $event->other['user']);
            set_user_preference('webdav_pass', $event->other['pass']);
        }
    }
}