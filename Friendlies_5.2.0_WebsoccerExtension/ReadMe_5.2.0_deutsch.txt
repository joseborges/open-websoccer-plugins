**********************************
Erweiterung für HSE WebSoccer-Sim:

Freundschaftsspiele
Version 5.2.0 (für Websoccer-Version 5.1.1)

Autor:
Pierre Keutel; pierre.keutel@yahoo.fr
**********************************


CHANGELOG
=========

Version 5.2.0

* Möglichkeit die Option für Freundschaftsspiele für Nationalteams zu aktivieren/deaktivieren
* Möglichkeit im Adminbereich Prämien für Freundschaftsspiele zu aktivieren und einzustellen (nur für Vereinsmannschaften)

Version 5.1.1

* Möglichkeit Freundschaftsspiele für Nationalmannschaften anzusetzen

Version 5.0.0

* Anpassung an die Version 5.0 des Websoccers
* New - Es wird nun kein spezieller Skin/Style mehr gebraucht (die bisher vorhanden
FriendlyDefaultBootstrapSkin sowie FriendlySchedioartFootballSkin sind nicht mehr vorhanden)

RESTRICTION
===========

* Für einige Style, insbesondere eigene Styles, müssen die CSS-Datei eventuell angepasst werden, für den Fall das Date und Timepicker nicht korrekt dargestellt werden - da diese aktuell global gültig sind.

DESCRIPTION
===========

Die Erweiterung ermöglicht es die Freundschaftsspiele durch User ansetzbar zu machen.

Adminbereich
* Im Admin-Bereich können die Freundschaftsspiele aktiviert oder deaktiviert werden.
* Es gibt die Möglicheit die Anzahl der verfügbaren Freundschaftsspiele pro Tag für die User festzulegen.
* Aktuell kann man die Freundschaftsspiele zu jedem möglichen Zeitpunkt ausführen (Es kann eingestellt werden wieviel Minuten Differenz zwischen der Ansetzungszeit und der Austragungszeit liegen müssen)
Bsp. 
	* Wert im Adminbereich = 30 Minuten
	* der User setzt das Spiel um  13h45 an -> kann also den Termin nicht auf 14h00 am gleichen Tag legen; sondern frühestens ab 14:15Uhr das Spiel ansetzen

* Man kann die Freundschaftsspiele für Nationalteams aktivieren/deaktivieren
* Es gibt die Option Prämien für Freundschaftsspiele zu vergeben

Userbereich
* Es gibt eine Übersicht für alle "heute" absolvierten Freundschaftsspiele 
* Der User kann eine Einladung zu einem Freundschaftsspiel versenden, welche vom Gegner angenommen werden muss bevor es zur Austragung des Spieles kommt.
* Der User kann eine bereits von ihm verschickte Einladung absagen.
* User die eine Einladung für ein Freundschaftsspiel bekommen haben können diese annehmen oder absagen.
* Bei Einladung wo die Frist (Austragung des Freundschaftsspieles) abgelaufen ist, werden automatisch gelöscht in der Übersicht der Anfragen
* Der User erhält eine Benachrichtigung für jede Einladung oder damit verbunden Aktion (Absage/Zusage)


ANFORDERUNGEN
=============
Diese Erweiterung wurde getestet mit dem Websoccer in Version 5.x und ist nur in der Version > 5.0 des Websoccers nutzbar


UPDATE-INSTALLATION 
(vorherige Version (für den Websoccer 5.x) des Freundschaftsfeatures (Datenbank) bereits installiert)
===================


1. Schalten Sie Ihren Websoccer in den Offline-Modus und legen Sie eine Datensicherung an.

2. Kopieren Sie alle Dateien aus dem Ordner extension auf ihren Server.

3. Öffnen Sie die Datei admin/config/config.inc.php und fügen sie am Ende folgende Zeilen hinzu

$conf["friendlies_nationalteam_on_off"] = "1";
$conf["friendlies_bonus"] = "1";
$conf["friendlies_bonus_win"] = "100";
$conf["friendlies_bonus_draw"] = "0";
$conf["friendlies_bonus_loss"] = "-10";

4. Die friendly_tmp.sql Datei muss nicht ausgeführt werden und kann somit ausgelassen werden.

5. Um die Änderungen wirksam zu machen halten Sie den Berechnungs-Job an und starten Sie ihn danach neu

6. Cache leeren


NEU-INSTALLATION
============
1. Schalten Sie Ihren Websoccer in den Offline-Modus und legen Sie eine Datensicherung an.

2. Kopieren Sie alle Dateien aus dem Ordner "extension" in einen Ordner auf Ihrem Rechner bspw. (den Ordner auf Ihrem Rechner in dem Sie die HSE WebSoccer-Sim entpackt haben).

3. Öffnen Sie die Datei admin/config/config.inc.php und fügen sie am Ende folgende Zeilen hinzu

$conf["friendlies_on_off"] = "0";
$conf["friendlies_time_difference"] = "30";
$conf["friendlies_per_day"] = "3";
$conf["friendlies_nationalteam_on_off"] = "1";
$conf["friendlies_bonus"] = "1";
$conf["friendlies_bonus_win"] = "100";
$conf["friendlies_bonus_draw"] = "0";
$conf["friendlies_bonus_loss"] = "-10";

Schliessen Sie die Datei, Speichern Sie die Änderung und laden Sie die Datei per FTP auf Ihren Webserver.

4. Laden Sie die neuen Dateien mit einem FTP-Programm auf Ihren Webserver.

5. Führen Sie die SQL-Befehle aus der Datei friendly_tmp.sql aus. Das geht wie folgt:
  a. Öffnen Sie die dieser Erweiterung mitgelieferte Datei friendly_tmp.sql mit einem Texteditor.
  b. Falls Ihre Datenbanktabellen NICHT den Prefix "ws3" benutzen, müssen Sie alle Vorkommen von "ws3" durch Ihr eigenes Prefix ersetzen.
  c. Kopieren Sie den Inhalt der Datei.
  d. Melden Sie dich auf Ihrem Webserver in das Datenbankadministrationstool (in der Regel PhpMyAdmin) ein.
  e. Klicken Sie auf "SQL ausführen" und fügen die zuvor kopierten Befehle ein.

6. Nachdem alle Aktionen ausgeführt wurden leeren Sie den Cache und nehmen Sie die Einstellungen im Administrationsbereich für die Freundschaftsspiele vor.
	"Allgemein / Einstellung => Freundschaftsspiele"
	

NEUE KLASSEN
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
	
NEUE CSS-Dateien
================
							
css/bootstrap-timepicker.min.css
css/datepicker.css
css/friendly.css

NEUE JAVASCRIPT (Ordner)
========================
			
js/bootstrap-datepicker/
js/bootstrap-timepicker/
js/friendly.js

NEUE MODULES-Dateien
====================	

modules/friendlies/adminmessages_de.xml
modules/friendlies/adminmessages_en.xml
modules/friendlies/adminmessages_fr.xml
modules/friendlies/messages_de.xml
modules/friendlies/messages_en.xml
modules/friendlies/messages_fr.xml
modules/friendlies/module.xml


NEUE TEMPLATES-Dateien
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
Beachten Sie, dass der Hersteller der HSE WebSoccer-Sim nicht für die Kompatibilität der Software mit dieser Erweiterung garantiert. 
Insbesondere nicht in zukünftigen Produktaktualisierungen.