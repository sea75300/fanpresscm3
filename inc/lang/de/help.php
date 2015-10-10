<?xml version="1.0" encoding="UTF-8"?>
<!--
Help language file
@author Stefan Seehafer <sea75300@yahoo.de>
@copyright (c) 2013-2015, Stefan Seehafer
@license http://www.gnu.org/licenses/gpl.txt GPLv3
*/
-->
<chapters>
    <chapter>
        <headline>
            HL_DASHBOARD
        </headline>
        <text>
        <![CDATA[
            <p>Im <b>Dashboard</b> findest du verschiedene Informationen u. a. zum Update-Satus deiner FanPress CM Installation, etc. Du kannst auch
            eigene Dashboard-Container erzeugen. Erzeuge dazu eine neue Conatainer-Datei unter "fanpress/inc/dashboard" oder über das entsprechende Modul-Event.</p>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            ARTICLES_EDITOR
        </headline>
        <text>
        <![CDATA[
            <p>Mit dem <b>Artikel-Editor</b> kannst du Artikel schreiben und/oder bearbeiten. Hierbei hast du vielfältige Gestaltungsmöglichkeiten, welche
            durch Module erweitert werden können. Du kannst einem Artikel Kategorien zuweisen, ihn "anpinnen", so dass er über allen anderen Artikeln
            dargestellt wird und verschiedene weitere Einstellungen vornehmen.</p>
            <p>Der Artikel-Editor hat zwei verschiedene Ansichten:</p>
            <ul>
                <li><b>WYSIWYG-Ansicht:</b><br>
                    Diese basiert auf TinyMCE 4 und zeigt dir direkt alle Formatierungen an, welche du vornimmst. Über den Button
                    <i>HTML</i> in der Format-Leiste kannst du eine einfache HTML-Ansicht öffnen.
                </li>
                <li><b>HTML-Ansicht:</b><br>
                    Die HTML-Ansicht ist ein reiner HTML-Editor, welcher neben verschiedenen Formatierungsmöglichkeiten u. a. auch Syntax-Hilighting
                    bietet.        
                </li>
            </ul>
            <p>Die Ansicht des Editors kannst du in den Systemeinstellungen ändern.</p>

            <p>Über den Button <span class="fpcm-ui-button">Kurzlink</span> am oberen Kopf des Artikel-Editors ist es bei gespeicherten Artikeln möglich, die URL über den Dienst
            <a href=http://is.gd>is.gd</a> kürzen zu lassen. Der genutzte Dienst kann über ein Modul-Event geändert werden</p>

            <p>Sofern es dein Host zulässt, kannst du in den Systemeinstellungen FanPress CM direkt mit Twitter verbinden. Somit werden Artikel beim
            Veröffentlichen oder über das Aktions-Menü unter <i>Artikel bearbeiten</i> direkt bei Twitter bekannt gemacht werden.</p>

            <p>Um einen Artikel zu einem bestimmten Zeitpunkt automatisch freizuschalten, öffne das <span class="fpcm-ui-button">Erweitert</span>-Menü über den Button am unteren
            Bildschirmrand. Setzte den Haken bei <span class="fpcm-ui-button">Eintrag freischalten am </span> um wählen anschließend Datum und Uhrzeit aus.</p>

            <p>In FanPress CM kannst du über den <strong>&lt;readmore&gt;</strong>-Tag ein Stück Text einfügen, das beim Aufruf der Seite
            nicht angezeigt wird. (bspw. für Spoiler, etc.)</p>

            <p>Der Artikel-Editor kann am oberen Rand bis zu drei Tabs enthalten. Immer angezeigt wird der Tab <i>Artikel-Editor</i>, welcher den Editor
            an sich umfasst. Als weitere Tabs können <i>Kommentare</i> und/oder <i>Revisionen</i> folgen.</p>

            <p>Unter <i>Kommentare</i> erhälst du eine Auflistung aller Kommentare, welche zu zum ausgewählten Artikel geschrieben wurden. Die Liste
            bietet dir die Möglichkeit, einzelne Kommentare zu löschen. Über einen Klick auf den Namen des Verfassern kannst du in einem einfachen
            Editor die Kommentare bearbeiten, freischalten, auf privat setzten, etc. Den Zugriff auf die Kommentare können du über die
            Berechtigungen geregelt werden.</p>

            <p>FanPress CM besitzt ein einfaches Revisions-System, d. h. bei Änderungen wird der vorherige Zustand gesichert und kann
            jederzeit wiederhergestellt werden. Die Revisionen kannst du über den Tab <i>Versionen</i> verwalten. Die Revisionen können
            über die Systemeinstellungen (de)aktiviert werden. Eine Liste aller Revisionen findest du über den entsprechenden Reiter
            im Editor. Dort kannst du jede Revision einzeln aufrufen bzw. den aktuelle Artikel auf eine Revision zurücksetzten.</p>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            HL_ARTICLE_EDIT
        </headline>
        <text>
        <![CDATA[
            <p>Im Bereich <b>Artikel bearbeiten</b> kannst findest du alle gespeicherten Artikel in FanPress CM. Über das Aktions-Menü unten rechts kannst
            du verschiedene Dinge durchführen, bspw. Artikel löschen oder archivieren.</p>
            <p>Über den Button <span class="fpcm-ui-button">Suche & Filter</span> kannst du mithilfe eines Dialogs die angezeigten Artikel anhand verschiedener Kriterien
            weiter eingrenzen. Über die Hauptnavigation kannst du bereits eine Vorauswahl treffen, welche Artikel dir angezeigt werden sollen.</p>
            <p>Sofern aktiv hast du am oberen Rand den Reiter "Papierkorb". Hier findest du eine Übersicht aller gelöschten Artikel. Du
            kannsst diese hier wieder herstellen oder vollständig löschen.</p>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            HL_COMMENTS_MNG
        </headline>
        <text>
        <![CDATA[
            <p>Im Bereich <b>Kommentare</b> erhältst du - unabhänig von den Artikeln - eine genrelle Übersicht über alle
            geschriebenen Kommentare. Hier besteht die Möglichkeit, alle Kommentare zu löschen, ent/sperren, etc.</p>
            <p>Willst du nur die Artikel zu einem bestimmten Artikel anzeigen lassen, geht das wie gewohnt über die Liste
            auf dem Kommentar-Tab im Artikel-Editor.</p>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            HL_FILES_MNG
        </headline>
        <text>
        <![CDATA[
        <p>Im <b>Dateimanager</b> kannst du Bilder hochladen, welche du in deinen Artikeln verwendet willst. Eine vereinfachte Ansicht lässt
        sich auch direkt aus dem Artikel-Editor heraus aufrufen. Er zeigt neben einem Vorschau-Bild noch einige zusätzliche Informationen zur
        hochgeladenen Datei an.</p>
        <p>Der Dateimanager bietet zwei verschiedene Modi. Einmal die klassischen Version, welche mittels HTML-Formularen arbeitet und vor allem
        für ältere Browser zu empfehlen ist. Alternativ steht der - standardmäßig aktive - Dateimanager auf Basis von jQuery zu Verfügung.
        Dieser bietet mehr Komfort und unterliegt weniger Beschränkungen v. a. beim Hochladen mehrerer Dateien.</p>
        <p>Welcher Modus genutzt wird, kann über die Systemeinstellungen festgelegt werden.</p>
        <p><b>Ich möchte ein Bild in einen Artikel einfügen, wie geht das?</b></p>
        <p>Um den Pfad eines Bildes direkt in den "Bild einfügen"-Formular zu kopieren, klicke auf die Buttons
        <span class="fpcm-ui-button">Thumbnail-Pfad in Quelle einfügen</span> bzw. <span class="fpcm-ui-button">Datei-Pfad in Quelle einfügen</span>
        zwischen dem Thumbnail und den Meta-Informationen des jeweiligen Bildes, je nachdem was du nutzen möchtest.</p>
        <p>Alternativ mache in der Dateiliste einen Rechtsklick auf den Bild- und/oder Thumbnail öffnen Button. Wähle nun im Kontext-Menü des
        jeweiligen Browsers "Link-Adresse kopieren", "Verknüpfung kopieren", o. ä. Füge den Pfad anschließend in das Feld "Quelle" im Editor
        ein. Im HTML-Editor kannst du auch einfach anfangen, den Dateinamen einzutippen. Hier öffnet sich dann eine
        Autovervollständigung. In TinyMCE steht im Bild einfügen Dialog auch ein Punkt auch "Image List" zur Verfügung.</p>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            HL_PROFILE
        </headline>
        <text>
        <![CDATA[
            <p>Das eigene <b>Profil</b> können alle Benutzer über das Profil-Menü oben rechts aufrufen. Jeder Benutzer kann dort folgende Dinge
            anpassen:</p>
            <ul>
                <li><b>Passwort</b> zum Login</li>
                <li><b>Name</b> welcher in den Artikel als Author-Name angezeigt wird</li>
                <li><b>E-Mail-Adresse</b> an die bspw. ein zurückgesetztes Passwort gesendet wird</li>
                <li><b>Sprache</b> des FanPress CM Admin-Bereichs</li>
                <li><b>Zeitzone</b> welche für die Umrechnung von Zeitangaben genutzt wird</li>
                <li><b>Datum- und Zeitanzeige</b>, welche für die Darstellung von Zeitangaben genutzt wird</li>
                <li><b>Anzahl an Artikeln im ACP</b>, legt die Anzahl an Artikeln fest, welche unter "Artikel bearbeiten" pro Seite angezeigt werden</li>
            </ul>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            HL_OPTIONS
        </headline>
        <text>
        <![CDATA[
            <p>Im Bereich <b>Optionen</b> können sämtliche Einstellungen von FanPress CM verändert werden.</p>
            <ul>
                <li><b>Systemeinstellungen:</b><br>
                    Benutzer mit den entsprechenden Rechten können hier zentrale Einstellungen von FanPress CM ändern.
                    <ul>
                        <li><b>Allgemein:</b><br>
                            <ul>
                                <li>Der obere Teil enthält allgemeine Einstellungen:
                                    <ul>
                                        <li><em>E-Mail-Adresse:</em> Zentrale E-Mail-Adresse für Systembenachrichtigungen.</li>
                                        <li><em>URL für Artikellinks:</em> Basis-URL für Artikel-Links im Frontent, wichtig v. a. bei der Nutzung
                                            von phpinclude. Entspricht in vielen Fällen der <em>deine-domain.xyz/index.php</em> oder der Datei, in der
                                            <em>fpcmapi.php</em> includiert ist.</li>
                                        <li><em>Sprache:</em> Globale Spracheinstellung, kann durch Profileinstellung überschrieben werden.</li>
                                        <li><em>Zeitzone:</em> Globale Zeitzone, kann durch Profileinstellung überschrieben werden.</li>
                                        <li><em>Datum- und Zeitanzeige:</em> Maske für die Anzeige von Datums- und Zeitangaben, kann durch
                                        Profileinstellung überschrieben werden.</li>
                                        <li><em>Zeit bis zum Verfall des Cache-Inhaltes:</em> Zeit bis der Cache-Inhalt von
                                        FanPress CM automatisch verworfen und der Cache neu aufgebaut wird.</li>
                                        <li><em>Verwendung per:</em> Nutzung von FanPress CM via phpinclude oder in einem iframe.</li>
                                        <li><em>Pfad zu deiner CSS-Datei:</em> Pfad zu deiner CSS-Datei mit deinen eigenen Style-Angaben. Wichtig
                                        wenn du FanPress CM via iframe nutzt.</li>
                                        <li><em>jQuery Bibliothek laden:</em> Soll jQuery bei Nutzung von phpinclude geladen werden oder nicht.
                                        Wichtig wenn du jQuery nicht andersweitig in deiner Seite eingebunden hast.</li>                                        
                                    </ul>
                                </li>
                                <li>Der untere Teil enthält Einstellungen zur Wartungs und System-Sicherheit:
                                    <ul>
                                        <li><em>Wartungsmodus aktiv:</em> Wurde der Wartungsmodus aktiviert, so haben nur angemeldete Benutzer Zugriff auf FanPress CM.
                                            Besucher deienr Seite, etc. erhalten eine Hinweis-Meldung.</li>
                                        <li><em>Maximale Länge einer Admin-Sitzung:</em> Länge einer Session im FanPress-CM Adminbereich.</li>
                                        <li><em>Anzahl Login-Versuche vor temporärerer Sperre:</em> Hiermit kannst du Anzahl der Fehlgeschlagenen Logins einstellen,
                                            bis der Login vorübergehend gesperrt wird. Diese Option hilft dabei, die Übernahme von FanPress CM Accounts
                                            zu erschweren.</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><b>Editor & Dateimanager:</b><br>
                            Der Tab umfasst Einstellungen zum Artikel-Editor und Dateimanager.
                            <ul>
                                <li><em>Editor auswählen:</em> Welcher Editor soll genutzt werden, die reine HTML-Ansicht oder der auf
                                Basis von TinyMCE 4.</li>
                                <li><em>jQuery Dateiupload verwenden:</em> Soll der moderne AJAX-Uploader genutzt werden, mit dem
                                mehrere Dateien auf einmal hochgeladen werden können. Oder den klassischen PHP-Uploader nutzten.</li>
                                <li><em>Revisionen aktivieren:</em> Soll FanPress CM Revisionen beim Speichern eines Artikels anlegen.</li>
                                <li><em>Artikel vor dem Löschen in Papierkorb verschieben:</em> Artikel nicht direkt löschen sondern
                                zuerst in Papierkorb verschieben. Hier kannst du sie ggf. wiederherstellen.</li>
                                <li><em>Vorschaubild erzeugen wenn Bild größer ist als:</em> Automatisches Erzeugen von Thumbnails, wenn
                                hochgeladene Bilder grüßer als die eingestellten Werte sind.</li>
                                <li><em>Maxmimale Größe des Vorschaubildes:</em> Größe der von FanPress CM erzeugten Thumbnails.</li>
                                <li><em>CSS-Klassen im Editor:</em> CSS-Klassen zur Nutzung im FanPress CM Editor.</li>
                            </ul>
                        </li>            
                        <li><b>Artikel:</b><br>
                            Der Tab enthält verschiedene Einstellungen zur Artikel-Ausgabe.
                            <ul>
                                <li><em>max. News pro Seite:</em> Anzahl an Artikeln, die im Frontend ausgegeben werden sollen.</li>
                                <li><em>Template für Artikel-Liste::</em> Template, welches für Artikel-Liste genutzt werden soll.</li>
                                <li><em>Template für einzelnen Artikel:</em> Template, welches für die Anzeige eines einzelnen Artikels
                                genutzt werden soll.</li>
                                <li><em>News sortieren nach:</em> Reihenfolge, nach der Artikel im Frontend sortiert werden sollen.</li>
                                <li><em>Share-Buttons anzeigen:</em> Sollen Share-Buttons angezeigt werden.</li>
                                <li><em>Archiv-Link anzeigen:</em> Soll Link zu Archiv in der Navigation im Frontend angezeigt werden.</li>
                                <li><em>RSS-Feed ist aktiv:</em> RSS-Feed aktivieren.</li>
                            </ul>
                        </li>
                        <li><b>Kommentare:</b><br>
                            Der Tab enthält verschiedene Einstellungen zur Ausgabe von Artikel-Kommentaren und deren Verwaltung.
                            <ul>
                                <li><em>Kommentar-System ist aktiv:</em> Kommentar-System global de/aktivieren.</li>
                                <li><em>Kommentare-Template:</em> Template für die Anzeige von Kommentaren.</li>
                                <li><em>Anti-Spam-Frage:</em> Frage für das Standard-Spam-Plugin.</li>
                                <li><em>Antwort auf Anti-Spam-Frage:</em> Antwort für das Standard-Spam-Plugin.</li>
                                <li><em>Zeitsperre zwischen zwei Kommentaren:</em> Zeit in Sekunden, die zwischen zwei Kommentaren von
                                der selben IP-Adresse verangen sein muss.</li>
                                <li><em>Muss E-Mail Adresse angegeben werden:</em> Muss E-Mail-Adresse beim Schreiben eines Kommentares
                                angegeben werden oder nicht.</li>
                                <li><em>Müssen Kommentare freigeschalten werden:</em> Kommentare sind sofort sichtbar oder
                                müssen manuell durch den Author oder einen Admin freigegeben werden.</li>
                                <li><em>Benachrichtigung bei neuem Kommentare an:</em> E-Mail-Adresse festlegen, an welche die
                                Benachrichtigungen über neue Kommentare gehen. (nur an Author, nur an globale Adresse oder an beide)</li>
                                <li><em>Automatische Spam-Markierung:</em> Sind vom aktuellen Kommentar-Autor bereits diese Anzahl an Kommentaren
                                    als Spam markiert im System vorhanden, so wird der neue Kommentar automatisch als Spam markiert.</li>
                            </ul>
                        </li>
                        <li><b>Twitter-Verbindung:</b><br>
                            Sofern dieser Tab angezeigt wird, siehe letzter Hilfe-Abschnitt ganz unten.
                        </li>
                        <li><b>System-Überprüfung & Updates:</b><br>
                            Auf diesem Tab erhälst du eine Übersicht über den aktuelle Update-Status deines FanPress CM-Systems sowie
                            der verfügbaren Funktionen, etc. deines Servers. Bei allen <i>nicht-optionalen</i> Werten sollte ein blauer
                            Haken wie <span class="fa fa-check-square fpcm-ui-booltext-yes"></span> zu sehen sein. Wenn dies nicht der
                            Fall ist, wende sich an deinen Host.
                        </li>            
                    </ul>
                </li>
                <li><b>Benutzer & Rollen:</b><br>
                    Benutzer mit entsprechenden Rechten können Benutzer und Benutzer-Rollen anlegen und veralten.
                </li>
                <li><b>Berechtigungen:</b><br>
                    Benutzer mit entsprechenden Rechten können hier die Zugriffsrechte auf verschiedene Dinge von FanPress CM ändern und
                    den Zugriff einschränken. Der Bereich sollte nur von Administratoren nutzbar sein! Der Rolle "Administrator" kann der Zugriff
                    auf die Rechte-Einstellungen nicht verweigert werden.
                </li>
                <li><b>IP-Adressen:</b><br>
                    Benutzer mit Rechten zur Änderung der Systemeinstellungen können hier IP-Adressen sperren oder Sperren wieder aufheben.
                    (z. B. wegen Spam) Pro Eintrag kann festgelegt werden, für welchen öffentlichen Bereich von FanPress CM die Sperren gelten
                    soll: keine Kommentare, kein Login, überhuapt kein Zugriff
                </li>
                <li><b>Kategorien:</b><br>
                    Benutzer mit entsprechenden Rechten können hier neue Kategorien, sowie bestehende ändern oder löschen.
                </li>
                <li><b>Templates:</b><br>
                    Benutzer mit entsprechenden Rechten können die Templates zur Ausgabe von Artikeln, Kommentaren, etc. bearbeiten.
                    Für eine bessere Übersicht bietet der Template-Editor Syntax-Hilighting und eine Liste der verfügbaren Platzhalter.
                </li>
                <li><b>Smileys:</b><br>
                    Benutzer mit den entsprechenden Rechten können die nutzbaren Smileys verwalten.
                </li>
                <li><b>Logs & Cronjob:</b><br>
                    Im Bereich der Systemlogs findest du eine Auflistung aller bisherigen Benutzer-Logins, System-Meldungen von FanPress und
                    Fehlermeldungen durch PHP selbst oder der Datenbank. Über den Button <i>Log-Datei leeren</i> kannst du Meldungen, etc. löschen
                    lassen. Außerdem findest du hier eine Liste von verfügbaren Cronjobs (regelmäßig, automatisch ausgeführten Aufgaben)
                    und deren Status.
                </li>
            </ul>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            HL_MODULES
        </headline>
        <text>
        <![CDATA[
            <p>Im Bereich <b>Module</b> kannst du Erweiterungen verwalten, welche die Funktionalität von FanPress CM erweitern können.
            Je nachdem, welche internen Events der Ersteller eines Moduls verwendet, können diese auch direkt in der Hauptnavigation
            erscheinen. Die Aktionen, welche ein Benutzer im Module-Manager ausführen kann, hängen von seinen Berechtigungen ab. Benutzer
            ohne Administrationsrechte sollten i. d. R. keine Möglichkeit haben, Module zu installieren bzw. Änderungen an ihrer
            Konfiguration vorzunehmen.</p>
            <p>Über den Buttons am Anfang eienr Zeile kannst du Module einzeln verwalten. Um Änderungen an mheren Modulen mit einmal
            vorzunehmen, aktivieren die Checkbox am Ende jeder Modul-Zeile und wähle unten rechts die Aktion aus.</p>
            <p>Am kompfortabelsten kannst du Module verwalten, wenn dein Host Verbindungen zu anderen Servern zulässt (siehe Info im Dashboard).
            Musst du Erweiterungen manuell installieren/aktualisieren, verwende den Tab "Modul manuell installieren". Wähle die entspreche de ZIP-Datei aus
            und klicke auf <span class="fpcm-ui-button">Upload starten</span>. Die Datei wird nun auf den Server geschoben und automatisch in das richtige Verzeichnis unter
            "fanpress/inc/modules" entpackt. Ist ein Modul noch nicht installiert werden ggf. zusätzliche Schritte zur Installtion
            durchgeführt. Ist ein Modul bereits installiert, werden definierte Update-Schritte durchgeführt.</p>
            <p>Für Module lasst sich <b>Abhängigkeiten</b> definieren, d. h. ein Modul kann erst dann aktiviert/ verwendet werden wenn
            andere Module installiert sind. Wird dir vor einem Modul der Button <span class="fpcm-ui-button"><span class="ui-icon ui-icon-alert"></span></span> angezeigt,
            so wurden für dieses Modul nicht-erfüllte Abhängigkeiten festgestellt. Werde in diesem Fall einen Blick in die Modul-Informationen.</p>
            <p>Wenn du selbst ein Modul erstellen willst, schau am Besten in das <a href="http://nobody-knows.org/download/fanpress-cm/tutorial-zum-schreiben-eines-moduls/">Tutorial</a>
            und besuche die <a href="http://nobody-knows.org/fpupdate/doku/">Klassen-Doku</a>.</p>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            HL_HELP_CACHE
        </headline>
        <text>
        <![CDATA[
            <p>FanPress CM besitzt ein Cache-System, welche die Ladenzeiten und System-Belastung deutlich reduzieren, da Daten nicht bei jedem
            Seiten-Aufruf aus der Datenbank gezogen werden müssen. Bei Aktionen, in denen der Cache-Inhalt als veraltet gilt, wird er i. d. R
            automatisch geleert. Sollte dies jedoch einmal nicht geschehen, so kann du über <span class="fpcm-ui-button">Cache leeren</span> neben dem Profil-Menü eine
            manuelle Löschung des Caches anstoßen.</p>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            HL_HELP_INTEGRATION
        </headline>
        <text>
        <![CDATA[
            <p>Wie du FanPress CM auf deiner Seite verwendest, hängt davon ab wie du den Inhalt in die Seite einbindest.</p>
            <p>Hilfe bei der Einbindung erhälst du durch das "FanPress CM Integration" Modul, welches du über die Modulverwaltung
            installieren kannst. Du kannst natürlich auch manuell vorgehen:</p>
            <p><b>php include:</b></p>
            <p>Wenn du deine Seite mittels php include verwendest, binde zuerst die API-Datei im FanPress Verzeichnis ein und erzeuge
            ein neues API-Objekt.</p>
            <pre>
                &lt;?php include_once 'fanpress/fpcmapi.php'; ?&gt;
                &lt;?php $api = new fpcmAPI(); ?&gt;
            </pre>
            <p>Anschließend kannst du die verschiedenen Funktionen aufrufen. Das sind im Detail:</p>
            <ul>
                <li><strong>$api->showArticles()</strong> zum Anzeigen der Artikel, anhand von Seiten, Archiv und einzeln inkl.
                Kommentare (entspricht der shownews.php auf FanPress CM 1.x und 2.x)</li>
                <li><strong>$api->showLatestNews()</strong> zum Anzeigen der zuletzt geschriebenen Artikel</li>
                <li><strong>$api->showPageNumber()</strong> zum Anzeigen der aktuell aufgerufenen Artikel-Seite. Als Parameter kannst du
                die Beschreibung für "Seite XYZ" angeben.</li>
                <li><strong>$api->showTitle()</strong> zum Anzeigen des Titels des aktuell aufgerufenen Artikels im &lt;title&gt;-Tag.
                Als Parameter kannst du einen Trenner zum restlichen Inhalt des &lt;title&gt;-Tags angeben.</li>
                <li><strong>$api->legacyRedirect()</strong> bietet dir die Möglichkeit, deine Besucher (v. a. bei vorheriger Nutzung des
                Importer-Modules) vom alten FanPress CM 1/2-URL-Stil zur entsprechenden Stelle von FanPress CM 3 weiterzuleiten.</li>
            </ul>
            <p>Die Ausgabe kannst du zudem über einige PHP-Konstanten beeinflussen:</p>
            <ul>
                <li><strong>FPCM_PUB_CATEGORY_LATEST</strong> Kategorie festlegen in $api->showLatestNews()</li>
                <li><strong>FPCM_PUB_CATEGORY_LISTALL</strong> Kategorie festlegen in $api->showArticles()</li>
                <li><strong>FPCM_PUB_LIMIT_LISTALL</strong> Anzahl der aktiven Artikel in $api->showArticles()</li>
                <li><strong>FPCM_PUB_LIMIT_ARCHIVE</strong> Anzahl der archvierten Artikel in $api->showArticles()</li>
                <li><strong>FPCM_PUB_LIMIT_LATEST</strong> Anzahl der Artikel in $api->showLatestNews()</li>
                <li><strong>FPCM_PUB_OUTPUT_UTF8</strong> UTF-8-Zeichensatz für Ausgabe de/aktivieren, in $api->showLatestNews(),
                $api->showArticles() und $api->showTitle(), sollte nur genutzt werden wenn Umlaute, Sonderzeichen, etc. nicht richtig
                angezeigt werden.</li>
            </ul>
            
            <p><b>iframes:</b></p>
            <p>Solltest du FanPress CM in <i>iframes</i> nutzen, so musst du die entsprechenden Controller direkt aufrufen.</p>
            <ul>
                <li><strong>deine-seite.xyz/fanpress/index.php?module=fpcm/list</strong> zum Anzeigen der aktiven Artikel
                (entspricht der shownews.php auf FanPress CM 1.x und 2.x)</li>
                <li><strong>deine-seite.xyz/fanpress/index.php?module=fpcm/archive</strong> zum Anzeigen des Artikel-Archives
                (entspricht der shownews.php auf FanPress CM 1.x und 2.x)</li>
                <li><strong>deine-seite.xyz/fanpress/index.php?module=fpcm/article&&amp;id=EINE_ZAHL</strong> zum Anzeigen eines ganz bestimmtes
                Artikels inkl. seiner Kommentare, etc.</li>
                <li><strong>deine-seite.xyz/fanpress/index.php?module=fpcm/latest</strong> zum Anzeigen der Latest News</li>
            </ul>
            
            <p><b>RSS Feed:</b></p>
            <p>Sofern du auch den RSS-Feed von FanPress CM für deine Besucher zur Verfügung stellen willst, so verlinke einfach auf
            <strong>deine-seite.xyz/fanpress/index.php?module=fpcm/feed</strong>. Der Link ist unabhängig von der restlichen Integration
            in deine Seite.</p>
        ]]>
        </text>
    </chapter>
    <chapter>
        <headline>
            SYSTEM_OPTIONS_TWITTER_CONNECTION
        </headline>
        <text>
        <![CDATA[
            <p>FanPress CM bietet dir die Möglichkeit, beim schreiben/aktualisieren eines Artikels automatisch einen Tweet bei Twitter
            erzeugen zu lassen.</p>
            <p>Um die Verbindung zu Twitter herzustellen, folge einfach der Anleitung.</p>
            <ol>
                <li>Öffne die Einstellungen der Twitter-Verbindungen über <strong>Optionen &rarr; Systemeinstellungen &rarr;
                Twitter-Verbindung</strong>.</li>
                <li><strong>API-Schlüssel:</strong> Klicke auf den Button <span class="fpcm-ui-button">API-Schlüssel
                anzufordern</span> und logge dich auf der Entwickler-Webseite von Twitter mit deinen normalen Zugangsdaten ein.</li>
                <li>Scrolle auf der folgenden Seite ganz nach unten bis du im Footer den Punkt "Manage Your Apps" siehst und klicke
                diesen an. Wählen den Button <span class="fpcm-ui-button">Create new app</span>, fülle das Formular aus und bestätige mit
                <span class="fpcm-ui-button">Create your Twitter application</span>.</li>
                <li>Öffne den Tab <strong>Keys and Access Tokens</strong> und kopiere von dort<strong>Consumer Key (API Key)</strong>
                    und <strong>Consumer Secret (API Secret)</strong> in die Felder in den Systemeinstellungen.</li>
                <li>Um Tweets erzeugen zu können, stelle den <strong>Access Level</strong> über den Reiter <strong>Permissions</strong>
                    von <strong>Read-only</strong> auf <strong>Read and Write</strong>.</li>
                <li><strong>Access Token:</strong> Nach dem API-Key musst du nun einen Access Token erzeugen. Scrolle dafür runter zum
                    Punkt <strong>Your Access Token</strong> und klicke auf den Button <span class="fpcm-ui-button">Create my access
                    token</span>. Kopiere anschließend <strong>Access Token</strong> und <strong>Access Token Secret</strong> in
                    in die Felder in den Systemeinstellungen.</li>
                
                <li>Klicke nun in den <strong>Systemeinstellungen</strong> auf Speichern, um die Daten zu speichern.</li>
                <li>Wurden alle Schritte richtig durchgeführt, so erhälst du einen entsprechenden Hinweis.</li>
            </ol>
            <p>Um die Twitter-Verbindung zu löschen, klicke den Button <span class="fpcm-ui-button">Verbindung zu löschen</span> an.</p>
        ]]>
        </text> 
    </chapter>
    <chapter>
        <headline>
            HL_HELP_SUPPORT
        </headline>
        <text>
        <![CDATA[
            <p>Solltest du weitergehende Hilfe bei technischen Problemen brauchen oder Fragen haben, schreiben eine E-mail an
            <em>fanpress@nobody-knows.org</em> oder <em>sea75300@yahoo.de</em>. Alternativ kannst du auch auf der Download-Seite unter
            <a href="http://nobody-knows.org/download/fanpress-cm/">nobody-knows.org</a> einen Kommentar hinterlassen.</p>
            <p>Das Module <em>FanPress CM Support Module</em> kann installiert werden, um einen einfachen, temporären Zugang
            zur Verfügung zu stellen. Beachte bitte, dass bereits bei der Installtion einen E-Mail mit den Zugangsdaten versendet
            wird.</p>
        ]]>
        </text> 
    </chapter>
</chapters>