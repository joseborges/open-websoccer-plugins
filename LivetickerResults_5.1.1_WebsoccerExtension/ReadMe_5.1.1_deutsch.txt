**********************************
Erweiterung für HSE WebSoccer-Sim:

Livematches - Block
Version 5.1.1 (für Version 5.x)

Autor: 		Pierre Keutel
Mail:		pierre.keutel@yahoo.fr
**********************************


CHANGELOG
=========

Version 5.1.1

* Neu - Es ist möglich die Parameter includepages/excludepages zu nutzen für den Block « id="livematches-container" » um den Block Liveticker nur auf « gewollten » Seiten anzeigen zu lassen.


DESCRIPTION

===========

Die Erweiterung ermöglicht es alle aktuellen Livespiele als Block im Websoccer anzuzeigen. Die Erweiterung ersetzt sozusagen den Block « Jetzt Live! » (HSE-Standard). Es wird sozusagen nicht mehr nur das eigene Live spiel angezeigt sondern alle aktuellen Livespiele.
Der Block aktualisiert sich selbst alle x Sekunden (stadrad: 30sec).


ANFORDERUNGEN
=============
Diese Erweiterung wurde getestet mit dem Websoccer in Version 5.1.
Diese Erweiterung funktioniert weitestgehend mit der letzten Version der gängigen Browser (eventuelle Darstellungsfehler mit IE 8.x)


UPDATE-INSTALLATION
============

1. Schalten Sie Ihren Websoccer in den Offline-Modus und legen Sie eine Datensicherung an.

2. Kopieren Sie alle Dateien aus dem Ordner "extension" in einen Ordner auf Ihrem Rechner bspw. (den Ordner auf Ihrem Rechner in dem Sie die HSE WebSoccer-Sim entpackt haben).

3. Laden Sie die neuen Dateien mit einem FTP-Programm auf Ihren Webserver.

4. Nachdem alle Aktionen ausgeführt wurden leeren Sie den Cache.


NEU-INSTALLATION
============

1. Schalten Sie Ihren Websoccer in den Offline-Modus und legen Sie eine Datensicherung an.

2. Kopieren Sie alle Dateien aus dem Ordner "extension" in einen Ordner auf Ihrem Rechner bspw. (den Ordner auf Ihrem Rechner in dem Sie die HSE WebSoccer-Sim entpackt haben).

3. Laden Sie die neuen Dateien mit einem FTP-Programm auf Ihren Webserver.

4. Sichern sie die Dateien (modules/matches/module.xml) die es zu ändern gilt um im Problemfall die alten Dateien wieder herzustellen.

5. Kommentieren oder Löschen Sie in der Datei modules/matches/module.xml folgenden Block um eine zusätzliche Ausgabe des alten « Jetzt Live! » zu unterbinden :

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


6. Nachdem alle Aktionen ausgeführt wurden leeren Sie den Cache.


NEUE/GEÄNDERTE CLASSES
============

classes/models/AllLiveMatchesBlockModel.class.php
classes/services/LiveMatchesDataService.class.php


NEUE/GEÄNDERTE MODULES
============

modules/matches/module.xml (siehe Punkt 5)
modules/livematches/module.xml
modules/livematches/messages_de.xmlmodules/livematches/messages_en.xmlmodules/livematches/messages_fr.xml


NEUE/GEÄNDERTE TEMPLATES
============

templates/default/home.twig (siehe Punkt 4)
templates/default/views/layout.twig (siehe Punkt 4)
templates/schedio/home.twig (siehe Punkt 4)
templates/schedio/views/layout.twig (siehe Punkt 4)

templates/default/blocks/all_livematches.twig
templates/default/blocks/livematches_container.twig


							
DISCLAIMER
==========
Beachten Sie, dass der Hersteller der HSE WebSoccer-Sim nicht für die Kompatibilität der Software mit dieser Erweiterung garantiert. 
Insbesondere nicht in zukünftigen Produktaktualisierungen.