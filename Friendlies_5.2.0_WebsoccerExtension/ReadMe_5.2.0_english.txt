**********************************
Extension for HSE WebSoccer-Sim:

Friendlies 
Version 5.2.0 (for Websoccer-Version 5.1.1)

Author:
Pierre Keutel; pierre.keutel@yahoo.fr
**********************************

CHANGELOG
=========

Version 5.2.0

* Possibility to activate/deactivate the option for friendlies for national teams
* Possibility to activate and to set bonuses for friendlies (only for club teams)

Version 5.1.1

* Possibility to create friendly matches for national teams

Version 5.0.0

* Adaptation for the version 5.0 of HSE Websoccer software
* New - A separate skin is no more needed (actually installed skins from former version of the feature can be deleted (FriendlyDefaultBootstrapSkin and FriendlySchedioartFootballSkin)

RESTRICTION
===========

* For some styles, especially your proper styles, the CSS files have to be adapted if the date and time picker are not correctly shown since the css files are globally valid.

DESCRIPTION
===========

The extension makes it possible for users to plan friendly matches against each other.

Admin area
* In the admin area friendlies can be activated and deactivated
* The possibility to fix the number of friendlies per day for the users is given.
* For the moment the friendlies can be done at every time (It is possible to fix the time difference in minutes between the moment when the friendly is scheduled and the time when the friendly will be played)

E.g. 
	* Value in admin area = 30 minutes
	* the user is planning the match at 13h45 -> so it is not possible to fix the match for 14h00 on the same day; the earliest time possible will be 14h15Uhr for the match

* There is the possibility to activate/deactivate the option for friendlies for national teams
* You can activate and set bonuses for friendlies (only for club teams)


User area
* There is an overview of all « daily » friendlies which were played
* The user can send an invitation for a friendly, which have to be accepted by the Opponent before the match can be played.
* The user can decline a received invitation.
* Users which receive an invitation can accept or decline these.
* If the time for a match is over before the invitation was accepted, so the planned match will automatically deleted
* The user receives a notification for each invitation and action (decline/accepted)

REQUIREMENTS
=============
The extension was tested with the Websoccer software in version 5.0 and is only working with version > 5.0


UPDATE-INSTALLATION 
(if former version (for Websoccer 5.x) of the friendly feature (with database) is already installed)
===================


1. Put the Websoccer in the offline mode and make a backup of your installation.

2. Copy all files of the directory extension.

3. Open the file admin/config/config.inc.php and add the following lines at the end

$conf["friendlies_nationalteam_on_off"] = "1";
$conf["friendlies_bonus"] = "1";
$conf["friendlies_bonus_win"] = "100";
$conf["friendlies_bonus_draw"] = "0";
$conf["friendlies_bonus_loss"] = "-10";

4. The friendly_tmp.sql file has not to be executed for an update installation.

5. To activate the changes stop the simulation job and erstarrt the job afterwards

6. clear/delete the cache


NEW-INSTALLATION
============
1. Put the Websoccer in the offline mode and make a backup of your installation.

2. Copy all files of the directory "extension" in a directory of your PC bspw. (the directory where you have stored/extracted the files of the HSE WebSoccer-Sim).

3. Open the file admin/config/config.inc.php and add the following lines at the end

$conf["friendlies_on_off"] = "0";
$conf["friendlies_time_difference"] = "30";
$conf["friendlies_per_day"] = "3";
$conf["friendlies_nationalteam_on_off"] = "1";
$conf["friendlies_bonus"] = "1";
$conf["friendlies_bonus_win"] = "100";
$conf["friendlies_bonus_draw"] = "0";
$conf["friendlies_bonus_loss"] = "-10";

Close the file, save the file and upload the file via FTP on your web server.

4. Load the new files by the help of an FTP Programm on your web server.

5. Executed the SQL-Commands which are in the friendly_tmp.sql
Follwing the procedure:
  a. Open the included SQL file friendly_tmp.sql with an text editor.
  b. If your database is NOT using the prefix "ws3" you have to replace all « ws3 » which are in the file with your own prefix.
  c. Copy the content.
  d. Login to a database administration tool on your web server (in general phpMyAdmin).
  e. Click on « Execute SQL" and Paste the copied content from step c.

6. After all actions are done clear/delete the cache and proceed with the parameters for the friendlies.
	« General / Settings => Friendlies »
	

NEW CLASSES
============

classes/actions/FriendlyAcceptDeclineController.class.phpclasses/actions/FriendlyController.class.php

classes/models/FriendlyAcceptDeclineModel.class.php
classes/models/FriendlyCreateMatchModel.class.php
classes/models/FriendlyMatchModel.class.php
classes/models/FriendlyOpenMatchModel.class.php
classes/models/FriendlyScheduleMatchModel.class.php

classes/plugins/FriendlyPlugin.class.php
		
classes/services/FriendlyDataService.class.php
		
classes/validators/TimeValidator.class.php
	
NEW CSS-Files
================
							
css/bootstrap-timepicker.min.css
css/datepicker.css
css/friendly.css

NEW JAVASCRIPT (Directory)
========================
			
js/bootstrap-datepicker/
js/bootstrap-timepicker/
js/friendly.js

NEW MODULES-Files
====================	

modules/friendlies/adminmessages_de.xml
modules/friendlies/adminmessages_en.xml
modules/friendlies/adminmessages_fr.xml
modules/friendlies/messages_de.xml
modules/friendlies/messages_en.xml
modules/friendlies/messages_fr.xml
modules/friendlies/module.xml


NEW TEMPLATES-Files
====================== 

templates/default/blocks/myopenfriendlies-list.twig

templates/default/macros/formelements.twig

templates/default/views/accept-friendly.twig
templates/default/views/decline-friendly.twig
templates/default/views/friendly-matches.twig
templates/default/views/friendly-matchset.twig
templates/default/views/friendly-openmatches.twig
templates/default/views/friendly-schedule.twig

							
DISCLAIMER
==========
Please be aware that the developer of the HSE WebSoccer-Sim is not guaranteeing any compatibility with this extension. 
Especially for planned future software updates.