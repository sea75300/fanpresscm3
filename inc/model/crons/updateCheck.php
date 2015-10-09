<?php
    /**
     * FanPress CM Update Check Cronjob
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\crons;
    
    /**
     * Cronjob update check
     * 
     * @package fpcm.model.crons
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class updateCheck extends \fpcm\model\abstracts\cron {

        /**
         * Async execution
         * @see \fpcm\model\abstracts\cron
         * @var bool
         */
        protected $runAsync = true;

        /**
         * Auszuführender Cron-Code
         */
        public function run() {

            $updater = new \fpcm\model\updater\system();
            
            $res = $updater->checkUpdates();
            $this->setReturnData($res);
            
            if ($res && $this->getAsyncCurrent() && FPCM_UPDATE_CRONNOTIFY_EMAIL) {
                
                $replacements = array(
                    '{{version}}' => $updater->getRemoteData('version'),
                    '{{acplink}}' => \fpcm\classes\baseconfig::$rootPath
                );
                
                $config   = \fpcm\classes\baseconfig::$fpcmConfig;
                $language = \fpcm\classes\baseconfig::$fpcmLanguage;
                $email = new \fpcm\classes\email($config->system_email,
                                                 $language->translate('CRONJOB_UPDATES_NEWVERSION'),
                                                 $language->translate('CRONJOB_UPDATES_NEWVERSION_TEXT', $replacements));                
                $email->submit();
            }            
            $this->updateLastExecTime();
            
            return true;
        }
        
        /**
         * Häufigkeit der Ausführung einschränken
         * @return boolean
         */        
        public function checkTime() {
            
            if (time() < $this->getNextExecTime()) return false;            

            return true;
        }
        
        /**
         * Interval-Dauer zurückgeben
         * @return int
         */
        public function getIntervalTime() {
            return 3600 * 24;
        }
        
    }
