<?php
    /**
     * AJAX installer database connection check controller
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\ajax\installer;
    
    /**
     * AJAX-Controller zur Prüfung der eingegebenen Datenbank-Zugangsdaten im Installer
     * 
     * @package fpcm.controller.ajax.installer.checkdb
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class checkdb extends \fpcm\controller\abstracts\ajaxController {
        
        /**
         * Konstruktor
         * @return boolean
         */
        public function __construct() {
            return true;
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {
            if (\fpcm\classes\baseconfig::dbConfigExists()) return false;
            
            return true;
        }
        
        /**
         * Controller-Processing
         */
        public function process() {

            $databaseInfo = $this->getRequestVar('dbdata');

            try {
                $db = new \fpcm\classes\database($databaseInfo);                
            } catch (\PDOException $exc) {
                trigger_error($exc->getMessage());
                die('0');
            }
            
            if (!$db->checkDbVersion()) {
                trigger_error('Unsupported database system detected. Installed version is '.$db->getDbVersion().', FanPress CM requires version '.$db->getRecommendVersion());
                die('0');
            }

            include_once \fpcm\classes\baseconfig::$configDir.'/database.php.sample';
            
            foreach ($databaseInfo as $key => $value) {
                $config[$key] = $value;
            }
            
            $content    = [];
            $content[]  = '<?php';
            $content[]  = '/**';
            $content[]  = ' * FanPress CM databse connection configuration file';
            $content[]  = ' * Only edit this file, if you know what you are doing!!!';
            $content[]  = ' *';
            $content[]  = ' * DBTYPE => databse type, mysql support only so far';
            $content[]  = ' * DBHOST => mostly localhost, modify this if you use a different name';
            $content[]  = ' * DBNAME => the database to connect to';
            $content[]  = ' * DBUSER => user to connect to database';
            $content[]  = ' * DBPASS => the users password to connect to database';
            $content[]  = ' * DBPREF => table prefix';
            $content[]  = ' *';
            $content[]  = ' */';
            $content[]  = '$config = '.var_export($config, true).';';
            $content[]  = '?>';
            file_put_contents(\fpcm\classes\baseconfig::$configDir.'/database.php', implode(PHP_EOL, $content));
            
            die('1');
        }

    }
?>