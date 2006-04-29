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

/* $Id: x-hacker.inc.php,v 1.203 2006-04-29 16:10:45 decoyduck Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_charset'] = "UTF-8";
$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "janU@rY";
$lang['month'][2]  = "ph38ru4rY";
$lang['month'][3]  = "m4rcH";
$lang['month'][4]  = "4PRiL";
$lang['month'][5]  = "M4y";
$lang['month'][6]  = "juNE";
$lang['month'][7]  = "JuLy";
$lang['month'][8]  = "4uGU5+";
$lang['month'][9]  = "\$Ep+Em8eR";
$lang['month'][10] = "0C+0ber";
$lang['month'][11] = "nOvEm83R";
$lang['month'][12] = "d3c3mBEr";

$lang['month_short'][1]  = "JAn";
$lang['month_short'][2]  = "Ph3B";
$lang['month_short'][3]  = "m@R";
$lang['month_short'][4]  = "@pR";
$lang['month_short'][5]  = "M4Y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "Jul";
$lang['month_short'][8]  = "@UG";
$lang['month_short'][9]  = "sEP";
$lang['month_short'][10] = "oct";
$lang['month_short'][11] = "NOv";
$lang['month_short'][12] = "d3c";

// Dates ---------------------------------------------------------------

// Various date and time formats as used by BeehiveForum. All times are
// expressed as 24 hour time format.

$lang['daymonthyear'] = "%s %s %s";                  // 1 Jan 2005
$lang['monthyear'] = "%s %s";                        // Jan 2005
$lang['daymonthyearhourminute'] = "%s %s %s %s:%s";  // 1 Jan 2005 12:00
$lang['daymonthhourminute'] = "%s %s %s:%s";         // 1 Jan 12:00
$lang['daymonth'] = "%s %s";                         // 1 Jan
$lang['hourminute'] = "%s:%s";                       // 12:00

// Common words --------------------------------------------------------

$lang['percent'] = "P3RCEnT";
$lang['average'] = "@ver@g3";
$lang['approve'] = "4pPR0v3";
$lang['banned'] = "BANned";
$lang['locked'] = "l0CK3D";
$lang['add'] = "AdD";
$lang['advanced'] = "4dv4nC3d";
$lang['active'] = "4c+IV3";
$lang['kick'] = "K1Ck";
$lang['remove'] = "r3M0V3";
$lang['style'] = "5TyLE";
$lang['go'] = "90";
$lang['folder'] = "F0lD3r";
$lang['ignoredfolder'] = "1GnorED F0ld3R";
$lang['folders'] = "pHoLD3r5";
$lang['thread'] = "+HRE@D";
$lang['threads'] = "+HrEads";
$lang['message'] = "m35\$4gE";
$lang['from'] = "fRoM";
$lang['to'] = "t0";
$lang['all_caps'] = "@Ll";
$lang['of'] = "0Ph";
$lang['reply'] = "replY";
$lang['replyall'] = "r3pLy +o @Ll";
$lang['pm_reply'] = "R3pLY @S PM";
$lang['delete'] = "DELE+3";
$lang['deleted'] = "dElE+3d";
$lang['del'] = "dEl";
$lang['edit'] = "3Di+";
$lang['privileges'] = "pRIV1LE9ES";
$lang['ignore'] = "1Gn0R3";
$lang['normal'] = "n0Rm4L";
$lang['interested'] = "1NTERES+ED";
$lang['subscribe'] = "Su8sCRiBE";
$lang['apply'] = "@PplY";
$lang['submit'] = "5U8MIt";
$lang['download'] = "d0WNL04D";
$lang['save'] = "54v3";
$lang['savechanges'] = "\$4Ve ch4n9E\$";
$lang['update'] = "UpD@+E";
$lang['cancel'] = "C4ncEl";
$lang['continue'] = "CoN+1nUE";
$lang['with'] = "wItH";
$lang['attachment'] = "@tt@CHm3nT";
$lang['attachments'] = "@tt4CHm3NT\$";
$lang['imageattachments'] = "1m49e 4TT@CHM3Nt\$";
$lang['filename'] = "PHILen4ME";
$lang['dimensions'] = "D1M3n\$IOn\$";
$lang['downloadedxtimes'] = "DOWNload3D: %d +1ME\$";
$lang['downloadedonetime'] = "dOWNl04deD: 1 t1M3";
$lang['size'] = "s1Z3";
$lang['viewmessage'] = "v13w mE\$5Ag3";
$lang['logon'] = "loGON";
$lang['more'] = "moR3";
$lang['recentvisitors'] = "r3cEN+ vi\$1+0r\$";
$lang['username'] = "U53rN@ME";
$lang['clear'] = "cLe@r";
$lang['action'] = "4Ct1oN";
$lang['unknown'] = "UNKn0WN";
$lang['none'] = "n0nE";
$lang['preview'] = "PrEV13w";
$lang['post'] = "Po\$+";
$lang['posts'] = "poSts";
$lang['change'] = "cH4n93";
$lang['yes'] = "YE5";
$lang['no'] = "No";
$lang['signature'] = "5IGn@+uRE";
$lang['signaturepreview'] = "SigN4+URE PReVIew";
$lang['signatureupdated'] = "SIgn@+UR3 UPD4tED";
$lang['wasnotfound'] = "W4s n0T F0UND";
$lang['back'] = "b4cK";
$lang['subject'] = "SUBj3CT";
$lang['close'] = "cL0se";
$lang['name'] = "N@M3";
$lang['description'] = "d35CRIp+1On";
$lang['date'] = "D4t3";
$lang['view'] = "v1Ew";
$lang['enterpasswd'] = "3Nt3R P4\$\$woRd";
$lang['passwd'] = "p45sW0RD";
$lang['ignored'] = "1gNor3D";
$lang['guest'] = "guESt";
$lang['next'] = "nExT";
$lang['prev'] = "PR3V10U5";
$lang['others'] = "o+hERS";
$lang['nickname'] = "nIckN4ME";
$lang['emailaddress'] = "eM4iL 4DDR3\$s";
$lang['confirm'] = "coNf1RM";
$lang['email'] = "Em4iL";
$lang['newcaps'] = "NeW";
$lang['poll'] = "p0Ll";
$lang['friend'] = "PHr1End";
$lang['error'] = "ErrOR";
$lang['guesterror_1'] = "s0RRy, J00 NE3D To 8E Lo99ED 1N +0 US3 THI\$ f3aTURE.";
$lang['guesterror_2'] = "LO9IN N0W";
$lang['on'] = "0N";
$lang['unread'] = "uNRe4d";
$lang['all'] = "@lL";
$lang['allcaps'] = "4ll";
$lang['me_caps'] = "m3";
$lang['by'] = "8y";
$lang['permissions'] = "p3rMissi0nS";
$lang['position'] = "po5iTIOn";
$lang['type'] = "typ3";
$lang['print'] = "pR1n+";
$lang['sticky'] = "5t1cKy";
$lang['polls'] = "P0Ll5";
$lang['user'] = "U\$3R";
$lang['enabled'] = "eN@bL3D";
$lang['disabled'] = "Di\$@8LeD";
$lang['options'] = "oPT1On\$";
$lang['emoticons'] = "EmO+IC0N5";
$lang['webtag'] = "Web+49";
$lang['makedefault'] = "m4K3 DepH4ULt";
$lang['unsetdefault'] = "un\$E+ DEPH4UL+";
$lang['rename'] = "REN@M3";
$lang['pages'] = "P49E\$";
$lang['top'] = "TOP";
$lang['used'] = "U\$3d";
$lang['days'] = "D@y5";
$lang['sortasc'] = "5oRt @SceNd1NG";
$lang['sortdesc'] = "s0RT DEscEND1Ng";
$lang['usage'] = "us@9E";
$lang['show'] = "5H0W";
$lang['prefix'] = "Pr3F1X";
$lang['hint'] = "h1n+";
$lang['new'] = "N3W";
$lang['reset'] = "rEseT";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "4DM1n tOOL\$";
$lang['forummanagement'] = "pH0ruM M4N493M3N+";
$lang['accessdenied'] = "4CcES5 deNi3D";
$lang['accessdeniedexp'] = "J00 D0 N0+ H4V3 p3RMI\$\$iON T0 U53 tHI5 53c+ION.";
$lang['managefolders'] = "m4NAgE pHoLDER\$";
$lang['manageforums'] = "M4N4gE fORUM\$";
$lang['manageforumpermissions'] = "man@Ge foRUM PERMIsSiOn5";
$lang['foldername'] = "f0LD3R nAM3";
$lang['move'] = "m0V3";
$lang['closed'] = "cL0s3D";
$lang['open'] = "0pEN";
$lang['restricted'] = "RE5tRICT3D";
$lang['iscurrentlyclosed'] = "1\$ cURRENTlY ClOSED";
$lang['youdonothaveaccessto'] = "J00 DO not H4V3 @cCE5\$ To";
$lang['toapplyforaccessplease'] = "t0 4PpLY pH0R 4CC35s pL34S3 CoNT4CT +H3 FoRUM OWn3r.";
$lang['adminforumclosedtip'] = "1PH J00 w4N+ T0 CH@n93 s0m3 \$eTTIn95 ON y0UR PH0rum CLIck +EH 4DMiN lINK 1N +EH N4vIG4T1On b4r 4b0V3.";
$lang['newfolder'] = "n3W fOLDeR";
$lang['forumadmin'] = "foRuM @dM1n";
$lang['adminexp_1'] = "USE +3h meNU ON tHE L3phT +0 m4n4G3 +hIn9\$ 1N Y0Ur FoRuM.";
$lang['adminexp_2'] = "<b>uSeR5</b> @lL0W\$ j00 +0 53+ iNDIV1dU@L usEr p3RMI\$s1oN5, iNcLUDIN9 4PPO1N+iNG ED1ToR\$ @ND 94991N9 p30PlE.";
$lang['adminexp_3'] = "<b>us3r 9R0UPs</b> 4LLoWS j00 to Cr34+E uSER GRoUPS to 4ss19N p3RM1ssi0Ns tO @\$ m@nY oR 4s feW U\$ErS QuICKlY 4Nd 3@51LY.";
$lang['adminexp_4'] = "<b>B@N cONtr0Ls</b> @lL0Ws +H3 B4nN1N9 4ND UN-84nNINg 0pH 1P 4dDRE\$\$3s, USeRN4M3s, 3m41L 4DdRe5\$E5 4nD NIcKN4MeS.";
$lang['adminexp_5'] = "<b>fOLDERs</b> @lL0W\$ tHE Cre4Ti0N, M0dIph1c4+10n 4Nd D3L3+1On 0pH PH0LD3R\$.";
$lang['adminexp_6'] = "<b>Pr0fIl35</b> Le+5 j00 cU5+0M1S3 T3h 1t3ms TH@+ 4PPEAR 1n +H3 USer PR0PHILe5.";
$lang['adminexp_7'] = "<b>phoRum seTT1nGS</b> 4llOw5 j00 tO CUS+0M15e YoUR fOrUM'S N4Me, 4PpE@RANc3 @ND M@ny o+HeR +h1NGs.";
$lang['adminexp_8'] = "<b>\$t4R+ P4Ge</b> lE+s J00 CUs+OMiS3 YoUR FoRUM'\$ \$+@R+ pA9E.";
$lang['adminexp_9'] = "<b>pHORUM \$TyLE</b> @lLOwS J00 +0 cRE@+3 sTYle5 pHOR yOur F0ruM MEM83rs +0 UsE.";
$lang['adminexp_10'] = "<b>worD FIL+Er</b> ALLoW\$ J00 to f1L+3r woRDs j00 dOn'+ W@n+ TO B3 Us3D 0N yOuR FORuM.";
$lang['adminexp_11'] = "<b>P0s+Ing s+4T\$</b> GENER4+es 4 R3poRT lI5tiN9 Th3 +0P 10 P05t3rs 1N 4 dEPHIN3D pERI0d.";
$lang['adminexp_12'] = "<b>fORum L1NKs</b> l3ts J00 m@n49E tH3 l1NK5 DropD0WN 1N +H3 N4V1g@+I0n B@r.";
$lang['adminexp_13'] = "<b>V13w l0g</b> LIsTS REC3NT 4cT10N5 8y tEH FORUM MOdER4+ORs.";
$lang['adminexp_14'] = "<b>M4n@g3 FORums</b> le+s J00 cR34+e 4ND d3lET3 4nD CLO5E 0R rEoP3N PH0RuM\$.";
$lang['adminexp_15'] = "<b>glo8@l FoRUm \$3+tING5</b> @LLoW\$ J00 +0 M0d1PhY sETTIngs Wh1CH @FpH3Ct @LL PH0RUMs.";
$lang['createforumstyle'] = "Cr3@+3 4 FOrUM \$tYLe";
$lang['newstyle'] = "N3W STylE";
$lang['successfullycreated'] = "5UccE\$sPhUlLY crE4T3d.";
$lang['stylealreadyexists'] = "4 STYlE WiTh +H4+ f1LEn4mE 4LReaDY 3xI\$t\$.";
$lang['stylenofilename'] = "J00 D1D N0+ 3nt3r a PhIL3N4M3 +0 sAVE tHE \$+YL3 WITH.";
$lang['stylenodatasubmitted'] = "C0ULD no+ RE@d PhorUM sTYLE d4t@.";
$lang['styleexp'] = "u\$3 TH1s p4G3 T0 HElP cR3@+e 4 r4nD0MLy 9En3r4+eD STYL3 FOR y0Ur FORum.";
$lang['stylecontrols'] = "COntR0LS";
$lang['stylecolourexp'] = "Cl1Ck 0n @ C0L0uR To M4KE 4 N3w 5TylE Sh33T 84sEd oN tH@+ C0L0ur. CURr3nT 84SE C0LOUr i\$ Ph1R5+ 1N lIS+.";
$lang['standardstyle'] = "5+4nD4RD s+yL3";
$lang['rotelementstyle'] = "rO+4teD EL3M3N+ STYL3";
$lang['randstyle'] = "r@nD0m s+YLE";
$lang['thiscolour'] = "+his cOlOUr";
$lang['enterhexcolour'] = "0r 3NT3r @ HEX COLoUR +O 84\$3 4 NEW \$+YL3 5h33+ 0N";
$lang['savestyle'] = "\$4V3 THis \$tYLE";
$lang['styledesc'] = "s+yLe dE\$C3NDiNG";
$lang['fileallowedchars'] = "(lOwERC4S3 L3+T3R5 (@-Z), nUMB3r\$ (0-9) @ND UndEr5CorE5 (_) 0NLY)";
$lang['stylepreview'] = "S+yLe PRevIEw";
$lang['welcome'] = "W3LCOMe";
$lang['messagepreview'] = "m3ss49e Pr3ViEW";
$lang['users'] = "useRS";
$lang['usergroups'] = "u\$3R 9ROUp5";
$lang['mustentergroupname'] = "j00 MuSt EN+3R 4 gROuP n4M3";
$lang['profiles'] = "PROFILEs";
$lang['manageforums'] = "M4n49E PhORums";
$lang['forumsettings'] = "F0RUM \$e+Tin9\$";
$lang['globalforumsettings'] = "9L08@l foRUM s3TtING\$";
$lang['settingsaffectallforumswarning'] = "<b>N0Te:</b> Th3S3 53TT1nGs ApHfeC+ @LL F0Rums. wH3r3 +H3 \$3+TiNg i5 dUpLiCAt3D oN +h3 IND1V1DU@L PHoRUM's 5EtT1nG5 P4G3 +H4+ W1lL +4KE pR3CeD3NcE oVER +he S3T+IN9s J00 cH@n9E HeRE.";
$lang['startpage'] = "sT4Rt P4GE";
$lang['startpageerror_1'] = "Y0uR sT@r+ pAgE c0ULd NO+ 8E s4V3D L0c4Lly +0 T3H sERV3R b3c4u\$3 PeRmissiOn W@\$ dEniEd. +o ChAN9E YoUR 5T4RT p@g3 PL34\$e cLick +hE DoWnLo4D 8u+Ton 83l0W WhIcH wIlL PrOmP+ J00 T0 \$4v3 TEh F1L3 +0 y0uR H4Rd Dr1Ve. J00 C4N +Hen UpL04D +H1s f1L3 +0 Y0Ur 53RvER IN+0";
$lang['startpageerror_2'] = "PHoLd3R, 1F N3CE5S4RY cRE@+ING +h3 F0lD3R STRuctur3 IN +h3 pR0C35S. pLe4\$E N0T3 +H4T 50ME bR0Ws3R\$ M4y cH4N9e TeH N@Me oPh T3H PhIL3 UP0N d0WnL04D.  WH3N UpL04Din9 THe F1L3 PlE@53 M4k3 \$UR3 +H4+ 1+ 1\$ N4Med 5t@RT_M4In.PHP o+hErwI\$E YoUR s+Ar+ P4g3 wIlL 4Ppe4R uNCH4n93d.";
$lang['failedtoopenmasterstylesheet'] = "Y0Ur fORuM \$+YLE COULD NOT b3 \$4Ved b3C4U\$3 tEH m@5TeR 5TyL3 sH33+ coULd NoT B3 l04DED. T0 SaV3 Y0uR s+YlE +He M4sT3R sTyL3 5heE+ (M@k3_STyLE.css) Mu\$+ 83 L0C4+3D IN th3 5TylE5 D1REC+0rY 0F Y0Ur B33h1VEforUM inS+4lL@TI0N.";
$lang['makestyleerror_1'] = "YOUR PHORum 5TyL3 coULD N0t 8E S4v3D L0CALLy T0 TEH s3RVeR b3C4uS3 pERMiSS1On W@5 DEnIED. T0 \$4Ve Y0ur f0RuM 5+yLe PLE4\$E Cl1Ck TH3 D0WNl04D BU+toN b3Low wHIcH W1LL PR0Mp+ J00 T0 \$@v3 +HE F1LE +0 Y0UR H4RD DRiv3. J00 C@N +HEN UPl04D Th15 f1L3 +o y0UR s3Rv3R in+0";
$lang['makestyleerror_2'] = "f0LDER, iPH NECEs\$@RY cRe@+InG +H3 PHoLd3R \$+RUcTUre In +H3 PRocE55. J00 \$h0ulD No+e +H4+ \$Om3 8ROWseR5 m@Y cHAnGE +HE N@ME oPh TEh F1Le uP0N D0WnL0AD. wHEn UPLO4DiN9 T3H PHiLe PLe4Se M@K3 \$UR3 Th4+ 1T 1\$ N4meD \$+ylE.c\$\$ 0+H3rWi\$e TEh F0RuM \$+YL3 WILl 8e uNUS@blE.";
$lang['uploadfailed'] = "YOUr n3W \$+4R+ P@G3 coULd N0T 8E UPL04DeD +o t3H sERVER bEC4U\$e pErMIs5ION w@5 DENIed. PLE4Se CheCk +HA+ THE W38 sERV3r / PHP PRocE5\$ 15 ABLe to wrIt3 +0 +3H %s pH0LdER oN Y0Ur s3RVeR.";
$lang['makestylefailed'] = "YoUr N3w F0RUM \$+yLe CoUld no+ b3 s4ved T0 Teh 53RvEr 8EC@u53 P3RM1Ssi0n W@s D3n1Ed. PlE453 CH3cK TH@T TH3 WeB S3rVEr / pHp ProC35S I\$ 4BlE To Wr1TE T0 +3h %s PHoLD3R 0n Y0UR SeRV3R.";
$lang['forumstyle'] = "F0rUm 5TyLE";
$lang['wordfilter'] = "WoRD PHiLT3r";
$lang['forumlinks'] = "pH0RUM L1Nk\$";
$lang['viewlog'] = "v13w l09";
$lang['invalidop'] = "InV4LId 0P3R4TION";
$lang['noprofilesectionspecified'] = "NO pROPHILE \$3CTiON 5PeCIpH13d.";
$lang['newitem'] = "new ITEM";
$lang['manageprofileitems'] = "M4N@gE PR0PH1L3 IT3MS";
$lang['itemname'] = "i+3M NAM3";
$lang['moveto'] = "MOvE +o";
$lang['deleteitem'] = "DELET3 i+3m";
$lang['deletesection'] = "D3l3t3 \$3CTI0N";
$lang['new_caps'] = "n3w";
$lang['newsection'] = "n3w \$3c+i0n";
$lang['manageprofilesections'] = "M4N4g3 PrOPHIL3 \$3CTI0N5";
$lang['sectionname'] = "s3CT10N N4ME";
$lang['items'] = "i+EMs";
$lang['startpageupdated'] = "\$+4rT p4GE uPD@+ED";
$lang['viewupdatedstartpage'] = "v13W UPD@+3d sTaR+ p493";
$lang['editstartpage'] = "3diT s+4RT p4G3";
$lang['nouserspecified'] = "n0 u\$3R \$P3c1PHieD For 3d1T1n9.";
$lang['manageuser'] = "MaNage US3r";
$lang['manageusers'] = "m4NA9E U53RS";
$lang['userstatus'] = "U5eR St4tU\$";
$lang['userdetails'] = "uS3R De+4iL5";
$lang['nicknameheader'] = "n1Ckn4m3:";
$lang['warning_caps'] = "w4RnInG";
$lang['userdeleteallpostswarning'] = "4r3 J00 5uRE J00 W4NT To DEle+3 4lL 0PH tHe sELECT3D U\$3R'S po5T\$? ONC3 T3h P05+5 4rE DeL3t3d +H3Y C4NnOT 8E Re+r1Ev3D 4nd w1LL 8e L0s+ pHoR3VeR.";
$lang['postssuccessfullydeleted'] = "P0\$tS wERE 5UCCE\$\$FuLLY DElE+ED.";
$lang['folderaccess'] = "PhOLD3r 4cC3s\$";
$lang['possiblealiases'] = "Po\$SIBle 4LI@\$3s";
$lang['usersettingsupdated'] = "US3R sE++ING\$ \$uCC3ssFULLY Upd4+eD";
$lang['nomatches'] = "n0 M4tchES";
$lang['deleteposts'] = "dELET3 P0s+S";
$lang['deleteallusersposts'] = "D3L3t3 @LL 0f +hIs u\$3R'\$ Po5t\$";
$lang['noattachmentsforuser'] = "NO 4T+4CHM3Nts FoR tH1s UsER";
$lang['aliasdesc'] = "th1\$ 1S a L1st 0PH O+H3r P0s+3R5 WhO m@+cH TH15 USEr's L4\$T 20 kN0wN 1P 4DDRE\$sE5.";
$lang['forgottenpassworddesc'] = "1f +HIS U\$3R H4\$ fOr9O+tEN +h3Ir P45\$W0rD J00 Can r3sET 1T PH0R THEM h3R3.";
$lang['manageusersexp_1'] = "+HI\$ LiS+ \$HOw5 4 5ELEc+10n 0Ph US3Rs WHo h@v3 logGED 0N +O Y0Ur FoRUM, \$0R+eD 8Y";
$lang['manageusersexp_2'] = "+o 4l+3R @ U\$eR'\$ PERM1\$\$10N5 cL1CK tHE1R n4ME.";
$lang['lastlogon'] = "L@st l090N";
$lang['nouseraccounts'] = "no u\$3R AcC0un+S In d@+4b4s3.";
$lang['searchforusernotinlist'] = "SE4rCH PH0R 4 UsER NO+ iN LI\$T";
$lang['adminaccesslog'] = "4dM1N @cC35s Lo9";
$lang['adminlogexp'] = "This L1s+ sH0W5 T3h L4\$t 4C+1On\$ \$4nCT1oNeD 8Y u\$ERs w1TH @dM1N PRiv1lE9E5.";
$lang['datetime'] = "d4+3/+IME";
$lang['unknownuser'] = "uNkn0WN US3r";
$lang['unknownfolder'] = "uNkNowN PHolD3r";
$lang['ip'] = "1P";
$lang['logged'] = "l0g9Ed";
$lang['notlogged'] = "N0+ LO9gEd";
$lang['wordfilterupdated'] = "w0Rd pHIL+ER Upd4+3d";
$lang['editwordfilter'] = "3D1T wORd pHILTER";
$lang['wordfilterexp_1'] = "u53 THI\$ p@9E +o 3dIt tHE w0rD f1L+3r F0R Y0UR PhORum. PLaCE 34cH w0Rd to b3 pH1LTERed oN a N3W L1nE.";
$lang['wordfilterexp_2'] = "P3RL-C0MP4ti8l3 R39UL4r ExPR3\$\$IOn\$ CAn 4LSo B3 U\$3D To m4TcH worDs IF J00 KN0w HoW.";
$lang['wordfilterexp_3'] = "u\$3 tH15 p@gE t0 3d1+ Y0UR Per\$oN@l w0RD FIlT3r. pL@cE 34CH W0rD to 8E f1l+er3D ON @ neW l1nE.";
$lang['wordfilterisfull'] = "J00 cANNo+ 4dD 4nY MoRe w0Rd F1Lt3rs. rEMOv3 S0Me unu\$Ed 0Nes 0r 3d1T +H3 3X1sTINg 0Nes phIR\$+.";
$lang['allow'] = "@LL0W";
$lang['access'] = "4Cc3sS";
$lang['normalthreadsonly'] = "noRM4L tHREADs 0nLY";
$lang['pollthreadsonly'] = "P0LL THr34D\$ onLY";
$lang['both'] = "BoTH +Hr34D TYp3s";
$lang['existingpermissions'] = "3XI\$T1n9 p3rmIS\$10NS";
$lang['nousers'] = "NO U\$3rs";
$lang['searchforuser'] = "SEARcH f0r US3R";
$lang['browsernegotiation'] = "8r0w\$3R N3GO+14+3D";
$lang['largetextfield'] = "L@R9e t3x+ F13LD";
$lang['mediumtextfield'] = "mEd1um +Ex+ F13LD";
$lang['smalltextfield'] = "SM4lL +3Xt pHI3LD";
$lang['multilinetextfield'] = "MUl+I-lIN3 t3XT PHI3lD";
$lang['radiobuttons'] = "R4D1O bUTtON5";
$lang['dropdown'] = "DroP DoWN";
$lang['threadcount'] = "+Hr34D C0Un+";
$lang['fieldtypeexample1'] = "F0R R4D1o bUtt0n5 4ND Dr0P DOWN fiElds J00 nEed TO 53P4R4T3 +h3 F13LDn4M3 @Nd t3H V@lu3S wiTh @ C0LOn 4Nd E4Ch V4LuE sH0uLD B3 \$EP4R4TeD 8Y 5eM1-Col0N\$.";
$lang['fieldtypeexample2'] = "EX4mpL3: +0 CR34+E 4 b4s1C 9END3R r4DiO 8u++ON5, WiTH TW0 S3L3CTIOnS FoR m4Le 4ND Ph3MALe, j00 woulD 3N+3R: <b>9eNDEr:MAL3;PheM4L3</b> In the I+eM N@Me f1ELD.";
$lang['editedwordfilter'] = "ediT3d WORD F1lTER";
$lang['editedforumsettings'] = "3d1+Ed pHoRUM \$eTT1nGS";
$lang['sessionsuccessfullyended'] = "S3Ss1oN sUcCEs5PHUlLY 3ND3D fOR U\$3R";
$lang['matchedtext'] = "m@tCHED T3xT";
$lang['replacementtext'] = "R3Pl@Cem3nt +ex+";
$lang['preg'] = "pREG";
$lang['wholeword'] = "Whol3 W0Rd";
$lang['word_filter_help_1'] = "<b>@Ll</b> M@+cHe5 @G@1NsT +HE WhoL3 +3xT \$0 PhiL+3r1N9 MOm t0 MuM W1Ll 4l\$O Ch4NgE MoM3Nt +o MUM3Nt.";
$lang['word_filter_help_2'] = "<b>wh0L3 WORd</b> M4TCHE\$ @9@1n\$+ wHolE WoRds 0Nly S0 f1l+3RINg MoM tO MUM w1LL NOT CH4NGe mOM3nT To MUMeNt.";
$lang['word_filter_help_3'] = "<b>PRe9</b> 4LLOW\$ J00 +0 U53 P3rl rEGuL@r 3Xpr35s10NS +O MA+CH +3Xt.";
$lang['forumdeletewarning'] = "4rE j00 5Ur3 J00 w@Nt t0 DEL3+3 ThE SeLEc+3D F0RuM? 0NCE THE f0RuM 15 D3L3T3D 1t'5 3nTiR3 C0N+ENT\$ I\$ Los+ F0r3VEr 4ND c4NN0+ B3 ReCoV3RED.";
$lang['deleteforum'] = "DELe+3 FoRuM";
$lang['successfullycreatedforum'] = "\$UccE5sPhUlLY cr34+3d PH0Rum";
$lang['failedtocreateforum_1'] = "ph4iL3d +O cRE@+3 f0RuM";
$lang['failedtocreateforum_2'] = "plE4SE ch3CK To M4kE SurE T3H WE8t4g 4nD T@8LE n4ME5 @r3N't 4lreAdY IN u53.";
$lang['nameanddesc'] = "N4mE @nD D3\$CR1P+i0N";
$lang['movethreads'] = "moV3 +HRE4Ds";
$lang['threadsmovedsuccessfully'] = "+hRE4ds M0VED sUCC3ssFulLY";
$lang['movethreadstofolder'] = "m0v3 THRE4D5 T0 FOLd3r";
$lang['allowfoldertocontain'] = "4lLoW pH0Ld3R t0 c0N+4In";
$lang['addnewfolder'] = "AdD N3W pHOLd3r";
$lang['mustenterfoldername'] = "j00 mU\$t en+3R @ PHoLD3R n4M3";
$lang['nofolderidspecified'] = "N0 phoLd3R 1D \$p3cIPh13D";
$lang['invalidfolderid'] = "inV4L1D FoLd3R Id. CHecK Th4+ 4 ph0LDer wITH TH1S Id ExiStS!";
$lang['successfullyaddedfolder'] = "\$ucce5sFULLY 4DD3D pHOLDEr";
$lang['successfullydeletedfolder'] = "\$UCC3sspHULlY d3LEt3d pH0lD3r";
$lang['folderupdatedsuccessfully'] = "f0lD3r UPD4+3D SUCc3s\$fULly";
$lang['forumisnotrestricted'] = "PHOrUM 1\$ No+ RESTr1cTED";
$lang['noforumidspecified'] = "NO FoRuM 1d \$PeCIpH1ed";
$lang['groups'] = "grOUps";
$lang['addnewgroup'] = "4Dd N3W GROuP";
$lang['nousergroups'] = "NO Us3r gR0UPs H@Ve B3EN \$et UP";
$lang['suppliedgidisnotausergroup'] = "suPpL13D gID IS n0t 4 US3r 9r0UP";
$lang['manageusergroups'] = "M4n4gE U5eR 9RoUP\$";
$lang['groupstatus'] = "GRoUP sT@+u5";
$lang['addusergroup'] = "4dD 9R0UP";
$lang['addremoveusers'] = "@dD/REM0V3 U\$3r\$";
$lang['nousersingroup'] = "+HeRE 4RE No Us3R\$ In +H1\$ 9RoUp";
$lang['deletegroups'] = "deLE+3 GROuP\$";
$lang['useringroups'] = "thI\$ uSEr Is 4 mEmBER oPh +3h F0LLOw1NG 9ROUPS";
$lang['usernotinanygroups'] = "th15 U\$3R 1S No+ IN 4nY UsER GrOUpS";
$lang['usergroupwarning'] = "noTE: +h1\$ U5Er m4Y b3 INhEr1+1NG 4DD1+iON4L PERM1s\$IOns PHROm 4nY U\$3R 9ROup\$ LI\$TED b3LOw.";
$lang['successfullyaddedgroup'] = "sucCe\$sPHULlY 4dD3D GroUP";
$lang['successfullydeletedgroup'] = "suCcE5sPHULly DEL3T3D 9R0UP";
$lang['usercanaccessforumtools'] = "U\$eR C4N 4CcE5s f0RuM +00Ls @ND c@N cRe4+3, D3Le+3 aNd Ed1T fOrUmS";
$lang['usercanmodallfoldersonallforums'] = "u5ER C@n mOD3R4TE <b>@LL pH0LD3Rs</b> 0n <b>alL FOruM\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "U\$3R c4N mod3r@+3 lINKs Sec+1oN ON <b>4LL Ph0RUMs</b>";
$lang['emailconfirmationrequired'] = "3M41l conF1Rm@+10n REqU1Red";
$lang['cancelemailconfirmation'] = "c@NCEl 3M4IL cOnF1RMA+IOn 4nD 4lL0W uS3R TO S+4RT Po\$+iNG";
$lang['resendconfirmationemail'] = "ReSENd COnPHIrm4T10N 3MAiL +0 U53R";
$lang['donothing'] = "dO No+h1NG";
$lang['usercanaccessadmintools'] = "u\$Er h4\$ 4cCEs\$ T0 F0RUM 4DM1N ToOLs";
$lang['usercanaccessadmintoolsonallforums'] = "U53R h4s ACC3S5 +0 4DM1N +00l5 <b>On @LL phORuMs</b>";
$lang['usercanmoderateallfolders'] = "us3R C4n MoDER4+e 4ll FoLD3rS";
$lang['usercanmoderatelinkssection'] = "US3r CAn MoD3R4tE L1NKs \$3CTIon";
$lang['userisbanned'] = "U53R I5 b@nNed";
$lang['useriswormed'] = "usEr IS W0RM3D";
$lang['userispilloried'] = "USer Is pILLoRI3D";
$lang['usercanignoreadmin'] = "uSeR C4n I9n0R3 4DMIN1sTR4+0RS";
$lang['groupcanaccessadmintools'] = "9RoUP CAn 4cceS\$ adm1N TO0lS";
$lang['groupcanmoderateallfolders'] = "GroUP c4N MOD3R4TE 4Ll phold3RS";
$lang['groupcanmoderatelinkssection'] = "9r0UP C@n M0d3r4T3 lINK\$ sEC+1ons";
$lang['groupisbanned'] = "GroUP 15 B4NNed";
$lang['groupiswormed'] = "9RouP Is woRMED";
$lang['readposts'] = "rE4D P05T5";
$lang['replytothreads'] = "rePLy +O +HrEADs";
$lang['createnewthreads'] = "cRE4tE n3W Thr3ADs";
$lang['editposts'] = "3d1t p05Ts";
$lang['deleteposts'] = "dEl3+3 pO5Ts";
$lang['uploadattachments'] = "uPl0@d ATT@ChmEnTs";
$lang['moderatefolder'] = "M0dER4T3 FolD3R";
$lang['postinhtml'] = "p05T IN h+mL";
$lang['postasignature'] = "P0s+ 4 sI9N4TUr3";
$lang['editforumlinks'] = "EdI+ Phorum l1nKS";
$lang['editforumlinks_exp'] = "US3 +H1s P49E To 4DD LiNKs +0 TEH dROP-D0Wn L1sT dI\$Pl@Y3D iN +hE +0P-rIGH+ Of +3H pHORuM PhR4Me5E+. 1PH N0 l1NKS 4RE sE+, tHe Dr0P-DoWn L1\$+ W1Ll noT 8E D15Pl@Y3d.";
$lang['notoplevellinkidspecified'] = "n0 top l3v3l liNK iD sPEc1F1ED";
$lang['notoplevellinktitlespecified'] = "NO top L3V3L lINK +1+l3 \$PECIpHI3D";
$lang['youmustenteratitleforalllinks'] = "J00 MUsT 3NT3R A +1+lE FoR 4lL L1NKs";
$lang['youmustprovideapositionforalllinks'] = "j00 Mu\$+ PROviD3 A liNk P0s1T10N FoR 4Ll LiNK5";
$lang['alllinkurismuststartwithaschema'] = "@Ll L1NK UR1S Mu\$+ 5T4R+ w1TH 4 \$CHem4 (1.e. h+Tp://, fTP://, 1RC://)";
$lang['allowguestaccess'] = "4lL0w 9u3St 4cCEsS";
$lang['searchenginespidering'] = "S34RCh 3N91n3 \$P1deR-IN9";
$lang['allowsearchenginespidering'] = "4lLOW \$34RCH 3ngINe 5p1D3R-iNG";
$lang['newuserregistrations'] = "neW U\$ER r39i5+R4+IONS";
$lang['preventduplicateemailaddresses'] = "pR3V3NT DuPl1C@+3 3M41L 4dDrE5\$35";
$lang['allownewuserregistrations'] = "@Ll0W new UsER R3G1s+r4T10N5";
$lang['requireemailconfirmation'] = "reQuIrE 3M4IL C0NphIRMATiON";
$lang['usetextcaptcha'] = "Us3 TeXT c4PTcH@";
$lang['textcaptchadir'] = "T3x+ C4PTCH4 DIReCToRY";
$lang['textcaptchakey'] = "+3xT c4P+CH4 K3y";
$lang['textcaptchafonterror_1'] = "+3x+ C4PTCH4 h@5 83eN D1\$48LeD @U+OMATicALLy b3c4uS3 +H3RE 4R3 No +RUE +YP3 F0N+5 AV41L4BLe PHoR 1+ To U\$E. PL34SE UpL04d 50M3 +Ru3 +YPE PHoNTs TO";
$lang['textcaptchafonterror_2'] = "on Y0UR 5ERvER.";
$lang['textcaptchadirerror'] = "t3x+ C4PTCH@ HA5 83En Di548L3D 83C4u\$3 THE T3xT_c@P+cH4 d1Rec+0RY @nD 1T'5 SU8-D1rECTORIE5 4RE n0T WR1+48L3 By +h3 wE8 SErV3r / PhP PrOC3\$\$.";
$lang['textcaptchagderror'] = "TExT C4PTCh@ H4S 833N d1\$@8Led 8ECaUS3 yOuR 53RveR'\$ pHp \$EtuP DoEs N0T PROV1D3 \$UpPoRt PH0r 9D 1M4Ge M@NIPuL4+IoN @ND / OR tTf F0NT sUPp0R+. 8o+H 4Re REqUIr3D FOR tEX+ C4P+Ch4 5uPPoRt.";
$lang['textcaptchadirblank'] = "+3xt c@P+CH4 dirEC+0RY Is 8L@NK!";
$lang['newuserpreferences'] = "NEW Us3R PREph3R3Nc3s";
$lang['sendemailnotificationonreply'] = "EM4iL n0TIf1C@+1on 0N REPLY tO Us3R";
$lang['sendemailnotificationonpm'] = "eM41L noTIf1C@+1oN 0N PM t0 U\$3R";
$lang['showpopuponnewpm'] = "sh0w PoPUP wHEN r3Ce1VING nEW pM";
$lang['setautomatichighinterestonpost'] = "Se+ @u+0M4TIC H1GH 1N+3REST 0N PO\$+";
$lang['top20postersforperiod'] = "+OP 20 P0S+ERs FoR p3RioD %s t0 %s";
$lang['postingstats'] = "POs+1N9 s+4T\$";
$lang['nodata'] = "N0 d4T@";
$lang['totalposts'] = "+0T@l P0ST\$";
$lang['totalpostsforthisperiod'] = "tO+4l Po5TS FoR +Hi5 PERIoD";
$lang['mustchooseastartday'] = "MUs+ CH00s3 4 5t@R+ D4Y";
$lang['mustchooseastartmonth'] = "mU5T CHO053 @ sT4R+ M0NTH";
$lang['mustchooseastartyear'] = "MUst cHo0sE 4 5+4r+ YEAR";
$lang['mustchooseaendday'] = "MU5t CH00\$E 4 END d4y";
$lang['mustchooseaendmonth'] = "mU5T cH00s3 4 End MoN+h";
$lang['mustchooseaendyear'] = "mUs+ CH0o53 4 3nd ye4r";
$lang['startperiodisaheadofendperiod'] = "s+4RT P3RIod is 4H34D 0F 3Nd PEr1OD";
$lang['bancontrols'] = "B@n cOntR0L5";
$lang['bannedipaddresses'] = "b@nN3D IP @dDREs\$35";
$lang['bannedlogons'] = "b4Nn3d L09on5";
$lang['bannednicknames'] = "b4NNEd N1cKnaM35";
$lang['bannedemailaddresses'] = "84NN3d 3M4IL @dDR3sSeS";
$lang['youcanusethepercentwildcard'] = "J00 CAN u\$E +3H p3rCeN+ (%) wIldC@RD sYM80L in 4NY Oph YoUr 8@N LIsts To 0b+41N P4R+I4l MATcHE5, I.E. '192.168.0.%' WOuLD 84N @LL 1p 4DdR3\$sE\$ 1N tHE r4nGe 192.168.0.1 tHr0uGh 192.168.0.254</p>";
$lang['ipaddressisalreadybanned'] = "ThA+ 1P @dDRE55 1\$ 4LR34DY 8@Nn3D. cH3CK Y0UR WILDC@rd5 To s33 IpH +hEY 4lRe4Dy M4+Ch 1+.";
$lang['logonisalreadybanned'] = "TH4T L090N iS 4LR34DY b4NNED. cH3ck y0Ur W1ldC4RD5 T0 SeE 1pH +H3Y 4lR34DY M4TCH 1+.";
$lang['nicknameisalreadybanned'] = "+H4t n1CKN4ME I\$ 4LRe@DY b4NN3d. CH3cK y0UR WiLdC4RD\$ +0 s3E IF +H3Y @LR34DY M4+CH 1+.";
$lang['emailisalreadybanned'] = "tH4+ Em4iL 4dDR3S\$ is @lr34DY b4nn3d. ch3cK Y0ur wILDcARds T0 \$EE 1F +H3Y 4LRE4Dy M@tCH IT.";
$lang['cannotusewildcardonown'] = "J00 C4nn0T 4dd % 4S @ W1LDc4RD MAtCH 0N IT'5 OWn!";
$lang['requirepostapproval'] = "r3QuIr3 P0\$T APPrOV4L";
$lang['adminforumtoolsusercounterror'] = "+hEr3 mUsT BE 4T lE4sT 1 U\$3r w1Th 4DMIN +00lS @nD F0rUm To0Ls @CcEs\$ On 4LL FoRUm\$!";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4N9ed u5ER s+4TUs Ph0R '%s'";
$lang['changedpasswordforuser'] = "ChAN93D P4s\$woRD PH0R '%s'";
$lang['changedforumaccess'] = "Ch@N93d f0RUM @cC35\$ pErmi5sIONS FoR '%s'";
$lang['deletedallusersposts'] = "dEl3T3d @LL PoSt\$ FOr '%s'";

$lang['createdusergroup'] = "crE4+3D U\$3R gR0UP '%s'";
$lang['deletedusergroup'] = "DELe+3D u53r GR0uP '%s'";
$lang['updatedusergroup'] = "upD4T3d U\$3R gR0UP '%s'";
$lang['addedusertogroup'] = "4dDeD us3R '%s' +0 9R0uP '%s'";
$lang['removeduserfromgroup'] = "REM0v3 USER '%s' FR0m 9rOup '%s'";

$lang['addedipaddresstobanlist'] = "4DD3D Ip '%s' +0 84N LI\$t";
$lang['removedipaddressfrombanlist'] = "R3M0VEd 1p '%s' fr0M B4n l1\$T";

$lang['addedlogontobanlist'] = "4dD3D L090N '%s' To 8AN L1sT";
$lang['removedlogonfrombanlist'] = "r3moV3D L09on '%s' pHRoM 8@N L1St";

$lang['addednicknametobanlist'] = "adDED NICKn4ME '%s' T0 84N L1\$+";
$lang['removednicknamefrombanlist'] = "R3MOvED nICkn@ME '%s' pHRoM b4N L1\$T";

$lang['addedemailtobanlist'] = "aDdED 3m4IL 4DDREss '%s' tO 84N L1\$t";
$lang['removedemailfrombanlist'] = "R3mov3D 3M41L 4DDrEs5 '%s' PhrOm b4N LIs+";

$lang['editedfolder'] = "3d1TeD FoLDer '%s'";
$lang['movedallthreadsfromto'] = "m0VED 4lL +HR34ds fRoM '%s' To '%s'";
$lang['creatednewfolder'] = "cRe@+3D NEw PH0Ld3R '%s'";
$lang['deletedfolder'] = "dEl3T3D FoLD3r '%s'";

$lang['changedprofilesectiontitle'] = "Ch@NG3d PROF1l3 \$3CT1On +1+LE PHROM '%s' +0 '%s'";
$lang['addednewprofilesection'] = "4dd3D NeW Pr0F1L3 53CTiON '%s'";
$lang['deletedprofilesection'] = "D3L3+ED pRof1L3 seC+10N '%s'";

$lang['addednewprofileitem'] = "4dd3d NeW PROPH1le 1TEM '%s' T0 53CT10n '%s'";
$lang['changedprofileitem'] = "CH4n93d pR0PH1L3 iTem '%s'";
$lang['deletedprofileitem'] = "Dele+Ed pR0PHilE 1+Em '%s'";

$lang['editedstartpage'] = "3di+3D \$t@R+ Page";
$lang['savednewstyle'] = "s4Ved NeW s+YL3 '%s'";

$lang['movedthread'] = "Moved Thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >' from '%s' to '%s'";
$lang['closedthread'] = "Closed Thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</@ >'";
$lang['openedthread'] = "Opened Thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >'";
$lang['renamedthread'] = "Renamed Thread '%s' to '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >'";
$lang['deletedthread'] = "Deleted Thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >'";

$lang['lockedthreadtitlefolder'] = "Locked thread options on '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >'";
$lang['unlockedthreadtitlefolder'] = "Unlocked thread options on '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >'";

$lang['deletedpostsfrominthread'] = "Deleted posts from '%s' in thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >'";
$lang['deletedattachmentfrompost'] = "Deleted attachment '%s' from post '<a href=\"index.php?msg=%s.%s\" target=\"_blank\">%s.%s</@ >'";

$lang['editedforumlinks'] = "3dIt3D fORUM L1NKS";

$lang['deletedpost'] = "Deleted Post '<a href=\"index.php?msg=%s.%s\" target=\"_blank\">%s.%s</@ >'";
$lang['editedpost'] = "Edited Post '<a href=\"index.php?msg=%s.%s\" target=\"_blank\">%s.%s</4 >'";

$lang['madethreadsticky'] = "Made thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</@ >' sticky";
$lang['madethreadnonsticky'] = "Made thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</@ >' non-sticky";

$lang['endedsessionforuser'] = "EnDEd S3ssI0N PhoR usEr '%s'";

$lang['approvedpost'] = "Approved post '<a href=\"index.php?msg=%s.%s\" target=\"_blank\">%s.%s</4 >'";

$lang['editedwordfilter'] = "3diTED WoRd F1lTER";

$lang['adminlogempty'] = "@DMIn L0g Is EMpTy";
$lang['clearlog'] = "cL34R L09";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['webtaginvalidchars'] = "WEB+49 c4N oNLY COnt41N UPpeRc4\$3 @-Z, 0-9, _ - cH4R4CT3Rs";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "GlOb4L U\$3R P3RmI\$\$IoNs";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumname'] = "J00 mUs+ \$UPpLy @ PhORuM N4M3";
$lang['mustsupplyforumemail'] = "j00 MuS+ \$uPPlY 4 PhoRuM em41L 4DDRe\$5";
$lang['mustchoosedefaultstyle'] = "J00 MUS+ ChoOS3 4 D3PH4ULT pHoRUM 5Tyl3";
$lang['mustchoosedefaultemoticons'] = "j00 MuSt CH0053 dEPH4UL+ forum eM0T1C0n5";
$lang['unknownemoticonsname'] = "unKNOwn Em0T1c0N5 NaMe";
$lang['mustchoosedefaultlang'] = "j00 mU5T cHO05E @ D3F@ULT pHoRUM L4N9U49E";
$lang['activesessiongreaterthansession'] = "acT1vE s3\$\$iOn tIME0UT canNOT 8E 9R34+Er +h4N \$3sSI0N t1ME0U+";
$lang['attachmentdirnotwritable'] = "4T+4CHMeN+ D1reCT0RY MuSt 8E WRIT48lE BY ThE We8 SErV3R / PHP PRocE5S!";
$lang['attachmentdirblank'] = "J00 MU5t SupPly 4 Dir3C+orY +0 5@v3 ATtACHmEN+s 1N";
$lang['mainsettings'] = "m41n \$ETT1NGS";
$lang['forumname'] = "pH0ruM N@ME";
$lang['forumemail'] = "FOruM EM@iL";
$lang['forumdesc'] = "PH0RUm De\$CrIP+IOn";
$lang['forumkeywords'] = "FORuM kEYw0RDs";
$lang['defaultstyle'] = "dEpH4ulT STYLe";
$lang['defaultemoticons'] = "DePhAULT Em0T1C0Ns";
$lang['defaultlanguage'] = "DEph4ul+ L4nGu493";
$lang['forumaccesssettings'] = "PhoRUM 4CcEs\$ seT+iNG\$";
$lang['forumaccessstatus'] = "FOrUm 4CCeSs 5+4Tus";
$lang['changepermissions'] = "ch@N9E P3rmI\$\$ION\$";
$lang['changepassword'] = "Ch4N9E p4S\$wOrd";
$lang['passwordprotected'] = "pas5wOrD ProTEct3D";
$lang['postoptions'] = "pO\$t oP+iON5";
$lang['allowpostoptions'] = "@lLOW P05+ eD1TING";
$lang['postedittimeout'] = "p0sT 3Di+ t1M30U+";
$lang['wikiintegration'] = "wIkiWIKI 1n+3GR@+Ion";
$lang['enablewikiintegration'] = "eN4BL3 w1KIw1k1 1NT39R4TiON";
$lang['enablewikiquicklinks'] = "eNAbLE W1K1W1Ki QUICK lInK\$";
$lang['wikiintegrationuri'] = "w1KIw1KI LoCATI0N";
$lang['maximumpostlength'] = "m4XiMuM p05+ L3NGth";
$lang['postfrequency'] = "P0St FREQUENCY";
$lang['enablelinkssection'] = "3NABLE L1NKs sECT1oN";
$lang['allowcreationofpolls'] = "4Ll0W CRE@+IOn oF pOlls";
$lang['searchoptions'] = "\$34RCh 0PtIOns";
$lang['searchfrequency'] = "s34RcH fREqU3Ncy";
$lang['sessions'] = "S35sIoN5";
$lang['sessioncutoffseconds'] = "53s\$IoN CUT 0pHF (s3C0NDs)";
$lang['activesessioncutoffseconds'] = "@cTiVE sE5sIoN CUT 0PhpH (S3C0NDs)";
$lang['stats'] = "ST4+\$";
$lang['hide_stats'] = "h1DE ST@Ts";
$lang['show_stats'] = "Sh0W \$t@+5";
$lang['enablestatsdisplay'] = "En48L3 5t4T\$ d15PL@y";
$lang['personalmessages'] = "PEr\$0n4L ME554g35";
$lang['enablepersonalmessages'] = "3n4BlE P3R\$0NAL MES5@9eS";
$lang['pmusermessages'] = "PM m3sS4GE\$ PEr u\$3r";
$lang['allowpmstohaveattachments'] = "4Ll0W P3RS0N4L ME\$s4GE\$ +0 H@vE 4++4CHM3NtS";
$lang['autopruneuserspmfoldersevery'] = "4U+0 PruN3 U\$3R'S PM Ph0LD3Rs 3VERy";
$lang['guestaccount'] = "9u3\$T 4CC0UnT";
$lang['enableguestaccount'] = "eN@BL3 9UEsT @CCOuNT";
$lang['autologinguests'] = "@u+OM4+1C4llY L0g1N 9Ues+5";
$lang['guestaccess'] = "gu3sT 4CCEs\$";
$lang['allowguestaccess'] = "4lL0w GuEsT @cCE5s";
$lang['enableattachments'] = "En4bLe 4++4CHm3n+S";
$lang['attachmentdir'] = "@+T@CHM3NT D1R";
$lang['userattachmentspace'] = "4t+4cHm3N+ Sp@cE P3r us3R";
$lang['allowembeddingofattachments'] = "@LlOW 3m8EDD1N9 oF 4TT@cHm3NTS";
$lang['usealtattachmentmethod'] = "usE @Lt3Rn4TiV3 ATTACHMEN+ m3+hod";
$lang['forumsettingsupdated'] = "f0RuM s3Tt1NG5 5UCCE5spHULly upd4t3D";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0\$t eDIt +iMEoUT</b> IS +3h +1mE iN HOUR\$ @Ph+ER PO\$T1N9 +H@+ @ Us3R C@N ED1T THeIr P0sT. If 53T +0 0 +H3Re i5 n0 LIM1T.";
$lang['forum_settings_help_11'] = "<b>m4X1MUM POs+ L3N9+H</b> 1S +hE m@xIMUm NUM8ER oF CH@r@C+Ers th@+ W1LL 83 d1\$Pl4YEd 1N 4 PO\$+. ipH 4 P0s+ 1\$ L0Nger TH4n ThE NUm8Er opH CH4R4C+3R5 d3FiN3d h3RE iT WILl 83 cU+ SHoR+ @ND A LiNK 4Dd3D To TH3 8o+ToM +O @LLoW U5Er5 +O R3@d TEh WH0L3 Po5T oN A 53p4R4+3 P@93.";
$lang['forum_settings_help_12'] = "1F j00 Don'T W4N+ YOUR U\$ER5 to 83 48LE +O CR34+e P0lL\$ j00 cAN D1S48lE +3H 4bov3 Op+10n.";
$lang['forum_settings_help_13'] = "+HE LiNK\$ 53CT10n oPh 833h1V3 PR0vIDEs 4 Pl4Ce PH0R Y0ur U53R\$ +0 mAInt@IN 4 LisT 0pH 5I+ES +H3y FR3qU3N+ly V151t TH4T 0tH3R UsErs M@Y FInd u\$3PHuL. L1Nks c@N B3 D1v1DeD iNto C@+E90R13\$ bY f0lDEr @nd @Ll0W pHoR COMM3N+s 4nd R4+InGS T0 Be 91VeN. 1N oRDER +o M0Der4+3 +H3 LInK5 s3C+1On 4 U53R Mus+ BE R4NtED GlOB4l MOd3R@TOr S+@+U5.";
$lang['forum_settings_help_15'] = "<b>\$3sS1on cUT 0fF</b> Is +H3 m4ximUm +Im3 8EPhOR3 4 Us3R'S \$35\$Ion i5 d33M3d D34d 4ND +HeY @R3 lo99ED OU+. by D3pH4uL+ +HI\$ 1\$ 24 H0UrS (86400 \$3CONDs).";
$lang['forum_settings_help_16'] = "<b>@C+1v3 s3s5IOn Cu+ ofpH</b> 1\$ +h3 M4XimUm +iM3 B3PH0R3 @ UsER'5 S3ssiON is De3M3d 1N4CTIv3 @+ WHICH poINT ThEY En+eR @n 1dLe ST4T3. 1N TH1\$ \$+4TE th3 u\$ER REM41N\$ Lo99Ed 1N, bu+ +H3y ARE REM0v3D PHrOm +3H @c+IVe U\$ER5 l15T In t3h st@+s dISpL4Y. OnC3 +Hey 83CoMe 4cTIV3 @9AIn th3y w1LL B3 RE-4dDeD +o +h3 Li\$+. By d3f@ULt +H15 53TT1Ng 1\$ Set to 15 MInUTE5 (900 sECond\$).";
$lang['forum_settings_help_17'] = "eN4BLinG +hiS 0PT1oN 4Ll0ws bEeh1V3 t0 iNCLudE A \$+4T5 d1sPL4Y @+ T3H 8Ottom oPh +hE M35\$@9E5 p4N3 \$1M1lAR +o tHE 0N3 usED 8Y M4Ny PH0rUM \$OpHTW4rE tI+L3\$. 0NCE 3N48l3D The D1\$PL4y oF T3H S+4+s P4g3 C4N B3 toG9LEd 1ND1vIDu4LLy BY 34CH U5ER. 1Ph THEy DoN'+ W4nT +O sEe 1t THey C@N HId3 1+ FroM Vi3w.";
$lang['forum_settings_help_18'] = "pER5oN@L M35\$493\$ 4RE InV4LU48lE 4S 4 W4Y 0Ph +4K1n9 MOR3 Pr1V@+E M4tTer5 ouT opH VI3W 0F +3h oThEr m3m83rS. hoWeV3R If J00 DoN'+ W4N+ YoUr UseRs +o BE @BLe To 53Nd EAcH 0Th3r P3rson@l ME5\$4gES J00 C4N DIS4Bl3 Th1s 0PtI0N.";
$lang['forum_settings_help_19'] = "P3R5On4l M3\$\$4G35 C4N 4L50 cON+4IN 4++4ChMEN+S WH1CH C4N B3 Us3pHUL PHOr ExCh4N9IN9 fIL3\$ 8eTWe3N U5Er\$.";
$lang['forum_settings_help_20'] = "<b>n0+3:</b> +h3 SP4C3 4llOc@+i0N PHor PM @+T4CHMen+S 1\$ t@KEN FR0m 3@cH U\$3r\$' m4IN 4T+4ChM3N+ 4LLoC4+ioN @nd 1+ N0+ IN @DdIt10N +O.";
$lang['forum_settings_help_21'] = "th3 Gu35T @cCOUnT @LL0Ws Vi51+0R5 T0 yOuR PH0ruM +0 R34D P0sTs w1+HoU+ H4V1NG +o 5I9N Up FoR @n @cCOUnT.";
$lang['forum_settings_help_22'] = "1F J00 PREFeR J00 C4N 4L\$o 5E+UP Y0UR 8eEH1V3 fORUm So TH@+ 9u3S+5 @RE 4U+0M4tiCALly l0G9eD iN. oNcE @ usER RE9I5TeR5 +HeY WIlL @lW4Ys 8E \$HowN +EH L091N 5CR33n @S Lon9 4\$ THeIR Co0kIE\$ R3M@1N In+4CT.";
$lang['forum_settings_help_23'] = "BeEHIvE ALLOW5 4+t4CHM3nTS +0 83 uPl0aD3D tO M35s4935 whEn Po\$+3D. 1ph J00 h@ve L1mIT3D W38 \$P4Ce J00 mAY WHicH TO Di\$ABLe 4++4Chm3NT5 bY cL34r1N9 +hE B0x 4boV3.";
$lang['forum_settings_help_24'] = "<b>@+T4cHMEn+ dIr</b> 1\$ +hE LOC4+1oN BE3HIV3 5HOulD \$+OR3 1t's @+t4CHm3N+5 in. TH1S d1reC+0RY MuS+ 3Xis+ oN Y0Ur W3B 5PAcE 4Nd MU\$+ 83 wR1T@BLe bY +H3 WE8 53RvER / PHp PR0c3ss o+HERw1Se Upl04DS wILl fA1l.";
$lang['forum_settings_help_25'] = "<b>atT@Chm3n+ SP@ce PER Us3R</b> Is tH3 M@x1mUM @MoUNT OPH DI\$K \$PAC3 4 US3r H45 PHoR @++4cHm3N+s. Once +h1\$ Sp4C3 1\$ Us3d uP Th3 u\$3R C4nNO+ upL0@D @Ny M0RE 4Tt4CHMenTs. bY DePH4Ul+ Th1s I\$ 1M8 0Ph 5P4cE.";
$lang['forum_settings_help_26'] = "<b>@LLow 3M83Dd1nG OPH @+T4CHM3nTS IN ME5s493s / S1Gn@+uR3\$</b> Allow5 U53R5 T0 3MBED 4++@cHm3N+S in P0S+s. en48L1N9 +h15 0P+ioN wH1le uSephUL C@n INcRE4S3 YouR B4NdW1dtH U\$@9E Dr@sT1CaLLY uNDEr C3RT@1N COnpHIgUR4+1oNS oPH phP. If J00 HaV3 LiMItED B4NdW1D+h 1+ iS ReCoMm3nD3D ThaT J00 D1S@8le +His oPtI0n.";
$lang['forum_settings_help_27'] = "<b>usE 4L+3rN4TIVE 4Tt4CHM3Nt mE+HOD</b> pHORC35 8eeH1V3 t0 U53 @n 4l+eRN4+1v3 ReTr1Ev4L m3THoD PHoR 4+T@CHMEn+s. If J00 r3C3IVe 404 ErRoR M3\$\$49E5 wH3N +rYIn9 to D0WnL04D 4T+4CHm3Nt\$ PhR0M M3\$\$a93s +RY 3N@8LinG Th1\$ 0Pt1ON.";
$lang['forum_settings_help_28'] = "+hI5 \$EtT1NG @Ll0wS yOuR PH0RuM To 83 \$p1DeR-3D 8Y s3@Rch 3nG1nEs l1kE 900GL3, al+4VIST@ 4Nd Y@H0o. 1PH J00 5WI+Ch ThI\$ OpT1on oPhf YOUr PH0ruM wiLL N0+ 8E INClUdED 1N ThEsE s34RcH EnG1NE\$ REsuL+s.";
$lang['forum_settings_help_29'] = "<b>4LL0w neW U\$3r rE91stR4T10ns</b> 4LL0W\$ 0R dIs4LL0wS TEH cRe@+ION oPH N3W u5ER 4CCoun+s. \$ET+INg TH3 0PT1oN +0 N0 C0MPlE+3Ly DIs@BLe5 +3H RE91S+RaT1oN PHORm.";
$lang['forum_settings_help_30'] = "<b>eN4BLE WiKIW1k1 1N+39R4+ioN</b> PRoV1DEs W1k1WORd \$upporT 1n YOuR FOrUM Po5+s. @ W1K1W0Rd i\$ M4dE Up OF Tw0 Or MoR3 C0NC@+3N4t3D w0Rd\$ W1+h UPpErC45E LE+T3RS (oF+En R3fERrEd +0 4S C4M3LC4\$e). iF J00 WRiTe @ WORD TH15 w4Y 1T w1Ll AUtoM4TiC4LlY B3 CH@nGED INT0 @ HYpErLInK PoIn+iNG tO Y0UR CHOs3N W1k1wIKi.";
$lang['forum_settings_help_31'] = "<b>en48L3 wIKIWIK1 QU1cK l1NK\$</b> 3N48L3\$ +h3 Us3 0pH m\$G:1.1 4Nd u5ER:LO90n sTyL3 ExTeND3D W1kIl1Nk\$ WH1Ch cR34Te HYpeRL1Nk5 +0 ThE \$p3CiF1eD M35s4G3 / u5ER PrOfiL3 oPH tH3 SpEc1PhI3D USER.";
$lang['forum_settings_help_32'] = "<b>WikiWiki Location</b> is used to specify the URI of your WikiWiki. When entering the URI use [WikiWord] to indicate where in the URI the WikiWord should appear, i.e.: <i>http://en.wikipedia.org/wiki/[WikiWord]</i> would link your WikiWords to <a href=\"http://en.wikipedia.org/\" target=\"_blank\">Wikipedia.org</4 >";
$lang['forum_settings_help_33'] = "<b>ph0RuM 4cC3S\$ \$t@TU\$</b> c0NTR0L\$ H0W U\$ERS m@y @CC3s\$ Y0Ur FOruM.";
$lang['forum_settings_help_34'] = "<b>OP3n</b> W1lL 4ll0W 4ll U\$3R\$ ANd 9u35ts @cc3sS to YoUR F0RuM WI+hOut r3sTRICTI0n.";
$lang['forum_settings_help_35'] = "<b>cl05ED</b> preV3nt\$ @CC3SS fOR 4Ll useRS, WI+H +h3 EXCepti0n oPH +HE @dMin Wh0 m4y 5T1LL @cC3S\$ +H3 AdMIN P4N3l.";
$lang['forum_settings_help_36'] = "<b>r3str1CT3d</b> 4ll0Ws TO S3+ A lI\$t 0PH U\$er5 Wh0 @rE @ll0weD 4cc3\$S +o y0UR phOrUM.";
$lang['forum_settings_help_37'] = "<b>p4S\$worD pR0t3C+3d</b> 4lLOWs J00 TO \$3+ 4 P@\$sw0Rd +O 9iV3 0uT +0 u5Er5 S0 +hEy C4n @cCeSS y0UR pHoRuM.";
$lang['forum_settings_help_38'] = "WhEn \$eTT1ng rE\$tRIc+3D OR P@5SWOrd prO+3Ct3D m0DE j00 W1LL n3ED +0 \$AVE Y0ur Ch4n93S 83foRe j00 c4n ch4n9E +He U\$eR @cc3SS PR1V1lE935 OR p4s5W0rd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fr0m kilLing +eh SErv3R.";
$lang['forum_settings_help_40'] = "<b>Po\$T fR3qU3NcY</b> i\$ THe m1Nimum tim3 @ uS3R must W4It b3pH0re thEY C@N P0\$+ a94iN. thi5 SeTT1ng @Ls0 ApHfEcT\$ +hE Cre4+1oN oPH PoLLS. s3+ to 0 to D15A8Le TH3 R3s+RICT10N.";
$lang['forum_settings_help_41'] = "+3h A80v3 0pT10Ns CH@N93 Th3 DEf4ULT V4lU3\$ f0r T3H UsER R3G15TR4TIoN PHorM. WHEr3 4Ppl1CABlE 0TheR 53tt1n9\$ wilL Us3 TH3 pH0RuM'5 oWn D3f@UlT \$E+tIn9\$.";
$lang['forum_settings_help_42'] = "<b>Pr3veN+ usE OPH dUPliCA+3 EM4IL aDDREsS3S</b> f0rcEs beEHIVE +O cH3cK THE usER 4CC0UN+s 4G41N5+ TEh eM41L @DdR3\$5 The usEr I5 R391S+3RIn9 w1+h @ND PromP+S tHEM T0 u\$e @NOtH3R 1ph I+ 1\$ 4LRE4dY IN USE.";
$lang['forum_settings_help_43'] = "<b>R3QUIrE 3m41L c0Nf1RM4t1On</b> wh3N EN@8LED W1ll 5EnD 4n 3m4Il +0 EACh n3W u\$Er W1+H @ l1NK +H@T c4N b3 usEd +0 COnpHIRm Th31r 3ma1l 4ddR3\$S. uNt1l ThEY coNPhIRM th3Ir em41L @DDR3\$S THeY WiLl NOt 83 48L3 +O po\$T UNl3SS +HeIR u\$3r P3rM1551On\$ 4r3 Ch4N93D m@NU@lLy 8Y @n 4DMIn.";
$lang['forum_settings_help_44'] = "<b>usE TExt C4ptCH4</b> prE53ntS THe n3w U\$3r wi+H 4 m4nGLEd IM@9e WhiCH +h3y MU\$T CopY 4 nUmB3r fr0M iNto A +3x+ f1eLd 0N +3h RE9isTr4+1oN foRM. U\$e +HIs 0PTi0N +0 pR3venT 4UTOM@teD \$1gN-uP V1A SCr1P+\$.";
$lang['forum_settings_help_45'] = "<b>+EXt C4P+CH4 DiRECToRY</b> \$PecIFI3S T3h L0C4T10N Th4T 833HIV3 WILL stor3 I+'5 +3XT C4P+CH4 1M4Ge\$ 4Nd FoNts In. Th15 DiR3C+0RY MusT 8e Wr1+4Bl3 8Y TH3 WEB sERv3R / PHp PROc3s\$ @Nd Mu\$t b3 4cc3ss1BLe V1@ hT+P. 4f+3R J00 H4V3 3N48LED TexT C4p+CH4 J00 Mus+ UpL04d \$0ME TrU3 +YP3 f0nts iN+0 THe PHonTS \$UB-D1REC+oRY oPH Y0uR M41N +eX+ c4PtCH4 d1R3CtoRY o+Herw1sE 833hIv3 W1lL Sk1p th3 +3x+ C4PTcH4 DuR1N9 U53R Re915TR4+IoN.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"T3H c0D3.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "4Id N0+ 5p3ciPh13D.";
$lang['upload'] = "uplo4D";
$lang['uploadnewattachment'] = "upLo@D NEw @+t@ChM3Nt";
$lang['waitdotdot'] = "w4i+..";
$lang['successfullyuploaded'] = "SUcc3S\$fULlY UpL04DEd";
$lang['failedtoupload'] = "ph41LEd t0 upL04d";
$lang['complete'] = "c0mPlEte";
$lang['uploadattachment'] = "upL0@D 4 f1l3 F0R @+T4cHmeNT to +h3 m3SS4G3";
$lang['enterfilenamestoupload'] = "3nT3R Ph1LEN4mE(S) +0 uPlo4D";
$lang['attachmentsforthismessage'] = "4++4ChMEN+5 fOR THIs M35\$4Ge";
$lang['otherattachmentsincludingpm'] = "OTH3r 4+t@cHMeNt5 (1nCLUD1N9 pm m3sS493s @nD OthEr f0ruMs)";
$lang['totalsize'] = "To+4L S1Z3";
$lang['freespace'] = "fR33 \$P4c3";
$lang['attachmentproblem'] = "tHeRE w4\$ 4 pr08Lem doWNL04D1Ng +H1s 4+t@cHMENt. PleAs3 +rY a94iN l4T3r.";
$lang['attachmentshavebeendisabled'] = "4+T@CHM3nts HAV3 833n D1\$4bLEd bY THE PHOrUM 0WNEr.";
$lang['canonlyuploadmaximum'] = "J00 C@n OnLy Uplo@D 4 m4XimUM opH 10 PHIL35 A+ @ +1ME";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@5sWoRD cH@N9ED";
$lang['passedchangedexp'] = "Y0UR p4\$SW0RD h@\$ 8E3n CH4N93d.";
$lang['updatefailed'] = "uPD4+3 faIleD";
$lang['passwdsdonotmatch'] = "P4SSWoRd\$ DO no+ m@+cH.";
$lang['allfieldsrequired'] = "4LL PH13LDs @Re R3QuiR3D.";
$lang['requiredinformationnotfound'] = "requ1r3d iNForM@+1oN No+ foUNd";
$lang['forgotpasswd'] = "pHOR90+ P@5sw0Rd";
$lang['enternewpasswdforuser'] = "3NTer 4 N3W P@\$SW0Rd PH0R U\$3r";
$lang['resetpassword'] = "REs3+ p@\$SWoRD";
$lang['resetpasswordto'] = "r3S3T P4s5word +0";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "No Me5\$4g3 SPEc1F1ED For D3L3+I0n";
$lang['deletemessage'] = "d3LE+E M35s49e";
$lang['postdelsuccessfully'] = "p0\$+ DEl3+3D sUccES5FuLLY";
$lang['errordelpost'] = "ERr0r dEL3+in9 P05T";
$lang['delthismessage'] = "d3l3Te +H1\$ MeSs4G3";
$lang['cannotdeletepostsinthisfolder'] = "j00 c4nnOt dEl3+3 Po5ts in +His FoLDER";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "N0 M3s5@9E speCipHiED FOr 3DITING";
$lang['edited_caps'] = "eD1TED";
$lang['editappliedtomessage'] = "edI+ 4PPl13D +o M35s4G3";
$lang['errorupdatingpost'] = "3rroR UPd@+INg P05t";
$lang['editmessage'] = "Ed1t MEs\$4g3";
$lang['editpollwarning'] = "<b>noT3</b>: 3d1t1n9 ceRT4IN 4\$P3cTS oPH @ p0Ll w1Ll voID 4LL TEh curr3NT v0TEs @nd 4lL0W PE0Pl3 +o vOt3 49A1n.";
$lang['hardedit'] = "H4Rd ED1+ OP+10ns (VO+3s W1Ll b3 RE\$3+):";
$lang['softedit'] = "S0f+ ED1+ 0P+1ON\$ (VoTEs W1LL 83 R3+4IN3D):";
$lang['changewhenpollcloses'] = "cH@n9E wHEn The p0Ll cL0s35?";
$lang['nochange'] = "NO Ch@NGe";
$lang['emailresult'] = "EM@1L rE\$UL+";
$lang['msgsent'] = "M3s54gE seN+";
$lang['msgsentsuccessfully'] = "M3\$\$@GE 53N+ SUCCE\$sPHuLlY.";
$lang['msgfail'] = "Me5s4G3 fA1L3D";
$lang['mailsystemfailure'] = "M@1L 5YsT3m FAILURE. M35S493 NOt sEN+.";
$lang['nopermissiontoedit'] = "J00 4RE NoT p3RMitT3D To 3DIT +hI5 M3ss@9E.";
$lang['pollediterror'] = "j00 C4NNo+ Ed1T poLLs";
$lang['cannoteditpostsinthisfolder'] = "j00 C@nN0t 3d1T p0\$TS IN TH1s F0lD3R";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "no Us3R SpEC1f1ED for EM4Il1N9.";
$lang['entersubjectformessage'] = "En+3R @ SUbj3c+ fOR Th3 ME\$\$4Ge";
$lang['entercontentformessage'] = "3N+3r \$oM3 c0N+3N+ Ph0r tHE Me5sa9E";
$lang['msgsentfromby'] = "THIS ME\$\$4G3 W@\$ \$3NT fROM %s bY %s";
$lang['subject'] = "\$UBJ3CT";
$lang['send'] = "\$3ND";

$lang['msgnotification_subject'] = "Me554Ge N0TIf1C@+1oN Fr0M";

$lang['msgnotificationemail_1'] = "p05ted 4 m3ss4gE +0 j00 0N";
$lang['msgnotificationemail_2'] = "tH3 \$U8JEc+ i\$:";
$lang['msgnotificationemail_3'] = "T0 Re@d TH4+ M3sS4GE 4Nd 0+H3r5 1N +h3 S4Me di5cUSSioN, g0 TO:";
$lang['msgnotificationemail_4'] = "No+E: 1F J00 D0 N0+ W1sH To R3c3IVe 3M@IL No+IfiCaT1oNs 0PH fORuM";
$lang['msgnotificationemail_5'] = "M3\$\$@gEs PO5TED TO Y0U, Go TO:";
$lang['msgnotificationemail_6'] = "cL1ck 0n mY C0NTROLs +HeN EM41L @ND pR1V4Cy, UN\$3l3cT +hE Em41L";
$lang['msgnotificationemail_7'] = "n0TIf1cA+1oN cH3cKB0x @nD pR35s \$U8m1+.";

$lang['subnotification_subject'] = "5u8scRiPTioN N0+1F1C4+ION FR0M";

$lang['subnotification_1'] = "P05teD 4 M35S49E 1n 4 ThR34D j00 H4V3 \$u8\$CR1b3D +0 0n";
$lang['subnotification_2'] = "TEH \$U8Ject i5:";
$lang['subnotification_3'] = "+O RE@d TH@T m3sS@9E 4Nd OTH3Rs iN +H3 s4m3 D1scuSsi0N, GO T0:";
$lang['subnotification_4'] = "No+E: IPH J00 DO NO+ wI\$H +O r3CeIv3 EM4IL N0+iF1C4+1ON5 opH n3W";
$lang['subnotification_5'] = "mESS49ES 1N +HI\$ tHR3AD, G0 +0:";
$lang['subnotification_6'] = "AND 4dJu\$T YoUR 1N+ER35T lEV3L 4+ tH3 80TtOm OF THe p4GE.";

$lang['pmnotification_subject'] = "PM nO+1F1C@TIoN PHRoM";

$lang['pmnotification_1'] = "POst3D 4 PM t0 J00 0n";
$lang['pmnotification_2'] = "tHe 5uBJ3CT 1\$:";
$lang['pmnotification_3'] = "to r34D ThE M3s549E 9O To:";
$lang['pmnotification_4'] = "N0T3: 1F j00 D0 N0T W1\$h +0 Rece1ve em4IL N0t1pHIc4t10NS oPh N3W Pm";
$lang['pmnotification_5'] = "me\$5@GES Po\$Ted tO yoU, G0 to:";
$lang['pmnotification_6'] = "CLICK mY c0n+R0ls TH3N EM4iL 4Nd PR1v@cY, UNs3L3c+ th3 pM";
$lang['pmnotification_7'] = "nO+If1C4+10n cH3CkB0X @ND PREss 5U8MiT.";

$lang['passwdchangenotification'] = "paS\$W0Rd ch4NGE NOt1FIc4T10N FR0m";

$lang['pwchangeemail_1'] = "+hi5 4 NOT1fIC4T10N EM4IL TO InPhoRm J00 th@+ Y0uR P4s5WOrD On";
$lang['pwchangeemail_2'] = "h4s 83En CH@n9ED.";
$lang['pwchangeemail_3'] = "It ha5 8E3n cH4n93D TO:";
$lang['pwchangeemail_4'] = "and w@S CH4nG3d 8y:";
$lang['pwchangeemail_5'] = "IF j00 h4V3 RECe1VEd +HI\$ 3M4IL in eRR0R 0R WeRE N0T 3xP3CTiN9";
$lang['pwchangeemail_6'] = "a Ch4NG3 +O YoUr P@\$sW0RD Ple45E coN+4C+ +3h FoRUM 0wn3R Or 4 MODERATor oN";
$lang['pwchangeemail_7'] = "imMeDI4TeLY To c0RR3ct 1T.";

$lang['hasoptedoutofemail'] = "h4\$ oP+3D OuT 0f 3M4IL CON+AcT";
$lang['hasinvalidemailaddress'] = "HAS 4N INVaLID 3M41l @DDR3S5";

$lang['emailconfirmationrequired'] = "EM@iL CoNPH1rm@+1oN R3QU1rED";

$lang['confirmemail_1'] = "hELL0";
$lang['confirmemail_2'] = "j00 R3cENtLY cR34+3D @ NEW UsER @cC0UNt 0N";
$lang['confirmemail_3'] = "b3foR3 J00 c@N \$T@r+ POSTIN9 W3 n33D TO c0Nf1RM YOur 3M@IL 4dDR3sS.";
$lang['confirmemail_4'] = "d0n'+ woRRY +h15 I\$ quITe E4\$Y. ALl J00 NEed +0 DO I\$ cLICk THe L1NK";
$lang['confirmemail_5'] = "b3L0W (OR coPY @ND P@\$tE IT 1N+o y0Ur 8r0WS3R):";
$lang['confirmemail_6'] = "0nC3 C0NPhIRM4tIoN Is coMpl3te J00 m4Y L0g1n 4Nd 5tar+ pOS+ing imm3D14+3ly.";
$lang['confirmemail_7'] = "ipH J00 Did No+ CRE4TE 4 U\$3R 4cCOUNT 0N";
$lang['confirmemail_8'] = "ple4SE 4CCEP+ 0uR @P0L091Es @nD f0RW@RD THI\$ EM4Il +O";
$lang['confirmemail_9'] = "\$0 tHat the soUrC3 0F 1T M4y be INVEs+Ig@+ED.";

// Error handler (errorhandler.inc.php) --------------------------------

$lang['retry'] = "r3tRy";

// Forgotten passwords (forgot_pw.php) ---------------------------------

$lang['forgotpwemail_1'] = "J00 R3QU3\$t3D THI\$ E-m4IL pHrOM";
$lang['forgotpwemail_2'] = "8EC4u\$3 J00 H4V3 f0R90T+3N YOuR P4\$sw0RD.";
$lang['forgotpwemail_3'] = "cL1cK TH3 lInK bELow (0R c0Py 4nD P4\$Te I+ iN+0 y0Ur bROW53R) T0 ResE+ Y0Ur p@S5WORd";
$lang['passwdresetrequest'] = "YOuR P45sWOrd Re5E+ REqUE5+";
$lang['passwdresetemailsent'] = "P4\$\$woRD Re53T E-mA1L \$eN+";
$lang['passwdresetexp'] = "j00 Sh0uLd ReceIvE 4N E-M41l CoNt41N1NG 1NS+rUcT1oNs FoR Re\$E++iNG Y0uR P4s\$WoRd \$h0R+Ly.";
$lang['validusernamerequired'] = "4 v4L1D Us3Rn@mE IS REQuIRed";
$lang['forgottenpasswd'] = "Ph0R90+ P4sswORd";
$lang['forgotpasswdexp'] = "1f j00 H4v3 fOR9O++3N yOur P4S5woRd, j00 c@N requE\$+ +0 h4ve 1t r3se+ 8Y enTeRINg YoUR Log0N N@Me BEl0W. 1n5+RuC+1oNS 0N HoW tO rEsET Y0uR p4sswoRD w1LL 8E S3N+ +o YoUR rE91\$T3R3D 3M41L 4DDr35S.";
$lang['couldnotsendpasswordreminder'] = "CoULd N0+ 53Nd P@5SW0RD rEmInD3R. pl34sE c0N+@C+ +He FoRuM 0WNER.";
$lang['request'] = "Requ3sT";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "3m4IL COnF1Rm4TIoN";
$lang['emailconfirmationcomplete'] = "+H4Nk J00 fOR conPHirMIN9 Y0Ur 3m41L AdDREs\$. J00 M4Y NoW l0G1N 4Nd \$+4R+ P0S+1NG IMmEDi4TElY.";
$lang['emailconfirmationfailed'] = "3m4il c0NF1RM@+1ON h@s F41l3d, PL3@\$3 try 4G@1n l4T3r. IF j00 ENC0Un+Er TH15 eRR0R MUL+1PLE TIME5 PLE4s3 c0n+4Ct +He foRUM own3R 0r 4 M0D3R4toR F0R 4s5i\$+AnCe.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "+Op LEvel";
$lang['maynotaccessthissection'] = "j00 M4Y N0+ @CCe5s TH15 \$3CTIon.";
$lang['toplevel'] = "toP lEv3L";
$lang['links'] = "LiNks";
$lang['viewmode'] = "V1eW M0dE";
$lang['hierarchical'] = "hi3r@RCH1C4L";
$lang['list'] = "lisT";
$lang['folderhidden'] = "Th1\$ PH0LD3R 1S H1DD3N";
$lang['hide'] = "H1D3";
$lang['unhide'] = "UNHID3";
$lang['nosubfolders'] = "nO \$UBpHOLdErS IN ThiS C4T390rY";
$lang['1subfolder'] = "1 sU8PH0Ld3r in +h15 C4T3g0RY";
$lang['subfoldersinthiscategory'] = "sUBPH0LD3Rs In +h1S c@+3GOrY";
$lang['linksdelexp'] = "3NtR13s iN 4 d3L3+ed FOLd3r wILL b3 M0VED to ThE p4RenT F0lD3R. oNLy fOLD3R5 wHiCh Do noT C0N+4IN sU8F0lD3R\$ m4Y B3 DEL3TeD.";
$lang['listview'] = "Li\$+ V13W";
$lang['listviewcannotaddfolders'] = "c4nn0+ @dD PhOLD3rS IN +h1s V1EW. \$HoW1Ng 20 ENTr13s 4+ 4 +IM3.";
$lang['rating'] = "r4tING";
$lang['commentsslashvote'] = "coMM3n+S / VoT3";
$lang['nolinksinfolder'] = "No L1nKs 1N Th1\$ PhoLdEr.";
$lang['addlinkhere'] = "4Dd l1Nk H3r3";
$lang['notvalidURI'] = "thAT 1s N0T @ V4LId Uri!";
$lang['mustspecifyname'] = "J00 MUs+ \$p3CipHy 4 n@Me!";
$lang['mustspecifyvalidfolder'] = "J00 MusT sPECIfY @ V4L1D f0LD3R!";
$lang['mustspecifyfolder'] = "J00 Mu5T \$pEC1PHY 4 F0LdeR!";
$lang['addlink'] = "@DD @ L1nK";
$lang['addinglinkin'] = "@DdIn9 LINK 1N";
$lang['addressurluri'] = "@DDReS\$ (URl/UR1)";
$lang['addnewfolder'] = "4dD A NEw PHOLD3R";
$lang['addnewfolderunder'] = "@dDIN9 NEw FOlDeR UND3R";
$lang['mustchooserating'] = "J00 mu\$+ CHoO5E @ R4TINg!";
$lang['commentadded'] = "y0Ur coMM3NT W45 @DDED.";
$lang['musttypecomment'] = "j00 MUs+ +YP3 @ c0MM3Nt!";
$lang['mustprovidelinkID'] = "j00 mU5T pRoV1DE 4 liNk Id!";
$lang['invalidlinkID'] = "1nv4lID lInk 1D!";
$lang['address'] = "@DDre55";
$lang['submittedby'] = "\$UbmITT3D bY";
$lang['clicks'] = "cLicK\$";
$lang['rating'] = "r4+1Ng";
$lang['vote'] = "V0+3";
$lang['votes'] = "VoTEs";
$lang['notratedyet'] = "NOT r4+3D By AnYOne Y3t";
$lang['rate'] = "R@tE";
$lang['bad'] = "84D";
$lang['good'] = "9oOd";
$lang['voteexcmark'] = "VOTE!";
$lang['commentby'] = "c0MMEn+ 8Y";
$lang['addacommentabout'] = "4dd @ CoMMeNT 480Ut";
$lang['modtools'] = "M0dEr4T10N T00Ls";
$lang['editname'] = "3d1+ N@Me";
$lang['editaddress'] = "ed1+ @dDR355";
$lang['editdescription'] = "Ed1T d35CRIPTION";
$lang['moveto'] = "m0ve T0";
$lang['linkdetails'] = "LiNK De+41Ls";
$lang['addcomment'] = "@dD c0Mm3n+";
$lang['voterecorded'] = "yOuR V0+3 H4s 833n R3coRd3D";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "USER iD";
$lang['alreadyloggedin'] = "4lR34DY L099eD IN";
$lang['loggedinsuccessfully'] = "j00 LO99ED iN sucC3\$sfUlLy.";
$lang['presscontinuetoresend'] = "PR3ss coN+iNU3 T0 R3s3ND f0Rm D@+@ oR C@NC3L TO R3LO4d P@g3.";
$lang['usernameorpasswdnotvalid'] = "+H3 U53rN4ME Or P45\$WORd j00 \$UPPLI3D 1S N0T v4liD.";
$lang['pleasereenterpasswd'] = "Pl3@53 Re-EN+ER Y0UR p@\$sWoRd And +RY 4941N.";
$lang['rememberpasswds'] = "ReMem8Er pA\$sWoRdS";
$lang['rememberpassword'] = "R3MeMB3r P@5sW0RD";
$lang['enterasa'] = "3N+3R 4s 4 %s";
$lang['donthaveanaccount'] = "D0N'+ H4VE 4N @CCoUNT? %s";
$lang['registernow'] = "R39IsTER N0W.";
$lang['problemsloggingon'] = "PrO8LeM\$ LO9g1Ng 0n?";
$lang['deletecookies'] = "D3LE+E c00K1ES";
$lang['cookiessuccessfullydeleted'] = "COOK1E5 SUCcEssPhully dELE+3d";
$lang['forgottenpasswd'] = "FOR90+T3N y0UR P@\$\$woRd?";
$lang['usingaPDA'] = "u\$1NG 4 pD4?";
$lang['lightHTMLversion'] = "LIgh+ HTML VERsI0n";
$lang['youhaveloggedout'] = "j00 H4Ve l09GeD oU+.";
$lang['currentlyloggedinas'] = "j00 @r3 cURRenTLY log9ED 1n AS";
$lang['logonbutton'] = "LO90n";
$lang['otherbutton'] = "othEr";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "MY F0RUM\$";
$lang['recentlyvisitedforums'] = "RECEn+lY v1sITED PHORUMs";
$lang['availableforums'] = "aV@1L4Bl3 f0RUms";
$lang['favouriteforums'] = "pH@VoURIt3 pHoRum\$";
$lang['lastvisited'] = "LA\$+ V1siTED";
$lang['unreadmessages'] = "UNRe@D Me5S@Ge5";
$lang['removefromfavourites'] = "rEM0V3 FR0m f@V0UrI+35";
$lang['addtofavourites'] = "4Dd To f@v0URI+3\$";
$lang['availableforums'] = "@vAiL48LE PhORuM5";
$lang['noforumsavailable'] = "th3rE ARE no pHoRuMS 4V@1L48Le.";
$lang['noforumsavailablelogin'] = "+H3Re 4RE nO PHoRUMs 4V@iL@8L3. PLe4\$3 LO91N TO VIeW y0Ur f0rUMs.";
$lang['passwdprotectedforum'] = "p@5sWorD prOTECT3d PH0rUM";
$lang['passwdprotectedwarning'] = "Th1s F0rUm 15 P@5SWORd PRo+eCt3D. +0 G@1N aCC35s eN+ER +eH p@\$\$WoRd 83l0W.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0\$T m35S4G3";
$lang['selectfolder'] = "5El3C+ F0lD3R";
$lang['mustenterpostcontent'] = "J00 Mu5T ENT3r soME CoN+En+ pHOR +hE P0s+!";
$lang['messagepreview'] = "ME\$s49e pREV1ew";
$lang['invalidusername'] = "InV@l1d U53rN4Me!";
$lang['mustenterthreadtitle'] = "J00 mUsT 3nT3r @ +ItLE PHoR T3h +hR34D!";
$lang['pleaseselectfolder'] = "pLE4s3 S3L3CT 4 FoLD3r!";
$lang['errorcreatingpost'] = "3rR0r Cr34+ING po5T! pLE4s3 +Ry 494iN 1N 4 F3W MINuTES.";
$lang['createnewthread'] = "cr34T3 nEW THR34d";
$lang['postreply'] = "po\$T R3PLY";
$lang['threadtitle'] = "THrE4d +1Tle";
$lang['messagehasbeendeleted'] = "me5s4G3 h4S bEeN Del3+3d.";
$lang['pleaseentermembername'] = "plE@\$e 3NT3R 4 MeMb3R N4M3:";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C@Nn0+ P0St THIs +hR3@d TYpE IN +h4+ PHOLd3R!";
$lang['cannotpostthisthreadtype'] = "J00 CANn0+ p05+ +HI\$ +HRE4D +yPE 4s +H3RE 4RE No 4V41LabL3 PH0lD3R\$ +H4T 4lL0W 1+.";
$lang['cannotcreatenewthreads'] = "J00 C4Nn0T CRE4+3 nEW +HRe4D\$.";
$lang['threadisclosedforposting'] = "TH1\$ thR3AD 1s cL053D, J00 C4NNoT pos+ IN It!";
$lang['moderatorthreadclosed'] = "W@RniNG: +HI5 +HRe4D 1s CLOS3d PHoR P05T1Ng +0 NoRM4L uSERs.";
$lang['threadclosed'] = "+HrE@d CLo53D";
$lang['usersinthread'] = "U\$er5 1N THrE@D";
$lang['correctedcode'] = "coRR3C+3D c0De";
$lang['submittedcode'] = "\$UbMi+TeD C0De";
$lang['htmlinmessage'] = "H+ml 1N M3s\$4Ge";
$lang['disableemoticonsinmessage'] = "d1548l3 EmoTiCoNs 1n ME\$s4gE";
$lang['automaticallyparseurls'] = "@U+0m4+ic4LLy p@R5E URl\$";
$lang['automaticallycheckspelling'] = "4U+0M4Tic@LLy cH3CK sPELliN9";
$lang['setthreadtohighinterest'] = "\$3T THRE@D TO h1GH IN+3Re\$+";
$lang['enabledwithautolinebreaks'] = "eN@8LED w1TH @U+o-LiN3-bR34K5";
$lang['fixhtmlexplanation'] = "tH1\$ pHORum US35 H+Ml pHil+3R1Ng. Y0UR 5u8M1+T3d H+ml h4S b3EN MOd1PHi3D 8y +3H PH1l+3R\$ 1N \$oM3 W4Y.\\N\\NTo V1Ew Y0Ur 0RIg1N4L C0D3, s3L3Ct TEh \\'Su8mIT+3D CoDe\\' R4d1O 8uT+0N.\\ntO ViEW TH3 ModIFi3D CoD3, \$3l3Ct +eh \\'C0Rr3C+3D C0D3\\' R4dI0 8u++0N.";
$lang['messageoptions'] = "M3Ss49E OPti0N\$";
$lang['notallowedembedattachmentpost'] = "j00 4RE no+ @LL0w3d To 3MBED 4t+4cHMEN+s 1n YoUR P05T\$.";
$lang['notallowedembedattachmentsignature'] = "J00 Are nO+ 4lL0WED T0 3mb3D @++4Chm3Nts In yoUR siGN4TURE.";
$lang['reducemessagelength'] = "ME\$5@9E l3N9+H Mu\$T bE UND3r 65,535 CH@R4CTEr5 (CURReN+lY:";
$lang['reducesiglength'] = "SiGNA+uR3 L3nGTH mUs+ B3 unDer 65,535 CH4R4C+3Rs (CurREn+LY:";
$lang['cannotcreatethreadinfolder'] = "j00 C@NNO+ CrEAT3 NEW ThRE@Ds iN +hIS F0ld3R";
$lang['cannotcreatepostinfolder'] = "J00 c@NNo+ ReplY tO P0s+S 1N +HI\$ PH0LD3r";
$lang['cannotattachfilesinfolder'] = "j00 C4NNo+ P0s+ 4tTACHm3N+s 1N +HI\$ FoLd3R. R3MOV3 4+T@cHm3Nts +0 CoNt1nu3.";
$lang['postfrequencytoogreat_1'] = "J00 c4N 0NLY P0sT ONCE eV3Ry";
$lang['postfrequencytoogreat_2'] = "S3C0Nd\$. PL34sE +RY 4G@1N L4+3r.";
$lang['emailconfirmationrequiredbeforepost'] = "Em4IL COnpHIrM4TiON IS R3QUIrED 8EfOR3 J00 C4n pos+. 1F j00 H4Ve n0+ REcE1V3d @ coNPh1RM4+i0N EM@1L PLe4Se cL1CK +hE BUTt0N 8el0w @nD 4 NeW onE W1LL 83 \$3nT +o Y0u. if YouR 3M@iL 4DDR3S\$ Ne3DS PlE4\$E D0 so 83PHoRE ReQU3St1N9 @ N3W CoNPh1Rm4T1oN Em41L. J00 MaY CH4n93 Y0uR 3M41L 4dDRES5 BY ClICK My CoNTr0L\$ 480V3 @ND +HeN U\$ER d3T@Ils";
$lang['emailconfirmationfailedtosend'] = "cONF1rM4t10N EMaiL ph@1LED to 5ENd. PLe@53 COn+4C+ THE PHoRUm oWnER +o r3CTIfY TH1\$.";
$lang['emailconfirmationsent'] = "CoNf1RM4T1ON eM41l h4s b3En ReS3NT.";
$lang['resendconfirmation'] = "r353Nd CONphiRM4t10n";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN rEplY to";
$lang['showmessages'] = "5HoW mE\$\$4Ge5";
$lang['ratemyinterest'] = "R4TE MY InT3rE\$T";
$lang['adjtextsize'] = "@dJU\$t t3x+ \$IZE";
$lang['smaller'] = "\$M4lLER";
$lang['larger'] = "LaRGer";
$lang['faq'] = "Ph4Q";
$lang['docs'] = "DOC\$";
$lang['support'] = "SupPORt";
$lang['donateexcmark'] = "D0N4Te!";
$lang['threadcouldnotbefound'] = "tHe r3qUE5tED THR34D c0ULd N0+ 83 f0UNd or 4Cc3s5 w4\$ DenI3D.";
$lang['mustselectpolloption'] = "J00 MU5T s3L3CT 4N 0Pt1oN T0 VO+3 F0R!";
$lang['mustvoteforallgroups'] = "j00 mU5T V0T3 iN 3vEry 9R0UP.";
$lang['keepreading'] = "kE3P RE4d1N9";
$lang['backtothreadlist'] = "8ack +O ThRE4D LIsT";
$lang['postdoesnotexist'] = "+h@T poST DOes N0T 3x1st IN +hIs THR34D!";
$lang['clicktochangevote'] = "cLICK +0 cH4N9E vo+3";
$lang['youvotedforoption'] = "j00 vo+3D Ph0R 0p+IoN";
$lang['youvotedforoptions'] = "J00 VOt3d F0R 0PTIoN5";
$lang['clicktovote'] = "cl1Ck +0 v0T3";
$lang['youhavenotvoted'] = "j00 H@VE no+ VOT3D";
$lang['viewresults'] = "V13w resuL+5";
$lang['msgtruncated'] = "mesS4G3 +rUNC4t3D";
$lang['viewfullmsg'] = "vIeW fULL mE\$s4GE";
$lang['ignoredmsg'] = "19norEd M35\$493";
$lang['wormeduser'] = "w0rM3D US3r";
$lang['ignoredsig'] = "I9NoR3D \$1Gn4+UrE";
$lang['wasdeleted'] = "W45 D3LET3d";
$lang['stopignoringthisuser'] = "s+0P 1gN0RIng +hIs UsER";
$lang['renamethread'] = "r3N4Me +hRE4D";
$lang['movethread'] = "m0V3 tHREAD";
$lang['editthepoll'] = "EDI+ +He p0lL";
$lang['torenamethisthread'] = "T0 ReN@M3 tH15 THrE@d";
$lang['closeforposting'] = "ClOs3 PH0r p05t1n9";
$lang['until'] = "UNT1l 00:00 utc";
$lang['approvalrequired'] = "@PpRovAL REQU1R3D";
$lang['awaitingapprovalbymoderator'] = "iS 4W41T1NG 4pPR0V4l BY 4 MOD3R4+0R";
$lang['postapprovedsuccessfully'] = "PoS+ 4Ppr0VED SUCCe\$\$pHuLly";
$lang['approvepost'] = "apPR0vE P0S+ F0R DI\$pL@Y";
$lang['approvedcaps'] = "Appr0V3D";
$lang['makesticky'] = "M@KE STiCKY";
$lang['linktothread'] = "PErm@N3NT LINK tO THIs THR34D";
$lang['linktopost'] = "l1Nk To Po5T";
$lang['linktothispost'] = "liNK +O THi\$ P05T";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "C@NNoT dI\$pL4Y F0Ld3R MODeR@ToRs";
$lang['mustprovidefolderid'] = "V4L1d FoLDEr 1D mU5T 8e PrOv1D3D";
$lang['moderatorlist'] = "m0DErAt0R LI\$T:";
$lang['modsforfolder'] = "M0dERAToRs pH0r F0LDER";
$lang['nomodsfound'] = "no m0D3ra+OR5 F0uND";
$lang['forumleaders'] = "F0RuM Le4D3R5:";
$lang['foldermods'] = "F0lDEr modER@T0RS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "sTar+";
$lang['messages'] = "meS\$@935";
$lang['pminbox'] = "PM 1n8oX";
$lang['startwiththreadlist'] = "\$+ArT P4gE Wi+H ThR34D L1S+";
$lang['pmsentitems'] = "seNT 1+3ms";
$lang['pmoutbox'] = "0UTBOX";
$lang['pmsaveditems'] = "s4Ved It3M5";
$lang['links'] = "L1Nks";
$lang['admin'] = "4dM1N";
$lang['login'] = "L0g1N";
$lang['logout'] = "l090ut";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------
$lang['privatemessages'] = "PriV4Te M35\$4GE\$";
$lang['addrecipient'] = "ADD REC1Pi3nT";
$lang['recipienttiptext'] = "\$Ep@RaT3 R3C1p1En+s 8Y SEm1-c0L0N OR comM4";
$lang['maximumtenrecipientspermessage'] = "thEr3 iS @ l1m1T oPH 10 R3Cip13Nts pER M3\$s4GE. Pl34\$3 @MENd YoUR r3CIpI3NT l1St.";
$lang['mustspecifyrecipient'] = "j00 Mu\$+ \$pECIfy 4T L34St 0nE ReCIP1en+.";
$lang['usernotfound1'] = "UsER";
$lang['usernotfound2'] = "nO+ f0UNd.";
$lang['sendnewpm'] = "\$eNd NEw pM";
$lang['savemessage'] = "\$@V3 MEs54G3";
$lang['timesent'] = "+1m3 sEn+";
$lang['nomessages'] = "nO M3S5493s";
$lang['errorcreatingpm'] = "erROr CRE4+1N9 PM! Pl34S3 TRY 49@iN IN 4 Ph3W mINUT3s";
$lang['writepm'] = "Wr1+e Me5s4gE";
$lang['editpm'] = "EDi+ ME\$\$@Ge";
$lang['cannoteditpm'] = "C@nNo+ ED1T +hIs PM. 1T H4S @lReADy BE3N VI3W3D bY tH3 RECIPI3NT oR THe m3\$s4G3 D03S not Ex1\$t oR I+ 1\$ 1n4cCe5sibl3 8y J00";
$lang['cannotviewpm'] = "CanN0T v1ew PM. ME\$s4ge doE\$ n0+ 3x1\$T 0r i+ i5 1N4CC3\$S1BLE 8Y J00";
$lang['nouserspecified'] = "NO usER 5P3C1F13d.";
$lang['pmnotificationpopup'] = "j00 h@V3 %d NEw PM. w0ulD J00 lIke +O 9O TO YoUr 1nBox noW?";
$lang['youdonothaveenoughfreespace'] = "j00 Do N0t H@vE 3n0U9H PHREE Sp4ce To seND +hI\$ m35S@9E.";
$lang['notenoughfreespace'] = "d03\$ No+ h4Ve EN0UGh PhREe 5P4C3 +0 REc3IV3 +H15 M3ss4G3";
$lang['hasoptoutpm'] = "h4s op+3d Out 0F rEC31vING p3R5ON@L m3sS4G35";
$lang['pmfolderpruningisenabled'] = "PM PHoLd3r prUN1NG i5 3n4BlED!";
$lang['pmpruneexplanation'] = "thIS FoRuM UseS Pm pHOLD3R PRuNiNG. +h3 Me\$\$4G3s j00 H4Ve sToR3D In y0Ur 1Nbox 4nD s3NT i+eM\$\\NPH0Ld3R\$ 4RE \$UBJEc+ +o 4uTOM4+Ic DELETi0n. @Ny M35s@9es J00 WISh +o ke3P sHouLd 83 MoV3d T0\\NYouR \\'\$Av3D ItEMs\\' Ph0lD3R s0 TH@+ +H3y AR3 N0+ DeL3TeD.";
$lang['yourpmfoldersare_1'] = "YOUR Pm PHoLD3R\$ Are";
$lang['yourpmfoldersare_2'] = "FuLL";
$lang['currentmessage'] = "CuRREnT m3SS4G3";
$lang['unreadmessage'] = "UNr3@D Me5s4g3";
$lang['readmessage'] = "r3@D m3ss4gE";
$lang['pmshavebeendisabled'] = "pers0N4L mes549eS H4VE b3en d1s48LeD 8y +3H PHOruM 0WNer.";
$lang['adduserstofriendslist'] = "4Dd Us3RS TO youR FRI3nDS l1s+ +0 H4Ve tHeM 4PP34R In @ DRoP d0Wn ON +H3 PM WrI+3 MES5@93 P49E.";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "MY CONtR0Ls";
$lang['myforums'] = "My PhOrUms";
$lang['menu'] = "MeNU";
$lang['userexp_1'] = "usE TH3 MENu On TeH L3Ft t0 m@N4G3 Y0uR 53TtiN95.";
$lang['userexp_2'] = "<b>usEr d3t@1l\$</b> 4LL0w5 J00 +o cH@nG3 yOUR N4ME, 3Mail 4DDResS @nD P@\$Sw0RD.";
$lang['userexp_3'] = "<b>UseR PROph1LE</b> 4LLoW\$ J00 +O eD1T Y0Ur UsER PRopH1L3.";
$lang['userexp_4'] = "<b>Ch4NGe P4s5wORD</b> 4LLOwS J00 tO cH4NGE Y0UR p@ssWORD";
$lang['userexp_5'] = "<b>3m@1L &amp; pR1V@Cy</b> LeT\$ j00 CH4NGE H0W j00 c4N b3 cOnt4Ct3D oN @nD 0PHf +3H fOruM.";
$lang['userexp_6'] = "<b>FORUM 0P+I0ns</b> LEts J00 cHAnGE HoW +H3 F0Rum L0oK\$ ANd w0rKs.";
$lang['userexp_7'] = "<b>@Tt@CHM3nT\$</b> 4LloW\$ j00 +0 eD1+/D3LE+3 YoUR @+t4CHMEN+S.";
$lang['userexp_8'] = "<b>ed1t 5IGN4TurE</b> L3+\$ J00 Ed1T yoUR s19N4TuRe.";
$lang['userdetails'] = "USer dE+@IL5";
$lang['userprofile'] = "U\$eR PROPHILe";
$lang['emailandprivacy'] = "3m4IL &amp; PRIV4CY";
$lang['editsignature'] = "ED1t sIGn4tUr3";
$lang['editrelationships'] = "ed1T R3L4+ION5hIp\$";
$lang['norelationships'] = "J00 h@Ve NO Us3R R3L@T1oN\$h1Ps Se+ UP";
$lang['editattachments'] = "eD1T ATT@CHmEn+5";
$lang['editwordfilter'] = "eDi+ WOrd fiLteR";
$lang['userinformation'] = "uS3R 1nPH0RMA+IoN";
$lang['changepassword'] = "Ch4NgE p@s5w0rd";
$lang['currentpasswd'] = "cUrREnT P@S5W0Rd";
$lang['newpasswd'] = "N3w p@5sW0Rd";
$lang['confirmpasswd'] = "CoNf1RM p45sWoRD";
$lang['passwdsdonotmatch'] = "p4s5WoRDS D0 No+ matCH!";
$lang['nicknamerequired'] = "N1CKN4M3 1s REQu1REd!";
$lang['emailaddressrequired'] = "Em@iL 4DDResS 15 REQUIreD!";
$lang['logonnotpermitted'] = "lOg0n NO+ pERMIt+eD. cHoOs3 4N0THeR!";
$lang['nicknamenotpermitted'] = "N1ckN4ME n0+ p3RmiTTEd. CHO0\$E 4No+h3R!";
$lang['emailaddressnotpermitted'] = "3M41L adDR3sS NO+ P3Rm1++3d. cH0O53 4NotH3r!";
$lang['emailaddressalreadyinuse'] = "3M41l @DDR3s\$ 4Lr34dY IN u\$3. ChO0\$3 @No+H3R!";
$lang['relationshipsupdated'] = "r3L@TIoN\$h1P\$ UPD4tEd";
$lang['relationshipupdatefailed'] = "ReL4t1OnshIP UpD@+ED FAILeD!";
$lang['preferencesupdated'] = "PrEf3R3ncEs w3R3 suCC3s5pHULLy upD@+3D.";
$lang['userdetails'] = "u5eR DETAIL\$";
$lang['firstname'] = "fIr\$+ n4m3";
$lang['lastname'] = "L4\$+ n4mE";
$lang['dateofbirth'] = "d@TE 0f B1R+H";
$lang['homepageURL'] = "h0M3P49e uRl";
$lang['pictureURL'] = "p1CtUrE UrL";
$lang['forumoptions'] = "F0RUM 0PT1oN\$";
$lang['pmoptions'] = "Pm 0PT1oN\$";
$lang['notifybyemail'] = "N0+IFy 8Y EM41L 0F P05+S to ME";
$lang['notifyofnewpm'] = "n0t1fY 8Y PopUp 0f N3w pM m3\$\$@9Es +o mE";
$lang['notifyofnewpmemail'] = "No+1phY 8Y 3m41L Oph N3W pM M3SS4gEs TO m3";
$lang['daylightsaving'] = "ADjuS+ F0R d4yLIGH+ s@VINg";
$lang['autohighinterest'] = "4U+0M@+ic4LlY M4Rk ThR3aDs 1 p05T 1N As hi9H 1n+Er35+";
$lang['convertimagestolinks'] = "@U+0m4T1C@LLY COnV3RT eMB3DDEd 1M4GE\$ In P05TS 1N+0 l1Nk\$";
$lang['thumbnailsforimageattachments'] = "+hUmbN@1L\$ PHoR 1M@93 @TT@cHmEN+S";
$lang['smallsized'] = "5m4ll s1zeD";
$lang['mediumsized'] = "mEDIUM 5IZeD";
$lang['largesized'] = "l4RG3 \$1ZeD";
$lang['globallyignoresigs'] = "9L084LLy 19Nor3 us3R 51GN4+UrE5";
$lang['allowpersonalmessages'] = "@ll0W O+her U\$Er5 to S3nD M3 PeR5On4l M3sS4GeS";
$lang['allowemails'] = "4Ll0W OTHER U\$3R\$ +O seND m3 eM4ILS VI@ MY pR0PH1l3";
$lang['timezonefromGMT'] = "T1M3 ZOnE";
$lang['postsperpage'] = "p0sTS pEr pAGe";
$lang['fontsize'] = "phonT 5IZE";
$lang['forumstyle'] = "FORUm S+YLe";
$lang['forumemoticons'] = "PhORUm 3M0TICons";
$lang['startpage'] = "s+4Rt P493";
$lang['containsHTML'] = "c0nT41N\$ htmL";
$lang['preferredlang'] = "pR3Ph3RR3d laNGu4GE";
$lang['donotshowmyageordobtoothers'] = "D0 n0T sHOW my 49e 0r d4T3 0Ph Bir+h +o o+HERS";
$lang['showonlymyagetoothers'] = "sHOw 0nLY mY @GE +O 0+H3R5";
$lang['showmyageanddobtoothers'] = "\$HoW b0+h mY 4G3 @nD d4Te 0F bIrTH +0 0THeR5";
$lang['listmeontheactiveusersdisplay'] = "lIS+ M3 On t3H @C+iVE U53r5 D1\$PL@y";
$lang['browseanonymously'] = "bR0W53 F0RuM AN0nYMoU5LY";
$lang['allowfriendstoseemeasonline'] = "8ROWsE 4NoNYMoUSly, bU+ All0W PHRIeNd5 To 5eE M3 4S onLIN3";
$lang['showforumstats'] = "5hoW PHORUM \$T4Ts @T bot+OM 0f m35s4G3 p4N3";
$lang['usewordfilter'] = "3N48lE w0rd PHILTER.";
$lang['forceadminwordfilter'] = "pH0Rce u\$e 0f aDm1N w0RD F1L+3R On 4lL Us3R5 (INc. GU3StS)";
$lang['timezone'] = "+im3 ZoNE";
$lang['language'] = "L@nGU@9E";
$lang['emailsettings'] = "3m4IL 4ND c0nT@c+ SE++1ngS";
$lang['forumanonymity'] = "pHORum AN0NymI+Y \$E+T1N9S";
$lang['birthdayanddateofbirth'] = "81RtHD4y 4ND d@+E oPh b1RTH d1SPl4Y";
$lang['includeadminfilter'] = "iNcLude 4DM1N WoRD PH1l+3R 1n MY l1\$+.";
$lang['setforallforums'] = "S3t PhoR @Ll FOrUM\$?";
$lang['containsinvalidchars'] = "coNT@iN3D INv@LiD Ch4R@C+3r\$!";
$lang['postpage'] = "P05T p@9e";
$lang['nohtmltoolbar'] = "no HTML +00Lb4R";
$lang['displaysimpletoolbar'] = "dI5PL@Y sIMplE H+ML +00lB4R";
$lang['displaytinymcetoolbar'] = "DI\$PL4y WY51wYG HtML t00lB4R";
$lang['displayemoticonspanel'] = "d15pL4Y 3m0tIcoNs P4N3L";
$lang['displaysignature'] = "DIsPL4Y sIGN@+URe";
$lang['disableemoticonsinpostsbydefault'] = "Dis48lE EMO+ICOnS 1N ME\$549E5 8y DEPh4Ult";
$lang['automaticallyparseurlsbydefault'] = "@UtoM4+Ic4LLY pAR5e UrL5 1n M3ss@93s 8y DEPH4Ul+";
$lang['postinplaintextbydefault'] = "Po\$T 1N PlAiN +3xT BY D3FaULT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p05T iN HTML WITh 4U+0-LIn3-BR34K5 8Y D3PH4uLT";
$lang['postinhtmlbydefault'] = "P0\$T iN H+ML bY DEPh@Ul+";
$lang['privatemessageoptions'] = "Pr1V@T3 MeS549E 0PTI0ns";
$lang['privatemessageexportoptions'] = "pR1V4T3 M3ss4Ge 3xP0rT oPT1oN5";
$lang['savepminsentitems'] = "\$@Ve 4 cOpY 0f E4CH PM I S3Nd 1N MY \$3N+ I+EM\$ Ph0Ld3R";
$lang['includepminreply'] = "1nCLUDE MEss4G3 b0Dy WH3N RePlY1NG +o Pm";
$lang['autoprunemypmfoldersevery'] = "Au+O PrUNe My PM FoLDeR5 3vERY:";
$lang['friendsonly'] = "FrIEnds 0NLY?";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "J00 Mu\$T pR0VIDE s0M3 4n5W3R gR0UpS";
$lang['mustprovidepolltype'] = "J00 mU\$T PROvIDE 4 POlL +yPE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 Mu5T Pr0vID3 R3\$uL+s d1sPl4Y TYPE";
$lang['mustprovidepollvotetype'] = "J00 mus+ PRoV1d3 a pOll Vo+3 +YP3";
$lang['mustprovidepolloptiontype'] = "J00 Mu\$T pR0VId3 4 P0LL OPTI0N +YPE";
$lang['mustprovidepollchangevotetype'] = "j00 mU5t pR0vIDE 4 POLl cH4N9E Vo+3 TYPE";
$lang['groupcountmustbelessthananswercount'] = "nuM8Er 0PH @n5WeR gr0UpS mu5+ 83 Le\$s +h@N to+4L NUMBer oPh @NsW3Rs";
$lang['pleaseselectfolder'] = "PLe@53 \$El3C+ @ foLD3R";
$lang['mustspecifyvalues1and2'] = "j00 MUST \$PECipHy V@LU3s PH0R @nsWErS 1 @nD 2";
$lang['tablepollmusthave2groups'] = "t4buL@R F0rM4T pOLls mU\$T H@Ve PR3Ci5ElY +wO V0+IN9 9R0uP5";
$lang['nomultivotetabulars'] = "t4Bul4R Phorm4+ PoLL5 c@NNOT b3 MUlTI-Vo+3";
$lang['nomultivotepublic'] = "pUbLIC b@lLo+s C4NN0+ 83 MUL+1-v0+E";
$lang['abletochangevote'] = "J00 wILl 83 @8LE TO Ch4N9e yoUR V0+e.";
$lang['abletovotemultiple'] = "j00 w1LL 83 48lE +o vo+3 MUl+IpLE timE\$.";
$lang['notabletochangevote'] = "j00 WIll n0+ 83 48le TO CH4Ng3 yOur V0+3.";
$lang['pollvotesrandom'] = "N0+E: POLl V0TeS 4re R@ND0Mly 9EN3R4+ED pH0R PR3v1Ew 0nLY.";
$lang['pollquestion'] = "p0ll qUeS+I0N";
$lang['possibleanswers'] = "po5S18le 4NSWERS";
$lang['enterpollquestionexp'] = "3NTEr +H3 4NsWER5 pH0R yoUR P0lL Qu3sTIoN.. iPH Y0UR p0LL I\$ 4 &quot;YE\$/No&quot; Qu3StI0n, SiMpLY enter &quot;Y3\$&quot; f0R 4N\$WER 1 4ND &quot;N0&quot; FOR 4n\$W3R 2.";
$lang['numberanswers'] = "N0. 4nsWEr5";
$lang['answerscontainHTML'] = "4NSW3rs CoN+4iN HTML (no+ IncLud1NG 5IGNa+URE)";
$lang['optionsdisplay'] = "4n\$W3R\$ d1sPL4Y +yp3";
$lang['optionsdisplayexp'] = "H0W SH0uLD TEh 4N\$W3R\$ 83 PR3s3NTED?";
$lang['dropdown'] = "4s Dr0P-D0WN l1sT(5)";
$lang['radios'] = "@S @ 5Er1e\$ OPH R4DiO bU+TOn\$";
$lang['votechanging'] = "VO+3 CH@N91NG";
$lang['votechangingexp'] = "C@N @ PErSoN CH@NG3 H1\$ 0R HeR V0+3?";
$lang['allowmultiplevotes'] = "4lL0W MuLTIpL3 Vo+3s";
$lang['pollresults'] = "P0Ll ReSuL+s";
$lang['pollresultsexp'] = "HOW WoUld J00 Lik3 To dIsPL4y +He R3SUl+5 0pH Y0UR poLL?";
$lang['pollvotetype'] = "P0LL voTiN9 TYP3";
$lang['pollvotesexp'] = "hoW ShoULD +H3 P0lL 8E C0NdUcTeD?";
$lang['pollvoteanon'] = "4N0NYMOU5lY";
$lang['pollvotepub'] = "PUBlIc 84LLoT";
$lang['horizgraph'] = "H0RiZOn+4L Gr4PH";
$lang['vertgraph'] = "VEr+1c@L 9R@pH";
$lang['tablegraph'] = "t4BuL4R PhOrm@+";
$lang['polltypewarning'] = "<b>w4rN1NG</b>: tHi\$ 1S 4 PU8lIc 8@Ll0T. Y0Ur N4M3 w1LL Be V15I8LE NEx+ TO Th3 0p+IoN J00 vo+3 pHoR.";
$lang['expiration'] = "3xPirA+10N";
$lang['showresultswhileopen'] = "Do J00 w@N+ To SHoW RE\$UlTs WH1LE +3h POlL 1s 0PEn?";
$lang['whenlikepollclose'] = "WhEN WOULD j00 l1KE Y0UR PolL To 4U+0mATic@lly cLo53?";
$lang['oneday'] = "onE D@Y";
$lang['threedays'] = "+hr33 d@y5";
$lang['sevendays'] = "S3v3n D@Y5";
$lang['thirtydays'] = "+h1rTy D@Y5";
$lang['never'] = "n3v3R";
$lang['polladditionalmessage'] = "4dD1t10N4L ME\$S4GE (0P+1on4l)";
$lang['polladditionalmessageexp'] = "Do J00 W4NT T0 1NCLuDe 4N 4DD1T10N4L P05t AfTER Th3 POll?";
$lang['mustspecifypolltoview'] = "j00 Mu\$+ 5pEC1PHY 4 p0LL T0 V13W.";
$lang['pollconfirmclose'] = "4r3 J00 5uRe j00 W4N+ +0 Cl0S3 tHE F0LloWINg POLl?";
$lang['endpoll'] = "3nD POll";
$lang['nobodyvoted'] = "N0boDY Vo+3D.";
$lang['nobodyhasvoted'] = "n0B0Dy H4S VOT3d.";
$lang['1personvoted'] = "1 peR\$0N V0T3d.";
$lang['1personhasvoted'] = "1 P3RS0n H4\$ Vo+3d.";
$lang['peoplevoted'] = "pE0PLE V0+3D.";
$lang['peoplehavevoted'] = "PEoPL3 H@V3 V0t3D.";
$lang['pollhasended'] = "POLl H@s 3nDEd";
$lang['youvotedfor'] = "j00 VO+3D PH0R";
$lang['thisisapoll'] = "+h1\$ 1s 4 P0Ll. ClICk +o vI3W R3\$Ul+\$.";
$lang['editpoll'] = "3d1+ p0Ll";
$lang['results'] = "r35ulTS";
$lang['resultdetails'] = "re5Ul+ D3+41L\$";
$lang['changevote'] = "cH4NGE V0T3";
$lang['pollshavebeendisabled'] = "POlls H4Ve bE3N D1\$ABl3D 8Y +3h ForUm oWN3R.";
$lang['answertext'] = "4nsWeR T3xT";
$lang['answergroup'] = "@NSW3R 9R0up";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "EdI+ pR0pHilE";
$lang['profileupdated'] = "pRoPH1LE UPD@+3D.";
$lang['profilesnotsetup'] = "t3H forUM OWN3r h@\$ no+ seT Up Pr0fiL3S.";
$lang['nouserspecified'] = "N0 Us3R \$PeCif1ED";
$lang['ignoreduser'] = "19NOR3D USEr";
$lang['lastvisit'] = "l4sT V1Sit";
$lang['sendemail'] = "\$3nD 3M@1L";
$lang['sendpm'] = "S3nD PM";
$lang['removefromfriends'] = "r3M0v3 FrOM FrIenD\$";
$lang['addtofriends'] = "@DD to FR1eNds";
$lang['stopignoringuser'] = "S+OP 19noriN9 u53r";
$lang['ignorethisuser'] = "I9n0RE TH1s Us3r";
$lang['age'] = "4gE";
$lang['aged'] = "4geD";
$lang['birthday'] = "b1rtHd4Y";
$lang['editmyattachments'] = "3d1T MY 4T+4CHMEN+5";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORRY, NEw User ReG1\$+R4+ioN5 4RE No+ 4ll0WEd rIGh+ N0W. pL3@\$E Ch3CK 84CK L@+3R.";
$lang['usernameinvalidchars'] = "uS3rN@M3 c@N 0NLY COnT@1N 4-Z, 0-9, _ - ChAR@c+3Rs";
$lang['usernametooshort'] = "U\$3RNaM3 Mu5T 8E 4 mIN1MUM Oph 2 CH@R4C+3Rs LOng";
$lang['usernametoolong'] = "U\$3rN@M3 MU5T B3 4 m4x1MUM opH 15 CH4rACT3Rs lon9";
$lang['usernamerequired'] = "@ lo90N N4M3 I5 rEqUIREd";
$lang['passwdmustnotcontainHTML'] = "P@\$SwOrd mUst n0+ CoN+41n H+ML T495";
$lang['passwordinvalidchars'] = "p45sWoRD c4n 0NLY CoN+41N A-Z, 0-9, _ - ch4r4CTERs";
$lang['passwdtooshort'] = "p45\$woRd MU5T 83 @ MIN1mUM 0PH 6 CH4r4c+ERs l0n9";
$lang['passwdrequired'] = "4 Pa\$\$WORD I\$ rEQu1r3D";
$lang['confirmationpasswdrequired'] = "a CONf1RM4+1On PAssWOrD I\$ REqU1r3D";
$lang['nicknamerequired'] = "4 NiCKN4Me is REQU1Red";
$lang['emailrequired'] = "@N Em@1l 4dDr35\$ 1\$ Requ1ReD";
$lang['passwdsdonotmatch'] = "p@5\$WORD\$ Do noT M4TCH";
$lang['usernamesameaspasswd'] = "UsERN4mE @Nd P4\$\$WOrd mUST bE D1fFeR3N+";
$lang['usernameexists'] = "\$OrRY, 4 u53r w1Th +h4T N@m3 4Lr34DY 3xi\$TS";
$lang['successfullycreateduseraccount'] = "succE5spHulLY CRE4T3D US3r 4CCOunt";
$lang['useraccountcreatedconfirmfailed'] = "Y0UR U53R 4CC0unT HA\$ 83En CREaT3D 8U+ ThE r3QUIred COnpHirM4T1on 3M@1L W45 no+ sENt. PLe4\$E CoNt@cT TEH F0Rum OWn3R +0 R3Ct1Fy +H15. IN +H1s Me4N+ImE Pl34S3 cLICk +3H CoNT1NU3 8Ut+0N +o L091N In.";
$lang['useraccountcreatedconfirmsuccess'] = "Y0Ur u\$ER 4CC0unT H4\$ 833N cRE@+3D BUT bEPH0R3 J00 C@N S+4r+ p0\$T1nG j00 mU5T COnPH1Rm y0uR EM41L 4DDr3\$s. Pl34sE ChEck y0Ur Em@IL pHoR 4 LINk +h4T WIlL AlL0w J00 To coNf1rM YoUr 4DDR35\$.";
$lang['useraccountcreated'] = "Y0uR uS3r 4Ccoun+ H4\$ 833N CRE4T3D 5ucc3SSfULLy! CL1cK +3H c0NT1NU3 bUtTOn b3L0W +0 lo91N";
$lang['errorcreatinguserrecord'] = "eRR0R cre4t1N9 Us3r ReCOrd";
$lang['userregistration'] = "U\$er r39i\$TR@+Ion";
$lang['registrationinformationrequired'] = "reg1\$tR4T10N 1NfORM4+I0N (REqu1r3d)";
$lang['profileinformationoptional'] = "PRopH1Le INF0RMA+10n (op+1on4l)";
$lang['preferencesoptional'] = "PrEfeReNcES (oPtIOn4L)";
$lang['register'] = "reg1\$TEr";
$lang['rememberpasswd'] = "ReM3mBer P4s\$WorD";
$lang['birthdayrequired'] = "Y0ur D@t3 of 81R+H I5 R3qu1RED oR I\$ 1Nv@l1D";
$lang['alwaysnotifymeofrepliestome'] = "nOTiFy On r3PlY +0 mE";
$lang['notifyonnewprivatemessage'] = "no+1pHy On neW pr1V@+e M3S\$4g3";
$lang['popuponnewprivatemessage'] = "POp Up oN NEw pRIv4tE me554g3";
$lang['automatichighinterestonpost'] = "4U+0M4+IC H1GH 1N+er3sT 0N P0s+";
$lang['confirmpassword'] = "coNph1rM p@SsWORd";
$lang['invalidemailaddressformat'] = "1NVALid 3M@il @DdR3s\$ pHorm4+";
$lang['moreoptionsavailable'] = "M0R3 pROF1lE 4nD PrEpHEr3NC3 0p+10N5 @R3 @V@1LAbl3 oNCe j00 R39I\$+3R";
$lang['textcaptchaconfirmation'] = "CONfIrM@+ion";
$lang['textcaptchaexplain'] = "+0 THe RIGh+ i\$ 4 T3X+-C@p+CH4 1m4ge. Ple4S3 +YP3 +eH Cod3 j00 C4N s3E IN the 1M4Ge 1NT0 +3H 1nPUt pH1ELd B3LoW 1+.";
$lang['textcaptchaimgtip'] = "th1s IS 4 C4P+Ch@-PIc+URE. I+ i5 u\$Ed t0 pRevenT 4U+0M4+iC R3G15TR4TION";
$lang['textcaptchamissingkey'] = "4 c0NF1RmAT10n CoD3 1s reqU1RED.";
$lang['textcaptchaverificationfailed'] = "T3X+ c4P+cH@ verIF1C4+ioN C0DE W@s 1NCorR3C+. Pl34\$E R3-3NtER I+.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "M3M83R";
$lang['searchforusernotinlist'] = "\$E4rcH F0r 4 Us3R N0+ 1N LisT";
$lang['yoursearchdidnotreturnanymatches'] = "YOUr \$34RCh d1D N0+ RE+URn @nY M4TcHeS. +Ry 5ImPLIfYINg YOUr \$e@rch pAR4MetEr\$ @nD +Ry 4941n.";

// Relationships (user_rel.php) ----------------------------------------

$lang['userrelationship'] = "uS3R rEl4+10n\$h1P";
$lang['userrelationships'] = "Us3r r3L4t10NSh1ps";
$lang['friends'] = "fRIEnDS";
$lang['ignoredcompletely'] = "1GNoreD ComPL3teLY";
$lang['relationship'] = "R3L4+ion\$H1p";
$lang['friend_exp'] = "US3R'\$ P05ts M4rK3D WiTH 4 &quot;pHR1eND&quot; ICoN.";
$lang['normal_exp'] = "u\$3R'\$ POs+\$ 4PPE@R 4s N0RMAL.";
$lang['ignore_exp'] = "U5Er'5 p0s+5 4r3 H1DD3n.";
$lang['ignore_completely_exp'] = "+hR34Ds @Nd Posts To oR PhR0m u\$3r W1Ll 4pP34R dElE+3D.";
$lang['display'] = "D1SpL4Y";
$lang['displaysig_exp'] = "usER's S19N4+UrE is dISPL4yEd 0N +H3IR POS+s.";
$lang['hidesig_exp'] = "U\$ER's SIGn@+URE iS H1DDeN on tHE1R Po5ts.";
$lang['globallyignored'] = "gl0B4LLy 1GNOreD";
$lang['globallyignoredsig_exp'] = "N0 \$1gN4+URe\$ 4RE D1sPL4yEd.";
$lang['cannotignoremod'] = "j00 c@nnO+ 1gNor3 TH1S U\$ER, 4\$ +H3Y 4rE 4 MOD3R4+0R.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "\$e4RcH r35UlT\$";
$lang['usernamenotfound'] = "+eH U5Ern4m3 J00 5pEcIF1Ed iN +Eh t0 oR PhROm PhIelD W4S n0T PHOuND.";
$lang['notexttosearchfor'] = "OnE 0R 4LL OF Y0UR s34RCH K3YWorD\$ w3R3 1NV@LId. 534RCH K3YWOrd\$ MU5t 83 NO \$h0RT3R TH4N %d ch4R4cTER5, N0 LONGer Th4N %d Ch@R4C+ERS AND Mu\$t no+ @PP34r 1N T3H %s";
$lang['mysqlstopwordlist'] = "MysQL STOpWoRD LI\$+";
$lang['foundzeromatches'] = "phoUNd: 0 M@+Ch35";
$lang['found'] = "FOUNd";
$lang['matches'] = "M4TChe5";
$lang['prevpage'] = "Pr3V1oU\$ p4Ge";
$lang['findmore'] = "Ph1ND MoR3";
$lang['searchmessages'] = "se@RCh mE\$s4G35";
$lang['searchdiscussions'] = "s34Rch d1scUS5Ion\$";
$lang['find'] = "FiND";
$lang['additionalcriteria'] = "@ddITIoN@L CRI+eR14";
$lang['searchbyuser'] = "\$e@RCH bY U53r (0p+1oN4L)";
$lang['folderbrackets_s'] = "F0LDeR(5)";
$lang['postedfrom'] = "p05+3D pHROM";
$lang['postedto'] = "pO5T3D to";
$lang['today'] = "+0D4Y";
$lang['yesterday'] = "y35t3RD4Y";
$lang['daybeforeyesterday'] = "D@Y 8EfOR3 Ye\$T3Rd4Y";
$lang['weekago'] = "%s W33k 4Go";
$lang['weeksago'] = "%s we3K5 AgO";
$lang['monthago'] = "%s MONTH 4GO";
$lang['monthsago'] = "%s MoN+Hs 4go";
$lang['yearago'] = "%s y3@r @90";
$lang['beginningoftime'] = "B391NNiNG opH t1M3";
$lang['now'] = "N0W";
$lang['newestfirst'] = "NEW3st PHiRst";
$lang['oldestfirst'] = "oLd3\$t pHIr\$+";
$lang['keywords'] = "k3yWORd\$";
$lang['orderby'] = "0RDER 8Y";
$lang['groupbythread'] = "groUP bY THRE4D";
$lang['postsfromuser'] = "PO\$+\$ PHRoM Us3r";
$lang['poststouser'] = "p0Sts +0 u5ER";
$lang['poststoandfromuser'] = "PO5T\$ To 4Nd PHRoM US3r";
$lang['searchfrequencyerror_1'] = "J00 c4n onLY 5E@RCH 0NC3 EV3RY";
$lang['searchfrequencyerror_2'] = "sEc0nD5. PLEASE tRY 4g4iN l4+eR.";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "RECEN+ +hR34D\$";
$lang['startreading'] = "S+4RT R34DING";
$lang['threadoptions'] = "+HrE4D 0p+IoN5";
$lang['editthreadoptions'] = "3D1t THR34D 0P+10Ns";
$lang['showmorevisitors'] = "5How m0r3 VIs1+oRS";
$lang['forthcomingbirthdays'] = "ph0rTHc0m1N9 B1rTHD4ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "J00 C4N 3DIT +H1s pA9E FR0m teH @DM1n 1n+3rF@cE";
$lang['uploadstartpage'] = "UPLo4d 5t@r+ P@9E (*.+XT, *.H+m, *.h+mL)";
$lang['invalidfiletypeerror'] = "phIlE +YPe N0t SuPP0R+3D. j00 c4N 0NLY U\$3 *.+xT, *.PHp 4nD *.h+M F1LEs As YoUR \$T4Rt P493.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "N3W d1\$CU\$si0n";
$lang['createpoll'] = "cr34Te pOlL";
$lang['search'] = "53@Rch";
$lang['searchagain'] = "\$34RCH @9AIN";
$lang['alldiscussions'] = "4lL D1\$cUS5iON5";
$lang['unreaddiscussions'] = "Unr34D d1SCUs5I0N5";
$lang['unreadtome'] = "UNR34D &quot;+0: mE&quot;";
$lang['todaysdiscussions'] = "+0d4Y'\$ D15cU5\$IoNs";
$lang['2daysback'] = "2 D4y\$ 84cK";
$lang['7daysback'] = "7 d@Y5 B4Ck";
$lang['highinterest'] = "hiGH IN+3R3sT";
$lang['unreadhighinterest'] = "UnRE4D hIgh 1N+er3St";
$lang['iverecentlyseen'] = "1'vE r3cENTLY \$33n";
$lang['iveignored'] = "i'V3 IGnOR3D";
$lang['byignoredusers'] = "8Y iGN0R3D USer5";
$lang['ivesubscribedto'] = "1'V3 5UbsCRI8ED TO";
$lang['startedbyfriend'] = "5+ARTed 8y Fr13Nd";
$lang['unreadstartedbyfriend'] = "UNR3@D 5TD 8Y Fri3nD";
$lang['startedbyme'] = "sT4rT3D bY m3";
$lang['unreadtoday'] = "UnR34d +OdAY";
$lang['deletedthreads'] = "DEL3T3D tHRE@D\$";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "fOld3R 1N+eR3S+";
$lang['postnew'] = "pos+ N3w";
$lang['currentthread'] = "CuRREnT THR34D";
$lang['highinterest'] = "h1GH 1NT3r3s+";
$lang['markasread'] = "M@Rk @s R34D";
$lang['next50discussions'] = "nEX+ 50 D1scU5sI0ns";
$lang['visiblediscussions'] = "v1\$I8LE DIscU5s1ONS";
$lang['selectedfolder'] = "5El3cT3d f0LDER";
$lang['navigate'] = "n4V1g4+3";
$lang['couldnotretrievefolderinformation'] = "ThERE 4rE N0 pHOld3R5 @v@iL4bLE.";
$lang['nomessagesinthiscategory'] = "n0 Mess49e5 1N +hI\$ c4T3Gory. PL34s3 sElEC+ 4N0+h3R, OR";
$lang['clickhere'] = "Cl1CK h3r3";
$lang['forallthreads'] = "FOR 4Ll +hREads";
$lang['prev50threads'] = "PR3Vi0Us 50 +hRE4DS";
$lang['next50threads'] = "N3x+ 50 tHR34Ds";
$lang['startedby'] = "\$+4R+3D By";
$lang['unreadthread'] = "Unr34D THRe4D";
$lang['readthread'] = "rE@D THr3aD";
$lang['unreadmessages'] = "UnRe4D ME554gE\$";
$lang['subscribed'] = "SU8scRIB3D";
$lang['ignorethisfolder'] = "I9N0R3 +h1\$ FoLDER";
$lang['stopignoringthisfolder'] = "SToP I9n0Rin9 tH1s f0LdeR";
$lang['stickythreads'] = "s+IcKy ThRe4D\$";
$lang['mostunreadposts'] = "MOs+ uNRe4d po5TS";
$lang['onenew'] = "%d N3W";
$lang['manynew'] = "%d N3W";
$lang['onenewoflength'] = "%d N3W oPH %d";
$lang['manynewoflength'] = "%d N3W 0F %d";
$lang['ignorefolderconfirm'] = "@RE j00 sURE j00 w4Nt +o 19n0R3 tH1s FOLDer?";
$lang['unignorefolderconfirm'] = "4RE J00 \$URe J00 WAnT +0 S+op iGNOrINg +HIs FoLd3R?";
$lang['threadviewedonetime'] = "v13W3D: 1 +IM3";
$lang['threadviewedtimes'] = "vIeWED: %d +1mE\$";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOld";
$lang['italic'] = "1t4LIC";
$lang['underline'] = "UnDERLIN3";
$lang['strikethrough'] = "5+r1KEthR0UGH";
$lang['superscript'] = "SuP3rScRIp+";
$lang['subscript'] = "\$UbScRIP+";
$lang['leftalign'] = "l3f+-4LIGn";
$lang['center'] = "CeNT3R";
$lang['rightalign'] = "rI9Ht-AL19N";
$lang['numberedlist'] = "nuMB3R3D L1s+";
$lang['list'] = "l1\$+";
$lang['indenttext'] = "1nDeNt teXT";
$lang['code'] = "c0De";
$lang['quote'] = "Qu0+E";
$lang['spoiler'] = "5POIlER";
$lang['horizontalrule'] = "h0RIZ0NT@l rULE";
$lang['image'] = "im4G3";
$lang['hyperlink'] = "hyPeRLINk";
$lang['noemoticons'] = "dI\$@8Le 3M0+iCon\$";
$lang['fontface'] = "PHOn+ ph4c3";
$lang['size'] = "\$IZ3";
$lang['colour'] = "C0LOUR";
$lang['red'] = "ReD";
$lang['orange'] = "OR@n9E";
$lang['yellow'] = "yeLl0W";
$lang['green'] = "9R33N";
$lang['blue'] = "bLu3";
$lang['indigo'] = "1NdIGo";
$lang['violet'] = "VI0lE+";
$lang['white'] = "wH1tE";
$lang['black'] = "BLAcK";
$lang['grey'] = "Gr3y";
$lang['pink'] = "P1NK";
$lang['lightgreen'] = "LIGhT GR3EN";
$lang['lightblue'] = "l19hT BLu3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0RuM stAtS";
$lang['guests'] = "gU3\$+S";
$lang['members'] = "m3MbERS";
$lang['anonymousmembers'] = "4NoNYMoU\$ MEM83rs";
$lang['viewcompletelist'] = "V1Ew cOmpLETe LIst";
$lang['ourmembershavemadeatotalof'] = "oUr MEM8ERs H4VE M@dE 4 t0T@l oF";
$lang['threadsand'] = "ThREaD\$ @nD";
$lang['postslowercase'] = "POst5";
$lang['longestthreadis'] = "LONge\$T THRE4D 1s";
$lang['therehavebeen'] = "+H3Re h@vE Be3N";
$lang['postsmadeinthelastsixtyminutes'] = "P0S+5 m4D3 1N +h3 L45T 60 m1NU+3s";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwas'] = "m0ST po\$+5 Ever mADE 1N 4 51NGL3 60 MInuT3 p3RIOD W@\$";
$lang['wehave'] = "we h@vE";
$lang['registeredmembers'] = "re9ISteRed MEM8ER5";
$lang['thenewestmemberis'] = "+He nEw3sT MeMBER I\$";
$lang['mostuserseveronlinewas'] = "m0\$T UsErs 3V3R ONl1n3 Was";
$lang['statsdisplayenabled'] = "5Ta+\$ d1sPl4Y 3N48LeD";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "UpD4+3s M4DE";
$lang['useroptions'] = "U5Er oPTion\$";
$lang['markedasread'] = "M@RKED 4\$ rE@d";
$lang['postsoutof'] = "POst\$ OUT oPH";
$lang['interest'] = "IN+3RE\$+";
$lang['closedforposting'] = "cLos3d F0r pO\$+1N9";
$lang['locktitleandfolder'] = "lOcK +1+LE 4ND fOlD3R";
$lang['deletepostsinthreadbyuser'] = "deLeTe P0sts 1N +HR34D bY U\$3r";
$lang['deletethread'] = "deL3+E P05T\$";
$lang['deletethread'] = "del3+3 tHR34D";
$lang['undeletethread'] = "UNdeL3+3 tHR3@D";
$lang['threaddeletedpermenantly'] = "THR34D DEl3T3D P3rMEN4NTly. C4NN0T uNDEL3+3.";
$lang['markasunread'] = "M4RK 4s unRe@d";
$lang['makethreadsticky'] = "M4K3 THRe4D 5+1cKY";
$lang['threareadstatusupdated'] = "tHRe4d RE4D \$T@+U5 upd@+3d sUCc35sPHULlY";
$lang['interestupdated'] = "+hR34D 1NTERe\$+ 5T4Tu\$ UPD4TED 5UCC35\$FULly";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "DIc+10nArY";
$lang['spellcheck'] = "spELL cHECK";
$lang['notindictionary'] = "nO+ IN D1cTi0N4rY";
$lang['changeto'] = "cH4NgE +o";
$lang['initialisingdotdotdot'] = "1NiTI4l1\$ING...";
$lang['spellcheckcomplete'] = "SP3Ll CHeCk 1\$ cOMPl3T3. D0 j00 W15H TO \$T@R+ @9aIN pHRoM +3H 8391NNING?";
$lang['spellcheck'] = "5pELl CHECK";
$lang['noformobj'] = "n0 Ph0Rm 08j3C+ SPECIF1ED PH0R r3+uRn +3x+";
$lang['bodytext'] = "boDy T3xt";
$lang['ignore'] = "19N0Re";
$lang['ignoreall'] = "i9NoR3 @lL";
$lang['change'] = "cHanGe";
$lang['changeall'] = "Ch@NG3 @LL";
$lang['add'] = "@DD";
$lang['suggest'] = "5U99E5T";
$lang['nosuggestions'] = "(N0 sUG9EsT10N\$)";
$lang['ok'] = "0k";
$lang['cancel'] = "C@NCEL";
$lang['dictionarynotinstalled'] = "NO D1C+1On4Ry H45 833n IN\$tALL3D. PLE@\$E con+@Ct TH3 FOrUm oWn3R t0 R3MEdY THIs.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p05T R34D1NG 4LLOW3D";
$lang['postcreationallowed'] = "p05T CR3ATi0N 4LL0Wed";
$lang['threadcreationallowed'] = "+hRe@d cRE@+ION @LlOW3D";
$lang['posteditingallowed'] = "p0s+ ED1T1Ng @LL0wed";
$lang['postdeletionallowed'] = "p05T DEL3tI0N @lL0W3D";
$lang['attachmentsallowed'] = "4+t@ChmEn+S AlL0w3D";
$lang['htmlpostingallowed'] = "htMl p05tInG 4Ll0WED";
$lang['signatureallowed'] = "S1gN4TUR3 @lLOwED";
$lang['guestaccessallowed'] = "gUe\$T 4cCEss aLl0WED";
$lang['postapprovalrequired'] = "PO\$+ 4PprOV4l R3QuiRed";

// RSS feeds gubbins

$lang['rssfeed'] = "RS5 FEED";
$lang['every30mins'] = "eV3RY 30 minU+35";
$lang['onceanhour'] = "oncE @N H0uR";
$lang['every6hours'] = "3VeRY 6 HOur\$";
$lang['every12hours'] = "eVEry 12 HoUR\$";
$lang['onceaday'] = "ONc3 4 D4Y";
$lang['rssfeeds'] = "R\$s Feed5";
$lang['feedlocation'] = "pH3Ed Loc4+1ON";
$lang['rssclicktoreadarticle'] = "cl1Ck HERE To r34D +h1S @RTIcl3";
$lang['rssfeedhelp_1'] = "h3Re J00 c4N s3TUP SoME R\$s PH3EDs FoR @U+om4TIC PR0P@94TIon IN+0 Y0UR Ph0RuM. teH 1tEM5 phRoM +3H RSS PHeED5 J00 4DD W1Ll 8E cR34+3D 4\$ +Hr34D5 Wh1Ch u53R\$ C4N repLY To @5 IF Th3Y WEr3 N0Rm@L pOS+s. WHEn 4dDIN9 4N R\$s pHEEd J00 mu\$+ sPEc1FY +3H uSeR LO9On J00 W1\$h t0 Be UsEd To s+4RT +eH +HR34D5, tH3 pH0ld3R J00 Wi\$H +HEM +O B3 Cr34+3d IN @Nd +He L0C@+1ON oph T3h PHE3D. tH3 pHE3D l0c4T10n I+s3Lph Mus+ 8e @CC3\$s1bL3 Vi@ H+tP, 1f iT I\$ not +HEN +H3 PhEeD W1Ll No+ WorK.";
$lang['mustspecifyrssfeedname'] = "MusT 5PECIfY R5s FE3D N@ME";
$lang['mustspecifyrssfeeduseraccount'] = "MU\$t SPECIPHy R\$5 PH33D U\$3R @ccOuNT";
$lang['mustspecifyrssfeedfolder'] = "MUS+ \$peC1fY R5s fEED pHoLD3R";
$lang['mustspecifyrssfeedurl'] = "muS+ SP3CIfY r\$S feED URL";
$lang['mustspecifyrssfeedprefix'] = "Mu\$t SpeC1Phy R\$5 F33D pREPHix";
$lang['mustspecifyrssfeedupdatefrequency'] = "Mu\$+ \$pECiPhy Rs5 FeED uPD@+3 FREQUenCY";
$lang['unknownrssuseraccount'] = "UNknoWN R\$S U53R @CcoUNt";
$lang['rssfeedsupportshttpurlsonly'] = "rS\$ PHeeD 5upP0R+s H++P Url\$ ONLY. \$3CUr3 fe3D5 (H++PS://) @R3 no+ \$Upp0RTED.";
$lang['rssfeedurlformatinvalid'] = "rS\$ pHe3d URl FOrM4+ 1s 1NV4LiD. URL Mu\$T INCLuDE ScH3M3 (E.9. hTtP://) 4ND @ ho5+NAMe (3.9. www.H0STNAME.cOM).";
$lang['rssfeeduserauthentication'] = "rs5 feEd DO35 no+ sUpPorT h++P u\$3r 4u+hENTic@+1on";

// PM Export Options

$lang['pmexportastype'] = "ExPoRT 4s +YPE";
$lang['pmexporthtml'] = "H+mL";
$lang['pmexportxml'] = "XmL";
$lang['pmexportplaintext'] = "pL@1n Text";
$lang['pmexportmessagesas'] = "3XP0R+ m3s5493s 4s";
$lang['pmexportonefileforallmessages'] = "0Ne F1L3 FoR @LL m3S5@GE\$";
$lang['pmexportonefilepermessage'] = "on3 f1l3 Per M3\$s493";
$lang['pmexportattachments'] = "exPort aTT4ChM3ntS";
$lang['pmexportincludestyle'] = "iNClUDE F0RUM S+ylE5hEET";
$lang['pmexportwordfilter'] = "@PpLy woRD F1L+ER t0 Mess@9Es";

?>