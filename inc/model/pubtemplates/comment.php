<?php
    /**
     * Public comment template file object
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\pubtemplates;

    /**
     * Kommentar Template Objekt
     * 
     * @package fpcm.model.system
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class comment extends template {

        /**
         * Template-Platzhalter
         * @var array
         */        
        protected $replacementTags = array(
            '{{author}}'                    => '',
            '{{email}}'                     => '',
            '{{website}}'                   => '',
            '{{text}}'                      => '',
            '{{date}}'                      => '',
            '{{number}}'                    => '',
            '{{id}}'                        => '',
            '{{mention}}:{{/mention}}'      => '',
            '{{mentionid}}:{{/mentionid}}'  => ''
        );
        
        /**
         * Konstruktor
         * @param string $fileName Template-Datei unterhalb von data/styles/comments
         */
        public function __construct($fileName) {
            parent::__construct($fileName.'.html', \fpcm\classes\baseconfig::$stylesDir.'comments/');
        }
        
        /**
         * Parst Template-Platzhalter
         * @return boolean
         */        
        public function parse() {

            if (!count($this->replacementTags) || !$this->content) return false;

            $this->replacementTags = $this->events->runEvent('parseTemplateComment', $this->replacementTags);
            
            $content = $this->content;
            
            $tags    = array_merge($this->replacementInternal, $this->replacementTags);
            
            $this->parseLinks($tags['{{text}}']);
            
            foreach ($tags as $replacement => $value) {
                
                $replacement = explode(':', $replacement);                
                $values = array();

                switch ($replacement[0]) {
                    case '{{mention}}':
                        $keys   = $replacement;                        
                        $values = array("<a href=\"\" id=\"$value\" class=\"fpcm-pub-mentionlink\">", '</a>');
                        break;
                    case '{{website}}':
                        $keys   = $replacement;                        
                        $values = array("<a href=\"{$value}\" class=\"fpcm-pub-websitelink\">{$value}</a>");
                        break;
                    default:
                        $keys   = $replacement;                        
                        $values = array($value);                        
                        break;
                }
                
                $content = str_replace($keys, $values, $content);
            }            
            
            $this->parseMentions($content);
            
            return $this->parseSmileys($content);
        }
        
        /**
         * Mentions parsen
         * @param string $content
         * @return string
         */
        protected function parseMentions(&$content) {            
            if (strpos($content, '@#') === false) return;
            $content = preg_replace("/@#([0-9])+/", "<a class=\"fpcm-pub-mentionedlink\" href=\"#c$1\">@$1</a>", $content);
        }
        
        /**
         * Links in Kommentar parsen
         * @param string $content
         * @param array $attributes
         */
        private function parseLinks(&$content, array $attributes=array()) {
            $attrs = '';
            foreach ($attributes as $attribute => $value) {
                $attrs .= " {$attribute}=\"{$value}\"";
            }
            
            preg_match_all("#(https?)://\S+[^\s.,>)\];'\"!?]#", $content, $links);
            if (!$links || !count($links)) return false;
            
            $links = array_map('trim', array_map('strip_tags', $links[0]));
            
            foreach ($links as $link) {
                if (strpos($link, '">') !== false || strpos($link, "'>") !== false) continue;
                $content = str_replace($link, "<a href=\"{$link}\" {$attrs}>{$link}</a>", $content);
            }
        }

    }
?>