<?php
    /**
     * View helper
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\view;

    /**
     * View Helper
     * 
     * @package fpcm.model.view
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class helper {
        
        /**
         * Objekt vom typ \fpcm\classes\language
         * @var \fpcm\classes\language
         */
        protected static $language;

        /**
         * Sprache für View-Helper initialisieren
         * @param string $langCode
         */
        public static function init($langCode) {
            self::$language = new \fpcm\classes\language($langCode);
        }

        /**
         * Erzeugt Speichern Button
         * @param string $name Name des Buttons
         */
        public static function saveButton($name) {         
            self::button('submit', $name, 'GLOBAL_SAVE', 'fpcm-save-btn fpcm-loader');
        }

        /**
         * Erzeugt Speichern Button
         * @param string $name Name des Buttons
         */
        public static function deleteButton($name) {         
            self::button('submit', $name, 'GLOBAL_DELETE', 'fpcm-delete-btn fpcm-loader');
        }
        
        /**
         * Erzeugt Zuürcksetzten Button
         * @param string $name Name des Buttons
         */        
        public static function resetButton($name) {           
            self::button('reset', $name, 'GLOBAL_RESET', 'fpcm-save-reset');
        }        
        
        /**
         * 
         * Erzeugt Senden Button
         * @param string $name Name des Buttons
         * @param string $descr Beschreibung des Buttons
         * @param string $class CSS-Klasse
         */
        public static function submitButton($name, $descr, $class = '') {   
            self::button('submit', $name, $descr, 'fpcm-submit-button '.$class);
        }
        
        /**
         * Erzeugt Button
         * @param string $type Button-Type
         * @param string $name Name des Buttons
         * @param string $descr Beschreibung des Buttons
         * @param string $class CSS-Klasse
         */
        public static function button($type, $name, $descr, $class = '') {            
            $name = ucfirst($name);            
            $descr = self::$language->translate($descr) ? self::$language->translate($descr) : $descr;
            print "<button type=\"$type\" class=\"fpcm-ui-button $class\" name=\"btn{$name}\" id=\"btn".self::cleanIdName($name)."\">$descr</button>";
        }
        
        /**
         * Erzeugt Link-basierten Button
         * @param string $href Ziel-URL
         * @param string $descr Beschreibung
         * @param string $id Button-ID
         * @param string $class CSS-Klasse
         * @param string $target Link-Target
         */
        public static function linkButton($href, $descr, $id = '', $class = '', $target = '_self') {
            $descr = self::$language->translate($descr) ? self::$language->translate($descr) : $descr;            
            print "<a href=\"$href\" class=\"fpcm-ui-button $class\" id=\"".self::cleanIdName($id)."\" target=\"$target\">$descr</a>\n";
        }
        
        /**
         * Erzeugt Button-Dummy
         * @param string $descr Beschreibung
         * @param string $class CSS-Klasse
         */
        public static function dummyButton($descr, $class = '') {
            $descr = self::$language->translate($descr) ? self::$language->translate($descr) : $descr;            
            print "<span class=\"fpcm-ui-button $class\">$descr</span>\n";
        }        
        
        /**
         * Erzeugt Link-basierte Bearbeiten-Button
         * @param string $href Ziel-URL Ziel-URL
         * @param bool $active Button ist aktiv
         * @param string $class CSS-Klasse
         */
        public static function editButton($href, $active = true, $class = '') {
            
            if (!$active) {
                print "<span class=\"fpcm-ui-button fpcm-ui-button-edit fpcm-ui-readonly\">".self::$language->translate('GLOBAL_EDIT')."</span>\n";
                return;
            }
            
            print "<a href=\"$href\" class=\"fpcm-ui-button fpcm-loader fpcm-ui-button-edit $class\">".self::$language->translate('GLOBAL_EDIT')."</a>\n";
        }
        
        /**
         * Erzeugt Input
         * @param string $name Name des Buttons
         * @param string $class CSS-Klasse
         * @param string $value Wert
         * @param bool $readonly readonly Status
         * @param int $maxLenght maximale Länge für Feld-Eingabe
         * @param string $placeholder Platzhalter-Text
         */
        public static function textInput($name, $class = '', $value = '', $readonly = false, $maxLenght = 255, $placeholder = false) {
            $html   = array();
            $html[] = "<input type=\"text\" class=\"fpcm-ui-input-text $class\" name=\"$name\" id=\"".self::cleanIdName($name)."\" value=\"".htmlentities($value, ENT_QUOTES)."\" maxlenght=\"$maxLenght\"";
            if ($readonly) $html[] = " readonly=\"readonly\"";
            if ($placeholder) $html[] = " placeholder=\"$placeholder\"";
            if ($placeholder && \fpcm\model\abstracts\view::isBrowser('MSIE 9.0')) {
                $html[] = " title=\"$placeholder\"";
            }
            
            $html[] = ">\n";
            
            print implode('', $html);
        }
        
        /**
         * Erzeugt hidden Inout-Feld
         * @param string $name Name des Buttons
         * @param string $value Wert
         */
        public static function hiddenInput($name, $value = '') {
            print "<input type=\"hidden\" name=\"$name\" id=\"".self::cleanIdName($name)."\" value=\"".htmlentities($value, ENT_QUOTES)."\">\n";
        }       
        
        /**
         * Erzeugt Passwort-Input
         * @param string $name Name des Buttons
         * @param string $class CSS-Klasse
         * @param string $value Wert
         * @param bool $readonly readonly Status
         * @param int $maxLenght maximale Länge für Feld-Eingabe
         * @param sting $placeholder HTML5-Platzhalter-Text
         */
        public static function passwordInput($name, $class = '', $value = '', $readonly = false, $maxLenght = 255, $placeholder = false) {
            $html   = array();
            $html[] = "<input type=\"password\" class=\"fpcm-ui-input-text $class\" name=\"$name\" id=\"".self::cleanIdName($name)."\" value=\"".htmlentities($value, ENT_QUOTES)."\" maxlenght=\"$maxLenght\"";
            if ($readonly) $html[] = " readonly=\"readonly\"";
            if ($placeholder) $html[] = " placeholder=\"$placeholder\"";
            if ($placeholder && \fpcm\model\abstracts\view::isBrowser('MSIE 9.0')) {
                $html[] = " title=\"$placeholder\"";
            }
            $html[] = ">\n";
            
            print implode('', $html);
        }
        
        /**
         * Erzeugt Checkbox
         * @param string $name Name des Buttons
         * @param string $class CSS-Klasse
         * @param string $value Wert
         * @param string $descr Beschreibung
         * @param string $id Button-ID
         * @param bool $selected Checkbox ist vorausgewählt
         * @param bool $readonly readonly Status
         */
        public static function checkbox($name, $class = '', $value = '', $descr = '', $id = '', $selected = true, $readonly = false) {
            $descr = self::$language->translate($descr) ? self::$language->translate($descr) : $descr;
            
            $html   = array();
            $html[] = "<input type=\"checkbox\" class=\"fpcm-ui-input-checkbox $class\" name=\"$name\" id=\"".self::cleanIdName($id)."\" value=\"".htmlentities($value, ENT_QUOTES)."\"";
            if ($readonly) $html[] = " readonly=\"readonly\"";
            if ($selected) $html[] = " checked=\"checked\"";
            $html[] = "> <label for=\"".self::cleanIdName($id)."\">$descr</label>\n";
            
            print implode('', $html);
        }
        
        /**
         * Erzeugt Radiobutton
         * @param string $name Name des Buttons
         * @param string $class CSS-Klasse
         * @param string $value Wert
         * @param string $descr Beschreibung
         * @param string $id Button-ID
         * @param bool $selected Checkbox ist vorausgewählt
         * @param bool $readonly readonly Status
         */
        public static function radio($name, $class = '', $value = '', $descr = '', $id = '', $selected = true, $readonly = false) {
            $descr = self::$language->translate($descr) ? self::$language->translate($descr) : $descr;
            
            $html   = array();
            $html[] = "<input type=\"radio\" class=\"fpcm-ui-input-checkbox $class\" name=\"$name\" id=\"".self::cleanIdName($id)."\" value=\"".htmlentities($value, ENT_QUOTES)."\"";
            if ($readonly) $html[] = " readonly=\"readonly\"";
            if ($selected) $html[] = " checked=\"checked\"";
            $html[] = "> <label for=\"$id\">$descr</label>\n";
            
            print implode('', $html);
        }
        
        /**
         * Erzeugt Textarea
         * @param string $name Name des Buttons
         * @param string $class CSS-Klasse
         * @param string $value Wert
         * @param bool $readonly readonly Status
         */
        public static function textArea($name, $class = '', $value = '', $readonly = false) {
            $html   = array();
            $html[] = "<textarea type=\"text\" class=\"fpcm-ui-textarea $class\" name=\"$name\" id=\"".self::cleanIdName($name)."\"";
            if ($readonly) $html[] = " readonly=\"readonly\"";
            $html[] = ">".htmlentities($value, ENT_QUOTES)."</textarea>\n";
            
            print implode('', $html);            
        }
        
        /**
         * Erzeugt Select-Menü
         * @param string $name Name des Buttons
         * @param array $options Array mit Optionen für das Auswahlmenü
         * @param string $selected vorausgewähltes Element
         * @param bool $firstEmpty erstes Element soll leer sein
         * @param bool $firstEnabled erstes Element wird automatisch erzeugt
         * @param bool $readonly readonly Status
         * @param string $class CSS-Klasse
         */
        public static function select($name, $options, $selected = null, $firstEmpty = false, $firstEnabled = true, $readonly = false, $class = '') {
            $optionsString = '';
            
            if ($firstEnabled) $optionsString = ($firstEmpty) ? '<option value=""></option>' : '<option value="">'.self::$language->translate('GLOBAL_SELECT').'</option>';            
            foreach ($options as $key => $value) {
                $optionsString .= "<option value=\"".htmlentities($value, ENT_QUOTES)."\"";
                if (!is_null($selected) && $value == $selected) $optionsString .= " selected=\"selected\"";
                $optionsString .= ">".htmlentities($key, ENT_QUOTES)."</option>";
            }
            
            $id = self::cleanIdName($name);
            
            $html   = array();
            $html[] = "<select name=\"$name\" id=\"$id\" class=\"fpcm-ui-input-select $class\"";
            if ($readonly) $html[] = " disabled=\"disabled\"";
            $html[] = ">$optionsString</select>\n";
            
            print implode('', $html);            
        }   
        
        /**
         * Erzeugt gruppiertes Select-Menü
         * @param string $name Name des Buttons
         * @param array $options Array mit Optionen für das Auswahlmenü
         * @param string $selected vorausgewähltes Element
         * @param bool $readonly readonly Status
         */
        public static function selectGroup($name, $options, $selected = null, $readonly = false) {
            $optionsString = '';
            foreach ($options as $key => $value) {               
                $optionsString .= "<optgroup label=\"".htmlentities($key, ENT_QUOTES)."\">";
                $optionsString .= self::selectOptions($value, $selected, true);
                $optionsString .= "</optgroup>";
            }
            
            $id = self::cleanIdName($name);
            
            $html   = array();
            $html[] = "<select name=\"$name\" id=\"$id\" class=\"fpcm-ui-input-select\"";
            if ($readonly) $html[] = " disabled=\"disabled\"";
            $html[] = ">$optionsString</select>\n";
            
            print implode('', $html);             
            
        } 
        
        /**
         * Erzeugt Option für Select-Menü
         * @param array $options Array mit Optionen für das Auswahlmenü
         * @param string $selected vorausgewähltes Element
         * @param bool $return Werte sollen zurückgegeben werden
         * @return string
         */
        public static function selectOptions($options, $selected = null, $return = false) {
            $optionsString = '';
            
            foreach ($options as $key => $value) {
                $optionsString .= "<option value=\"".htmlentities($value, ENT_QUOTES)."\"";
                if (!is_null($selected) && $value == $selected) $optionsString .= " selected=\"selected\"";
                $optionsString .= ">".htmlentities($key, ENT_QUOTES)."</option>";
            }
            
            if ($return) return $optionsString;
            
            print $optionsString;
            
        }
        
        /**
         * Setzt bool-Wert in Text ja/nein um
         * @param bool $value Wert
         */
        public static function boolToText($value) {
            print ($value) ? '<span class="fa fa-check-square fpcm-ui-booltext-yes" title="'.self::$language->translate('GLOBAL_YES').'"></span>' : '<span class="fa fa-minus-square fpcm-ui-booltext-no" title="'.self::$language->translate('GLOBAL_NO').'"></span>';
        }
        
        /**
         * Erzeugt Ja/nein Select-Menü
         * @param string $name Name des Buttons
         * @param array $selected
         * @param bool $readonly readonly Status
         * @param string $class CSS-Klasse
         * @return string
         */
        public static function boolSelect($name, $selected, $readonly = false, $class = '') {            
            $options = array(self::$language->translate('GLOBAL_YES') => 1, self::$language->translate('GLOBAL_NO') => 0);
            return self::select($name, $options, $selected, false, false, $readonly, $class);
        }
        
        /**
         * CSS-Klassen-Containter für Button-Toolbar
         * @return void
         */
        public static function buttonsContainerClass() {
            print 'fpcm-buttons fpcm-buttons-fixed ui-widget-header ui-corner-tl ui-corner-bl';
        }
        
        /**
         * Werte in View escapen als Schutz gegen XSS, etc.
         * @param string $value
         * @param int $mode
         * @return string
         */
        public static function escapeVal($value, $mode = false) {
            return htmlentities($value, ($mode ? (int) $mode : ENT_COMPAT | ENT_HTML5));
        }

        /**
         * IDs aufräumen
         * @param string $text ID-String
         * @return string
         */
        private static function cleanIdName($text) {
            return trim(str_replace(array('[','(',')',']','-'), '', $text));
        }
    }
?>