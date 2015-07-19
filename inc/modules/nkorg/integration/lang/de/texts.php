<?php
    /**
     * Module Sprachpaket Deutsch
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array (
        'NKORG_INTEGRATION_CSSCLASSES_TEXT'     => 'Füge in deine CSS-Datei folgende CSS-Klassen ein, um die Ausgabe FanPress CM '.
                                                   'zu gestalten.',
        
        'NKORG_INTEGRATION_PHPINCLUDE_TEXT1'    => 'Wenn du deine Seite mittels php include verwendest, binde zuerst die API-Datei im in '.
                                                   'FanPress Verzeichnis ein und erzeuge dann ein neues API-Objekt.',
        
        'NKORG_INTEGRATION_PHPINCLUDE_TEXT2'    => 'Füge diese oder ähnlich gearteten Code soweit wie möglich am Anfang deiner Seite an. '.
                                                   'Dies wird vermutlich die Datei<p class="fpcm-ui-center"><strong>{{filename}}</strong></p> sein, welche du in den '.
                                                   'System-Einstellungen unter <em>URL für Artikellinks</em> angegeben hast.',
        
        'NKORG_INTEGRATION_SHOWARTICLES_TEXT'   => 'Füge an die Stelle, an der du deine verfassten Artikel ausgeben lassen '.
                                                   'willst folgenden Code ein. Die Umgebenden DIV-Box kannst du u. U. weglassen.'.
                                                   'Über die Konstanten <em>FPCM_PUB_LIMIT_LISTALL (aktive Artikel)</em> und/ oder <em>FPCM_PUB_LIMIT_ARCHIVE '.
                                                   '(Archiv)</em> kannst du die Anzahl pro Seite für festlegen, an sonsten wird die Anzahl aus'.
                                                   'den Systemeinstellungen genutzt. Über die Konstante <em>FPCM_PUB_CATEGORY_LISTALL</em> kannst du die Anzeige auf '.
                                                   'eine einzelne Kategorie einschränken. Nutze hierfür die Kategorie-ID.',
        
        'NKORG_INTEGRATION_SHOWLATEST_TEXT'     => 'Füge an die Stelle, an der du die "Latest News" ausgeben lassen '.
                                                   'willst, folgenden Code ein. Die Umgebenden DIV-Box kannst du u. U. weglassen.'.
                                                   'Über die Konstante <em>FPCM_PUB_LIMIT_LATEST</em> kannst du die Anzahl festlegen, '.
                                                   'an sonsten wird die Anzahl aus den Systemeinstellungen genutzt. Über die Konstante <em>FPCM_PUB_CATEGORY_LATEST</em> '.
                                                   'kannst du die Anzeige auf eine einzelne Kategorie einschränken. Nutze hierfür die Kategorie-ID.',
        
        'NKORG_INTEGRATION_SHOWTITLE_TEXT1'     => 'Gebe den Text ein, welche als Trenner zum Titel deiner Seite fungieren soll.',
        
        'NKORG_INTEGRATION_SHOWTITLE_TEXT2'     => 'Füge in der Datei, wo das &lt;title&gt;-Tag deiner Seite enthalten ist, folgenden Code zwischen &lt;title&gt; und &lt;/title&gt; ein. '.
                                                   'Dies kann deine index.php, header.php, o. ä. sein.',

        'NKORG_INTEGRATION_UTF8OUTPUT_TEXT'     => 'Sollten nach der Integration Umlaute, Sonderzeichen, etc. nicht richtig angezeigt werden, '.
                                                   'so nutzt du für deine Seite keinen <em>utf-8</em>-Zeichensatz. In dem Fall füge <em>vor</em> '.
                                                   'der Erzeugung des API-Objekts (siehe oben) folgenden Code ein.',

        'NKORG_INTEGRATION_RSSFEED_TEXT'        => 'Um den RSS-Feed zu verwenden, füge einfach folgenden Code o. ä. in deine Seite ein.',

        'NKORG_INTEGRATION_SHOW_IFRAME'         => 'Füge an die Stelle, wo die Ausgabe erscheinen soll, einfach folgenden HTML-Code ein.',
    );