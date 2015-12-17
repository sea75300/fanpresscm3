<?php
    /**
     * FanPress CM MySQL database driver class
     * 
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\drivers;

    /**
     * MySQL database driver class
     * 
     * @package fpcm.drivers.database
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.2
     */ 
    interface sqlDriver {
        
        /**
         * Erzeugt DNS-String für \PDO:__construct
         * @param array $dbconfig
         * @return string
         * @link http://php.net/manual/de/pdo.construct.php
         */
        public function getPdoDns(array $dbconfig);
        
        /**
         * Liefert Options-Array für \PDO:__construct
         * @return array
         * @link http://php.net/manual/de/pdo.construct.php
         */
        public function getPdoOptions();

        /**
         * Erzeugt LIKE-SQL-String
         * @return string
         */
        public function getDbLike();

        /**
         * Erzeugt LIMIT-SQL-String
         * @param int $limit
         * @param int $offset
         * @return string
         */
        public function limitQuery($limit, $offset);
        
        /**
         * Erzeugt ORDER BY-SQL-String
         * @param array $conditions
         * @return string
         */        
        public function orderBy(array $conditions);
        
        /**
         * Erzeugt CONCAT SQl_String
         * @param array $fields
         * @return string
         * @since FPCM 3.1.0
         */        
        public function concatString(array $fields);
        
    }