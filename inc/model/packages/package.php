<?php
    /**
     * Package object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\packages;

    /**
     * System package objekt
     * 
     * @package fpcm.model.packages
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class package {
        
        /**
         * Fehler beim Abrufen der Update-Server-Infos
         */
        const FPCMPACKAGE_REMOTEFILE_ERROR  = -1;
        
        /**
         * Fehler beim Öffnen der lokalen Datei
         */
        const FPCMPACKAGE_LOCALFILE_ERROR   = -2;
        
        /**
         * Fehler beim Schreiben der Daten in die lokalen Datei
         */
        const FPCMPACKAGE_LOCALWRITE_ERROR  = -3;
        
        /**
         * Prüfung, dass Datei lokal vorhanden ist schlägt fehl
         */
        const FPCMPACKAGE_LOCALEXISTS_ERROR = -4;
        
        /**
         * Hash-Wert stimmt nicht überein
         */
        const FPCMPACKAGE_HASHCHECK_ERROR   = -5;
        
        /**
         * ZIP-Archiv kann nicht geöffnet werden
         */
        const FPCMPACKAGE_ZIPOPEN_ERROR     = -6;
        
        /**
         * Fehler beim Entpacken des ZIP-Archivs
         */
        const FPCMPACKAGE_ZIPEXTRACT_ERROR  = -7;
        
        /**
         * Fehler beim kopieren der Paket-Dateien
         */
        const FPCMPACKAGE_FILESCOPY_ERROR  = -8;
        
        /**
         * Packages-Unterordner auf Paket-Server
         */
        const FPCMPACKAGE_SERVER_PACKAGEPATH = 'packages/';
        
        /**
         * Pfad auf Paket-Server
         * @var string
         */
        protected $remoteFile   = '';
        
        /**
         * Datei-Hash auf Paket-Server
         * @var string
         */
        protected $remoteHash   = '';

        /**
         * Pfad zur lokalen Paket-Kopie
         * @var string
         */        
        protected $localFile    = '';
        
        /**
         * Datei-Hash auf lokalem Server
         * @var string
         */
        protected $localHash    = '';
        
        /**
         * Paket-Schlüssel
         * @var string
         */        
        protected $key          = '';
        
        /**
         * Paket-Version
         * @var string
         */        
        protected $version      = '';
        
        /**
         * Paket-Dateiname
         * @var string
         */
        protected $filename     = '';
        
        /**
         * lokaler Pfad zum Entpacken
         * @var string
         */
        protected $extractPath  = '';
        
        /**
         * Erweiterung des lokalen Pfades zum Entpacken
         * @var string
         */
        protected $copyDestination  = '/';

        /**
         * Paket-Type
         * * update -> FPCM System Update Paket
         * * module -> FPCM Modul Paket
         * @var string
         */
        protected $type         = '';

        /**
         * Paket-Inhalt
         * @var array
         */
        protected $data         = array();
        
        /**
         * Paket-Dateiliste
         * @var array
         */
        protected $files        = array();
        
        /**
         * Paket-Abhängigkeiten
         * @var array
         */
        protected $dependencies    = array();
        
        /**
         * ZIP-Archiv-Object
         * @var \ZipArchive
         */
        protected $archive;
        
        /**
         * temporäre Datei mit Dateiliste
         * @var string
         */
        protected $tempListFile = '';
        
        /**
         * Signatur-String, der vom Update-Server geschickt wurde
         * @var string
         */
        protected $remoteSignature = '';
        
        /**
         * Signatur-String, der lokal berechnet wurde
         * @var string
         */
        protected $localSignature    = '';

        /**
         * Konstruktor
         * @param string $key Package-Key
         * @param string $version Package-Version
         * @param string $type Package-Type
         * @param string $signature Package-Signature
         */
        public function __construct($type, $key, $version = '', $signature = '') {
            $this->type            = $type;
            $this->key             = $key;
            $this->version         = $version;
            $this->remoteSignature = $signature;
            $this->archive         = new \ZipArchive();
            
            $this->init();
        }
        
        /**
         * Magic get
         * @param string $name
         * @return mixed
         */
        public function __get($name) {
            return isset($this->data[$name]) ? $this->data[$name] : false;
        }
        
        /**
         * Magic set
         * @param mixed $name
         * @param mixed $value
         */
        public function __set($name, $value) {
            $this->data[$name] = $value;
        }
        
        /**
         * Gibt Pfad von Paketdatei auf Server zurück
         * @return string
         */
        public function getRemoteFile() {
            return $this->remoteFile;
        }

        /**
         * Gibt lokalen Pfad der Paketdatei zurück
         * @return string
         */
        public function getLocalFile() {
            return $this->localFile;
        }

        /**
         * Gibt Paketkey zurück
         * @return string
         */
        public function getKey() {
            return $this->key;
        }

        /**
         * Gibt Paketversion zurück
         * @return string
         */
        public function getVersion() {
            return $this->version;
        }

        /**
         * Gibt Dateiname zurück
         * @return string
         */
        public function getFilename() {
            return $this->filename;
        }

        /**
         * Gibt Pakettyp zurück
         * @return string
         */
        public function getType() {
            return $this->type;
        }

        /**
         * Gibt data-Eigenschaft zurück
         * @return mixed
         */
        public function getData() {
            return $this->data;
        }
        
        /**
         * Gibt Hashwert der Datei auf Server zurück
         * @return string
         */
        public function getRemoteHash() {
            return $this->remoteHash;
        }

        /**
         * Gibt lokalen Dateihash zurück
         * @return string
         */
        public function getLocalHash() {
            return $this->localHash;
        }

        /**
         * Gibt Entpacken-Pfad zurück
         * @return string
         */
        public function getExtractPath() {
            return $this->extractPath;
        }

        /**
         * Gibt enthaltene Datein zurück
         * @return string
         */
        public function getFiles() {
            return $this->files;
        }        

        /**
         * Gibt zusätzlichen Pfad für Kopierziel zurück
         * @return string
         */
        public function getCopyDestination() {
            return $this->copyDestination;
        }
        
        /**
         * Gibt Abhängigkeiten zurück
         * @return array
         */
        public function getDependencies() {
            return $this->dependencies;
        }

        /**
         * Setzt Paket-Key
         * @param string $key
         */
        public function setKey($key) {
            $this->key = $key;
        }

        /**
         * Setzt Paket-Version
         * @param string $version
         */
        public function setVersion($version) {
            $this->version = $version;
            $this->init();
        }

        /**
         * Setzt Paket-Typ
         * @param string $type
         */
        public function setType($type) {
            $this->type = $type;
            $this->init();
        }
        
        /**
         * Setzt zusätzliches Kopier-Ziel
         * @param string $copyDestination
         */
        public function setCopyDestination($copyDestination) {
            $this->copyDestination .= ltrim($copyDestination, '/');
        }
        
        /**
         * Setzt Abhängigkeiten
         * @param array $dependencies
         */
        public function setDependencies(array $dependencies) {
            $this->dependencies = $dependencies;
        }        
        
        /**
         * Lädt Package in Abhängigkeit von Einstellungen herunter
         * @return boolean
         */
        public function download() {
            
            $handleRemote = fopen($this->remoteFile, 'rb');
            
            if (!$handleRemote) {
                trigger_error('Unable to connect to remote server: '.$this->remoteFile);
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return self::FPCMPACKAGE_REMOTEFILE_ERROR;
            }
            
            if ($this->type == 'module' && !is_dir(dirname($this->localFile))) {
                if (!mkdir(dirname($this->localFile))) {
                    trigger_error('Unable to create module vendor folder: '.dirname($this->localFile));
                    \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                    return self::FPCMPACKAGE_LOCALFILE_ERROR;
                }
            }
            
            $handleLocal = fopen($this->localFile, 'wb');
            
            if (!$handleLocal) {
                trigger_error('Unable to open local file: '.$this->localFile);
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return self::FPCMPACKAGE_LOCALFILE_ERROR;
            }            
            
            while(!feof($handleRemote)) {
                if (fwrite($handleLocal, fgets($handleRemote)) === false) {
                    trigger_error("Error while writing content of {$this->remoteFile} to {$this->localFile}.");
                    \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                    return self::FPCMPACKAGE_LOCALEXISTS_ERROR;
                }
            }            
            
            fclose($handleRemote);
            fclose($handleLocal);
            
            if (!file_exists($this->localFile)) {
                trigger_error("Downloaded file not found in {$this->localFile}.");
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return self::FPCMPACKAGE_LOCALEXISTS_ERROR;
            }
            
            $res = $this->checkHashes();
            if ($res !== true) {
                return $res;
            }
            
            return true;
            
        }
        
        /**
         * Package entpacken
         * @return boolean
         */
        public function extract() {

            if ($this->archive->open($this->localFile) !== true) {
                trigger_error('Unable to open ZIP archive for extraction: '.$this->localFile);
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return self::FPCMPACKAGE_ZIPOPEN_ERROR;
            }
            
            $this->listArchiveFiles();
            
            if ($this->archive->extractTo($this->extractPath) !== true) {
                trigger_error('Unable to extract ZIP archive: '.$this->localFile);
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return self::FPCMPACKAGE_ZIPEXTRACT_ERROR;
            }
            
            return true;
            
        }

        /**
         * Kopiert Inhalt von Paket von Quelle nach Ziel
         * @return boolean
         */
        public function copy() {    
            
            if (!file_exists($this->tempListFile)) {
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return false;
            }
            
            $this->loadPackageFileListFromTemp();
            
            if (!count($this->files)) {
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return false;
            }
            
            $vendorFolder = \fpcm\classes\baseconfig::$baseDir.$this->copyDestination.dirname($this->key);
            if ($this->type == 'module' && !is_dir($vendorFolder) && !mkdir($vendorFolder) ) {
                trigger_error('Unable to create module vendor folder '.$vendorFolder);
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return false;
            }
            
            $res = true;
            foreach ($this->files as $zipFile) {
                $source = $this->extractPath.$zipFile;

                $dest   = ($this->type == 'module'
                        ? \fpcm\classes\baseconfig::$baseDir.$this->copyDestination.str_replace(basename($this->key).'/', $this->key.'/', $zipFile)
                        : dirname(\fpcm\classes\baseconfig::$baseDir).$this->copyDestination.$zipFile);

                $dest   = str_replace('fanpress/', basename(\fpcm\classes\baseconfig::$baseDir).'/', $dest);
                
                if (is_dir($source)) {
                    if (!file_exists($dest) && !mkdir($dest, 0777)) {
                        if (!is_array($res)) $res = array();
                        $res[] = $dest;
                    }
                    continue;
                }
                
                if (file_exists($dest) && sha1_file($source) == sha1_file($dest)) {
                    continue;
                }
                
                if (!copy($source, $dest)) {
                    if (!is_array($res)) $res = array();                    
                    $res[] = $dest;
                }
                
            }            
            
            return is_array($res) ? self::FPCMPACKAGE_FILESCOPY_ERROR : $res;
        }
        
        /**
         * Lädt Paket-Dateiliste aus temporärer Datei
         * @return boolean
         */
        public function loadPackageFileListFromTemp() {
            if (count($this->files)) {
                return true;
            }
            
            $this->files = json_decode(base64_decode(file_get_contents($this->tempListFile)), true);
            return true;
        }
        
        /**
         * Löscht temoräre Dateien
         */
        public function cleanup() {            
            if (!unlink($this->tempListFile)) {
                trigger_error('Unable to remove temp list file '.$this->tempListFile);
            }
            
            if (!unlink($this->localFile)) {
                trigger_error('Unable to delete local package copy '.$this->localFile);
            }
            
            if (!\fpcm\model\files\ops::deleteRecursive($this->extractPath)) {
                trigger_error('Package extraction path still exists in '.$this->extractPath);
            }
            
        }

        /**
         * Baut Datei-Liste aus Archiv auf
         */
        protected function listArchiveFiles() {
            for ($i = 0; $i < $this->archive->numFiles; $i++) {
                $this->files[] = $this->archive->getNameIndex($i);
            }
            
            file_put_contents($this->tempListFile, base64_encode(json_encode($this->files)));
        }

        /**
         * Initialisiert Daten
         */
        protected function init() {
            $this->filename     = $this->key.$this->version.'.zip';

            $this->remoteFile   = \fpcm\classes\baseconfig::$updateServer.self::FPCMPACKAGE_SERVER_PACKAGEPATH.$this->filename;
            $this->localFile    = \fpcm\classes\baseconfig::$tempDir.$this->filename;
            $this->extractPath  = dirname($this->localFile).'/'.md5(basename($this->localFile, '.zip')).'/';
            $this->tempListFile = \fpcm\classes\baseconfig::$tempDir.md5($this->localFile);
        }
        
        /**
         * Prüft ob Datei-Hashed und ggf. Datei-Signaturen übereinstimmen
         * @return boolean
         */
        protected function checkHashes() {
            $this->buildHashes();
            
            if ($this->remoteHash != $this->localHash) {
                trigger_error('Remote and local file hash do not match for '.$this->localFile);
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return self::FPCMPACKAGE_HASHCHECK_ERROR;
            }
            
            
            if ($this->remoteSignature != $this->localSignature) {
                trigger_error('Remote and local file hash do not match for '.$this->localFile);
                \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
                return self::FPCMPACKAGE_HASHCHECK_ERROR;
            }
            
            return true;
        }
        
        /**
         * Erzeugt Hashed und loale Datei-Signatur
         * @return void
         */
        protected function buildHashes() {
            $this->remoteHash = sha1_file($this->remoteFile);            
            $this->localHash  = sha1_file($this->localFile);
            
            if (!$this->remoteSignature) {
                return;
            }

            $this->localSignature = '$sig$'.md5_file($this->localFile).'_'.sha1_file($this->localFile).'$sig$';
        }
        
        /**
         * Ersetzt "fanpress"-Ordnername durch basedir-Daen in einem Pfad
         * @param string $path
         * @return string
         */
        protected function replaceFanpressDirString($path) {
            return str_replace('fanpress/', basename(\fpcm\classes\baseconfig::$baseDir).'/', $path);
        }

        /**
         * Dateiname/ Key der Form modulkey_versionX.Y.Z aufsplitten
         * @param string $filename
         * @return array
         */
        public static function explodeModuleFileName($filename) {            
            return explode('_version', $filename);            
        }

    }
