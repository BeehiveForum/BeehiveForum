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

/* $Id: x-hacker.inc.php,v 1.243 2007-08-21 20:27:40 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nuaRy";
$lang['month'][2]  = "fe8RU4RY";
$lang['month'][3]  = "marcH";
$lang['month'][4]  = "aPR1L";
$lang['month'][5]  = "m4y";
$lang['month'][6]  = "jUne";
$lang['month'][7]  = "jULY";
$lang['month'][8]  = "au9Us+";
$lang['month'][9]  = "s3ptemB3r";
$lang['month'][10] = "octObeR";
$lang['month'][11] = "noV3M8eR";
$lang['month'][12] = "dECEm8eR";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "fe8";
$lang['month_short'][3]  = "mAR";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m4y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aUg";
$lang['month_short'][9]  = "sEp";
$lang['month_short'][10] = "oC+";
$lang['month_short'][11] = "n0V";
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

// Periods -------------------------------------------------------------

// Various time periods as used by BeehiveForum.

$lang['date_periods']['year']   = "%s yeaR";
$lang['date_periods']['month']  = "%s m0NTH";
$lang['date_periods']['week']   = "%s weEk";
$lang['date_periods']['day']    = "%s d@Y";
$lang['date_periods']['hour']   = "%s HOUr";
$lang['date_periods']['minute'] = "%s mInUTE";
$lang['date_periods']['second'] = "%s 53CONd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y34RS";
$lang['date_periods_plural']['month']  = "%s m0nThs";
$lang['date_periods_plural']['week']   = "%s weEK5";
$lang['date_periods_plural']['day']    = "%s D4ys";
$lang['date_periods_plural']['hour']   = "%s hoUrS";
$lang['date_periods_plural']['minute'] = "%s m1NUTE5";
$lang['date_periods_plural']['second'] = "%s SeConDS";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%sHr";   // 5hr
$lang['date_periods_short']['minute'] = "%smIn";  // 6min
$lang['date_periods_short']['second'] = "%ssec";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3rC3nT";
$lang['average'] = "av3r49e";
$lang['approve'] = "aPPr0vE";
$lang['banned'] = "b4nn3d";
$lang['locked'] = "loCkED";
$lang['add'] = "add";
$lang['advanced'] = "adv4NC3d";
$lang['active'] = "aC+1V3";
$lang['style'] = "sTYLE";
$lang['go'] = "g0";
$lang['folder'] = "f0LD3R";
$lang['ignoredfolder'] = "i9nOREd PHoLD3r";
$lang['folders'] = "f0lDeR\$";
$lang['thread'] = "thre4D";
$lang['threads'] = "thr34Ds";
$lang['threadlist'] = "thr3@D L1\$T";
$lang['message'] = "me\$\$493";
$lang['messagenumber'] = "m35S4G3 nUMBEr";
$lang['from'] = "fR0m";
$lang['to'] = "to";
$lang['all_caps'] = "alL";
$lang['of'] = "oph";
$lang['reply'] = "reply";
$lang['forward'] = "forw@rd";
$lang['replyall'] = "r3pLY To 4LL";
$lang['pm_reply'] = "reply 4S PM";
$lang['delete'] = "deLETe";
$lang['deleted'] = "dElE+ED";
$lang['edit'] = "edi+";
$lang['privileges'] = "pr1v1Le9eS";
$lang['ignore'] = "i9n0RE";
$lang['normal'] = "nOrM@L";
$lang['interested'] = "intEr3\$+3d";
$lang['subscribe'] = "sU85cr18E";
$lang['apply'] = "aPPLY";
$lang['download'] = "d0wnL04d";
$lang['save'] = "s4VE";
$lang['update'] = "upd4+E";
$lang['cancel'] = "c4NCEL";
$lang['retry'] = "r3Try";
$lang['continue'] = "cOntiNU3";
$lang['attachment'] = "a++@chmEN+";
$lang['attachments'] = "at+@chmEn+S";
$lang['imageattachments'] = "iM4G3 4++@chm3nTs";
$lang['filename'] = "f1L3N4mE";
$lang['dimensions'] = "d1mEn510ns";
$lang['downloadedxtimes'] = "d0wnL04DED: %d +1M3S";
$lang['downloadedonetime'] = "d0wnL04dED: 1 +1ME";
$lang['size'] = "sIze";
$lang['viewmessage'] = "v1eW M3s\$@GE";
$lang['deletethumbnails'] = "d3LeTe +HUMBN@1L\$";
$lang['logon'] = "lO90N";
$lang['more'] = "m0r3";
$lang['recentvisitors'] = "r3cenT VI\$i+OrS";
$lang['username'] = "u53Rn4m3";
$lang['clear'] = "cleAr";
$lang['action'] = "ac+IOn";
$lang['unknown'] = "unKnOwN";
$lang['none'] = "n0nE";
$lang['preview'] = "pRev1ew";
$lang['post'] = "po\$+";
$lang['posts'] = "p0s+\$";
$lang['change'] = "cH4N93";
$lang['yes'] = "y3\$";
$lang['no'] = "n0";
$lang['signature'] = "s19N@+URe";
$lang['signaturepreview'] = "sIGNA+URe Pr3v13W";
$lang['signatureupdated'] = "sI9N4+UrE uPD@TED";
$lang['signatureupdatedforallforums'] = "si9n@+uRE Upd4+3D pH0R @ll F0rUmS";
$lang['back'] = "b4Ck";
$lang['subject'] = "subjECt";
$lang['close'] = "cl0\$e";
$lang['name'] = "n4m3";
$lang['description'] = "dESCR1pTIoN";
$lang['date'] = "d4te";
$lang['view'] = "view";
$lang['enterpasswd'] = "en+3R P4sswORD";
$lang['passwd'] = "p4SswOrD";
$lang['ignored'] = "ignor3D";
$lang['guest'] = "gu3sT";
$lang['next'] = "nEx+";
$lang['prev'] = "pR3vi0Us";
$lang['others'] = "o+h3R\$";
$lang['nickname'] = "n1CKn@ME";
$lang['emailaddress'] = "eM41L 4DDres\$";
$lang['confirm'] = "cOnFiRm";
$lang['email'] = "eM4iL";
$lang['poll'] = "polL";
$lang['friend'] = "fR1enD";
$lang['success'] = "succ35s";
$lang['error'] = "erroR";
$lang['warning'] = "w4RniNG";
$lang['guesterror'] = "sorry, J00 NE3d +0 BE LOg9eD IN t0 UsE +HIS PH34+URE.";
$lang['loginnow'] = "l0GIn NOw";
$lang['unread'] = "unrE4d";
$lang['all'] = "alL";
$lang['allcaps'] = "aLL";
$lang['permissions'] = "p3rMiS\$i0ns";
$lang['type'] = "tYp3";
$lang['print'] = "prinT";
$lang['sticky'] = "s+1CkY";
$lang['polls'] = "polL5";
$lang['user'] = "u53R";
$lang['enabled'] = "eN@8l3D";
$lang['disabled'] = "dI5@bleD";
$lang['options'] = "oPTI0nS";
$lang['emoticons'] = "eM0T1coN5";
$lang['webtag'] = "w3Bt49";
$lang['makedefault'] = "m@kE d3F4ulT";
$lang['unsetdefault'] = "uNs3+ D3f4uLT";
$lang['rename'] = "rEn@M3";
$lang['pages'] = "pA93S";
$lang['used'] = "u5eD";
$lang['days'] = "d4YS";
$lang['usage'] = "u\$@G3";
$lang['show'] = "shOw";
$lang['hint'] = "hint";
$lang['new'] = "n3w";
$lang['referer'] = "r3pHeREr";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDm1N ToOLs";
$lang['forummanagement'] = "f0rUm m@NAGEM3n+";
$lang['accessdeniedexp'] = "j00 D0 nOT H4v3 P3rM1ss10N +0 u53 THi5 \$3CT1On.";
$lang['managefolders'] = "m4n4ge PHoLDER5";
$lang['manageforums'] = "mAn4GE PHORUM\$";
$lang['manageforumpermissions'] = "m4N4gE PHoRum PERmI\$5IONs";
$lang['foldername'] = "f0lD3R n4m3";
$lang['move'] = "m0V3";
$lang['closed'] = "cl0\$ed";
$lang['open'] = "oPen";
$lang['restricted'] = "rE\$+R1CtED";
$lang['forumiscurrentlyclosed'] = "%s iS curR3nTLy CLo\$ED";
$lang['youdonothaveaccesstoforum'] = "j00 d0 N0t H4Ve @CCEs\$ t0 %s";
$lang['toapplyforaccessplease'] = "to @PpLY F0R aCc35S PL3@53 C0Nt4ct +hE fOrUM OwNER.";
$lang['adminforumclosedtip'] = "if j00 W4N+ TO cH4n93 5omE 53+T1NG5 ON Y0ur f0RUM CL1ck TEh @DM1n LInk 1n +H3 N4vI94+10n 8@R 48oVE.";
$lang['newfolder'] = "n3W F0lD3r";
$lang['forumadmin'] = "foruM 4DM1n";
$lang['adminexp_1'] = "use +eh mENU 0N +H3 L3F+ +O m4N4GE TH1nG\$ 1n YOUR PH0RUm.";
$lang['adminexp_2'] = "<b>u\$3R\$</b> 4Ll0WS J00 +0 53+ 1nD1v1dU4l U\$3R P3RMI\$\$I0n\$, 1NcluD1nG 4PP01nT1n9 MOD3r4+0r5 4ND G4GGIn9 PEOplE.";
$lang['adminexp_3'] = "<b>uS3r 9r0UPs</b> 4lL0Ws J00 T0 cre4T3 U\$er GR0uPs tO 4ssI9n pERmI\$\$I0nS TO 4s ManY OR @\$ F3w Us3R\$ qU1CklY 4ND 34silY.";
$lang['adminexp_4'] = "<b>b@N COn+roLs</b> 4LLOw\$ +HE 84nN1N9 @Nd Un-b4nn1ng 0PH 1p 4DDrE\$535, HT+P REPH3r3r\$, u\$eRn4m3\$, 3m4IL 4DDrE\$S3\$ @ND NiCkN4Me\$.";
$lang['adminexp_5'] = "<b>f0ldErs</b> alL0Ws +H3 Cr3@tI0n, mod1pH1C4+10n 4ND D3l3t1oN 0f FolDEr\$.";
$lang['adminexp_6'] = "<b>rs\$ F3eDs</b> 4lL0Ws J00 +0 m@N@g3 rSs PHEeDS f0r PR0p0g4+1ON 1n+O y0Ur f0ruM.";
$lang['adminexp_7'] = "<b>profil3s</b> l3ts J00 CUsT0m1\$E THE I+3M5 Th4T @pp34r IN TEh US3r PROPhiLE\$.";
$lang['adminexp_8'] = "<b>f0RuM sE++inG\$</b> 4Ll0w5 J00 TO CuS+oMi\$3 YOur ph0ruM's N@ME, 4pP34R4NCE aND m4nY 0THEr ThiN9S.";
$lang['adminexp_9'] = "<b>st4Rt P4gE</b> LE+5 J00 Cu5+0mISe YoUr pHORUm'5 \$+@R+ P493.";
$lang['adminexp_10'] = "<b>f0ruM sTyl3</b> 4lLOw\$ J00 +o GEn3R@+3 rANDOM s+yLEs pH0R YouR F0rUm M3m83R\$ +0 U\$3.";
$lang['adminexp_11'] = "<b>wORD PH1l+3r</b> 4llOw5 J00 tO FiLtER WorD5 J00 DOn'+ W4NT +0 83 u\$3d oN Y0uR F0ruM.";
$lang['adminexp_12'] = "<b>pO\$t1n9 S+4ts</b> GEN3r@+e\$ 4 R3p0R+ L1\$+INg +he +Op 10 po5+ERs In 4 D3fIn3D pERiOD.";
$lang['adminexp_13'] = "<b>foRuM L1NKs</b> lEts J00 m4n493 +HE lINkS DRoPD0wn in +HE n4VIg@+IoN 84r.";
$lang['adminexp_14'] = "<b>vi3W L09</b> lis+\$ ReCEN+ ACT1on\$ BY teH Forum M0d3r@+0R5.";
$lang['adminexp_15'] = "<b>m4n@9E PH0RUmS</b> l3+5 j00 CRE@+E aND D3LEtE 4nD CLOsE OR rE0P3N F0RumS.";
$lang['adminexp_16'] = "<b>gL08aL PHORum 53++in9\$</b> 4LLOws J00 +0 MOD1phY \$3t+iN9s WHICH @FfEct 4LL PHOruM\$.";
$lang['adminexp_17'] = "<b>poS+ APPR0V4L QUEU3</b> 4lLOwS j00 +O V13W aNy pOS+5 4w@IT1N9 ApPROv@L 8Y 4 m0D3R@+Or.";
$lang['adminexp_18'] = "<b>v1\$1t0R l09</b> 4lL0Ws j00 t0 VI3W @N Ex+3ND3d lI\$+ Oph V1\$i+oRs INCLUDin9 +H3IR HtTP REF3r3R\$.";
$lang['createforumstyle'] = "cRe@+3 @ PH0RuM \$+YL3";
$lang['newstylesuccessfullycreated'] = "n3W 5+yL3 %s 5uCC3SsPhULlY CRE4teD.";
$lang['stylealreadyexists'] = "a sTYLe WI+H TH4T fIL3n@M3 @lRE4Dy EXi5+\$.";
$lang['stylenofilename'] = "j00 DID N0t ENtEr @ ph1lEN4mE to 5@v3 +3h \$+YlE WI+H.";
$lang['stylenodatasubmitted'] = "c0ulD N0T R34d PHOrUM S+yLE D4t@.";
$lang['styleexp'] = "use +HI5 P@g3 +0 HELP CrE4+E 4 R4nD0MlY GEn3r@+3D S+YLE phOr YOuR F0rum.";
$lang['stylecontrols'] = "c0n+rOls";
$lang['stylecolourexp'] = "cLIck On A COL0UR +0 M4KE @ NEW 5TYL3 Sh3e+ B4sED 0n +H@+ C0lOUr. CURrENT 8@se coL0ur 15 PH1R\$+ 1N lI5T.";
$lang['standardstyle'] = "st4Nd4rd s+YlE";
$lang['rotelementstyle'] = "rO+@+3D ELeMeNt \$+yL3";
$lang['randstyle'] = "r4nD0m \$+yl3";
$lang['thiscolour'] = "tH1s C0L0ur";
$lang['enterhexcolour'] = "or 3N+3R 4 HEx cOL0uR +0 84s3 @ New \$tYL3 \$H33+ On";
$lang['savestyle'] = "s@v3 tHi5 \$+yLE";
$lang['styledesc'] = "sTylE DESCrIpt1on";
$lang['fileallowedchars'] = "(L0W3rC4s3 L3++3r\$ (4-Z), NumBERs (0-9) 4ND UNDER\$C0r3s (_) 0NLY)";
$lang['stylepreview'] = "s+yL3 pREv13w";
$lang['welcome'] = "w3lC0ME";
$lang['messagepreview'] = "m355@93 pR3vIEW";
$lang['users'] = "u53R\$";
$lang['usergroups'] = "uSeR 9R0UP5";
$lang['mustentergroupname'] = "j00 mus+ 3n+Er 4 GR0up n4mE";
$lang['profiles'] = "pr0FIl35";
$lang['manageforums'] = "m@n4g3 ForUMs";
$lang['forumsettings'] = "fOruM \$3T+1N9s";
$lang['globalforumsettings'] = "glob4L PHOrUm \$3+T1n9\$";
$lang['settingsaffectallforumswarning'] = "<b>n0+E:</b> +h3s3 \$3+T1N9\$ AfF3C+ 4LL ForUm5. WHER3 +H3 \$e++IN9 I\$ dUpLiC4+3d 0N +H3 iNDIVidu4L PhOrUM'S \$3T+IN9S P4gE Th4T WILL +@K3 PR3CeD3nCe Ov3r TH3 53T+IN9s J00 CH4ng3 H3R3.";
$lang['startpage'] = "sT@rt P@9E";
$lang['startpageerror'] = "y0ur s+4R+ PAgE COuLD N0t 8E \$4v3d L0C@LlY to +3H 53RvER b3c4us3 PErM1\$\$1On W4\$ Den1eD.</p><p>t0 CH4N9e Y0uR S+4rT P493 pLE4s3 cl1CK TeH DOwNLo4D 8u++On BELow WHICH WILL PR0MP+ J00 +o \$4ve THE PHIlE T0 Y0ur h4rD Dr1v3. J00 C4N THEn uPlO4D TH1\$ phIl3 +o Your seRvEr Into THe pH0llOw1NG f0lDer, 1Ph nEC355@RY CR3@+1N9 +3h F0LDEr 5+RuC+ur3 1n +3h procES\$.</p><p><b>%s</b></p><p>pL34se nOTE th4+ 5ome BR0Ws3rs M@Y ch4nG3 +hE n@m3 0ph +Eh pHil3 up0n DowNlO@D.  WH3N UpL04d1n9 +He philE pLe4\$3 M@k3 suR3 Th4t iT 1s n4mEd 5+@R+_M@1n.pHP o+H3RWis3 Your sT4R+ p49e WIlL @PPE4R UnCh4nG3D.";
$lang['failedtoopenmasterstylesheet'] = "youR phOrUM S+Yle c0ULD N0t 8E \$@v3d 83C@USe TEH M@\$+3r StYl3 sh33+ couLD No+ 8e L04d3d. +0 \$4ve Y0uR s+Yle +3H M@StER stYlE 5HEE+ (M4K3_S+YlE.CS\$) MU5T b3 Loc@+3D 1N ThE 5TYL3\$ dIrEcT0Ry 0PH y0UR 8eeHiV3 PHOruM In\$+aLlAt1On.";
$lang['makestyleerror'] = "y0Ur pHoRuM stYl3 C0UlD nO+ BE S4VED L0CalLy +O tHE sERVEr BEC4uSe PERmI\$SIon wA5 DenI3d. +0 \$4ve Y0uR ForUm 5+yLE pL34S3 cLiCK T3h D0wNl0aD 8u++0n 83lOw wh1Ch WIlL PromPT J00 +0 s@v3 +h3 PHiL3 to y0Ur H4RD dRiV3. J00 C4n Th3n Uplo@D +H1\$ Ph1le +0 yoUr serv3r 1Nto %s PholDer, 1PH nECE\$S@Ry Cre4+ING +h3 F0ld3r S+ruC+urE in +h3 pr0c3S\$. j00 \$h0uld n0t3 +h4+ \$0m3 8row\$ers m4Y Ch4N93 +3h N@m3 of thE ph1l3 upon DowNl0AD. Wh3N Uplo4d1NG tEh FilE plE4\$3 m@K3 sure tH@+ I+ 1\$ n@meD stYl3.Css o+h3rwI\$3 TeH ph0ruM styL3 WilL b3 unU5@BlE.";
$lang['uploadfailed'] = "your N3w \$t4r+ page C0uLd n0T 8e UPLoaD3D t0 TEh SErVeR bEc4u53 PErMi\$\$1On W4s DENiED. PlE453 cheCK Th4+ +3H We8 S3rvER / PHP pr0C3s5 1\$ @8lE T0 WR1+E tO tH3 %s F0LD3R oN Y0uR s3rvEr.";
$lang['forumstyle'] = "fOruM StyL3";
$lang['wordfilter'] = "w0rD F1ltEr";
$lang['forumlinks'] = "f0rUm L1NK5";
$lang['viewlog'] = "vi3W LO9";
$lang['noprofilesectionspecified'] = "no ProF1le S3Ct10n \$P3C1phI3D.";
$lang['itemname'] = "i+3m n@ME";
$lang['moveto'] = "m0ve tO";
$lang['manageprofilesections'] = "m4N4g3 PR0PH1le \$eCt1on\$";
$lang['sectionname'] = "s3Ct1on n@m3";
$lang['items'] = "i+3Ms";
$lang['mustspecifyaprofilesectionid'] = "mu5+ spECiPhY 4 Pr0pH1L3 53cT10N iD";
$lang['mustsepecifyaprofilesectionname'] = "mU5+ SpEcIpHy 4 PR0pH1le 53cT1on n4m3";
$lang['noprofilesectionsfound'] = "tHerE 4R3 n0 3x1s+ING PR0pH1lE s3Ct1ons. To @DD A PROpHIL3 sect1on PL3@\$3 CLick T3h BUT+0N b3L0w.";
$lang['addnewprofilesection'] = "add n3w PrOpH1l3 \$3c+i0n";
$lang['successfullyaddedprofilesection'] = "sucC35sPHUlLy @DD3D PR0ph1LE \$eCTi0N";
$lang['successfullyeditedprofilesection'] = "successPhUlLY eDI+3D PR0fiL3 53c+I0n";
$lang['addnewprofilesection'] = "adD N3w pR0pH1lE s3ct1oN";
$lang['mustsepecifyaprofilesectionname'] = "muSt sp3Cify 4 pR0pH1lE \$eCTIOn N4M3";
$lang['successfullyremovedselectedprofilesections'] = "suCcE5\$PhullY r3MovED s3l3c+Ed Pr0FIL3 S3cT10n5";
$lang['failedtoremoveprofilesections'] = "fa1LeD +O r3moV3 PR0f1Le \$3C+i0n5";
$lang['viewitems'] = "view I+3mS";
$lang['successfullyaddednewprofileitem'] = "sucC3\$\$FUlly ADD3d New PR0F1LE I+3m";
$lang['successfullyeditedprofileitem'] = "sucCEssfuLlY EDi+3d PR0f1lE I+3m";
$lang['successfullyremovedselectedprofileitems'] = "sUcCE5\$fulLy REmOveD \$3l3cTED pROph1l3 1+3M5";
$lang['failedtoremoveprofileitems'] = "f@il3D to R3M0V3 PR0f1lE i+3Ms";
$lang['noexistingprofileitemsfound'] = "tH3r3 4r3 No EXi5+ING PR0fIl3 1+3M\$ IN ThI5 \$3CT1oN. T0 4dD 4 PR0pHIlE ITem CL1Ck THe bU+tOn 8ELow.";
$lang['edititem'] = "eD1+ 1tEM";
$lang['invalidprofilesectionid'] = "inv4L1D PrOfIL3 53ct1on 1D 0R \$3CT1oN N0+ PH0unD";
$lang['invalidprofileitemid'] = "inv4Lid pR0FiLE 1+eM 1D 0R I+3m NO+ PHoUnd";
$lang['addnewitem'] = "add N3W 1TEM";
$lang['youmustenteraprofileitemname'] = "j00 MUs+ 3NT3R 4 PROFiLE 1+3m N4M3";
$lang['invalidprofileitemtype'] = "iNv4lID PR0f1lE 1+3M +YP3 S3l3C+3D";
$lang['failedtocreatenewprofileitem'] = "f@1L3d +O CrE4tE NEW pROFiL3 I+3m";
$lang['failedtoupdateprofileitem'] = "f@1l3d +0 UPD@+3 Pr0f1L3 ItEm";
$lang['startpageupdated'] = "s+4RT P@9E upD4+3D. %s";
$lang['viewupdatedstartpage'] = "vi3W UpD4+3D 5t4R+ PAG3";
$lang['editstartpage'] = "eD1+ \$+4r+ P4gE";
$lang['nouserspecified'] = "nO Us3r \$p3C1ph1ED.";
$lang['manageuser'] = "m@n49E us3R";
$lang['manageusers'] = "m4n493 Us3R5";
$lang['userstatusforforum'] = "u\$3R \$T4tU5 f0R %s";
$lang['userdetails'] = "u\$3r DE+41LS";
$lang['warning_caps'] = "wARNiNG";
$lang['userdeleteallpostswarning'] = "aRe j00 sUre J00 w@N+ TO DEl3+3 4lL 0f THE sEL3ct3d Us3R'\$ pO5t\$? 0NCE The pOs+s @R3 dEl3+3D THeY C4Nn0t 8e R3+R1eV3d 4nD WIlL 8e LOs+ PH0Rev3r.";
$lang['postssuccessfullydeleted'] = "pOs+S wEr3 \$uCC355fULlY del3TED.";
$lang['folderaccess'] = "f0lD3R 4CCEs5";
$lang['possiblealiases'] = "p0s\$i8LE @L1a53\$";
$lang['userhistory'] = "u\$ER hIStOrY";
$lang['nohistory'] = "n0 h1\$toRY r3cord\$ \$@v3D";
$lang['userhistorychanges'] = "ch4N93\$";
$lang['clearuserhistory'] = "cl3@R U\$er HI\$t0RY";
$lang['changedlogonfromto'] = "cH4nGED l0G0n fRom %s +o %s";
$lang['changednicknamefromto'] = "cH4Ng3D nIckN4mE PhROm %s tO %s";
$lang['changedemailfromto'] = "cH4N93D 3M4iL FRom %s +O %s";
$lang['successfullycleareduserhistory'] = "sUcC3ssPhULly cle@r3D Us3R h1\$+0Ry";
$lang['failedtoclearuserhistory'] = "f@1LED +o CL3@r U53R H1sTORy";
$lang['successfullychangedpassword'] = "sucCE5\$FuLly Ch@NG3d P4SsWoRD";
$lang['failedtochangepasswd'] = "f@1L3d +0 ch4N93 P4\$\$W0rD";
$lang['viewuserhistory'] = "vI3W U\$3R HI5+0rY";
$lang['viewuseraliases'] = "v1ew U\$3R aLi@\$e\$";
$lang['nomatches'] = "nO m@+CHE\$";
$lang['deleteposts'] = "deLE+3 p0S+5";
$lang['deleteuser'] = "d3leTE u\$3r";
$lang['userdeletewarning'] = "aRe J00 suRE J00 W4N+ +0 D3L3t3 +H3 \$3LeC+3D U\$er 4CC0Un+? 0NC3 +H3 ACC0uNt H4s b3EN D3lETEd 1T c4nn0+ BE R3+R13v3d @Nd WILL b3 Lo5t FoR3vER.";
$lang['usersuccessfullydeleted'] = "usEr \$ucCEs\$FUlly D3Le+3D";
$lang['failedtodeleteuser'] = "fa1LED +O DEl3+3 UsER";
$lang['forgottenpassworddesc'] = "ipH thIS U\$er H4S ph0r9ot+3n +H3iR p@\$5w0rD j00 Can R3\$3+ iT phor +HEm h3re.";
$lang['manageusersexp'] = "tH1S LIs+ SHoWS @ sEL3CtIon 0Ph useR5 WHo h4vE lO9g3D oN T0 y0UR phORUm, S0r+ED 8Y %s. T0 4LtEr 4 U\$3R'\$ pERmI5\$10N\$ ClICk +H31r N@ME.";
$lang['userfilter'] = "user PH1lT3R";
$lang['onlineusers'] = "oNl1n3 Us3rs";
$lang['offlineusers'] = "oFfl1n3 User5";
$lang['usersawaitingapproval'] = "u5eRS 4w@I+in9 APProv4L";
$lang['bannedusers'] = "b4nnED U\$erS";
$lang['lastlogon'] = "l4st l0g0N";
$lang['sessionreferer'] = "s3ssioN R3F3R3R";
$lang['signupreferer'] = "s1gn-UP Ref3R3R:";
$lang['nouseraccountsmatchingfilter'] = "n0 u\$ER ACC0uNT\$ m@+CH1N9 f1L+ER";
$lang['searchforusernotinlist'] = "s3@rCH PhOr 4 U53R N0T iN L1st";
$lang['adminaccesslog'] = "adm1n 4CCEs5 L09";
$lang['adminlogexp'] = "thi\$ L1\$+ \$h0W5 +3H L4st 4CTiOn5 S4ncT1ONEd by Us3Rs WI+h 4DmIN PrIviLE9ES.";
$lang['datetime'] = "d@tE/+iM3";
$lang['unknownuser'] = "unKNoWn U5Er";
$lang['unknownfolder'] = "uNkn0wN F0lD3r";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4S+ IP 4Ddr3\$5";
$lang['logged'] = "l0993D";
$lang['notlogged'] = "n0t L09G3D";
$lang['addwordfilter'] = "aDd w0rD PH1LT3r";
$lang['addnewwordfilter'] = "add NeW WoRd Ph1LTEr";
$lang['wordfilterupdated'] = "worD PhIltER Upd4TED";
$lang['filtername'] = "f1l+3r N@m3";
$lang['filtertype'] = "fIl+ER TYp3";
$lang['filterenabled'] = "fILTEr 3N@8L3D";
$lang['editwordfilter'] = "ed1+ wORD PH1l+3r";
$lang['nowordfilterentriesfound'] = "nO 3x1\$+inG w0rD Ph1lTEr EN+R1e\$ pHouND. T0 4dD 4 wOrD PH1LTEr Cl1Ck +H3 BU++On BELoW.";
$lang['mustspecifyfiltername'] = "j00 MU\$t \$p3c1pHY 4 fILTEr NamE";
$lang['mustspecifymatchedtext'] = "j00 MU\$t \$P3C1pHY M@+CHED TExT";
$lang['mustspecifyfilteroption'] = "j00 MUS+ 5p3cIpHY 4 PHiLt3r opT1oN";
$lang['mustspecifyfilterid'] = "j00 MUsT \$P3c1pHY 4 FIltER ID";
$lang['invalidfilterid'] = "iNV4lid Ph1l+3r 1D";
$lang['failedtoupdatewordfilter'] = "f@ilED T0 upD4tE W0Rd Fil+3R. cheCK +H4+ THE F1LTER s+IlL 3x1s+5.";
$lang['allow'] = "aLl0W";
$lang['block'] = "bl0Ck";
$lang['normalthreadsonly'] = "nOrm4l ThRE4D\$ OnLy";
$lang['pollthreadsonly'] = "p0lL tHr3@D\$ onLY";
$lang['both'] = "b0Th tHRe4d TYPe\$";
$lang['existingpermissions'] = "eXi\$+iNg P3RMI5si0n5";
$lang['nousers'] = "nO UsErs";
$lang['searchforuser'] = "s34RCH F0R U\$er";
$lang['browsernegotiation'] = "bROw53R N3G0t14+3D";
$lang['largetextfield'] = "l4rGE TEx+ F13LD";
$lang['mediumtextfield'] = "meDiUm tEx+ F1eLd";
$lang['smalltextfield'] = "sMALl TEx+ Fi3lD";
$lang['multilinetextfield'] = "muL+I-l1N3 T3X+ FI3LD";
$lang['radiobuttons'] = "r4d1O 8u+T0NS";
$lang['dropdown'] = "dR0p DOwn";
$lang['threadcount'] = "thre4d c0UNT";
$lang['fieldtypeexample1'] = "fOr r4di0 8uT+on\$ And DRoP D0wN f1ELd\$ J00 N33D t0 \$ePAr@+3 THe fI3ldN@M3 @ND TH3 v4Lu3\$ w1+H 4 C0LOn 4nD E4cH v4lU3 5HOUld b3 \$Ep@R4+3D 8Y \$eMI-C0lONs.";
$lang['fieldtypeexample2'] = "ex4mpLE: to CR34+E 4 b4SIC 9EnD3r R4d1o 8U+T0NS, w1+H TW0 \$el3C+10n\$ PHor M@le AnD FEm4L3, J00 W0Uld En+3r: <b>gEnD3r:mAl3;F3M@L3</b> iN The I+3M N@M3 PHI3LD.";
$lang['editedwordfilter'] = "eDI+3d WOrD FilTEr";
$lang['editedforumsettings'] = "eDI+ED PhOrum sE+T1nG5";
$lang['successfullyendedusersessionsforselectedusers'] = "suCC35\$PhULly ENDEd S3\$\$10nS F0r s3L3CtED u\$3r\$";
$lang['matchedtext'] = "matCh3D TEx+";
$lang['replacementtext'] = "r3Pl4c3MEnT T3XT";
$lang['preg'] = "pR3G";
$lang['wholeword'] = "wHolE WoRD";
$lang['word_filter_help_1'] = "<b>all</b> m4TCH3S aG41nS+ +HE wH0l3 T3X+ \$0 FIlTerIN9 M0m +0 mUM W1LL 4L\$o CH4N9E M0MeN+ To mUm3n+.";
$lang['word_filter_help_2'] = "<b>whOlE W0RD</b> M4+CHEs 4G@In\$+ WHolE W0RDs OnlY 5o FiL+3r1nG MOm +O mUM W1lL N0t ch@nG3 m0M3N+ To MUM3N+.";
$lang['word_filter_help_3'] = "<b>pr3G</b> 4lL0Ws j00 t0 UsE pERl RE9uL@R Expr3\$si0ns To m4+Ch t3xt.";
$lang['nameanddesc'] = "n4mE @nD D35cr1pT1oN";
$lang['movethreads'] = "mOve THr34dS";
$lang['movethreadstofolder'] = "m0ve +HrE@d5 T0 f0LD3R";
$lang['resetuserpermissions'] = "reS3+ Us3r P3rM1\$\$1On\$";
$lang['failedtoresetuserpermissions'] = "f@ILED +0 res3t UsEr P3rMi\$s10N5";
$lang['allowfoldertocontain'] = "alL0w F0ld3r To cONT4iN";
$lang['addnewfolder'] = "adD n3w pHoLDEr";
$lang['mustenterfoldername'] = "j00 MU5+ 3nTEr 4 PH0LD3r n4M3";
$lang['nofolderidspecified'] = "n0 f0LD3r iD \$p3cIpH13D";
$lang['invalidfolderid'] = "inv4lID F0lD3r 1D. CHECk Th4t @ PHolD3R W1+H th1\$ 1D exI\$+\$!";
$lang['successfullyaddednewfolder'] = "sucC3sSPHuLLy 4DD3D nEW PholD3r";
$lang['successfullyremovedselectedfolders'] = "suCCEsSfUlLy REM0veD \$3lec+3D PHOld3Rs";
$lang['successfullyeditedfolder'] = "sUCCESspHuLly 3Di+ED ph0lDER";
$lang['failedtocreatenewfolder'] = "f@1l3D TO CREa+E NEW PHoLd3r";
$lang['failedtodeletefolder'] = "f4iL3D T0 D3L3tE PHOlD3r.";
$lang['failedtoupdatefolder'] = "f41l3d TO UpD@t3 PHoLD3R";
$lang['cannotdeletefolderwiththreads'] = "c4nnoT DEl3+3 pHOlders Th4T 5+iLL C0Nt41n THR34D\$.";
$lang['forumisnotrestricted'] = "fORum IS NO+ RE\$+R1CTed";
$lang['groups'] = "gROUp5";
$lang['nousergroups'] = "nO u\$Er GRoUpS H4v3 BE3n 53T UP";
$lang['suppliedgidisnotausergroup'] = "sUPpL1ED 91d I5 N0+ 4 UsER GROUP";
$lang['manageusergroups'] = "m4n@G3 useR Gr0uPS";
$lang['groupstatus'] = "gRouP 5+4+US";
$lang['addusergroup'] = "add 9RoUP";
$lang['addremoveusers'] = "adD/R3moV3 usER5";
$lang['nousersingroup'] = "tHEr3 4R3 N0 u53RS IN THi5 9R0Up";
$lang['useringroups'] = "tHis U53r IS @ meMB3R oPh +HE PHoLl0W1n9 gROUps";
$lang['usernotinanygroups'] = "tH1\$ Us3r i\$ No+ 1n 4NY US3r 9ROuP\$";
$lang['usergroupwarning'] = "n0tE: tHI5 US3r M@Y 8E InH3Rit1ng 4DDIt1on4L PERM15\$1ons PHR0m 4nY U5Er GRoup\$ L1\$+3d 8ElOw.";
$lang['successfullyaddedgroup'] = "sUcC3\$SFuLlY 4Dd3D 9roUp";
$lang['successfullyeditedgroup'] = "succe5SfULly 3DI+Ed gRoUP";
$lang['successfullydeletedgroup'] = "sUcc3\$\$FuLly D3l3+3D 9r0up";
$lang['usercanaccessforumtools'] = "u\$er c4N 4CcE\$s PHorUm +OOl5 4nD C4N CRE4+E, d3l3TE @nD ED1+ PH0RUMs";
$lang['usercanmodallfoldersonallforums'] = "uSer c4N M0DEr@+3 <b>alL PH0LdEr5</b> ON <b>aLl PHOrUM5</b>";
$lang['usercanmodlinkssectiononallforums'] = "uS3R CaN ModeR@+3 L1Nk\$ S3c+10N 0n <b>all F0ruMS</b>";
$lang['emailconfirmationrequired'] = "emaiL COnPh1rm@t1ON REqUIr3D";
$lang['userisbannedfromallforums'] = "user i5 B4nNED Fr0M <b>all F0rUM\$</b>";
$lang['cancelemailconfirmation'] = "c4nCEL 3m4IL CoNpHIRm4T1on @ND 4LLoW U\$eR T0 S+Ar+ P0s+1N9";
$lang['resendconfirmationemail'] = "r353nd cOnFiRmAti0N EM@iL to UsER";
$lang['donothing'] = "dO N0+HING";
$lang['usercanaccessadmintools'] = "uSer H@5 ACC3S\$ +0 FOrUM @Dm1n TO0Ls";
$lang['usercanaccessadmintoolsonallforums'] = "u\$er H45 @Cc3\$\$ +0 @Dm1n +00Ls <b>oN @LL PHOrUM\$</b>";
$lang['usercanmoderateallfolders'] = "us3R C4n M0d3R@+3 @LL PHOLD3R5";
$lang['usercanmoderatelinkssection'] = "user c@n M0dER@+3 L1NKS \$3CT1On";
$lang['userisbanned'] = "uS3r iS 84nNED";
$lang['useriswormed'] = "u\$3R 1\$ w0rM3d";
$lang['userispilloried'] = "u53r I\$ p1ll0Ri3d";
$lang['usercanignoreadmin'] = "u\$ER c4N I9n0rE ADMIn1\$+r@+0R5";
$lang['groupcanaccessadmintools'] = "gr0UP CAN @CC355 4DM1N TO0l\$";
$lang['groupcanmoderateallfolders'] = "group C@N M0d3R4+3 4lL FoLDEr\$";
$lang['groupcanmoderatelinkssection'] = "gR0up can MoDERa+3 l1NK\$ S3ct1oN\$";
$lang['groupisbanned'] = "gR0up 1\$ B@nNED";
$lang['groupiswormed'] = "gR0up I\$ worMED";
$lang['readposts'] = "r34D Pos+5";
$lang['replytothreads'] = "r3PLY +0 +HR34D5";
$lang['createnewthreads'] = "cR34+E N3w +HRe@ds";
$lang['editposts'] = "eDI+ Pos+5";
$lang['deleteposts'] = "d3lEt3 PO\$T5";
$lang['postssuccessfullydeleted'] = "poST5 \$UCCeSspHUlLy DeL3+3d";
$lang['failedtodeleteusersposts'] = "f41L3d TO D3L3T3 UsER's P0\$+5";
$lang['uploadattachments'] = "uPL04d @++4CHMEN+5";
$lang['moderatefolder'] = "mod3r4+3 FolDEr";
$lang['postinhtml'] = "p0st 1N HTML";
$lang['postasignature'] = "p0S+ A \$19N@+UrE";
$lang['editforumlinks'] = "eD1+ pHoRuM L1nks";
$lang['editforumlinks_exp'] = "u\$e tH15 P493 +O @dd L1NK\$ +O Teh DRoP-DOwn LI5+ D1\$PL@yEd 1n +3H +Op-R1gH+ OPh +3h pHorUm PhR4mEs3+. 1F NO lINK\$ @rE s3+, +HE DROp-D0wN lI\$+ W1ll N0T 8e Di\$pL4Y3D.";
$lang['notoplevellinktitlespecified'] = "nO +0p LEvEL lInK +1+L3 \$p3CIph13d";
$lang['youmustenteralinktitle'] = "j00 MU5+ EnTEr @ LINK +i+lE";
$lang['alllinkurismuststartwithaschema'] = "alL L1nk UR1\$ mUs+ 5T4rT W1Th @ \$CHEm4 (I.E. HtTP://, ftp://, iRC://)";
$lang['noexistingforumlinksfound'] = "ther3 @re N0 EX1s+Ing PH0RUM L1nks. +0 @DD A PHoRUm LInk cliCK THE 8U++0n 8EL0w.";
$lang['editlink'] = "ed1+ LINK";
$lang['addnewforumlink'] = "aDD nEW fOrUM LINK";
$lang['forumlinktitle'] = "f0RUm LINK +1Tle";
$lang['forumlinklocation'] = "fOrum L1nK l0C@+1oN";
$lang['successfullyaddednewforumlink'] = "suCCEssfUlLy 4DD3d NEW FOrUm L1nK";
$lang['successfullyeditedforumlink'] = "sucC3\$SpHUlLY 3dI+3D PHOrUm LiNk";
$lang['invalidlinkidorlinknotfound'] = "iNVAlID LinK 1D 0R L1nK N0T PH0UnD";
$lang['successfullyremovedselectedforumlinks'] = "sUcCE\$sphUlLY R3M0VeD 53L3CtED LINKS";
$lang['toplinkcaption'] = "t0P L1nK c@pt1On";
$lang['allowguestaccess'] = "allOw gUEs+ @ccES\$";
$lang['searchenginespidering'] = "seaRCh 3N9iN3 5P1DErin9";
$lang['allowsearchenginespidering'] = "aLlow S3@Rch 3n91N3 5p1DerINg";
$lang['newuserregistrations'] = "n3w U53R R391\$TR@+i0n5";
$lang['preventduplicateemailaddresses'] = "pr3V3n+ DUPl1C@TE EM41l @Ddr3s535";
$lang['allownewuserregistrations'] = "aLlow N3w Us3r REG1stR4+I0nS";
$lang['requireemailconfirmation'] = "rEQU1r3 3M41L ConF1rM4t1On";
$lang['usetextcaptcha'] = "u\$E tEx+-c4PTCh@";
$lang['textcaptchadir'] = "teX+-C4ptCHa dirECt0rY";
$lang['textcaptchakey'] = "text-C4pTCh@ Key";
$lang['textcaptchafonterror'] = "tEX+-C4PTCHA H@\$ 83eN d1\$48LED AU+0m4t1C4LLY b3C4UsE +H3r3 @R3 N0 TrU3 +YPe F0ntS @V@ILA8l3 f0r 1+ +0 U\$3. plE453 UPlO4d 50Me +RUE TYPE f0n+S T0 <b>%s</b> 0n Y0UR SeRv3r.";
$lang['textcaptchadirerror'] = "t3X+-c4p+CH@ H4\$ BE3N d15@BL3d 83C@US3 +hE tEXt_CAp+Ch4 D1R3C+orY @ND It'\$ sU8-d1r3C+0R1es 4RE N0t wR1+@bl3 BY +3h W38 \$eRvEr / PHP PR0c3sS.";
$lang['textcaptchagderror'] = "tEX+-C4ptCH4 H4s bEen D1\$@bLED BEC4U\$e YOUr S3rv3R's PhP \$E+Up Do3\$ noT PR0vIDe 5UpP0r+ PhoR GD 1MAGe M4n1pUL4+I0n 4ND / OR +TF PhonT \$upP0rT. BoTh 4RE reqU1R3d PHoR +Ext-C4pTCH4 \$UPpOr+.";
$lang['textcaptchadirblank'] = "t3xt-caP+Ch4 DIR3Ctory 1\$ 8l@NK!";
$lang['newuserpreferences'] = "nEw us3r Pr3phEr3nc3\$";
$lang['sendemailnotificationonreply'] = "eM4IL N0t1F1c@+iOn On r3PLY +0 U\$3R";
$lang['sendemailnotificationonpm'] = "eM41l N0tIph1C4t1oN On Pm TO US3r";
$lang['showpopuponnewpm'] = "sHow p0pUp wH3n REC3ivInG nEw Pm";
$lang['setautomatichighinterestonpost'] = "s3+ @UToM4+1C HiGH 1NT3r3s+ oN Po\$+";
$lang['postingstats'] = "post1Ng sT4+s";
$lang['postingstatsforperiod'] = "p0\$T1n9 s+4Ts PhOr p3RiOD %s tO %s";
$lang['nodata'] = "no D4+@";
$lang['totalposts'] = "tO+4L P0sTs";
$lang['totalpostsforthisperiod'] = "tot@L P05t\$ PHOr THiS PER10d";
$lang['mustchooseastartday'] = "muS+ ch0OSE @ s+4R+ D4Y";
$lang['mustchooseastartmonth'] = "mu\$+ CHo053 @ s+@RT MOnTh";
$lang['mustchooseastartyear'] = "mU5+ ch0Ose 4 St@RT Y34r";
$lang['mustchooseaendday'] = "mu5+ ChO0s3 4 3ND d4Y";
$lang['mustchooseaendmonth'] = "mu5T cHoOs3 4 END MOnTh";
$lang['mustchooseaendyear'] = "muS+ CH0ose A 3ND YE4r";
$lang['startperiodisaheadofendperiod'] = "s+4rt p3ri0d 15 AHe4d Of 3ND PeRiOD";
$lang['bancontrols'] = "b4n C0ntR0l5";
$lang['addban'] = "aDd B4n";
$lang['checkban'] = "cH3ck B4n";
$lang['editban'] = "eDi+ B4N";
$lang['bantype'] = "ban +YPe";
$lang['bandata'] = "b4n D@+@";
$lang['bancomment'] = "cOMM3n+";
$lang['ipban'] = "iP b@n";
$lang['logonban'] = "lo90n B4n";
$lang['nicknameban'] = "n1CkN4mE b4N";
$lang['emailban'] = "eM41L 8@N";
$lang['refererban'] = "rephEr3r 84n";
$lang['invalidbanid'] = "iNv4liD 84n 1d";
$lang['affectsessionwarnadd'] = "tH1\$ B4n M@Y 4FFeCt +EH FoLloW1n9 AC+Ive US3r \$3s5I0n\$";
$lang['noaffectsessionwarn'] = "this B4n 4ffECTs No 4c+IV3 5Es\$i0ns";
$lang['mustspecifybantype'] = "j00 MU5+ Sp3c1pHY @ B4n +YPE";
$lang['mustspecifybandata'] = "j00 MU\$+ \$PeCiFY sOM3 b4n D4+4";
$lang['successfullyremovedselectedbans'] = "sUcC3\$\$phULlY ReM0vED SeL3c+ED B@NS";
$lang['failedtoaddnewban'] = "f@1L3d +O 4DD n3w b4n";
$lang['failedtoremovebans'] = "f4il3D TO r3moV3 S0m3 oR @ll OpH ThE \$3L3CTED b@ns";
$lang['duplicatebandataentered'] = "dupL1C4+3 b@n da+4 3nTERED. PL34s3 CHeck YouR WIlDC@RD\$ +0 S33 IF +H3y 4LR34Dy m4+ch +HE D4t4 eNTErED";
$lang['successfullyaddedban'] = "sUcCE5\$fulLy @DDED b@N";
$lang['successfullyupdatedban'] = "suCCE\$SPhULLy UPD4TeD 8@N";
$lang['noexistingbandata'] = "tH3R3 IS no 3xI5T1N9 84N D@+4. TO 4DD s0m3 84N D@TA PL3@\$3 cl1cK TEH BU+ToN 8eLOw.";
$lang['youcanusethepercentwildcard'] = "j00 caN Us3 +H3 PERCEn+ (%) WILDc@RD \$ymB0l In 4NY oph YOuR 84n li5+\$ +0 OBT41N P@RT1aL M4+CHE\$, 1.e. '192.168.0.%' W0uLd 8@N @LL IP ADDR3s\$35 IN +eh r4n9E 192.168.0.1 +HRou9h 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C4nnOt 4dD % 4\$ @ W1lDC4RD M4Tch 0N 1+'\$ oWn!";
$lang['requirepostapproval'] = "r3qU1r3 PO5+ 4PPR0V@L";
$lang['adminforumtoolsusercounterror'] = "tH3Re MUs+ Be @+ LE4s+ 1 U\$3R W1+H 4DM1N To0ls @ND Ph0rUm ToOlS ACCeS5 0n 4LL ph0rUms!";
$lang['postcount'] = "p0sT c0UN+";
$lang['resetpostcount'] = "reseT Post couNt";
$lang['failedtoresetuserpostcount'] = "f41l3d T0 R3S3+ P0s+ c0UN+";
$lang['failedtochangeuserpostcount'] = "f@1lED +O cH@N93 Us3r P0ST C0Un+";
$lang['postapprovalqueue'] = "pOs+ @PPRoV4l QUEU3";
$lang['nopostsawaitingapproval'] = "n0 P0sts aR3 4w41+in9 APPrOvaL";
$lang['approveselected'] = "aPPR0v3 \$3l3C+3d";
$lang['successfullyapproveduser'] = "sucCEsSpHuLly APPr0VED s3lEc+3d us3R\$";
$lang['kickselected'] = "kicK \$elECtED";
$lang['visitorlog'] = "vISI+0r LO9";
$lang['novisitorslogged'] = "n0 VI5I+Or\$ L09G3d";
$lang['addselectedusers'] = "aDd s3lECtED U5ers";
$lang['removeselectedusers'] = "reMOv3 \$El3C+Ed uS3rs";
$lang['addnew'] = "aDd NEw";
$lang['deleteselected'] = "d3lete \$3lEcted";
$lang['forumrulesmessage'] = "<p><b>forUm Rul3S</b></p><p>\nR39I\$+rA+I0n +O %1\$5 1\$ PHrEE! WE Do In\$i\$+ TH4T j00 4BIDE By TH3 RUL3\$ @nD P0LIC135 DE+41leD BEL0w. 1f J00 49R33 +0 TH3 +3Rm5, PLE4sE ChECK +HE '1 49r33' CHeCkb0x 4ND Pres\$ +3H 'rEgI\$+3R' BU++0n 8El0w. IF j00 W0uld Lik3 +o C4NC3l th3 rE9i\$+R@t1on, CLiCk %2\$s tO r3TUrn To +h3 f0rUMs inD3X.</p><p>\n@ltHou9H tEh 4dMini\$+R@+oR\$ 4ND modEr4+oRs oph %1\$S wIlL 4t+eMp+ To ke3p 4lL 0bjECt1On@ble mEss493s 0PHPh +Hi\$ f0Rum, 1+ 1\$ impO5\$1Bl3 f0r us +0 r3v13W 4ll m35S4ges. All mes54GES exPRE\$S +he V1Ews opH tEh 4u+H0r, aNd nE1+h3r +H3 0wn3rs 0PH %1\$s, Nor pRojecT BEeh1v3F0RuM @nD 1+'\$ 4phPhiLi@+3S WilL b3 H3LD rEspon\$1Ble pHor tH3 ContEnt 0PH 4ny mE\$s4G3.</p><p>\nBY 49R331ng +o +h3se rul3s, J00 Warr4nt tHa+ j00 Will No+ Po\$T 4ny m3S5@Ge5 +h4+ @r3 0b5CEne, vulG@r, 53Xu@llY-or13nT4T3d, h@+efUl, tHr3@+3N1ng, 0r 0th3rwI\$e vIOl@t1ve 0f 4Ny l4w5.</p><p>th3 owner\$ 0F %1\$\$ REserv3 +he r1gh+ +0 r3M0v3, 3DI+, mov3 0r ClosE @ny tHre4d f0r @NY re4S0n.</p>";
$lang['cancellinktext'] = "hEre";
$lang['failedtoupdateforumsettings'] = "f@iL3D t0 UPD4+E PhOrUM \$3TT1N9\$. pLe4SE TRy 49@IN L4TEr.";
$lang['moreadminoptions'] = "m0rE 4dm1n 0pTI0nS";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch@nG3D Us3r s+4+Us Ph0r '%s'";
$lang['changedpasswordforuser'] = "cH4NGED P4S5W0rD FOr '%s'";
$lang['changedforumaccess'] = "cH4n93d PH0rUM 4CCE\$5 PERMIsS10NS PH0R '%s'";
$lang['deletedallusersposts'] = "deL3T3d @ll P0St5 PHOr '%s'";

$lang['createdusergroup'] = "cre@+ED U\$3R 9r0uP '%s'";
$lang['deletedusergroup'] = "del3tED U53r 9RoUp '%s'";
$lang['updatedusergroup'] = "uPd4tED U\$er 9RouP '%s'";
$lang['addedusertogroup'] = "adDED U\$3R '%s' +0 GR0UP '%s'";
$lang['removeduserfromgroup'] = "r3m0Ve UsEr '%s' PHR0m gR0up '%s'";

$lang['addedipaddresstobanlist'] = "add3D IP '%s' +0 84N LI\$+";
$lang['removedipaddressfrombanlist'] = "rem0VeD IP '%s' FR0m 84n LI\$+";

$lang['addedlogontobanlist'] = "adD3D Lo90n '%s' To 84n LI5+";
$lang['removedlogonfrombanlist'] = "r3M0VED LO9on '%s' fROm 8@N L1st";

$lang['addednicknametobanlist'] = "add3d NicknaM3 '%s' to 84n L1\$t";
$lang['removednicknamefrombanlist'] = "rEmoV3d N1CKn4mE '%s' PHR0M 84N LI\$+";

$lang['addedemailtobanlist'] = "aDD3D EM41l @DDRE\$5 '%s' T0 B4n l1\$+";
$lang['removedemailfrombanlist'] = "rEm0veD EM41l 4DdR3\$\$ '%s' phR0m 84N lISt";

$lang['addedreferertobanlist'] = "adDeD REf3rER '%s' T0 8An L15+";
$lang['removedrefererfrombanlist'] = "rEm0vED R3F3rER '%s' PHr0m ban L15t";

$lang['editedfolder'] = "edi+ED F0lDEr '%s'";
$lang['movedallthreadsfromto'] = "m0v3D @LL tHR3@D\$ fr0M '%s' +0 '%s'";
$lang['creatednewfolder'] = "cr3@+3D New FoLD3R '%s'";
$lang['deletedfolder'] = "d3l3TED F0lD3R '%s'";

$lang['changedprofilesectiontitle'] = "cH4N9Ed PRophIlE \$3ctION Ti+l3 PHrom '%s' TO '%s'";
$lang['addednewprofilesection'] = "aDd3d N3w pR0PH1lE \$3Ct1ON '%s'";
$lang['deletedprofilesection'] = "del3tED PR0ph1LE 53CTi0n '%s'";

$lang['addednewprofileitem'] = "aDdeD N3W PR0PH1LE I+3M '%s' T0 SECt1on '%s'";
$lang['changedprofileitem'] = "cH4N9eD ProPHiLE ITEM '%s'";
$lang['deletedprofileitem'] = "d3LeTED PR0F1L3 1+3M '%s'";

$lang['editedstartpage'] = "edI+3D \$+4Rt P493";
$lang['savednewstyle'] = "s4VED NEw StYl3 '%s'";

$lang['movedthread'] = "m0v3d THRE4D '%s' phR0M '%s' +O '%s'";
$lang['closedthread'] = "cL0\$3d +HR34D '%s'";
$lang['openedthread'] = "oPeN3d THRE4D '%s'";
$lang['renamedthread'] = "rEN@MeD THr34D '%s' T0 '%s'";

$lang['deletedthread'] = "d3L3t3D +HRE4D '%s'";
$lang['undeletedthread'] = "uNdEl3+3D tHRE@D '%s'";

$lang['lockedthreadtitlefolder'] = "locKEd THR34d 0p+I0Ns 0n '%s'";
$lang['unlockedthreadtitlefolder'] = "uNlOCK3d ThRE4d Opt1onS On '%s'";

$lang['deletedpostsfrominthread'] = "d3l3+3D PoSTs PHrOm '%s' 1N THRe4D '%s'";
$lang['deletedattachmentfrompost'] = "d3LETED A++@CHmENt '%s' FrOM p0st '%s'";

$lang['editedforumlinks'] = "edI+3d PhOrUM L1nk5";
$lang['editedforumlink'] = "ediTed F0RUM L1NK: '%s'";

$lang['addedforumlink'] = "aDd3d foRUm L1nK: '%s'";
$lang['deletedforumlink'] = "d3LEteD PHorUM l1nK: '%s'";
$lang['changedtoplinkcaption'] = "cH4ngED ToP l1nK C4p+IOn fr0M '%s' +o '%s'";

$lang['deletedpost'] = "d3l3+3D POs+ '%s'";
$lang['editedpost'] = "eDI+3d P0s+ '%s'";

$lang['madethreadsticky'] = "m4dE +hRE4d '%s' S+ICkY";
$lang['madethreadnonsticky'] = "m4De +hR34d '%s' N0n-\$t1CKY";

$lang['endedsessionforuser'] = "end3D \$e\$5I0N F0r User '%s'";

$lang['approvedpost'] = "appRoveD P05T '%s'";

$lang['editedwordfilter'] = "edI+ED W0RD FiL+3r";

$lang['addedrssfeed'] = "aDd3D rs\$ FE3d '%s'";
$lang['editedrssfeed'] = "eDi+ED R55 Ph33D '%s'";
$lang['deletedrssfeed'] = "d3lEt3D RsS Ph33d '%s'";

$lang['updatedban'] = "uPd@T3d 84N '%s'. ch4n93D TYP3 pHr0m '%s' T0 '%s', ch4n93D D4t4 From '%s' +0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spl1+ ThrE4d '%s' 4T PO\$+ %s  IN+O n3w +HR3@D '%s'";
$lang['mergedthreadintonewthread'] = "mER93D +HRe4Ds '%s' 4nD '%s' InT0 NEw +HRe4D '%s'";

$lang['approveduser'] = "aPPRoVED Us3r '%s'";

$lang['adminlogempty'] = "adM1n L09 1\$ 3MP+y";
$lang['clearlog'] = "cle@R LOG";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no ex1\$+1NG F0rUM\$ fOuND. TO cRE4tE @ nEw pHOrum PlE@\$E cl1Ck tEh 8U++0N 83loW.";
$lang['webtaginvalidchars'] = "w3B+@9 C@N 0NLy cOnT41N UpPERC4\$3 @-z, 0-9 @Nd uNDErSCoRE Ch4R4C+3r5";
$lang['databasenameinvalidchars'] = "d4+4B4s3 N4ME C4n 0NLY ConT4IN 4-Z, 4-Z, 0-9 4ND UnD3rsC0rE CH@R@CTER\$";
$lang['invalidforumidorforumnotfound'] = "iNv4LID phoRUm ph1D F0r fOrUM NoT F0unD";
$lang['successfullyupdatedforum'] = "sucCE\$\$FuLlY UpDAteD F0rUM";
$lang['failedtoupdateforum'] = "fa1LeD T0 upd4+E PH0RUM: '%s'";
$lang['successfullycreatednewforum'] = "sUccE5\$fulLY CRE4tED NEW F0rUM";
$lang['selectedwebtagisalreadyinuse'] = "tH3 \$eL3C+3d W3Bt49 15 @LRE4dY 1n U\$3. pL34sE CHoose An0THEr.";
$lang['selecteddatabasecontainsconflictingtables'] = "th3 S3L3CtED D4tAb@\$3 c0n+4INs COnflICtING +48l35. CoNpHl1Ct1n9 T48le N4MES @r3:";
$lang['forumdeleteconfirmation'] = "are J00 SUrE j00 W4N+ TO D3lE+3 @LL 0PH Teh \$El3c+3D PHORUm\$?";
$lang['forumdeletewarning'] = "ple@s3 N0tE +H@+ j00 c4NN0T R3CoVeR DEl3+3d FoRuMs. Onc3 d3l3+3d @ PHOrUm @Nd 4lL Oph 1+'s @\$soc1aTED D4+4 Is PERm3n4N+LY R3mOv3d pHR0M TEh D4t4B4\$3. 1f j00 dO NO+ wI5H To Del3+E THE 53LECTEd f0rUm\$ pL34se CliCK C4NCEl.";
$lang['successfullyremovedselectedforums'] = "sUCC3ssphUlLY DeLEtED SEL3ctED F0RUm\$";
$lang['failedtodeleteforum'] = "f@1L3d t0 D3l3tED f0rum: '%s'";
$lang['addforum'] = "add FORum";
$lang['editforum'] = "eD1t pH0rUm";
$lang['visitforum'] = "v1Si+ PHOrUM: %s";
$lang['accesslevel'] = "aCcEs\$ l3v3L";
$lang['forumleader'] = "fOruM l34DER";
$lang['usedatabase'] = "us3 D@+@b4SE";
$lang['unknownmessagecount'] = "uNkn0wN";
$lang['forumwebtag'] = "fORUM WE8T49";
$lang['defaultforum'] = "d3ph@UL+ PHoruM";
$lang['forumdatabasewarning'] = "ple4\$3 En5ure J00 \$El3C+ +H3 coRrEC+ D4T4b4s3 WH3n CrE4+1NG A N3W F0RuM. 0NCe Cr34+3D A N3w PHorUm C@Nn0+ 83 M0vED Be+WEeN @V@Il4blE D4+@Ba53\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gLo84L Us3R p3Rmi5sI0Ns";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MUsT \$uppLy @ PhoruM W3Bt49";
$lang['mustsupplyforumname'] = "j00 mus+ 5UpPlY 4 ForUM N4ME";
$lang['mustsupplyforumemail'] = "j00 MUSt 5UPply A PH0RUM 3m41L 4DDRe55";
$lang['mustchoosedefaultstyle'] = "j00 mU\$t cHoOs3 4 D3ph@uLt FoRUM \$+yLE";
$lang['mustchoosedefaultemoticons'] = "j00 MU\$+ cHoos3 D3pH@ul+ PHOrUM eM0t1COnS";
$lang['mustsupplyforumaccesslevel'] = "j00 MUs+ \$UppLy @ pHoRUM 4CCEs5 LEV3l";
$lang['mustsupplyforumdatabasename'] = "j00 MuSt \$UPPly 4 PHOrUm dA+@84sE N@m3";
$lang['unknownemoticonsname'] = "uNknowN 3MoT1c0NS N@m3";
$lang['mustchoosedefaultlang'] = "j00 mU5+ CH0osE 4 D3f@Ul+ PHoRUm L4n9U493";
$lang['activesessiongreaterthansession'] = "aC+Iv3 sE\$sIon T1ME0u+ c4NnOt 8E grE4tEr TH4n \$355i0n +IME0u+";
$lang['attachmentdirnotwritable'] = "at+4CHm3N+ DIREC+OrY @ND 5ys+3m +3MP0r4rY DIREC+Ory / PHP.1N1 'uPL0AD_TmP_D1r' mU\$+ Be WrIt4BL3 By +3h W3B seRv3r / PHp PRoC3\$\$!";
$lang['attachmentdirblank'] = "j00 MU\$+ SuPpLy 4 dIr3C+OrY TO s@VE A++@chM3nts 1N";
$lang['mainsettings'] = "m@1n sE++INg\$";
$lang['forumname'] = "forUM n4M3";
$lang['forumemail'] = "f0rum Em@il";
$lang['forumnoreplyemail'] = "n0-r3PLY 3m@IL";
$lang['forumdesc'] = "f0RUM D35CR1P+1On";
$lang['forumkeywords'] = "foRUM k3yWoRDs";
$lang['defaultstyle'] = "d3ph4ul+ S+YLE";
$lang['defaultemoticons'] = "d3pH@Ul+ 3MO+1C0nS";
$lang['defaultlanguage'] = "dePh@UL+ LANGU493";
$lang['forumaccesssettings'] = "f0rUm 4CCEs5 S3TT1n9\$";
$lang['forumaccessstatus'] = "fORUM 4CC3Ss sT4+Us";
$lang['changepermissions'] = "cH4N9e PerMI\$510N5";
$lang['changepassword'] = "ch4N93 P@S\$w0rd";
$lang['passwordprotected'] = "p@5\$word pR0tEC+3d";
$lang['passwordprotectwarning'] = "j00 H4V3 nOt s3+ @ ph0rUm P4s5woRD. 1PH J00 dO N0t 53t @ P4s\$w0RD THE Pas5wOrd pR0T3C+i0N PHUNct1on@lItY wilL 8E 4Utom4t1C4LLY DIs@BLeD!";
$lang['postoptions'] = "poS+ oPt1oN\$";
$lang['allowpostoptions'] = "alLoW po\$+ 3Di+In9";
$lang['postedittimeout'] = "p0sT EdI+ T1M3oU+";
$lang['posteditgraceperiod'] = "p0st 3D1+ 9R@ce PERi0D";
$lang['wikiintegration'] = "w1KiWIki 1NtE9r4T10n";
$lang['enablewikiintegration'] = "eN@Bl3 WIKIWIkI 1NTE9r4T10n";
$lang['enablewikiquicklinks'] = "en@8lE W1KIWiK1 QUICK L1nks";
$lang['wikiintegrationuri'] = "wiKIwIki lOC4+1oN";
$lang['maximumpostlength'] = "m4X1MUm p0\$+ L3Ng+H";
$lang['postfrequency'] = "pOst pHREqU3NCy";
$lang['enablelinkssection'] = "en4bl3 l1nK\$ \$eC+I0n";
$lang['allowcreationofpolls'] = "aLloW CRE@+I0n 0f POlL\$";
$lang['allowguestvotesinpolls'] = "allOw gues+\$ +0 V0TE In P0lL\$";
$lang['unreadmessagescutoff'] = "uNR34D m3s5@G3\$ cU+-OFpH";
$lang['unreadcutoffseconds'] = "sEc0nDs";
$lang['disableunreadmessages'] = "d1S@8L3 Unr34d M3\$S@9E\$";
$lang['nocutoffdefault'] = "n0 CUT-0PHph (d3F4UlT)";
$lang['1month'] = "1 M0ntH";
$lang['6months'] = "6 m0Nth5";
$lang['1year'] = "1 yE@R";
$lang['customsetbelow'] = "cU\$+OM V@LUe (seT BEl0W)";
$lang['searchoptions'] = "s34rCH OPt1oN\$";
$lang['searchfrequency'] = "se@rCh FrEqUenCY";
$lang['sessions'] = "s3S510NS";
$lang['sessioncutoffseconds'] = "se5Si0N CU+ 0pHF (S3CondS)";
$lang['activesessioncutoffseconds'] = "ac+1V3 s355Ion CUt 0PHPh (S3C0nDS)";
$lang['stats'] = "st4+\$";
$lang['hide_stats'] = "h1de 5+4+S";
$lang['show_stats'] = "sHow sTAT5";
$lang['enablestatsdisplay'] = "en48lE 5+ATs D1\$pLay";
$lang['personalmessages'] = "pERS0N4L M3s5@GE\$";
$lang['enablepersonalmessages'] = "eNa8le PEr\$0N4l M3\$\$@GE\$";
$lang['pmusermessages'] = "pM m3Ss4gE\$ p3r U\$3R";
$lang['allowpmstohaveattachments'] = "alL0w PErS0N4l MES\$4Ge5 T0 H4vE 4++@chm3Nt5";
$lang['autopruneuserspmfoldersevery'] = "aU+o PRUnE u53r'\$ pM F0lD3r\$ 3V3rY";
$lang['userandguestoptions'] = "useR aND Gu3\$t 0p+IoN\$";
$lang['enableguestaccount'] = "ena8LE gUE\$+ acC0un+";
$lang['listguestsinvisitorlog'] = "l1S+ 9UEs+\$ 1N V1sI+0r L09";
$lang['allowguestaccess'] = "aLLOw GUeS+ @cCes5";
$lang['userandguestaccesssettings'] = "us3r 4Nd GUEs+ 4CCes\$ 53++IN9\$";
$lang['allowuserstochangeusername'] = "all0W Us3r\$ +O Ch4n93 U\$3rN@M3";
$lang['requireuserapproval'] = "r3QUIr3 UseR 4PProVaL 8Y 4Dmin";
$lang['requireforumrulesagreement'] = "r3qU1R3 U5ER T0 49R33 +O pHOruM rULEs";
$lang['enableattachments'] = "eN4bl3 4+T4chMEN+5";
$lang['attachmentdir'] = "aT+@cHmEN+ D1r";
$lang['userattachmentspace'] = "aT+@CHmEN+ \$p@CE PEr U\$3R";
$lang['allowembeddingofattachments'] = "all0W EmB3DDiN9 Oph A++4CHMENts";
$lang['usealtattachmentmethod'] = "usE 4l+3rN4+Iv3 4+T@CHMeN+ M3+HOD";
$lang['allowgueststoaccessattachments'] = "aLLoW 9U3S+5 T0 4CCE5\$ @T+4CHMEnt5";
$lang['forumsettingsupdated'] = "fORUM s3+T1N95 \$uCCEs5pHuLLy UPd@+Ed";
$lang['forumstatusmessages'] = "fOruM \$t4+Us M3S\$4gEs";
$lang['forumclosedmessage'] = "f0rum CLos3D m3\$s@9e";
$lang['forumrestrictedmessage'] = "f0rum R3S+R1CtEd MEs5ag3";
$lang['forumpasswordprotectedmessage'] = "forUm P4ssw0rD PRo+3cteD mEs5@gE";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>pos+ 3DI+ +1m30Ut</b> 1\$ +3h +IM3 1N MiNU+3\$ @PH+3R P0s+1n9 TH4T 4 u53R C4n EDI+ +H3ir P0st. 1f sE+ +O 0 +H3rE 1\$ no L1m1+.";
$lang['forum_settings_help_11'] = "<b>m4xiMum PoSt LEN9+H</b> 1S THE m@x1MUm NUmBeR 0F CH4rac+3R5 th@+ W1LL BE DIspl4yeD In 4 P0s+. 1F @ PO\$+ 1S LOn93r th@N +HE NUm8ER oph Ch@R@CTeR\$ d3Fin3d H3R3 1T w1lL 83 cUT shor+ @nd A L1NK 4dDED +o TEh 8o++0M T0 4lLOw User\$ +0 R34D +H3 Whol3 pO5t ON a 5ePar4+e p@gE.";
$lang['forum_settings_help_12'] = "if J00 doN't W4nT Y0Ur uSERs To 8e 48LE T0 cre4tE P0LL5 j00 C4N DI5@8l3 +3h 480VE 0p+IOn.";
$lang['forum_settings_help_13'] = "tH3 L1NKs 53ct1on oF 8E3hivE PR0V1des 4 Pl4CE Ph0r Y0ur UsErs tO M4IN+@IN @ lI\$+ OPh \$i+3s tHEy pHREquEntLy V1sI+ tH4T 0THEr Us3R5 M@Y FinD U5EFUl. LiNK\$ c4N be DivIDED 1ntO C@+3GoR13S 8Y pHoLDeR 4Nd 4lLOw PhoR coMm3N+5 @nD R@T1N95 +O B3 g1V3n. 1n orDEr +0 M0D3r4+3 TeH l1nK5 seCt10N 4 usEr Mus+ 8e R4N+3d 9l0b4L m0dEr@+0r s+aTu5.";
$lang['forum_settings_help_15'] = "<b>s3SS10N cut 0pHf</b> I\$ +3h M@X1MUM +1mE 8efoR3 4 U\$eR's \$e\$5I0n 1S D3emED D34d 4nD Th3y @R3 lOg9ED 0u+. 8Y D3f@ulT +H1S IS 24 HoUrS (86400 seC0nD\$).";
$lang['forum_settings_help_16'] = "<b>ac+IV3 \$E\$5I0n cU+ oPhPH</b> i\$ +3H M@XIMum +IM3 83F0re @ UsEr's sE5SIon 15 D33MED 1n@CT1vE @+ wH1cH POin+ THEY ENter 4n idLe \$+4te. 1n +H1\$ ST4TE +hE u53R R3m41nS L09GeD 1N, 8ut TH3y @re rem0veD pHr0M teh 4Ct1Ve UseRs L15+ 1N TH3 st4Ts Di\$pl4y. Onc3 +h3Y B3ComE 4c+1ve @g@iN Th3y wIlL 8e r3-@DDeD +o tEh Li\$+. By D3f4Ul+ +Hi5 53++iNg I\$ \$E+ +0 15 MiNu+3s (900 sec0nDs).";
$lang['forum_settings_help_17'] = "en4Blin9 +hi\$ 0PT10n @lloWs 83EhIve +0 INCLUdE 4 \$+4tS D15PL4Y @+ +3h bo++0m OpH TEh m3\$\$4GEs p4nE \$imIlAr T0 tHE On3 UsEd 8y M4nY F0RuM s0phTw@RE +I+l3s. OnCE 3n@Bl3D +3h d1\$PL4y 0f TH3 St4ts P@9E C4n B3 +099L3d 1nDIv1DU4LlY 8Y 34Ch Us3R. 1Ph TH3y DoN't W4n+ +0 se3 i+ +H3y c@n hIDe i+ phRom v13w.";
$lang['forum_settings_help_18'] = "p3Rs0n@l M3ss@G3S 4rE iNv@Lu@BL3 4s A W@Y 0pH +4kING M0R3 pR1VA+3 M4ttER\$ 0U+ opH V13w of ThE OthEr M3M83r5. H0w3V3r If J00 Don't W@N+ Y0UR U53R\$ +o B3 48L3 +0 S3ND E4cH 0tHER PeR5on@L M3s\$@g35 J00 C4n D15@BLE +HiS 0P+I0N.";
$lang['forum_settings_help_19'] = "pEr\$0N4L m3s\$@9E\$ C4N 4L\$0 CONt41N 4Tt4chMEn+5 Wh1cH CAn BE us3ful F0R 3xCH@Ng1ng PhIl3\$ BEtw3En Users.";
$lang['forum_settings_help_20'] = "<b>n0TE:</b> th3 sp4CE @LlOC4t1oN PhoR Pm 4Tt4ChM3nT5 Is +4kEN phRoM E4Ch Us3r\$' m41N AT+4CHM3n+ 4lL0C@tIon 4nD 1S Not iN @DDI+I0n +o.";
$lang['forum_settings_help_21'] = "<b>eN4BlE 9U3\$+ @CC0un+</b> alL0Ws V1\$i+orS T0 8RoWs3 y0Ur PHorum 4nD r3Ad pOstS wIth0U+ REGI\$+ER1ng @ Us3R 4cCoUnT. @ u53r @CCOuN+ 1s 5+ILL R3QU1r3d 1pH THEY wIsH +O P0st 0r chaN9e US3r pREF3RENCeS.";
$lang['forum_settings_help_22'] = "<b>lIS+ GUEs+5 In V1s1TOr l0G</b> 4ll0W5 J00 TO sP3C1PHY WH3+hER or n0t Unr3gi\$+3rEd Us3rS ARE l1STEd 0n TEh V1\$I+Or l09 4l0n9 5iD3 r3g1sTEr3D u\$3rS.";
$lang['forum_settings_help_23'] = "b3Eh1v3 @Ll0ws 4Tt4CHm3n+5 +O BE UpL0@deD To ME\$5@g3\$ wH3n PosTED. 1ph J00 H4vE lImIteD WE8 5P4C3 J00 M4y Wh1ch +0 DI\$@8L3 @++@chm3NTs bY Cl34r1NG TeH BoX 48ove.";
$lang['forum_settings_help_24'] = "<b>aT+@chM3N+ d1R</b> I\$ +h3 Loc@tiOn b3EHiv3 ShoUlD 5toR3 I+'S 4tT4Chmen+\$ In. Th1\$ d1r3Ct0RY MU\$+ 3Xi5+ on YOUr w38 \$P4C3 4nD MUst B3 WRI+@BLE 8y TEH w38 \$eRv3r / PHP PROce5s OtHErW1s3 UPLo4ds WILl Ph@IL.";
$lang['forum_settings_help_25'] = "<b>aTt4cHmEn+ 5PACE P3r u53r</b> I5 T3h M4x1MuM @M0uN+ OpH dI\$k \$PAC3 @ Us3r H4\$ phoR 4T+4chM3N+\$. oNC3 +hI\$ \$P@CE I\$ UseD Up TEH us3R C4nN0+ UpLO@D 4nY MOR3 4++@CHMEnT5. BY DEPh@UL+ +HI5 1\$ 1MB Oph sp@CE.";
$lang['forum_settings_help_26'] = "<b>aLlow EM8eddin9 OPh 4T+@CHMEN+5 IN MeS\$@GE\$ / Si9n4TUr3s</b> 4lL0ws UseRs +o Emb3D @++4ChMEnTs in P0\$+\$. 3N48liNG THIS opTiOn WhIle U53FUl C4N 1NCR34S3 YoUr 84nDW1d+h Us4gE DR4s+ic4LLY Und3R C3r+41n CoNfiGUr4t1ons 0f pHP. IPh J00 H@V3 L1MI+3D BanDw1d+h IT 1s r3ComMenDeD +H4+ J00 Di5@8l3 +HiS 0P+Ion.";
$lang['forum_settings_help_27'] = "<b>u5E @lTERn@+IV3 @+TACHmEN+ m3+H0D</b> phOrC3\$ 83ehivE T0 U53 4N @LTErn@+Iv3 R3trIEvaL MEtHod PH0r 4t+aCHm3N+\$. IF J00 R3CEiV3 404 3rrOR M3s\$4GE5 whEn +RY1N9 +O d0WnLO@D 4+t4CHm3n+5 PHr0M MEs\$4GE5 +Ry 3N48L1nG TH1\$ OPt10N.";
$lang['forum_settings_help_28'] = "tHI\$ 5E++ING 4Ll0wS YOuR PhorUM +O B3 \$piDER3d BY \$34RCH Eng1n3s LiKE 9009Le, @LT4V15+@ @ND Y4HoO. if J00 SwI+CH +HI\$ Opt1oN oFF Y0ur F0ruM W1ll N0+ BE inclUd3d 1n +H353 53@rcH 3NgINE\$ rE\$ult\$.";
$lang['forum_settings_help_29'] = "<b>all0w NEw Us3r REg1stR@+i0n\$</b> 4lL0Ws Or d15@LL0Ws +3h CR34T10N opH nEw Us3r 4cC0uNts. \$3Tt1N9 +HE opTiOn +O No CoMpLetElY DI5@8l3s TEh REg1strATi0n F0rm.";
$lang['forum_settings_help_30'] = "<b>eN48l3 WiKIWIK1 INTegRAt1oN</b> Pr0Vid35 W1kiWoRD \$uppoR+ 1n y0uR Ph0Rum P0\$+5. 4 W1KIWoRD i\$ m@D3 up oF +WO 0r MOre c0NC4+3n4tED W0rD5 W1+h UPP3rc4sE LEtTERs (OpH+3N R3F3RR3D t0 a5 CaM3lc4s3). IpH j00 wR1t3 @ W0rD Th1\$ W4y 1+ WILL @UtOm4+1C4LLY 83 CH4n93D 1n+0 4 hyPeRl1Nk pOin+1ng +0 Y0ur ChosEn w1kiWikI.";
$lang['forum_settings_help_31'] = "<b>en4BlE WIKIW1KI qU1Ck l1nk5</b> 3nA8lE\$ +h3 Use OpH Msg:1.1 @ND US3r:L09ON 5tyL3 Ex+3NDED w1kil1nK5 wH1cH CRE4tE hYPErL1NK\$ To tH3 SpECIphI3d M3\$s@ge / Us3r PR0F1LE Oph THE \$p3cIPhI3D us3R.";
$lang['forum_settings_help_32'] = "<b>w1K1WIk1 L0c4tI0n</b> is Us3D TO Sp3c1PHy TH3 URi 0F y0uR W1kIwiKI. Wh3n 3n+3RiNG TEh uRi Us3 [w1k1W0Rd] +0 INDIC4te wH3R3 1N TEH Ur1 tHe wiKiwOrD sh0UlD 4PPE4R, I.3.: <i>h++P://EN.w1K1pEDi4.or9/W1kI/[W1k1w0RD]</i> W0uLD liNK y0Ur WikiW0RD\$ +0 %s";
$lang['forum_settings_help_33'] = "<b>f0RUm 4CC3\$s \$+@+us</b> c0ntR0l\$ hoW Us3rs m@Y 4CCE\$\$ yOur f0rUm.";
$lang['forum_settings_help_34'] = "<b>op3N</b> WiLL ALL0w ALl U53R\$ anD 9U35TS @cc35\$ +0 YoUr PHoRum w1+hOuT RE\$+RiC+I0n.";
$lang['forum_settings_help_35'] = "<b>cl0\$ed</b> pr3V3N+\$ @cc35S F0R @Ll Us3rs, WI+H +3H exC3p+I0n of THe @DM1N WhO mAY s+1lL ACCES5 +eH 4dm1n p4nEl.";
$lang['forum_settings_help_36'] = "<b>r3StrICTeD</b> 4LL0wS To S3t 4 L1\$+ of u\$3R\$ wH0 4r3 aLLoW3d ACC3ss tO yOUr f0RUM.";
$lang['forum_settings_help_37'] = "<b>p@\$SW0RD PrOTECteD</b> 4LL0w5 J00 TO S3T 4 PA55w0RD T0 91v3 0U+ +0 U\$ers \$0 th3Y CaN @Cc3s\$ your PhoRuM.";
$lang['forum_settings_help_38'] = "wH3n SE++INg RE\$+riCtED 0r P4\$\$worD PR0TECtED MoD3 J00 wILL N3ED t0 S4ve Y0Ur CH4NGeS 8ef0r3 J00 C@N cH4NGe +H3 UsER 4cCEss PrIviLe93\$ 0r P4ssW0rd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"From k1lLinG +H3 \$3RV3r.";
$lang['forum_settings_help_40'] = "<b>p0\$T Fr3qUeNCy</b> i\$ +3H mIN1mUm +Im3 4 uSeR Mu\$+ WAI+ 83F0re Th3Y Can poS+ @G@1n. +H1S 53++ING AL\$o @FF3cts +HE cR34TiOn 0f P0LLs. sE+ t0 0 TO D1s48LE teH R3s+R1CT1On.";
$lang['forum_settings_help_41'] = "the 4Bov3 0p+1on\$ Ch4nG3 +HE DEpH4uL+ V4lUeS Ph0R +He Us3r RE9i5tr4t1on Form. WHER3 4ppL1C4bl3 0th3r SeT+Ing5 W1LL UsE tHE Forum's 0wN d3ph4uLt 53t+1n9\$.";
$lang['forum_settings_help_42'] = "<b>pREV3N+ usE 0f dUpl1c4tE 3M41L @DDRE\$5e\$</b> ForC3s BE3h1v3 to CH3Ck T3H UsEr 4cCoUn+s @941ns+ th3 3m41L 4DDR35\$ +H3 usEr I\$ REgI\$+3r1n9 WITH 4ND PR0MptS +H3m +0 us3 @N0tHEr IPH 1+ 1s 4lR3@dy IN us3.";
$lang['forum_settings_help_43'] = "<b>rEQuIr3 3M41L coNFIrm4T1oN</b> wHEn 3N48L3d WILL \$3Nd 4n 3m@IL TO e4ch NeW US3r WitH 4 l1nK TH4T CAn B3 us3D +O CoNphiRm thE1R 3m41L 4DDr3\$S. UnT1l +Hey conpH1RM THeIr EM41l 4dDRe\$s th3y W1lL N0t b3 @8LE +o P0\$+ UnLE\$S THE1r UsEr peRmI\$s10Ns @Re ChaNg3d M@NU@LlY 8y @N 4dMin.";
$lang['forum_settings_help_44'] = "<b>u5e +3Xt-C@pTch4</b> pRes3n+5 TEH N3w Us3r WI+H 4 M4nGL3d 1m@GE WhICh th3y mUs+ c0py 4 NUmBer pHRom 1n+0 4 TExt Phi3LD On +H3 Regi\$+Ra+I0n F0rm. u\$3 THiS 0p+ioN +O PR3v3nt 4u+0m4teD Si9n-Up v14 scRip+5.";
$lang['forum_settings_help_45'] = "<b>tEx+-CAp+Ch4 d1recTorY</b> SpeC1pH13S The L0c@+I0n +H4+ 8e3HIve W1ll s+0Re i+'\$ t3XT-c4ptCh4 iM4G3S @nD PhoNts 1N. +hI5 d1r3ct0ry MUst b3 WRit4BLE By +H3 W3B s3rv3r / pHp PrOcEs\$ 4Nd mUST 8e @cC3s518Le Vi4 ht+p. @F+3r j00 H@V3 EN48led tex+-C@pTch4 J00 mUs+ Upl0AD \$om3 Tru3 +YpE f0n+\$ In+0 tH3 PhonTs suB-Dir3cTory oph yoUr m@in tExt-c4ptCh4 dIr3CtoRy o+heRwi\$3 83Ehiv3 W1Ll \$K1p +h3 +ex+-C4ptcH@ dUring us3R rEG1\$TR@+I0N.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"t3H COd3.";
$lang['forum_settings_help_47'] = "<b>p0\$+ 3Di+ GR4c3 PeRi0D</b> @Ll0wS J00 +0 D3FIN3 @ PER10D IN m1NuTEs wH3r3 u\$ers m@y eDi+ PoSts WI+HOUt +h3 '3D1+3d 8y' TeX+ aPPE4ring 0N ThEir p0S+s. If sE+ +o 0 +HE 'EDi+ED 8y' TEx+ WiLl AlWays 4PP3@R.";
$lang['forum_settings_help_48'] = "<b>uNr34D m3ss@93s CU+-OphPh</b> Sp3CiFi3s HOw LoN9 UnRe4d M355@g3s @R3 R3+4IN3d. J00 M@Y CH00sE PHr0M V4ri0U5 PRE\$3T V4lUEs oR enT3r Y0uR 0wn CU+-0PHf P3r10D IN sEC0NDS. +HRE4D\$ MOd1PHI3D 34rl1eR tHaN The D3Fin3D cU+-oFf P3riOd w1ll 4u+om4T1C4LLY 4pp34R @\$ R3@D.";
$lang['forum_settings_help_49'] = "ch0o\$1n9 <b>di5@bL3 UnRE4d ME5s4G3s</b> w1Ll c0MpL3tEly R3M0V3 UNrE4d Me\$\$493\$ SUppOr+ 4nD r3moV3 +hE R3l3v4NT 0P+ioNs pHrOm tHE D15Cu5\$I0n +Ype DR0p D0Wn 0n T3H +HR34d LIs+.";
$lang['forum_settings_help_50'] = "<b>rEQu1r3 Us3R 4PpR0v@l 8Y AdmIN</b> 4lLoWs J00 T0 r35+rICT @Cc3s5 BY NEw U\$er\$ Un+Il THey hAv3 BE3n 4PPR0VeD bY 4 M0d3R@+0r Or @DM1n. wItH0uT @pPrOv@L @ UseR C4nN0t 4cce\$\$ 4NY 4Re4 0f +H3 8E3H1V3 pHOrUm 1n\$+@ll4T1ON 1nCLUDIN9 INDIViDU4l pHorUm\$, PM InBOx 4ND mY phOrum5 53ction\$.";
$lang['forum_settings_help_51'] = "u\$e <b>clo\$3d m3s5@93</b>, <b>r3\$trIC+ED M35\$49e</b> @Nd <b>p4s5W0rD pRo+3CtEd M3S\$4Ge</b> t0 cU5+0M1sE +HE Me\$5@GE D1\$PLaY3D WH3n us3R\$ @cC355 Y0ur PhOrUm iN th3 v@r10u5 st@+35.";
$lang['forum_settings_help_52'] = "j00 C4n U53 HTML In Y0ur MEs5@G3s. HYPERL1nks 4ND 3M41l @dDre\$53S W1lL 4l\$0 8E @UT0m4+1c4lLY COnv3rtED +0 LiNKS. +O U53 +3h DEPhAulT 8EEhIvE ph0rum ME\$S@9e5 Cl34R +3h FIeLDs.";
$lang['forum_settings_help_53'] = "<b>alL0W UsErs +o CHaNG3 US3Rn@m3</b> perMiTs @Lr3@dY R39isT3r3D usErs t0 Ch@Ng3 +hE1R UseRn4m3. WH3N 3N@8Led J00 C@N Tr4cK +H3 CH4ng35 4 UsEr m4KEs T0 ThEIr U\$3rn@M3 VI@ t3H 4Dm1n us3r T00L\$.";
$lang['forum_settings_help_54'] = "us3 <b>f0rUm RULeS</b> T0 EnT3r 4N ACC3+4bL3 Use P0l1cy Th4T e4cH u5Er Must 49R3E +O 8EpHorE REg1steRiNg oN y0ur PHoRUm.";
$lang['forum_settings_help_55'] = "j00 c@n u\$e H+mL 1N Y0Ur pHoRUm RUl3s. HYPErL1nk5 AND 3m@Il @Ddres\$e\$ WiLl @L\$o b3 4ut0m4+iC4llY COnv3rT3D +0 LINK\$. to U53 +3H D3f@Ul+ 833H1v3 PHoruM @UP CL34r tH3 PhI3Ld.";
$lang['forum_settings_help_56'] = "u53 <b>n0-R3pLY 3MA1l</b> to Sp3CIpHy 4n 3M41L 4dDr3\$\$ +H4+ D0Es No+ 3xI5+ Or WIlL NO+ BE MoN1TOrED PHor R3plIE\$. +H15 EM41l 4DDrEs5 wiLL 8E Us3d In TEh HE@dER5 PHOr @Ll Em41Ls \$EN+ PHr0M YoUr f0ruM 1nCLuD1ng bu+ NO+ LImi+ED T0 P0st 4nD pM N0tiphICa+I0ns, U5er EM41ls ANd pas\$w0rd R3MinD3Rs.";
$lang['forum_settings_help_57'] = "i+ 1\$ r3C0MMEND3d TH4T j00 U\$e An em41L 4DDrE55 +H4+ DO3\$ NO+ 3xi5+ +0 HElP cUt DoWn 0n 5p4M TH4t m4Y be D1R3CtED 4T YoUr M41N PHoRUm 3m41l @ddr3\$s";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d N0+ sP3cifI3D.";
$lang['upload'] = "uplo4d";
$lang['uploadnewattachment'] = "uPl0@D N3w AT+4chMEN+";
$lang['waitdotdot'] = "w41+..";
$lang['successfullyuploaded'] = "sucCE\$\$FuLlY Upl04D3D: %s";
$lang['failedtoupload'] = "fA1L3d T0 uPl04D: %s";
$lang['complete'] = "comPL3+3";
$lang['uploadattachment'] = "uPLO4d A FiL3 ph0r ATt4ChM3nt T0 TEh M3\$s@G3";
$lang['enterfilenamestoupload'] = "eNtEr FiLEn4mE(s) T0 UpL04D";
$lang['attachmentsforthismessage'] = "a+tAChM3n+\$ FOr THI\$ M3\$\$4GE";
$lang['otherattachmentsincludingpm'] = "o+h3r A+t@chMenTs (INCLud1N9 PM MES5@93s aND o+HEr Ph0rUMs)";
$lang['totalsize'] = "tot4L sIzE";
$lang['freespace'] = "fRe3 \$p@cE";
$lang['attachmentproblem'] = "tH3R3 w45 4 pROBLEM D0wnLoadinG TH1\$ @+T4ChMEn+. PLe4s3 +RY 49@iN L4teR.";
$lang['attachmentshavebeendisabled'] = "aT+4chM3nt5 H4VE 8EeN D1\$@BleD BY +H3 pHoRUm 0Wn3r.";
$lang['canonlyuploadmaximum'] = "j00 C@N Only UpL0ad A m@XImUm 0pH 10 pH1lEs 4t @ t1m3";
$lang['deleteattachments'] = "dEL3+e 4+T4CHmEn+s";
$lang['deleteattachmentsconfirm'] = "are J00 sUR3 j00 W4NT tO DEl3tE +H3 5eL3CTED 4tT4Chm3n+5?";
$lang['deletethumbnailsconfirm'] = "aRE j00 \$urE j00 W4NT tO DELeT3 +3h 53l3ctED 4tT4Chm3N+\$ +HUM8naIl\$?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4SsW0rD Ch@Ng3d";
$lang['passedchangedexp'] = "y0ur P4SSwoRD h@\$ B33N CH4n9eD.";
$lang['updatefailed'] = "uPDa+E Ph@IlED";
$lang['passwdsdonotmatch'] = "p4ssW0Rd\$ D0 Not M4+Ch.";
$lang['newandoldpasswdarethesame'] = "nEw @ND 0LD P4\$\$W0RD5 4r3 +H3 5@M3.";
$lang['requiredinformationnotfound'] = "r3Qu1r3D 1NPH0Rm4+I0N NO+ pHOUnD";
$lang['forgotpasswd'] = "foRg0+ P4ssWorD";
$lang['resetpassword'] = "r3S3t P@\$\$w0RD";
$lang['resetpasswordto'] = "r35ET p@ssW0rd to";
$lang['invaliduseraccount'] = "iNV@L1d U53r 4cC0uN+ \$PeCifi3D. CHECk 3MA1l F0r coRREC+ L1Nk";
$lang['invaliduserkeyprovided'] = "iNv4liD Us3r kEY PR0v1Ded. CHECK 3M41L F0R C0rr3CT L1nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO mE\$5@G3 \$p3C1phI3D PHOr D3l3t1on";
$lang['deletemessage'] = "d3l3TE M3\$S@GE";
$lang['postdelsuccessfully'] = "pO5+ D3l3tED sUCCes5pHULlY";
$lang['errordelpost'] = "err0R d3L3+iNg P0s+";
$lang['cannotdeletepostsinthisfolder'] = "j00 C4Nn0+ DeL3+3 PO\$+\$ in Th1s F0lD3r";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 ME\$s@g3 \$p3c1PHi3D PH0r 3Di+ING";
$lang['cannoteditpollsinlightmode'] = "c@NNO+ EDI+ P0lLs IN L19hT MODe";
$lang['editedbyuser'] = "edI+Ed: %s BY %s";
$lang['editappliedtomessage'] = "eD1t 4ppLIED T0 m3s5@Ge";
$lang['errorupdatingpost'] = "error UpD4+iNG POsT";
$lang['editmessage'] = "edi+ mE\$s@g3 %s";
$lang['editpollwarning'] = "<b>n0+E</b>: EDi+IN9 CErT4iN 4sPECts 0pH 4 P0ll W1lL VO1d 4LL TEH CuRrEnT V0t3s @nD aLLow p30pL3 +0 v0Te 4G41N.";
$lang['hardedit'] = "h4rD 3DIt 0p+ions (Vo+3S w1LL 8E RE\$e+):";
$lang['softedit'] = "soF+ 3dI+ op+I0N5 (vOte5 W1lL 8E re+41N3d):";
$lang['changewhenpollcloses'] = "cH4ng3 wH3n +Eh P0ll clo53\$?";
$lang['nochange'] = "nO ChAn9E";
$lang['emailresult'] = "em@Il REsul+";
$lang['msgsent'] = "m3Ss493 \$eNt";
$lang['msgsentsuccessfully'] = "mEss4g3 S3nt \$UCC3s\$phULlY.";
$lang['mailsystemfailure'] = "m4il \$ys+Em F@IluR3. ME\$5@G3 N0+ \$3n+.";
$lang['nopermissiontoedit'] = "j00 4r3 NO+ pErMiT+3D To EDI+ THIS m3ss493.";
$lang['cannoteditpostsinthisfolder'] = "j00 C@NnO+ EDI+ Po\$T\$ 1n TH1s pH0LdER";
$lang['messagewasnotfound'] = "me\$5@GE %s w4s N0T FounD";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "n0 Us3R \$pec1fiED F0r 3M@1L1n9.";
$lang['entersubjectformessage'] = "ent3R 4 sU8J3Ct F0r +3H M3s5@93";
$lang['entercontentformessage'] = "en+3r \$0mE C0nTeN+ PHOr +3H M3s\$@g3";
$lang['msgsentfromby'] = "tH1\$ mEs5@9e W4\$ \$3nt FroM %s 8y %s";
$lang['subject'] = "sU8J3c+";
$lang['send'] = "s3nd";
$lang['hasoptedoutofemail'] = "h@S op+3D OUT Oph 3M4IL Con+4CT";
$lang['hasinvalidemailaddress'] = "U5£r %s h4s @n 1NV@L1d 3m41l 4dDre5\$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "me55493 not1FIc@T1on FroM %s";
$lang['msgnotificationemail'] = "heLl0 %s,\n\n%s p0s+3D 4 M3\$5493 +O J00 On %s.\n\nTh3 Su8jec+ I\$: %s.\n\n+o RE@D th@+ M3ss@G3 4nD OtHERs 1n Th3 S@M3 d1scus\$i0N, 90 TO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnot3: 1Ph J00 D0 N0+ w1Sh +o rECE1V3 3M41l no+IphiC4+i0N5 oph PhOruM m3s\$4G3\$ PostEd To y0u, 9o +o: %s CL1ck 0n mY c0nTr0L5 +H3N 3m41L 4nD Priv@Cy, uN5ElEC+ Th3 3m4iL n0t1phIc4t1on chECKB0x aND pR3s\$ \$Ubm1+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sUbsCr1pt1on N0T1pHIC4t1on FrOm %s";
$lang['subnotification'] = "h3Ll0 %s,\n\n%s P0S+ED 4 MEs\$4GE iN 4 +HR34d J00 H4v3 \$uB5cR1bed +o oN %s.\n\n+he sUBj3C+ 1\$: %s.\n\n+O RE4D TH4t M355@g3 4ND 0TH3rS in Th3 s4mE d1\$Cus5i0n, 90 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0Te: Iph J00 Do Not wi5h +0 R3ceIvE 3m4iL n0t1pH1C4+i0nS 0F NeW m35S@93s 1N TH1\$ +HrE4D, 9O +0: %s 4ND 4dju\$+ youR InTerEs+ L3vEl 4t thE 8OTt0m 0f th3 PAgE.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm No+IpHIC4T1oN PHr0m %s";
$lang['pmnotification'] = "h3LlO %s,\n\n%s P0s+3D @ Pm +O J00 ON %s.\n\n+hE \$ubJ3C+ 1\$: %s.\n\n+o r3@D +H3 m3\$5@Ge G0 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnotE: IPh J00 DO No+ WiSh tO R3cE1V3 3M@IL N0+1PHIC4+10nS OpH NEw pM MEs\$493s p0sTeD To y0u, 90 t0: %s clICK My C0n+rolS +H3N Em@Il 4nd PR1V@cy, uN53L3Ct +H3 Pm NOt1pHIC4t1On CheCkBOX 4nD PrE5s sU8MI+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4\$SworD CH4n93 N0+1pH1C4+10n FR0M %s";
$lang['pwchangeemail'] = "h3ll0 %s,\n\nTH15 a NoT1phiC4t1oN 3m@1l To 1nPH0rm J00 THa+ YoUR p@\$sw0rd On %s h@\$ beeN CH@N93d.\n\ni+ h4S 83en CH4nGeD t0: %s 4ND W45 ch@Ng3D bY: %s.\n\n1Ph J00 h4ve rECE1v3d THIs Em41l IN 3rRor 0R W3R3 No+ Exp3cTiNg @ CHanG3 +0 Y0Ur P4\$SW0RD pl34Se C0nt@Ct T3h PhorUm 0wNEr or 4 MoDEr@+0r 0n %s iMM3d14T3lY t0 CorrEC+ 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "em4iL c0Nf1RM4T1On R3QuiRED PHOr %s";
$lang['confirmemail'] = "h3Ll0 %s,\n\nY0u REC3NTLY CR34+3D A NEW U\$3R ACC0uN+ 0N %s.\nb3f0RE J00 C@n \$+4R+ P05TIN9 w3 n33d +0 coNph1rM Y0ur Em41l 4DdrE\$s. D0n'T W0rRy +HI5 1s QU1T3 Ea\$y. 4lL J00 NEeD tO d0 I\$ clICK Th3 l1nK BELow (0r CoPy @ND p4S+E I+ 1ntO YoUr BR0W\$3r):\n\n%s\n\noNC3 conPhiRm4+10N 1\$ C0mpL3TE J00 M4y lo9iN @Nd s+4r+ Po\$+Ing imM3Di@+Ely.\n\n1ph j00 Did n0t Cr34Te 4 U53r @CCount on %s PL34S3 4Cc3p+ oUr @polOgi3s @ND Phorw@Rd Th15 3M41l +o %s \$0 Th4+ tEh s0urcE 0PH 1+ m@Y B3 iNV3s+194t3d.";
$lang['confirmchangedemail'] = "h3llo %s,\n\ny0U R3cENTlY CH4n93d YOUr 3M@Il 0N %s.\n83PHOrE J00 c4N 5+@RT P0\$t1N9 49@IN W3 NEED To CoNpHirM Y0ur NEw EM41L @DDRE\$5. D0n'T WoRRy tH15 1\$ qUI+3 345Y. 4LL J00 N33d +O D0 I5 cL1Ck +H3 L1Nk 83L0W (Or c0PY @Nd P@S+E 1+ in+0 Y0Ur Br0wSer):\n\n%s\n\n0nC3 ConpH1rm@+10N 1\$ C0mpl3T3 j00 M@Y ConT1nue t0 U\$3 +h3 f0RUm @\$ norM@l.\n\n1f J00 wEr3 N0T expECt1ng Th1\$ em4IL phr0m %s pl34se @CCEpt 0ur 4P0L091E5 4nD f0Rw4RD +HI\$ 3M41l +o %s \$0 thAT +He \$OUrcE 0PH 1+ m4y 8E iNV3st1g4TEd.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3ll0 %s,\n\ny0u REQu35+eD Th1\$ 3-M@iL PHR0m %s BEC4us3 J00 h@V3 ForG0tT3N Y0ur P4s5w0RD.\n\ncl1Ck +H3 L1NK BEL0w (Or COPy @ND Pa5+E 1t INT0 YOur brows3R) T0 R353T Y0UR P4s5woRD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0UR P@\$sword Res3t R3qUEs+ PHRoM %s";
$lang['passwdresetemailsent'] = "p@5SwoRD rE\$3t E-m41l S3NT";
$lang['passwdresetexp'] = "j00 sH0uLD sh0r+LY r3CEivE @N E-M@iL con+@In1nG 1N\$+RUCTioNs Phor R3S3tt1Ng Y0ur p4s\$word.";
$lang['validusernamerequired'] = "a v@LiD U\$3rN@M3 1\$ REQu1R3D";
$lang['forgottenpasswd'] = "f0r9OT p4sswOrD";
$lang['couldnotsendpasswordreminder'] = "c0uld n0+ 53nD p4ssW0rD r3m1NDER. PlE4S3 cONt4C+ TEH f0rUm 0WNEr.";
$lang['request'] = "r3Qu3st";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM@Il ConPh1rM@+IOn";
$lang['emailconfirmationcomplete'] = "th4nk j00 F0R CONf1rm1n9 Y0uR eM41L @dDre5\$. J00 m4y NOw L0g1n 4Nd \$+4R+ P0\$+ing IMmEdi4+elY.";
$lang['emailconfirmationfailed'] = "eM4il confIRm4+1oN h4s PH@1L3D, PLe4s3 +RY 4G@IN L4TEr. 1ph J00 3nCounTEr tH1\$ Err0R MuL+1PL3 T1M3\$ ple@\$e CoN+4C+ THe PH0RUm 0wnER oR 4 M0D3R4t0r F0R @\$51S+@nCE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "tOp l3vEl";
$lang['maynotaccessthissection'] = "j00 M4Y N0+ 4cCEs\$ tHIS 53C+1On.";
$lang['toplevel'] = "t0p lEVeL";
$lang['links'] = "l1nk\$";
$lang['viewmode'] = "vIeW M0D3";
$lang['hierarchical'] = "h1er4rCh1c4l";
$lang['list'] = "li5+";
$lang['folderhidden'] = "tH1\$ f0lD3r 1s h1DDEn";
$lang['hide'] = "h1D3";
$lang['unhide'] = "unh1dE";
$lang['nosubfolders'] = "no suBF0ldErS IN TH1s C4+3G0rY";
$lang['1subfolder'] = "1 5uBF0LD3R 1n TH1\$ C@+E90rY";
$lang['subfoldersinthiscategory'] = "sUBfolDER\$ in +HI\$ c4tEg0rY";
$lang['linksdelexp'] = "en+rI3S 1N A deL3tED F0lDER W1lL Be MOvEd TO +HE P4rEnT pH0LD3r. 0nlY PhOlDER\$ Wh1cH DO n0t C0n+a1n \$U8pholDERs M@Y 8e D3l3TED.";
$lang['listview'] = "li\$+ Vi3W";
$lang['listviewcannotaddfolders'] = "c4NnOt 4Dd PHOLDER5 1n TH15 V13w. Sh0W1n9 20 3NTRIe\$ AT 4 +IM3.";
$lang['rating'] = "r4t1nG";
$lang['nolinksinfolder'] = "nO LINks iN Th1\$ pHoLD3r.";
$lang['addlinkhere'] = "add Link HEr3";
$lang['notvalidURI'] = "tH@+ 15 No+ 4 V4LID URI!";
$lang['mustspecifyname'] = "j00 mu\$t \$P3C1pHY 4 N4me!";
$lang['mustspecifyvalidfolder'] = "j00 mUs+ 5PecipHy 4 V@L1d f0ld3R!";
$lang['mustspecifyfolder'] = "j00 MU\$+ \$p3C1PHY A FolD3r!";
$lang['successfullyaddedlinkname'] = "sUcC3\$SFuLly @DDED L1nk '%s'";
$lang['failedtoaddlink'] = "f41l3d +0 4DD LinK";
$lang['failedtoaddfolder'] = "fa1LEd +0 4Dd PhoLDEr";
$lang['addlink'] = "add @ LINK";
$lang['addinglinkin'] = "addiNg L1nK 1n";
$lang['addressurluri'] = "aDdr3ss";
$lang['addnewfolder'] = "aDd @ NEw F0ld3r";
$lang['addnewfolderunder'] = "aDd1N9 nEW PholD3r UnDEr";
$lang['editfolder'] = "edI+ ph0lD3r";
$lang['editingfolder'] = "eD1+IN9 fOlDEr";
$lang['mustchooserating'] = "j00 MUs+ ch0o53 4 RA+IN9!";
$lang['commentadded'] = "your ComM3N+ W4s 4dD3d.";
$lang['commentdeleted'] = "coMmEN+ W4\$ DEl3teD.";
$lang['commentcouldnotbedeleted'] = "c0mmeN+ CoULD N0t 8e DeLE+3D.";
$lang['musttypecomment'] = "j00 MU5+ tYP3 @ ComM3Nt!";
$lang['mustprovidelinkID'] = "j00 Mu\$t PR0v1D3 4 LINK iD!";
$lang['invalidlinkID'] = "inv@L1d LINK iD!";
$lang['address'] = "addR3S\$";
$lang['submittedby'] = "sU8M1++3d 8Y";
$lang['clicks'] = "cLiCKs";
$lang['rating'] = "r@TIN9";
$lang['vote'] = "v0+3";
$lang['votes'] = "vOTE5";
$lang['notratedyet'] = "n0T R@+ED 8Y 4nY0NE YET";
$lang['rate'] = "r4T3";
$lang['bad'] = "b@d";
$lang['good'] = "g00d";
$lang['voteexcmark'] = "vOtE!";
$lang['clearvote'] = "cleAr v0tE";
$lang['commentby'] = "c0MM3n+ BY %s";
$lang['addacommentabout'] = "aDd 4 cOmM3n+ 480u+";
$lang['modtools'] = "moD3R@t1oN +00ls";
$lang['editname'] = "edit N4m3";
$lang['editaddress'] = "eD1+ ADDREs\$";
$lang['editdescription'] = "eDIT D3\$criP+I0n";
$lang['moveto'] = "mOv3 to";
$lang['linkdetails'] = "l1nK dE+@IL\$";
$lang['addcomment'] = "adD C0MM3N+";
$lang['voterecorded'] = "y0UR V0tE h4s be3n R3C0rD3d";
$lang['votecleared'] = "y0uR voTE h@\$ Be3N cle4r3D";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L09GeD 1n sUccE\$5FUlLy.";
$lang['presscontinuetoresend'] = "pre\$s C0n+iNUE +0 RE53ND foRM d@+A 0R CANc3L +0 r3L04d P493.";
$lang['usernameorpasswdnotvalid'] = "tHe U\$3Rn4M3 OR P@\$sw0Rd J00 5uPPlI3D 15 n0+ V4L1d.";
$lang['pleasereenterpasswd'] = "pL3@\$3 R3-3N+3R Y0Ur P@5sw0rD 4ND TrY @G@1N.";
$lang['rememberpasswds'] = "r3MEM8er P4Ssw0rDS";
$lang['rememberpassword'] = "r3mEm8Er p4\$SWoRD";
$lang['enterasa'] = "en+Er @\$ @ %s";
$lang['donthaveanaccount'] = "don'+ H4v3 4n @cc0UNt? %s";
$lang['registernow'] = "r3GIsT3R N0W.";
$lang['problemsloggingon'] = "pr0BLEms Lo9gInG On?";
$lang['deletecookies'] = "delEt3 C0okI3\$";
$lang['cookiessuccessfullydeleted'] = "c00Ki35 \$uCCEsSpHUllY d3L3tED";
$lang['forgottenpasswd'] = "f0rG0T+3n Y0uR P4s5w0rD?";
$lang['usingaPDA'] = "u51N9 4 pD4?";
$lang['lightHTMLversion'] = "l1GHt hTML VER5IoN";
$lang['youhaveloggedout'] = "j00 H4V3 l099ED Ou+.";
$lang['currentlyloggedinas'] = "j00 @r3 cUrrEnTlY L0993d IN @\$ %s";
$lang['logonbutton'] = "logoN";
$lang['otherbutton'] = "o+heR";
$lang['yoursessionhasexpired'] = "youR 53Ss10n h@\$ 3xPirED. J00 WIlL N33D TO LogIn A9a1N t0 C0n+1NuE.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "mY ph0rUms";
$lang['allavailableforums'] = "all @V41lA8l3 Ph0RUMs";
$lang['favouriteforums'] = "f4vOURi+3 F0RUms";
$lang['ignoredforums'] = "ignOr3D PHOrum\$";
$lang['ignoreforum'] = "iGnor3 PHoRUm";
$lang['unignoreforum'] = "uN1gN0rE f0ruM";
$lang['lastvisited'] = "l@\$+ V1\$iTED";
$lang['forumunreadmessages'] = "%s Unr34D ME\$5@g3s";
$lang['forummessages'] = "%s M3s5@G3s";
$lang['forumunreadtome'] = "%s uNr34d &quot;+O: M3&quot;";
$lang['forumnounreadmessages'] = "n0 UNr34d M3\$\$@9E\$";
$lang['removefromfavourites'] = "rEM0V3 pHR0m F4V0uRi+3\$";
$lang['addtofavourites'] = "aDd to F@VoUrI+3s";
$lang['availableforums'] = "av@iL48LE PH0rUm\$";
$lang['noforumsofselectedtype'] = "tH3R3 @RE NO F0rUMs 0f TEh sEL3ct3d TYP3 4v41LA8l3. Pl34S3 53l3CT 4 d1fFErEn+ tYP3.";
$lang['noforumsavailablelogin'] = "th3Re AR3 NO PH0ruMs 4V4iLa8LE. pl34S3 Lo9iN To Vi3w YOUr F0RUMs.";
$lang['passwdprotectedforum'] = "p4SsW0RD Pr0tEC+3d PHORuM";
$lang['passwdprotectedwarning'] = "tH1S PHOrUM I\$ p4s\$w0rd pRoTECteD. +0 G4IN @cC3ss 3N+3R Th3 pAS\$w0RD BeLow.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "po5+ m3\$s@93";
$lang['selectfolder'] = "sel3ct F0Ld3r";
$lang['mustenterpostcontent'] = "j00 mU\$+ EN+ER 50mE cont3nT FOr +hE P0\$+!";
$lang['messagepreview'] = "mE5\$4GE PR3v1ew";
$lang['invalidusername'] = "inV@L1d U53rn4ME!";
$lang['mustenterthreadtitle'] = "j00 mUSt 3NTEr 4 T1TL3 For th3 +HR3@d!";
$lang['pleaseselectfolder'] = "pl3@\$E s3L3ct @ ph0lD3r!";
$lang['errorcreatingpost'] = "eRR0R CrE4tiNg POsT! PL34S3 +RY 4G41n 1n 4 f3w M1nUTe5.";
$lang['createnewthread'] = "crea+e N3w +hR34D";
$lang['postreply'] = "poST r3Ply";
$lang['threadtitle'] = "tHr3@D +1Tle";
$lang['messagehasbeendeleted'] = "mE\$\$A9e NO+ F0unD. Ch3CK +h4+ i+ H45N't 83en D3l3t3D.";
$lang['messagenotfoundinselectedfolder'] = "meSs493 NO+ PhOUnd 1N SElECtED FOlD3r. CHecK th4T IT h@\$n'+ B3en m0vED or D3lETeD.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C@nNoT pOS+ +H1\$ +HrE4d TyPE iN +H@+ F0ldeR!";
$lang['cannotpostthisthreadtype'] = "j00 C4nN0+ pos+ th15 ThRe4D tYp3 4s +HEr3 4r3 NO @v@Il48l3 pH0LDErs tH@+ @LL0w 1T.";
$lang['cannotcreatenewthreads'] = "j00 C@nNot crE4+3 NeW tHR34D\$.";
$lang['threadisclosedforposting'] = "th15 +HR3@d 1\$ Clo\$3d, J00 C4nnot pOS+ IN I+!";
$lang['moderatorthreadclosed'] = "w4rniNG: TH15 tHR34d I\$ cLo53D F0r Pos+1n9 tO N0rMaL U\$er\$.";
$lang['threadclosed'] = "thre4D CL0s3d";
$lang['usersinthread'] = "uSeRs 1N +HRe4D";
$lang['correctedcode'] = "corrEC+3D COd3";
$lang['submittedcode'] = "su8Mi+T3D C0d3";
$lang['htmlinmessage'] = "htML 1n MES5@GE";
$lang['disableemoticonsinmessage'] = "dIs48Le 3m0TICOns in mES5@GE";
$lang['automaticallyparseurls'] = "aUT0m@+IC@lLY P@rS3 URls";
$lang['automaticallycheckspelling'] = "aUtom4+IC@LLy CHECk sP3lL1n9";
$lang['setthreadtohighinterest'] = "s3+ +HR3@D +o h19H 1NTER3\$t";
$lang['enabledwithautolinebreaks'] = "en@8l3d W1+H @U+0-LIN3-BrE4K\$";
$lang['fixhtmlexplanation'] = "tH1\$ f0rUM USe5 hTml FIlTER1NG. YoUR suBM1t+3D hTmL H45 8EEN MoD1fi3d BY Th3 pHiLtEr\$ IN \$0Me w4y.\\n\\nTo VI3w YoUR 0RIGIn4l CoD3, Sel3cT +H3 \\'\$uBM1+tED CoD3\\' RaDiO 8u+T0n.\\nTO v13w +3h Mod1phI3D C0de, SElEC+ +3H \\'CORrECT3D c0D3\\' R4di0 BU++0N.";
$lang['messageoptions'] = "me5\$@GE opT1oNs";
$lang['notallowedembedattachmentpost'] = "j00 4R3 NO+ 4lL0wed tO 3M8ED AT+4ChMen+5 1N Y0UR Pos+5.";
$lang['notallowedembedattachmentsignature'] = "j00 4r3 NoT @LL0W3D To 3m83D @++ACHMeN+5 IN YoUr 51GNATurE.";
$lang['reducemessagelength'] = "me5\$4Ge lENgTh mUs+ 83 UnD3r 65,535 Char@c+3r\$ (CuRr3nTlY: %s)";
$lang['reducesiglength'] = "si9n4TUr3 lENgTh MUs+ 83 UNdER 65,535 Ch4r4C+3Rs (CURREN+Ly: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c4NNoT CRE4+3 NEw tHr34Ds 1n THi\$ PHoldEr";
$lang['cannotcreatepostinfolder'] = "j00 C4nnoT R3pLY +O p0\$+\$ iN +H1\$ PholDEr";
$lang['cannotattachfilesinfolder'] = "j00 C4nn0t P0s+ aT+4cHm3N+5 1n +HI5 PHOlD3r. R3m0VE @++4cHm3nT5 +0 con+InU3.";
$lang['postfrequencytoogreat'] = "j00 C@N 0nLY POs+ 0NC3 3V3ry %s SEC0nD\$. pLE453 +RY 4G4in LaTER.";
$lang['emailconfirmationrequiredbeforepost'] = "em@il C0NPh1RM4T10N i5 R3QUiREd b3f0re J00 C4n P0\$+. IPH j00 H@VE Not R3c3iV3d @ cONPHiRm4t1on Em41L Pl34S3 cLiCK +H3 Bu++0N 8eLoW @nd 4 NEw OnE WiLl 8e \$3NT T0 y0U. IPH Your EM@Il @Ddr3\$\$ NE3d\$ CH@ng1NG PLe@53 d0 \$0 83FoRe r3QU3\$+1n9 @ NEw C0nf1rm4T1on 3m41L. J00 m@Y ChANgE youR Em4Il 4dDr3\$S By ClICk My c0n+R0L\$ @80ve @Nd +HeN usEr dEt4ILs";
$lang['emailconfirmationfailedtosend'] = "c0nfIrmAt10N Em41L F@IL3d T0 SEnD. PL34s3 cOnTACt THE foRum OwNEr to REC+1phY +H1\$.";
$lang['emailconfirmationsent'] = "c0nphirM4T1on EM41L h4\$ 8eEn RE\$En+.";
$lang['resendconfirmation'] = "r3\$enD cOnPhIRm4+10n";
$lang['userapprovalrequiredbeforeaccess'] = "y0ur u53R 4CC0Un+ NE3D5 +0 8E APpR0vED 8Y @ FOrUm 4DMIn BEpH0r3 J00 c4N ACC3\$s ThE REque5tEd PHoruM.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in rePly +0";
$lang['showmessages'] = "show MeSs4GEs";
$lang['ratemyinterest'] = "r@Te My 1N+3R3s+";
$lang['adjtextsize'] = "aDjuS+ T3x+ \$Iz3";
$lang['smaller'] = "sm4ll3R";
$lang['larger'] = "lArgEr";
$lang['faq'] = "f4q";
$lang['docs'] = "doc5";
$lang['support'] = "supp0r+";
$lang['donateexcmark'] = "don4tE!";
$lang['threadcouldnotbefound'] = "tH3 R3qU35+3d +HREad coulD N0+ 8e F0unD oR @cc3s\$ W@5 D3NI3d.";
$lang['mustselectpolloption'] = "j00 MU\$t S3L3C+ @n OP+I0n T0 vOTE PhOR!";
$lang['mustvoteforallgroups'] = "j00 Mu\$+ V0t3 1n 3vERy gRoUP.";
$lang['keepreading'] = "kE3P Re4diNg";
$lang['backtothreadlist'] = "b4Ck +0 THRE4d L1\$+";
$lang['postdoesnotexist'] = "tH4T P0St DoEs nOt ExI\$T IN THiS ThRE4d!";
$lang['clicktochangevote'] = "cliCk +0 CHangE Vo+3";
$lang['youvotedforoption'] = "j00 v0T3d PHor OpT1ON";
$lang['youvotedforoptions'] = "j00 Vo+3d f0R Op+iOn\$";
$lang['clicktovote'] = "cl1CK +O Vot3";
$lang['youhavenotvoted'] = "j00 H@V3 Not Vo+3D";
$lang['viewresults'] = "vi3w REsUL+s";
$lang['msgtruncated'] = "mE\$S4g3 TrUNC@+Ed";
$lang['viewfullmsg'] = "vieW PhUll M3\$s@G3";
$lang['ignoredmsg'] = "i9n0RED M3\$\$@Ge";
$lang['wormeduser'] = "wormeD U\$3r";
$lang['ignoredsig'] = "i9nor3D 519n@+UrE";
$lang['messagewasdeleted'] = "m35\$@gE %s.%s W4\$ DEl3+3D";
$lang['stopignoringthisuser'] = "s+0p I9norInG +HI5 Us3R";
$lang['renamethread'] = "r3n4Me +HrE4D";
$lang['movethread'] = "mOvE +HR3@D";
$lang['editthepoll'] = "edI+ +H3 p0lL";
$lang['torenamethisthread'] = "to r3n@ME TH1\$ +HRe4D";
$lang['closeforposting'] = "cL0S3 FoR Po\$+InG";
$lang['until'] = "uNtil 00:00 uTC";
$lang['approvalrequired'] = "appr0v4l REqU1reD";
$lang['messageawaitingapprovalbymoderator'] = "mEss493 %s.%s iS Aw41+inG @PPRoV4l By @ MODEr@+Or";
$lang['postapprovedsuccessfully'] = "pOst 4ppROv3D SUcC3ssFuLlY";
$lang['postapprovalfailed'] = "post @pPrOv@L F41lED.";
$lang['postdoesnotrequireapproval'] = "po5T dOe5 No+ REqU1rE @pprOv@L";
$lang['approvepost'] = "appr0VE pOst F0r d1SPl@Y";
$lang['approvedbyuser'] = "aPproV3D: %s 8y %s";
$lang['makesticky'] = "m@kE 5+Icky";
$lang['messagecountdisplay'] = "%s 0F %s";
$lang['linktothread'] = "p3Rm@N3N+ L1NK +O Th1\$ tHrE4d";
$lang['linktopost'] = "liNK tO pO\$t";
$lang['linktothispost'] = "l1nk +0 +HiS p0\$+";
$lang['imageresized'] = "tH1\$ IM4G3 H4s bEEN R3siz3d (oR19iN@L \$IZ3 %1\$sx%2\$s). +0 v1ew +HE phUll-sIz3 IM4ge ClICK HeR3.";
$lang['messagedeletedbyuser'] = "me5\$49E %s.%s D3LEtED %s 8y %s";
$lang['messagedeleted'] = "m3\$S@Ge %s.%s W@5 DELE+3D";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@Nno+ D15pL@y pholD3r MoDErAT0r\$";
$lang['moderatorlist'] = "mOd3r4+0r L1\$+:";
$lang['modsforfolder'] = "m0DEr@+oR\$ Phor F0lD3r";
$lang['nomodsfound'] = "n0 moDER@+0Rs pHoUnD";
$lang['forumleaders'] = "forUm l34DeR\$:";
$lang['foldermods'] = "f0LD3r MoDERa+0rS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "sT4r+";
$lang['messages'] = "mess493s";
$lang['pminbox'] = "in8Ox";
$lang['startwiththreadlist'] = "sT4r+ P493 WI+H +HR34D Lis+";
$lang['pmsentitems'] = "sEn+ 1TEms";
$lang['pmoutbox'] = "oU+b0x";
$lang['pmsaveditems'] = "s4V3d 1+3Ms";
$lang['pmdrafts'] = "dR4fTs";
$lang['links'] = "links";
$lang['admin'] = "aDMin";
$lang['login'] = "lOg1N";
$lang['logout'] = "l0g0u+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRiv4tE M3s5@g35";
$lang['recipienttiptext'] = "sePAr4+3 R3C1p13n+5 BY SeMi-CoLoN oR c0MM4";
$lang['maximumtenrecipientspermessage'] = "th3rE 1s 4 L1mI+ OPh 10 reC1p1EnTs p3r MEs5a93. PL34s3 @M3nD Y0UR r3Cip13NT l15+.";
$lang['mustspecifyrecipient'] = "j00 MUs+ \$p3CIphY 4T L34s+ oN3 R3C1Pien+.";
$lang['usernotfound'] = "u\$er %s N0t fOuND";
$lang['sendnewpm'] = "s3nD nEw Pm";
$lang['savemessage'] = "s@v3 M35\$4gE";
$lang['timesent'] = "t1ME \$eN+";
$lang['nomessages'] = "no mEs\$493S";
$lang['errorcreatingpm'] = "err0R cR34T1N9 pM! pl34Se +RY 4G4iN 1n A phEw MInUtes";
$lang['writepm'] = "wrI+3 M355@G3";
$lang['editpm'] = "eDi+ m3\$S@G3";
$lang['cannoteditpm'] = "c4NN0t Ed1+ TH1\$ Pm. I+ H@S @lR3@Dy b3EN vi3w3D BY tHE REC1pI3n+ oR +H3 M3Ss4G3 D0Es N0T 3xisT 0r i+ I\$ 1N4ccE\$SIBL3 8Y J00";
$lang['cannotviewpm'] = "c4Nn0t VIEW Pm. M355@GE DoEs nOt 3xI5T OR I+ i5 1N@cc3ss18L3 8y J00";
$lang['pmmessagenumber'] = "m3S5@G3 %s";

$lang['youhavexnewpm'] = "j00 H@V3 %d N3W M3s\$493\$. W0ulD j00 L1K3 +0 GO tO yOUr 1n80x n0W?";
$lang['youhave1newpm'] = "j00 H4vE 1 NEW M3\$SAgE. W0ulD j00 lIK3 +0 gO To yOuR 1n80x noW?";
$lang['youhave1newpmand1waiting'] = "j00 H@VE 1 nEW M3\$s@gE.\\n\\nyoU 4ls0 H4vE 1 mE\$S@G3 4w41+iNG DEliv3ry. +o ReCeiVe tHi\$ M3Ss@93 Pl34SE Cl34r \$0m3 \$PaC3 1N your iNb0x.\\n\\nwouLd J00 LiK3 +0 g0 +0 YouR 1n80x N0w?";
$lang['youhave1pmwaiting'] = "j00 H4v3 1 M3s5@G3 4W41+InG DelIv3Ry. +O rECE1VE +HI\$ mE\$\$49E pl34SE CL3@R S0M3 5pACE iN yOuR 1NB0x.\\n\\nWOUlD J00 L1kE to 9o TO yoUr 1n8oX Now?";
$lang['youhavexnewpmand1waiting'] = "j00 H4v3 %d NEw m35S4Ges.\\n\\nY0u 4L5O H@V3 1 M3\$5@GE @w4i+ING D3liv3RY. +0 r3c3iVE tH1\$ me55@9E PLE4\$3 CLEaR 5om3 sP@CE iN Y0ur IN80X.\\n\\nwoulD J00 LIK3 +0 g0 +0 Y0UR 1NB0x n0W?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4VE %d NEw MEs\$4GE\$.\\n\\nyou @Ls0 H4VE %d M3S5@93s @W@1+inG DEliV3Ry. T0 rECeIvE tH3\$3 ME\$5@G3 PL3@53 CL34R \$0ME \$P4c3 In Y0uR inB0x.\\n\\nW0ulD J00 LIKE T0 G0 +0 Your 1n80X N0w?";
$lang['youhave1newpmandxwaiting'] = "j00 H4vE 1 NEw mEs5@G3.\\n\\ny0U @Ls0 HAVE %d MEs5@G35 4WAi+1n9 DeL1V3RY. +0 R3C3iVE +H3se mEs5a935 PL3@\$3 CLe@R s0mE 5PaCE In Y0uR iN80X.\\n\\nWOUlD J00 L1K3 +0 GO +0 YoUr Inb0x N0w?";
$lang['youhavexpmwaiting'] = "j00 H4Ve %d MeSs@G3S 4w@I+IN9 DELIvERy. TO R3cE1VE +H3s3 m3\$s@g3s pLE4s3 cl34R 5ome 5P4c3 1n YOUr 1n80x.\\n\\nWouLD J00 L1k3 +0 G0 T0 YOuR Inb0x noW?";

$lang['youdonothaveenoughfreespace'] = "j00 D0 N0t H4VE 3n0UgH PHRe3 Sp4CE To 53nD Th1\$ MESs4gE.";
$lang['userhasoptedoutofpm'] = "%s h4\$ OpTED Ou+ Oph REC31V1N9 P3R\$on@l ME\$5@G3\$";
$lang['pmfolderpruningisenabled'] = "pM F0LdER PrUNiN9 I\$ 3n4BLED!";
$lang['pmpruneexplanation'] = "tH1s PhOruM Us3s PM F0lDEr PRUNiN9. Teh MES\$@9ES j00 H4v3 s+0rED 1n Y0ur 1nB0x @ND s3Nt I+3Ms\\nPH0LDErs 4r3 \$uBJEC+ T0 4UToma+IC D3l3+i0N. 4nY Mes\$4GES J00 W1\$h TO KE3p \$h0ulD 8E Mov3D T0\\nY0Ur \\'S@V3d 1+Em5\\' FolDEr \$o +H@+ THEy @Re NoT D3lE+Ed.";
$lang['yourpmfoldersare'] = "yOUR pM Ph0LDErS 4rE %s fuLl";
$lang['currentmessage'] = "curreN+ M35\$493";
$lang['unreadmessage'] = "uNre@D MEss4g3";
$lang['readmessage'] = "reaD M3\$S@93";
$lang['pmshavebeendisabled'] = "p3rS0N4L M3ss493S HAV3 beEn d1\$@bl3d 8Y THE PhorUM OWN3r.";
$lang['adduserstofriendslist'] = "aDD US3R\$ +o Y0Ur PHRI3nD5 L1s+ TO h4V3 +H3M 4pPE4R 1N 4 DrOp DOwN on tHE pM Wri+3 M3\$s@gE PAG3.";

$lang['messagesaved'] = "m3ss493 \$@V3D";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3sS@93 W@\$ 5UCCEs5pHUlLy S4VED T0 'DrAF+\$' pHoLDEr";
$lang['couldnotsavemessage'] = "c0ulD NO+ 5@V3 m3\$s@93. M4K3 SUre J00 H4V3 3N0u9H @V@il4Bl3 PHRE3 sp4CE.";
$lang['pmtooltipxmessages'] = "%s m3sS4GE\$";
$lang['pmtooltip1message'] = "1 me5s@9E";

$lang['allowusertosendpm'] = "aLl0W U\$er To s3nD PER\$0N@l mE\$s@g3s +o ME";
$lang['blockuserfromsendingpm'] = "bl0cK U\$Er pHRom \$enDIn9 PEr5oN@L M35\$49es +O M3";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my c0NtR0lS";
$lang['myforums'] = "mY FoRuM\$";
$lang['menu'] = "m3NU";
$lang['userexp_1'] = "u\$E tHE M3NU 0n +3H L3Ph+ T0 M4N493 Y0Ur Se++1n9\$.";
$lang['userexp_2'] = "<b>u\$3R D3+@ILs</b> 4LloWs J00 T0 Ch@N9e YOUr N4mE, EM41l 4dDR35s AnD Pas5W0rd.";
$lang['userexp_3'] = "<b>uS3r ProFIl3</b> @Llows J00 T0 EDI+ YOur U53R PRoph1L3.";
$lang['userexp_4'] = "<b>ch@Ng3 P45SwOrD</b> 4lL0ws J00 T0 CH4N93 Y0ur paSsWorD";
$lang['userexp_5'] = "<b>em4Il &amp; pR1V@cy</b> le+\$ j00 CH4n93 HOw J00 c4N 83 ContactED On aND 0phpH TEh f0rum.";
$lang['userexp_6'] = "<b>fORUm 0PT10ns</b> l3+S J00 ch4n9e HOw +EH PH0Rum Lo0ks 4nD Works.";
$lang['userexp_7'] = "<b>a++4CHm3NT5</b> 4lL0w5 J00 To 3Di+/DEl3+3 Your 4+t@CHmEn+\$.";
$lang['userexp_8'] = "<b>sI9N@+UrE</b> l3Ts j00 3Di+ Y0ur S19N4+Ure.";
$lang['userexp_9'] = "<b>r3l4+10NsHiP\$</b> l3TS J00 mAn@g3 YoUr R3l4+I0nshIp W1tH 0thEr u\$erS On ThE ph0rum.";
$lang['userexp_9'] = "<b>wORD PhIlTEr</b> LEts J00 Edi+ Y0Ur P3Rson@L W0RD phILtER.";
$lang['userexp_10'] = "<b>tHreAD 5U8sCriPt1oN\$</b> 4Ll0W\$ J00 +O M@NA93 YOUR +HrE4D \$uBsCR1PTiOns.";
$lang['userdetails'] = "u\$3r DEt41ls";
$lang['userprofile'] = "u5eR Pr0f1LE";
$lang['emailandprivacy'] = "eM4IL &amp; PRIVACY";
$lang['editsignature'] = "eD1T 5IGn@+URE";
$lang['norelationships'] = "j00 H4v3 NO Us3R REL@+iOnsH1ps s3t UP";
$lang['editwordfilter'] = "eDI+ wOrD Ph1L+3r";
$lang['userinformation'] = "us3R InPH0RM4+1On";
$lang['changepassword'] = "cH4n93 P4\$\$w0rD";
$lang['currentpasswd'] = "cuRr3nT p4SSworD";
$lang['newpasswd'] = "nEw p@\$\$W0rD";
$lang['confirmpasswd'] = "coNFirm P4S\$w0rD";
$lang['passwdsdonotmatch'] = "p@5\$W0rD5 Do N0T m4TCH!";
$lang['nicknamerequired'] = "n1ckN@M3 15 ReqUIrEd!";
$lang['emailaddressrequired'] = "eM41l 4DDR3\$s 1\$ REqu1r3D!";
$lang['logonnotpermitted'] = "l0GOn N0+ p3rm1++3D. CH00SE ANO+HER!";
$lang['nicknamenotpermitted'] = "n1CKn@M3 N0+ PErm1+TED. CH0053 @N0+HEr!";
$lang['emailaddressnotpermitted'] = "em41l 4DDR3\$\$ NO+ P3rM1TTED. CHo0sE @NO+HEr!";
$lang['emailaddressalreadyinuse'] = "eM41L 4dDRE\$s aLRE4DY 1n Us3. CHOosE @NOtH3R!";
$lang['relationshipsupdated'] = "r3l@+1on\$hIp5 UpD@+3D!";
$lang['relationshipupdatefailed'] = "r3la+I0NsHiP uPD@+3D PH41l3d!";
$lang['preferencesupdated'] = "pRepHErenc3\$ W3RE sUccEs\$fuLlY UPDaTED.";
$lang['userdetails'] = "us3R De+41ls";
$lang['memberno'] = "m3M8eR No.";
$lang['firstname'] = "fIRst N@ME";
$lang['lastname'] = "l4s+ n4m3";
$lang['dateofbirth'] = "d@T3 oPh 81rTH";
$lang['homepageURL'] = "hOM3p4GE urL";
$lang['profilepicturedimensions'] = "pR0FilE p1C+Ure (m@x 95x95PX)";
$lang['avatarpicturedimensions'] = "av4+@r PiCTurE (M4X 15x15px)";
$lang['invalidattachmentid'] = "iNv@lID 4T+@chmen+. ch3Ck tHAt 1\$ H@Sn'+ 8e3n D3let3D.";
$lang['unsupportedimagetype'] = "unSUpPOR+ED 1m493 a++4Chm3nT. j00 can OnLy USe jPG, 9If 4ND pn9 IMa9E @+TAChM3Nts PhoR y0ur aV@+4r @ND pROphIle P1CtUr3.";
$lang['selectattachment'] = "s3l3ct 4TT4chm3n+";
$lang['pictureURL'] = "p1cTurE UrL";
$lang['avatarURL'] = "aV@+@R uRL";
$lang['profilepictureconflict'] = "to u\$E 4n 4TTAChMEn+ PHor YoUr pR0phil3 P1c+URe +H3 P1C+Ure UrL Fi3ld mUs+ 8e 8l@NK.";
$lang['avatarpictureconflict'] = "tO U53 4n @++4Chm3N+ PHoR Y0UR AV4t4R P1c+URE +H3 @v4T4r uRL Ph1elD MU5+ 83 Bl4NK.";
$lang['attachmenttoolargeforprofilepicture'] = "s3l3c+3d AtT4ChmeNT I5 +Oo l4Rg3 PHOr pRoF1lE P1ctUr3. M4xImuM D1m3N5iOn5 ArE 95x95px";
$lang['attachmenttoolargeforavatarpicture'] = "s3l3c+3D 4++AChMEN+ 1\$ +oO L@R93 phoR @V@+@r PIC+URE. M4x1MUM dIm3Ns10NS @RE 15x15Px";
$lang['failedtoupdateuserdetails'] = "s0mE 0R ALL Of Y0uR us3r ACC0un+ DE+41l5 c0uLD N0+ 83 UpD4TED. PLE4s3 +RY @G4IN L4T3R.";
$lang['failedtoupdateuserpreferences'] = "sOm3 or @Ll oPH Y0Ur U53R prEF3r3NC35 COuLD n0+ be UPD4TED. pL34\$3 TRY 4G41N L4tEr.";
$lang['emailaddresschanged'] = "em41l 4DDr3S\$ h@\$ BEEn ch4ng3d";
$lang['newconfirmationemailsuccess'] = "yOur Em@1l 4DDr355 h4\$ BEEn Ch4nG3D @nD 4 N3w COnpH1rm@+I0n 3maIl HA5 b33N 53NT. Pl34\$3 cH3Ck 4Nd rE4d +H3 3m4IL Ph0r PHUr+H3r in5tRuCT10Ns.";
$lang['newconfirmationemailfailure'] = "j00 H4v3 CH4N9eD YoUr 3M@Il 4dDr3\$s, bUT W3 W3R3 UN48LE +0 5End 4 C0nPhIrm4+i0N R3qU3s+. PlE4S3 COn+@C+ +HE PHoRUm oWN3R F0R As5I\$T4Nc3.";
$lang['forumoptions'] = "foRUM 0ptiONs";
$lang['notifybyemail'] = "nOT1phY BY EM41L 0f Po\$+5 +O ME";
$lang['notifyofnewpm'] = "nO+1fy By pOpUp 0Ph NEW PM ME55@GE5 +O Me";
$lang['notifyofnewpmemail'] = "n0t1phY by 3M@il 0PH NEw PM M3S\$4GES t0 m3";
$lang['daylightsaving'] = "aDju\$t Phor d4YL1gH+ S4v1N9";
$lang['autohighinterest'] = "aUT0m@+IC4llY M4Rk THR34ds 1 POs+ iN 4s HIgH 1NtER3st";
$lang['convertimagestolinks'] = "aut0M@+1C4lLY C0nvErT EM83dD3D IM4Ge\$ In P0s+\$ In+O lINk5";
$lang['thumbnailsforimageattachments'] = "thUm8n@IL5 pHOr Im@9e @++4ChMeN+5";
$lang['smallsized'] = "sM4Ll Siz3D";
$lang['mediumsized'] = "m3D1UM S1zED";
$lang['largesized'] = "l4RG3 5Iz3D";
$lang['globallyignoresigs'] = "gloB@llY 1GN0R3 Us3R s1gnAtURE\$";
$lang['allowpersonalmessages'] = "alloW 0tH3r Us3rS T0 s3nD M3 PEr5on@L M3\$S@G35";
$lang['allowemails'] = "aLlow 0th3R U53rs +o s3nD M3 3m4IL\$ V1A MY PRopH1l3";
$lang['timezonefromGMT'] = "tImE ZoN3";
$lang['postsperpage'] = "p0sts PEr P4g3";
$lang['fontsize'] = "fOnt sIZE";
$lang['forumstyle'] = "f0RUM s+Yl3";
$lang['forumemoticons'] = "f0rum 3mOtIcOn5";
$lang['startpage'] = "s+@r+ PA93";
$lang['signaturecontainshtmlcode'] = "si9N4+UrE cOnT4IN\$ hTmL cOD3";
$lang['savesignatureforuseonallforums'] = "s4ve \$ignA+URE pHoR U53 0N 4LL PhOrUmS";
$lang['preferredlang'] = "pR3ph3rrED l@NGuaGe";
$lang['donotshowmyageordobtoothers'] = "do N0t Sh0W MY 493 OR D4te 0f b1r+h +0 O+H3r\$";
$lang['showonlymyagetoothers'] = "show 0nLY MY 493 TO 0ThER5";
$lang['showmyageanddobtoothers'] = "sH0w 80tH MY @9E 4nD D@+E 0F BiR+H +O OthErS";
$lang['showonlymydayandmonthofbirthytoothers'] = "shOW onLy My D4y 4nd mOn+H oF 81rtH +O O+H3R5";
$lang['listmeontheactiveusersdisplay'] = "l1St M3 0n +HE 4c+IV3 usER\$ D1\$Pl4y";
$lang['browseanonymously'] = "brOWse f0ruM @NOnym0USLY";
$lang['allowfriendstoseemeasonline'] = "bROws3 4N0nYMOuSlY, BuT 4LLOw Fri3Nd5 T0 s3e M3 A\$ 0nl1n3";
$lang['revealspoileronmouseover'] = "rEV34l \$po1lER\$ 0n MOu53 0ver";
$lang['resizeimagesandreflowpage'] = "rES1ze IM4Ge\$ @nD REPhloW P@9e +O pr3v3NT HOr1z0nt4L \$cr0LL1N9.";
$lang['showforumstats'] = "show PhOrUm sT4t\$ 4+ B0T+Om 0pH M3s\$4g3 P@N3";
$lang['usewordfilter'] = "eNa8LE w0RD PH1LTER.";
$lang['forceadminwordfilter'] = "foRC3 uS3 OpH ADMIn W0RD FilTEr On 4lL U53r\$ (1nC. GUEs+5)";
$lang['timezone'] = "tim3 Z0n3";
$lang['language'] = "l@n9u@g3";
$lang['emailsettings'] = "em41l AND c0NT4C+ sEt+iNGs";
$lang['forumanonymity'] = "f0ruM 4noNyMI+Y sE++INg\$";
$lang['birthdayanddateofbirth'] = "b1r+HD4y @ND D@T3 0f B1rTH Di5pl4y";
$lang['includeadminfilter'] = "iNcLUD3 4dMiN w0rD FIlTEr 1N MY LI5T.";
$lang['setforallforums'] = "s3+ For 4lL F0ruMs?";
$lang['containsinvalidchars'] = "%s C0nta1Ns iNvAl1d CH@RaCTeR\$!";
$lang['homepageurlmustincludeschema'] = "hOmep@9E Url MU\$+ IncLUDE h++P:// sCHEm4.";
$lang['pictureurlmustincludeschema'] = "piC+ur3 Url MUst iNCLUDE HtTP:// \$ChEM4.";
$lang['avatarurlmustincludeschema'] = "av@+@R URl MUs+ iNCluDE H++P:// SChEM@.";
$lang['postpage'] = "poSt pAGE";
$lang['nohtmltoolbar'] = "nO h+mL +O0l84r";
$lang['displaysimpletoolbar'] = "dI5Pl4y \$1MPLE HTmL t0Ol84R";
$lang['displaytinymcetoolbar'] = "d1\$pLAy WYsiwYg H+ML +00lB4R";
$lang['displayemoticonspanel'] = "dI\$PL4Y EM0T1CoN5 P4nEl";
$lang['displaysignature'] = "dI5PL4y S19N4+uRE";
$lang['disableemoticonsinpostsbydefault'] = "di\$@8Le 3M0+1c0Ns 1N M3\$s@G3S by Def4ULt";
$lang['automaticallyparseurlsbydefault'] = "aU+OmatIC4lLy P4rs3 uRLs 1n MES5@9e\$ By D3PH@Ul+";
$lang['postinplaintextbydefault'] = "p0\$+ iN PL41n +Ex+ BY DEPH@Ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0\$+ In HTmL WI+H aU+0-LIN3-Br34Ks By DePh4uL+";
$lang['postinhtmlbydefault'] = "p0s+ 1n H+ML 8y D3F@UL+";
$lang['privatemessageoptions'] = "pRiv4+3 M3\$s@G3 opt1Ons";
$lang['privatemessageexportoptions'] = "priV4+3 M355@g3 3xP0r+ Opt1onS";
$lang['savepminsentitems'] = "sAve 4 C0PY Oph 34Ch PM 1 \$enD 1n MY SEn+ i+3m\$ f0lD3r";
$lang['includepminreply'] = "iNClUd3 MeS5@G3 80dy WH3N R3pLYinG +O PM";
$lang['autoprunemypmfoldersevery'] = "aUt0 PRUN3 mY PM PhOlD3r\$ 3vErY:";
$lang['friendsonly'] = "fr1EnD\$ ONlY?";
$lang['globalstyles'] = "gLO84l S+YlEs";
$lang['forumstyles'] = "fOrum 5+YLEs";
$lang['youmustenteryourcurrentpasswd'] = "j00 MU\$+ 3NTEr Y0uR cUrR3n+ P4sswOrD";
$lang['youmustenteranewpasswd'] = "j00 mu\$+ 3ntEr 4 NEW p@s\$w0rD";
$lang['youmustconfirmyournewpasswd'] = "j00 Mu\$+ c0npHirM YoUR NEW pA55W0rD";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mU5+ pR0V1D3 \$om3 @N\$W3R 9RoUp5";
$lang['mustprovidepolltype'] = "j00 mu\$+ pRov1d3 4 P0ll TYpe";
$lang['mustprovidepollresultsdisplaytype'] = "j00 Mus+ PR0V1D3 RE\$ulTs dISPl4y +YPE";
$lang['mustprovidepollvotetype'] = "j00 MUst Pr0v1d3 4 P0lL VOtE +YPe";
$lang['mustprovidepollguestvotetype'] = "j00 MUs+ \$P3C1phY 1PH 9Ues+\$ 5hoUlD 8e 4Ll0WED +O V0te";
$lang['mustprovidepolloptiontype'] = "j00 mUs+ Pr0v1DE 4 PoLL opTI0n +YPe";
$lang['mustprovidepollchangevotetype'] = "j00 MU5t pRov1d3 4 P0LL Ch@N93 V0TE +Yp3";
$lang['pleaseselectfolder'] = "pLE453 53L3Ct 4 F0LD3r";
$lang['mustspecifyvalues1and2'] = "j00 mUst sP3c1phY V4LU3S PHoR 4nsW3Rs 1 4ND 2";
$lang['tablepollmusthave2groups'] = "tABul4R f0rM4T PoLLs MUs+ HAv3 pR3CisELy +W0 V0t1N9 9roUPs";
$lang['nomultivotetabulars'] = "t48Ul4r PHORm@+ p0LL\$ c4nn0+ BE Mul+I-VoTE";
$lang['nomultivotepublic'] = "puBlic 84LL0tS C4nn0T 8e MuL+1-VotE";
$lang['abletochangevote'] = "j00 WilL 83 48lE t0 CH@n93 YouR v0Te.";
$lang['abletovotemultiple'] = "j00 WILl 8e @8L3 +O VotE MuL+1pL3 +1M3s.";
$lang['notabletochangevote'] = "j00 w1Ll N0T 8e @blE +0 CH@ng3 Y0UR V0tE.";
$lang['pollvotesrandom'] = "nOTE: PoLl Vo+3s 4RE R@NDomly 93N3R@+3D PHOR PREvI3w 0NLY.";
$lang['pollquestion'] = "pOll QUEs+IoN";
$lang['possibleanswers'] = "poSs18lE aN\$W3r\$";
$lang['enterpollquestionexp'] = "eNtEr teh 4N\$w3r5 PHoR Y0ur PolL QUes+IoN.. IPH YoUr PoLl 1s a &quot;YE5/no&quot; QUesT1On, sImPly EntEr &quot;y3s&quot; F0r 4nsw3r 1 @nD &quot;No&quot; foR An\$W3r 2.";
$lang['numberanswers'] = "n0. 4n\$wer\$";
$lang['answerscontainHTML'] = "aNswEr\$ cON+41n H+Ml (N0T 1nCLuDIn9 S19n@+UR3)";
$lang['optionsdisplay'] = "aN\$W3Rs D1sPl4Y tyP3";
$lang['optionsdisplayexp'] = "h0w \$H0UlD TEH 4N\$W3R\$ b3 PREs3n+eD?";
$lang['dropdown'] = "as DRop-DOwn L1s+(s)";
$lang['radios'] = "a\$ 4 \$er13s 0F r4Di0 8U+Ton5";
$lang['votechanging'] = "v0+E Ch4N9IN9";
$lang['votechangingexp'] = "c@N a PEr\$0n CH4n93 H15 oR h3r Vo+3?";
$lang['guestvoting'] = "gUe5+ vo+IN9";
$lang['guestvotingexp'] = "c4n gU35T\$ v0+3 iN TH1\$ P0LL?";
$lang['allowmultiplevotes'] = "all0W MULt1pl3 VoTE5";
$lang['pollresults'] = "p0ll R35UlTs";
$lang['pollresultsexp'] = "hOW W0ULD J00 LIKe to dI5Pl4y +3H R35ul+5 OpH YOur P0lL?";
$lang['pollvotetype'] = "pOll v0+ING TYP3";
$lang['pollvotesexp'] = "hOw ShoULD tHE PoLL BE COnDUcTED?";
$lang['pollvoteanon'] = "aN0NYm0U\$ly";
$lang['pollvotepub'] = "puBl1c B4llo+";
$lang['horizgraph'] = "hoRIzONt4l GR@PH";
$lang['vertgraph'] = "vER+1c@l 9r4ph";
$lang['tablegraph'] = "t4BULar PhOrM4+";
$lang['polltypewarning'] = "<b>w4RN1n9</b>: TH15 1\$ 4 pU8lIC 84LLot. Y0uR N@m3 w1LL 8E v1si8lE NEx+ +0 +3H 0Pt1oN J00 v0TE pH0R.";
$lang['expiration'] = "eXP1r@tI0N";
$lang['showresultswhileopen'] = "do J00 w@N+ +O \$H0W rEsUl+s WhilE THE PoLl 1\$ 0P3N?";
$lang['whenlikepollclose'] = "wHen W0uLD j00 l1k3 YouR POlL T0 4ut0m4T1C4lLy CL0sE?";
$lang['oneday'] = "oNe D@Y";
$lang['threedays'] = "threE DAy\$";
$lang['sevendays'] = "sEvEn D@ys";
$lang['thirtydays'] = "th1r+y D4y\$";
$lang['never'] = "n3V3R";
$lang['polladditionalmessage'] = "add1+I0N4l M3\$s@9e (Op+I0n4l)";
$lang['polladditionalmessageexp'] = "do J00 w@N+ t0 1NClud3 @N @dd1+10N4L Po\$+ 4Ft3r +H3 poLl?";
$lang['mustspecifypolltoview'] = "j00 Mus+ \$p3cIPhy A P0LL To vI3w.";
$lang['pollconfirmclose'] = "aRe j00 suRE j00 W4nT +O CLo\$3 THE PhOlL0w1n9 P0lL?";
$lang['endpoll'] = "eNd p0lL";
$lang['nobodyvotedclosedpoll'] = "no80Dy V0+3d";
$lang['votedisplayopenpoll'] = "%s @nD %s h4vE VO+3d.";
$lang['votedisplayclosedpoll'] = "%s 4ND %s voTeD.";
$lang['nousersvoted'] = "nO USEr5";
$lang['oneuservoted'] = "1 u53R";
$lang['xusersvoted'] = "%s u5ers";
$lang['noguestsvoted'] = "nO Gu3s+5";
$lang['oneguestvoted'] = "1 9U3st";
$lang['xguestsvoted'] = "%s guEs+5";
$lang['pollhasended'] = "pOll H@\$ 3nDEd";
$lang['youvotedforpolloptionsondate'] = "j00 Vo+eD FOr %s 0N %s";
$lang['thisisapoll'] = "th1\$ i\$ 4 p0LL. CLICK TO vI3W RE5ul+S.";
$lang['editpoll'] = "eD1t P0lL";
$lang['results'] = "r35ul+s";
$lang['resultdetails'] = "re5UL+ D3+@iL\$";
$lang['changevote'] = "ch@Nge v0T3";
$lang['pollshavebeendisabled'] = "p0ll\$ H4v3 833n D1\$48L3d by +Eh FoRum OWner.";
$lang['answertext'] = "aN\$weR +3x+";
$lang['answergroup'] = "answ3r 9r0uP";
$lang['previewvotingform'] = "pr3Vi3w vO+IN9 forM";
$lang['viewbypolloption'] = "v13W 8Y P0LL op+i0N";
$lang['viewbyuser'] = "vI3w BY u\$3r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eDI+ Pr0f1LE";
$lang['profileupdated'] = "pr0PHiL3 Upd@+3D.";
$lang['profilesnotsetup'] = "teh PHoRUm OwnER H45 NO+ s3+ Up Pr0Ph1L3\$.";
$lang['ignoreduser'] = "i9norED U\$er";
$lang['lastvisit'] = "l@s+ v1SI+";
$lang['userslocaltime'] = "u5er's LoCaL T1M3";
$lang['userstatus'] = "sT@+u5";
$lang['useractive'] = "onlin3";
$lang['userinactive'] = "in4cTiVe / 0fPhL1N3";
$lang['totaltimeinforum'] = "tot4l +IM3";
$lang['longesttimeinforum'] = "loNG3st \$35\$I0n";
$lang['sendemail'] = "sEnd 3m41l";
$lang['sendpm'] = "sEnD pM";
$lang['visithomepage'] = "vI\$IT HOm3p@G3";
$lang['age'] = "a93";
$lang['aged'] = "ag3D";
$lang['birthday'] = "b1R+HDaY";
$lang['registered'] = "rEG1\$+3rED";
$lang['findpostsmadebyuser'] = "f1nD Po\$+S m4dE 8Y %s";
$lang['findpostsmadebyme'] = "f1ND pOsTs M@DE 8y ME";
$lang['profilenotavailable'] = "prOF1L3 NOT 4v41l48lE.";
$lang['userprofileempty'] = "th1\$ usEr h4s n0+ PHILL3D iN th3iR PR0PH1lE 0R 1+ IS s3+ TO PRiv@T3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORRY, NEW US3r rEGI\$+R@+10Ns 4R3 no+ 4LL0WED RIGHT N0W. pL34sE CHECk 8@CK L4+3r.";
$lang['usernameinvalidchars'] = "u5ERN4m3 c@n OnLY C0Nt41n 4-Z, 0-9, _ - CH4R4c+ER\$";
$lang['usernametooshort'] = "uS3RN4Me MUS+ B3 @ M1N1MUm 0F 2 ch@R@C+3R5 L0n9";
$lang['usernametoolong'] = "u\$3rN4me MUs+ BE a M@ximUM 0f 15 ch4r4cTEr\$ L0n9";
$lang['usernamerequired'] = "a l0g0n N4ME I5 rEQuIRED";
$lang['passwdmustnotcontainHTML'] = "pAssw0RD mU5T N0T CoNt@IN HTMl T495";
$lang['passwordinvalidchars'] = "p4S5W0Rd c@N ONly COn+@In @-Z, 0-9, _ - cH4r4cTER\$";
$lang['passwdtooshort'] = "p4SsW0rD MU5+ be 4 M1nIMum OPh 6 CH4r@c+3r5 L0N9";
$lang['passwdrequired'] = "a p@5swoRd 1\$ R3QU1rED";
$lang['confirmationpasswdrequired'] = "a C0NF1rM4t1on P4sswOrD I\$ ReqUIr3D";
$lang['nicknamerequired'] = "a nickn4M3 1\$ REqu1rED";
$lang['emailrequired'] = "aN eM@iL 4DDReS\$ I\$ REQU1R3D";
$lang['passwdsdonotmatch'] = "p4Ssw0RD\$ D0 N0t M4+CH";
$lang['usernamesameaspasswd'] = "u5ERN4m3 4ND P4s\$w0rD MU\$t 8e d1phFER3nt";
$lang['usernameexists'] = "sOrrY, 4 Us3r W1tH +H4+ N@M3 @LRE@dY 3xI5+\$";
$lang['successfullycreateduseraccount'] = "succE5spHUlLy CrE4Ted uSEr 4CC0un+";
$lang['useraccountcreatedconfirmfailed'] = "yOUr u5eR 4CC0uNt H4S 833n CR34+3D bu+ +3H R3qU1rED C0Nf1rm4T1on 3m@iL w45 No+ sEN+. PLE4s3 C0N+4C+ +hE PhorUm owN3R T0 R3c+1Fy ThIs. 1n TH1\$ mE4nt1m3 PL34se ClICk +H3 C0N+iNuE BUt+0n TO Log1N iN.";
$lang['useraccountcreatedconfirmsuccess'] = "yoUr Us3r 4ccoun+ H4s BEeN CRE4t3D buT 8EpH0R3 j00 C4n S+@rt P0st1N9 J00 MU\$+ c0npH1Rm yOuR eMa1l 4DdRE\$S. ple4Se cH3Ck y0uR 3m41L For 4 liNk th4+ W1lL @llOW J00 +O CoNFirm yoUr @DdReS5.";
$lang['useraccountcreated'] = "your Us3r @cc0un+ H4\$ bEeN Cr34TED 5UCCeS\$FUlly! Cl1Ck +H3 C0nt1nU3 8u++0N 8El0w +0 LoGIn";
$lang['errorcreatinguserrecord'] = "err0R CR34+iN9 u53r RECoRD";
$lang['userregistration'] = "u\$eR R3g1\$+R4+10n";
$lang['registrationinformationrequired'] = "rEGi5+r4+I0n 1NpH0RM4t1on (R3qU1r3d)";
$lang['profileinformationoptional'] = "pR0F1l3 iNPHOrM4t1On (0P+I0N4l)";
$lang['preferencesoptional'] = "preph3rENCES (OPtI0n4l)";
$lang['register'] = "r3Gis+3R";
$lang['rememberpasswd'] = "remEm8ER P4ssWord";
$lang['birthdayrequired'] = "youR D@+3 0f 81r+H IS r3qu1RED oR i5 InValID";
$lang['alwaysnotifymeofrepliestome'] = "no+1Phy 0N REPLY +0 ME";
$lang['notifyonnewprivatemessage'] = "nOt1phY 0N N3w pRIv@+3 M3s\$4g3";
$lang['popuponnewprivatemessage'] = "pop Up 0N nEw pRiVaTE mES5@9E";
$lang['automatichighinterestonpost'] = "auT0ma+IC HIgH 1n+3R35T ON PO\$+";
$lang['confirmpassword'] = "c0nfIrM P@55woRD";
$lang['invalidemailaddressformat'] = "iNv@LID EM@IL @ddr3\$s pHoRm4T";
$lang['moreoptionsavailable'] = "mOrE pR0Ph1L3 @Nd PR3pH3REnC3 0p+I0Ns 4RE 4v4Il48l3 OnC3 J00 R3GiS+Er";
$lang['textcaptchaconfirmation'] = "coNpH1Rm4TIoN";
$lang['textcaptchaexplain'] = "to +He R1gh+ i5 A +Ex+-C@Ptch4 IM4gE. PL34s3 +YP3 +eH COD3 j00 C@n \$3E In THE 1m@G3 iN+O +h3 INPUt Phi3LD BElow 1+.";
$lang['textcaptchaimgtip'] = "tHi\$ 1\$ 4 C4p+CH4-PIC+UrE. I+ 1s Us3d T0 PREveNT 4u+OM@+iC R3gIs+RA+I0n";
$lang['textcaptchamissingkey'] = "a C0NF1RM4+I0N CoDE I\$ rEqU1RED.";
$lang['textcaptchaverificationfailed'] = "t3xT-CAp+CH4 VER1PHIC4t1on CoDE W@\$ 1nCOrR3Ct. Ple@\$E Re-3n+3r I+.";
$lang['forumrules'] = "f0rUm RUlE5";
$lang['forumrulesnotification'] = "in 0Rd3r To ProC3eD, J00 Mu\$+ 4GREE Wi+H +HE PhOll0w1N9 rULEs";
$lang['forumrulescheckbox'] = "i HaV3 r34D, @ND 49rEE +o 4B1dE 8y THe F0ruM rUl3s.";
$lang['youmustagreetotheforumrules'] = "j00 mUs+ 49RE3 +0 +H3 PHOruM rUL3s BEf0RE J00 C4n COnT1nU3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mEMBeR";
$lang['searchforusernotinlist'] = "sE@rCh f0r 4 UsER n0t 1n LIS+";
$lang['yoursearchdidnotreturnanymatches'] = "yOur 53@rCH DID N0t R3+uRN 4NY m@+Ch35. +Ry SIMpL1FY1N9 YoUR \$34Rch p4r@M3+eR\$ ANd +RY 49@1n.";
$lang['hiderowswithemptyornullvalues'] = "hIde RoW5 W1+H 3mP+Y 0R NulL VaLUE\$ in \$3lECTED ColuMNs";
$lang['showregisteredusersonly'] = "sH0W r3g1\$+3r3D UsErS 0nlY (H1DE Gu3\$+s)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rElA+1oN\$hIPs";
$lang['userrelationship'] = "u\$Er r3l4+1oNsHip";
$lang['userrelationships'] = "us3r REl@+ioN\$hIps";
$lang['failedtoremoveselectedrelationships'] = "fA1LED +o REm0VE \$3L3ctED REL@+I0nshIp";
$lang['friends'] = "fR1ENDs";
$lang['ignoredcompletely'] = "iGnorED c0MpL3+3lY";
$lang['relationship'] = "r3l@+1oNsh1p";
$lang['restorenickname'] = "restor3 UsER's n1CkN4mE";
$lang['friend_exp'] = "u\$3r'\$ po5t\$ M4rK3d WITH 4 &quot;PHRIeNd&quot; IC0N.";
$lang['normal_exp'] = "uSer's PO\$+s @pP34R @\$ n0Rm@l.";
$lang['ignore_exp'] = "u\$3R's pO\$+\$ AR3 HiDDEn.";
$lang['ignore_completely_exp'] = "thRE4ds 4nD P0Sts T0 or PHRom U\$eR W1ll @ppe4R DEl3+3d.";
$lang['display'] = "d1SpL@Y";
$lang['displaysig_exp'] = "useR'5 s19N@+URe I\$ DIsPl4YED on +H31R P0s+5.";
$lang['hidesig_exp'] = "u\$3R'\$ \$1GN4tUr3 iS hIDd3n On tHEir p0st5.";
$lang['cannotignoremod'] = "j00 c4nNoT IGn0rE +HI\$ us3r, AS +H3y AR3 4 mOd3r4tOr.";
$lang['previewsignature'] = "pr3Vi3w siGnA+Ure";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s3@rCh reSUl+s";
$lang['usernamenotfound'] = "th3 US3RN@M3 j00 SPeC1PhIED In TEh +0 0r PHRom fI3lD W45 n0T F0unD.";
$lang['notexttosearchfor'] = "oN3 or 4Ll 0F Y0ur sE4rCH K3ywOrD\$ w3r3 1nV@l1D. \$34RCH KeywOrDs mU\$+ 8e No sh0R+Er tH4n %d CH4R4C+3rs, N0 loN9ER Th4n %d Ch4r4C+eR\$ aND mUs+ N0t 4ppE4R IN ThE %s";
$lang['keywordscontainingerrors'] = "keYw0rD\$ C0nt41nIN9 3rRoR\$: %s";
$lang['mysqlstopwordlist'] = "mY\$QL s+0pWOrd Lis+";
$lang['foundzeromatches'] = "f0uND: 0 M4Tch3\$";
$lang['found'] = "fOunD";
$lang['matches'] = "m@TCh3\$";
$lang['prevpage'] = "pReviOUs PaGE";
$lang['findmore'] = "fiND m0RE";
$lang['searchmessages'] = "searCh ME\$\$493\$";
$lang['searchdiscussions'] = "s3@Rch DI5cussiON\$";
$lang['find'] = "fiND";
$lang['additionalcriteria'] = "aDdI+I0N4L CRi+3r14";
$lang['searchbyuser'] = "searCh 8y UsEr (Opt1on@l)";
$lang['folderbrackets_s'] = "f0lD3r(S)";
$lang['postedfrom'] = "pOS+3d FrOm";
$lang['postedto'] = "pos+eD To";
$lang['today'] = "tod@y";
$lang['yesterday'] = "ye\$+3rD@Y";
$lang['daybeforeyesterday'] = "d4y BEfOr3 yE\$+3Rd@Y";
$lang['weekago'] = "%s wE3K 49o";
$lang['weeksago'] = "%s w33Ks A9O";
$lang['monthago'] = "%s MoN+h 490";
$lang['monthsago'] = "%s mon+Hs 490";
$lang['yearago'] = "%s Y3@r AGo";
$lang['beginningoftime'] = "bE91NNin9 OpH T1M3";
$lang['now'] = "n0w";
$lang['lastpostdate'] = "l4St Po\$T DatE";
$lang['numberofreplies'] = "numB3r of R3pL13s";
$lang['foldername'] = "f0ldeR n4M3";
$lang['authorname'] = "aU+hoR N@M3";
$lang['decendingorder'] = "n3weS+ FIrsT";
$lang['ascendingorder'] = "old3s+ PHirS+";
$lang['keywords'] = "k3ywoRDs";
$lang['sortby'] = "sor+ BY";
$lang['sortdir'] = "s0RT d1r";
$lang['sortresults'] = "sOr+ rE5uLts";
$lang['groupbythread'] = "gr0uP By THRE@D";
$lang['postsfromuser'] = "p0\$Ts frOm UsEr";
$lang['poststouser'] = "p0S+\$ +0 UsEr";
$lang['poststoandfromuser'] = "p0\$ts +O @nD FR0m U\$er";
$lang['searchfrequencyerror'] = "j00 C4N 0Nly S34RCh 0nC3 EVErY %s sEC0nDs. PlEA5e +RY @941N L4+3R.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sEleC+";
$lang['searchforthread'] = "se@RCH FoR +HR34d";
$lang['mustspecifytypeofsearch'] = "j00 MUst 5P3c1PHY +YP3 Oph \$3@RCh +O PErPhorM";
$lang['unkownsearchtypespecified'] = "uNKnoWn \$34RcH TYp3 SpEc1PHI3D";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rec3N+ THre@D\$";
$lang['startreading'] = "s+@r+ R34D1ng";
$lang['threadoptions'] = "tHr3aD OP+i0ns";
$lang['editthreadoptions'] = "eDIT thr3@D 0PTionS";
$lang['morevisitors'] = "moRE v1S1+0r\$";
$lang['forthcomingbirthdays'] = "f0RThC0m1n9 BIR+Hd@Ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c4N ediT +h1S Pa9E FRom thE @Dm1n 1Nt3rPH@cE";
$lang['uploadstartpage'] = "uPlO4d St@rt PA9e (%s)";
$lang['invalidfiletypeerror'] = "file +yp3 NOt supp0R+3D. J00 C@N 0nLy usE %s fIl3s 45 y0ur St@rt P493.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3W dISCu\$s10N";
$lang['createpoll'] = "cr3at3 POlL";
$lang['search'] = "se4RCh";
$lang['searchagain'] = "s3@RCH 494In";
$lang['alldiscussions'] = "aLl d1\$cU\$SIOnS";
$lang['unreaddiscussions'] = "uNre4d D15cUssiON\$";
$lang['unreadtome'] = "uNre4D &quot;+0: M3&quot;";
$lang['todaysdiscussions'] = "t0d@y's D1\$CU5\$I0n\$";
$lang['2daysback'] = "2 D4yS b4CK";
$lang['7daysback'] = "7 d4ys bACk";
$lang['highinterest'] = "h19H In+3R35+";
$lang['unreadhighinterest'] = "unrE4D H1gH 1N+3R3st";
$lang['iverecentlyseen'] = "i've REC3n+LY \$EEn";
$lang['iveignored'] = "i'v3 1Gn0RED";
$lang['byignoredusers'] = "bY iGNOrED U\$ERS";
$lang['ivesubscribedto'] = "i'v3 SUBscr1BED To";
$lang['startedbyfriend'] = "sT@r+3D By Fr13nd";
$lang['unreadstartedbyfriend'] = "unrEaD 5tD by fRIEnD";
$lang['startedbyme'] = "s+@r+3D BY M3";
$lang['unreadtoday'] = "uNr34D Tod4Y";
$lang['deletedthreads'] = "d3l3tED +HRE4ds";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "f0lDEr 1NTEr3\$+";
$lang['postnew'] = "p0st N3W";
$lang['currentthread'] = "cUrRen+ +Hr34D";
$lang['highinterest'] = "h19H iN+3Re\$+";
$lang['markasread'] = "m4rk 4s RE4d";
$lang['next50discussions'] = "n3x+ 50 Di\$cU\$SIOnS";
$lang['visiblediscussions'] = "v1\$1BL3 d15CUssIOn\$";
$lang['selectedfolder'] = "s3leCtED PHolD3R";
$lang['navigate'] = "n4V19@+e";
$lang['couldnotretrievefolderinformation'] = "tH3rE @rE No FolD3R\$ aV41L4Bl3.";
$lang['nomessagesinthiscategory'] = "nO m3ss4Ge\$ IN THI5 C4+390RY. Pl34s3 53l3Ct 4N0TheR, 0R";
$lang['clickhere'] = "cLiCk her3";
$lang['forallthreads'] = "f0R 4ll +HR34d\$";
$lang['prev50threads'] = "pRevI0u5 50 +HR3@D5";
$lang['next50threads'] = "nex+ 50 +Hr34D5";
$lang['nextxthreads'] = "n3X+ %s +HRE4Ds";
$lang['threadstartedbytooltip'] = "tHR34D #%s st4r+3D 8y %s. vi3w3D %s";
$lang['threadviewedonetime'] = "1 +1m3";
$lang['threadviewedtimes'] = "%d +1m3s";
$lang['unreadthread'] = "unreAD THrE4d";
$lang['readthread'] = "r34D +HRE4D";
$lang['unreadmessages'] = "unrE4D MEs\$4GE\$";
$lang['subscribed'] = "su8sCR1B3d";
$lang['ignorethisfolder'] = "iGNore tHIs PholD3R";
$lang['stopignoringthisfolder'] = "s+Op 19n0R1N9 TH1\$ f0lDEr";
$lang['stickythreads'] = "stiCky +HrE4d\$";
$lang['mostunreadposts'] = "moS+ UnRE@D p0\$+\$";
$lang['onenew'] = "%d n3W";
$lang['manynew'] = "%d n3W";
$lang['onenewoflength'] = "%d N3w 0pH %d";
$lang['manynewoflength'] = "%d n3w of %d";
$lang['ignorefolderconfirm'] = "ar3 J00 \$urE J00 WAN+ +0 I9n0RE tHI5 PHoLd3r?";
$lang['unignorefolderconfirm'] = "aR3 J00 \$urE J00 w4nt +0 s+0p 1GNoR1N9 +Hi5 f0lD3r?";
$lang['gotofirstpostinthread'] = "go +0 f1rSt p0s+ IN ThR34D";
$lang['gotolastpostinthread'] = "g0 +O l4S+ P0\$+ 1n +HRE4d";
$lang['viewmessagesinthisfolderonly'] = "v13w ME\$\$@G3s 1n TH1\$ PHolDEr OnlY";
$lang['shownext50threads'] = "sH0W nEx+ 50 THrE4D\$";
$lang['showprev50threads'] = "show pReVi0U5 50 THr3@D\$";
$lang['createnewdiscussioninthisfolder'] = "cR34tE NEW D1\$cUs\$ION 1N THI5 PHoLD3r";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0ld";
$lang['italic'] = "iT4Lic";
$lang['underline'] = "uNDErliN3";
$lang['strikethrough'] = "sTRIk3tHrOu9h";
$lang['superscript'] = "sUpersCR1P+";
$lang['subscript'] = "sub\$cRip+";
$lang['leftalign'] = "lEft-Al1gN";
$lang['center'] = "c3N+ER";
$lang['rightalign'] = "rI9h+-@L1Gn";
$lang['numberedlist'] = "nUMb3R3D lI5+";
$lang['list'] = "l1\$+";
$lang['indenttext'] = "ind3n+ tExT";
$lang['code'] = "code";
$lang['quote'] = "qUo+e";
$lang['spoiler'] = "spOIl3r";
$lang['horizontalrule'] = "h0R1Z0N+4L rULE";
$lang['image'] = "iM49e";
$lang['hyperlink'] = "hyp3RlinK";
$lang['noemoticons'] = "d1\$48lE 3Mo+IC0ns";
$lang['fontface'] = "font Ph@Ce";
$lang['size'] = "sIze";
$lang['colour'] = "c0l0Ur";
$lang['red'] = "r3d";
$lang['orange'] = "oRANgE";
$lang['yellow'] = "y3llow";
$lang['green'] = "grE3N";
$lang['blue'] = "blUE";
$lang['indigo'] = "iNdiGo";
$lang['violet'] = "v10LEt";
$lang['white'] = "wHI+3";
$lang['black'] = "bL@Ck";
$lang['grey'] = "gR3y";
$lang['pink'] = "p1nk";
$lang['lightgreen'] = "l1ghT Gr3En";
$lang['lightblue'] = "lI9ht BLU3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0RUm St4tS";
$lang['usersactiveinthepasttimeperiod'] = "%s @C+Iv3 1N tEH P45+ %s.";

$lang['numactiveguests'] = "<b>%s</b> 9u3s+5";
$lang['oneactiveguest'] = "<b>1</b> GuEst";
$lang['numactivemembers'] = "<b>%s</b> MEmB3rS";
$lang['oneactivemember'] = "<b>1</b> MEm8er";
$lang['numactiveanonymousmembers'] = "<b>%s</b> AnoNym0U5 M3M8eR5";
$lang['oneactiveanonymousmember'] = "<b>1</b> @n0NyMOUs m3mber";

$lang['numthreadscreated'] = "<b>%s</b> +hRe4d\$";
$lang['onethreadcreated'] = "<b>1</b> tHr34D";
$lang['numpostscreated'] = "<b>%s</b> pos+s";
$lang['onepostcreated'] = "<b>1</b> p0\$+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nV1\$iBl3)";
$lang['viewcompletelist'] = "vIew c0MpL3te L15+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUR m3m8Er5 H4ve M@DE @ Tot4L Of %s 4nD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lOn93ST tHRe4D IS <b>%s</b> WI+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3rE H@V3 BEeN <b>%s</b> p0s+5 M4dE iN TEh L4\$+ 60 M1nuTEs.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "theR3 h@5 83En <b>1</b> po\$+ M@DE IN T3H l4sT 60 MiNuTes.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m0s+ pO\$+5 EvEr m4D3 1N a \$INglE 60 m1NUTE PeRiOD I5 <b>%s</b> On %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "wE H@V3 <b>%s</b> reg1StEr3d MEM8eR\$ 4nD THe n3W3st M3mbER IS <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "we h4vE %s rEG1s+3reD MEMB3Rs.";
$lang['wehaveoneregisteredmember'] = "w3 H@V3 0n3 r3gI5T3r3d mem8er.";
$lang['mostuserseveronlinewasnumondate'] = "moS+ U\$ER\$ 3VeR 0nL1N3 W4\$ <b>%s</b> On %s.";
$lang['statsdisplayenabled'] = "s+4+s D1sPL@y En@8lED";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "Updates saved successfully";
$lang['useroptions'] = "useR 0P+I0NS";
$lang['markedasread'] = "m4Rk3D @\$ Re4D";
$lang['postsoutof'] = "po5+s 0Ut OpH";
$lang['interest'] = "int3ReS+";
$lang['closedforposting'] = "cLos3d pH0R P0s+1n9";
$lang['locktitleandfolder'] = "l0cK t1+l3 4nD folDER";
$lang['deletepostsinthreadbyuser'] = "d3l3+3 po\$+S 1n +HRE4D By Us3R";
$lang['deletethread'] = "dEL3+3 +hR34d";
$lang['permenantlydelete'] = "pErmen4n+ly D3l3TE";
$lang['movetodeleteditems'] = "mOve +0 DEL3+3d +HRE4D\$";
$lang['undeletethread'] = "und3l3+3 +HR3@D";
$lang['threaddeletedpermenantly'] = "tHr3@d DEL3T3d PeRm@N3N+LY. c4NnOt UnDEl3+E.";
$lang['markasunread'] = "m4Rk @\$ uNrE4D";
$lang['makethreadsticky'] = "m@k3 +HR3@D s+ICKY";
$lang['threareadstatusupdated'] = "tHr34D R34D 5T4TUs UPD4tED SuCCE55fULlY";
$lang['interestupdated'] = "tHre@D 1N+3r3s+ St4TUs UPD4+3D 5Ucc3SSphULlY";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1ct1On@Ry";
$lang['spellcheck'] = "sPelL Ch3ck";
$lang['notindictionary'] = "nOT 1n d1c+1on4rY";
$lang['changeto'] = "ch4nG3 T0";
$lang['restartspellcheck'] = "r3\$t4R+";
$lang['cancelchanges'] = "c4nC3l Ch4nGeS";
$lang['initialisingdotdotdot'] = "ini+14lIsiN9...";
$lang['spellcheckcomplete'] = "sp3lL CHEcK i5 C0MpL3tE. TO rE\$+4R+ \$PelL CH3cK CL1CK R35+4r+ Bu+T0N 8el0w.";
$lang['spellcheck'] = "sp3lL Ch3ck";
$lang['noformobj'] = "n0 pHOrm o8Jec+ sP3c1pHi3d PHOr RE+UrN +3x+";
$lang['bodytext'] = "b0dY +Ex+";
$lang['ignore'] = "iGn0r3";
$lang['ignoreall'] = "igNoR3 4LL";
$lang['change'] = "chanG3";
$lang['changeall'] = "cH4ngE @Ll";
$lang['add'] = "add";
$lang['suggest'] = "sU9ge\$+";
$lang['nosuggestions'] = "(n0 5U9G3stI0ns)";
$lang['cancel'] = "c@nceL";
$lang['dictionarynotinstalled'] = "n0 diCtioN4rY H4S 83En in\$+@Lled. pL3@53 CONt4cT TEH FoRum 0wN3r T0 r3mEDy tH15.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0st r3@DiN9 @LL0wED";
$lang['postcreationallowed'] = "p0St CRe4t1oN 4lLOwED";
$lang['threadcreationallowed'] = "tHRE4D CrE@+1oN 4llOwED";
$lang['posteditingallowed'] = "pOST 3Di+IN9 4lL0W3D";
$lang['postdeletionallowed'] = "pOs+ D3l3t1oN @lLoWeD";
$lang['attachmentsallowed'] = "a+T4ChM3n+S @LL0WEd";
$lang['htmlpostingallowed'] = "hTmL PosT1n9 4lL0W3d";
$lang['signatureallowed'] = "s19N4tUR3 @lL0wED";
$lang['guestaccessallowed'] = "gue\$+ @CC3\$S 4LlOw3D";
$lang['postapprovalrequired'] = "pos+ @PprOv@L R3qU1rED";

// RSS feeds gubbins

$lang['rssfeed'] = "r5s PhEED";
$lang['every30mins'] = "eV3Ry 30 m1NUtE\$";
$lang['onceanhour'] = "oNcE @N HoUr";
$lang['every6hours'] = "eV3ry 6 HoUR\$";
$lang['every12hours'] = "every 12 HOuR\$";
$lang['onceaday'] = "onc3 4 D@Y";
$lang['rssfeeds'] = "rS5 Ph3ED5";
$lang['feedname'] = "fe3D n@M3";
$lang['feedfoldername'] = "f33d f0LdEr N@m3";
$lang['feedlocation'] = "fe3D lOc@Ti0n";
$lang['threadtitleprefix'] = "thRE4d +I+L3 pR3fIx";
$lang['feednameandlocation'] = "f33d N4mE ANd LOC4+1oN";
$lang['feedsettings'] = "f33D 53++1N9\$";
$lang['updatefrequency'] = "upd4T3 frEQUEnCY";
$lang['rssclicktoreadarticle'] = "cliCk H3rE +O R3ad +HI\$ @rT1Cl3";
$lang['addnewfeed'] = "aDD neW F3Ed";
$lang['editfeed'] = "ed1T F3eD";
$lang['feeduseraccount'] = "f33d UsER 4CC0un+";
$lang['noexistingfeeds'] = "nO 3xis+1NG R\$s Ph33d5 PHoUnd. +0 4Dd 4 fEED PLe4se CLICK +hE but+0n 8EloW";
$lang['rssfeedhelp'] = "h3rE j00 C4n 53+Up SoM3 RS5 pH33Ds F0R 4uT0m4+1c PR0p@G@+1on IN+0 Y0Ur f0rUm. TEh i+3ms PhRom t3h R\$s FEEd5 J00 @Dd wiLl 83 crE4ted @\$ thr34D5 whICH Users C4N r3plY +O 4s iPH +HEY wErE noRm4L P05+S. tH3 rs5 pH3Ed mU\$+ 8E 4Cce\$SI8le v14 hT+P or I+ WiLL n0+ woRk.";
$lang['mustspecifyrssfeedname'] = "mUSt sP3C1FY R5\$ ph33D N@M3";
$lang['mustspecifyrssfeeduseraccount'] = "muS+ sp3c1FY R\$5 Ph33d Us3R 4cC0UnT";
$lang['mustspecifyrssfeedfolder'] = "mus+ \$P3c1PhY R\$s pHEED PHolDER";
$lang['mustspecifyrssfeedurl'] = "mUst sP3C1PHY R5\$ ph33D URl";
$lang['mustspecifyrssfeedupdatefrequency'] = "mU5+ 5PECIpHy Rss ph33D UpdA+3 PHREQU3ncY";
$lang['unknownrssuseraccount'] = "unknoWn Rs\$ US3r @ccoUn+";
$lang['rssfeedsupportshttpurlsonly'] = "rsS pHE3D \$upP0RTs HTTP URl5 OnLy. S3cUr3 Ph33D\$ (hTTPS://) 4rE Not \$uppOrTeD.";
$lang['rssfeedurlformatinvalid'] = "r5s F33D Url F0rM4+ Is iNv@l1D. Url MU\$t 1nClUDE \$chEm3 (3.9. HtTP://) 4ND 4 H0s+n@M3 (3.9. WWW.hos+N4ME.C0M).";
$lang['rssfeeduserauthentication'] = "r5s f33d Do35 NO+ sUpPoR+ H+Tp UsER 4U+H3n+IC4t1On";
$lang['successfullyremovedselectedfeeds'] = "sUcC3ssPHuLly rEM0vED seL3cTED pH3eds";
$lang['successfullyaddedfeed'] = "succ3s5fUlLy @DDED NeW FEeD";
$lang['successfullyeditedfeed'] = "suCCes5fulLy EDi+3D PH33d";
$lang['failedtoremovefeeds'] = "f4iL3D t0 Rem0vE 5oME 0r @ll 0F +HE \$elEc+3D FE3D\$";
$lang['failedtoaddnewrssfeed'] = "f@1L3D +o adD N3W R5s F3eD";
$lang['failedtoupdaterssfeed'] = "f@1l3d TO UpD4tE R\$5 PH33D";
$lang['rssstreamworkingcorrectly'] = "r\$\$ S+r3@M 4pPE4R\$ +O Be wOrK1nG CoRrEC+LY";
$lang['rssstreamnotworkingcorrectly'] = "rs\$ \$+rEaM W@5 EMp+Y oR COuLD n0t 8E FoUnd";
$lang['invalidfeedidorfeednotfound'] = "inv4LiD pH33D ID 0r FE3d NoT f0unD";

// PM Export Options

$lang['pmexportastype'] = "eXp0RT @\$ +YPE";
$lang['pmexporthtml'] = "h+ML";
$lang['pmexportxml'] = "xMl";
$lang['pmexportplaintext'] = "pLa1N T3X+";
$lang['pmexportmessagesas'] = "eXp0R+ M3\$S@G35 @5";
$lang['pmexportonefileforallmessages'] = "oN3 F1lE f0r 4Ll M3s5@9e\$";
$lang['pmexportonefilepermessage'] = "oNe F1L3 PEr M3s\$@GE";
$lang['pmexportattachments'] = "eXPort @TtAChMEn+\$";
$lang['pmexportincludestyle'] = "iNcLuDE F0rum S+yLE She3+";
$lang['pmexportwordfilter'] = "applY WOrD Fil+3R TO M3s\$@g35";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHrE4d H@5 833N \$pL1+";
$lang['threadhasbeenmerged'] = "tHre4d H@\$ be3n M3R9eD";
$lang['mergesplitthread'] = "m3R9E / SpLI+ ThR34d";
$lang['mergewiththreadid'] = "m3r9E wITH THR34d 1D:";
$lang['postsinthisthreadatstart'] = "pOsTs 1N THIs ThrE@D @T S+@rT";
$lang['postsinthisthreadatend'] = "p0sts 1n TH1\$ tHr34D 4T eND";
$lang['reorderpostsintodateorder'] = "r3-OrDER P0sts 1NTo D4+e oRDER";
$lang['splitthreadatpost'] = "spL1t ThR34D @+ p0\$+:";
$lang['selectedpostsandrepliesonly'] = "sEleC+ED Po\$+ @ND REPl135 0nLY";
$lang['selectedandallfollowingposts'] = "sEl3c+3D @ND 4lL PHoLloW1n9 PO\$+\$";

$lang['threadmovedhere'] = "hER3";

$lang['thisthreadhasmoved'] = "<b>tHR3aDS M3rGEd:</b> th1\$ +Hr34D h@\$ MovED %s";
$lang['thisthreadwasmergedfrom'] = "<b>thr34D5 m3R9eD:</b> Th15 +HR34D W4\$ Merg3D PHROm %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thR34D \$pL1+:</b> \$0ME P0\$+s 1N TH15 tHR34D H4V3 8E3N mOv3D %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHR34D spl1+:</b> 5om3 PostS 1n TH1s +HR34d WER3 Mov3d fR0m %s";

$lang['thisposthasbeenmoved'] = "<b>tHRE4d Spl1t:</b> TH15 p05+ h4S BeEN MOv3D %s";

$lang['invalidfunctionarguments'] = "iNv@LiD FuNC+I0n @RgUmEN+\$";
$lang['couldnotretrieveforumdata'] = "c0Uld NOt RETRI3ve PHOrUm d4+4";
$lang['cannotmergepolls'] = "one 0R m0rE tHrE@d\$ I\$ @ P0Ll. J00 c4NNoT M3rg3 POll\$";
$lang['couldnotretrievethreaddatamerge'] = "c0uld n0T Re+rI3vE thr34d DAta PHrOm 0n3 0r m0R3 +hReaDS";
$lang['couldnotretrievethreaddatasplit'] = "c0ULD n0t r3Tr13ve tHR34D D4+@ phrOM \$OUrc3 +hR3@D";
$lang['couldnotretrievepostdatamerge'] = "cOUlD nO+ R3+rI3V3 P0sT d@+@ pHr0M 0NE or MOr3 +HREaDS";
$lang['couldnotretrievepostdatasplit'] = "cOulD n0T Re+RI3v3 P0s+ d@+4 fr0M \$0urC3 +hRe@D";
$lang['failedtocreatenewthreadformerge'] = "f@1LED +0 CrE4te n3W +HrE4D pH0R M3rGE";
$lang['failedtocreatenewthreadforsplit'] = "f@1l3D to cRe4te n3w THR3@D Ph0R 5PLI+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thR3@D sUBSCR1pti0ns";
$lang['couldnotupdateinterestonthread'] = "c0uLD N0t UPD4+E iN+3r3st on tHR3@d '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thRE4d 1NtERE5+\$ upD4TED sUCC3\$5fuLLy";
$lang['resetselected'] = "rE\$3+ 53l3cT3d";
$lang['allthreadtypes'] = "aLL +hr3@D +YPEs";
$lang['ignoredthreads'] = "i9nOr3D Thr3@dS";
$lang['highinterestthreads'] = "h1gh INt3R3s+ +hrEADS";
$lang['subscribedthreads'] = "su8ScRI8ED +HR34ds";
$lang['currentinterest'] = "cURrEnt IN+3R3st";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 Can 0Nly 4DD 3 c0LUmN5. +0 4DD 4 n3W c0LUmN Cl0s3 @N 3xi5+INg 0nE";
$lang['columnalreadyadded'] = "j00 HAvE @LR34dY 4dD3d +Hi5 c0LuMn. 1Ph J00 WANT +o REm0vE I+ Cl1Ck iT'\$ CL053 Bu++ON";

?>