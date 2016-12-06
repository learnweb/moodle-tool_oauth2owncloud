<?php

namespace tool_oauth2sciebo;

defined('MOODLE_INTERNAL') || die();

class observer {

    public static function login_requested(\repository_sciebo\event\sciebo_loggedin $event) {

        // Just a test for Events. The username and password of the login attempt to Sciebo
        // are bypassed to the admin tool and here they are written into the user preferences.
        if((get_user_preferences('webdav_user') == null) || (get_user_preferences('webdav_pass') == null)) {
            set_user_preference('webdav_user', $event->other['user']);
            set_user_preference('webdav_pass', $event->other['pass']);
        }
    }
}