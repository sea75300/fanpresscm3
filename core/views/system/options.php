<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-cog"></span> <?php $FPCM_LANG->write('HL_OPTIONS_SYSTEM'); ?></h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=system/options">
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-options-general"><?php $FPCM_LANG->write('SYSTEM_HL_OPTIONS_GENERAL'); ?></a></li>
                <li><a href="#tabs-options-editor"><?php $FPCM_LANG->write('SYSTEM_HL_OPTIONS_EDITOR'); ?></a></li>
                <li><a href="#tabs-options-news"><?php $FPCM_LANG->write('SYSTEM_HL_OPTIONS_ARTICLES'); ?></a></li>
                <li><a href="#tabs-options-comments"><?php $FPCM_LANG->write('SYSTEM_HL_OPTIONS_COMMENTS'); ?></a></li>
                <?php if ($showTwitter) : ?> 
                <li><a href="#tabs-options-twitter"><?php $FPCM_LANG->write('SYSTEM_HL_OPTIONS_TWITTER'); ?></a></li>
                <?php endif; ?>
                <li id="tabs-options-syscheck"><a href="#tabs-options-check"><?php $FPCM_LANG->write('SYSTEM_HL_OPTIONS_SYSCHECK'); ?></a></li>
            </ul>

            <div id="tabs-options-general">
                <table class="fpcm-ui-table fpcm-ui-options">
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_MAINTENANCE'); ?>:</td>
                        <td><?php fpcm\model\view\helper::boolSelect('system_maintenance', $globalConfig['system_maintenance']); ?></td>		
                    </tr>
                    <tr>			
                        <td><?php $FPCM_LANG->write('GLOBAL_EMAIL'); ?>:</td>
                        <td><?php fpcm\model\view\helper::textInput('system_email', '', $globalConfig['system_email']); ?></td>		
                    </tr>			
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_URL'); ?>:</td>
                        <td><?php fpcm\model\view\helper::textInput('system_url', '', $globalConfig['system_url']); ?></td>
                    </tr>	
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_LANG'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('system_lang', $languages, $globalConfig['system_lang'], false, false); ?></td>				 
                    </tr>		
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_TIMEZONE'); ?>:</td>
                        <td><?php fpcm\model\view\helper::selectGroup('system_timezone', $timezoneAreas, $globalConfig['system_timezone']); ?></td>		
                    </tr>						
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_DATETIMEMASK'); ?>:</td>
                        <td><?php fpcm\model\view\helper::textInput('system_dtmask', '', $globalConfig['system_dtmask']); ?></td>
                    </tr>			 			 
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_SESSIONLENGHT'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('system_session_length', $acpLenghts, $globalConfig['system_session_length'], false, false); ?></td>
                    </tr>
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_CACHETIMEOUT'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('system_cache_timeout', $cacheTimeout, $globalConfig['system_cache_timeout'], false, false); ?></td>
                    </tr>                               
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_USEMODE'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('system_mode', $systemModes, $globalConfig['system_mode'], false, false); ?></td>		
                    </tr>			 
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_STYLESHEET'); ?>:</td>
                        <td><?php fpcm\model\view\helper::textInput('system_css_path', '', $globalConfig['system_css_path']); ?></td>
                    </tr>
                    <tr>
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_INCLUDEJQUERY'); ?>:</td>
                        <td>
                            <?php fpcm\model\view\helper::boolSelect('system_loader_jquery', $globalConfig['system_loader_jquery']); ?>
                            <span style="position:relative;bottom:0.8em;" class="fa fa-question-circle fa-fw fpcm-ui-shorthelp" title="<?php $FPCM_LANG->write('SYSTEM_OPTIONS_INCLUDEJQUERY_YES'); ?>"></span>
                        </td>
                    </tr>                            
                </table>
            </div>

            <div id="tabs-options-editor">
                <table class="fpcm-ui-table fpcm-ui-options">
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWS_EDITOR'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('system_editor', $editors, $globalConfig['system_editor'], false, false); ?></td>		
                    </tr> 
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_REVISIONS_ENABLED'); ?>:</td>
                        <td>
                            <?php fpcm\model\view\helper::boolSelect('articles_revisions', $globalConfig['articles_revisions']); ?>
                        </td>		
                    </tr>
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWS_ENABLETRASH'); ?>:</td>
                        <td><?php fpcm\model\view\helper::boolSelect('articles_trash', $globalConfig['articles_trash']); ?></td>		
                    </tr>
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWS_NEWUPLOADER'); ?>:</td>
                        <td><?php fpcm\model\view\helper::boolSelect('file_uploader_new', $globalConfig['file_uploader_new']); ?></td>		
                    </tr>
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWSSHOWMAXIMGSIZE'); ?>:</td>
                        <td>
                            <?php fpcm\model\view\helper::textInput('files_img_thumb_minwidth', 'fpcm-ui-spinner', $globalConfig['files_img_thumb_minwidth']); ?> <span class="fa fa-times fa-fw"></span>
                            <?php fpcm\model\view\helper::textInput('files_img_thumb_minheight', 'fpcm-ui-spinner', $globalConfig['files_img_thumb_minheight']); ?>
                            <?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWSSHOWMAXIMGSIZEPIXELS'); ?>
                        </td>
                    </tr>	                        

                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWSSHOWIMGTHUMBSIZE'); ?>:</td>
                        <td>
                            <?php fpcm\model\view\helper::textInput('file_img_thumb_width', 'fpcm-ui-spinner', $globalConfig['file_img_thumb_width']); ?> <span class="fa fa-times fa-fw"></span>
                            <?php fpcm\model\view\helper::textInput('file_img_thumb_height', 'fpcm-ui-spinner', $globalConfig['file_img_thumb_height']); ?>
                            <?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWSSHOWMAXIMGSIZEPIXELS'); ?>
                        </td>	
                    </tr>
                    <tr>			
                        <td class="fpcm-align-top"><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWS_EDITOR_CSS'); ?>:</td>
                        <td>
                            <?php fpcm\model\view\helper::textArea('system_editor_css', 'fpcm-half-width fpcm-options-cssclasses', $globalConfig['system_editor_css']) ?>
                        </td>	
                    </tr>
                </table>
            </div>

            <div id="tabs-options-news">
                <table class="fpcm-ui-table fpcm-ui-options">
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWSSHOWLIMIT'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('articles_limit', $articleLimitList, $globalConfig['articles_limit'], false, false); ?></td>
                    </tr>				
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_ACTIVENEWSTEMPLATE'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('articles_template_active', $articleTemplates, $globalConfig['articles_template_active'], false, false); ?></td>		
                    </tr>				
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_ACTIVENEWSTEMPLATESINGLE'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('article_template_active', $articleTemplates, $globalConfig['article_template_active'], false, false); ?></td>		
                    </tr>
                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWS_SORTING'); ?>:</td>
                        <td>
                            <?php fpcm\model\view\helper::select('articles_sort', $sorts, $globalConfig['articles_sort'], false, false); ?> <?php fpcm\model\view\helper::select('articles_sort_order', $sortsOrders, $globalConfig['articles_sort_order'], false, false); ?>
                        </td>		
                    </tr>                        

                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWSSHOWSHARELINKS'); ?>:</td>
                        <td><?php fpcm\model\view\helper::boolSelect('system_show_share', $globalConfig['system_show_share']); ?></td>		
                    </tr>	 

                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_ARCHIVE_LINK'); ?>:</td>
                        <td><?php fpcm\model\view\helper::boolSelect('articles_archive_show', $globalConfig['articles_archive_show']); ?></td>		
                    </tr>

                    <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWS_ENABLEFEED'); ?>:</td>
                        <td><?php fpcm\model\view\helper::boolSelect('articles_rss', $globalConfig['articles_rss']); ?></td>		
                    </tr>  

                </table>                    
            </div>

            <div id="tabs-options-comments">
                <table class="fpcm-ui-table fpcm-ui-options">
                   <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_COMMENT_ENABLED_GLOBAL'); ?>:</td>
                        <td><?php fpcm\model\view\helper::boolSelect('system_comments_enabled', $globalConfig['system_comments_enabled']); ?></td>		
                   </tr>                                                
                   <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_ACTIVECOMMENTTEMPLATE'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('comments_template_active', $commentTemplates, $globalConfig['comments_template_active'], false, false); ?></td>
                   </tr>
                   <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_FLOODPROTECTION'); ?>:</td>
                        <td><?php fpcm\model\view\helper::select('comments_flood', $commentFloodList, $globalConfig['comments_flood'], false, false); ?></td>
                   </tr>		
                   <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_COMMENTEMAIL'); ?>:</td>
                        <td><?php fpcm\model\view\helper::boolSelect('comments_email_optional', $globalConfig['comments_email_optional']); ?></td>
                   </tr>	
                   <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_COMMENT_APPROVE'); ?>:</td>
                        <td><?php fpcm\model\view\helper::boolSelect('comments_confirm', $globalConfig['comments_confirm']); ?></td>		
                   </tr>	
                   <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_COMMENT_NOTIFY'); ?>:</td>
                        <td>
                        <?php fpcm\model\view\helper::select('comments_notify', $notify, $globalConfig['comments_notify'], false, false); ?>
                        
                        </td>
                   </tr>	 
                   <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_ANTISPAMQUESTION'); ?>:</td>
                        <td><?php fpcm\model\view\helper::textInput('comments_antispam_question', '', $globalConfig['comments_antispam_question']); ?></td>		
                   </tr>			 
                   <tr>			
                        <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_ANTISPAMANSWER'); ?>:</td>
                        <td><?php fpcm\model\view\helper::textInput('comments_antispam_answer', '', $globalConfig['comments_antispam_answer']); ?></td>
                   </tr>	
               </table>                    
            </div>

            <?php if ($showTwitter) : ?>    
            <div id="tabs-options-twitter">
                <?php include_once __DIR__.'/twitter.php'; ?>
            </div> 
            <?php endif; ?>                

            <div id="tabs-options-check"></div>
        </div>

        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
            <table>
                <tr>
                    <td><?php fpcm\model\view\helper::saveButton('configSave', 'fpcm-loader'); ?></td>
                </tr>
            </table>
        </div>

        <?php \fpcm\model\view\helper::pageTokenField(); ?>
        
    </form> 
</div>