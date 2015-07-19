<?php
    /**
     * Common inits
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    error_reporting(0);

    /**
     * FanPress CM internal checkpoint
     */
    define('IN_FPCM', true);

    include __DIR__.'/classes/baseconfig.php';
    include __DIR__.'/constants.php';
    include __DIR__.'/functions.php';
    
    spl_autoload_register('fpcmAutoLoader');
    set_error_handler("fpcmErrorHandler");   
    
    \fpcm\classes\baseconfig::init();
    
?>