<?php
    /**
     * Libary loader class
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\classes;
    
    /**
     * Libary loader
     * 
     * @package fpcm.classes.loader
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    final class loader {
        
        /**
         * Dateipfad zurückgeben
         * @param string $libname
         * @param string $libfile
         * @param string $subpaths
         * @return string
         */
        public static function libGetFilePath($libname, $libfile, $subpaths = '') {      

            $path = baseconfig::$incDir.'lib/'.$libname.'/'.trim($subpaths, '/').$libfile;
            
            if (!file_exists($path)) {
                trigger_error('Lib path '.$path.' does not exists!');
                return '';
            }
            
            return $path;
        }
        
        /**
         * Dateiurl zurückgeben
         * @param string $libname
         * @param string $libfile
         * @param string $subpaths
         * @return string
         */
        public static function libGetFileUrl($libname, $libfile = '', $subpaths = '') {
            
            if (!$libfile) return baseconfig::$rootPath.'inc/lib/'.$libname.'/';
            
            $path = 'inc/lib/'.$libname.'/'.trim($subpaths, '/').$libfile;

            if (!file_exists(baseconfig::$incDir.'lib/'.$libname.'/'.trim($subpaths, '/').$libfile)) {
                trigger_error('Lib path '.$path.' does not exists!');
                return '';
            }
            
            return baseconfig::$rootPath.$path;
        }
        
        
    }
