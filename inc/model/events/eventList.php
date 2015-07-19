<?php
    /**
     * FanPress CM event list model
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\events;

    /**
     * FanPress CM event list model
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.events
     */
    final class eventList {
        
        /**
         * Internal Event files
         * @var array
         */
        protected $events       = array();
        
        /**
         * Module events files
         * @var array 
         */
        protected $moduleEvents = array();

        /**
         * Konstruktor
         */
        public function __construct() {
            $this->getEvents();
            $this->initModuleEvents();
        }
        
        /**
         * Load event classes
         */
        private function getEvents() {
            
            if (\fpcm\classes\baseconfig::installerEnabled()) return false;
            
            $eventFiles = glob(\fpcm\classes\baseconfig::$incDir.'model/events/*.php');

            foreach ($eventFiles as $eventFile) {                
                if ($eventFile == __FILE__) continue;
                $this->events[] = basename($eventFile, '.php');
            }
        }

        /**
         * Load module event lists
         */
        private function initModuleEvents() {

            if (\fpcm\classes\baseconfig::installerEnabled()) return false;
            
            $eventFiles = glob(\fpcm\classes\baseconfig::$moduleDir."*/*/events/*.php");

            if (!$eventFiles || !count($eventFiles)) return array();
            
            foreach ($eventFiles as $eventFile) {
                $eventKey  = basename($eventFile, '.php');
                $moduleKey = \fpcm\model\abstracts\module::getModuleKeyByFolder($eventFile);
                $this->moduleEvents[$eventKey][] = $moduleKey;
            }
        }

        /**
         * Run event $eventName with params $dataParams
         * @param string $eventName
         * @param mixed $dataParams
         * @return mixed
         */
        public function runEvent($eventName, $dataParams = null) {

            if (!\fpcm\classes\baseconfig::dbConfigExists() || \fpcm\classes\baseconfig::installerEnabled()) return $dataParams;
            
            if (!in_array($eventName, $this->events)) {
                trigger_error('ERROR: Undefined event called: '.$eventName);
                return $dataParams;
            }
            
            if (!isset($this->moduleEvents[$eventName])) {
                return $dataParams;
            }
            
            /**
             * @var \fpcm\model\events\event
             */
            $eventClassName = "\\fpcm\\model\\events\\".$eventName;
            $event  = new $eventClassName($this->moduleEvents[$eventName]);
            
            if (!$event->checkPermissions()) {
                return $dataParams;
            }

            return $event->run($dataParams);            
        }
        
        /**
         * Gibt Liste mit Events des Systems zurück
         * @return array
         */
        public function getSystemEventList() {

            $list = array();
            foreach (glob(\fpcm\classes\baseconfig::$incDir.'model/events/*.php') as &$file) {                
                if ($file == __FILE__) continue;                
                $list[]  = basename($file, '.php');
            }
            
            return $list;
            
        }

    }
