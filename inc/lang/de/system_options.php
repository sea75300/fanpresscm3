<?php
    /**
     * System options language file
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2017, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array(
        'SYSTEM_HL_OPTIONS_GENERAL'                 => 'Allgemein',
        'SYSTEM_HL_OPTIONS_EDITOR'                  => 'Editor &amp; Dateimanager',
        'SYSTEM_HL_OPTIONS_ARTICLES'                => 'Artikel',
        'SYSTEM_HL_OPTIONS_COMMENTS'                => 'Kommentare',
        'SYSTEM_HL_OPTIONS_SECURITY'                => 'Sicherheit & Wartung',
        'SYSTEM_HL_OPTIONS_TWITTER'                 => 'Twitter-Verbindung',
        'SYSTEM_HL_OPTIONS_SYSCHECK'                => 'Systemprüfung',

        'SYSTEM_OPTIONS_MAINTENANCE'                => 'Wartungsmodus aktiv',
        'SYSTEM_OPTIONS_CRONJOBS'                   => 'Asynchrone Cronjob-Ausführung inaktiv',
        'SYSTEM_OPTIONS_URL'                        => 'URL für Artikellinks',
        'SYSTEM_OPTIONS_LANG'                       => 'Sprache',   
        'SYSTEM_OPTIONS_DATETIMEMASK'               => 'Datum- und Zeitanzeige',
        'SYSTEM_OPTIONS_DATETIMEMASK_HELP'          => 'Syntax entspricht date()-Funktion von PHP',
        'SYSTEM_OPTIONS_TIMEZONE'                   => 'Zeitzone',

        'SYSTEM_OPTIONS_SESSIONLENGHT'              => 'Maximale Länge einer Admin-Sitzung',
        'SYSTEM_OPTIONS_SESSIONLENGHT_INTERVALS'    => array(
            '30 minuten'  => 1800,
            '1 Stunde'    => 3600,
            '1,5 Stunden' => 5400,
            '2 Stunden'   => 7200,
            '2,5 Stunden' => 9000,
            '3 Stunden'   => 10800,
            '4 Stunden'   => 14400,
            '5 Stunden'   => 18000,
            '6 Stunden'   => 21600
        ),        
        
        'SYSTEM_OPTIONS_CACHETIMEOUT'               => 'Zeit bis zum Cache-Timeout',
        'SYSTEM_OPTIONS_CACHETIMEOUT_INTERVAL'      => array(
            '30 Minuten' => 1800,
            '1 Stunde'   => 3600,
            '6 Stunden'  => 21600,
            '12 Stunden' => 43200,
            '18 Stunden' => 64800,
            '1 Tag'      => 86400,
            '2 Tage'     => 172800,
            '3 Tage'     => 259200,
            '4 Tage'     => 345600,
            '5 Tage'     => 432000,
            '6 Tage'     => 518400,
            '1 Woche'    => 604800
        ),
        
        'SYSTEM_OPTIONS_USEMODE'                    => 'Verwendung per',
        'SYSTEM_OPTIONS_USEMODE_IFRAME'             => 'iframe',
        'SYSTEM_OPTIONS_USEMODE_PHPINCLUDE'         => 'phpinclude',
        'SYSTEM_OPTIONS_INCLUDEJQUERY'              => 'jQuery Bibliothek laden',
        'SYSTEM_OPTIONS_INCLUDEJQUERY_YES'          => 'Wähle &quot;ja&quot;, wenn du jQuery noch nicht anderweitig in deiner Seite eingebunden hast.',
        'SYSTEM_OPTIONS_STYLESHEET'                 => 'Pfad zu deiner CSS-Datei',   
        'SYSTEM_OPTIONS_NEWSSHOWLIMIT'              => 'Anzahl Artikel pro öffentlicher Seite',  
        'SYSTEM_OPTIONS_ACTIVENEWSTEMPLATE'         => 'Template für Artikel-Liste',
        'SYSTEM_OPTIONS_ACTIVENEWSTEMPLATESINGLE'   => 'Template für einzelnen Artikel',
        'SYSTEM_OPTIONS_LATESTNEWSTEMPLATE'         => '&quot;Lastest News&quot; Template',
        'SYSTEM_OPTIONS_NEWSSHOWSHARELINKS'         => 'Share-Buttons anzeigen',
        'SYSTEM_OPTIONS_NEWSSHOWIMGTHUMBSIZE'       => 'Vorschaubild-Größe', 
        'SYSTEM_OPTIONS_NEWSSHOWMAXIMGSIZEPIXELS'   => 'Pixel',
        'SYSTEM_OPTIONS_FILEMANAGER_LIMIT'          => 'Anzahl Bilder pro Seite',
        'SYSTEM_OPTIONS_NEWS_EDITOR'                => 'Editor auswählen',
        'SYSTEM_OPTIONS_NEWS_EDITOR_STD'            => 'WYSIWYG Ansicht',
        'SYSTEM_OPTIONS_NEWS_EDITOR_CLASSIC'        => 'HTML Ansicht',
        'SYSTEM_OPTIONS_NEWS_EDITOR_CSS'            => 'CSS-Klassen im Editor',
        'SYSTEM_OPTIONS_NEWS_EDITOR_FONTSIZE'       => 'Standard-Schriftgröße im Editor',
        'SYSTEM_OPTIONS_NEWS_EDITOR_IMGTOOLS'       => 'Bilder-Änderungen in TinyMCE auf Server speichern',
        'SYSTEM_OPTIONS_NEWS_NEWUPLOADER'           => 'jQuery Dateiupload verwenden',
        'SYSTEM_OPTIONS_NEWS_ARCHIVELIMIT'          => 'Artikel in Archiv anzeigen ab',
        'SYSTEM_OPTIONS_NEWS_ARCHIVELIMIT_EMPTY'    => 'leer lassen für kein Limit',
        'SYSTEM_OPTIONS_NEWS_URLREWRITING'          => 'URL-Rewriting für Artikel-Links aktivieren',
        'SYSTEM_OPTIONS_NEWS_REVISIONS_LIMIT'       => 'Alte Revisionen löschen, wenn älter als',
        'SYSTEM_OPTIONS_NEWS_REVISIONS_LIMIT_LIST'  => array(
            'nie'         => 0,
            '1 Woche'     => 604800,
            '2 Wochen'    => 1209600,
            '3 Wochen'    => 1814400,
            '4 Wochen'    => 2419200,
            '6 Wochen'    => 3628800,
            '8 Wochen'    => 4838400,
            '3 Monate'    => 7257600,
            '6 Monate'    => 14515200,
            '12 Monate'   => 31449600,
            '18 Monate'   => 43545600,
            '24 Monate'   => 62899200
        ),
        'SYSTEM_OPTIONS_ARCHIVE_LINK'               => 'Archiv-Link anzeigen',
        'SYSTEM_OPTIONS_ACTIVECOMMENTTEMPLATE'      => 'Kommentar-Template',
        'SYSTEM_OPTIONS_COMMENTFORMTEMPLATE'        => 'Kommentar-Formular-Template',
        'SYSTEM_OPTIONS_ANTISPAMQUESTION'           => 'Anti-Spam-Frage',
        'SYSTEM_OPTIONS_ANTISPAMANSWER'             => 'Antwort auf Anti-Spam-Frage',
        'SYSTEM_OPTIONS_ACPARTICLES_LIMIT'          => 'Anzahl an Artikeln pro Seite in ACP',
        'SYSTEM_OPTIONS_LOGIN_MAXATTEMPTS'          => 'Anzahl Login-Versuche vor temporärer Sperre',
        
        'SYSTEM_OPTIONS_FLOODPROTECTION'            => 'Zeitsperre zwischen zwei Kommentaren',
        'SYSTEM_OPTIONS_FLOODPROTECTION_INTERVALS'  => array(
            'keine'        => 0,
            '10 Sekunden'  => 10,
            '20 Sekunden'  => 20,
            '30 Sekunden'  => 30,
            '60 Sekunden'  => 60,
            '90 Sekunden'  => 90,
            '2 Minuten'   => 120,
            '5 Minuten'   => 300,
            '10 Minuten'  => 600,
            '15 Minuten'  => 900,
            '30 Minuten'  => 1800,
            '60 Minuten'  => 3600,
        ),  
        
        'SYSTEM_OPTIONS_COMMENTEMAIL'               => 'E-Mail-Adresse erforderlich',
        'SYSTEM_OPTIONS_COMMENT_APPROVE'            => 'Kommentar-Freigabe erforderlich',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY'             => 'Kommentar-Benachrichtigung an',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY_GLOBAL'      => 'globale E-Mail-Adresse',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY_AUTHOR'      => 'nur Autor',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY_ALL'         => 'globale E-Mail-Adresse und Autor',
        'SYSTEM_OPTIONS_COMMENT_ENABLED_GLOBAL'     => 'Kommentar-System ist aktiv',
        'SYSTEM_OPTIONS_COMMENT_MARKSPAM_PASTCHECK' => 'Automatische Spam-Markierung',
        'SYSTEM_OPTIONS_COMMENT_PRIVACYOPTIN'       => 'Zustimmung zur Datenschutz-Erklärung erforderlich',
        'SYSTEM_OPTIONS_REVISIONS_ENABLED'          => 'Revisionen aktivieren',
        'SYSTEM_OPTIONS_NEWS_SORTING'               => 'News sortieren nach',
        'SYSTEM_OPTIONS_NEWS_BYWRITTENTIME'         => 'Veröffentlichung',
        'SYSTEM_OPTIONS_NEWS_BYEDITEDTIME'          => 'Letzter Änderung',
        'SYSTEM_OPTIONS_NEWS_BYINTERNALID'          => 'Interner ID',
        'SYSTEM_OPTIONS_NEWS_BYAUTHOR'              => 'Autor',
        'SYSTEM_OPTIONS_NEWS_ORDERASC'              => 'Aufsteigend',
        'SYSTEM_OPTIONS_NEWS_ORDERDESC'             => 'Absteigend',
        'SYSTEM_OPTIONS_NEWS_ENABLETRASH'           => 'Papierkorb aktivieren',
        'SYSTEM_OPTIONS_NEWS_ENABLEFEED'            => 'RSS-Feed ist aktiv',

        'SYSTEM_OPTIONS_EXTENDED_EMAILUPDATES'      => 'E-Mail-Benachrichtigung, wenn Updates verfügbar',
        'SYSTEM_OPTIONS_EXTENDED_DEVUPDATES'        => 'Entwickler-Versionen bei Update-Check anzeigen',
        'SYSTEM_OPTIONS_EXTENDED_UPDATESMANCHK'     => 'Update-Check-Intervall, wenn externe Server-Verbindungen nicht möglich',
        
        'SYSTEM_OPTIONS_TWITTER_CONNECTION'         => 'Twitter-Verbindung',
        'SYSTEM_OPTIONS_TWITTER_CONNECT'            => 'API-Schlüssel und/oder Token anfordern',
        'SYSTEM_OPTIONS_TWITTER_DISCONNECT'         => 'Verbindung löschen',
        'SYSTEM_OPTIONS_TWITTER_EVENTS'             => 'Tweet zu Artikel erzeugen beim',
        'SYSTEM_OPTIONS_TWITTER_CONSUMER_KEY'       => 'Consumer Key (API Key)',
        'SYSTEM_OPTIONS_TWITTER_CONSUMER_SECRET'    => 'Consumer Secret (API Secret)',
        'SYSTEM_OPTIONS_TWITTER_USER_TOKEN'         => 'Access Token',
        'SYSTEM_OPTIONS_TWITTER_USER_SECRET'        => 'Access Token Secret',
        'SYSTEM_OPTIONS_TWITTER_ACTIVE'             => 'Twitter-Verbindung ist aktiv! Verbunden mit Benutzer "{{screenname}}".',
        'SYSTEM_OPTIONS_TWITTER_EVENTCREATE'        => 'Veröffentlichen',
        'SYSTEM_OPTIONS_TWITTER_EVENTUPDATE'        => 'Aktualisieren',

        'SYSTEM_OPTIONS_EMAIL_ENABLED'              => 'E-Mails via SMTP versenden',
        'SYSTEM_OPTIONS_EMAIL_SERVER'               => 'SMTP-Server-Adresse',
        'SYSTEM_OPTIONS_EMAIL_PORT'                 => 'SMTP-Server-Port',
        'SYSTEM_OPTIONS_EMAIL_USERNAME'             => 'SMTP-Benutzername',
        'SYSTEM_OPTIONS_EMAIL_PASSWORD'             => 'SMTP-Passwort',
        'SYSTEM_OPTIONS_EMAIL_ENCRYPTED'            => 'SMTP-Verschlüsselung',
        'SYSTEM_OPTIONS_EMAIL_ACTIVE'               => 'Prüfung der Zugangsdaten war erfolgreich. E-Mail-Versand erfolgt via SMTP.',
        
        'SYSTEM_OPTIONS_SYSCHECK_CURRENT'           => 'Aktueller Wert',
        'SYSTEM_OPTIONS_SYSCHECK_RECOMMEND'         => 'Empfohlener Wert',
        'SYSTEM_OPTIONS_SYSCHECK_STATUS'            => 'Wert OK?',
        'SYSTEM_OPTIONS_SYSCHECK_FPCMVERSION'       => 'FanPress CM Version',
        'SYSTEM_OPTIONS_SYSCHECK_PHPVERSION'        => 'PHP Version',
        'SYSTEM_OPTIONS_SYSCHECK_PHPMEMLIMIT'       => 'PHP Speicherlimit',
        'SYSTEM_OPTIONS_SYSCHECK_PHPMAXEXECTIME'    => 'Maximale Ausführungszeit für PHP',
        'SYSTEM_OPTIONS_SYSCHECK_DBDRV_MYSQL'       => 'MySQL/ MariaDB Datenbanktreiber',
        'SYSTEM_OPTIONS_SYSCHECK_DBDRV_PGSQL'       => 'Postgres Datenbanktreiber',
        'SYSTEM_OPTIONS_SYSCHECK_DBDRV_ACTIVE'      => 'Aktiver Datenbanktreiber',
        'SYSTEM_OPTIONS_SYSCHECK_DBVERSION'         => 'Version des Datenbanksystems',
        'SYSTEM_OPTIONS_SYSCHECK_HTTPS'             => 'HTTPS ist aktiv',
        'SYSTEM_OPTIONS_SYSCHECK_SUBMITSTATS'       => 'Statistische Daten übermitteln',

        'SYSTEM_OPTIONS_CRONINTERVALS' => array(
            'bei jedem Aufruf'  => 0,
            'minütlich'         => 60,
            '90 Sekunden'       => 90,
            'aller 2 Minuten'   => 120,
            'aller 5 Minuten'   => 300,
            'aller 10 Minuten'  => 600,
            'aller 15 Minuten'  => 900,
            'halbstündlich'     => 1800,
            'stündlich'         => 3600,
            'aller 2 Stunden'   => 7200,
            'aller 3 Stunden'   => 10800,
            'aller 6 Stunden'   => 21600,
            'aller 12 Stunden'  => 43200,
            'täglich'           => 86400,
            'aller 2 Tage'      => 172800,
            'wöchentlich'       => 604800,
            '14-tägig'          => 1209600,
            'monatlich'         => 2419200
        ),

        'SYSTEM_OPTIONS_UPDATESMANUAL' => array(
            'täglich'           => 86400,            
            'wöchentlich'       => 604800,
            '14-tägig'          => 1209600,
            'monatlich'         => 2419200
        )
        
    );