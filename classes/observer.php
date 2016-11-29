<?php

defined('MOODLE_INTERNAL') || die();

class oath2sciebo_observer {

    public static function login_requested(\repository_sciebo\event\login_requested $event) {

        set_user_preference('webdav_user', $event->other['user']);
        set_user_preference('webdav_pass', $event->other['pass']);

    }
}