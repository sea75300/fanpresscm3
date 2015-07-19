<?php
    /**
     * FanPress CM e-mail object
     * 
     * Objekt für Verwaltung einer E-Mail
     * 
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\classes;

    /**
     * E-Mail-Objekt
     * 
     * @package fpcm.classes.email
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */ 
    final class email {

        /**
         * Event-Liste
         * @var \fpcm\model\events\eventList
         */
        private $events;

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
         * HTML-E-Mail-Status
         * @var bool
         */
        private $html       = false;

        function __construct($to, $subject, $text, $from = false, $html = false) {
            $this->to       = $to;
            $this->from     = $from ? $from : 'FanPress CM <fanpresscm@'.$_SERVER['HTTP_HOST'].'>';
            $this->subject  = $subject;
            $this->text     = is_array($text) ? implode(PHP_EOL, $text) : $text;
            $this->html     = $html;

            $this->events   = baseconfig::$fpcmEvents;
        }

        function getTo() {
            return $this->to;
        }

        function getFrom() {
            return $this->from;
        }

        function getSubject() {
            return $this->subject;
        }

        function getText() {
            return $this->text;
        }

        function isHtml() {
            return $this->html;
        }

        function setTo($to) {
            $this->to = $to;
        }

        function setFrom($from) {
            $this->from = $from;
        }

        function setSubject($subject) {
            $this->subject = $subject;
        }

        function setText($text) {
            $this->text = $text;
        }

        function setHtml($html) {
            $this->html = $html;
        }

        /**
         * Versendet E-Mail
         * @return boolean
         */
        public function submit() {

            $headers    = array();
            $headers[]  = 'FROM: '.$this->from;
            $headers[]  = 'X-Mailer: FanPressCM3/PHP'.PHP_VERSION;

            if ($this->html) {
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=utf-8';
            }

            $eventData = $this->events->runEvent('emailSubmit', array(
                'headers'     => $headers,
                'maildata'    => array(
                    'to'      => $this->to,
                    'from'    => $this->from,
                    'subject' => utf8_decode($this->subject),
                    'text'    => ($this->html ? $this->text : utf8_decode($this->text))
                )
            ));

            $headers = $eventData['headers'];
            foreach ($eventData['maildata'] as $key => $value) {
                $this->$key = $value;
            }

            if (!mail($this->to, $this->subject, $this->text, implode(PHP_EOL, $headers))) {
                trigger_error("Unable to send e-mail \"{$this->subject}\" to \"{$this->to}\".\n----------\n{$this->text}");
                return false;
            }

            return true;
        }    

    }
