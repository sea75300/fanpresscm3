<?php
    /**
     * Module Sprachpaket Deutsch
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array (
        'NKORG_LANGEDITOR_HEADLINE'     => 'Language Editor',
        'NKORG_LANGEDITOR_FILE'         => 'Sprachdatei auswählen',
        'NKORG_LANGEDITOR_FILENOTICE'   => 'Bitte unten eine Sprachdatei auswählen.',
        'NKORG_LANGEDITOR_LANGVAR'      => 'Sprachvariable',
        'NKORG_LANGEDITOR_VARVALUE'     => 'Inhalt',
        'NKORG_LANGEDITOR_LOADERROR'    => 'Sprachdateien-Liste konnte nicht geladen werden',
        'NKORG_LANGEDITOR_SELECTERROR'  => 'Die ausgewählte Datei ist nicht vorhanden.',
        'NKORG_LANGEDITOR_EMPTYLINE'    => 'Leerzeile für neue Sprachvariable',
        'NKORG_LANGEDITOR_DELETELINE'   => 'Zeile leer lassen oder Checkbox aktivieren, um Variable zu löschen',
        'NKORG_LANGEDITOR_FILEERROR'    => 'Die ausgewählte Sprach-Datei konnte nicht geladen werden.',
        'NKORG_LANGEDITOR_BACKUPERROR'  => 'Es konnte keine Sicherungskopie in {{path}} erzeugt werden.',
        'NKORG_LANGEDITOR_SAVEERROR'    => 'Die ausgewählte Sprach-Datei konnte nicht gespeichert werden.',
        'NKORG_LANGEDITOR_SAVEOK'       => 'Die ausgewählte Sprach-Datei wurde gespeichert.',
        'NKORG_LANGEDITOR_NOTWRITABLE'  => 'Der Ordner {{syslangapth}} mit den systemeigenen Sprachdateien ist nicht beschreibbar!',
        'NKORG_LANGEDITOR_MANAGER_HELP' => '<ul>'.
                                           '<li>Mit den Language Editor kannst du die Sprachdateien von FanPress CM und installierten '.
                                           'bearbeiten, sofern du Administrator bis und die Berechtigungen für die Systemoptionen.</li>'.
                                           '<li>In der linken Spalte musst ist der Name der Sprachvariable enthalten, in der rechten'.
                                           'Spalte der Wert.</li>'.
                                           '<li>Nach jeder vorhandenen Sprachvariable ist eine leerzeile enthalten, über welche du einen '.
                                           'neuen Eintrag erzeugen kannst.</li>'.
                                           '<li>Möchtest du in einem Text Zeilenumbrüche einfügen, so musst du diese durch "\\n" ersetzten.</li>'.
                                           '<li>Um einen Wert zu löschen, aktiviere die Checkbox hinter der entsprechenden Zeile oder '.
                                           'entferne alle Werte aus der Zeile und klicke auf Speichern.</li>'.
                                           '<li><strong>Hinweis:</strong> Der Name einer Sprachvariable darf maximal 512 Zeichen lang '.
                                           'sein, Werte einer Sprachvariable maximal 2048 Zeichen.</li>'.
                                           '<li><strong>Hinweis:</strong> Wird eine Zeile in roter Schrift dargestellt, so überschreitet '.
                                           'mindestens einer der Werte die maximale Zeichenlänge. In diesem Fall kann es passieren, dass '.
                                           'Werte beim Speichern abgeschnitten werden. Überlege die gut, ob du eine solche Datei bearbeitest.</li>'.
                                           '<li>Wird einer Sprachdatei geändert, so wird vor dem Speichern eine '.
                                           'Sicherungskopie unter <em>{{datapath}}</em> angelegt.</li>'.
                                           '</ul>'
    );