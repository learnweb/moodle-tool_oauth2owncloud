<?php

defined('MOODLE_INTERNAL') || die();

$observers = array(
    array(
        'eventname' => '\repository_sciebo\event\sciebo_loggedin',
        'callback' => 'tool_oauth2sciebo\observer::login_requested'
    )
);