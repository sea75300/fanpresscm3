<?php

    namespace fpcm\model\theme;

    /**
     * ACP navigation item object
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2017, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @package fpcm\model\theme
     * @since FPCM 3.5
     */ 
    class navigationItem extends \fpcm\model\abstracts\staticModel {

        /**
         * im Navigation angezeigte Beschreibung
         * @var string
         */
        protected $description  = '';

        /**
         * Ziellink
         * @var string
         */
        protected $link         = '';

        /**
         * CSS-Klassen für Icon
         * @var string
         */
        protected $icon         = '';

        /**
         * allgemeine CSS-Klassen
         * @var string
         */
        protected $class        = '';

        /**
         * Item-ID
         * @var string
         */
        protected $id           = '';

        /**
         * Eltern-Bereich des Menü-Eintrages
         * @var string
         */
        protected $parent       = 'after';

        /**
         * Berechtigungen
         * @var array
         */
        protected $permission   = [];

        /**
         * Untermenü, array mit Elementen vom Typ navigationItem
         * @var array
         */
        protected $submenu      = [];

        /**
         * Status, ob Zeil gerade aktiv ist
         * @var bool
         */
        protected $active      = false;

        /**
         * aktuell ausgewähltes Modul
         * @var string
         */
        private $currentModule = '';

        /**
         * Konstruktor
         */
        public function __construct() {
            
            parent::__construct();
            $this->id            = uniqid('fpcm-nav-item');
            $this->currentModule = \fpcm\classes\tools::getNavigationActiveCheckStr();
            
        }

        /**
         * Beschreibung zurückgeben
         * @return string
         */
        public function getDescription() {
            return $this->description;
        }

        /**
         * Ziellink zurückgeben
         * @return string
         */
        public function getLink() {
            return $this->link;
        }

        /**
         * CSS-Klassen für Icon zurückgeben
         * @return string
         */
        public function getIcon() {
            return $this->icon;
        }

        /**
         * allgemeine CSS-Klassen zurückgeben
         * @return string
         */
        public function getClass() {
            return $this->class;
        }

        /**
         * Item-ID zurückgeben
         * @return string
         */
        public function getId() {
            return $this->id;
        }

        /**
         * Eltern-Bereich zurückgeben
         * @return string
         */
        public function getParent() {
            return $this->parent;
        }
        
        /**
         * Berechtigungen zurückgeben
         * @return array
         */
        public function getPermission() {
            return $this->permission;
        }

        /**
         * Untermenü-Elemente zurückgegen
         * @return array
         */
        public function getSubmenu() {
            return $this->submenu;
        }

        /**
         * Beschreibung setzen
         * @param string $description
         */
        public function setDescription($description) {
            $this->description = $description;
        }

        /**
         * Ziellink setzen
         * @param string $link
         */
        public function setLink($link) {
            $this->link = $link;
        }

        /**
         * CSS-Klassen für Icon setzen
         * @param string $icon
         */
        public function setIcon($icon) {
            $this->icon = $icon;
        }

        /**
         * allgemeine CSS-Klassen setzen
         * @param string $class
         */
        public function setClass($class) {
            $this->class = $class;
        }

        /**
         * Item-ID setzen
         * @param string $id
         */
        public function setId($id) {
            $this->id = $id;
        }

        /**
         * Eltern-Bereich setzen
         * @param string $parent
         */
        public function setParent($parent) {
            $this->parent = $parent;
        }
                
        /**
         * Berechtigungen setzen
         * @param array $permission
         */
        public function setPermission(array $permission) {
            $this->permission = $permission;
        }

        /**
         * Untermenü-Array füllen
         * @param array $submenu
         */
        public function setSubmenu(array $submenu) {
            $this->submenu = $submenu;
        }

        /**
         * Status zurückgeben, ob Ziel aktiv ist
         * @return bool
         */
        public function isActive() {
            return ( substr($this->link, 0, strlen($this->currentModule)) === $this->currentModule ? true : false );
        }

    }
