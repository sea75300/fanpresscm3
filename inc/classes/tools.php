<?php
    /**
     * FanPress CM internal tools class
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @since FPCM 3.1.2
     */

    namespace fpcm\classes;

    /**
     * Internal tools class
     * 
     * @package fpcm.classes.baseconfig
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @since FPCM 3.1.2
     */     
    final class tools {
        
        /**
         * Erzeugt für Wert in $value einen String mit passender Einheit und Anzahl Dezimalstellen
         * von Byte (B) bis Terrabyte/Tebibyte (TB/TiB)
         * @param number $value ein numerischer Wert
         * @param int $decimals Anzahl Dezimalstellen, Default = 2
         * @param string $delimDec Dezimal-Trennzeichen
         * @param string $delimTousands Tausender-Trennzeichen
         * @return string
         * @since FPCM 3.1.2
         */
        public static function calcSize($value, $decimals = 2, $delimDec = ',', $delimTousands = '.') {

            if (!is_numeric($value)) {
                return $value;
            }

            $sizeUnits = array('B', 'KiB', 'MiB', 'GiB', 'TiB');
            
            $unitIdx = 0;
            while ($value > 1024) {
                $value = $value / 1024;
                $unitIdx++;
            }
            
            $suffix = isset($sizeUnits[$unitIdx]) ? $sizeUnits[$unitIdx] : ' ?';
            return number_format($value, $decimals, $delimDec, $delimTousands).' '.$suffix;
            
        }        
    }
?>