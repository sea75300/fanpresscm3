<?php

error_reporting(0);

$controller = new fpcmWebInstaller();
$controller->process();

class fpcmWebInstaller {

    private $texts   = array();
    
    private $server  = 'http://nobody-knows.org/updatepools/fanpress/system/';
    
    private $imgcode = '<img src="data:image/png;base64,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" >';
    
    private $locaFileName = '';
    
    private $remoteFilePath = '';
    
    function __construct() {
        if (!(int) ini_get('allow_url_fopen')) {
            $this->texts[] = 'The webinstaller cannot be executed, because php setting "allow_url_fopen" does not allow connections to external servers!';
            $this->template();
        }

        if (version_compare(phpversion(), '5.4.0', '<')) {
            $this->texts[] = 'FanPress CM 3.x requires PHP version 5.4.0 or higher.';
            $this->template();
        }

        if (file_exists(__DIR__.'/fanpress/')) {
            $this->texts[] = 'This directory already contains a "fanpress"-directory!';
            $this->template();
        }
        
        if (!is_writable(__DIR__)) {
            $this->texts[] = 'This directory is not writable! Chmod write permissions until this message disappears.';
            $this->template();
        }
    }
    
    public function process() {

        if (!isset($_GET['download']) && PHP_SAPI != 'cli') {
            $this->texts = array(
                '<p><a href="?download">'.$this->imgcode.'</a></p>',
                '<p>Click the FanPress CM Logo to start the install package download!</p>'
            );
            $this->template();
            
            return true;
        }

        if (PHP_SAPI == 'cli') {
            $this->texts = array('FANPRESS CM NEWS SYSTEM Webinstaller');
        } else {
            $this->texts = array('<p>'.$this->imgcode.'</p>');            
        }
        

        $currentFileName    = $this->getCurrentFilename();
        $this->locaFileName = __DIR__.'/'.basename($currentFileName);;

        $executeNext = true;

        if (file_exists($this->locaFileName)) {
            $this->texts[] = 'This directory alreay contains a FanPress CM 3.x install package in <i>'.$this->locaFileName.'</i>!';
            $executeNext = false;
        }        

        if ($executeNext) {
            $executeNext = $this->getCurrentFile($currentFileName);
        }

        if ($executeNext) {
            $executeNext = $this->extractFile();
        }

        if ($executeNext && PHP_SAPI == 'cli') {
            $this->texts[] = 'Open you browser and visit your-domain.xyz/fanpress/index.php?module=installer to proceed with FanPress CM 3.x install assistent...';
        } elseif ($executeNext && PHP_SAPI != 'cli') {
            $this->texts[] = '<a href="fanpress/index.php?module=installer">Click here to continue to FanPress CM 3.x install assistent...</a>';
        }

        $this->template();
    }

    private function download($path) {
        return file_get_contents($path);
    }

    private function getCurrentFile($currentFileName) {

        $this->texts[] = "<p>Start download from <i>{$currentFileName}</i>... please wait...</p>";

        $content = $this->download($currentFileName);

        if (!$content) {
            $this->texts[] = "<p>Unable to download package file! Retry again later or download package file manually!</p>";
            return false;
        }

        if (!file_put_contents($this->locaFileName, $content)) {
            $this->texts[] = "<p>Unable to save install package file to <i>{$this->locaFileName}</i>!</p>";
            return false;
        }

        if (sha1_file($this->locaFileName) != sha1_file($currentFileName)) {
            $this->texts[] = "<p>Package checksum does not match! Please run webinstaller again or try manual installation!</p>";
            return false;
        }

        $this->texts[]  = "<p>Download successfull... continue...</p>";
        
        return true;
    }
    
    private function extractFile() {

        $archive = new ZipArchive();
        
        $this->texts[]  = "<p>Extracting install package <i>{$this->locaFileName}</i>...</p>";
        
        $res = $archive->open($this->locaFileName);
        if ($res !== true) {
            $this->texts[] = "<p>Unable to open install package archive! Error code: {$res}</p>";
            return false;
        }

        if ($archive->extractTo(__DIR__) !== true) {
            $this->texts[] = "<p>Unable to extract install package archive!</p>";
            return false;
        }
        
        $this->texts[]  = "<p>Extracting install sucessfull...</p>";
        
        return true;
    }

    private function getCurrentFilename() {
        
        $arr = array( 'webinstaller' => md5(uniqid().'$'.mt_rand(0, mt_getrandmax()).'$'.$_SERVER['HTTP_HOST']) );

        $this->texts[] = "<p>Fetch current version data... please wait...</p>";

        $currentVersion = $this->download($this->server.'server3.php?data='.str_rot13(base64_encode(json_encode($arr))));

        if (!$currentVersion) {
            $this->texts[] = "<p>Unable to fetch current version data from server!</p>";
            return false;
        }

        return base64_decode(str_rot13(base64_decode($currentVersion)));
    }

    private function template() {
        
        if (PHP_SAPI == 'cli') {
            die(strip_tags(implode(PHP_EOL, $this->texts)).PHP_EOL);
        }
        
        $html   = array();
        $html[] = '<html>';
        $html[] = '<head>';
        $html[] = '<title>FanPress CM 3.x Webinstaller</title>';
        $html[] = '<meta http-equiv="content-type" content= "text/html; charset=utf-8">';
        $html[] = '<meta name="robots" content="noindex, nofollow">';
        
        $html[] = '<style>';
        $html[] = 'body {font-size:10pt;font-family:sans-serif;background:-moz-linear-gradient(top,#ffffff 0%,#d0e3ed 50%,#d7e8f2 51%, #ffffff 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(50%,#d0e3ed), color-stop(51%,#d7e8f2), color-stop(100%,#ffffff));background: -webkit-linear-gradient(top, #ffffff 0%,#d0e3ed 50%,#d7e8f2 51%,#ffffff 100%);background:-ms-linear-gradient(top,#ffffff 0%,#d0e3ed 50%,#d7e8f2 51%,#ffffff 100%);background:linear-gradient(to bottom,#ffffff 0%,#d0e3ed 50%,#d7e8f2 51%,#ffffff 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#ffffff\',endColorstr=\'#ffffff\',GradientType=0);background-attachment:fixed;}';
        $html[] = 'i{color:#0048a9;}';
        
        $html[] = '</style>';
        
        $html[] = '</head>';

        $html[] = '<body>';
        
        $html[] = '<div style="text-align:center;margin-top:275px;">';
        

        $html   = array_merge($html, $this->texts);

        $html[] = '</div>';
        $html[] = '</body>';
        $html[] = '</html>';

        die(implode(PHP_EOL, $html));
    }
    
}