<?php
    /**
     * FanPress CM MySQL database driver class
     * 
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
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
    final class mysql implements sqlDriver {
        
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
            return ' LIMIT '.(int) $limit.', '.(int) $offset;
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
         * @param string $table
         * @return string
         */
        public function getLastInsertIdParams($table) {
            return null;
        }

        /**
         * Query-String um Wert in angegebener Spalte zu negieren
         * @param string $field
         * @return string
         */
        public function getNotQuery($field) {
            return "$field = NOT $field";
        }

        /**
         * Datentyp-Mapping für Yaml-basierte Tabelle-Definitionen
         * @return array
         */
        public function getYaTDLDataTypes() {

            return array(
                'int'       => 'int',
                'bigint'    => 'bigint',
                'varchar'   => 'varchar',
                'text'      => 'text',
                'mtext'     => 'mediumtext',
                'bool'      => 'tinyint',
                'bin'       => 'blob',
            );

        }

    }
