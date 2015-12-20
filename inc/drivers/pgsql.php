<?php
    /**
     * FanPress CM Postgres database driver class
     * 
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\drivers;

    /**
     * Postgres database driver class
     * 
     * @package fpcm.drivers.database
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.2
     */ 
    final class pgsql implements sqlDriver {
        
        /**
         * Erzeugt DNS-String für \PDO:__construct
         * @param array $dbconfig
         * @return string
         * @link http://php.net/manual/de/pdo.construct.php
         */
        public function getPdoDns(array $dbconfig) {
            return 'dbname='.$dbconfig['DBNAME'].';host='.$dbconfig['DBHOST'];
        }
        
        /**
         * Liefert Options-Array für \PDO:__construct
         * @return array
         * @link http://php.net/manual/de/pdo.construct.php
         */        
        public function getPdoOptions() {
            return array();
        }
        
        /**
         * Erzeugt CONCAT SQl_String
         * @param array $fields
         * @return string
         */ 
        public function concatString(array $fields) {
            return ' CONCAT ('.implode(', ', array_map('trim', $fields)).') ';
        }

        /**
         * Erzeugt LIKE-SQL-String
         * @return string
         */
        public function getDbLike() {
            return 'LIKE';
        }

        /**
         * Erzeugt LIMIT-SQL-String
         * @param int $limit
         * @param int $offset
         * @return string
         */
        public function limitQuery($limit, $offset) {
            return ' LIMIT '.(int) $limit.' OFFSET '.(int) $offset;
        }
        
        /**
         * Erzeugt ORDER BY-SQL-String
         * @param array $conditions
         * @return string
         */  
        public function orderBy(array $conditions) {
            return ' ORDER BY '.implode(', ', array_map('trim', $conditions));
        }
        
        /**
         * Erzeugt Parameter für @see \PDO::lastInsertId()
         * @return string
         */
        public function getLastInsertIdParams($table) {
            return $table.'_id_seq';
        }

    }
