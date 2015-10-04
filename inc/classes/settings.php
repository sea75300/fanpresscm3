<?php
    /**
     * FanPress CM global settings model
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\classes;

    /**
     * Global settings model
     * 
     * @package fpcm.classes.settings
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @property \fpcm\model\system\config $config Config-Objekt
     * @property language $language Sprach-Objekt
     * @property \fpcm\model\system\session $session Session-Objekt
     */     
    final class settings {
        
        /**
         * Data array for __get/__set
         * @var array
         */
        protected $data;

        /**
         * Konstruktor
         */
        public function __construct() {

            if (\fpcm\classes\baseconfig::installerEnabled()) return false;

            $this->config   = new \fpcm\model\system\config();
            $this->language = new \fpcm\classes\language($this->config->system_lang);
            $this->session  = new \fpcm\model\system\session();
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
        
    }
