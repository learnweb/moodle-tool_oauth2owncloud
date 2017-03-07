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
 * tool_oauth2sciebo.php for oauth2sciebo admin tool. Contains all defined language strings.
 *
 * @package    tool_oauth2sciebo
 * @copyright  2016 Westfälische Wilhelms-Universität Münster (WWU Münster)
 * @author     Projektseminar Uni Münster
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// General.
$string['configplugin'] = 'ownCloud configuration';
$string['pluginname'] = 'ownCloud authentication';
$string['sciebo:view'] = 'View a ownCloud folder';
$string['missing_settings'] = 'Please check the required client settings. Some might be missing.';

// Settings.
$string['clientid'] = 'Client ID';
$string['secret'] = 'Secret';
$string['server'] = 'ownCloud Server';
$string['path'] = 'ownCloud Path';
$string['protocol'] = 'Protocol';
$string['port'] = 'Port';
$string['oauthlegend'] = 'OAuth 2.0:';
$string['webdavlegend'] = 'WebDAV:';

// Not used at the moment.
$string['user'] = 'Username';
$string['pass'] = 'Password';
$string['auth_url'] = 'Authorization URL';
$string['token_url'] = 'Token URL';
$string['oauth2redirecturi'] = 'OAuth 2 Redirect URI';
$string['clientid_desc'] = 'Beschreibung für ClientID';
$string['oauthinfo'] = 'some important installing sentence';
$string['required'] = 'Required';
$string['pluginname_help'] = 'A ownCloud authentication admin tool';
$string['oauthsciebo'] = 'To use this plugin, you must register your site with ownCloud.
As part of the registration process, you will need to enter the following URL as \'Redirect domain\': {$a}
Once registered, you will be provided with a client ID and secret which can be entered here.';
$string['remember'] = 'Remember me';
