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

    /**
     * Debug-Modus aktiviere
     */
    if (!defined('FPCM_DEBUG')) define ('FPCM_DEBUG', false);
    
    /**
     * SQL-Debug-Modus aktiviere
     */
    if (!defined('FPCM_DEBUG_SQL')) define ('FPCM_DEBUG_SQL', false);
    
    /**
     * ModulAbhängigkeiten ignorieren
     */
    if (!defined('FPCM_MODULE_IGNORE_DEPENDENCIES')) define ('FPCM_MODULE_IGNORE_DEPENDENCIES', false);
    
    /**
     * aktiven Installer ignorieren
     */
    if (!defined('FPCM_IGNORE_INSTALLER_DISABLED')) define ('FPCM_IGNORE_INSTALLER_DISABLED', false);
    
    /**
     * verfügbare Beta/ RC Versionen bei Update-Check anzeigen
     */
    if (!defined('FPCM_UPDATER_DEVCHECK')) define ('FPCM_UPDATER_DEVCHECK', false);
    
    /**
     * Benachrichtigung über neue verfügbare Updates bei Cronjob-Ausführung verhindern
     */
    if (!defined('FPCM_UPDATE_CRONNOTIFY_EMAIL')) define ('FPCM_UPDATE_CRONNOTIFY_EMAIL', true);

    /**
     * System-Update-Controller-Action
     */
    if (!defined('FPCM_CONTROLLER_SYSUPDATES')) define ('FPCM_CONTROLLER_SYSUPDATES', 'package/sysupdate');
    
    /**
     * Anzahl Elemente in ACP-Artikel-Liste
     */
    if (!defined('FPCM_ACP_ARTICLELIST_LIMIT')) define ('FPCM_ACP_ARTICLELIST_LIMIT', 100);
    
    /**
     * Anzahl an Fehlerlogins bis Sperre
     */
    if (!defined('FPCM_ACP_LOGINFAILED_LIMIT')) define ('FPCM_ACP_LOGINFAILED_LIMIT', 5);
    
    /**
     * Interval für manuellen Update-Check
     */
    if (!defined('FPCM_UPDATER_MANUALCHECK')) define ('FPCM_UPDATER_MANUALCHECK', 3600 * 24 * 14);
    
    /**
     * Timeout für Sprache-Cache
     */
    if (!defined('FPCM_LANGCACHE_TIMEOUT')) define ('FPCM_LANGCACHE_TIMEOUT', 3600 * 24);
    
    /**
     * Anzahl an Spam deklarierter vorhandener Kommentare, wenn ein neuer Kommentar geschrieben wird
     * Nutzung in Default-Captcha-Plugin
     */
    if (!defined('FPCM_COMMENT_MARKSPAM_PASTCHECK')) define ('FPCM_COMMENT_MARKSPAM_PASTCHECK', 2);
    
    /**
     * Standard-Sprachcode
     */
    if (!defined('FPCM_DEFAULT_LANGUAGE_CODE')) define ('FPCM_DEFAULT_LANGUAGE_CODE', 'de');