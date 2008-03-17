<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: de.inc.php,v 1.70 2008-03-17 14:12:14 decoyduck Exp $ */

// German language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "de";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "Januar";
$lang['month'][2]  = "Februar";
$lang['month'][3]  = "Maerz";
$lang['month'][4]  = "April";
$lang['month'][5]  = "Mai";
$lang['month'][6]  = "Juni";
$lang['month'][7]  = "Juli";
$lang['month'][8]  = "August";
$lang['month'][9]  = "September";
$lang['month'][10] = "Oktober";
$lang['month'][11] = "November";
$lang['month'][12] = "Dezember";

$lang['month_short'][1]  = "Jan";
$lang['month_short'][2]  = "Feb";
$lang['month_short'][3]  = "Mar";
$lang['month_short'][4]  = "Apr";
$lang['month_short'][5]  = "Mai";
$lang['month_short'][6]  = "Jun";
$lang['month_short'][7]  = "Jul";
$lang['month_short'][8]  = "Aug";
$lang['month_short'][9]  = "Sep";
$lang['month_short'][10] = "Okt";
$lang['month_short'][11] = "Nov";
$lang['month_short'][12] = "Dez";

// Dates ---------------------------------------------------------------

// Various date and time formats as used by Beehive Forum. All times are
// expressed as 24 hour time format.

$lang['daymonthyear'] = "%s %s %s";                  // 1 Jan 2005
$lang['monthyear'] = "%s %s";                        // Jan 2005
$lang['daymonthyearhourminute'] = "%s %s %s %s:%s";  // 1 Jan 2005 12:00
$lang['daymonthhourminute'] = "%s %s %s:%s";         // 1 Jan 12:00
$lang['daymonth'] = "%s %s";                         // 1 Jan
$lang['hourminute'] = "%s:%s";                       // 12:00

// Periods -------------------------------------------------------------

// Various time periods as used by Beehive Forum.

$lang['date_periods']['year']   = "%s Jahr";
$lang['date_periods']['month']  = "%s month";
$lang['date_periods']['week']   = "%s week";
$lang['date_periods']['day']    = "%s day";
$lang['date_periods']['hour']   = "%s hour";
$lang['date_periods']['minute'] = "%s minute";
$lang['date_periods']['second'] = "%s second";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s Jahre";
$lang['date_periods_plural']['month']  = "%s months";
$lang['date_periods_plural']['week']   = "%s weeks";
$lang['date_periods_plural']['day']    = "%s days";
$lang['date_periods_plural']['hour']   = "%s hours";
$lang['date_periods_plural']['minute'] = "%s minutes";
$lang['date_periods_plural']['second'] = "%s seconds";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sJ";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%smin";  // 6min
$lang['date_periods_short']['second'] = "%ssec";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "Prozent";
$lang['average'] = "Durchschnitt";
$lang['approve'] = "Genehmigt";
$lang['banned'] = "Gebannt";
$lang['locked'] = "Gesperrt";
$lang['add'] = "Hinzufügen";
$lang['advanced'] = "Erweitert";
$lang['active'] = "Aktiv";
$lang['style'] = "Stil";
$lang['go'] = "Weiter";
$lang['folder'] = "Ordner";
$lang['ignoredfolder'] = "Ignorierte Ordner";
$lang['folders'] = "Ordner";
$lang['thread'] = "Eintrag";
$lang['threads'] = "Eintraege";
$lang['threadlist'] = "Eintragsliste";
$lang['message'] = "Nachricht";
$lang['from'] = "Von";
$lang['to'] = "An";
$lang['all_caps'] = "ALLE";
$lang['of'] = "von";
$lang['reply'] = "Antwort";
$lang['forward'] = "Vorwaerts";
$lang['replyall'] = "Antwort an alle";
$lang['pm_reply'] = "Antwort als PM";
$lang['delete'] = "Loeschen";
$lang['deleted'] = "Geloescht";
$lang['edit'] = "Editieren";
$lang['privileges'] = "Privileg";
$lang['ignore'] = "Ignorieren";
$lang['normal'] = "Normal";
$lang['interested'] = "Interessiert";
$lang['subscribe'] = "Wichtig";
$lang['apply'] = "Bestaetigen";
$lang['download'] = "Download";
$lang['save'] = "Speichern";
$lang['update'] = "Aktualisierung";
$lang['cancel'] = "Abbrechen";
$lang['continue'] = "Fortfahren";
$lang['attachment'] = "Dateianhang";
$lang['attachments'] = "Dateianhaenge";
$lang['imageattachments'] = "Bildanhang";
$lang['filename'] = "Dateiname";
$lang['dimensions'] = "Masse";
$lang['downloadedxtimes'] = "Heruntergeladen: %d mal";
$lang['downloadedonetime'] = "Heruntergeladen: 1 mal";
$lang['size'] = "Groesse";
$lang['viewmessage'] = "Nachricht anzeigen";
$lang['deletethumbnails'] = "Loesche Thumbnails";
$lang['logon'] = "Anmeldung";
$lang['more'] = "Mehr";
$lang['recentvisitors'] = "Neue Besucher";
$lang['username'] = "Benutzername";
$lang['clear'] = "Loeschen";
$lang['action'] = "Aktion";
$lang['unknown'] = "Unbekannt";
$lang['none'] = "keine";
$lang['preview'] = "Voransicht";
$lang['post'] = "Senden";
$lang['posts'] = "Beitraege";
$lang['change'] = "Wechsel";
$lang['yes'] = "Ja";
$lang['no'] = "Nein";
$lang['signature'] = "Signatur";
$lang['signaturepreview'] = "Signatur Voransicht";
$lang['signatureupdated'] = "Signature aktualisiert";
$lang['signatureupdatedforallforums'] = "Signatur fuer alle Foren geaendert";
$lang['back'] = "Zurück";
$lang['subject'] = "Thema";
$lang['close'] = "Schliessen";
$lang['name'] = "Name";
$lang['description'] = "Beschreibung";
$lang['date'] = "Datum";
$lang['view'] = "Anzeige";
$lang['enterpasswd'] = "Passwort eingeben";
$lang['passwd'] = "Passwort";
$lang['ignored'] = "Ignoriert";
$lang['guest'] = "Gast";
$lang['next'] = "Naechste";
$lang['prev'] = "Vorherige";
$lang['others'] = "Andere";
$lang['nickname'] = "Nickname";
$lang['emailaddress'] = "Email-Addresse";
$lang['confirm'] = "bestaetigen";
$lang['email'] = "Email";
$lang['poll'] = "Abstimmung";
$lang['friend'] = "Freund";
$lang['success'] = "Erfolgreich";
$lang['error'] = "Fehler";
$lang['warning'] = "Warnung";
$lang['guesterror'] = "Entschuldige, aber dazu musst du angemeldet sein.";
$lang['loginnow'] = "Jetzt anmelden";
$lang['unread'] = "ungelesene";
$lang['all'] = "Alle";
$lang['allcaps'] = "ALLE";
$lang['permissions'] = "Erlaubnis";
$lang['type'] = "Typ";
$lang['print'] = "Druck";
$lang['sticky'] = "Sticky";
$lang['polls'] = "Abstimmungen";
$lang['user'] = "Benutzer";
$lang['enabled'] = "Aktiviert";
$lang['disabled'] = "Deaktiviert";
$lang['options'] = "Optionen";
$lang['emoticons'] = "Emoticons";
$lang['webtag'] = "Webtag";
$lang['makedefault'] = "Auf Standard";
$lang['unsetdefault'] = "Standard Rueckgaengig";
$lang['rename'] = "Umbenennen";
$lang['pages'] = "Seiten";
$lang['used'] = "Benutzt";
$lang['days'] = "Tagen";
$lang['usage'] = "In Benutzung";
$lang['show'] = "Anzeigen";
$lang['hint'] = "Tipp";
$lang['new'] = "Neu";
$lang['referer'] = "Verweis";
$lang['thefollowingerrorswereencountered'] = "Folgende Fehler sind aufgetreten:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "Admin Werkzeuge";
$lang['forummanagement'] = "Forum Management";
$lang['accessdeniedexp'] = "Sie haben keine Rechte diesen Bereich zu nutzen.";
$lang['managefolders'] = "Ordner managen";
$lang['manageforums'] = "Foren managen";
$lang['manageforumpermissions'] = "Manage Forum-Rechte";
$lang['foldername'] = "Ordnername";
$lang['move'] = "Verschieben";
$lang['closed'] = "Geschlossen";
$lang['open'] = "Geoeffnet";
$lang['restricted'] = "Eingeschraenkt";
$lang['forumiscurrentlyclosed'] = "%s ist momentan geschlossen";
$lang['youdonothaveaccesstoforum'] = "Sie haben keinen Zugriff auf %s";
$lang['toapplyforaccessplease'] = "Um Zugriff zu erhalten bitte den Admin kontaktieren.";
$lang['adminforumclosedtip'] = "Wenn Du einige Einstellungen aendern willst klicke auf den Admin-Link.";
$lang['newfolder'] = "Neuer Ordner";
$lang['nofoldersfound'] = "Keine bestehenden Ordner gefunden. Um einen Ordner hinzuzufuegen auf 'Neu hinzufuegen' klicken.";
$lang['forumadmin'] = "Forum Admin";
$lang['adminexp_1'] = "Benutze das linke Menü um dein Forum zu bearbeiten.";
$lang['adminexp_2'] = "<b>Benutzer</b> ist zum Setzen von Benutzerberechtigungen und Einstellungen.";
$lang['adminexp_3'] = "<b>Benutzergruppen</b> ist zum Setzen von Gruppenberechtigungen und Einstellungen.";
$lang['adminexp_4'] = "<b>Bann-Steuerung</b> ist zum Bannen/Aussperren von IP Addressen, Benutzernamen, Emailaddressen und Nicknamen.";
$lang['adminexp_5'] = "<b>Ordner</b> Erstellen, Aendern und Loeschen von Ordnern.";
$lang['adminexp_6'] = "<b>RSS Feeds</b> allows you to create and remove RSS feeds for propogation into your forum.";
$lang['adminexp_7'] = "<b>Profiles</b> zum Anpassen der Artikel die in den Benutzerprofilen erscheinen.";
$lang['adminexp_8'] = "<b>Profile</b> Eintraege anpassen die im Benutzer-Profil erscheinen.";
$lang['adminexp_9'] = "<b>Forum Einstellungen</b> Anpassen des Forennamens, Erscheinung und vieles anderes.";
$lang['adminexp_10'] = "<b>Forum style</b> Stil erstellen fuer die Benutzung durch die Forenmitglieder.";
$lang['adminexp_11'] = "<b>Wortfilter</b> Woerter ausfiltern die im Forum nicht benutzt werden sollen.";
$lang['adminexp_12'] = "<b>Poststatistiken</b> Generiert einen Bericht ueber die 10 haeufigsten Poster eines bestimmten Zeitraums.";
$lang['adminexp_13'] = "<b>Forum links</b> Links definieren fuer das rechte Drop-Down-Feld.";
$lang['adminexp_14'] = "<b>Log anzeigen</b> zeigt die letzten Aktionen der Forenmoderatoren.";
$lang['adminexp_15'] = "<b>Manage Foren</b> Erstellen, Oeffnen, Schliessen oder Wiederoeffnen von Foren.";
$lang['adminexp_16'] = "<b>Global Foreneinstellungen</b> Aenderung der Einstellungen fuer alle Foren.";
$lang['adminexp_17'] = "<b>Post Zustimmungswarteschlange</b> zeigt alle Posts die auf Zustimmung/Akzeptierung des Moderators warten.";
$lang['adminexp_18'] = "<b>Besucher Log</b> zeigt eine erweiterte Liste aller Besucher inkl. deren HTTP-Verweise.";
$lang['createforumstyle'] = "Forenstil erstellen";
$lang['newstylesuccessfullycreated'] = "Neuer Stil erfolgreich erstellt.";
$lang['stylealreadyexists'] = "Ein Stil mit diesem Dateinamen existiert bereits.";
$lang['stylenofilename'] = "Sie haben keinen Dateinamen eingeben für diesen Stil.";
$lang['stylenodatasubmitted'] = "Kann Forenstil-Daten nicht lesen.";
$lang['styleexp'] = "Diese Seite hilft Ihnen einen zufaellig generierten Stil fuer Ihr Forum zu erstellen.";
$lang['stylecontrols'] = "Steuerung";
$lang['stylecolourexp'] = "Farbauswahl fuer den neuen Stil. Aktuelle Farbe ist die erste der Liste.";
$lang['standardstyle'] = "Standard Stil";
$lang['rotelementstyle'] = "Gedrehtes Stilelement";
$lang['randstyle'] = "Zufallsstil";
$lang['thiscolour'] = "Diese Farbe";
$lang['enterhexcolour'] = "Oder trage eine HEX-Farbe als Basis des neuen Stils ein";
$lang['savestyle'] = "Stil speichern";
$lang['styledesc'] = "Stil absteigend";
$lang['stylefilenamemayonlycontain'] = "Dateinamensstil darf nur Kleinbuchstaben (a-z), Zahlen (0-9) und Unterstrich enthalten.";
$lang['stylepreview'] = "Stil Voransicht";
$lang['welcome'] = "Willkommen";
$lang['messagepreview'] = "Nachricht Voransicht";
$lang['users'] = "Benutzer";
$lang['usergroups'] = "Benutzergruppen";
$lang['mustentergroupname'] = "Sie muessen eine Benutzergruppe auswaehlen";
$lang['profiles'] = "Profil";
$lang['manageforums'] = "Foren managen";
$lang['forumsettings'] = "Foreneinstellungen";
$lang['globalforumsettings'] = "Allgemeine Foreneinstellungen";
$lang['settingsaffectallforumswarning'] = "<b>Note:</b> Diese Einstellungen beziehen sich auf ALLE Foren. Einstellungen in den individuellen Einstellungen der Foren haben Vorrang gegenueber den Einstellungen hier.";
$lang['startpage'] = "Startseite";
$lang['failedtoopenmasterstylesheet'] = "Dein Forenstil konnte nicht gespeichert werden da der Masterstil nicht geladen werden konnte. Um den Stil als Master-Stil zu speichern muss (make_style.css) im Styles-Verzeichnis Ihrer BeehiveForeninstallation gefunden werden.";
$lang['forumstyle'] = "Forenstil";
$lang['wordfilter'] = "Wortfilter";
$lang['forumlinks'] = "Forum Links";
$lang['viewlog'] = "Log Anzeigen";
$lang['noprofilesectionspecified'] = "Kein Profilbereich angegeben.";
$lang['itemname'] = "Eintragsname";
$lang['moveto'] = "Verschieben nach";
$lang['manageprofilesections'] = "Manage Profilbereich";
$lang['sectionname'] = "Bereichsname";
$lang['items'] = "Eintraege";
$lang['mustspecifyaprofilesectionid'] = "Eine Profilbereichs-ID muss festgelegt werden";
$lang['mustsepecifyaprofilesectionname'] = "Ein Profilbereichsname muss festgelegt werden";
$lang['noprofilesectionsfound'] = "Kein bestehender Profilbereich gefunden. Um einen Profilbereich hinzuzufuegen auf 'Neu hinzufuegen' klicken.";
$lang['addnewprofilesection'] = "Neuen Profilbereich anlegen";
$lang['successfullyaddedprofilesection'] = "Profilbereich erfolgreich hinzugefuegt";
$lang['successfullyeditedprofilesection'] = "Profilbereich erfolgreich bearbeitet";
$lang['addnewprofilesection'] = "Neuen Profilbereich anlegen";
$lang['mustsepecifyaprofilesectionname'] = "Ein Profilbereichsname muss festgelegt werden";
$lang['successfullyremovedselectedprofilesections'] = "Profilbereich erfolgreich geloescht";
$lang['failedtoremoveprofilesections'] = "Profilbereich konnte nicht geloescht werden";
$lang['viewitems'] = "Eintraege anzeigen";
$lang['successfullyaddednewprofileitem'] = "Profileintrag erfolgreich hinzugefuegt";
$lang['successfullyeditedprofileitem'] = "Profileintrag erfolgreich geaendert";
$lang['successfullyremovedselectedprofileitems'] = "ausgewaehlter Profileintrag erfolgreich geloescht";
$lang['failedtoremoveprofileitems'] = "Profileintrag konnte nicht geloescht werden";
$lang['noexistingprofileitemsfound'] = "Keine bestehenden Profileintraege in diesem Bereich. Um einen Eintrag hinzuzufuegen 'Neu hinzufuegen' klicken.";
$lang['edititem'] = "Eintrag bearbeiten";
$lang['invalidprofilesectionid'] = "Ungueltige Profilbereichs-ID oder Bereich nicht gefunden";
$lang['invalidprofileitemid'] = "Ungueltige Profilartikel-ID oder Artikel nicht gefunden";
$lang['addnewitem'] = "Neuen Eintrag hinzufuegen";
$lang['youmustenteraprofileitemname'] = "Profilartikelname muss eingegeben werden";
$lang['invalidprofileitemtype'] = "Ungueltiger Profilartikeltyp angegeben";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "Fuer den ausgewaehlten Profileintrags-Typ muessen einige Optionen eingegeben werden";
$lang['youmustentermorethanoneoptionforitem'] = "Fuer den ausgewaehlten Profileintrags-Typ muss mehr als eine Option eingegeben werden";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "Profileintrags-Hyperlinks unterstuetzen nur HTTP-URLs";
$lang['profileitemhyperlinkformatinvalid'] = "Profileintrags-Hyperlinkformat ungueltig";
$lang['youmustincludeprofileentryinhyperlinks'] = "Fuer anklickbare Hyperlinks muss <i>%s</i> in der URL eingetragen sein";
$lang['failedtocreatenewprofileitem'] = "Fehler beim Erstellen des neuen Profilartikels";
$lang['failedtoupdateprofileitem'] = "Fehler beim Aendern des Profilartikels";
$lang['startpageupdated'] = "Startseite geaendert. %s";
$lang['viewupdatedstartpage'] = "geaenderte Startseite anzeigen";
$lang['editstartpage'] = "Startseite editieren";
$lang['nouserspecified'] = "Kein Benutzer definiert.";
$lang['manageuser'] = "Manage Benutzer";
$lang['manageusers'] = "Manage Benutzer";
$lang['userstatusforforum'] = "Benutzerstatus fuer %s";
$lang['userdetails'] = "Benutzerdetails";
$lang['warning_caps'] = "WARNUNG";
$lang['userdeleteallpostswarning'] = "Bist Du sicher dass Du ALLE Eintraege des ausgewaehlten Benutzers loeschen willst? Sind die Eintraege einmal geloescht koennen sie nicht mehr wiederhergestellt werden.";
$lang['postssuccessfullydeleted'] = "Eintraege erfolgreich geloescht.";
$lang['folderaccess'] = "Ordnerzugriff";
$lang['possiblealiases'] = "Erlaubte Aliase";
$lang['userhistory'] = "Benutzerhistorie";
$lang['nohistory'] = "Keine Historieneintraege vorhanden";
$lang['userhistorychanges'] = "Aenderungen";
$lang['clearuserhistory'] = "Loesche Benutzerhistorie";
$lang['changedlogonfromto'] = "Logon geaendert von %s auf %s";
$lang['changednicknamefromto'] = "Nickname geaendert von %s auf %s";
$lang['changedemailfromto'] = "Email geaendert von %s auf %s";
$lang['successfullycleareduserhistory'] = "Benutzerhistorie erfolgreich geloescht";
$lang['failedtoclearuserhistory'] = "Fehler beim Loeschen der Benutzerhistorie";
$lang['successfullychangedpassword'] = "Passwort erfolgreich geaendert";
$lang['failedtochangepasswd'] = "Fehler beim Aendern des Passworts";
$lang['viewuserhistory'] = "Benutzerhistorie anzeigen";
$lang['viewuseraliases'] = "Benutzeraliase anzeigen";
$lang['searchreturnednoresults'] = "Suche fand keine Ergebnisse";
$lang['deleteposts'] = "Loesche Eintraege";
$lang['deleteuser'] = "Benutzer loeschen";
$lang['alsodeleteusercontent'] = "Auch alle Inhalte/Eintraege des Benutzers loeschen";
$lang['userdeletewarning'] = "Soll das Benutzerkonto wirklich geloescht werden? Das Konto kann nicht wiederhergestellt werden und ist dauerhaft geloescht.";
$lang['usersuccessfullydeleted'] = "Benutzer erfolgreich geloescht";
$lang['failedtodeleteuser'] = "Fehler beim Loeschen des Benutzers";
$lang['forgottenpassworddesc'] = "Falls der Benutzer sein Passwort vergessen hat kann es hier zurueckgesetzt werden.";
$lang['manageusersexp'] = "Diese Liste zeigt eine Benutzerauswahl, die in diesem Forum angemeldet sind, sortiert nach %s. Um Benutzerrechte zu aendern auf den Namen klicken.";
$lang['userfilter'] = "Benutzerfilter";
$lang['onlineusers'] = "Benutzer Online";
$lang['offlineusers'] = "Benutzer Offline";
$lang['usersawaitingapproval'] = "Noch nicht zugelassene Benutzer";
$lang['bannedusers'] = "Gebannte Benutzer";
$lang['lastlogon'] = "Letzte Anmeldung";
$lang['sessionreferer'] = "Abschnittsverweis";
$lang['signupreferer'] = "Ueberschriftsverweis:";
$lang['nouseraccountsmatchingfilter'] = "Kein Benutzerkonto entspricht dem Filter";
$lang['searchforusernotinlist'] = "Suche nach einem nicht aufgelisteten Benutzer";
$lang['adminaccesslog'] = "Admin Zugriffslog";
$lang['adminlogexp'] = "Liste zeigt die letzten Aktionen die von Admin-Benutzern unterbunden wurden.";
$lang['datetime'] = "Datum Uhrzeit";
$lang['unknownuser'] = "Unbekannter Benutzer";
$lang['unknownuseraccount'] = "Unbekanntes Benutzerkonto";
$lang['unknownfolder'] = "Unbekannter Ordner";
$lang['ip'] = "IP";
$lang['lastipaddress'] = "Letztes IP-address";
$lang['logged'] = "Gespeichert";
$lang['notlogged'] = "Nicht gelogged";
$lang['addwordfilter'] = "Wortfilter hinzufuegen";
$lang['addnewwordfilter'] = "neuen Wortfilter hinzufuegen";
$lang['wordfilterupdated'] = "Wortfilter aktualisiert";
$lang['wordfilterisfull'] = "Es koennen keine weiteren Wortfilter gesetzt werden. Loesche einige unbenutzte oder aendere bestehende.";
$lang['filtername'] = "Filtername";
$lang['filtertype'] = "Filtertyp";
$lang['filterenabled'] = "Filter aktiviert";
$lang['editwordfilter'] = "Wortfilter editieren";
$lang['nowordfilterentriesfound'] = "Keine bestehenden Wortfiltereintraege gefunden. Um einen Filter hinzuzufuegen auf 'Neu hinzufuegen' klicken.";
$lang['mustspecifyfiltername'] = "Filtername muss angegeben werden";
$lang['mustspecifymatchedtext'] = "Bitte Trefferauswahl definieren";
$lang['mustspecifyfilteroption'] = "Bitte Filteroption definieren";
$lang['mustspecifyfilterid'] = "Bitte Filter-ID definieren";
$lang['invalidfilterid'] = "nicht erlaubte Filter-ID";
$lang['failedtoupdatewordfilter'] = "Fehler beim Aendern des Wortfilters. Bitte pruefen ob Wortfilter existiert.";
$lang['allow'] = "Erlaubt";
$lang['block'] = "Block";
$lang['normalthreadsonly'] = "Nur Normale Eintraege";
$lang['pollthreadsonly'] = "Nur Abstimmungseintraege";
$lang['both'] = "Beide Eintragstypen";
$lang['existingpermissions'] = "Erteilte Erlaubnis";
$lang['nousershavebeengrantedpermission'] = "Keine bestehenden Benutzerrechte gefunden. Um REchte fuer den Benutzer zu definieren unten heraussuchen.";
$lang['successfullyaddedpermissionsforselectedusers'] = "Rechte fuer ausgewaehlten Benutzer erfolgreich hinzugefuegt";
$lang['successfullyremovedpermissionsfromselectedusers'] = "Rechte fuer ausgewaehlten Benutzer erfolgreich entfernt";
$lang['failedtoaddpermissionsforuser'] = "Fehler beim Hinzufuegen von Rechten fuer Benutzer '%s'";
$lang['failedtoremovepermissionsfromuser'] = "Fehler beim Entfernen von Rechten fuer Benutzer '%s'";
$lang['searchforuser'] = "Suche nach Benutzer";
$lang['browsernegotiation'] = "Browser ermittelt";
$lang['largetextfield'] = "Grosses Textfeld";
$lang['mediumtextfield'] = "Mittleres Textfeld";
$lang['smalltextfield'] = "Kleines Textfeld";
$lang['multilinetextfield'] = "Mehrzeilen-Textfeld";
$lang['radiobuttons'] = "Radio-Buttons";
$lang['dropdownlist'] = "Drop-Down Liste";
$lang['clickablehyperlink'] = "Anklickbarer Hyperlink";
$lang['threadcount'] = "Eintragszaehler";
$lang['clicktoeditfolder'] = "Klicken um Ordner zu bearbeiten";
$lang['fieldtypeexample1'] = "Um Radio Buttons oder eine Drop-Downliste zu erstellen muss fuer jeden Wert eine separate Zeile im Optionsfeld eingegeben werden.";
$lang['fieldtypeexample2'] = "Um anklickbare Links zu erstellen bitte die URL im Optionsfeld angeben und <i>%1\$s</i> benutzen bei dem der Eintrag des Benutzerprofils erscheinen sollte. Beispiel: <p>MySpace: <i>http://www.myspace.com/%1\$s</i><br />Xbox LIVE: <i>http://profile.mygamercard.net/%1\$s</i>";
$lang['editedwordfilter'] = "Editierter Wortfilter";
$lang['editedforumsettings'] = "Editierte Foreneinstellungen";
$lang['successfullyendedusersessionsforselectedusers'] = "Sitzung erfolgreich beendet fuer Benutzer";
$lang['failedtoendsessionforuser'] = "Sitzung des Benutzers %s konnte nicht beendet werden";
$lang['successfullyapprovedselectedusers'] = "Ausgewaehlte Benutzer erfolgreich geprueft";
$lang['matchedtext'] = "Gefundener Text";
$lang['replacementtext'] = "Ersetzter Text";
$lang['preg'] = "PREG";
$lang['wholeword'] = "Ganzes Wort";
$lang['word_filter_help_1'] = "<b>Alle</b> gefundenen Texte die so gefitert werden: mom zu mum werden auch solche Aenderungen durchfuehren: moment zu mument.";
$lang['word_filter_help_2'] = "<b>Ganzes Wort</b> gefundene Texte werden nur so gefiltert dass mom zu mum wird, aber keine Aenderung bei: moment.";
$lang['word_filter_help_3'] = "<b>PREG</b> Erlaubt Dir Perl-Regulaere Erweiterungen zu nutzen m Texte zu finden.";
$lang['nameanddesc'] = "Name und Beschreibung";
$lang['movethreads'] = "Verschiebe Eintraege";
$lang['movethreadstofolder'] = "Verschiebe Eintraege in Ordner";
$lang['failedtomovethreads'] = "Fehler beim Verschieben der Eintraege in definierten Ordner";
$lang['resetuserpermissions'] = "Benutzerrechte zuruecksetzen";
$lang['failedtoresetuserpermissions'] = "Fehler beim Zuruecksetzen der Benutzerrechte";
$lang['allowfoldertocontain'] = "Erlaubter Ordnerinhalt";
$lang['addnewfolder'] = "Neuen Ordner hinzufuegen";
$lang['mustenterfoldername'] = "Du musst einen Ordnernamen eingeben";
$lang['nofolderidspecified'] = "Keine Ordner-ID vorhanden";
$lang['invalidfolderid'] = "Unbekannte Ordner-ID. Stelle sicher dass ein Ordner mit dieser ID existiert!";
$lang['successfullyaddednewfolder'] = "Neuer Ordner erfolgreich hinzugefuegt";
$lang['successfullyremovedselectedfolders'] = "Ausgewaehlte Ordner erfolgreich geloescht";
$lang['successfullyeditedfolder'] = "Ordner erfolgreich bearbeitet";
$lang['failedtocreatenewfolder'] = "Fehler beim Ordnererstellen";
$lang['failedtodeletefolder'] = "Ordner konnte nicht geloescht werden.";
$lang['failedtoupdatefolder'] = "Fehler beim Ordneraendern";
$lang['cannotdeletefolderwiththreads'] = "Kann Ordner die noch Eintraege enthalten nicht loeschen.";
$lang['forumisnotrestricted'] = "kein eingeschraenktes Forum";
$lang['groups'] = "Gruppen";
$lang['nousergroups'] = "Keine Benutzergruppen definiert. Um eine Gruppe hinzuzufuegen 'Neu Hinzufuegen' klicken.";
$lang['suppliedgidisnotausergroup'] = "angegebene GID ist keine Benutzergruppe";
$lang['manageusergroups'] = "Manage Benutzergruppen";
$lang['groupstatus'] = "Gruppenstatus";
$lang['addusergroup'] = "Gruppe hinzufuegen";
$lang['addemptygroup'] = "Leere Gruppe hinzugefuegt";
$lang['adduserstogroup'] = "Benutzer zu Gruppe hinzufuegen";
$lang['addremoveusers'] = "Anfuegen/Loeschen Benutzer";
$lang['nousersingroup'] = "Keine Benutzer in dieser Gruppe. Um Benutzer dieser Gruppe hinzuzufuegen unten heraussuchen.";
$lang['groupaddedaddnewuser'] = "Gruppe erfolgreich hinzugefuegt. Um Benutzer dieser Gruppe hinzuzufuegen unten heraussuchen.";
$lang['nousersingroupaddusers'] = "Keine Benutzer in dieser Gruppe. Um Benutzer hinzuzufuegen auf 'Benutzer Hinzufuegen/Entfernen' klicken.";
$lang['useringroups'] = "Dieser Benutzer ist Mitglied folgender Gruppen";
$lang['usernotinanygroups'] = "Dieser Benutzer ist in keiner Benutzergruppe";
$lang['usergroupwarning'] = "Anmerkung: Dieser Benutzer koennte zusaetzliche Rechte von jeder unten aufgefuehrten Benutzergruppe erhalten.";
$lang['successfullyaddedgroup'] = "Gruppe erfolgreich angefuegt";
$lang['successfullyeditedgroup'] = "Gruppe erfolgreich bearbeitet";
$lang['successfullydeletedselectedgroups'] = "Ausgewaehlte Gruppen erfolgreich geloescht";
$lang['failedtodeletegroupname'] = "Fehler beim Loeschen von Gruppe %s";
$lang['usercanaccessforumtools'] = "Benutzer hat Zugriff auf Foren-Tools und kann Foren erstellen, loeschen und editieren";
$lang['usercanmodallfoldersonallforums'] = "Benutzer ist Moderator ueber <b>alle Ordner</b> in <b>allen Foren</b>";
$lang['usercanmodlinkssectiononallforums'] = "Benutzer kann den Links-Bereicht moderieren in <b>allen Foren</b>";
$lang['emailconfirmationrequired'] = "Email-Bestaetigung erforderlich";
$lang['userisbannedfromallforums'] = "Benutzer ist gebannt in <b>Allen Foren</b>";
$lang['cancelemailconfirmation'] = "Email-Bestaetigung abbrechen und Benutzer Start von Postings erlauben";
$lang['resendconfirmationemail'] = "Wiederhole Bestaetigungs-Email an Benutzer";
$lang['donothing'] = "Keine Aktion";
$lang['usercanaccessadmintools'] = "Benutzer hat Zugriff auf Foren-Admin-Tools";
$lang['usercanaccessadmintoolsonallforums'] = "Benutzer hat Zugriff auf Admin-Tools <b>in allen Foren</b>";
$lang['usercanmoderateallfolders'] = "Benutzer kann alle Ordner moderieren";
$lang['usercanmoderatelinkssection'] = "Benutzer kann Links-Bereich moderieren";
$lang['userisbanned'] = "Benutzer ist gebannt";
$lang['useriswormed'] = "Benutzer ist sauer";
$lang['userispilloried'] = "Benutzer ist ueberdreht";
$lang['usercanignoreadmin'] = "Benutzer kann Administrator ignorieren";
$lang['groupcanaccessadmintools'] = "Gruppe kann auf Admin-Tools zugreifen";
$lang['groupcanmoderateallfolders'] = "Gruppe kann alle Ordner moderieren";
$lang['groupcanmoderatelinkssection'] = "Gruppe kann Links-Bereich moderieren";
$lang['groupisbanned'] = "Gruppe ist gebannt";
$lang['groupiswormed'] = "Gruppe ist sauer";
$lang['readposts'] = "Lese Posts";
$lang['replytothreads'] = "Antwort auf Eintrag";
$lang['createnewthreads'] = "Erstelle neuen Eintrag";
$lang['editposts'] = "Editiere Posts";
$lang['deleteposts'] = "Loesche Eintraege";
$lang['postssuccessfullydeleted'] = "Eintraege erfolgreich geloescht.";
$lang['failedtodeleteusersposts'] = "Fehler beim Loeschen von Benutzerposts";
$lang['uploadattachments'] = "Anhang hochladen";
$lang['moderatefolder'] = "Moderiere Ordner";
$lang['postinhtml'] = "Post in HTML";
$lang['postasignature'] = "Poste eine Signatur";
$lang['editforumlinks'] = "Editiere Forum-Links";
$lang['linksaddedhereappearindropdown'] = "Hier hinzugefuegte Links erscheinen in einem Drop down im Kopf rechts des Framesets.";
$lang['linksaddedhereappearindropdownaddnew'] = "Hier hinzugefuegte Links erscheinen ind einem Dropdown im Kopf rechts des Framesets. Um einen Link hinzuzufuegen auf 'Neu hinzufuegen' klicken.";
$lang['failedtoremoveforumlink'] = "Fehler beim Entfernen des Foren-Links '%s'";
$lang['failedtoaddnewforumlink'] = "Fehler beim Hinzufuegen des neuen Foren-Links '%s'";
$lang['failedtoupdateforumlink'] = "Fehler beim Aendern des Foren-Links '%s'";
$lang['notoplevellinktitlespecified'] = "Kein top level link Titel angegeben";
$lang['youmustenteralinktitle'] = "Ein Link-Titel muss angegeben werden";
$lang['alllinkurismuststartwithaschema'] = "All Link-URLs muessen so beginnen (z.B. http://, ftp://, irc://)";
$lang['editlink'] = "Link bearbeiten";
$lang['addnewforumlink'] = "Neuen Link hinzufuegen";
$lang['forumlinktitle'] = "Forum Link Titel";
$lang['forumlinklocation'] = "Forum Link Bereich";
$lang['successfullyaddednewforumlink'] = "Neuer Foren-Link erfolgreich hinzugefuegt";
$lang['successfullyeditedforumlink'] = "Foren-Link erfolgreich bearbeitet";
$lang['invalidlinkidorlinknotfound'] = "Falsche Link-ID oder Link nicht gefunden";
$lang['successfullyremovedselectedforumlinks'] = "Ausgewaehlte Links erfolgreich entfernt";
$lang['toplinkcaption'] = "Top Link Untertitel";
$lang['allowguestaccess'] = "Erlaube Gast-Zugriff";
$lang['searchenginespidering'] = "Suche ueber Engine Spider-ing";
$lang['allowsearchenginespidering'] = "Erlaube Suche Engine Spider-ing";
$lang['newuserregistrations'] = "Neue Benutzerregistrierungen";
$lang['preventduplicateemailaddresses'] = "Verhindere doppelte eMail-Adressen";
$lang['allownewuserregistrations'] = "Erlaube neue Benutzerregistrierungen";
$lang['requireemailconfirmation'] = "Email-Bestaetigung notwendig";
$lang['usetextcaptcha'] = "Benutze Text Captcha";
$lang['textcaptchadir'] = "Text captcha Verzeichnis";
$lang['textcaptchakey'] = "Text captcha Schluessel";
$lang['textcaptchafonterror'] = "Text Captcha wurde automatisch deaktiviert da keine True-Type-Fonts vorhanden sind. Bitte lade einige TTFonts <b>text_captcha/fonts</b> auf deinen Server.";
$lang['textcaptchadirerror'] = "Text Captcha wurde deaktiviert da das text_captcha Verzeichnis und seine Unterverzeichnisse keine Schreibrechte haben auf diesem Webserver / PHP Prozess.";
$lang['textcaptchagderror'] = "Text Captcha wurde deaktiviert da deines Server's PHP setup keine GD-Imagebearbeitung zulaesst und / oder TTF fonts fehlen. Beides ist notwendig fuer text captcha support.";
$lang['textcaptchadirblank'] = "Text captcha Verzeichnis ist leer!";
$lang['newuserpreferences'] = "Neue Benutzerpraeferenz";
$lang['sendemailnotificationonreply'] = "Emailmitteilung ueber Antwort von Benutzer";
$lang['sendemailnotificationonpm'] = "Emailmitteilung ueber PM von Benutzer";
$lang['showpopuponnewpm'] = "Zeige Pop-Up wenn neue PM eingeht";
$lang['setautomatichighinterestonpost'] = "Setze automatisch Hohes Interesse in Posts";
$lang['postingstats'] = "Eintragsstatistik";
$lang['postingstatsforperiod'] = "Posting Statistik fuer Zeitraum von %s bis %s";
$lang['nopostdatarecordedforthisperiod'] = "Keine Eintragsdaten gespeichert fuer diesen Zeitraum.";
$lang['totalposts'] = "Totale Posts";
$lang['totalpostsforthisperiod'] = "Totale Posts fuer diesen Zeitraum";
$lang['mustchooseastartday'] = "Waehle Start Tag";
$lang['mustchooseastartmonth'] = "Waehle Start Monat";
$lang['mustchooseastartyear'] = "Waehle Start Jahr";
$lang['mustchooseaendday'] = "Waehle Ende Tag";
$lang['mustchooseaendmonth'] = "Waehle Ende Monat";
$lang['mustchooseaendyear'] = "Waehle Ende Jahr";
$lang['startperiodisaheadofendperiod'] = "Start-Zeitraum ist hoeher als Ende-Zeitraum";
$lang['bancontrols'] = "Bann-Kontrolle";
$lang['addban'] = "Sperre hinzufuegen";
$lang['checkban'] = "Sperre pruefen";
$lang['editban'] = "Sperre bearbeiten";
$lang['bantype'] = "Sperrtyp";
$lang['bandata'] = "Sperrdaten";
$lang['bancomment'] = "Bemerkung";
$lang['ipban'] = "IP sperren";
$lang['logonban'] = "Anmeldung sperren";
$lang['nicknameban'] = "Nickname sperren";
$lang['emailban'] = "Email sperren";
$lang['refererban'] = "Verweis sperren";
$lang['invalidbanid'] = "Unzulaessige Sperr-ID";
$lang['affectsessionwarnadd'] = "Diese Sperren beeinflusst folgende aktiven Benutzersitzungen";
$lang['noaffectsessionwarn'] = "Dieser Bann betrifft keine aktive Sitzungen";
$lang['mustspecifybantype'] = "Sperrtyp muss ausgewaehlt sein";
$lang['mustspecifybandata'] = "Einige Sperrdaten muessen ausgewaehlt werden";
$lang['successfullyremovedselectedbans'] = "Ausgewaehlte Sperren erfolgreich entfernt";
$lang['failedtoaddnewban'] = "neue Sperre nicht angefuegt";
$lang['failedtoremovebans'] = "einige oder alle ausgewaehlten Sperren konnten nicht entfernt werden";
$lang['duplicatebandataentered'] = "Doppelte Sperrdaten eingegeben. Bitte Wildcards pruefen ob diese den eingegebenen Daten entsprechen.";
$lang['successfullyaddedban'] = "Sperre erfolgreich hinzugefuegt";
$lang['successfullyupdatedban'] = "Sperre erfolgreich geaendert";
$lang['noexistingbandata'] = "Keine Sperrdaten vorhanden. Um Sperrdaten hinzuzufuegen folgende Schaltflaeche klicken.";
$lang['youcanusethepercentwildcard'] = "Du kannst das Prozent-Zeichen (%) benutzen als wildcard-Symbol in jedem Eintrag deiner Bannliste um komplette Bereiche zu definieren, z.B. '192.168.0.%' bannt alle IP-Addressen in dem Bereich 192.168.0.1 bis 192.168.0.254</p>";
$lang['cannotusewildcardonown'] = "Du kannst kein % als alleinigen Wert eintragen!";
$lang['requirepostapproval'] = "Erfordert Post-Zustimmung";
$lang['adminforumtoolsusercounterror'] = "Es muss mindestens 1 Benutzer mit Admin-Tools und Forum-Tools Berechtigung in allen Foren vorhanden sein!";
$lang['postcount'] = "Postzaehler";
$lang['resetpostcount'] = "Postzaehler zuruecksetzen";
$lang['failedtoresetuserpostcount'] = "Fehler beim Zuruecksetzen des Eintragszaehlers";
$lang['failedtochangeuserpostcount'] = "Fehler beim Aendern des Eintragszaehlers des Benutzers";
$lang['postapprovalqueue'] = "Post Zustimmungswarteschlange";
$lang['nopostsawaitingapproval'] = "Keine Posts warten auf Zustimmung";
$lang['approveselected'] = "Zustimmung ausgewaehlt";
$lang['failedtoapproveuser'] = "Fehler beim Zulassen des Benutzers %s";
$lang['kickselected'] = "Kick (kurzfristiger Rauswurf) ausgewaehlt";
$lang['visitorlog'] = "Benutzer Log";
$lang['clearvisitorlog'] = "Besucher-Log loeschen";
$lang['novisitorslogged'] = "Kein Besucher protokolliert";
$lang['addselectedusers'] = "Ausgewaehlte Benutzer hinzufuegen";
$lang['removeselectedusers'] = "Ausgewaehlte Benutzer loeschen";
$lang['addnew'] = "Neu hinzufuegen";
$lang['deleteselected'] = "Auswahl loeschen";
$lang['forumrulesmessage'] = "<p><b>Foren-Regeln</b></p><p>\nRegistrierung zu %1\$s frei! Wir bestehen auf Einhaltung der Regeln und Verfahren dieses Forums. Wenn Sie mit den Bedingungen einverstanden sind, bitte das 'Ich bin einverstanden'-Feld aktivieren und auf 'Registrieren' klicken. Wenn Sie die Registirerung abbrechen moechten, klicken Sie %2\$s um zum Forum zurueckzukehren.</p><p>\nAuch werden die Administratoren und Moderatoren des %1\$s versuchen alle unerwuenschten/anstoessigen Nachrichten zu entfernen, leider ist es uns unmöglich alle Eintraege in diesem Forum zu pruefen. Alle Nachrichten sind dem jeweiligen Autor zuzuschreiben und nicht den Betreibern des %1\$s, kein Projekt des Beehive Forum und seiner Ableger ist rechtlich belangbar fuer die Inhalte der Nachrichten/Eintraege.</p><p>\nMit dem Akzeptieren dieser Regeln garantieren Sie, dass Sie keinerlei Nachrichten posten die abstoessig, vulgaer, sex-orientiert, hassend, drohend oder in sonstiger Weise gegen geltendes Recht verstossen.</p><p>Die Betreiber des %1\$s behalten sich das Recht vor jegliche Eintraege zu loeschen, aendern, verschieben oder zu sperren, gleich aus welchem Grund.</p>";
$lang['cancellinktext'] = "hier";
$lang['failedtoupdateforumsettings'] = "Fehler beim Aendern der Foren-Einstellungen. Bitte spaeter nochmal probieren.";
$lang['moreadminoptions'] = "Weitere Admin-Optionen";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "Benutzerstatus geaendert fuer '%s'";
$lang['changedpasswordforuser'] = "Passwort geaendert fuer '%s'";
$lang['changedforumaccess'] = "Forum-Zugriffsberechtigungen geaendert fuer '%s'";
$lang['deletedallusersposts'] = "Alle Posts geloescht fuer '%s'";

$lang['createdusergroup'] = "Benutzergruppe '%s' erstellt";
$lang['deletedusergroup'] = "Benutzergruppe '%s' geloescht";
$lang['updatedusergroup'] = "Benutzergruppe '%s' geaendert";
$lang['addedusertogroup'] = "Benutzer '%s' an Gruppe '%s' angefuegt";
$lang['removeduserfromgroup'] = "Benutzer '%s' von Gruppe '%s' geloescht";

$lang['addedipaddresstobanlist'] = "IP '%s' an Bannliste angefuegt";
$lang['removedipaddressfrombanlist'] = "IP '%s' aus Bannliste geloescht";

$lang['addedlogontobanlist'] = "Logon '%s' in Bannliste angefuegt";
$lang['removedlogonfrombanlist'] = "Logon '%s' von Bannliste geloescht";

$lang['addednicknametobanlist'] = "Nickname '%s' an Bannliste angefuegt";
$lang['removednicknamefrombanlist'] = "Nickname '%s' aus Bannliste geloescht";

$lang['addedemailtobanlist'] = "Emailaddresse '%s' an Bannliste angefuegt";
$lang['removedemailfrombanlist'] = "Emailaddresse '%s' von Bannliste geloescht";

$lang['addedreferertobanlist'] = "Verweis '%s' an Bannliste angefuegt";
$lang['removedrefererfrombanlist'] = "Verweis '%s' von Bannliste geloescht";

$lang['editedfolder'] = "Editierte Ordner '%s'";
$lang['movedallthreadsfromto'] = "Alle Eintraege verschoben von '%s' nach '%s'";
$lang['creatednewfolder'] = "Neuer Ordner '%s' erstellt";
$lang['deletedfolder'] = "Ordner '%s' geloescht";

$lang['changedprofilesectiontitle'] = "Profilbereich Titel von '%s' nach '%s' geaendert";
$lang['addednewprofilesection'] = "Neuer Profilbereich '%s' erstellt";
$lang['deletedprofilesection'] = "Profilbereich '%s' geloescht";

$lang['addednewprofileitem'] = "Neuer Profileintrag '%s' in Bereich '%s' hinzugefuegt";
$lang['changedprofileitem'] = "Profileintrag '%s' geaendert";
$lang['deletedprofileitem'] = "Profileintrag '%s' geloescht";

$lang['editedstartpage'] = "Startseite editiert";
$lang['savednewstyle'] = "Neuer Stil '%s' gespeichert";

$lang['movedthread'] = "Verschobener Eintrag '%s' von '%s' nach '%s'";
$lang['closedthread'] = "Eintrag geschlossen '%s'";
$lang['openedthread'] = "Eintrag geoeffnet '%s'";
$lang['renamedthread'] = "Umbenannter Eintrag '%s' to '%s'";

$lang['deletedthread'] = "Geloeschter Eintrag '%s'";
$lang['undeletedthread'] = "Ungeloeschter Eintrag '%s'";

$lang['lockedthreadtitlefolder'] = "Gesperrte Eintragsoptionen auf '%s'";
$lang['unlockedthreadtitlefolder'] = "Geoeffnete Eintragsoptionen auf '%s'";

$lang['deletedpostsfrominthread'] = "Geloeschte Posts von '%s' in Eintrag '%s'";
$lang['deletedattachmentfrompost'] = "Geloeschter Anhang '%s' von Post '%s'";

$lang['editedforumlinks'] = "Editierte Foren-Links";
$lang['editedforumlink'] = "Bearbeiteter Foren-Link: '%s'";

$lang['addedforumlink'] = "Hinzugefuegter Foren-Link: '%s'";
$lang['deletedforumlink'] = "Geloeschter Foren-Link: '%s'";
$lang['changedtoplinkcaption'] = "Top-Link Untertitel geaendert von '%s' auf '%s'";

$lang['deletedpost'] = "Geloeschter Post '%s'";
$lang['editedpost'] = "Editierter Post '%s'";

$lang['madethreadsticky'] = "Eintrag erstellt '%s' sticky";
$lang['madethreadnonsticky'] = "Eintrag erstellt '%s' non-sticky";

$lang['endedsessionforuser'] = "Beendete Sitzung fuer Benutzer '%s'";

$lang['approvedpost'] = "Akzeptierter Post '%s'";

$lang['editedwordfilter'] = "Editierter Wortfilter";

$lang['addedrssfeed'] = "RSS Feed '%s' hinzugefuegt";
$lang['editedrssfeed'] = "RSS Feed '%s' bearbeitet";
$lang['deletedrssfeed'] = "RSS Feed '%s' geloescht";

$lang['updatedban'] = "Sperre '%s'. '%s' an '%s', '%s' an '%s' aktualisiert.";

$lang['splitthreadatpostintonewthread'] = "Teile Eintrag '%s' im Post %s in neuen Eintrag '%s'";
$lang['mergedthreadintonewthread'] = "Gemischte Eintraege '%s' und '%s' in neuen Eintrag '%s'";

$lang['approveduser'] = "Anerkannter Benutzer '%s'";

$lang['forumautoupdatestats'] = "Forum Auto Update: Statistiken aktualisiert";
$lang['forumautoprunepm'] = "Forum Auto Update: PM Ordner bereinigt";
$lang['forumautoprunesessions'] = "Forum Auto Update: Sitzungen bereinigt";
$lang['forumautocleanthreadunread'] = "Forum Auto Update: ungelesene Eintragsdaten bereinigt";
$lang['forumautocleancaptcha'] = "Forum Auto Update: Text-Captcha Bilder bereinigt";

$lang['adminlogempty'] = "Admin Log ist leer";

$lang['youmustspecifyanactiontypetoremove'] = "Zum Loeschen Vorgangstyp vorher auswaehlen";

$lang['removeentriesrelatingtoaction'] = "Vorgangsbezug auf Eintragsloeschung";
$lang['removeentriesolderthandays'] = "Eintraege loeschen die aelter sind als (Tage)";

$lang['successfullyprunedadminlog'] = "Admin-Log erfolgreich bereinigt";
$lang['failedtopruneadminlog'] = "Fehler beim Bereinigen des Admin-Logs";

$lang['prune_log'] = "Log-Bereinigung";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "Keine existierenden Foren gefunden. Um eine neues Forum zu erstellen folgende Schaltflaeche klicken.";
$lang['webtaginvalidchars'] = "Webtag akzeptiert nur grossgeschriebene A-Z und 0-9, _ - Zeichen";
$lang['databasenameinvalidchars'] = "Datenbankname darf nur a-z, A-Z, 0-9 und Unterstrich-Zeichen beinhalten";
$lang['invalidforumidorforumnotfound'] = "Falsche Forum-FID oder Forum nicht gefunden";
$lang['successfullyupdatedforum'] = "Forum erfolgreich aktualisiert: '%s'";
$lang['failedtoupdateforum'] = "Forum konnte nicht aktualisiert werden: '%s'";
$lang['successfullycreatednewforum'] = "Forum erfolgreich erstellt";
$lang['selectedwebtagisalreadyinuse'] = "Ausgewaehlter Webtag ist gerade in Benutzung. Bitte anderen auswaehlen.";
$lang['selecteddatabasecontainsconflictingtables'] = "Tabellenkonflikt in ausgewaehlter Datenbank. Betreffende Tabellen sind:";
$lang['forumdeleteconfirmation'] = "Sind Sie sicher dass Sie alle Eintraege der ausgewaehlten Foren loeschen wollen ?";
$lang['forumdeletewarning'] = "Bist Du sicher dass das ausgewaehlte Forum geloescht werden soll? Sobald es geloescht ist ist es nicht mehr wiederherstellbar.";
$lang['successfullyremovedselectedforums'] = "Ausgewaehlte Foren erfolgreich geloescht";
$lang['failedtodeleteforum'] = "Forum konnte nicht geloescht werden: '%s'";
$lang['addforum'] = "Forum hinzufuegen";
$lang['editforum'] = "Forum bearbeiten";
$lang['visitforum'] = "Besuche Forum: %s";
$lang['accesslevel'] = "Zugriffsstufe";
$lang['forumleader'] = "Forenleiter";
$lang['usedatabase'] = "Benutze Datenbank";
$lang['unknownmessagecount'] = "Unbekannt";
$lang['forumwebtag'] = "Foren-Webtag";
$lang['defaultforum'] = "Standard-Forum";
$lang['forumdatabasewarning'] = "Bitte sicherstellen dass Sie die richtige Datenbank ausgewaehlt haben wenn Sie ein neues Forum erstellen. Ein einmal erstelltes Forum kann nicht verschoben werden zwischen verschiedenen Datenbanken.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "Allgemeine Benutzerberechtigungen";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "Sie muessen einen Forum-Webtag angeben";
$lang['mustsupplyforumname'] = "Du musst einen Forennamen angeben";
$lang['mustsupplyforumemail'] = "Du musst eine Foren-Emailaddresse angeben";
$lang['mustchoosedefaultstyle'] = "Du musst einen Standard-Forenstil auswaehlen";
$lang['mustchoosedefaultemoticons'] = "Du musst Standard Foren-emoticons auswaehlen";
$lang['mustsupplyforumaccesslevel'] = "Sie muessen eine Forum-Zugriffsstufe angeben";
$lang['mustsupplyforumdatabasename'] = "Sie muessen einen Forum-Datenbanknamen angeben";
$lang['unknownemoticonsname'] = "Unbekannter emoticon Name";
$lang['mustchoosedefaultlang'] = "Du musst eine Standard Forensprache auswaehlen";
$lang['activesessiongreaterthansession'] = "Aktiver Sitzungstimeout kann nicht groesser sein als Sitzungstimeout";
$lang['attachmentdirnotwritable'] = "Anhangsverzeichnis muss Schreibrechte auf dem Webserver / PHP-Prozess haben!";
$lang['attachmentdirblank'] = "Du musst ein Verzeichnis fuer die Speicherung der Anhaenge angeben";
$lang['mainsettings'] = "Haupteinstellungen";
$lang['forumname'] = "ForenName";
$lang['forumemail'] = "Foren-Email";
$lang['forumnoreplyemail'] = "No-Reply Email";
$lang['forumdesc'] = "Forum Beschreibung";
$lang['forumkeywords'] = "Forum Schluesselwoerter";
$lang['defaultstyle'] = "Standard Stil";
$lang['defaultemoticons'] = "Standard Emoticons";
$lang['defaultlanguage'] = "Standard Sprache";
$lang['forumaccesssettings'] = "Forenzugriffseinstellungen";
$lang['forumaccessstatus'] = "Forenzugriffsstatus";
$lang['changepermissions'] = "Berechtigungen aendern";
$lang['changepassword'] = "Passwort aendern";
$lang['passwordprotected'] = "Passwort geschuetzt";
$lang['passwordprotectwarning'] = "Es ist noch kein Foren-Passwort gesetzt. Wenn Sie kein Passwort setzen werden Schutzfunktionen automatisch deaktiviert!";
$lang['postoptions'] = "Post Optionen";
$lang['allowpostoptions'] = "Erlaube Post Editierung";
$lang['postedittimeout'] = "Post Editierungs-Timeout";
$lang['posteditgraceperiod'] = "Post Bearbeitung Grace Periode";
$lang['wikiintegration'] = "WikiWiki Integrierung";
$lang['enablewikiintegration'] = "WikiWiki Integration einschalten";
$lang['enablewikiquicklinks'] = "WikiWiki Quick Links einschalten";
$lang['wikiintegrationuri'] = "WikiWiki Position";
$lang['maximumpostlength'] = "Max Post-Laenge";
$lang['postfrequency'] = "Post Haeufigkeit";
$lang['enablelinkssection'] = "Linksbereich aktivieren";
$lang['allowcreationofpolls'] = "Abstimmungserstellung erlauben";
$lang['allowguestvotesinpolls'] = "Erlaube Gaesten in Abstimmungen zu waehlen";
$lang['unreadmessagescutoff'] = "Ungelesene Nachrichten abgeschnitten";
$lang['disableunreadmessages'] = "Ungelesene Nachrichten deaktiviert";
$lang['thirtynumberdays'] = "30 Tagen";
$lang['sixtynumberdays'] = "60 Tagen";
$lang['ninetynumberdays'] = "90 Tagen";
$lang['hundredeightynumberdays'] = "180 Tagen";
$lang['onenumberyear'] = "1 Jahr";
$lang['searchoptions'] = "Optionen suchen";
$lang['searchfrequency'] = "Haeufigkeit suchen";
$lang['sessions'] = "Sitzungen";
$lang['sessioncutoffseconds'] = "Sitzung abbrechen (Sekunden)";
$lang['activesessioncutoffseconds'] = "Aktive Sitzung abbrechen (Sekunden)";
$lang['stats'] = "Statistik";
$lang['hide_stats'] = "Statistik verstecken";
$lang['show_stats'] = "Statistik zeigen";
$lang['enablestatsdisplay'] = "Statistikanzeige aktivieren";
$lang['personalmessages'] = "Persoenliche Nachrichten (PM)";
$lang['enablepersonalmessages'] = "Persoenliche Nachrichten freischalten";
$lang['pmusermessages'] = "PM-Nachrichten je Benutzer";
$lang['allowpmstohaveattachments'] = "Erlaube Anhaenge an PMs";
$lang['autopruneuserspmfoldersevery'] = "Automatische Ueberpruefung der PM-Ordner der Benutzer alle";
$lang['userandguestoptions'] = "Benutzer- und Gaeste-Optionen";
$lang['enableguestaccount'] = "Aktiviere Gastzugang";
$lang['listguestsinvisitorlog'] = "Gaesteliste in Besucher-Log";
$lang['allowguestaccess'] = "Erlaube Gast-Zugriff";
$lang['userandguestaccesssettings'] = "Benutzer- und Gast-Zugriffseinstellungen";
$lang['allowuserstochangeusername'] = "Benutzer erlauben Benutzernamen zu aendern";
$lang['requireuserapproval'] = "Benoetige Benutzerzustimmung vom Admin";
$lang['requireforumrulesagreement'] = "Benötige Benutzer zur Forenregeln-Zustimmung";
$lang['enableattachments'] = "Erlaube Anhaenge";
$lang['attachmentdir'] = "Anhangsverzeichnis";
$lang['userattachmentspace'] = "Anhangsspeicherplatz je Benutzer";
$lang['allowembeddingofattachments'] = "Erlaube Einbettung von Anhaengen";
$lang['usealtattachmentmethod'] = "Benutze alternative Anhangsmethoden";
$lang['allowgueststoaccessattachments'] = "Zugriff auf Anhaenge Gaesten erlauben";
$lang['forumsettingsupdated'] = "Forumeinstellungen erfolgreich geaendert";
$lang['forumstatusmessages'] = "Forum Status-Nachrichten";
$lang['forumclosedmessage'] = "Forum-Nachricht geschlossen";
$lang['forumrestrictedmessage'] = "Forum Eingeschraenkte Nachricht";
$lang['forumpasswordprotectedmessage'] = "Forum Passwort-geschuetzte Nachricht";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>Post Edit Timeout</b> Ist die Zeit in Sekunden nachdem ein Benutzer sein Posting noch aendern kann. 0 heisst keine Einschraenkung.";
$lang['forum_settings_help_11'] = "<b>Max Post Laenge</b> maximale Anzahl von Zeichen die in einem Post angezeigt werden. Ist ein Post laenger wird dieser abgeshnitten und ein Link ans Ende gesetzt um den Benutzern den ganzen Post auf einer Extraseite anzuzeigen.";
$lang['forum_settings_help_12'] = "Wenn Du nicht willst dass Benutzer Abstimmungen erstellen koennen deaktiviere diese Option.";
$lang['forum_settings_help_13'] = "Der Links-Bereich zeigt eine Liste von Seiten die haeufig besucht wurden, die andere Benutzer interessant finden koennten. Links koennen getrennt in Kategorien angezeigt werden und erlauben Kommentare und Benotung. Zur Moderation dieser Links muss der Benutzer globalen Moderator-Status haben.";
$lang['forum_settings_help_15'] = "<b>Sitzung abbrechen</b> maximale Zeit bevor eine Sitzung abgebrochen und der Benutzer abgemeldet wird. Standardmaessig sind dies 24 Stunden (86400 sek).";
$lang['forum_settings_help_16'] = "<b>Aktive Sitzung abbrechen</b> maximale Zeit bevor eine Benutzersitzung als inaktiv angesehen wird. In diesem Fall bleibt der Benutzer noch angemeldet, wird aber aus der Liste der Aktiven entfernt. Sobald er wieder aktiv wird wird er neu in die Aktiv-Liste aufgenommen. Standardmaessig sind dies 15 Min (900 sek).";
$lang['forum_settings_help_17'] = "Aktivieren dieser Option erlaubt dem Forum eine Statistik anzuzeigen am Ende der Nachrichten. Einmal aktivert kann die Statistik individuell von jedem Benutzer umgeschaltet werden. Wenn diese es nicht sehen wollen koennen sie es selbst ausblenden.";
$lang['forum_settings_help_18'] = "Persoenliche Nachrichten (PMs) sind ein unschaetzbarer Weg private Angelegenheiten persoenlich ohne Sicht anderer Benutzer zu klaeren. Wenn dies nicht erwuenscht ist kann es hier abgestellt werden.";
$lang['forum_settings_help_19'] = "Persoenliche Nachrichten (PMs) koennen auch Anhaenge beinhalten zum Datenaustausch mit anderen Benutzern.";
$lang['forum_settings_help_20'] = "<b>Merke:</b> Die Speichergroesse von PM-Anhaengen wird von des jeweiligen Benutzers Gesamtgroesse verwenden, sie verbraucht also dessen Speicherplatz.";
$lang['forum_settings_help_21'] = "Der Gastzugang erlaubt Anwendern ohne Anmeldung Foreneintraege zu lesen.";
$lang['forum_settings_help_22'] = "Wenn Du willst kannst Du das Forum so konfigurieren dass Benutzer automatisch als Gast angemeldet sind. Sobald ein Benutzer registriert ist wird sein Benutzername automtisch im Login angezeigt (wenn Cookies bei ihm aktiv sind).";
$lang['forum_settings_help_23'] = "Das Forum erlaubt Anhaenge mit Nachrichten hochzuladen. Wenn Du zu wenig Speicherplatz hast kannst Du diese Option natuerlich auch abschalten.";
$lang['forum_settings_help_24'] = "<b>Verzeichnis fuer Anhaenge</b> ist das Verzeichnis in dem die Dateianhaenge gespeichert werden. Dieses Verzeichnis muss auf dem Webserver vorhanden sein und muss Schreibrechte haben.";
$lang['forum_settings_help_25'] = "<b>Anhangsspeicherplatz je Benutzer</b> ist der maximale Speicherplatz den jeder Benutzer nutzen darf fuer Dateianhaenge. Ist dieser Platz verbraucht kann nicht mehr hochgeladen werden. Im Standard ist das 1 MB.";
$lang['forum_settings_help_26'] = "<b>Erlaube Einbetten von Anhaengen in Nachrichten / Signaturen</b> sagt ja schon alles, oder? ;-)";
$lang['forum_settings_help_27'] = "<b>Benutzer alternative Anhangmethode</b> Wenn Fehler beim Download von Anhaengen kommen (404 error message) versuche dies durch aktivieren dieser Option zu beheben.";
$lang['forum_settings_help_28'] = "Diese Einstellung erlaubt Suchmaschinen Dein Forum zu durchsuchen und im Listing aufzunehmen (z.B. Google, AltaVista und Yahoo).";
$lang['forum_settings_help_29'] = "<b>Erlaubt neuen Benutzern sich zu registrieren</b> ist dies abgeschaltet koennen sich keine neuen Benutzer registrieren.";
$lang['forum_settings_help_30'] = "<b>Aktiviert WikiWiki Integration</b> erlaubt WikiWord-Zugriff in den Foren-Posts. WikiWords sind miteinander verkettete Woerter in Grossbuchstaben. Wenn Du so ein Wort schreibst wird es automatisch in ein Hyperlink geaendert das auf den WikiWiki-Seiten gesucht/erklaert wird.";
$lang['forum_settings_help_31'] = "<b>Aktivert WikiWiki Quick Links</b> aktiviert die Benutzung von msg:1.1 und User:Logon-Stilen erweiterten WikiLinks die Hyperlinks zu den spezifizierten Nachrichten / Benutzerprofilen erstellen.";
$lang['forum_settings_help_32'] = "<b>WikiWiki Position</b> hier wird der Pfad zu deinem gewuenschten WikiWiki angegeben. Bei Eingabe der URL sollte dies: <i>%1\$s</i> als Platzhalter fuer das betreffende Wort angegeben werden, z.B.: <i>http://en.wikipedia.org/wiki/%1\$s</i> sendet das WikiWord an %s";
$lang['forum_settings_help_33'] = "<b>Forum Access Status</b> ueberprueft wielvie Benutzer das Forum nutzen.";
$lang['forum_settings_help_34'] = "<b>Offen</b> Erlaubt allen Benutzern und Gaesten das Forum zu nutzen.";
$lang['forum_settings_help_35'] = "<b>Geschlossen</b> Laesst keinen Zugriff mehr zu ausser dem Admin in die Admin-Tools.";
$lang['forum_settings_help_36'] = "<b>Eingeschraenkt</b> erlaubt eine Liste von Benutzern zu definieren die Zugriff erhalten.";
$lang['forum_settings_help_37'] = "<b>Passwortgeschuetzt</b> Erlaubt ein Passwort zu definieren ueber das das Forum dann nur zu betreten ist.";
$lang['forum_settings_help_38'] = "Bei Eingeschraenkt oder Passwortgeschuetzt muss vorher gespeichert werden bevor die Berechtigungen definiert werden.";
$lang['forum_settings_help_39'] = "<b>suchhaeufigkeit</b> definiert wie lange ein Benutzer warten muss bis er weitersuchen kann. Sucharbeiten sind auf einem Server sehr rechenintensiv, daher ist es wichtig dass eine weitere Suche erst nach fruehestens 30 Sek. stattfinden kann \"search spamming\" sonst bremst das den Server bis zum Stillstand.";
$lang['forum_settings_help_40'] = "<b>Post Haeufigkeit</b> Minimum an Zeit die ein Benutzer warten muss bevor er einen weiteren Post erstellen kann. Dies betrifft ebenso auch Abstimmungen. 0 deaktiviert die Einschraenkung.";
$lang['forum_settings_help_41'] = "Die oben genannten Optionen aendern die Einstellungen für Benutzerregistrierungen. Ansonsten werden die Standardeinstellungen verwendet.";
$lang['forum_settings_help_42'] = "<b>Verhindere Benutzung doppelter e-Mailadressen</b> laesst bei Benutzerregistrierungen keine gleichen eMail-Adressen zu.";
$lang['forum_settings_help_43'] = "<b>Benoetigt eMail-Bestaetigung</b> wenn aktiv wird eine email an jeden neuen Benutzer gesendet mit einem Link der zur Bestaetigung der eMail-Adresse notwendig ist. Bis zur Bestaetigung ist der Anwender nicht in der Lage zu posten ausser wenn der Admin die Berechtigungen manuell vorher freigibt.";
$lang['forum_settings_help_44'] = "<b>Benutze Text Captcha</b> zeigt dem neuen Benutzer ein Bild von dem die Nummer in ein Textfeld der Registrierung eingetragen werden muss. Benutz diese Option um automatisierte Registrierungen durchzufuehren.";
$lang['forum_settings_help_47'] = "<b>Post Bearbeitung Grace Periode</b> zur Definition einer Zeitspanne in Minuten in denen Benutzer ihre Posts bearbeiten ohne dass ein 'EDITED BY' Text erscheint in deren Posts. 0 heisst der 'EDITED BY' Text erscheint immer.";
$lang['forum_settings_help_49'] = "Auswahl von <b>Ungelesene Nachrichten deaktivieren</b> wird der Ungelesene-Nachrichten-Support vollstaendig und alle relevanten Optionen des Diskussionstyps aus der Drop-Down-Liste der Eintraege entfernt.";
$lang['forum_settings_help_50'] = "Ihr Beehive Forum wird nicht automatisch die ungelesenen Nachrichten Ihrer Datenbank abschneiden. Sie muessen dies in den Abschneide-Optionen explizit auswaehlen.";
$lang['forum_settings_help_51'] = "Du kannst eine vorhergehende Genehmigung für alle Benutzerrechte anfordern, bevor sie genutzt werden koennen, indem Du diese Option aktivierst. Ohne Aktivierung kann ein Benutzer keinen Bereich der Beehive-Forumsinstallation einschliesslich individueller Foren nutzen, PM-Eingang und Mein-Forum-Bereiche.";
$lang['forum_settings_help_52'] = "Nutze <b>Geschlossene Nachricht</b>, <b>Eingeschraenkte Nachricht</b> und <b>Passwort-geschuetzte Nachricht</b> um besondere Einstellungen der Nachricht anzuzeigen wenn Benutzer auf das Forum auf verschiedene Arten zugreifen.";
$lang['forum_settings_help_53'] = "In den Nachrichten kann HTML genutzt werden. Hyperlinks und email-Addressen werden ebenfalls automatisch in Links konvertiert. Um die Standard-Beehive-Forum-Einstellungen zu nutzen leere die Felder.";
$lang['forum_settings_help_54'] = "Use <b>Forum Rules</b> to enter an Accetable Use Policy that each user must agree to before registering on your forum.";
$lang['forum_settings_help_55'] = "Sie koennen HTML in Forenregeln nutzen. Hyperlinks und email-Adressen werden auch automatisch in Links umgewandelt. Um das Standard-Beehive Forum AUP zu nutzen Feld leeren.";
$lang['forum_settings_help_56'] = "Nutze die <b>No-Reply Email</b> um eine eMail-Adresse einzustellen die nicht exisitiert oder nicht fuer Antworten geeignet ist. Diese eMail-Adresse wird benutzt fuer alle eMails von diesem Forum ausser Post- und PM-Meldungen, Benutzer-emails und Passwort-Erinnerungen.";
$lang['forum_settings_help_57'] = "Es wird empfohlen eine eMail-Adresse zu nutzen die nicht existiert um Spoam zu vermeiden die an die Foren-eMail-Adresse gesendet wird";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "AID nicht bekannt.";
$lang['upload'] = "Hochlanden";
$lang['uploadnewattachment'] = "Neuer Dateianhang hochladen";
$lang['waitdotdot'] = "warten..";
$lang['successfullyuploaded'] = "Erfolgreich hochgeladen: %s";
$lang['failedtoupload'] = "Fehler beim Hochladen: %s";
$lang['complete'] = "Fertig";
$lang['uploadattachment'] = "Dateianhang fuer eine Nachricht hochladen";
$lang['enterfilenamestoupload'] = "Dateinamen zum Hochladen eingeben";
$lang['attachmentsforthismessage'] = "Anhaenge für diese Nachricht";
$lang['otherattachmentsincludingpm'] = "andere Anhaenge (inkl. PMs und andere Foren)";
$lang['totalsize'] = "Gesamtgroesse";
$lang['freespace'] = "Freier Speicher";
$lang['attachmentproblem'] = "Problem beim Herunterladen des Anhangs. Bitte spaeter nochmal probieren.";
$lang['attachmentshavebeendisabled'] = "Dateianhaenge wurden vom Admin deaktiviert.";
$lang['canonlyuploadmaximum'] = "Es duerfen im Moment max. 10 Dateien hochgeladen werden";
$lang['deleteattachments'] = "Loesche Anhaenge";
$lang['deleteattachmentsconfirm'] = "Bist Du sicher dass die ausgewaehlten Anhaenge geloescht werden sollen?";
$lang['deletethumbnailsconfirm'] = "Sind Sie sicher dass Sie die ausgewaehlten Anhangs-Thumbnails loeschen wollen ?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "Passwort geaendert";
$lang['passedchangedexp'] = "Dein Passwort wurde geaendert.";
$lang['updatefailed'] = "Aenderung fehlgeschlagen";
$lang['passwdsdonotmatch'] = "Passwoerter stimmen nicht ueberein.";
$lang['newandoldpasswdarethesame'] = "Neues und altes Passwort sind gleich.";
$lang['requiredinformationnotfound'] = "Notwendige Information nicht gefunden";
$lang['forgotpasswd'] = "Passwort vergessen";
$lang['resetpassword'] = "Passwort zuruecksetzen";
$lang['resetpasswordto'] = "Passwort zuruecksetzen zu";
$lang['invaliduseraccount'] = "Ungueltiges Benutzerkonto. eMail-Eingang pruefen fuer echten Link";
$lang['invaliduserkeyprovided'] = "Ungueltiger Benutzerschluessel. eMail-Eingang pruefen fuer echten Link";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "Keine Nachricht fuer Loeschung definiert";
$lang['deletemessage'] = "Nachricht loeschen";
$lang['postdelsuccessfully'] = "Post erfolgreich geloescht";
$lang['errordelpost'] = "Fehler beim Loeschen des Posts";
$lang['cannotdeletepostsinthisfolder'] = "Du kannst keine Posts in diesem Ordner loeschen";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "Keine Nachricht fuer Editierung definiert";
$lang['cannoteditpollsinlightmode'] = "Kann Abstimmungen im Light-Modus nicht bearbeiten";
$lang['editedbyuser'] = "Geaendert: %s von %s";
$lang['editappliedtomessage'] = "Editierung fuer diese Nachricht angewendet";
$lang['errorupdatingpost'] = "Fehler bei Aenderung des Posts";
$lang['editmessage'] = "Editiere Nachricht %s";
$lang['editpollwarning'] = "<b>Merke</b>: Editierung einiger Punkte einer Abstimmung fuehrt dazu dass alle Benutzer erneut abstimmen koennen.";
$lang['hardedit'] = "Harte Editierungsoptionen (Stimmen werden zurueckgesetzt):";
$lang['softedit'] = "Sanfte Editierungsoptionen (Stimmen bleiben erhalten):";
$lang['changewhenpollcloses'] = "Aendern wenn Abstimmung geschlossen?";
$lang['nochange'] = "Keine Aenderung";
$lang['emailresult'] = "Ergebnis mailen";
$lang['msgsent'] = "Nachricht gesendet";
$lang['msgsentsuccessfully'] = "Nachricht erfolgreich gesendet.";
$lang['mailsystemfailure'] = "Mail-System fehlerhaft. Nachricht nicht gesendet.";
$lang['nopermissiontoedit'] = "Du hast keine Rechte diese Nachricht zu editieren.";
$lang['cannoteditpostsinthisfolder'] = "Du kannst keine Abstimmungen in diesem Ordner editieren";
$lang['messagewasnotfound'] = "Nachricht %s nicht gefunden";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "Sende eMail an %s";
$lang['nouserspecifiedforemail'] = "Kein Benutzer fuer eMail definiert.";
$lang['entersubjectformessage'] = "Bitte Betreff fuer diese Nachricht eingeben";
$lang['entercontentformessage'] = "Bitte Inhalt der Nachricht eingeben";
$lang['msgsentfromby'] = "Diese Nachricht wurde gesendet von %s durch %s";
$lang['subject'] = "Thema";
$lang['send'] = "Senden";
$lang['userhasoptedoutofemail'] = "%s hat durch eMail-Kontakt entschieden";
$lang['userhasinvalidemailaddress'] = "%s ungueltige eMail-Adresse";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "Nachricht Mitteilung von %s";
$lang['msgnotificationemail'] = "Hallo %s,\n\n%s schickte ein nachricht an dich auf %s\n\nBetreff: %s\n\nUm die Nachricht zu lesen und andere in der gleichen Diskussion, gehe zu:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nMerke: Wenn Du keine Nachrichten-Mitteilungen vom Forum bekommen moechtest Nachrichten wurden an dich gesendet, gehe zu: %s klick auf Meine Einstellungen, dann eMail und Privat, entferne Haken bei Mailmitteilung Mitteilung checkbox und klicke Senden.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "Subskription Mitteilung von %s";
$lang['subnotification'] = "Hallo %s,\n\n%s schickte eine Nachricht in einem Eintrag den Du aktiviert hast %s\n\nBetreff: %s\n\nUm diese und andere betreffende Nachrichten zu lesen, gehe zu:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nMerke: Wenn Du keine weiteren eMail-Mitteilungen bei neuen eintraegen in diesem Bereich wuenschst, gehe zu: %s und aendere den Interesse-Level am Fuss der Seite.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "PM Mitteilung von %s";
$lang['pmnotification'] = "Hallo %s,\n\n%s schickte eine PM an Dich auf\n\nBetreff: %s\n\nUm die Nachricht zu lesen, gehe zu:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nMerke: Wenn Du keine weiteren eMail-Mitteilungen bei neuen PMs moechtest gehe zu: %s klick auf Meine Einstellungen, dann eMail und Privat, deaktiviere PM Mitteilungscheckbox und klick auf Absenden.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "Passwort Aenderungsmitteilung von %s";
$lang['pwchangeemail'] = "Hallo %s,\n\nDiese Mitteilungsmail moechte Dich darueber informieren dass dein Passwort auf %s geaendert wurde.\n\nEs wurde geaendert auf: %s von: %s\n\nFalls eine Aenderung nicht von Dir gewuenscht/erwartet war sprich einen Moderator oder Admin im Forum darauf an %s um den Fehler umgehend zu korrigieren.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "Email-Bestaetigung erforderlich";
$lang['confirmemail'] = "Hallo %s,\n\nDu hast kuerzlich ein neues Benutzerkonto angelegt auf %s\nBevor Du anfangen kannst eigene Posts zu erstellen benoetigen wir die Bestaetigung Deiner eMail-Adresse. Keine Angst, das ist ganz einfach. Du musst nur auf den Link unten klicken (oder kopier ihn und fueg ihn in deinem Browser ein):\n\n%s\n\nWenn die Bestaetigung durchgegangen ist kannst Du Dich sofort anmelden und posten. Wenn Du kein Konto angelegt hast auf dann entschuldige diesen Fehler und leite diese Mail weiter an %s so dass der Ursprung dieser Mail ermittelt werden kann.";
$lang['confirmchangedemail'] = "Hallo %s,\n\nSie haben kuerzlich Ihre email geaendert in %s.\nBevor Sie wieder posten koennen benoetigen wir eine Bestaetigung Ihrer neuen eMail-Adresse. Keine Sorge, das ist ganz einfach. Alles was Sie tun muessen ist auf den Link unten zu klicken (oder mit Kopieren und Einfuegen in Ihren Browser):\n\n%s\n\nIst die Bestaetigung erfolgt koennen Sie das Forum ganz normal weiternutzen.\n\nFalls Sie diese eMail unerwartet erhalten haben %s akzeptieren Sie bitte unsere Entschuldigung und senden Sie eine eMail an %s damit die Ursache nachverfolgt werden kann.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "Hallo %s,\n\nDu erwartest diese eMail von %s da Du wohl Dein Passwort vergessen hast.\n\nKlick auf den unten folgenden Link (oder kopier ihn und fueg ihn in Deinen Brwoser ein) um Dein Passwort zurueckzusetzen:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "Dein Passwort-Rueckstellungsantrag";
$lang['passwdresetemailsent'] = "Passwort-Rueckstellung wurde gesendet";
$lang['passwdresetexp'] = "Du solltest gleich eine eMail erhalten die Instruktionen fuer die Zurueckstellung deines Passworts enthaelt.";
$lang['validusernamerequired'] = "Ein gueltiger Benutzername ist notwendig";
$lang['forgottenpasswd'] = "Passwort vergessen";
$lang['couldnotsendpasswordreminder'] = "Konnte Passwort-Erinnerung nicht senden. Bitte Moderator oder Admin kontaktieren.";
$lang['request'] = "Antrag";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eMail-Bestaetigung";
$lang['emailconfirmationcomplete'] = "Vielen Dank zur Bestaetigung Deiner eMail-Adresse. Du kannst Dich jetzt anmelden und sofort mit dem Posten beginnen.";
$lang['emailconfirmationfailed'] = "eMail-Bestaetigung fehlgeschlagen, bitte spaeter noch einmal probieren. Sollte dieser Fehler mehrfach auftreten bitte einen Moderator oder Admin benachrichtigen.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "Erste Seite";
$lang['maynotaccessthissection'] = "Evtl. kannst du auf diesen Bereich nicht zugreifen.";
$lang['toplevel'] = "Erste Seite";
$lang['links'] = "Links";
$lang['viewmode'] = "Ansichtsmodus";
$lang['hierarchical'] = "hierarchisch";
$lang['list'] = "Liste";
$lang['folderhidden'] = "Dieser Ordner ist versteckt";
$lang['hide'] = "verstecken";
$lang['unhide'] = "sichtbar machen";
$lang['nosubfolders'] = "Keine Unterordner in dieser Kategorie";
$lang['1subfolder'] = "1 Unterordner in dieser Kategorie";
$lang['subfoldersinthiscategory'] = "Unterordner in dieser Kategorie";
$lang['linksdelexp'] = "Eintraege in geloeschten Ordnern werden verschoben zum darueberliegenden Ordner. Nur Ordner ohne Unterordner werden geloescht.";
$lang['listview'] = "Ansichtsauflistung";
$lang['listviewcannotaddfolders'] = "Kann keine Ordner in dieser Ansicht anfuegen. Zeige momentan 20 Eintraege.";
$lang['rating'] = "Bewertung";
$lang['nolinksinfolder'] = "Keine Links in diesem Ordner.";
$lang['addlinkhere'] = "Link hier hinzufuegen";
$lang['notvalidURI'] = "Das ist keine gueltige URL";
$lang['mustspecifyname'] = "Bitte Namen definieren";
$lang['mustspecifyvalidfolder'] = "Bitte gueltigen Ordner definieren";
$lang['mustspecifyfolder'] = "Bitte Ordner definieren";
$lang['successfullyaddedlinkname'] = "Link '%s' erfolgreich hinzugefuegt";
$lang['failedtoaddlink'] = "Fehler beim Hinzufuegen des Links";
$lang['failedtoaddfolder'] = "Fehler beim Hinzufuegen des Ordners";
$lang['addlink'] = "Link hinzufuegen";
$lang['addinglinkin'] = "Link hinzufuegen in";
$lang['addressurluri'] = "Addresse";
$lang['addnewfolder'] = "Neuen Ordner hinzufuegen";
$lang['addnewfolderunder'] = "Neuen Ordner hinzufuegen unter";
$lang['editfolder'] = "Ordner aendern";
$lang['editingfolder'] = "Ordneraenderung";
$lang['mustchooserating'] = "Du musst eine Bewertung auswaehlen!";
$lang['commentadded'] = "Dein Kommentar wurde angefuegt.";
$lang['commentdeleted'] = "Kommentar wurde geloescht.";
$lang['commentcouldnotbedeleted'] = "Kommentar konnte nicht geloescht werden.";
$lang['musttypecomment'] = "Du musst einen Kommentar eingeben!";
$lang['mustprovidelinkID'] = "Du musst eine Link-ID zu Verfuegung stellen!";
$lang['invalidlinkID'] = "Unguetlige Link-ID!";
$lang['address'] = "Addresse";
$lang['submittedby'] = "Eingereicht von";
$lang['clicks'] = "Klicks";
$lang['rating'] = "Bewertung";
$lang['vote'] = "Stimme";
$lang['votes'] = "Stimmen";
$lang['notratedyet'] = "Bisher noch von niemandem bewertet";
$lang['rate'] = "Bewerten";
$lang['bad'] = "Schlecht";
$lang['good'] = "Gut";
$lang['voteexcmark'] = "Stimmen!";
$lang['clearvote'] = "Stimme loeschen";
$lang['commentby'] = "Kommentiert von %s";
$lang['addacommentabout'] = "einen Kommentar einfuegen ueber";
$lang['modtools'] = "Moderations-Tools";
$lang['editname'] = "Namen editieren";
$lang['editaddress'] = "Adresse editieren";
$lang['editdescription'] = "Beschreibung editieren";
$lang['moveto'] = "Verschieben nach";
$lang['linkdetails'] = "Link-Details";
$lang['addcomment'] = "Kommentar anfuegen";
$lang['voterecorded'] = "Deine Stimme wurde gespeichert";
$lang['votecleared'] = "Ihre Stimme wurde geloescht";
$lang['linknametoolong'] = "Linkname zu lang. Bitte maximal %s Zeichen";
$lang['linkurltoolong'] = "Link-URL zu lang. Bitte maximal %s Zeichen";
$lang['linkfoldernametoolong'] = "Ordnername zu lang. Max. Laenge %s Zeichen";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "Erfolgreich angemeldet.";
$lang['presscontinuetoresend'] = "Klick auf Weiter um Formulardaten nochmal zu senden oder Abbrechen um diese Seite nochmal zu starten.";
$lang['usernameorpasswdnotvalid'] = "Benutzername oder Passwort nicht gueltig.";
$lang['rememberpasswds'] = "Passworterinnerung";
$lang['rememberpassword'] = "Passworterinnerung";
$lang['enterasa'] = "Eingeben als ein %s";
$lang['donthaveanaccount'] = "Noch keinen Benutzer angelegt? %s";
$lang['registernow'] = "Jetzt anlegen";
$lang['problemsloggingon'] = "Probleme beim anmelden?";
$lang['deletecookies'] = "Cookies loeschen";
$lang['cookiessuccessfullydeleted'] = "Cookies erfolgreich geloescht";
$lang['forgottenpasswd'] = "Passwort vergessen";
$lang['usingaPDA'] = "Benutzt Du einen PDA?";
$lang['lightHTMLversion'] = "Light HTML Version";
$lang['youhaveloggedout'] = "Du bist abgemeldet.";
$lang['currentlyloggedinas'] = "Du bist im Moment angemeldet als %s";
$lang['logonbutton'] = "Anmelden";
$lang['yoursessionhasexpired'] = "Ihre Sitzung ist abgelaufen. Sie muessen sich wieder anmelden um fortzufahren.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "Meine Foren";
$lang['allavailableforums'] = "Alle verfuegbaren Foren";
$lang['favouriteforums'] = "Bevorzugte Foren";
$lang['ignoredforums'] = "Ignorierte Foren";
$lang['ignoreforum'] = "Forum ignorieren";
$lang['unignoreforum'] = "Forum nicht mehr ignorieren";
$lang['lastvisited'] = "Zuletzt besucht";
$lang['forumunreadmessages'] = "%s ungelesene Nachrichten";
$lang['forummessages'] = "%s Nachrichten";
$lang['forumunreadtome'] = "%s ungelesen \"An: Mich\"";
$lang['forumnounreadmessages'] = "Keine ungelesenen Nachrichten";
$lang['removefromfavourites'] = "Aus Bevorzugten loeschen";
$lang['addtofavourites'] = "Zu Bevorzugten hinzufuegen";
$lang['availableforums'] = "Erreichbare Foren";
$lang['noforumsofselectedtype'] = "Keine Foren des ausgewaehlten Typs verfuegbar. Bitte anderen Typ waehlen.";
$lang['successfullyaddedforumtofavourites'] = "Forum zu Favoriten hinzugefuegt.";
$lang['successfullyremovedforumfromfavourites'] = "Forum aus Favoriten entfernt.";
$lang['successfullyignoredforum'] = "Forum wird ignoriert.";
$lang['successfullyunignoredforum'] = "Forum wird nicht mehr ignoriert.";
$lang['failedtoupdateforuminterestlevel'] = "Fehler beim Aendern der Foren-Interessenstufe";
$lang['noforumsavailablelogin'] = "Es sind keine Foren erreichbar. Bitte anmelden.";
$lang['passwdprotectedforum'] = "Passwort-geschuetztes Forum";
$lang['passwdprotectedwarning'] = "Dieses Forum ist passwortgeschuetzt. Fuer Zugriff bitte Passwort unten eingeben.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "Poste Nachricht";
$lang['selectfolder'] = "Ordner auswaehlen";
$lang['mustenterpostcontent'] = "Du musst Inhalt in dem Post angeben!";
$lang['messagepreview'] = "Nachricht Voransicht";
$lang['invalidusername'] = "Ungueltiger Benutzername!";
$lang['mustenterthreadtitle'] = "Du musst einen Titel fuer den Eintrag eingeben!";
$lang['pleaseselectfolder'] = "Bitte Ordner auswaehlen!";
$lang['errorcreatingpost'] = "Fehler beim Erstellen des Posts! Bitte in ein paar Minuten noch einmal probieren.";
$lang['createnewthread'] = "Erstelle neuen Eintrag";
$lang['postreply'] = "Post Antwort";
$lang['threadtitle'] = "Eintragstitel";
$lang['messagehasbeendeleted'] = "Nachricht wurde geloescht.";
$lang['messagenotfoundinselectedfolder'] = "Nachricht nicht in ausgewahlten Ordnern gefunden. Bitte pruefen ob es verschoben oder geloescht wurde.";
$lang['cannotpostthisthreadtypeinfolder'] = "Du kannst diesen Eintragstyp in diesem Ordner nicht posten!";
$lang['cannotpostthisthreadtype'] = "Du kannst diesen Eintragstyp nicht posten da hier keine Ordner sind die dies erlauben.";
$lang['cannotcreatenewthreads'] = "Du kannst keine neuen Eintraege erstellen.";
$lang['threadisclosedforposting'] = "Dieser Eintrag ist geschlossen, Du kannst hier nichts mehr eintragen!";
$lang['moderatorthreadclosed'] = "Achtung: dieser Eintrag wurde geschlossen fuer normale Benutzer.";
$lang['usersinthread'] = "Benutzer im Eintrag";
$lang['correctedcode'] = "Korrigierter Code";
$lang['submittedcode'] = "Gesendeter Code";
$lang['htmlinmessage'] = "HTML in Nachricht";
$lang['disableemoticonsinmessage'] = "Emoticons deaktivieren in dieser Nachricht";
$lang['automaticallyparseurls'] = "Automatisch URLs analysieren";
$lang['automaticallycheckspelling'] = "Automatisch Rechtschreibung pruefen";
$lang['setthreadtohighinterest'] = "Setze Eintrag auf Wichtig";
$lang['enabledwithautolinebreaks'] = "Aktiviere Autom. Zeilenumbruch";
$lang['fixhtmlexplanation'] = "Dieses Forum benutzt HTML-Filter. Dein uebertragenes HTML wurde vom Filter teilweise angepasst.\\n\\num Deinen Orginalcode anzuzeigen, waehle \\'Uebertragener Code\\' radio button.\\nUm den angepassten Code zu zeigen, waehle \\'Korrigierter Code\\' radio button.";
$lang['messageoptions'] = "Nachrichtsoptionen";
$lang['notallowedembedattachmentpost'] = "Du hast nicht das Recht eingebettete Anhaenge in Deinen Posts zu verwenden.";
$lang['notallowedembedattachmentsignature'] = "Du hast nicht das Recht eingebettete Anhaenge in Deiner Signatur zu verwenden.";
$lang['reducemessagelength'] = "Nachrichtenlaenge muss weniger als 65,535 Zeichen haben (im Moment: %s)";
$lang['reducesiglength'] = "Signaturlaenge muss weniger als 65,535 Zeichen haben (im Moment: %s)";
$lang['cannotcreatethreadinfolder'] = "Du kannst keine neuen Eintraege in diesem Ordner erstellen";
$lang['cannotcreatepostinfolder'] = "Du kannst nicht auf Eintraege antworten in diesem Ordner";
$lang['cannotattachfilesinfolder'] = "Du kannst keine Anhaenge in diesem Ordner posten. Entferne die Anhaenge um Fortzufahren.";
$lang['postfrequencytoogreat'] = "Du kannst nur einmal alle %s sek. posten. Bitte probier es spaeter noch einmal.";
$lang['emailconfirmationrequiredbeforepost'] = "eMail-Bestaetigung ist notwendig bevor Du posten kannst. Wenn du noch keine Bestaetigungs-eMail erhalten hast klick bitte auf den Schalter unten damit eine weitere eMail-Bestaetigungsnachricht gesendet wird. Wenn Du noch keine eMail-Adresse hast lege Dir erst eine an bevor Du diesen Schalter betaetigst. Du kannst Deine eMail-Adresse auch aendern ueber Meine Einstellungen in der oberen Menueleiste udn dann Benutzerdetails";
$lang['emailconfirmationfailedtosend'] = "Bestaetigungsmail konnte nicht gesendet werden. Bitte kontaktiere den Admin um das zu pruefen.";
$lang['emailconfirmationsent'] = "Bestaetigungs-eMail wurde nochmal versendet.";
$lang['resendconfirmation'] = "Sende Bestaetigungs-eMail noch einmal";
$lang['userapprovalrequiredbeforeaccess'] = "Dein Benutzerkonto muss von einem Foren-Admin genehmigt werden bevor du auf das gewuenschte Forum zugreifen kannst.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "Als Antwort an";
$lang['showmessages'] = "Nachrichten anzeigen";
$lang['ratemyinterest'] = "Bewerte meine Wichtigkeiten";
$lang['adjtextsize'] = "Textgroesse einstellen";
$lang['smaller'] = "Kleiner";
$lang['larger'] = "Groesser";
$lang['faq'] = "FAQ";
$lang['docs'] = "Doks";
$lang['support'] = "Hilfe";
$lang['donateexcmark'] = "Spenden!";
$lang['fontsizechanged'] = "Schriftgroesse geaendert. %s";
$lang['framesmustbereloaded'] = "Frames muessen manuell neu geladen werden um Aenderungen zu sehen.";
$lang['threadcouldnotbefound'] = "Der angeforderte Eintrag wurde nicht gefunden oder der Zugriff wurde verweigert.";
$lang['mustselectpolloption'] = "Du musst eine Option auswaehlen um abzustimmen!";
$lang['mustvoteforallgroups'] = "Du musst in jeder Gruppe abstimmen.";
$lang['keepreading'] = "Unterhaltmesswert";
$lang['backtothreadlist'] = "Zurueck zur Eintragsliste";
$lang['postdoesnotexist'] = "Dieser Post existiert nicht in diesem Eintrag!";
$lang['clicktochangevote'] = "Klicken um Stimme zu aendern";
$lang['youvotedforoption'] = "Du stimmtest fuer Option";
$lang['youvotedforoptions'] = "Du stimmtest fuer Optionen";
$lang['clicktovote'] = "Klick zur Abstimmung";
$lang['youhavenotvoted'] = "Du hast nicht abgestimmt";
$lang['viewresults'] = "Ergebnisse zeigen";
$lang['msgtruncated'] = "Nachricht abgeschnitten";
$lang['viewfullmsg'] = "Zeige volle Nachricht";
$lang['ignoredmsg'] = "Nachricht ignorieren";
$lang['wormeduser'] = "gewurmter Benutzer";
$lang['ignoredsig'] = "Signatur ignoriert";
$lang['messagewasdeleted'] = "Nachricht %s.%s wurde geloescht";
$lang['stopignoringthisuser'] = "Aufhoeren Benutzer zu ignorieren";
$lang['renamethread'] = "Eintrag umbenennen";
$lang['movethread'] = "Eintrag verschieben";
$lang['torenamethisthreadyoumusteditthepoll'] = "Um Eintrag umzubenennen muss Abstimmung geaendert werden.";
$lang['closeforposting'] = "Geschlossen. Kein Posten mehr moeglich";
$lang['until'] = "Bis 00:00 UTC";
$lang['approvalrequired'] = "Aktivierung notwendig";
$lang['messageawaitingapprovalbymoderator'] = "Nachricht %s.%s wartet auf Aktivierung eines Moderators";
$lang['postapprovedsuccessfully'] = "Post erfolgreich aktiviert";
$lang['postapprovalfailed'] = "Post-Genehmigung fehlgeschlagen.";
$lang['postdoesnotrequireapproval'] = "Post benoetigt keine Genehmigung";
$lang['approvepost'] = "Stimme Post";
$lang['approvedbyuser'] = "Anerkannt: %s durch %s";
$lang['makesticky'] = "Erstelle Sticker";
$lang['messagecountdisplay'] = "%s von %s";
$lang['linktothread'] = "Permanenter Link zu diesem Eintrag";
$lang['linktopost'] = "Link zu Post";
$lang['linktothispost'] = "Link zu diesem Post";
$lang['imageresized'] = "Bildgroesse kann geaendert werden (Originalgroesse %1\$sx%2\$s). Um Bild in voller Groesse anzuzeigen hier klicken.";
$lang['messagedeletedbyuser'] = "Nachricht %s.%s geloescht %s durch %s";
$lang['messagedeleted'] = "Nachricht %s.%s wurde geloescht";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "Kann Ordner-Moderator nicht anzeigen";
$lang['moderatorlist'] = "Moderatorenliste:";
$lang['modsforfolder'] = "Moderatoren fuer Ordner";
$lang['nomodsfound'] = "Kein Moderator gefunden";
$lang['forumleaders'] = "Forenadmin:";
$lang['foldermods'] = "Ordner-Moderatoren:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "Start";
$lang['messages'] = "Nachrichten";
$lang['pminbox'] = "Nachrichteneingang";
$lang['startwiththreadlist'] = "Starseite mit Eintragsliste";
$lang['pmsentitems'] = "Gesendete Nachrichten";
$lang['pmoutbox'] = "Postausgang";
$lang['pmsaveditems'] = "Gespeicherte Nachrichten";
$lang['pmdrafts'] = "Entwuerfe";
$lang['links'] = "Links";
$lang['admin'] = "Admin";
$lang['login'] = "Anmeldung";
$lang['logout'] = "Abmeldung";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "Private Nachrichten";
$lang['recipienttiptext'] = "Trenne Empfaenger mit Semikolon oder Kommata";
$lang['maximumtenrecipientspermessage'] = "Max. 10 Empfaenger je Nachricht. Bitte Empfaengerliste anpassen.";
$lang['mustspecifyrecipient'] = "Mindestens ein Empfaenger muss eingetragen sein.";
$lang['usernotfound'] = "Benutzer %s nicht gefunden.";
$lang['sendnewpm'] = "Neue Nachricht senden";
$lang['savemessage'] = "Nachricht speichern";
$lang['timesent'] = "Uhrzeit gesendet";
$lang['errorcreatingpm'] = "Fehler beim Erstellen der Nachricht! Bitte in ein paar Minuten ncohmal probieren";
$lang['writepm'] = "Nachricht schreiben";
$lang['editpm'] = "Nachricht anzeigen";
$lang['cannoteditpm'] = "Kann diese Nachricht nicht anzeigen. Sie wurde bereits vom Empfaenger gelesen oder die Nachricht existiert nicht oder es darf nicht von Dir darauf zugegriffen werden";
$lang['cannotviewpm'] = "Kann PM nicht anzeigen. Nachricht existiert nicht oder darf von Dir nicht angezeigt werden";
$lang['pmmessagenumber'] = "Nachricht %s";

$lang['youhavexnewpm'] = "Du hast %d neue PMs. Willst Du jetzt in den Posteingang wechseln?";
$lang['youhave1newpm'] = "'Du hast 1 neue PM. Willst du jetzt in den Posteingang wechseln?";
$lang['youhave1newpmand1waiting'] = "Sie haben eine neue Nachricht.\\n\\nSie haben 1 weitere Nachricht im Empfang. Um diese Nachricht zu erhalten loeschen Sie einige Nachrichten in Ihrem Postordner.\\n\\nWollen Sie nun in den Posteingang wechseln?";
$lang['youhave1pmwaiting'] = "Sie haben eine Nachricht im Empfang. Um die Nachricht zu erhalten loeschen Sie einige Nachrichten in Ihrem Postordner.\\n\\nWollen Sie nun zum Posteingang wechseln?";
$lang['youhavexnewpmand1waiting'] = "Sie haben %d neue Nachrichten.\\n\\nSie haben 1 weitere Nachricht im Empfang. Um die Nachricht zu erhalten loeschen Sie einige Nachrichten in Ihrem Postordner.\\n\\nWollen Sie nun zum Posteingang wechseln?";
$lang['youhavexnewpmandxwaiting'] = "Sie haben %d neue Nachrichten.\\n\\nSie haben weitere %d Nachrichten im Empfang. Um diese Nachrichten zu erhalten loeschen Sie einige Nachrichten in Ihrem Postordner.\\n\\nWollen Sie nun zum Posteingang wechseln?";
$lang['youhave1newpmandxwaiting'] = "Sie haben 1 neue Nachricht.\\n\\nSie haben weitere %d Nachrichten im Empfang. Um diese Nachrichten zu erhalten loeschen Sie einige Nachrichten in Ihrem Postordner.\\n\\nWollen Sie nun zum Posteingang wechseln?";
$lang['youhavexpmwaiting'] = "Sie haben %d neue Nachrichten.\\n\\nSie haben weitere %d Nachrichten im Empfang. Um diese Nachrichten zu erhalten loeschen Sie einige Nachrichten in Ihrem Postordner.\\n\\nWollen Sie nun zum Posteingang wechseln?";

$lang['youdonothaveenoughfreespace'] = "Du hast nicht genug freien Speicher um die Nachricht zu senden.";
$lang['userhasoptedoutofpm'] = "%s wurde aus dem PM-Empfang entfernt";
$lang['pmfolderpruningisenabled'] = "PM-Ordnerkuerzung eingeschaltet!";
$lang['pmpruneexplanation'] = "Dieses Forum nutzt PM-Ordnerkuerzung. Die Nachrichten wurden in Deinem Posteingang gespeichert und gesendete Eintraege \\nfolders werden automatisch geloescht. Jede Nachricht die Du gespeichert halten moechtest sollte verschoben werden nach \\nyour \\'Saved Items\\' Ordner damitsie nicht geloescht werden.";
$lang['yourpmfoldersare'] = "Ihre PM-Ordner sind zu %s voll";
$lang['currentmessage'] = "Aktuelle Nachricht";
$lang['unreadmessage'] = "Ungelesene Nachricht";
$lang['readmessage'] = "Gelesene Nachricht";
$lang['pmshavebeendisabled'] = "Persoenlichen Nachrichten (Personal Messages = PMs) wurden deaktiviert vom Admin.";
$lang['adduserstofriendslist'] = "Benutzer zu Deiner Freundesliste hinzufuegen um Sie immer im Drop-Down-Feld deiner PM-Seite zu haben.";

$lang['messagesaved'] = "Nachricht gespeichert";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "Nachricht im 'Entwuerfe'-Ordner gespeichert";
$lang['couldnotsavemessage'] = "Nachricht konnte nicht gespeichert werden. Bitte sicherstellen dass genuegend Speicherplatz vorhanden ist.";
$lang['pmtooltipxmessages'] = "%s Nachrichten";
$lang['pmtooltip1message'] = "1 Nachricht";

$lang['allowusertosendpm'] = "Benutzer erlauben mir persoenliche Nachrichten (PM) zu senden";
$lang['blockuserfromsendingpm'] = "Benutzer sperren fuer PM an mich";
$lang['yourfoldernamefolderisempty'] = "Ihr %s -Ordner ist leer";
$lang['successfullydeletedselectedmessages'] = "Ausgewahlte Nachrichten geloescht";
$lang['successfullyarchivedselectedmessages'] = "Ausgewaehlte Nachrichten archiviert";
$lang['failedtodeleteselectedmessages'] = "Fehler beim Loeschen der Nachrichten";
$lang['failedtoarchiveselectedmessages'] = "Fehler beim Archivieren der Nachrichten";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "Meine Einstellungen";
$lang['myforums'] = "Meine Foren";
$lang['menu'] = "Menue";
$lang['userexp_1'] = "Benutze das Menue links um Deine Einstellungen zu verwalten.";
$lang['userexp_2'] = "<b>Benutzer-Details</b> zum Aendern des Namens, eMail-Adresse und Passwort.";
$lang['userexp_3'] = "<b>Benutzer-Profil</b> Aendern des Benutzerprofils.";
$lang['userexp_4'] = "<b>Passwort Aendern</b> ";
$lang['userexp_5'] = "<b>Email &amp; Privat</b> Kontakt.";
$lang['userexp_6'] = "<b>Forum-Optionen</b> Aussehen und Arbeitsweise des Forums.";
$lang['userexp_7'] = "<b>Anhaenge</b> Anzeigen/Loeschen Deiner Anhaenge.";
$lang['userexp_8'] = "<b>Signatur editieren</b> die Unterschrift unter Deinen Beitraegen.";
$lang['userexp_9'] = "<b>Relationships</b> lets you manage your relationship with other users on the forum.";
$lang['userexp_9'] = "<b>Relationships</b> lets you manage your relationship with other users on the forum.";
$lang['userexp_10'] = "<b>Eintragsbeschreibung</b> verwaltet die Eintragsbeschreibungen.";
$lang['userdetails'] = "Benutzerdetails";
$lang['userprofile'] = "Benutzer-Profil";
$lang['emailandprivacy'] = "Email &amp; Privat";
$lang['editsignature'] = "Signatur editieren";
$lang['norelationshipssetup'] = "Sie haben noch keine Benutzerbeziehungen erstellt. Fuegen Sie einen neuen Benutzer hinzu wie folgt.";
$lang['editwordfilter'] = "Wortfilter editieren";
$lang['userinformation'] = "Benutzer-Information";
$lang['changepassword'] = "Passwort aendern";
$lang['currentpasswd'] = "Aktuelles Passwort";
$lang['newpasswd'] = "Neues Passwort";
$lang['confirmpasswd'] = "neues Password bestaetigen";
$lang['passwdsdonotmatch'] = "Passwoerter stimmen nicht ueberein.";
$lang['nicknamerequired'] = "Nickname/Kurzname wird benoetigt!";
$lang['emailaddressrequired'] = "Email-Addresse wird benoetigt!";
$lang['logonnotpermitted'] = "Anmeldung nicht erlaubt. Bitte andere auswaehlen!";
$lang['nicknamenotpermitted'] = "Nickname/Kurzname nicht erlaubt. Bitte anderen auswaehlen!";
$lang['emailaddressnotpermitted'] = "Email-Addresse nicht erlaubt. Bitte andere auswaehlen!";
$lang['emailaddressalreadyinuse'] = "Email-Addresse bereits registriert. Bitte andere auswaehlen!";
$lang['relationshipsupdated'] = "Verhaeltnisse geaendert!";
$lang['relationshipupdatefailed'] = "Verhaeltnis-Aenderung fehlgeschlagen!";
$lang['preferencesupdated'] = "Praeferenzen wurden erfolgreich geaendert.";
$lang['userdetails'] = "Benutzerdetails";
$lang['memberno'] = "Mitglied Nr.";
$lang['firstname'] = "Vorname";
$lang['lastname'] = "Nachname";
$lang['dateofbirth'] = "Geburtstag";
$lang['homepageURL'] = "Homepage URL";
$lang['profilepicturedimensions'] = "Profil-Bild (Max 95x95px)";
$lang['avatarpicturedimensions'] = "Avatar-Bild (Max 15x15px)";
$lang['invalidattachmentid'] = "Ungueltiger Anhang. Bitte pruefen ob geloescht.";
$lang['unsupportedimagetype'] = "Ungueltiger Bild-Anhang. Bitte nur jpg, gif und png-Bildanhaenge fuer Ihr Avatar- und Profil-Bild nutzen.";
$lang['selectattachment'] = "Anhang auswaehlen";
$lang['pictureURL'] = "Eigenes Bild URL";
$lang['avatarURL'] = "Avatar URL";
$lang['profilepictureconflict'] = "Um einen Anhang fuer Ihr Profilbild zu nutzen muss das URL-Feld leer sein.";
$lang['avatarpictureconflict'] = "Um einen Anhang fuer Ihr Avatarbild zu nutzen muss das URL-Feld leer sein.";
$lang['attachmenttoolargeforprofilepicture'] = "Ausgewaehlter Anhang ist zu gross fuer Profilbild. Bitte max. %s";
$lang['attachmenttoolargeforavatarpicture'] = "Ausgewaehlter Anhang ist zu gross fuer Avatarbild. Bitte max. %s";
$lang['failedtoupdateuserdetails'] = "Einige oder alle Benutzerkontendetails konnten nicht geaendert werden. Bitte probieren Sie es spaeter noch einmal.";
$lang['failedtoupdateuserpreferences'] = "Einige oder alle Benutzerpraeferenzen konnten nicht geaendert werden. Bitte probieren Sie es spaeter noch einmal.";
$lang['emailaddresschanged'] = "Email-Adresse wurde geaendert";
$lang['newconfirmationemailsuccess'] = "Ihre eMailadresse wurde geaendert und eine Bestaetigungsemail wurde versendet. Bitte diese eMail lesen fuer weitere Instruktionen.";
$lang['newconfirmationemailfailure'] = "Sie haben Ihre eMail-Adresse geaendert, es konnte aber keine Bestaetigungsmail gesendet werden. Bitte Forenbetreiber kontaktieren fuer Hilfe.";
$lang['forumoptions'] = "Forum-Optionen";
$lang['notifybyemail'] = "Benachrichtige mich via eMail bei Antworten auf Eintraege von mir";
$lang['notifyofnewpm'] = "Benachrichtigung via Popup bei neuen PM (Persoenliche Nachrichten) fuer mich";
$lang['notifyofnewpmemail'] = "Benachrichtigung via eMail bei neuen PM (Persoenliche Nachrichten) fuer mich";
$lang['daylightsaving'] = "Einstellungen fuer Tageslicht-Schutz";
$lang['autohighinterest'] = "Automatisch Eintraege markieren die ich als Wichtig definiert habe";
$lang['convertimagestolinks'] = "Automatisch eingebettete Bilder in Eintraegen zu Links umstellen";
$lang['thumbnailsforimageattachments'] = "Voransichtsbilder fuer Bildanhaenge";
$lang['smallsized'] = "kleine Groesse";
$lang['mediumsized'] = "mittlere Groesse";
$lang['largesized'] = "Gross";
$lang['globallyignoresigs'] = "Generell Signaturen der Benutzer nicht anzeigen";
$lang['allowpersonalmessages'] = "Erlaube anderen Benutzern mir PMs zu senden";
$lang['allowemails'] = "Erlaube anderen Benutzern mir eMails zu senden via Profil (Addresse ist dabei nicht sichtbar!)";
$lang['timezonefromGMT'] = "Zeitzone";
$lang['postsperpage'] = "Posts je Seite";
$lang['fontsize'] = "Schriftgroesse";
$lang['forumstyle'] = "Forenstil";
$lang['forumemoticons'] = "Foren-Emoticons";
$lang['startpage'] = "Startseite";
$lang['signaturecontainshtmlcode'] = "Signatur enthaelt HTML-Code";
$lang['savesignatureforuseonallforums'] = "Signatur speichern fuer alle Foren";
$lang['preferredlang'] = "Bevorzugte Sprache";
$lang['donotshowmyageordobtoothers'] = "Mein Alter und Geburtsdatum nicht zeigen";
$lang['showonlymyagetoothers'] = "Nur Alter sichtbar";
$lang['showmyageanddobtoothers'] = "Alter und Geburtsdatum anderen sichtbar mache";
$lang['showonlymydayandmonthofbirthytoothers'] = "Nur Geburtstag und -monat anzeigen in Foren";
$lang['listmeontheactiveusersdisplay'] = "In den Aktiven Benutzern anzeigen wenn angemeldet";
$lang['browseanonymously'] = "Forum anonym durchsuchen";
$lang['allowfriendstoseemeasonline'] = "anonym durchsuchen, aber Freunden erlauben mich als Online zu sehen";
$lang['revealspoileronmouseover'] = "Spoiler hervorheben durch Mouse-Over";
$lang['showspoilersinlightmode'] = "Spoiler immer hell anzeigen (nutzt hellere Schriftfarbe)";
$lang['resizeimagesandreflowpage'] = "Bildgroessen aendern und Seite aktualisieren um horizontales Scrollen zu vermeiden.";
$lang['showforumstats'] = "Zeige Forenstatistik am Fuss der Nachrichten";
$lang['usewordfilter'] = "Wortfilter aktivieren.";
$lang['forceadminwordfilter'] = "Nutze Admin Wortfilter bei allen Benutzern (inkl. Gast)";
$lang['timezone'] = "Zeitzone";
$lang['language'] = "Sprache";
$lang['emailsettings'] = "Email und Kontakteinstellungen";
$lang['forumanonymity'] = "Forum-Anonymitaetseinstellungen";
$lang['birthdayanddateofbirth'] = "Geburtstag und Geb-Datumsanzeige";
$lang['includeadminfilter'] = "Admin-Wortfilter in meine Liste mit aufnehmen.";
$lang['setforallforums'] = "Fuer alle Foren aktivieren?";
$lang['containsinvalidchars'] = "enthaelt ungueltige Zeichen!";
$lang['homepageurlmustincludeschema'] = "Homepage-URL muss http:// beinhalten.";
$lang['pictureurlmustincludeschema'] = "Bild-URL muss http:// beinhalten.";
$lang['avatarurlmustincludeschema'] = "Avatar-URL muss http:// beinhalten.";
$lang['postpage'] = "Posts-Seite";
$lang['nohtmltoolbar'] = "Keine HTML-Werkzeugleiste";
$lang['displaysimpletoolbar'] = "zeige einfache HTML-Leiste";
$lang['displaytinymcetoolbar'] = "zeige WYSIWYG HTML-Leiste";
$lang['displayemoticonspanel'] = "zeige Emoticons-Leiste";
$lang['displaysignature'] = "Signatur anzeigen";
$lang['disableemoticonsinpostsbydefault'] = "Deaktiviere Emoticons standardmaessig in Nachrichten";
$lang['automaticallyparseurlsbydefault'] = "Automatisch URLs analysieren standardmaessig in Nachrichten";
$lang['postinplaintextbydefault'] = "Poste standardmaessig in einfachem Text";
$lang['postinhtmlwithautolinebreaksbydefault'] = "Poste standardmaessig in HTML mit Auto-Zeilenumbruch";
$lang['postinhtmlbydefault'] = "Poste standardmaessig in HTML";
$lang['privatemessageoptions'] = "Private Nachrichtenoptionen";
$lang['privatemessageexportoptions'] = "Private Nachrichten Export-Optionen";
$lang['savepminsentitems'] = "Speichere eine Kopie jeder PM die ich sende im Gesendete Nachrichten-Ordner";
$lang['includepminreply'] = "Fuege Nachrichtentext an bei einer Antwort auf eine PM";
$lang['autoprunemypmfoldersevery'] = "kuerze automtisch meine PM-Ordner jeden:";
$lang['friendsonly'] = "nur Freunde?";
$lang['globalstyles'] = "Globale Stile";
$lang['forumstyles'] = "Forenstile";
$lang['youmustenteryourcurrentpasswd'] = "Bitte aktuelles Passwort eingeben";
$lang['youmustenteranewpasswd'] = "Bitte neues Passwort eingeben";
$lang['youmustconfirmyournewpasswd'] = "Bitte neues Passwort bestaetigen";
$lang['profileentriesmustnotincludehtml'] = "Profileintraege muessen keinen HTML-Code beinhalten";
$lang['failedtoupdateuserprofile'] = "Fehler beim Aendern des Benutzerprofils";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "Du musst einige Antwortgruppen bereitstellen";
$lang['mustprovidepolltype'] = "Du musst einen Abstimmungstyp auswaehlen";
$lang['mustprovidepollresultsdisplaytype'] = "Du musst einen Ergebnisanzeigentyp auswaehlen";
$lang['mustprovidepollvotetype'] = "Du musst einen Abstimmungstyp auswaehlen";
$lang['mustprovidepollguestvotetype'] = "Bitte definieren ob Gaesten das Waehlen erlaubt sein soll";
$lang['mustprovidepolloptiontype'] = "Du musst einen Abstimmungsoptionstyp auswaehlen";
$lang['mustprovidepollchangevotetype'] = "Du musst einen Abstimmungsaenderungstyp auswaehlen";
$lang['pollquestioncontainsinvalidhtml'] = "Ihre Abstimmungsfrage(n) beinhalten fehlerhaften HTML-Code.";
$lang['pleaseselectfolder'] = "Bitte Ordner auswaehlen!";
$lang['mustspecifyvalues1and2'] = "Du musst einen Wert fuer die Antworten 1 und 2 definieren";
$lang['tablepollmusthave2groups'] = "Tabellenabstimmungen muessen genau 2 Stimmgruppen haben.";
$lang['nomultivotetabulars'] = "Tabellenabstimmungen koennen keine Mehrfachstimmen annehmen";
$lang['nomultivotepublic'] = "Oeffentliche Stimmzettel koennen keine Mehrfachstimmen annehmen";
$lang['abletochangevote'] = "Du kannst Deine Stimme noch aendern.";
$lang['abletovotemultiple'] = "Du kannst mehrfach stimmen.";
$lang['notabletochangevote'] = "Du kannst Deine Stimme nicht mehr aendern.";
$lang['pollvotesrandom'] = "Merke: Stimmen fuer Abstimmungen werden nur fuer die Voransicht zufaellig generiert.";
$lang['pollquestion'] = "Abstimmungsfrage";
$lang['possibleanswers'] = "Moegliche Antworten";
$lang['enterpollquestionexp'] = "Gib die Antworten fuer deine Abstimmungsfrage ein. Wenn Deine Abstimmung eine  &quot;Ja/Nein&quot; Frage ist, gib einfach &quot;Ja&quot; fuer Antwort 1 und &quot;Nein&quot; fuer Antwort 2.";
$lang['numberanswers'] = "Nr. der Antworten";
$lang['answerscontainHTML'] = "Antwort enthaelt HTML (enthaelt keine Signatur)";
$lang['optionsdisplay'] = "Antwortenanzeigentyp";
$lang['optionsdisplayexp'] = "Wie sollen die Antworten angezeigt werden?";
$lang['dropdown'] = "Drop-Down";
$lang['radios'] = "Mit mehreren Radio-Buttons (Schaltern)";
$lang['votechanging'] = "Stimmaenderung";
$lang['votechangingexp'] = "Kann ein Benutzer seine Stimme aendern?";
$lang['guestvoting'] = "Gaestewahl";
$lang['guestvotingexp'] = "Koennen Gaeste in dieser Abstimmung waehlen?";
$lang['allowmultiplevotes'] = "Erlaube mehrfache Stimmen";
$lang['pollresults'] = "Abstimmungsergebnis";
$lang['pollresultsexp'] = "Wie soll das Ergebnis angezeigt werden?";
$lang['pollvotetype'] = "Abstimmungseintrag";
$lang['pollvotesexp'] = "Wie soll die Abstimmung geleitet werden?";
$lang['pollvoteanon'] = "Anonym";
$lang['pollvotepub'] = "Oeffentliche Stimmzettel";
$lang['horizgraph'] = "Horizontale Grafik";
$lang['vertgraph'] = "Vertikale Grafik";
$lang['tablegraph'] = "Tabellenformat";
$lang['polltypewarning'] = "<b>Achtung</b>: Dies ist ein oeffentlicher Stimmzettel. Dein Name wird angezeigt werden in der Option fuer die Du stimmst.";
$lang['expiration'] = "Dauer/Ablaufzeit";
$lang['showresultswhileopen'] = "Willst Du die Ergebnisse sehen koennen waehrend die Abstimmung noch laeuft?";
$lang['whenlikepollclose'] = "Wann soll die Abstimmung ablaufen?";
$lang['oneday'] = "1 Tag";
$lang['threedays'] = "3 Tage";
$lang['sevendays'] = "7 Tage";
$lang['thirtydays'] = "30 Tage";
$lang['never'] = "Nie";
$lang['polladditionalmessage'] = "Zusaetzliche Nachricht (Optional)";
$lang['polladditionalmessageexp'] = "Willst Du einen zusaetzlichen Post integrieren nach der Abstimmung ?";
$lang['mustspecifypolltoview'] = "du musst eine Abstimmung zur Anzeige auswaehlen.";
$lang['pollconfirmclose'] = "Bist du sicher dass Du diese Abstimmung schliessen willst?";
$lang['endpoll'] = "Abstimmungsende";
$lang['nobodyvotedclosedpoll'] = "Niemand waehlte";
$lang['votedisplayopenpoll'] = "%s und %s haben gewaehlt.";
$lang['votedisplayclosedpoll'] = "%s und %s waehlten.";
$lang['nousersvoted'] = "Keine Benutzer";
$lang['oneuservoted'] = "1 Benutzer";
$lang['xusersvoted'] = "%s Benutzer";
$lang['noguestsvoted'] = "Keine Gaeste";
$lang['oneguestvoted'] = "1 Gast";
$lang['xguestsvoted'] = "%s Gaeste";
$lang['pollhasended'] = "Abstimmung ist beendet";
$lang['youvotedforpolloptionsondate'] = "Sie stimmen fuer %s auf %s";
$lang['thisisapoll'] = "Dies ist eine Abstimmung. Klicke auf Ergebnis der Abstimmung.";
$lang['editpoll'] = "Abstimmung editieren";
$lang['results'] = "Ergebnisse";
$lang['resultdetails'] = "Ergebnis-Details";
$lang['changevote'] = "Stimme aendern";
$lang['pollshavebeendisabled'] = "Abstimmungen wurden vom Forenadmin gesperrt.";
$lang['answertext'] = "Antworttext";
$lang['answergroup'] = "Antwortgruppe";
$lang['previewvotingform'] = "Abstimmungsformular-Voransicht";
$lang['viewbypolloption'] = "Anzeige mit Abstimmungsoption";
$lang['viewbyuser'] = "Anzeige mit Benutzer";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "Profil editieren";
$lang['profileupdated'] = "Profil geaendert.";
$lang['profilesnotsetup'] = "Der Forenadmin hat Profile nicht aktiviert";
$lang['ignoreduser'] = "Ignorierter Benutzer";
$lang['lastvisit'] = "zuletzt besucht";
$lang['userslocaltime'] = "Benutzer-Tageszeit";
$lang['userstatus'] = "Benutzerstatus";
$lang['useractive'] = "Online";
$lang['userinactive'] = "Inaktiv / Offline";
$lang['totaltimeinforum'] = "Gesamtzeit";
$lang['longesttimeinforum'] = "Laengste Sitzung";
$lang['sendemail'] = "eMail senden";
$lang['sendpm'] = "PM senden";
$lang['visithomepage'] = "Website besuchen";
$lang['age'] = "Alter";
$lang['aged'] = "gealtert";
$lang['birthday'] = "Geburtstag";
$lang['registered'] = "Registriert";
$lang['findpostsmadebyuser'] = "Finde Eintrage von %s";
$lang['findpostsmadebyme'] = "Finde Eintraege von mir";
$lang['profilenotavailable'] = "Profil nicht verfuegbar.";
$lang['userprofileempty'] = "Benutzer hat kein Profil oder ist auf Privat gestellt.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "Leider sind neue Benutzeranmeldungen im Moment nicht erlaubt. Bitte spaeter noch einmal probieren.";
$lang['usernameinvalidchars'] = "Benutzername kann nur a-z, 0-9, _ - Zeichen beinhalten";
$lang['usernametooshort'] = "Benutzername muss mind. 2 Zeichen lang sein";
$lang['usernametoolong'] = "Benutzername darf max. 15 Zeichen lang sein";
$lang['usernamerequired'] = "Ein Anmeldename ist notwendig";
$lang['passwdmustnotcontainHTML'] = "Passwort darf keine HTML-tags beinhalten";
$lang['passwordinvalidchars'] = "Passwort kann nur a-z, 0-9, _ - Zeichen beinhalten";
$lang['passwdtooshort'] = "Passwort muss mind. 6 Zeichen lang sein";
$lang['passwdrequired'] = "Ein Passwort ist notwendig";
$lang['confirmationpasswdrequired'] = "Eine Passwortbestaetigung muss eingegeben sein";
$lang['nicknamerequired'] = "Nickname/Kurzname wird benoetigt!";
$lang['emailrequired'] = "Eine eMail-Adresse muss eingegeben werden";
$lang['passwdsdonotmatch'] = "Passwoerter stimmen nicht ueberein.";
$lang['usernamesameaspasswd'] = "Benutzername und Passwort muessen unterschiedlich sein";
$lang['usernameexists'] = "Ein Benutzer mit diesem Namen exisitiert bereits";
$lang['successfullycreateduseraccount'] = "Benutzerkonto erfolgreich erstellt";
$lang['useraccountcreatedconfirmfailed'] = "Dein Benutzerkonto wurde erstellt, benoetigt aber noch die email-Bestaetigung die nicht gesendet werden konnte. Bitte den Forenadmin kontaktieren um den Fehler zu beheben. I nder Zwischenzeit klicke auf Weiter um Dich anzumelden.";
$lang['useraccountcreatedconfirmsuccess'] = "Dein Benutzerkonto wurde erstellt, bevor Du neue Posts erstellen kannst musst Du Deine eMail-Adresse bestaetigen. Bitte pruefe Dein Email-Postfach nach einer eMail vom Forum und folge den Anweisungen in dieser Mail um Dein Konto hier zu bestaetigen.";
$lang['useraccountcreated'] = "Dein Benutzerkonto wurde erfolgreich erstellt. Klick auf Weiter um Dich anzumelden";
$lang['errorcreatinguserrecord'] = "Fehler bei der Erstellung des Benutzerkontos";
$lang['userregistration'] = "Benutzerregistrierung";
$lang['registrationinformationrequired'] = "Registrierungsinfo (Benoetigt)";
$lang['profileinformationoptional'] = "Profilinformation (Optional)";
$lang['preferencesoptional'] = "Praeferenzen (Optional)";
$lang['register'] = "Registrieren";
$lang['rememberpasswd'] = "Passworterinnerung";
$lang['birthdayrequired'] = "Dein Geburtsdatum fehlt oder ist fehlerhaft";
$lang['alwaysnotifymeofrepliestome'] = "Mitteilen wenn Antwort fuer mich";
$lang['notifyonnewprivatemessage'] = "Mitteilen bei neuer PM (Private Nachricht)";
$lang['popuponnewprivatemessage'] = "PopUp bei neuer PM";
$lang['automatichighinterestonpost'] = "Automatisch als Wichtig kennzeichen wenn Eintrag erstellt wird?";
$lang['confirmpassword'] = "Passwort bestaetigen";
$lang['invalidemailaddressformat'] = "Falsches eMail-Adressformat";
$lang['moreoptionsavailable'] = "Mehr Profil- und Praeferenzoptionen gibt es nach deiner Registrierung";
$lang['textcaptchaconfirmation'] = "Bestaetigung";
$lang['textcaptchaexplain'] = "Rechts ist ein textbeinhaltendes Bild. Bitte tippe die Zeichen die Du in dem Bild sehen kannst in das Eingabefeld darunter.";
$lang['textcaptchaimgtip'] = "Dies ist ein captcha-Bild. Es ist notwendig um eine automatische Registrierung zu ueberpruefen";
$lang['textcaptchamissingkey'] = "Der Bestaetigungscode ist notwendig.";
$lang['textcaptchaverificationfailed'] = "Text-Vergleich fehlgeschlagen. Bitte nochmals eingeben.";
$lang['forumrules'] = "Forenregeln";
$lang['forumrulesnotification'] = "Um fortzufahren muessen Sie folgenden Regeln zustimmen";
$lang['forumrulescheckbox'] = "Ich habe die Forenregeln gelesen und akzeptiert.";
$lang['youmustagreetotheforumrules'] = "Sie muessen den Forenregeln zustimmen bevor Sie fortfahren.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "Mitglied";
$lang['searchforusernotinlist'] = "Suche nach einem nicht aufgelisteten Benutzer";
$lang['yoursearchdidnotreturnanymatches'] = "Deine Suche ergab keine Treffer. Aendere deine Suchbegriffe und  versuch es noch mal.";
$lang['hiderowswithemptyornullvalues'] = "Reihen mit leeren Werten in ausgewaehlten Foren ausblenden";
$lang['showregisteredusersonly'] = "Nur registrierte Benutzer anzeigen (Gaeste ausblenden)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "Verhaeltnisse";
$lang['userrelationship'] = "Benutzerverhaeltnis";
$lang['userrelationships'] = "Benutzerverhaeltnisse";
$lang['failedtoremoveselectedrelationships'] = "Ausgewaehlte Beziehung konnte nicht geloescht werden";
$lang['friends'] = "Freunde";
$lang['ignoredcompletely'] = "Komplett Ignoriert";
$lang['relationship'] = "Verhaeltnis";
$lang['restorenickname'] = "Nickname des Benutzers wiederherstellen";
$lang['friend_exp'] = "Benutzerposts werden mit &quot;Freund&quot; icon markiert.";
$lang['normal_exp'] = "Benutzerposts erscheinen normal.";
$lang['ignore_exp'] = "Benutzerposts werden versteckt.";
$lang['ignore_completely_exp'] = "Eintraege an und von Benutzer erscheinen geloescht.";
$lang['display'] = "Anzeige";
$lang['displaysig_exp'] = "Benutzersignatur wird in den Posts angezeigt";
$lang['hidesig_exp'] = "Benutzersignatur wird in den Posts versteckt";
$lang['cannotignoremod'] = "Du kannst keine Benutzer ignorieren wenn sie Moderatoren sind.";
$lang['previewsignature'] = "Voransicht Signatur";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "Suchergebnisse";
$lang['usernamenotfound'] = "Der definierte Benutzername im An- oder Von-Feld wurde nicht gefunden.";
$lang['notexttosearchfor'] = "Einer oder alle Deine Suchbegriffe sind ungueltig. Suchbegriffe muessen kuerzer als %d Zeichen und nicht laenger als %d Zeichen sein und duerfen nicht in der %s erscheinen";
$lang['keywordscontainingerrors'] = "Schluesselwoerter haben Fehler: %s";
$lang['mysqlstopwordlist'] = "MySQL Stopwortliste";
$lang['foundzeromatches'] = "Gefunden: 0 Treffer";
$lang['found'] = "Gefunden";
$lang['matches'] = "Treffer";
$lang['prevpage'] = "Vorherige Seite";
$lang['findmore'] = "Mehr finden";
$lang['searchmessages'] = "Such in Nachrichten";
$lang['searchdiscussions'] = "Such in Diskussionen";
$lang['find'] = "Finde";
$lang['additionalcriteria'] = "Zusaetzliche Kriterien";
$lang['searchbyuser'] = "Suche ueber Benutzer (optional)";
$lang['folderbrackets_s'] = "Ordner";
$lang['postedfrom'] = "Geschrieben von";
$lang['postedto'] = "Geschrieben an";
$lang['today'] = "Heute";
$lang['yesterday'] = "Gestern";
$lang['daybeforeyesterday'] = "Vorgestern";
$lang['weekago'] = "vor %s Woche";
$lang['weeksago'] = "vor %s Wochen";
$lang['monthago'] = "vor %s Monat";
$lang['monthsago'] = "vor %s Monaten";
$lang['yearago'] = "vor %s Jahr";
$lang['beginningoftime'] = "von Anfang an";
$lang['now'] = "Jetzt";
$lang['lastpostdate'] = "Letztes Eintragsdatum";
$lang['numberofreplies'] = "Anzahl der Antworten";
$lang['foldername'] = "Ordnername";
$lang['authorname'] = "Autor-Name";
$lang['decendingorder'] = "Neuste zuerst";
$lang['ascendingorder'] = "Aelteste zuerst";
$lang['keywords'] = "Schluesselwoerter";
$lang['sortby'] = "Sortiert nach";
$lang['sortdir'] = "Sortierverzeichnis";
$lang['sortresults'] = "Sortierergebnisse";
$lang['groupbythread'] = "Gruppieren nach Eintrag";
$lang['postsfromuser'] = "Posts von Benutzer";
$lang['poststouser'] = "Posts an Benutzer";
$lang['poststoandfromuser'] = "Posts an und von Benutzer";
$lang['searchfrequencyerror'] = "Du kannst nur einmal jede %s Sekunden suchen. Bitte versuch es spaeter nochmal.";
$lang['searchsuccessfullycompleted'] = "Sucher fertiggestellt. %s";
$lang['clickheretoviewresults'] = "Hier klicken fuer Ergebnisse.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "Auswaehlen";
$lang['searchforthread'] = "Suche nach Eintrag";
$lang['mustspecifytypeofsearch'] = "Typ definieren um Suche zu starten";
$lang['unkownsearchtypespecified'] = "Unbekannter Suchtyp definiert";
$lang['mustentersomethingtosearchfor'] = "Es muss etwas zum Suchen eingegeben sein";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "Neue Eintraege";
$lang['startreading'] = "Lesen";
$lang['threadoptions'] = "Eintragsoptionen";
$lang['editthreadoptions'] = "Eintragsoptionen aendern";
$lang['morevisitors'] = "Mehr Besucher";
$lang['forthcomingbirthdays'] = "Bevorstehende Geburtstage";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "Aendern dieser Seite ueber das Admin-Interface";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "Neue Diskussion";
$lang['createpoll'] = "Abstimmung erstellen";
$lang['search'] = "Suchen";
$lang['searchagain'] = "Weitersuchen";
$lang['alldiscussions'] = "Alle Diskussionen";
$lang['unreaddiscussions'] = "Ungelesene Diskussionen";
$lang['unreadtome'] = "Ungelesene &quot;An: Me&quot;";
$lang['todaysdiscussions'] = "Diskussionen von Heute";
$lang['2daysback'] = "2 Tage zurueck";
$lang['7daysback'] = "7 Tage zurueck";
$lang['highinterest'] = "Wichtig";
$lang['unreadhighinterest'] = "Ungelesenes Wichtiges";
$lang['iverecentlyseen'] = "Vor kurzem gelesenes";
$lang['iveignored'] = "Ich werde ignoriert";
$lang['byignoredusers'] = "Von ignorierten Benutzern";
$lang['ivesubscribedto'] = "Ich bin angenommen bei";
$lang['startedbyfriend'] = "Von einem Freund gestartet";
$lang['unreadstartedbyfriend'] = "Ungelesen gestartet von einem Freund";
$lang['startedbyme'] = "von mir gestartet";
$lang['unreadtoday'] = "Heute ungelesen";
$lang['deletedthreads'] = "Geloeschte Eintraege";
$lang['goexcmark'] = "Los!";
$lang['folderinterest'] = "Ordnerwichtigkeit";
$lang['postnew'] = "Neue Posts";
$lang['currentthread'] = "Aktueller Eintrag";
$lang['highinterest'] = "Wichtig";
$lang['markasread'] = "Als gelesen markieren";
$lang['next50discussions'] = "Naechste 50 Diskussionen";
$lang['visiblediscussions'] = "Sichtbare Diskussionen";
$lang['selectedfolder'] = "Ordner auswaehlen";
$lang['navigate'] = "Navigieren";
$lang['couldnotretrievefolderinformation'] = "Keine Ordner vorhanden.";
$lang['nomessagesinthiscategory'] = "Keine Nachrichten in dieser Kategorie. Bitte waehle eine andere, oder %s fuer alle Eintraege";
$lang['clickhere'] = "klick hier";
$lang['prev50threads'] = "Vorherige 50 Eintraege";
$lang['next50threads'] = "Naechste 50 Eintraege";
$lang['nextxthreads'] = "Naechste %s Eintraege";
$lang['threadstartedbytooltip'] = "Eintrag #%s gestart durch %s. Angesehen %s";
$lang['threadviewedonetime'] = "Angezeigehaeufigkeit: 1 mal";
$lang['threadviewedtimes'] = "Angezeigehaeufigkeit: %d mal";
$lang['unreadthread'] = "Ungelesener Eintrag";
$lang['readthread'] = "Gelesener Eintrag";
$lang['unreadmessages'] = "Ungelesene Nachrichten";
$lang['subscribed'] = "Angenommen";
$lang['ignorethisfolder'] = "Diesen Ordner ignorieren";
$lang['stopignoringthisfolder'] = "Diesen Ordner nicht mehr ignorieren";
$lang['stickythreads'] = "Eintrag festgehalten";
$lang['mostunreadposts'] = "Meiste ungelesene Eintraege";
$lang['onenew'] = "%d neu";
$lang['manynew'] = "%d neu";
$lang['onenewoflength'] = "%d neu von %d";
$lang['manynewoflength'] = "%d neu von %d";
$lang['ignorefolderconfirm'] = "Bist Du sicher dass Du diesen Ordner ignorieren willst?";
$lang['unignorefolderconfirm'] = "Bist Du sicher dass Du diesen Ordner nicht mehr ignorieren willst?";
$lang['confirmmarkasread'] = "Ausgewaehlte Eintraege als gelesen markieren?";
$lang['successfullymarkreadselectedthreads'] = "Ausgewaehlte Eintraege als gelesen markiert";
$lang['failedtomarkselectedthreadsasread'] = "Fehler beim Markieren der Eintraege als gelesen";
$lang['gotofirstpostinthread'] = "Springe zum ersten Post im Eintrag";
$lang['gotolastpostinthread'] = "Springe zu letztem Post im Eintrag";
$lang['viewmessagesinthisfolderonly'] = "Nachrichten nur in diesem Ordner anzeigen";
$lang['shownext50threads'] = "Zeige naechste 50 Eintraege";
$lang['showprev50threads'] = "Zeige vorherige 50 Eintraege";
$lang['createnewdiscussioninthisfolder'] = "Erstelle neue Diskussion in diesem Ordner";
$lang['nomessages'] = "Keine Nachrichten";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "Fellt";
$lang['italic'] = "Schraegschrift";
$lang['underline'] = "Unterstrichen";
$lang['strikethrough'] = "Durchgestrichen";
$lang['superscript'] = "Hochzeichen";
$lang['subscript'] = "Tiefzeichen";
$lang['leftalign'] = "Linksbuendig";
$lang['center'] = "Mittig";
$lang['rightalign'] = "Rechtsbuendig";
$lang['numberedlist'] = "Nummerische Liste";
$lang['list'] = "Liste";
$lang['indenttext'] = "Texteinzug";
$lang['code'] = "Code";
$lang['quote'] = "Anfuehrungsstrich";
$lang['spoiler'] = "Spoiler";
$lang['horizontalrule'] = "Horizontale Linie";
$lang['image'] = "Bild";
$lang['hyperlink'] = "Hyperlink";
$lang['noemoticons'] = "Emoticons deaktivieren";
$lang['fontface'] = "Schriftart";
$lang['size'] = "Groesse";
$lang['colour'] = "Farbe";
$lang['red'] = "Rot";
$lang['orange'] = "Orange";
$lang['yellow'] = "Gelb";
$lang['green'] = "Gruen";
$lang['blue'] = "Blau";
$lang['indigo'] = "Indigo";
$lang['violet'] = "Violett";
$lang['white'] = "Weiss";
$lang['black'] = "Schwarz";
$lang['grey'] = "Grau";
$lang['pink'] = "Rosa";
$lang['lightgreen'] = "Hellgruen";
$lang['lightblue'] = "Hellblau";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "Forenstatistik";
$lang['usersactiveinthepasttimeperiod'] = "%s aktriv in den letzten %s. %s";

$lang['numactiveguests'] = "<b>%s</b> Gaeste";
$lang['oneactiveguest'] = "<b>1</b> Gast";
$lang['numactivemembers'] = "<b>%s</b> Mitglieder";
$lang['oneactivemember'] = "<b>1</b> Mitglied";
$lang['numactiveanonymousmembers'] = "<b>%s</b> anonyme Mitglieder";
$lang['oneactiveanonymousmember'] = "<b>1</b> anonymes Mitglied";

$lang['numthreadscreated'] = "<b>%s</b> Eintraege";
$lang['onethreadcreated'] = "<b>1</b> Eintrag";
$lang['numpostscreated'] = "<b>%s</b> Posts";
$lang['onepostcreated'] = "<b>1</b> Post";

$lang['younormal'] = "Du";
$lang['youinvisible'] = "Du (Unsichtbar)";
$lang['viewcompletelist'] = "Zeige komplette Liste";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "Unsere Mitglieder haben insgesamt %s und %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "Laengster Eintrag ist <b>%s</b> mit %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "Es wurden <b>%s</b> Posts erstellt in den letzten 60 Minuten.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "Es wurde <b>1</b> Post erstellt in den letzten 60 minuten.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "Die meisten Posts die je gemacht wurden innerhalb 60 Minuten sind <b>%s</b> in %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "Wir haben <b>%s</b> registrierte Mitglieder und das neuste Mitglied ist <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "Wir haben %s registrierte Mitglieder.";
$lang['wehaveoneregisteredmember'] = "Wir haben 1 registriertes Mitglied.";
$lang['mostuserseveronlinewasnumondate'] = "Die meisten Benutzer die je online waren sind <b>%s</b> in %s.";
$lang['statsdisplaychanged'] = "Statistikanzeige geaendert";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "Aenderungen gespeichert";
$lang['useroptions'] = "Benutzeroptionen";
$lang['markedasread'] = "Als gelesen markieren";
$lang['postsoutof'] = "Posts aus";
$lang['interest'] = "Wichtigkeit";
$lang['closedforposting'] = "Geschlossen, keine Posts mehr moeglich";
$lang['locktitleandfolder'] = "Sperre Titel und Ordner";
$lang['deletepostsinthreadbyuser'] = "Loesche Posts in Eintraegen von Benutzer";
$lang['deletethread'] = "Loesche Eintrag";
$lang['permenantlydelete'] = "Permenantly Delete";
$lang['movetodeleteditems'] = "Verschieben zu den geloeschten Eintraegen";
$lang['undeletethread'] = "Ungeloeschte Eintraege";
$lang['threaddeletedpermenantly'] = "Eintrag endgueltig geloescht. Keine Wiederherstellung moeglich.";
$lang['markasunread'] = "Als Ungelesen markieren";
$lang['makethreadsticky'] = "Eintrag festhalten";
$lang['threareadstatusupdated'] = "Eintragslesestatus erfolgreich geaendert";
$lang['interestupdated'] = "Eintragswichtigkeitsstatus erfolgreich geaendert";
$lang['failedtoupdatethreadreadstatus'] = "Fehler beim Aendern des Lese-Status";
$lang['failedtoupdatethreadinterest'] = "Fehler beim Aendern des Interessenstatus";
$lang['failedtorenamethread'] = "Fehler bei Eintragsumbenennung";
$lang['failedtomovethread'] = "Fehler beim Verschieben des definierten Ordners";
$lang['failedtoupdatethreadstickystatus'] = "Fehler beim Aendern des Sticky-Status";
$lang['failedtoupdatethreadclosedstatus'] = "Fehler beim Aendern des Schliessen-Status";
$lang['failedtoupdatethreadlockstatus'] = "Fehler beim Aendern des Sperrstatus";
$lang['failedtodeletepostsbyuser'] = "Fehler beim Posts-Loeschen des ausgewaehlten Benutzers";
$lang['failedtodeletethread'] = "Eintragsloeschung fehlgeschlagen.";
$lang['failedtoundeletethread'] = "Eintragswiederherstellung fehlgeschlagen";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "Woerterbuch";
$lang['spellcheck'] = "Rechtschreibpruefung";
$lang['notindictionary'] = "Nicht im Woerterbuch";
$lang['changeto'] = "Wechsel zu";
$lang['restartspellcheck'] = "Neustart";
$lang['cancelchanges'] = "Aenderungen verwerfen";
$lang['initialisingdotdotdot'] = "Initialisierung...";
$lang['spellcheckcomplete'] = "Rechtschreibpruefung abgeschlossen. Erneute Pruefung mit 'Neustart'.";
$lang['spellcheck'] = "Rechtschreibpruefung";
$lang['noformobj'] = "Kein Formularobjekt definiert fuer Zurueck-Text";
$lang['bodytext'] = "Inhaltstext";
$lang['ignore'] = "Ignorieren";
$lang['ignoreall'] = "Alles ignorieren";
$lang['change'] = "Wechsel";
$lang['changeall'] = "Alles aendern";
$lang['add'] = "Hinzufügen";
$lang['suggest'] = "Vorschlagen";
$lang['nosuggestions'] = "(keine Vorschlaege)";
$lang['cancel'] = "Abbrechen";
$lang['dictionarynotinstalled'] = "Kein Woerterbuch installiert. Bitte Foren-Admin informieren.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "Posts lesen erlaubt";
$lang['postcreationallowed'] = "Posts erstellen erlaubt";
$lang['threadcreationallowed'] = "Eintragserstellung erlaubt";
$lang['posteditingallowed'] = "Postsaenderung erlaubt";
$lang['postdeletionallowed'] = "Postsloeschung erlaubt";
$lang['attachmentsallowed'] = "Anhaenge erlaubt";
$lang['htmlpostingallowed'] = "HTML posten erlaubt";
$lang['signatureallowed'] = "Signatur erlaubt";
$lang['guestaccessallowed'] = "Gastzugang erlaubt";
$lang['postapprovalrequired'] = "Post benoetigt Zustimmung eines Moderators";

// RSS feeds gubbins

$lang['rssfeed'] = "RSS Feed";
$lang['every30mins'] = "Alle 30 Minuten";
$lang['onceanhour'] = "Einmal je Stunde";
$lang['every6hours'] = "Alle 6 Stunden";
$lang['every12hours'] = "Alle 12 Stunden";
$lang['onceaday'] = "Einmal am Tag";
$lang['onceaweek'] = "Once a Week";
$lang['rssfeeds'] = "RSS Feeds";
$lang['feedname'] = "Feed-Name";
$lang['feedfoldername'] = "Feed Ordner Name";
$lang['feedlocation'] = "Feed Lokation";
$lang['threadtitleprefix'] = "Eintragstitel Praefix";
$lang['feednameandlocation'] = "Feed Name und Position";
$lang['feedsettings'] = "Feed Einstellungen";
$lang['updatefrequency'] = "Aktualisierungshaeufigkeit";
$lang['rssclicktoreadarticle'] = "Hier klicken um den Artikel zu lesen";
$lang['addnewfeed'] = "Neuen Feed hinzufuegen";
$lang['editfeed'] = "Feed bearbeiten";
$lang['feeduseraccount'] = "Feed Benutzerkonto";
$lang['noexistingfeeds'] = "Keine bestehenden RSS-Feeds gefunden. um einen hinzuzufuegen 'Neu hinzufuegen' klicken";
$lang['rssfeedhelp'] = "Hier kannst Du RSS-Feeds installieren fuer automatische Verbreitung in Deinem Forum. Die Eintraege der RSS-Feeds die Du anfuegst werden in Threads erstellt mit denen Benutzer antworten koennen als waeren es normale Posts. Beim Hinzufuegen eines RSS-Feeds musst Du den Benutzerlogon definieren der benutzt werden soll um Threads zu starten, Der Ordner in dem er erstellt werden soll und die Lokation des Feeds. Die Feed-Lokation muss via HTTP erreichbar sein, ansonsten wird es nicht funktionieren.";
$lang['mustspecifyrssfeedname'] = "RSS Feed Name muss definiert sein";
$lang['mustspecifyrssfeeduseraccount'] = "RSS Feed Benutzerkonto muss definiert sein";
$lang['mustspecifyrssfeedfolder'] = "RSS Feed Ordner muss definiert sein";
$lang['mustspecifyrssfeedurl'] = "RSS Feed URL muss definiert sein";
$lang['mustspecifyrssfeedupdatefrequency'] = "RSS Feed Update-Haeufigkeit muss definiert sein";
$lang['unknownrssuseraccount'] = "Unbekanntes RSS Benutzerkonto";
$lang['rssfeedsupportshttpurlsonly'] = "RSS Feed unterstuetzt nur HTTP URLs. Sichere Feeds (https://) werden nicht unterstuetzt.";
$lang['rssfeedurlformatinvalid'] = "RSS Feed URL format ist ungueltig. URL muss Schema beinhalten (e.g. http://) und einen Hostnamen (z.B. www.hostname.com).";
$lang['rssfeeduserauthentication'] = "RSS Feed unterstuetzt keine HTTP user-authentication";
$lang['successfullyremovedselectedfeeds'] = "Ausgewaehlte Feeds erfolgreich geloescht";
$lang['successfullyaddedfeed'] = "Ausgewaehlte Feeds erfolgreich hinzugefuegt";
$lang['successfullyeditedfeed'] = "Feed erfolgreich bearbeitet";
$lang['failedtoremovefeeds'] = "Fehler beim Loeschen einiger oder aller ausgewaehlter Feeds";
$lang['failedtoaddnewrssfeed'] = "Fehler beim Hinzufuegen des neuen RSS Feeds";
$lang['failedtoupdaterssfeed'] = "Fehler beim Aktualisieren des RSS Feeds";
$lang['rssstreamworkingcorrectly'] = "RSS Stream scheint korrekt zu funktionieren";
$lang['rssstreamnotworkingcorrectly'] = "RSS Stream war leer oder konnte nicht gefunden werden";
$lang['invalidfeedidorfeednotfound'] = "Falsche Feed-ID oder Feed nicht gefunden";

// PM Export Options

$lang['pmexportastype'] = "Exportieren als Dateiart";
$lang['pmexporthtml'] = "HTML";
$lang['pmexportxml'] = "XML";
$lang['pmexportplaintext'] = "Reiner Text";
$lang['pmexportmessagesas'] = "Exportiere Nachrichten als";
$lang['pmexportonefileforallmessages'] = "Eine Datei fuer alle Nachrichten";
$lang['pmexportonefilepermessage'] = "Eine Datei je Nachricht";
$lang['pmexportattachments'] = "Exportiere Anhaenge";
$lang['pmexportincludestyle'] = "Einschliesslich Forendesign";
$lang['pmexportwordfilter'] = "Zutreffende Wortfilter in Nachrichten";

// Thread merge / split options

$lang['threadhasbeensplit'] = "Eintrag wurde aufgeteilt";
$lang['threadhasbeenmerged'] = "Eintraege wurden zusammengefuegt";
$lang['mergesplitthread'] = "Zusammenfuegen/Trennen von Eintraegen";
$lang['mergewiththreadid'] = "Zusammenfuegen mit Eintrag Nr:";
$lang['postsinthisthreadatstart'] = "Beitraege in diesem Eintrag starten ab";
$lang['postsinthisthreadatend'] = "Beitraege in diesem Eintrag stoppen bei";
$lang['reorderpostsintodateorder'] = "Sortiere Eintraege nach Datum";
$lang['splitthreadatpost'] = "Trenne Eintrag bei Beitrag:";
$lang['selectedpostsandrepliesonly'] = "Waehle Beitrag aus und beantworte nur";
$lang['selectedandallfollowingposts'] = "Diesen und alle folgenden Beitraege auswaehlen";

$lang['threadmovedhere'] = "hier";

$lang['thisthreadhasmoved'] = "<b>Eintraege zusammengefuegt:</b> Dieser Eintrag wurde verscvhoben nach %s";
$lang['thisthreadwasmergedfrom'] = "<b>Eintraege zusammengefuegt:</b> Dieser Eintrag wurde angefuegt an %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>Eintragsaufteilung:</b> Einige Beitraege in diesem Eintrag wurden verschoben nach %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>Eintragsaufteilung:</b> Einige Beitrage ind diesem Eintrag wurden verschoben von %s";

$lang['thisposthasbeenmoved'] = "<b>Eintragsaufteilung:</b> Dieser Post wurde verschoben %s";

$lang['invalidfunctionarguments'] = "Falsche Funktionsangaben";
$lang['couldnotretrieveforumdata'] = "Kann Forendaten nicht holen";
$lang['cannotmergepolls'] = "Einer oder mehrere Eintraege sind Abstimmungen. Sie koennen Abstimmungen nicht zusammenlegen";
$lang['couldnotretrievethreaddatamerge'] = "Kann Eintragsdaten aus einem oder mehreren Eintraegen nicht holen";
$lang['couldnotretrievethreaddatasplit'] = "Kann Eintragsdaten nicht aus dem Quell-Eintrag holen";
$lang['couldnotretrievepostdatamerge'] = "Kann Eintragsdaten aus einem oder mehreren Eintraegen nicht holen";
$lang['couldnotretrievepostdatasplit'] = "Kann Eintragsdaten nicht aus dem Quell-Eintrag holen";
$lang['failedtocreatenewthreadformerge'] = "Kann neuen Eintrag nicht anlegen fuer Zusammenlegung";
$lang['failedtocreatenewthreadforsplit'] = "Kann neuen Eintrag nicht anlegen zur Aufteilung";

// Thread subscriptions

$lang['threadsubscriptions'] = "Eintragsbeschreibungen";
$lang['couldnotupdateinterestonthread'] = "Konnte Interessensfunktion in Eintrag '%s' nicht aendern";
$lang['threadinterestsupdatedsuccessfully'] = "Interessensfunktion des Eintrags erfolgreich geaendert";
$lang['nothreadsubscriptions'] = "Sie sind in keinem Eintrag verzeichnet.";
$lang['resetselected'] = "Auswahl zuruecksetzen";
$lang['allthreadtypes'] = "Alle Eintragstypen";
$lang['ignoredthreads'] = "Ignoriere Eintraege";
$lang['highinterestthreads'] = "Sehr wichtige Eintraege";
$lang['subscribedthreads'] = "abgezeichnete Eintraege";
$lang['currentinterest'] = "im Moment wichtig";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "Sie koennen nur 3 Zeilen hinzufuegen. Um eine neue Zeile einzufuegen muss eine bestehende geschlossen werden";
$lang['columnalreadyadded'] = "Diese Zeile wurde bereits hinzugefuegt. Um Sie zu entfernen den dazugehoerigen 'Schliessen'-Button klicken";

?>
