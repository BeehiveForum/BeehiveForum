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

/* $Id: x-hacker.inc.php,v 1.40 2003-11-02 16:18:33 decoyduck Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_charset'] = "utf-8"; // ISO Charset code
$lang['_isocode'] = "en";    // ISO-639 language code
$lang['_textdir'] = "ltr";   // ltr or rtl; left to right or vice versa


// Common words --------------------------------------------------------

$lang['add'] = "ADd";
$lang['remove'] = "R3moV3";
$lang['go'] = "90";
$lang['folder'] = "PHOLDer";
$lang['folders'] = "pHoLD3r\$";
$lang['thread'] = "+hRead";
$lang['threads'] = "+hre@D\$";
$lang['message'] = "M3\$\$4GE";
$lang['from'] = "PhR0m";
$lang['to'] = "TO";
$lang['all_caps'] = "ALL";
$lang['of'] = "OPh";
$lang['reply'] = "REpLY";
$lang['delete'] = "dElE+e";
$lang['del'] = "dEl";
$lang['edit'] = "eD1T";
$lang['privileges'] = "PRiv1l3g3\$";
$lang['ignore'] = "I9N0re";
$lang['normal'] = "NORMAL";
$lang['interested'] = "inT3Re\$+3D";
$lang['subscribe'] = "sU8sCr1b3";
$lang['apply'] = "@pPly";
$lang['submit'] = "\$UbM1+";
$lang['save'] = "\$4vE";
$lang['cancel'] = "c4NC3l";
$lang['continue'] = "COnt1nue";
$lang['queen'] = "QU33n";
$lang['soldier'] = "\$0lDIEr";
$lang['worker'] = "wOrK3r";
$lang['worm'] = "WorM";
$lang['wasp'] = "W4sP";
$lang['splat'] = "5pl4T";
$lang['with'] = "With";
$lang['attachment'] = "4TtACHmen+";
$lang['attachments'] = "ATT4CHmEn+s";
$lang['filename'] = "fIlENamE";
$lang['dimensions'] = "dIMen51oN\$";
$lang['downloaded'] = "DoWnl0@D3d";
$lang['size'] = "51z3";
$lang['time'] = "+im3";
$lang['times'] = "T1M3\$";
$lang['viewmessage'] = "V1ew m3\$s49E";
$lang['messageunavailable'] = "M3SS4g3 un4V41l48le";
$lang['logon'] = "l0Gon";
$lang['status'] = "STATUs";
$lang['more'] = "MoRe";
$lang['recentvisitors'] = "R3cEn+ v15IT0r\$";
$lang['username'] = "U\$erN4m3";
$lang['clear'] = "cl34R";
$lang['action'] = "4ct1On";
$lang['unknown'] = "UNKnoWn";
$lang['none'] = "n0n3";
$lang['preview'] = "PrEV13W";
$lang['post'] = "PO\$+";
$lang['posts'] = "P0S+5";
$lang['change'] = "CH4n93";
$lang['yes'] = "Y35";
$lang['no'] = "N0";
$lang['signature'] = "51gn@tuRe";
$lang['wasnotfound'] = "w@5 NoT F0unD";
$lang['back'] = "8@Ck";
$lang['subject'] = "\$U8j3C+";
$lang['close'] = "cl0\$3";
$lang['name'] = "N4mE";
$lang['description'] = "deScRIp+ion";
$lang['date'] = "D4tE";
$lang['view'] = "vI3W";
$lang['passwd'] = "P4ssw0rD";
$lang['ignored'] = "1Gn0r3d";
$lang['guest'] = "GUesT";
$lang['next'] = "NeX+";
$lang['prev'] = "pR3v";
$lang['others'] = "0th3R5";
$lang['nickname'] = "NiCKN@m3";
$lang['emailaddress'] = "eM41l aDDr3ss";
$lang['confirm'] = "CoNf1rm";
$lang['email'] = "EMA1l";
$lang['new'] = "n3w";
$lang['poll'] = "pOLl";
$lang['friend'] = "Fr13nD";
$lang['error'] = "ERror";
$lang['reset'] = "R3\$3+";
$lang['guesterror_1'] = "\$orrY, j00 Need t0 be l09GeD 1n +0 uS3 tHI\$ Ph34tURe.";
$lang['guesterror_2'] = "L0G1n N0w";
$lang['on'] = "oN";
$lang['unread'] = "unR3@D";
$lang['all'] = "@lL";
$lang['me_caps'] = "m3";
$lang['by'] = "bY";
$lang['permissions'] = "P3RM155i0N\$";
$lang['position'] = "P0si+IOn";
$lang['or'] = "OR";
$lang['hours'] = "hoUR\$";
$lang['type'] = "TYP3";
$lang['print'] = "Print";
$lang['sticky'] = "sTICKy";
$lang['polls'] = "PoLl5";
$lang['user'] = "U53r";
$lang['enabled'] = "en@8l3d";
$lang['disabled'] = "di\$@Bl3d";

// Error handling messages (error_handler.inc.php) ---------------------

$lang['db_connect_error'] = "<p>An error has occured while connecting to the database.</p>\n<p>If you are the forum owner, please ensure the following variables in your config.inc.php are set correctly:</p><pre>\$db_server<br />\$db_username<br />\$db_password<br />\$db_database</pre><p>They should be set to the database details given to you by your hosting provider.</p>\n";

// Admin interface (admin*.php) ----------------------------------------

$lang['accessdenied'] = "4CC3\$\$ denI3D";
$lang['accessdeniedexp'] = "J00 d0 not H4v3 PERM1ss1On tO Us3 THi\$ \$3c+1ON.";
$lang['managefolders'] = "M4n4ge pHold3RS";
$lang['managefolder'] = "m4n493 fold3r";
$lang['id'] = "ID";
$lang['foldername'] = "FOlD3r N4m3";
$lang['accesslevel'] = "4Cc3\$S l3V3l";
$lang['move'] = "M0v3";
$lang['closed'] = "CL053D";
$lang['open'] = "OpeN";
$lang['restricted'] = "R3S+r1Ct3d";
$lang['newfolder'] = "nEw fOLD3r";
$lang['forumadmin'] = "PhOrum 4dMin";
$lang['adminexp_1'] = "U5e +h3 mEnU 0n +EH lefT +0 m4N49e +HIngS 1n YoUR PhOrum.";
$lang['adminexp_2'] = "<b>uSer\$</b> @ll0Ws j00 +O S3+ u53r PErmiS\$i0N\$, 1nCLUd1N9 @PP01nTInG EDi+0R\$ 4nd g4Gg1ng pe0pl3.";
$lang['adminexp_3'] = "U\$e <b>F0LDer\$</b> t0 4dD new PHoldeRS 0r CHan9E tH3 n4m35 0f ex1s+1N9 0nE5.";
$lang['adminexp_4'] = "<b>pRophILES</b> l3+\$ j00 CH4n9E teH i+3m\$ 4Ppe4RIn9 iN usEr pR0pH1leS.";
$lang['adminexp_5'] = "Choo\$3 <b>5+4rt P@9e</b> +0 ED1+ THe F0ruM sT@rt P@ge.";
$lang['adminexp_6'] = "u\$iN9 <b>fOrum s+yle</b> @ll0w5 j00 +o crE4tE nEw col0ur 5CHem3\$ ph0R +h3 pH0rum.";
$lang['adminexp_7'] = "+he w0Rd\$ iN +3H <b>WOrd Ph1l+3r</b> c4N 83 edi+ed.";
$lang['adminexp_8'] = "lo0K 4+ +3h <b>@dm1n L09</b> +0 sEe wH4+ 4C+1Ons FOrum m0d3r4+oR5 haV3 t4K3n r3CenTly.";
$lang['createforumstyle'] = "CREA+e 4 f0rUM STyL3";
$lang['newstyle'] = "New STyLE";
$lang['successfullycreated'] = "SucC3\$\$FullY CR3@TeD.";
$lang['stylesdirnotwritable'] = "+h3 5+YLE5 dIRectORy IS no+ wrITE48L3. pl3@\$E chMOd +h3 5tYl3\$ diR3ctOry 4ND rE+rY.";
$lang['stylealreadyexists'] = "@ \$+YLE w1+h th@+ pHIlen@ME @lrE@dy Ex15tS.";
$lang['stylenofilename'] = "J00 d1d n0t 3NT3R @ pH1LEn@m3 tO S@v3 t3h S+yl3 wITh.";
$lang['stylenotauthorised'] = "j00 @RE nOt AU+h0Ri\$ed T0 CRE4te FOrum StylE5.";
$lang['styleexp'] = "uS3 +h15 p49E +0 heLP cRE4+3 a R@NDOMLy 9eN3r@+3D styL3 phoR Y0ur phoRum.";
$lang['stylecontrols'] = "c0NtRoL5";
$lang['stylecolourexp'] = "clICK 0N @ C0l0UR +O m4k3 a neW stYL3\$hEEt 845ED 0n tH@+ C0L0ur. Curr3nT B@\$e col0ur 1s f1RsT 1n li5+.";
$lang['standardstyle'] = "\$t@nd4rd \$tyLe";
$lang['rotelementstyle'] = "ROT@t3d eLEMent stylE";
$lang['randstyle'] = "r@ND0m s+yl3";
$lang['enterhexcolour'] = "Or 3N+3r 4 HEX coL0ur +0 B@s3 4 neW styL3\$HEet oN";
$lang['savestyle'] = "s@ve +HIs \$tyLE";
$lang['styledesc'] = "\$+ylE d3Sc.";
$lang['fileallowedchars'] = "(L0Werc45e l3++3R\$ (@-z), NUm8er5 (0-9) 4Nd uND3r\$C0r35 (_) 0nLY)";
$lang['stylepreview'] = "STyl3 PReviEW";
$lang['welcome'] = "w3Lc0m3";
$lang['messagepreview'] = "MEs\$@9E Pr3viEW";
$lang['h1tag'] = "H1 T4g";
$lang['subhead'] = "SuBHEAd";
$lang['users'] = "UsErs";
$lang['profiles'] = "pr0f1l3s";
$lang['startpage'] = "\$T4rt P49e";
$lang['forumstyle'] = "ph0rUm 5TYle";
$lang['wordfilter'] = "W0Rd ph1lteR";
$lang['viewlog'] = "vI3w lo9";
$lang['invalidop'] = "INv4lid 0per4ti0N";
$lang['noprofilesectionspecified'] = "n0 proFiL3 SeC+1on \$PEC1f1ED.";
$lang['newitem'] = "new i+3M";
$lang['manageprofileitems'] = "m4N@9E pr0fil3 1+3m5";
$lang['section'] = "sEC+i0N";
$lang['itemname'] = "1+3m NAM3";
$lang['moveto'] = "MoVE +0";
$lang['deleteitem'] = "D3LEte IT3m";
$lang['deletesection'] = "DeL3+3 53c+ion";
$lang['new_caps'] = "N3w";
$lang['newsection'] = "New sECt10N";
$lang['manageprofilesections'] = "M4N4ge prOF1le \$3CTI0N\$";
$lang['sectionname'] = "SeCTI0N n@me";
$lang['items'] = "I+EMS";
$lang['startpageupdated'] = "s+Art P493 uPD4t3d";
$lang['viewupdatedstartpage'] = "V13w upd4+3d 5+@R+ p4G3";
$lang['editstartpage'] = "3DIT \$T@rT p@ge";
$lang['editstartpageexp'] = "USe tH1s P@ge +O 3di+ TH3 ST@rT P493 0N y0uR pHOrum.";
$lang['nouserspecified'] = "No User 5peCiph1ED for 3DI+in9.";
$lang['manageuser'] = "M4n493 U\$eR";
$lang['manageusers'] = "M4N@93 US3r\$";
$lang['userstatus'] = "u\$er \$T4TU5";
$lang['warning_caps'] = "w4rniN9";
$lang['userdeleteallpostswarning'] = "4R3 j00 \$URe j00 wan+ +0 d3l3+3 4ll of +h3 \$3l3ct3D u\$eR'5 poS+s? 0nc3 t3h post5 @re deLet3d th3y caNN0+ b3 r3trIEVed and w1ll be Lo\$T Ph0r3ver.";
$lang['postssuccessfullydeleted'] = "PO\$tS wEr3 sUcc3\$5FUlly DeLetED.";
$lang['folderaccess'] = "ph0Ld3R aCc3s5";
$lang['norestrictedfolders'] = "nO re5+RicT3d fOld3rs";
$lang['possiblealiases'] = "pO5518L3 4li4S3s";
$lang['nomatches'] = "n0 M4+cHe5";
$lang['cannotipbansoldiers'] = "j00 c4nNO+ 1P b@n 0+hER s0LdiER\$. LOWEr +h3IR st4+US f1r5+.";
$lang['banthisipaddress'] = "b4N TH1s iP Addr3ss";
$lang['noipaddress'] = "Th3re 1S nO 1p 4ddr3s\$ pHOr tHI\$ 4CCount. TH3 uS3r C4Nn0t 83 8@nn3D 8y 1p @DDr3ss.";
$lang['deleteposts'] = "DEl3TE p0\$Ts";
$lang['deleteallusersposts'] = "Dele+3 @LL oph tH1s U53R'\$ P0\$TS";
$lang['noattachmentsforuser'] = "no @Tt@cHMEnt\$ f0R tHI5 u53r";
$lang['soldierdesc'] = "<b>SolDi3rS</b> c@n 4cc3\$s @ll moD3R@+1on t00l5, buT c4nNOT cREat3 0R reM0v3 0+H3r \$0ld1erS.";
$lang['workerdesc'] = "<b>Work3r5</b> C4N 3D1+ 0R DEL3t3 @NY pO\$+.";
$lang['wormdesc'] = "<b>woRMs</b> caN rE4d me\$S4Ge5 aND po\$+ 4\$ N0rm@l, 8ut tHE1r M3554g3\$ wILl 4pP34r d3le+ed to 4ll 0theR U\$ErS.";
$lang['waspdesc'] = "<b>W@sps</b> c4N r34D m355A9E\$, 8ut c@nn0t rEpLY oR P05T n3w M3s5Ag3\$.";
$lang['splatdesc'] = "<b>5PlAt\$</b> cANnot aCCe5s +3h f0Rum. uS3 tHIs TO 84N pERsI5t3N+ 1diO+\$.";
$lang['aliasdesc'] = "<b>P05S18l3 4l14\$E5</b> 15 4 lIs+ OF O+h3R uSerS Wh0'\$ L@\$+ R3c0rD3D ip @ddrE\$s m@tch +h1\$ Us3r.";
$lang['manageusersexp_1'] = "+his LI\$+ 5h0wS a 53lEct1ON 0f u5ERs WHo h@ve L0G9ED on tO y0ur F0RUm, \$ort3d 8Y";
$lang['manageusersexp_2'] = "t0 4LTEr 4 us3r's perM1SSI0ns Click +h31R n4m3.";
$lang['manageusersexp_3'] = "t0 \$Ee TEH l4St feW User\$ To l0goN, SOr+ T3h LI\$+ 8y LAs+_L090n.";
$lang['lastlogon'] = "L4\$+ LOG0n";
$lang['logonfrom'] = "lo90N phrOM";
$lang['nouseraccounts'] = "No u\$ER 4cc0un+\$ 1n d@t@B@\$3.";
$lang['searchforusernotinlist'] = "534rcH ph0R 4 us3r no+ 1N l15+";
$lang['adminaccesslog'] = "4dm1n @cc35\$ LoG";
$lang['adminlogexp'] = "tHi5 l1st 5hoW\$ +h3 l@s+ @c+10n\$ s4nC+1On3d 8y us3rs witH aDmin PR1vilE9e5.";
$lang['showingactions'] = "SH0Win9 4c+ionS";
$lang['inclusive'] = "1nclU5Ive";
$lang['datetime'] = "D4+3/+IM3";
$lang['unknownuser'] = "UNkn0wN U\$3r";
$lang['unknownfolder'] = "uNKnown Ph0ldER";
$lang['changeduserstatus'] = "Ch@n93d US3r \$+@+U\$ for U\$er";
$lang['changedfolderaccess'] = "CH4ng3d uS3R FoLD3R ACc3\$s pRIV5 PHOr u\$er";
$lang['deletedallusersposts'] = "d3LE+eD 4ll P0s+\$ f0r u5er";
$lang['banneduser'] = "84Nn3D u\$Er";
$lang['unbanneduser'] = "UN84nn3D U\$3r";
$lang['ipaddress'] = "1P @Ddr35\$";
$lang['deleteduser'] = "D3l3+ed us3r";
$lang['changedtitleaccessfolder'] = "Ch4ngEd fold3r 0pt1ons f0r folder";
$lang['movedthreads'] = "moVEd +Hre4d5 to fold3r";
$lang['creatednewfolder'] = "CRe4+ED New fold3r";
$lang['changedprofilesectiontitle'] = "ch4n9ed prophil3 53ct10n t1tLE ph0R s3cTi0n";
$lang['addednewprofilesection'] = "@DD3d n3w pRoF1LE \$3C+10n";
$lang['deletedprofilesection'] = "Del3ted proph1Le \$3Ction";
$lang['changedprofileitemtitle'] = "ch4N9ed prophiLe 1+3m +1tl3 for iTem";
$lang['addednewprofileitem'] = "@dDED N3w pROpH1LE 1+em";
$lang['deletedprofileitem'] = "D3L3+ed pr0ph1L3 i+em";
$lang['editedstartpage'] = "3d1+3d st@r+ p49e";
$lang['savednewstyle'] = "\$4veD neW s+yle";
$lang['movedthread'] = "M0ved +hrE@d";
$lang['closedthread'] = "cLOs3D +hre@d";
$lang['openedthread'] = "0p3ned +hrE4d";
$lang['renamedthread'] = "R3n4MEd THr3@d";
$lang['deletedpost'] = "D3lE+3D P0\$t";
$lang['editedpost'] = "Ed1t3d POsT";
$lang['editedwordfilter'] = "3D1T3d w0rd PhiltER";
$lang['adminlogempty'] = "4DMIN LO9 i\$ empty";
$lang['recententries'] = "ReC3nt 3N+rie\$";
$lang['clearlog'] = "cL34r lo9";
$lang['wordfilterupdated'] = "W0RD F1Lt3r uPd@TED";
$lang['editwordfilter'] = "eDIt W0RD Phil+3r";
$lang['wordfilterexp_1'] = "u\$3 +HIS P4G3 t0 edit T3h word fiLt3r foR yoUR f0RuM. Pl4c3 34Ch WOrD t0 83 fIl+eREd 0N 4 nEW L1NE.";
$lang['wordfilterexp_2'] = "PERL-CoMP@+ibl3 regUl@r Expre\$S10n\$ c@n 4Ls0 8e U\$3d +0 m@tch W0Rds 1ph j00 kN0W hoW.";
$lang['allow'] = "AlL0W";
$lang['normalthreadsonly'] = "n0Rm4L +hRe4d5 Only";
$lang['pollthreadsonly'] = "P0ll thrE4ds onLy";
$lang['both'] = "80Th thRE4d +YP3s";
$lang['existingpermissions'] = "eX1St1n9 p3rmI\$s1onS";
$lang['folderisnotrestricted'] = "PH0LDeR IS n0t res+r1C+eD. s3T 1+'\$ 4cC3\$s lEV3L TO restric+3d 83F0r3 add1ng/rEM0V1NG Us3r\$";
$lang['nousers'] = "n0 U\$3R\$";
$lang['addnewuser'] = "@dD NEw U\$3R";
$lang['adduser'] = "@DD USer";
$lang['searchforuser'] = "Se4RCh phoR USer";
$lang['browsernegotiation'] = "brOws3r n3G0ti4T3d";
$lang['largetextfield'] = "L4R9e +3x+ phIELD";
$lang['mediumtextfield'] = "mED1uM +3xt PH1eld";
$lang['smalltextfield'] = "5m4ll T3X+ pHIelD";
$lang['multilinetextfield'] = "mUL+1liNE TExt ph1eld";
$lang['radiobuttons'] = "r4Di0 8U+tons";
$lang['dropdown'] = "drop D0Wn";
$lang['threadcount'] = "thR34d cOuNt";
$lang['fieldtypeexample1'] = "FoR r@d1o bU+ton5 @Nd DR0P d0wn fiELd5 j00 nEEd +O s3P3RA+3 +3h fI3lDn4ME @nd +eh V4lu3s wi+H 4 Colon @Nd e4ch V@lue shoulD B3 \$ep3r4+3d 8y \$3mi-colons.";
$lang['fieldtypeexample2'] = "Ex4mpl3: +0 CR34t3 4 B@\$1C g3ndeR R4di0 8uTt0nS, wIth +w0 \$ELEc+1oN\$ For M4le 4ND FeM4L3, J00 wOulD ENTer: <b>gend3R:m4lE;feM4LE</b> in tEH i+em n4m3 phi3LD.";
$lang['madethreadsticky'] = "M@d3 +hrE4D \$TIcky";
$lang['madethreadnonsticky'] = "MADe +hRE@d noN-5ticKy";

// Attachments (attachments.php, getattachment.php) ---------------------------------------

$lang['aidnotspecified'] = "41D n0t spEc1fied.";
$lang['upload'] = "uPlO4d";
$lang['waitdotdot'] = "w@1T..";
$lang['attachmentnospace'] = "SOrry, j00 dO Not H4V3 3nOUgh pHRe3 @+T@chmENt Sp@ce. plE45E FRe3 soM3 \$P4ce ANd +Ry @g4In.";
$lang['successfullyuploaded'] = "5uCCES\$phUllY UPl04dED";
$lang['uploadfailed'] = "UPlo4d f4iLEd";
$lang['errorfilesizeis0'] = "ERroR: fIlE51Ze MUst 83 9R3@T3R +H4n 0 by+3S";
$lang['complete'] = "C0MPL3TE";
$lang['uploadattachment'] = "UpLO4D @ f1L3 F0r 4+t@chMeNt +0 T3H mEsS@9E";
$lang['enterfilenametoupload'] = "En+er FIlen4M3 to UPlo@D";
$lang['nowpress'] = "N0W pr35S";
$lang['ifdoneattachingfiles'] = "if j00 4r3 Done @++@cH1N9 ph1L3(\$), pRE55";
$lang['attachmentsforthismessage'] = "@T+@ChmeNT5 For +h15 m3\$S@g3";
$lang['otherattachmentsincludingpm'] = "O+H3r ATt@chm3n+S (INcluD1ng Pm mE\$S4g3s)";
$lang['totalsize'] = "+Ot4l sizE";
$lang['freespace'] = "PHree \$p4ce";
$lang['attachmentproblem'] = "Th3R3 waS @ pRO8Lem doWNl0@d1ng +h1s @T+@chM3N+. pl3@S3 +ry @g@1N L@TeR.";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "pA55wOrd CH@n93d";
$lang['passedchangedexp'] = "Y0UR P4S5w0rD h45 83en chaN9ED.";
$lang['gotologin'] = "9o +o l09In scR33n";
$lang['updatefailed'] = "upd4t3 ph@iled";
$lang['passwdsdonotmatch'] = "P4\$Sw0rd5 D0 noT m4tCH.";
$lang['allfieldsrequired'] = "4LL fi3lDS ar3 REqu1r3d.";
$lang['invalidaccess'] = "iNValid 4ccES5";
$lang['requiredinformationnotfound'] = "R3QUIred INf0RM4t1ON N0+ FounD";
$lang['forgotpasswd'] = "F0r9O+ P4s5wOrd";
$lang['enternewpasswdforuser'] = "ent3r A New p45sw0rD phoR uS3r";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "no m3S\$4GE sp3c1phIED ph0R del3+ioN";
$lang['postdelsuccessfully'] = "p0St Del3teD 5uCC3sSFully";
$lang['errordelpost'] = "erRor D3le+1NG p0\$+";
$lang['delthismessage'] = "DEle+3 tH15 me\$\$ag3";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "no MeS\$@9e \$P3CipHiEd FOr edI+Ing";
$lang['edited_caps'] = "3dIT3d";
$lang['editappliedtomessage'] = "3d1t 4PPlIEd TO mE554gE";
$lang['editappliedtopoll'] = "ED1t 4ppL1ed +o POLl";
$lang['errorupdatingpost'] = "ERrOr upd4+iNG P05+";
$lang['editmessage'] = "3di+ Me\$\$a93";
$lang['edittext'] = "EdI+ t3x+";
$lang['editHTML'] = "3D1+ hTMl";
$lang['editpollwarning'] = "<b>note</b>: 3dITIn9 @nY 4\$Pec+ 0PH 4 p0lL w1lL v01D @LL t3h CUrr3N+ V0+e\$ @nd 4ll0W pe0ple tO vOt3 4941n.";
$lang['changewhenpollcloses'] = "Ch4ng3 wh3n +3h PolL Clo\$E5?";
$lang['nochange'] = "No cH@NGe";
$lang['emailresult'] = "3M41l ReSuL+";
$lang['msgsent'] = "m3s54g3 s3n+";
$lang['msgfail'] = "Ma1L Sy\$+3M F@1LURe. M3ss4Ge Not \$3n+.";
$lang['nopermissiontoedit'] = "J00 ARE n0+ peRm1++3D +0 3d1+ tHI\$ meS\$4g3.";
$lang['pollediterror'] = "J00 c@NnoT eDi+ p0LLS";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "n0 u\$Er 5P3cipH1ed Ph0R eM@1lIn9.";
$lang['entersubjectformessage'] = "3n+er a sUBjEc+ fOR tEh M3\$5A9E";
$lang['entercontentformessage'] = "enter Som3 c0n+en+ F0r +h3 me5S@93";
$lang['msgsentfrombeehiveforumby'] = "+hI5 me\$54G3 w45 S3n+ fr0M 4 833h1v3 ph0Rum BY";
$lang['subject'] = "\$U8JecT";
$lang['send'] = "S3Nd";
$lang['msgnotificationemail_1'] = "pO\$T3d a m3\$S4g3 +O J00 0n";
$lang['msgnotificationemail_2'] = "thE \$ubj3CT 1S";
$lang['msgnotificationemail_3'] = "+O re4d +h4+ mE\$549e 4nD 0thER5 in +H3 S@me D1scU\$5iOn, 9o +0";
$lang['msgnotificationemail_4'] = "n0TE: 1pH j00 d0 n0+ WISH +0 r3C31Ve 3m41L nOTific4+i0ns oph pH0rUM ME\$S@9es";
$lang['msgnotificationemail_5'] = "p05+3d t0 y0U, 9o t0";
$lang['msgnotificationemail_6'] = "cLicK";
$lang['msgnotificationemail_7'] = "0N prePheR3nc35, un\$elEc+ tHe 3M41l NoT1pHIc4T1on cHeck8ox 4nd pRe55 SUbmi+.";
$lang['msgnotification_subject'] = "m3S549E N0+1PHiC4+iOn fr0M";
$lang['subnotification_1'] = "po\$teD 4 m3\$54G3 1n 4 Thre@D j00";
$lang['subnotification_2'] = "h4V3 5ubSCrI8Ed +o 0n";
$lang['subnotification_3'] = "thE \$u8jec+ i5";
$lang['subnotification_4'] = "t0 re@d +H@+ mESS@9e 4nd 0+HEr5 1N +3h \$4me dI\$cu5\$IOn, 90 to";
$lang['subnotification_5'] = "n0TE: 1ph J00 d0 No+ w1sh +0 R3cEIve 3M@1l nOT1phic4+IOns oPH neW M3\$sAGe5";
$lang['subnotification_6'] = "iN Thi5 THRE4d, 9O +0";
$lang['subnotification_7'] = "4Nd @dJU\$T yoUR In+er3\$T Lev3L at +h3 end 0F +h3 P4gE.";
$lang['subnotification_subject'] = "\$ubscR1PT1on N0+1PHIcA+1oN phROm";
$lang['pmnotification_1'] = "pos+eD @ pm +o j00 0n";
$lang['pmnotification_2'] = "teH Su8J3c+ iS";
$lang['pmnotification_3'] = "T0 re4D +3H MEs\$4G3 g0 To";
$lang['pmnotification_4'] = "nO+3: 1ph J00 d0 n0+ W1sh +0 R3CEive 3M4IL n0+IF1caT1on\$ oPH pM mE55493\$";
$lang['pmnotification_5'] = "po\$t3D +0 y0u, g0 t0";
$lang['pmnotification_6'] = "CLick";
$lang['pmnotification_7'] = "On Preph3rENC35, uns3l3C+ th3 pm Em41L n0t1fic4+10n ch3ckBox 4ND pr35S subM1+.";
$lang['pmnotification_subject'] = "pm n0+1Fic4+I0n FRoM";

// Error handler (errorhandler.inc.php) --------------------------------

$lang['errorpleasewaitandretry'] = "@n err0r h4\$ OccUr3d. pl34se w@it 4 PHEW Minu+3s @nd tH3N cl1ck th3 reTrY Bu+t0N 83l0w.";
$lang['retry'] = "R3+ry";
$lang['multipleerroronpost'] = "+hIS errOR h4s oCCured mOR3 +h4N oncE while 4tt3MP+1n9 +0 Post/prev1ew yoUR M3SSA9e. phor YOur c0nvi3nienc3 w3 H@v3 1ncluded your M3ss4g3 +eXt 4nd IPh @pplic48le tHE thr3@d 4nd mESS49e nuMb3R J00 w3Re r3pLy1ng +0 b3L0w. J00 m4Y W15h to \$@v3 4 coPY of t3h teX+ 3l\$Ewh3r3 uNt1l ThE foruM i5 4vAIl48le 4g41N.";
$lang['replymsgnumber'] = "R3Ply M3Ss@93 nUMbeR";
$lang['errormsgfordevs'] = "3rr0r M3\$S@93 PHor SerVER adM1n5 4nd d3VEl0p3Rs";

// Forgotten passwords (forgot_pw.php) ---------------------------------

$lang['forgotpwemail_1'] = "j00 reQuesT3D tHi\$ E-m41l pHRom";
$lang['forgotpwemail_2'] = "b3c4uS3 J00 H@ve f0RGO++3N YOur p4\$\$w0rD.";
$lang['forgotpwemail_3'] = "cLICk th3 LINK b3L0W (0r cOpy 4ND p4\$t3 1+ Int0 y0uR 8rOws3R) to REsET y0uR p4ssword";
$lang['passwdresetrequest'] = "y0UR p@55woRD RE\$E+ r3Qu3ST";
$lang['passwdresetemailsent'] = "P4SSword rESEt e-M@il SEn+";
$lang['passwdresetexp_1'] = "J00 SH0ulD r3c3IV3 4N 3-mAIl cON+4INing";
$lang['passwdresetexp_2'] = "4 LiNK +o r353t YoUr P455W0rd \$H0Rtly.";
$lang['validusernamerequired'] = "4 V4liD usern4mE Is REQUireD";
$lang['forgotpasswd'] = "phor90t p4s5W0rd";
$lang['forgotpasswdexp_1'] = "eN+er yOUr L0gOn n4m3 48oVe anD @N Em41l Cont4in1n9 @ liNK 4lL0w1NG";
$lang['forgotpasswdexp_2'] = "J00 t0 CHaN93 your p4S5w0Rd wiLL 83 S3Nt +0 yOUr r39i\$+3reD 3M@1l 4DDr3\$s";
$lang['couldnotsendpasswordreminder'] = "c0UlD N0t s3nd p4\$sW0RD reM1nder. pl34s3 C0n+@cT the phoRum 0WNer.";
$lang['request'] = "REqu3sT";

// Frameset things (index.php) -----------------------------------------

$lang['noframessupport'] = "OOP\$, y0ur 8RowSeR S4Ys IT D035n'+ suPP0rT phr4me\$";
$lang['uselightversion'] = "j00 nE3d +o USe +eH LighT htML veR\$I0n 0pH Th3 FORUM <a href=\"llogon.php\">H3r3</a>.";

// Links database (links*.php) -----------------------------------------

$lang['maynotaccessthissection'] = "J00 M@Y n0T 4ccEs\$ +H15 \$EC+10n.";
$lang['toplevel'] = "Top L3veL";
$lang['links'] = "L1nk\$";
$lang['viewmode'] = "V13W mOd3";
$lang['hierarchical'] = "h1Er4rch1C4L";
$lang['list'] = "l15+";
$lang['folderhidden'] = "tHi5 FOld3r 1s h1dd3n";
$lang['hide'] = "h1De";
$lang['unhide'] = "uNHid3";
$lang['nosubfolders'] = "N0 subFolDeRs 1n +h1\$ c4tE90RY";
$lang['1subfolder'] = "1 Su8phOLD3r 1n THIS c4+390Ry";
$lang['subfoldersinthiscategory'] = "sUbFoldeRS 1n +h1s c@Teg0rY";
$lang['linksdelexp'] = "3ntr1E\$ 1N @ deLEteD fOLder w1LL 83 mOV3d t0 Teh pAR3N+ fOLd3r. 0Nly f0ld3r\$ WH1cH D0 n0+ coN+@In su8folders M4y 83 d3LET3d.";
$lang['listview'] = "L1\$+ V1ew";
$lang['listviewcannotaddfolders'] = "C4NN0t 4dd PH0ld3r\$ 1n +h1\$ Vi3w. sh0w1ng 20 Entr135 4t @ t1m3.";
$lang['rating'] = "r4+iN9";
$lang['commentsslashvote'] = "COmmeN+s / vo+E";
$lang['nolinksinfolder'] = "n0 linKS in +H1s pH0lDER.";
$lang['addlinkhere'] = "4Dd l1Nk h3rE";
$lang['notvalidURI'] = "TH4+ 1\$ nOT 4 val1d ur1!";
$lang['mustspecifyname'] = "J00 mu\$T 5P3c1fY a n4m3!";
$lang['mustspecifyvalidfolder'] = "J00 mu\$+ sp3c1Phy @ V@lid FOLder!";
$lang['mustspecifyfolder'] = "j00 mu5+ sPecIPhy 4 PHolD3R!";
$lang['addlink'] = "Add 4 l1NK";
$lang['addinglinkin'] = "4dDING liNk 1N";
$lang['addressurluri'] = "@dDr3\$S (urL/uR1)";
$lang['addnewfolder'] = "4dD 4 new pholDer";
$lang['addnewfolderunder'] = "ADDiN9 n3w pHOlDEr uNd3r";
$lang['mustchooserating'] = "j00 mUS+ cHOo\$E 4 R4TIn9!";
$lang['commentadded'] = "Y0uR cOMm3nT w4S adDED.";
$lang['musttypecomment'] = "j00 muS+ tyPE 4 cOMmen+!";
$lang['mustprovidelinkID'] = "J00 mus+ provIDe @ l1nk 1d!";
$lang['invalidlinkID'] = "1Nv4lid l1nK 1d!";
$lang['address'] = "4DdR3S\$";
$lang['submittedby'] = "SUBM1+t3d 8Y";
$lang['clicks'] = "Cl1cK5";
$lang['rating'] = "r@ting";
$lang['vote'] = "vO+3";
$lang['votes'] = "voT3s";
$lang['notratedyet'] = "nO+ R@+ed 8y 4nyon3 ye+";
$lang['rate'] = "r4+3";
$lang['bad'] = "b@D";
$lang['good'] = "9oOD";
$lang['voteexcmark'] = "vOt3!";
$lang['commentby'] = "c0MmENt 8y";
$lang['nocommentsposted'] = "No Comm3nT5 h@v3 yet 833n p05+ED.";
$lang['addacommentabout'] = "4DD 4 c0mmeN+ 4bou+";
$lang['modtools'] = "moder4+10n t0Ol\$";
$lang['editname'] = "3dIT n4M3";
$lang['editaddress'] = "ED1t 4DdreS5";
$lang['editdescription'] = "eD1+ dESCr1p+1ON";
$lang['moveto'] = "M0v3 T0";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "u53r id";
$lang['alreadyloggedin'] = "4LR34dY L0g93d in";
$lang['loggedinsuccessfully'] = "J00 l0G93d 1n SUcc355fULly.";
$lang['usernameorpasswdnotvalid'] = "+Eh useRN@mE or PA5sword j00 5uPpLiEd i5 No+ VAL1d.";
$lang['usernameandpasswdrequired'] = "A u\$3rN4mE aND p@s\$W0rD i\$ r3qUIR3d";
$lang['welcometolight'] = "welc0me to DIet 833hIV3!";
$lang['pleasereenterpasswd'] = "pl3as3 re3n+er yOUr p4\$\$WOrd 4nD TRy @94in.";
$lang['rememberpasswds'] = "r3M3M83R p@\$\$W0rd5";
$lang['enterasa'] = "EN+3r 4S 4";
$lang['donthaveanaccount'] = "don'+ h4ve 4N 4ccoUN+?";
$lang['problemsloggingon'] = "pr08leM5 l0g9iN9 oN?";
$lang['deletecookies'] = "D3L3+E cOOkies";
$lang['forgottenpasswd'] = "Phor9OTT3N youR p@5sw0rd?";
$lang['usingaPDA'] = "u\$1Ng 4 PD@?";
$lang['lightHTMLversion'] = "l19h+ H+ML v3R51ON";
$lang['youhaveloggedout'] = "j00 h4Ve L0g93d 0ut.";
$lang['currentlyloggedinas'] = "j00 4Re cuRR3NTlY loggED 1n 45";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "Po5+ m3\$s49e";
$lang['selectfolder'] = "53LeC+ fOlD3R";
$lang['messagecontainsHTML'] = "mEss@93 C0nt4IN5 htML";
$lang['notincludingsignature'] = "(n0t 1ncLUdinG 5i9N4turE)";
$lang['mustenterpostcontent'] = "J00 mu5t EN+er \$0M3 con+3nt ph0r thE PO5+!";
$lang['messagepreview'] = "me5\$493 prevIEW";
$lang['invalidusername'] = "INv4lid U\$erN4mE!";
$lang['mustenterthreadtitle'] = "j00 muS+ 3n+er @ tiTL3 ph0R +HE +hr3@D!";
$lang['pleaseselectfolder'] = "PlE453 \$elec+ 4 phoLDEr!";
$lang['errorcreatingpost'] = "3RR0R cr3a+INg Post! pl34\$3 +ry 4gAIN in 4 pH3w m1nUT3s.";
$lang['createnewthread'] = "Cr34tE neW +hre@D";
$lang['postreply'] = "p05+ r3Ply";
$lang['threadtitle'] = "+hr34D T1+L3";
$lang['messagehasbeendeleted'] = "mE\$\$@9E h4\$ 8een d3LE+3d.";
$lang['converttoHTML'] = "c0nv3rT +0 hTml";
$lang['pleaseentermembername'] = "pl3@\$3 3N+er @ M3MB3rn@M3:";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c@nnO+ PO\$T th1S +hre4d TYpe IN th4+ ph0LDER!";
$lang['cannotpostthisthreadtype'] = "J00 C@nnOT P05t tH1S thrE4d Typ3 4S +hEre @re N0 4V41l@Bl3 Phold3R\$ +h@t @ll0w IT.";
$lang['threadisclosedforposting'] = "+H15 +hR3@D is cl0\$eD, J00 c4nNO+ PO5t 1n I+!";
$lang['moderatorthreadclosed'] = "w@rn1NG: tH1\$ tHReaD iS cL05ED ph0r p05tINg T0 NorMAl u5ER\$.";
$lang['threadclosed'] = "+hRe4d Cl0SED";
$lang['usersinthread'] = "U\$3r\$ iN +hrE@d";
$lang['correctedcode'] = "CoRR3ctED cod3";
$lang['submittedcode'] = "SUbm1++3D C0dE";
$lang['htmlinmessage'] = "h+Ml in M3s\$49e";
$lang['enabledwithautolinebreaks'] = "3NA8L3d WIth 4Uto-l1n38RE@k\$";
$lang['fixhtmlexplanation'] = "+H1\$ foruM u\$eS hTML ph1l+eRIN9. y0ur 5ubmiTt3d h+ml H4S B33n m0dipHIED 8Y TH3 f1lt3R5 1N \$0m3 w@y.\\N\\n+0 v1ew your 0r1g1nal c0d3, s3L3cT +3h \\'\$u8mi+t3D c0d3\\' R4di0 bU+t0n.\\NTO v13w tEH mOdiph13d c0d3, S3lEct tH3 \\'cOrrECTEd code\\' R@Di0 BUT+0N.";
$lang['messageoptions'] = "meSS@g3 0p+ION\$";
$lang['notallowedembedattachmentpost'] = "J00 4Re nOT allOWed tO emB3d 4++4chMen+\$ 1n Y0ur P0\$tS.";
$lang['notallowedembedattachmentsignature'] = "J00 @R3 No+ 4ll0weD to 3m8ED @tTACHMen+S 1n YOur 519N4tur3.";

// Message display (messages.php) --------------------------------------

$lang['inreplyto'] = "in r3Ply +O";
$lang['showmessages'] = "\$H0W meS\$4gE\$";
$lang['ratemyinterest'] = "RaTE my INTeR3\$t";
$lang['adjtextsize'] = "4dJu5t +3xT 51z3";
$lang['smaller'] = "Sm4Ller";
$lang['larger'] = "L@rger";
$lang['faq'] = "FAq";
$lang['docs'] = "D0C\$";
$lang['support'] = "supp0RT";
$lang['threadcouldnotbefound'] = "+eh r3Qu35+Ed tHR34d C0uLd n0+ b3 PH0unD 0R 4CC355 w4\$ DEn13d.";
$lang['mustselectpolloption'] = "J00 MUs+ s3l3CT @n 0PTion +o voTE foR!";
$lang['keepreading'] = "k33p r34dIn9";
$lang['backtothreadlist'] = "8@CK +o +hr34d l1\$T";
$lang['postdoesnotexist'] = "th4+ p05t D035 nOT 3xis+ iN tHiS +hr34D!";
$lang['clicktochangevote'] = "cl1ck +0 Ch@n93 v0T3";
$lang['youvotedforoption'] = "j00 vo+ed For 0p+i0N";
$lang['youvotedforoptions'] = "J00 vo+ED ph0R 0pt10ns";
$lang['clicktovote'] = "cLick +o v0te";
$lang['youhavenotvoted'] = "j00 h@vE not v0+Ed";
$lang['viewresults'] = "v1Ew resUL+s";
$lang['msgtruncated'] = "ME\$s4ge TruNc4+3D";
$lang['viewfullmsg'] = "view Phull Mes\$4G3";
$lang['ignoredmsg'] = "iGnOR3d me5S@9e";
$lang['wormeduser'] = "w0Rm3d uS3r";
$lang['ignoredsig'] = "I9N0ReD siGn4Tur3";
$lang['wasdeleted'] = "W4\$ dElE+3d";
$lang['stopignoringthisuser'] = "st0P 1GN0r1n9 tHIs u53R";
$lang['renamethread'] = "REn4ME thR3@D";
$lang['movethread'] = "m0ve +HR34d";
$lang['editthepoll'] = "ed1+ +h3 p0lL";
$lang['torenamethisthread'] = "+0 ren@Me thiS thrE4d";
$lang['reopenforposting'] = "RE0p3n foR p0s+1n9";
$lang['closeforposting'] = "clOS3 F0R p0S+in9";
$lang['makesticky'] = "M4k3 ST1cky";
$lang['makenonsticky'] = "m4ke Non-\$+1ckY";
$lang['until'] = "uN+1l 00:00 uTC";
$lang['stickyuntil'] = "ST1ckY uNT1l";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "\$+4r+";
$lang['messages'] = "M3\$sAG3S";
$lang['pminbox'] = "pm in8oX";
$lang['pmsentitems'] = "Sent 1+3m5";
$lang['pmoutbox'] = "outb0x";
$lang['pmsaveditems'] = "\$@vEd 1+3M5";
$lang['links'] = "LInk\$";
$lang['preferences'] = "PR3f3r3Nces";
$lang['profile'] = "PROF1l3";
$lang['admin'] = "Adm1n";
$lang['login'] = "L091N";
$lang['logout'] = "L090u+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------
$lang['privatemessages'] = "pRIV@tE m3s\$4935";
$lang['addrecipient'] = "@dD reciP13n+";
$lang['recipienttiptext'] = "\$Epera+3 rec1p13nt5 8y S3MI-coloN 0R c0mm4";
$lang['maximumtenrecipientspermessage'] = "th3re 15 @ l1M1+ 0F 10 r3CiPI3nt5 per m3\$s4g3. pLe45e 4MmEND your ReciP13n+ L1sT.";
$lang['mustspecifyrecipient'] = "J00 mu5t 5pecIfY At l345T 0n3 reCIp1enT.";
$lang['usernotfound1'] = "useR";
$lang['usernotfound2'] = "nOt fouND.";
$lang['sendnewpm'] = "53nd n3w pM";
$lang['savemessage'] = "\$4VE M3ssAGE";
$lang['sentby'] = "\$3N+ By";
$lang['timesent'] = "t1ME \$eNt";
$lang['nomessages'] = "N0 mESs@g35";
$lang['errorcreatingpm'] = "ERR0R cR34ting pm! ple4se try 4941n In 4 few minu+3\$";
$lang['writepm'] = "wrI+E mE5\$@93";
$lang['editpm'] = "ED1+ Me5\$49E";
$lang['cannoteditpm'] = "c@nn0t ed1t +H1\$ pM. 1+ h4\$ @Lre4dy 8een v13w3d 8Y +hE reciPieN+ 0r +3h m35\$4gE dOes n0t ex1St or 1t I5 1N4CCE5s18le 8Y J00";
$lang['cannotviewpm'] = "C4NNO+ v13w pm. m3\$S@g3 d0e5 no+ eXIS+ 0r 1+ is 1n4ccess18l3 8Y j00";
$lang['nomessagespecifiedforreply'] = "n0 M3SS@9e 5peC1ph13D phoR r3plY +0";
$lang['nouserspecified'] = "nO U\$3r SpeCiphiEd.";

// Preferences (prefs.php) ---------------------------------------------
$lang['newpasswd'] = "neW p45sWORD";
$lang['confirmpasswd'] = "c0Nf1rm p45\$word";
$lang['passwdsdonotmatch'] = "P45\$W0RD\$ d0 N0t m@tCH!";
$lang['nicknamerequired'] = "NICKN4m3 15 rEQU1r3d!";
$lang['emailaddressrequired'] = "EMAIl 4DDre55 1\$ rEquir3D!";
$lang['jan'] = "J4NU@ry";
$lang['feb'] = "PHebrU4RY";
$lang['mar'] = "M4RCH";
$lang['apr'] = "@Pril";
$lang['may'] = "M@Y";
$lang['jun'] = "jUn3";
$lang['jul'] = "juLY";
$lang['aug'] = "4u9U\$+";
$lang['sep'] = "\$EP+3m83r";
$lang['oct'] = "0C+OB3r";
$lang['nov'] = "N0VEmb3R";
$lang['dec'] = "DEc3m83r";
$lang['userpreferences'] = "US3R prepherenc3s";
$lang['preferencesupdated'] = "pREph3REnc3\$ wEr3 suCce5sFULlY upDAtEd.";
$lang['leaveblanktoretaincurrentpasswd'] = "l3@v3 BLaNk t0 rE+4In curr3nt p@ssw0Rd";
$lang['firstname'] = "fIRs+ nAme";
$lang['lastname'] = "L4S+ n4m3";
$lang['dateofbirth'] = "d4+E Of b1rTH";
$lang['homepageURL'] = "h0mEP49e uRl";
$lang['pictureURL'] = "PiCtur3 URl";
$lang['forumoptions'] = "PHoRum 0PT10nS";
$lang['notifybyemail'] = "n0+1phy By em4IL oph P0\$TS +0 ME";
$lang['notifyofnewpm'] = "NO+1Phy 8Y PoPup oF neW pm mE\$\$4g3\$ T0 Me";
$lang['notifyofnewpmemail'] = "N0+1pHY 8Y 3m41L 0f N3w Pm m3s\$4G35 +0 me";
$lang['daylightsaving'] = "aDJU5t pH0r d@ylIGht 54viN9";
$lang['autohighinterest'] = "4U+om4+1C@lLy mARk +HRe4d\$ i P0\$+ IN @\$ h1gh inTere5+";
$lang['globallyignoresigs'] = "GLO8allY ignOR3 us3r s1GN4TuR3s";
$lang['timezonefromGMT'] = "+ImeZOne";
$lang['postsperpage'] = "pO5+\$ peR p49e";
$lang['fontsize'] = "pHon+ 51z3";
$lang['forumstyle'] = "Ph0ruM 5TYl3";
$lang['startpage'] = "s+4RT P4GE";
$lang['containsHTML'] = "C0N+41ns hTML";
$lang['preferredlang'] = "PrEF3RR3d lanGU4ge";
$lang['ageanddob'] = "4ge 4nd d4+3 Oph 8ir+h";
$lang['neitheragenordob'] = "DO no+ SH0w +O 0+her5";
$lang['showonlyage'] = "shOw 0nly @93 T0 O+h3rs";
$lang['showageanddob'] = "\$how to 0theRs";
$lang['browseanonymously'] = "8r0W\$e PHoruM 4n0NYMOuSly";
$lang['showforumstats'] = "5h0w ph0rum st4+\$ 4+ 8OT+0m 0f me\$s493 p@n3";

// Polls (create_poll.php, pollresults.php) ---------------------------------------------

$lang['mustenterpollquestion'] = "J00 must 3n+3R @ poLl quESt10n";
$lang['groupcountmustbelessthananswercount'] = "Numb3r 0F 4n5W3r 9roUpS mUS+ be lE5\$ TH@n t0TAL NUMb3r oF 4Nswer\$";
$lang['pleaseselectfolder'] = "ple@se \$Elect 4 PholD3r";
$lang['mustspecifyvalues1and2'] = "J00 mu\$+ sP3cify V4lues phOR 4nsWERS 1 4ND 2";
$lang['cannotcreatemultivotepublicballot'] = "J00 c4nnot cR34t3 mult1-votE public 84lLO+S. puBlic b@lloT5 reQUIr3 T3h u53 0PH VO+3 Lo99in9 to woRk.";
$lang['abletochangevote'] = "J00 wilL 83 @8l3 tO ch@n9e Your votE.";
$lang['abletovotemultiple'] = "J00 w1lL 8E 4bl3 to vot3 MuL+iPle T1m3\$.";
$lang['notabletochangevote'] = "j00 wIll n0T 8E @8le to ch4N93 youR v0+3.";
$lang['pollvotesrandom'] = "N0+E: polL vot3S 4R3 r4nDOmLY geneR@t3d PH0r pR3v1eW 0nly.";
$lang['pollquestion'] = "p0lL qu35+1on";
$lang['possibleanswers'] = "p05\$ibLe @nSWErS";
$lang['enterpollquestionexp'] = "EnTEr +eH 4n\$wER\$ FOR yoUR p0LL QU3stion.. If y0UR polL i5 4 \"yes/no\" QUE\$+ioN, \$1mPlY 3NTER \"yE5\" pHoR 4nSW3R 1 4nD \"N0\" fOR 4N5Wer 2.";
$lang['numberanswers'] = "No. 4nswerS";
$lang['answerscontainHTML'] = "4nSwer5 CON+@in Html (n0t 1Nclud1Ng \$ign4turE)";
$lang['votechanging'] = "v0te Chan9iN9";
$lang['votechangingexp'] = "c4N 4 P3rson CH4ng3 hiS 0r her v0t3?";
$lang['allowmultiplevotes'] = "4lLOW mult1pLE v0+e5";
$lang['pollresults'] = "POll rEsult5";
$lang['pollresultsexp'] = "H0w w0ULD j00 lIK3 +0 d15pL@y +h3 ResuL+\$ 0f YOUR poLL?";
$lang['pollvotetype'] = "PoLL v0tIn9 +ypE";
$lang['pollvotesexp'] = "hoW \$h0ulD +eH poLl 83 C0nduC+3d?";
$lang['pollvoteanon'] = "4NoNYmoUSlY";
$lang['pollvotepub'] = "Pu8Lic 84LL0t";
$lang['pollresultnote'] = "<b>No+E:</b> CHO0s1ng 'pu8l1C B@llOT' wILL Over1DE TH3 p0lL r3\$ul+ TyP3.";
$lang['horizgraph'] = "h0r1Z0N+@l 9r4PH";
$lang['vertgraph'] = "VEr+IcAL Gr@PH";
$lang['publicviewable'] = "PuBl1C bAllo+";
$lang['polltypewarning'] = "<b>warNing</b>: +hiS 1s 4 pubLIC b4lLOt. youR n@mE w1ll 8e v1SiBl3 nEX+ t0 +eH oP+i0N j00 V0T3 ph0R.";
$lang['expiration'] = "ExPir4+10n";
$lang['showresultswhileopen'] = "D0 j00 W4nT +0 5hoW re5uL+\$ whILE t3H poLl 15 0peN?";
$lang['whenlikepollclose'] = "WHen w0uld J00 l1K3 y0ur poll +O Autom@TIC4lly clos3?";
$lang['oneday'] = "0n3 d@y";
$lang['threedays'] = "tHR3E daYS";
$lang['sevendays'] = "SeVEN d4yS";
$lang['thirtydays'] = "tHirty d@y\$";
$lang['never'] = "NeV3r";
$lang['polladditionalmessage'] = "4Dd1+I0n@l m3s\$4gE (0Pt10n@L)";
$lang['polladditionalmessageexp'] = "D0 j00 w@n+ +0 inCludE 4N 4ddIT1on@L po\$+ @phTEr +h3 P0ll?";
$lang['mustspecifypolltoview'] = "J00 mu\$t \$PECIFY 4 pOLL t0 V1ew.";
$lang['pollconfirmclose'] = "4rE j00 SURe j00 w@NT T0 cl053 +he phOll0w1n9 p0ll?";
$lang['endpoll'] = "3ND pOll";
$lang['nobodyvoted'] = "noB0dY vO+ED.";
$lang['nobodyhasvoted'] = "N0bODY H@s v0t3D.";
$lang['1personvoted'] = "1 p3Rs0n vo+3d.";
$lang['1personhasvoted'] = "1 P3r\$On H@s v0+ED.";
$lang['peoplevoted'] = "p3oPle v0+3d.";
$lang['peoplehavevoted'] = "P30Pl3 h@V3 v0+ED.";
$lang['pollhasended'] = "PoLL H4s 3ndEd";
$lang['youvotedfor'] = "j00 v0+ed For";
$lang['thisisapoll'] = "th1\$ is 4 PolL. CL1CK +o V1ew rE5UL+S.";
$lang['editpoll'] = "3dIT POLl";
$lang['results'] = "Re\$ul+\$";
$lang['resultdetails'] = "r3sulT d3+41L\$";
$lang['changevote'] = "cH@n93 VO+3";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "EdIT pr0PH1le";
$lang['profileupdated'] = "PROf1Le UPD4t3d.";
$lang['profilesnotsetup'] = "+h3 phORum own3r H4s n0T set Up pr0FILe\$.";
$lang['nouserspecified'] = "n0 user sp3c1pHi3d";
$lang['ignoreduser'] = "IgNOReD U\$3r";
$lang['lastvisit'] = "L4\$+ vI\$1+";
$lang['sendemail'] = "\$End 3m4il";
$lang['sendpm'] = "53Nd PM";
$lang['removefromfriends'] = "REmoV3 pHR0m fR1ENDS";
$lang['addtofriends'] = "4dD t0 phriENd5";
$lang['stopignoringuser'] = "stop 1gnorIn9 u\$er";
$lang['ignorethisuser'] = "19n0rE thIS u\$er";
$lang['age'] = "493";
$lang['aged'] = "AgEd";
$lang['birthday'] = "Bir+hdAy";
$lang['editmyattachments'] = "EDi+ my @tt4cHMEN+5";

// Registration (register.php) -----------------------------------------

$lang['usernamemustnotcontainHTML'] = "u\$3rn@M3 mU\$t NOt cON+@iN h+mL t4g5";
$lang['usernameinvalidchars'] = "UseRN4me C@n onlY con+41N @-z, 0-9, _ - ch4r@c+3r\$";
$lang['usernametooshort'] = "UsERn@ME Mu\$T B3 @ mIn1mUM oph 2 ch@r4cTeR\$ Lon9";
$lang['usernametoolong'] = "UsernAme MUST 83 4 m4XIMUm of 15 cH4r@cTEr\$ lON9";
$lang['usernamerequired'] = "4 Lo9oN n4M3 1s reQU1reD";
$lang['passwdmustnotcontainHTML'] = "P4SsWOrd musT N0T Cont@iN H+ml t49s";
$lang['passwdtooshort'] = "p4S5W0Rd MuS+ 83 @ M1n1mUM OPh 6 CH4R4c+3rs Lon9";
$lang['passwdrequired'] = "@ P4\$sW0rd I\$ rEqu1r3d";
$lang['confirmationpasswdrequired'] = "@ C0Nf1rM4tiON p4s\$wORd 1s r3QU1r3d";
$lang['nicknamemustnotcontainHTML'] = "nIckn4m3 Mus+ n0t Cont@IN h+ml T49\$";
$lang['nicknamerequired'] = "4 NICKN4m3 15 r3qUIreD";
$lang['emailmustnotcontainHTML'] = "EM41l mUST no+ conT4in htmL T@gs";
$lang['emailrequired'] = "4N 3m@iL 4ddRE5\$ 1s R3qU1r3d";
$lang['passwdsdonotmatch'] = "P@S5WoRd5 D0 N0+ m@+ch";
$lang['usernamesameaspasswd'] = "u\$3RN4m3 4ND P4\$swOrD mu5t 8E difF3R3n+";
$lang['usernameexists'] = "5OrrY, @ uS3r wI+h +h@T n4mE 4lrE4Dy Ex1s+s";
$lang['userrecordcreated'] = "Huzz4H! YOur u5er REcORd h4\$ B3EN cre4t3d 5UCC3\$sPHully!";
$lang['errorcreatinguserrecord'] = "ERr0r CRE4TiNg u\$er Record";
$lang['userregistration'] = "US3r re9i\$tR@+I0n";
$lang['registrationinformationrequired'] = "RE9istR@Ti0N iNpH0rm4+10N (r3QUIred)";
$lang['profileinformationoptional'] = "prOPh1L3 1NF0RM@tiOn (0p+i0N4L)";
$lang['preferencesoptional'] = "PReph3reNCes (0Pt1on4l)";
$lang['register'] = "re9istEr";
$lang['rememberpasswd'] = "reMEM83r p@\$sWord";
$lang['birthdayrequired'] = "Y0UR d@Te oPH b1R+h 1\$ r3QU1Red Or 15 1NV4lid";
$lang['alwaysnotifymeofrepliestome'] = "NotifY on R3Ply +0 M3";
$lang['notifyonnewprivatemessage'] = "N0T1phy on n3w pr1V4t3 me\$S493";
$lang['popuponnewprivatemessage'] = "pOP UP On new pr1vAT3 M3\$s493";
$lang['automatichighinterestonpost'] = "4U+OM4+ic h19h 1nt3REsT ON poS+";
$lang['itemsmarkedwithaasterixarerequired'] = "ItEMS M@rkEd witH @ * 4re r3QuiR3d";
$lang['confirmpassword'] = "ConpHIRM p4s\$woRd";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "M3MB3R";
$lang['searchforusernotinlist'] = "\$e4rcH FOr 4 U\$Er n0T in l1sT";
$lang['yoursearchdidnotreturnanymatches'] = "YoUr sE@rch d1d Not R3tuRn 4Ny M4+ch3s. try \$IMpLiphYInG Your S34rcH p4r@m3ter5 4nd try 49@1n.";

// Relationships (user_rel.php) ----------------------------------------

$lang['userrelationship'] = "u\$er R3l@t1Onsh1p";
$lang['relationship'] = "r3l@+ioN5HIP";
$lang['friend_exp'] = "uS3R'S P0\$TS m4Rk3d W1TH 4 &QU0T;fr1eNd&Qu0t; ic0n.";
$lang['normal_exp'] = "u\$er's PoS+S 4pp34R aS N0rM4L.";
$lang['ignore_exp'] = "u53r'\$ p0\$+5 @Re HiddeN.";
$lang['display'] = "DiSpL4y";
$lang['displaysig_exp'] = "U5eR'S \$ign@tURE 1s Di\$pL4yeD ON theIr p05ts.";
$lang['hidesig_exp'] = "u\$Er'S \$Igna+urE I5 hiddEN 0N TH31r P0\$+s.";
$lang['globallyignored'] = "GlOb4llY IGnorED";
$lang['globallyignoredsig_exp'] = "nO si9N4+URES 4r3 Displ4YED.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s3ARch r3Sul+s";
$lang['usernamenotfound'] = "t3H u53Rn4m3 J00 spECiph1ed iN +H3 +o 0r pHR0M fIEld wAS n0+ FOund.";
$lang['notexttosearchfor_1'] = "J00 did n0T SPEcIpHY 4ny w0rd5 to s34RCh foR or t3h Word\$ WER3 UNder";
$lang['notexttosearchfor_2'] = "Ch4R4c+ERS loNG";
$lang['foundzeromatches'] = "PH0und: 0 m@tCh3s";
$lang['found'] = "phOUND";
$lang['matches'] = "M4tCHeS";
$lang['prevpage'] = "PR3vIOUs P4ge";
$lang['findmore'] = "PhIND Mor3";
$lang['searchmessages'] = "5E4RcH M3s\$A9e\$";
$lang['searchdiscussions'] = "s34rch di\$Cus\$i0N\$";
$lang['containingallwords'] = "c0nt41n1Ng 4ll of tH3 woRD\$";
$lang['containinganywords'] = "COn+@in1ng 4nY OF +3h W0rdS";
$lang['containingexactphrase'] = "C0N+41ning +hE Ex4cT phr4S3";
$lang['find'] = "phind";
$lang['wordsshorterthan_1'] = "w0RD5 \$h0rtEr tH4n";
$lang['wordsshorterthan_2'] = "ch@r@c+3Rs wiLl n0+ 83 1NCLuD3d";
$lang['additionalcriteria'] = "AdD1T10n@l cRi+3RI@";
$lang['folderbrackets_s'] = "pH0ld3R(5)";
$lang['postedfrom'] = "P05+ed pHrom";
$lang['postedto'] = "pOs+eD +0";
$lang['today'] = "tOd@y";
$lang['yesterday'] = "Y3sT3Rd4y";
$lang['daybeforeyesterday'] = "D@Y 8ephOre yESteRD4Y";
$lang['weekago'] = "w3Ek @90";
$lang['weeksago'] = "wE3Ks 4g0";
$lang['monthago'] = "M0N+h @90";
$lang['monthsago'] = "M0n+h\$ @g0";
$lang['yearago'] = "Y34R 4GO";
$lang['beginningoftime'] = "83GInNiNg oPH +IMe";
$lang['now'] = "noW";
$lang['relevance'] = "r3l3V4nc3";
$lang['newestfirst'] = "NEw3s+ FirS+";
$lang['oldestfirst'] = "oLD3st PHirs+";
$lang['onlyshowmessagestoorfromme'] = "0nly \$HoW me\$5493s +0 0r From me";
$lang['groupsresultsbythread'] = "9rouP R3Sul+\$ 8Y +hR34D";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rEcEnt +hRE4ds";
$lang['startreading'] = "st4rt r34D1n9";
$lang['threadoptions'] = "THRE4D op+IOns";
$lang['showmorevisitors'] = "5how M0R3 v1sI+oR\$";
$lang['forthcomingbirthdays'] = "PH0rthc0m1ng 8IRThd@y\$";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "NEW di5CUSs10N";
$lang['createpoll'] = "CReAte p0ll";
$lang['search'] = "\$34RCH";
$lang['alldiscussions'] = "@ll d1SCU5\$1on\$";
$lang['unreaddiscussions'] = "UnRe4d d15cu\$s10n\$";
$lang['unreadtome'] = "uNR34d &qu0t;+0: me&qu0+;";
$lang['todaysdiscussions'] = "tOd@Y'S DIscu\$S10ns";
$lang['2daysback'] = "2 D@y5 84ck";
$lang['7daysback'] = "7 d@ys 8ACK";
$lang['highinterest'] = "hI9H in+Er3st";
$lang['unreadhighinterest'] = "Unr34d h1Gh 1n+EResT";
$lang['iverecentlyseen'] = "i've RECENtly s33N";
$lang['iveignored'] = "i'vE 1GnoR3D";
$lang['ivesubscribedto'] = "1'Ve \$UBscr18Ed +o";
$lang['startedbyfriend'] = "st@Rt3d 8Y frienD";
$lang['unreadstartedbyfriend'] = "UNre@d s+d 8y pHrieND";
$lang['goexcmark'] = "90!";
$lang['folderinterest'] = "pHOlder In+3rEST";
$lang['postnew'] = "p0ST n3W";
$lang['currentthread'] = "cUrr3nt +hrE4d";
$lang['highinterest'] = "hiGh 1n+er3\$+";
$lang['markasread'] = "M4rk 4s rE4d";
$lang['next50discussions'] = "neXT 50 DISCU\$\$I0ns";
$lang['visiblediscussions'] = "Vi\$iblE d1\$cusS10n\$";
$lang['navigate'] = "n4VI9a+3";
$lang['couldnotretrievefolderinformation'] = "th3R3 4re n0 fOLDeRS av4il4bl3.";
$lang['nomessagesinthiscategory'] = "n0 MESs@9es in +his c4T3GOry. PLE4\$3 5Elect @no+h3r, 0r";
$lang['clickhere'] = "CL1ck h3rE";
$lang['forallthreads'] = "phor 4LL thr34dS";
$lang['prev50threads'] = "pR3vi0us 50 thR34D5";
$lang['next50threads'] = "n3X+ 50 thr34dS";
$lang['startedby'] = "5t4RtED 8y";
$lang['unreadthread'] = "uNRE4d THR34d";
$lang['readthread'] = "R3@d thre4D";
$lang['unreadmessages'] = "UNread M3s54G3s";
$lang['subscribed'] = "sUbscr18ED";
$lang['ignorethisfolder'] = "i9nore +HI\$ phOLDEr";
$lang['stopignoringthisfolder'] = "\$+0p 19noriNG +H15 f0lder";
$lang['stickythreads'] = "5T1Cky +hrE4ds";
$lang['mostunreadposts'] = "MoS+ Unr3@D p0s+\$";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "B0LD";
$lang['italic'] = "1T@l1c";
$lang['underline'] = "uNd3Rline";
$lang['strikethrough'] = "sTR1KE+hr0u9H";
$lang['superscript'] = "suPERSCr1PT";
$lang['subscript'] = "\$u8sCRIPT";
$lang['leftalign'] = "L3F+-4liGn";
$lang['center'] = "CeNTer";
$lang['rightalign'] = "ri9h+-@lI9n";
$lang['numberedlist'] = "nUmBered L1st";
$lang['list'] = "lI\$+";
$lang['indenttext'] = "INd3nt t3x+";
$lang['code'] = "C0de";
$lang['quote'] = "QuOT3";
$lang['horizontalrule'] = "h0r1z0n+@l RUL3";
$lang['image'] = "im4g3";
$lang['hyperlink'] = "HyP3rLInk";
$lang['fontface'] = "F0Nt f4c3";
$lang['size'] = "5iZe";
$lang['colour'] = "CoL0ur";
$lang['red'] = "R3D";
$lang['orange'] = "0r@n9e";
$lang['yellow'] = "YEll0w";
$lang['green'] = "gr33n";
$lang['blue'] = "8LU3";
$lang['indigo'] = "1Nd1Go";
$lang['violet'] = "Vi0L3T";
$lang['white'] = "wh1+3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0Rum 5t@ts";
$lang['guests'] = "9u3s+s";
$lang['members'] = "M3mbER\$";
$lang['anonymousmembers'] = "4N0NYM0u\$ mEMb3r5";
$lang['viewcompletelist'] = "VIew COMPL3t3 lI5+";
$lang['ourmembershavemadeatotalof'] = "0ur m3Mbers H4v3 M4d3 4 +o+4l 0ph";
$lang['threadsand'] = "+hre4d\$ @nd";
$lang['postslowercase'] = "POs+s";
$lang['longestthreadis'] = "Longe5t +Hr3@d 15";
$lang['therehavebeen'] = "THeR3 h4v3 b33n";
$lang['postsmadeinthelastsixtyminutes'] = "P0S+\$ m4d3 1N +3h l45t 60 minu+E\$";
$lang['mostpostsevermadeinasinglesixtyminuteperiodis'] = "m0ST p05+S ev3R m@de 1n 4 \$ingl3 60 MInut3 P3ri0d 15";
$lang['wehave'] = "W3 h@ve";
$lang['registeredmembers'] = "RE9Is+3red Mem8er\$";
$lang['thenewestmemberis'] = "TH3 n3w3\$+ M3mbeR I\$";
$lang['mostuserseveronlinewas'] = "m0s+ u\$ER5 3ver online W4s";


?>