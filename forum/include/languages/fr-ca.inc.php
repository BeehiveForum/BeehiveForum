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
$lang['month'][2]  = "Février";
$lang['month'][3]  = "Mars";
$lang['month'][4]  = "Avril";
$lang['month'][5]  = "Mai";
$lang['month'][6]  = "Juin";
$lang['month'][7]  = "Juillet";
$lang['month'][8]  = "Août";
$lang['month'][9]  = "Septembre";
$lang['month'][10] = "Octobre";
$lang['month'][11] = "Novembre";
$lang['month'][12] = "Décembre";

$lang['month_short'][1]  = "jan";
$lang['month_short'][2]  = "fév";
$lang['month_short'][3]  = "mars";
$lang['month_short'][4]  = "avr";
$lang['month_short'][5]  = "mai";
$lang['month_short'][6]  = "juin";
$lang['month_short'][7]  = "juil";
$lang['month_short'][8]  = "août";
$lang['month_short'][9]  = "sep";
$lang['month_short'][10] = "oct";
$lang['month_short'][11] = "nov";
$lang['month_short'][12] = "déc";

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
$lang['locked'] = "Verrouillé";
$lang['add'] = "Ajouter";
$lang['advanced'] = "Avancé";
$lang['active'] = "Actif";
$lang['style'] = "Style";
$lang['go'] = "Allez-y";
$lang['folder'] = "Dossier";
$lang['ignoredfolder'] = "Dossier ignoré";
$lang['folders'] = "Dossiers";
$lang['thread'] = "fil de discussion";
$lang['threads'] = "fils de discussion";
$lang['threadlist'] = "Thread List";
$lang['message'] = "Message";
$lang['messagenumber'] = "Numéro de message";
$lang['from'] = "De";
$lang['to'] = "À";
$lang['all_caps'] = "TOUS";
$lang['of'] = "de";
$lang['reply'] = "Répondre";
$lang['forward'] = "Forward";
$lang['replyall'] = "Répondre à tous";
$lang['pm_reply'] = "Répondre en MP";
$lang['delete'] = "supprimer";
$lang['deleted'] = "supprimé";
$lang['edit'] = "Modifier";
$lang['privileges'] = "Privilèges";
$lang['ignore'] = "Ignorer";
$lang['normal'] = "Normal";
$lang['interested'] = "Interessé";
$lang['subscribe'] = "S'abonner à";
$lang['apply'] = "Appliquer";
$lang['download'] = "Télécharger";
$lang['save'] = "Enregistrer";
$lang['update'] = "Mettre à jour";
$lang['cancel'] = "Annuler";
$lang['retry'] = "Retry";
$lang['continue'] = "Continuer";
$lang['attachment'] = "Fichier joint";
$lang['attachments'] = "Fichiers joints";
$lang['imageattachments'] = "Image jointe";
$lang['filename'] = "Nom de fichier";
$lang['dimensions'] = "Dimensions";
$lang['downloadedxtimes'] = "Téléchargé: %d fois";
$lang['downloadedonetime'] = "Téléchargé: 1 fois";
$lang['size'] = "Taille de fichier";
$lang['viewmessage'] = "voir le message";
$lang['deletethumbnails'] = "Supprimer vignettes";
$lang['logon'] = "Ouverture de session";
$lang['more'] = "Plus";
$lang['recentvisitors'] = "Dernières visites";
$lang['username'] = "nom d'utilisateur";
$lang['clear'] = "Effacer";
$lang['action'] = "Action";
$lang['unknown'] = "Inconnu";
$lang['none'] = "aucun";
$lang['preview'] = "Aperçu";
$lang['post'] = "Poster";
$lang['posts'] = "Messages";
$lang['change'] = "Changer";
$lang['yes'] = "Oui";
$lang['no'] = "Non";
$lang['signature'] = "Signature";
$lang['signaturepreview'] = "Aperçu de Signature";
$lang['signatureupdated'] = "Signature mise à jour";
$lang['back'] = "Retour";
$lang['subject'] = "Sujet";
$lang['close'] = "Fermer";
$lang['name'] = "Nom";
$lang['description'] = "Description";
$lang['date'] = "Date";
$lang['view'] = "Visualiser";
$lang['enterpasswd'] = "Entrer mot de passe";
$lang['passwd'] = "Mot de passe";
$lang['ignored'] = "Ignoré(e)";
$lang['guest'] = "Visiteur";
$lang['next'] = "Prochain";
$lang['prev'] = "Précédent";
$lang['others'] = "Autres";
$lang['nickname'] = "Pseudonyme";
$lang['emailaddress'] = "Adress courriel";
$lang['confirm'] = "Confirmer";
$lang['email'] = "Courriel";
$lang['poll'] = "Scrutin";
$lang['friend'] = "Ami(e)";
$lang['error'] = "Erreur";
$lang['guesterror'] = "Désolé, vous devez ouvrir une session pour utiliser cette fonction.";
$lang['loginnow'] = "Ouvrir une session maintenant";
$lang['unread'] = "non-lu";
$lang['all'] = "Tous";
$lang['allcaps'] = "TOUS";
$lang['permissions'] = "Droits d'accès";
$lang['type'] = "Type";
$lang['print'] = "Imprimer";
$lang['sticky'] = "Collant";
$lang['polls'] = "Scrutins";
$lang['user'] = "Utilisateur";
$lang['enabled'] = "Activé";
$lang['disabled'] = "Désactivé";
$lang['options'] = "Options";
$lang['emoticons'] = "Binettes";
$lang['webtag'] = "balise d'adresse web";
$lang['makedefault'] = "En faire l'option par défaut";
$lang['unsetdefault'] = "Supprimer le défaut";
$lang['rename'] = "Renommer";
$lang['pages'] = "Pages";
$lang['used'] = "Utilisé";
$lang['days'] = "jours";
$lang['usage'] = "Utilisation";
$lang['show'] = "Montrer";
$lang['hint'] = "Indice";
$lang['new'] = "Nouveau";
$lang['referer'] = "Référent";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "OUtils admin";
$lang['forummanagement'] = "Gestion du forum";
$lang['accessdeniedexp'] = "Vous n'avez pas les droits d'accès pour utiliser cette section.";
$lang['managefolders'] = "Organiser les dossiers";
$lang['manageforums'] = "Organiser les forums";
$lang['manageforumpermissions'] = "Organiser les droits d'accès du forum";
$lang['foldername'] = "Nom du dossier";
$lang['move'] = "Déplacer";
$lang['closed'] = "Fermé";
$lang['open'] = "Ouvert";
$lang['restricted'] = "Limité";
$lang['iscurrentlyclosed'] = "est présentement fermé";
$lang['youdonothaveaccessto'] = "Vous n'avez pas les droits d'accès à";
$lang['toapplyforaccessplease'] = "Pour demander accès, veuillez contacter le propriétaire du forum.";
$lang['adminforumclosedtip'] = "Si vous désirez changer certains réglages sur votre forum, cliquer le lien Admin dans la barre de navigation ci-dessus.";
$lang['newfolder'] = "Nouveau dossier";
$lang['forumadmin'] = "Admin du forum";
$lang['adminexp_1'] = "Utiliser le menu à gauche pour gérer votre forum.";
$lang['adminexp_2'] = "<b>Utilisateurs</b> vous permet de fixer les droits d'accès d'utilisateurs individuels, y inclut la nomination d'éditeurs et le baîllonnement d'individus.";
$lang['adminexp_3'] = "<b>Groupes d'utilisateurs</b> vous permet de créer des groupes d'utilisateurs pour assigner des droits d'accès à quelques ou plusieurs utilisateurs rapidement et facilement.";
$lang['adminexp_4'] = "<b>Commandes de bannissement</b> permet le bannissement et la levée de bannissement d'adresses IP, noms d'utilisateurs, adresses courriel et pseudonymes.";
$lang['adminexp_5'] = "<b>Dossiers</b> permet de créer, modifier et de supprimer les dossiers.";
$lang['adminexp_6'] = "<b>RSS Feeds</b> allows you to create and remove RSS feeds for propogation into your forum.";
$lang['adminexp_7'] = "<b>Profiles</b> vous permet de personnaliser les détails qui apparaîssent dans les profiles d'utilisateurs.";
$lang['adminexp_8'] = "<b>Options du forum</b> vous permet de personnaliser le nom du forum, l'apparence et plusieurs autres choses.";
$lang['adminexp_9'] = "<b>Page de démarrage</b> permet la personnalisation de la page de démarrage de votre forum.";
$lang['adminexp_10'] = "<b>Style du forum</b> vous permet de créer des styles que vos membres pourront utiliser.";
$lang['adminexp_11'] = "<b>Filtrage de mots</b> vous permet de filtrer les mots dont vous voulez interdire l'usage sur votre forum.";
$lang['adminexp_12'] = "<b>Statistiques de postage</b> produit un rapport des 10 posteurs les plus prolifiques durant une période de temps définie.";
$lang['adminexp_13'] = "<b>Liens de Forums</b> permet la gestion de la liste déroulante verticale de liens dans la barre de navigation.";
$lang['adminexp_14'] = "<b>Visualiser le fichier journal</b> permet de voir chacune des actions récentes prises par les modérateurs du forum.";
$lang['adminexp_15'] = "<b>Gestion du forum</b> permet la création, suppression, fermeture et réouverture des forums.";
$lang['adminexp_16'] = "<b>Options de forum globales</b> vous permet de modifier les options qui touchent tous les forums.";
$lang['adminexp_17'] = "<b>File d'attente de postes à approuver</b> vous permet de voir tous messages en attente d'approbation par un modérateur.";
$lang['adminexp_18'] = "<b>Fichier journal des visiteurs</b> vous permet de voir une liste détaillée des visiteurs, y inclut leur référent HTTP.";
$lang['createforumstyle'] = "Créer un style pour le forum";
$lang['newstylesuccessfullycreated'] = "Nouveau style %s créé avec succès.";
$lang['stylealreadyexists'] = "Un style avec ce nom de fichier existe déjà.";
$lang['stylenofilename'] = "Vous n'avez pas entrer un nom de fichier pour enregistrer ce style.";
$lang['stylenodatasubmitted'] = "Impossible de lire les données du style de forum.";
$lang['styleexp'] = "Utiliser cette page pour vous aider à créer un style généré aléatoirement pour votre forum.";
$lang['stylecontrols'] = "Contrôles";
$lang['stylecolourexp'] = "Cliquer sur une couleur pour créer un nouveau stylesheet basé sur cette couleur. La couleur de base courrante est en tête de liste.";
$lang['standardstyle'] = "Style Standard";
$lang['rotelementstyle'] = "Style d'élément inversé";
$lang['randstyle'] = "Style aléatoire";
$lang['thiscolour'] = "Cette Couleur";
$lang['enterhexcolour'] = "ou entrer une couleur hex pour servir de base pour un nouveau stylesheet.";
$lang['savestyle'] = "Enregistrer ce style";
$lang['styledesc'] = "Desc. de Style";
$lang['fileallowedchars'] = "(lettres bas de casse (a-z), chiffres (0-9) et soulignement (_) seulement)";
$lang['stylepreview'] = "Aperçu du style";
$lang['welcome'] = "Bienvenue";
$lang['messagepreview'] = "Aperçu du message";
$lang['users'] = "Utilisateurs";
$lang['usergroups'] = "Groupes d'utilisateurs";
$lang['mustentergroupname'] = "Vous devez inclure un nom de groupe";
$lang['profiles'] = "Profiles";
$lang['manageforums'] = "Organiser les forums";
$lang['forumsettings'] = "Options de forum";
$lang['globalforumsettings'] = "Options de forum globales";
$lang['settingsaffectallforumswarning'] = "<b>Note:</b> Ces options affectent tous les forums. En cas de duplication d'un ou plusieurs option sur la page d'options d'un forum individuel, ces options prendront précédence sur les options que vous changez ici.";
$lang['startpage'] = "Page de démarrage";
$lang['startpageerror'] = "Votre page de démarrage n'a pas pu être entregistrer locallement sur le serveur à cause de déni de permission. Pour modifier votre page de démarrage, SVP cliquer le bouton de téléchargement ci-dessous qui vous invitera à enregister le fichier sur votre disque dur. Vous pourriez par la suite téléverser ce fichier vers le dossier %s sur votre serveur. SVP noter que certains navigateurs web pourraient changer le nom du fichier sur téléchargement. Lorsque vous téléversez le fichier, SVP vous assurer de le nommer start_main.php sinon les modifications n'apparaîtront pas.";
$lang['failedtoopenmasterstylesheet'] = "Votre style de forum n'a pas pu être enregistré parce que la feuille de style maîtresse n'a pas pu être chargée. Pour enregistrer votre style, la feuille de style maîtresse (make_style.css) doit être située dans le répertoire styles de votre installation Beehive Forum.";
$lang['makestyleerror'] = "Votre style de forum n'a pas pu être sauvegarder localement sur le serveur parce que la permission a été refusée. Pour sauvegarder votre style de forum, cliquer le bouton de téléchargement ci-dessous ce qui vous invitera à sauvegarder le fichier sur votre lecteur de disque dur. Vous pouvez ensuite téléverser ce fichier à votre serveur dans le dossier %s et si nécéssaire, créant la structure de dossier en même temps. SVP noter que certains navigateurs web changeront peut-être le nom du fichier sur téléchargement. Lors du téléversement de ce fichier, SVP vous assurer qu'il est nommé style.css sinon ce style de forum sera inutilisable.";
$lang['uploadfailed'] = "Votre nouvelle page de démarrage n'a pas pu être téléversée au serveur à cause de déni de permission. SVP vérifier que le serveur web / processus PHP est capable d'écrire au dossier %s sur votre serveur.";
$lang['forumstyle'] = "Style du forum";
$lang['wordfilter'] = "Filtre des mots";
$lang['forumlinks'] = "Liens de forum";
$lang['viewlog'] = "Visualiser fichier journal";
$lang['noprofilesectionspecified'] = "Aucune section de profile spécifiée.";
$lang['itemname'] = "Nom d'item";
$lang['moveto'] = "Déplacer vers";
$lang['manageprofilesections'] = "Organiser la section profile";
$lang['sectionname'] = "Nom de section";
$lang['items'] = "Items";
$lang['mustspecifyaprofilesectionid'] = "Vous devez spécifier une identification pour la section du profil";
$lang['mustsepecifyaprofilesectionname'] = "Vous devez spécifier un nom pour la section du profil";
$lang['successfullyeditedprofilesection'] = "Modification de la section du profil réussie";
$lang['addnewprofilesection'] = "Ajouter une nouvelle section au profil";
$lang['mustsepecifyaprofilesectionname'] = "Vous devez spécifier un nom pour la section du profil";
$lang['successfullyremovedselectedprofilesections'] = "Sections du profil sélectionnées supprimer avec succès";
$lang['failedtoremoveprofilesections'] = "La suppression des sections du profil a échoué";
$lang['viewitems'] = "Visualiser les items";
$lang['successfullyremovedselectedprofileitems'] = "La suppression des sections du profil selectionnées réussi";
$lang['failedtoremoveprofileitems'] = " La suppression  des items du profil a échoué";
$lang['noexistingprofileitemsfound'] = "Il n'y a pas d'items de profil existants dans cette section. Pour ajouter un item de profil, cliquer le bouton ci-dessous.";
$lang['edititem'] = "Modifier l'item";
$lang['invaliditemidoritemnotfound'] = "Identification d'item non valide ou item non trouvé";
$lang['addnewitem'] = "Ajouter un nouveau item";
$lang['startpageupdated'] = "Page de démarrage mise à jour";
$lang['viewupdatedstartpage'] = "Visualiser la page de démarrage mise à jour";
$lang['editstartpage'] = "Modifier la page de démarrage";
$lang['nouserspecified'] = "Aucun utilisateur de spécifié";
$lang['manageuser'] = "Gérer l'utilisateur";
$lang['manageusers'] = "Gérer les utilisateurs";
$lang['userstatus'] = "Statut de l'utilisateur";
$lang['userdetails'] = "Détails d'utilisateur";
$lang['warning_caps'] = "MISE EN GARDE";
$lang['userdeleteallpostswarning'] = "Êtes-vous certain de vouloir supprimer tous les messages de l'utilisateur sélectionné? Une fois supprimés, les messages ne peuvent être récupérés et seront perdus pour toujours.";
$lang['postssuccessfullydeleted'] = "Suppression de messages réussie.";
$lang['folderaccess'] = "Accès aux dossiers";
$lang['possiblealiases'] = "Pseudonymes possibles";
$lang['userhistory'] = "Historique de l'usager";
$lang['nohistory'] = "Aucun rapport d'historique sauvegarder";
$lang['userhistorychanges'] = "Changements";
$lang['clearuserhistory'] = "Effacer l'historique de l'usager";
$lang['changedlogonfromto'] = "Changement de la session d'ouverture de %s à %s";
$lang['changednicknamefromto'] = "Changement du pseudonyme de %s à %s";
$lang['changedemailfromto'] = "Changement de l'adresse courriel de %s à %s";
$lang['usersettingsupdated'] = "La mise à jour des options d'utilisateurs réussie.";
$lang['nomatches'] = "Aucune correspondance trouvée.";
$lang['deleteposts'] = "Supprimer les messages";
$lang['deleteallusersposts'] = "Supprimer tous les messages de cet utilisateur";
$lang['noattachmentsforuser'] = "Aucun fichier joint pour cet utilisateur";
$lang['forgottenpassworddesc'] = "Si cet utilisateur a oublié leur mot de passe, vous pouvez le réinitialiser ici.";
$lang['manageusersexp'] = "Cette liste démontre une sélection d'utilisateurs qui ont ouvert une session sur votre forum, triée par %s. Pour modifier les droits d'accès d'un utilisateur, cliquer sur leur nom.";
$lang['userfilter'] = "Filtre des usagers";
$lang['onlineusers'] = "Usagers en ligne";
$lang['offlineusers'] = "Usagers hors ligne";
$lang['usersawaitingapproval'] = "Usagers en attente d'approbation";
$lang['bannedusers'] = "Usagers bannis";
$lang['lastlogon'] = "Dernière ouverture de session";
$lang['sessionreferer'] = "Orienteur de session";
$lang['signupreferer'] = "Orienteur d'enregistrement:";
$lang['nouseraccountsmatchingfilter'] = "Aucun compte d'usager assortissant avec le filtre";
$lang['searchforusernotinlist'] = "Chercher pour un utilisateur qui n'est pas sur la liste";
$lang['adminaccesslog'] = "Fichier journal d'accès admin";
$lang['adminlogexp'] = "Liste des dernières actions sanctionnées par les utilisateurs avec les droits d'accès admin.";
$lang['datetime'] = "Date/Heure";
$lang['unknownuser'] = "Utilisateur inconnu";
$lang['unknownfolder'] = "Dossier inconnu";
$lang['ip'] = "IP";
$lang['lastipaddress'] = "Dernière adresse IP";
$lang['logged'] = "Journalisé";
$lang['notlogged'] = "Non journalisé";
$lang['addwordfilter'] = "Ajouter filtre de mots";
$lang['addnewwordfilter'] = "Ajouter nouveau filtre de mots";
$lang['wordfilterupdated'] = "Mise à jour du filtre de mots";
$lang['filtername'] = "Filter Name";
$lang['filtertype'] = "Type de filtre";
$lang['filterenabled'] = "Filter Enabled";
$lang['editwordfilter'] = "Modifier le filtre de mots";
$lang['nowordfilterentriesfound'] = "Aucune entrée de filtre des mots existante trouvée. Pour ajouter un filtre des mots, cliquez le bouton ci-dessous.";
$lang['mustspecifymatchedtext'] = "Vous devez spécifier le texte apparié";
$lang['mustspecifyfilteroption'] = "Vous devez spécifier une option de filtre";
$lang['mustspecifyfilterid'] = "Vous devez spécifier une identification de filtre";
$lang['invalidfilterid'] = "Identification de filtre invalide";
$lang['failedtoupdatewordfilter'] = "Mise à jour du filtre des mots échouée.  Vérifiez que le filtre existe toujours.";
$lang['allow'] = "Permettre";
$lang['normalthreadsonly'] = "Fils de discussion normales uniquement";
$lang['pollthreadsonly'] = "Fils de discussion avec scrutins uniquement";
$lang['both'] = "Les deux types de fils de discussion permis";
$lang['existingpermissions'] = "Droits d'accès existants";
$lang['nousers'] = "Aucun utilisateur";
$lang['searchforuser'] = "Chercher pour utilisateur";
$lang['browsernegotiation'] = "Négocié par navigateur web";
$lang['largetextfield'] = "Gros champ de texte";
$lang['mediumtextfield'] = "Champ de texte moyen";
$lang['smalltextfield'] = "Petit champ de texte";
$lang['multilinetextfield'] = "Champ de texte multiligne";
$lang['radiobuttons'] = "Cases d'option";
$lang['dropdown'] = "Déroulant vertical";
$lang['threadcount'] = "Dénombrement des fils de discussion";
$lang['fieldtypeexample1'] = "Pour les cases d'option et les champs déroulants verticaux vous devez séparer le nom de champ et les valeurs avec un deux-points et chaque valeur doit être séparée par un point-virgule.";
$lang['fieldtypeexample2'] = "Example: Pour créer des cases d'option pour le sexe, avec deux sélections pour Homme et Femme, inscrire: <b>Sexe:Homme;Femme</b> dans le champ Nom d'Item.";
$lang['editedwordfilter'] = "Filtre de mots modifié";
$lang['editedforumsettings'] = "Options de forum modifiés";
$lang['sessionsuccessfullyended'] = "Terminaison de session réussie pour l'utilisateur";
$lang['matchedtext'] = "Texte correspondant";
$lang['replacementtext'] = "Texte de remplacement";
$lang['preg'] = "PREG";
$lang['wholeword'] = "Mot complet";
$lang['word_filter_help_1'] = "<b>Tous</b> recherche correspondances contre le texte complet alors le filtrage de c à c'est changera incidence à inc'estidenc'este.";
$lang['word_filter_help_2'] = "<b>Mot complet</b> recherche correspondance avec le mot complet seulement alors le filtrage de c à c'est ne changera PAS incidence à inc'estidenc'este.";
$lang['word_filter_help_3'] = "<b>PREG</b> permet l'utilisation des Regular Expressions du langage Perl pour trouver des correspondances de texte";
$lang['nameanddesc'] = "Nom et Description";
$lang['movethreads'] = "Déplacer fils de discussion";
$lang['threadsmovedsuccessfully'] = "Déplacement de fils de discussion réussie";
$lang['movethreadstofolder'] = "Déplacer fils de discussion au dossier";
$lang['resetuserpermissions'] = "Réinitialiser les permissions d'utilisateur";
$lang['userpermissionsresetsuccessfully'] = "Réinitialisation des permissions d'utilisateur réussie";
$lang['allowfoldertocontain'] = "Permettre au dossier de contenir";
$lang['addnewfolder'] = "Ajouter nouveau dossier";
$lang['mustenterfoldername'] = "Vous devez inscrire un nom de dossier";
$lang['nofolderidspecified'] = "Aucune identification de dossier définie";
$lang['invalidfolderid'] = "Identification de dossier invalide. Vérifier qu'un dossier avec cette identification existe!";
$lang['successfullyaddedfolder'] = "Ajout de dossier réussi";
$lang['successfullydeletedfolder'] = "Suppression de dossier réussie";
$lang['failedtodeletefolder'] = "La suppression du dossier a échoué.";
$lang['folderupdatedsuccessfully'] = "Mise à jour du dossier réussie";
$lang['cannotdeletefolderwiththreads'] = "Impossible de supprimer les dossiers contenant toujours des fils de discussion.";
$lang['forumisnotrestricted'] = "Forum n'est pas limité";
$lang['groups'] = "Groupes";
$lang['nousergroups'] = "Aucun groupe d'utilisateur établit";
$lang['suppliedgidisnotausergroup'] = "L'identification de group fournie n'est pas un groupe d'utilisateur";
$lang['manageusergroups'] = "Organiser les groupes d'utilisateurs";
$lang['groupstatus'] = "Statut de groupe";
$lang['addusergroup'] = "Ajouter groupe";
$lang['addremoveusers'] = "Ajouter/enlever utilisateurs";
$lang['nousersingroup'] = "Il n'y a pas d'utilisateurs dans ce groupe";
$lang['useringroups'] = "Cet utilisateur est membre des groupes suivants";
$lang['usernotinanygroups'] = "Cet utilisateur n'est pas dans aucun groupe d'utilisateurs";
$lang['usergroupwarning'] = "Note: Cet utilisateur pourrait accumuler les droits d'accès supplémentaires de un ou plusieurs des groupes d'utilisateurs énumérés ci-dessous.";
$lang['successfullyaddedgroup'] = "Ajout de groupe réussie";
$lang['successfullydeletedgroup'] = "Suppression de groupe réussie";
$lang['usercanaccessforumtools'] = "L'utilisateur peut accéder aux outils du forum et peut créer, supprimer et modifier les forums";
$lang['usercanmodallfoldersonallforums'] = "L'utilisateur peut modérer tous les dossiers sur tous les forums";
$lang['usercanmodlinkssectiononallforums'] = "L'utilisateur peut modérer la section des liens sur tous les forums";
$lang['emailconfirmationrequired'] = "Confirmation par courriel requis";
$lang['userisbannedfromallforums'] = "Usager est banni de <b>tous les forums</b>";
$lang['cancelemailconfirmation'] = "Annuler confirmation par courriel et permettre l'utilisateur de poster";
$lang['resendconfirmationemail'] = "Renvoyer confirmation par courriel à l'utilisateur";
$lang['donothing'] = "Ne faites rien";
$lang['usercanaccessadmintools'] = "L'utilisateur a accès aux outils admin du forum";
$lang['usercanaccessadmintoolsonallforums'] = "L'utilisatieur a accès aux outils admin <b>sur tous les forums</b>";
$lang['usercanmoderateallfolders'] = "L'utilisateur peut modérer tous les dossiers";
$lang['usercanmoderatelinkssection'] = "L'utilisateur peut modérer la section des Liens";
$lang['userisbanned'] = "L'utilisateur est banni";
$lang['useriswormed'] = "L'utilisateur est parasité";
$lang['userispilloried'] = "L'utilisateur est cloué au pilori";
$lang['usercanignoreadmin'] = "L'utilisateur peut ignorer les administrateurs";
$lang['groupcanaccessadmintools'] = "Groupe peut accéder aux outils admin";
$lang['groupcanmoderateallfolders'] = "Groupe peut modérer tous les dossiers";
$lang['groupcanmoderatelinkssection'] = "Groupe peut modérer la section des Liens";
$lang['groupisbanned'] = "Groupe est banni";
$lang['groupiswormed'] = "Groupe est parasité";
$lang['readposts'] = "Lire messages";
$lang['replytothreads'] = "Répondre aux fils de discussion";
$lang['createnewthreads'] = "Créer nouveaux fils de discussion";
$lang['editposts'] = "Réviser messages";
$lang['deleteposts'] = "Supprimer les messages";
$lang['uploadattachments'] = "Téléverser fichiers joints";
$lang['moderatefolder'] = "Modérer le dossier";
$lang['postinhtml'] = "Poster en HTML";
$lang['postasignature'] = "Poster une signature";
$lang['editforumlinks'] = "Modifier les Liens de Forum";
$lang['editforumlinks_exp'] = "Utiliser cette page pour l'ajout de liens à la liste déroulante verticale affichée au dessus-droit du cadre du forum. Si aucun lien est positionné, la liste déroulante verticale ne sera pas afficher.";
$lang['notoplevellinktitlespecified'] = "Aucun titre le lien de niveau supérieur d'indiqué";
$lang['toplinktitlesuccessfullyupdated'] = "Mise à jour du titre du lien de premier niveau réussi";
$lang['youmustenteralinktitle'] = "Vous devez entrer un titre de lien";
$lang['alllinkurismuststartwithaschema'] = "Tous URIs de liens doivent commencés avec un schéma (i.e. http://, ftp://, irc://)";
$lang['noexistingforumlinksfound'] = "Il n'y a pas de liens de forum existants. Pour ajouter un lien de forum, cliquez le bouton ci-dessous.";
$lang['editlink'] = "Modifier lien";
$lang['addnewforumlink'] = "Ajouter nouveau lien de forum";
$lang['forumlinktitle'] = "Titre du lien de forum";
$lang['forumlinklocation'] = "Localisation du lien de forum";
$lang['successfullyaddedlink'] = "Ajout du lien réussi: '%s'";
$lang['successfullyeditedlink'] = "Modification du lien réussi: '%s'";
$lang['invalidlinkidorlinknotfound'] = "Identification du lien invalide ou lien introuvable";
$lang['successfullyremovedselectedlinks'] = "La suppression des liens sélectionnés réussi";
$lang['failedtoremovelinks'] = "La suppression des liens sélectionnés a échoué";
$lang['failedtoaddnewlink'] = "Ajout du nouveau lien non-réussi: '%s'";
$lang['failedtoupdatelink'] = "Mise à jour du lien échouée: '%s'";
$lang['toplinkcaption'] = "Légende du lien de premier niveau";
$lang['allowguestaccess'] = "Permettre l'accès aux visiteurs";
$lang['searchenginespidering'] = "Balayage par moteurs de recherche";
$lang['allowsearchenginespidering'] = "Permettre le balayage par moteurs de recherche";
$lang['newuserregistrations'] = "Enregistrement de nouveaux utilisateurs";
$lang['preventduplicateemailaddresses'] = "Empêcher adresses courriel en double";
$lang['allownewuserregistrations'] = "Permettre l'enregistrement de nouveaux utilisateurs";
$lang['requireemailconfirmation'] = "Exiger confirmation par courriel";
$lang['usetextcaptcha'] = "Utiliser Captcha de texte";
$lang['textcaptchadir'] = "Répertoire de captcha de texte";
$lang['textcaptchakey'] = "Clé de captcha de texte";
$lang['textcaptchafonterror'] = "Le Captcha de texte a été désactivé automatiquement parce qu'il n'y a pas de polices truetype de disponible pour son usage. SVP téléverser des polices truetype à <b>%s</b> sur votre serveur.";
$lang['textcaptchadirerror'] = "Le Captcha de texte a été désactivé parce que le répertoire text_captcha and ses sous-répertoires ne sont pas inscriptibles part le serveur web / processus PHP.";
$lang['textcaptchagderror'] = "Le Captcha de texte a été désactivé parce que le réglage PHP de votre serveur ne fournit pas de support pour la manipulation d'image GD et / ou de support pour les polices TTF. Les deux sont requis pour supporter le captcha de texte.";
$lang['textcaptchadirblank'] = "Le répertoire de captcha de texte est vierge!";
$lang['newuserpreferences'] = "Préférences du nouveau utilisateur";
$lang['sendemailnotificationonreply'] = "Avertissement par courriel sur réponse à l'utilisateur";
$lang['sendemailnotificationonpm'] = "Avertissement par courriel sur MP à l'utilisateur";
$lang['showpopuponnewpm'] = "Afficher fenêtre contextuelle sur réception de nouveau MP";
$lang['setautomatichighinterestonpost'] = "Établir intérêt élevé automatique sur postage";
$lang['top20postersforperiod'] = "Les 20 posteurs les plus prolifiques pour la période %s à %s";
$lang['postingstats'] = "Statistiques de postage";
$lang['nodata'] = "Aucune donnée";
$lang['totalposts'] = "Contributions totales";
$lang['totalpostsforthisperiod'] = "Contributions totales pour cette période";
$lang['mustchooseastartday'] = "Doit choisir un jour de début";
$lang['mustchooseastartmonth'] = "Doit choisir un mois de début";
$lang['mustchooseastartyear'] = "DOit choisir une année de début";
$lang['mustchooseaendday'] = "Doit choisir un jour de fin";
$lang['mustchooseaendmonth'] = "Doit choisir un mois de fin";
$lang['mustchooseaendyear'] = "Doit choisir une année de fin";
$lang['startperiodisaheadofendperiod'] = "Période de début devance la période de fin";
$lang['bancontrols'] = "Contrôles de bannissement";
$lang['addban'] = "Ajouter bannissement";
$lang['checkban'] = "Vérifier bannissement";
$lang['editban'] = "Modifier bannissement";
$lang['bantype'] = "Type de bannissement";
$lang['bandata'] = "Données de bannissement";
$lang['bancomment'] = "Commentaire";
$lang['ipban'] = "Bannissement par IP";
$lang['logonban'] = "Bannissement par ouverture de session";
$lang['nicknameban'] = "Bannissement par pseudonyme";
$lang['emailban'] = "Bannissement par adresse de courriel";
$lang['refererban'] = "Bannissement par site orienteur";
$lang['invalidbanid'] = "Bannissement d'identité invalide";
$lang['affectsessionwarnadd'] = "Ce bannissment pourrait affecter les sessions d'utilisateurs actives suivantes";
$lang['noaffectsessionwarn'] = "Ce banissement n'affecte aucune session active";
$lang['mustspecifybantype'] = "Vous devez indiquer un type de bannissement";
$lang['mustspecifybandata'] = "Vous devez indiquer des données de bannissement";
$lang['successfullyremovedselectedbans'] = "Lever de bannissements sélectionnés réussi";
$lang['failedtoaddnewban'] = "Ajout de nouveau bannissement échoué";
$lang['failedtoremovebans'] = "Lever de certains ou de tous les bannissment sélectionnés échoué";
$lang['duplicatebandataentered'] = "Données de bannissement entrer en double. Vérifiez vos caractères de remplacement pour voir s'ils s'accordent avec les données entrées";
$lang['successfullyaddedban'] = "Ajout de bannissement réussi";
$lang['successfullyupdatedban'] = "Mise à jour du bannissement réussi";
$lang['noexistingbandata'] = "Il n'y a pas de données de bannissement existantes. Pour ajouter des données de bannissement, veuillez cliquer le bouton ci-dessous.";
$lang['youcanusethepercentwildcard'] = "Vous pouvez utiliser le caractère de remplacement pourcentage (%) dans n'importe quelle liste de bannissement afin d'obtenir des correspondances partielles, ex. '192.168.0.%' bannirait toutes les adresses IP dans la gamme de 192.168.0.1 à travers 192.168.0.254</p>\n ";
$lang['cannotusewildcardonown'] = "Vous ne pouvez pas ajouter % comme concordance de caractère de remplacement seul!";
$lang['requirepostapproval'] = "Exiger approbation du message";
$lang['adminforumtoolsusercounterror'] = "Il doit y avoir au moins un utilisateur avec accès aux outils admin et aux outils de forum sur tous les forums!";
$lang['postcount'] = "Compte de postes";
$lang['resetpostcount'] = "Réinitialisation du compte de postes";
$lang['postapprovalqueue'] = "File d'attente d'approbation de messages";
$lang['nopostsawaitingapproval'] = "Aucun message en attente d'approbation";
$lang['approveselected'] = "Approuver sélectionné(s)";
$lang['successfullyapproveduser'] = "Approbation de l'usager réussi";
$lang['kickselected'] = "Éjecter sélectionné";
$lang['visitorlog'] = "Feuille de contrôle des visiteurs";
$lang['novisitorslogged'] = "Aucun visiteur journalisé";
$lang['addselectedusers'] = "Ajouter usagers sélectionnés";
$lang['removeselectedusers'] = "Enlever usagers sélectionnés";
$lang['addnew'] = "Ajouter nouveau";
$lang['deleteselected'] = "Supprimer sélectionné";
$lang['noprofilesectionsfound'] = "Il n'y a aucune section de profil existante. Pour ajouter une section de profil, cliquez le bouton ci-dessous.";
$lang['addnewprofilesection'] = "Ajouter une nouvelle section au profil";
$lang['successfullyaddedsection'] = "Ajout de la section réussi";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "A changé le statut d'utilisateur pour '%s'";
$lang['changedpasswordforuser'] = "A changé mot de passe pour '%s'";
$lang['changedforumaccess'] = "A changé droits d'accès au forum pour '%s'";
$lang['deletedallusersposts'] = "A supprimé tous les messages pour '%s'";

$lang['createdusergroup'] = "A créé groupe d'utilisateurs '%s'";
$lang['deletedusergroup'] = "A supprimé groupe d'utilisateurs '%s'";
$lang['updatedusergroup'] = "A mise à jour le groupe d'utilisateurs '%s'";
$lang['addedusertogroup'] = "A ajouté l'utilisateur '%s' au groupe '%s'";
$lang['removeduserfromgroup'] = "A enlevé l'utilisateur '%s' du groupe '%s'";

$lang['addedipaddresstobanlist'] = "A ajouté IP '%s' à la liste de bannissement";
$lang['removedipaddressfrombanlist'] = "A enlevé IP '%s' de la liste de bannissement";

$lang['addedlogontobanlist'] = "A ajouté le nom d'utilisateur '%s' à la liste de bannissement";
$lang['removedlogonfrombanlist'] = "A enlevé le nom d'utilisateur '%s' de la liste de bannissement";

$lang['addednicknametobanlist'] = "A ajouté le pseudonyme '%s' à la liste de bannissement";
$lang['removednicknamefrombanlist'] = "A enlevé le pseudonyme '%s' de la liste de bannissement";

$lang['addedemailtobanlist'] = "A ajouté l'adresse courriel '%s' à la liste de bannissement";
$lang['removedemailfrombanlist'] = "A enlevé l'adresse courriel '%s' de la liste de bannissement";

$lang['addedreferertobanlist'] = "Ajouter le site orienteur '%s' à la liste de bannissement";
$lang['removedrefererfrombanlist'] = "Enlevé le site orienteur '%s' de la liste de bannissement";

$lang['editedfolder'] = "A modifié dossier '%s'";
$lang['movedallthreadsfromto'] = "A déplacé tous les fils de discussion de '%s' à '%s'";
$lang['creatednewfolder'] = "A créé nouveau dossier '%s'";
$lang['deletedfolder'] = "A supprimé le dossier '%s'";

$lang['changedprofilesectiontitle'] = "A changé le titre de section de Profil de '%s' à '%s'";
$lang['addednewprofilesection'] = "A ajouté une nouvelle section de Profil '%s'";
$lang['deletedprofilesection'] = "A supprimé une section de Profil '%s'";

$lang['addednewprofileitem'] = "A ajouté un nouveau item de Profil '%s' à la section '%s'";
$lang['changedprofileitem'] = "A changé l'item de Profil '%s'";
$lang['deletedprofileitem'] = "A supprimé l'item de Profil '%s'";

$lang['editedstartpage'] = "A modifié la page de démarrage";
$lang['savednewstyle'] = "A enregistré le nouveau style '%s'";

$lang['movedthread'] = "A déplacé le fil de discussion '%s' de '%s' à '%s'";
$lang['closedthread'] = "A fermé le fil de discussion '%s'";
$lang['openedthread'] = "A ouvert le fil de discussion '%s'";
$lang['renamedthread'] = "A renommé le fil de discussion '%s' de '%s'";

$lang['deletedthread'] = "A supprimé le fil de discussion '%s'";
$lang['undeletedthread'] = "Fils de discussion non-supprimé '%s'";

$lang['lockedthreadtitlefolder'] = "A verrouillé les options de fil de discussion sur '%s'";
$lang['unlockedthreadtitlefolder'] = "A déverrouillé les options de fil de discussion sur '%s'";

$lang['deletedpostsfrominthread'] = "A supprimé les messages de '%s' dans fil de discussion '%s'";
$lang['deletedattachmentfrompost'] = "A supprimé le fichier joint '%s' du message '%s'";

$lang['editedforumlinks'] = "A modifié les liens de forum";
$lang['editedforumlink'] = "Modification du lien de forum: '%s'";

$lang['addedforumlink'] = "Ajout de lien de forum: '%s'";
$lang['deletedforumlink'] = "Suppression de lien de forum: '%s'";
$lang['changedtoplinkcaption'] = "Changement de la légende du lien de premier niveau de '%s' à '%s'";

$lang['deletedpost'] = "A supprimé le message '%s'";
$lang['editedpost'] = "A révisé le message '%s'";

$lang['madethreadsticky'] = "A rendu le fil de discussion '%s' collant";
$lang['madethreadnonsticky'] = "A rendu le fil de discussion '%s' non-collant";

$lang['endedsessionforuser'] = "A terminé la session pour l'utilisateur '%s'";

$lang['approvedpost'] = "A approuvé le message '%s'";

$lang['editedwordfilter'] = "Filtre de mots modifié";

$lang['addedrssfeed'] = "Ajouté source de données RSS '%s'";
$lang['editedrssfeed'] = "Modifié source de données RSS '%s'";
$lang['deletedrssfeed'] = "Supprimé source de données RSS '%s'";

$lang['updatedban'] = "Mise-à-jour du bannissement '%s'. '%s' à '%s', '%s' à '%s'.";

$lang['splitthreadatpostintonewthread'] = "Disperser le fils de discussion '%s' au message %s  en un nouvel fils de discussion '%s'";
$lang['mergedthreadintonewthread'] = "Fils de discussion '%s' et '%s' fusionnés en un nouvel fils de discussion '%s'";

$lang['approveduser'] = "Usager approuvé '%s'";

$lang['adminlogempty'] = "Fiche journalier admin est vide";
$lang['clearlog'] = "Vider fiche journalier";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "Aucun forum existent retrouvé. Pour créer un nouveau forum, cliquez le bouton ci-dessous.";
$lang['webtaginvalidchars'] = "Balise d'adresse web peut contenir des caractères capitales A-Z, 0-9, _ - uniquement";
$lang['databasenameinvalidchars'] = "Le nom de la base de données ne peut inclure les caractères a-z, A-Z, 0-9 et le soulignement";
$lang['invalidforumidorforumnotfound'] = "Identification du forum (FID) invalide ou non trouvée";
$lang['successfullyupdatedforum'] = "Mise à jour du forum: '%s' réussie ";
$lang['failedtoupdateforum'] = " Mise à jour du forum: '%s' échouée";
$lang['successfullycreatedforum'] = "Création de forum réussie";
$lang['failedtocreateforum'] = "La creation du forum '%s' n'est pas réussie. Veuillez vérifier que le l'identification du forum (webtag) et les noms des tables ne sont pas déjà en usage.";
$lang['forumdeleteconfirmation'] = "Êtes-vous certain de vouloir supprimer tous les forums selections?";
$lang['forumdeletewarning'] = "Étes-vous certain de vouloir supprimer le forum sélectionné? Une fois le forum supprimé, le contenu est perdu pour toujours et ne peut pas être récupéré.";
$lang['successfullydeletedforum'] = "Suppression du forum: '%s' réussie";
$lang['failedtodeleteforum'] = "Suppression du forum: '%s' échoué";
$lang['addforum'] = "Ajouter forum";
$lang['editforum'] = "Modifier forum";
$lang['visitforum'] = "Visiter forum: %s";
$lang['accesslevel'] = "Niveau d'accès";
$lang['usedatabase'] = "Utiliser la base de données";
$lang['unknownmessagecount'] = "Inconnu";
$lang['forumwebtag'] = "Identification (webtag) du forum";
$lang['defaultforum'] = "Forum par défaut";
$lang['forumdatabasewarning'] = "Veuillez vous assurer que vous avez choisit la bonne base de données lors de la création d'un nouveau forum. Une fois créé, un nouveau forum ne peut pas être déplacé entre les bases de données disponibles.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "droits d'accès d'utilisateur globaux";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "Vous devez indiquer une identification (webtag) de forum";
$lang['mustsupplyforumname'] = "Vous devez fournir un nom pour le forum";
$lang['mustsupplyforumemail'] = "Vous devez fournir une adresse courriel pour le forum";
$lang['mustchoosedefaultstyle'] = "Vous devez choisir un style de forum de défaut";
$lang['mustchoosedefaultemoticons'] = "Vous devez choisir des binettes de forum de défaut";
$lang['mustsupplyforumaccesslevel'] = "Vous devez indiquer un niveau d'accès au forum";
$lang['mustsupplyforumdatabasename'] = "Vous devez indiquer un nom pour la base de données du forum";
$lang['unknownemoticonsname'] = "Nom de binettes inconnu";
$lang['mustchoosedefaultlang'] = "Vous devez choisir un langage de défaut pour le forum";
$lang['activesessiongreaterthansession'] = "La temporisation de session active ne peut pas excéder la temporisation de session";
$lang['attachmentdirnotwritable'] = "Le répertoire de fichiers joints doit être inscriptible par le serveur web / processus PHP!";
$lang['attachmentdirblank'] = "Vous devez fournir un répertoire pour l'enregistrement de fichiers joints";
$lang['mainsettings'] = "Options principales";
$lang['forumname'] = "Nom du forum";
$lang['forumemail'] = "Courriel du forum";
$lang['forumdesc'] = "Description du Forum";
$lang['forumkeywords'] = "Mots-clé du forum";
$lang['defaultstyle'] = "Style de défaut";
$lang['defaultemoticons'] = "Binettes de défaut";
$lang['defaultlanguage'] = "Language de défaut";
$lang['forumaccesssettings'] = "Options d'accès du forum";
$lang['forumaccessstatus'] = "Statut d'accès au forum";
$lang['changepermissions'] = "Changer droits d'accès";
$lang['changepassword'] = "Changer mot de passe";
$lang['passwordprotected'] = "Protéger par mot de passe";
$lang['passwordprotectwarning'] = "Vous n'avez pas défini un mot de passe pour le forum. Si vous ne définissez pas un mot de passe, la fonctionnalité de protection par mot de passe sera automatiquement désactivée!";
$lang['postoptions'] = "Options de message";
$lang['allowpostoptions'] = "Permettre la révision de message";
$lang['postedittimeout'] = "Temporisation de révision de message";
$lang['posteditgraceperiod'] = "Période de délai de grâce pour modification de poste";
$lang['wikiintegration'] = "Intégration Wiki";
$lang['enablewikiintegration'] = "Activer intégration WikiWiki";
$lang['enablewikiquicklinks'] = "Activer Quick Links WikiWiki";
$lang['wikiintegrationuri'] = "Adresse WikiWiki";
$lang['maximumpostlength'] = "Longueure de message maximale";
$lang['postfrequency'] = "Fréquence de postage";
$lang['enablelinkssection'] = "Activer section des Liens";
$lang['allowcreationofpolls'] = "Permettre création de scrutins";
$lang['allowguestvotesinpolls'] = "Permettre invités de voter dans les scrutins";
$lang['unreadmessagescutoff'] = "Période limite pour messages non-lus";
$lang['unreadcutoffseconds'] = "secondes";
$lang['disableunreadmessages'] = "Désactiver messages non-lus";
$lang['nocutoffdefault'] = "Aucune période limite (défault)";
$lang['1month'] = "1 mois";
$lang['6months'] = "6 mois";
$lang['1year'] = "1 ans";
$lang['customsetbelow'] = "Valeur personnalisée (régler ci-dessous)";
$lang['searchoptions'] = "Options de recherche";
$lang['searchfrequency'] = "Fréquence de recherche";
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
$lang['autopruneuserspmfoldersevery'] = "Élaguer automatiquement les dossiers MP de l'utilisateur chaque";
$lang['userandguestoptions'] = "Options d'usagers et de visiteurs";
$lang['enableguestaccount'] = "Activer compte de visiteur";
$lang['listguestsinvisitorlog'] = "Lister les visiteurs dans la liste des dernières visites";
$lang['allowguestaccess'] = "Permettre l'accès aux visiteurs";
$lang['userandguestaccesssettings'] = "Options d'accès pour usagers et invités";
$lang['allowuserstochangeusername'] = "Permettre aux usagers de changer leur nom d'usager";
$lang['requireuserapproval'] = "Exiger approbation de l'usager par un administrateur";
$lang['enableattachments'] = "Activer fichiers joints";
$lang['attachmentdir'] = "Rep de fichiers joints";
$lang['userattachmentspace'] = "Espace pour fichiers joints par utilisateur";
$lang['allowembeddingofattachments'] = "Permettre l'incorporation de fichiers joints";
$lang['usealtattachmentmethod'] = "Utiliser méthode alternative pour fichiers joints";
$lang['allowgueststoaccessattachments'] = "Permettre aux invités d'avoir accès aux fichiers joints";
$lang['forumsettingsupdated'] = "mise à jour des options de forum réussie";
$lang['forumstatusmessages'] = "Messages de status du forum";
$lang['forumclosedmessage'] = "Message Forum fermé";
$lang['forumrestrictedmessage'] = "Message Forum à accès restreint";
$lang['forumpasswordprotectedmessage'] = "Message Forum protégé par mot de passe";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>Délai d'attente pour modification de message</b> indique le temps en secondes après avoir poster qu'un utilisateur a pour apporter des modifications à son message. Si établit à 0, il n'y a pas de limite.";
$lang['forum_settings_help_11'] = "<b>Longueure maximale du message</b> indique le nombre maximale de caractères qui seront affichés dans un message. Si un message dépasse le nombre de caractères défini ici, il sera tronqué et un hyperlien sera ajouté au pied du message pour permettre aux utilisateurs de le lire au complet sur une page à part.";
$lang['forum_settings_help_12'] = "Si vous ne voulez pas que vos utilisateurs soient capables de créer des scrutins, vous pouvez désactiver cette option ci-haut.";
$lang['forum_settings_help_13'] = "La section Liens de Beehive permet à vos utilisateurs de maintenir une liste de sites Web qu'ils visitent régulièrement et que les autres utilisateurs trouveront peut-être utiles. Les hyperliens peuvent être divisés en catégories par dossier et être commenter et coter. Afin de modérer la section liens, un utilisateur doit avoir le statut de modérateur globale.";
$lang['forum_settings_help_15'] = "<b>Troncage de session</b> indique le temps maximale avant que la session d'un utilisateur est présumée inactive et qu'il a fermé sa session. Par défaut, ceci est 24 heures (86400 secondes).";
$lang['forum_settings_help_16'] = "<b>Troncage de session active</b> indique le temps maximale avant que la session d'utilisateur est présumée inactive et qu'elle entre dans un état de repos. Dans cet état, la session de l'utilisateur demeure ouverte, mais l'utilisateur n'apparaît plus dans la liste d'utilisateurs actifs dans l'affichage des statistiques du forum. Une fois redevenu actif, l'utilisateur sera ré-ajouté à la liste. Par défaut, cette option est établie à 15 minutes (900 secondes).";
$lang['forum_settings_help_17'] = "L'activation de cette option permet à Beehive d'inclure l'affichage des statistiques du forum au pied du sous-fenêtre des messages semblable à ceux utilisés par plusieurs logiciels de forum. Une fois activée, l'affichage des statistiques peut être contrôler par chaque utilisateur. S'ils ne veulent pas le voir, ils peuvent le masquer.";
$lang['forum_settings_help_18'] = "Les Messages Personnels ont une valeur inestimable comme moyen de permettre la discussion de sujets plus personnels hors de la vue des autres utilisateurs. Cependant, si vous ne voulez pas permettre à vos utilisateurs de s'envoyer des MPs, vous pouvez désactiver cette option.";
$lang['forum_settings_help_19'] = "Les Messages Personnels peuvent aussi contenir des fichiers joints, ce qui peut faciliter l'échange de fichiers entre utilisateurs.";
$lang['forum_settings_help_20'] = "<b>Note:</b> L'allocation d'espace pour les fichiers joints de MP provient de l'allocation d'espace pour fichiers joints principale de chaque utilisateur et n'est pas un montant additionel. ";
$lang['forum_settings_help_21'] = "Le compte visiteur permet aux personnes qui visitent votre forum de lires les messages sans avoir à créer un compte.";
$lang['forum_settings_help_22'] = "Si vous préférez, vous pouvez aussi régler votre forum Beehive pour ouvrir automatiquement une session pour vos visiteurs. Une fois qu'un utilisateur crée un compte, l'écran d'ouverture de session lui sera toujours montré tant que les témoins demeureront intactes.";
$lang['forum_settings_help_23'] = "Beehive permet le téléversement de fichiers joints dans les messages postés. Si vous avez un montant d'espace Web limité, il vous serait peut-être préférable de désactiver les fichiers joints en décochant la case d'option ci-haut.";
$lang['forum_settings_help_24'] = "<b>Rep de Fichiers Joints</b> est l'endroit où Beehive devrait enregistrer les fichiers joints. Ce répertoire doit exister sur votre espace Web et doit être inscriptible par le serveur Web / processus PHP sinon les téléversements échoueront.";
$lang['forum_settings_help_25'] = "<b>Espace pour fichiers joints par utilisateur</b> est la taille de l'espace disque maximale mis à la disposition de chaque utilisateur pour les fichiers joints. Une fois complet, l'utilisateur ne peut téléverser d'autres fichiers joints. Par défaut, ils ont chacun 1MB d'espace.";
$lang['forum_settings_help_26'] = "<b>Permettre l'incorporation de fichiers joints dans messages / signatures</b> permet les utilisateurs d'incorporer des fichiers joints dans leurs messages. Quoique utile, une fois activée, cette option peut accroître dramatiquement votre usage de bande passante sous certaines configurations de PHP. Si vous avez un usage de bande passante limité, il est recommendé que vous désactivez cette option.";
$lang['forum_settings_help_27'] = "<b>Utiliser méthode alternative pour fichiers joints</b> Cette option force Beehive à utiliser une méthode alternative pour récupérer les fichiers joints. Si vous recevez des messages d'erreur 404 lorsque vous essayé de télécharger des fichiers joints dans les messages, activer cette option.";
$lang['forum_settings_help_28'] = "Cette option permet le balayage de votre forum par les robots de moteurs de recherche tels que Google, Altavista et Yahoo. Si vous désactiver cette option, votre forum ne sera pas inclut dans les résultats de recherche.";
$lang['forum_settings_help_29'] = "<b>Permettre enregistrement de nouveaux comptes</b> permet ou empêche la céation de nouveaux comptes d'utilisateurs. Si vous le réglé à non, le formulaire d'enregistrement sera complètement désactivé.";
$lang['forum_settings_help_30'] = "<b>Activer intégration WikiWiki</b> fournit un support WikiWord dans les messages sur votre forum. Un mot WikiWord consiste de deux ou plusieurs mots concaténés avec capitales (qu'on appelle aussi CamelCase). Si vous écrivez un mot de cette façon, il sera converti automatiquement en hyperlien pointant à votre Wiki de choix.";
$lang['forum_settings_help_31'] = "<b>Activer hyperliens rapides WikiWiki</b> active l'usage de liens étendues du style msg:1.1 et User:Logon qui créent des hyperliens au message spécifié / profile d'utilisateur de l'utilisateur spécifié.";
$lang['forum_settings_help_32'] = "<b>Localisation WikiWiki</b> est utilisée pour spécifier le URI de votre WikiWiki. Lorsque vous entrer le URI, utilisez [WikiWord] pour indiquer où dans le URI le WikiWord devrait apparaître, i.e.: <i>http://en.wikipedia.org/wiki/[WikiWord]</i> hyperlierait vos WikiWords à %s";
$lang['forum_settings_help_33'] = "<b>Statut d'accès au forum</b> contrôle de quelle façon les utilisateurs peuvent accéder à votre forum.";
$lang['forum_settings_help_34'] = "<b>Ouvert</b> permettra à tous les utilisateurs et visiteurs d'avoir accès à votre forum sans restrictions.";
$lang['forum_settings_help_35'] = "<b>Fermé</b> empêche l'accès à tous les utilisateurs, à l'exception des Admins qui pourront toujours accéder au panneau admin.";
$lang['forum_settings_help_36'] = "<b>Accès limité</b> permet d'établir une liste d'utilisateurs qui ont la permission d'accéder au forum.";
$lang['forum_settings_help_37'] = "<b>Protégé par mot de passe</b> vous permet d'établir un mot de passe que vous pouvez ensuite donner aux utilisateurs pour qu'ils puissent accéder au forum.";
$lang['forum_settings_help_38'] = "Lorsque vous réglez les modes d'Accès limité ou Protégé par mot de passe, vous devez enregistrer vos changements avant de changer les privilèges d'accès des utilisateurs ou le mot de passe.";
$lang['forum_settings_help_39'] = "<b>Fréquence min de recherche</b> définit la durée de temps qu'un utilisateur doit attendre avant d'initialiser une autre recherche. Les recherches exigent beaucoup de la base de données alors il est recommendé que vous établissez cette valeur à aumoins 30 secondes afin d'empêcher le \"pollupostage par recherche\" de tuer le serveur.";
$lang['forum_settings_help_40'] = "<b>Fréquence minimale de postage</b> est le temps minimale qu'un utilisateur doit attendre avant qu'il peut poster de nouveau. Cette option affecte aussi la création de scrutin. Régler à 0 pour désactiver la restriction.";
$lang['forum_settings_help_41'] = "Les options ci-haut modifient les valeurs par défaut pour le formulaire d'enregistrement de compte. En cas pertinent, certains autres options utiliseront les réglages par défaut du forum.";
$lang['forum_settings_help_42'] = "<b>Empêcher l'usage en double d'adresses courriel</b> force Beehive à vérifier les comptes d'utilisateur contre l'adresse courriel avec laquelle un utilisateur enregistre son compte et l'invite à choisir un autre si le premier est déjà en usage.";
$lang['forum_settings_help_43'] = "<b>Exiger confirmation par courriel</b> si activé, envoyera à chaque nouveau utilisateur un courriel contenant un hyperlien qui peut être utilisé pour confirmer leur adresse courriel. Ils ne pourront pas poster tant qu'ils n'auront pas confirmer leur adresse courriel, à moins que leurs privilèges sont changés manuellement par un admin.";
$lang['forum_settings_help_44'] = "<b>Utiliser le Captcha de texte</b> presente le nouveau utilisateur avec une image floue duquel il doit copier un numéro dans le champ de texte dans le formulaire d'enregistrement. Utiliser cette option afin d'empécher les enregistrements via scripts.";
$lang['forum_settings_help_45'] = "<b>Répertoire de Captcha de texte</b> spécifie l'endroit où Beehive conservera ses images et polices captcha. Ce répertoire doit être inscriptible par le serveur web / processus PHP et doit être accessible via HTTP. Après que vous avez activé le captcha de texte, vous devez téléverser les polices truetype au sous-répertoire de votre répertoire principale de captcha de texte sinon Beehive sautera le captcha de texte durant l'enregistrement d'utilisateur.";
$lang['forum_settings_help_46'] = "<b>Clé de Captcha de texte</b> vous permet de changer la clé utilisée par Beehive pour générer le code captcha de texte qui apparait dans l'image. Le plus unique la clé, le plus difficile que ça devient pour les processus automatisés de \"deviner\" le code.";
$lang['forum_settings_help_47'] = "<b>Période de délai de grâce pour modification de poste</b> vous permet de définir une période en minutes durant laquelle les utilisateurs peuvent modifier leurs messages sans que le texte 'MODIFIÉ PAR' apparait dans le message. Si régler à 0 le texte 'MODIFIÉ PAR' va toujours paraître.";
$lang['forum_settings_help_48'] = "<b>Période limite pour messages non-lus</b> spécifie pour quelle durée de temps les messages non-lus seront conservés. Vous pouvez choisir entre des valeurs pré-établies ou choisir votre propre période limite en secondes. Les fils de discussion modifiés antérieurement à la période limite définie apparaîtront automatiquement comme lues.";
$lang['forum_settings_help_49'] = "La sélection de <b>Désactiver messages non-lus</b> enlèvera complètement tout support pour messages non-lus et enlèvera aussi les options reliées du menu déroulant vertical de types de discussions sur la liste des fils de discussions.";
$lang['forum_settings_help_50'] = "Vous pouvez exiger l'approbation de tout nouveau compte d'usager avant qu'il soit utilisé en activant cette fonction. Sans approbation, un usager ne peut accéder à aucune section de l'installation du forum Beehive, y inclut les forums individuels, la boîte de réception MP et sections Mes Forums.";
$lang['forum_settings_help_51'] = "Utilisez <b>Message de fermeture</b>, <b>Message d'accès restreint</b> et <b>Message de protégé par mot de passe</b> pour personnaliser le message affiché lorsque les usagers accèdent au forum dans ses états variés.";
$lang['forum_settings_help_52'] = "Vous pouvez utiliser le HTML dans vos messages et les hyperliens et les adresses courriel seront automatiquement convertis en hyperliens. Pour utiliser les messages de forum Beehive par défaut vider les champs de données.";
$lang['forum_settings_help_53'] = "<b>Permettre aux usagers de changer leur nom d'usager</b> permet aux usagers déjà enregistrés de changer leur nom d'usager. Lorsque active, vous pouvez suivre les changements effectués par un usager à son nom d'usager par moyen des outils administratifs.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "Identification de fichier joint non indiquée.";
$lang['upload'] = "Téléverser";
$lang['uploadnewattachment'] = "Téléverser nouveau fichier joint";
$lang['waitdotdot'] = "patienter..";
$lang['successfullyuploaded'] = "Téléversement réussi";
$lang['failedtoupload'] = "Téléversement échoué";
$lang['complete'] = "Compléter";
$lang['uploadattachment'] = "Téléverser un fichier pour joindre au message";
$lang['enterfilenamestoupload'] = "Entrer nom(s) de fichier(s) à téléverser";
$lang['attachmentsforthismessage'] = "Fichiers joints pour ce message";
$lang['otherattachmentsincludingpm'] = "Autres fichiers joints (y inclut messages MP et autres forums)";
$lang['totalsize'] = "Taille totale";
$lang['freespace'] = "Espace libre";
$lang['attachmentproblem'] = "Il y a eu un problème avec le téléchargement de ce fichier joint. Veuillez essayer de nouveau plus tard.";
$lang['attachmentshavebeendisabled'] = "Les fichiers joints ont été désactivés par le propriétaire du forum.";
$lang['canonlyuploadmaximum'] = "Vous pouvez téléverser un maximum de 10 fichiers à la fois";
$lang['deleteattachments'] = "Supprimez fichiers joints";
$lang['deleteattachmentsconfirm'] = "Êtes vous certain de vouloir supprimer les fichiers joints sélectionnés?";
$lang['deletethumbnailsconfirm'] = "Êtes-vous certain de vouloir supprimer les vignettes de pieces jointes sélectionnées?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "Mot de passe changé";
$lang['passedchangedexp'] = "Votre mot de passe a été changé.";
$lang['updatefailed'] = "Mise à jour non-réussie";
$lang['passwdsdonotmatch'] = "Les mots de passe ne correspondent pas.";
$lang['allfieldsrequired'] = "Tous les champs sont requis.";
$lang['requiredinformationnotfound'] = "Information requise non trouvée";
$lang['forgotpasswd'] = "Oublier mot de passe";
$lang['enternewpasswdforuser'] = "Entrer un nouveau mot de passe pour l'utilisateur %s";
$lang['resetpassword'] = "Réinitialiser le mot de passe";
$lang['resetpasswordto'] = "Reinitialiser le mot de passe à";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "Aucun message indiqué pour suppression";
$lang['deletemessage'] = "Supprimer Message";
$lang['postdelsuccessfully'] = "Suppression de message réussie";
$lang['errordelpost'] = "Erreur rencontrée en supprimant le message";
$lang['cannotdeletepostsinthisfolder'] = "Vous ne pouvez pas supprimer vos messages dans ce dossier";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "Aucun message d'indiqué pour révision";
$lang['cannoteditpollsinlightmode'] = "Impossible de modifier les scrutins en mode léger";
$lang['editedbyuser'] = "EDITED: %s by %s";
$lang['editappliedtomessage'] = "Révision appliquée au message";
$lang['errorupdatingpost'] = "Erreur rencontrée durant la mise à jour du message";
$lang['editmessage'] = "Réviser le message %s";
$lang['editpollwarning'] = "<b>Note</b>: La révision de certains aspects d'un scrutin annulera tous les votes déjà enregistrés et permettra aux utilisateurs de voter de nouveau.";
$lang['hardedit'] = "Options de révision forte (votes seront réinitialisés):";
$lang['softedit'] = "Options de révision faible (votes seronts retenus):";
$lang['changewhenpollcloses'] = "Changer quand le scrutin termine?";
$lang['nochange'] = "Aucun changement";
$lang['emailresult'] = "Envoyer le résultat par courriel";
$lang['msgsent'] = "Message envoyé";
$lang['msgsentsuccessfully'] = "Envoi du message réussi.";
$lang['mailsystemfailure'] = "Défaillance du système courriel. Le message n'a pas été envoyé.";
$lang['nopermissiontoedit'] = "Vous n'avez pas la permission de réviser ce message.";
$lang['cannoteditpostsinthisfolder'] = "Vous ne pouvez pas réviser les messages dans ce dossier";
$lang['messagewasnotfound'] = "Message %s n'a pas été retrouvé";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "Aucun utilisateur indiqué pour envoi de courriel.";
$lang['entersubjectformessage'] = "Indiquer un sujet pour le message";
$lang['entercontentformessage'] = "Indiquer du contenu pour le message";
$lang['msgsentfromby'] = "Ce message a été envoyé de %s par %s";
$lang['subject'] = "Sujet";
$lang['send'] = "Envoyer";
$lang['hasoptedoutofemail'] = "refuse d'être contacté par courriel";
$lang['hasinvalidemailaddress'] = "a une adresse courriel invalide";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "Confirmation de message de %s";
$lang['msgnotificationemail'] = "Salut %s.\n\n%s a posté un message à votre attention sur %s\n\nLe sujet est: %s\n\nPour lire ce message et les autres dans le même fil de discussion, allez à:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: Si vous désirez ne plus recevoir de confirmations de message par courriel du forum messages postés à votre attention, allez à: %s cliquer sur Mes Contrôles, ensuite Courriel et Confidentialité, déselectionner le courriel Case à cocher Confirmation et appuyer Soumettre.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "Confirmation d'abonnement de %s";
$lang['subnotification'] = "Salut %s.\n\n%s a posté un message dans un fil de discussion auquel vous vous êtes abonné sur %s\n\nLe sujet est: %s\n\nPour lire ce message et les autres dans le même fil de discussion, allez à:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: Si vous désirez ne plus recevoir de confirmations de message par courriel de nouveau messages dans ce fil de discussion, allez à: %s et ajuster votre Niveau d'intérêt au bas de la page.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "Confirmation de MP de %s";
$lang['pmnotification']  = "Salut %s.\n\n%s vous a posté un MP sur %s\n\nLe sujet est: %s\n\nPour lire ce message, allez à:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: Si vous désirez ne plus recevoir de confirmations par courriel de nouveau MP messages postés à votre attention, allez à: %s cliquer sur Mes Contrôles, ensuite Courriel et Confidentialité, déselectionner le MP Case à cocher Confirmation et appuyer Soumettre.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "Confirmation de changement de mot de passe de %s";
$lang['pwchangeemail'] = "Salut %s.\n\nCeci est un courriel de confirmation pour vous informer que votre mot de passe sur %s a été changé.\n\nVotre nouveau mot de passe est: %s Il a été changé par: %sSi vous avez reçu ce courriel par erreur ou n'étiez pas en attente de un changement à votre mot de passe, veuillez contacter le propriétaire du forum ou un modérateur sur %s dans les plus brefs délais pour corriger la situation.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "Confirmation par courriel requis";
$lang['confirmemail'] = "Salut %s.\n\nVous avez récemment créé un nouveau compte d'utilisateur sur %s\nAvant que vous puissiez commencer à poster, nous devons confirmer votre adresse courriel. Ne vous inquiètez pas, ceci est très facile. Vous n'avez qu'à cliquer le lien ci-dessous (ou le copier et coller dans votre navigateur web):\n\n%s\n\nUne fois la confirmation faite, vous pourriez immédiatement ouvrir une session et commencer à poster.\n\nSi vous n'avez pas créer un compte d'utilisateur sur %s veuillez accepter nos excuses et tranférer ce courriel à %s pour nous permettre d'enquêter sur la source.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "Salut %s.\n\nVous avez demandé ce courriel de %s parce que vous avez oublié votre mot de passe.\n\nCliquer le lien ci-dessous (ou le copier et coller dans votre navigateur web) pour réinitialiser votre mot de passe:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "Votre demande de réinitialisation de mot de passe";
$lang['passwdresetemailsent'] = "Courriel de réinitialisation de mot de passe envoyé";
$lang['passwdresetexp'] = "Un courriel avec les instructions pour réinitialiser votre mot de passe vous parviendra sous peu.";
$lang['validusernamerequired'] = "Un nom d'utilisateur valide est requis";
$lang['forgottenpasswd'] = "Vous avez oublié votre mot de passe?";
$lang['forgotpasswdexp'] = "Si vous avez oublié votre mot de passe, vous pouvez demander qu'il soit réinitialisé en entrant votre nom d'utilisateur ci-dessous. Un courriel avec les instructions de réinitisalisation de mot de passe vous sera acheminé à l'adresse courriel enregistrée.";
$lang['couldnotsendpasswordreminder'] = "Incapable d'envoyer rappel de mot de passe. Veuillez contacter le propriétaire du forum.";
$lang['request'] = "Demander";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "Confirmation d'adresse de courriel";
$lang['emailconfirmationcomplete'] = "Merci d'avoir confirmé votre adresse courriel. Vous pouvez maintenant ouvrir une session et commencer à poster.";
$lang['emailconfirmationfailed'] = "Échec de la confirmation d'adresse de courriel, veuillez essayer de nouveau plus tard. Si vous rencontré cette erreur plusieurs fois, veuillez contacter le propriétaire du forum ou un modérateur pour aide.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "Niveau supérieur";
$lang['maynotaccessthissection'] = "Vous ne pouvez pas accéder à cette section.";
$lang['toplevel'] = "Niveau supérieur";
$lang['links'] = "Liens";
$lang['viewmode'] = "Mode de vue";
$lang['hierarchical'] = "Hiérarchique";
$lang['list'] = "Liste";
$lang['folderhidden'] = "Ce dossier est caché";
$lang['hide'] = "Cacher";
$lang['unhide'] = "Montrer";
$lang['nosubfolders'] = "Aucun sous-dossier dans cette catégorie";
$lang['1subfolder'] = "1 sous-dossier dans cette catégorie";
$lang['subfoldersinthiscategory'] = "sous-dossiers dans cette catégorie";
$lang['linksdelexp'] = "Les entrées dans un dossier supprimé seront déplacées vers le dossier parent. Seulement les dossiers qui n'ont pas de sous-dossiers peuvent être supprimés.";
$lang['listview'] = "Vue de liste";
$lang['listviewcannotaddfolders'] = "Impossible d'ajouter dossiers dans cette vue. Montrant 20 entrées à la fois.";
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
$lang['commentadded'] = "Votre commentaire a été ajouté.";
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
$lang['modtools'] = "Outils de modération";
$lang['editname'] = "Modifier le nom";
$lang['editaddress'] = "Modifier l'adresse";
$lang['editdescription'] = "Modifier la description";
$lang['moveto'] = "Déplacer vers";
$lang['linkdetails'] = "Détails du lien";
$lang['addcomment'] = "Ajouter un commentaire";
$lang['voterecorded'] = "Votre vote a été enregistré";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "Ouverture de session réussie.";
$lang['presscontinuetoresend'] = "Appuyer Continuer pour renvoyer les données du formulaire ou annuler pour renvoyer la page.";
$lang['usernameorpasswdnotvalid'] = "Le nom d'utilisateur ou le mot de passe que vous avez entré n'est pas valide.";
$lang['pleasereenterpasswd'] = "SVP ré-introduire votre mot de passe de essayer de nouveau.";
$lang['rememberpasswds'] = "Se souvenir des mots de passe";
$lang['rememberpassword'] = "Se souvenir du mot de passe";
$lang['enterasa'] = "Entrer comme un %s";
$lang['donthaveanaccount'] = "Vous n'avez pas de compte? %s";
$lang['registernow'] = "Enregistrez-vous maintenant";
$lang['problemsloggingon'] = "Vous avez des problèmes d'ouverture de session?";
$lang['deletecookies'] = "Supprimer les témoins";
$lang['cookiessuccessfullydeleted'] = "Suppression des témoins réussie";
$lang['forgottenpasswd'] = "Vous avez oublié votre mot de passe?";
$lang['usingaPDA'] = "Vous utilisez un assistant personnel numérique (PDA)?";
$lang['lightHTMLversion'] = "Version HTML légèr";
$lang['youhaveloggedout'] = "Vous avez fermé votre session.";
$lang['currentlyloggedinas'] = "Vous êtes en session actuelle sous le nom d'utilisateur %s";
$lang['logonbutton'] = "Ouvrir session";
$lang['otherbutton'] = "Autre";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "Mes Forums";
$lang['availableforums'] = "Forums disponibles";
$lang['favouriteforums'] = "Forums favoris";
$lang['lastvisited'] = "Dernière visite";
$lang['forumunreadmessages'] = "%s Unread Messages";
$lang['forummessages'] = "%s Messages";
$lang['forumunreadtome'] = "%s Unread &quot;To: Me&quot;";
$lang['forumnounreadmessages'] = "No Unread Messages";
$lang['removefromfavourites'] = "Supprimer de mes favoris";
$lang['addtofavourites'] = "Ajouter à mes favoris";
$lang['availableforums'] = "Forums disponibles";
$lang['noforumsavailablelogin'] = "Aucun forum de disponible. SVP ouvrir une session pour voir vos forums.";
$lang['passwdprotectedforum'] = "Forum protégé par mot de passe";
$lang['passwdprotectedwarning'] = "Ce forum est protégé par mot de passe. Pour y accéder, entrer le mot de passe ci-dessous.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "Poster message";
$lang['selectfolder'] = "Sélectionner le dossier";
$lang['mustenterpostcontent'] = "Votre message doit avoir du contenu!";
$lang['messagepreview'] = "Aperçu du message";
$lang['invalidusername'] = "Nom d'utilisateur invalide!";
$lang['mustenterthreadtitle'] = "Vous devez inclure un titre pour le fil de discussion!";
$lang['pleaseselectfolder'] = "SVP sélectionner un dossier!";
$lang['errorcreatingpost'] = "Erreur en créant le message! SVP essayer de nouveau dans quelques minutes.";
$lang['createnewthread'] = "Créer un nouveau fil de discussion";
$lang['postreply'] = "Afficher la réponse";
$lang['threadtitle'] = "Titre du fil de discussion";
$lang['messagehasbeendeleted'] = "Message a été supprimé.";
$lang['messagenotfoundinselectedfolder'] = "Message not found in selected folder. Check that it hasn't been moved or deleted.";
$lang['cannotpostthisthreadtypeinfolder'] = "Vous ne pouvez pas poster ce type de fil de discussion dans ce dossier!";
$lang['cannotpostthisthreadtype'] = "Vous ne pouvez pas poster ce type de fil de discussion car il n'y a aucun dossier de disponible qui le permet.";
$lang['cannotcreatenewthreads'] = "Vous ne pouvez pas créer des nouveaux fils de discussion.";
$lang['threadisclosedforposting'] = "Ce fil de discussion est fermé aux contributions. Vous ne pouvez pas y poster un message!";
$lang['moderatorthreadclosed'] = "Mise en garde: ce fil de discussion est fermé pour contributions aux utilisateurs réguliers.";
$lang['threadclosed'] = "Fil de discussion fermé aux contributions";
$lang['usersinthread'] = "Utilisateurs dans le fil de discussion";
$lang['correctedcode'] = "Code corrigé";
$lang['submittedcode'] = "Code soumis";
$lang['htmlinmessage'] = "HTML dans le message";
$lang['disableemoticonsinmessage'] = "Désactiver les binettes dans le message";
$lang['automaticallyparseurls'] = "Transformer automatiquement les adresses URLs en liens hypertexte";
$lang['automaticallycheckspelling'] = "Vérifier automatiquement l'orthographe";
$lang['setthreadtohighinterest'] = "Établir le niveau d'intérêt du fil de discussion à élevé";
$lang['enabledwithautolinebreaks'] = "Activé avec coupures de lignes automatiques";
$lang['fixhtmlexplanation'] = "Ce forum utilise le filtrage d'HTML. Le code HTML que vous avez soumis a été modifié par les filtres de façon quelconque.\\n\\nPour voir votre code original, sélectionner la case d'option \\'Code sousmis\\'.\\nPour voir le code modifié, sélectionner la case d'option \\'Code corrigé\\'.";
$lang['messageoptions'] = "Options de message";
$lang['notallowedembedattachmentpost'] = "Vous n'avez pas la permission d'incorporer des fichiers joints dans vos messages.";
$lang['notallowedembedattachmentsignature'] = "Vous n'avez pas la permission d'incorporer des fichiers joints dans votre signature.";
$lang['reducemessagelength'] = "La longueure du message doit être moins de 65,535 charactères (actuellement: ";
$lang['reducesiglength'] = "La longueure de la signature doit être moins de 65,535 charactères (actuellement: ";
$lang['cannotcreatethreadinfolder'] = "Vous ne pouvez pas créer de nouveaux fils de discussion dans ce dossier";
$lang['cannotcreatepostinfolder'] = "Vous ne pouvez pas répondre aux messages dans ce dossier";
$lang['cannotattachfilesinfolder'] = "Vous ne pouvez pas poster des fichiers joints dans ce dossier. Enlever les fichiers joints pour continuer.";
$lang['postfrequencytoogreat'] = "Vous pouvez poster seulement une fois tous les %s secondes. SVP ré-essayer plus tard.";
$lang['emailconfirmationrequiredbeforepost'] = "Confirmation d'adresse courriel requise avant que vous pouvez poster!";
$lang['emailconfirmationfailedtosend'] = "L'envoi du courriel de confirmation a échoué. SVP contacter le propriétaire du forum pour corriger cette situation.";
$lang['emailconfirmationsent'] = "Confirmation email has been resent.";
$lang['resendconfirmation'] = "Renvoyer confirmation";
$lang['userapprovalrequiredbeforeaccess'] = "Votre compte d'usager doit être approuvé par un administrateur du forum avant que vous pouvez accéder au forum demandé.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "en réponse à";
$lang['showmessages'] = "Montrer les messages";
$lang['ratemyinterest'] = "Coter mon intérêt";
$lang['adjtextsize'] = "Changer la taille des textes";
$lang['smaller'] = "Plus petit";
$lang['larger'] = "Plus grand";
$lang['faq'] = "FAQ";
$lang['docs'] = "Docs";
$lang['support'] = "Support";
$lang['donateexcmark'] = "Contribuez!";
$lang['threadcouldnotbefound'] = "Le fil de discussion demandé n'a pas pu être trouvé ou l'accès a été refusé.";
$lang['mustselectpolloption'] = "Vous devez voter pour une option!";
$lang['mustvoteforallgroups'] = "Vous devez voter dans chaque groupe.";
$lang['keepreading'] = "Continuer lecture";
$lang['backtothreadlist'] = "Retournez à la liste de fils de discussion";
$lang['postdoesnotexist'] = "Ce message n'existe pas dans ce fil de discussion!";
$lang['clicktochangevote'] = "Cliquez pour changer votre vote";
$lang['youvotedforoption'] = "Vous avez voté pour l'option";
$lang['youvotedforoptions'] = "Vous avez voté pour les options";
$lang['clicktovote'] = "Cliquez pour voter";
$lang['youhavenotvoted'] = "Vous n'avez pas voté";
$lang['viewresults'] = "Voir les résultats";
$lang['msgtruncated'] = "Message tronqué";
$lang['viewfullmsg'] = "Voir message complet";
$lang['ignoredmsg'] = "Message ignoré";
$lang['wormeduser'] = "Utilisateur parasité";
$lang['ignoredsig'] = "Signature ignorée";
$lang['messagewasdeleted'] = "Message %s.%s a été supprimé";
$lang['stopignoringthisuser'] = "Cesser d'ignorer cet utilisateur";
$lang['renamethread'] = "Renommer le fil de discussion";
$lang['movethread'] = "Déplacer le fil de discussion";
$lang['editthepoll'] = "Modifer le scrutin";
$lang['torenamethisthread'] = "pour renommer ce fil de discussion";
$lang['closeforposting'] = "Fermer aux contributions";
$lang['until'] = "Jusqu'à 00:00 UTC";
$lang['approvalrequired'] = "Approbation requise";
$lang['messageawaitingapprovalbymoderator'] = "Message %s.%s en attente d'approbation par un modérateur";
$lang['postapprovedsuccessfully'] = "Approbation de message réussie";
$lang['postapprovalfailed'] = "L'approbation du message a échoué.";
$lang['postdoesnotrequireapproval'] = "Approbation du message non requis";
$lang['approvepost'] = "Approuver message pour affichage";
$lang['approvedbyuser'] = "APPROVED: %s by %s";
$lang['makesticky'] = "Rendre collant";
$lang['messagecountdisplay'] = "%s de %s";
$lang['linktothread'] = "Lien permanent à ce fil de discussion";
$lang['linktopost'] = "Hyperlier au message";
$lang['linktothispost'] = "Hyperlier à ce message";
$lang['imageresized'] = "Cet image a été redimensionné (taille originale %1\$sx%2\$s). Pour voir l'image à l'échelle, cliquez ici.";
$lang['messagedeletedbyuser'] = "Message %s.%s deleted %s by %s";
$lang['messagedeleted'] = "Message %s.%s was deleted";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "Impossible d'afficher modérateurs de dossier";
$lang['moderatorlist'] = "Liste de modérateurs:";
$lang['modsforfolder'] = "Modérateurs de dossier";
$lang['nomodsfound'] = "Aucun modérateur retrouvé";
$lang['forumleaders'] = "Leaders du forum:";
$lang['foldermods'] = "Modérateurs de dossier:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "Début";
$lang['messages'] = "Messages";
$lang['pminbox'] = "Boîte de réception MP";
$lang['startwiththreadlist'] = "Page d'accueil avec liste de fils de discussion";
$lang['pmsentitems'] = "Items envoyés";
$lang['pmoutbox'] = "Boîte d'envoi";
$lang['pmsaveditems'] = "Items sauvegardés";
$lang['pmdrafts'] = "Drafts";
$lang['links'] = "Liens";
$lang['admin'] = "Admin";
$lang['login'] = "Ouvrir session";
$lang['logout'] = "Fermer session";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "Messages privés";
$lang['recipienttiptext'] = "Séparer les destinataires par un point-virgule ou une virgule";
$lang['maximumtenrecipientspermessage'] = "Il y a une limite de 10 destinataires par message. SVP modifier votre liste de destinataires.";
$lang['mustspecifyrecipient'] = "Vous devez spécifier aumoins un destinataire.";
$lang['usernotfound'] = "User %s not found";
$lang['sendnewpm'] = "Envoyer nouveau MP";
$lang['savemessage'] = "Enregistrer message";
$lang['timesent'] = "Heure d'envoi";
$lang['nomessages'] = "Aucun message";
$lang['errorcreatingpm'] = "Erreur en créant MP! SVP essayer de nouveau dans quelques minutes";
$lang['writepm'] = "Rédiger message";
$lang['editpm'] = "Réviser message";
$lang['cannoteditpm'] = "Impossible de réviser ce MP. Soit qu'il a déjà été lu par le destinataire ou que le message n'existe pas ou qu'il ne vous est pas accessible.";
$lang['cannotviewpm'] = "Cannot view PM. Message does not exist or it is inaccessible by you";
$lang['pmmessagenumber'] = "Message %s";

$lang['youhavexnewpm'] = "Vous avez %d un nouveau MP. Désirez-vous ouvrir votre boite de réception maintenant?";
$lang['youhave1newpm'] = "Vous avez 1 un nouveau MP. Désirez-vous ouvrir votre boite de réception maintenant?";
$lang['youhave1newpmand1waiting'] = "You have 1 new message.\\n\\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhave1pmwaiting'] = "You have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhavexnewpmand1waiting'] = "You have %d new messages.\\n\\nYou also have 1 message awaiting delivery. To receive this message please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhavexnewpmandxwaiting'] = "You have %d new messages.\\n\\nYou also have %d messages awaiting delivery. To receive these message please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhave1newpmandxwaiting'] = "You have 1 new message.\\n\\nYou also have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";
$lang['youhavexpmwaiting'] = "You have %d messages awaiting delivery. To receive these messages please clear some space in your Inbox.\\n\\nWould you like to go to your Inbox now?";

$lang['youdonothaveenoughfreespace'] = "Vous n'avez pas assez d'espace libre pour envoyer ce message.";
$lang['userhasoptedoutofpm'] = "%s a choisi de ne pas recevoir les messages personnels";
$lang['pmfolderpruningisenabled'] = "L'élagation du dossier MP est activée!";
$lang['pmpruneexplanation'] = "Ce forum utilise l'élagation du dossier PM. Les messages que vous avez de conservé dans vos \\ndossiers de boîte de réception et de boîte d'envoi sont assujettis à la suppression automatique. Veuillez transférer à \\nvotre dossier \\'Items sauvegardés\\' tout message que vous désirez conserver afin qu'ils ne soient pas supprimés.";
$lang['yourpmfoldersare'] = "Vos dossiers MP sont %s pleins";
$lang['currentmessage'] = "Message actuel";
$lang['unreadmessage'] = "Message non-lu";
$lang['readmessage'] = "Lire message";
$lang['pmshavebeendisabled'] = "Les messages personnels ont été désactivés par le propriétaire du forum.";
$lang['adduserstofriendslist'] = "Si vous ajoutez des utilisateurs à votre liste d'ami(e)s, ils apparaîtront dans la liste déroulante verticalement de la page Rédiger Message PM.";

$lang['messagesaved'] = "Message Saved";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "Message was successfully saved to 'Drafts' folder";
$lang['couldnotsavemessage'] = "Could not save message. Make sure you have enough available free space.";
$lang['pmtooltipxmessages'] = "%s messages";
$lang['pmtooltip1message'] = "1 message";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "Mes Contrôles";
$lang['myforums'] = "Mes Forums";
$lang['menu'] = "Menu";
$lang['userexp_1'] = "Utiliser le menu à gauche pour gérer vos options.";
$lang['userexp_2'] = "<b>Détails d'utilisateur</b> vous permet de changer votre nom, adresse courriel, et mot de passe.";
$lang['userexp_3'] = "<b>Profile d'utilisateur</b> vous permet de modifier votre profile d'utilisateur.";
$lang['userexp_4'] = "<b>Changer mot de passe</b> vous permet de changer votre mot de passe";
$lang['userexp_5'] = "<b>Courriel &amp; confidentialité</b> vous permet de changer la façon dont vous pouvez être contacté sur le forum et en dehors du forum.";
$lang['userexp_6'] = "<b>Options du Forum</b> vous permet de changer l'allure et le fonctionnement du forum.";
$lang['userexp_7'] = "<b>Fichiers joints</b> vous permet de modifier/supprimer vos fichiers joints.";
$lang['userexp_8'] = "<b>Modifer Signature</b> vous permet de modifier votre signature.";
$lang['userexp_9'] = "<b>Relationships</b> lets you manage your relationship with other users on the forum.";
$lang['userexp_9'] = "<b>Relationships</b> lets you manage your relationship with other users on the forum.";
$lang['userexp_10'] = "<b>Thread Subscriptions</b> allows you to manage your thread subscriptions.";
$lang['userdetails'] = "Détails d'utilisateur";
$lang['userprofile'] = "Profile d'utilisateur";
$lang['emailandprivacy'] = "Courriel &amp; Confidentialité";
$lang['editsignature'] = "Modifier Signature";
$lang['norelationships'] = "Aucune relation d'utilisateur d'établie";
$lang['editwordfilter'] = "Modifier le filtre de mots";
$lang['userinformation'] = "Information d'utilisateur";
$lang['changepassword'] = "Changer mot de passe";
$lang['currentpasswd'] = "Mot de passe actuel";
$lang['newpasswd'] = "Nouveau mot de passe";
$lang['confirmpasswd'] = "Confirmer mot de passe";
$lang['passwdsdonotmatch'] = "Les mots de passe ne correspondent pas.";
$lang['nicknamerequired'] = "Pseudonyme requis!";
$lang['emailaddressrequired'] = "Adresse courriel requis!";
$lang['logonnotpermitted'] = "Nom d'utilisateur non-autorisé. Choisissez un autre!";
$lang['nicknamenotpermitted'] = "Pseudonyme non-autorisé. Choisissez un autre!";
$lang['emailaddressnotpermitted'] = "Adresse courriel non-autorisée. Choisissez une autre!";
$lang['emailaddressalreadyinuse'] = "Adresse courriel déjà en usage. Choisissez une autre!";
$lang['relationshipsupdated'] = "Relations mises à jour!";
$lang['relationshipupdatefailed'] = "Échec de la mise à jour des relations!";
$lang['preferencesupdated'] = "Mise à jour des préférences réussie.";
$lang['userdetails'] = "Détails d'utilisateur";
$lang['memberno'] = "No. de membre";
$lang['firstname'] = "Prénom";
$lang['lastname'] = "Nom de famille";
$lang['dateofbirth'] = "Date de naissance";
$lang['homepageURL'] = "Adresse URL de votre page d'accueil";
$lang['pictureURL'] = "Adresse URL de l'image";
$lang['forumoptions'] = "Options de forum";
$lang['notifybyemail'] = "M'aviser par courriel de messages à moi";
$lang['notifyofnewpm'] = "M'aviser par fenêtre contextuelle de nouveaux messages MP";
$lang['notifyofnewpmemail'] = "M'aviser par courriel de nouveaux messages MP";
$lang['daylightsaving'] = "Ajuster pour l'heure avancée";
$lang['autohighinterest'] = "Marquer automatiquement les fils de discussion dans lesquels je poste comme étant d'intérêt élevé";
$lang['convertimagestolinks'] = "Convertir automatiquement en hyperliens les images incorporées dans les messages";
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
$lang['startpage'] = "Page de démarrage";
$lang['preferredlang'] = "Langage préféré";
$lang['donotshowmyageordobtoothers'] = "Masquer mon âge et ma date de naissance";
$lang['showonlymyagetoothers'] = "Montrer uniquement mon âge aux autres utilisateurs";
$lang['showmyageanddobtoothers'] = "Montrer mon âge et ma date de naissance aux autres utilisateurs";
$lang['showonlymydayandmonthofbirthytoothers'] = "Show only my day and month of birth to others";
$lang['listmeontheactiveusersdisplay'] = "M'inclure dans la liste des utilisateurs actifs";
$lang['browseanonymously'] = "Naviguer le forum anonymement";
$lang['allowfriendstoseemeasonline'] = "Naviguer anonymement, mais permettre mes ami(e)s de voir que je suis connecté";
$lang['revealspoileronmouseover'] = "Révèlez les gâcheurs sur survol";
$lang['resizeimagesandreflowpage'] = "Redimensionner les images et remarginer la page afin de prévenir le défilement horizontal.";
$lang['showforumstats'] = "Montrer les statistiques du forum au pied du panneau de message";
$lang['usewordfilter'] = "Activer le filtre des mots.";
$lang['forceadminwordfilter'] = "Forcer l'usage du filtre des mots de l'admin sur tous les utilisateurs (y inclut les visiteurs)";
$lang['timezone'] = "Fuseau horaire";
$lang['language'] = "Langage";
$lang['emailsettings'] = "Options de courriel et de contacte";
$lang['forumanonymity'] = "Options d'anonymité sur le forum";
$lang['birthdayanddateofbirth'] = "Affichage d'anniversaire et date de naissance";
$lang['includeadminfilter'] = "Inclure filtre des mots de l'admin dans ma liste.";
$lang['setforallforums'] = "Établir pour tous les forums?";
$lang['containsinvalidchars'] = "Contient des caractères invalides!";
$lang['postpage'] = "Page de postage";
$lang['nohtmltoolbar'] = "Pas de barre d'outils HTML";
$lang['displaysimpletoolbar'] = "Afficher la barre d'outils HTML simple";
$lang['displaytinymcetoolbar'] = "Afficher la barre d'outils HTML tel-tel";
$lang['displayemoticonspanel'] = "Afficher panneau de binettes";
$lang['displaysignature'] = "Afficher signature";
$lang['disableemoticonsinpostsbydefault'] = "Désactiver les binettes dans les messages par défaut";
$lang['automaticallyparseurlsbydefault'] = "Transformer automatiquement les adresses URLs en liens hypertexte dans les messages par défaut";
$lang['postinplaintextbydefault'] = "Poster en texte en clair par défaut";
$lang['postinhtmlwithautolinebreaksbydefault'] = "Poster en HTML avec coupures de lignes automatiques par défaut";
$lang['postinhtmlbydefault'] = "Poster en HTML par défaut";
$lang['privatemessageoptions'] = "Options de message privé";
$lang['privatemessageexportoptions'] = "Options d'exportation de message privé";
$lang['savepminsentitems'] = "Enregistrer une copie de chaque MP que j'envois dans mon dossier d'Items envoyés";
$lang['includepminreply'] = "Inclure le corps du message en répondant au MP";
$lang['autoprunemypmfoldersevery'] = "Élaguer automatiquement mes dossiers de MP tous les:";
$lang['friendsonly'] = "Ami(e)s seulement?";
$lang['globalstyles'] = "Global Styles";
$lang['forumstyles'] = "Forum Styles";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "Vous devez fournir des groupes de réponse";
$lang['mustprovidepolltype'] = "Vous devez fournir un type de scrutin";
$lang['mustprovidepollresultsdisplaytype'] = "Vous devez fournir un type d'affichage pour les résultats";
$lang['mustprovidepollvotetype'] = "Vous devez fournir un type de vote de scrutin";
$lang['mustprovidepollguestvotetype'] = "Vous devez indiquer si les invités ont la permission de voter";
$lang['mustprovidepolloptiontype'] = "Vous devez fournir un type d'option de scrutin";
$lang['mustprovidepollchangevotetype'] = "Vous devez fournir un type de changer vote du scrutin";
$lang['pleaseselectfolder'] = "SVP sélectionner un dossier!";
$lang['mustspecifyvalues1and2'] = "Vous devez spécifier des valeurs pour les réponses 1 et 2";
$lang['tablepollmusthave2groups'] = "Les scrutins de format tabulaire doivent avoir exactement deux groupes de mise aux voix";
$lang['nomultivotetabulars'] = "Les scrutins de format tabulaire ne peuved pas être multi-votes";
$lang['nomultivotepublic'] = "Les scrutins publiques ne peuvent pas être multi-votes";
$lang['abletochangevote'] = "Vous serez capable de changer votre vote.";
$lang['abletovotemultiple'] = "Vous pourrez voter plusieurs fois.";
$lang['notabletochangevote'] = "Vous ne pourrez pas changer votre vote.";
$lang['pollvotesrandom'] = "Note: Les votes de scrutin sont générés au hasard pour l'aperçu seulement.";
$lang['pollquestion'] = "Question de scrutin";
$lang['possibleanswers'] = "Réponses possibles";
$lang['enterpollquestionexp'] = "Entrer les réponses pour votre question de scrutin. Si votre scrutin est une question &quot;oui/non&quot;, vous n'avez qu'à entrer &quot;Oui&quot; pour Réponse 1 et &quot;Non&quot; pour Réponse 2.";
$lang['numberanswers'] = "No. Réponses";
$lang['answerscontainHTML'] = "Réponses contiennent du HTML (apart de la signature)";
$lang['optionsdisplay'] = "Type d'affichage des réponses";
$lang['optionsdisplayexp'] = "Comment voulez-vous que les réponses soient présentées?";
$lang['dropdown'] = "Déroulant vertical";
$lang['radios'] = "Comme une série de cases d'option";
$lang['votechanging'] = "Changement de vote";
$lang['votechangingexp'] = "Une personne est-elle permise de changer son vote?";
$lang['guestvoting'] = "Le vote par invité";
$lang['guestvotingexp'] = "Est-ce que les visiteurs peuvent voter dans ce scrutin?";
$lang['allowmultiplevotes'] = "Permettre votes multiples";
$lang['pollresults'] = "Résultats du scrutin";
$lang['pollresultsexp'] = "Comment voulez-vous afficher les résultats de votre scrutin?";
$lang['pollvotetype'] = "Type de vote de scrutin";
$lang['pollvotesexp'] = "Comment voulez-vous mener le scrutin?";
$lang['pollvoteanon'] = "Anonymement";
$lang['pollvotepub'] = "Vote publique";
$lang['horizgraph'] = "Graphique horizontale";
$lang['vertgraph'] = "Graphique verticale";
$lang['tablegraph'] = "Format tabulaire";
$lang['polltypewarning'] = "<b>Mise en garde</b>: Ceci est un vote publique. Votre nom d'utilisateur sera visible à côté de l'option pour laquelle vous avez voté.";
$lang['expiration'] = "Expiration";
$lang['showresultswhileopen'] = "Voulez-vous afficher les résultats pendant que le scrutin est ouvert?";
$lang['whenlikepollclose'] = "Quand aimeriez-vous que votre scrutin termine automatiquement?";
$lang['oneday'] = "Un jour";
$lang['threedays'] = "Trois jours";
$lang['sevendays'] = "Sept jours";
$lang['thirtydays'] = "Trente jours";
$lang['never'] = "Jamais";
$lang['polladditionalmessage'] = "Message supplémentaire (optionnel)";
$lang['polladditionalmessageexp'] = "Voulez-vous inclure un message supplémentaire après le scrutin?";
$lang['mustspecifypolltoview'] = "Vous devez spécifier un scrutin à afficher.";
$lang['pollconfirmclose'] = "Êtes-vous certain de vouloir fermer le scrutin suivant?";
$lang['endpoll'] = "Fermer scrutin";
$lang['nobodyvotedclosedpoll'] = "Personne a voté";
$lang['votedisplayopenpoll'] = "%s et %s ont voté.";
$lang['votedisplayclosedpoll'] = "%s et %s ont voté.";
$lang['nousersvoted'] = "Aucun usager";
$lang['oneuservoted'] = "1 usager";
$lang['xusersvoted'] = "%s usagers";
$lang['noguestsvoted'] = "Aucun invité";
$lang['oneguestvoted'] = "1 invité";
$lang['xguestsvoted'] = "%s invités";
$lang['pollhasended'] = "Le scrutin a terminé";
$lang['youvotedforpolloptionsondate'] = "You voted for %s on %s";
$lang['thisisapoll'] = "Ceci est un scrutin. Cliquer pour voir les résultats.";
$lang['editpoll'] = "Modifier le scrutin";
$lang['results'] = "Résultats";
$lang['resultdetails'] = "Détails des résultats";
$lang['changevote'] = "Changer vote";
$lang['pollshavebeendisabled'] = "Les scrutins ont été désactivé par le propriétaire du forum.";
$lang['answertext'] = "Texte de réponse";
$lang['answergroup'] = "Groupe de réponse";
$lang['previewvotingform'] = "Prévisualisation du formulaire de scrutin";
$lang['viewbypolloption'] = "View by poll option";
$lang['viewbyuser'] = "View by user";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "Modifier profile";
$lang['profileupdated'] = "Profile mise à jour.";
$lang['profilesnotsetup'] = "Le propriétaire du forum n'a pas établit les profiles.";
$lang['ignoreduser'] = "Utilisateur ignoré";
$lang['lastvisit'] = "Dernière visite";
$lang['totaltimeinforum'] = "Durée totale";
$lang['longesttimeinforum'] = "Session la plus longue";
$lang['sendemail'] = "Envoyer courriel";
$lang['sendpm'] = "Envoyer MP";
$lang['visithomepage'] = "Visiter le site web";
$lang['age'] = "Âge";
$lang['aged'] = "âgé";
$lang['birthday'] = "Anniversaire";
$lang['registered'] = "Enregistré";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "Désolé, le forum n'accepte pas de nouveaux enregistrements d'utilisateurs en ce moment. Veuillez ré-essayer plus tard.";
$lang['usernameinvalidchars'] = "Le nom d'utilisateur peut contenir seulement les caractères a-z, 0-9, _ -";
$lang['usernametooshort'] = "Le nom d'utilisateur doit contenir aumoins 2 caractères comme minimum";
$lang['usernametoolong'] = "Le nom d'utilisateur peut contenir un maximum de 15 caractères";
$lang['usernamerequired'] = "Un nom d'utilisateur est requis";
$lang['passwdmustnotcontainHTML'] = "Le mot de passe ne doit pas inclure des balises HTML";
$lang['passwordinvalidchars'] = "Le mot de passe peut contenir seulement les caractères a-z, 0-9, _ -";
$lang['passwdtooshort'] = "Le mot de passe doit être un minimum de 6 caractères de long";
$lang['passwdrequired'] = "Un mot de passe est requis";
$lang['confirmationpasswdrequired'] = "Un mot de passe de confirmation est requis";
$lang['nicknamerequired'] = "Pseudonyme requis!";
$lang['emailrequired'] = "Une adresse courriel est requise";
$lang['passwdsdonotmatch'] = "Les mots de passe ne correspondent pas.";
$lang['usernamesameaspasswd'] = "Le nom d'utilisateur et le mot de passe doivent être différents l'un de l'autre";
$lang['usernameexists'] = "Désolé, ce nom d'utilisateur est déjà en usage";
$lang['successfullycreateduseraccount'] = "Création de compte d'utilisateur réussie";
$lang['useraccountcreatedconfirmfailed'] = "Votre compte d'utilisateur a été créé mais le courriel de confirmation n'a pas été envoyé. Veuillez contacter le propriétaire du forum pour corriger cette situation. Entretemps, SVP cliquer le bouton continuer ci-dessous pour ouvrir une session.";
$lang['useraccountcreatedconfirmsuccess'] = "Votre compte d'utilisateur a été créé mais avant que vous puissiez commencer à poster, vous devez confirmer votre adresse courriel. SVP vérifier votre courriel pour un lien qui vous permettra de confirmer votre adresse courriel.";
$lang['useraccountcreated'] = "Création de compte d'utilisateur réussie! Cliquer le bouton continuer ci-dessous pour ouvrir une session";
$lang['errorcreatinguserrecord'] = "Erreur rencontrée durant la création du dossier d'utilisateur";
$lang['userregistration'] = "Enregistrement d'utilisateur";
$lang['registrationinformationrequired'] = "Information pour l'enregistrement (requise)";
$lang['profileinformationoptional'] = "Information de profile (Optionnelle)";
$lang['preferencesoptional'] = "Préférences (Optionnelle)";
$lang['register'] = "Enregistrer";
$lang['rememberpasswd'] = "Se souvenir du mot de passe";
$lang['birthdayrequired'] = "Votre date de naissance est requise ou est invalide";
$lang['alwaysnotifymeofrepliestome'] = "M'aviser lors de réponse à mes messages";
$lang['notifyonnewprivatemessage'] = "M'aviser lors de nouveaux Messages Privés";
$lang['popuponnewprivatemessage'] = "Fenêtre contextuelle lors de nouveau Messages Privés";
$lang['automatichighinterestonpost'] = "Niveau d'intérêt élevé automatique sur postage";
$lang['confirmpassword'] = "Confirmer mot de passe";
$lang['invalidemailaddressformat'] = "Format d'adresse courriel invalide";
$lang['moreoptionsavailable'] = "D'autres options de Profile et de Préférences sont disponibles une fois que vous vous êtes enregistré";
$lang['textcaptchaconfirmation'] = "Confirmation";
$lang['textcaptchaexplain'] = "À la droite est une image de text-captcha. SVP taper dans la zone d'entrée ci-dessous le code que vous voyer dans l'image.";
$lang['textcaptchaimgtip'] = "Ceci est une image-captcha. Elle est utilisée pour prévenir l'enregistrement automatique.";
$lang['textcaptchamissingkey'] = "Un code de confimation est requis.";
$lang['textcaptchaverificationfailed'] = "Le code de vérification du text captcha est erroné. SVP le réintroduire.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "Membre";
$lang['searchforusernotinlist'] = "Chercher pour un utilisateur qui n'est pas sur la liste";
$lang['yoursearchdidnotreturnanymatches'] = "Votre recherche n'a pas trouvé de correspondances. Veuillez simplifier vos paramètres de recherche et essayer de nouveau.";
$lang['hiderowswithemptyornullvalues'] = "Hide rows with empty or null values in selected columns";
$lang['showregisteredusersonly'] = "Show Registered Users only (hide Guests)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "Relations";
$lang['userrelationship'] = "Relation d'utilisateur";
$lang['userrelationships'] = "Relations d'utilisateur";
$lang['friends'] = "Ami(e)s";
$lang['ignoredcompletely'] = "Ignoré complètement";
$lang['relationship'] = "Relation";
$lang['restorenickname'] = "Restaurer le pseudonyme de l'utilisateur";
$lang['friend_exp'] = "Les messages de cet utilisateur seront marqué avec un icône &quot;Ami(e)&quot;";
$lang['normal_exp'] = "Les messages de cet utilisateur apparaîitront normallement.";
$lang['ignore_exp'] = "Les messages de cet utilisateur sont masqués.";
$lang['ignore_completely_exp'] = "Fils de discussion et messages de et à cet utilisateur apparaîtront comme supprimés.";
$lang['display'] = "Afficher";
$lang['displaysig_exp'] = "Afficher la signature de l'utilisateur sur leurs postes.";
$lang['hidesig_exp'] = "La signature de l'utilisateur est masquée sur leurs postes.";
$lang['cannotignoremod'] = "Vous ne pouvez pas ignorer cet utilisateur parce qu'il/elle est un modérateur.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "Résultats de recherche";
$lang['usernamenotfound'] = "Le nom d'utilisateur spécifié dans le champs à ou dans le champs de n'a pas été retrouvé.";
$lang['notexttosearchfor'] = "Un ou tous vos mots-clés de recherche étaient invalides. Les mots-clés de recherche doivent avoir un minimum de %d caractères et un maximum de %d caractères et ne doivent pas apparaître dans le %s.";
$lang['mysqlstopwordlist'] = "liste de mots vides MySQL";
$lang['foundzeromatches'] = "Correspondances trouvées: 0";
$lang['found'] = "Trouvé";
$lang['matches'] = "correspondances";
$lang['prevpage'] = "Page précédante";
$lang['findmore'] = "Trouver d'autres";
$lang['searchmessages'] = "Chercher les messages";
$lang['searchdiscussions'] = "Chercher les discussions";
$lang['find'] = "Trouver";
$lang['additionalcriteria'] = "Critères supplémentaires";
$lang['searchbyuser'] = "Chercher par utilisateur (optionnel)";
$lang['folderbrackets_s'] = "Dossier(s)";
$lang['postedfrom'] = "Posté depuis";
$lang['postedto'] = "Posté jusqu'à";
$lang['today'] = "aujourd'hui";
$lang['yesterday'] = "hier";
$lang['daybeforeyesterday'] = "avant hier";
$lang['weekago'] = "%s semaine passée";
$lang['weeksago'] = "%s semaines passées";
$lang['monthago'] = "%s mois passé";
$lang['monthsago'] = "%s mois passés";
$lang['yearago'] = "il y a un an";
$lang['beginningoftime'] = "Du début des temps";
$lang['now'] = "Maintenant";
$lang['lastpostdate'] = "Date du dernier message";
$lang['numberofreplies'] = "Nombre de réponses";
$lang['foldername'] = "Nom du dossier";
$lang['authorname'] = "Nom de l'auteur";
$lang['decendingorder'] = "Le plus récent en premier";
$lang['ascendingorder'] = "Le plus ancien en premier";
$lang['keywords'] = "Mots-clé";
$lang['sortby'] = "Assortir par";
$lang['sortdir'] = "Assortir dir";
$lang['sortresults'] = "Assortir les résultats";
$lang['groupbythread'] = "Grouper par fil de discussion";
$lang['postsfromuser'] = "Messages de cet utilisateur";
$lang['poststouser'] = "Messages à cet utilisateur";
$lang['poststoandfromuser'] = "Messages à et de cet utilisateur";
$lang['searchfrequencyerror'] = "Vous pouvez chercher seulement une fois tous les %s secondes. Veuillez essayer de nouveau plus tard.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "Choisir";
$lang['searchforthread'] = "Chercher pour fils de discussion";
$lang['mustspecifytypeofsearch'] = "You must specify type of search to perform";
$lang['unkownsearchtypespecified'] = "Unknown search type specified";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "Fils de discussion récents";
$lang['startreading'] = "Commencer lecture";
$lang['threadoptions'] = "Options de fil de discussion";
$lang['editthreadoptions'] = "Modifier options de fil de discussion";
$lang['morevisitors'] = "Plus de visiteurs";
$lang['forthcomingbirthdays'] = "Anniversaires à venir";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "Vous pouvez modifier cette page de l'interface admin";
$lang['uploadstartpage'] = "Téléverser page de démarrage (%s)";
$lang['invalidfiletypeerror'] = "Type de fichier invalide. Vous pouvez utiliser seulement les fichiers *.txt, *.php et *.htm pour votre page de démarrage.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "Nouvelle discussion";
$lang['createpoll'] = "Créer Scrutin";
$lang['search'] = "Chercher";
$lang['searchagain'] = "Chercher encore";
$lang['alldiscussions'] = "Toutes les discussions";
$lang['unreaddiscussions'] = "Discussions non-lues";
$lang['unreadtome'] = "Non-lues &quot;À: Moi&quot;";
$lang['todaysdiscussions'] = "Discussions du jour";
$lang['2daysback'] = "Depuis 2 jours";
$lang['7daysback'] = "Depuis 7 jours";
$lang['highinterest'] = "D'intérêt élevé";
$lang['unreadhighinterest'] = "D'intérêt élevé non-lues";
$lang['iverecentlyseen'] = "que j'ai récemment vues";
$lang['iveignored'] = "que j'ai ignorées";
$lang['byignoredusers'] = "Par utilisateurs ignorés";
$lang['ivesubscribedto'] = "auquelles je m'abonne";
$lang['startedbyfriend'] = "Commencées par des amis";
$lang['unreadstartedbyfriend'] = "Non-lues commencées par amis";
$lang['startedbyme'] = "que j'ai commencées";
$lang['unreadtoday'] = "Non-lues aujourd'hui";
$lang['deletedthreads'] = "Fils de discussions supprimés";
$lang['goexcmark'] = "Allez-y!";
$lang['folderinterest'] = "Niveau d'intérêt du dossier";
$lang['postnew'] = "Poster nouveau";
$lang['currentthread'] = "Fil de discussion courant";
$lang['highinterest'] = "D'intérêt élevé";
$lang['markasread'] = "Marquer comme lues";
$lang['next50discussions'] = "Prochaines 50 discussions";
$lang['visiblediscussions'] = "Discussions Visibles";
$lang['selectedfolder'] = "Dossier sélectionné";
$lang['navigate'] = "Naviguer";
$lang['couldnotretrievefolderinformation'] = "Aucun dossier de disponible.";
$lang['nomessagesinthiscategory'] = "Aucun message dans cette catégorie. Veuillez sélectionner un autre, ou";
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
$lang['subscribed'] = "Abonné";
$lang['ignorethisfolder'] = "Ignorer ce dossier";
$lang['stopignoringthisfolder'] = "Cesser d'ignorer ce dossier";
$lang['stickythreads'] = "Fils de discussion collants";
$lang['mostunreadposts'] = "Plus de messages non-lus";
$lang['onenew'] = "%d nouveau";
$lang['manynew'] = "%d nouveaux";
$lang['onenewoflength'] = "%d nouveau de %d";
$lang['manynewoflength'] = "%d nouveaux de %d";
$lang['ignorefolderconfirm'] = "Êtes-vous certain de vouloir ignorer ce dossier?";
$lang['unignorefolderconfirm'] = "Êtes-vous certain de vouloir cesser d'ignorer ce dossier?";
$lang['gotofirstpostinthread'] = "Allez au premier message du fils de discussion";
$lang['gotolastpostinthread'] = "Allez au dernier message du fils de discussion";
$lang['viewmessagesinthisfolderonly'] = "Visualiser les messages dans ce dossier seulement";
$lang['shownext50threads'] = "Montrez les 50 fils de discussion suivants";
$lang['showprev50threads'] = "Montrez les 50 fils de discussion précédents";
$lang['createnewdiscussioninthisfolder'] = "Créez un nouveau fils de discussion dans ce dossier";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "Caractère gras";
$lang['italic'] = "Italique";
$lang['underline'] = "Souligner";
$lang['strikethrough'] = "Biffure";
$lang['superscript'] = "Lettre supérieure";
$lang['subscript'] = "Indice inférieure";
$lang['leftalign'] = "Alignement à gauche";
$lang['center'] = "Centrer";
$lang['rightalign'] = "Alignement à droite";
$lang['numberedlist'] = "Liste énumérée";
$lang['list'] = "Liste";
$lang['indenttext'] = "Indenter texte";
$lang['code'] = "Code";
$lang['quote'] = "Citer";
$lang['spoiler'] = "Gâcheur";
$lang['horizontalrule'] = "Règle horizontale";
$lang['image'] = "Image";
$lang['hyperlink'] = "Liens hypertexte";
$lang['noemoticons'] = "Désactiver les binettes";
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
$lang['lightgreen'] = "Vert pâle";
$lang['lightblue'] = "Bleu pâle";

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
$lang['viewcompletelist'] = "Voir liste complète";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "Our members have made a total of %s and %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "Longest thread is <b>%s</b> with %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "There have been <b>%s</b> posts made in the last 60 minutes.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "There has been <b>1</b> post made in the last 60 minutes.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "Most posts ever made in a single 60 minute period is <b>%s</b> on %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "We have <b>%s</b> registered members and the newest member is <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "We have %s registered members.";
$lang['wehaveoneregisteredmember'] = "We have one registered member.";
$lang['mostuserseveronlinewasnumondate'] = "Most users ever online was <b>%s</b> on %s.";
$lang['statsdisplayenabled'] = "Affichage de statistiques activé";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "Mises à jour effectuées";
$lang['useroptions'] = "Options d'utilisateur";
$lang['markedasread'] = "Marquer comme lu";
$lang['postsoutof'] = "messages sur";
$lang['interest'] = "Intérêt";
$lang['closedforposting'] = "Fermé au postage";
$lang['locktitleandfolder'] = "Verrouiller le titre et le dossier";
$lang['deletepostsinthreadbyuser'] = "Supprimer les messages dans le fil de discussion par l'utilisateur";
$lang['deletethread'] = "Supprimer le fil de discussion";
$lang['permenantlydelete'] = "Permenantly Delete";
$lang['movetodeleteditems'] = "Move to Deleted Threads";
$lang['undeletethread'] = "Annuler suppression du fils de discussion";
$lang['threaddeletedpermenantly'] = "Fils de discussion supprimer en permanence. Impossible d'annuler la suppression.";
$lang['markasunread'] = "Marquer comme non-lu";
$lang['makethreadsticky'] = "Rendre le fil de discussion collant";
$lang['threareadstatusupdated'] = "Mise à jour du statut de lecture du fil de discussion réussie";
$lang['interestupdated'] = "Mise à jour du statut de l'intérêt du fil de discussion réussie";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "Dictionnaire";
$lang['spellcheck'] = "Vérification d'orthographe";
$lang['notindictionary'] = "Pas dans le dictionnaire";
$lang['changeto'] = "Changer à";
$lang['restartspellcheck'] = "Restart";
$lang['cancelchanges'] = "Cancel Changes";
$lang['initialisingdotdotdot'] = "Initialisation...";
$lang['spellcheckcomplete'] = "Spell check is complete. To restart spell check click restart button below.";
$lang['spellcheck'] = "Vérification d'orthographe";
$lang['noformobj'] = "Aucun objet de forme indiqué pour texte de retour";
$lang['bodytext'] = "Corps de texte";
$lang['ignore'] = "Ignorer";
$lang['ignoreall'] = "Ignorer tout";
$lang['change'] = "Changer";
$lang['changeall'] = "Changer tout";
$lang['add'] = "Ajouter";
$lang['suggest'] = "Suggérer";
$lang['nosuggestions'] = "(aucune suggestion)";
$lang['cancel'] = "Annuler";
$lang['dictionarynotinstalled'] = "Aucun dictionnaire d'installer. Veuillez contacter le propriétaire du forum pour remédier cette situation.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "Lecture de messages permis";
$lang['postcreationallowed'] = "Création de messages permis";
$lang['threadcreationallowed'] = "Création de fils de discusion permis";
$lang['posteditingallowed'] = "Révision de message permis";
$lang['postdeletionallowed'] = "Suppression de message permis";
$lang['attachmentsallowed'] = "Fichiers joints permis";
$lang['htmlpostingallowed'] = "Postage avec HTML permis";
$lang['signatureallowed'] = "Signature permis";
$lang['guestaccessallowed'] = "Accès aux visiteurs permis";
$lang['postapprovalrequired'] = "Approbation de message requise";

// RSS feeds gubbins

$lang['rssfeed'] = "Alimentation RSS";
$lang['every30mins'] = "Toutes les 30 minutes";
$lang['onceanhour'] = "Une fois par heure";
$lang['every6hours'] = "Toutes les 6 heures";
$lang['every12hours'] = "Toutes les 12 heures";
$lang['onceaday'] = "Une fois par jour";
$lang['rssfeeds'] = "Sources de données RSS";
$lang['feedname'] = "Nom de la source de donnée";
$lang['feedfoldername'] = "Nom du fichier pour les souces de données";
$lang['feedlocation'] = "Repérage de source de données";
$lang['threadtitleprefix'] = "Préfix pour titre des fils de discussion";
$lang['feednameandlocation'] = "Nom de la source de données et emplacement";
$lang['feedsettings'] = "Options de la source de données";
$lang['updatefrequency'] = "Fréquence de mise à jour";
$lang['rssclicktoreadarticle'] = "Cliquer ici pour lire cette article";
$lang['addnewfeed'] = "Ajouter nouvelle source de données";
$lang['editfeed'] = "Modifier source de données";
$lang['feeduseraccount'] = "Nom d'utilisateur de la souce de données";
$lang['noexistingfeeds'] = "Aucune source de données RSS existante trouvé. Pour ajouter une souce de données, veuillez cliquer le bouton ci-dessous";
$lang['rssfeedhelp'] = "Vous pouvez ici régler des sources de données RSS pour propagation automatique dans votre forum. Les items des sources de données RSS que vous ajoutez seront créés comme fils de discussion auquels vos utilisateurs pourront répondre comme si c'étaient des messages normales. Lorsque vous ajouter une source de données RSS, vous devez indiquer le nom d'utilisateur à utiliser pour commencer les fils de discussion, le dossier dans lequel ils seront créés et le repérage des sources de données. Le repérage des sources de données lui-même doit être accessible via HTTP, sinon les sources de données ne fonctionneront pas.";
$lang['mustspecifyrssfeedname'] = "Vous devez spécifier le nom de l'alimentation RSS";
$lang['mustspecifyrssfeeduseraccount'] = "Vous devez spécifier le compte d'utilisateur de l'alimentation RSS";
$lang['mustspecifyrssfeedfolder'] = "Vous devez spécifier le dossier d'alimentation RSS";
$lang['mustspecifyrssfeedurl'] = "Vous devez spécifier l'adresse URL de l'alimentation RSS";
$lang['mustspecifyrssfeedupdatefrequency'] = "Vous devez spécifier la fréquence de mise à jour de l'alimentation RSS";
$lang['unknownrssuseraccount'] = "Compte d'utilisateur RSS inconnu";
$lang['rssfeedsupportshttpurlsonly'] = "L'alimentation RSS supporte uniquement les adresses URL HTTP. Les alimentations protégées (https://) ne sont pas supportées.";
$lang['rssfeedurlformatinvalid'] = "L'adresse URL doit inclure la spécification du protocole d'application (ex. http://) et une adresse internet (ex. www.adresseinternet.com).";
$lang['rssfeeduserauthentication'] = "L'alimentation RSS ne supporte pas l'authentication d'utilisateur HTTP";
$lang['successfullyremovedselectedfeeds'] = "Supression des sources de données sélectionnées réussie";
$lang['successfullyaddedfeed'] = "Ajout de nouvelle souce de données réussi";
$lang['successfullyeditedfeed'] = "Modification de la source de donnée réussie";
$lang['failedtoremovefeeds'] = "La suppression de certaines ou de toutes les sources de données sélectionnées a échoué";
$lang['failedtoaddnewrssfeed'] = "L'ajout d'une nouvelle source de données RSS a échoué";
$lang['failedtoupdaterssfeed'] = "Mise à jour de la source de données RSS a échoué";
$lang['rssstreamworkingcorrectly'] = "Flux de données RSS semble fonctionner correctement";
$lang['rssstreamnotworkingcorrectly'] = "Flux de données RSS était vide ou introuvable";
$lang['invalidfeedidorfeednotfound'] = "Source de données invalide ou source introuvable";

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
$lang['postsinthisthreadatstart'] = "Messages dans ce fils de discussion au début";
$lang['postsinthisthreadatend'] = "Messages dans ce fils de discussion à la fin";
$lang['reorderpostsintodateorder'] = "Trier par ordre de date";
$lang['splitthreadatpost'] = "Diviser fils de discussion à message:";
$lang['selectedpostsandrepliesonly'] = "Message sélectionné et réponses seulement";
$lang['selectedandallfollowingposts'] = "Message sélectionné et tous les suivants";

$lang['thisthreadhasmoved'] = "<b>Fils de discussion fusionnés:</b> Ce fils de discussion a déménagé %s";
$lang['thisthreadwasmergedfrom'] = "<b>Fils de discussion fusionnés:</b> Ce fils de discussion a été fusionné d'ici %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>Division de fils de discussion:</b> Certains messages dans ce fils de discussion ont été déplacé %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>Division de fils de discussion:</b> Certains messages de ce fils de discussion ont été déplacé de %s";

$lang['invalidfunctionarguments'] = "Arguments de fonction invalide";
$lang['couldnotretrieveforumdata'] = "Impossible de récupérer les données du forum";
$lang['cannotmergepolls'] = "Un ou plusieurs fils de discussion est un scrutin. Vous ne pouvez pas fusionner les scrutins";
$lang['couldnotretrievethreaddatamerge'] = "Impossible récupérer les données de fils de discussions d'un ou plusieurs fils de discussion";
$lang['couldnotretrievethreaddatasplit'] = "Impossible de récupérer les données du fils de discussion du fils de discussion source";
$lang['couldnotretrievepostdatamerge'] = "Impossible de récupérer les données des messages d'un ou plusieurs fils de discussion";
$lang['couldnotretrievepostdatasplit'] = "Impossible de récupérer les données des messages du fils de discussion source";
$lang['failedtocreatenewthreadformerge'] = "Création d'un nouveau fils de discussion pour fusionnement a échoué";
$lang['failedtocreatenewthreadforsplit'] = "Création d'un nouveau fils de discussion pour dispersion a échoué";

// Thread subscriptions

$lang['threadsubscriptions'] = "Abonnement de fils de discussion";
$lang['couldnotupdateinterestonthread'] = "L'intérêt du fil de discussion '%s' n'a pas pu être mise à jour";
$lang['threadinterestsupdatedsuccessfully'] = "Mise à jour du statut de l'intérêt du fil de discussion réussie";
$lang['resetselected'] = "Réinitialiser sélectionné";
$lang['allthreadtypes'] = "Tous les types de fils de discussion";
$lang['ignoredthreads'] = "Fils de discussion ignorés";
$lang['highinterestthreads'] = "Fils de discussion à intérêt élevé";
$lang['subscribedthreads'] = "Fils de discussion abonnés";
$lang['currentinterest'] = "Intérêt actuel";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "You can only add 3 columns. To add a new column close an existing one";
$lang['columnalreadyadded'] = "You have already added this column. If you want to remove it click it's close button";

?>
