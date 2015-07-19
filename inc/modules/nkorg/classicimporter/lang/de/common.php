<?php
    /**
     * FanPress CM Classic Importer Language File
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array (
        'FPCM_CLASSICIMPORTER_HEADLINE'     => 'FanPress CM Classic Importer',
        'FPCM_CLASSICIMPORTER_NOIMPORT'     => 'Der Classic Importer sollte nicht verwendet werden, da bereits Daten im System vorhanden sind. Bei Nutzung des Importers könnte es zu Problemen kommen. Falls du doch einen Import durchf+hren möchtest, verwende ggf. vorher die "System zurücksetzten"-Funktion.',
        'FPCM_CLASSICIMPORTER_CHECK'        => 'Bitte prüfe, ob alle Daten korrekt importiert wurden, <strong>bevor</strong> du mit dem Import fortfährst!',
        'FPCM_CLASSICIMPORTER_OPENMODULE'   => 'Modul aufrufen',
        'FPCM_CLASSICIMPORTER_RESETSYSTEM'  => 'System zurücksetzten',
        
        'FPCM_CLASSICIMPORTER_IMPORT_FPCM2'                   => 'Verbindung zu FanPress CM 2.5.x',
        'FPCM_CLASSICIMPORTER_IMPORT_FPCM2_PATH'              => 'Pfad der zu importierenden FanPress CM 2.5.x',
        'FPCM_CLASSICIMPORTER_IMPORT_FPCM2_CHECKPATH'         => 'Pfad und Verbindung prüfen',
        'FPCM_CLASSICIMPORTER_IMPORT_FPCM2_CHECKPATH_OK'      => 'Die Prüfung von Pfad und Verbindung war erfolgreich.',
        'FPCM_CLASSICIMPORTER_IMPORT_FPCM2_CHECKPATH_ERR'     => 'Die Prüfung von Pfad und Verbindung war nicht erfolgreich!',
        'FPCM_CLASSICIMPORTER_IMPORT_FPCM2_CHECKPATH_VERSION' => 'Die zu importierende FanPress CM Installation muss Version 2.5.0 oder neuer verwenden. Ältere Versionen werden nicht unterstützt.',
        
        'FPCM_CLASSICIMPORTER_IMPORT_ROLLS'     => 'Rollen importieren',
        'FPCM_CLASSICIMPORTER_IMPORT_ROLLS_TXT' => 'Es werden nur Rollen importiert, welche du selbst angelegt hast und welche noch nicht im System existieren. System-Rollen werden nicht beachtet.',
        
        'FPCM_CLASSICIMPORTER_IMPORT_USERS'     => 'Benutzer importieren',
        'FPCM_CLASSICIMPORTER_IMPORT_USERS_TXT' => 'Es werden nur Benutzer importiert, welche deren Benutzernamen noch nicht existiert. Das Passwort wird dabei auf den Benutzernamen zurückgesetzt, da FanPress CM 3 eine andere Verschlüsselung als FanPress CM 2 verwendet.',
        
        'FPCM_CLASSICIMPORTER_IMPORT_CATEGORIES'     => 'Kategorien importieren',
        'FPCM_CLASSICIMPORTER_IMPORT_CATEGORIES_TXT' => 'Es werden nur Kategorien importiert, welche noch nicht existieren. Der Zugriff auf Kategorien durch Rollen muss nach dem Import u. U. manuell angepasst werden.',
        
        'FPCM_CLASSICIMPORTER_IMPORT_ARTICLES'      => 'Artikel und Kommentare importieren',
        'FPCM_CLASSICIMPORTER_IMPORT_ARTICLES_TXT'  => 'Artikel und Kommentare werden zusammen importiert, um die gegenseitige Verknüpfung zu erhalten. Bei vielen Artikeln und Kommentaren kann der Vorgang sehr lange dauern. Es wird außerdem versucht, die Pfade für hochgeladene Dateien anzupassen, so dass Bilder in älteren Artikeln korrekt angezeigt werden.',
        'FPCM_CLASSICIMPORTER_IMPORT_ARTICLES_ID'   => 'Artikel mit ID',
        
        'FPCM_CLASSICIMPORTER_IMPORT_UPLAODS'       => 'Upload importieren',
        'FPCM_CLASSICIMPORTER_IMPORT_UPLAODS_TXT'   => 'Der Import von hochgeladenen Dateien kann u. U. sehr lange dauern insb. bei vielen großen Dateien. Schließe in der Zeit das Browserfenter nicht! Je nachdem besteht zudem die Möglichkeit, dass sich - insb. bei Vorschaubildern - Pfade ändern und in älteren Artikeln keine Bilder mehr angezeigt werden.',
        
        'FPCM_CLASSICIMPORTER_IMPORT_SMILEYS'       => 'Smileys importieren',
        'FPCM_CLASSICIMPORTER_IMPORT_SMILEYS_TXT'   => 'Beim Import von Smileys werden nur solche importiert, welche noch nicht existieren. Hast du die Standard-Smileys durch andere Dateien mit gleichem Namen ersetzt, so musst du die Dateien manuell ersetzten.',
        
        'FPCM_CLASSICIMPORTER_IMPORT_IPS'           => 'Gesperrte IP-Adressen importieren',
        'FPCM_CLASSICIMPORTER_IMPORT_IPS_TXT'       => 'Gesperrte IP-Adressen verweigern nach dem Import wie in FanPress CM 2.x nur den Zugriff auf die Kommentare.',
        
        'FPCM_CLASSICIMPORTER_IMPORT_CONFIG'        => 'Konfiguration importieren',
        'FPCM_CLASSICIMPORTER_IMPORT_CONFIG_TXT'    => 'Der Import der Konfiguration beinhaltet nicht alle verfügbaren Optionen. Beim Import werden bereits bestehende Konfigurationen überschrieben! Importiert werden Daten für die Optionen:',

        'FPCM_CLASSICIMPORTER_IMPORT_TEMPLATES'     => 'Templates importieren',
        'FPCM_CLASSICIMPORTER_IMPORT_TEMPLATES_TXT' => 'Der Import der Templates von FanPress CM 2.x nach FanPress CM 3 erfolgt soweit dies möglich ist, betrifft aber ausschließlich die Platzhalter im den HTML-Code.'.
                                                       'CSS-Klassen, nicht ersetzte Platzhalter u. a. müssen von dir nachträglich angepasst werden.<br><br>Importiert werden jeweils das <strong>aktuelle aktive Artikel- und Kommentar-Template</strong>.',
        
        'FPCM_CLASSICIMPORTER_IMPORT_START'         => 'Import starten...',
        'FPCM_CLASSICIMPORTER_IMPORT_FINISHED'      => 'Import erfolgreich abgeschlossen.',
        'FPCM_CLASSICIMPORTER_IMPORT_ERROR'         => 'Beim Import ist ein Fehler aufgetreten! Werfe einen Blick in das Fehlerlog für weitere Details.',
        'FPCM_CLASSICIMPORTER_RESET_OK'             => 'Benutzer, Rollen, kategorien sowie Artikel und Kommentare wurden erfolgreich zurückgesetzt.',
        'FPCM_CLASSICIMPORTER_RESET_ERROR'          => 'Beim Zurücksetzten des Systems ist ein Fehler aufgetreten.',
        
        
        
        
        
    );