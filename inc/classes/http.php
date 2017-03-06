<?php
    /**
     * FanPress CM HTTP request class
     * 
     * Handler für $_GET, $_POST, $_COOKIE, $_FILES, $_SESSION
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\classes;

    /**
     * HTTP handler class
     * 
     * @package fpcm\classes\http
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    final class http {
        
        /**
         * HTTP-Reuqest aus $_REQUEST und $_COOKIE
         * @var array
         */
        private static $request;

        /**
         * HTTP initialisieren
         */
        public static function init() {
            self::$request = array_merge($_REQUEST, $_COOKIE);
        }

        /**
         * Daten aus $_REQUEST, $_POST, $_GET, $_COOKIE auslesen
         * Ersetz für direkten Zugriff auf $_REQUEST, $_POST, $_GET, $_COOKIE!!!
         * @param string $varname Variablenname
         * @param array $filter Filter vor Rückgabe durchführen, @see http::filter()
         * @return mixed null wenn Variable nicht gesetzt
         */
        public static function get($varname = null, array $filter = array(1,4,7)) {
            if (is_null($varname)) return self::$request;
            $returnVal = (isset(self::$request[$varname])) ? self::filter(self::$request[$varname], $filter) : null;
            return $returnVal;            
        }

        /**
         * Daten aus $_POST
         * Ersetz für direkten Zugriff auf $_POST
         * @param string $varname Variablenname
         * @param array $filter Filter vor Rückgabe durchführen, @see http::filter()
         * @return mixed null wenn Variable nicht gesetzt
         */
        public static function postOnly($varname = null, array $filter = array(1,4,7)) {
            if (is_null($varname)) return $_POST;
            $returnVal  = (isset($_POST[$varname])) ? self::filter($_POST[$varname], $filter) : null;
            return $returnVal;
        }

        /**
         * Daten aus $_GET
         * Ersetz für direkten Zugriff auf $_GET
         * @param string $varname Variablenname
         * @param array $filter Filter vor Rückgabe durchführen, @see http::filter()
         * @return mixed null wenn Variable nicht gesetzt
         */
        public static function getOnly($varname = null, array $filter = array(1,4,7)) {
            if (is_null($varname)) return $_GET;
            $returnVal  = (isset($_GET[$varname])) ? self::filter($_GET[$varname], $filter) : null;
            return $returnVal;
        }

        /**
         * Daten aus $_COOKIE
         * Ersetz für direkten Zugriff auf $_COOKIE
         * @param string $varname Variablenname
         * @param array $filter Filter vor Rückgabe durchführen, @see http::filter()
         * @return mixed null wenn Variable nicht gesetzt
         */
        public static function cookieOnly($varname = null, array $filter = array(1,4,7)) {
            return (isset($_COOKIE[$varname])) ? self::filter($_COOKIE[$varname], $filter) : null;
        }
        
        /**
         * Gibt IP-Adresse des aktuellen Nutzers zurück
         * @return string
         */
        public static function getIp() {
            return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        }
        
        /**
         * Gibt HTTP-Host des aktuellen Nutzers zurück
         * @return string
         */
        public static function getHttpHost() {
            return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
        }
        
        /**
         * Gibt Page-Token-Informationen zurück
         * @return string
         */
        public static function getPageToken() {
            return self::postOnly(security::getPageTokenFieldName());
        }

        /**
         * Gibt Inhalt von Dateiupload via PHP zurück
         * @return array
         */
        public static function getFiles() {
            return (isset($_FILES['files']) && count($_FILES['files'])) ? $_FILES['files'] : null;
        }

        /**
         * Ließt Daten aus $_SESSION
         * @param string $varName
         * @return mixed false, wenn Variable nicht gesetzt
         */
        public static function getSessionVar($varName) {  
            return isset($_SESSION[$varName]) ? $_SESSION[$varName] : false;            
        }

        /**
         * Schreibt Daten in $_SESSION
         * @param string $varName
         * @param mixed $value
         */
        public static function setSessionVar($varName, $value) {            
            $_SESSION[$varName] = $value;
        }

        /**
         * Führt Filter auf einen String aus,
         * Verwendung v. A. für Werte aus Formularen, etc.
         * 
         * @param string $filterString
         * @param array $filters
         * * 1 - strip_tags
         * * 2 - htmlspecialchars
         * * 3 - htmlentities
         * * 4 - stripslashes
         * * 5 - htmlspecialchars_decode
         * * 6 - html_entity_decode
         * * 7 - trim
         * * 8 - json_decode
         * * 9 - (int)-Cast
         * 
         * * allowedtags - erlaubte HTML-Tags für "1 - strip_tags"
         * * mode - Modus für
         * * * "2 - htmlspecialchars"
         * * * "3 - htmlentities",
         * * * "5 - htmlspecialchars_decode"
         * * * "6 - html_entity_decode"
         * * object - json_decode-Ergebnis als Objekt oder Array
         * 
         * @return mixed
         */
        public static function filter($filterString, array $filters) {

            if (!$filterString) {
                return $filterString;
            }
            
            if (is_array($filterString)) {  
                foreach ($filterString as $value) {
                    static::filter($value, $filters);
                }
                return $filterString;
            }
            
            $allowedTags = (isset($filters['allowedtags'])) ? $filters['allowedtags'] : '';
            $htmlMode    = isset($filters['mode']) ? $filters['mode'] : (ENT_COMPAT | ENT_HTML401);
            foreach ($filters as $filter) {          
                $filter = (int) $filter;
                switch ($filter) {
                    case 1 :
                        $filterString = strip_tags($filterString, $allowedTags);
                    break;
                    case 2 :
                        $filterString = htmlspecialchars($filterString, $htmlMode);
                    break;
                    case 3 :
                        $filterString = htmlentities($filterString, $htmlMode);
                    break;
                    case 4 :
                        $filterString = stripslashes($filterString);
                    break;
                    case 5 :
                        $filterString = htmlspecialchars_decode($filterString, $htmlMode);
                    break;
                    case 6 :
                        $filterString = html_entity_decode($filterString, $htmlMode);
                    break;
                    case 7 :
                        $filterString = trim($filterString);
                    break;
                    case 8 :
                        $filterString = json_decode($filterString, ($filters['object'] ? false : true));
                    break;
                    case 9 :
                        $filterString = (int) $filterString;
                    break;
                    case 10 :
                        $crypt = new crypt();
                        $filterString = $crypt->decrypt($filterString);
                    break;
                    case 11 :
                        $filterString = urldecode($filterString);
                    break;
                }
            }            
            
            return $filterString;             
        }
        
    }
