<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class common extends \fpcm\controller\abstracts\ajaxController {

        protected $fpcm2Path = '';
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {
            $this->fpcm2Path = realpath(dirname(\fpcm\classes\baseconfig::$baseDir).$this->getRequestVar('path'));
            return parent::request();
        }
        
        protected function initDatabase() {
            
            include_once $this->fpcm2Path.'/inc/config.php';
            
            $databaseInfo = array(
                'DBTYPE' => 'mysql',
                'DBHOST' => DBSRV,
                'DBNAME' => DBNAME,
                'DBUSER' => DBUSR,
                'DBPASS' => DBPASSWD,
                'DBPREF' => FP_PREFIX
            );

            try {
                $db = new \fpcm\classes\database($databaseInfo, false);                
            } catch (\PDOException $exc) {
                fpcmLogSql($exc->getMessage());
                return 0;
            }
            
            return $db;
        }
        
        public function __destruct() {
            $this->cache->cleanup();
        }

    }
?>