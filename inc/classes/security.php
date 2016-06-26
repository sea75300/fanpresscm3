<?php
    /**
     * FanPress CM Security class
     * 
     * Security class
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\classes;
    
    /**
     * Security class
     * 
     * @package fpcm.classes.security
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    final class security {        
        
        /**
         * Passwort Check RegEx
         */
        const regexPasswordCkeck = "/^.*(?=.{6,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/";
        
        /**
         * Cookie-Name zurückgeben
         * @return string
         */
        public static function getSessionCookieName() {
            return 'fpcm_sid'.md5(baseconfig::$rootPath.'_'.date('d-m-Y'));
        }
        
        /**
         * Page-Token-Feld-Name zurückgeben
         * @return string
         */
        public static function getPageTokenFieldName() {
            return hash('sha256', 'pagetoken'.baseconfig::$rootPath.'_'.date('d-m-Y').'$'.http::getOnly('module'));
        }
        
        /**
         * gibt Inhalt von Session cookie zurück
         * @return string
         */
        public static function getSessionCookieValue() {            
            return http::cookieOnly(self::getSessionCookieName(), array(1,4,7));
        }
                
        /**
         * gibt Inhalt von Session cookie zurück
         * @return string
         */
        public static function createSessionId() {
            return hash('sha256', self::getSecureBaseString());
        }         
        
        /**
         * Passwort-Hash erzeugen
         * @param string $password
         * @param string $salt
         * @return string
         */
        public static function createPasswordHash($password, $salt) {            
            return crypt($password, $salt);
        }
        
        /**
         * Passwort-Salt erzeugen
         * @param string $additional
         * @return string
         */
        public static function createSalt($additional = '') {
            return '$5$'.substr(hash('sha256', self::getSecureBaseString()), 0, 16).'$';
        }
        
        /**
         * Erzeugt Page-Token zur Absicherung gegen 
         * @return string
         */
        public static function createPageToken() {
            $str = hash('sha256', '$'.baseconfig::$rootPath.'$pageToken$'.self::getSessionCookieValue().'$'.http::getOnly('module').'$');

            $cache = new cache(self::getPageTokenFieldName());
            $cache->cleanup(self::getPageTokenFieldName());
            $cache->write($str, FPCM_PAGETOKENCACHE_TIMEOUT);            
            unset($cache);
            
            return $str;
        }

        /**
         * Erzeugt Basis-String für Hash-Funktionen
         * @return string
         */
        private static function getSecureBaseString() {
            return uniqid('fpcm', true).'#'.microtime(true).'#'.md5($_SERVER['HTTP_HOST']).'#'.mt_rand(0, mt_getrandmax());
        }
        
    }
