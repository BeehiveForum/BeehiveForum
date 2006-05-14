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

/* $Id: x-hacker.inc.php,v 1.205 2006-05-14 12:12:15 decoyduck Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_charset'] = "UTF-8";
$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "J@NUARY";
$lang['month'][2]  = "feBRu@rY";
$lang['month'][3]  = "m@rcH";
$lang['month'][4]  = "4PR1l";
$lang['month'][5]  = "m4y";
$lang['month'][6]  = "JuNE";
$lang['month'][7]  = "JULy";
$lang['month'][8]  = "@U9Us+";
$lang['month'][9]  = "\$3p+eMber";
$lang['month'][10] = "0C+O8eR";
$lang['month'][11] = "N0vEMb3R";
$lang['month'][12] = "d3c3M83r";

$lang['month_short'][1]  = "j@n";
$lang['month_short'][2]  = "F3b";
$lang['month_short'][3]  = "M4r";
$lang['month_short'][4]  = "Apr";
$lang['month_short'][5]  = "m4y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "JUL";
$lang['month_short'][8]  = "@U9";
$lang['month_short'][9]  = "\$ep";
$lang['month_short'][10] = "OC+";
$lang['month_short'][11] = "Nov";
$lang['month_short'][12] = "dEc";

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

$lang['percent'] = "p3RCENt";
$lang['average'] = "@V3R493";
$lang['approve'] = "@pProVe";
$lang['banned'] = "84nnED";
$lang['locked'] = "LocKEd";
$lang['add'] = "AdD";
$lang['advanced'] = "ADV4Nced";
$lang['active'] = "@c+IVE";
$lang['kick'] = "k1ck";
$lang['remove'] = "ReMoVE";
$lang['style'] = "\$tyL3";
$lang['go'] = "90";
$lang['folder'] = "Fold3R";
$lang['ignoredfolder'] = "I9nor3d F0lD3r";
$lang['folders'] = "FolD3rS";
$lang['thread'] = "thre4d";
$lang['threads'] = "tHRE4d5";
$lang['message'] = "me\$sa9E";
$lang['from'] = "fR0m";
$lang['to'] = "t0";
$lang['all_caps'] = "@lL";
$lang['of'] = "0F";
$lang['reply'] = "r3PLy";
$lang['replyall'] = "rEPLy T0 4Ll";
$lang['pm_reply'] = "r3pLY @\$ pM";
$lang['delete'] = "D3L3+E";
$lang['deleted'] = "deL3+eD";
$lang['del'] = "D3L";
$lang['edit'] = "eD1+";
$lang['privileges'] = "priV1LE9e\$";
$lang['ignore'] = "1GNOr3";
$lang['normal'] = "NORm4L";
$lang['interested'] = "IN+er35+ED";
$lang['subscribe'] = "sU85crIbE";
$lang['apply'] = "4PPlY";
$lang['submit'] = "su8m1+";
$lang['download'] = "d0wNL0@D";
$lang['save'] = "\$4V3";
$lang['savechanges'] = "S@v3 Ch4n9E5";
$lang['update'] = "UPd4+3";
$lang['cancel'] = "caNCEL";
$lang['continue'] = "C0nTINUE";
$lang['with'] = "wI+H";
$lang['attachment'] = "4++4CHMENT";
$lang['attachments'] = "4T+@CHMENT5";
$lang['imageattachments'] = "im4GE @++4cHm3N+\$";
$lang['filename'] = "pH1l3N@M3";
$lang['dimensions'] = "d1MENsION\$";
$lang['downloadedxtimes'] = "DOWnL04deD: %d +1Me\$";
$lang['downloadedonetime'] = "DOWNL0@d3d: 1 +1m3";
$lang['size'] = "s1z3";
$lang['viewmessage'] = "V13W m3\$54g3";
$lang['logon'] = "lOg0n";
$lang['more'] = "M0RE";
$lang['recentvisitors'] = "RecENT V1sI+0RS";
$lang['username'] = "u\$3rN@M3";
$lang['clear'] = "Cl34R";
$lang['action'] = "@c+i0n";
$lang['unknown'] = "UnKNOwn";
$lang['none'] = "nONE";
$lang['preview'] = "PrEViEW";
$lang['post'] = "POs+";
$lang['posts'] = "P0st5";
$lang['change'] = "Ch4NG3";
$lang['yes'] = "y3\$";
$lang['no'] = "n0";
$lang['signature'] = "s1Gn4TuRE";
$lang['signaturepreview'] = "\$19n4tUR3 Pr3v13w";
$lang['signatureupdated'] = "\$1gN4+uR3 UPDAt3d";
$lang['wasnotfound'] = "W4S Not f0uNd";
$lang['back'] = "B@cK";
$lang['subject'] = "Su8j3cT";
$lang['close'] = "cL0\$3";
$lang['name'] = "n@ME";
$lang['description'] = "D35CR1P+i0n";
$lang['date'] = "d4+3";
$lang['view'] = "V13w";
$lang['enterpasswd'] = "3Nt3r p4\$SwOrD";
$lang['passwd'] = "P@s5w0RD";
$lang['ignored'] = "19nOR3d";
$lang['guest'] = "9U3\$+";
$lang['next'] = "NEXt";
$lang['prev'] = "pr3V10U\$";
$lang['others'] = "0tH3rS";
$lang['nickname'] = "n1ckN4M3";
$lang['emailaddress'] = "3m4IL 4ddr3\$S";
$lang['confirm'] = "C0NPHIrM";
$lang['email'] = "3m4iL";
$lang['newcaps'] = "n3w";
$lang['poll'] = "poLL";
$lang['friend'] = "pHr13nd";
$lang['error'] = "ErrOr";
$lang['guesterror_1'] = "\$0rry, j00 N3eD +O 83 lo9g3d In +o uS3 THi5 pH3@+UR3.";
$lang['guesterror_2'] = "l091N N0w";
$lang['on'] = "0n";
$lang['unread'] = "UNRE4D";
$lang['all'] = "4LL";
$lang['allcaps'] = "AlL";
$lang['me_caps'] = "m3";
$lang['by'] = "bY";
$lang['permissions'] = "PerMISSI0ns";
$lang['position'] = "poSiT10N";
$lang['type'] = "+yPe";
$lang['print'] = "pRIN+";
$lang['sticky'] = "s+1ckY";
$lang['polls'] = "p0ll5";
$lang['user'] = "U\$ER";
$lang['enabled'] = "En4bLed";
$lang['disabled'] = "d1S4bLED";
$lang['options'] = "0PTI0NS";
$lang['emoticons'] = "3MO+1cOnS";
$lang['webtag'] = "we8t49";
$lang['makedefault'] = "M@Ke d3Ph4UL+";
$lang['unsetdefault'] = "UNs3+ deF4uLT";
$lang['rename'] = "r3n4me";
$lang['pages'] = "P4G3s";
$lang['top'] = "T0P";
$lang['used'] = "uSed";
$lang['days'] = "D4y5";
$lang['sortasc'] = "5OR+ 45ceNDIN9";
$lang['sortdesc'] = "50rT dE\$CeNdIN9";
$lang['usage'] = "Us@g3";
$lang['show'] = "SH0w";
$lang['prefix'] = "PREPHIx";
$lang['hint'] = "H1n+";
$lang['new'] = "NEW";
$lang['reset'] = "RE53T";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "4dM1N T0OLs";
$lang['forummanagement'] = "f0Rum M4N4GEM3N+";
$lang['accessdenied'] = "4cc3\$5 D3n1ed";
$lang['accessdeniedexp'] = "J00 dO nOt H4V3 pERMi5\$i0N t0 U\$e tHIS \$3cTI0N.";
$lang['managefolders'] = "M@n49e FoldErs";
$lang['manageforums'] = "m4n49E FOrum5";
$lang['manageforumpermissions'] = "M@n4GE F0RUM P3RM15S10n\$";
$lang['foldername'] = "f0LDEr N4M3";
$lang['move'] = "M0Ve";
$lang['closed'] = "Cl0S3d";
$lang['open'] = "0pEN";
$lang['restricted'] = "rE5tRIcT3d";
$lang['iscurrentlyclosed'] = "1s cUrR3NTly ClO\$Ed";
$lang['youdonothaveaccessto'] = "j00 D0 no+ h4VE 4cCESs +0";
$lang['toapplyforaccessplease'] = "tO @pPLY foR 4cC3\$S PLe4\$E c0N+4ct +H3 pHORUM OwNER.";
$lang['adminforumclosedtip'] = "1PH j00 W4n+ tO cH4N93 \$0M3 \$e++1N9S 0N your pHorUM cL1cK TH3 @Dm1N L1nK 1n +HE n4vI94+I0n 8@R 480V3.";
$lang['newfolder'] = "nEW ph0lDeR";
$lang['forumadmin'] = "pHoruM @DmIn";
$lang['adminexp_1'] = "us3 T3h M3NU 0N Th3 lEfT t0 m4n4gE THINg\$ IN YoUR F0RUM.";
$lang['adminexp_2'] = "<b>U\$ERs</b> 4LL0W\$ j00 T0 Se+ 1ndIV1dU4L U53R pERMi5S1on\$, 1NCLUdIN9 @pPOIn+INg EdItOrs 4ND G4G9iN9 PEoPl3.";
$lang['adminexp_3'] = "<b>u\$eR 9Roup5</b> 4LlowS j00 T0 cRE4+e uS3r 9R0upS +0 4\$s1Gn pERm1S\$i0NS +O @s M4nY 0R 4\$ F3W uS3r\$ QUIckLY 4Nd 34s1LY.";
$lang['adminexp_4'] = "<b>BAN cONTROLs</b> 4LLow\$ tH3 84nnIn9 4nD uN-b4NNiN9 Of iP 4ddRe\$sE\$, UserN@M3s, 3M@IL 4DDress35 @nD N1ckN@MES.";
$lang['adminexp_5'] = "<b>Ph0Ld3Rs</b> 4LLOWS TEh cre4TI0N, m0d1pHIC4+1On 4nD dEL3t10N 0pH PHolDErS.";
$lang['adminexp_6'] = "<b>pr0FIlE5</b> L3+S j00 CU5t0m153 +eH Item\$ tH4T 4pP34R iN tH3 Us3r ProPh1l3\$.";
$lang['adminexp_7'] = "<b>PH0rUM 53+T1N9s</b> 4lLow\$ J00 +O cu\$+om153 yOUr pHorUM'S N@m3, @Pp34r4nce 4nD M@NY o+hER +H1N9S.";
$lang['adminexp_8'] = "<b>sT4RT p4g3</b> LEtS j00 cuS+0mise yOUR pH0rUm'5 s+4R+ P4GE.";
$lang['adminexp_9'] = "<b>phOrUM \$tyle</b> 4LlOw5 J00 +0 CR34T3 stYLE5 pHOR Y0UR PHoRUM M3M83R\$ +0 U53.";
$lang['adminexp_10'] = "<b>WoRD pHIL+eR</b> @lL0W\$ j00 +O FiLt3R W0RD5 j00 dOn'T W4Nt tO bE U\$3d 0N YoUR FORuM.";
$lang['adminexp_11'] = "<b>POs+INg \$t4T5</b> Gen3ra+3s a ReP0rT l1\$+1N9 the +0p 10 pOs+ers 1n 4 DEfIN3D P3RI0D.";
$lang['adminexp_12'] = "<b>PHoRUm L1NKS</b> lE+S j00 m@n4G3 +eH LINk5 DROPD0wN IN +eH Nav19@TI0N B4R.";
$lang['adminexp_13'] = "<b>vIEW log</b> LIs+5 r3c3nT 4cT10nS bY THE FORum m0d3rATor\$.";
$lang['adminexp_14'] = "<b>M@n4ge pHOrUMs</b> Le+5 j00 cRe4+e 4ND D3Le+3 4ND ClOS3 oR RE0p3n ph0rUmS.";
$lang['adminexp_15'] = "<b>GlO84L FoRUM \$E+tIn9s</b> 4LL0ws J00 +0 Mod1pHY \$ETTiN9\$ wH1cH 4PhpHECT @LL F0RuMs.";
$lang['createforumstyle'] = "cR3@+3 @ pH0RUM \$TYl3";
$lang['newstyle'] = "n3w S+YL3";
$lang['successfullycreated'] = "sUcc3\$5PhULlY CRE@t3D.";
$lang['stylealreadyexists'] = "@ S+yL3 W1+h +H4+ FileN4ME 4LR34dY eX1S+S.";
$lang['stylenofilename'] = "j00 dId N0+ EN+3r @ fileN4mE TO s4vE tHE \$+YLE w1+h.";
$lang['stylenodatasubmitted'] = "C0ULD n0+ R34d phoRuM S+yLE d4+4.";
$lang['styleexp'] = "U\$e th15 Pa9E +O H3LP crE@tE 4 r4nd0MLY 9ENER@TEd \$TyLE F0R Y0Ur pH0rUM.";
$lang['stylecontrols'] = "con+ROL\$";
$lang['stylecolourexp'] = "CLICk On @ COlouR T0 M4K3 4 NEW \$+yLE SHe3+ 84S3d oN +h@+ C0LouR. CurR3Nt 8As3 C0L0Ur IS PhIRST IN LiSt.";
$lang['standardstyle'] = "5t@nd4RD 5+yLE";
$lang['rotelementstyle'] = "r0T4T3d 3L3mENt \$TYLE";
$lang['randstyle'] = "R4nD0m STYL3";
$lang['thiscolour'] = "+Hi5 cOLouR";
$lang['enterhexcolour'] = "0r 3N+ER 4 h3X CoL0uR +O 8453 @ n3W s+yl3 5h3E+ 0N";
$lang['savestyle'] = "5@v3 +HI\$ s+yL3";
$lang['styledesc'] = "\$tyl3 d3SCENDIN9";
$lang['fileallowedchars'] = "(L0w3rCa\$E LE++ER5 (4-Z), NuMBeRs (0-9) 4nd UnDERsC0r3\$ (_) 0nlY)";
$lang['stylepreview'] = "5tYL3 pR3VIEw";
$lang['welcome'] = "wELC0M3";
$lang['messagepreview'] = "mE\$5a93 PR3V13w";
$lang['users'] = "USers";
$lang['usergroups'] = "u53r gr0up5";
$lang['mustentergroupname'] = "j00 mUst 3N+Er a 9R0up n4mE";
$lang['profiles'] = "propH1L3s";
$lang['manageforums'] = "m4n@G3 PHORUmS";
$lang['forumsettings'] = "fOruM 53+T1ng5";
$lang['globalforumsettings'] = "gL0b4L PH0rUM \$eTt1ngS";
$lang['settingsaffectallforumswarning'] = "<b>NOT3:</b> tH3\$e S3++IN95 4Fph3ct @Ll pHOrUMs. WHeR3 THe Se+TinG Is DUPlIC4+3D ON Th3 InDIv1DU4L F0RUM'5 Se+tiNgS P@g3 Th4+ W1Ll TAK3 Pr3cEDeNC3 0vEr +H3 \$E+T1N9\$ J00 Ch4N9E HerE.";
$lang['startpage'] = "St@rT P49e";
$lang['startpageerror_1'] = "yoUr s+4Rt p4GE c0ULD NO+ 83 \$4V3d L0C4Lly To tH3 s3rV3R 83c4U53 PerM15S10N W@s DEn13D. TO cH4n9E Y0uR sT@Rt p@Ge Pl34s3 Cl1Ck T3h D0wNl04D Bu+T0N BELoW Wh1Ch wIlL Pr0MpT J00 +0 \$@Ve +H3 Phil3 T0 y0Ur H4rD Dr1V3. J00 C@N +h3N UpLo4D +H1\$ pHILE TO Y0UR 53RvEr 1N+0";
$lang['startpageerror_2'] = "FOlD3R, 1F Nec3S54RY CR3@+iN9 t3H PhoLDER \$TRucTUR3 1N +H3 pRoc3Ss. ple4Se NOt3 th4T s0M3 bROW53r5 M4Y CH4NgE TeH N4M3 0Ph +H3 F1Le UpOn DoWNl04D.  WH3n UPlo@D1NG +He PHilE Ple4s3 M4K3 sUR3 tH4+ It 1s N4M3D 5T4Rt_m41n.PhP 0TH3RW153 yoUR \$TaRt P4GE WiLl 4pP34R uNCh@nG3D.";
$lang['failedtoopenmasterstylesheet'] = "yoUR Ph0RUm sTyL3 c0UlD NO+ 8e s4V3d Bec4Us3 +EH M4sT3r StYl3 5HEE+ C0ULd N0+ 83 Lo4DEd. +0 \$@Ve YouR s+ylE +3H M4S+3R 5TyLE \$HeEt (M4k3_\$tYL3.C5s) Mu\$T B3 LoC4T3D in +hE stYl3S DirECtoRY 0F Y0uR Be3h1V3FOrUm IN\$+AlL4+i0N.";
$lang['makestyleerror_1'] = "Y0ur F0RUM 5tYLE cOUld NOT bE S@VED L0C4LLy +0 +EH s3rV3R 8ec4US3 pErmIs5i0N W@5 d3NI3d. tO \$4V3 Y0UR FORuM 5Tyl3 pLE@s3 cl1cK +he DOwNL04D 8uTtoN 8ElOw WHICh wILl PROMpT j00 +O \$@VE thE pHiL3 +0 Y0uR H@RD dRiVE. J00 C4N +h3n UpL0@D +h1\$ f1lE +0 Y0uR 53Rv3R INTo";
$lang['makestyleerror_2'] = "pHolD3R, iF NECe\$54rY Cr3@t1N9 T3h FoLD3R STrucTURE IN +eH PRocEs5. J00 SH0uLD n0+3 +ha+ 5oME 8RoW53RS M@Y cH4N93 Th3 N@M3 Oph teH pH1Le UP0N DoWnL04D. wH3N uPl04D1N9 tEH FiL3 Pl3@\$3 M@k3 \$UR3 +H4+ IT iS N@MEd styL3.cSs O+H3RW1s3 +hE Ph0rUm S+yl3 wIlL BE Unu\$Abl3.";
$lang['uploadfailed'] = "youR New S+ART P@GE cOULd nO+ 8e uPL0@d3d t0 +HE SERvER beC4u5E P3RMISS10N w45 D3Ni3d. pL3453 cH3ck +H4t TEh w3B \$3RV3R / pHP PRoc3sS 1\$ 48L3 t0 WR1+3 TO +H3 %s pHOldER 0N yOuR sERveR.";
$lang['makestylefailed'] = "YOUr NEW F0rum STyL3 c0ULd N0T B3 \$4veD +0 TH3 53RV3R 83C@US3 p3RmIs5i0n w4\$ DEn1ED. pLE453 CH3cK +H4T TeH WE8 S3RV3r / PHP pR0cEs5 1s a8LE +O WR1T3 +o +H3 %s phoLDER oN Y0uR s3rvER.";
$lang['forumstyle'] = "pHoRUM S+yLE";
$lang['wordfilter'] = "word FiLTer";
$lang['forumlinks'] = "f0RuM LiNKS";
$lang['viewlog'] = "v1EW LO9";
$lang['invalidop'] = "1nV@lID Op3r4TI0n";
$lang['noprofilesectionspecified'] = "NO pR0PHiLE sec+I0n SpecIpHiED.";
$lang['newitem'] = "nEW iTEM";
$lang['manageprofileitems'] = "m@n49e PrOfiLE 1+eMs";
$lang['itemname'] = "1+EM n4M3";
$lang['moveto'] = "m0vE T0";
$lang['deleteitem'] = "D3leT3 1t3M";
$lang['deletesection'] = "deLE+e \$ec+10n";
$lang['new_caps'] = "N3W";
$lang['newsection'] = "n3w S3cTI0n";
$lang['manageprofilesections'] = "m4N4GE pROfiL3 S3ct1OnS";
$lang['sectionname'] = "S3c+I0N n4mE";
$lang['items'] = "ItemS";
$lang['startpageupdated'] = "S+@RT p@g3 uPD4+3d";
$lang['viewupdatedstartpage'] = "Vi3w UPD4+3d S+4r+ PA93";
$lang['editstartpage'] = "3D1t 5T4R+ p@g3";
$lang['nouserspecified'] = "No UseR \$pEcIFIEd f0r 3DI+1n9.";
$lang['manageuser'] = "m4n493 u\$3R";
$lang['manageusers'] = "M4N@g3 US3RS";
$lang['userstatus'] = "UseR 5+4+Us";
$lang['userdetails'] = "U\$eR dEt41l\$";
$lang['nicknameheader'] = "n1cKn@mE:";
$lang['warning_caps'] = "W4RN1n9";
$lang['userdeleteallpostswarning'] = "@RE J00 suR3 j00 W4N+ T0 DEl3t3 @LL 0F tHe SEl3ct3d u5Er'5 p0s+5? oNC3 tH3 pOsTS @R3 d3LEt3D +Hey c4Nn0+ B3 ReTR13veD 4ND WIlL b3 lO5t pHoR3V3R.";
$lang['postssuccessfullydeleted'] = "p0StS w3re SUCCES5PHuLLy del3+Ed.";
$lang['folderaccess'] = "pH0ldER @cceS\$";
$lang['possiblealiases'] = "p0S5I8lE alia\$E\$";
$lang['usersettingsupdated'] = "UsEr S3tTIN95 SUcceS\$phUlLy UpD@Ted";
$lang['nomatches'] = "N0 m4+Ch3S";
$lang['deleteposts'] = "DeLEt3 PO5t\$";
$lang['deleteallusersposts'] = "DELeT3 4Ll 0pH TH1\$ U53r'S P0S+\$";
$lang['noattachmentsforuser'] = "n0 4+t@cHMENTS pH0r TH15 U\$er";
$lang['aliasdesc'] = "tHIS 1S 4 li5+ 0F 0+her p0\$+eRS wHo MA+ch tHI5 Us3R'\$ l4St 20 KNowN iP 4ddres53\$.";
$lang['forgottenpassworddesc'] = "1PH +H1S u53r h@5 Ph0RGotteN tHeIR P4\$\$w0rd J00 C@n re5eT it FoR THEM h3r3.";
$lang['manageusersexp_1'] = "thIs Li5T sHoW\$ 4 S3l3CTiOn of u53R5 WH0 H@VE LoGGeD 0N +O YoUR PHoRuM, s0RtED By";
$lang['manageusersexp_2'] = "+o AL+ER 4 uSEr'5 PeRMi5\$i0nS cl1CK th3iR N@m3.";
$lang['lastlogon'] = "l@S+ L09ON";
$lang['nouseraccounts'] = "N0 uSEr 4cCOunT\$ 1N D4+4b@SE.";
$lang['searchforusernotinlist'] = "5E4RCH pH0r 4 Us3R nOT iN l15+";
$lang['adminaccesslog'] = "4dM1N 4CceS5 lO9";
$lang['adminlogexp'] = "+h1\$ L1s+ \$h0w5 t3h l45+ 4ct10NS S4ncTiON3d 8Y u5eR\$ WITh 4DMIn prIV1l3g35.";
$lang['datetime'] = "d4+E/+1mE";
$lang['unknownuser'] = "uNkn0WN u\$3r";
$lang['unknownfolder'] = "uNKnOWN PHolD3r";
$lang['ip'] = "Ip";
$lang['logged'] = "LOG93d";
$lang['notlogged'] = "NoT LogGED";
$lang['wordfilterupdated'] = "woRD pHILT3r upD@tED";
$lang['editwordfilter'] = "3Di+ wORD F1LTER";
$lang['wordfilterexp_1'] = "U53 TH1S P4GE +o 3d1+ +hE worD f1L+3R f0r yOuR pH0RUM. PL4cE e@cH wORD +o 83 FIlTEreD 0N 4 N3W LIne.";
$lang['wordfilterexp_2'] = "PerL-cOMP4+ibLE r3GuL4R 3xpRe\$S1Ons c@N @LSo 8E uS3D +0 m@tCh WOrd5 1pH J00 KNOW HOW.";
$lang['wordfilterexp_3'] = "us3 +H1s P49E tO 3D1t YouR P3R\$On4L wOrd pH1lT3r. pLACE 34cH WOrd +O 8e PH1lT3R3D 0N @ N3w lInE.";
$lang['wordfilterisfull'] = "j00 CaNNoT 4dd 4nY mOre W0Rd FiL+Er\$. r3M0vE 50ME Unu\$ed One5 or 3d1+ +eh 3xiS+IN9 On3S f1Rs+.";
$lang['allow'] = "aLl0W";
$lang['access'] = "4Cc3\$\$";
$lang['normalthreadsonly'] = "N0RM@L tHR3@dS 0NlY";
$lang['pollthreadsonly'] = "pOLL +hre@d\$ 0nlY";
$lang['both'] = "80+H thR3@D +YpE5";
$lang['existingpermissions'] = "EX15tiNG p3RM15s1On5";
$lang['nousers'] = "No uS3RS";
$lang['searchforuser'] = "53ARCH f0R User";
$lang['browsernegotiation'] = "BR0wS3r n390+I@T3d";
$lang['largetextfield'] = "L4R9e +EXt pHIELD";
$lang['mediumtextfield'] = "mEDIuM +3X+ F13lD";
$lang['smalltextfield'] = "Sm4lL +3xt fIELD";
$lang['multilinetextfield'] = "MUlTI-LIN3 +exT Fi3ld";
$lang['radiobuttons'] = "r4D1O 8UTt0ns";
$lang['dropdown'] = "dr0p d0Wn";
$lang['threadcount'] = "+HR3@d c0Un+";
$lang['fieldtypeexample1'] = "foR R4Di0 buT+oN5 4Nd dR0P D0WN Ph13lD\$ J00 n3Ed +o SEP@R4Te +h3 f1ELDN4m3 @nD tHe V@Lu3\$ WI+h 4 C0L0N 4nD E4cH V@Lue sHOUld 83 53P4rA+ED 8Y 53m1-COL0n5.";
$lang['fieldtypeexample2'] = "EX@MpLe: to CRE@T3 A B@Sic GEnder R4DI0 bu++OnS, W1Th TWo SelEC+iOn\$ Ph0r M4l3 4Nd PH3m4LE, J00 WoUld En+eR: <b>93ND3R:m4Le;feM@L3</b> iN T3H It3M N4M3 PhI3LD.";
$lang['editedwordfilter'] = "EdI+eD wOrd fil+3R";
$lang['editedforumsettings'] = "ed1+ED f0rUM S3TTIN9s";
$lang['sessionsuccessfullyended'] = "SE\$\$1On SUCCE55PHULLY 3nd3d pH0R user";
$lang['matchedtext'] = "M@Tch3d tEx+";
$lang['replacementtext'] = "rEpl4ceMENT +3X+";
$lang['preg'] = "PREG";
$lang['wholeword'] = "WhOL3 WOrd";
$lang['word_filter_help_1'] = "<b>4lL</b> m@tcHE\$ 494In\$t tH3 WHolE +3X+ 5O pH1Lt3R1N9 M0m T0 mUm W1Ll 4L5o cH4N9E MoMeNT To MuM3N+.";
$lang['word_filter_help_2'] = "<b>wH0LE W0RD</b> M@TcHEs 4G@In5+ WhOl3 w0rD5 0NlY S0 FIlT3R1NG M0M T0 MUM w1Ll NOT CH4N9E MoMeNt TO mUM3n+.";
$lang['word_filter_help_3'] = "<b>PREg</b> 4llOW\$ J00 +0 u\$3 p3rL ReGUl4r eXPr3S51ON5 +O m4tCh +eX+.";
$lang['forumdeletewarning'] = "AR3 j00 \$UrE j00 w4n+ +0 d3L3T3 +HE s3l3ct3d F0rUM? 0nc3 +he F0RUm Is dEl3+eD 1T's 3N+iR3 c0NTeNtS I\$ l0\$+ pH0ReVEr 4ND C@Nn0+ 8e R3CoVEr3D.";
$lang['deleteforum'] = "D3l3t3 ForUM";
$lang['successfullycreatedforum'] = "\$Ucc3\$5PHULLY cRE@t3d fOrum";
$lang['failedtocreateforum_1'] = "pH4iL3d +o cR3ATE FORUM";
$lang['failedtocreateforum_2'] = "pL34s3 cHECk t0 m4k3 SURE THE wEb+49 @Nd +48l3 N@M3S @R3N'+ @LREADy 1n uS3.";
$lang['nameanddesc'] = "N4mE 4nd d3ScR1pTI0N";
$lang['movethreads'] = "MOV3 +HRe4d5";
$lang['threadsmovedsuccessfully'] = "Thr34Ds m0V3d \$UcC3\$sFULLY";
$lang['movethreadstofolder'] = "m0ve ThREad\$ TO FoLD3R";
$lang['allowfoldertocontain'] = "4lLOw PH0Ld3R +o c0NT@IN";
$lang['addnewfolder'] = "4Dd n3w f0ldER";
$lang['mustenterfoldername'] = "J00 muS+ enTER @ f0lD3r N@me";
$lang['nofolderidspecified'] = "NO f0lD3r 1d 5p3cIPH13d";
$lang['invalidfolderid'] = "inv@lID f0LD3R 1d. cH3CK +H4+ 4 FOld3R W1TH +H15 id ex15t5!";
$lang['successfullyaddedfolder'] = "sUcC3SsfUlLY @DdEd PH0LD3R";
$lang['successfullydeletedfolder'] = "\$UCc3\$5FUlLy D3LETed PHoLD3R";
$lang['folderupdatedsuccessfully'] = "phoLD3r UPd4TeD SucCES5pHulLY";
$lang['forumisnotrestricted'] = "f0RUM i5 N0+ RES+R1c+ed";
$lang['noforumidspecified'] = "no FORUM ID \$P3c1PhI3d";
$lang['groups'] = "9R0UpS";
$lang['addnewgroup'] = "aDD N3w 9rOUP";
$lang['nousergroups'] = "no US3R GRoUP5 H4VE 8eEN s3+ up";
$lang['suppliedgidisnotausergroup'] = "5uppL1Ed g1D 15 nOT 4 us3r gROUp";
$lang['manageusergroups'] = "M@n@G3 US3r 9r0ups";
$lang['groupstatus'] = "gROUp 5t4tU\$";
$lang['addusergroup'] = "@DD GR0UP";
$lang['addremoveusers'] = "4dd/REM0vE US3Rs";
$lang['nousersingroup'] = "THEr3 4rE N0 u\$3r\$ 1N +h1S 9R0UP";
$lang['deletegroups'] = "dElET3 9ROUpS";
$lang['useringroups'] = "ThIS Us3r I5 4 m3M83R 0pH TH3 FOLL0WIN9 GrOUpS";
$lang['usernotinanygroups'] = "THi5 US3r 15 nO+ 1n @NY u5ER GR0uPS";
$lang['usergroupwarning'] = "N0+e: THI5 USer m4y bE 1NH3R1+iN9 4dD1TI0N4l pERm1\$s1ons PHR0M 4NY us3R GR0uP\$ L1\$T3d 83LOw.";
$lang['successfullyaddedgroup'] = "\$UCc3\$5FULLY @dd3d 9ROUP";
$lang['successfullydeletedgroup'] = "sUCCEs5FulLY d3LeT3d gR0uP";
$lang['usercanaccessforumtools'] = "us3r C@N @Cc355 pH0RuM T0oL\$ 4ND C4n cRE@T3, D3lET3 @nd ed1+ PH0RUMs";
$lang['usercanmodallfoldersonallforums'] = "U5Er c4N MoDER4T3 <b>4Ll PH0LDER5</b> 0N <b>4ll pH0ruM5</b>";
$lang['usercanmodlinkssectiononallforums'] = "u\$eR c4n mOD3R4+e LInk\$ SeC+10N 0N <b>@lL FoRUM5</b>";
$lang['emailconfirmationrequired'] = "em41L C0nphIrM4+10N ReqUireD";
$lang['cancelemailconfirmation'] = "c4NcEL EM4iL conPHirM4+Ion @ND 4lL0W U53R +o \$t4Rt poS+1N9";
$lang['resendconfirmationemail'] = "Re\$3nd c0NfIRm4TI0N eM41L +0 uSER";
$lang['donothing'] = "D0 no+H1n9";
$lang['usercanaccessadmintools'] = "u53r H@s ACC3sS +o PhORuM 4dMIn T00Ls";
$lang['usercanaccessadmintoolsonallforums'] = "U53r h@s 4ccESs +0 @dm1n +0ol\$ <b>0n @LL F0rUM\$</b>";
$lang['usercanmoderateallfolders'] = "US3R C4N Mod3R4Te @lL Ph0lD3RS";
$lang['usercanmoderatelinkssection'] = "USER C@N mOder@T3 L1NK5 \$3cTI0N";
$lang['userisbanned'] = "u\$ER 1\$ b4Nn3d";
$lang['useriswormed'] = "U\$ER Is w0rMED";
$lang['userispilloried'] = "us3r 15 pILl0r1ED";
$lang['usercanignoreadmin'] = "u\$3R cAN 1gN0RE 4dm1NI\$Tra+oR\$";
$lang['groupcanaccessadmintools'] = "9RouP c4n 4cc3\$5 4dm1N +oOLs";
$lang['groupcanmoderateallfolders'] = "gr0uP C4n mOd3R@TE ALl F0ld3r\$";
$lang['groupcanmoderatelinkssection'] = "9rOuP c4n MOder4t3 L1nkS secTI0n\$";
$lang['groupisbanned'] = "9r0uP IS bANNed";
$lang['groupiswormed'] = "9ROUp Is W0RmeD";
$lang['readposts'] = "Re@D POst\$";
$lang['replytothreads'] = "r3PLy to THRE@dS";
$lang['createnewthreads'] = "CRe4T3 N3W THR34Ds";
$lang['editposts'] = "3Di+ Po5+5";
$lang['deleteposts'] = "d3Let3 P0s+S";
$lang['uploadattachments'] = "UpL04D @tT4CHM3n+5";
$lang['moderatefolder'] = "M0Der4+E F0LDEr";
$lang['postinhtml'] = "P0\$t 1N hTml";
$lang['postasignature'] = "P0sT 4 S19N4+uR3";
$lang['editforumlinks'] = "3d1+ pH0RuM LiNK\$";
$lang['editforumlinks_exp'] = "U\$3 tH1s p4g3 +O @dD L1NK\$ +0 Th3 Dr0P-DoWN lI\$T DIsPl@Y3D In +h3 +0P-rIGh+ Oph Th3 PHORuM PHr@M3S3T. 1F N0 l1Nks 4R3 53+, +He DrOp-D0Wn LiSt W1LL No+ B3 D1sPl4Yed.";
$lang['notoplevellinkidspecified'] = "N0 top L3VEl l1Nk 1d sp3c1F1ed";
$lang['notoplevellinktitlespecified'] = "nO +Op l3VeL lINk T1+LE speCIFied";
$lang['youmustenteratitleforalllinks'] = "j00 MU\$T 3NT3R 4 T1+l3 PH0r AlL lInk\$";
$lang['youmustprovideapositionforalllinks'] = "j00 MUST PR0V1d3 4 L1nK Pos1T1On pH0R 4LL LINk\$";
$lang['alllinkurismuststartwithaschema'] = "@lL LINk UR15 mUsT s+Ar+ w1tH @ \$cH3M@ (I.3. HTtp://, FTP://, IRC://)";
$lang['allowguestaccess'] = "4lLoW Gu3\$T 4cc3\$5";
$lang['searchenginespidering'] = "534RcH eN91nE 5PIDeR-1nG";
$lang['allowsearchenginespidering'] = "4lL0W sE@RcH EnGINe \$P1D3r-Ing";
$lang['newuserregistrations'] = "neW UsEr R3GI5tR4TI0N\$";
$lang['preventduplicateemailaddresses'] = "PR3v3N+ DuPL1C4T3 3M4il 4DDreSSe5";
$lang['allownewuserregistrations'] = "4LloW N3W U\$3R R3GI5+R4Ti0ns";
$lang['requireemailconfirmation'] = "reQU1Re Em41L c0NPHirM4t1ON";
$lang['usetextcaptcha'] = "u5e T3xT cAp+cH@";
$lang['textcaptchadir'] = "TeX+ c@PTcH4 D1R3C+oRY";
$lang['textcaptchakey'] = "text C@pTch4 keY";
$lang['textcaptchafonterror_1'] = "+3Xt c4P+Ch4 h4S bEEN dI548Led @ut0M@TIC@lLY BEC4U\$3 +H3rE 4RE NO TRue TyP3 fOnTs 4V@1l@bL3 PH0R 1T tO u\$3. Ple4S3 UpLoad 50ME TRUe +yP3 PhON+5 TO";
$lang['textcaptchafonterror_2'] = "oN YOur 53RVER.";
$lang['textcaptchadirerror'] = "T3X+ C4p+cH4 h4s been Di548LEd bEc4U53 TeH T3X+_C@p+CH@ Dir3cT0rY @ND 1+'\$ sU8-D1r3c+0RI35 4R3 N0+ wrIt@8Le bY Th3 WEB 53RvEr / PhP Pr0cE\$S.";
$lang['textcaptchagderror'] = "+3Xt C4PTCh@ H@s beEN Di5@BleD BeC4uS3 Y0UR S3rVER'S pHp SE+Up do3s N0T PRoVID3 SuPPOrT FOr GD IM4g3 M@nIpUL@+i0N AND / 0R T+F Ph0n+ SUpP0RT. 80+H 4RE R3QUIr3d PH0R +3x+ c4P+cH4 5UPPoR+.";
$lang['textcaptchadirblank'] = "+Ex+ C4p+cH@ d1R3CTORY i5 BL@Nk!";
$lang['newuserpreferences'] = "New u53R pREF3reNcEs";
$lang['sendemailnotificationonreply'] = "3Ma1l n0+1PHic@T1ON On REPlY +0 User";
$lang['sendemailnotificationonpm'] = "eM4IL n0tIFIC4TION 0n pM T0 uS3R";
$lang['showpopuponnewpm'] = "sHoW P0PUp WHEn R3c31vING n3W PM";
$lang['setautomatichighinterestonpost'] = "53T 4U+Om4TIc Hi9h 1n+3REST 0N pO\$t";
$lang['top20postersforperiod'] = "top 20 P0\$+3RS FOR P3Riod %s T0 %s";
$lang['postingstats'] = "p0S+Ing \$t@T5";
$lang['nodata'] = "N0 d@t4";
$lang['totalposts'] = "T0+AL PO5+5";
$lang['totalpostsforthisperiod'] = "+0+@L P0\$t5 ph0r +H1s pER10D";
$lang['mustchooseastartday'] = "MUST cH0o53 @ S+4Rt D@y";
$lang['mustchooseastartmonth'] = "Mu5T cHOo\$3 A 5T4R+ MONth";
$lang['mustchooseastartyear'] = "MU\$+ cHOo\$3 4 5+4rt YE4R";
$lang['mustchooseaendday'] = "MUs+ cH0O5E @ 3ND dAy";
$lang['mustchooseaendmonth'] = "mUST cHoO\$3 4 3ND m0NTH";
$lang['mustchooseaendyear'] = "MU\$T CHoO\$3 4 3ND y34r";
$lang['startperiodisaheadofendperiod'] = "st@RT p3RI0d iS 4H34D 0F 3ND p3R1od";
$lang['bancontrols'] = "B4N c0N+Rol\$";
$lang['bannedipaddresses'] = "B4NN3d iP 4dDR35S3\$";
$lang['bannedlogons'] = "84Nned L090n\$";
$lang['bannednicknames'] = "84NN3d nIcKN4m3\$";
$lang['bannedemailaddresses'] = "b@NN3d EM@IL 4ddr3s53\$";
$lang['youcanusethepercentwildcard'] = "j00 c@n us3 +3h peRceNT (%) WiLdC@rD \$yMbOL iN 4nY 0F Y0uR b4n l15tS tO O8+4iN P4R+I@L M4tcH3\$, I.3. '192.168.0.%' W0Uld BAn 4Ll iP 4dDr3sse5 IN TEH R@n9E 192.168.0.1 +hRou9H 192.168.0.254</p>";
$lang['ipaddressisalreadybanned'] = "Th4T IP 4DDR3\$S 1s 4LreADY 84nned. cH3cK Y0UR W1LDC@Rd\$ +O S3E IPh TH3Y 4lrE4DY M@TCH IT.";
$lang['logonisalreadybanned'] = "+h4T L09ON IS 4lR34DY B@NNeD. chEcK YouR WiLDc4RDs To S3e 1pH +heY @LR3AdY m@tcH I+.";
$lang['nicknameisalreadybanned'] = "+H4T niCkN4M3 15 4Lr34dY 84nn3d. cHECK y0Ur W1LDC4RD\$ T0 S3E 1PH +heY 4LR34DY m@TCh It.";
$lang['emailisalreadybanned'] = "Th4+ 3m41l 4ddr3SS 1S aLre4Dy baNnED. CH3Ck yOur w1ldc4RdS to S3e Iph +H3Y @lr3AdY MA+cH 1t.";
$lang['cannotusewildcardonown'] = "j00 c4NN0+ 4dD % 45 4 wILDc4rD M@TcH On 1T'\$ 0WN!";
$lang['requirepostapproval'] = "r3qUir3 pO\$+ 4pPR0v@l";
$lang['adminforumtoolsusercounterror'] = "+her3 Mu\$+ bE 4+ l345+ 1 USer WITh 4dm1N ToOLs 4nd pHoRUm +o0L\$ 4Cc3SS On 4Ll pHoruM5!";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH@nG3d UseR \$+4TU\$ PH0r '%s'";
$lang['changedpasswordforuser'] = "cH4N9ED P4\$swORD PHOR '%s'";
$lang['changedforumaccess'] = "ch4n9eD f0RuM @CCEs5 p3RM1ss10nS F0r '%s'";
$lang['deletedallusersposts'] = "delEt3d 4lL PO\$T\$ pHOr '%s'";

$lang['createdusergroup'] = "cR3A+eD UseR GR0UP '%s'";
$lang['deletedusergroup'] = "del3+eD U\$3r GR0UP '%s'";
$lang['updatedusergroup'] = "UPD4T3d u53R 9ROUp '%s'";
$lang['addedusertogroup'] = "4DD3D Us3r '%s' +o 9R0Up '%s'";
$lang['removeduserfromgroup'] = "r3mOv3 u53r '%s' phR0m 9r0uP '%s'";

$lang['addedipaddresstobanlist'] = "4dDED Ip '%s' +O 8aN l15+";
$lang['removedipaddressfrombanlist'] = "reM0VeD IP '%s' PHrOM 8@n l1S+";

$lang['addedlogontobanlist'] = "4ddEd Lo9On '%s' +o 84N lISt";
$lang['removedlogonfrombanlist'] = "r3m0v3D L090n '%s' PHR0M b4n l15+";

$lang['addednicknametobanlist'] = "@dd3D nICkNAME '%s' +o 84n LI\$+";
$lang['removednicknamefrombanlist'] = "rEM0vED nIcKn@M3 '%s' pHR0m 84N L15T";

$lang['addedemailtobanlist'] = "4dd3D 3m@1l 4dDR3\$S '%s' t0 84N L1s+";
$lang['removedemailfrombanlist'] = "REMOv3D eM4IL 4dDr355 '%s' PHRom 84n Li5+";

$lang['editedfolder'] = "3dI+ED foLd3R '%s'";
$lang['movedallthreadsfromto'] = "m0VeD 4LL +Hr34Ds fR0M '%s' +O '%s'";
$lang['creatednewfolder'] = "Cr34TeD N3W f0LD3R '%s'";
$lang['deletedfolder'] = "d3L3teD Ph0ld3r '%s'";

$lang['changedprofilesectiontitle'] = "Ch@nG3d pROPhIl3 SEctI0N T1+l3 pHr0m '%s' +0 '%s'";
$lang['addednewprofilesection'] = "4dD3d N3w PrOFiL3 S3ct1on '%s'";
$lang['deletedprofilesection'] = "DEleT3D pR0F1L3 SECTi0N '%s'";

$lang['addednewprofileitem'] = "4DD3d N3W pRoFIL3 1tEM '%s' t0 S3cTI0n '%s'";
$lang['changedprofileitem'] = "Ch@NG3d PR0Ph1L3 1TeM '%s'";
$lang['deletedprofileitem'] = "DeL3+3d Pr0Fil3 IT3M '%s'";

$lang['editedstartpage'] = "EdIt3d ST4rT P4G3";
$lang['savednewstyle'] = "\$4VED NEw \$+YlE '%s'";

$lang['movedthread'] = "Moved Thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</@ >' from '%s' to '%s'";
$lang['closedthread'] = "Closed Thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</a >'";
$lang['openedthread'] = "Opened Thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</@ >'";
$lang['renamedthread'] = "Renamed Thread '%s' to '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</@ >'";
$lang['deletedthread'] = "Deleted Thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >'";

$lang['lockedthreadtitlefolder'] = "Locked thread options on '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >'";
$lang['unlockedthreadtitlefolder'] = "Unlocked thread options on '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >'";

$lang['deletedpostsfrominthread'] = "Deleted posts from '%s' in thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</a >'";
$lang['deletedattachmentfrompost'] = "Deleted attachment '%s' from post '<a href=\"index.php?msg=%s.%s\" target=\"_blank\">%s.%s</4 >'";

$lang['editedforumlinks'] = "3DIT3d F0ruM lINk\$";

$lang['deletedpost'] = "Deleted Post '<a href=\"index.php?msg=%s.%s\" target=\"_blank\">%s.%s</4 >'";
$lang['editedpost'] = "Edited Post '<a href=\"index.php?msg=%s.%s\" target=\"_blank\">%s.%s</@ >'";

$lang['madethreadsticky'] = "Made thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >' sticky";
$lang['madethreadnonsticky'] = "Made thread '<a href=\"index.php?msg=%s.1\" target=\"_blank\">%s</4 >' non-sticky";

$lang['endedsessionforuser'] = "eNd3d \$e\$5I0n PhOr u53r '%s'";

$lang['approvedpost'] = "Approved post '<a href=\"index.php?msg=%s.%s\" target=\"_blank\">%s.%s</A >'";

$lang['editedwordfilter'] = "3D1+ED WorD FIL+3R";

$lang['adminlogempty'] = "4DM1n lo9 I5 3mpty";
$lang['clearlog'] = "cle@R L09";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['webtaginvalidchars'] = "w38+@g c4n 0nLY c0nT@IN upPErC4\$e A-z, 0-9, _ - CH@R@c+3rs";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "9lo84l u\$3R P3RM155I0n5";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumname'] = "J00 mU\$t \$UPPLY 4 FORum n4ME";
$lang['mustsupplyforumemail'] = "J00 MUs+ 5UPPLY 4 phOruM 3M41L 4Ddres5";
$lang['mustchoosedefaultstyle'] = "j00 mUsT cHO0S3 A dEpH4UL+ PH0rUM 5tYLe";
$lang['mustchoosedefaultemoticons'] = "J00 Mu5T CHoo\$3 d3PH4Ult F0rUM 3M0+1cOnS";
$lang['unknownemoticonsname'] = "unKNown eM0+icON\$ N@m3";
$lang['mustchoosedefaultlang'] = "J00 mUS+ choO\$E A DEPh4ul+ Ph0RUM l4N9U@Ge";
$lang['activesessiongreaterthansession'] = "AC+iV3 \$E\$51On tIM3ou+ c@Nn0+ 8E GRE4+Er TH4N 53\$510N +1M3ou+";
$lang['attachmentdirnotwritable'] = "4t+4cHM3nT dIReC+ORy Mu\$t be WR1+4bl3 8y +He W38 53RVER / pHP PROCeS5!";
$lang['attachmentdirblank'] = "J00 mU\$T 5UpPLY 4 D1R3c+ORY TO S4VE 4++4CHM3NTs 1N";
$lang['mainsettings'] = "m@1N S3TT1ng5";
$lang['forumname'] = "Ph0rum N4m3";
$lang['forumemail'] = "PH0rum 3M4IL";
$lang['forumdesc'] = "F0rUM d3\$cR1p+10n";
$lang['forumkeywords'] = "Ph0RUM K3YW0RDs";
$lang['defaultstyle'] = "DePh4ULT Styl3";
$lang['defaultemoticons'] = "D3F4uLt 3m0+ICon5";
$lang['defaultlanguage'] = "D3pH4Ul+ lAnGU4g3";
$lang['forumaccesssettings'] = "F0rUM 4cceS\$ 5e+T1Ng\$";
$lang['forumaccessstatus'] = "fOruM accEsS 5t4tu\$";
$lang['changepermissions'] = "Ch4N9e pErM1sSi0n\$";
$lang['changepassword'] = "ch@n9e P@5\$w0rd";
$lang['passwordprotected'] = "PasSWoRD Pr0+ECT3d";
$lang['postoptions'] = "po\$T 0pT10Ns";
$lang['allowpostoptions'] = "@lLOW POST ED1TiNG";
$lang['postedittimeout'] = "pO\$T ED1t T1m3Ou+";
$lang['wikiintegration'] = "W1KiW1Ki In+39R@tI0N";
$lang['enablewikiintegration'] = "En48le wIKiW1Ki 1N+E9R4+10N";
$lang['enablewikiquicklinks'] = "3nablE wiK1wIKi QUIck LInk\$";
$lang['wikiintegrationuri'] = "WiK1wiKI Loc@+10N";
$lang['maximumpostlength'] = "m@xIMum PoST L3NgTH";
$lang['postfrequency'] = "pO\$+ PHReqUENCY";
$lang['enablelinkssection'] = "en48Le LINkS SEc+I0N";
$lang['allowcreationofpolls'] = "@lL0w cRE@tI0N 0pH PolLS";
$lang['searchoptions'] = "\$E@rcH op+1ONS";
$lang['searchfrequency'] = "5E4RCh phreqUENCY";
$lang['sessions'] = "s3SsI0nS";
$lang['sessioncutoffseconds'] = "se\$s10n CUT OFF (SeCoND5)";
$lang['activesessioncutoffseconds'] = "@c+IVe \$E\$\$i0n cu+ OphF (S3c0nD5)";
$lang['stats'] = "sT4tS";
$lang['hide_stats'] = "H1D3 \$+@t5";
$lang['show_stats'] = "5h0W \$T4T5";
$lang['enablestatsdisplay'] = "3NA8L3 5T4Ts d1Spl4Y";
$lang['personalmessages'] = "P3R\$0n4L M3SsA93S";
$lang['enablepersonalmessages'] = "eN4bLe PeR\$0N@l mEs5@G3\$";
$lang['pmusermessages'] = "pM m35\$49Es P3R U53r";
$lang['allowpmstohaveattachments'] = "@LLOw p3RS0N4L M3\$S493\$ tO H4V3 @TT4cHm3nTS";
$lang['autopruneuserspmfoldersevery'] = "4u+O PRUNE user'S Pm Fold3rs 3VeRY";
$lang['guestaccount'] = "9UE\$+ acC0uNT";
$lang['enableguestaccount'] = "3N4bLE 9U3St 4ccOUNt";
$lang['autologinguests'] = "4Ut0m4tic@LLY lOgiN gUe5+\$";
$lang['guestaccess'] = "GueST 4cc3\$5";
$lang['allowguestaccess'] = "4LlOW GU35t 4cces\$";
$lang['enableattachments'] = "EnAbL3 @T+4cHM3NT5";
$lang['attachmentdir'] = "at+ACHM3nT D1R";
$lang['userattachmentspace'] = "4T+4cHM3NT \$P4c3 p3r U53r";
$lang['allowembeddingofattachments'] = "AlL0W eM83DD1NG 0F AT+4cHMENTS";
$lang['usealtattachmentmethod'] = "US3 4l+3rN@tIVE 4TT4cHMeN+ meTh0d";
$lang['forumsettingsupdated'] = "fOrUM SE+tIN9s \$ucc3\$sfULLy UPD4t3d";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>pOsT ed1+ +1M3ou+</b> 1s tEH +1M3 iN houR\$ 4F+Er p0\$+1nG +h4+ 4 U\$3r c4n eDI+ th3iR P05T. 1f \$3+ +0 0 TH3r3 1s N0 l1m1T.";
$lang['forum_settings_help_11'] = "<b>M4XIMum PO5t LEN9+h</b> 15 +h3 M4XIMum nUMB3R oPh ch4r4c+ER\$ +H4+ W1lL bE d15PL@yed 1N @ P0St. 1Ph 4 P0s+ i5 LOn9Er +H4n +H3 NUmBER 0f Ch4R4C+3Rs D3PhINEd H3R3 I+ W1Ll 8E cU+ SHORt 4Nd 4 L1Nk ADDeD To +3H BOtT0M TO 4Ll0W US3Rs +0 R34d +H3 WH0l3 P0\$T On 4 53P4R4T3 p@Ge.";
$lang['forum_settings_help_12'] = "1f J00 Don't w@NT y0UR u53Rs T0 be @Ble +0 cr3@t3 pOll\$ J00 c@n dIS@8LE +EH 480VE opTiOn.";
$lang['forum_settings_help_13'] = "+H3 LINk\$ 53c+ION Of b3EHIv3 PROvIDE5 4 PL4cE phor Y0UR Us3rs t0 M4iNT4iN 4 L1St oF sIT35 tHEy PhREQu3NTlY V1S1t +H4t O+HER U53R5 M4Y F1Nd U\$efUL. lInKs c@N BE d1V1dED 1N+0 c4TEgOrI3s BY pHOldEr 4ND 4LL0w FOR coMM3N+s 4ND R@+INGS to bE 91V3N. 1N OrdEr To M0DeR4+E +HE L1Nks \$EC+1oN 4 Us3R MUST 83 R@NTeD 9L08@L M0dER4toR \$+4TuS.";
$lang['forum_settings_help_15'] = "<b>5ESs10n cuT 0pHPH</b> is +eh M@X1mUM +1m3 83fOR3 4 u53r'S 53S\$i0n Is de3mED D34d And +H3Y 4RE Lo9G3d 0U+. By dePh4Ul+ th1\$ I5 24 H0UR\$ (86400 s3CONdS).";
$lang['forum_settings_help_16'] = "<b>AC+ive 53\$s10N cu+ 0PHpH</b> 1\$ T3h m4x1mUM T1m3 BeFORe 4 uS3r'S \$e\$SI0n is D33MED In@ct1V3 4T wHICh Po1NT tH3Y Ent3R 4N 1dLE S+@+3. IN THi\$ s+4T3 THe U\$Er r3M41N\$ L09G3d 1n, But +H3Y 4RE R3M0vED Fr0M tH3 4C+1vE U5eR5 l1\$+ 1n +3H s+4+S d15pL@y. oNCe +h3y 83c0M3 4c+iV3 @9@iN TH3y W1lL 83 r3-@DDED TO THe LI5t. bY dEPH4UL+ TH1s S3+T1nG 1s SE+ +o 15 MInu+E5 (900 \$3C0ND\$).";
$lang['forum_settings_help_17'] = "eN4bLIN9 +h15 0Pt1ON @LL0w5 beeHIve To INCluDE @ S+4tS DisPl4y 4+ +eH b0TTOm OPh Th3 M3\$s4GEs P4n3 S1MIl@R To +He ONe u53D 8y M@Ny Ph0RUm s0F+W4Re +1+LES. oNC3 3n@8L3D +H3 di5pL@y 0F +Eh 5T@TS P@9E c4n BE To9GlEd 1Nd1V1du@lLY 8Y 34cH U\$ER. iPh Th3Y d0N'+ W4N+ t0 53E I+ +HEY C4N H1D3 I+ FRoM V13W.";
$lang['forum_settings_help_18'] = "PERs0n4L M3\$S4G35 4R3 INv4lU48lE 4S @ W@Y 0pH T4Kin9 m0RE PrIV4t3 m@Tt3R\$ 0U+ 0F V13W 0PH +Eh 0+h3R M3MbeR\$. h0weV3r IF J00 d0N't W4NT YOuR uS3RS T0 b3 48LE +0 \$3nD E4Ch 0Th3r PeR\$On4L m3ss@9E\$ j00 c4N DiS@8lE +h1s Op+ION.";
$lang['forum_settings_help_19'] = "P3R50N4L Me\$5493S C@N @LsO coNT4IN 4TT4CHm3n+\$ whICH c4N 8E US3PhUl pHoR excH4n9INg FIl3s bE+W33N u53RS.";
$lang['forum_settings_help_20'] = "<b>n0T3:</b> THE SP4c3 4lL0c4+10n fOR pm 4++4CHmEnT5 1S tAkeN fR0m e@CH U\$3RS' m41N @++4cHMEnT @LLoCA+I0N @ND 1t n0+ In @ddI+I0N T0.";
$lang['forum_settings_help_21'] = "tH3 Gue5T @cc0Un+ @LLoW5 vIsi+0R\$ +O Y0UR FoRum T0 RE@d P0\$T5 wItH0Ut hav1Ng To \$IgN UP f0R @N 4CC0UnT.";
$lang['forum_settings_help_22'] = "1F J00 pR3PH3R j00 C@N @l\$0 \$3TUP Y0ur 8EEHIv3 PH0RUm \$0 +H@+ 9U35+5 4RE 4u+OM4T1C4LlY l09G3D In. 0NC3 4 U\$3R ReG1sTeR\$ TheY W1ll 4Lw4YS bE sH0Wn +3H L091N \$CR3En 4\$ l0Ng @\$ tHe1R C00KIes REm4IN 1NTAC+.";
$lang['forum_settings_help_23'] = "8E3HIv3 4LLOWS 4++4cHM3N+\$ t0 83 UpLO@ded T0 mES\$493S WH3n P05T3D. IF J00 H4VE lIm1T3d wE8 5p4C3 J00 M@Y WhICH +O D154BL3 4++4chMeNt5 8Y CLE4rINg THe b0x 48ov3.";
$lang['forum_settings_help_24'] = "<b>@t+4cHMEN+ D1r</b> 1s +3H l0c@TIOn 8EEHIV3 5Hould \$T0r3 1+'\$ 4+T@cHMeNT5 in. tHis DIR3cT0RY MUsT 3X1s+ 0N YOuR W3B 5P@c3 @ND MU\$T B3 wr1+4BLe 8y +H3 W38 53rVER / PhP pr0C3\$\$ o+HerWI5E UpLO4d5 w1ll pH41L.";
$lang['forum_settings_help_25'] = "<b>4TT4chm3n+ 5P4c3 pER U\$3R</b> iS +EH m@X1mUM 4m0UN+ Oph dIsK SP4C3 4 u53R H4s fOr 4Tt@CHm3NTs. 0nCE +h15 sPACe I5 UseD Up +H3 Us3R CANn0T UpL0@d @NY m0r3 @tT4cHmEnT\$. 8y dEpH4ULt TH1s 15 1Mb 0Ph SPacE.";
$lang['forum_settings_help_26'] = "<b>@Ll0w eMB3ddInG oph 4T+4cHMENTs 1N ME\$S4gE\$ / si9n@tUREs</b> 4LLows UsERS To eM8Ed 4++4CHM3N+5 1N Po\$T5. En4bL1Ng +H1s 0Pt10N WHiL3 U\$3PHuL CaN 1NcRE@5E YOuR 84NDW1DTh US4G3 DR4\$+1C@LLy UNDeR C3RT4iN c0nPhI9Ur@t1oNs Of PHP. If J00 h@Ve l1M1tED b@NDW1D+H 1T 1S R3C0mmEnDED +H4T J00 dIs48L3 +Hi\$ Op+IoN.";
$lang['forum_settings_help_27'] = "<b>U5E @l+eRN@+IV3 aTT@CHm3NT mETh0D</b> Ph0RCe\$ bEEH1V3 +0 u\$3 4N 4l+ErN4T1V3 R3+r13V4L M3+HOD PH0R @++4ChMEN+s. IPh j00 rEC3iV3 404 3RROR M3ss4G3\$ WHEn TRy1NG +O DoWNl04D 4+T4cHmEN+s FroM MESs49Es +Ry 3N@8lIng +hI\$ 0Pt1oN.";
$lang['forum_settings_help_28'] = "+h1S 53++INg @Ll0WS YOUr pHORuM +0 83 spID3R-3d bY SE@RCH eN9INE5 l1k3 9O0Gle, 4LT4V15+@ 4nD y4h00. 1F J00 5W1TcH +H1s OPt1ON OfPH Y0Ur FOrUM WilL N0T b3 InclUDed IN Th3SE \$34RCH En9InE\$ r35UL+\$.";
$lang['forum_settings_help_29'] = "<b>@LlOW nEW U53r r39i5+R4T10nS</b> 4lLOW\$ OR d1S@LL0wS +he Cre4tI0n 0pH neW u53R 4cCOun+s. SEttING t3H 0p+i0N +0 No COMpLET3lY D1s4bL3\$ TH3 R3gI5tR@+1on PHOrm.";
$lang['forum_settings_help_30'] = "<b>3n4Ble wik1WIK1 1n+E9r@+1ON</b> pROv1D3\$ W1KIw0Rd 5uPP0r+ 1n YOUr Ph0RuM POsT5. 4 w1K1Word i\$ m4dE UP 0F +W0 0R MoRe c0NC4+eN4+Ed W0RdS w1Th UPPeRC4\$E l3TtER\$ (0F+3N REfeRReD tO 4S c4M3LC4s3). iPH J00 Wr1tE A w0RD Th1\$ W4y 1+ w1Ll 4U+OM4+iC@LLy 8E CH4N93D 1N+O @ HYPERLiNk POin+InG +O Y0uR CH0\$3N W1K1W1k1.";
$lang['forum_settings_help_31'] = "<b>eN@8L3 WIkIWiK1 QuICk lINkS</b> 3N4bLES The U\$3 0pH M\$G:1.1 @ND Us3R:Lo90N \$+YL3 EXTENdED w1KIL1NkS Wh1CH CrE4T3 HYPERl1NKS t0 ThE 5P3c1F1ed mESS@Ge / U\$3R ProF1Le 0f +Eh sP3CiPhIEd u53r.";
$lang['forum_settings_help_32'] = "<b>WikiWiki Location</b> is used to specify the URI of your WikiWiki. When entering the URI use [WikiWord] to indicate where in the URI the WikiWord should appear, i.e.: <i>http://en.wikipedia.org/wiki/[WikiWord]</i> would link your WikiWords to <a href=\"http://en.wikipedia.org/\" target=\"_blank\">Wikipedia.org</4 >";
$lang['forum_settings_help_33'] = "<b>F0rUM 4ccE55 s+4TU5</b> c0n+r0Ls H0W u\$3R5 M4Y @cCEs\$ Y0UR PH0RuM.";
$lang['forum_settings_help_34'] = "<b>0p3n</b> W1lL @Llow 4Ll U\$eR\$ 4Nd gue\$ts 4ccE5s +0 yOUR pHORUm W1TH0UT R35TRIC+I0N.";
$lang['forum_settings_help_35'] = "<b>Cl0S3D</b> Pr3VENtS @cc3\$S PH0r @lL U\$3rs, w1+h tHE EXC3pT10N OF tHE @DMin Wh0 m4y \$+ILl @cC3\$S +h3 @DM1n p4N3L.";
$lang['forum_settings_help_36'] = "<b>R3STr1cTED</b> @LL0w\$ +0 \$3+ @ LIS+ of u53R\$ wHo @R3 4Ll0wEd 4cc3\$5 +0 y0UR F0RUM.";
$lang['forum_settings_help_37'] = "<b>p@ssWORD pR0t3ct3d</b> @ll0w\$ j00 TO set @ Pa\$sW0RD t0 gIvE 0UT tO Us3rs 5o Th3y c4N @ccEs5 YOuR FoRUM.";
$lang['forum_settings_help_38'] = "WH3n \$3+tiN9 RE5Tr1c+Ed Or P4\$SwOrD PrO+ECT3d mOd3 J00 W1Ll NeEd +0 saV3 YOUr CHANGe\$ bEpHoRe J00 c4N ChaN9e T3h U\$er 4CC3\$\$ priV1L393s 0R pAsSw0RD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"pHRom kILL1N9 Th3 \$3RV3r.";
$lang['forum_settings_help_40'] = "<b>P0sT Phr3qU3nCY</b> 1S tEh M1NIMUm +IME @ uSER Mus+ W41t b3Phor3 th3Y C4n PoST 4g4In. +Hi\$ 53TtIN9 4L\$O 4pHFeCT\$ +EH CRE4tIoN OPh POLlS. sEt TO 0 T0 D1\$48Le +EH R3sTRiCt1ON.";
$lang['forum_settings_help_41'] = "+hE 4b0Ve Opt1OnS cH4N9E T3h deF@ULT V4LU3\$ pHor +hE uSER RegiS+R4tI0N FOrM. wH3R3 4PPL1c48L3 0+hEr \$EtTIN95 w1LL U\$3 +H3 fORum'\$ 0wN DePH4ULT 5Et+IN95.";
$lang['forum_settings_help_42'] = "<b>PR3ven+ uSe of duPl1C@T3 Em@1L 4ddr3ss3s</b> PHOrceS B3ehIV3 +o cHeCk +h3 USeR 4cCOUN+5 494INst tEh em4IL 4DDR3ss Th3 us3R 1\$ R3g1\$+3R1n9 WI+H 4nd PRoMp+5 THem +0 U\$3 @no+HeR IPH i+ 1S @LRE@DY 1n Us3.";
$lang['forum_settings_help_43'] = "<b>REQu1r3 3mAIL CoNf1RM4+1ON</b> WH3N 3N48l3D W1LL 53ND 4N 3m41l +o 34CH N3W u53R W1TH A LiNK Th@t c@N B3 u\$3d +o coNf1RM +H3Ir em4Il 4DdR3\$\$. Un+IL +H3Y COnF1Rm THe1r EM41L 4DDr3sS +h3Y W1lL N0T BE 48L3 To P05T Unl3ss +H3Ir USEr P3RM1SSIoN5 @R3 ch4N93D M4Nu4LLy 8Y @n 4DmIN.";
$lang['forum_settings_help_44'] = "<b>u\$3 +3X+ c4p+ch4</b> pRE5eN+S tH3 N3w US3r w1+H @ mANGL3d 1M@93 wHiCH THEY mU5t C0PY 4 NUMbER fR0m In+O 4 +3Xt fI3LD 0n Th3 Re91\$+R@+10N PhoRm. U53 +hiS 0PtIOn TO PreVEn+ @U+0m4tEd \$i9N-uP VI4 \$Cr1P+\$.";
$lang['forum_settings_help_45'] = "<b>TexT c4p+Ch@ d1R3C+OrY</b> \$p3c1PHIE5 TH3 Loc4+I0N +h4+ bE3HivE w1LL S+0r3 1T'\$ T3x+ C4Ptch@ Im4G35 4ND pH0nts IN. tHI\$ d1rec+0RY MuSt B3 Wr1t48Le 8Y +H3 w3B sErv3R / pHp PR0c3ss @ND Mu\$T 8e @cc35Si8L3 vi4 H+tP. @f+3R J00 H4Ve En48L3D T3XT c4ptcH@ j00 MUST UpL04D soM3 +rUE +YP3 Ph0Nt\$ 1NTO T3H FoN+s \$UB-D1R3C+OrY 0f YoUr M4IN TeXt C4PtCH4 dIr3cT0RY 0THeRw1S3 b33HiVE W1Ll sKIp +H3 TEX+ C4PtCh@ Dur1NG UsER R3g1sTR4TiON.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"tEH cOD3.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "@Id N0t SP3cIPHIEd.";
$lang['upload'] = "uPlo4d";
$lang['uploadnewattachment'] = "UpL04D N3W 4++4cHM3N+";
$lang['waitdotdot'] = "W@1t..";
$lang['successfullyuploaded'] = "5Ucc3\$\$fULLy UPl04dEd";
$lang['failedtoupload'] = "F@Il3d +o uPlO4d";
$lang['complete'] = "cOmPLeTE";
$lang['uploadattachment'] = "uPL04d 4 f1LE FOR @+t4chM3Nt +o tHe meS54G3";
$lang['enterfilenamestoupload'] = "3NT3R f1LeN@m3(\$) +0 uPlo4D";
$lang['attachmentsforthismessage'] = "@T+AChM3N+S for +h1s m3\$\$4G3";
$lang['otherattachmentsincludingpm'] = "O+HeR @TT4cHmEN+S (INcLuDIN9 Pm mESS@gEs 4nD O+HeR F0RUmS)";
$lang['totalsize'] = "+0+4l 51z3";
$lang['freespace'] = "pHr3e SP@c3";
$lang['attachmentproblem'] = "+HEr3 W4\$ 4 pr08l3m d0WNlo@din9 +h1\$ 4Tt@cHMEnt. pL3@S3 +rY 4g@1n l@T3R.";
$lang['attachmentshavebeendisabled'] = "Att@chmenTs hAVE beeN d15@bLeD bY T3H FORUm OWN3r.";
$lang['canonlyuploadmaximum'] = "j00 C4n ONly UPL0@d 4 m4xiMum 0pH 10 fILES 4+ 4 +iM3";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4SsWord ChaN9Ed";
$lang['passedchangedexp'] = "y0Ur P45SWord h4S 83eN cHANGED.";
$lang['updatefailed'] = "uPD4t3 f@iL3D";
$lang['passwdsdonotmatch'] = "P45SworD\$ D0 nO+ M@tcH.";
$lang['allfieldsrequired'] = "4Ll FIElds 4r3 REQuireD.";
$lang['requiredinformationnotfound'] = "R3Qu1RED 1nF0rM4TI0N n0+ pH0UnD";
$lang['forgotpasswd'] = "phOR90+ P4\$SW0RD";
$lang['enternewpasswdforuser'] = "3N+eR @ N3W p@\$swOrD pH0R U\$eR";
$lang['resetpassword'] = "r3Se+ P4\$5W0Rd";
$lang['resetpasswordto'] = "R3\$et p4SSW0rd +O";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 meS\$4GE SPECIphied phOr DeLe+1on";
$lang['deletemessage'] = "d3LET3 M35S49e";
$lang['postdelsuccessfully'] = "pO\$t DelE+ed sUCCEs\$FuLly";
$lang['errordelpost'] = "ERRoR D3l3T1ng Pos+";
$lang['delthismessage'] = "DeL3Te tHis mE\$S493";
$lang['cannotdeletepostsinthisfolder'] = "J00 C4NNO+ del3t3 pO\$TS 1n +hIS pHOLD3R";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "NO m3SS@g3 \$p3CIF13d pH0R 3DiTIN9";
$lang['edited_caps'] = "Edi+ed";
$lang['editappliedtomessage'] = "eDi+ 4pPL1Ed +O m3sS4Ge";
$lang['errorupdatingpost'] = "Err0R uPD4+iN9 PoST";
$lang['editmessage'] = "edIt MesS49E";
$lang['editpollwarning'] = "<b>n0+3</b>: EdIT1ng c3RT4IN 4spEc+s 0F @ POLl WILL v01d @lL +he cuRREN+ Vo+3s 4Nd @Ll0w PE0pLE +o Vo+e 4G@1N.";
$lang['hardedit'] = "H4RD 3DIT 0P+I0Ns (VOT3\$ w1ll be R3\$3t):";
$lang['softedit'] = "\$0pH+ 3dIT 0p+10N\$ (V0t3s WIll 83 RE+4iN3d):";
$lang['changewhenpollcloses'] = "cH4N93 WH3n +eH P0LL cLOs3\$?";
$lang['nochange'] = "N0 ch4Ng3";
$lang['emailresult'] = "eM41L r3\$uL+";
$lang['msgsent'] = "mE5S@GE sENT";
$lang['msgsentsuccessfully'] = "mESs493 53nT sucCes\$fuLLy.";
$lang['msgfail'] = "m3S54G3 f@iL3d";
$lang['mailsystemfailure'] = "M@IL \$Y5+3m f4ILUR3. m3Ss@93 N0t s3Nt.";
$lang['nopermissiontoedit'] = "j00 4RE nO+ P3rM1+ted tO 3dI+ +H15 Me\$5A93.";
$lang['pollediterror'] = "j00 C@NN0+ edIT POLLs";
$lang['cannoteditpostsinthisfolder'] = "J00 c@nN0+ EdI+ pO\$T5 IN ThI5 FOld3R";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "n0 User \$PEc1phiEd fOR 3m41LIn9.";
$lang['entersubjectformessage'] = "3N+3r @ Su8j3CT Ph0r tH3 M3sS4G3";
$lang['entercontentformessage'] = "ENTer 50ME c0nt3n+ pHOR teH m35S4GE";
$lang['msgsentfromby'] = "Th1\$ mEs54G3 w4\$ s3N+ pHROM %s 8Y %s";
$lang['subject'] = "Su8jEc+";
$lang['send'] = "5End";

$lang['msgnotification_subject'] = "M3\$S493 NO+ifiC@TI0n PhRoM";

$lang['msgnotificationemail_1'] = "p0S+ed 4 ME554GE To J00 0N";
$lang['msgnotificationemail_2'] = "+hE su8j3c+ 1s:";
$lang['msgnotificationemail_3'] = "t0 Re@d +h4t M35s4ge 4ND O+H3r\$ 1n tEH S@Me d15cUsSIon, 90 TO:";
$lang['msgnotificationemail_4'] = "n0+E: 1Ph j00 do NO+ WI\$H t0 R3c3ive 3m4IL nO+1pHIc4+10nS OF f0ruM";
$lang['msgnotificationemail_5'] = "MES\$4g3S p0S+ed +0 you, G0 T0:";
$lang['msgnotificationemail_6'] = "Cl1cK ON MY cOn+RolS +HEN 3M@1l 4nd PR1v4cy, unSeLect +h3 3m4iL";
$lang['msgnotificationemail_7'] = "N0+iPHiC4+1ON cH3CK8Ox 4nD pR3sS \$u8MI+.";

$lang['subnotification_subject'] = "Su85CRIPTI0N n0+1F1C@T1on PHRom";

$lang['subnotification_1'] = "po5T3D 4 M3\$s4Ge 1n 4 +hRE4D j00 h4Ve 5u8sCr1B3D tO ON";
$lang['subnotification_2'] = "+Eh su8J3cT 1\$:";
$lang['subnotification_3'] = "+O RE4d +H4+ MES5@gE 4nd OthERS iN +Eh S4me D1Scus5i0n, g0 +o:";
$lang['subnotification_4'] = "n0te: IPH J00 D0 N0+ W1\$h T0 rEcE1Ve Em4IL NO+IPH1c4+i0n\$ OPH nEW";
$lang['subnotification_5'] = "m3\$\$4G3\$ 1N THI\$ +hR3@D, g0 t0:";
$lang['subnotification_6'] = "@nD 4dJUST y0UR iN+eRES+ L3v3L A+ +he b0+T0M OF THe P@g3.";

$lang['pmnotification_subject'] = "pm N0t1Phic4T1On PHRom";

$lang['pmnotification_1'] = "POST3d 4 Pm +O J00 oN";
$lang['pmnotification_2'] = "tH3 sU8J3cT 1s:";
$lang['pmnotification_3'] = "+o rE4D T3H m3\$s4G3 90 T0:";
$lang['pmnotification_4'] = "N0+3: If J00 dO N0T WI\$H T0 R3c31VE 3M4iL noTIPhICa+1oN\$ OF N3W PM";
$lang['pmnotification_5'] = "M3sS4Ge\$ PoS+3d +O YOU, G0 t0:";
$lang['pmnotification_6'] = "cl1cK mY con+rOlS +hEn Em4IL 4nD pRIV4CY, uN53lEC+ +HE pM";
$lang['pmnotification_7'] = "no+Iph1C@+10N CHEckbOX 4ND Pre\$S sU8MI+.";

$lang['passwdchangenotification'] = "Pas5W0rD cH4N9E n0+1phIc4T1oN FrOm";

$lang['pwchangeemail_1'] = "+hi5 @ N0+1pH1C@tI0N 3mA1L +O 1npH0RM j00 tH4T y0UR P4S\$wOrd ON";
$lang['pwchangeemail_2'] = "h4\$ 8EeN ch4NgED.";
$lang['pwchangeemail_3'] = "it H4s BeEn ch4N93d To:";
$lang['pwchangeemail_4'] = "@Nd w@5 cH4nG3D 8Y:";
$lang['pwchangeemail_5'] = "1pH J00 H4v3 RecE1VED THIS eM@IL 1N ERr0R oR w3R3 Not eXpeC+1N9";
$lang['pwchangeemail_6'] = "a Ch4N9E +O YoUR P4s5W0Rd PL34s3 cOnt@c+ +H3 FoRUm 0WnEr 0R 4 M0DeR@T0R 0N";
$lang['pwchangeemail_7'] = "Immed14TeLy +o cORr3c+ It.";

$lang['hasoptedoutofemail'] = "H@5 0P+ED 0UT 0PH eM4Il coN+4c+";
$lang['hasinvalidemailaddress'] = "h4s 4n 1nV4lid 3m@1l 4dDr3\$S";

$lang['emailconfirmationrequired'] = "3m4Il coNFIrM4t10N r3qUIReD";

$lang['confirmemail_1'] = "hElL0";
$lang['confirmemail_2'] = "j00 R3cEN+lY CR34t3d @ N3w US3R ACc0uN+ ON";
$lang['confirmemail_3'] = "83pHOr3 j00 C@n sT4R+ p0\$TIn9 wE n3ED t0 cOnF1RM Y0UR 3M4Il 4DDRE\$S.";
$lang['confirmemail_4'] = "DoN'T wORrY THi5 I\$ Qui+E E4sy. @LL J00 NE3D +0 d0 I\$ CLiCk +HE lInK";
$lang['confirmemail_5'] = "bEl0w (0r CopY 4Nd PAS+3 it In+0 yOUR br0W\$eR):";
$lang['confirmemail_6'] = "0Nc3 c0nFirM4tI0N 1s c0mPl3te J00 m4Y Lo9In 4ND \$T@rT p0S+In9 IMMed14t3lY.";
$lang['confirmemail_7'] = "IPH J00 d1d NO+ cR34+3 4 U\$eR 4CC0uN+ 0n";
$lang['confirmemail_8'] = "pl3@s3 4ccEP+ 0Ur 4p0LO9i3\$ 4nD fORW4Rd +H1\$ em4il +O";
$lang['confirmemail_9'] = "50 TH4+ +HE \$ouRCE 0Ph 1+ m4y 83 1nv3\$tI94+3d.";

// Error handler (errorhandler.inc.php) --------------------------------

$lang['retry'] = "RE+RY";

// Forgotten passwords (forgot_pw.php) ---------------------------------

$lang['forgotpwemail_1'] = "j00 R3qUeS+ED +HI\$ 3-m4Il pHR0M";
$lang['forgotpwemail_2'] = "83c4USE j00 h4VE Forg0++EN YouR P@\$sworD.";
$lang['forgotpwemail_3'] = "cLicK T3h L1Nk BElOW (0r copY 4nD P@\$t3 1+ In+0 youR bR0w\$eR) t0 rE\$3+ YoUr P@sSW0rD";
$lang['passwdresetrequest'] = "YOur p4sSw0RD R3\$3+ R3qUES+";
$lang['passwdresetemailsent'] = "p4s\$W0rD r3\$3+ 3-M@iL 5en+";
$lang['passwdresetexp'] = "j00 sH0UlD rEC3IV3 4N e-MA1l c0NT4IN1n9 INs+RuCTI0NS F0R rEs3++1ng y0UR P@\$5w0rD Sh0R+LY.";
$lang['validusernamerequired'] = "4 V4LId u5ErN4ME i5 r3qU1RED";
$lang['forgottenpasswd'] = "f0R9o+ P4\$swOrD";
$lang['forgotpasswdexp'] = "iF J00 h4v3 F0Rgo++En YoUR p4\$SWOrd, j00 cAN REQU3st +0 H4vE 1T r3s3T bY enT3rINg Y0Ur l0G0n n@me 83L0W. 1NStRUc+IOn\$ 0n H0W To R353T Y0ur P@\$sW0rd w1LL 83 53Nt +o YoUr r3GiSTeR3D Em4Il 4ddR35s.";
$lang['couldnotsendpasswordreminder'] = "COulD n0+ s3nD P4s5W0RD RemINDEr. pL345e cOn+@CT T3H f0RuM 0WnEr.";
$lang['request'] = "R3QuE5T";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "3m@1L C0NPHiRMAt1on";
$lang['emailconfirmationcomplete'] = "Th4nK j00 FoR ConF1RMiNG YoUr Em@1L 4DDr3\$\$. J00 m4Y N0W l0GIn @ND st4RT P0sT1NG 1MmEdI4+elY.";
$lang['emailconfirmationfailed'] = "3m4iL CONpH1RM4+I0N H4s F41Led, PL3@\$3 +RY 494In LATeR. IpH J00 3NC0unTer Th1S ErroR MuLTipL3 T1M3S pLE453 C0Nt4C+ tEH pHoRUM oWn3r 0R @ M0d3R4+Or pHoR @\$5i\$T4Nc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "toP L3VEL";
$lang['maynotaccessthissection'] = "J00 M4Y no+ 4cc355 tH1S 53cTIoN.";
$lang['toplevel'] = "+OP Lev3L";
$lang['links'] = "LiNKS";
$lang['viewmode'] = "vIEw M0D3";
$lang['hierarchical'] = "hIer@rCHIC@l";
$lang['list'] = "l1st";
$lang['folderhidden'] = "+H1s PhoLd3R 15 HiDd3N";
$lang['hide'] = "HIdE";
$lang['unhide'] = "uNhiD3";
$lang['nosubfolders'] = "No \$u8fOLD3r5 iN +h1\$ c@+EgORy";
$lang['1subfolder'] = "1 sUBF0ld3R 1N ThIS C@t39OrY";
$lang['subfoldersinthiscategory'] = "\$ubPH0lDER5 In THI5 c4T3GOrY";
$lang['linksdelexp'] = "En+r135 1N 4 del3+ED pH0LdER W1lL bE M0vED +0 T3H p4R3N+ f0lDER. ONLY f0ld3r\$ WhICh D0 N0+ coN+41N SUbpH0lDEr\$ M@y 83 dEL3T3D.";
$lang['listview'] = "lIS+ V13W";
$lang['listviewcannotaddfolders'] = "C4NNO+ 4dD F0LD3r\$ IN +h1\$ V13W. SHoWInG 20 3nTR135 4t 4 TIm3.";
$lang['rating'] = "r@+InG";
$lang['commentsslashvote'] = "c0mM3n+S / vo+3";
$lang['nolinksinfolder'] = "N0 LInKs in Th1S pHolD3R.";
$lang['addlinkhere'] = "4dD lINK HeR3";
$lang['notvalidURI'] = "+h4T Is NoT @ V@L1d Ur1!";
$lang['mustspecifyname'] = "J00 MUST spECIFy 4 n4M3!";
$lang['mustspecifyvalidfolder'] = "J00 MuS+ Spec1phy 4 VaLId PH0ld3R!";
$lang['mustspecifyfolder'] = "j00 mUSt Sp3cIfY 4 F0LD3r!";
$lang['addlink'] = "aDD 4 L1nk";
$lang['addinglinkin'] = "4DD1N9 l1Nk 1n";
$lang['addressurluri'] = "@DdrE\$5 (uRL/URi)";
$lang['addnewfolder'] = "@dD @ n3W fOLd3R";
$lang['addnewfolderunder'] = "@ddIng n3w ph0lDER UNd3R";
$lang['mustchooserating'] = "j00 MuST CHoOS3 @ r4+1N9!";
$lang['commentadded'] = "Your c0mMENT W45 @dd3d.";
$lang['musttypecomment'] = "J00 Mu5+ +YP3 4 c0mM3Nt!";
$lang['mustprovidelinkID'] = "j00 mU\$T PROvidE 4 liNK 1d!";
$lang['invalidlinkID'] = "invAlID L1nK ID!";
$lang['address'] = "@DdRE\$\$";
$lang['submittedby'] = "\$UbMi++ED 8Y";
$lang['clicks'] = "cLiCK5";
$lang['rating'] = "r4T1n9";
$lang['vote'] = "v0Te";
$lang['votes'] = "Vo+ES";
$lang['notratedyet'] = "N0+ r4t3d BY 4NyON3 yET";
$lang['rate'] = "R@Te";
$lang['bad'] = "84D";
$lang['good'] = "90od";
$lang['voteexcmark'] = "V0T3!";
$lang['commentby'] = "cOmMen+ 8Y";
$lang['addacommentabout'] = "4DD 4 C0MMeN+ 4b0uT";
$lang['modtools'] = "moDEr@TI0N +0OLS";
$lang['editname'] = "EDIT n@M3";
$lang['editaddress'] = "EDI+ 4DDreS5";
$lang['editdescription'] = "3D1t de\$cR1p+10n";
$lang['moveto'] = "moVe T0";
$lang['linkdetails'] = "L1nk dET41lS";
$lang['addcomment'] = "aDd cOmM3n+";
$lang['voterecorded'] = "y0Ur VO+E h45 83EN R3C0rD3d";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "U\$3r 1D";
$lang['alreadyloggedin'] = "@LREady LO9g3d 1n";
$lang['loggedinsuccessfully'] = "J00 LoGGed 1N sUCCESsFULLy.";
$lang['presscontinuetoresend'] = "prES\$ C0N+1nu3 To R3\$End F0rM d4+4 or C4ncEL T0 reL0@D p@g3.";
$lang['usernameorpasswdnotvalid'] = "t3H US3rN4m3 0R P@\$SwoRD J00 sUpPlI3D 1S N0+ V4lID.";
$lang['pleasereenterpasswd'] = "Pl3453 r3-3N+Er YOUR P4sSWORD And +Ry 49@1N.";
$lang['rememberpasswds'] = "Rem3m8Er p@S5W0rd5";
$lang['rememberpassword'] = "R3mEMBER P@S5w0RD";
$lang['enterasa'] = "3N+ER 4\$ 4 %s";
$lang['donthaveanaccount'] = "DoN'+ H4VE 4n 4ccOunT? %s";
$lang['registernow'] = "r39I5t3R NOW.";
$lang['problemsloggingon'] = "Pr08L3M\$ Lo9gING 0n?";
$lang['deletecookies'] = "Del3+3 c0Ok13\$";
$lang['cookiessuccessfullydeleted'] = "C0Ok1e\$ 5UCCE\$SFulLY dELETed";
$lang['forgottenpasswd'] = "f0rGo++En y0Ur P@sSw0RD?";
$lang['usingaPDA'] = "using 4 PD4?";
$lang['lightHTMLversion'] = "LiGH+ H+Ml V3R5IoN";
$lang['youhaveloggedout'] = "J00 H4V3 L0G9ED ouT.";
$lang['currentlyloggedinas'] = "j00 4r3 cURR3N+lY Lo9g3D 1N 4s";
$lang['logonbutton'] = "l0gon";
$lang['otherbutton'] = "OtHER";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my PH0rUM5";
$lang['recentlyvisitedforums'] = "R3cENTlY VIs1T3D pH0RUMs";
$lang['availableforums'] = "4V4iL48L3 f0RUmS";
$lang['favouriteforums'] = "f@v0URIT3 FoRUM\$";
$lang['lastvisited'] = "l4\$+ v1S1T3D";
$lang['unreadmessages'] = "UnreAD m3\$s49eS";
$lang['removefromfavourites'] = "reM0Ve FR0m F@vouRI+35";
$lang['addtofavourites'] = "@DD To ph@vOuRi+ES";
$lang['availableforums'] = "@V41L4BLE PHOrUMS";
$lang['noforumsavailable'] = "+heR3 4re No FOruM5 4v4iL4blE.";
$lang['noforumsavailablelogin'] = "ThER3 4r3 NO f0RUM5 4vA1l48lE. pLe@53 logIN to V1EW y0UR pHoRUM5.";
$lang['passwdprotectedforum'] = "p4sSWORd PRo+eCT3d PH0RuM";
$lang['passwdprotectedwarning'] = "tH1\$ phoRUM IS P@5sWORd PRot3Ct3d. +o G@iN 4Cc3\$s eNt3r +eh p@5swoRD Bel0w.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "posT M3\$sagE";
$lang['selectfolder'] = "S3lect PH0ldER";
$lang['mustenterpostcontent'] = "j00 mUST enT3R \$0m3 coN+3n+ F0r t3H pOs+!";
$lang['messagepreview'] = "M3ss49e PREv13W";
$lang['invalidusername'] = "1Nv4L1d u\$ERn4M3!";
$lang['mustenterthreadtitle'] = "J00 Mu\$T en+Er @ +1+Le pHor Th3 +hR34D!";
$lang['pleaseselectfolder'] = "pL34\$3 53l3C+ A F0ldER!";
$lang['errorcreatingpost'] = "ErROr CR34+inG p0\$T! pl3453 +Ry 4941n 1N A f3W miNU+e5.";
$lang['createnewthread'] = "cRe4+e n3w +HR34d";
$lang['postreply'] = "Pos+ rePlY";
$lang['threadtitle'] = "+hR34d +itL3";
$lang['messagehasbeendeleted'] = "m3\$S49E h@5 bEeN D3letED.";
$lang['pleaseentermembername'] = "PlEA\$3 3n+ER 4 mEm83R n4m3:";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c@NNo+ pOST +HIs +HRE4D +YP3 iN ThA+ FolD3r!";
$lang['cannotpostthisthreadtype'] = "J00 cANNo+ p0ST ThIs +HRe4D TYp3 As +H3R3 AR3 N0 4V4IL4BlE FoLD3r\$ tH4+ 4lLoW iT.";
$lang['cannotcreatenewthreads'] = "j00 C4Nn0t cR3@t3 nEW THre@dS.";
$lang['threadisclosedforposting'] = "+h1S THRE@d 1S cLoS3D, J00 c4NN0t P0\$T 1n I+!";
$lang['moderatorthreadclosed'] = "W4rNIn9: THI\$ +HR3@d Is cL0s3D PHoR P0s+iN9 TO NoRM@l U5Ers.";
$lang['threadclosed'] = "tHRe@d CLo\$3d";
$lang['usersinthread'] = "us3R\$ iN +hRE@d";
$lang['correctedcode'] = "c0RRec+3d c0DE";
$lang['submittedcode'] = "\$U8mitT3D C0DE";
$lang['htmlinmessage'] = "H+Ml 1N M3\$5@G3";
$lang['disableemoticonsinmessage'] = "d1\$48Le Em0t1cON\$ in MeS5@G3";
$lang['automaticallyparseurls'] = "@u+0mA+1C4lLY p4R\$E Urls";
$lang['automaticallycheckspelling'] = "@U+Om4t1C4lLY cH3Ck \$PELl1N9";
$lang['setthreadtohighinterest'] = "\$ET tHrE4D T0 HI9H iN+ERE5+";
$lang['enabledwithautolinebreaks'] = "en4bL3D wI+H 4UtO-L1N3-8RE4ks";
$lang['fixhtmlexplanation'] = "+his PHoRUm u53\$ HtmL F1LT3rIng. Y0UR \$UBM1TT3D hTML H4\$ b33n m0DiF1ED bY +H3 PHIlTER5 In \$Om3 W4Y.\\n\\N+0 VIew Y0Ur 0RiG1N@L C0D3, s3L3C+ THe \\'5ubMIT+ED c0DE\\' R4D10 8uT+0N.\\nT0 View +h3 mODiPH13D COde, S3l3C+ tEH \\'C0Rr3Ct3d C0DE\\' R4Dio bu+TON.";
$lang['messageoptions'] = "mE5S49E 0Pt10N\$";
$lang['notallowedembedattachmentpost'] = "j00 @rE N0T 4LLOwED +O EM83d aTt4cHM3n+S IN y0UR p0sTs.";
$lang['notallowedembedattachmentsignature'] = "J00 @RE N0+ 4lL0Wed t0 3MBED 4Tt4CHm3NTs 1N yoUR 51Gn4TUR3.";
$lang['reducemessagelength'] = "mE\$s4G3 LeN9+H Mus+ be und3r 65,535 cH@R@cTERS (cUrreN+ly:";
$lang['reducesiglength'] = "\$1gn4tUrE Len9tH mU\$t Be uNDER 65,535 ch4r4ct3r\$ (cURR3n+lY:";
$lang['cannotcreatethreadinfolder'] = "J00 c4NN0+ Cr3@+E n3W +hre@D5 In +HI\$ F0LD3R";
$lang['cannotcreatepostinfolder'] = "j00 c@nN0t R3Ply T0 pOSTS 1n +h1\$ PHOlD3R";
$lang['cannotattachfilesinfolder'] = "j00 C@nN0+ P0St @Tt@CHmEn+S 1N +his FolDeR. R3M0V3 4tT4ChM3NT5 t0 ConT1Nu3.";
$lang['postfrequencytoogreat_1'] = "J00 cAn 0NLY p0st 0ncE EV3RY";
$lang['postfrequencytoogreat_2'] = "5ecOnDS. PL34s3 +RY @G41N L4t3R.";
$lang['emailconfirmationrequiredbeforepost'] = "eM41l conPHIrM4+1oN 1s reqU1R3d 83PH0Re j00 C@N P0sT. 1F J00 H4V3 Not R3cE1V3D @ C0NPHIrM4T1oN 3M@Il PLe4\$3 Cl1Ck +H3 8U++0N 8EL0W @ND A NEw ONe WILl bE \$3N+ T0 Y0u. IF YoUr Em41L 4DdR3S\$ N33Ds PLe4Se Do 5o B3PhoR3 r3QUes+1N9 4 NEw CoNpH1RM@t10N 3M@1L. j00 m@Y Ch@nG3 YouR 3M4Il 4DdRE\$5 8Y cLicK mY CoN+roLS 4B0V3 4ND +H3N u\$er d3T@1LS";
$lang['emailconfirmationfailedtosend'] = "c0NfiRm4Ti0N EM4iL F@iL3D To \$eNd. pL34SE cOn+4c+ tH3 PHOruM 0wN3r to REC+iPHY +H1\$.";
$lang['emailconfirmationsent'] = "c0nFIrm4+1On Em4iL hAS b3En r3\$eNT.";
$lang['resendconfirmation'] = "r3s3nd cOnf1RM4TI0n";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "1N R3pLY +O";
$lang['showmessages'] = "\$h0w M3\$54g3s";
$lang['ratemyinterest'] = "r4T3 MY iN+eR3St";
$lang['adjtextsize'] = "@DJuS+ +eX+ \$IZe";
$lang['smaller'] = "\$M4LL3R";
$lang['larger'] = "L4rGER";
$lang['faq'] = "f4q";
$lang['docs'] = "D0cs";
$lang['support'] = "sUPpOR+";
$lang['donateexcmark'] = "DON4+3!";
$lang['threadcouldnotbefound'] = "tHe R3QU3\$+3D THR3@D COulD nOT bE F0UND OR 4cc3\$5 w4s dENi3D.";
$lang['mustselectpolloption'] = "j00 MuST S3LECT 4N 0PTiOn To VO+3 F0R!";
$lang['mustvoteforallgroups'] = "J00 mU\$T V0+E 1N 3vERY GROuP.";
$lang['keepreading'] = "Ke3p R34DIN9";
$lang['backtothreadlist'] = "b4CK +0 tHre@d LIs+";
$lang['postdoesnotexist'] = "Th4t P0sT dO3\$ NO+ EXI5+ 1n thI5 THR34D!";
$lang['clicktochangevote'] = "CliCK +O cH4N93 VoT3";
$lang['youvotedforoption'] = "J00 VoT3D FoR 0P+I0N";
$lang['youvotedforoptions'] = "j00 vO+ED pHOR OP+1ons";
$lang['clicktovote'] = "CL1CK +o v0+e";
$lang['youhavenotvoted'] = "j00 h4vE NOt V0+3d";
$lang['viewresults'] = "Vi3W RE\$UL+s";
$lang['msgtruncated'] = "mESS4Ge +rUNc4T3D";
$lang['viewfullmsg'] = "v1eW FULL M3\$54Ge";
$lang['ignoredmsg'] = "19NoRed M3Ss49e";
$lang['wormeduser'] = "w0rmed USER";
$lang['ignoredsig'] = "19n0rEd \$i9N4+uR3";
$lang['wasdeleted'] = "W4s D3L3+Ed";
$lang['stopignoringthisuser'] = "stOp iGN0R1N9 tHI5 U\$3r";
$lang['renamethread'] = "rEN@M3 +HRE4D";
$lang['movethread'] = "MoVE +hRE4D";
$lang['editthepoll'] = "3di+ +eH PoLl";
$lang['torenamethisthread'] = "+0 R3N4M3 +h1S ThrE4D";
$lang['closeforposting'] = "Cl0S3 ph0r pO\$t1Ng";
$lang['until'] = "uN+IL 00:00 uTC";
$lang['approvalrequired'] = "@Ppr0V4L R3QUiREd";
$lang['awaitingapprovalbymoderator'] = "1S @w4I+IN9 4pPR0V@L BY 4 mOD3R@+0r";
$lang['postapprovedsuccessfully'] = "p0St 4pPR0vED \$UCCEs5PHulLY";
$lang['approvepost'] = "@Ppr0Ve Pos+ ph0R d1\$PL4Y";
$lang['approvedcaps'] = "4PPR0v3D";
$lang['makesticky'] = "M4K3 \$TICKY";
$lang['linktothread'] = "P3RM4n3nT l1NK +o +hI5 +Hr34d";
$lang['linktopost'] = "lINK +0 P0\$T";
$lang['linktothispost'] = "l1nk T0 tHIs po\$t";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@nnO+ dI5PL4Y F0LdER M0DeR4t0RS";
$lang['mustprovidefolderid'] = "V@LiD FoLDER 1d MUsT 83 PR0v1dED";
$lang['moderatorlist'] = "M0dER@t0r l1St:";
$lang['modsforfolder'] = "modER@+oR\$ PH0r FOLD3R";
$lang['nomodsfound'] = "N0 M0d3R4+0rS FOUnd";
$lang['forumleaders'] = "FOrUM l34deRS:";
$lang['foldermods'] = "fOlD3R MODeR@t0R5:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "\$+4R+";
$lang['messages'] = "MeS54G3S";
$lang['pminbox'] = "PM InbOX";
$lang['startwiththreadlist'] = "5T4RT P4g3 wI+H +hRe@D lI5T";
$lang['pmsentitems'] = "5En+ I+eM\$";
$lang['pmoutbox'] = "OuTb0X";
$lang['pmsaveditems'] = "\$@V3d 1t3M\$";
$lang['links'] = "l1nkS";
$lang['admin'] = "ADMIN";
$lang['login'] = "LoGIN";
$lang['logout'] = "l090U+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------
$lang['privatemessages'] = "prIV4t3 M3\$s4g35";
$lang['addrecipient'] = "4dd reciPi3N+";
$lang['recipienttiptext'] = "\$EP4R4+3 RECiPI3Nts bY \$em1-colOn oR CoMM4";
$lang['maximumtenrecipientspermessage'] = "+h3RE 1S @ lIMIT 0F 10 r3cIPi3n+\$ PER MEsS4G3. pLE@S3 4m3nd Y0UR rEc1PI3N+ L1ST.";
$lang['mustspecifyrecipient'] = "j00 mu5t \$P3c1PHY 4T L3@ST 0ne r3ciP1EN+.";
$lang['usernotfound1'] = "U53R";
$lang['usernotfound2'] = "NOt f0UND.";
$lang['sendnewpm'] = "S3nd nEW Pm";
$lang['savemessage'] = "\$4VE meS54g3";
$lang['timesent'] = "+iMe \$3N+";
$lang['nomessages'] = "no MeSs@g3s";
$lang['errorcreatingpm'] = "eRr0r cR34tINg PM! PLeAs3 TrY 494in 1N @ Ph3W M1Nut35";
$lang['writepm'] = "wRI+e M3sS4G3";
$lang['editpm'] = "eDIT M35s4G3";
$lang['cannoteditpm'] = "c4NnO+ EDIt +h1S Pm. 1T H4s 4LrE4Dy 833n V13WEd bY t3h R3ciPiEN+ 0R +EH mEsS@GE DOE\$ no+ 3x1sT OR i+ I\$ IN4cCE\$\$iBL3 8Y j00";
$lang['cannotviewpm'] = "C4nNO+ V13W PM. mES\$@ge d0ES no+ eX1\$+ or 1+ 1s iN@cc35s1BlE 8Y J00";
$lang['nouserspecified'] = "no U5ER sp3C1PHi3D.";
$lang['youhavexnewpm'] = "j00 H4VE %d N3W PMs. W0uld j00 LIk3 To 90 +0 Y0UR INBox N0w?";
$lang['youhave1newpm'] = "j00 h4V3 1 NEw pm. W0uLD J00 L1K3 +0 G0 T0 YOUR 1NbOx N0w?";
$lang['youdonothaveenoughfreespace'] = "J00 d0 NOT h@VE ENouGh phR3E 5P@C3 T0 \$3ND +h1\$ M3s549E.";
$lang['notenoughfreespace'] = "Do3\$ N0T h@vE 3NOuGh Fr3e \$P@Ce +0 R3CE1v3 tHI5 M3s54g3";
$lang['hasoptoutpm'] = "H4S 0Pt3D 0U+ 0PH R3c31VinG P3Rs0n4L ME\$s4GEs";
$lang['pmfolderpruningisenabled'] = "PM fOldeR pRunING Is 3N48LEd!";
$lang['pmpruneexplanation'] = "+HIs F0RuM US3\$ Pm PH0lDer PrUN1NG. +3H M35s4G3\$ J00 h4V3 ST0r3D 1N Y0Ur 1n80X 4ND 53N+ IT3Ms\\NfoLDer\$ @re subJ3c+ To 4U+0mATIC dEL3+ion. @NY M3SS4gE\$ J00 W1SH +0 ke3P shouLd B3 m0V3d +0\\NYouR \\'5AVED 1TEMS\\' PHoLdeR s0 Th@T tHey 4r3 NO+ D3L3+3D.";
$lang['yourpmfoldersare_1'] = "YOur PM FOld3R\$ @rE";
$lang['yourpmfoldersare_2'] = "FULL";
$lang['currentmessage'] = "cuRRent mes54Ge";
$lang['unreadmessage'] = "UnR34D meS5493";
$lang['readmessage'] = "Re4D m3ssA9E";
$lang['pmshavebeendisabled'] = "P3R\$0N4L Mes\$4g35 H4VE 83EN D1\$48LED 8Y TH3 PH0RUM Own3R.";
$lang['adduserstofriendslist'] = "4dD users TO y0UR fR13nd\$ l1s+ TO H@V3 Them 4Pp34R 1N @ dR0P DOwN oN +H3 PM WRit3 m3SS@9e P493.";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY cOn+R0L\$";
$lang['myforums'] = "my Ph0rUms";
$lang['menu'] = "m3Nu";
$lang['userexp_1'] = "u\$E T3h M3nU 0N th3 lEf+ +0 m@nagE YOUR 53T+iNg5.";
$lang['userexp_2'] = "<b>U\$eR D3+4iLs</b> @LlOW\$ J00 tO ch@NG3 YouR n4me, EM@iL 4ddR3sS 4ND p4\$\$woRD.";
$lang['userexp_3'] = "<b>U53R prOPH1lE</b> 4LL0W\$ j00 +O 3di+ YOUR u\$ER pR0fIlE.";
$lang['userexp_4'] = "<b>ch@NGE p45SW0rD</b> 4LL0W5 j00 +O ch4ng3 Y0UR p4\$\$woRD";
$lang['userexp_5'] = "<b>Em41l &amp; pRIV4cY</b> LETs J00 cH4NG3 how J00 C4N 83 c0NT@cT3d 0N 4ND OphPh +H3 F0rUm.";
$lang['userexp_6'] = "<b>PH0RUM 0PT1On5</b> L3+S j00 ch@Ng3 HOw +EH ForUM LOoKs @nd WOrks.";
$lang['userexp_7'] = "<b>4Tt4ChM3N+\$</b> 4LLoWs J00 +0 EDIt/D3LeTE Y0Ur 4TT@CHm3N+5.";
$lang['userexp_8'] = "<b>3DiT \$1gN4tURE</b> L3+\$ j00 EDI+ YouR S1GN4+uR3.";
$lang['userdetails'] = "US3r d3+@1L\$";
$lang['userprofile'] = "u53r Pr0pH1l3";
$lang['emailandprivacy'] = "em41L &amp; Pr1V@Cy";
$lang['editsignature'] = "edIt s1gN@tURe";
$lang['editrelationships'] = "3dI+ rEL@t1ON5HIPS";
$lang['norelationships'] = "j00 H4V3 No us3R rEl@TI0N\$H1Ps \$3+ UP";
$lang['editattachments'] = "3D1+ 4tT@cHMen+\$";
$lang['editwordfilter'] = "3D1+ WOrd PHiL+eR";
$lang['userinformation'] = "U\$eR 1Nf0rM@TI0N";
$lang['changepassword'] = "cH4N9E P45\$w0Rd";
$lang['currentpasswd'] = "CUrR3N+ P4ssW0rD";
$lang['newpasswd'] = "nEW P@ssWOrd";
$lang['confirmpasswd'] = "CoNf1RM Pas5WOrD";
$lang['passwdsdonotmatch'] = "P4sSW0rD\$ DO no+ M4+cH!";
$lang['nicknamerequired'] = "N1cKN4m3 1\$ REqu1R3d!";
$lang['emailaddressrequired'] = "eM41l 4ddrE\$S is r3qU1rED!";
$lang['logonnotpermitted'] = "l09On N0+ pErMIT+3d. ch0OSe @NO+h3r!";
$lang['nicknamenotpermitted'] = "NiCKN4M3 n0+ PErM1Tt3D. cH0o53 4N0+H3r!";
$lang['emailaddressnotpermitted'] = "emAil 4Ddr35s N0t p3Rm1tteD. cH0053 4NOTH3r!";
$lang['emailaddressalreadyinuse'] = "3M41l 4ddRe\$S 4lr34dY 1N uSE. CHOO\$3 4N0+H3R!";
$lang['relationshipsupdated'] = "reL4t1On\$H1Ps UPD4+ED";
$lang['relationshipupdatefailed'] = "r3l4t1OnSHIP UPDa+Ed f4IL3d!";
$lang['preferencesupdated'] = "prePH3r3NC3\$ W3Re \$UCCE55FULlY UPd4+3d.";
$lang['userdetails'] = "USEr dE+41lS";
$lang['firstname'] = "PHirst N4mE";
$lang['lastname'] = "L4s+ n4ME";
$lang['dateofbirth'] = "d4T3 0F bIR+h";
$lang['homepageURL'] = "HoMEP@g3 uRl";
$lang['pictureURL'] = "Pic+uR3 uRL";
$lang['forumoptions'] = "ph0RUM opTI0nS";
$lang['pmoptions'] = "Pm OP+1ON\$";
$lang['notifybyemail'] = "No+1FY by em41L 0PH p0\$t5 T0 me";
$lang['notifyofnewpm'] = "No+IPHy BY p0PUp 0PH N3W PM m3s\$@GES T0 mE";
$lang['notifyofnewpmemail'] = "N0+IpHy 8y 3m41l 0F nEW Pm m3\$S49e5 tO mE";
$lang['daylightsaving'] = "4DjU5+ For d4YL1GHt s4V1N9";
$lang['autohighinterest'] = "@UTOM@T1c4lly m@rK ThR34d5 i pO\$T iN 45 hI9H In+3rE\$t";
$lang['convertimagestolinks'] = "@U+OM4TIC4LLY c0NV3r+ eMbEDDEd 1M49E\$ IN P05+\$ iNt0 L1Nk5";
$lang['thumbnailsforimageattachments'] = "+hUMbN41Ls ph0R IM4G3 4TT@chM3N+5";
$lang['smallsized'] = "\$M4LL s1Z3D";
$lang['mediumsized'] = "mediuM 5Iz3d";
$lang['largesized'] = "l@rg3 sIz3d";
$lang['globallyignoresigs'] = "9lO8@Lly 1GNor3 uSeR SIGN4TURes";
$lang['allowpersonalmessages'] = "@lL0w 0+HeR USeRS +0 53ND m3 pER50n@L M3S\$@G3S";
$lang['allowemails'] = "4lLOW 0+H3r u\$eR5 TO \$3ND M3 eM@1Ls vI4 MY PRoF1L3";
$lang['timezonefromGMT'] = "tIMe ZoNE";
$lang['postsperpage'] = "pos+5 P3R p4G3";
$lang['fontsize'] = "f0nT sIzE";
$lang['forumstyle'] = "PhorUm \$+YLE";
$lang['forumemoticons'] = "pH0RUM EM0+ICOns";
$lang['startpage'] = "STArT p4Ge";
$lang['containsHTML'] = "c0Nt41NS hTml";
$lang['preferredlang'] = "Pr3f3rrED L@NGu4g3";
$lang['donotshowmyageordobtoothers'] = "Do n0T 5H0W mY 493 0R d@te 0F bIr+h +o 0tH3R5";
$lang['showonlymyagetoothers'] = "shoW ONly mY @9e +O O+hEr5";
$lang['showmyageanddobtoothers'] = "sH0W bo+h mY @G3 4ND d@t3 0F 8IR+h +0 O+hERS";
$lang['listmeontheactiveusersdisplay'] = "L1ST M3 ON +3H @CtIVe Us3R\$ dI5PL4Y";
$lang['browseanonymously'] = "8R0W53 FORUM 4NONym0U5LY";
$lang['allowfriendstoseemeasonline'] = "BR0WSe @n0NYM0U\$ly, 8U+ @lL0W Fr1ENd5 t0 S3E M3 4S 0nlIn3";
$lang['showforumstats'] = "sH0W PhOrUm 5t4T\$ 4t 80TTOm OF MEs54g3 Pan3";
$lang['usewordfilter'] = "3n4BLE word pH1lt3R.";
$lang['forceadminwordfilter'] = "pHORC3 Use OpH 4DMIN worD FIlteR ON @LL u53rS (iNc. gu3\$ts)";
$lang['timezone'] = "+IM3 ZOne";
$lang['language'] = "L4nGU4g3";
$lang['emailsettings'] = "3m4Il 4nD cOnT@C+ 5eT+1N9\$";
$lang['forumanonymity'] = "PhOrUM @nOnyM1tY 53++1Ng5";
$lang['birthdayanddateofbirth'] = "8IR+hD4Y 4nd d4t3 OPh b1rTH dI\$pl4Y";
$lang['includeadminfilter'] = "InCLude @dMiN WORd FilT3R 1N My l1s+.";
$lang['setforallforums'] = "S3+ FOr ALL ForUM\$?";
$lang['containsinvalidchars'] = "CONt41N3D InV4Lid ch@R@c+3R\$!";
$lang['postpage'] = "P0s+ P4G3";
$lang['nohtmltoolbar'] = "NO h+mL T00L84R";
$lang['displaysimpletoolbar'] = "d1SpL4Y \$iMPL3 H+mL +O0L84R";
$lang['displaytinymcetoolbar'] = "di\$PL@Y wY\$1wYG h+Ml +00LBAr";
$lang['displayemoticonspanel'] = "Di\$PL4Y 3M0+1c0NS P4n3l";
$lang['displaysignature'] = "d1spL4y SI9N@TUr3";
$lang['disableemoticonsinpostsbydefault'] = "dIS4BLe EM0+IC0N\$ iN M35s4G3\$ BY d3pH4UL+";
$lang['automaticallyparseurlsbydefault'] = "@Ut0M4T1c4lly p4RsE uRLS 1N MES\$@9es 8Y DEf4Ul+";
$lang['postinplaintextbydefault'] = "PO\$T In pL41n +EXt bY dEF@ULT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "pO5+ 1N hTML w1tH 4uTo-L1N3-8R34k5 bY DEF@uL+";
$lang['postinhtmlbydefault'] = "P0ST iN h+mL by d3F@ULT";
$lang['privatemessageoptions'] = "pRiV4+3 mE5s4Ge OptIoNS";
$lang['privatemessageexportoptions'] = "pR1v4+3 m3\$S49e eXPoR+ OP+10nS";
$lang['savepminsentitems'] = "S4VE 4 CoPY oF 34cH Pm 1 \$END 1N MY 53nt 1t3ms pH0LDer";
$lang['includepminreply'] = "INcLUD3 ME\$S4g3 bOdY wH3N rEPLYInG tO pM";
$lang['autoprunemypmfoldersevery'] = "4u+0 PrUnE MY PM PH0LDErs 3VERY:";
$lang['friendsonly'] = "pHri3ND\$ 0nLY?";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 Mu5+ pr0v1dE S0m3 4n5W3R 9RouPs";
$lang['mustprovidepolltype'] = "j00 mu\$+ ProV1D3 4 P0Ll +YP3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 Mu5T PROv1D3 Re\$uL+\$ dIsPL@Y TYPe";
$lang['mustprovidepollvotetype'] = "j00 MU5T PRov1dE 4 P0Ll Vo+e tYPE";
$lang['mustprovidepolloptiontype'] = "j00 MU\$T PR0v1dE @ p0LL OP+ION TYP3";
$lang['mustprovidepollchangevotetype'] = "J00 muS+ pr0V1DE 4 POlL cH@n93 v0T3 TyP3";
$lang['groupcountmustbelessthananswercount'] = "nuMBeR OPH 4n\$w3R 9ROUPs MU5t 8E L35S +H@n TOt@l nUMB3R OPH 4NSWERs";
$lang['pleaseselectfolder'] = "pL345E SeLECT @ pHOLD3R";
$lang['mustspecifyvalues1and2'] = "j00 MU5+ sPeC1pHY V4lU3\$ f0r 4NSw3R\$ 1 4nD 2";
$lang['tablepollmusthave2groups'] = "T48uL4r FOrm4T p0Ll5 mUs+ H4V3 prECI53lY +WO V0+1nG GROUP5";
$lang['nomultivotetabulars'] = "+@8Ul4R Ph0RM4+ P0Ll\$ C4NN0+ Be MUL+I-Vo+3";
$lang['nomultivotepublic'] = "PubLic b4LL0+\$ C4nNo+ 83 MULt1-V0+E";
$lang['abletochangevote'] = "j00 wIlL 83 4bLE TO chan9e y0UR v0+E.";
$lang['abletovotemultiple'] = "j00 W1LL 8E 4bL3 tO VO+E mULTIPlE tiM3\$.";
$lang['notabletochangevote'] = "J00 W1lL n0+ 83 48Le +0 cH4NG3 Y0Ur V0+e.";
$lang['pollvotesrandom'] = "n0t3: P0lL vo+eS 4R3 r4ND0MLY 9EN3R4T3D PHoR Pr3VI3W Only.";
$lang['pollquestion'] = "POLl qU3\$t1on";
$lang['possibleanswers'] = "po5S1ble 4n5W3R\$";
$lang['enterpollquestionexp'] = "3N+ER +HE @NsW3Rs Ph0R YOuR P0lL QuestIoN.. 1PH Y0uR PoLL 1s 4 &quot;yes/N0&quot; Qu35TI0N, 5ImPLy Ent3R &quot;Ye\$&quot; pH0r 4N5W3R 1 4Nd &quot;N0&quot; F0R @N5WEr 2.";
$lang['numberanswers'] = "nO. @NSW3R\$";
$lang['answerscontainHTML'] = "@NSw3rs C0nT4IN h+ml (N0+ 1nCLUd1nG s19n@tUR3)";
$lang['optionsdisplay'] = "4n\$WER\$ d1SPL4y TyP3";
$lang['optionsdisplayexp'] = "h0w \$H0uLD TH3 4n5W3R\$ BE PR3\$ENt3d?";
$lang['dropdown'] = "@5 DROp-Down lIs+(S)";
$lang['radios'] = "4\$ 4 \$Er1e\$ 0f R@dI0 8ut+0N5";
$lang['votechanging'] = "Vot3 cH4N9In9";
$lang['votechangingexp'] = "c4N 4 P3R50N cH4Ng3 h1S 0r HeR v0+E?";
$lang['allowmultiplevotes'] = "@ll0W MUL+IPLE VO+e\$";
$lang['pollresults'] = "pOlL R3\$uLt5";
$lang['pollresultsexp'] = "H0W WOUld j00 lIKE +0 d15pL4y TH3 rE5Ul+5 oF Y0UR pOLL?";
$lang['pollvotetype'] = "pOLL v0+IN9 +Ype";
$lang['pollvotesexp'] = "HOw 5hOUld +H3 p0LL be c0ndUC+3D?";
$lang['pollvoteanon'] = "4n0Nym0U\$LY";
$lang['pollvotepub'] = "pU8LIC 84lL0+";
$lang['horizgraph'] = "H0R1ZoNt4L GR4Ph";
$lang['vertgraph'] = "v3RT1c@L GR4pH";
$lang['tablegraph'] = "+@bUl4R FORm@T";
$lang['polltypewarning'] = "<b>W4RN1n9</b>: +h1S i\$ 4 pU8LIC 84lLo+. YOuR N@M3 w1lL be v15i8L3 nex+ +0 +he 0p+IoN J00 v0+E PH0r.";
$lang['expiration'] = "ExPiR4T10N";
$lang['showresultswhileopen'] = "D0 j00 W@nT t0 \$H0W R35uL+s WH1L3 +hE PoLL I5 0peN?";
$lang['whenlikepollclose'] = "wH3N WouLD J00 lIKe yOur p0Ll tO @ut0m4+1C4lLY cloS3?";
$lang['oneday'] = "0NE D@Y";
$lang['threedays'] = "+HR33 d@y\$";
$lang['sevendays'] = "S3VEn d4Ys";
$lang['thirtydays'] = "THIRty dAY\$";
$lang['never'] = "NEver";
$lang['polladditionalmessage'] = "4dd1+i0N4L mES5@gE (op+ioN4L)";
$lang['polladditionalmessageexp'] = "D0 j00 W4nT T0 1NCluDE aN 4DDi+1On@l P0S+ 4Ft3R +H3 poLL?";
$lang['mustspecifypolltoview'] = "j00 Mu5T sP3C1pHY @ POLl TO v13W.";
$lang['pollconfirmclose'] = "4R3 J00 SuRe j00 W4n+ +O cLO\$3 t3H f0LL0wING p0lL?";
$lang['endpoll'] = "end P0lL";
$lang['nobodyvoted'] = "N0b0DY VO+ed.";
$lang['nobodyhasvoted'] = "No80dy h4S V0t3d.";
$lang['1personvoted'] = "1 pERsON VO+3D.";
$lang['1personhasvoted'] = "1 P3R\$0N H45 V0+eD.";
$lang['peoplevoted'] = "p30pL3 VO+3d.";
$lang['peoplehavevoted'] = "P30PLE h4v3 vO+ed.";
$lang['pollhasended'] = "pOll h4S 3ndED";
$lang['youvotedfor'] = "j00 v0T3d For";
$lang['thisisapoll'] = "+H1s I5 4 poLL. Cl1cK To V1EW R35UL+S.";
$lang['editpoll'] = "EDIT p0LL";
$lang['results'] = "r3SulT5";
$lang['resultdetails'] = "RESULt dE+41LS";
$lang['changevote'] = "cH@NGE V0+3";
$lang['pollshavebeendisabled'] = "P0lLs h4V3 833n dIs48lED 8Y tH3 FORuM OWneR.";
$lang['answertext'] = "@NsW3R T3xT";
$lang['answergroup'] = "4N5WEr gRouP";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "3DiT pROPhIl3";
$lang['profileupdated'] = "PrOF1L3 UPD4t3d.";
$lang['profilesnotsetup'] = "TeH f0RUm 0WN3R H4S NOT 53+ UP PR0FIl3\$.";
$lang['nouserspecified'] = "n0 US3R 5PECIFi3D";
$lang['ignoreduser'] = "19NoRed U53R";
$lang['lastvisit'] = "L4s+ v1SI+";
$lang['sendemail'] = "s3Nd 3M41L";
$lang['sendpm'] = "\$3nD pM";
$lang['removefromfriends'] = "ReM0VE pHROM PHR13Nd\$";
$lang['addtofriends'] = "4dD T0 fR1EnDs";
$lang['stopignoringuser'] = "5tOp 1gN0R1NG useR";
$lang['ignorethisuser'] = "19NOR3 THIs u53R";
$lang['age'] = "@9E";
$lang['aged'] = "@g3d";
$lang['birthday'] = "bir+HD4Y";
$lang['editmyattachments'] = "3dI+ My 4++4CHMen+S";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "50RRY, nEw U\$3R R3g1S+R@+I0N5 4r3 no+ 4LL0w3d RI9H+ Now. Ple@\$3 CH3CK b@cK l4t3R.";
$lang['usernameinvalidchars'] = "U53Rn4m3 c4n 0nLY CON+4in @-z, 0-9, _ - cH4R4C+eR\$";
$lang['usernametooshort'] = "Us3RN4M3 MUsT b3 4 m1niMUm 0F 2 Ch4r4CtERs L0NG";
$lang['usernametoolong'] = "u\$eRN4mE mu5+ b3 4 M4x1mum 0F 15 ch4r4cTEr5 L0nG";
$lang['usernamerequired'] = "4 lOgON N@ME 15 r3qUIR3D";
$lang['passwdmustnotcontainHTML'] = "p@SSw0rD mU\$T No+ cONT@IN h+mL t@9\$";
$lang['passwordinvalidchars'] = "P4s5w0rD c4n 0NLY cOn+4iN 4-z, 0-9, _ - Ch4r4c+eR\$";
$lang['passwdtooshort'] = "P@\$SW0rD mUS+ 8E @ M1nIMum 0pH 6 CH4r4c+er5 lOnG";
$lang['passwdrequired'] = "4 p4\$sw0rd i5 rEQuiRED";
$lang['confirmationpasswdrequired'] = "a cOnF1RMA+i0n p@SSW0rD Is R3qUIR3D";
$lang['nicknamerequired'] = "@ n1CKNAM3 i5 r3qUir3d";
$lang['emailrequired'] = "@n 3M41L 4DDreSS 1\$ REQU1R3d";
$lang['passwdsdonotmatch'] = "p@55WoRdS D0 N0t M@TCH";
$lang['usernamesameaspasswd'] = "U5ERN4mE @nD P455W0RD Mu\$T BE dIphPH3REn+";
$lang['usernameexists'] = "S0RRY, @ U\$ER wITH +ha+ N4ME ALReadY eX1sts";
$lang['successfullycreateduseraccount'] = "SuCcESSfULly cr34+3d U53R 4cc0UNT";
$lang['useraccountcreatedconfirmfailed'] = "youR Us3R 4cCoUNT H@s 8EEN cR34T3D 8U+ +3H ReQu1R3D CoNf1rM4Tion 3m4IL W45 N0T 53Nt. PlE4sE COnTaC+ TeH PhOrUM 0WNEr T0 reC+IpHY +H1\$. IN TH15 Me@nT1M3 PLe4s3 Cl1Ck +He C0n+INue 8U+tOn +0 loGiN IN.";
$lang['useraccountcreatedconfirmsuccess'] = "y0ur USER 4cc0UNT HA5 8eeN CR34t3D bU+ BefOrE j00 c4N St4rT Po\$TINg J00 mUS+ c0NfIrm Y0uR 3M41l @ddr3S5. pL34\$3 ch3CK Y0ur EM@1L PhOR 4 l1Nk +H4T WilL 4LLoW J00 +O cOnPHiRM YoUR 4DDREsS.";
$lang['useraccountcreated'] = "Y0UR U5eR 4ccOun+ H4S 83eN cr3aT3d SucCEssPhUllY! cL1CK +He C0N+1nU3 8UTT0n 83LoW +0 L091N";
$lang['errorcreatinguserrecord'] = "3Rr0R cRE4+iNG Us3r R3c0RD";
$lang['userregistration'] = "USER R3G15+r@tIon";
$lang['registrationinformationrequired'] = "r3gIsTr4+ion iNPHorM4+1on (REQuiRED)";
$lang['profileinformationoptional'] = "pRoF1l3 1nfOrM4t1On (OPti0n@l)";
$lang['preferencesoptional'] = "PREpH3R3NCeS (oP+I0n@l)";
$lang['register'] = "rEG1STER";
$lang['rememberpasswd'] = "ReM3M83r p@SSw0Rd";
$lang['birthdayrequired'] = "youR d@T3 OF BirTH 1s r3qu1rEd OR I\$ inv@LID";
$lang['alwaysnotifymeofrepliestome'] = "n0t1Fy 0n rEPlY +0 M3";
$lang['notifyonnewprivatemessage'] = "n0+1fY 0N N3W PRIV@T3 Me\$S@G3";
$lang['popuponnewprivatemessage'] = "p0p UP ON nEw pR1v4+E M3S549e";
$lang['automatichighinterestonpost'] = "4UT0m4+1C H1gH 1nt3rE\$+ 0n P0\$+";
$lang['confirmpassword'] = "CONPhiRM p4sSW0rD";
$lang['invalidemailaddressformat'] = "iNV@LID EM@IL 4ddRE5\$ FORM4T";
$lang['moreoptionsavailable'] = "m0R3 PR0pHiLE @nD pR3Ph3REncE 0PT10n\$ 4R3 @v41l48l3 oNc3 j00 R391St3r";
$lang['textcaptchaconfirmation'] = "cONfiRM4TI0n";
$lang['textcaptchaexplain'] = "+0 +Eh rI9ht 1\$ 4 +3x+-C4ptcH4 iMa9E. PLE4S3 TyP3 +hE c0d3 J00 C@N 53E IN +he IM4GE 1n+0 T3H 1NPut F13LD Bel0w 1+.";
$lang['textcaptchaimgtip'] = "ThI\$ 1\$ 4 c4PtCh4-PIC+URE. IT iS U53d tO pREvEnt @uT0Ma+1c r391sTR4t1ON";
$lang['textcaptchamissingkey'] = "@ C0NPHirM4TI0n c0D3 1\$ r3qU1r3d.";
$lang['textcaptchaverificationfailed'] = "tEXT c@p+ch@ V3RIphIC4TI0n c0d3 w@S INCorREc+. PL34\$e rE-eNT3R I+.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "MeMBeR";
$lang['searchforusernotinlist'] = "S34rcH pHor 4 u\$er NO+ IN L1S+";
$lang['yoursearchdidnotreturnanymatches'] = "yOuR S34RCH D1D N0T RETUrN 4Ny M4+cH3s. +RY s1MPL1FYInG y0UR SE4rCH p4R4METeRS 4ND TrY 494iN.";

// Relationships (user_rel.php) ----------------------------------------

$lang['userrelationship'] = "Us3r R3l4TIoN5h1P";
$lang['userrelationships'] = "US3R R3L@+1onsHIPs";
$lang['friends'] = "FriEND\$";
$lang['ignoredcompletely'] = "1gn0r3d c0MplET3LY";
$lang['relationship'] = "rEL4t1oN5HiP";
$lang['friend_exp'] = "U\$Er'\$ p0s+5 m@RkEd Wi+H 4 &quot;FR13Nd&quot; Ic0N.";
$lang['normal_exp'] = "U\$eR's pO\$t5 @PP34r @S N0Rm4L.";
$lang['ignore_exp'] = "U5Er'S pOsTs @r3 h1dD3N.";
$lang['ignore_completely_exp'] = "thr3@dS @nd P0\$TS +0 oR pHRoM U\$3R W1LL @pP34R dELE+eD.";
$lang['display'] = "DiSpl4Y";
$lang['displaysig_exp'] = "U53R'\$ SI9N@TURE 1S DI5PL@yED ON +hE1r P0sT\$.";
$lang['hidesig_exp'] = "U53R'S \$I9N4+Ur3 I5 H1Dd3N ON +hE1R p0StS.";
$lang['globallyignored'] = "Glob@llY IgNoReD";
$lang['globallyignoredsig_exp'] = "n0 \$iGn4TURe\$ 4Re dIsPL4Y3D.";
$lang['cannotignoremod'] = "J00 cANN0+ i9Nor3 THIs U\$3r, 4s TH3Y 4r3 @ M0DERa+0R.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "\$E4rcH rE\$uLts";
$lang['usernamenotfound'] = "Th3 U\$3Rn4m3 J00 sPECIf13d 1n Th3 +o 0R FROm F13Ld w4s N0T F0Und.";
$lang['notexttosearchfor'] = "0N3 0R @lL 0f YouR 53@RCH k3YW0rDs W3R3 1NV4lID. \$E@rcH K3YwOrDs MUsT 8e nO sHOrTER Th@n %d CH4RAC+3R5, n0 LonGeR +H4N %d CH4R4cteR5 4ND Mu\$t NoT @pP34R 1N +EH %s";
$lang['mysqlstopwordlist'] = "MYSQL S+0PW0RD LI5t";
$lang['foundzeromatches'] = "fouNd: 0 m4TcH3\$";
$lang['found'] = "f0uNd";
$lang['matches'] = "M4+chE5";
$lang['prevpage'] = "pR3VIou\$ P493";
$lang['findmore'] = "PH1nD M0R3";
$lang['searchmessages'] = "5E@rcH mE\$54g3S";
$lang['searchdiscussions'] = "5E@RcH dIscu55iON5";
$lang['find'] = "FiNd";
$lang['additionalcriteria'] = "@ddiTioN@l cR1t3r14";
$lang['searchbyuser'] = "\$EarcH 8y u53r (Opt10naL)";
$lang['folderbrackets_s'] = "pHoLDER(\$)";
$lang['postedfrom'] = "P0st3D frOM";
$lang['postedto'] = "Po\$t3d +O";
$lang['today'] = "+od4y";
$lang['yesterday'] = "y3ST3rD4Y";
$lang['daybeforeyesterday'] = "d4y 83ForE Y3Sterd4Y";
$lang['weekago'] = "%s wEEK @90";
$lang['weeksago'] = "%s w3EKs @g0";
$lang['monthago'] = "%s MONth 4g0";
$lang['monthsago'] = "%s mOntH5 4g0";
$lang['yearago'] = "%s YE4R 4G0";
$lang['beginningoftime'] = "b3g1Nn1N9 0PH +iME";
$lang['now'] = "N0w";
$lang['newestfirst'] = "New3S+ FIR\$+";
$lang['oldestfirst'] = "0LD3\$T pHIR\$T";
$lang['keywords'] = "K3YWORDs";
$lang['orderby'] = "oRDeR bY";
$lang['groupbythread'] = "GrOUP 8y tHReAd";
$lang['postsfromuser'] = "pOSTS FR0m uS3r";
$lang['poststouser'] = "p05+\$ +o uS3R";
$lang['poststoandfromuser'] = "p05+s T0 ANd fR0M US3r";
$lang['searchfrequencyerror_1'] = "J00 C@N ONLY SEarCH 0nc3 EVERY";
$lang['searchfrequencyerror_2'] = "\$3C0nD5. pl3453 +ry @94iN l4+eR.";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rEC3N+ +HR34d5";
$lang['startreading'] = "St@rt ReAd1NG";
$lang['threadoptions'] = "+HREad 0p+10nS";
$lang['editthreadoptions'] = "3d1t thRE4D OP+i0nS";
$lang['showmorevisitors'] = "\$h0w mOr3 vi\$it0R\$";
$lang['forthcomingbirthdays'] = "fOr+hC0MIng bIRTHD4Ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C4n edi+ +H1S P49e FR0M +eH 4DmIN 1N+ERF4ce";
$lang['uploadstartpage'] = "UPLoad \$t4r+ p49e (*.tXT, *.H+M, *.hTmL)";
$lang['invalidfiletypeerror'] = "Ph1LE tYP3 NO+ SUPPorTED. J00 c4n 0NlY Use *.tx+, *.phP 4ND *.hTm PHile\$ 4\$ YOuR 5+@r+ P4Ge.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3W D1\$cus\$1On";
$lang['createpoll'] = "Cre4t3 pOLL";
$lang['search'] = "\$e4rcH";
$lang['searchagain'] = "\$3@RCH 4G41N";
$lang['alldiscussions'] = "4Ll d1scuSs10n5";
$lang['unreaddiscussions'] = "UNr34d D15cu\$S10nS";
$lang['unreadtome'] = "UNR34D &quot;T0: M3&quot;";
$lang['todaysdiscussions'] = "+0D4Y's d15cU\$Si0N\$";
$lang['2daysback'] = "2 d4YS b4cK";
$lang['7daysback'] = "7 D4yS B4ck";
$lang['highinterest'] = "H1GH iNT3r3\$T";
$lang['unreadhighinterest'] = "unR3Ad H1gH 1N+EREs+";
$lang['iverecentlyseen'] = "i'V3 R3c3n+lY S3EN";
$lang['iveignored'] = "I'V3 iGN0R3d";
$lang['byignoredusers'] = "8Y 19NORED u\$3rS";
$lang['ivesubscribedto'] = "i'vE 5UbSCRiBed t0";
$lang['startedbyfriend'] = "ST@rT3d 8y pHRI3Nd";
$lang['unreadstartedbyfriend'] = "UNRe4d \$TD by FRIEnd";
$lang['startedbyme'] = "S+4RT3D 8Y M3";
$lang['unreadtoday'] = "UnR34D +0d4Y";
$lang['deletedthreads'] = "deLEt3D thR34D5";
$lang['goexcmark'] = "9O!";
$lang['folderinterest'] = "Ph0ld3r 1nT3re\$+";
$lang['postnew'] = "P0\$t NEW";
$lang['currentthread'] = "CURR3N+ +HRe@d";
$lang['highinterest'] = "Hi9h iNt3r35+";
$lang['markasread'] = "M4rk 4S r34d";
$lang['next50discussions'] = "n3xt 50 di5cU\$S10nS";
$lang['visiblediscussions'] = "vI\$iBL3 d1scUsS1ON5";
$lang['selectedfolder'] = "\$3lEcT3D PHOld3R";
$lang['navigate'] = "n4VI9@+3";
$lang['couldnotretrievefolderinformation'] = "TheR3 4r3 N0 PH0ld3R\$ 4v41l48lE.";
$lang['nomessagesinthiscategory'] = "No mEsSA93S 1n +h1\$ C4T390Ry. PLe4\$3 53L3c+ 4n0+heR, OR";
$lang['clickhere'] = "cL1cK HERE";
$lang['forallthreads'] = "FOr 4lL +HRE@dS";
$lang['prev50threads'] = "pR3Vi0US 50 +HReAD\$";
$lang['next50threads'] = "NEX+ 50 THR34ds";
$lang['startedby'] = "\$T4rT3d 8y";
$lang['unreadthread'] = "UnR34d +HRe4D";
$lang['readthread'] = "R3aD +hRE@D";
$lang['unreadmessages'] = "UnRE@d M35S4gE\$";
$lang['subscribed'] = "SUbscRiBEd";
$lang['ignorethisfolder'] = "i9N0RE +H1\$ FOldeR";
$lang['stopignoringthisfolder'] = "S+0P 1Gn0R1Ng +HI\$ FolD3R";
$lang['stickythreads'] = "s+IcKY thRE@dS";
$lang['mostunreadposts'] = "M0\$+ uNre4d P0\$+5";
$lang['onenew'] = "%d NEw";
$lang['manynew'] = "%d nEW";
$lang['onenewoflength'] = "%d N3W 0PH %d";
$lang['manynewoflength'] = "%d NeW OpH %d";
$lang['ignorefolderconfirm'] = "4RE J00 \$uRE j00 W4nT T0 1gNORe +h1S pHOLd3R?";
$lang['unignorefolderconfirm'] = "@rE J00 \$UR3 J00 W4nT to 5T0p 1GN0R1nG tHiS PhOLDEr?";
$lang['threadviewedonetime'] = "VieWed: 1 TIM3";
$lang['threadviewedtimes'] = "Vi3Wed: %d t1MES";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOlD";
$lang['italic'] = "1+4LiC";
$lang['underline'] = "UNd3Rlin3";
$lang['strikethrough'] = "str1kE+HR0u9h";
$lang['superscript'] = "\$uP3R5CRiP+";
$lang['subscript'] = "sUB5Cr1P+";
$lang['leftalign'] = "l3fT-@liGn";
$lang['center'] = "CeNT3R";
$lang['rightalign'] = "Ri9hT-4l19N";
$lang['numberedlist'] = "nuM83ReD lI\$T";
$lang['list'] = "lIS+";
$lang['indenttext'] = "1ND3n+ +3X+";
$lang['code'] = "c0dE";
$lang['quote'] = "qU0T3";
$lang['spoiler'] = "5pO1L3r";
$lang['horizontalrule'] = "H0r1z0Nt@l rulE";
$lang['image'] = "1MA9e";
$lang['hyperlink'] = "hYPerLINK";
$lang['noemoticons'] = "DiSABl3 3MO+IcONs";
$lang['fontface'] = "Ph0n+ f@c3";
$lang['size'] = "51z3";
$lang['colour'] = "c0l0Ur";
$lang['red'] = "R3D";
$lang['orange'] = "0r4nG3";
$lang['yellow'] = "yELLoW";
$lang['green'] = "GR3eN";
$lang['blue'] = "bLU3";
$lang['indigo'] = "INd190";
$lang['violet'] = "ViOL3t";
$lang['white'] = "wH1+e";
$lang['black'] = "bL4cK";
$lang['grey'] = "9R3Y";
$lang['pink'] = "p1Nk";
$lang['lightgreen'] = "lIghT 9R33N";
$lang['lightblue'] = "L1gH+ 8lU3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "FORUm St4+\$";
$lang['guests'] = "9ueStS";
$lang['members'] = "m3mBeRs";
$lang['anonymousmembers'] = "4NonYMous M3M83R\$";
$lang['viewcompletelist'] = "v1ew cOmpLET3 L1ST";
$lang['ourmembershavemadeatotalof'] = "OUR M3M83rs H@V3 M4D3 4 +0+4L 0F";
$lang['threadsand'] = "ThRE4Ds 4nD";
$lang['postslowercase'] = "pOStS";
$lang['longestthreadis'] = "L0ngE5T +hre@d i5";
$lang['therehavebeen'] = "+h3R3 H4V3 83En";
$lang['postsmadeinthelastsixtyminutes'] = "p0\$tS M@d3 1n T3H L4\$T 60 mINut3\$";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwas'] = "mO\$T P05+5 3veR m4d3 1n @ SINGLE 60 MInU+E PErI0D w@S";
$lang['wehave'] = "We h4V3";
$lang['registeredmembers'] = "R3915T3REd MEMBeRs";
$lang['thenewestmemberis'] = "tH3 nEWEs+ mEmBER IS";
$lang['mostuserseveronlinewas'] = "MO5T uS3Rs 3veR oNL1NE w@\$";
$lang['statsdisplayenabled'] = "5t4TS dIsPL4Y 3n4bLED";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "UPDA+3\$ M4D3";
$lang['useroptions'] = "us3r OP+iOnS";
$lang['markedasread'] = "m@RkeD 4S R3@d";
$lang['postsoutof'] = "p05ts 0U+ 0F";
$lang['interest'] = "iNt3rE5+";
$lang['closedforposting'] = "ClO\$3D FOR pO\$tIN9";
$lang['locktitleandfolder'] = "l0cK TI+lE 4ND pH0LD3R";
$lang['deletepostsinthreadbyuser'] = "dElET3 P05+S iN tHR34D bY u\$3R";
$lang['deletethread'] = "D3L3+E POsT5";
$lang['deletethread'] = "DEle+e tHr34d";
$lang['undeletethread'] = "UNdeLET3 +HRe@d";
$lang['threaddeletedpermenantly'] = "+HReAd d3le+ed pERM3n4n+ly. C4nNo+ uNd3L3T3.";
$lang['markasunread'] = "M4rK @\$ UnRe4D";
$lang['makethreadsticky'] = "M4K3 +hR34d \$TIcKY";
$lang['threareadstatusupdated'] = "tHrE4D rE4d 5t4TUs uPD@T3d \$UccEs5PHuLLY";
$lang['interestupdated'] = "ThR34d 1nT3R35T 5+4TU5 UPd4+3d 5ucCE\$sfULly";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dIC+1On@RY";
$lang['spellcheck'] = "SpeLL cHECK";
$lang['notindictionary'] = "n0+ 1N DIc+1On@rY";
$lang['changeto'] = "Ch4NG3 +O";
$lang['initialisingdotdotdot'] = "INi+1AliS1N9...";
$lang['spellcheckcomplete'] = "5p3ll cHECk 15 C0MPl3+E. DO j00 w15h +0 \$T4RT 4G4In FR0M +HE beGINN1ng?";
$lang['spellcheck'] = "Sp3LL CHECk";
$lang['noformobj'] = "N0 pH0RM O8J3cT sPEcIPHi3D F0R R3+URn +eXT";
$lang['bodytext'] = "b0Dy +3xt";
$lang['ignore'] = "i9nORE";
$lang['ignoreall'] = "IgN0re @Ll";
$lang['change'] = "cH4NgE";
$lang['changeall'] = "cH4NG3 4lL";
$lang['add'] = "4dd";
$lang['suggest'] = "5U9G35+";
$lang['nosuggestions'] = "(NO \$u9g3\$+i0nS)";
$lang['ok'] = "0k";
$lang['cancel'] = "C4Nc3l";
$lang['dictionarynotinstalled'] = "n0 d1c+1On4rY H45 8eEN InsT@LLED. pl3@\$3 C0N+4c+ THE ForuM 0wN3R +0 R3MEDy +H1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "P0S+ re4d1NG 4Ll0W3d";
$lang['postcreationallowed'] = "P0\$T cRE4+1On All0WEd";
$lang['threadcreationallowed'] = "Thr34d cR34+10n all0wed";
$lang['posteditingallowed'] = "pOst edITIN9 4LL0WED";
$lang['postdeletionallowed'] = "Po\$T d3LE+1ON 4LL0WEd";
$lang['attachmentsallowed'] = "@Tt4cHMENT\$ @LL0W3D";
$lang['htmlpostingallowed'] = "HtmL P0\$+1n9 @LLoW3D";
$lang['signatureallowed'] = "si9N4+URe 4LL0W3d";
$lang['guestaccessallowed'] = "9ueST acc3\$s 4lLOw3d";
$lang['postapprovalrequired'] = "pO5T 4pPR0VAL rEQu1R3d";

// RSS feeds gubbins

$lang['rssfeed'] = "RsS F33d";
$lang['every30mins'] = "3vERY 30 MInU+e\$";
$lang['onceanhour'] = "0NCe 4N hOUR";
$lang['every6hours'] = "EVerY 6 hOurS";
$lang['every12hours'] = "EvERY 12 H0URS";
$lang['onceaday'] = "0NCE @ d@y";
$lang['rssfeeds'] = "RSS pHEEd5";
$lang['feedlocation'] = "f3ED L0c4tI0n";
$lang['rssclicktoreadarticle'] = "cLIcK HERe TO re4d tHIs 4rTICLe";
$lang['rssfeedhelp_1'] = "herE J00 c4n 5eTUp \$Ome RSs F33ds PhOR 4UT0M4+ic PRoP4G4+1On 1N+0 y0UR pH0rUM. TH3 1T3M5 PhR0M T3H Rs\$ FeeD\$ j00 4dd W1lL B3 CRE4+3D 4\$ Thre4Ds WH1Ch usER\$ c@n rEpLy +0 4s IPh +H3Y WErE N0rM4L PoST\$. Wh3N @DD1NG 4n R\$s FEed j00 MUsT 5P3CiFY +3H Us3R LoG0n j00 W1sH +O 8E U\$Ed TO 5+4Rt TEh THRe4DS, +3H PH0lD3R j00 WiSh +H3M To b3 cRE@teD 1N 4ND THE LoC@+10n 0F TEH Ph3Ed. tHE f33D L0c4T1ON It\$3Lf MUS+ 8e aCCes\$ibL3 V1@ h+TP, IF 1+ i5 n0+ THeN +h3 FEed W1ll NOt W0rK.";
$lang['mustspecifyrssfeedname'] = "MU5+ SpecIfY Rs5 fe3d n@m3";
$lang['mustspecifyrssfeeduseraccount'] = "mUST sPECIfY Rs\$ fe3D U\$3R 4cC0UN+";
$lang['mustspecifyrssfeedfolder'] = "Mu\$T SPeCiPHY R\$5 F3ED pHOLD3R";
$lang['mustspecifyrssfeedurl'] = "MUs+ \$P3C1pHY r\$S F3ED UrL";
$lang['mustspecifyrssfeedprefix'] = "mU5t spEcIphY r5\$ Ph3ED PREF1X";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUS+ SPECiPhy r5S Ph3ED UpDA+e Fr3qu3nCy";
$lang['unknownrssuseraccount'] = "uNkNOwn r5\$ U53R @cC0UNT";
$lang['rssfeedsupportshttpurlsonly'] = "rS\$ F3ED SUPpOr+\$ hT+P URLs 0nLY. S3cURE FE3Ds (H++p5://) 4R3 nO+ \$UPpORT3d.";
$lang['rssfeedurlformatinvalid'] = "r\$\$ PH3ed uRL PhorM4+ 1s INV4LID. URL mU5T 1NcLud3 scHeME (E.9. HT+p://) 4nD 4 Ho\$Tn4Me (E.9. wWw.HO\$+N4M3.C0M).";
$lang['rssfeeduserauthentication'] = "R\$s PhE3d d03S No+ 5UPp0R+ h++p US3R @utH3NT1C@ti0N";

// PM Export Options

$lang['pmexportastype'] = "3xP0RT @s tYPE";
$lang['pmexporthtml'] = "H+ML";
$lang['pmexportxml'] = "XmL";
$lang['pmexportplaintext'] = "Pl4IN T3XT";
$lang['pmexportmessagesas'] = "expOr+ me\$SA9ES 4S";
$lang['pmexportonefileforallmessages'] = "0NE F1L3 PH0R ALL M3\$SA9E\$";
$lang['pmexportonefilepermessage'] = "oN3 PH1Le PER MEss@G3";
$lang['pmexportattachments'] = "EXP0R+ 4++4cHM3nT\$";
$lang['pmexportincludestyle'] = "iNcLUD3 PH0RUm \$TYle\$h3eT";
$lang['pmexportwordfilter'] = "4ppLy worD F1Lt3R TO M3\$s@93\$";

// Thread merge / split options

$lang['mergesplitthread'] = "M3R93 / sPl1T THr3@d";
$lang['mergewiththreadid'] = "mER93 W1+h thR34D ID:";
$lang['postsinthisthreadatstart'] = "pO5T5 IN th15 THR34d 4t \$t4RT";
$lang['postsinthisthreadatend'] = "P0st5 IN tH1s +HrE@d 4T 3nD";
$lang['reorderpostsintodateorder'] = "RE-0RD3R Po\$T\$ in+0 d4+e Ord3r";
$lang['splitthreadatpost'] = "\$Pli+ +HrE4d 4T PO5+:";
$lang['selectedpostsandrepliesonly'] = "\$3L3cT3d P05T @Nd rEpl1E5 0nLy";
$lang['selectedandallfollowingposts'] = "S3l3Ct3d @nd 4ll f0llOW1N9 pO\$+S";

$lang['threadhere'] = "H3RE";
$lang['thisthreadhasmoved'] = "<b>Threads Merged:</b> This thread has moved <a href=\"%s\" target=\"_self\">%s</@ >";
$lang['thisthreadwasmergedfrom'] = "<b>Threads Merged:</b> This thread was merged from <a href=\"%s\" target=\"_self\">%s</@ >";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>Thread Split:</b> Some posts in this thread have been moved <a href=\"%s\" target=\"_self\">%s</@ >";
$lang['somepostsinthisthreadwheremovedfrom'] = "<b>Thread Split:</b> Some posts in this thread were moved from <a href=\"%s\" target=\"_self\">%s</@ >";

$lang['threadmergefailed'] = "+HR34D MERGe ph4iLeD";
$lang['threadsplitfailed'] = "+HREaD \$pL1T f41L3D";

?>