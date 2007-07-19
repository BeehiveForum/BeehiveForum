<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: fr-ca.inc.php,v 1.60 2007-07-19 22:14:13 decoyduck Exp $ */

// French Canadian language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "fr-ca";    // ISO-639 language code
$lang['_textdir'] = "ltr";      // ltr or rtl; left to right or vice versa

// Months --------------------------------------------------------------

$lang['month'][1]  = "Janvier";
$lang['month'][2]  = "F�vrier";
$lang['month'][3]  = "Mars";
$lang['month'][4]  = "Avril";
$lang['month'][5]  = "Mai";
$lang['month'][6]  = "Juin";
$lang['month'][7]  = "Juillet";
$lang['month'][8]  = "Ao�t";
$lang['month'][9]  = "Septembre";
$lang['month'][10] = "Octobre";
$lang['month'][11] = "Novembre";
$lang['month'][12] = "D�cembre";

$lang['month_short'][1]  = "jan";
$lang['month_short'][2]  = "f�v";
$lang['month_short'][3]  = "mars";
$lang['month_short'][4]  = "avr";
$lang['month_short'][5]  = "mai";
$lang['month_short'][6]  = "juin";
$lang['month_short'][7]  = "juil";
$lang['month_short'][8]  = "ao�t";
$lang['month_short'][9]  = "sep";
$lang['month_short'][10] = "oct";
$lang['month_short'][11] = "nov";
$lang['month_short'][12] = "d�c";

// Dates ---------------------------------------------------------------

// Various date and time formats as used by BeehiveForum. All times are
// expressed as 24 hour time format.

$lang['daymonthyear'] = "%s %s %s";                 // e.g. 1 Jan 2005
$lang['monthyear'] = "%s %s";                       // e.g. Jan 2005
$lang['daymonthyearhourminute'] = "%s %s %s %sh%s"; // e.g. 1 Jan 2005 12:00
$lang['daymonthhourminute'] = "%s %s %sh%s";        // e.g. 1 Jan 18:30
$lang['daymonth'] = "%s %s";                        // e.g. 1 Jan
$lang['hourminute'] = "%sh%s";                      // e.g. 12:00

// Periods -------------------------------------------------------------

// Various time periods as used by BeehiveForum.

$lang['date_periods']['year']   = "%s year";
$lang['date_periods']['month']  = "%s month";
$lang['date_periods']['week']   = "%s week";
$lang['date_periods']['day']    = "%s day";
$lang['date_periods']['hour']   = "%s hour";
$lang['date_periods']['minute'] = "%s minute";
$lang['date_periods']['second'] = "%s second";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s years";
$lang['date_periods_plural']['month']  = "%s months";
$lang['date_periods_plural']['week']   = "%s weeks";
$lang['date_periods_plural']['day']    = "%s days";
$lang['date_periods_plural']['hour']   = "%s hours";
$lang['date_periods_plural']['minute'] = "%s minutes";
$lang['date_periods_plural']['second'] = "%s seconds";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%smin";  // 6min
$lang['date_periods_short']['second'] = "%ssec";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "Pourcentage";
$lang['average'] = "Moyenne";
$lang['approve'] = "Approuver";
$lang['banned'] = "Banni";
$lang['locked'] = "Verrouill�";
$lang['add'] = "Ajouter";
$lang['advanced'] = "Avanc�";
$lang['active'] = "Actif";
$lang['style'] = "Style";
$lang['go'] = "Allez-y";
$lang['folder'] = "Dossier";
$lang['ignoredfolder'] = "Dossier ignor�";
$lang['folders'] = "Dossiers";
$lang['thread'] = "fil de discussion";
$lang['threads'] = "fils de discussion";
$lang['threadlist'] = "Thread List";
$lang['message'] = "Message";
$lang['messagenumber'] = "Num�ro de message";
$lang['from'] = "De";
$lang['to'] = "�";
$lang['all_caps'] = "TOUS";
$lang['of'] = "de";
$lang['reply'] = "R�pondre";
$lang['forward'] = "Forward";
$lang['replyall'] = "R�pondre � tous";
$lang['pm_reply'] = "R�pondre en MP";
$lang['delete'] = "supprimer";
$lang['deleted'] = "supprim�";
$lang['edit'] = "Modifier";
$lang['privileges'] = "Privil�ges";
$lang['ignore'] = "Ignorer";
$lang['normal'] = "Normal";
$lang['interested'] = "Interess�";
$lang['subscribe'] = "S'abonner �";
$lang['apply'] = "Appliquer";
$lang['download'] = "T�l�charger";
$lang['save'] = "Enregistrer";
$lang['update'] = "Mettre � jour";
$lang['cancel'] = "Annuler";
$lang['retry'] = "Retry";
$lang['continue'] = "Continuer";
$lang['attachment'] = "Fichier joint";
$lang['attachments'] = "Fichiers joints";
$lang['imageattachments'] = "Image jointe";
$lang['filename'] = "Nom de fichier";
$lang['dimensions'] = "Dimensions";
$lang['downloadedxtimes'] = "T�l�charg�: %d fois";
$lang['downloadedonetime'] = "T�l�charg�: 1 fois";
$lang['size'] = "Taille de fichier";
$lang['viewmessage'] = "voir le message";
$lang['deletethumbnails'] = "Supprimer vignettes";
$lang['logon'] = "Ouverture de session";
$lang['more'] = "Plus";
$lang['recentvisitors'] = "Derni�res visites";
$lang['username'] = "nom d'utilisateur";
$lang['clear'] = "Effacer";
$lang['action'] = "Action";
$lang['unknown'] = "Inconnu";
$lang['none'] = "aucun";
$lang['preview'] = "Aper�u";
$lang['post'] = "Poster";
$lang['posts'] = "Messages";
$lang['change'] = "Changer";
$lang['yes'] = "Oui";
$lang['no'] = "Non";
$lang['signature'] = "Signature";
$lang['signaturepreview'] = "Aper�u de Signature";
$lang['signatureupdated'] = "Signature mise � jour";
$lang['back'] = "Retour";
$lang['subject'] = "Sujet";
$lang['close'] = "Fermer";
$lang['name'] = "Nom";
$lang['description'] = "Description";
$lang['date'] = "Date";
$lang['view'] = "Visualiser";
$lang['enterpasswd'] = "Entrer mot de passe";
$lang['passwd'] = "Mot de passe";
$lang['ignored'] = "Ignor�(e)";
$lang['guest'] = "Visiteur";
$lang['next'] = "Prochain";
$lang['prev'] = "Pr�c�dent";
$lang['others'] = "Autres";
$lang['nickname'] = "Pseudonyme";
$lang['emailaddress'] = "Adress courriel";
$lang['confirm'] = "Confirmer";
$lang['email'] = "Courriel";
$lang['poll'] = "Scrutin";
$lang['friend'] = "Ami(e)";
$lang['error'] = "Erreur";
$lang['guesterror'] = "D�sol�, vous devez ouvrir une session pour utiliser cette fonction.";
$lang['loginnow'] = "Ouvrir une session maintenant";
$lang['unread'] = "non-lu";
$lang['all'] = "Tous";
$lang['allcaps'] = "TOUS";
$lang['permissions'] = "Droits d'acc�s";
$lang['type'] = "Type";
$lang['print'] = "Imprimer";
$lang['sticky'] = "Collant";
$lang['polls'] = "Scrutins";
$lang['user'] = "Utilisateur";
$lang['enabled'] = "Activ�";
$lang['disabled'] = "D�sactiv�";
$lang['options'] = "Options";
$lang['emoticons'] = "Binettes";
$lang['webtag'] = "balise d'adresse web";
$lang['makedefault'] = "En faire l'option par d�faut";
$lang['unsetdefault'] = "Supprimer le d�faut";
$lang['rename'] = "Renommer";
$lang['pages'] = "Pages";
$lang['used'] = "Utilis�";
$lang['days'] = "jours";
$lang['usage'] = "Utilisation";
$lang['show'] = "Montrer";
$lang['hint'] = "Indice";
$lang['new'] = "Nouveau";
$lang['referer'] = "R�f�rent";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "OUtils admin";
$lang['forummanagement'] = "Gestion du forum";
$lang['accessdeniedexp'] = "Vous n'avez pas les droits d'acc�s pour utiliser cette section.";
$lang['managefolders'] = "Organiser les dossiers";
$lang['manageforums'] = "Organiser les forums";
$lang['manageforumpermissions'] = "Organiser les droits d'acc�s du forum";
$lang['foldername'] = "Nom du dossier";
$lang['move'] = "D�placer";
$lang['closed'] = "Ferm�";
$lang['open'] = "Ouvert";
$lang['restricted'] = "Limit�";
$lang['iscurrentlyclosed'] = "est pr�sentement ferm�";
$lang['youdonothaveaccessto'] = "Vous n'avez pas les droits d'acc�s �";
$lang['toapplyforaccessplease'] = "Pour demander acc�s, veuillez contacter le propri�taire du forum.";
$lang['adminforumclosedtip'] = "Si vous d�sirez changer certains r�glages sur votre forum, cliquer le lien Admin dans la barre de navigation ci-dessus.";
$lang['newfolder'] = "Nouveau dossier";
$lang['forumadmin'] = "Admin du forum";
$lang['adminexp_1'] = "Utiliser le menu � gauche pour g�rer votre forum.";
$lang['adminexp_2'] = "<b>Utilisateurs</b> vous permet de fixer les droits d'acc�s d'utilisateurs individuels, y inclut la nomination d'�diteurs et le ba�llonnement d'individus.";
$lang['adminexp_3'] = "<b>Groupes d'utilisateurs</b> vous permet de cr�er des groupes d'utilisateurs pour assigner des droits d'acc�s � quelques ou plusieurs utilisateurs rapidement et facilement.";
$lang['adminexp_4'] = "<b>Commandes de bannissement</b> permet le bannissement et la lev�e de bannissement d'adresses IP, noms d'utilisateurs, adresses courriel et pseudonymes.";
$lang['adminexp_5'] = "<b>Dossiers</b> permet de cr�er, modifier et de supprimer les dossiers.";
$lang['adminexp_6'] = "<b>RSS Feeds</b> allows you to create and remove RSS feeds for propogation into your forum.";
$lang['adminexp_7'] = "<b>Profiles</b> vous permet de personnaliser les d�tails qui appara�ssent dans les profiles d'utilisateurs.";
$lang['adminexp_8'] = "<b>Options du forum</b> vous permet de personnaliser le nom du forum, l'apparence et plusieurs autres choses.";
$lang['adminexp_9'] = "<b>Page de d�marrage</b> permet la personnalisation de la page de d�marrage de votre forum.";
$lang['adminexp_10'] = "<b>Style du forum</b> vous permet de cr�er des styles que vos membres pourront utiliser.";
$lang['adminexp_11'] = "<b>Filtrage de mots</b> vous permet de filtrer les mots dont vous voulez interdire l'usage sur votre forum.";
$lang['adminexp_12'] = "<b>Statistiques de postage</b> produit un rapport des 10 posteurs les plus prolifiques durant une p�riode de temps d�finie.";
$lang['adminexp_13'] = "<b>Liens de Forums</b> permet la gestion de la liste d�roulante verticale de liens dans la barre de navigation.";
$lang['adminexp_14'] = "<b>Visualiser le fichier journal</b> permet de voir chacune des actions r�centes prises par les mod�rateurs du forum.";
$lang['adminexp_15'] = "<b>Gestion du forum</b> permet la cr�ation, suppression, fermeture et r�ouverture des forums.";
$lang['adminexp_16'] = "<b>Options de forum globales</b> vous permet de modifier les options qui touchent tous les forums.";
$lang['adminexp_17'] = "<b>File d'attente de postes � approuver</b> vous permet de voir tous messages en attente d'approbation par un mod�rateur.";
$lang['adminexp_18'] = "<b>Fichier journal des visiteurs</b> vous permet de voir une liste d�taill�e des visiteurs, y inclut leur r�f�rent HTTP.";
$lang['createforumstyle'] = "Cr�er un style pour le forum";
$lang['newstylesuccessfullycreated'] = "Nouveau style %s cr�� avec succ�s.";
$lang['stylealreadyexists'] = "Un style avec ce nom de fichier existe d�j�.";
$lang['stylenofilename'] = "Vous n'avez pas entrer un nom de fichier pour enregistrer ce style.";
$lang['stylenodatasubmitted'] = "Impossible de lire les donn�es du style de forum.";
$lang['styleexp'] = "Utiliser cette page pour vous aider � cr�er un style g�n�r� al�atoirement pour votre forum.";
$lang['stylecontrols'] = "Contr�les";
$lang['stylecolourexp'] = "Cliquer sur une couleur pour cr�er un nouveau stylesheet bas� sur cette couleur. La couleur de base courrante est en t�te de liste.";
$lang['standardstyle'] = "Style Standard";
$lang['rotelementstyle'] = "Style d'�l�ment invers�";
$lang['randstyle'] = "Style al�atoire";
$lang['thiscolour'] = "Cette Couleur";
$lang['enterhexcolour'] = "ou entrer une couleur hex pour servir de base pour un nouveau stylesheet.";
$lang['savestyle'] = "Enregistrer ce style";
$lang['styledesc'] = "Desc. de Style";
$lang['fileallowedchars'] = "(lettres bas de casse (a-z), chiffres (0-9) et soulignement (_) seulement)";
$lang['stylepreview'] = "Aper�u du style";
$lang['welcome'] = "Bienvenue";
$lang['messagepreview'] = "Aper�u du message";
$lang['users'] = "Utilisateurs";
$lang['usergroups'] = "Groupes d'utilisateurs";
$lang['mustentergroupname'] = "Vous devez inclure un nom de groupe";
$lang['profiles'] = "Profiles";
$lang['manageforums'] = "Organiser les forums";
$lang['forumsettings'] = "Options de forum";
$lang['globalforumsettings'] = "Options de forum globales";
$lang['settingsaffectallforumswarning'] = "<b>Note:</b> Ces options affectent tous les forums. En cas de duplication d'un ou plusieurs option sur la page d'options d'un forum individuel, ces options prendront pr�c�dence sur les options que vous changez ici.";
$lang['startpage'] = "Page de d�marrage";
$lang['startpageerror'] = "Votre page de d�marrage n'a pas pu �tre entregistrer locallement sur le serveur � cause de d�ni de permission. Pour modifier votre page de d�marrage, SVP cliquer le bouton de t�l�chargement ci-dessous qui vous invitera � enregister le fichier sur votre disque dur. Vous pourriez par la suite t�l�verser ce fichier vers le dossier %s sur votre serveur. SVP noter que certains navigateurs web pourraient changer le nom du fichier sur t�l�chargement. Lorsque vous t�l�versez le fichier, SVP vous assurer de le nommer start_main.php sinon les modifications n'appara�tront pas.";
$lang['failedtoopenmasterstylesheet'] = "Votre style de forum n'a pas pu �tre enregistr� parce que la feuille de style ma�tresse n'a pas pu �tre charg�e. Pour enregistrer votre style, la feuille de style ma�tresse (make_style.css) doit �tre situ�e dans le r�pertoire styles de votre installation Beehive Forum.";
$lang['makestyleerror'] = "Votre style de forum n'a pas pu �tre sauvegarder localement sur le serveur parce que la permission a �t� refus�e. Pour sauvegarder votre style de forum, cliquer le bouton de t�l�chargement ci-dessous ce qui vous invitera � sauvegarder le fichier sur votre lecteur de disque dur. Vous pouvez ensuite t�l�verser ce fichier � votre serveur dans le dossier %s et si n�c�ssaire, cr�ant la structure de dossier en m�me temps. SVP noter que certains navigateurs web changeront peut-�tre le nom du fichier sur t�l�chargement. Lors du t�l�versement de ce fichier, SVP vous assurer qu'il est nomm� style.css sinon ce style de forum sera inutilisable.";
$lang['uploadfailed'] = "Votre nouvelle page de d�marrage n'a pas pu �tre t�l�vers�e au serveur � cause de d�ni de permission. SVP v�rifier que le serveur web / processus PHP est capable d'�crire au dossier %s sur votre serveur.";
$lang['forumstyle'] = "Style du forum";
$lang['wordfilter'] = "Filtre des mots";
$lang['forumlinks'] = "Liens de forum";
$lang['viewlog'] = "Visualiser fichier journal";
$lang['noprofilesectionspecified'] = "Aucune section de profile sp�cifi�e.";
$lang['itemname'] = "Nom d'item";
$lang['moveto'] = "D�placer vers";
$lang['manageprofilesections'] = "Organiser la section profile";
$lang['sectionname'] = "Nom de section";
$lang['items'] = "Items";
$lang['mustspecifyaprofilesectionid'] = "Vous devez sp�cifier une identification pour la section du profil";
$lang['mustsepecifyaprofilesectionname'] = "Vous devez sp�cifier un nom pour la section du profil";
$lang['successfullyeditedprofilesection'] = "Modification de la section du profil r�ussie";
$lang['addnewprofilesection'] = "Ajouter une nouvelle section au profil";
$lang['mustsepecifyaprofilesectionname'] = "Vous devez sp�cifier un nom pour la section du profil";
$lang['successfullyremovedselectedprofilesections'] = "Sections du profil s�lectionn�es supprimer avec succ�s";
$lang['failedtoremoveprofilesections'] = "La suppression des sections du profil a �chou�";
$lang['viewitems'] = "Visualiser les items";
$lang['successfullyremovedselectedprofileitems'] = "La suppression des sections du profil selectionn�es r�ussi";
$lang['failedtoremoveprofileitems'] = " La suppression  des items du profil a �chou�";
$lang['noexistingprofileitemsfound'] = "Il n'y a pas d'items de profil existants dans cette section. Pour ajouter un item de profil, cliquer le bouton ci-dessous.";
$lang['edititem'] = "Modifier l'item";
$lang['invaliditemidoritemnotfound'] = "Identification d'item non valide ou item non trouv�";
$lang['addnewitem'] = "Ajouter un nouveau item";
$lang['startpageupdated'] = "Page de d�marrage mise � jour";
$lang['viewupdatedstartpage'] = "Visualiser la page de d�marrage mise � jour";
$lang['editstartpage'] = "Modifier la page de d�marrage";
$lang['nouserspecified'] = "Aucun utilisateur de sp�cifi�";
$lang['manageuser'] = "G�rer l'utilisateur";
$lang['manageusers'] = "G�rer les utilisateurs";
$lang['userstatus'] = "Statut de l'utilisateur";
$lang['userdetails'] = "D�tails d'utilisateur";
$lang['warning_caps'] = "MISE EN GARDE";
$lang['userdeleteallpostswarning'] = "�tes-vous certain de vouloir supprimer tous les messages de l'utilisateur s�lectionn�? Une fois supprim�s, les messages ne peuvent �tre r�cup�r�s et seront perdus pour toujours.";
$lang['postssuccessfullydeleted'] = "Suppression de messages r�ussie.";
$lang['folderaccess'] = "Acc�s aux dossiers";
$lang['possiblealiases'] = "Pseudonymes possibles";
$lang['userhistory'] = "Historique de l'usager";
$lang['nohistory'] = "Aucun rapport d'historique sauvegarder";
$lang['userhistorychanges'] = "Changements";
$lang['clearuserhistory'] = "Effacer l'historique de l'usager";
$lang['changedlogonfromto'] = "Changement de la session d'ouverture de %s � %s";
$lang['changednicknamefromto'] = "Changement du pseudonyme de %s � %s";
$lang['changedemailfromto'] = "Changement de l'adresse courriel de %s � %s";
$lang['usersettingsupdated'] = "La mise � jour des options d'utilisateurs r�ussie.";
$lang['nomatches'] = "Aucune correspondance trouv�e.";
$lang['deleteposts'] = "Supprimer les messages";
$lang['deleteallusersposts'] = "Supprimer tous les messages de cet utilisateur";
$lang['noattachmentsforuser'] = "Aucun fichier joint pour cet utilisateur";
$lang['forgottenpassworddesc'] = "Si cet utilisateur a oubli� leur mot de passe, vous pouvez le r�initialiser ici.";
$lang['manageusersexp'] = "Cette liste d�montre une s�lection d'utilisateurs qui ont ouvert une session sur votre forum, tri�e par %s. Pour modifier les droits d'acc�s d'un utilisateur, cliquer sur leur nom.";
$lang['userfilter'] = "Filtre des usagers";
$lang['onlineusers'] = "Usagers en ligne";
$lang['offlineusers'] = "Usagers hors ligne";
$lang['usersawaitingapproval'] = "Usagers en attente d'approbation";
$lang['bannedusers'] = "Usagers bannis";
$lang['lastlogon'] = "Derni�re ouverture de session";
$lang['sessionreferer'] = "Orienteur de session";
$lang['signupreferer'] = "Orienteur d'enregistrement:";
$lang['nouseraccountsmatchingfilter'] = "Aucun compte d'usager assortissant avec le filtre";
$lang['searchforusernotinlist'] = "Chercher pour un utilisateur qui n'est pas sur la liste";
$lang['adminaccesslog'] = "Fichier journal d'acc�s admin";
$lang['adminlogexp'] = "Liste des derni�res actions sanctionn�es par les utilisateurs avec les droits d'acc�s admin.";
$lang['datetime'] = "Date/Heure";
$lang['unknownuser'] = "Utilisateur inconnu";
$lang['unknownfolder'] = "Dossier inconnu";
$lang['ip'] = "IP";
$lang['lastipaddress'] = "Derni�re adresse IP";
$lang['logged'] = "Journalis�";
$lang['notlogged'] = "Non journalis�";
$lang['addwordfilter'] = "Ajouter filtre de mots";
$lang['addnewwordfilter'] = "Ajouter nouveau filtre de mots";
$lang['wordfilterupdated'] = "Mise � jour du filtre de mots";
$lang['filtername'] = "Filter Name";
$lang['filtertype'] = "Type de filtre";
$lang['filterenabled'] = "Filter Enabled";
$lang['editwordfilter'] = "Modifier le filtre de mots";
$lang['nowordfilterentriesfound'] = "Aucune entr�e de filtre des mots existante trouv�e. Pour ajouter un filtre des mots, cliquez le bouton ci-dessous.";
$lang['mustspecifymatchedtext'] = "Vous devez sp�cifier le texte appari�";
$lang['mustspecifyfilteroption'] = "Vous devez sp�cifier une option de filtre";
$lang['mustspecifyfilterid'] = "Vous devez sp�cifier une identification de filtre";
$lang['invalidfilterid'] = "Identification de filtre invalide";
$lang['failedtoupdatewordfilter'] = "Mise � jour du filtre des mots �chou�e.  V�rifiez que le filtre existe toujours.";
$lang['allow'] = "Permettre";
$lang['normalthreadsonly'] = "Fils de discussion normales uniquement";
$lang['pollthreadsonly'] = "Fils de discussion avec scrutins uniquement";
$lang['both'] = "Les deux types de fils de discussion permis";
$lang['existingpermissions'] = "Droits d'acc�s existants";
$lang['nousers'] = "Aucun utilisateur";
$lang['searchforuser'] = "Chercher pour utilisateur";
$lang['browsernegotiation'] = "N�goci� par navigateur web";
$lang['largetextfield'] = "Gros champ de texte";
$lang['mediumtextfield'] = "Champ de texte moyen";
$lang['smalltextfield'] = "Petit champ de texte";
$lang['multilinetextfield'] = "Champ de texte multiligne";
$lang['radiobuttons'] = "Cases d'option";
$lang['dropdown'] = "D�roulant vertical";
$lang['threadcount'] = "D�nombrement des fils de discussion";
$lang['fieldtypeexample1'] = "Pour les cases d'option et les champs d�roulants verticaux vous devez s�parer le nom de champ et les valeurs avec un deux-points et chaque valeur doit �tre s�par�e par un point-virgule.";
$lang['fieldtypeexample2'] = "Example: Pour cr�er des cases d'option pour le sexe, avec deux s�lections pour Homme et Femme, inscrire: <b>Sexe:Homme;Femme</b> dans le champ Nom d'Item.";
$lang['editedwordfilter'] = "Filtre de mots modifi�";
$lang['editedforumsettings'] = "Options de forum modifi�s";
$lang['sessionsuccessfullyended'] = "Terminaison de session r�ussie pour l'utilisateur";
$lang['matchedtext'] = "Texte correspondant";
$lang['replacementtext'] = "Texte de remplacement";
$lang['preg'] = "PREG";
$lang['wholeword'] = "Mot complet";
$lang['word_filter_help_1'] = "<b>Tous</b> recherche correspondances contre le texte complet alors le filtrage de c � c'est changera incidence � inc'estidenc'este.";
$lang['word_filter_help_2'] = "<b>Mot complet</b> recherche correspondance avec le mot complet seulement alors le filtrage de c � c'est ne changera PAS incidence � inc'estidenc'este.";
$lang['word_filter_help_3'] = "<b>PREG</b> permet l'utilisation des Regular Expressions du langage Perl pour trouver des correspondances de texte";
$lang['nameanddesc'] = "Nom et Description";
$lang['movethreads'] = "D�placer fils de discussion";
$lang['threadsmovedsuccessfully'] = "D�placement de fils de discussion r�ussie";
$lang['movethreadstofolder'] = "D�placer fils de discussion au dossier";
$lang['resetuserpermissions'] = "R�initialiser les permissions d'utilisateur";
$lang['userpermissionsresetsuccessfully'] = "R�initialisation des permissions d'utilisateur r�ussie";
$lang['allowfoldertocontain'] = "Permettre au dossier de contenir";
$lang['addnewfolder'] = "Ajouter nouveau dossier";
$lang['mustenterfoldername'] = "Vous devez inscrire un nom de dossier";
$lang['nofolderidspecified'] = "Aucune identification de dossier d�finie";
$lang['invalidfolderid'] = "Identification de dossier invalide. V�rifier qu'un dossier avec cette identification existe!";
$lang['successfullyaddedfolder'] = "Ajout de dossier r�ussi";
$lang['successfullydeletedfolder'] = "Suppression de dossier r�ussie";
$lang['failedtodeletefolder'] = "La suppression du dossier a �chou�.";
$lang['folderupdatedsuccessfully'] = "Mise � jour du dossier r�ussie";
$lang['cannotdeletefolderwiththreads'] = "Impossible de supprimer les dossiers contenant toujours des fils de discussion.";
$lang['forumisnotrestricted'] = "Forum n'est pas limit�";
$lang['groups'] = "Groupes";
$lang['nousergroups'] = "Aucun groupe d'utilisateur �tablit";
$lang['suppliedgidisnotausergroup'] = "L'identification de group fournie n'est pas un groupe d'utilisateur";
$lang['manageusergroups'] = "Organiser les groupes d'utilisateurs";
$lang['groupstatus'] = "Statut de groupe";
$lang['addusergroup'] = "Ajouter groupe";
$lang['addremoveusers'] = "Ajouter/enlever utilisateurs";
$lang['nousersingroup'] = "Il n'y a pas d'utilisateurs dans ce groupe";
$lang['useringroups'] = "Cet utilisateur est membre des groupes suivants";
$lang['usernotinanygroups'] = "Cet utilisateur n'est pas dans aucun groupe d'utilisateurs";
$lang['usergroupwarning'] = "Note: Cet utilisateur pourrait accumuler les droits d'acc�s suppl�mentaires de un ou plusieurs des groupes d'utilisateurs �num�r�s ci-dessous.";
$lang['successfullyaddedgroup'] = "Ajout de groupe r�ussie";
$lang['successfullydeletedgroup'] = "Suppression de groupe r�ussie";
$lang['usercanaccessforumtools'] = "L'utilisateur peut acc�der aux outils du forum et peut cr�er, supprimer et modifier les forums";
$lang['usercanmodallfoldersonallforums'] = "L'utilisateur peut mod�rer tous les dossiers sur tous les forums";
$lang['usercanmodlinkssectiononallforums'] = "L'utilisateur peut mod�rer la section des liens sur tous les forums";
$lang['emailconfirmationrequired'] = "Confirmation par courriel requis";
$lang['userisbannedfromallforums'] = "Usager est banni de <b>tous les forums</b>";
$lang['cancelemailconfirmation'] = "Annuler confirmation par courriel et permettre l'utilisateur de poster";
$lang['resendconfirmationemail'] = "Renvoyer confirmation par courriel � l'utilisateur";
$lang['donothing'] = "Ne faites rien";
$lang['usercanaccessadmintools'] = "L'utilisateur a acc�s aux outils admin du forum";
$lang['usercanaccessadmintoolsonallforums'] = "L'utilisatieur a acc�s aux outils admin <b>sur tous les forums</b>";
$lang['usercanmoderateallfolders'] = "L'utilisateur peut mod�rer tous les dossiers";
$lang['usercanmoderatelinkssection'] = "L'utilisateur peut mod�rer la section des Liens";
$lang['userisbanned'] = "L'utilisateur est banni";
$lang['useriswormed'] = "L'utilisateur est parasit�";
$lang['userispilloried'] = "L'utilisateur est clou� au pilori";
$lang['usercanignoreadmin'] = "L'utilisateur peut ignorer les administrateurs";
$lang['groupcanaccessadmintools'] = "Groupe peut acc�der aux outils admin";
$lang['groupcanmoderateallfolders'] = "Groupe peut mod�rer tous les dossiers";
$lang['groupcanmoderatelinkssection'] = "Groupe peut mod�rer la section des Liens";
$lang['groupisbanned'] = "Groupe est banni";
$lang['groupiswormed'] = "Groupe est parasit�";
$lang['readposts'] = "Lire messages";
$lang['replytothreads'] = "R�pondre aux fils de discussion";
$lang['createnewthreads'] = "Cr�er nouveaux fils de discussion";
$lang['editposts'] = "R�viser messages";
$lang['deleteposts'] = "Supprimer les messages";
$lang['uploadattachments'] = "T�l�verser fichiers joints";
$lang['moderatefolder'] = "Mod�rer le dossier";
$lang['postinhtml'] = "Poster en HTML";
$lang['postasignature'] = "Poster une signature";
$lang['editforumlinks'] = "Modifier les Liens de Forum";
$lang['editforumlinks_exp'] = "Utiliser cette page pour l'ajout de liens � la liste d�roulante verticale affich�e au dessus-droit du cadre du forum. Si aucun lien est positionn�, la liste d�roulante verticale ne sera pas afficher.";
$lang['notoplevellinktitlespecified'] = "Aucun titre le lien de niveau sup�rieur d'indiqu�";
$lang['toplinktitlesuccessfullyupdated'] = "Mise � jour du titre du lien de premier niveau r�ussi";
$lang['youmustenteralinktitle'] = "Vous devez entrer un titre de lien";
$lang['alllinkurismuststartwithaschema'] = "Tous URIs de liens doivent commenc�s avec un sch�ma (i.e. http://, ftp://, irc://)";
$lang['noexistingforumlinksfound'] = "Il n'y a pas de liens de forum existants. Pour ajouter un lien de forum, cliquez le bouton ci-dessous.";
$lang['editlink'] = "Modifier lien";
$lang['addnewforumlink'] = "Ajouter nouveau lien de forum";
$lang['forumlinktitle'] = "Titre du lien de forum";
$lang['forumlinklocation'] = "Localisation du lien de forum";
$lang['successfullyaddedlink'] = "Ajout du lien r�ussi: '%s'";
$lang['successfullyeditedlink'] = "Modification du lien r�ussi: '%s'";
$lang['invalidlinkidorlinknotfound'] = "Identification du lien invalide ou lien introuvable";
$lang['successfullyremovedselectedlinks'] = "La suppression des liens s�lectionn�s r�ussi";
$lang['failedtoremovelinks'] = "La suppression des liens s�lectionn�s a �chou�";
$lang['failedtoaddnewlink'] = "Ajout du nouveau lien non-r�ussi: '%s'";
$lang['failedtoupdatelink'] = "Mise � jour du lien �chou�e: '%s'";
$lang['toplinkcaption'] = "L�gende du lien de premier niveau";
$lang['allowguestaccess'] = "Permettre l'acc�s aux visiteurs";
$lang['searchenginespidering'] = "Balayage par moteurs de recherche";
$lang['allowsearchenginespidering'] = "Permettre le balayage par moteurs de recherche";
$lang['newuserregistrations'] = "Enregistrement de nouveaux utilisateurs";
$lang['preventduplicateemailaddresses'] = "Emp�cher adresses courriel en double";
$lang['allownewuserregistrations'] = "Permettre l'enregistrement de nouveaux utilisateurs";
$lang['requireemailconfirmation'] = "Exiger confirmation par courriel";
$lang['usetextcaptcha'] = "Utiliser Captcha de texte";
$lang['textcaptchadir'] = "R�pertoire de captcha de texte";
$lang['textcaptchakey'] = "Cl� de captcha de texte";
$lang['textcaptchafonterror'] = "Le Captcha de texte a �t� d�sactiv� automatiquement parce qu'il n'y a pas de polices truetype de disponible pour son usage. SVP t�l�verser des polices truetype � <b>%s</b> sur votre serveur.";
$lang['textcaptchadirerror'] = "Le Captcha de texte a �t� d�sactiv� parce que le r�pertoire text_captcha and ses sous-r�pertoires ne sont pas inscriptibles part le serveur web / processus PHP.";
$lang['textcaptchagderror'] = "Le Captcha de texte a �t� d�sactiv� parce que le r�glage PHP de votre serveur ne fournit pas de support pour la manipulation d'image GD et / ou de support pour les polices TTF. Les deux sont requis pour supporter le captcha de texte.";
$lang['textcaptchadirblank'] = "Le r�pertoire de captcha de texte est vierge!";
$lang['newuserpreferences'] = "Pr�f�rences du nouveau utilisateur";
$lang['sendemailnotificationonreply'] = "Avertissement par courriel sur r�ponse � l'utilisateur";
$lang['sendemailnotificationonpm'] = "Avertissement par courriel sur MP � l'utilisateur";
$lang['showpopuponnewpm'] = "Afficher fen�tre contextuelle sur r�ception de nouveau MP";
$lang['setautomatichighinterestonpost'] = "�tablir int�r�t �lev� automatique sur postage";
$lang['top20postersforperiod'] = "Les 20 posteurs les plus prolifiques pour la p�riode %s � %s";
$lang['postingstats'] = "Statistiques de postage";
$lang['nodata'] = "Aucune donn�e";
$lang['totalposts'] = "Contributions totales";
$lang['totalpostsforthisperiod'] = "Contributions totales pour cette p�riode";
$lang['mustchooseastartday'] = "Doit choisir un jour de d�but";
$lang['mustchooseastartmonth'] = "Doit choisir un mois de d�but";
$lang['mustchooseastartyear'] = "DOit choisir une ann�e de d�but";
$lang['mustchooseaendday'] = "Doit choisir un jour de fin";
$lang['mustchooseaendmonth'] = "Doit choisir un mois de fin";
$lang['mustchooseaendyear'] = "Doit choisir une ann�e de fin";
$lang['startperiodisaheadofendperiod'] = "P�riode de d�but devance la p�riode de fin";
$lang['bancontrols'] = "Contr�les de bannissement";
$lang['addban'] = "Ajouter bannissement";
$lang['checkban'] = "V�rifier bannissement";
$lang['editban'] = "Modifier bannissement";
$lang['bantype'] = "Type de bannissement";
$lang['bandata'] = "Donn�es de bannissement";
$lang['bancomment'] = "Commentaire";
$lang['ipban'] = "Bannissement par IP";
$lang['logonban'] = "Bannissement par ouverture de session";
$lang['nicknameban'] = "Bannissement par pseudonyme";
$lang['emailban'] = "Bannissement par adresse de courriel";
$lang['refererban'] = "Bannissement par site orienteur";
$lang['invalidbanid'] = "Bannissement d'identit� invalide";
$lang['affectsessionwarnadd'] = "Ce bannissment pourrait affecter les sessions d'utilisateurs actives suivantes";
$lang['noaffectsessionwarn'] = "Ce banissement n'affecte aucune session active";
$lang['mustspecifybantype'] = "Vous devez indiquer un type de bannissement";
$lang['mustspecifybandata'] = "Vous devez indiquer des donn�es de bannissement";
$lang['successfullyremovedselectedbans'] = "Lever de bannissements s�lectionn�s r�ussi";
$lang['failedtoaddnewban'] = "Ajout de nouveau bannissement �chou�";
$lang['failedtoremovebans'] = "Lever de certains ou de tous les bannissment s�lectionn�s �chou�";
$lang['duplicatebandataentered'] = "Donn�es de bannissement entrer en double. V�rifiez vos caract�res de remplacement pour voir s'ils s'accordent avec les donn�es entr�es";
$lang['successfullyaddedban'] = "Ajout de bannissement r�ussi";
$lang['successfullyupdatedban'] = "Mise � jour du bannissement r�ussi";
$lang['noexistingbandata'] = "Il n'y a pas de donn�es de bannissement existantes. Pour ajouter des donn�es de bannissement, veuillez cliquer le bouton ci-dessous.";
$lang['youcanusethepercentwildcard'] = "Vous pouvez utiliser le caract�re de remplacement pourcentage (%) dans n'importe quelle liste de bannissement afin d'obtenir des correspondances partielles, ex. '192.168.0.%' bannirait toutes les adresses IP dans la gamme de 192.168.0.1 � travers 192.168.0.254</p>\n ";
$lang['cannotusewildcardonown'] = "Vous ne pouvez pas ajouter % comme concordance de caract�re de remplacement seul!";
$lang['requirepostapproval'] = "Exiger approbation du message";
$lang['adminforumtoolsusercounterror'] = "Il doit y avoir au moins un utilisateur avec acc�s aux outils admin et aux outils de forum sur tous les forums!";
$lang['postcount'] = "Compte de postes";
$lang['resetpostcount'] = "R�initialisation du compte de postes";
$lang['postapprovalqueue'] = "File d'attente d'approbation de messages";
$lang['nopostsawaitingapproval'] = "Aucun message en attente d'approbation";
$lang['approveselected'] = "Approuver s�lectionn�(s)";
$lang['successfullyapproveduser'] = "Approbation de l'usager r�ussi";
$lang['kickselected'] = "�jecter s�lectionn�";
$lang['visitorlog'] = "Feuille de contr�le des visiteurs";
$lang['novisitorslogged'] = "Aucun visiteur journalis�";
$lang['addselectedusers'] = "Ajouter usagers s�lectionn�s";
$lang['removeselectedusers'] = "Enlever usagers s�lectionn�s";
$lang['addnew'] = "Ajouter nouveau";
$lang['deleteselected'] = "Supprimer s�lectionn�";
$lang['noprofilesectionsfound'] = "Il n'y a aucune section de profil existante. Pour ajouter une section de profil, cliquez le bouton ci-dessous.";
$lang['addnewprofilesection'] = "Ajouter une nouvelle section au profil";
$lang['successfullyaddedsection'] = "Ajout de la section r�ussi";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "A chang� le statut d'utilisateur pour '%s'";
$lang['changedpasswordforuser'] = "A chang� mot de passe pour '%s'";
$lang['changedforumaccess'] = "A chang� droits d'acc�s au forum pour '%s'";
$lang['deletedallusersposts'] = "A supprim� tous les messages pour '%s'";

$lang['createdusergroup'] = "A cr�� groupe d'utilisateurs '%s'";
$lang['deletedusergroup'] = "A supprim� groupe d'utilisateurs '%s'";
$lang['updatedusergroup'] = "A mise � jour le groupe d'utilisateurs '%s'";
$lang['addedusertogroup'] = "A ajout� l'utilisateur '%s' au groupe '%s'";
$lang['removeduserfromgroup'] = "A enlev� l'utilisateur '%s' du groupe '%s'";

$lang['addedipaddresstobanlist'] = "A ajout� IP '%s' � la liste de bannissement";
$lang['removedipaddressfrombanlist'] = "A enlev� IP '%s' de la liste de bannissement";

$lang['addedlogontobanlist'] = "A ajout� le nom d'utilisateur '%s' � la liste de bannissement";
$lang['removedlogonfrombanlist'] = "A enlev� le nom d'utilisateur '%s' de la liste de bannissement";

$lang['addednicknametobanlist'] = "A ajout� le pseudonyme '%s' � la liste de bannissement";
$lang['removednicknamefrombanlist'] = "A enlev� le pseudonyme '%s' de la liste de bannissement";

$lang['addedemailtobanlist'] = "A ajout� l'adresse courriel '%s' � la liste de bannissement";
$lang['removedemailfrombanlist'] = "A enlev� l'adresse courriel '%s' de la liste de bannissement";

$lang['addedreferertobanlist'] = "Ajouter le site orienteur '%s' � la liste de bannissement";
$lang['removedrefererfrombanlist'] = "Enlev� le site orienteur '%s' de la liste de bannissement";

$lang['editedfolder'] = "A modifi� dossier '%s'";
$lang['movedallthreadsfromto'] = "A d�plac� tous les fils de discussion de '%s' � '%s'";
$lang['creatednewfolder'] = "A cr�� nouveau dossier '%s'";
$lang['deletedfolder'] = "A supprim� le dossier '%s'";

$lang['changedprofilesectiontitle'] = "A chang� le titre de section de Profil de '%s' � '%s'";
$lang['addednewprofilesection'] = "A ajout� une nouvelle section de Profil '%s'";
$lang['deletedprofilesection'] = "A supprim� une section de Profil '%s'";

$lang['addednewprofileitem'] = "A ajout� un nouveau item de Profil '%s' � la section '%s'";
$lang['changedprofileitem'] = "A chang� l'item de Profil '%s'";
$lang['deletedprofileitem'] = "A supprim� l'item de Profil '%s'";

$lang['editedstartpage'] = "A modifi� la page de d�marrage";
$lang['savednewstyle'] = "A enregistr� le nouveau style '%s'";

$lang['movedthread'] = "A d�plac� le fil de discussion '%s' de '%s' � '%s'";
$lang['closedthread'] = "A ferm� le fil de discussion '%s'";
$lang['openedthread'] = "A ouvert le fil de discussion '%s'";
$lang['renamedthread'] = "A renomm� le fil de discussion '%s' de '%s'";

$lang['deletedthread'] = "A supprim� le fil de discussion '%s'";
$lang['undeletedthread'] = "Fils de discussion non-supprim� '%s'";

$lang['lockedthreadtitlefolder'] = "A verrouill� les options de fil de discussion sur '%s'";
$lang['unlockedthreadtitlefolder'] = "A d�verrouill� les options de fil de discussion sur '%s'";

$lang['deletedpostsfrominthread'] = "A supprim� les messages de '%s' dans fil de discussion '%s'";
$lang['deletedattachmentfrompost'] = "A supprim� le fichier joint '%s' du message '%s'";

$lang['editedforumlinks'] = "A modifi� les liens de forum";
$lang['editedforumlink'] = "Modification du lien de forum: '%s'";

$lang['addedforumlink'] = "Ajout de lien de forum: '%s'";
$lang['deletedforumlink'] = "Suppression de lien de forum: '%s'";
$lang['changedtoplinkcaption'] = "Changement de la l�gende du lien de premier niveau de '%s' � '%s'";

$lang['deletedpost'] = "A supprim� le message '%s'";
$lang['editedpost'] = "A r�vis� le message '%s'";

$lang['madethreadsticky'] = "A rendu le fil de discussion '%s' collant";
$lang['madethreadnonsticky'] = "A rendu le fil de discussion '%s' non-collant";

$lang['endedsessionforuser'] = "A termin� la session pour l'utilisateur '%s'";

$lang['approvedpost'] = "A approuv� le message '%s'";

$lang['editedwordfilter'] = "Filtre de mots modifi�";

$lang['addedrssfeed'] = "Ajout� source de donn�es RSS '%s'";
$lang['editedrssfeed'] = "Modifi� source de donn�es RSS '%s'";
$lang['deletedrssfeed'] = "Supprim� source de donn�es RSS '%s'";

$lang['updatedban'] = "Mise-�-jour du bannissement '%s'. '%s' � '%s', '%s' � '%s'.";

$lang['splitthreadatpostintonewthread'] = "Disperser le fils de discussion '%s' au message %s  en un nouvel fils de discussion '%s'";
$lang['mergedthreadintonewthread'] = "Fils de discussion '%s' et '%s' fusionn�s en un nouvel fils de discussion '%s'";

$lang['approveduser'] = "Usager approuv� '%s'";

$lang['adminlogempty'] = "Fiche journalier admin est vide";
$lang['clearlog'] = "Vider fiche journalier";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "Aucun forum existent retrouv�. Pour cr�er un nouveau forum, cliquez le bouton ci-dessous.";
$lang['webtaginvalidchars'] = "Balise d'adresse web peut contenir des caract�res capitales A-Z, 0-9, _ - uniquement";
$lang['databasenameinvalidchars'] = "Le nom de la base de donn�es ne peut inclure les caract�res a-z, A-Z, 0-9 et le soulignement";
$lang['invalidforumidorforumnotfound'] = "Identification du forum (FID) invalide ou non trouv�e";
$lang['successfullyupdatedforum'] = "Mise � jour du forum: '%s' r�ussie ";
$lang['failedtoupdateforum'] = " Mise � jour du forum: '%s' �chou�e";
$lang['successfullycreatedforum'] = "Cr�ation de forum r�ussie";
$lang['failedtocreateforum'] = "La creation du forum '%s' n'est pas r�ussie. Veuillez v�rifier que le l'identification du forum (webtag) et les noms des tables ne sont pas d�j� en usage.";
$lang['forumdeleteconfirmation'] = "�tes-vous certain de vouloir supprimer tous les forums selections?";
$lang['forumdeletewarning'] = "�tes-vous certain de vouloir supprimer le forum s�lectionn�? Une fois le forum supprim�, le contenu est perdu pour toujours et ne peut pas �tre r�cup�r�.";
$lang['successfullydeletedforum'] = "Suppression du forum: '%s' r�ussie";
$lang['failedtodeleteforum'] = "Suppression du forum: '%s' �chou�";
$lang['addforum'] = "Ajouter forum";
$lang['editforum'] = "Modifier forum";
$lang['visitforum'] = "Visiter forum: %s";
$lang['accesslevel'] = "Niveau d'acc�s";
$lang['usedatabase'] = "Utiliser la base de donn�es";
$lang['unknownmessagecount'] = "Inconnu";
$lang['forumwebtag'] = "Identification (webtag) du forum";
$lang['defaultforum'] = "Forum par d�faut";
$lang['forumdatabasewarning'] = "Veuillez vous assurer que vous avez choisit la bonne base de donn�es lors de la cr�ation d'un nouveau forum. Une fois cr��, un nouveau forum ne peut pas �tre d�plac� entre les bases de donn�es disponibles.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "droits d'acc�s d'utilisateur globaux";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "Vous devez indiquer une identification (webtag) de forum";
$lang['mustsupplyforumname'] = "Vous devez fournir un nom pour le forum";
$lang['mustsupplyforumemail'] = "Vous devez fournir une adresse courriel pour le forum";
$lang['mustchoosedefaultstyle'] = "Vous devez choisir un style de forum de d�faut";
$lang['mustchoosedefaultemoticons'] = "Vous devez choisir des binettes de forum de d�faut";
$lang['mustsupplyforumaccesslevel'] = "Vous devez indiquer un niveau d'acc�s au forum";
$lang['mustsupplyforumdatabasename'] = "Vous devez indiquer un nom pour la base de donn�es du forum";
$lang['unknownemoticonsname'] = "Nom de binettes inconnu";
$lang['mustchoosedefaultlang'] = "Vous devez choisir un langage de d�faut pour le forum";
$lang['activesessiongreaterthansession'] = "La temporisation de session active ne peut pas exc�der la temporisation de session";
$lang['attachmentdirnotwritable'] = "Le r�pertoire de fichiers joints doit �tre inscriptible par le serveur web / processus PHP!";
$lang['attachmentdirblank'] = "Vous devez fournir un r�pertoire pour l'enregistrement de fichiers joints";
$lang['mainsettings'] = "Options principales";
$lang['forumname'] = "Nom du forum";
$lang['forumemail'] = "Courriel du forum";
$lang['forumdesc'] = "Description du Forum";
$lang['forumkeywords'] = "Mots-cl� du forum";
$lang['defaultstyle'] = "Style de d�faut";
$lang['defaultemoticons'] = "Binettes de d�faut";
$lang['defaultlanguage'] = "Language de d�faut";
$lang['forumaccesssettings'] = "Options d'acc�s du forum";
$lang['forumaccessstatus'] = "Statut d'acc�s au forum";
$lang['changepermissions'] = "Changer droits d'acc�s";
$lang['changepassword'] = "Changer mot de passe";
$lang['passwordprotected'] = "Prot�ger par mot de passe";
$lang['passwordprotectwarning'] = "Vous n'avez pas d�fini un mot de passe pour le forum. Si vous ne d�finissez pas un mot de passe, la fonctionnalit� de protection par mot de passe sera automatiquement d�sactiv�e!";
$lang['postoptions'] = "Options de message";
$lang['allowpostoptions'] = "Permettre la r�vision de message";
$lang['postedittimeout'] = "Temporisation de r�vision de message";
$lang['posteditgraceperiod'] = "P�riode de d�lai de gr�ce pour modification de poste";
$lang['wikiintegration'] = "Int�gration Wiki";
$lang['enablewikiintegration'] = "Activer int�gration WikiWiki";
$lang['enablewikiquicklinks'] = "Activer Quick Links WikiWiki";
$lang['wikiintegrationuri'] = "Adresse WikiWiki";
$lang['maximumpostlength'] = "Longueure de message maximale";
$lang['postfrequency'] = "Fr�quence de postage";
$lang['enablelinkssection'] = "Activer section des Liens";
$lang['allowcreationofpolls'] = "Permettre cr�ation de scrutins";
$lang['allowguestvotesinpolls'] = "Permettre invit�s de voter dans les scrutins";
$lang['unreadmessagescutoff'] = "P�riode limite pour messages non-lus";
$lang['unreadcutoffseconds'] = "secondes";
$lang['disableunreadmessages'] = "D�sactiver messages non-lus";
$lang['nocutoffdefault'] = "Aucune p�riode limite (d�fault)";
$lang['1month'] = "1 mois";
$lang['6months'] = "6 mois";
$lang['1year'] = "1 ans";
$lang['customsetbelow'] = "Valeur personnalis�e (r�gler ci-dessous)";
$lang['searchoptions'] = "Options de recherche";
$lang['searchfrequency'] = "Fr�quence de recherche";
$lang['sessions'] = "Sessions";
$lang['sessioncutoffseconds'] = "Coupure de session (secondes)";
$lang['activesessioncutoffseconds'] = "Coupure de session active (secondes)";
$lang['stats'] = "Statistiques";
$lang['hide_stats'] = "Cacher statistiques";
$lang['show_stats'] = "Montrer Statistiques";
$lang['enablestatsdisplay'] = "Activer affichage des statistiques";
$lang['personalmessages'] = "Messages personnel";
$lang['enablepersonalmessages'] = "Activer messages personnel";
$lang['pmusermessages'] = "MP par utilisateur";
$lang['allowpmstohaveattachments'] = "Permettre fichiers joints dans les messages personnel";
$lang['autopruneuserspmfoldersevery'] = "�laguer automatiquement les dossiers MP de l'utilisateur chaque";
$lang['userandguestoptions'] = "Options d'usagers et de visiteurs";
$lang['enableguestaccount'] = "Activer compte de visiteur";
$lang['listguestsinvisitorlog'] = "Lister les visiteurs dans la liste des derni�res visites";
$lang['allowguestaccess'] = "Permettre l'acc�s aux visiteurs";
$lang['userandguestaccesssettings'] = "Options d'acc�s pour usagers et invit�s";
$lang['allowuserstochangeusername'] = "Permettre aux usagers de changer leur nom d'usager";
$lang['requireuserapproval'] = "Exiger approbation de l'usager par un administrateur";
$lang['enableattachments'] = "Activer fichiers joints";
$lang['attachmentdir'] = "Rep de fichiers joints";
$lang['userattachmentspace'] = "Espace pour fichiers joints par utilisateur";
$lang['allowembeddingofattachments'] = "Permettre l'incorporation de fichiers joints";
$lang['usealtattachmentmethod'] = "Utiliser m�thode alternative pour fichiers joints";
$lang['allowgueststoaccessattachments'] = "Permettre aux invit�s d'avoir acc�s aux fichiers joints";
$lang['forumsettingsupdated'] = "mise � jour des options de forum r�ussie";
$lang['forumstatusmessages'] = "Messages de status du forum";
$lang['forumclosedmessage'] = "Message Forum ferm�";
$lang['forumrestrictedmessage'] = "Message Forum � acc�s restreint";
$lang['forumpasswordprotectedmessage'] = "Message Forum prot�g� par mot de passe";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>D�lai d'attente pour modification de message</b> indique le temps en secondes apr�s avoir poster qu'un utilisateur a pour apporter des modifications � son message. Si �tablit � 0, il n'y a pas de limite.";
$lang['forum_settings_help_11'] = "<b>Longueure maximale du message</b> indique le nombre maximale de caract�res qui seront affich�s dans un message. Si un message d�passe le nombre de caract�res d�fini ici, il sera tronqu� et un hyperlien sera ajout� au pied du message pour permettre aux utilisateurs de le lire au complet sur une page � part.";
$lang['forum_settings_help_12'] = "Si vous ne voulez pas que vos utilisateurs soient capables de cr�er des scrutins, vous pouvez d�sactiver cette option ci-haut.";
$lang['forum_settings_help_13'] = "La section Liens de Beehive permet � vos utilisateurs de maintenir une liste de sites Web qu'ils visitent r�guli�rement et que les autres utilisateurs trouveront peut-�tre utiles. Les hyperliens peuvent �tre divis�s en cat�gories par dossier et �tre commenter et coter. Afin de mod�rer la section liens, un utilisateur doit avoir le statut de mod�rateur globale.";
$lang['forum_settings_help_15'] = "<b>Troncage de session</b> indique le temps maximale avant que la session d'un utilisateur est pr�sum�e inactive et qu'il a ferm� sa session. Par d�faut, ceci est 24 heures (86400 secondes).";
$lang['forum_settings_help_16'] = "<b>Troncage de session active</b> indique le temps maximale avant que la session d'utilisateur est pr�sum�e inactive et qu'elle entre dans un �tat de repos. Dans cet �tat, la session de l'utilisateur demeure ouverte, mais l'utilisateur n'appara�t plus dans la liste d'utilisateurs actifs dans l'affichage des statistiques du forum. Une fois redevenu actif, l'utilisateur sera r�-ajout� � la liste. Par d�faut, cette option est �tablie � 15 minutes (900 secondes).";
$lang['forum_settings_help_17'] = "L'activation de cette option permet � Beehive d'inclure l'affichage des statistiques du forum au pied du sous-fen�tre des messages semblable � ceux utilis�s par plusieurs logiciels de forum. Une fois activ�e, l'affichage des statistiques peut �tre contr�ler par chaque utilisateur. S'ils ne veulent pas le voir, ils peuvent le masquer.";
$lang['forum_settings_help_18'] = "Les Messages Personnels ont une valeur inestimable comme moyen de permettre la discussion de sujets plus personnels hors de la vue des autres utilisateurs. Cependant, si vous ne voulez pas permettre � vos utilisateurs de s'envoyer des MPs, vous pouvez d�sactiver cette option.";
$lang['forum_settings_help_19'] = "Les Messages Personnels peuvent aussi contenir des fichiers joints, ce qui peut faciliter l'�change de fichiers entre utilisateurs.";
$lang['forum_settings_help_20'] = "<b>Note:</b> L'allocation d'espace pour les fichiers joints de MP provient de l'allocation d'espace pour fichiers joints principale de chaque utilisateur et n'est pas un montant additionel. ";
$lang['forum_settings_help_21'] = "Le compte visiteur permet aux personnes qui visitent votre forum de lires les messages sans avoir � cr�er un compte.";
$lang['forum_settings_help_22'] = "Si vous pr�f�rez, vous pouvez aussi r�gler votre forum Beehive pour ouvrir automatiquement une session pour vos visiteurs. Une fois qu'un utilisateur cr�e un compte, l'�cran d'ouverture de session lui sera toujours montr� tant que les t�moins demeureront intactes.";
$lang['forum_settings_help_23'] = "Beehive permet le t�l�versement de fichiers joints dans les messages post�s. Si vous avez un montant d'espace Web limit�, il vous serait peut-�tre pr�f�rable de d�sactiver les fichiers joints en d�cochant la case d'option ci-haut.";
$lang['forum_settings_help_24'] = "<b>Rep de Fichiers Joints</b> est l'endroit o� Beehive devrait enregistrer les fichiers joints. Ce r�pertoire doit exister sur votre espace Web et doit �tre inscriptible par le serveur Web / processus PHP sinon les t�l�versements �choueront.";
$lang['forum_settings_help_25'] = "<b>Espace pour fichiers joints par utilisateur</b> est la taille de l'espace disque maximale mis � la disposition de chaque utilisateur pour les fichiers joints. Une fois complet, l'utilisateur ne peut t�l�verser d'autres fichiers joints. Par d�faut, ils ont chacun 1MB d'espace.";
$lang['forum_settings_help_26'] = "<b>Permettre l'incorporation de fichiers joints dans messages / signatures</b> permet les utilisateurs d'incorporer des fichiers joints dans leurs messages. Quoique utile, une fois activ�e, cette option peut accro�tre dramatiquement votre usage de bande passante sous certaines configurations de PHP. Si vous avez un usage de bande passante limit�, il est recommend� que vous d�sactivez cette option.";
$lang['forum_settings_help_27'] = "<b>Utiliser m�thode alternative pour fichiers joints</b> Cette option force Beehive � utiliser une m�thode alternative pour r�cup�rer les fichiers joints. Si vous recevez des messages d'erreur 404 lorsque vous essay� de t�l�charger des fichiers joints dans les messages, activer cette option.";
$lang['forum_settings_help_28'] = "Cette option permet le balayage de votre forum par les robots de moteurs de recherche tels que Google, Altavista et Yahoo. Si vous d�sactiver cette option, votre forum ne sera pas inclut dans les r�sultats de recherche.";
$lang['forum_settings_help_29'] = "<b>Permettre enregistrement de nouveaux comptes</b> permet ou emp�che la c�ation de nouveaux comptes d'utilisateurs. Si vous le r�gl� � non, le formulaire d'enregistrement sera compl�tement d�sactiv�.";
$lang['forum_settings_help_30'] = "<b>Activer int�gration WikiWiki</b> fournit un support WikiWord dans les messages sur votre forum. Un mot WikiWord consiste de deux ou plusieurs mots concat�n�s avec capitales (qu'on appelle aussi CamelCase). Si vous �crivez un mot de cette fa�on, il sera converti automatiquement en hyperlien pointant � votre Wiki de choix.";
$lang['forum_settings_help_31'] = "<b>Activer hyperliens rapides WikiWiki</b> active l'usage de liens �tendues du style msg:1.1 et User:Logon qui cr�ent des hyperliens au message sp�cifi� / profile d'utilisateur de l'utilisateur sp�cifi�.";
$lang['forum_settings_help_32'] = "<b>Localisation WikiWiki</b> est utilis�e pour sp�cifier le URI de votre WikiWiki. Lorsque vous entrer le URI, utilisez [WikiWord] pour indiquer o� dans le URI le WikiWord devrait appara�tre, i.e.: <i>http://en.wikipedia.org/wiki/[WikiWord]</i> hyperlierait vos WikiWords � %s";
$lang['forum_settings_help_33'] = "<b>Statut d'acc�s au forum</b> contr�le de quelle fa�on les utilisateurs peuvent acc�der � votre forum.";
$lang['forum_settings_help_34'] = "<b>Ouvert</b> permettra � tous les utilisateurs et visiteurs d'avoir acc�s � votre forum sans restrictions.";
$lang['forum_settings_help_35'] = "<b>Ferm�</b> emp�che l'acc�s � tous les utilisateurs, � l'exception des Admins qui pourront toujours acc�der au panneau admin.";
$lang['forum_settings_help_36'] = "<b>Acc�s limit�</b> permet d'�tablir une liste d'utilisateurs qui ont la permission d'acc�der au forum.";
$lang['forum_settings_help_37'] = "<b>Prot�g� par mot de passe</b> vous permet d'�tablir un mot de passe que vous pouvez ensuite donner aux utilisateurs pour qu'ils puissent acc�der au forum.";
$lang['forum_settings_help_38'] = "Lorsque vous r�glez les modes d'Acc�s limit� ou Prot�g� par mot de passe, vous devez enregistrer vos changements avant de changer les privil�ges d'acc�s des utilisateurs ou le mot de passe.";
$lang['forum_settings_help_39'] = "<b>Fr�quence min de recherche</b> d�finit la dur�e de temps qu'un utilisateur doit attendre avant d'initialiser une autre recherche. Les recherches exigent beaucoup de la base de donn�es alors il est recommend� que vous �tablissez cette valeur � aumoins 30 secondes afin d'emp�cher le \"pollupostage par recherche\" de tuer le serveur.";
$lang['forum_settings_help_40'] = "<b>Fr�quence minimale de postage</b> est le temps minimale qu'un utilisateur doit attendre avant qu'il peut poster de nouveau. Cette option affecte aussi la cr�ation de scrutin. R�gler � 0 pour d�sactiver la restriction.";
$lang['forum_settings_help_41'] = "Les options ci-haut modifient les valeurs par d�faut pour le formulaire d'enregistrement de compte. En cas pertinent, certains autres options utiliseront les r�glages par d�faut du forum.";
$lang['forum_settings_help_42'] = "<b>Emp�cher l'usage en double d'adresses courriel</b> force Beehive � v�rifier les comptes d'utilisateur contre l'adresse courriel avec laquelle un utilisateur enregistre son compte et l'invite � choisir un autre si le premier est d�j� en usage.";
$lang['forum_settings_help_43'] = "<b>Exiger confirmation par courriel</b> si activ�, envoyera � chaque nouveau utilisateur un courriel contenant un hyperlien qui peut �tre utilis� pour confirmer leur adresse courriel. Ils ne pourront pas poster tant qu'ils n'auront pas confirmer leur adresse courriel, � moins que leurs privil�ges sont chang�s manuellement par un admin.";
$lang['forum_settings_help_44'] = "<b>Utiliser le Captcha de texte</b> presente le nouveau utilisateur avec une image floue duquel il doit copier un num�ro dans le champ de texte dans le formulaire d'enregistrement. Utiliser cette option afin d'emp�cher les enregistrements via scripts.";
$lang['forum_settings_help_45'] = "<b>R�pertoire de Captcha de texte</b> sp�cifie l'endroit o� Beehive conservera ses images et polices captcha. Ce r�pertoire doit �tre inscriptible par le serveur web / processus PHP et doit �tre accessible via HTTP. Apr�s que vous avez activ� le captcha de texte, vous devez t�l�verser les polices truetype au sous-r�pertoire de votre r�pertoire principale de captcha de texte sinon Beehive sautera le captcha de texte durant l'enregistrement d'utilisateur.";
$lang['forum_settings_help_46'] = "<b>Cl� de Captcha de texte</b> vous permet de changer la cl� utilis�e par Beehive pour g�n�rer le code captcha de texte qui apparait dans l'image. Le plus unique la cl�, le plus difficile que �a devient pour les processus automatis�s de \"deviner\" le code.";
$lang['forum_settings_help_47'] = "<b>P�riode de d�lai de gr�ce pour modification de poste</b> vous permet de d�finir une p�riode en minutes durant laquelle les utilisateurs peuvent modifier leurs messages sans que le texte 'MODIFI� PAR' apparait dans le message. Si r�gler � 0 le texte 'MODIFI� PAR' va toujours para�tre.";
$lang['forum_settings_help_48'] = "<b>P�riode limite pour messages non-lus</b> sp�cifie pour quelle dur�e de temps les messages non-lus seront conserv�s. Vous pouvez choisir entre des valeurs pr�-�tablies ou choisir votre propre p�riode limite en secondes. Les fils de discussion modifi�s ant�rieurement � la p�riode limite d�finie appara�tront automatiquement comme lues.";
$lang['forum_settings_help_49'] = "La s�lection de <b>D�sactiver messages non-lus</b> enl�vera compl�tement tout support pour messages non-lus et enl�vera aussi les options reli�es du menu d�roulant vertical de types de discussions sur la liste des fils de discussions.";
$lang['forum_settings_help_50'] = "Vous pouvez exiger l'approbation de tout nouveau compte d'usager avant qu'il soit utilis� en activant cette fonction. Sans approbation, un usager ne peut acc�der � aucune section de l'installation du forum Beehive, y inclut les forums individuels, la bo�te de r�ception MP et sections Mes Forums.";
$lang['forum_settings_help_51'] = "Utilisez <b>Message de fermeture</b>, <b>Message d'acc�s restreint</b> et <b>Message de prot�g� par mot de passe</b> pour personnaliser le message affich� lorsque les usagers acc�dent au forum dans ses �tats vari�s.";
$lang['forum_settings_help_52'] = "Vous pouvez utiliser le HTML dans vos messages et les hyperliens et les adresses courriel seront automatiquement convertis en hyperliens. Pour utiliser les messages de forum Beehive par d�faut vider les champs de donn�es.";
$lang['forum_settings_help_53'] = "<b>Permettre aux usagers de changer leur nom d'usager</b> permet aux usagers d�j� enregistr�s de changer leur nom d'usager. Lorsque active, vous pouvez suivre les changements effectu�s par un usager � son nom d'usager par moyen des outils administratifs.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "Identification de fichier joint non indiqu�e.";
$lang['upload'] = "T�l�verser";
$lang['uploadnewattachment'] = "T�l�verser nouveau fichier joint";
$lang['waitdotdot'] = "patienter..";
$lang['successfullyuploaded'] = "T�l�versement r�ussi";
$lang['failedtoupload'] = "T�l�versement �chou�";
$lang['complete'] = "Compl�ter";
$lang['uploadattachment'] = "T�l�verser un fichier pour joindre au message";
$lang['enterfilenamestoupload'] = "Entrer nom(s) de fichier(s) � t�l�verser";
$lang['attachmentsforthismessage'] = "Fichiers joints pour ce message";
$lang['otherattachmentsincludingpm'] = "Autres fichiers joints (y inclut messages MP et autres forums)";
$lang['totalsize'] = "Taille totale";
$lang['freespace'] = "Espace libre";
$lang['attachmentproblem'] = "Il y a eu un probl�me avec le t�l�chargement de ce fichier joint. Veuillez essayer de nouveau plus tard.";
$lang['attachmentshavebeendisabled'] = "Les fichiers joints ont �t� d�sactiv�s par le propri�taire du forum.";
$lang['canonlyuploadmaximum'] = "Vous pouvez t�l�verser un maximum de 10 fichiers � la fois";
$lang['deleteattachments'] = "Supprimez fichiers joints";
$lang['deleteattachmentsconfirm'] = "�tes vous certain de vouloir supprimer les fichiers joints s�lectionn�s?";
$lang['deletethumbnailsconfirm'] = "�tes-vous certain de vouloir supprimer les vignettes de pieces jointes s�lectionn�es?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "Mot de passe chang�";
$lang['passedchangedexp'] = "Votre mot de passe a �t� chang�.";
$lang['updatefailed'] = "Mise � jour non-r�ussie";
$lang['passwdsdonotmatch'] = "Les mots de passe ne correspondent pas.";
$lang['allfieldsrequired'] = "Tous les champs sont requis.";
$lang['requiredinformationnotfound'] = "Information requise non trouv�e";
$lang['forgotpasswd'] = "Oublier mot de passe";
$lang['enternewpasswdforuser'] = "Entrer un nouveau mot de passe pour l'utilisateur %s";
$lang['resetpassword'] = "R�initialiser le mot de passe";
$lang['resetpasswordto'] = "Reinitialiser le mot de passe �";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "Aucun message indiqu� pour suppression";
$lang['deletemessage'] = "Supprimer Message";
$lang['postdelsuccessfully'] = "Suppression de message r�ussie";
$lang['errordelpost'] = "Erreur rencontr�e en supprimant le message";
$lang['cannotdeletepostsinthisfolder'] = "Vous ne pouvez pas supprimer vos messages dans ce dossier";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "Aucun message d'indiqu� pour r�vision";
$lang['cannoteditpollsinlightmode'] = "Impossible de modifier les scrutins en mode l�ger";
$lang['editedbyuser'] = "EDITED: %s by %s";
$lang['editappliedtomessage'] = "R�vision appliqu�e au message";
$lang['errorupdatingpost'] = "Erreur rencontr�e durant la mise � jour du message";
$lang['editmessage'] = "R�viser le message %s";
$lang['editpollwarning'] = "<b>Note</b>: La r�vision de certains aspects d'un scrutin annulera tous les votes d�j� enregistr�s et permettra aux utilisateurs de voter de nouveau.";
$lang['hardedit'] = "Options de r�vision forte (votes seront r�initialis�s):";
$lang['softedit'] = "Options de r�vision faible (votes seronts retenus):";
$lang['changewhenpollcloses'] = "Changer quand le scrutin termine?";
$lang['nochange'] = "Aucun changement";
$lang['emailresult'] = "Envoyer le r�sultat par courriel";
$lang['msgsent'] = "Message envoy�";
$lang['msgsentsuccessfully'] = "Envoi du message r�ussi.";
$lang['mailsystemfailure'] = "D�faillance du syst�me courriel. Le message n'a pas �t� envoy�.";
$lang['nopermissiontoedit'] = "Vous n'avez pas la permission de r�viser ce message.";
$lang['cannoteditpostsinthisfolder'] = "Vous ne pouvez pas r�viser les messages dans ce dossier";
$lang['messagewasnotfound'] = "Message %s n'a pas �t� retrouv�";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "Aucun utilisateur indiqu� pour envoi de courriel.";
$lang['entersubjectformessage'] = "Indiquer un sujet pour le message";
$lang['entercontentformessage'] = "Indiquer du contenu pour le message";
$lang['msgsentfromby'] = "Ce message a �t� envoy� de %s par %s";
$lang['subject'] = "Sujet";
$lang['send'] = "Envoyer";
$lang['hasoptedoutofemail'] = "refuse d'�tre contact� par courriel";
$lang['hasinvalidemailaddress'] = "a une adresse courriel invalide";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "Confirmation de message de %s";
$lang['msgnotificationemail'] = "Salut %s.\n\n%s a post� un message � votre attention sur %s\n\nLe sujet est: %s\n\nPour lire ce message et les autres dans le m�me fil de discussion, allez �:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: Si vous d�sirez ne plus recevoir de confirmations de message par courriel du forum messages post�s � votre attention, allez �: %s cliquer sur Mes Contr�les, ensuite Courriel et Confidentialit�, d�selectionner le courriel Case � cocher Confirmation et appuyer Soumettre.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "Confirmation d'abonnement de %s";
$lang['subnotification'] = "Salut %s.\n\n%s a post� un message dans un fil de discussion auquel vous vous �tes abonn� sur %s\n\nLe sujet est: %s\n\nPour lire ce message et les autres dans le m�me fil de discussion, allez �:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: Si vous d�sirez ne plus recevoir de confirmations de message par courriel de nouveau messages dans ce fil de discussion, allez �: %s et ajuster votre Niveau d'int�r�t au bas de la page.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "Confirmation de MP de %s";
$lang['pmnotification']  = "Salut %s.\n\n%s vous a post� un MP sur %s\n\nLe sujet est: %s\n\nPour lire ce message, allez �:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: Si vous d�sirez ne plus recevoir de confirmations par courriel de nouveau MP messages post�s � votre attention, allez �: %s cliquer sur Mes Contr�les, ensuite Courriel et Confidentialit�, d�selectionner le MP Case � cocher Confirmation et appuyer Soumettre.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "Confirmation de changement de mot de passe de %s";
$lang['pwchangeemail'] = "Salut %s.\n\nCeci est un courriel de confirmation pour vous informer que votre mot de passe sur %s a �t� chang�.\n\nVotre nouveau mot de passe est: %s Il a �t� chang� par: %sSi vous avez re�u ce courriel par erreur ou n'�tiez pas en attente de un changement � votre mot de passe, veuillez contacter le propri�taire du forum ou un mod�rateur sur %s dans les plus brefs d�lais pour corriger la situation.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "Confirmation par courriel requis";
$lang['confirmemail'] = "Salut %s.\n\nVous avez r�cemment cr�� un nouveau compte d'utilisateur sur %s\nAvant que vous puissiez commencer � poster, nous devons confirmer votre adresse courriel. Ne vous inqui�tez pas, ceci est tr�s facile. Vous n'avez qu'� cliquer le lien ci-dessous (ou le copier et coller dans votre navigateur web):\n\n%s\n\nUne fois la confirmation faite, vous pourriez imm�diatement ouvrir une session et commencer � poster.\n\nSi vous n'avez pas cr�er un compte d'utilisateur sur %s veuillez accepter nos excuses et tranf�rer ce courriel � %s pour nous permettre d'enqu�ter sur la source.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "Salut %s.\n\nVous avez demand� ce courriel de %s parce que vous avez oubli� votre mot de passe.\n\nCliquer le lien ci-dessous (ou le copier et coller dans votre navigateur web) pour r�initialiser votre mot de passe:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "Votre demande de r�initialisation de mot de passe";
$lang['passwdresetemailsent'] = "Courriel de r�initialisation de mot de passe envoy�";
$lang['passwdresetexp'] = "Un courriel avec les instructions pour r�initialiser votre mot de passe vous parviendra sous peu.";
$lang['validusernamerequired'] = "Un nom d'utilisateur valide est requis";
$lang['forgottenpasswd'] = "Vous avez oubli� votre mot de passe?";
$lang['forgotpasswdexp'] = "Si vous avez oubli� votre mot de passe, vous pouvez demander qu'il soit r�initialis� en entrant votre nom d'utilisateur ci-dessous. Un courriel avec les instructions de r�initisalisation de mot de passe vous sera achemin� � l'adresse courriel enregistr�e.";
$lang['couldnotsendpasswordreminder'] = "Incapable d'envoyer rappel de mot de passe. Veuillez contacter le propri�taire du forum.";
$lang['request'] = "Demander";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "Confirmation d'adresse de courriel";
$lang['emailconfirmationcomplete'] = "Merci d'avoir confirm� votre adresse courriel. Vous pouvez maintenant ouvrir une session et commencer � poster.";
$lang['emailconfirmationfailed'] = "�chec de la confirmation d'adresse de courriel, veuillez essayer de nouveau plus tard. Si vous rencontr� cette erreur plusieurs fois, veuillez contacter le propri�taire du forum ou un mod�rateur pour aide.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "Niveau sup�rieur";
$lang['maynotaccessthissection'] = "Vous ne pouvez pas acc�der � cette section.";
$lang['toplevel'] = "Niveau sup�rieur";
$lang['links'] = "Liens";
$lang['viewmode'] = "Mode de vue";
$lang['hierarchical'] = "Hi�rarchique";
$lang['list'] = "Liste";
$lang['folderhidden'] = "Ce dossier est cach�";
$lang['hide'] = "Cacher";
$lang['unhide'] = "Montrer";
$lang['nosubfolders'] = "Aucun sous-dossier dans cette cat�gorie";
$lang['1subfolder'] = "1 sous-dossier dans cette cat�gorie";
$lang['subfoldersinthiscategory'] = "sous-dossiers dans cette cat�gorie";
$lang['linksdelexp'] = "Les entr�es dans un dossier supprim� seront d�plac�es vers le dossier parent. Seulement les dossiers qui n'ont pas de sous-dossiers peuvent �tre supprim�s.";
$lang['listview'] = "Vue de liste";
$lang['listviewcannotaddfolders'] = "Impossible d'ajouter dossiers dans cette vue. Montrant 20 entr�es � la fois.";
$lang['rating'] = "Cote";
$lang['nolinksinfolder'] = "Aucun lien dans ce dossier.";
$lang['addlinkhere'] = "Ajouter un lien ici";
$lang['notvalidURI'] = "Ce n'est pas un URI valide!";
$lang['mustspecifyname'] = "Vous devez indiquer un nom!";
$lang['mustspecifyvalidfolder'] = "Vous devez indiquer un dossier valide!";
$lang['mustspecifyfolder'] = "Vous devez indiquer un dossier!";
$lang['addlink'] = "Ajouter un lien";
$lang['addinglinkin'] = "Ajout de lien dans";
$lang['addressurluri'] = "Adresse";
$lang['addnewfolder'] = "Ajouter nouveau dossier";
$lang['addnewfolderunder'] = "Ajout de nouveau dossier sous";
$lang['mustchooserating'] = "Vous devez choisir une cote!";
$lang['commentadded'] = "Votre commentaire a �t� ajout�.";
$lang['musttypecomment'] = "Vous devez taper un commentaire!";
$lang['mustprovidelinkID'] = "Vous devez fournir une identification de lien!";
$lang['invalidlinkID'] = "Identification de lien invalide!";
$lang['address'] = "Adresse";
$lang['submittedby'] = "Soumis par";
$lang['clicks'] = "Clics";
$lang['rating'] = "Cote";
$lang['vote'] = "Voter";
$lang['votes'] = "Votes";
$lang['notratedyet'] = "Pas encore coter";
$lang['rate'] = "Coter";
$lang['bad'] = "Mauvais";
$lang['good'] = "Bon";
$lang['voteexcmark'] = "Votez!";
$lang['commentby'] = "Commentaire par %s";
$lang['addacommentabout'] = "Ajouter un commentaire concernant";
$lang['modtools'] = "Outils de mod�ration";
$lang['editname'] = "Modifier le nom";
$lang['editaddress'] = "Modifier l'adresse";
$lang['editdescription'] = "Modifier la description";
$lang['moveto'] = "D�placer vers";
$lang['linkdetails'] = "D�tails du lien";
$lang['addcomment'] = "Ajouter un commentaire";
$lang['voterecorded'] = "Votre vote a �t� enregistr�";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "Ouverture de session r�ussie.";
$lang['presscontinuetoresend'] = "Appuyer Continuer pour renvoyer les donn�es du formulaire ou annuler pour renvoyer la page.";
$lang['usernameorpasswdnotvalid'] = "Le nom d'utilisateur ou le mot de passe que vous avez entr� n'est pas valide.";
$lang['pleasereenterpasswd'] = "SVP r�-introduire votre mot de passe de essayer de nouveau.";
$lang['rememberpasswds'] = "Se souvenir des mots de passe";
$lang['rememberpassword'] = "Se souvenir du mot de passe";
$lang['enterasa'] = "Entrer comme un %s";
$lang['donthaveanaccount'] = "Vous n'avez pas de compte? %s";
$lang['registernow'] = "Enregistrez-vous maintenant";
$lang['problemsloggingon'] = "Vous avez des probl�mes d'ouverture de session?";
$lang['deletecookies'] = "Supprimer les t�moins";
$lang['cookiessuccessfullydeleted'] = "Suppression des t�moins r�ussie";
$lang['forgottenpasswd'] = "Vous avez oubli� votre mot de passe?";
$lang['usingaPDA'] = "Vous utilisez un assistant personnel num�rique (PDA)?";
$lang['lightHTMLversion'] = "Version HTML l�g�r";
$lang['youhaveloggedout'] = "Vous avez ferm� votre session.";
$lang['currentlyloggedinas'] = "Vous �tes en session actuelle sous le nom d'utilisateur %s";
$lang['logonbutton'] = "Ouvrir session";
$lang['otherbutton'] = "Autre";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "Mes Forums";
$lang['availableforums'] = "Forums disponibles";
$lang['favouriteforums'] = "Forums favoris";
$lang['lastvisited'] = "Derni�re visite";
$lang['forumunreadmessages'] = "%s Unread Messages";
$lang['forummessages'] = "%s Messages";
$lang['forumunreadtome'] = "%s Unread &quot;To: Me&quot;";
$lang['forumnounreadmessages'] = "No Unread Messages";
$lang['removefromfavourites'] = "Supprimer de mes favoris";
$lang['addtofavourites'] = "Ajouter � mes favoris";
$lang['availableforums'] = "Forums disponibles";
$lang['noforumsavailablelogin'] = "Aucun forum de disponible. SVP ouvrir une session pour voir vos forums.";
$lang['passwdprotectedforum'] = "Forum prot�g� par mot de passe";
$lang['passwdprotectedwarning'] = "Ce forum est prot�g� par mot de passe. Pour y acc�der, entrer le mot de passe ci-dessous.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "Poster message";
$lang['selectfolder'] = "S�lectionner le dossier";
$lang['mustenterpostcontent'] = "Votre message doit avoir du contenu!";
$lang['messagepreview'] = "Aper�u du message";
$lang['invalidusername'] = "Nom d'utilisateur invalide!";
$lang['mustenterthreadtitle'] = "Vous devez inclure un titre pour le fil de discussion!";
$lang['pleaseselectfolder'] = "SVP s�lectionner un dossier!";
$lang['errorcreatingpost'] = "Erreur en cr�ant le message! SVP essayer de nouveau dans quelques minutes.";
$lang['createnewthread'] = "Cr�er un nouveau fil de discussion";
$lang['postreply'] = "Afficher la r�ponse";
$lang['threadtitle'] = "Titre du fil de discussion";
$lang['messagehasbeendeleted'] = "Message a �t� supprim�.";
$lang['messagenotfoundinselectedfolder'] = "Message not found in selected folder. Check that it hasn't been moved or deleted.";
$lang['cannotpostthisthreadtypeinfolder'] = "Vous ne pouvez pas poster ce type de fil de discussion dans ce dossier!";
$lang['cannotpostthisthreadtype'] = "Vous ne pouvez pas poster ce type de fil de discussion car il n'y a aucun dossier de disponible qui le permet.";
$lang['cannotcreatenewthreads'] = "Vous ne pouvez pas cr�er des nouveaux fils de discussion.";
$lang['threadisclosedforposting'] = "Ce fil de discussion est ferm� aux contributions. Vous ne pouvez pas y poster un message!";
$lang['moderatorthreadclosed'] = "Mise en garde: ce fil de discussion est ferm� pour contributions aux utilisateurs r�guliers.";
$lang['threadclosed'] = "Fil de discussion ferm� aux contributions";
$lang['usersinthread'] = "Utilisateurs dans le fil de discussion";
$lang['correctedcode'] = "Code corrig�";
$lang['submittedcode'] = "Code soumis";
$lang['htmlinmessage'] = "HTML dans le message";
$lang['disableemoticonsinmessage'] = "D�sactiver les binettes dans le message";
$lang['automaticallyparseurls'] = "Transformer automatiquement les adresses URLs en liens hypertexte";
$lang['automaticallycheckspelling'] = "V�rifier automatiquement l'orthographe";
$lang['setthreadtohighinterest'] = "�tablir le niveau d'int�r�t du fil de discussion � �lev�";
$lang['enabledwithautolinebreaks'] = "Activ� avec coupures de lignes automatiques";
$lang['fixhtmlexplanation'] = "Ce forum utilise le filtrage d'HTML. Le code HTML que vous avez soumis a �t� modifi� par les filtres de fa�on quelconque.\\n\\nPour voir votre code original, s�lectionner la case d'option \\'Code sousmis\\'.\\nPour voir le code modifi�, s�lectionner la case d'option \\'Code corrig�\\'.";
$lang['messageoptions'] = "Options de message";
$lang['notallowedembedattachmentpost'] = "Vous n'avez pas la permission d'incorporer des fichiers joints dans vos messages.";
$lang['notallowedembedattachmentsignature'] = "Vous n'avez pas la permission d'incorporer des fichiers joints dans votre signature.";
$lang['reducemessagelength'] = "La longueure du message doit �tre moins de 65,535 charact�res (actuellement: ";
$lang['reducesiglength'] = "La longueure de la signature doit �tre moins de 65,535 charact�res (actuellement: ";
$lang['cannotcreatethreadinfolder'] = "Vous ne pouvez pas cr�er de nouveaux fils de discussion dans ce dossier";
$lang['cannotcreatepostinfolder'] = "Vous ne pouvez pas r�pondre aux messages dans ce dossier";
$lang['cannotattachfilesinfolder'] = "Vous ne pouvez pas poster des fichiers joints dans ce dossier. Enlever les fichiers joints pour continuer.";
$lang['postfrequencytoogreat'] = "Vous pouvez poster seulement une fois tous les %s secondes. SVP r�-essayer plus tard.";
$lang['emailconfirmationrequiredbeforepost'] = "Confirmation d'adresse courriel requise avant que vous pouvez poster!";
$lang['emailconfirmationfailedtosend'] = "L'envoi du courriel de confirmation a �chou�. SVP contacter le propri�taire du forum pour corriger cette situation.";
$lang['emailconfirmationsent'] = "Confirmation email has been resent.";
$lang['resendconfirmation'] = "Renvoyer confirmation";
$lang['userapprovalrequiredbeforeaccess'] = "Votre compte d'usager doit �tre approuv� par un administrateur du forum avant que vous pouvez acc�der au forum demand�.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "en r�ponse �";
$lang['showmessages'] = "Montrer les messages";
$lang['ratemyinterest'] = "Coter mon int�r�t";
$lang['adjtextsize'] = "Changer la taille des textes";
$lang['smaller'] = "Plus petit";
$lang['larger'] = "Plus grand";
$lang['faq'] = "FAQ";
$lang['docs'] = "Docs";
$lang['support'] = "Support";
$lang['donateexcmark'] = "Contribuez!";
$lang['threadcouldnotbefound'] = "Le fil de discussion demand� n'a pas pu �tre trouv� ou l'acc�s a �t� refus�.";
$lang['mustselectpolloption'] = "Vous devez voter pour une option!";
$lang['mustvoteforallgroups'] = "Vous devez voter dans chaque groupe.";
$lang['keepreading'] = "Continuer lecture";
$lang['backtothreadlist'] = "Retournez � la liste de fils de discussion";
$lang['postdoesnotexist'] = "Ce message n'existe pas dans ce fil de discussion!";
$lang['clicktochangevote'] = "Cliquez pour changer votre vote";
$lang['youvotedforoption'] = "Vous avez vot� pour l'option";
$lang['youvotedforoptions'] = "Vous avez vot� pour les options";
$lang['clicktovote'] = "Cliquez pour voter";
$lang['youhavenotvoted'] = "Vous n'avez pas vot�";
$lang['viewresults'] = "Voir les r�sultats";
$lang['msgtruncated'] = "Message tronqu�";
$lang['viewfullmsg'] = "Voir message complet";
$lang['ignoredmsg'] = "Message ignor�";
$lang['wormeduser'] = "Utilisateur parasit�";
$lang['ignoredsig'] = "Signature ignor�e";
$lang['messagewasdeleted'] = "Message %s.%s a �t� supprim�";
$lang['stopignoringthisuser'] = "Cesser d'ignorer cet utilisateur";
$lang['renamethread'] = "Renommer le fil de discussion";
$lang['movethread'] = "D�placer le fil de discussion";
$lang['editthepoll'] = "Modifer le scrutin";
$lang['torenamethisthread'] = "pour renommer ce fil de discussion";
$lang['closeforposting'] = "Fermer aux contributions";
$lang['until'] = "Jusqu'� 00:00 UTC";
$lang['approvalrequired'] = "Approbation requise";
$lang['messageawaitingapprovalbymoderator'] = "Message %s.%s en attente d'approbation par un mod�rateur";
$lang['postapprovedsuccessfully'] = "Approbation de message r�ussie";
$lang['postapprovalfailed'] = "L'approbation du message a �chou�.";
$lang['postdoesnotrequireapproval'] = "Approbation du message non requis";
$lang['approvepost'] = "Approuver message pour affichage";
$lang['approvedbyuser'] = "APPROVED: %s by %s";
$lang['makesticky'] = "Rendre collant";
$lang['messagecountdisplay'] = "%s de %s";
$lang['linktothread'] = "Lien permanent � ce fil de discussion";
$lang['linktopost'] = "Hyperlier au message";
$lang['linktothispost'] = "Hyperlier � ce message";
$lang['imageresized'] = "Cet image a �t� redimensionn� (taille originale %1\$sx%2\$s). Pour voir l'image � l'�chelle, cliquez ici.";
$lang['messagedeletedbyuser'] = "Message %s.%s deleted %s by %s";
$lang['messagedeleted'] = "Message %s.%s was deleted";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "Impossible d'afficher mod�rateurs de dossier";
$lang['moderatorlist'] = "Liste de mod�rateurs:";
$lang['modsforfolder'] = "Mod�rateurs de dossier";
$lang['nomodsfound'] = "Aucun mod�rateur retrouv�";
$lang['forumleaders'] = "Leaders du forum:";
$lang['foldermods'] = "Mod�rateurs de dossier:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "D�but";
$lang['messages'] = "Messages";
$lang['pminbox'] = "Bo�te de r�ception MP";
$lang['startwiththreadlist'] = "Page d'accueil avec liste de fils de discussion";
$lang['pmsentitems'] = "Items envoy�s";
$lang['pmoutbox'] = "Bo�te d'envoi";
$lang['pmsaveditems'] = "Items sauvegard�s";
$lang['pmdrafts'] = "Drafts";
$lang['links'] = "Liens";
$lang['admin'] = "Admin";
$lang['login'] = "Ouvrir session";
$lang['logout'] = "Fermer session";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "Messages priv�s";
$lang['recipienttiptext'] = "S�parer les destinataires par un point-virgule ou une virgule";
$lang['maximumtenrecipientspermessage'] = "Il y a une limite de 10 destinataires par message. SVP modifier votre liste de destinataires.";
$lang['mustspecifyrecipient'] = "Vous devez sp�cifier aumoins un destinataire.";
$lang['usernotfound'] = "User %s not found";
$lang['sendnewpm'] = "Envoyer nouveau MP";
$lang['savemessage'] = "Enregistrer message";
$lang['timesent'] = "Heure d'envoi";
$lang['nomessages'] = "Aucun message";
$lang['errorcreatingpm'] = "Erreur en cr�ant MP! SVP essayer de nouveau dans quelques minutes";
$lang['writepm'] = "R�diger message";
$lang['editpm'] = "R�viser message";
$lang['cannoteditpm'] = "Impossible de r�viser ce MP. Soit qu'il a d�j� �t� lu par le destinataire ou que le message n'existe pas ou qu'il ne vous est pas accessible.";
$lang['cannotviewpm'] = "Cannot view PM. Message does not exist or it is inaccessible by you";
$lang['pmmessagenumber'] = "Message %s";

$lang['youhavexnewpm'] = "Vous avez %d un nouveau MP. D�sirez-vous ouvrir votre boite de r�ception maintenant?";
$lang['youhave1newpm'] = "Vous avez 1 un nouveau MP. D�sirez-vous ouvrir votre boite de r�ception maintenant?";
$lang['youhave1newpmand1waiting'] = "You have 1 new message.\\n\\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhave1pmwaiting'] = "You have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhavexnewpmand1waiting'] = "You have %d new messages.\\n\\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhavexnewpmandxwaiting'] = "You have %d new messages.\\n\\nYou also have %d messages awaiting delivery. To receive these message please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhave1newpmandxwaiting'] = "You have 1 new message.\\n\\nYou also have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhavexpmwaiting'] = "You have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";

$lang['youdonothaveenoughfreespace'] = "Vous n'avez pas assez d'espace libre pour envoyer ce message.";
$lang['userhasoptedoutofpm'] = "%s a choisi de ne pas recevoir les messages personnels";
$lang['pmfolderpruningisenabled'] = "L'�lagation du dossier MP est activ�e!";
$lang['pmpruneexplanation'] = "Ce forum utilise l'�lagation du dossier PM. Les messages que vous avez de conserv� dans vos \\ndossiers de bo�te de r�ception et de bo�te d'envoi sont assujettis � la suppression automatique. Veuillez transf�rer � \\nvotre dossier \\'Items sauvegard�s\\' tout message que vous d�sirez conserver afin qu'ils ne soient pas supprim�s.";
$lang['yourpmfoldersare'] = "Vos dossiers MP sont %s pleins";
$lang['currentmessage'] = "Message actuel";
$lang['unreadmessage'] = "Message non-lu";
$lang['readmessage'] = "Lire message";
$lang['pmshavebeendisabled'] = "Les messages personnels ont �t� d�sactiv�s par le propri�taire du forum.";
$lang['adduserstofriendslist'] = "Si vous ajoutez des utilisateurs � votre liste d'ami(e)s, ils appara�tront dans la liste d�roulante verticalement de la page R�diger Message PM.";

$lang['messagesaved'] = "Message Saved";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "Message was successfully saved to 'Drafts' folder";
$lang['couldnotsavemessage'] = "Could not save message. Make sure you have enough available free space.";
$lang['pmtooltipxmessages'] = "%s messages";
$lang['pmtooltip1message'] = "1 message";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "Mes Contr�les";
$lang['myforums'] = "Mes Forums";
$lang['menu'] = "Menu";
$lang['userexp_1'] = "Utiliser le menu � gauche pour g�rer vos options.";
$lang['userexp_2'] = "<b>D�tails d'utilisateur</b> vous permet de changer votre nom, adresse courriel, et mot de passe.";
$lang['userexp_3'] = "<b>Profile d'utilisateur</b> vous permet de modifier votre profile d'utilisateur.";
$lang['userexp_4'] = "<b>Changer mot de passe</b> vous permet de changer votre mot de passe";
$lang['userexp_5'] = "<b>Courriel &amp; confidentialit�</b> vous permet de changer la fa�on dont vous pouvez �tre contact� sur le forum et en dehors du forum.";
$lang['userexp_6'] = "<b>Options du Forum</b> vous permet de changer l'allure et le fonctionnement du forum.";
$lang['userexp_7'] = "<b>Fichiers joints</b> vous permet de modifier/supprimer vos fichiers joints.";
$lang['userexp_8'] = "<b>Modifer Signature</b> vous permet de modifier votre signature.";
$lang['userexp_9'] = "<b>Relationships</b> lets you manage your relationship with other users on the forum.";
$lang['userexp_9'] = "<b>Relationships</b> lets you manage your relationship with other users on the forum.";
$lang['userexp_10'] = "<b>Thread Subscriptions</b> allows you to manage your thread subscriptions.";
$lang['userdetails'] = "D�tails d'utilisateur";
$lang['userprofile'] = "Profile d'utilisateur";
$lang['emailandprivacy'] = "Courriel &amp; Confidentialit�";
$lang['editsignature'] = "Modifier Signature";
$lang['norelationships'] = "Aucune relation d'utilisateur d'�tablie";
$lang['editwordfilter'] = "Modifier le filtre de mots";
$lang['userinformation'] = "Information d'utilisateur";
$lang['changepassword'] = "Changer mot de passe";
$lang['currentpasswd'] = "Mot de passe actuel";
$lang['newpasswd'] = "Nouveau mot de passe";
$lang['confirmpasswd'] = "Confirmer mot de passe";
$lang['passwdsdonotmatch'] = "Les mots de passe ne correspondent pas.";
$lang['nicknamerequired'] = "Pseudonyme requis!";
$lang['emailaddressrequired'] = "Adresse courriel requis!";
$lang['logonnotpermitted'] = "Nom d'utilisateur non-autoris�. Choisissez un autre!";
$lang['nicknamenotpermitted'] = "Pseudonyme non-autoris�. Choisissez un autre!";
$lang['emailaddressnotpermitted'] = "Adresse courriel non-autoris�e. Choisissez une autre!";
$lang['emailaddressalreadyinuse'] = "Adresse courriel d�j� en usage. Choisissez une autre!";
$lang['relationshipsupdated'] = "Relations mises � jour!";
$lang['relationshipupdatefailed'] = "�chec de la mise � jour des relations!";
$lang['preferencesupdated'] = "Mise � jour des pr�f�rences r�ussie.";
$lang['userdetails'] = "D�tails d'utilisateur";
$lang['memberno'] = "No. de membre";
$lang['firstname'] = "Pr�nom";
$lang['lastname'] = "Nom de famille";
$lang['dateofbirth'] = "Date de naissance";
$lang['homepageURL'] = "Adresse URL de votre page d'accueil";
$lang['pictureURL'] = "Adresse URL de l'image";
$lang['forumoptions'] = "Options de forum";
$lang['notifybyemail'] = "M'aviser par courriel de messages � moi";
$lang['notifyofnewpm'] = "M'aviser par fen�tre contextuelle de nouveaux messages MP";
$lang['notifyofnewpmemail'] = "M'aviser par courriel de nouveaux messages MP";
$lang['daylightsaving'] = "Ajuster pour l'heure avanc�e";
$lang['autohighinterest'] = "Marquer automatiquement les fils de discussion dans lesquels je poste comme �tant d'int�r�t �lev�";
$lang['convertimagestolinks'] = "Convertir automatiquement en hyperliens les images incorpor�es dans les messages";
$lang['thumbnailsforimageattachments'] = "vignettes pour images jointes";
$lang['smallsized'] = "de petite taille";
$lang['mediumsized'] = "de taille moyenne";
$lang['largesized'] = "de grande taille";
$lang['globallyignoresigs'] = "Ignorer globalement les signatures d'utilisateurs";
$lang['allowpersonalmessages'] = "Permettre aux autres utilisateurs de m'envoyer des messages personnels";
$lang['allowemails'] = "Permettre aux autres utilisateurs de m'envoyer des courriels via mon profile";
$lang['timezonefromGMT'] = "Fuseau horaire";
$lang['postsperpage'] = "Postes par page";
$lang['fontsize'] = "Taille de police";
$lang['forumstyle'] = "Style du forum";
$lang['forumemoticons'] = "Binettes du forum";
$lang['startpage'] = "Page de d�marrage";
$lang['preferredlang'] = "Langage pr�f�r�";
$lang['donotshowmyageordobtoothers'] = "Masquer mon �ge et ma date de naissance";
$lang['showonlymyagetoothers'] = "Montrer uniquement mon �ge aux autres utilisateurs";
$lang['showmyageanddobtoothers'] = "Montrer mon �ge et ma date de naissance aux autres utilisateurs";
$lang['showonlymydayandmonthofbirthytoothers'] = "Show only my day and month of birth to others";
$lang['listmeontheactiveusersdisplay'] = "M'inclure dans la liste des utilisateurs actifs";
$lang['browseanonymously'] = "Naviguer le forum anonymement";
$lang['allowfriendstoseemeasonline'] = "Naviguer anonymement, mais permettre mes ami(e)s de voir que je suis connect�";
$lang['revealspoileronmouseover'] = "R�v�lez les g�cheurs sur survol";
$lang['resizeimagesandreflowpage'] = "Redimensionner les images et remarginer la page afin de pr�venir le d�filement horizontal.";
$lang['showforumstats'] = "Montrer les statistiques du forum au pied du panneau de message";
$lang['usewordfilter'] = "Activer le filtre des mots.";
$lang['forceadminwordfilter'] = "Forcer l'usage du filtre des mots de l'admin sur tous les utilisateurs (y inclut les visiteurs)";
$lang['timezone'] = "Fuseau horaire";
$lang['language'] = "Langage";
$lang['emailsettings'] = "Options de courriel et de contacte";
$lang['forumanonymity'] = "Options d'anonymit� sur le forum";
$lang['birthdayanddateofbirth'] = "Affichage d'anniversaire et date de naissance";
$lang['includeadminfilter'] = "Inclure filtre des mots de l'admin dans ma liste.";
$lang['setforallforums'] = "�tablir pour tous les forums?";
$lang['containsinvalidchars'] = "Contient des caract�res invalides!";
$lang['postpage'] = "Page de postage";
$lang['nohtmltoolbar'] = "Pas de barre d'outils HTML";
$lang['displaysimpletoolbar'] = "Afficher la barre d'outils HTML simple";
$lang['displaytinymcetoolbar'] = "Afficher la barre d'outils HTML tel-tel";
$lang['displayemoticonspanel'] = "Afficher panneau de binettes";
$lang['displaysignature'] = "Afficher signature";
$lang['disableemoticonsinpostsbydefault'] = "D�sactiver les binettes dans les messages par d�faut";
$lang['automaticallyparseurlsbydefault'] = "Transformer automatiquement les adresses URLs en liens hypertexte dans les messages par d�faut";
$lang['postinplaintextbydefault'] = "Poster en texte en clair par d�faut";
$lang['postinhtmlwithautolinebreaksbydefault'] = "Poster en HTML avec coupures de lignes automatiques par d�faut";
$lang['postinhtmlbydefault'] = "Poster en HTML par d�faut";
$lang['privatemessageoptions'] = "Options de message priv�";
$lang['privatemessageexportoptions'] = "Options d'exportation de message priv�";
$lang['savepminsentitems'] = "Enregistrer une copie de chaque MP que j'envois dans mon dossier d'Items envoy�s";
$lang['includepminreply'] = "Inclure le corps du message en r�pondant au MP";
$lang['autoprunemypmfoldersevery'] = "�laguer automatiquement mes dossiers de MP tous les:";
$lang['friendsonly'] = "Ami(e)s seulement?";
$lang['globalstyles'] = "Global Styles";
$lang['forumstyles'] = "Forum Styles";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "Vous devez fournir des groupes de r�ponse";
$lang['mustprovidepolltype'] = "Vous devez fournir un type de scrutin";
$lang['mustprovidepollresultsdisplaytype'] = "Vous devez fournir un type d'affichage pour les r�sultats";
$lang['mustprovidepollvotetype'] = "Vous devez fournir un type de vote de scrutin";
$lang['mustprovidepollguestvotetype'] = "Vous devez indiquer si les invit�s ont la permission de voter";
$lang['mustprovidepolloptiontype'] = "Vous devez fournir un type d'option de scrutin";
$lang['mustprovidepollchangevotetype'] = "Vous devez fournir un type de changer vote du scrutin";
$lang['pleaseselectfolder'] = "SVP s�lectionner un dossier!";
$lang['mustspecifyvalues1and2'] = "Vous devez sp�cifier des valeurs pour les r�ponses 1 et 2";
$lang['tablepollmusthave2groups'] = "Les scrutins de format tabulaire doivent avoir exactement deux groupes de mise aux voix";
$lang['nomultivotetabulars'] = "Les scrutins de format tabulaire ne peuved pas �tre multi-votes";
$lang['nomultivotepublic'] = "Les scrutins publiques ne peuvent pas �tre multi-votes";
$lang['abletochangevote'] = "Vous serez capable de changer votre vote.";
$lang['abletovotemultiple'] = "Vous pourrez voter plusieurs fois.";
$lang['notabletochangevote'] = "Vous ne pourrez pas changer votre vote.";
$lang['pollvotesrandom'] = "Note: Les votes de scrutin sont g�n�r�s au hasard pour l'aper�u seulement.";
$lang['pollquestion'] = "Question de scrutin";
$lang['possibleanswers'] = "R�ponses possibles";
$lang['enterpollquestionexp'] = "Entrer les r�ponses pour votre question de scrutin. Si votre scrutin est une question &quot;oui/non&quot;, vous n'avez qu'� entrer &quot;Oui&quot; pour R�ponse 1 et &quot;Non&quot; pour R�ponse 2.";
$lang['numberanswers'] = "No. R�ponses";
$lang['answerscontainHTML'] = "R�ponses contiennent du HTML (apart de la signature)";
$lang['optionsdisplay'] = "Type d'affichage des r�ponses";
$lang['optionsdisplayexp'] = "Comment voulez-vous que les r�ponses soient pr�sent�es?";
$lang['dropdown'] = "D�roulant vertical";
$lang['radios'] = "Comme une s�rie de cases d'option";
$lang['votechanging'] = "Changement de vote";
$lang['votechangingexp'] = "Une personne est-elle permise de changer son vote?";
$lang['guestvoting'] = "Le vote par invit�";
$lang['guestvotingexp'] = "Est-ce que les visiteurs peuvent voter dans ce scrutin?";
$lang['allowmultiplevotes'] = "Permettre votes multiples";
$lang['pollresults'] = "R�sultats du scrutin";
$lang['pollresultsexp'] = "Comment voulez-vous afficher les r�sultats de votre scrutin?";
$lang['pollvotetype'] = "Type de vote de scrutin";
$lang['pollvotesexp'] = "Comment voulez-vous mener le scrutin?";
$lang['pollvoteanon'] = "Anonymement";
$lang['pollvotepub'] = "Vote publique";
$lang['horizgraph'] = "Graphique horizontale";
$lang['vertgraph'] = "Graphique verticale";
$lang['tablegraph'] = "Format tabulaire";
$lang['polltypewarning'] = "<b>Mise en garde</b>: Ceci est un vote publique. Votre nom d'utilisateur sera visible � c�t� de l'option pour laquelle vous avez vot�.";
$lang['expiration'] = "Expiration";
$lang['showresultswhileopen'] = "Voulez-vous afficher les r�sultats pendant que le scrutin est ouvert?";
$lang['whenlikepollclose'] = "Quand aimeriez-vous que votre scrutin termine automatiquement?";
$lang['oneday'] = "Un jour";
$lang['threedays'] = "Trois jours";
$lang['sevendays'] = "Sept jours";
$lang['thirtydays'] = "Trente jours";
$lang['never'] = "Jamais";
$lang['polladditionalmessage'] = "Message suppl�mentaire (optionnel)";
$lang['polladditionalmessageexp'] = "Voulez-vous inclure un message suppl�mentaire apr�s le scrutin?";
$lang['mustspecifypolltoview'] = "Vous devez sp�cifier un scrutin � afficher.";
$lang['pollconfirmclose'] = "�tes-vous certain de vouloir fermer le scrutin suivant?";
$lang['endpoll'] = "Fermer scrutin";
$lang['nobodyvotedclosedpoll'] = "Personne a vot�";
$lang['votedisplayopenpoll'] = "%s et %s ont vot�.";
$lang['votedisplayclosedpoll'] = "%s et %s ont vot�.";
$lang['nousersvoted'] = "Aucun usager";
$lang['oneuservoted'] = "1 usager";
$lang['xusersvoted'] = "%s usagers";
$lang['noguestsvoted'] = "Aucun invit�";
$lang['oneguestvoted'] = "1 invit�";
$lang['xguestsvoted'] = "%s invit�s";
$lang['pollhasended'] = "Le scrutin a termin�";
$lang['youvotedforpolloptionsondate'] = "You voted for %s on %s";
$lang['thisisapoll'] = "Ceci est un scrutin. Cliquer pour voir les r�sultats.";
$lang['editpoll'] = "Modifier le scrutin";
$lang['results'] = "R�sultats";
$lang['resultdetails'] = "D�tails des r�sultats";
$lang['changevote'] = "Changer vote";
$lang['pollshavebeendisabled'] = "Les scrutins ont �t� d�sactiv� par le propri�taire du forum.";
$lang['answertext'] = "Texte de r�ponse";
$lang['answergroup'] = "Groupe de r�ponse";
$lang['previewvotingform'] = "Pr�visualisation du formulaire de scrutin";
$lang['viewbypolloption'] = "View by poll option";
$lang['viewbyuser'] = "View by user";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "Modifier profile";
$lang['profileupdated'] = "Profile mise � jour.";
$lang['profilesnotsetup'] = "Le propri�taire du forum n'a pas �tablit les profiles.";
$lang['ignoreduser'] = "Utilisateur ignor�";
$lang['lastvisit'] = "Derni�re visite";
$lang['totaltimeinforum'] = "Dur�e totale";
$lang['longesttimeinforum'] = "Session la plus longue";
$lang['sendemail'] = "Envoyer courriel";
$lang['sendpm'] = "Envoyer MP";
$lang['visithomepage'] = "Visiter le site web";
$lang['age'] = "�ge";
$lang['aged'] = "�g�";
$lang['birthday'] = "Anniversaire";
$lang['registered'] = "Enregistr�";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "D�sol�, le forum n'accepte pas de nouveaux enregistrements d'utilisateurs en ce moment. Veuillez r�-essayer plus tard.";
$lang['usernameinvalidchars'] = "Le nom d'utilisateur peut contenir seulement les caract�res a-z, 0-9, _ -";
$lang['usernametooshort'] = "Le nom d'utilisateur doit contenir aumoins 2 caract�res comme minimum";
$lang['usernametoolong'] = "Le nom d'utilisateur peut contenir un maximum de 15 caract�res";
$lang['usernamerequired'] = "Un nom d'utilisateur est requis";
$lang['passwdmustnotcontainHTML'] = "Le mot de passe ne doit pas inclure des balises HTML";
$lang['passwordinvalidchars'] = "Le mot de passe peut contenir seulement les caract�res a-z, 0-9, _ -";
$lang['passwdtooshort'] = "Le mot de passe doit �tre un minimum de 6 caract�res de long";
$lang['passwdrequired'] = "Un mot de passe est requis";
$lang['confirmationpasswdrequired'] = "Un mot de passe de confirmation est requis";
$lang['nicknamerequired'] = "Pseudonyme requis!";
$lang['emailrequired'] = "Une adresse courriel est requise";
$lang['passwdsdonotmatch'] = "Les mots de passe ne correspondent pas.";
$lang['usernamesameaspasswd'] = "Le nom d'utilisateur et le mot de passe doivent �tre diff�rents l'un de l'autre";
$lang['usernameexists'] = "D�sol�, ce nom d'utilisateur est d�j� en usage";
$lang['successfullycreateduseraccount'] = "Cr�ation de compte d'utilisateur r�ussie";
$lang['useraccountcreatedconfirmfailed'] = "Votre compte d'utilisateur a �t� cr�� mais le courriel de confirmation n'a pas �t� envoy�. Veuillez contacter le propri�taire du forum pour corriger cette situation. Entretemps, SVP cliquer le bouton continuer ci-dessous pour ouvrir une session.";
$lang['useraccountcreatedconfirmsuccess'] = "Votre compte d'utilisateur a �t� cr�� mais avant que vous puissiez commencer � poster, vous devez confirmer votre adresse courriel. SVP v�rifier votre courriel pour un lien qui vous permettra de confirmer votre adresse courriel.";
$lang['useraccountcreated'] = "Cr�ation de compte d'utilisateur r�ussie! Cliquer le bouton continuer ci-dessous pour ouvrir une session";
$lang['errorcreatinguserrecord'] = "Erreur rencontr�e durant la cr�ation du dossier d'utilisateur";
$lang['userregistration'] = "Enregistrement d'utilisateur";
$lang['registrationinformationrequired'] = "Information pour l'enregistrement (requise)";
$lang['profileinformationoptional'] = "Information de profile (Optionnelle)";
$lang['preferencesoptional'] = "Pr�f�rences (Optionnelle)";
$lang['register'] = "Enregistrer";
$lang['rememberpasswd'] = "Se souvenir du mot de passe";
$lang['birthdayrequired'] = "Votre date de naissance est requise ou est invalide";
$lang['alwaysnotifymeofrepliestome'] = "M'aviser lors de r�ponse � mes messages";
$lang['notifyonnewprivatemessage'] = "M'aviser lors de nouveaux Messages Priv�s";
$lang['popuponnewprivatemessage'] = "Fen�tre contextuelle lors de nouveau Messages Priv�s";
$lang['automatichighinterestonpost'] = "Niveau d'int�r�t �lev� automatique sur postage";
$lang['confirmpassword'] = "Confirmer mot de passe";
$lang['invalidemailaddressformat'] = "Format d'adresse courriel invalide";
$lang['moreoptionsavailable'] = "D'autres options de Profile et de Pr�f�rences sont disponibles une fois que vous vous �tes enregistr�";
$lang['textcaptchaconfirmation'] = "Confirmation";
$lang['textcaptchaexplain'] = "� la droite est une image de text-captcha. SVP taper dans la zone d'entr�e ci-dessous le code que vous voyer dans l'image.";
$lang['textcaptchaimgtip'] = "Ceci est une image-captcha. Elle est utilis�e pour pr�venir l'enregistrement automatique.";
$lang['textcaptchamissingkey'] = "Un code de confimation est requis.";
$lang['textcaptchaverificationfailed'] = "Le code de v�rification du text captcha est erron�. SVP le r�introduire.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "Membre";
$lang['searchforusernotinlist'] = "Chercher pour un utilisateur qui n'est pas sur la liste";
$lang['yoursearchdidnotreturnanymatches'] = "Votre recherche n'a pas trouv� de correspondances. Veuillez simplifier vos param�tres de recherche et essayer de nouveau.";
$lang['hiderowswithemptyornullvalues'] = "Hide rows with empty or null values in selected columns";
$lang['showregisteredusersonly'] = "Show Registered Users only (hide Guests)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "Relations";
$lang['userrelationship'] = "Relation d'utilisateur";
$lang['userrelationships'] = "Relations d'utilisateur";
$lang['friends'] = "Ami(e)s";
$lang['ignoredcompletely'] = "Ignor� compl�tement";
$lang['relationship'] = "Relation";
$lang['restorenickname'] = "Restaurer le pseudonyme de l'utilisateur";
$lang['friend_exp'] = "Les messages de cet utilisateur seront marqu� avec un ic�ne &quot;Ami(e)&quot;";
$lang['normal_exp'] = "Les messages de cet utilisateur appara�itront normallement.";
$lang['ignore_exp'] = "Les messages de cet utilisateur sont masqu�s.";
$lang['ignore_completely_exp'] = "Fils de discussion et messages de et � cet utilisateur appara�tront comme supprim�s.";
$lang['display'] = "Afficher";
$lang['displaysig_exp'] = "Afficher la signature de l'utilisateur sur leurs postes.";
$lang['hidesig_exp'] = "La signature de l'utilisateur est masqu�e sur leurs postes.";
$lang['cannotignoremod'] = "Vous ne pouvez pas ignorer cet utilisateur parce qu'il/elle est un mod�rateur.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "R�sultats de recherche";
$lang['usernamenotfound'] = "Le nom d'utilisateur sp�cifi� dans le champs � ou dans le champs de n'a pas �t� retrouv�.";
$lang['notexttosearchfor'] = "Un ou tous vos mots-cl�s de recherche �taient invalides. Les mots-cl�s de recherche doivent avoir un minimum de %d caract�res et un maximum de %d caract�res et ne doivent pas appara�tre dans le %s.";
$lang['mysqlstopwordlist'] = "liste de mots vides MySQL";
$lang['foundzeromatches'] = "Correspondances trouv�es: 0";
$lang['found'] = "Trouv�";
$lang['matches'] = "correspondances";
$lang['prevpage'] = "Page pr�c�dante";
$lang['findmore'] = "Trouver d'autres";
$lang['searchmessages'] = "Chercher les messages";
$lang['searchdiscussions'] = "Chercher les discussions";
$lang['find'] = "Trouver";
$lang['additionalcriteria'] = "Crit�res suppl�mentaires";
$lang['searchbyuser'] = "Chercher par utilisateur (optionnel)";
$lang['folderbrackets_s'] = "Dossier(s)";
$lang['postedfrom'] = "Post� depuis";
$lang['postedto'] = "Post� jusqu'�";
$lang['today'] = "aujourd'hui";
$lang['yesterday'] = "hier";
$lang['daybeforeyesterday'] = "avant hier";
$lang['weekago'] = "%s semaine pass�e";
$lang['weeksago'] = "%s semaines pass�es";
$lang['monthago'] = "%s mois pass�";
$lang['monthsago'] = "%s mois pass�s";
$lang['yearago'] = "il y a un an";
$lang['beginningoftime'] = "Du d�but des temps";
$lang['now'] = "Maintenant";
$lang['lastpostdate'] = "Date du dernier message";
$lang['numberofreplies'] = "Nombre de r�ponses";
$lang['foldername'] = "Nom du dossier";
$lang['authorname'] = "Nom de l'auteur";
$lang['decendingorder'] = "Le plus r�cent en premier";
$lang['ascendingorder'] = "Le plus ancien en premier";
$lang['keywords'] = "Mots-cl�";
$lang['sortby'] = "Assortir par";
$lang['sortdir'] = "Assortir dir";
$lang['sortresults'] = "Assortir les r�sultats";
$lang['groupbythread'] = "Grouper par fil de discussion";
$lang['postsfromuser'] = "Messages de cet utilisateur";
$lang['poststouser'] = "Messages � cet utilisateur";
$lang['poststoandfromuser'] = "Messages � et de cet utilisateur";
$lang['searchfrequencyerror'] = "Vous pouvez chercher seulement une fois tous les %s secondes. Veuillez essayer de nouveau plus tard.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "Choisir";
$lang['searchforthread'] = "Chercher pour fils de discussion";
$lang['mustspecifytypeofsearch'] = "You must specify type of search to perform";
$lang['unkownsearchtypespecified'] = "Unknown search type specified";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "Fils de discussion r�cents";
$lang['startreading'] = "Commencer lecture";
$lang['threadoptions'] = "Options de fil de discussion";
$lang['editthreadoptions'] = "Modifier options de fil de discussion";
$lang['morevisitors'] = "Plus de visiteurs";
$lang['forthcomingbirthdays'] = "Anniversaires � venir";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "Vous pouvez modifier cette page de l'interface admin";
$lang['uploadstartpage'] = "T�l�verser page de d�marrage (%s)";
$lang['invalidfiletypeerror'] = "Type de fichier invalide. Vous pouvez utiliser seulement les fichiers *.txt, *.php et *.htm pour votre page de d�marrage.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "Nouvelle discussion";
$lang['createpoll'] = "Cr�er Scrutin";
$lang['search'] = "Chercher";
$lang['searchagain'] = "Chercher encore";
$lang['alldiscussions'] = "Toutes les discussions";
$lang['unreaddiscussions'] = "Discussions non-lues";
$lang['unreadtome'] = "Non-lues &quot;�: Moi&quot;";
$lang['todaysdiscussions'] = "Discussions du jour";
$lang['2daysback'] = "Depuis 2 jours";
$lang['7daysback'] = "Depuis 7 jours";
$lang['highinterest'] = "D'int�r�t �lev�";
$lang['unreadhighinterest'] = "D'int�r�t �lev� non-lues";
$lang['iverecentlyseen'] = "que j'ai r�cemment vues";
$lang['iveignored'] = "que j'ai ignor�es";
$lang['byignoredusers'] = "Par utilisateurs ignor�s";
$lang['ivesubscribedto'] = "auquelles je m'abonne";
$lang['startedbyfriend'] = "Commenc�es par des amis";
$lang['unreadstartedbyfriend'] = "Non-lues commenc�es par amis";
$lang['startedbyme'] = "que j'ai commenc�es";
$lang['unreadtoday'] = "Non-lues aujourd'hui";
$lang['deletedthreads'] = "Fils de discussions supprim�s";
$lang['goexcmark'] = "Allez-y!";
$lang['folderinterest'] = "Niveau d'int�r�t du dossier";
$lang['postnew'] = "Poster nouveau";
$lang['currentthread'] = "Fil de discussion courant";
$lang['highinterest'] = "D'int�r�t �lev�";
$lang['markasread'] = "Marquer comme lues";
$lang['next50discussions'] = "Prochaines 50 discussions";
$lang['visiblediscussions'] = "Discussions Visibles";
$lang['selectedfolder'] = "Dossier s�lectionn�";
$lang['navigate'] = "Naviguer";
$lang['couldnotretrievefolderinformation'] = "Aucun dossier de disponible.";
$lang['nomessagesinthiscategory'] = "Aucun message dans cette cat�gorie. Veuillez s�lectionner un autre, ou";
$lang['clickhere'] = "cliquer ici";
$lang['forallthreads'] = "pour tous les fils de discussion";
$lang['prev50threads'] = "Premiers 50 fil de discussion";
$lang['next50threads'] = "Prochains 50 fils de discussion";
$lang['nextxthreads'] = "Prochains %s fils de discussion";
$lang['threadstartedbytooltip'] = "Thread #%s Started by %s. Viewed %s";
$lang['threadviewedonetime'] = "Vu: 1 fois";
$lang['threadviewedtimes'] = "Vu: %d fois";
$lang['unreadthread'] = "Fil de discussion non-lu";
$lang['readthread'] = "Lire fil de discussion";
$lang['unreadmessages'] = "Messages non-lus";
$lang['subscribed'] = "Abonn�";
$lang['ignorethisfolder'] = "Ignorer ce dossier";
$lang['stopignoringthisfolder'] = "Cesser d'ignorer ce dossier";
$lang['stickythreads'] = "Fils de discussion collants";
$lang['mostunreadposts'] = "Plus de messages non-lus";
$lang['onenew'] = "%d nouveau";
$lang['manynew'] = "%d nouveaux";
$lang['onenewoflength'] = "%d nouveau de %d";
$lang['manynewoflength'] = "%d nouveaux de %d";
$lang['ignorefolderconfirm'] = "�tes-vous certain de vouloir ignorer ce dossier?";
$lang['unignorefolderconfirm'] = "�tes-vous certain de vouloir cesser d'ignorer ce dossier?";
$lang['gotofirstpostinthread'] = "Allez au premier message du fils de discussion";
$lang['gotolastpostinthread'] = "Allez au dernier message du fils de discussion";
$lang['viewmessagesinthisfolderonly'] = "Visualiser les messages dans ce dossier seulement";
$lang['shownext50threads'] = "Montrez les 50 fils de discussion suivants";
$lang['showprev50threads'] = "Montrez les 50 fils de discussion pr�c�dents";
$lang['createnewdiscussioninthisfolder'] = "Cr�ez un nouveau fils de discussion dans ce dossier";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "Caract�re gras";
$lang['italic'] = "Italique";
$lang['underline'] = "Souligner";
$lang['strikethrough'] = "Biffure";
$lang['superscript'] = "Lettre sup�rieure";
$lang['subscript'] = "Indice inf�rieure";
$lang['leftalign'] = "Alignement � gauche";
$lang['center'] = "Centrer";
$lang['rightalign'] = "Alignement � droite";
$lang['numberedlist'] = "Liste �num�r�e";
$lang['list'] = "Liste";
$lang['indenttext'] = "Indenter texte";
$lang['code'] = "Code";
$lang['quote'] = "Citer";
$lang['spoiler'] = "G�cheur";
$lang['horizontalrule'] = "R�gle horizontale";
$lang['image'] = "Image";
$lang['hyperlink'] = "Liens hypertexte";
$lang['noemoticons'] = "D�sactiver les binettes";
$lang['fontface'] = "Police";
$lang['size'] = "Taille de fichier";
$lang['colour'] = "Couleure";
$lang['red'] = "Rouge";
$lang['orange'] = "Orange";
$lang['yellow'] = "Jaune";
$lang['green'] = "Vert";
$lang['blue'] = "Bleu";
$lang['indigo'] = "Indigo";
$lang['violet'] = "Violet";
$lang['white'] = "Blanc";
$lang['black'] = "Noir";
$lang['grey'] = "Gris";
$lang['pink'] = "Rose";
$lang['lightgreen'] = "Vert p�le";
$lang['lightblue'] = "Bleu p�le";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "Statistiques du forum";
$lang['usersactiveinthepasttimeperiod'] = "%s active in the past %s.";

$lang['numactiveguests'] = "<b>%s</b> guests";
$lang['oneactiveguest'] = "<b>1</b> guest";
$lang['numactivemembers'] = "<b>%s</b> members";
$lang['oneactivemember'] = "<b>1</b> member";
$lang['numactiveanonymousmembers'] = "<b>%s</b> anonymous members";
$lang['oneactiveanonymousmember'] = "<b>1</b> anonymous member";

$lang['numthreadscreated'] = "<b>%s</b> threads";
$lang['onethreadcreated'] = "<b>1</b> thread";
$lang['numpostscreated'] = "<b>%s</b> posts";
$lang['onepostcreated'] = "<b>1</b> post";

$lang['younormal'] = "Toi";
$lang['youinvisible'] = "Toi (Invisible)";
$lang['viewcompletelist'] = "Voir liste compl�te";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "Our members have made a total of %s and %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "Longest thread is <b>%s</b> with %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "There have been <b>%s</b> posts made in the last 60 minutes.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "There has been <b>1</b> post made in the last 60 minutes.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "Most posts ever made in a single 60 minute period is <b>%s</b> on %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "We have <b>%s</b> registered members and the newest member is <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "We have %s registered members.";
$lang['wehaveoneregisteredmember'] = "We have one registered member.";
$lang['mostuserseveronlinewasnumondate'] = "Most users ever online was <b>%s</b> on %s.";
$lang['statsdisplayenabled'] = "Affichage de statistiques activ�";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "Mises � jour effectu�es";
$lang['useroptions'] = "Options d'utilisateur";
$lang['markedasread'] = "Marquer comme lu";
$lang['postsoutof'] = "messages sur";
$lang['interest'] = "Int�r�t";
$lang['closedforposting'] = "Ferm� au postage";
$lang['locktitleandfolder'] = "Verrouiller le titre et le dossier";
$lang['deletepostsinthreadbyuser'] = "Supprimer les messages dans le fil de discussion par l'utilisateur";
$lang['deletethread'] = "Supprimer le fil de discussion";
$lang['permenantlydelete'] = "Permenantly Delete";
$lang['movetodeleteditems'] = "Move to Deleted Threads";
$lang['undeletethread'] = "Annuler suppression du fils de discussion";
$lang['threaddeletedpermenantly'] = "Fils de discussion supprimer en permanence. Impossible d'annuler la suppression.";
$lang['markasunread'] = "Marquer comme non-lu";
$lang['makethreadsticky'] = "Rendre le fil de discussion collant";
$lang['threareadstatusupdated'] = "Mise � jour du statut de lecture du fil de discussion r�ussie";
$lang['interestupdated'] = "Mise � jour du statut de l'int�r�t du fil de discussion r�ussie";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "Dictionnaire";
$lang['spellcheck'] = "V�rification d'orthographe";
$lang['notindictionary'] = "Pas dans le dictionnaire";
$lang['changeto'] = "Changer �";
$lang['restartspellcheck'] = "Restart";
$lang['cancelchanges'] = "Cancel Changes";
$lang['initialisingdotdotdot'] = "Initialisation...";
$lang['spellcheckcomplete'] = "Spell check is complete. To restart spell check click restart button below.";
$lang['spellcheck'] = "V�rification d'orthographe";
$lang['noformobj'] = "Aucun objet de forme indiqu� pour texte de retour";
$lang['bodytext'] = "Corps de texte";
$lang['ignore'] = "Ignorer";
$lang['ignoreall'] = "Ignorer tout";
$lang['change'] = "Changer";
$lang['changeall'] = "Changer tout";
$lang['add'] = "Ajouter";
$lang['suggest'] = "Sugg�rer";
$lang['nosuggestions'] = "(aucune suggestion)";
$lang['cancel'] = "Annuler";
$lang['dictionarynotinstalled'] = "Aucun dictionnaire d'installer. Veuillez contacter le propri�taire du forum pour rem�dier cette situation.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "Lecture de messages permis";
$lang['postcreationallowed'] = "Cr�ation de messages permis";
$lang['threadcreationallowed'] = "Cr�ation de fils de discusion permis";
$lang['posteditingallowed'] = "R�vision de message permis";
$lang['postdeletionallowed'] = "Suppression de message permis";
$lang['attachmentsallowed'] = "Fichiers joints permis";
$lang['htmlpostingallowed'] = "Postage avec HTML permis";
$lang['signatureallowed'] = "Signature permis";
$lang['guestaccessallowed'] = "Acc�s aux visiteurs permis";
$lang['postapprovalrequired'] = "Approbation de message requise";

// RSS feeds gubbins

$lang['rssfeed'] = "Alimentation RSS";
$lang['every30mins'] = "Toutes les 30 minutes";
$lang['onceanhour'] = "Une fois par heure";
$lang['every6hours'] = "Toutes les 6 heures";
$lang['every12hours'] = "Toutes les 12 heures";
$lang['onceaday'] = "Une fois par jour";
$lang['rssfeeds'] = "Sources de donn�es RSS";
$lang['feedname'] = "Nom de la source de donn�e";
$lang['feedfoldername'] = "Nom du fichier pour les souces de donn�es";
$lang['feedlocation'] = "Rep�rage de source de donn�es";
$lang['threadtitleprefix'] = "Pr�fix pour titre des fils de discussion";
$lang['feednameandlocation'] = "Nom de la source de donn�es et emplacement";
$lang['feedsettings'] = "Options de la source de donn�es";
$lang['updatefrequency'] = "Fr�quence de mise � jour";
$lang['rssclicktoreadarticle'] = "Cliquer ici pour lire cette article";
$lang['addnewfeed'] = "Ajouter nouvelle source de donn�es";
$lang['editfeed'] = "Modifier source de donn�es";
$lang['feeduseraccount'] = "Nom d'utilisateur de la souce de donn�es";
$lang['noexistingfeeds'] = "Aucune source de donn�es RSS existante trouv�. Pour ajouter une souce de donn�es, veuillez cliquer le bouton ci-dessous";
$lang['rssfeedhelp'] = "Vous pouvez ici r�gler des sources de donn�es RSS pour propagation automatique dans votre forum. Les items des sources de donn�es RSS que vous ajoutez seront cr��s comme fils de discussion auquels vos utilisateurs pourront r�pondre comme si c'�taient des messages normales. Lorsque vous ajouter une source de donn�es RSS, vous devez indiquer le nom d'utilisateur � utiliser pour commencer les fils de discussion, le dossier dans lequel ils seront cr��s et le rep�rage des sources de donn�es. Le rep�rage des sources de donn�es lui-m�me doit �tre accessible via HTTP, sinon les sources de donn�es ne fonctionneront pas.";
$lang['mustspecifyrssfeedname'] = "Vous devez sp�cifier le nom de l'alimentation RSS";
$lang['mustspecifyrssfeeduseraccount'] = "Vous devez sp�cifier le compte d'utilisateur de l'alimentation RSS";
$lang['mustspecifyrssfeedfolder'] = "Vous devez sp�cifier le dossier d'alimentation RSS";
$lang['mustspecifyrssfeedurl'] = "Vous devez sp�cifier l'adresse URL de l'alimentation RSS";
$lang['mustspecifyrssfeedupdatefrequency'] = "Vous devez sp�cifier la fr�quence de mise � jour de l'alimentation RSS";
$lang['unknownrssuseraccount'] = "Compte d'utilisateur RSS inconnu";
$lang['rssfeedsupportshttpurlsonly'] = "L'alimentation RSS supporte uniquement les adresses URL HTTP. Les alimentations prot�g�es (https://) ne sont pas support�es.";
$lang['rssfeedurlformatinvalid'] = "L'adresse URL doit inclure la sp�cification du protocole d'application (ex. http://) et une adresse internet (ex. www.adresseinternet.com).";
$lang['rssfeeduserauthentication'] = "L'alimentation RSS ne supporte pas l'authentication d'utilisateur HTTP";
$lang['successfullyremovedselectedfeeds'] = "Supression des sources de donn�es s�lectionn�es r�ussie";
$lang['successfullyaddedfeed'] = "Ajout de nouvelle souce de donn�es r�ussi";
$lang['successfullyeditedfeed'] = "Modification de la source de donn�e r�ussie";
$lang['failedtoremovefeeds'] = "La suppression de certaines ou de toutes les sources de donn�es s�lectionn�es a �chou�";
$lang['failedtoaddnewrssfeed'] = "L'ajout d'une nouvelle source de donn�es RSS a �chou�";
$lang['failedtoupdaterssfeed'] = "Mise � jour de la source de donn�es RSS a �chou�";
$lang['rssstreamworkingcorrectly'] = "Flux de donn�es RSS semble fonctionner correctement";
$lang['rssstreamnotworkingcorrectly'] = "Flux de donn�es RSS �tait vide ou introuvable";
$lang['invalidfeedidorfeednotfound'] = "Source de donn�es invalide ou source introuvable";

// PM Export Options

$lang['pmexportastype'] = "Exporter comme type";
$lang['pmexporthtml'] = "HTML";
$lang['pmexportxml'] = "XML";
$lang['pmexportplaintext'] = "Texte en clair";
$lang['pmexportmessagesas'] = "Exporter messages comme";
$lang['pmexportonefileforallmessages'] = "Un fichier pour tous les messages";
$lang['pmexportonefilepermessage'] = "Un fichier pour chaque message";
$lang['pmexportattachments'] = "Exporter les fichiers joints";
$lang['pmexportincludestyle'] = "Inclure feuille de style du forum";
$lang['pmexportwordfilter'] = "Appliquer le filtre des mots aux messages";

// Thread merge / split options

$lang['mergesplitthread'] = "Fusionner / Diviser fils de discussion";
$lang['mergewiththreadid'] = "Fusionner avec identification de fils de discussion:";
$lang['postsinthisthreadatstart'] = "Messages dans ce fils de discussion au d�but";
$lang['postsinthisthreadatend'] = "Messages dans ce fils de discussion � la fin";
$lang['reorderpostsintodateorder'] = "Trier par ordre de date";
$lang['splitthreadatpost'] = "Diviser fils de discussion � message:";
$lang['selectedpostsandrepliesonly'] = "Message s�lectionn� et r�ponses seulement";
$lang['selectedandallfollowingposts'] = "Message s�lectionn� et tous les suivants";

$lang['thisthreadhasmoved'] = "<b>Fils de discussion fusionn�s:</b> Ce fils de discussion a d�m�nag� %s";
$lang['thisthreadwasmergedfrom'] = "<b>Fils de discussion fusionn�s:</b> Ce fils de discussion a �t� fusionn� d'ici %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>Division de fils de discussion:</b> Certains messages dans ce fils de discussion ont �t� d�plac� %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>Division de fils de discussion:</b> Certains messages de ce fils de discussion ont �t� d�plac� de %s";

$lang['invalidfunctionarguments'] = "Arguments de fonction invalide";
$lang['couldnotretrieveforumdata'] = "Impossible de r�cup�rer les donn�es du forum";
$lang['cannotmergepolls'] = "Un ou plusieurs fils de discussion est un scrutin. Vous ne pouvez pas fusionner les scrutins";
$lang['couldnotretrievethreaddatamerge'] = "Impossible r�cup�rer les donn�es de fils de discussions d'un ou plusieurs fils de discussion";
$lang['couldnotretrievethreaddatasplit'] = "Impossible de r�cup�rer les donn�es du fils de discussion du fils de discussion source";
$lang['couldnotretrievepostdatamerge'] = "Impossible de r�cup�rer les donn�es des messages d'un ou plusieurs fils de discussion";
$lang['couldnotretrievepostdatasplit'] = "Impossible de r�cup�rer les donn�es des messages du fils de discussion source";
$lang['failedtocreatenewthreadformerge'] = "Cr�ation d'un nouveau fils de discussion pour fusionnement a �chou�";
$lang['failedtocreatenewthreadforsplit'] = "Cr�ation d'un nouveau fils de discussion pour dispersion a �chou�";

// Thread subscriptions

$lang['threadsubscriptions'] = "Abonnement de fils de discussion";
$lang['couldnotupdateinterestonthread'] = "L'int�r�t du fil de discussion '%s' n'a pas pu �tre mise � jour";
$lang['threadinterestsupdatedsuccessfully'] = "Mise � jour du statut de l'int�r�t du fil de discussion r�ussie";
$lang['resetselected'] = "R�initialiser s�lectionn�";
$lang['allthreadtypes'] = "Tous les types de fils de discussion";
$lang['ignoredthreads'] = "Fils de discussion ignor�s";
$lang['highinterestthreads'] = "Fils de discussion � int�r�t �lev�";
$lang['subscribedthreads'] = "Fils de discussion abonn�s";
$lang['currentinterest'] = "Int�r�t actuel";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "You can only add 3 columns. To add a new column close an existing one";
$lang['columnalreadyadded'] = "You have already added this column. If you want to remove it click it's close button";

?>
