<?php
global $CFG;

$observers = array(
    array(
        'eventname' => '\repository_sciebo\events\login_requested',
        'includefile' => $CFG->dirroot.'/admin/tool/oauth2sciebo/classes/observer.php',
        'callback' => 'oath2sciebo_observer::login_requested'
    )
);