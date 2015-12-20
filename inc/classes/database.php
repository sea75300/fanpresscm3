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
         * Datenbank-Treiber
         * @var \fpcm\drivers\sqlDriver
         * @since FPCM 3.2
         */
        private $driver;

        /**
         * Tabellen-Prefix
         * @var string
         */
        private $dbprefix;

        /**
         * Datenbank-Typ
         * @var string
         * @since FPCM 3.2
         */
        private $dbtype;
        
        /**
         * letzter ausgeführter Datenbank-Querystring
         * @var string
         */
        private $lastQueryString = '';
        
        /**
         * Anzahl an Datenbank abgesetzte Queries
         * @var int
         */
        private $queryCount = 0;

        /**
         * Konstruktor
         * @param array $dbconfig alternative Datenbank-Zugangsdaten, wenn false werden Daten aus FPCM-Config genutzt
         * @param bool $dieOnError wenn Verbindung fehlschlägt, soll Ausführung vollständig abgebrochen werden
         * @return void
         */
        public function __construct($dbconfig = false, $dieOnError = true) {   

            $dbconfig   = (is_array($dbconfig)
                        ? $dbconfig
                        : baseconfig::getDatabaseConfig());

            $driverClass = '\\fpcm\\drivers\\'.$dbconfig['DBTYPE'];

            if (!class_exists($driverClass)) {
                logs::sqllogWrite('SQL driver not found for '.$dbconfig['DBTYPE']);
                $this->dieError();
            }
            
            $this->driver = new $driverClass();
            if (!is_a($this->driver, '\\fpcm\\drivers\\sqlDriver')) {
                logs::sqllogWrite('SQL driver '.$driverClass.' must be an instance of "\\fpcm\\drivers\\sqlDriver"!');
                $this->dieError();
            }

            try {
                $this->connection = new \PDO($dbconfig['DBTYPE'].':'.$this->driver->getPdoDns($dbconfig), $dbconfig['DBUSER'], $dbconfig['DBPASS'], $this->driver->getPdoOptions());
            } catch(PDOException $e) {
                logs::sqllogWrite($e->getMessage());
                if (!$dieOnError) {
                    return;
                }
                $this->dieError();
            }

            $this->dbprefix = $dbconfig['DBPREF'];
            $this->dbtype   = $dbconfig['DBTYPE'];
        }

        /**
         * Der Destruktor
         */
        public function __destruct() {
            $this->connection = null;
        }

        /**
         * Führt SELECT-Befehl auf DB aus
         * @param string $table select table
         * @param string $item select items
         * @param string|null $where select condition
         * @param array $params select condition params
         * @param bool $distinct Distinct select
         * @return mixed
         */
        public function select($table, $item = '*', $where = null, array $params = array(), $distinct = false) {            
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
        public function insert($table, $fields, $values, array $params = array()) {
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";
            $sql = "INSERT INTO $table ($fields) VALUES ($values);";

            $this->exec($sql, $params);
            return $this->getLastInsertId($table);
        }

        /**
         * Führt UPDATE-Befehl auf DB aus
         * @param string $table
         * @param array $fields
         * @param array $params
         * @param string $where
         * @return bool
         */
        public function update($table, array $fields, array $params = array(), $where = null) {
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
        public function delete($table, $where = null, array $params = array()) {
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";
            $sql    = "DELETE FROM $table";
            if (!is_null($where)) $sql .= " WHERE $where";    

            return $this->exec($sql, $params);
        }

        /**
         * Ändert Tabellenstruktur via ALTER TABLE
         * @param string $table
         * @param string $methode
         * @param string $field
         * @param string $where
         * @param bool $checkExists Prüfung durchführen, ob Feld existiert
         * @return bool
         */
        public function alter($table, $methode, $field, $where = "", $checkExists = true) {
            
            if ($checkExists && $this->fetch($this->select($table, $field)) !== false) return true;
            
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";
            $sql = "ALTER TABLE $table $methode $field $where";
            return $this->exec($sql);
        }

        /**
         * Zählt nach den angebenen Einstellungen
         * @param string $table In welcher Tabelle soll gezählt werden
         * @param string $countitem Welche Spalte soll gezählt werden
         * @param string $where Nach welchen Filterkriterien soll gezählt werden
         * @param array $params
         * @return boolean
         */
        public function count($table, $countitem = '*', $where = null, array $params = array()) {
            $sql = "SELECT count(".$countitem.") AS counted FROM {$this->dbprefix}_{$table}";
            if (!is_null($where)) {
                $sql .= " WHERE ".$where.";";                
            }

            $result = $this->query($sql, $params);	
            if ($result === false) { $this->getError();return false; }
            $row = $this->fetch($result);

            return isset($row->counted) ? $row->counted : 0;
        }

        /**
         * Negiert den Wert des übergebenen Feldes
         * @param string|array $table
         * @param string $field
         * @param string $where
         * @return bool
         */
        public function reverseBool($table, $field, $where) {        
            $table = (is_array($table)) ? $this->dbprefix.'_'.implode(', '.$this->dbprefix.'_', $table) : $this->dbprefix."_$table";
            $sql = "UPDATE $table SET $field = NOT $field";
            if (!is_null($where)) $sql .= " WHERE $where";
            return $this->exec($sql);
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
         * Tabelle via DROP TABLE löschen
         * @param string $table
         * @return bool
         */
        public function drop($table) {            
            return $this->exec("DROP TABLE {$this->dbprefix}_{$table}");            
        }

        /**
         * Führt ein SQL Kommando aus
         * @param string $command SQL String
         * @param array $bindParams Paramater, welche gebunden werden sollen
         * @return bool
         */
        public function exec($command, array $bindParams = array()) {
            
            $this->queryCount++;
            
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
         * Führt SQL-Datei aus
         * @param string $path
         * @return boolean
         * @since FPCM 3.2.0
         */
        public function execSqlFile($path) {

            if (substr($path, -4) != '.sql') {
                trigger_error('Given file was not SQL file '.$path);
                return false;
            }
            
            if (!file_exists($path) || filesize($path) < 1) {
                trigger_error('File not found or file is empty in '.$path);
                return false;
            }

            $this->queryCount++;

            $sql = str_replace('{{dbpref}}', $this->getDbprefix(), file_get_contents($path));
            $this->lastQueryString = $sql;
            
            if (defined('FPCM_DEBUG') && FPCM_DEBUG && defined('FPCM_DEBUG_SQL') && FPCM_DEBUG_SQL) {
                logs::sqllogWrite($sql);
            }

            try {
                $res = $this->connection->exec($this->connection->quote($sql));
            } catch (\PDOException $e) {
                logs::sqllogWrite($e);
            }            
            
            if ($res === false) {
                $this->getError();
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
        public function query($command, array$bindParams = array()) {
            
            $this->queryCount++;
            
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
         * @return array
         */		
        public function fetch(\PDOStatement $result,$getAll = false) {
            if ($result->rowCount() > 1 || $getAll == true) {
                return $result->fetchAll(\PDO::FETCH_OBJ);
            }
            
            return $result->fetch(\PDO::FETCH_OBJ);
        }

        /**
         * Liefert ID des letzten Insert-Eintrags
         * @return string
         */
        public function getLastInsertId($table = null) {
            
            $this->queryCount++;
            
            $params = $this->driver->getLastInsertIdParams($table);
            $return = $params
                    ? $this->connection->lastInsertId($params)
                    : $this->connection->lastInsertId();

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
         * Erzeugt LIMIT-SQL-String
         * @param int $limit
         * @param int $offset
         * @return string
         */
        public function limitQuery($limit, $offset) {
            return $this->driver->limitQuery($limit, $offset);
        }
        
        /**
         * Erzeugt ORDER BY-SQL-String
         * @param array $conditions
         * @return string
         */
        public function orderBy(array $conditions) {
            return $this->driver->orderBy($conditions);
        }
        
        /**
         * Erzeugt CONCAT SQl_String
         * @param array $fields
         * @return string
         * @since FPCM 3.1.0
         */
        public function concatString(array $fields) {
            return $this->driver->concatString($fields);
        }
        
        /**
         * Erzeugt LIKE-SQL-String
         * @return string
         * @since FPCM 3.2.0
         */
        public function dbLike() {
            return $this->driver->getDbLike();
        }

        /**
         * Tabellen-Prefix zurückgeben
         * @return string
         */
        public function getDbprefix() {
            return $this->dbprefix;
        }
        
        /**
         * Datenbank-Typ zurückgeben
         * @return string
         * @since FPCM 3.2
         */
        public function getDbtype() {
            return $this->dbtype;
        }
                
        /**
         * Gibt Anzahl an ausgeführt Datenbank-Queries zurück
         * @return int
         * @since FPCM 3.1.0
         */
        public function getQueryCount() {
            return $this->queryCount;
        }
        
        /**
         * Error die
         */
        private function dieError() {
            die('Connection to database failed!');
        }

    }
