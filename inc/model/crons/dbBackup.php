<?php
    /**
     * FanPress CM Database dump cronjob
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\crons;
    
    /**
     * FanPress CM Database dump cronjob
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm.model.crons
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class dbBackup extends \fpcm\model\abstracts\cron {

        /**
         * Backup-Pfad-Datei
         * @var string
         */
        protected $dumpfile;

        /**
         * Auszuführender Cron-Code
         */
        public function run() {
            
            include_once \fpcm\classes\loader::libGetFilePath('Ifsnop/Mysqldump', 'Mysqldump.php');
            
            $dbconfig = \fpcm\classes\baseconfig::getDatabaseConfig();
            
            $dumpSettings = array();
            
            $this->dumpfile = \fpcm\classes\baseconfig::$dbdumpDir.'/'.$dbconfig['DBNAME'].'_'.date('Y-m-d_H-i-s').'.sql';
            if (function_exists('gzopen')) {
                $dumpSettings['compress'] = \Ifsnop\Mysqldump\Mysqldump::GZIP;
                $this->dumpfile .= '.gz';
            }
            
            $dumpSettings['single-transaction']   = false;
            $dumpSettings['lock-tables']          = false;
            $dumpSettings['add-locks']            = false;
            $dumpSettings['extended-insert']      = false;
            $dumpSettings['no-autocommit']        = false;
            
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableArticles;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableAuthors;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableCategories;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableComments;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableConfig;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableCronjobs;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableFiles;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableIpAdresses;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableModules;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tablePermissions;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableRoll;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableSessions;
            $dumpSettings['include-tables'][] = $dbconfig['DBPREF'].'_'.\fpcm\classes\database::tableSmileys;
            
            $dumpSettings['include-tables']   = $this->events->runEvent('cronjobDbDumpIncludeTables', $dumpSettings['include-tables']);

            \fpcm\classes\logs::syslogWrite('Create new database dump in "'.\fpcm\model\files\ops::removeBaseDir($this->dumpfile, true).'"...');
            
            $mysqlDump = new \Ifsnop\Mysqldump\Mysqldump($dbconfig['DBNAME'],
                                                         $dbconfig['DBUSER'],
                                                         $dbconfig['DBPASS'],
                                                         $dbconfig['DBHOST'],
                                                         $dbconfig['DBTYPE'],
                                                         $dumpSettings);
            $mysqlDump->start($this->dumpfile);
            
            $this->updateLastExecTime();
            
            if (!file_exists($this->dumpfile)) {
                \fpcm\classes\logs::syslogWrite('Unable to create database dump in "'.\fpcm\model\files\ops::removeBaseDir($this->dumpfile, true).'", file not found. See system check and error log!');
                return false;
            }
            
            \fpcm\classes\logs::syslogWrite('New database dump created in "'.\fpcm\model\files\ops::removeBaseDir($this->dumpfile, true).'".');            

            $text  = \fpcm\classes\baseconfig::$fpcmLanguage->translate('CRONJOB_DBBACKUPS_TEXT', array(
                '{{filetime}}' => date(\fpcm\classes\baseconfig::$fpcmConfig->system_dtmask, $this->getLastExecTime()),
                '{{dumpfile}}' => \fpcm\model\files\ops::removeBaseDir($this->dumpfile, true)
            ));
            $email = new \fpcm\classes\email(\fpcm\classes\baseconfig::$fpcmConfig->system_email, \fpcm\classes\baseconfig::$fpcmLanguage->translate('CRONJOB_DBBACKUPS_SUBJECT'), $text);
            $email->submit();
            
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
            return 86400 * 14;
        }
        
    }
