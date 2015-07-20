<?php
    /**
     * FanPress CM database abstraction class
     * 
     * Database abstraction layer
     * 
     * @article Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\classes;

    /**
     * Database abstraction 
     * 
     * @package fpcm.classes.database
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    final class database {

        /**
         * Article-Tabelle
         */
        const tableArticles     = 'articles';
        
        /**
         * Benutzer-Tabelle
         */
        const tableAuthors      = 'authors';
        
        /**
         * Kategorie-Tabelle
         */
        const tableCategories   = 'categories';
        
        /**
         * Kommentar-Tabelle
         */
        const tableComments     = 'comments';
        
        /**
         * Config-Tabelle
         */
        const tableConfig       = 'config';
        
        /**
         * Cronjob-Tabelle
         */
        const tableCronjobs     = 'cronjobs';
        
        /**
         * Dateiindex-Tabelle
         */
        const tableFiles        = 'uploadfiles';
        
        /**
         * Tabeller gesperrter IP-Adressen
         */
        const tableIpAdresses   = 'blockedip';
        
        /**
         * Modul-Tabelle
         */
        const tableModules      = 'modules';
        
        /**
         * Tabelle für Berechtigungen
         */
        const tablePermissions  = 'permissions';
        
        /**
         * Benutzerrollen-Tabelle
         */
        const tableRoll         = 'userrolls';
        
        /**
         * Sessions-Tabelle
         */
        const tableSessions     = 'sessions';
        
        /**
         * Smiley-Tabelle
         */
        const tableSmileys      = 'smileys';

        /**
         * Datenbank-Verbindung
         * @var \PDO
         */
        private $connection;

        /**
         * Tabellen-Prefix
         * @var string
         */
        private $dbprefix;
        
        /**
         * letzter ausgeführter Datenbank-Querystring
         * @var string
         */
        private $lastQueryString = '';

        /**
         * 
         * @param array $dbconfig alternative Datenbank-Zugangsdaten, wenn false werden Daten aus FPCM-Config genutzt
         * @param bool $dieOnError wenn Verbindung fehlschlägt, soll Ausführung vollständig abgebrochen werden
         * @return void
         */
        public function __construct($dbconfig = false, $dieOnError = true) {        
            $dbconfig = is_array($dbconfig) ? $dbconfig : baseconfig::getDatabaseConfig();

            try {
                $this->connection = new \PDO($dbconfig['DBTYPE'].':dbname='.$dbconfig['DBNAME'].';host='.$dbconfig['DBHOST'], $dbconfig['DBUSER'], $dbconfig['DBPASS']);
            } catch(PDOException $e) {
                logs::sqllogWrite($e->getMessage());
                if (!$dieOnError) return;                
                die('Connection to database failed!');
            }

            $this->dbprefix = $dbconfig['DBPREF'];
        }

        /**
         * Der Destruktor
         */
        public function __destruct() {
            $this->connection = null;
        }


        /**
         * Parst einfach Anfürungszeichen in Zichenkette
         * @param string $string Text mit einfachen Anfürungszeichen
         * @return string
         */
        public function quoteString($string) {
            return str_replace("'", "\'", $string);
        }


        /**
         * Führt SELECT-Befehl auf DB aus
         * @param string $table select table
         * @param string $item select items
         * @param string $where select condition
         * @param array $params select condition params
         * @param bool $distinct Distinct select
         * @return mixed
         */
        public function select($table, $item = '*', $where = null, $params = null, $distinct = false) {            
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";
            $sql = $distinct ? "SELECT DISTINCT $item FROM $table" : "SELECT $item FROM $table";
            if (!is_null($where)) $sql .= " WHERE $where";
            return $this->query($sql, $params);            
        }

        /**
         * Führt INSERT-Befehl auf DB aus
         * @param string $table
         * @param string $fields
         * @param string $values
         * @param array $params
         * @return bool|int
         */
        public function insert($table, $fields, $values, $params = null) {
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";
            $sql = "INSERT INTO $table ($fields) VALUES ($values);";

            $this->exec($sql, $params);
            return $this->getLastInsertId();
        }

        /**
         * Führt UPDATE-Befehl auf DB aus
         * @param string $table
         * @param array $fields
         * @param array $values
         * @param array $params
         * @param string $where
         * @return bool
         */
        public function update($table, array $fields, $params = null, $where = null) {
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";            
            $sql = "UPDATE $table SET ";
            $sql .= implode(' = ?, ', $fields).' = ?';            
            if (!is_null($where)) $sql .= " WHERE $where";
            return $this->exec($sql, $params);            
        }

        /**
         * Führt DELETE-Befehl auf DB aus
         * @param string $table
         * @param string $where
         * @param array $params
         * @return bool
         */
        public function delete($table, $where = null, $params = null) {
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";
            $sql    = "DELETE FROM $table";
            if (!is_null($where)) $sql .= " WHERE $where";    

            return $this->exec($sql, $params);
        }

        /**
         * Ändert Tabellenstruktur
         * @param string $table
         * @param string $methode
         * @param string $field
         * @param string $where
         */
        public function alter($table, $methode, $field, $where = "") {
            
            if ($this->fetch($this->select($table, $field)) !== false) return true;
            
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";
            $sql = "ALTER TABLE $table $methode $field $where";
            return $this->exec($sql);
        }

        /**
         * Zählt nach den angebenen Einstellungen
         * @param string $table In welcher Tabelle soll gezählt werden
         * @param string $countitem Welche Spalte soll gezählt werden
         * @param string $where Nach welchen Filterkriterien soll gezählt werden
         * @return int
         */
        public function count($table, $countitem = '*',$where = null, $params = null) {
            $sql = "SELECT count(".$countitem.") AS counted FROM {$this->dbprefix}_{$table}";
            if ($where != null) { $sql .= " WHERE ".$where.";"; }

            $result = $this->query($sql, $params);	
            if ($result === false) { $this->getError();return false; }
            $row = $this->fetch($result);

            return isset($row->counted) ? $row->counted : 0;
        }

        /**
         * Negiert den Wert des übergebenen Feldes
         * @param string $table
         * @param string $field
         * @param string $where
         */
        public function reverseBool($table, $field, $where) {        
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";
            $sql = "UPDATE $table SET $field = NOT $field";
            if (!is_null($where)) $sql .= " WHERE $where";
            return $this->exec($sql);
        }

        /**
         * Führt ein SQL Kommando aus
         * @param string $command SQL String
         * @param array $bindParams Paramater, welche gebunden werden sollen
         * @return void
         */
        public function exec($command, $bindParams = null) {        
            $statement = $this->connection->prepare($command);     

            if (defined('FPCM_DEBUG') && FPCM_DEBUG && defined('FPCM_DEBUG_SQL') && FPCM_DEBUG_SQL) {
                logs::sqllogWrite($statement->queryString);
            }

            $this->lastQueryString = $statement->queryString;
            
            try {
                $res = $statement->execute($bindParams);
            } catch (\PDOException $e) {
                logs::sqllogWrite($e);
            }            
            
            if (!$res) {
                $this->getStatementError($statement);
                return false;
            }

            return true;
        }

        /**
         * Führt ein SQL Kommando aus und gibt Result-Set zurück
         * @param string $command SQL String
         * @param array $bindParams Paramater, welche gebunden werden sollen
         * @return PDOStatement Zeilen in der Datenbank
         */
        public function query($command, $bindParams = null) {
            $statement = $this->connection->prepare($command);

            if (defined('FPCM_DEBUG') && FPCM_DEBUG && defined('FPCM_DEBUG_SQL') && FPCM_DEBUG_SQL) {
                logs::sqllogWrite($statement->queryString);
            }
            
            $this->lastQueryString = $statement->queryString;
            
            try {
                $res = $statement->execute($bindParams);
            } catch (\PDOException $e) {
                logs::sqllogWrite($e);
            }
            
            if (!$res) {
                $this->getStatementError($statement);
            }

            return $statement;
        }

        /**
         * Schreibt letzte Fehlermeldung der DB-Verbindung in DB-Log
         * @return boolean
         */
        public function getError() {	
            logs::sqllogWrite(print_r($this->connection->errorInfo(), true));
            
            return true;
        }

        /**
         * Schreibt letzte Fehlermeldung des ausgefühtren Statements in DB-Log
         * @param \PDOStatement $statement
         * @return boolean
         */
        public function getStatementError(\PDOStatement &$statement) {	
            logs::sqllogWrite(print_r($statement->errorInfo(), true));
            
            return true;
        }

        /**
         * Liefert eine Zeile des results als Objekt zurück
         * @param PDOStatement $result Resultset
         * @param bool $getAll soll fetchAll() erzwungen werden
         * @return object
         */		
        public function fetch($result,$getAll = false) {
            if ($result->rowCount() > 1 || $getAll == true) {
                return $result->fetchAll(\PDO::FETCH_OBJ);
            } else {
                return $result->fetch(\PDO::FETCH_OBJ);
            }
        }

        /**
         * Liefert ID des letzten Insert-Eintrags
         * @return string
         */
        public function getLastInsertId() {
            $return = $this->connection->lastInsertId();

            if (defined('FPCM_DEBUG') && FPCM_DEBUG && defined('FPCM_DEBUG_SQL') && FPCM_DEBUG_SQL) {
                logs::sqllogWrite("Last insert id was: $return");
            }        

            return $return;
        }

        /**
         * Liefert zuletzt ausgeführten Query-String zurück
         * @return string
         */
        public function getLastQueryString() {
            return $this->lastQueryString;
        }        
        
        /**
         * Liefert höchten Wert einer Tabellen-ID
         * @param string $table Tabellen-Name
         * @return int
         */
        public function getMaxTableId($table) {
            $sql = "SELECT max(id) as maxid from {$this->dbprefix}_{$table};";
            $data = $this->fetch($this->query($sql));

            if (defined('FPCM_DEBUG') && FPCM_DEBUG && defined('FPCM_DEBUG_SQL') && FPCM_DEBUG_SQL) {
                logs::sqllogWrite("MAXID from {$this->dbprefix}_{$table} is {$data->maxid}.");
            }

            return $data->maxid;
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
         * Tabelle-Prefix zurückgeben
         * @return string
         */
        public function getDbprefix() {
            return $this->dbprefix;
        }

    }
