<?php
    /**
     * FanPress CM constants
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    if (file_exists(dirname(__DIR__).'/data/config/constants.custom.php')) {
        include_once dirname(__DIR__).'/data/config/constants.custom.php';
    }

    if (!defined('FPCM_DEBUG')) {
        /**
         * Debug-Modus aktivieren
         */
        define ('FPCM_DEBUG', false);
    }
    
    if (!defined('FPCM_DEBUG_SQL')) {
        /**
         * SQL-Debug-Modus aktivieren
         */
        define ('FPCM_DEBUG_SQL', false);
    }
    
    if (!defined('FPCM_MODULE_IGNORE_DEPENDENCIES')) {
        /**
         * ModulAbhängigkeiten ignorieren
         */
        define ('FPCM_MODULE_IGNORE_DEPENDENCIES', false);
    }
    
    if (!defined('FPCM_IGNORE_INSTALLER_DISABLED')) {
        /**
         * aktiven Installer ignorieren
         */
        define ('FPCM_IGNORE_INSTALLER_DISABLED', false);
    }
    
    if (!defined('FPCM_UPDATER_DEVCHECK')) {
        /**
         * verfügbare Beta/ RC Versionen bei Update-Check anzeigen
         */
        define ('FPCM_UPDATER_DEVCHECK', false);
    }
    
    if (!defined('FPCM_UPDATE_CRONNOTIFY_EMAIL')) {        
        /**
         * Benachrichtigung über neue verfügbare Updates bei Cronjob-Ausführung verhindern
         */
        define ('FPCM_UPDATE_CRONNOTIFY_EMAIL', true);
    }

    if (!defined('FPCM_CONTROLLER_SYSUPDATES')) {
        /**
         * System-Update-Controller-Action
         */
        define ('FPCM_CONTROLLER_SYSUPDATES', 'package/sysupdate');
    }
    
    if (!defined('FPCM_ACP_ARTICLELIST_LIMIT')) {
        /**
         * Anzahl Elemente in ACP-Artikel-Liste
         * @deprecated since FPCM 3.1.0, moved to system options
         */        
        define ('FPCM_ACP_ARTICLELIST_LIMIT', 100);
    }
    
    if (!defined('FPCM_ACP_LOGINFAILED_LIMIT')) {
        /**
         * Anzahl an Fehlerlogins bis Sperre
         * @deprecated since FPCM 3.1.0, moved to system options
         */        
        define ('FPCM_ACP_LOGINFAILED_LIMIT', 5);
    }
    
    if (!defined('FPCM_UPDATER_MANUALCHECK')) {
        /**
         * Interval für manuellen Update-Check
         */
        define ('FPCM_UPDATER_MANUALCHECK', 3600 * 24 * 14);
    }
    
    if (!defined('FPCM_LANGCACHE_TIMEOUT')) {
        /**
         * Timeout für Sprach-Cache
         */
        define ('FPCM_LANGCACHE_TIMEOUT', 3600 * 24 * 31);
    }
    
    if (!defined('FPCM_PAGETOKENCACHE_TIMEOUT')) {
        /**
         * Timeout für Pagetoken-Cache
         */
        define ('FPCM_PAGETOKENCACHE_TIMEOUT', 3600 * 5);
    }
    
    if (!defined('FPCM_COMMENT_MARKSPAM_PASTCHECK')) {
        /**
         * Anzahl an Spam deklarierter vorhandener Kommentare, wenn ein neuer Kommentar geschrieben wird
         * Nutzung in Default-Captcha-Plugin
         * @deprecated since FPCM 3.1.0, moved to system options
         */
        define ('FPCM_COMMENT_MARKSPAM_PASTCHECK', 2);
    }
    
    if (!defined('FPCM_DEFAULT_LANGUAGE_CODE')) {
        /**
         * Standard-Sprachcode
         */
        define ('FPCM_DEFAULT_LANGUAGE_CODE', 'de');
    }
    
    if (!defined('FPCM_CACHE_DEBUG')) {
        /**
         * Cache-Datei-Namen nicht hashen
         * @since FPCM 3.2
         */
        define ('FPCM_CACHE_DEBUG', false);
    }