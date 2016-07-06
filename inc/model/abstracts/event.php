<?php
    /**
     * FanPress CM event model
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\abstracts;

    /**
     * Event model base
     * 
     * @package fpcm.model.abstracts
     * @abstract
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    abstract class event implements \fpcm\model\interfaces\event {

        /**
         *Event-Daten
         * @var array
         */
        protected $data;
        
        /**
         * Events mit aktuellem Event
         * @var array
         */
        protected $modules;
        
        /**
         * Liste mit aktiven Modulen
         * @var array
         */
        protected $activeModules = array();
        
        /**
         * Event-Cache
         * @var \fpcm\classes\cache
         */
        protected $cache;
        
        /**
         * Array mit zu prüfenden Berchtigungen
         * @var array
         */
        protected $checkPermission = array();
        
        /**
         * Berechtigungen
         * @var \fpcm\model\system\permissions
         */
        protected $permissions;

        /**
         * Konstruktor
         * @param array $modules
         * @return boolean
         */
        public function __construct($modules) {
            $this->modules = $modules;
            
            $moduleList = new \fpcm\model\modules\modulelist();
            
            $this->cache = new \fpcm\classes\cache('activeeventscache');
            
            if (\fpcm\classes\baseconfig::installerEnabled()) return false;
            
            $config = \fpcm\classes\baseconfig::$fpcmConfig;
            $config->setUserSettings();
            
            if ($this->cache->isExpired()) {
                $this->activeModules = $moduleList->getEnabledInstalledModules();
                $this->cache->write($this->activeModules, $config->system_cache_timeout);
            } else {
                $this->activeModules = $this->cache->read();
            }
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
         * Magische Methode für nicht vorhandene Methoden
         * @param string $name
         * @param mixed $arguments
         * @return boolean
         */
        public function __call($name, $arguments) {
            print "Function '{$name}' not found in ".get_class($this).'<br>';
            return false;
        }

        /**
         * Magische Methode für nicht vorhandene, statische Methoden
         * @param string $name
         * @param mixed $arguments
         * @return boolean
         */        
        public static function __callStatic($name, $arguments) {
            print "Static function '{$name}' not found in ".get_class($this).'<br>';
            return false;
        }
        
        /**
         * Gibt Module-Key anhand des Event-Datei-Pfades zurück
         * @param string $path
         * @return string
         */
        public function getModuleKeyByEvent($path) {
            return module::getModuleKeyByFolder($path);
        }
        
        /**
         * Prüft ob spezielle Berechtigungen für Event nötig sind
         * @return boolean
         */
        public function checkPermissions() {
            
            if (!$this->permissions || !count($this->checkPermission)) return true;
            
            return $this->permissions->check($this->checkPermission);
        }

        /**
         * Prüft, ob Modul-Event-Klasse von \fpcm\model\abstracts\moduleEvent abgeleitet ist
         * @param mixed $object
         * @return boolean
         */
        protected function is_a($object) {
            
            if (is_a($object, '\\fpcm\\model\\abstracts\\moduleEvent')) return true;
            
            trigger_error('Event object of class '.  get_class($object).' must be an instance of \\fpcm\\model\\interfaces\\event!');
            return false;
        }
        
        /**
         * Liefert Array mit Event-Klassen in installierten Modulen zurück
         * @return array
         * @since FPCM 3.3
         */
        protected function getEventClasses() {

            return glob(\fpcm\classes\baseconfig::$moduleDir.'*/*/events/'.str_replace('fpcm\\model\\events\\', '', get_class($this)).'.php');

        }
        
    }
