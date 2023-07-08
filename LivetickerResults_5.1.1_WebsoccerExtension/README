**********************************
Extension for HSE WebSoccer-Sim:

Livematches - Block
Version 5.1.1 (for Version 5.x)

Author: 	Pierre Keutel
Mail:		pierre.keutel@yahoo.fr
**********************************


CHANGELOG
=========

Version 5.1.1

* New - It is now possible to use the parameters includepages/excludepages in the module.xml for the block « id="livematches-container" ». By the help of these parameters you can explicitly decide where the block « liveticker » will be possible.


DESCRIPTION

===========

This extension gives the possibility to view all actual live matches in form of a block in the websoccer interface . The extension replaces the already existing block on the front page and live match report « Watch now! » where up to now only your match was displayed. Instead it will show all live matches currently on line.
The block will refresh itself every x seconds (default: 30). 


REQUIREMENTS
=============
This extension was tested with the latest Websoccer Version 5.1
This extension is running as far as possible with the latest versions of actual browsers (probably some display errors with IE 8.x)


UPDATE INSTALLATION
============

1. Put your Websoccer Installation in offline mode and make a Backup of your installation.

2. Copy all files from the directory « extension » in a directory on your PC for example where you have extracted the installation of HSE Websoccer.

3. Upload the new files by the help of a FTP Programm on your web server.

4. After all actions are done you have to clear/delete the cache.


NEW INSTALLATION
============

1. Put your Websoccer Installation in offline mode and make a Backup of your installation.

2. Copy all files from the directory « extension » in a directory on your PC for example where you have extracted the installation of HSE Websoccer.

3. Upload the new files by the help of a FTP Programm on your web server.

4. Backup the files (modules/matches/module.xml) which have to be modified to restore them in case of an error.

5. Comment or delete the following block in the file modules/matches/module.xml to inhibit an additional output of the former block « Watch now! » :

<!—Commented        
        <block
            id="livematch"
            template="livematch"
            model="LiveMatchBlockModel"
            includepages="all"
            area="sidebar"
            weight="2"
            role="user" />
-->


6. After all actions are done you have to clear/delete the cache.


NEW/CHANGED CLASSES
============

classes/models/AllLiveMatchesBlockModel.class.php
classes/services/LiveMatchesDataService.class.php


NEW/CHANGED MODULES
============

modules/matches/module.xml (see point 5)
modules/livematches/module.xml
modules/livematches/messages_de.xmlmodules/livematches/messages_en.xmlmodules/livematches/messages_fr.xml


NEW/CHANGED TEMPLATES
============

templates/default/home.twig (see point 4)
templates/default/views/layout.twig (see point 4)
templates/schedio/home.twig (see point 4)
templates/schedio/views/layout.twig (see point 4)

templates/default/blocks/all_livematches.twig
templates/default/blocks/livematches_container.twig

							
DISCLAIMER
==========
Please be aware that the developer of the HSE WebSoccer-Sim is not guaranteeing any compatibility with this extension. 
Especially for planned future software updates.