<?php
    /**
     * YaML Table Definition Language Parser
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\system;

    /**
     * YaML Table Definition Language Parse
     * 
     * @package fpcm.model.system
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.2.0
     */
    class yatdl extends \fpcm\model\abstracts\staticModel {
        
        /**
         * Check von geparstem YAML-String fehlgeschlagen
         */
        const ERROR_YAMLCHECK_FAILED = -1;
        
        /**
         * Beim Parsen der Spalten ist ein Feler aufgetreten
         */
        const ERROR_YAMLPARSER_COLS = -2;
        
        /**
         * Beim Parsen der Spalten ist ein Feler aufgetreten
         */
        const ERROR_YAMLPARSER_AUTOINCREMENT = -3;
        
        /**
         * Beim Parsen von Index-Definitionen ist ein Feler aufgetreten
         */
        const ERROR_YAMLPARSER_INDICES = -4;
        
        /**
         * In Array geparstes YAML-String
         * @var array
         */
        protected $yamlArray;
        
        /**
         * Dateipfad zur YAML-Datei
         * @var string
         */
        protected $filePath;
        
        /**
         * Datenbank-Objekt
         * @var \fpcm\classes\database
         */
        protected $db;
        
        /**
         * Ist Datenbank Postgres oder MySQL
         * @var bool
         */
        protected $isPg;
        
        /**
         * Array mit SQL-Strings
         * @var array
         */
        protected $sqlArray = array();
        
        /**
         * Feldtypen aus \fpcm\classes\database::getYaTDLDataTypes()
         * @var array
         */
        protected $colTypes = array();
        
        /**
         * fertige SQL-Query
         * @var string
         */
        protected $sqlString = '';
        
        /**
         * Parsen erfolgreich abgeschlossen
         * @var bool
         */
        protected $parsingOk = false;

        /**
         * Konstruktor
         * @param string $filePath
         */
        public function __construct($filePath) {

            $this->db   = \fpcm\classes\baseconfig::$fpcmDatabase;
            $this->isPg = ($this->db->getDbtype() == 'pgsql' ? true : false);
            $this->colTypes = $this->db->getYaTDLDataTypes();

            include_once \fpcm\classes\loader::libGetFilePath('spyc', 'Spyc.php');
            $this->yamlArray = \Spyc::YAMLLoad($filePath);
        }
        
        /**
         * Parst Array aus YAML-String in SQL-String
         * @return boolean
         */
        public function parse() {
         
            if (!$this->checkYamlArray()) {
                return self::ERROR_YAMLCHECK_FAILED;
            }
            
            $this->createTableString();
            
            if (!$this->createColRows()) {
                return self::ERROR_YAMLPARSER_COLS;
            }
            
            $this->createTableEndline();

            if (!$this->createAutoincrement()) {
                return self::ERROR_YAMLPARSER_AUTOINCREMENT;
            }
            
            $this->createPrimaryKey();

            if (!$this->createIndices()) {
                return self::ERROR_YAMLPARSER_INDICES;
            }
            
            $this->sqlArray['cols'] = implode(','.PHP_EOL, $this->sqlArray['cols']);
            $this->sqlString        = implode(PHP_EOL, $this->sqlArray);
            
            $this->parsingOk = true;
            
            return true;
            
        }
        
        /**
         * Gibt fertigen SQL-String zurück
         * @return string
         */
        public function getSqlString() {
            
            if (!$this->parsingOk || !is_string($this->sqlString)) {
                return '';
            }
            
            return $this->sqlString;
        }
        
        /**
         * Debug-Ausgabe von geparstem YAML-String
         */
        public function dumpYamlArray() {
            fpcmDump($this->yamlArray);
        }

        /**
         * Create Table Statement erzeugen
         */
        private function createTableString() {
            
            $this->sqlArray[] = ($this->isPg
                              ? "CREATE TABLE {{dbpref}}_{$this->yamlArray['name']} ("
                              : "CREATE TABLE IF NOT EXISTS `{{dbpref}}_{$this->yamlArray['name']}` (");
            
        }
        
        /**
         * Create Table Statement Abschluss-Zeile erzeugen
         */
        private function createTableEndline() {

            $this->sqlArray[] = ($this->isPg
                              ? ");"
                              : ") ENGINE={$this->yamlArray['engine']} DEFAULT CHARSET={$this->yamlArray['charset']}".
                                " AUTO_INCREMENT={$this->yamlArray['autoincrement']['start']};");
            
        }
        
        /**
         * Spalten parsen
         * @return boolean
         */
        private function createColRows() {

            $lenghtTypes = array('varchar');
            if (!$this->isPg) {
                $lenghtTypes += array('int', 'bigint', 'bool');
            }
            
            foreach ($this->yamlArray['cols'] as $rowName => $row) {
                
                if (!$this->checkYamlColRow($rowName, $row)) {
                    return false;
                }

                $rowName = strtolower($rowName);
                $sql = $this->isPg ? "{$rowName}" : "`{$rowName}`";
                
                $sql .= " {$this->colTypes[$row['type']]}";
                $sql .= ($row['length'] && in_array($row['type'], $lenghtTypes))
                      ? "({$row['length']}) " 
                      : " ";

                if ($row['params']) {
                    $sql .= $row['params'];
                }
                
                $this->sqlArray['cols'][$rowName] = $sql;
                
            }
            
            return true;
            
        }
        
        /**
         * Auto Increment Angaben übersetzten
         * @return boolean
         */
        private function createAutoincrement() {
            
            if (!isset($this->yamlArray['autoincrement']['start'])) {
                trigger_error('Invalid YAML autoincrement data, no "start" property found!');
                return false;
            }
            
            if (!isset($this->yamlArray['autoincrement']['colname'])) {
                trigger_error('Invalid YAML autoincrement data, no "colname" property found!');
                return false;
            }
            
            if ($this->isPg) {
                $seqName = "{{dbpref}}_{$this->yamlArray['name']}_{$this->yamlArray['autoincrement']['colname']}_seq";
                
                $seq  = "CREATE SEQUENCE {$seqName}";
                $seq .= " START WITH {$this->yamlArray['autoincrement']['start']}";
                $seq .= " INCREMENT BY 1";
                $seq .= " NO MINVALUE";
                $seq .= " NO MAXVALUE";
                $seq .= " CACHE 1;";
                
                $this->sqlArray[] = $seq;
                $this->sqlArray[] = "ALTER SEQUENCE {$seqName} OWNED BY {{dbpref}}_{$this->yamlArray['name']}.{$this->yamlArray['autoincrement']['colname']};";
                $this->sqlArray[] = "ALTER TABLE ONLY {{dbpref}}_{$this->yamlArray['name']} ALTER COLUMN id SET DEFAULT nextval('{$seqName}'::regclass);";
                
                return true;
            }
            
            $this->sqlArray['cols'][$this->yamlArray['autoincrement']['colname']] .= ' AUTO_INCREMENT';
            
            return true;
            
        }
        
        /**
         * Primary Key angabe anlegen
         * @return boolean
         */
        private function createPrimaryKey() {
            
            if (!trim($this->yamlArray['primarykey'])) {
                return true;
            }
            
            if ($this->isPg) {
                $this->sqlArray[] = "ALTER TABLE ONLY {{dbpref}}_{$this->yamlArray['name']} ADD CONSTRAINT {{dbpref}}_{$this->yamlArray['name']}_{$this->yamlArray['primarykey']} PRIMARY KEY ({$this->yamlArray['primarykey']});";
                return true;
            }

            $this->sqlArray['cols'][] = "PRIMARY KEY (`{$this->yamlArray['primarykey']}`)";
            
            return true;
        }
        
        /**
         * Index-Angabe erzeugen
         * @return boolean
         */
        private function createIndices() {

            if (!is_array($this->yamlArray['indices']) || !count($this->yamlArray['indices'])) {
                return true;
            }
            
            foreach ($this->yamlArray['indices'] as $rowName => $row) {
                
                if (!$this->checkYamlIndiceRow($rowName, $row)) {
                    return false;
                }
                
                if ($this->isPg) {
                    $index = ($row['isUnqiue'] ? 'UNIQUE INDEX' : 'INDEX');
                    $sql   = "CREATE {$index} {{dbpref}}_{$this->yamlArray['name']}_{$rowName} ON {{dbpref}}_{$this->yamlArray['col']} USING btree ({$row['col']});";
                }
                else {
                    $index = ($row['isUnqiue'] ? 'UNIQUE' : 'INDEX');
                    $sql   = "ALTER TABLE {{dbpref}}_{$this->yamlArray['name']} ADD {$index} `{$rowName}` ( `{$row['col']}` ) ";
                }
              
                $this->sqlArray[] = $sql;
                
            }
            
            return true;
        }

        /**
         * Spalten-Zeile prüfen, ob alle nötigen Daten vorhanden sind
         * @param string $rowName
         * @param array $row
         * @return boolean
         */
        private function checkYamlColRow($rowName, array $row) {
            
            if (!$rowName) {
                trigger_error('Invalid YAML col data, key must include column name!');
                return false;
            }

            if (!isset($row['type']) || !count($row['type'])) {
                trigger_error('Invalid YAML col data, no "cols" property found!');
                return false;
            }

            if (!isset($this->colTypes[$row['type']])) {
                trigger_error('Invalid YAML col data, undefined col type found!');
                return false;
            }

            if (!isset($row['length'])) {
                trigger_error('Invalid YAML col data, no "isNull" property found!');
                return false;
            }

            if (!isset($row['params'])) {
                trigger_error('Invalid YAML col data, no "params" property found!');
                return false;
            }
            
            return true;
            
        }

        /**
         * Index-Zeile prüfen, ob alle nötigen Daten vorhanden sind
         * @param string $rowName
         * @param array $row
         * @return boolean
         */
        private function checkYamlIndiceRow($rowName, array $row) {
            
            if (!isset($row['col']) || !trim($row['col'])) {
                trigger_error('Invalid YAML indice row data, no "col" property found!');
                return false;
            }

            if (!$rowName) {
                trigger_error('Invalid YAML indice row data, key must include column name!');
                return false;
            }

            if (!isset($row['isUnqiue'])) {
                trigger_error('Invalid YAML indice row data, no "name" property found!');
                return false;
            }
            
            return true;
            
        }

        /**
         * Array aus \Spyc-gepartem YAML-String prüfen
         * @return boolean
         */
        private function checkYamlArray() {

            if (!is_array($this->yamlArray)) {
                trigger_error('Invalid YAML data, no valid data available!');
                return false;
            }
            
            if (!array_key_exists('name', $this->yamlArray) || !trim($this->yamlArray['name'])) {
                trigger_error('Invalid YAML data, no "name" property found!');
                return false;
            }

            if (!array_key_exists('cols', $this->yamlArray) || !count($this->yamlArray['cols'])) {
                trigger_error('Invalid YAML data, no "cols" property found!');
                return false;
            }

            if (!array_key_exists('indices', $this->yamlArray)) {
                trigger_error('Invalid YAML data, no "index" property found!');
                return false;
            }

            if (!array_key_exists('primarykey', $this->yamlArray)) {
                trigger_error('Invalid YAML data, no "primarykey" property found!');
                return false;
            }

            if (!array_key_exists('charset', $this->yamlArray)) {
                trigger_error('Invalid YAML data, no "charset" property found!');
                return false;
            }

            if (!array_key_exists('autoincrement', $this->yamlArray) ||
                !isset($this->yamlArray['autoincrement']['colname']) ||
                !isset($this->yamlArray['autoincrement']['start'])) {
                trigger_error('Invalid YAML data, no "autoincrement" property found!');
                return false;
            }

            if (!array_key_exists('engine', $this->yamlArray)) {
                trigger_error('Invalid YAML data, no "engine" property found!');
                return false;
            }
            
            return true;
            
        }

    }
