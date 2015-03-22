# Marketing Website Generator #
The Marketing Website Generator is membership management software for online marketers utilizing Linux / Apache / MySQL / PHP5 (LAMP).  The current release includes support for MwgGizmos - a special type of plugin architecture.

By using a special compatibility layer, many themes designed for Wordpress and Joomla! can be used with the system.  See MwgThemes for more details.

## Installation ##
The Djinnstaller automatically downloads, extracts and begins the MWG installation process. Simply upload mwginstaller.php to your server, then run the file via a web-browser. Complete installation instructions can be found by clicking: CpanelInstallation.

Please Note: To eliminate any permissions issues, be sure that your cpanel hosting provider is running [suPHP](http://www.cpanel.net/documentation/easyapache/ea3php_php_requests.html).

## Release 1.1 New Features ##
1.1 introduced MwgGizmos, a complete remote installation system and increased code stability as well as core bug fixes and a new back-end template.

## Release 1.2.3 ##
Today we release version 1.2.3 to the general public. This release incorporates all 1.2.x changes, as well as building a better wordpress theme system. Joomla 1.0 module positions left and right are also supported.  See the commit log for details.


## Upcoming Features in the 1.2.x Series ##
  1. IN PROGRESS: Additional system events allowing for additional Gizmo functionality
  1. DONE: Exposition of mail settings, allowing SMTP and sendmail to be used for mail
  1. DONE: Configuration of number of messages to be sent via the cron, effectively choking mailings as needed on virtual hosts
  1. DONE: View payment / IPN logs from Administrator
  1. Allow multiple administrators, each with their own username / password
  1. Optionally Allow affiliates to redirect to any page on the site, while setting the appropriate tracking cookie.
  1. DONE: Addition ~~SMARTY~~ Flexy template library to eventually replace the current library. For now, it will run along side, handling native MWG themes.



