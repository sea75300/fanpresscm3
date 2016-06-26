<?php
    /**
     * System timezone trait
     * 
     * System timezone trait
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\traits\common;
    
    /**
     * Zeitzonen trait
     * 
     * @package fpcm.controller.traits.common.timezone
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    trait timezone {
        
        /**
         * Gibt übersetzte Zeitzonen zurück
         * @return array
         */
        public function getTimeZones() {
            $timezones = array();
            
            foreach ($this->lang->translate('SYSTEM_OPTIONS_TZ') as $timeZoneArea => $timeZoneAreaName) {
                $timezones[$timeZoneAreaName] = \DateTimeZone::listIdentifiers($timeZoneArea);
            }
            return $timezones;
        }
    }
?>