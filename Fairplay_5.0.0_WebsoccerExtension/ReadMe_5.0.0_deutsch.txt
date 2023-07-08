**********************************
Erweiterung für HSE WebSoccer-Sim:

Fairplay 
Version 5.0.0 (für Version 5.x)

Autor: 	Pierre Keutel
Mail:	pierre.keutel@yahoo.fr
**********************************


CHANGES v2.0 -> v5.0.0
====================

* Anpassung des Features an die Websoccer version 5.0
* Korrektur (CSS-Datei) für falsche Darstellung der Pfeile (aufsteigend/absteigend) bei der Sortierung


CHANGES v1.0 -> v2.0
====================

* Sortierung der Spalten (Verein, Gelbe Karten, Gelb-Rote Karten, Rote Karten und Strafpunkte) möglich
* Korrektion für die Anzeige des Userbildes (nach Update WS4.3)
* Anzeige von Vereinswappen in der Tabellenübersicht


DESCRIPTION

===========

Die Erweiterung ermöglicht es die Fairplay-Statistiken für die einzelnen Ligen anzuzeigen.


Userbereich:

* Neuer Menüeintrag "Fairplay" im Bereich Ligen
* Ligenauswahl auf der Seite der Fairplay-Statistiken
* Tabellenübersicht der Fairplaystatistiken nach "Strafpunkten" (berechnet aus gelben, gelb-roten und roten Karten) geordnet.
* Farbliche Kennzeichnung für fairstes Team und die 3 unfairsten Teams.
* Sortierung der Spalten (Verein, Gelbe Karten, Gelb-Rote Karten, Rote Karten und Strafpunkte) möglich

ANFORDERUNGEN
=============
Diese Erweiterung wurde getestet mit dem Websoccer in Version 5.0 und läuft nur in dieser Version durch Änderung des Einbindens von CSS/JS-Dateien
Diese Erweiterung funktioniert weitestgehend mit der letzten Version der gängigen Browser (eventuelle Darstellungsfehler mit IE 8.x)


INSTALLATION
============

1. Schalten Sie Ihren Websoccer in den Offline-Modus und legen Sie eine Datensicherung an.

2. Kopieren Sie alle Dateien aus dem Ordner "extension" in einen Ordner auf Ihrem Rechner bspw. (den Ordner auf Ihrem Rechner in dem Sie die HSE WebSoccer-Sim entpackt haben).

3. Laden Sie die neuen Dateien mit einem FTP-Programm auf Ihren Webserver.

3a) Sofern es sich um eine UPDATE-Installation handelt, d.h. eine vorherige Version (v2.0) ist bereits vorhanden löschen sie folgende Dateien/Ordner
- classes/skins/FriendlyDefaultBootstrapSkin.class.php (sofern nicht bereits gelöscht mit dem Freundschaftsspiel-Feature)
- classes/skins/FriendlySchedioartFootballSkin.class.php (sofern nicht bereits gelöscht mit dem Freundschaftsspiel-Feature)
- Ordner sorttable unter css/sorttable

4. Nachdem alle Aktionen ausgeführt wurden leeren Sie den Cache.


NEUE/GEÄNDERTE KLASSEN
============

classes/models/FairplayModel.class.php
classes/services/FairplayDataService.class.php

NEUE/GEÄNDERTE MODULES
============

modules/fairplay/messages_de.xml
modules/fairplay/messages_en.xml
modules/fairplay/messages_fr.xml
modules/fairplay/module.xml
 
NEUE/GEÄNDERTE TEMPLATES-Dateien
====================== 

templates/default/views/fairplay.twig

NEUE/GEÄNDERTE JS-Dateien
====================== 

js/sorttable.js

NEUE/GEÄNDERTE CSS-Dateien
====================== 

css/sorrtable.css

NEUE/GEÄNDERTE IMG-Dateien
======================

img/sorrtable/down-arrow.png
img/sorrtable/up-arrow.png

							
DISCLAIMER
==========
Beachten Sie, dass der Hersteller der HSE WebSoccer-Sim nicht für die Kompatibilität der Software mit dieser Erweiterung garantiert. 
Insbesondere nicht in zukünftigen Produktaktualisierungen.