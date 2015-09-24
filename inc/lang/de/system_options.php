<?php
    /**
     * System options language file
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2014, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array(
        'SYSTEM_HL_OPTIONS_GENERAL'                 => 'Allgemein',
        'SYSTEM_HL_OPTIONS_EDITOR'                  => 'Editor &amp; Dateimanager',
        'SYSTEM_HL_OPTIONS_ARTICLES'                => 'Artikel',
        'SYSTEM_HL_OPTIONS_COMMENTS'                => 'Kommentare',
        'SYSTEM_HL_OPTIONS_TWITTER'                 => 'Twitter-Verbindung',
        'SYSTEM_HL_OPTIONS_SYSCHECK'                => 'System-Überprüfung & Updates',

        'SYSTEM_OPTIONS_MAINTENANCE'                => 'Wartungsmodus aktiv',
        'SYSTEM_OPTIONS_URL'                        => 'URL für Artikellinks',
        'SYSTEM_OPTIONS_LANG'                       => 'Sprache',   
        'SYSTEM_OPTIONS_DATETIMEMASK'               => 'Datum- und Zeitanzeige (Syntax: <a href="http://php.net/manual/de/function.date.php">date()</a>-Funktion von PHP)',
        'SYSTEM_OPTIONS_TIMEZONE'                   => 'Zeitzone',
        'SYSTEM_OPTIONS_SESSIONLENGHT'              => 'Maximale Länge einer Admin-Sitzung',
        'SYSTEM_OPTIONS_SESSIONLENGHT_1800'         => '0,5 Stunden',
        'SYSTEM_OPTIONS_SESSIONLENGHT_3600'         => '1 Stunde',
        'SYSTEM_OPTIONS_SESSIONLENGHT_5400'         => '1,5 Stunden',
        'SYSTEM_OPTIONS_SESSIONLENGHT_7200'         => '2 Stunden',
        'SYSTEM_OPTIONS_SESSIONLENGHT_9000'         => '2,5 Stunden',
        'SYSTEM_OPTIONS_SESSIONLENGHT_10800'        => '3 Stunden',
        'SYSTEM_OPTIONS_SESSIONLENGHT_14400'        => '4 Stunden',
        'SYSTEM_OPTIONS_SESSIONLENGHT_18000'        => '5 Stunden', 
        
        'SYSTEM_OPTIONS_CACHETIMEOUT'               => 'Zeit bis zum atomatischen Neuaufbau des Cache in Sekunden',
        'SYSTEM_OPTIONS_CACHETIMEOUT_3600'          => '1 Stunde',
        'SYSTEM_OPTIONS_CACHETIMEOUT_21600'         => '6 Stunden',
        'SYSTEM_OPTIONS_CACHETIMEOUT_43200'         => '12 Stunden',
        'SYSTEM_OPTIONS_CACHETIMEOUT_64800'         => '18 Stunden',
        'SYSTEM_OPTIONS_CACHETIMEOUT_86400'         => '1 Tag',
        'SYSTEM_OPTIONS_CACHETIMEOUT_172800'        => '2 Tage',
        'SYSTEM_OPTIONS_CACHETIMEOUT_259200'        => '3 Tage',
        'SYSTEM_OPTIONS_CACHETIMEOUT_345600'        => '4 Tage',
        'SYSTEM_OPTIONS_CACHETIMEOUT_432000'        => '5 Tage',
        
        'SYSTEM_OPTIONS_USEMODE'                    => 'Verwendung per',
        'SYSTEM_OPTIONS_USEMODE_IFRAME'             => 'iframe',
        'SYSTEM_OPTIONS_USEMODE_PHPINCLUDE'         => 'phpinclude',
        'SYSTEM_OPTIONS_INCLUDEJQUERY'              => 'jQuery Bibliothek laden',
        'SYSTEM_OPTIONS_INCLUDEJQUERY_YES'          => 'Wähle &quot;ja&quot;, wenn du jQuery noch nicht anderweitig in deiner Seite eingebunden hast.',
        'SYSTEM_OPTIONS_STYLESHEET'                 => 'Pfad zu deiner CSS-Datei',   
        'SYSTEM_OPTIONS_NEWSSHOWLIMIT'              => 'max. News pro Seite',  
        'SYSTEM_OPTIONS_ACTIVENEWSTEMPLATE'         => 'Template für Artikel-Liste',
        'SYSTEM_OPTIONS_ACTIVENEWSTEMPLATESINGLE'   => 'Template für einzelnen Artikel',
        'SYSTEM_OPTIONS_LATESTNEWSTEMPLATE'         => '&quot;Lastest News&quot; Template',
        'SYSTEM_OPTIONS_NEWSSHOWSHARELINKS'         => 'Share-Buttons anzeigen',
        'SYSTEM_OPTIONS_NEWSSHOWMAXIMGSIZE'         => 'Vorschaubild erzeugen wenn Bild größer ist als',
        'SYSTEM_OPTIONS_NEWSSHOWIMGTHUMBSIZE'       => 'Maxmimale Größe des Vorschaubildes', 
        'SYSTEM_OPTIONS_NEWSSHOWMAXIMGSIZEPIXELS'   => 'Pixel',
        'SYSTEM_OPTIONS_NEWS_EDITOR'                => 'Editor auswählen',
        'SYSTEM_OPTIONS_NEWS_EDITOR_STD'            => 'WYSIWYG Ansicht',
        'SYSTEM_OPTIONS_NEWS_EDITOR_CLASSIC'        => 'HTML Ansicht',
        'SYSTEM_OPTIONS_NEWS_EDITOR_CSS'            => 'CSS-Klassen im Editor',
        'SYSTEM_OPTIONS_NEWS_NEWUPLOADER'           => 'jQuery Dateiupload verwenden',
        'SYSTEM_OPTIONS_ARCHIVE_LINK'               => 'Archiv-Link anzeigen',
        'SYSTEM_OPTIONS_ACTIVECOMMENTTEMPLATE'      => 'Kommentare-Template',
        'SYSTEM_OPTIONS_COMMENTFORMTEMPLATE'        => 'Kommentar-Formular-Template',
        'SYSTEM_OPTIONS_ANTISPAMQUESTION'           => 'Anti-Spam-Frage',
        'SYSTEM_OPTIONS_ANTISPAMANSWER'             => 'Antwort auf Anti-Spam-Frage',
        'SYSTEM_OPTIONS_ACPARTICLES_LIMIT'          => 'Anzahl an Artikeln im ACP',
        
        'SYSTEM_OPTIONS_FLOODPROTECTION'            => 'Zeitsperre zwischen zwei Kommentaren',
        'SYSTEM_OPTIONS_FLOODPROTECTION_0'          => 'keine',
        'SYSTEM_OPTIONS_FLOODPROTECTION_10'         => '10 Sekunden',
        'SYSTEM_OPTIONS_FLOODPROTECTION_20'         => '20 Sekunden',
        'SYSTEM_OPTIONS_FLOODPROTECTION_30'         => '30 Sekunden',
        'SYSTEM_OPTIONS_FLOODPROTECTION_60'         => '60 Sekunden',
        'SYSTEM_OPTIONS_FLOODPROTECTION_90'         => '90 Sekunden',
        'SYSTEM_OPTIONS_FLOODPROTECTION_120'        => '2 Minuten',
        'SYSTEM_OPTIONS_FLOODPROTECTION_300'        => '5 Minuten',
        'SYSTEM_OPTIONS_FLOODPROTECTION_600'        => '10 Minuten',
        'SYSTEM_OPTIONS_FLOODPROTECTION_900'        => '15 Minuten',
        'SYSTEM_OPTIONS_FLOODPROTECTION_1800'       => '30 Minuten',        
        
        'SYSTEM_OPTIONS_COMMENTEMAIL'               => 'Muss E-Mail Adresse angegeben werden',
        'SYSTEM_OPTIONS_COMMENT_APPROVE'            => 'Müssen Kommentare freigeschalten werden',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY'             => 'Benachrichtigung bei neuem Kommentare an',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY_GLOBAL'      => 'globale E-Mail-Adresse',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY_AUTHOR'      => 'nur Author',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY_ALL'         => 'globale E-Mail-Adresse und Author',
        'SYSTEM_OPTIONS_COMMENT_ENABLED_GLOBAL'     => 'Kommentar-System ist aktiv',
        'SYSTEM_OPTIONS_REVISIONS_ENABLED'          => 'Revisionen aktivieren',
        'SYSTEM_OPTIONS_NEWS_SORTING'               => 'News sortieren nach',
        'SYSTEM_OPTIONS_NEWS_BYWRITTENTIME'         => 'Veröffentlichung',
        'SYSTEM_OPTIONS_NEWS_BYEDITEDTIME'          => 'Letzter Änderung',
        'SYSTEM_OPTIONS_NEWS_BYINTERNALID'          => 'Interner ID',
        'SYSTEM_OPTIONS_NEWS_BYAUTHOR'              => 'Author',
        'SYSTEM_OPTIONS_NEWS_ORDERASC'              => 'Aufsteigend',
        'SYSTEM_OPTIONS_NEWS_ORDERDESC'             => 'Absteigend',
        'SYSTEM_OPTIONS_NEWS_ENABLETRASH'           => 'Artikel vor dem Löschen in Papierkorb verschieben',
        'SYSTEM_OPTIONS_NEWS_ENABLEFEED'            => 'RSS-Feed ist aktiv',
        
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
        
        'SYSTEM_OPTIONS_SYSCHECK_CURRENT'           => 'Aktueller Wert',
        'SYSTEM_OPTIONS_SYSCHECK_RECOMMEND'         => 'Empfohlener Wert',
        'SYSTEM_OPTIONS_SYSCHECK_STATUS'            => 'Wert OK?',
        'SYSTEM_OPTIONS_SYSCHECK_FPCMVERSION'       => 'FanPress CM Version',
        'SYSTEM_OPTIONS_SYSCHECK_PHPVERSION'        => 'PHP Version'
    );