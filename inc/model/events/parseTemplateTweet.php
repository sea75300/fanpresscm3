<?php
    /**
     * Module-Event: parseTemplateTweet
     * 
     * Event wird ausgeführt, wenn Tweet-Template geparst wird
     * Parameter: array mit Platzhaltern und zugewiesenen Daten
     * Rückgabe: array mit Platzhaltern und zugewiesenen Daten
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\events;

    /**
     * Module-Event: parseTemplateTweet
     * 
     * Event wird ausgeführt, wenn Tweet-Template geparst wird
     * Parameter: array mit Platzhaltern und zugewiesenen Daten
     * Rückgabe: array mit Platzhaltern und zugewiesenen Daten
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.events
     */
    final class parseTemplateTweet extends \fpcm\model\abstracts\event {

        /**
         * wird ausgeführt, wenn Tweet-Template geparst wird
         * @param array $data
         * @return array
         */
        public function run($data = null) {
            
            $eventClasses = glob(\fpcm\classes\baseconfig::$moduleDir.'*/*/events/parseTemplateTweet.php');
            
            if (!count($eventClasses)) return $data;
            
            $mdata = $data;
            foreach ($eventClasses as $eventClass) {
                
                $classkey = $this->getModuleKeyByEvent($eventClass);                
                if (!in_array($classkey, $this->activeModules)) continue;
                
                $eventClass = \fpcm\model\abstracts\module::getModuleEventNamespace($classkey, 'parseTemplateTweet');
                
                /**
                 * @var \fpcm\model\abstracts\event
                 */
                $module = new $eventClass();

                if (!$this->is_a($module)) continue;
                
                $mdata = $module->run($mdata);
            }
            
            if (!isset($mdata['content'])) return $data;
            
            return $mdata;
            
        }
    }