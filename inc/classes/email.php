<?php
    /**
     * FanPress CM e-mail object
     * 
     * Objekt für Verwaltung einer E-Mail
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\classes;

    /**
     * E-Mail-Objekt
     * 
     * @package fpcm\classes\email
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    final class email {

        /**
         * Event-Liste
         * @var \fpcm\model\events\eventList
         */
        private $events;

        /**
         * Config-Objekt
         * @var \fpcm\model\system\config
         */
        private $config;

        /**
         * Empfänger
         * @var string
         */
        private $to         = '';

        /**
         * Absender
         * @var string
         */
        private $from       = '';

        /**
         * Betreff
         * @var string
         */
        private $subject    = '';

        /**
         * E-Mail-Text
         * @var string
         */
        private $text       = '';

        /**
         * Headers
         * @var array
         */
        private $headers    = [];

        /**
         * HTML-E-Mail-Status
         * @var bool
         */
        private $html       = false;

        /**
         * Konstruktor
         * @param sring $to Empfänger-Adresse
         * @param sring $subject Betreff
         * @param sring|array $text E-Mail-Inhalt
         * @param sring $from Absender-Adresse, Default: fanpresscm@@hostdomain.xyz
         * @param bool $html enthält $text HTML-Code ja/nein
         */
        function __construct($to, $subject, $text, $from = false, $html = false) {
            $this->to       = $to;
            $this->from     = $from ? $from : 'FanPress CM <fanpresscm@'.$_SERVER['HTTP_HOST'].'>';
            $this->subject  = $subject;
            $this->text     = is_array($text) ? implode(PHP_EOL, $text) : $text;
            $this->html     = $html;

            $this->events   = baseconfig::$fpcmEvents;
            $this->config   = baseconfig::$fpcmConfig;
        }

        /**
         * Empfänger auslesen
         * @return sring
         */
        function getTo() {
            return $this->to;
        }

        /**
         * Absender auslesen
         * @return sring
         */
        function getFrom() {
            return $this->from;
        }

        /**
         * Betreff auslesen
         * @return sring
         */
        function getSubject() {
            return $this->subject;
        }

        /**
         * E-Mail-Inhalt auslesen
         * @return sring
         */
        function getText() {
            return $this->text;
        }

        /**
         * HTMl-E-Mail ja/nein
         * @return bool
         */
        function isHtml() {
            return $this->html;
        }

        /**
         * Empfänger setzen
         * @param sring $to
         */
        function setTo($to) {
            $this->to = $to;
        }

        /**
         * Absender setzen
         * @param sring $from
         */
        function setFrom($from) {
            $this->from = $from;
        }

        /**
         * Betreff setzen
         * @param sring $subject
         */
        function setSubject($subject) {
            $this->subject = $subject;
        }

        /**
         * E-Mail-Inhalt setzen
         * @param sring $text
         */
        function setText($text) {
            $this->text = $text;
        }

        /**
         * E-Mail- als HTML-E-Mail markieren
         * @param bool $html
         */
        function setHtml($html) {
            $this->html = $html;
        }

        /**
         * Versendet E-Mail
         * @return boolean
         */
        public function submit() {

            $this->headers['headerFrom']   = 'FROM: '.$this->from;
            $this->headers['headerMailer'] = 'X-Mailer: FanPressCM'.$this->config->system_version.'/PHP'.PHP_VERSION;

            if ($this->html) {
                $this->headers['headerMime']    = 'MIME-Version: 1.0';
                $this->headers['headerContent'] = 'Content-type: text/html; charset=utf-8';
            }

            $eventData = $this->events->runEvent('emailSubmit', array(
                'headers'     => $this->headers,
                'maildata'    => array(
                    'to'      => $this->to,
                    'from'    => $this->from,
                    'subject' => utf8_decode($this->subject),
                    'text'    => ($this->html ? $this->text : utf8_decode($this->text))
                )
            ));

            $this->headers = $eventData['headers'];
            foreach ($eventData['maildata'] as $key => $value) {
                $this->$key = $value;
            }

            return call_user_func([$this, 'submit'.($this->config->smtp_enabled ? 'Smtp' : 'Php')]);
        }

        /**
         * E-Mail versenden via PHP mail() Funktion
         * @return boolean
         */
        private function submitPhp() {

            if (!mail($this->to, $this->subject, $this->text, implode(PHP_EOL, $this->headers))) {
                trigger_error("Unable to send e-mail \"{$this->subject}\" to \"{$this->to}\".\n----------\n{$this->text}");
                return false;
            }

            return true;
        }

        /**
         * E-Mail via SMTP versenden
         * @return bool
         */
        private function submitSmtp() {
            
            require_once loader::libGetFilePath('PHPMailer', 'class.phpmailer.php');
            require_once loader::libGetFilePath('PHPMailer', 'class.smtp.php');
            

            $mail = new \PHPMailer();
            $mail->isSMTP();
            $mail->isHTML($this->html);
            $mail->setFrom($this->config->smtp_settings['user']);
            
            $recipients   = explode('; ', $this->to);
            foreach ($recipients as $recipient) {
                $recipient = explode(' <', $recipient, 3);
                $mail->addAddress($recipient[0], isset($recipient[1]) ? trim(str_replace(['<', '>'], '', $recipient[1])) : '');
            }

            $mail->Subject = $this->subject;
            $mail->Body    = $this->text;
            $mail->XMailer = $this->headers['headerMailer'];

            unset($this->headers['headerFrom'], $this->headers['headerMailer'],  $this->headers['headerMime'], $this->headers['headerContent']);
            
            if (count($this->headers)) {
                foreach ($this->headers as $name => $value) {
                    $mail->addCustomHeader($name, $value);
                }
            }
            
            $autoEncryption = ($this->config->smtp_settings['encr'] === 'auto' ? true : false);
            
            $mail->Host        = $this->config->smtp_settings['srvurl'];
            $mail->Username    = $this->config->smtp_settings['user'];
            $mail->Password    = $this->config->smtp_settings['pass'];
            $mail->Port        = $this->config->smtp_settings['port'];
            $mail->SMTPSecure  = !$autoEncryption ? $this->config->smtp_settings['encr'] : '';
            $mail->SMTPAutoTLS = $autoEncryption;
            $mail->SMTPAuth    = ($this->config->smtp_settings['user'] && $this->config->smtp_settings['pass']) ? true : false;

            if (!$mail->send()) {
                trigger_error("Unable to send SMTP e-mail \"{$this->subject}\" to \"{$this->to}\".\n----------\n{$this->text}\n----------\n\n{$mail->ErrorInfo}");
                return false;
            }

            return true;

        }

    }
