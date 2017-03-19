#moodle-tool-oauth2owncloud *(beta_candidate)*

# English
[![Build Status](https://travis-ci.org/pssl16/moodle-tool_oauth2owncloud.svg?branch=master)]
(https://travis-ci.org/pssl16/moodle-tool_oauth2owncloud)</br>
This Plugin connects ownCloud with Moodle with the OAuth2 Protocol. It will later serve the following Plugins:
[Repository sciebo](https://github.com/pssl16/moodle-repository_sciebo) and 
[Activity Plugin CollaborativeFolders](https://github.com/pssl16/moodle-mod_collaborativefolders).

Written and maintained by
[ProjectsSeminar of the University of Muenster](https://github.com/pssl16).
# Installation
This plugin should go into `admin/tool/oauth2owncloud`. 

### Admin Setting

To enable the plugin the site admin has to fill in the settings form. This Form is available under the path
 
 `Website-Administration ► Plugins ► Admin tools ► ownCloud OAuth 2.0 Configuration`.

![Plugin-Struktur](pix/OAuth2Form.png)

When the client was registert in ownCloud the clientID and secret can be found in the ownCloud App.

![Plugin-Struktur](pix/WebDAVForm.png)

Afterwards the settings for the WebDAV client have to be filled in.
Therefore the ownCloud server, path and protocol have to be filled in. The port is optional and in most cases not necessary.

When all settings are correct the admin_tool can be used to authenticate user with the [Repository sciebo](https://github.com/pssl16/moodle-repository_sciebo) or the
[Activity Plugin CollaborativeFolders](https://github.com/pssl16/moodle-mod_collaborativefolders).

For additional information please visit our [documentation page](https://pssl16.github.io).

# Deutsch
[![Build Status](https://travis-ci.org/pssl16/moodle-tool_oauth2owncloud.svg?branch=master)]
(https://travis-ci.org/pssl16/moodle-tool_oauth2sciebo)</br>
Dieses Plugin ermöglicht die Authentifizierung mittels des OAuth2 Protokolls für das [Repository sciebo](https://github.com/pssl16/moodle-repository_sciebo) <
und/oder das
[Activity Plugin CollaborativeFolders](https://github.com/pssl16/moodle-mod_collaborativefolders).

Das Plugin wurde geschrieben von dem [Projektseminar Sciebo@Learnweb](https://github.com/pssl16) der Westfälischen Wilhelms-Universität Münster.
# Installation
 Das Plugin muss in `admin/tool/oauth2owncloud` platziert werden.

### Admin Einstellungen

Damit das OAuth 2 Protokoll reibungslos ablaufen kann, muss zuerst der Client in den Einstellungen registriert werden.

Hierfür muss der Administrator das Formular des Plugins, das unter `Website-Administration ► Plugins ► Plugins ► Admin tools ► ownCloud OAuth 2.0 Configuration` zu finden ist, ausfüllen.

![Plugin-Struktur](pix/OAuth2Form.png)

Als erstes Feld muss die Client ID eingegeben werden. Diese findet man in ownCloud, sobald ein neuer Client registriert wurde. Dasselbe gilt für das nächste Feld, hier wird das Secret angegeben, dass sich auch aus der ownCloud App kopieren lässt.

![Plugin-Struktur](pix/WebDAVForm.png)

Nun werden die Einstellungen für den WebDAV Zugriff festgelegt.
Als erstes wird die Adresse des ownCloud Servers angegeben.
Im nächsten Feld wird der Pfad zur WebDAV Schnittstelle angegeben in ownCloud endet diese typischerweise mit `remote.php/webdav/`.
Als Protokolltyp kann http oder https angegeben werden. Wenn keine Angabe gemacht wird, wird von https ausgegangen.
Als letztes kann der Port angegeben werden.

Für genauere Informationen besuchen sie unsere [Website Dokumentation](https://pssl16.github.io).