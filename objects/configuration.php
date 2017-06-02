<?php

if (empty($global['systemRootPath'])) {
    $global['systemRootPath'] = "../";
}
require_once $global['systemRootPath'] . 'videos/configuration.php';
require_once $global['systemRootPath'] . 'objects/user.php';
require_once $global['systemRootPath'] . 'objects/functions.php';

class Configuration {

    private $id;
    private $video_resolution;
    private $webSiteTitle;
    private $language;
    private $contactEmail;
    private $users_id;
    private $version;
    private $authGoogle_id;
    private $authGoogle_key;
    private $authGoogle_enabled;
    private $authFacebook_id;
    private $authFacebook_key;
    private $authFacebook_enabled;
    private $authCanUploadVideos;
    private $authCanComment;

    private $ffprobeDuration;
    private $ffmpegImage;
    private $ffmpegMp4;
    private $ffmpegWebm;
    private $ffmpegMp4Portrait;
    private $ffmpegWebmPortrait;
    private $ffmpegMp3;
    private $ffmpegOgg;
    private $youtubedl;
    
    private $ffmpegPath;
    private $youtubeDlPath;
    
    private $exiftool;
    private $exiftoolPath;
    
    private $head;
    private $logo;
    private $logo_small;
    
    private $adsense;
    
    private $mode;    
    
    // version 2.7
    private $disable_analytics;    
    private $session_timeout;    
    private $encode_mp4;    
    private $encode_webm;    
    private $encode_mp3spectrum;
    private $ffmpegSpectrum;
    private $autoplay;
    
    function __construct($video_resolution="") {
        $this->load();
        if(!empty($video_resolution)){
            $this->video_resolution = $video_resolution;
        }
    }

    function load() {
        global $global;
        $sql = "SELECT * FROM configurations WHERE id = 1 LIMIT 1";
        //echo $sql;exit;
        $res = $global['mysqli']->query($sql);
        if ($res) {
            $config = $res->fetch_assoc();
            foreach ($config as $key => $value){
                $this->$key = $value;
            }
        } else {
            return false;
        }
        
    }

    function save() {
        global $global;
        if (!User::isAdmin()) {
            header('Content-Type: application/json');
            die('{"error":"' . __("Permission denied") . '"}');
        }
        $this->users_id = User::getId();
        
        
        
        $sql = "UPDATE configurations SET "
                . "video_resolution = '{$this->video_resolution}',"
                . "webSiteTitle = '{$this->webSiteTitle}',"
                . "language = '{$this->language}',"
                . "contactEmail = '{$this->contactEmail}',"
                . "users_id = '{$this->users_id}',  "
                . "authGoogle_id = '{$this->authGoogle_id}',"
                . "authGoogle_key = '{$this->authGoogle_key}',"
                . "authGoogle_enabled = '{$this->authGoogle_enabled}',"
                . "authFacebook_id = '{$this->authFacebook_id}',"
                . "authFacebook_key = '{$this->authFacebook_key}',"
                . "authFacebook_enabled = '{$this->authFacebook_enabled}',"
                . "authCanUploadVideos = '{$this->authCanUploadVideos}',"
                . "authCanComment = '{$this->authCanComment}',"
                . "ffmpegImage = '{$global['mysqli']->real_escape_string($this->getFfmpegImage())}',"
                . "ffmpegMp3 = '{$global['mysqli']->real_escape_string($this->getFfmpegMp3())}',"
                . "ffmpegMp4 = '{$global['mysqli']->real_escape_string($this->getFfmpegMp4())}',"
                . "ffmpegOgg = '{$global['mysqli']->real_escape_string($this->getFfmpegOgg())}',"
                . "ffmpegWebm = '{$global['mysqli']->real_escape_string($this->getFfmpegWebm())}',"
                . "ffmpegMp4Portrait = '{$global['mysqli']->real_escape_string($this->getFfmpegMp4Portrait())}',"
                . "ffmpegWebmPortrait = '{$global['mysqli']->real_escape_string($this->getFfmpegWebmPortrait())}',"
                . "ffprobeDuration = '{$global['mysqli']->real_escape_string($this->getFfprobeDuration())}',"
                . "youtubedl = '{$global['mysqli']->real_escape_string($this->getYoutubedl())}',"
                . "youtubedlPath = '{$global['mysqli']->real_escape_string($this->youtubeDlPath)}',"
                . "ffmpegPath = '{$global['mysqli']->real_escape_string($this->ffmpegPath)}',"
                . "head = '{$global['mysqli']->real_escape_string($this->getHead())}',"
                . "adsense = '{$global['mysqli']->real_escape_string($this->getAdsense())}',"
                . "mode = '{$this->getMode()}',"
                . "logo = '{$global['mysqli']->real_escape_string($this->getLogo())}',"
                . "logo_small = '{$global['mysqli']->real_escape_string($this->getLogo_small())}',"
                . "disable_analytics = '{$this->getDisable_analytics()}',"
                . "session_timeout = '{$this->getSession_timeout()}',"
                . "encode_mp4 = '{$this->getEncode_mp4()}',"
                . "encode_webm = '{$this->getEncode_webm()}',"
                . "encode_mp3spectrum = '{$this->getEncode_mp3spectrum()}',"
                . "ffmpegSpectrum = '{$global['mysqli']->real_escape_string($this->getFfmpegSpectrum())}',"
                . "autoplay = '{$global['mysqli']->real_escape_string($this->getAutoplay())}'"
                . "WHERE id = 1";
                

        $insert_row = $global['mysqli']->query($sql);

        if ($insert_row) {
            return true;
        } else {
            die($sql . ' Error : (' . $global['mysqli']->errno . ') ' . $global['mysqli']->error);
        }
    }
    
    function getVideo_resolution() {
        return $this->video_resolution;
    }

    function getUsers_id() {
        return $this->users_id;
    }

    function getVersion() {
        if(empty($this->version)){
            return " 0.1";
        }
        return $this->version;
    }
    
    function getWebSiteTitle() {
        return $this->webSiteTitle;
    }

    function getLanguage() {
        if($this->language == "en"){
            return "us";
        }
        return $this->language;
    }

    function getContactEmail() {
        return $this->contactEmail;
    }

    function setVideo_resolution($video_resolution) {
        $this->video_resolution = $video_resolution;
    }

    function setWebSiteTitle($webSiteTitle) {
        $this->webSiteTitle = $webSiteTitle;
    }

    function setLanguage($language) {
        $this->language = $language;
    }

    function setContactEmail($contactEmail) {
        $this->contactEmail = $contactEmail;
    }        
        
    function currentVersionLowerThen($version){
        return version_compare($version, $this->getVersion())>0;
    }    
    function currentVersionGreaterThen($version){
        return version_compare($version, $this->getVersion())<0;
    }
    function currentVersionEqual($version){
        return version_compare($version, $this->getVersion())==0;
    }


    function getAuthGoogle_id() {
        return $this->authGoogle_id;
    }

    function getAuthGoogle_key() {
        return $this->authGoogle_key;
    }

    function getAuthGoogle_enabled() {
        return intval($this->authGoogle_enabled);
    }

    function getAuthFacebook_id() {
        return $this->authFacebook_id;
    }

    function getAuthFacebook_key() {
        return $this->authFacebook_key;
    }

    function getAuthFacebook_enabled() {
        return intval($this->authFacebook_enabled);
    }

    function setAuthGoogle_id($authGoogle_id) {
        $this->authGoogle_id = $authGoogle_id;
    }

    function setAuthGoogle_key($authGoogle_key) {
        $this->authGoogle_key = $authGoogle_key;
    }

    function setAuthGoogle_enabled($authGoogle_enabled) {
        $this->authGoogle_enabled = intval($authGoogle_enabled);
    }

    function setAuthFacebook_id($authFacebook_id) {
        $this->authFacebook_id = $authFacebook_id;
    }

    function setAuthFacebook_key($authFacebook_key) {
        $this->authFacebook_key = $authFacebook_key;
    }

    function setAuthFacebook_enabled($authFacebook_enabled) {
        $this->authFacebook_enabled = intval($authFacebook_enabled);
    }

    function getAuthCanUploadVideos() {
        return $this->authCanUploadVideos;
    }

    function getAuthCanComment() {
        return $this->authCanComment;
    }

    function setAuthCanUploadVideos($authCanUploadVideos) {
        $this->authCanUploadVideos = $authCanUploadVideos;
    }

    function setAuthCanComment($authCanComment) {
        $this->authCanComment = $authCanComment;
    }

    function getFfprobeDuration() {
        if(empty($this->ffprobeDuration)){
            return 'ffprobe -i {$file} -sexagesimal -show_entries  format=duration -v quiet -of csv=\'p=0\'';
        }
        return $this->ffprobeDuration;
    }

    function getFfmpegImage() {
        if(empty($this->ffprobeDuration)){
            return 'ffmpeg -ss 5 -i {$pathFileName} -qscale:v 2 -vframes 1 -y {$destinationFile}';
        }
        return $this->ffmpegImage;
    }

    function getFfmpegMp4() {
        if(empty($this->ffmpegMp4)){
            return 'ffmpeg -i {$pathFileName} -vf scale={$videoResolution} -vcodec h264 -acodec aac -strict -2 -y {$destinationFile}';
        }
        return $this->ffmpegMp4;
    }

    function getFfmpegWebm() {
        if(empty($this->ffmpegWebm)){
            return 'ffmpeg -i {$pathFileName} -vf scale={$videoResolution} -f webm -c:v libvpx -b:v 1M -acodec libvorbis -y {$destinationFile}';
        }
        return $this->ffmpegWebm;
    }
    
    function getFfmpegMp4Portrait() {
        if(empty($this->ffmpegMp4Portrait)){
            return 'ffmpeg -i {$pathFileName} -lavfi \'[0:v]scale=ih*16/9:-1,boxblur=luma_radius=min(h\,w)/20:luma_power=1:chroma_radius=min(cw\,ch)/20:chroma_power=1[bg];[bg][0:v]overlay=(W-w)/2:(H-h)/2,crop=h=iw*9/16\' -vcodec h264 -acodec aac -strict -2 -y {$destinationFile}';
        }
        return $this->ffmpegMp4Portrait;
    }

    function getFfmpegWebmPortrait() {
        if(empty($this->ffmpegWebmPortrait)){
            return 'ffmpeg -i {$pathFileName} -lavfi \'[0:v]scale=ih*16/9:-1,boxblur=luma_radius=min(h\,w)/20:luma_power=1:chroma_radius=min(cw\,ch)/20:chroma_power=1[bg];[bg][0:v]overlay=(W-w)/2:(H-h)/2,crop=h=iw*9/16\' -f webm -c:v libvpx -b:v 1M -acodec libvorbis -y {$destinationFile}';
        }
        return $this->ffmpegWebmPortrait;
    }

    function getFfmpegMp3() {
        if(empty($this->ffmpegMp3)){
            return 'ffmpeg -i {$pathFileName} -acodec libmp3lame -y {$destinationFile}';
        }
        return $this->ffmpegMp3;
    }

    function getFfmpegOgg() {
        if(empty($this->ffmpegOgg)){
            return 'ffmpeg -i {$pathFileName} -acodec libvorbis -y {$destinationFile}';
        }
        return $this->ffmpegOgg;
    }

    function getYoutubedl() {
        if(empty($this->youtubedl)){
            return 'youtube-dl -o {$destinationFile} -f \'bestvideo[ext=mp4]+bestaudio[ext=m4a]/mp4\' {$videoURL}';
        }
        return $this->youtubedl;
    }

    function setFfprobeDuration($ffprobeDuration) {
        $this->ffprobeDuration = $ffprobeDuration;
    }

    function setFfmpegImage($ffmpegImage) {
        $this->ffmpegImage = $ffmpegImage;
    }

    function setFfmpegMp4($ffmpegMp4) {
        $this->ffmpegMp4 = $ffmpegMp4;
    }

    function setFfmpegWebm($ffmpegWebm) {
        $this->ffmpegWebm = $ffmpegWebm;
    }

    function setFfmpegMp3($ffmpegMp3) {
        $this->ffmpegMp3 = $ffmpegMp3;
    }

    function setFfmpegOgg($ffmpegOgg) {
        $this->ffmpegOgg = $ffmpegOgg;
    }

    function setYoutubedl($youtubedl) {
        $this->youtubedl = $youtubedl;
    }
    
    function setFfmpegPath($ffmpegPath) {
        $this->ffmpegPath = $ffmpegPath;
    }

    function setYoutubeDlPath($youtubeDlPath) {
        $this->youtubeDlPath = $youtubeDlPath;
    }
    
    function getFfmpegPath() {
        if(!empty($this->ffmpegPath)){
            if(substr($this->ffmpegPath, -1)!=="/"){
                $this->ffmpegPath .= "/";
            }
        }
        return $this->ffmpegPath;
    }

    function getYoutubeDlPath() {
        if(!empty($this->youtubeDlPath)){
            if(substr($this->youtubeDlPath, -1)!=="/"){
                $this->youtubeDlPath .= "/";
            }
        }
        return $this->youtubeDlPath;
    }

    function getExiftool() {
        if(empty($this->exiftool)){
            return 'exiftool {$pathFileName}';
        }
        return $this->exiftool;
    }

    function getExiftoolPath() {
        return $this->exiftoolPath;
    }

    function setExiftool($exiftool) {
        $this->exiftool = $exiftool;
    }

    function setExiftoolPath($exiftoolPath) {
        $this->exiftoolPath = $exiftoolPath;
    }

    function setFfmpegMp4Portrait($ffmpegMp4Portrait) {
        $this->ffmpegMp4Portrait = $ffmpegMp4Portrait;
    }

    function setFfmpegWebmPortrait($ffmpegWebmPortrait) {
        $this->ffmpegWebmPortrait = $ffmpegWebmPortrait;
    }

    function getHead() {
        if(empty($this->head)){
            /*
            return "
<script>
    // YouPHPTube Analytics
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-96597943-1', 'auto');
    ga('send', 'pageview');
</script>    
    ";
            */
        }        
        return $this->head;
    }

    function getLogo() {
        if(empty($this->logo)){
            return "view/img/logo138x30.png";
        }
        return $this->logo;
    }

    function setHead($head) {
        $this->head = $head;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    function getLogo_small() {
        if(empty($this->logo_small)){
            return "view/img/logo32.png";
        }
        return $this->logo_small;
    }

    function setLogo_small($logo_small) {
        $this->logo_small = $logo_small;
    }
    
    function getAdsense() {
        if(empty($this->adsense)){
            /*
            return '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- YouPHPTube -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-8404441263723333"
     data-ad-slot="3904005408"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';
             * 
             */
            
        }        
        return $this->adsense;
    }

    function setAdsense($adsense) {
        $this->adsense = $adsense;
    }

    function getMode() {
        if(empty($this->mode)){
            return 'Youtube';
        }
        return $this->mode;
    }

    function setMode($mode) {
        $this->mode = $mode;
    }

    // version 2.7
    function getDisable_analytics() {
        return $this->disable_analytics;
    }

    function getSession_timeout() {
        return $this->session_timeout;
    }

    function getEncode_mp4() {
        return $this->encode_mp4;
    }

    function getEncode_webm() {
        return $this->encode_webm;
    }

    function getEncode_mp3spectrum() {
        return $this->encode_mp3spectrum;
    }

    function setDisable_analytics($disable_analytics) {
        $this->disable_analytics = $disable_analytics=='true'?1:0;
    }

    function setSession_timeout($session_timeout) {
        $this->session_timeout = $session_timeout;
    }

    function setEncode_mp4($encode_mp4) {
        $this->encode_mp4 = $encode_mp4=='true'?1:0;
    }

    function setEncode_webm($encode_webm) {
        $this->encode_webm = $encode_webm=='true'?1:0;
    }

    function setEncode_mp3spectrum($encode_mp3spectrum) {
        $this->encode_mp3spectrum = $encode_mp3spectrum=='true'?1:0;
    }
    
    function getFfmpegSpectrum() {
        if(empty($this->ffmpegSpectrum)){
            return 'ffmpeg -i {$pathFileName} -filter_complex \'[0:a]showwaves=s=858x480:mode=line,format=yuv420p[v]\' -map \'[v]\' -map 0:a -c:v libx264 -c:a copy {$destinationFile}';
        }
        return $this->ffmpegSpectrum;
    }

    function setFfmpegSpectrum($ffmpegSpectrum) {
        $this->ffmpegSpectrum = $ffmpegSpectrum;
    }

    function getAutoplay() {
        return $this->autoplay;
    }

    function setAutoplay($autoplay) {
        $this->autoplay = $autoplay=='true'?1:0;
    }

            
    // end version 2.7



}
