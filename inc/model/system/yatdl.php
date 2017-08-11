<?php
    /**
     * YaML Table Definition Language\n
     * Parse Wrapper\n
     * uses \nkorg\yatdl\parser as of FPCM 3.6
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\system;

    /**
     * YaML Table Definition Language Parse
     * 
     * @package fpcm\model\system
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.2.0
     */
    class yatdl extends \fpcm\model\abstracts\staticModel {

        /**
         * Datentypen mit Längen-Angabe
         * @var \nkorg\yatdl\yatdl
         * @since FPCM 3.6
         */
        protected $parser;

        /**
         * Konstruktor
         * @param string $filePath
         */
        public function __construct($filePath) {

            include_once \fpcm\classes\loader::libGetFilePath('spyc', 'Spyc.php');
            include_once \fpcm\classes\loader::libGetFilePath('nkorg/yatdl', 'parser.php');
            
            $this->parser = new \nkorg\yatdl\parser(
                \Spyc::YAMLLoad($filePath),
                \fpcm\classes\baseconfig::$fpcmDatabase->getDbtype(),
                \fpcm\classes\baseconfig::$fpcmDatabase->getYaTDLDataTypes()
            );

        }

        /**
         * Setzt zusätzliches Tabellen-Prefix
         * @param string $tablePrefix
         * @since FPCM 3.4
         */
        public function setTablePrefix($tablePrefix) {
            $this->parser->setTablePrefix($tablePrefix);
        }
        
        /**
         * Parst Array aus YAML-String in SQL-String
         * @return boolean
         */
        public function parse() {
            return $this->parser->parse();
        }
        
        /**
         * Gibt fertigen SQL-String zurück
         * @return string
         */
        public function getSqlString() {
            return $this->parser->getSqlString();
        }
        
        /**
         * Debug-Ausgabe von geparstem YAML-String
         * @return void
         */
        public function dumpYamlArray() {
            $this->parser->dumpYamlArray();
        }
        
        /**
         * Gibt geparsten YAML-String als Array zurück
         * @return array
         * @since FPCM 3.3.2
         */
        public function getArray() {            
            return $this->parser->getArray();
        }

    }
