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

/* $Id: fr.inc.php,v 1.29 2004-02-27 22:00:13 decoyduck Exp $ */

// French language file Ver 0.3
// By Mark Krywonos and Endo
// All sections are complete but will probabily contain gramattical errors.

// Language character set and text direction options -------------------

$lang['_charset'] = "ISO-8859-1";
$lang['_isocode'] = "fr";    // ISO-639 language code
$lang['_textdir'] = "ltr";  // ltr or rtl; left to right or vice versa


// Common words --------------------------------------------------------

$lang['locked'] = "Verrouillé";
$lang['add'] = "Ajouter";
$lang['advanced'] = "Avançé";
$lang['active'] = "Actif";
$lang['kick'] = "Coup-de-pied";
$lang['remove'] = "Enlever";
$lang['style'] = "Modèle";
$lang['go'] = "Valider";
$lang['folder'] = "Dossier";
$lang['ignoredfolder'] = "Dossier Ignoré";
$lang['folders'] = "Dossiers";
$lang['thread'] = "fil";
$lang['threads'] = "fils";
$lang['message'] = "Message";
$lang['from'] = "De";
$lang['to'] = "A";
$lang['all_caps'] = "Tous";
$lang['of'] = "de";
$lang['reply'] = "Répondre";
$lang['delete'] = "Effacement";
$lang['deleted'] = "Supprimé";
$lang['del'] = "Effacer";
$lang['edit'] = "Editer";
$lang['privileges'] = "Privilèges";
$lang['ignore'] = "Désactivé";
$lang['normal'] = "Activé";
$lang['interested'] = "Intéressé";
$lang['subscribe'] = "S'abonne";
$lang['apply'] = "S'appliquer";
$lang['submit'] = "Soumettre";
$lang['save'] = "Epargner";
$lang['cancel'] = "Annuler";
$lang['continue'] = "Continuer";
$lang['queen'] = "Reine";
$lang['soldier'] = "Soldat";
$lang['worker'] = "Ouvrier";
$lang['worm'] = "Ver";
$lang['wasp'] = "Guêpe";
$lang['splat'] = "Splat";
$lang['attachment'] = "Attachment";
$lang['attachments'] = "Attachments";
$lang['filename'] = "Nom de fichier";
$lang['dimensions'] = "Dimensions";
$lang['downloaded'] = "Téléchargé";
$lang['size'] = "Taille";
$lang['time'] = "temps";
$lang['times'] = "temps";
$lang['viewmessage'] = "Regarder le Message";
$lang['messageunavailable'] = "Le message Indisponible";
$lang['logon'] = "Logon";
$lang['status'] = "Statut";
$lang['more'] = "Plus";
$lang['recentvisitors'] = "Visiteurs récents";
$lang['username'] = "Nom d'utilisateur";
$lang['clear'] = "Clair";
$lang['action'] = "Action";
$lang['unknown'] = "Inconnu";
$lang['none'] = "aucun";
$lang['preview'] = "Aperçu";
$lang['post'] = "Poste";
$lang['posts'] = "Postes";
$lang['change'] = "Changement";
$lang['yes'] = "Oui";
$lang['no'] = "Non";
$lang['signature'] = "Signature";
$lang['wasnotfound'] = "pas trouvé";
$lang['back'] = "Dos";
$lang['subject'] = "Sujet";
$lang['close'] = "Fin";
$lang['name'] = "Nom";
$lang['description'] = "Description";
$lang['date'] = "Date";
$lang['view'] = "Vue";
$lang['passwd'] = "Mot de passe";
$lang['ignored'] = "Négligé";
$lang['guest'] = "Invité";
$lang['next'] = "Après";
$lang['others'] = "Autres";
$lang['nickname'] = "Surnom";
$lang['emailaddress'] = "Adresse mél";
$lang['confirm'] = "Confirmer";
$lang['email'] = "Email";
$lang['new'] = "nouveau";
$lang['poll'] = "Sondage";
$lang['friend'] = "Ami";
$lang['error'] = "Erreur";
$lang['reset'] = "Remet à l'état initial";
$lang['guesterror_1'] = "Désolé, vous avez besoin d'être abonné pour utiliser cette caractéristique.";
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

// Admin interface (admin*.php) ----------------------------------------

$lang['accessdenied'] = "Accès Nié";
$lang['accessdeniedexp'] = "Vous n'avez pas la permission pour utiliser cette section.";
$lang['managefolders'] = "Gérer des Dossiers";
$lang['managefolder'] = "Gérer le Dossier";
$lang['id'] = "ID";
$lang['foldername'] = "Nom de dossier";
$lang['accesslevel'] = "Niveau d'accès";
$lang['move'] = "Mouvement";
$lang['closed'] = "Fermé";
$lang['open'] = "Ouvrir";
$lang['restricted'] = "Limité";
$lang['newfolder'] = "Nouveau Dossier";
$lang['forumadmin'] = "Administration de forum";
$lang['adminexp_1'] = "Utiliser le menu sur le gauche pour gérer des choses dans votre forum.";
$lang['adminexp_2'] = "<b>Utilisateurs</b> vous permet de régler les permissions d'utilisateur, y compris nommer d'Editeurs et bâillonner les gens.";
$lang['adminexp_3'] = "Usage <b>Dossiers</b> pour ajouter de nouveaux dossiers ou change les noms d'une existante.";
$lang['adminexp_4'] = "<b>Profils</b> vous permettre de change les articles apparaissant dans les profils d'utilisateur.";
$lang['adminexp_5'] = "Choisir <b>Commencer par la page</b> pour éditer la page de Démarrage de forum.";
$lang['adminexp_6'] = "Utilisation <b>Style de forum</b> vous permet de créer les nouveaux arrangements de couleur pour le forum.";
$lang['adminexp_7'] = "Les mots dans le <b>Filtre de mot</b> peut être édité.";
$lang['adminexp_8'] = "Regarde le <b>Journal de bord administratif</b> pour voir que quels modérateurs de forum d'actions ont-ils pris récemment.";
$lang['createforumstyle'] = "Créer un Style de Forum";
$lang['newstyle'] = "Nouveau style";
$lang['successfullycreated'] = "avec succès créé.";
$lang['stylesdirnotwritable'] = "L'annuaire de styles n'est pas writeable. S'il vous plaît CHMOD l'annuaire de styles et juger à nouveau.";
$lang['stylealreadyexists'] = "Un style avec ce nom de fichier existe déjà.";
$lang['stylenofilename'] = "Vous n'êtes pas entré un nom de fichier pour Sauvegarder le style avec.";
$lang['stylenotauthorised'] = "Vous n'êtes pas autorisé de créer les styles de forum.";
$lang['styleexp'] = "Utiliser cette page pour aider crée un style au hasard engendré pour votre forum.";
$lang['stylecontrols'] = "Contrôles";
$lang['stylecolourexp'] = "Cliqueter sur une couleur pour faire un nouveau stylesheet a basé sur cette couleur. La couleur actuelle de base est première dans la liste.";
$lang['standardstyle'] = "Style standard";
$lang['rotelementstyle'] = "Le Style tourné d'Elément";
$lang['randstyle'] = "Style fait au hasard";
$lang['enterhexcolour'] = "ou entrer une couleur de sort pour baser un nouveau stylesheet sur";
$lang['savestyle'] = "Epargner ce style";
$lang['styledesc'] = "Desc de style.";
$lang['fileallowedchars'] = "(les lettres minuscules (a-z), les numéros (0-9) et les soulignés (_) seulement)";
$lang['stylepreview'] = "Aperçu de style";
$lang['welcome'] = "Accueil";
$lang['messagepreview'] = "Aperçu";
$lang['h1tag'] = "H1 Tag";
$lang['subhead'] = "Subhead";
$lang['users'] = "Utilisateurs";
$lang['profiles'] = "Profils";
$lang['startpage'] = "Commencer par la page";
$lang['forumstyle'] = "Style de forum";
$lang['wordfilter'] = "Filtre de mot";
$lang['viewlog'] = "Journal de bord de vue";
$lang['invalidop'] = "Opération nulle";
$lang['noprofilesectionspecified'] = "Aucune section de Profil a spécifié.";
$lang['newitem'] = "Nouvel Article";
$lang['manageprofileitems'] = "Gérer les Articles de Profil";
$lang['section'] = "Section";
$lang['itemname'] = "Nom d'article";
$lang['moveto'] = "Se transfère à";
$lang['deleteitem'] = "Effacer l'Article";
$lang['deletesection'] = "Effacer la Section";
$lang['new_caps'] = "NOUVEAU";
$lang['newsection'] = "Nouvelle Section";
$lang['manageprofilesections'] = "Gérer les Sections de Profil";
$lang['sectionname'] = "Nom de section";
$lang['items'] = "Articles";
$lang['startpageupdated'] = "Commencer par la page mise à jour";
$lang['viewupdatedstartpage'] = "Regarder la Page mise à jour de Démarrage";
$lang['editstartpage'] = "Editer la Page de Démarrage";
$lang['editstartpageexp'] = "Utiliser cette page pour éditer la Page de Démarrage sur votre forum.";
$lang['nouserspecified'] = "Aucun utilisateur a spécifié pour éditer.";
$lang['manageuser'] = "Gérer l'Utilisateur";
$lang['manageusers'] = "Gérer des Utilisateurs";
$lang['userstatus'] = "Statut d'utilisateur";
$lang['warning_caps'] = "AVERTISSEMENT";
$lang['userdeleteallpostswarning'] = "Etes-vous sûr que vous voulez effacer tout l'a choisi les postes de l'utilisateur? Une fois les postes ils sont n'effacés peut pas être rapporté et sera perdu à jamais.";
$lang['postssuccessfullydeleted'] = "Les postes ont été effacées avec succès.";
$lang['folderaccess'] = "Accès de dossier";
$lang['norestrictedfolders'] = "Les dossiers non limités";
$lang['possiblealiases'] = "Aliases possible";
$lang['usersettingsupdated'] = "Arrangements D'Utilisateur Avec succès Mis à jour";
$lang['nomatches'] = "Aucunes allumettes";
$lang['tobananIPaddress'] = "To ban an IP Address tick the checkbox next to the alias and click the Submit button below";
$lang['cannotipbansoldiers'] = "Vous ne pouvez pas l'interdiction de IP les autres Soldats. Plus bas leur Statut premièrement.";
$lang['banthisipaddress'] = "Interdire cette adresse de IP";
$lang['noipaddress'] = "Il n'y a pas l'adresse de IP pour ce compte. L'utilisateur ne peut pas être interdit par l'adresse de IP.";
$lang['deleteposts'] = "Effacer des Postes";
$lang['deleteallusersposts'] = "Effacer toutes ces postes de l'utilisateur";
$lang['noattachmentsforuser'] = "Aucuns attachements pour cet utilisateur";
$lang['soldierdesc'] = "<b>Soldats</b> peut accéder à tous outils de modération, mais ne peut pas créer ou peut enlever d'autres Soldats.";
$lang['workerdesc'] = "<b>Ouvriers</b> peut éditer ou peut effacer n'importe quelle poste.";
$lang['wormdesc'] = "<b>Vers</b> peut lire des messages et la poste comme normal, mais leurs messages apparaîtront effacé à tous autres utilisateurs.";
$lang['waspdesc'] = "<b>Guêpes</b> peut lire des messages, mais ne peut pas répondre ou peut poster de nouveaux messages.";
$lang['splatdesc'] = "<b>Splats</b> Ne peut pas accéder au forum. Utiliser ceci pour interdire des idiots persistants.";
$lang['aliasdesc'] = "<b>Aliases possible</b> est une liste d'autres utilisateurs qui est dernière l'adresse de IP enregistrée égale cet utilisateur.";
$lang['manageusersexp_1'] = "Cette liste montre une sélection d'utilisateurs qui ont effectué une procédure d'entrée à votre forum, trié par";
$lang['manageusersexp_2'] = "Pour altérer une permissions de l'utilisateur cliquetent leur nom.";
$lang['manageusersexp_3'] = "Pour voir que le dernier peu d'utilisateurs à logon, trier la liste par DERNIER_LOGON.";
$lang['lastlogon'] = "Dernier Logon";
$lang['logonfrom'] = "Logon De";
$lang['nouseraccounts'] = "Aucun utilisateur explique dans la base de données.";
$lang['searchforusernotinlist'] = "Cherche un utilisateur pas dans la liste";
$lang['adminaccesslog'] = "Le Journal de bord D'accès administratif";
$lang['adminlogexp'] = "Cette liste montre les dernières actions sanctionnées par les utilisateurs avec les privilèges Administratifs.";
$lang['showingactions'] = "Actions de démonstration";
$lang['inclusive'] = "inclus";
$lang['datetime'] = "Date/Temps";
$lang['unknownuser'] = "Utilisateur inconnu";
$lang['unknownfolder'] = "Dossier inconnu";
$lang['changeduserstatus'] = "Le Statut changé d'Utilisateur pour l'Utilisateur";
$lang['changedfolderaccess'] = "Le Dossier changé d'Utilisateur Privs D'accès pour l'Utilisateur";
$lang['deletedallusersposts'] = "A effacé Toutes Postes pour l'Utilisateur";
$lang['banneduser'] = "Utilisateur interdit";
$lang['unbanneduser'] = "Unbanned Utilisateur";
$lang['ipaddress'] = "IP adresse";
$lang['ip'] = "IP";
$lang['logged'] = "Noté";
$lang['notlogged'] = "Non noté";
$lang['deleteduser'] = "Utilisateur effacé";
$lang['changedtitleaccessfolder'] = "Les Options changées de Dossier pour le dossier";
$lang['movedthreads'] = "A transféré fils au dossier";
$lang['creatednewfolder'] = "Créé le nouveau dossier";
$lang['changedprofilesectiontitle'] = "Le titre changé de section de Profil pour la section";
$lang['addednewprofilesection'] = "Supplémentaire la Nouvelle section de Profil";
$lang['deletedprofilesection'] = "La Section effacée de Profil";
$lang['changedprofileitemtitle'] = "Le titre changé d'Article de Profil pour l'article";
$lang['addednewprofileitem'] = "Supplémentaire le Nouvel Article de Profil";
$lang['deletedprofileitem'] = "L'Article effacé de Profil";
$lang['editedstartpage'] = "La Page éditée de Démarrage";
$lang['savednewstyle'] = "Epargné le Nouveau Style";
$lang['movedthread'] = "Fil déplacé";
$lang['closedthread'] = "Fil fermé";
$lang['openedthread'] = "Fil ouvert";
$lang['renamedthread'] = "Fil renommé";
$lang['deletedpost'] = "Poste effacée";
$lang['editedpost'] = "Poste éditée";
$lang['editedwordfilter'] = "Le Filtre édité de Mot";
$lang['adminlogempty'] = "Le Journal de bord administratif est vide";
$lang['recententries'] = "Entrées récentes";
$lang['clearlog'] = "Journal de bord clair";
$lang['wordfilterupdated'] = "Le Filtre de mot a mis à jour";
$lang['editwordfilter'] = "Editer le Filtre de Mot";
$lang['wordfilterexp_1'] = "Utiliser cette page pour éditer le Filtre de Mot pour votre forum. Placer chaque mot être filtré sur une nouvelle ligne.";
$lang['wordfilterexp_2'] = "Perl-les expressions régulières compatibles peuvent être utilisées aussi pour égaler des mots si vous savez.";
$lang['allow'] = "Permettre";
$lang['normalthreadsonly'] = "Les fils normaux seulement";
$lang['pollthreadsonly'] = "Le sondage enfile seulement";
$lang['both'] = "Les deux fil tape";
$lang['existingpermissions'] = "Permissions existantes";
$lang['folderisnotrestricted'] = "Le dossier n'est pas limité. Régler c'est le Niveau D'accès à A Limité avant des utilisateurs ajoute/enlevant";
$lang['nousers'] = "Aucuns utilisateurs";
$lang['addnewuser'] = "Ajouter le Nouvel Utilisateur";
$lang['adduser'] = "Ajouter l'Utilisateur";
$lang['searchforuser'] = "Cherche l'Utilisateur";
$lang['browsernegotiation'] = "Choix du navigateur par défaut";
$lang['largetextfield'] = "Le grand Champ de Texte";
$lang['mediumtextfield'] = "Le Champ moyen de Texte";
$lang['smalltextfield'] = "Le petit Champ de Texte";
$lang['multilinetextfield'] = "Le Champ de Texte de Multiline";
$lang['radiobuttons'] = "Le radio Boutonne";
$lang['dropdown'] = "Tomber en bas";
$lang['threadcount'] = "Compte de fil";
$lang['fieldtypeexample1'] = "Pour les Boutons de Radio et le Dépot en bas Champs vous avez besoin d'à seperate le fieldname et les valeurs avec un deux points et chaque valeur devraient être seperated par le point virgule.";
$lang['fieldtypeexample2'] = "L'exemple: créer un boutons de radio de Sexe fondamentaux, avec deux sélections pour Mâle et Femelle, vous entreriez: <b>Le sexe: mâle; la femelle</b> dans le champ de Nom d'Article.";
$lang['madethreadsticky'] = "Fait Enfiler Collant";
$lang['madethreadnonsticky'] = "Le Fil fait Non-Collant";

// Attachments (attachments.php, getattachment.php) ---------------------------------------

$lang['aidnotspecified'] = "AID pas spécifié.";
$lang['upload'] = "Télécharger";
$lang['uploadnewattachment'] = "Nouvel Attachement De Téléchargement";
$lang['waitdotdot'] = "attente..";
$lang['attachmentnospace'] = "Désolé, vous n'avez pas l'espace assez d'attachement libre. S'il vous plaît libérer quelque espace et essaie encore.";
$lang['successfullyuploaded'] = "Avec succès Téléchargé";
$lang['uploadfailed'] = "Télécharger Echoué";
$lang['errorfilesizeis0'] = "L'erreur: Filesize doit être plus grand que 0 octets";
$lang['complete'] = "Complet";
$lang['uploadattachment'] = "Télécharger un fichier pour l'attachement à le message";
$lang['enterfilenametoupload'] = "Entrer le nom de fichier pour télécharger";
$lang['nowpress'] = "Maintenant la presse";
$lang['ifdoneattachingfiles'] = "Si vous êtes fait de fichier attachant, la presse";
$lang['attachmentsforthismessage'] = "Les attachements pour ce message";
$lang['otherattachmentsincludingpm'] = "Les autres Attachements (y compris PM les Messages)";
$lang['totalsize'] = "Taille totale";
$lang['freespace'] = "Espace libre";
$lang['attachmentproblem'] = "Il y avait un problème téléchargeant cet attachement. S'il vous plaît essayer encore plus tard.";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "Le mot de passe a changé";
$lang['passedchangedexp'] = "Votre mot de passe a été changé.";
$lang['gotologin'] = "Valider à l'écran de Login";
$lang['updatefailed'] = "Met à jour échoué";
$lang['passwdsdonotmatch'] = "Passwords do not match.";
$lang['allfieldsrequired'] = "Les mots de passe pas allumette. ";
$lang['invalidaccess'] = "Accès nul";
$lang['requiredinformationnotfound'] = "L'information exigere n'a pas trouvé";
$lang['forgotpasswd'] = "Mot de passe oublié";
$lang['enternewpasswdforuser'] = "Entrer un nouveau mot de passe pour l'utilisateur";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "Aucun message a spécifié pour la suppression";
$lang['postdelsuccessfully'] = "Poster effacé avec succès";
$lang['errordelpost'] = "L'erreur efface la poste";
$lang['delthismessage'] = "Effacer ce message";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "Aucun message a spécifié pour éditer";
$lang['edited_caps'] = "EDITE";
$lang['editappliedtomessage'] = "Editer Appliqué au Message";
$lang['editappliedtopoll'] = "Editer Est Appliqué Interroger";
$lang['errorupdatingpost'] = "L'erreur met à jour la poste";
$lang['editmessage'] = "Editer le message";
$lang['edittext'] = "Editer le texte";
$lang['editHTML'] = "Editer HTML";
$lang['editpollwarning'] = "<b>Note</b>: Editer n'importe quel aspect d'un sondage fera vide tout le courant vote et permet des gens pour voter encore.";
$lang['changewhenpollcloses'] = "Change quand le sondage ferme? ";
$lang['nochange'] = "Aucun changement";
$lang['emailresult'] = "Email résultat";
$lang['msgsent'] = "Le message a envoyé";
$lang['msgfail'] = "Envoyer l'échec de système. Le message n'a pas envoyé.";
$lang['nopermissiontoedit'] = "Vous n'êtes pas permis d'éditer ce message.";
$lang['pollediterror'] = "Vous ne pouvez pas éditer de sondage";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "Aucun utilisateur spécifié pour envoie un e-mail à.";
$lang['entersubjectformessage'] = "Entrer un sujet pour le message";
$lang['entercontentformessage'] = "Entrer quelque contenu pour le message";
$lang['msgsentfrombeehiveforumby'] = "Ce message a été envoyé d'un Forum de Ruche par";
$lang['subject'] = "Sujet";
$lang['send'] = "Envoyer";
$lang['msgnotificationemail_1'] = "a posté un message à vous sur";
$lang['msgnotificationemail_2'] = "Le sujet est";
$lang['msgnotificationemail_3'] = "Pour lire ce message et ces autres dans la discussion pareille, Valider à";
$lang['msgnotificationemail_4'] = "Note: Si vous ne souhaitez pas recevoir les notifications d'e-mail de messages de Forum";
$lang['msgnotificationemail_5'] = "posté à vous, allez à";
$lang['msgnotificationemail_6'] = "déclic";
$lang['msgnotificationemail_7'] = "sur les Préférences, desélectionner la case de pointage de Notification d'E-mail et la presse Soumet.";
$lang['msgnotification_subject'] = "La Notification de message de";
$lang['subnotification_1'] = "a posté un message dans un fil vous";
$lang['subnotification_2'] = "s'est abonné à sur";
$lang['subnotification_3'] = "Le sujet est";
$lang['subnotification_4'] = "Pour lire ce message et ces autres dans la discussion pareille, Valider à";
$lang['subnotification_5'] = "Note: Si vous ne souhaitez pas recevoir les notifications d'e-mail de nouveaux messages";
$lang['subnotification_6'] = "dans ce fil, Valider à";
$lang['subnotification_7'] = "et ajuster votre niveau d'Intérêt à la fin de la page.";
$lang['subnotification_subject'] = "La Notification de souscription de";
$lang['pmnotification_1'] = "a posté un PM à vous sur";
$lang['pmnotification_2'] = "Le sujet est";
$lang['pmnotification_3'] = "Pour lire le message va à";
$lang['pmnotification_4'] = "Note: Si vous ne souhaitez pas recevoir les notifications d'e-mail de PM les messages";
$lang['pmnotification_5'] = "posté à vous, allez à";
$lang['pmnotification_6'] = "déclic";
$lang['pmnotification_7'] = "sur les Préférences, desélectionner le PM la case de pointage de Notification d'E-mail et la presse Soumettent.";
$lang['pmnotification_subject'] = "PM la Notification de";

// Error handler (errorhandler.inc.php) --------------------------------

$lang['errorpleasewaitandretry'] = "Une erreur a arrivé. 
S'il vous plaît attendre quelques minutes et alors cliqueter le Juger au Nouveau bouton au dessous.";
$lang['retry'] = "Juger à nouveau";
$lang['multipleerroronpost'] = "Cette erreur a arrivé plus qu'une fois en tentant la poster/avant-première votre message. Pour votre convienience nous avons inclus votre texte de message et le cas échéant le fil et le message numérotent vous répondiez à au dessous. Vous pouvez souhaiter Sauvegarder une copie du texte ailleurs jusqu'à ce que le forum est disponible encore. .";
$lang['replymsgnumber'] = "Le Numéro de Message de réponse";
$lang['errormsgfordevs'] = "Le Message d'erreur pour les administrations de serveur et les entrepreneurs";

// Forgotten passwords (forgot_pw.php) ---------------------------------

$lang['forgotpwemail_1'] = "Vous avez demandé cet e-mail de";
$lang['forgotpwemail_2'] = "parce que vous avez oublié votre mot de passe.";
$lang['forgotpwemail_3'] = "Cliqueter le lien au dessous (ou la copie et le colle dans votre navigateur) remettre à l'état initial votre mot de passe";
$lang['passwdresetrequest'] = "Votre mot de passe remet à l'état initial la demande";
$lang['passwdresetemailsent'] = "Le mot de passe remet à l'état initial l'e-mail envoyé";
$lang['passwdresetexp_1'] = "Vous devez recevoir un e-mail contient";
$lang['passwdresetexp_2'] = "un lien pour remettre à l'état initial votre mot de passe bientôt.";
$lang['validusernamerequired'] = "Un username valide est exigé";
$lang['forgotpasswd'] = "Mot de passe oublié";
$lang['forgotpasswdexp_1'] = "Entrer votre nom de logon au-dessus de et un e-mail contenant un lien permet";
$lang['forgotpasswdexp_2'] = "vous changer votre mot de passe sera envoyé à votre Adresse mél enregistrée";
$lang['couldnotsendpasswordreminder'] = "vous changer votre mot de passe sera envoyé à votre Adresse mél enregistrée.";
$lang['request'] = "Demande";

// Frameset things (index.php) -----------------------------------------

$lang['noframessupport'] = "Oops, votre navigateur dit qu'il ne soutient pas de cadre";
$lang['uselightversion'] = "Vous avez besoin d'utiliser la version de HTML légère du forum <a href=\"llogon.php\">here</a>.";

// Links database (links*.php) -----------------------------------------

$lang['maynotaccessthissection'] = "Vous ne pouvez pas accéder à cette section.";
$lang['toplevel'] = "Premier Niveau";
$lang['links'] = "Liens";
$lang['viewmode'] = "Regarder le Mode";
$lang['hierarchical'] = "Hiérarchique";
$lang['list'] = "Liste";
$lang['folderhidden'] = "Ce dossier est caché";
$lang['hide'] = "peau";
$lang['unhide'] = "unhide";
$lang['nosubfolders'] = "Aucun subfolders dans cette catégorie";
$lang['1subfolder'] = "1 subfolder dans cette catégorie";
$lang['subfoldersinthiscategory'] = "subfolders dans cette catégorie";
$lang['linksdelexp'] = "Les entrées dans un dossier effacé seront transférées au dossier de parent. Seulement les dossiers qui ne contiennent pas subfolders peuvent être effacés.";
$lang['listview'] = "Vue de liste";
$lang['listviewcannotaddfolders'] = "Ne peut pas ajouter de dossier dans cette vue. Le maximum de démonstration 30 entrées.";
$lang['rating'] = "Classement";
$lang['commentsslashvote'] = "Les commentaires / le Vote";
$lang['nolinksinfolder'] = "Aucuns liens dans ce dossier.";
$lang['addlinkhere'] = "Ajouter le lien ici";
$lang['notvalidURI'] = "Cela n'est pas un URI valide!";
$lang['mustspecifyname'] = "Vous devez spécifier un nom!";
$lang['mustspecifyvalidfolder'] = "Vous devez spécifier un dossier valide!";
$lang['mustspecifyfolder'] = "Vous devez spécifier un dossier!";
$lang['addlink'] = "Ajouter un lien";
$lang['addinglinkin'] = "Ajouter un lien";
$lang['addressurluri'] = "Adresse (URL/URI)";
$lang['addnewfolder'] = "Ajouter un nouveau dossier";
$lang['addnewfolderunder'] = "Ajoutant le nouveau dossier sous";
$lang['mustchooserating'] = "Vous devez choisir un classement!";
$lang['commentadded'] = "Your comment was added.";
$lang['musttypecomment'] = "Votre commentaire a été ajouté!";
$lang['mustprovidelinkID'] = "Vous devez fournir une ID de lien!";
$lang['invalidlinkID'] = "La ID nulle de lien!";
$lang['address'] = "Adresse";
$lang['submittedby'] = "Soumis par";
$lang['clicks'] = "Déclics";
$lang['rating'] = "Classement";
$lang['vote'] = "Vote";
$lang['votes'] = "Votes";
$lang['notratedyet'] = "Pas évalué par n'importe qui pourtant";
$lang['rate'] = "Taux";
$lang['bad'] = "Mauvais";
$lang['good'] = "Bon";
$lang['voteexcmark'] = "Vote!";
$lang['commentby'] = "Commenter par";
$lang['nocommentsposted'] = "Aucuns commentaires ont été pourtant postés.";
$lang['addacommentabout'] = "Ajouter un commentaire de";
$lang['modtools'] = "Outils de modération";
$lang['editname'] = "Editer le nom";
$lang['editaddress'] = "Editer l'adresse";
$lang['editdescription'] = "Editer la description";
$lang['moveto'] = "Se transfère à";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "Utilisateur ID";
$lang['alreadyloggedin'] = "a abonné déjà";
$lang['loggedinsuccessfully'] = "Vous avez abonné avec succès.";
$lang['usernameorpasswdnotvalid'] = "Le username ou le mot de passe que vous n'avez pas fourni est valide.";
$lang['usernameandpasswdrequired'] = "Un username et le mot de passe est exigé";
$lang['welcometolight'] = "Bienvenu pour Suivre un régime la Ruche!";
$lang['pleasereenterpasswd'] = "S'il vous plaît revient dans votre mot de passe et essaie encore.";
$lang['rememberpasswds'] = "Se souvenir des mots de passe";
$lang['enterasa'] = "Entrer comme un";
$lang['donthaveanaccount'] = "Ne pas avoir un compte?";
$lang['problemsloggingon'] = "Les problèmes effectuant une procédure d'entrée?";
$lang['deletecookies'] = "Effacer  Cookies";
$lang['forgottenpasswd'] = "Oublié votre mot de passe?";
$lang['usingaPDA'] = "L'utilisation un PDA?";
$lang['lightHTMLversion'] = "La version légère de HTML";
$lang['youhaveloggedout'] = "Vous avez noté hors.";
$lang['currentlyloggedinas'] = "Vous êtes actuellement abonnés comme";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "Poster le message";
$lang['selectfolder'] = "Dossier privilégié";
$lang['messagecontainsHTML'] = "Le message contient de l'HTML";
$lang['notincludingsignature'] = "(pas y compris la signature)";
$lang['mustenterpostcontent'] = "Vous devez entrer quelque contenu pour la poste!";
$lang['messagepreview'] = "Aperçu";
$lang['invalidusername'] = "Username nul!";
$lang['mustenterthreadtitle'] = "Vous devez entrer un titre pour le fil!";
$lang['pleaseselectfolder'] = "S'il vous plaît choisir un dossier!";
$lang['errorcreatingpost'] = "L'erreur crée la poste! S'il vous plaît essayer encore dans quelques minutes.";
$lang['createnewthread'] = "Créer le nouveau fil";
$lang['postreply'] = "En réponse à";
$lang['threadtitle'] = "Titre de fil";
$lang['messagehasbeendeleted'] = "Le message a été effacé.";
$lang['converttoHTML'] = "Convertir à HTML";
$lang['pleaseentermembername'] = "S'il vous plaît entrer un membername:";
$lang['cannotpostthisthreadtypeinfolder'] = "Vous ne pouvez pas poster ce fil tape ce dossier!";
$lang['cannotpostthisthreadtype'] = "Vous ne pouvez pas poster ce type de fil comme il n'y a pas de dossiers disponibles qui il permettent.";
$lang['threadisclosedforposting'] = "Ce fil est fermé, vous ne pouvez pas poster dans il!";
$lang['moderatorthreadclosed'] = "L'avertissement: ce fil est fermé pour poster aux utilisateurs normaux.";
$lang['threadclosed'] = "Enfiler fermé";
$lang['usersinthread'] = "Les utilisateurs dans le fil";
$lang['correctedcode'] = "Code corrigé";
$lang['submittedcode'] = "Code soumis";
$lang['htmlinmessage'] = "HTML dans le message";
$lang['enabledwithautolinebreaks'] = "Rendu capable avec l'auto-linebreaks";
$lang['fixhtmlexplanation'] = "Ce forum utilise filtrer de HTML. Votre HTML soumis a été modifié par les filtres à certains égards.\\n\\nPour regarder votre code original, choisir le \\'Submitted code\\' radio button.\\nPour regarder le code modifié, choisir le \\'Corrected code\\' radio button.";
$lang['messageoptions'] = "Options de message";
$lang['notallowedembedattachmentpost'] = "Vous n'êtes pas permis d'enfoncer des attachements dans vos postes.";
$lang['notallowedembedattachmentsignature'] = "Vous n'êtes pas permis d'enfoncer des attachements dans votre signature.";

// Message display (messages.php) --------------------------------------

$lang['inreplyto'] = "En réponse à";
$lang['showmessages'] = "Montrer des messages";
$lang['ratemyinterest'] = "Evaluer mon intérêt";
$lang['adjtextsize'] = "Ajuster la taille de texte";
$lang['smaller'] = "Plus petit";
$lang['larger'] = "Plus grand";
$lang['faq'] = "FAQ";
$lang['docs'] = "Docs";
$lang['support'] = "Soutien";
$lang['threadcouldnotbefound'] = "Le fil demandé ne pourrait pas être trouvé ou accède à a été nié.";
$lang['mustselectpolloption'] = "Vous devez choisir une option pour voter pour!";
$lang['keepreading'] = "Garder la lecture";
$lang['backtothreadlist'] = "Le dos pour enfiler la liste";
$lang['postdoesnotexist'] = "Cette poste n'existe pas dans ce fil!";
$lang['clicktochangevote'] = "Le déclic pour changer le vote";
$lang['youvotedforoption'] = "Vous avez voté pour l'option";
$lang['youvotedforoptions'] = "Vous avez voté pour les options";
$lang['clicktovote'] = "Le déclic pour voter";
$lang['youhavenotvoted'] = "Vous n'avez pas voté";
$lang['viewresults'] = "La vue Résulte";
$lang['msgtruncated'] = "Le message A Tronqué";
$lang['viewfullmsg'] = "Regarder le message plein";
$lang['ignoredmsg'] = "Message négligé";
$lang['wormeduser'] = "Wormed utilisateur";
$lang['ignoredsig'] = "Signature négligée";
$lang['wasdeleted'] = "a été effacé";
$lang['stopignoringthisuser'] = "Arrête de négliger cet utilisateur";
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
$lang['until'] = "Jusqu' à 00:00 UTC";
$lang['stickyuntil'] = "Collant jusqu' à";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "Démarrage";
$lang['messages'] = "Messages";
$lang['pminbox'] = "PM Inbox";
$lang['pmsentitems'] = "Articles envoyés";
$lang['pmoutbox'] = "Outbox";
$lang['pmsaveditems'] = "Articles épargnés";
$lang['links'] = "Liens";
$lang['preferences'] = "Préférences";
$lang['profile'] = "Profil";
$lang['admin'] = "Admin";
$lang['login'] = "Login";
$lang['logout'] = "Logout";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------
$lang['privatemessages'] = "Messages privés";
$lang['addrecipient'] = "Ajoute le Bénéficiaire";
$lang['recipienttiptext'] = "Les bénéficiaires de Seperate par le point virgule ou la virgule";
$lang['maximumtenrecipientspermessage'] = "Il y a une limite de 10 bénéficiaires par le message. S'il vous plaît ammend votre liste de bénéficiaire.";
$lang['mustspecifyrecipient'] = "Vous devez spécifier au moins un bénéficiaire.";
$lang['usernotfound1'] = "Usage";
$lang['usernotfound2'] = "Pas trouvé.";
$lang['sendnewpm'] = "Envoyer Nouveau PM";
$lang['savemessage'] = "Epargner le Message";
$lang['sentby'] = "Envoyé Par";
$lang['timesent'] = "Chronométrer Envoyé";
$lang['nomessages'] = "Aucuns Messages";
$lang['errorcreatingpm'] = "L'erreur créant PM! S'il vous plaît essayer encore dans quelques minutes";
$lang['writepm'] = "Ecrire le Message";
$lang['editpm'] = "Editer le Message";
$lang['cannoteditpm'] = "Ne peut pas éditer ceci PM. Il a été déjà regardé par le bénéficiaire ou le message n'existe pas ou c'est inaccessible par vous";
$lang['cannotviewpm'] = "Ne peut pas regarder PM. Le message n'existe pas ou c'est inaccessible par vous";
$lang['nomessagespecifiedforreply'] = "Aucun message a spécifié pour la réponse à";
$lang['nouserspecified'] = "Aucun utilisateur a spécifié.";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "My Controls";
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
$lang['userinformation'] = "User Information";
$lang['changepassword'] = "Change Password";
$lang['newpasswd'] = "Nouveau Mot de passe";
$lang['confirmpasswd'] = "Confirmer le Mot de passe";
$lang['passwdsdonotmatch'] = "Les mots de passe pas allumette!";
$lang['nicknamerequired'] = "Le surnom est exigé!";
$lang['emailaddressrequired'] = "Adresse mél est exige!";
$lang['jan'] = "Janvier";
$lang['feb'] = "Février";
$lang['mar'] = "Mars";
$lang['apr'] = "Avril";
$lang['may'] = "Mai";
$lang['jun'] = "Juin";
$lang['jul'] = "Juillet";
$lang['aug'] = "Août";
$lang['sep'] = "Septembre";
$lang['oct'] = "Octobre";
$lang['nov'] = "Novembre";
$lang['dec'] = "Décembre";
$lang['userpreferences'] = "Préférences d'utilisateur";
$lang['preferencesupdated'] = "Les préférences avec succès ont été mises à jour.";
$lang['leaveblanktoretaincurrentpasswd'] = "Omettre les champs pour retenir le mot de passe actuel";
$lang['firstname'] = "Prénom";
$lang['lastname'] = "Nom de famille";
$lang['dateofbirth'] = "Date de naissance";
$lang['homepageURL'] = "URL de votre page d'accueil";
$lang['pictureURL'] = "URL de votre image";
$lang['forumoptions'] = "Forum Options";
$lang['notifybyemail'] = "Me notifier par mél de messages";
$lang['notifyofnewpm'] = "Me notifier par popup de nouveaux messages personels.";
$lang['notifyofnewpmemail'] = "Me notifier par mél de nouveaux messages personels";
$lang['daylightsaving'] = "DST";
$lang['autohighinterest'] = "Automatiquement marquer comme intéressant les discussions dans lesquelles je participe";
$lang['convertimagestolinks'] = "Automatically convert embedded images in posts into links";
$lang['globallyignoresigs'] = "Ignorer globalement les signatures d'utilisateurs";
$lang['timezonefromGMT'] = "Fuseau horaire";
$lang['postsperpage'] = "Nombre de messages par page";
$lang['fontsize'] = "Taille du jeu de caractères";
$lang['forumstyle'] = "Style de forum";
$lang['startpage'] = "Commencer par la page";
$lang['containsHTML'] = "contient de l'HTML";
$lang['preferredlang'] = "Langue préférée";
$lang['ageanddob'] = "Age et date de naissance";
$lang['neitheragenordob'] = "ne pas l'afficher aux autres";
$lang['showonlyage'] = "afficher uniquement l'âge aux autres";
$lang['showageanddob'] = "afficher aux autres";
$lang['browseanonymously'] = "Naviguer le forum anonymement";
$lang['showforumstats'] = "Afficher les statistiques du forum en bas du volet de messagerie.";
$lang['timezone'] = "Time Zone";
$lang['language'] = "Language";
$lang['emailsettings'] = "Email Settings";
$lang['privacysettings'] = "Privacy Settings";

// Polls (create_poll.php, pollresults.php) ---------------------------------------------

$lang['mustenterpollquestion'] = "Vous devez entrer une question de sondage";
$lang['groupcountmustbelessthananswercount'] = "Le numéro de groupes de réponse doit être le numéro moins que total de réponses";
$lang['pleaseselectfolder'] = "S'il vous plaît choisir un dossier";
$lang['mustspecifyvalues1and2'] = "Vous devez spécifier des valeurs pour les réponses 1 et 2";
$lang['cannotcreatemultivotepublicballot'] = "Vous ne pouvez pas créer multi-vote les bulletins de vote publics. Les bulletins de vote publics exigent que l'usage de noter de vote pour ait travaillé.";
$lang['abletochangevote'] = "Vous pourrez changer votre vote.";
$lang['abletovotemultiple'] = "Vous pourrez voter des temps multiples.";
$lang['notabletochangevote'] = "Vous ne pourrez pas changer votre vote.";
$lang['pollvotesrandom'] = "Note: les votes de Sondage sont engendrés au hasard pour l'avant-première seulement.";
$lang['pollquestion'] = "Question de sondage";
$lang['possibleanswers'] = "Réponses possibles";
$lang['enterpollquestionexp'] = "Entrer les réponses pour votre question de sondage. Si votre sondage est un \"yes/no\" la question, simplement entrer \"Yes\" pour la Réponse 1 et \"No\" pour la Réponse 2.";
$lang['numberanswers'] = "No les Réponses";
$lang['answerscontainHTML'] = "Les réponses Contiennent HTML (pas y compris la signature)";
$lang['votechanging'] = "Voter Changer";
$lang['votechangingexp'] = "Pouvoir une personne change son ou son vote?";
$lang['allowmultiplevotes'] = "Permettre des Votes Multiples";
$lang['pollresults'] = "Le sondage Résulte";
$lang['pollresultsexp'] = "Comment vous ferait comme afficher les résultats de votre sondage?";
$lang['pollvotetype'] = "Interroger le Type de Suffrage";
$lang['pollvotesexp'] = "Comment devrait le sondage est dirigé?";
$lang['pollvoteanon'] = "Anonymement";
$lang['pollvotepub'] = "Bulletin de vote public";
$lang['pollresultnote'] = "<b>Note:</b> Choisir 'le bulletin de vote Public' fera overide le type de résultat de sondage.";
$lang['horizgraph'] = "Graphique horizontal";
$lang['vertgraph'] = "Graphique vertical";
$lang['publicviewable'] = "Bulletin de vote public";
$lang['polltypewarning'] = "<b>Avertissement</b>: Ceci est un bulletin de vote public. Votre nom sera visible à côté de l'option que vous votez pour.";
$lang['expiration'] = "Expiration";
$lang['showresultswhileopen'] = "Faire vous voulez montrer des résultats pendant que le sondage est ouvert?";
$lang['whenlikepollclose'] = "Quand aimeriez-vous que votre sondage automatiquement pour ait fermé?";
$lang['oneday'] = "Un jour";
$lang['threedays'] = "Trois jours";
$lang['sevendays'] = "Sept jours";
$lang['thirtydays'] = "Trente jours";
$lang['never'] = "Jamais";
$lang['polladditionalmessage'] = "Le Message supplémentaire (Facultatif)";
$lang['polladditionalmessageexp'] = "Faire vous voulez inclure une poste supplémentaire après le sondage?";
$lang['mustspecifypolltoview'] = "Vous devez spécifier un sondage pour regarder.";
$lang['pollconfirmclose'] = "Vous sont sûr vous voulez fermer le Sondage suivant?";
$lang['endpoll'] = "Sondage de fin";
$lang['nobodyvoted'] = "Personne n'a voté.";
$lang['nobodyhasvoted'] = "Personne n'a voté.";
$lang['1personvoted'] = "1 personne a voté.";
$lang['1personhasvoted'] = "1 personne a voté.";
$lang['peoplevoted'] = "les gens ont voté.";
$lang['peoplehavevoted'] = "les gens ont voté.";
$lang['pollhasended'] = "Le sondage a terminé";
$lang['youvotedfor'] = "Vous avez voté pour";
$lang['thisisapoll'] = "Ceci est un sondage. Le déclic pour regarder des résultats.";
$lang['editpoll'] = "Editer le Sondage";
$lang['results'] = "Résultats";
$lang['resultdetails'] = "Le résultat Détaille";
$lang['changevote'] = "Vote de changement";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "Editer le Profil";
$lang['profileupdated'] = "Le profil a mis à jour.";
$lang['profilesnotsetup'] = "Le propriétaire de forum n'a pas établi de Profil.";
$lang['nouserspecified'] = "Aucun utilisateur a spécifié";
$lang['ignoreduser'] = "Utilisateur négligé";
$lang['lastvisit'] = "Dernière Visite";
$lang['sendemail'] = "Envoyer l'e-mail";
$lang['sendpm'] = "Envoyer PM";
$lang['removefromfriends'] = "Enlever des amis";
$lang['addtofriends'] = "Ajouter aux amis";
$lang['stopignoringuser'] = "Arrête de négliger l'utilisateur";
$lang['ignorethisuser'] = "Négliger cet utilisateur";
$lang['age'] = "Age";
$lang['aged'] = "vieilli";
$lang['birthday'] = "Anniversaire";
$lang['editmyattachments'] = "Editer Mon Attachements";

// Registration (register.php) -----------------------------------------

$lang['usernamemustnotcontainHTML'] = "Username ne doit pas contenir les étiquettes de HTML";
$lang['usernameinvalidchars'] = "Username peut contenir seulement l'un-z, 0-9, _ - les caractères";
$lang['usernametooshort'] = "Username doit être au moins 2 caractères longs";
$lang['usernametoolong'] = "Username doit être au maximum 15 caractères longs";
$lang['usernamerequired'] = "Un nom de logon est exigé";
$lang['passwdmustnotcontainHTML'] = "Le mot de passe ne doit pas contenir les étiquettes de HTML";
$lang['passwdtooshort'] = "Le mot de passe doit être au moins 6 caractères longs";
$lang['passwdrequired'] = "Un mot de passe est exigé";
$lang['confirmationpasswdrequired'] = "Un mot de passe de confirmation est exigé";
$lang['nicknamemustnotcontainHTML'] = "Surnommer ne doit pas contenir les étiquettes de HTML";
$lang['nicknamerequired'] = "Un surnom est exigé";
$lang['emailmustnotcontainHTML'] = "Envoie un e-mail à ne doit pas contenir les étiquettes de HTML";
$lang['emailrequired'] = "Une Adresse mél est exigée";
$lang['passwdsdonotmatch'] = "Les mots de passe pas allumette";
$lang['usernamesameaspasswd'] = "Username et le mot de passe doivent être différents";
$lang['usernameexists'] = "Désolé, un utilisateur avec ce nom existe déjà";
$lang['userrecordcreated'] = "Huzzah! Votre disque d'utilisateur a été créé avec succès!";
$lang['errorcreatinguserrecord'] = "L'erreur crée le disque d'utilisateur";
$lang['userregistration'] = "Enregistrement d'utilisateur";
$lang['registrationinformationrequired'] = "L'Information d'enregistrement (A Exigé)";
$lang['profileinformationoptional'] = "L'Information de profil (Facultatif)";
$lang['preferencesoptional'] = "Les préférences (Facultatif)";
$lang['register'] = "Registre";
$lang['rememberpasswd'] = "Se souvenir du mot de passe";
$lang['birthdayrequired'] = "Votre date de naissance est exigée ou est nul";
$lang['alwaysnotifymeofrepliestome'] = "Notifier sur la réponse me";
$lang['notifyonnewprivatemessage'] = "Notifier sur nouveau le Message Privé";
$lang['popuponnewprivatemessage'] = "Revient sur nouveau le Message Privé";
$lang['automatichighinterestonpost'] = "Automatique l'haut intérêt sur la poste";
$lang['itemsmarkedwithaasterixarerequired'] = "Les articles ont marqué avec un * sont exigé";
$lang['confirmpassword'] = "Confirmer le Mot de passe";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "Membre";
$lang['searchforusernotinlist'] = "Cherche un utilisateur pas dans la liste";
$lang['yoursearchdidnotreturnanymatches'] = "Votre recherche n'est pas retournée d'allumette. Essayer simplifiant vos paramètres de recherche et essaie encore.";

// Relationships (user_rel.php) ----------------------------------------

$lang['userrelationship'] = "Relation d'utilisateur";
$lang['userrelationships'] = "Rapports d'utilisateur";
$lang['friends'] = "Friends";
$lang['ignoredusers'] = "Ignored Users";
$lang['ignoredsignatures'] = "Ignored Signatures";
$lang['relationship'] = "Relation";
$lang['friend_exp'] = "Les postes de l'utilisateur ont marqué avec un &quot;Friend&quot; icon.";
$lang['normal_exp'] = "Les postes de l'utilisateur apparaissent comme normal.";
$lang['ignore_exp'] = "Les postes de l'utilisateur sont cachées.";
$lang['display'] = "Exposition";
$lang['displaysig_exp'] = "La signature de l'utilisateur est affiché sur leurs postes.";
$lang['hidesig_exp'] = "La signature de l'utilisateur est cachée sur leurs postes.";
$lang['globallyignored'] = "Globalement négligé";
$lang['globallyignoredsig_exp'] = "Aucunes signatures sont affiché.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "Résultat de recherches";
$lang['usernamenotfound'] = "Le username que vous avez spécifié dans l'à ou du champ n'a pas été trouvé.";
$lang['notexttosearchfor_1'] = "Vous n'avez pas spécifié de mot pour chercher ou les mots étaient sous";
$lang['notexttosearchfor_2'] = "les caractères longs";
$lang['foundzeromatches'] = "Trouvé: 0 allumettes";
$lang['found'] = "Trouvé";
$lang['matches'] = "allumettes";
$lang['prevpage'] = "Page précédente";
$lang['findmore'] = "Trouver plus";
$lang['searchmessages'] = "Chercher des Messages";
$lang['searchdiscussions'] = "Chercher la discussion";
$lang['containingallwords'] = "Contenir tous les mots";
$lang['containinganywords'] = "Contenir n'importe quel des mots";
$lang['containingexactphrase'] = "Contenir la phrase exacte";
$lang['find'] = "Découverte";
$lang['wordsshorterthan_1'] = "Les mots plus courts que";
$lang['wordsshorterthan_2'] = "les caractères ne seront pas inclus";
$lang['additionalcriteria'] = "Critères supplémentaires";
$lang['folderbrackets_s'] = "Le dossier(s)";
$lang['postedfrom'] = "Posté de";
$lang['postedto'] = "Posté à";
$lang['today'] = "Aujourd'hui";
$lang['yesterday'] = "Hier";
$lang['daybeforeyesterday'] = "Le jour avant hier";
$lang['weekago'] = "la semaine il y a";
$lang['weeksago'] = "les semaines il y a";
$lang['monthago'] = "le mois il y a";
$lang['monthsago'] = "les mois il y a";
$lang['yearago'] = "l'année il y a";
$lang['beginningoftime'] = "Le commencement de temps";
$lang['now'] = "Maintenant";
$lang['relevance'] = "Pertinence";
$lang['newestfirst'] = "Plus nouveau premièrement";
$lang['oldestfirst'] = "Plus vieux premièrement";
$lang['onlyshowmessagestoorfromme'] = "Seulement les messages de spectacle à ou de moi";
$lang['groupsresultsbythread'] = "Le groupe résulte par le fil";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "Fil récents";
$lang['startreading'] = "Commencer la Lecture";
$lang['threadoptions'] = "Options";
$lang['showmorevisitors'] = "Montrer plus de Visiteurs";
$lang['forthcomingbirthdays'] = "Prochains Anniversaires";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "Nouvelle Discussion";
$lang['createpoll'] = "Créer le Sondage";
$lang['search'] = "Recherche";
$lang['searchagain'] = "Recherche Encore";
$lang['alldiscussions'] = "Toutes Discussions";
$lang['unreaddiscussions'] = "Discussions non lues";
$lang['unreadtome'] = "Non lu &quot;A: Me&quot;";
$lang['todaysdiscussions'] = "Aujourd'hui Discussions";
$lang['2daysback'] = "2 Les jours Soutiennent";
$lang['7daysback'] = "7 Les jours Soutiennent";
$lang['highinterest'] = "Haut Intérêt";
$lang['unreadhighinterest'] = "Non lu Haut Interest";
$lang['iverecentlyseen'] = "J'ai vu récemment";
$lang['iveignored'] = "J'ai négligé";
$lang['ivesubscribedto'] = "Je se suis abonné à";
$lang['startedbyfriend'] = "Commencé par l'ami";
$lang['unreadstartedbyfriend'] = "Non lu commencé par l'ami";
$lang['goexcmark'] = "Valider!";
$lang['folderinterest'] = "Intérêt de dossier";
$lang['postnew'] = "Poster Nouveau";
$lang['currentthread'] = "Fil actuel";
$lang['highinterest'] = "Haut Intérêt";
$lang['markasread'] = "Marquer comme lu";
$lang['next50discussions'] = "Prochain 50 discussions";
$lang['visiblediscussions'] = "Discussions visibles";
$lang['navigate'] = "Naviguer";
$lang['couldnotretrievefolderinformation'] = "Il n'y a pas de dossiers disponibles.";
$lang['nomessagesinthiscategory'] = "Aucuns messages dans cette catégorie. S'il vous plaît choisir un autre, ou";
$lang['clickhere'] = "cliqueter ici";
$lang['forallthreads'] = "pour tous fils";
$lang['prev50threads'] = "Précédent 50 fils";
$lang['next50threads'] = "Prochain 50 fils";
$lang['startedby'] = "Commencé par";
$lang['unreadthread'] = "Fil non lu";
$lang['readthread'] = "Lire le Fil";
$lang['unreadmessages'] = "Messages non lus";
$lang['subscribed'] = "S'abonné";
$lang['ignorethisfolder'] = "Négliger Ce Dossier";
$lang['stopignoringthisfolder'] = "Arrête de Négliger Ce Dossier";
$lang['stickythreads'] = "Fils collants";
$lang['mostunreadposts'] = "La plupart des postes non lus";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "Hardi";
$lang['italic'] = "Italique";
$lang['underline'] = "Souligner";
$lang['strikethrough'] = "Strikethrough";
$lang['superscript'] = "Exposant";
$lang['subscript'] = "Indice inférieur";
$lang['leftalign'] = "Gauche-aligne";
$lang['center'] = "Centre";
$lang['rightalign'] = "Droite-aligne";
$lang['numberedlist'] = "Liste numérotée";
$lang['list'] = "Liste";
$lang['indenttext'] = "Indenter le texte";
$lang['code'] = "Code";
$lang['quote'] = "Citation";
$lang['horizontalrule'] = "Règle horizontale";
$lang['image'] = "Image";
$lang['hyperlink'] = "Hyperlink";
$lang['fontface'] = "Face de jeu de caractères";
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
$lang['db_connect_error_1'] = "An error has occured while connecting to the database.";
$lang['db_connect_error_2'] = "If you are the forum owner, please ensure the following variables in your config.inc.php are set correctly:";
$lang['db_connect_error_3'] = "They should be set to the database details given to you by your hosting provider.";
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

?>