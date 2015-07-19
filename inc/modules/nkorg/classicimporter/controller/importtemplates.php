<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class importtemplates extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $data = $db->fetch($db->select('config', 'config_value', "config_name = 'active_news_template' OR config_name = 'active_comment_template'"), true);
            
            $articleTemplate = $this->fpcm2Path.'/styles/'.$data[0]->config_value.'.html';
            $commentTemplate = $this->fpcm2Path.'/styles/'.$data[1]->config_value.'.html';
            
            if (!file_exists($articleTemplate) || !file_exists($commentTemplate)) die('0');

            if (file_put_contents(\fpcm\classes\baseconfig::$stylesDir.'articles/fpcm2import.html', '') === false || file_put_contents(\fpcm\classes\baseconfig::$stylesDir.'comments/fpcm2import.html', '') === false) {
                trigger_error('Unable to create import template dummy files...');
                die('0');
            }
            
            $articleReplacements = array(
                '%news_headline%'   => '{{headline}}',
                '%news_text%'       => '{{text}}',
                '%author%'          => '{{author}}',
                '%category%'        => '{{categoryTexts}}',
                '%caticon%'         => '{{categoryIcons}}',
                '%date%'            => '{{date}}',
                '%edited%'          => '{{changeDate}}',
                '%comment_count%'   => '{{commentCount}}',
                '%commemts%'        => '{{commentLink}}Comments{{/commentLink}}',
                '%sharebuttons%'    => '{{shareButtons}}',
                '[newslink]'        => '{{permaLink}}',
                '[/newslink]'       => '{{/permaLink}}',
                '%status_pinned%'   => '{{statusPinned}}'
            );
            
            $articleTemplateContent = str_replace(array_keys($articleReplacements), array_values($articleReplacements), file_get_contents($articleTemplate));            
            $tplArticle = new \fpcm\model\pubtemplates\article('fpcm2import');
            $tplArticle->setContent($articleTemplateContent);
            if (!$tplArticle->save()) {
                trigger_error('Unable to import active FanPress CM 2.5 article template.');
                die('0');
            }

            $commentReplacements = array(
                '%author%'          => '{{author}}',
                '%email%'           => '{{email}}',
                '%comment_text%'    => '{{text}}',
                '%url%'             => '{{website}}',
                '%date%'            => '{{date}}',
                '%comment_num%'     => '{{number}}',
                '[mention]'         => '{{mention}}',
                '[/mention]'        => '{{/mention}}'
            );
            
            $commentTemplateContent = str_replace(array_keys($commentReplacements), array_values($commentReplacements), file_get_contents($commentTemplate));
            $tplComment = new \fpcm\model\pubtemplates\comment('fpcm2import');
            $tplComment->setContent($commentTemplateContent);
            if (!$tplComment->save()) {
                trigger_error('Unable to import active FanPress CM 2.5 comment template.');
                die('0');
            }
            
            die('1');
        }

    }
?>