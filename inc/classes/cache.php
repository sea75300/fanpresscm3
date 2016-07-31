<?php
    /**
     * FanPress CM cache class
     * 
     * Cache system
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\classes;

    /**
     * Cache system
     * 
     * @package fpcm.classes.cache
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    final class cache {
        
        /**
         * kodierter Cache-Datei-Name als MD5-Hash
         * @var string
         */
        private $cacheName;
        
        /**
         * Cache-Datei-Pfad inkl. Name
         * @var string
         */
        private $fileName;

        /**
         * Cache-Inhalt
         * @var mixed
         */
        private $data;
        
        /**
         * Zeitpunkt des Verfalls
         * @var int
         */
        private $expirationTime;

        /**
         * Der Konstruktur
         * @param string $cacheName
         */
        public function __construct($cacheName = null) {
            $this->cacheName = $this->initCacheName($cacheName);
            
            if (!is_null($this->cacheName)) {
                $this->fileName = baseconfig::$cacheDir.$this->cacheName.'.cache';

                if (file_exists($this->fileName)) {
                    $data = unserialize(base64_decode(file_get_contents($this->fileName)));
                    $this->data = $data['data'];
                    $this->expirationTime = $data['expires'];
                }
            }
        }
        
        /**
         * Gibt Dateiname von aktuellem Cache zurück
         * @return string
         */
        public function getCacheFileName() {
            return $this->fileName;
        }

        /**
         * Ist Cache-Inhalt veraltet
         * @return bool
         */
        public function isExpired() {
            if (defined('FPCM_INSTALLER_NOCACHE') && FPCM_INSTALLER_NOCACHE) return true;
            
            return ($this->expirationTime <= time() || !file_exists($this->fileName)) ?  true : false;
        }

        /**
         * Cache-Inhalt schreiben
         * @param mixed $data
         * @param int $expires
         */
        public function write($data, $expires = 0) {
            if (defined('FPCM_INSTALLER_NOCACHE') && FPCM_INSTALLER_NOCACHE) return false;
            
            if (!is_null($this->fileName)) {
                file_put_contents($this->fileName, base64_encode(serialize(array('data' => $data,'expires' => time() + $expires))));
            }
        }
        
        /**
         * Cache-Inhalt lesen
         * @return string
         */
        public function read() {
            if (!is_null($this->fileName) && file_exists($this->fileName)) { 
                $data = unserialize(base64_decode(file_get_contents($this->fileName)));
                return $data['data'];
            }
            
            return '';
        }
        
        /**
         * Cache-Inhalt leeren
         * @param string $path
         * @return bool
         */
        public function cleanup($path = false) {
            $cacheFiles = $path ? glob(baseconfig::$cacheDir.'/'.$this->initCacheName($path).'.cache') : glob(baseconfig::$cacheDir.'/*.cache');

            if (!is_array($cacheFiles) || !count($cacheFiles)) return false;
            
            foreach ($cacheFiles as $cacheFile) {
                if (file_exists($cacheFile)) {
                    unlink($cacheFile);
                }
            }
 
            return true;
        }
        
        /**
         * Gibt aktuelle Größe des Caches in byte zurück
         * @return int
         */
        public function getSize() {            
            return array_sum(array_map('filesize', glob(baseconfig::$cacheDir.'/*.cache')));
        }

        /**
         * Gibt Zeitspanne zurück, bis Cache verfällt
         * @return int
         * @since FPCM 3.3
         */
        function getExpirationTime() {
            return $this->expirationTime;
        }
        
        /**
         * Cache-Name verschlüsseln
         * @param string $cacheName
         * @return string
         */
        protected function initCacheName($cacheName) {
            
            if (is_null($cacheName)) return null;

            if (defined('FPCM_CACHE_DEBUG') && FPCM_CACHE_DEBUG) {
                return strtolower($cacheName);
            }
            
            return md5(strtolower($cacheName));
        }

    }

?>