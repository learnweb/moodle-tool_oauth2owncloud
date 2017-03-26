# Moodle Admin Tool `oauth2owncloud`

[![Build Status](https://travis-ci.org/pssl16/moodle-tool_oauth2owncloud.svg?branch=master)](https://travis-ci.org/pssl16/moodle-tool_oauth2owncloud)
[![codecov](https://codecov.io/gh/pssl16/moodle-tool_oauth2owncloud/branch/master/graph/badge.svg)](https://codecov.io/gh/pssl16/moodle-tool_oauth2owncloud)

# English

This Plugin connects ownCloud with Moodle using the OAuth 2.0 protocol. It is used by the following Plugins:
* [Repository Plugin `owncloud`](https://github.com/pssl16/moodle-repository_owncloud) 
* [Activity Module `collaborativefolders`](https://github.com/pssl16/moodle-mod_collaborativefolders)

Created by the project seminar sciebo@Learnweb of the University of Münster.

## Installation

Copy the content of this repository to `admin/tool/oauth2owncloud`. 

## Admin Settings

To enable the plugin the site admin has to fill in the settings form. This form is available under `Site administration ► Plugins ► Admin tools ► ownCloud OAuth 2.0 Configuration`.

![OAuth 2.0 Form](pix/OAuth2Form.png)

The Client ID and Secret of registered clients can be found in ownCloud (see [OAuth 2.0 App](https://github.com/owncloud/oauth2)).

![WebDAV Form](pix/WebDAVForm.png)

Afterwards the settings for the WebDAV client have to be filled in. This includes the ownCloud server, path and protocol. The field “port” is optional and in most cases not necessary.

If all settings are correct the Admin Tool can be used for authentication and authorization via OAuth 2.0.

Additional information can be found in our [documentation](https://pssl16.github.io).

# Deutsch

Dieses Plugin verbindet ownCloud und Moodle mittels des OAuth 2.0 Protokolls. Es wird von den folgenden Plugins verwendet:
* [Repository Plugin `owncloud`](https://github.com/pssl16/moodle-repository_owncloud) 
* [Activity Module `collaborativefolders`](https://github.com/pssl16/moodle-mod_collaborativefolders)

Erstellt vom Projektseminar sciebo@Learnweb der Westfälischen Wilhelms-Universität Münster.

## Installation

Kopieren Sie den Inhalt dieses Repositorys nach `admin/tool/oauth2owncloud`.

## Admin Einstellungen

Um dieses Plugin zu aktivieren, muss der Administrator das Einstellungsformular ausfüllen. Dieses Formular ist zu finden unter `Site administration ► Plugins ► Admin tools ► ownCloud OAuth 2.0 Configuration`.

![OAuth 2.0 Formular](pix/OAuth2Form.png)

Die Client ID und das Secret registrierter Clients können in ownCloud ermittelt werden (siehe [OAuth 2.0 App](https://github.com/owncloud/oauth2)).

![WebDAV WebDAV](pix/WebDAVForm.png)

Danach müssen die Einstellungen für den WebDAV Client ausgefüllt werden. Dies umfasst den ownCloud Server, Path und Protocol. Das Feld „Port“ ist optional und in den meisten Fällen nicht notwendig.

Wenn alle Einstellungen korrekt sind, kann das Admin Tool für die Authentifizierung und Autorisierung via OAuth 2.0 genutzt werden.

Nähere Informationen finden Sie in unserer [Dokumentation](https://pssl16.github.io).
