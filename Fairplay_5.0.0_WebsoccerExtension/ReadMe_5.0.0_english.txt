**********************************
Extension for HSE WebSoccer-Sim:

Fairplay 
Version 5.0.0 (for Version 5.x)

Author: 	Pierre Keutel
Mail:	pierre.keutel@yahoo.fr
**********************************


CHANGES v2.0 -> v5.0.0
====================

* Adaptation of the feature for the new HSE Websoccer version 5.0
* Correction (CSS-File) for wrong für falsche presentation of arrow for sorting (arrow up/down)

CHANGES v1.0 -> v2.0
====================

* Sorting of columns (team, yellow cards, yellow red cards, red cards and penalty points) possible
* Correction for the display of the user image (after update WS4.3)
* Display of club logo in table overview


DESCRIPTION

===========

This extension gives the possibility to display the fairplay statistics for every league.


User area:

* New menu entry « Fairplay » in menu Leagues
* Drop down menu for league selection on the fairplay statistics page
* Table overview of the fairplay statistics sorted after « penalty points » (which are calculate by the receive yellow, yellow red and red cards Karten).
* Colored labeling of the faires team and the 3 unfairest teams.
* Sorting possible of the columns for team, yellow cards, yellow red cards, red cards and penalty points


REQUIREMENTS
=============
This extension was testet with the latest Websoccer Version 5.0 and is running only with this version since there were changes with the include of CSS/JS files 
If you have a former version of the Websoccer you shall use the Faiplay feature in its version 2.0
This extension is running as far as possible with the latest versions of actual browsers (probably some display errors with IE 8.x)


INSTALLATION
============

1. Put your Websoccer Installation in offline mode and make a Backup of your installation.

2. Copy all files from the directory « extension » in a directory on your PC for example where you have extracted the installation of HSE Websoccer.

3. Upload the new files by the help of a FTP Programm on your web server.

3a)If you will upgrade an already existing version of the fairplay extension, which means you have an already installed version (v2.0) on you web server so you have to delete the following files/directories on your server resulting from former installation
- classes/skins/FriendlyDefaultBootstrapSkin.class.php (in the case where these files are not already deleted, e.g. after installation of friendly feature v5.0.0)
- classes/skins/FriendlySchedioartFootballSkin.class.php (in the case where these files are not already deleted, e.g. after installation of friendly feature v5.0.0)
- directory sorttable under css/sorttable

4. After all actions are done you have to clear/delete the cache.


NEW/CHANGED CLASSES
============

classes/models/FairplayModel.class.php
classes/services/FairplayDataService.class.php

NEW/CHANGED MODULES
============

modules/fairplay/messages_de.xml
modules/fairplay/messages_en.xml
modules/fairplay/messages_fr.xml
modules/fairplay/module.xml
 
NEW/CHANGED TEMPLATE files
====================== 

templates/default/views/fairplay.twig

NEW/CHANGED JS files
====================== 

js/sorttable.js

NEW/CHANGED CSS files
====================== 

css/sorrtable.css

NEW/CHANGED IMG files
======================

img/sorrtable/down-arrow.png
img/sorrtable/up-arrow.png

							
DISCLAIMER
==========
Please be aware that the developer of the HSE WebSoccer-Sim is not guaranteeing any compatibility with this extension. 
Especially for planned future software updates.