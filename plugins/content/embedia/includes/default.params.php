<?php
/**
 * @version 3.0.1
 * @package embedia(formerly mosEasyMedia)
 * @copyright Copyright &copy; 2009, Brilaps LLC
 * @author Ozgur Cem Sen
 * @email code@brilaps.com
 * @link http://brilaps.com || http://wiki.brilaps.com
 * @license http://www.opensource.org/licenses/gpl-license.php GNU/GPL v.2 .
 */


/**
 * Incase the params cannot be loaded from the db, this is a fallback class
 */
class DefaultParams 
{
	
	public static $params = "embedia_moseasymedia=yes
noscript=Please turn on javascript to view the media.	
embedia_Popup_popup=none
embedia_Popup_popupmediathumbnail=http://brilaps.appspot.com/images/popupthumbnail.jpg
embedia_Popup_popuplinktext=Click here to open in another window.
embedia_Popup_popupwidth=600
embedia_Popup_popupheight=480
embedia_Popup_popuptoolbar=no
embedia_Popup_popupmenubar=no
embedia_Popup_popupscrollbars=no
playerWindowsMediaPlayerVideo=WindowsMediaPlayerVideo
classidWindowsMediaPlayerVideo=CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6
codebaseWindowsMediaPlayerVideo=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=7,0,0,1954
pluginspageWindowsMediaPlayerVideo=http://www.microsoft.com/Windows/MediaPlayer/
embedia_UseJavascriptWindowsMediaPlayerVideo=1
embedia_ExtensionsWindowsMediaPlayerVideo=wmv|avi|mpg|mpeg|asf|asx
typeWindowsMediaPlayerVideo=application/x-ms-wmp
widthWindowsMediaPlayerVideo=560
heightWindowsMediaPlayerVideo=400
stretchtofitWindowsMediaPlayerVideo=1
autostartWindowsMediaPlayerVideo=1
playcountWindowsMediaPlayerVideo=1
volumeWindowsMediaPlayerVideo=50
embedia_CSSWindowsMediaPlayerVideo=embediaWindowsMediaPlayerVideo.css
embedia_MediaSharingWebsitesUsingWindowsMediaPlayerVideo=msn.com, microsoft.com
playerWindowsMediaPlayerAudio=WindowsMediaPlayerAudio
classidWindowsMediaPlayerAudio=CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6
codebaseWindowsMediaPlayerAudio=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=7,0,0,1954
pluginspageWindowsMediaPlayerAudio=http://www.microsoft.com/Windows/MediaPlayer/
embedia_UseJavascriptWindowsMediaPlayerAudio=1
embedia_ExtensionsWindowsMediaPlayerAudio=wav|wma|midi|mid|m3u
typeWindowsMediaPlayerAudio=application/x-ms-wmp
widthWindowsMediaPlayerAudio=320
heightWindowsMediaPlayerAudio=75
autostartWindowsMediaPlayerAudio=1
playcountWindowsMediaPlayerAudio=1
volumeWindowsMediaPlayerAudio=50
embedia_CSSWindowsMediaPlayerAudio=embediaWindowsMediaPlayerAudio.css
embedia_MediaSharingWebsitesUsingWindowsMediaPlayerAudio=
playerFlash=Flash
classidFlash=CLSID:d27cdb6e-ae6d-11cf-96b8-444553540000
codebaseFlash=http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0
pluginspageFlash=http://www.macromedia.com/go/getflashplayer
embedia_UseJavascriptFlash=1
embedia_ExtensionsFlash=swf
typeFlash=application/x-shockwave-flash
widthFlash=560
heightFlash=340
qualityFlash=Best
playFlash=strtrue
wmodeFlash=window
bgcolorFlash=#FFFFFF
loopFlash=strfalse
allowscriptaccessFlash=always
embedia_CSSFlash=embediaFlash.css
embedia_MediaSharingWebsitesUsingFlash=google.com, youtube.com
playerQuicktime=Quicktime
classidQuicktime=clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B
codebaseQuicktime=http://www.apple.com/qtactivex/qtplugin.cab
pluginspageQuicktime=http://www.apple.com/quicktime/download/
embedia_UseJavascriptQuicktime=1
embedia_ExtensionsQuicktime=mov|mp4
typeQuicktime=video/quicktime
widthQuicktime=560
heightQuicktime=400
scaleQuicktime=aspect
kioskmodeQuicktime=strtrue
cacheQuicktime=strtrue
autoplayQuicktime=strtrue
controllerQuicktime=strtrue
loopQuicktime=strfalse
volumeQuicktime=50
bgcolorQuicktime=#000
embedia_CSSQuicktime=embediaQuicktime.css
embedia_MediaSharingWebsitesUsingQuicktime=
playerRealPlayer=RealPlayer
classidRealPlayer=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA
codebaseRealPlayer=
pluginspageRealPlayer=http://www.real.com/products/player/
embedia_UseJavascriptRealPlayer=1
embedia_ExtensionsRealPlayer=ram|rv|rpm|ra
typeRealPlayer=audio/x-pn-realaudio-plugin
widthRealPlayer=560
heightRealPlayer=400
autostartRealPlayer=strtrue
controlsRealPlayer=ImageWindow
loopRealPlayer=strfalse
centerRealPlayer=strtrue
maintainaspectRealPlayer=strtrue
embedia_CSSRealPlayer=embediaRealPlayer.css
embedia_MediaSharingWebsitesUsingRealPlayer=
playerDivX=DivX
classidDivX=clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616
codebaseDivX=http://go.divx.com/plugin/DivXBrowserPlugin.cab
pluginspageDivX=http://go.divx.com/plugin/download/
embedia_UseJavascriptDivX=1
embedia_ExtensionsDivX=divx
typeDivX=video/divx
widthDivX=560
heightDivX=400
autoplayDivX=strtrue
modeDivX=mini
allowcontextmenuDivX=strtrue
loopDivX=strfalse
bufferingmodeDivX=null
previewimageDivX=
previewmessageDivX=Click to play the video
embedia_CSSDivX=embediaDivX.css
embedia_MediaSharingWebsitesUsingDivX=stage6.com
playerJWMediaPlayer=JWMediaPlayer
classidJWMediaPlayer=CLSID:d27cdb6e-ae6d-11cf-96b8-444553540000
codebaseJWMediaPlayer=http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0
pluginspageJWMediaPlayer=http://www.macromedia.com/go/getflashplayer
embedia_UseJavascriptJWMediaPlayer=1
embedia_ExtensionsJWMediaPlayer=xml|png|jpg|flv
typeJWMediaPlayer=application/x-shockwave-flash
widthJWMediaPlayer=560
heightJWMediaPlayer=400
displayheightJWMediaPlayer=260
logoJWMediaPlayer=
backcolorJWMediaPlayer=0xFFFFFF
frontcolorJWMediaPlayer=0x000000
lightJWMediaPlayer=0xFFFFFF
overstretchJWMediaPlayer=fit
shownavigationJWMediaPlayer=strtrue
autostartJWMediaPlayer=strtrue
volumeJWMediaPlayer=80
bufferlengthJWMediaPlayer=3
repeatJWMediaPlayer=list
largecontrolsJWMediaPlayer=strfalse
wmodeJWMediaPlayer=window
shuffleJWMediaPlayer=strfalse
allowscriptaccessJWMediaPlayer=always
CSSJWMediaPlayer=embediaJWMediaPlayer.css
embedia_MediaSharingWebsitesUsingJWMediaPlayer=
playerJWMP3Player=JWMP3Player
classidJWMP3Player=CLSID:d27cdb6e-ae6d-11cf-96b8-444553540000
codebaseJWMP3Player=http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0
pluginspageJWMP3Player=http://www.macromedia.com/go/getflashplayer
embedia_UseJavascriptJWMP3Player=1
embedia_ExtensionsJWMP3Player=cp3
typeJWMP3Player=application/x-shockwave-flash
widthJWMP3Player=300
heightJWMP3Player=24
logoJWMP3Player=
backcolorJWMP3Player=0xFFFFFF
frontcolorJWMP3Player=0x000000
lightJWMP3Player=0xFFFFFF
overstretchJWMP3Player=fit
shownavigationJWMP3Player=strtrue
autostartJWMP3Player=strtrue
volumeJWMP3Player=80
bufferlengthJWMP3Player=3
repeatJWMP3Player=list
largecontrolsJWMP3Player=strfalse
wmodeJWMP3Player=window
shuffleJWMP3Player=strfalse
CSSJWMP3Player=embediaJWMP3Player.css
allowscriptaccessJWMP3Player=always
embedia_MediaSharingWebsitesUsingJWMP3Player=
playerXSPFPlayer=XSPFPlayer
classidXSPFPlayer=CLSID:d27cdb6e-ae6d-11cf-96b8-444553540000
codebaseXSPFPlayer=http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0
pluginspageXSPFPlayer=http://www.macromedia.com/go/getflashplayer
embedia_UseJavascriptXSPFPlayer=1
embedia_ExtensionsXSPFPlayer=xspf|mp3
typeXSPFPlayer=application/x-shockwave-flash
widthXSPFPlayer=300
heightXSPFPlayer=140
player_titleXSPFPlayer=embedia mp3 player
info_button_textXSPFPlayer=
embedia_modeXSPFPlayer=extended
autoplayXSPFPlayer=strtrue
autoloadXSPFPlayer=strtrue
repeat_playlistXSPFPlayer=strfalse
CSSXSPFPlayer=embediaXSPFPlayer.css
embedia_MediaSharingWebsitesUsingXSPFPlayer=
";
	
}