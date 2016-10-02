<?php
    /**
     * FanPress CM example logsfile
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\modules\nkorg\example\model;

    class logfile {

        public static function logParams($params) {

            $params = is_array($params) || is_object($params) ? print_r($params, true) : $params;
            $params = date(DATE_W3C).PHP_EOL.$params;
            file_put_contents(\fpcm\classes\baseconfig::$logDir.'nkorg_example.log', $params.PHP_EOL.PHP_EOL, FILE_APPEND);

        }

        public static function getLog() {

            $data = file_get_contents(\fpcm\classes\baseconfig::$logDir.'nkorg_example.log');

            if ($data === false) {
                return '';
            }

            return $data;

        }
        
    }