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

/* $Id: fr.inc.php,v 1.87 2004-06-19 11:33:17 decoyduck Exp $ */

// French language file Ver 0.3
// By Mark Krywonos and Endo
// All sections are complete but will probabily contain gramattical errors.

// Language character set and text direction options -------------------

$lang['_charset'] = "ISO-8859-1";
$lang['_isocode'] = "fr";    // ISO-639 language code
$lang['_textdir'] = "ltr";  // ltr or rtl; left to right or vice versa


// Common words --------------------------------------------------------

$lang['locked'] = "Verrouill�";
$lang['add'] = "Ajouter";
$lang['advanced'] = "Avan��";
$lang['active'] = "Actif";
$lang['kick'] = "Coup-de-pied";
$lang['remove'] = "Enlever";
$lang['style'] = "Mod�le";
$lang['go'] = "Valider";
$lang['folder'] = "Dossier";
$lang['ignoredfolder'] = "Dossier Ignor�";
$lang['folders'] = "Dossiers";
$lang['thread'] = "fil";
$lang['threads'] = "fils";
$lang['message'] = "Message";
$lang['from'] = "De";
$lang['to'] = "A";
$lang['all_caps'] = "Tous";
$lang['of'] = "de";
$lang['reply'] = "R�pondre";
$lang['delete'] = "Effacement";
$lang['deleted'] = "Supprim�";
$lang['del'] = "Effacer";
$lang['edit'] = "Editer";
$lang['privileges'] = "Privil�ges";
$lang['ignore'] = "D�sactiv�";
$lang['normal'] = "Activ�";
$lang['interested'] = "Int�ress�";
$lang['subscribe'] = "S'abonne";
$lang['apply'] = "S'appliquer";
$lang['submit'] = "Soumettre";
$lang['save'] = "Epargner";
$lang['update'] = "Mise � jour";
$lang['cancel'] = "Annuler";
$lang['continue'] = "Continuer";
$lang['queen'] = "Reine";
$lang['soldier'] = "Soldat";
$lang['worker'] = "Ouvrier";
$lang['worm'] = "Ver";
$lang['wasp'] = "Gu�pe";
$lang['splat'] = "Splat";
$lang['attachment'] = "Attachment";
$lang['attachments'] = "Attachments";
$lang['filename'] = "Nom de fichier";
$lang['dimensions'] = "Dimensions";
$lang['downloaded'] = "T�l�charg�";
$lang['size'] = "Taille";
$lang['time'] = "temps";
$lang['times'] = "temps";
$lang['viewmessage'] = "Regarder le Message";
$lang['messageunavailable'] = "Le message Indisponible";
$lang['logon'] = "Logon";
$lang['status'] = "Statut";
$lang['more'] = "Plus";
$lang['recentvisitors'] = "Visiteurs r�cents";
$lang['username'] = "Nom d'utilisateur";
$lang['clear'] = "Clair";
$lang['action'] = "Action";
$lang['unknown'] = "Inconnu";
$lang['none'] = "aucun";
$lang['preview'] = "Aper�u";
$lang['post'] = "Poste";
$lang['posts'] = "Postes";
$lang['change'] = "Changement";
$lang['yes'] = "Oui";
$lang['no'] = "Non";
$lang['signature'] = "Signature";
$lang['signaturepreview'] = "Aper�u de Signature";
$lang['wasnotfound'] = "pas trouv�";
$lang['back'] = "Dos";
$lang['subject'] = "Sujet";
$lang['close'] = "Fin";
$lang['name'] = "Nom";
$lang['description'] = "Description";
$lang['date'] = "Date";
$lang['view'] = "Vue";
$lang['passwd'] = "Mot de passe";
$lang['ignored'] = "N�glig�";
$lang['guest'] = "Invit�";
$lang['next'] = "Apr�s";
$lang['others'] = "Autres";
$lang['nickname'] = "Surnom";
$lang['emailaddress'] = "Adresse m�l";
$lang['confirm'] = "Confirmer";
$lang['email'] = "Email";
$lang['new'] = "nouveau";
$lang['newcaps'] = "NOUVEAU";
$lang['poll'] = "Sondage";
$lang['friend'] = "Ami";
$lang['error'] = "Erreur";
$lang['reset'] = "Remet � l'�tat initial";
$lang['guesterror_1'] = "D�sol�, vous avez besoin d'�tre abonn� pour utiliser cette caract�ristique.";
$lang['guesterror_2'] = "Login maintenant";
$lang['on'] = "sur";
$lang['unread'] = "non lu";
$lang['all'] = "Tous";
$lang['me_caps'] = "ME";
$lang['by'] = "par";
$lang['permissions'] = "Permissions";
$lang['position'] = "Position";
$lang['or'] = "ou";
$lang['hours'] = "Heures";
$lang['type'] = "Type";
$lang['print'] = "Print";
$lang['sticky'] = "Sticky";
$lang['polls'] = "Sondages";
$lang['user'] = "Utilisateur";
$lang['enabled'] = "Rendu capable";
$lang['disabled'] = "Rendu infirme";
$lang['options'] = "Options";
$lang['emoticons'] = "Emoticons";
$lang['savechanges'] = "Save Changes";
$lang['webtag'] = "Webtag";
$lang['default'] = "default";
$lang['makedefault'] = "Make Default";
$lang['unsetdefault'] = "Unset Default";
$lang['rename'] = "Rename";
$lang['pages'] = "Pages";

// Admin interface (admin*.php) ----------------------------------------

$lang['accessdenied'] = "Acc�s Ni�";
$lang['accessdeniedexp'] = "Vous n'avez pas la permission pour utiliser cette section.";
$lang['managefolders'] = "G�rer des Dossiers";
$lang['managefolder'] = "G�rer le Dossier";
$lang['id'] = "ID";
$lang['foldername'] = "Nom de dossier";
$lang['accesslevel'] = "Niveau d'acc�s";
$lang['move'] = "Mouvement";
$lang['closed'] = "Ferm�";
$lang['open'] = "Ouvrir";
$lang['restricted'] = "Limit�";
$lang['newfolder'] = "Nouveau Dossier";
$lang['forumadmin'] = "Administration de forum";
$lang['adminexp_1'] = "Use the menu on the left to manage things in your forum.";
$lang['adminexp_2'] = "<b>Users</b> allows you to set user permissions, including appointing Editors and gagging people.";
$lang['adminexp_3'] = "Use <b>Manage Forums</b> to add new forums or change existing ones.";
$lang['adminexp_4'] = "<b>Forum Settings</b> allows you to change the current forums settings.";
$lang['adminexp_5'] = "Use <b>Folders</b> to add new folders or change the names of existing ones.";
$lang['adminexp_6'] = "<b>Profiles</b> lets you change the items appearing in user profiles.";
$lang['adminexp_7'] = "Choose <b>Start Page</b> to edit the forum start page.";
$lang['adminexp_8'] = "Using <b>Forum Style</b> allows you to create new colour schemes for the forum.";
$lang['adminexp_9'] = "The words in the <b>Word Filter</b> can be edited.";
$lang['adminexp_10'] = "Look at the <b>Admin Log</b> to see what actions forum moderators have taken recently.";$lang['createforumstyle'] = "Cr�er un Style de Forum";
$lang['newstyle'] = "Nouveau style";
$lang['successfullycreated'] = "avec succ�s cr��.";
$lang['stylesdirnotwritable'] = "L'annuaire de styles n'est pas writeable. S'il vous pla�t CHMOD l'annuaire de styles et juger � nouveau.";
$lang['stylealreadyexists'] = "Un style avec ce nom de fichier existe d�j�.";
$lang['stylenofilename'] = "Vous n'�tes pas entr� un nom de fichier pour Sauvegarder le style avec.";
$lang['stylenotauthorised'] = "Vous n'�tes pas autoris� de cr�er les styles de forum.";
$lang['styleexp'] = "Utiliser cette page pour aider cr�e un style au hasard engendr� pour votre forum.";
$lang['stylecontrols'] = "Contr�les";
$lang['stylecolourexp'] = "Cliqueter sur une couleur pour faire un nouveau stylesheet a bas� sur cette couleur. La couleur actuelle de base est premi�re dans la liste.";
$lang['standardstyle'] = "Style standard";
$lang['rotelementstyle'] = "Le Style tourn� d'El�ment";
$lang['randstyle'] = "Style fait au hasard";
$lang['enterhexcolour'] = "ou entrer une couleur de sort pour baser un nouveau stylesheet sur";
$lang['savestyle'] = "Epargner ce style";
$lang['styledesc'] = "Desc de style.";
$lang['fileallowedchars'] = "(les lettres minuscules (a-z), les num�ros (0-9) et les soulign�s (_) seulement)";
$lang['stylepreview'] = "Aper�u de style";
$lang['welcome'] = "Accueil";
$lang['messagepreview'] = "Aper�u";
$lang['h1tag'] = "H1 Tag";
$lang['subhead'] = "Subhead";
$lang['users'] = "Utilisateurs";
$lang['profiles'] = "Profils";
$lang['manageforums'] = "Manage Forums";
$lang['forumsettings'] = "Forum Settings";
$lang['startpage'] = "Commencer par la page";
$lang['forumstyle'] = "Style de forum";
$lang['forumemoticons'] = "Emoticons de forum";
$lang['wordfilter'] = "Filtre de mot";
$lang['viewlog'] = "Journal de bord de vue";
$lang['invalidop'] = "Op�ration nulle";
$lang['noprofilesectionspecified'] = "Aucune section de Profil a sp�cifi�.";
$lang['newitem'] = "Nouvel Article";
$lang['manageprofileitems'] = "G�rer les Articles de Profil";
$lang['section'] = "Section";
$lang['itemname'] = "Nom d'article";
$lang['moveto'] = "Se transf�re �";
$lang['deleteitem'] = "Effacer l'Article";
$lang['deletesection'] = "Effacer la Section";
$lang['new_caps'] = "NOUVEAU";
$lang['newsection'] = "Nouvelle Section";
$lang['manageprofilesections'] = "G�rer les Sections de Profil";
$lang['sectionname'] = "Nom de section";
$lang['items'] = "Articles";
$lang['startpageupdated'] = "Commencer par la page mise � jour";
$lang['viewupdatedstartpage'] = "Regarder la Page mise � jour de D�marrage";
$lang['editstartpage'] = "Editer la Page de D�marrage";
$lang['editstartpageexp'] = "Utiliser cette page pour �diter la Page de D�marrage sur votre forum.";
$lang['nouserspecified'] = "Aucun utilisateur a sp�cifi� pour �diter.";
$lang['manageuser'] = "G�rer l'Utilisateur";
$lang['manageusers'] = "G�rer des Utilisateurs";
$lang['userstatus'] = "Statut d'utilisateur";
$lang['warning_caps'] = "AVERTISSEMENT";
$lang['userdeleteallpostswarning'] = "Etes-vous s�r que vous voulez effacer tout l'a choisi les postes de l'utilisateur? Une fois les postes ils sont n'effac�s peut pas �tre rapport� et sera perdu � jamais.";
$lang['postssuccessfullydeleted'] = "Les postes ont �t� effac�es avec succ�s.";
$lang['folderaccess'] = "Acc�s de dossier";
$lang['norestrictedfolders'] = "Les dossiers non limit�s";
$lang['possiblealiases'] = "Aliases possible";
$lang['usersettingsupdated'] = "Arrangements D'Utilisateur Avec succ�s Mis � jour";
$lang['nomatches'] = "Aucunes allumettes";
$lang['tobananIPaddress'] = "To ban an IP Address tick the checkbox next to the alias and click the Submit button below";
$lang['cannotipbansoldiers'] = "Vous ne pouvez pas l'interdiction de IP les autres Soldats. Plus bas leur Statut premi�rement.";
$lang['banthisipaddress'] = "Interdire cette adresse de IP";
$lang['noipaddress'] = "Il n'y a pas l'adresse de IP pour ce compte. L'utilisateur ne peut pas �tre interdit par l'adresse de IP.";
$lang['deleteposts'] = "Effacer des Postes";
$lang['deleteallusersposts'] = "Effacer toutes ces postes de l'utilisateur";
$lang['noattachmentsforuser'] = "Aucuns attachements pour cet utilisateur";
$lang['soldierdesc'] = "<b>Soldats</b> peut acc�der � tous outils de mod�ration, mais ne peut pas cr�er ou peut enlever d'autres Soldats.";
$lang['workerdesc'] = "<b>Ouvriers</b> peut �diter ou peut effacer n'importe quelle poste.";
$lang['wormdesc'] = "<b>Vers</b> peut lire des messages et la poste comme normal, mais leurs messages appara�tront effac� � tous autres utilisateurs.";
$lang['waspdesc'] = "<b>Gu�pes</b> peut lire des messages, mais ne peut pas r�pondre ou peut poster de nouveaux messages.";
$lang['splatdesc'] = "<b>Splats</b> Ne peut pas acc�der au forum. Utiliser ceci pour interdire des idiots persistants.";
$lang['aliasdesc'] = "<b>Aliases possible</b> est une liste d'autres utilisateurs qui est derni�re l'adresse de IP enregistr�e �gale cet utilisateur.";
$lang['manageusersexp_1'] = "Cette liste montre une s�lection d'utilisateurs qui ont effectu� une proc�dure d'entr�e � votre forum, tri� par";
$lang['manageusersexp_2'] = "Pour alt�rer une permissions de l'utilisateur cliquetent leur nom.";
$lang['manageusersexp_3'] = "Pour voir que le dernier peu d'utilisateurs � logon, trier la liste par DERNIER_LOGON.";
$lang['lastlogon'] = "Dernier Logon";
$lang['logonfrom'] = "Logon De";
$lang['nouseraccounts'] = "Aucun utilisateur explique dans la base de donn�es.";
$lang['searchforusernotinlist'] = "Cherche un utilisateur pas dans la liste";
$lang['adminaccesslog'] = "Le Journal de bord D'acc�s administratif";
$lang['adminlogexp'] = "Cette liste montre les derni�res actions sanctionn�es par les utilisateurs avec les privil�ges Administratifs.";
$lang['showingactions'] = "Actions de d�monstration";
$lang['inclusive'] = "inclus";
$lang['datetime'] = "Date/Temps";
$lang['unknownuser'] = "Utilisateur inconnu";
$lang['unknownfolder'] = "Dossier inconnu";
$lang['changeduserstatus'] = "Le Statut chang� d'Utilisateur pour l'Utilisateur";
$lang['changedfolderaccess'] = "Le Dossier chang� d'Utilisateur Privs D'acc�s pour l'Utilisateur";
$lang['deletedallusersposts'] = "A effac� Toutes Postes pour l'Utilisateur";
$lang['banneduser'] = "Utilisateur interdit";
$lang['unbanneduser'] = "Unbanned Utilisateur";
$lang['ipaddress'] = "IP adresse";
$lang['ip'] = "IP";
$lang['logged'] = "Not�";
$lang['notlogged'] = "Non not�";
$lang['deleteduser'] = "Utilisateur effac�";
$lang['changedtitleaccessfolder'] = "Les Options chang�es de Dossier pour le dossier";
$lang['movedthreads'] = "A transf�r� fils au dossier";
$lang['creatednewfolder'] = "Cr�� le nouveau dossier";
$lang['changedprofilesectiontitle'] = "Le titre chang� de section de Profil pour la section";
$lang['addednewprofilesection'] = "Suppl�mentaire la Nouvelle section de Profil";
$lang['deletedprofilesection'] = "La Section effac�e de Profil";
$lang['changedprofileitemtitle'] = "Le titre chang� d'Article de Profil pour l'article";
$lang['addednewprofileitem'] = "Suppl�mentaire le Nouvel Article de Profil";
$lang['deletedprofileitem'] = "L'Article effac� de Profil";
$lang['editedstartpage'] = "La Page �dit�e de D�marrage";
$lang['savednewstyle'] = "Epargn� le Nouveau Style";
$lang['movedthread'] = "Fil d�plac�";
$lang['closedthread'] = "Fil ferm�";
$lang['openedthread'] = "Fil ouvert";
$lang['renamedthread'] = "Fil renomm�";
$lang['lockedthreadtitlefolder'] = "Locked Thread Title/Folder";
$lang['unlockedthreadtitlefolder'] = "Unlocked Thread Title/Folder";
$lang['userspostsdeletedinthread'] = "User's Posts Deleted in Thread";
$lang['deleteduserattachmentfrompost'] = "Deleted User's Attachment From Post";
$lang['threaddeleted'] = "Thread Deleted";
$lang['deletedpost'] = "Poste effac�e";
$lang['editedpost'] = "Poste �dit�e";
$lang['editedwordfilter'] = "Le Filtre �dit� de Mot";
$lang['adminlogempty'] = "Le Journal de bord administratif est vide";
$lang['recententries'] = "Entr�es r�centes";
$lang['clearlog'] = "Journal de bord clair";
$lang['wordfilterupdated'] = "Le Filtre de mot a mis � jour";
$lang['editwordfilter'] = "Editer le Filtre de Mot";
$lang['wordfilterexp_1'] = "Utiliser cette page pour �diter le Filtre de Mot pour votre forum. Placer chaque mot �tre filtr� sur une nouvelle ligne.";
$lang['wordfilterexp_2'] = "Perl-les expressions r�guli�res compatibles peuvent �tre utilis�es aussi pour �galer des mots si vous savez.";
$lang['wordfilterexp_3'] = "Utiliser cette page pour �diter votre filtre personnel de mot. Placer chaque mot �tre filtr� sur une nouvelle ligne.";
$lang['wordfilterisfull'] = "You cannot add any more word filters. Remove some unused ones or edit the existing ones first.";
$lang['allow'] = "Permettre";
$lang['normalthreadsonly'] = "Les fils normaux seulement";
$lang['pollthreadsonly'] = "Le sondage enfile seulement";
$lang['both'] = "Les deux fil tape";
$lang['existingpermissions'] = "Permissions existantes";
$lang['folderisnotrestricted'] = "Le dossier n'est pas limit�. R�gler c'est le Niveau D'acc�s � A Limit� avant des utilisateurs ajoute/enlevant";
$lang['nousers'] = "Aucuns utilisateurs";
$lang['addnewuser'] = "Ajouter le Nouvel Utilisateur";
$lang['adduser'] = "Ajouter l'Utilisateur";
$lang['searchforuser'] = "Cherche l'Utilisateur";
$lang['browsernegotiation'] = "Choix du navigateur par d�faut";
$lang['largetextfield'] = "Le grand Champ de Texte";
$lang['mediumtextfield'] = "Le Champ moyen de Texte";
$lang['smalltextfield'] = "Le petit Champ de Texte";
$lang['multilinetextfield'] = "Le Champ de Texte de Multiline";
$lang['radiobuttons'] = "Le radio Boutonne";
$lang['dropdown'] = "Tomber en bas";
$lang['threadcount'] = "Compte de fil";
$lang['fieldtypeexample1'] = "Pour les Boutons de Radio et le D�pot en bas Champs vous avez besoin d'� seperate le fieldname et les valeurs avec un deux points et chaque valeur devraient �tre seperated par le point virgule.";
$lang['fieldtypeexample2'] = "L'exemple: cr�er un boutons de radio de Sexe fondamentaux, avec deux s�lections pour M�le et Femelle, vous entreriez: <b>Le sexe: m�le; la femelle</b> dans le champ de Nom d'Article.";
$lang['madethreadsticky'] = "Fait Enfiler Collant";
$lang['madethreadnonsticky'] = "Le Fil fait Non-Collant";
$lang['editedforumsettings'] = "Edited Forum Settings";
$lang['sessionsuccessfullyended'] = "Session successfully ended for user";
$lang['endedsessionforuser'] = "Ended session for user";
$lang['matchedtext'] = "Texte Assorti";
$lang['replacementtext'] = "Texte De rechange";
$lang['preg'] = "PREG";
$lang['wholeword'] = "Whole Word";
$lang['word_filter_help_1'] = "<b>All</b> matches against the whole text so filtering mom to mum will also change moment to mument.";
$lang['word_filter_help_2'] = "<b>Whole Word</b> matches against whole words only so filtering mom to mum will NOT change moment to mument.";
$lang['word_filter_help_3'] = "<b>PREG</b> allows you to use Perl Regular Expressions to match text.";
$lang['webtaginvalidchars'] = "Webtag can only contain uppercase A-Z, 0-9, _ - characters";
$lang['warningnoforums'] = "WARNING: You have no forums set up.";
$lang['forumdeletewarning'] = "Are you sure you want to delete the selected forum? Once the forum is deleted it's entire contents is lost forever and cannot be recovered.";
$lang['deleteforum'] = "Delete Forum";
$lang['defaultforum'] = "Default Forum";
$lang['successfullycreatedforum'] = "Successfully created forum";
$lang['failedtocreateforum_1'] = "Failed to create forum";
$lang['failedtocreateforum_2'] = "Please check to make sure the webtag and table names aren't already in use.";
$lang['moveposts'] = "Move Posts";
$lang['movepoststofolder'] = "Move posts to folder";
$lang['allowfoldertocontain'] = "Allow folder to contain";
$lang['mustenterfoldername'] = "You must enter a folder name";
$lang['invalidfolderid'] = "Invalid Folder ID. Check that a folder with this ID exists!";
$lang['nofolderidspecified'] = "No Folder ID specified";
$lang['successfullyaddedfolder'] = "Successfully Added Folder";
$lang['successfullydeletedfolder'] = "Successfully Deleted Folder";
$lang['forumisnotrestricted'] = "Forum is not restricted";
$lang['noforumidspecified'] = "No Forum ID specified";
$lang['usergroups'] = "User Groups";
$lang['nameanddesc'] = "Name and Description";
$lang['groups'] = "Groups";
$lang['addnewgroup'] = "Add New Group";
$lang['nousergroups'] = "No User Groups have been set up";
$lang['suppliedgidisnotausergroup'] = "Supplied GID is not a user group";
$lang['manageusergroups'] = "Manage User Groups";
$lang['groupstatus'] = "Group Status";
$lang['addusergroup'] = "Add Group";
$lang['addremoveusers'] = "Add/Remove Users";
$lang['addtogroup'] = "Add to group";
$lang['nousersingroup'] = "There are no users in this group";
$lang['deletegroups'] = "Delete Groups";

$lang['successfullyaddedgroup'] = "Successfully added group";
$lang['successfullydeletedgroup'] = "Successfully deleted group";

$lang['useringroups'] = "This user is a member of the following groups";
$lang['usernotinanygroups'] = "This user is not in any user groups";
$lang['usergroupwarning'] = "Note: This user may be inheriting additional permissions from any user groups listed below.";

$lang['usercanaccessadmintools'] = "User can access admin tools";
$lang['userisbanned'] = "User is banned";
$lang['useriswormed'] = "User is wormed";

$lang['groupcanaccessadmintools'] = "Group can access admin tools";
$lang['groupisbanned'] = "Group is banned";
$lang['groupiswormed'] = "Group is wormed";

$lang['readposts'] = "Read Posts";
$lang['replytothreads'] = "Reply to threads";
$lang['createnewthreads'] = "Create new threads";
$lang['editposts'] = "Edit posts";
$lang['uploadattachments'] = "Upload attachments";
$lang['moderatefolder'] = "Moderate folder";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumname'] = "You must supply a forum name";
$lang['mustsupplyforumemail'] = "You must supply a forum email address";
$lang['mustchoosedefaultstyle'] = "You must choose a default forum style";
$lang['mustchoosedefaultemoticons'] = "You must choose default forum emoticons";
$lang['unknownstylename'] = "Unknown style name";
$lang['unknownemoticonsname'] = "Unknown emoticons name";
$lang['unknownlanguage'] = "Unknown language";
$lang['mustchoosedefaultlang'] = "You must choose a default forum language";
$lang['activesessiongreaterthansession'] = "Active session timeout cannot be greater than session timeout";
$lang['attachmentdirnotwritable'] = "Choosen attachment directory and it's parent directory must be writable by PHP";
$lang['attachmentdirblank'] = "You must supply a directory to save attachments in";
$lang['mainsettings'] = "Main Settings";
$lang['forumname'] = "Forum Name";
$lang['forumemail'] = "Forum Email";
$lang['forumdesc'] = "Forum Description";
$lang['forumkeywords'] = "Forum Keywords";
$lang['defaultstyle'] = "Default Style";
$lang['defaultemoticons'] = "Default Emoticons";
$lang['defaultlanguage'] = "Default Language";
$lang['errorhandler'] = "Error Handler";
$lang['showfriendlyerrors'] = "Show Friendly Error Messages";
$lang['gzipcompression'] = "GZIP Compression";
$lang['compresspagesusinggzip'] = "Compress pages using GZIP";
$lang['gzipcompressionlevel'] = "GZIP Compression Level";
$lang['cookieoptions'] = "Cookie Options";
$lang['cookiedomain'] = "Cookie Domain";
$lang['postoptions'] = "Post Options";
$lang['allowpostoptions'] = "Allow Post Editing";
$lang['postedittimeout'] = "Post Edit Timeout";
$lang['maximumpostlength'] = "Maximum Post Length";
$lang['allowcreationofpolls'] = "Allow creation of polls";
$lang['searchoptions'] = "Search Options";
$lang['minsearchwordlength'] = "Min search word length";
$lang['sessions'] = "Sessions";
$lang['sessioncutoffseconds'] = "Session cut off (seconds)";
$lang['activesessioncutoffseconds'] = "Active session cut off (seconds)";
$lang['stats'] = "stats";
$lang['enablestatsdisplay'] = "Enable Stats Display at bottom of message pane";
$lang['personalmessages'] = "Personal Messages";
$lang['enablepersonalmessages'] = "Enable Personal Messages";
$lang['allowpmstohaveattachments'] = "Allow Personal Messages to have attachments";
$lang['guestaccount'] = "Guest Account";
$lang['enableguestaccount'] = "Enable Guest Account";
$lang['autologinguests'] = "Automatically Login Guests";
$lang['enableattachments'] = "Enable Attachments";
$lang['attachmentdir'] = "Attachment Dir";
$lang['userattachmentspace'] = "Attachment space per user";
$lang['showdeletedattachments'] = "Show Deleted Attachments in messages";
$lang['allowembeddingofattachments'] = "Allow embedding of attachments in messages / signatures";
$lang['usealtattachmentmethod'] = "Use Alternative attachment method";
$lang['forumsettingsupdated'] = "Forum settings successfully updated";
$lang['pmuserspace'] = "PM space per user";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_1'] = "Beehive can make use of it's own error handler to show more friendly error messages than the default PHP ones. However, this setting can cause problems with some versions of PHP so if you encounter any problems with blank pages with this option switched on you should switch it off.";
$lang['forum_settings_help_2'] = "This setting enables the built in GZIP compression in Beehive. Compressing the output of the scripts can save you considerable amounts of bandwidth, but it can also increase the CPU load on the server and slow things down.";
$lang['forum_settings_help_3'] = "If your server is running PHP 4.2.0 or higher you can also change the maximum level of compression that should be used. The higher the level used the higher the server load.";
$lang['forum_settings_help_4'] = "<b>WARNING:</b> If you are using mod_gzip or any other gzipping module to handle the compression of PHP scripts on your web server, do <b>NOT</b> enable the built in GZIP compression in Beehive, otherwise your forum may become inaccessible.";
$lang['forum_settings_help_5'] = "This setting specifies the domain name that the cookies set by Beehive should use. This is useful for situations where there is more than one access point for your forum.";
$lang['forum_settings_help_6'] = "For example supposed the following URLs are both valid access points for the same forum:";
$lang['forum_settings_help_7'] = "http://forum.mybeehiveforum.net/<br />http://www.mybeehiveforum.net/forum/";
$lang['forum_settings_help_8'] = "To prevent users from having to login in twice at each access point, you could set the above value to &quot;mybeehiveforum.net&quot; and the cookies for both the logon page and the main session cookies will work for both URLs.";
$lang['forum_settings_help_9'] = "<b>WARNING:</b> Do not change this if you do not understand what it does. Setting it to an invalid or incorrect value will make your forum inaccessible.";
$lang['forum_settings_help_10'] = "<b>Post Edit Timeout</b> is the time in hours after posting that a user can edit their post. If set to 0 there is no limit.";
$lang['forum_settings_help_11'] = "<b>Maximum Post Length</b> is the maximum number of characters that will be displayed in a post. If a post is longer than the number of characters defined here it will be cut short and a link added to the bottom to allow users to read the whole post on a seperate page.";
$lang['forum_settings_help_12'] = "If you don't want your users to be able to create polls you can disable the above option.";
$lang['forum_settings_help_13'] = "This settings defines the mimumum word length that is allowed to to be searched for in AND and OR based searches. Words smaller than the value specified will be removed from the query automatically. Exact phrase searches are not effected by this setting";
$lang['forum_settings_help_14'] = "<b>Session cut off</b> is the maximum time before a user's session is deemed dead and they are logged out. By default this is 24 hours (86400 seconds).";
$lang['forum_settings_help_15'] = "<b>Active session cut off</b> is the maximum time before a user's is deemed inactive at which point they enter an idle state. In this state the user remains logged in, but they are removed from the active users list in the stats display. Once they become active again they will be re-added to the list. By default this setting is set to 15 minutes (900 seconds).";
$lang['forum_settings_help_16'] = "Enabling this option allows Beehive to include a stats display at the bottom of the messages pane similar to the one used by many forum software titles. Once enabled the display of the stats page can be toggled individually by each user. If they don't want to see it they can hide it from view.";
$lang['forum_settings_help_17'] = "Personal Messages are invaluable as a way of taking more private matters out of view of the other members. However if you don't want your users to be able to send each other PMs you can disable this option.";
$lang['forum_settings_help_18'] = "Personal Messages can also contain attachments which can be useful for exchanging files between users.";
$lang['forum_settings_help_19'] = "<b>Note:</b> The space allocation for PM attachments is taken from each users' main attachment allocation and it not in addition to. ";
$lang['forum_settings_help_20'] = "The guest account allows visitors to your forum to read posts without having to sign up for an account.";
$lang['forum_settings_help_21'] = "If you prefer you can also setup your BeehiveForum so that guests are automatically logged in. Once a user registers they will always be shown the login screen as long as their cookies remain intact.";
$lang['forum_settings_help_22'] = "Beehive allows attachments to be uploaed to messages when posted. If you have limited webspace you may which to disable attachments by unticking the box above.";
$lang['forum_settings_help_23'] = "<b>Attachment Dir</b> is the location Beehive should store it's attachments in. This directory must exist on your webspace and must be writable by the webserver / PHP process otherwise uploads will fail.";
$lang['forum_settings_help_24'] = "<b>Attachment Space Per User</b> is the maximum amount of disk space a user has for attachments. Once this space is used up the user cannot upload any more attachments. By default this is 1MB of space.";
$lang['forum_settings_help_25'] = "<b>Show Deleted Attachments in messages</b> forces Beehive to keep filenames of previously deleted attachments visible in the posts they were attached to. This can help accountability of who upload what and where. If you don't want or need this functionality you can disable it.";
$lang['forum_settings_help_26'] = "<b>Allow embedding of attachments in messages / signatures</b> allows users to embed attachments in posts. Enabling this option while useful can increase your bandwidth usage drastically under certain configurations of PHP. If you have limited bandwidth it is recommended that you disable this option.";
$lang['forum_settings_help_27'] = "<b>Use Alternative attachment method</b> Forces Beehive to use an alternative retrieval method for attachments. If you receive 404 error messages when trying to download attachments from messages try enabling this option.";

// Attachments (attachments.php, getattachment.php) ---------------------------------------

$lang['aidnotspecified'] = "AID pas sp�cifi�.";
$lang['upload'] = "T�l�charger";
$lang['uploadnewattachment'] = "Nouvel Attachement De T�l�chargement";
$lang['waitdotdot'] = "attente..";
$lang['attachmentnospace'] = "D�sol�, vous n'avez pas l'espace assez d'attachement libre. S'il vous pla�t lib�rer quelque espace et essaie encore.";
$lang['successfullyuploaded'] = "Avec succ�s T�l�charg�";
$lang['uploadfailed'] = "T�l�charger Echou�";
$lang['errorfilesizeis0'] = "L'erreur: Filesize doit �tre plus grand que 0 octets";
$lang['complete'] = "Complet";
$lang['uploadattachment'] = "T�l�charger un fichier pour l'attachement � le message";
$lang['enterfilenamestoupload'] = "Entrer le nom(s) de fichier pour t�l�charger";
$lang['nowpress'] = "Maintenant la presse";
$lang['ifdoneattachingfiles'] = "Si vous �tes fait de fichier attachant, la presse";
$lang['attachmentsforthismessage'] = "Les attachements pour ce message";
$lang['otherattachmentsincludingpm'] = "Les autres Attachements (y compris PM les Messages)";
$lang['totalsize'] = "Taille totale";
$lang['freespace'] = "Espace libre";
$lang['attachmentproblem'] = "Il y avait un probl�me t�l�chargeant cet attachement. S'il vous pla�t essayer encore plus tard.";
$lang['removefile'] = "Remove File";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "Le mot de passe a chang�";
$lang['passedchangedexp'] = "Votre mot de passe a �t� chang�.";
$lang['gotologin'] = "Valider � l'�cran de Login";
$lang['updatefailed'] = "Met � jour �chou�";
$lang['passwdsdonotmatch'] = "Passwords do not match.";
$lang['allfieldsrequired'] = "Les mots de passe pas allumette. ";
$lang['invalidaccess'] = "Acc�s nul";
$lang['requiredinformationnotfound'] = "L'information exigere n'a pas trouv�";
$lang['forgotpasswd'] = "Mot de passe oubli�";
$lang['enternewpasswdforuser'] = "Entrer un nouveau mot de passe pour l'utilisateur";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "Aucun message a sp�cifi� pour la suppression";
$lang['postdelsuccessfully'] = "Poster effac� avec succ�s";
$lang['errordelpost'] = "L'erreur efface la poste";
$lang['delthismessage'] = "Effacer ce message";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "Aucun message a sp�cifi� pour �diter";
$lang['edited_caps'] = "EDITE";
$lang['editappliedtomessage'] = "Editer Appliqu� au Message";
$lang['editappliedtopoll'] = "Editer Est Appliqu� Interroger";
$lang['errorupdatingpost'] = "L'erreur met � jour la poste";
$lang['editmessage'] = "Editer le message";
$lang['edittext'] = "Editer le texte";
$lang['editHTML'] = "Editer HTML";
$lang['editpollwarning'] = "<b>Note</b>: Editer n'importe quel aspect d'un sondage fera vide tout le courant vote et permet des gens pour voter encore.";
$lang['changewhenpollcloses'] = "Change quand le sondage ferme? ";
$lang['nochange'] = "Aucun changement";
$lang['emailresult'] = "Email r�sultat";
$lang['msgsent'] = "Le message a envoy�";
$lang['msgfail'] = "Envoyer l'�chec de syst�me. Le message n'a pas envoy�.";
$lang['nopermissiontoedit'] = "Vous n'�tes pas permis d'�diter ce message.";
$lang['pollediterror'] = "Vous ne pouvez pas �diter de sondage";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "Aucun utilisateur sp�cifi� pour envoie un e-mail �.";
$lang['entersubjectformessage'] = "Entrer un sujet pour le message";
$lang['entercontentformessage'] = "Entrer quelque contenu pour le message";
$lang['msgsentfrombeehiveforumby'] = "Ce message a �t� envoy� d'un Forum de Ruche par";
$lang['subject'] = "Sujet";
$lang['send'] = "Envoyer";
$lang['msgnotificationemail_1'] = "a post� un message � vous sur";
$lang['msgnotificationemail_2'] = "Le sujet est";
$lang['msgnotificationemail_3'] = "Pour lire ce message et ces autres dans la discussion pareille, Valider �";
$lang['msgnotificationemail_4'] = "Note: Si vous ne souhaitez pas recevoir les notifications d'e-mail de messages de Forum";
$lang['msgnotificationemail_5'] = "post� � vous, allez �";
$lang['msgnotificationemail_6'] = "d�clic";
$lang['msgnotificationemail_7'] = "sur les Pr�f�rences, des�lectionner la case de pointage de Notification d'E-mail et la presse Soumet.";
$lang['msgnotification_subject'] = "La Notification de message de";
$lang['subnotification_1'] = "a post� un message dans un fil vous";
$lang['subnotification_2'] = "s'est abonn� � sur";
$lang['subnotification_3'] = "Le sujet est";
$lang['subnotification_4'] = "Pour lire ce message et ces autres dans la discussion pareille, Valider �";
$lang['subnotification_5'] = "Note: Si vous ne souhaitez pas recevoir les notifications d'e-mail de nouveaux messages";
$lang['subnotification_6'] = "dans ce fil, Valider �";
$lang['subnotification_7'] = "et ajuster votre niveau d'Int�r�t � la fin de la page.";
$lang['subnotification_subject'] = "La Notification de souscription de";
$lang['pmnotification_1'] = "a post� un PM � vous sur";
$lang['pmnotification_2'] = "Le sujet est";
$lang['pmnotification_3'] = "Pour lire le message va �";
$lang['pmnotification_4'] = "Note: Si vous ne souhaitez pas recevoir les notifications d'e-mail de PM les messages";
$lang['pmnotification_5'] = "post� � vous, allez �";
$lang['pmnotification_6'] = "d�clic";
$lang['pmnotification_7'] = "sur les Pr�f�rences, des�lectionner le PM la case de pointage de Notification d'E-mail et la presse Soumettent.";
$lang['pmnotification_subject'] = "PM la Notification de";
$lang['hasoptedoutofemail'] = "has opted out of email contact";
$lang['hasinvalidemailaddress'] = "has an invalid email address";

// Error handler (errorhandler.inc.php) --------------------------------

$lang['errorpleasewaitandretry'] = "Une erreur a arriv�.
S'il vous pla�t attendre quelques minutes et alors cliqueter le Juger au Nouveau bouton au dessous.";
$lang['retry'] = "Juger � nouveau";
$lang['multipleerroronpost'] = "Cette erreur a arriv� plus qu'une fois en tentant la poster/avant-premi�re votre message. Pour votre convienience nous avons inclus votre texte de message et le cas �ch�ant le fil et le message num�rotent vous r�pondiez � au dessous. Vous pouvez souhaiter Sauvegarder une copie du texte ailleurs jusqu'� ce que le forum est disponible encore. .";
$lang['replymsgnumber'] = "Le Num�ro de Message de r�ponse";
$lang['errormsgfordevs'] = "Le Message d'erreur pour les administrations de serveur et les entrepreneurs";

// Forgotten passwords (forgot_pw.php) ---------------------------------

$lang['forgotpwemail_1'] = "Vous avez demand� cet e-mail de";
$lang['forgotpwemail_2'] = "parce que vous avez oubli� votre mot de passe.";
$lang['forgotpwemail_3'] = "Cliqueter le lien au dessous (ou la copie et le colle dans votre navigateur) remettre � l'�tat initial votre mot de passe";
$lang['passwdresetrequest'] = "Votre mot de passe remet � l'�tat initial la demande";
$lang['passwdresetemailsent'] = "Le mot de passe remet � l'�tat initial l'e-mail envoy�";
$lang['passwdresetexp_1'] = "Vous devez recevoir un e-mail contient";
$lang['passwdresetexp_2'] = "un lien pour remettre � l'�tat initial votre mot de passe bient�t.";
$lang['validusernamerequired'] = "Un username valide est exig�";
$lang['forgotpasswd'] = "Mot de passe oubli�";
$lang['forgotpasswdexp_1'] = "Entrer votre nom de logon au-dessus de et un e-mail contenant un lien permet";
$lang['forgotpasswdexp_2'] = "vous changer votre mot de passe sera envoy� � votre Adresse m�l enregistr�e";
$lang['couldnotsendpasswordreminder'] = "vous changer votre mot de passe sera envoy� � votre Adresse m�l enregistr�e.";
$lang['request'] = "Demande";

// Frameset things (index.php) -----------------------------------------

$lang['noframessupport'] = "Oops, votre navigateur dit qu'il ne soutient pas de cadre";
$lang['uselightversion'] = "Vous avez besoin d'utiliser la version de HTML l�g�re du forum <a href=\"llogon.php\">here</a>.";

// Links database (links*.php) -----------------------------------------

$lang['maynotaccessthissection'] = "Vous ne pouvez pas acc�der � cette section.";
$lang['toplevel'] = "Premier Niveau";
$lang['links'] = "Liens";
$lang['viewmode'] = "Regarder le Mode";
$lang['hierarchical'] = "Hi�rarchique";
$lang['list'] = "Liste";
$lang['folderhidden'] = "Ce dossier est cach�";
$lang['hide'] = "peau";
$lang['unhide'] = "unhide";
$lang['nosubfolders'] = "Aucun subfolders dans cette cat�gorie";
$lang['1subfolder'] = "1 subfolder dans cette cat�gorie";
$lang['subfoldersinthiscategory'] = "subfolders dans cette cat�gorie";
$lang['linksdelexp'] = "Les entr�es dans un dossier effac� seront transf�r�es au dossier de parent. Seulement les dossiers qui ne contiennent pas subfolders peuvent �tre effac�s.";
$lang['listview'] = "Vue de liste";
$lang['listviewcannotaddfolders'] = "Ne peut pas ajouter de dossier dans cette vue. Le maximum de d�monstration 30 entr�es.";
$lang['rating'] = "Classement";
$lang['commentsslashvote'] = "Les commentaires / le Vote";
$lang['nolinksinfolder'] = "Aucuns liens dans ce dossier.";
$lang['addlinkhere'] = "Ajouter le lien ici";
$lang['notvalidURI'] = "Cela n'est pas un URI valide!";
$lang['mustspecifyname'] = "Vous devez sp�cifier un nom!";
$lang['mustspecifyvalidfolder'] = "Vous devez sp�cifier un dossier valide!";
$lang['mustspecifyfolder'] = "Vous devez sp�cifier un dossier!";
$lang['addlink'] = "Ajouter un lien";
$lang['addinglinkin'] = "Ajouter un lien";
$lang['addressurluri'] = "Adresse (URL/URI)";
$lang['addnewfolder'] = "Ajouter un nouveau dossier";
$lang['addnewfolderunder'] = "Ajoutant le nouveau dossier sous";
$lang['mustchooserating'] = "Vous devez choisir un classement!";
$lang['commentadded'] = "Your comment was added.";
$lang['musttypecomment'] = "Votre commentaire a �t� ajout�!";
$lang['mustprovidelinkID'] = "Vous devez fournir une ID de lien!";
$lang['invalidlinkID'] = "La ID nulle de lien!";
$lang['address'] = "Adresse";
$lang['submittedby'] = "Soumis par";
$lang['clicks'] = "D�clics";
$lang['rating'] = "Classement";
$lang['vote'] = "Vote";
$lang['votes'] = "Votes";
$lang['notratedyet'] = "Pas �valu� par n'importe qui pourtant";
$lang['rate'] = "Taux";
$lang['bad'] = "Mauvais";
$lang['good'] = "Bon";
$lang['voteexcmark'] = "Vote!";
$lang['commentby'] = "Commenter par";
$lang['nocommentsposted'] = "Aucuns commentaires ont �t� pourtant post�s.";
$lang['addacommentabout'] = "Ajouter un commentaire de";
$lang['modtools'] = "Outils de mod�ration";
$lang['editname'] = "Editer le nom";
$lang['editaddress'] = "Editer l'adresse";
$lang['editdescription'] = "Editer la description";
$lang['moveto'] = "Se transf�re �";
$lang['linkdetails'] = "Link Details";
$lang['addcomment'] = "Add Comment";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "Utilisateur ID";
$lang['alreadyloggedin'] = "a abonn� d�j�";
$lang['loggedinsuccessfully'] = "Vous avez abonn� avec succ�s.";
$lang['presscontinuetoresend'] = "Press Continue to resend form data or cancel to reload page.";
$lang['usernameorpasswdnotvalid'] = "Le username ou le mot de passe que vous n'avez pas fourni est valide.";
$lang['usernameandpasswdrequired'] = "Un username et le mot de passe est exig�";
$lang['welcometolight'] = "Bienvenu pour Suivre un r�gime la Ruche!";
$lang['pleasereenterpasswd'] = "S'il vous pla�t revient dans votre mot de passe et essaie encore.";
$lang['rememberpasswds'] = "Se souvenir des mots de passe";
$lang['rememberpassword'] = "Se souvenir des mots de passe";
$lang['enterasa'] = "Entrer comme un";
$lang['donthaveanaccount'] = "Ne pas avoir un compte?";
$lang['problemsloggingon'] = "Les probl�mes effectuant une proc�dure d'entr�e?";
$lang['deletecookies'] = "Effacer  Cookies";
$lang['cookiessuccessfullydeleted'] = "Cookies successfully deleted";
$lang['forgottenpasswd'] = "Oubli� votre mot de passe?";
$lang['usingaPDA'] = "L'utilisation un PDA?";
$lang['lightHTMLversion'] = "La version l�g�re de HTML";
$lang['youhaveloggedout'] = "Vous avez not� hors.";
$lang['currentlyloggedinas'] = "Vous �tes actuellement abonn�s comme";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "My Forums";
$lang['recentlyvisitedforums'] = "Recently Visited Forums";
$lang['availableforums'] = "Available Forums";
$lang['favouriteforums'] = "Favourite Forums";
$lang['lastvisited'] = "Last Visited";
$lang['unreadmessages'] = "Unread Messages";
$lang['removefromfavourites'] = "Remove From Favourites";
$lang['addtofavourites'] = "Add To Favourites";
$lang['availableforums'] = "Available Forums";
$lang['noforumsavailable'] = "There are no forums available.";
$lang['noforumsavailablelogin'] = "There are no forums available. Please login to view your forums.";
$lang['defaultforumsettings'] = "Default Forum Settings";
$lang['unnamedforum'] = "Unnamed Forum";
$lang['enterpasswd'] = "Enter Password";
$lang['passwdprotectedforum'] = "Password Protected Forum";
$lang['passwdprotectedwarning'] = "This forum is password protected. To gain access enter the password below.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "Poster le message";
$lang['selectfolder'] = "Dossier privil�gi�";
$lang['messagecontainsHTML'] = "Le message contient de l'HTML";
$lang['notincludingsignature'] = "(pas y compris la signature)";
$lang['mustenterpostcontent'] = "Vous devez entrer quelque contenu pour la poste!";
$lang['messagepreview'] = "Aper�u";
$lang['invalidusername'] = "Username nul!";
$lang['mustenterthreadtitle'] = "Vous devez entrer un titre pour le fil!";
$lang['pleaseselectfolder'] = "S'il vous pla�t choisir un dossier!";
$lang['errorcreatingpost'] = "L'erreur cr�e la poste! S'il vous pla�t essayer encore dans quelques minutes.";
$lang['createnewthread'] = "Cr�er le nouveau fil";
$lang['postreply'] = "En r�ponse �";
$lang['threadtitle'] = "Titre de fil";
$lang['messagehasbeendeleted'] = "Le message a �t� effac�.";
$lang['converttoHTML'] = "Convertir � HTML";
$lang['pleaseentermembername'] = "S'il vous pla�t entrer un membername:";
$lang['cannotpostthisthreadtypeinfolder'] = "Vous ne pouvez pas poster ce fil tape ce dossier!";
$lang['cannotpostthisthreadtype'] = "Vous ne pouvez pas poster ce type de fil comme il n'y a pas de dossiers disponibles qui il permettent.";
$lang['threadisclosedforposting'] = "Ce fil est ferm�, vous ne pouvez pas poster dans il!";
$lang['moderatorthreadclosed'] = "L'avertissement: ce fil est ferm� pour poster aux utilisateurs normaux.";
$lang['threadclosed'] = "Enfiler ferm�";
$lang['usersinthread'] = "Les utilisateurs dans le fil";
$lang['correctedcode'] = "Code corrig�";
$lang['submittedcode'] = "Code soumis";
$lang['htmlinmessage'] = "HTML dans le message";
$lang['enabledwithautolinebreaks'] = "Rendu capable avec l'auto-linebreaks";
$lang['fixhtmlexplanation'] = "Ce forum utilise filtrer de HTML. Votre HTML soumis a �t� modifi� par les filtres � certains �gards.\\n\\nPour regarder votre code original, choisir le \\'Submitted code\\' radio button.\\nPour regarder le code modifi�, choisir le \\'Corrected code\\' radio button.";
$lang['messageoptions'] = "Options de message";
$lang['notallowedembedattachmentpost'] = "Vous n'�tes pas permis d'enfoncer des attachements dans vos postes.";
$lang['notallowedembedattachmentsignature'] = "Vous n'�tes pas permis d'enfoncer des attachements dans votre signature.";
$lang['reducemessagelength'] = "Message length must be under 65,535 characters (currently: ";
$lang['reducesiglength'] = "Signature length must be under 65,535 characters (currently: ";
$lang['cannotdeletepostsinthisfolder'] = "You cannot delete posts in this folder";
$lang['cannoteditpostsinthisfolder'] = "You cannot edit posts in this folder";
$lang['cannotcreatethreadinfolder'] = "You cannot create new threads in this folder";
$lang['cannotcreatepostinfolder'] = "You cannot reply to posts in this folder";
$lang['cannotattachfilesinfolder'] = "You cannot post attachments in this folder. Remove attachments to continue.";

// Message display (messages.php) --------------------------------------

$lang['inreplyto'] = "En r�ponse �";
$lang['showmessages'] = "Montrer des messages";
$lang['ratemyinterest'] = "Evaluer mon int�r�t";
$lang['adjtextsize'] = "Ajuster la taille de texte";
$lang['smaller'] = "Plus petit";
$lang['larger'] = "Plus grand";
$lang['faq'] = "FAQ";
$lang['docs'] = "Docs";
$lang['support'] = "Soutien";
$lang['threadcouldnotbefound'] = "Le fil demand� ne pourrait pas �tre trouv� ou acc�de � a �t� ni�.";
$lang['mustselectpolloption'] = "Vous devez choisir une option pour voter pour!";
$lang['keepreading'] = "Garder la lecture";
$lang['backtothreadlist'] = "Le dos pour enfiler la liste";
$lang['postdoesnotexist'] = "Cette poste n'existe pas dans ce fil!";
$lang['clicktochangevote'] = "Le d�clic pour changer le vote";
$lang['youvotedforoption'] = "Vous avez vot� pour l'option";
$lang['youvotedforoptions'] = "Vous avez vot� pour les options";
$lang['clicktovote'] = "Le d�clic pour voter";
$lang['youhavenotvoted'] = "Vous n'avez pas vot�";
$lang['viewresults'] = "La vue R�sulte";
$lang['msgtruncated'] = "Le message A Tronqu�";
$lang['viewfullmsg'] = "Regarder le message plein";
$lang['ignoredmsg'] = "Message n�glig�";
$lang['wormeduser'] = "Wormed utilisateur";
$lang['ignoredsig'] = "Signature n�glig�e";
$lang['wasdeleted'] = "a �t� effac�";
$lang['stopignoringthisuser'] = "Arr�te de n�gliger cet utilisateur";
$lang['renamethread'] = "Renommer le fil";
$lang['movethread'] = "Fil de mouvement";
$lang['editthepoll'] = "Editer le sondage";
$lang['torenamethisthread'] = "pour renommer ce fil";
$lang['reopenforposting'] = "Reopen pour poster";
$lang['closeforposting'] = "Fermer pour poster";
$lang['preventediting'] = "Prevent editing";
$lang['allowediting'] = "Allow editing";
$lang['makesticky'] = "Faire collant";
$lang['makenonsticky'] = "Faire non-collant";
$lang['until'] = "Jusqu' � 00:00 UTC";
$lang['stickyuntil'] = "Collant jusqu' �";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "D�marrage";
$lang['messages'] = "Messages";
$lang['pminbox'] = "PM Inbox";
$lang['pmsentitems'] = "Articles envoy�s";
$lang['pmoutbox'] = "Outbox";
$lang['pmsaveditems'] = "Articles �pargn�s";
$lang['links'] = "Liens";
$lang['preferences'] = "Pr�f�rences";
$lang['profile'] = "Profil";
$lang['admin'] = "Admin";
$lang['login'] = "Login";
$lang['logout'] = "Logout";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------
$lang['privatemessages'] = "Messages priv�s";
$lang['addrecipient'] = "Ajoute le B�n�ficiaire";
$lang['recipienttiptext'] = "Les b�n�ficiaires de Seperate par le point virgule ou la virgule";
$lang['maximumtenrecipientspermessage'] = "Il y a une limite de 10 b�n�ficiaires par le message. S'il vous pla�t ammend votre liste de b�n�ficiaire.";
$lang['mustspecifyrecipient'] = "Vous devez sp�cifier au moins un b�n�ficiaire.";
$lang['usernotfound1'] = "Usage";
$lang['usernotfound2'] = "Pas trouv�.";
$lang['sendnewpm'] = "Envoyer Nouveau PM";
$lang['savemessage'] = "Epargner le Message";
$lang['sentby'] = "Envoy� Par";
$lang['timesent'] = "Chronom�trer Envoy�";
$lang['nomessages'] = "Aucuns Messages";
$lang['errorcreatingpm'] = "L'erreur cr�ant PM! S'il vous pla�t essayer encore dans quelques minutes";
$lang['writepm'] = "Ecrire le Message";
$lang['editpm'] = "Editer le Message";
$lang['cannoteditpm'] = "Ne peut pas �diter ceci PM. Il a �t� d�j� regard� par le b�n�ficiaire ou le message n'existe pas ou c'est inaccessible par vous";
$lang['cannotviewpm'] = "Ne peut pas regarder PM. Le message n'existe pas ou c'est inaccessible par vous";
$lang['nomessagespecifiedforreply'] = "Aucun message a sp�cifi� pour la r�ponse �";
$lang['nouserspecified'] = "Aucun utilisateur a sp�cifi�.";
$lang['oldermessages'] = "Older Messages";
$lang['newermessages'] = "Newer Messages";
$lang['notenoughfreespace'] = "does not have enough free space to receive this message";
$lang['hasoptoutpm'] = "Has opted out of receiving personal messages";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "My Controls";
$lang['myforums'] = "My Forums";
$lang['menu'] = "Menu";
$lang['userexp_1'] = "Use the menu on the left to manage your settings.";
$lang['userexp_2'] = "<b>User Details</b> allows you to change your name, email address and password.";
$lang['userexp_3'] = "<b>User Profile</b> allows you to edit your user profile.";
$lang['userexp_4'] = "<b>Change Password</b> allows you to change your password";
$lang['userexp_5'] = "<b>Email & Privacy</b> lets you change how you can be contacted on and off the forum.";
$lang['userexp_6'] = "<b>Forum Options</b> lets you change how the forum looks and works.";
$lang['userexp_7'] = "<b>Attachments</b> allows you to edit/delete your attachments.";
$lang['userexp_8'] = "<b>Edit Signature</b> lets you edit your signature.";
$lang['userdetails'] = "User Details";
$lang['userprofile'] = "User Profile";
$lang['emailandprivacy'] = "Email & Privacy";
$lang['editsignature'] = "Edit Signature";
$lang['newrelationship'] = "New Relationship";
$lang['editrelationships'] = "Edit Relationships";
$lang['norelationships'] = "You have no user relationships set up";
$lang['editattachments'] = "Edit Attachments";
$lang['userinformation'] = "User Information";
$lang['changepassword'] = "Change Password";
$lang['newpasswd'] = "Nouveau Mot de passe";
$lang['confirmpasswd'] = "Confirmer le Mot de passe";
$lang['passwdsdonotmatch'] = "Les mots de passe pas allumette!";
$lang['nicknamerequired'] = "Le surnom est exig�!";
$lang['emailaddressrequired'] = "Adresse m�l est exige!";
$lang['relationshipsupdated'] = "Relationships Updated";
$lang['relationshipupdatefailed'] = "Relationship updated failed!";
$lang['jan'] = "Janvier";
$lang['feb'] = "F�vrier";
$lang['mar'] = "Mars";
$lang['apr'] = "Avril";
$lang['may'] = "Mai";
$lang['jun'] = "Juin";
$lang['jul'] = "Juillet";
$lang['aug'] = "Ao�t";
$lang['sep'] = "Septembre";
$lang['oct'] = "Octobre";
$lang['nov'] = "Novembre";
$lang['dec'] = "D�cembre";
$lang['userpreferences'] = "Pr�f�rences d'utilisateur";
$lang['preferencesupdated'] = "Les pr�f�rences avec succ�s ont �t� mises � jour.";
$lang['leaveblanktoretaincurrentpasswd'] = "Omettre les champs pour retenir le mot de passe actuel";
$lang['firstname'] = "Pr�nom";
$lang['lastname'] = "Nom de famille";
$lang['dateofbirth'] = "Date de naissance";
$lang['homepageURL'] = "URL de votre page d'accueil";
$lang['pictureURL'] = "URL de votre image";
$lang['forumoptions'] = "Forum Options";
$lang['notifybyemail'] = "Me notifier par m�l de messages";
$lang['notifyofnewpm'] = "Me notifier par popup de nouveaux messages personels.";
$lang['notifyofnewpmemail'] = "Me notifier par m�l de nouveaux messages personels";
$lang['daylightsaving'] = "DST";
$lang['autohighinterest'] = "Automatiquement marquer comme int�ressant les discussions dans lesquelles je participe";
$lang['convertimagestolinks'] = "Automatically convert embedded images in posts into links";
$lang['globallyignoresigs'] = "Ignorer globalement les signatures d'utilisateurs";
$lang['timezonefromGMT'] = "Fuseau horaire";
$lang['postsperpage'] = "Nombre de messages par page";
$lang['fontsize'] = "Taille du jeu de caract�res";
$lang['forumstyle'] = "Style de forum";
$lang['startpage'] = "Commencer par la page";
$lang['containsHTML'] = "contient de l'HTML";
$lang['preferredlang'] = "Langue pr�f�r�e";
$lang['ageanddob'] = "Age et date de naissance";
$lang['neitheragenordob'] = "ne pas l'afficher aux autres";
$lang['showonlyage'] = "afficher uniquement l'�ge aux autres";
$lang['showageanddob'] = "afficher aux autres";
$lang['browseanonymously'] = "Naviguer le forum anonymement";
$lang['showforumstats'] = "Afficher les statistiques du forum en bas du volet de messagerie.";
$lang['usewordfilter'] = "Enable word filter.";
$lang['forceadminwordfilter'] = "Force use of admin word filter on all users (inc. guests)";
$lang['timezone'] = "Time Zone";
$lang['language'] = "Language";
$lang['emailsettings'] = "Email Settings";
$lang['privacysettings'] = "Privacy Settings";
$lang['includeadminfilter'] = "Include admin word filter in my list.";
$lang['allowpersonalmessages'] = "Allow other users to send me personal messages";
$lang['allowemails'] = "Allow other users to send me emails via my profile";
$lang['currentpasswd'] = "Current Password";

// Polls (create_poll.php, pollresults.php) ---------------------------------------------

$lang['mustenterpollquestion'] = "Vous devez entrer une question de sondage";
$lang['groupcountmustbelessthananswercount'] = "Le num�ro de groupes de r�ponse doit �tre le num�ro moins que total de r�ponses";
$lang['pleaseselectfolder'] = "S'il vous pla�t choisir un dossier";
$lang['mustspecifyvalues1and2'] = "Vous devez sp�cifier des valeurs pour les r�ponses 1 et 2";
$lang['cannotcreatemultivotepublicballot'] = "Vous ne pouvez pas cr�er multi-vote les bulletins de vote publics. Les bulletins de vote publics exigent que l'usage de noter de vote pour ait travaill�.";
$lang['abletochangevote'] = "Vous pourrez changer votre vote.";
$lang['abletovotemultiple'] = "Vous pourrez voter des temps multiples.";
$lang['notabletochangevote'] = "Vous ne pourrez pas changer votre vote.";
$lang['pollvotesrandom'] = "Note: les votes de Sondage sont engendr�s au hasard pour l'avant-premi�re seulement.";
$lang['pollquestion'] = "Question de sondage";
$lang['possibleanswers'] = "R�ponses possibles";
$lang['enterpollquestionexp'] = "Entrer les r�ponses pour votre question de sondage. Si votre sondage est un \"yes/no\" la question, simplement entrer \"Yes\" pour la R�ponse 1 et \"No\" pour la R�ponse 2.";
$lang['numberanswers'] = "No les R�ponses";
$lang['answerscontainHTML'] = "Les r�ponses Contiennent HTML (pas y compris la signature)";
$lang['votechanging'] = "Voter Changer";
$lang['votechangingexp'] = "Pouvoir une personne change son ou son vote?";
$lang['allowmultiplevotes'] = "Permettre des Votes Multiples";
$lang['pollresults'] = "Le sondage R�sulte";
$lang['pollresultsexp'] = "Comment vous ferait comme afficher les r�sultats de votre sondage?";
$lang['pollvotetype'] = "Interroger le Type de Suffrage";
$lang['pollvotesexp'] = "Comment devrait le sondage est dirig�?";
$lang['pollvoteanon'] = "Anonymement";
$lang['pollvotepub'] = "Bulletin de vote public";
$lang['pollresultnote'] = "<b>Note:</b> Choisir 'le bulletin de vote Public' fera overide le type de r�sultat de sondage.";
$lang['horizgraph'] = "Graphique horizontal";
$lang['vertgraph'] = "Graphique vertical";
$lang['publicviewable'] = "Bulletin de vote public";
$lang['polltypewarning'] = "<b>Avertissement</b>: Ceci est un bulletin de vote public. Votre nom sera visible � c�t� de l'option que vous votez pour.";
$lang['expiration'] = "Expiration";
$lang['showresultswhileopen'] = "Faire vous voulez montrer des r�sultats pendant que le sondage est ouvert?";
$lang['whenlikepollclose'] = "Quand aimeriez-vous que votre sondage automatiquement pour ait ferm�?";
$lang['oneday'] = "Un jour";
$lang['threedays'] = "Trois jours";
$lang['sevendays'] = "Sept jours";
$lang['thirtydays'] = "Trente jours";
$lang['never'] = "Jamais";
$lang['polladditionalmessage'] = "Le Message suppl�mentaire (Facultatif)";
$lang['polladditionalmessageexp'] = "Faire vous voulez inclure une poste suppl�mentaire apr�s le sondage?";
$lang['mustspecifypolltoview'] = "Vous devez sp�cifier un sondage pour regarder.";
$lang['pollconfirmclose'] = "Vous sont s�r vous voulez fermer le Sondage suivant?";
$lang['endpoll'] = "Sondage de fin";
$lang['nobodyvoted'] = "Personne n'a vot�.";
$lang['nobodyhasvoted'] = "Personne n'a vot�.";
$lang['1personvoted'] = "1 personne a vot�.";
$lang['1personhasvoted'] = "1 personne a vot�.";
$lang['peoplevoted'] = "les gens ont vot�.";
$lang['peoplehavevoted'] = "les gens ont vot�.";
$lang['pollhasended'] = "Le sondage a termin�";
$lang['youvotedfor'] = "Vous avez vot� pour";
$lang['thisisapoll'] = "Ceci est un sondage. Le d�clic pour regarder des r�sultats.";
$lang['editpoll'] = "Editer le Sondage";
$lang['results'] = "R�sultats";
$lang['resultdetails'] = "Le r�sultat D�taille";
$lang['changevote'] = "Vote de changement";
$lang['mustvoteforallgroups'] = "You must vote in every group.";
$lang['tablepollmusthave2groups'] = "Tabular format polls must have precisely two voting groups";
$lang['nomultivotetabulars'] = "Tabular format polls cannot be multi-vote";
$lang['tablegraph'] = "Tabular format";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "Editer le Profil";
$lang['profileupdated'] = "Le profil a mis � jour.";
$lang['profilesnotsetup'] = "Le propri�taire de forum n'a pas �tabli de Profil.";
$lang['nouserspecified'] = "Aucun utilisateur a sp�cifi�";
$lang['ignoreduser'] = "Utilisateur n�glig�";
$lang['lastvisit'] = "Derni�re Visite";
$lang['sendemail'] = "Envoyer l'e-mail";
$lang['sendpm'] = "Envoyer PM";
$lang['removefromfriends'] = "Enlever des amis";
$lang['addtofriends'] = "Ajouter aux amis";
$lang['stopignoringuser'] = "Arr�te de n�gliger l'utilisateur";
$lang['ignorethisuser'] = "N�gliger cet utilisateur";
$lang['age'] = "Age";
$lang['aged'] = "vieilli";
$lang['birthday'] = "Anniversaire";
$lang['editmyattachments'] = "Editer Mon Attachements";

// Registration (register.php) -----------------------------------------

$lang['usernamemustnotcontainHTML'] = "Username ne doit pas contenir les �tiquettes de HTML";
$lang['usernameinvalidchars'] = "Username peut contenir seulement l'un-z, 0-9, _ - les caract�res";
$lang['usernametooshort'] = "Username doit �tre au moins 2 caract�res longs";
$lang['usernametoolong'] = "Username doit �tre au maximum 15 caract�res longs";
$lang['usernamerequired'] = "Un nom de logon est exig�";
$lang['passwdmustnotcontainHTML'] = "Le mot de passe ne doit pas contenir les �tiquettes de HTML";
$lang['passwordinvalidchars'] = "Un mot de passe peut contenir seulement l'un-z, 0-9, _ - les caract�res";
$lang['passwdtooshort'] = "Le mot de passe doit �tre au moins 6 caract�res longs";
$lang['passwdrequired'] = "Un mot de passe est exig�";
$lang['confirmationpasswdrequired'] = "Un mot de passe de confirmation est exig�";
$lang['nicknamemustnotcontainHTML'] = "Surnommer ne doit pas contenir les �tiquettes de HTML";
$lang['nicknamerequired'] = "Un surnom est exig�";
$lang['emailmustnotcontainHTML'] = "Envoie un e-mail � ne doit pas contenir les �tiquettes de HTML";
$lang['emailrequired'] = "Une Adresse m�l est exig�e";
$lang['passwdsdonotmatch'] = "Les mots de passe pas allumette";
$lang['usernamesameaspasswd'] = "Username et le mot de passe doivent �tre diff�rents";
$lang['usernameexists'] = "D�sol�, un utilisateur avec ce nom existe d�j�";
$lang['userrecordcreated'] = "Huzzah! Votre disque d'utilisateur a �t� cr�� avec succ�s!";
$lang['errorcreatinguserrecord'] = "L'erreur cr�e le disque d'utilisateur";
$lang['userregistration'] = "Enregistrement d'utilisateur";
$lang['registrationinformationrequired'] = "L'Information d'enregistrement (A Exig�)";
$lang['profileinformationoptional'] = "L'Information de profil (Facultatif)";
$lang['preferencesoptional'] = "Les pr�f�rences (Facultatif)";
$lang['register'] = "Registre";
$lang['rememberpasswd'] = "Se souvenir du mot de passe";
$lang['birthdayrequired'] = "Votre date de naissance est exig�e ou est nul";
$lang['alwaysnotifymeofrepliestome'] = "Notifier sur la r�ponse me";
$lang['notifyonnewprivatemessage'] = "Notifier sur nouveau le Message Priv�";
$lang['popuponnewprivatemessage'] = "Revient sur nouveau le Message Priv�";
$lang['automatichighinterestonpost'] = "Automatique l'haut int�r�t sur la poste";
$lang['itemsmarkedwithaasterixarerequired'] = "Les articles ont marqu� avec un * sont exig�";
$lang['confirmpassword'] = "Confirmer le Mot de passe";
$lang['invalidemailaddressformat'] = "Invalid email address format";
$lang['moreoptionsavailable'] = "More Profile and Preference options are available once you register";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "Membre";
$lang['searchforusernotinlist'] = "Cherche un utilisateur pas dans la liste";
$lang['yoursearchdidnotreturnanymatches'] = "Votre recherche n'est pas retourn�e d'allumette. Essayer simplifiant vos param�tres de recherche et essaie encore.";

// Relationships (user_rel.php) ----------------------------------------

$lang['userrelationship'] = "Relation d'utilisateur";
$lang['userrelationships'] = "Rapports d'utilisateur";
$lang['friends'] = "Friends";
$lang['ignoredusers'] = "Ignored Users";
$lang['ignoredsignatures'] = "Ignored Signatures";
$lang['relationship'] = "Relation";
$lang['friend_exp'] = "Les postes de l'utilisateur ont marqu� avec un &quot;Friend&quot; icon.";
$lang['normal_exp'] = "Les postes de l'utilisateur apparaissent comme normal.";
$lang['ignore_exp'] = "Les postes de l'utilisateur sont cach�es.";
$lang['display'] = "Exposition";
$lang['displaysig_exp'] = "La signature de l'utilisateur est affich� sur leurs postes.";
$lang['hidesig_exp'] = "La signature de l'utilisateur est cach�e sur leurs postes.";
$lang['globallyignored'] = "Globalement n�glig�";
$lang['globallyignoredsig_exp'] = "Aucunes signatures sont affich�.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "R�sultat de recherches";
$lang['usernamenotfound'] = "Le username que vous avez sp�cifi� dans l'� ou du champ n'a pas �t� trouv�.";
$lang['notexttosearchfor_1'] = "You did not specify any words to search for or the words were under";
$lang['notexttosearchfor_2'] = "characters long or you did not enter a username to search against";
$lang['foundzeromatches'] = "Trouv�: 0 allumettes";
$lang['found'] = "Trouv�";
$lang['matches'] = "allumettes";
$lang['prevpage'] = "Page pr�c�dente";
$lang['findmore'] = "Trouver plus";
$lang['searchmessages'] = "Chercher des Messages";
$lang['searchdiscussions'] = "Chercher la discussion";
$lang['containingallwords'] = "Contenir tous les mots";
$lang['containinganywords'] = "Contenir n'importe quel des mots";
$lang['containingexactphrase'] = "Contenir la phrase exacte";
$lang['usingbooleanquery'] = "Use boolean query";
$lang['searchbyuser'] = "Search by user (optional)";
$lang['find'] = "D�couverte";
$lang['wordsshorterthan_1'] = "Les mots plus courts que";
$lang['wordsshorterthan_2'] = "les caract�res ne seront pas inclus";
$lang['additionalcriteria'] = "Crit�res suppl�mentaires";
$lang['folderbrackets_s'] = "Le dossier(s)";
$lang['postedfrom'] = "Post� de";
$lang['postedto'] = "Post� �";
$lang['today'] = "Aujourd'hui";
$lang['yesterday'] = "Hier";
$lang['daybeforeyesterday'] = "Le jour avant hier";
$lang['weekago'] = "la semaine il y a";
$lang['weeksago'] = "les semaines il y a";
$lang['monthago'] = "le mois il y a";
$lang['monthsago'] = "les mois il y a";
$lang['yearago'] = "l'ann�e il y a";
$lang['beginningoftime'] = "Le commencement de temps";
$lang['now'] = "Maintenant";
$lang['relevance'] = "Pertinence";
$lang['newestfirst'] = "Plus nouveau premi�rement";
$lang['oldestfirst'] = "Plus vieux premi�rement";
$lang['keywords'] = "Keywords";
$lang['orderby'] = "Order by";
$lang['onlyshowmessagestoorfromme'] = "Seulement les messages de spectacle � ou de moi";
$lang['groupsresultsbythread'] = "Le groupe r�sulte par le fil";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "Fil r�cents";
$lang['startreading'] = "Commencer la Lecture";
$lang['threadoptions'] = "Options";
$lang['showmorevisitors'] = "Montrer plus de Visiteurs";
$lang['forthcomingbirthdays'] = "Prochains Anniversaires";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "You can edit this page from the admin interface";
$lang['uploadstartpage'] = "Upload Start Page (*.txt, *.php, *.htm)";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "Nouvelle Discussion";
$lang['createpoll'] = "Cr�er le Sondage";
$lang['search'] = "Recherche";
$lang['searchagain'] = "Recherche Encore";
$lang['alldiscussions'] = "Toutes Discussions";
$lang['unreaddiscussions'] = "Discussions non lues";
$lang['unreadtome'] = "Non lu &quot;A: Me&quot;";
$lang['todaysdiscussions'] = "Aujourd'hui Discussions";
$lang['2daysback'] = "2 Les jours Soutiennent";
$lang['7daysback'] = "7 Les jours Soutiennent";
$lang['highinterest'] = "Haut Int�r�t";
$lang['unreadhighinterest'] = "Non lu Haut Interest";
$lang['iverecentlyseen'] = "J'ai vu r�cemment";
$lang['iveignored'] = "J'ai n�glig�";
$lang['ivesubscribedto'] = "Je se suis abonn� �";
$lang['startedbyfriend'] = "Commenc� par l'ami";
$lang['unreadstartedbyfriend'] = "Non lu commenc� par l'ami";
$lang['goexcmark'] = "Valider!";
$lang['folderinterest'] = "Int�r�t de dossier";
$lang['postnew'] = "Poster Nouveau";
$lang['currentthread'] = "Fil actuel";
$lang['highinterest'] = "Haut Int�r�t";
$lang['markasread'] = "Marquer comme lu";
$lang['next50discussions'] = "Prochain 50 discussions";
$lang['visiblediscussions'] = "Discussions visibles";
$lang['navigate'] = "Naviguer";
$lang['couldnotretrievefolderinformation'] = "Il n'y a pas de dossiers disponibles.";
$lang['nomessagesinthiscategory'] = "Aucuns messages dans cette cat�gorie. S'il vous pla�t choisir un autre, ou";
$lang['clickhere'] = "cliqueter ici";
$lang['forallthreads'] = "pour tous fils";
$lang['prev50threads'] = "Pr�c�dent 50 fils";
$lang['next50threads'] = "Prochain 50 fils";
$lang['startedby'] = "Commenc� par";
$lang['unreadthread'] = "Fil non lu";
$lang['readthread'] = "Lire le Fil";
$lang['unreadmessages'] = "Messages non lus";
$lang['subscribed'] = "S'abonn�";
$lang['ignorethisfolder'] = "N�gliger Ce Dossier";
$lang['stopignoringthisfolder'] = "Arr�te de N�gliger Ce Dossier";
$lang['stickythreads'] = "Fils collants";
$lang['mostunreadposts'] = "La plupart des postes non lus";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "Hardi";
$lang['italic'] = "Italique";
$lang['underline'] = "Souligner";
$lang['strikethrough'] = "Strikethrough";
$lang['superscript'] = "Exposant";
$lang['subscript'] = "Indice inf�rieur";
$lang['leftalign'] = "Gauche-aligne";
$lang['center'] = "Centre";
$lang['rightalign'] = "Droite-aligne";
$lang['numberedlist'] = "Liste num�rot�e";
$lang['list'] = "Liste";
$lang['indenttext'] = "Indenter le texte";
$lang['code'] = "Code";
$lang['quote'] = "Citation";
$lang['horizontalrule'] = "R�gle horizontale";
$lang['image'] = "Image";
$lang['hyperlink'] = "Hyperlink";
$lang['noemoticons'] = "Disable emoticons";
$lang['fontface'] = "Face de jeu de caract�res";
$lang['size'] = "Taille";
$lang['colour'] = "Couleur";
$lang['red'] = "Rouge";
$lang['orange'] = "Orange";
$lang['yellow'] = "Jaune";
$lang['green'] = "Vert";
$lang['blue'] = "Bleu";
$lang['indigo'] = "Indigo";
$lang['violet'] = "Violet";
$lang['white'] = "Blanc";

// Missing Entries:

$lang['with'] = "with";
$lang['prev'] = "Prev";
$lang['attachmentshavebeendisabled'] = "Attachments have been disabled by the forum owner.";
$lang['pmnotificationpopup'] = "You have a new PM. Would you like to go to your Inbox now?";
$lang['pollshavebeendisabled'] = "Polls have been disabled by the forum owner.";
$lang['forumstats'] = "Forum Stats";
$lang['guests'] = "guests";
$lang['members'] = "members";
$lang['anonymousmembers'] = "anonymous members";
$lang['viewcompletelist'] = "View Complete List";
$lang['ourmembershavemadeatotalof'] = "Our members have made a total of";
$lang['threadsand'] = "threads and";
$lang['postslowercase'] = "posts";
$lang['longestthreadis'] = "Longest thread is";
$lang['therehavebeen'] = "There have been";
$lang['postsmadeinthelastsixtyminutes'] = "posts made in the last 60 minutes";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwas'] = "Most posts ever made in a single 60 minute period was";
$lang['wehave'] = "We have";
$lang['registeredmembers'] = "registered members";
$lang['thenewestmemberis'] = "The newest member is";
$lang['mostuserseveronlinewas'] = "Most users ever online was";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "Updates Made";
$lang['useroptions'] = "User Options";
$lang['markedasread'] = "Marked as read";
$lang['postsoutof'] = "posts out of";
$lang['interest'] = "Interest";
$lang['adminoptions'] = "Admin Options";
$lang['closedforposting'] = "Closed for posting";
$lang['locktitleandfolder'] = "Lock title and folder";
$lang['deletepostsinthreadbyuser'] = "Delete posts in thread by user";
$lang['deletethread'] = "Delete Thread";
$lang['markasunread'] = "Mark as unread";
$lang['makethreadsticky'] = "Make Thread Sticky";
$lang['threareadstatusupdated'] = "Thread Read Status Updated Successfully";

?>