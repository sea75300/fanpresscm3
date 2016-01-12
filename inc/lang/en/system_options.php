<?php
    /**
     * System options language file
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2014, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array(
        'SYSTEM_HL_OPTIONS_GENERAL'                 => 'General',
        'SYSTEM_HL_OPTIONS_EDITOR'                  => 'Editor and file manager',
        'SYSTEM_HL_OPTIONS_ARTICLES'                => 'Articles',
        'SYSTEM_HL_OPTIONS_COMMENTS'                => 'Comments',
        'SYSTEM_HL_OPTIONS_SECURITY'                => 'Security and Maintenance',
        'SYSTEM_HL_OPTIONS_TWITTER'                 => 'Twitter connection',
        'SYSTEM_HL_OPTIONS_SYSCHECK'                => 'System check and updates',
        
        'SYSTEM_OPTIONS_MAINTENANCE'                => 'Maintenance mode enabled',
        'SYSTEM_OPTIONS_CRONJOBS'                   => 'Asynchronous cronjob execution disabled',
        'SYSTEM_OPTIONS_URL'                        => 'Article url base',
        'SYSTEM_OPTIONS_LANG'                       => 'Language',   
        'SYSTEM_OPTIONS_DATETIMEMASK'               => 'Date-Time mask',
        'SYSTEM_OPTIONS_DATETIMEMASK_HELP'          => 'Syntax equivalent to PHP function date()',
        'SYSTEM_OPTIONS_TIMEZONE'                   => 'Timezone',
        'SYSTEM_OPTIONS_SESSIONLENGHT'              => 'ACP session length',
        'SYSTEM_OPTIONS_SESSIONLENGHT_1800'         => '0,5 hours',
        'SYSTEM_OPTIONS_SESSIONLENGHT_3600'         => '1 hour',
        'SYSTEM_OPTIONS_SESSIONLENGHT_5400'         => '1,5 hours',
        'SYSTEM_OPTIONS_SESSIONLENGHT_7200'         => '2 hours',
        'SYSTEM_OPTIONS_SESSIONLENGHT_9000'         => '2,5 hours',
        'SYSTEM_OPTIONS_SESSIONLENGHT_10800'        => '3 hours',
        'SYSTEM_OPTIONS_SESSIONLENGHT_14400'        => '4 hours',
        'SYSTEM_OPTIONS_SESSIONLENGHT_18000'        => '5 hours', 
        
        'SYSTEM_OPTIONS_CACHETIMEOUT'               => 'Interval for cache timeout',
        'SYSTEM_OPTIONS_CACHETIMEOUT_3600'          => '1 hour',
        'SYSTEM_OPTIONS_CACHETIMEOUT_21600'         => '6 hours',
        'SYSTEM_OPTIONS_CACHETIMEOUT_43200'         => '12 hours',
        'SYSTEM_OPTIONS_CACHETIMEOUT_64800'         => '18 hours',
        'SYSTEM_OPTIONS_CACHETIMEOUT_86400'         => '1 day',
        'SYSTEM_OPTIONS_CACHETIMEOUT_172800'        => '2 days',
        'SYSTEM_OPTIONS_CACHETIMEOUT_259200'        => '3 days',
        'SYSTEM_OPTIONS_CACHETIMEOUT_345600'        => '4 days',
        'SYSTEM_OPTIONS_CACHETIMEOUT_432000'        => '5 days',
        
        'SYSTEM_OPTIONS_USEMODE'                    => 'Usemode',
        'SYSTEM_OPTIONS_USEMODE_IFRAME'             => 'iframe',
        'SYSTEM_OPTIONS_USEMODE_PHPINCLUDE'         => 'phpinclude',
        'SYSTEM_OPTIONS_INCLUDEJQUERY'              => 'Include jQuery library',
        'SYSTEM_OPTIONS_INCLUDEJQUERY_YES'          => 'Select &quot;yes&quot;, if jQuery is not loaded in your site yet.',
        'SYSTEM_OPTIONS_STYLESHEET'                 => 'CSS style file path',   
        'SYSTEM_OPTIONS_NEWSSHOWLIMIT'              => 'Articles per page',  
        'SYSTEM_OPTIONS_ACTIVENEWSTEMPLATE'         => 'Article list template',
        'SYSTEM_OPTIONS_ACTIVENEWSTEMPLATESINGLE'   => 'Single article template',
        'SYSTEM_OPTIONS_LATESTNEWSTEMPLATE'         => '&quot;Lastest News&quot; Template',
        'SYSTEM_OPTIONS_NEWSSHOWSHARELINKS'         => 'Show share buttons',
        'SYSTEM_OPTIONS_NEWSSHOWMAXIMGSIZE'         => 'Create thumbnail from',
        'SYSTEM_OPTIONS_NEWSSHOWIMGTHUMBSIZE'       => 'Thumbnail size', 
        'SYSTEM_OPTIONS_NEWSSHOWMAXIMGSIZEPIXELS'   => 'Pixel',
        'SYSTEM_OPTIONS_NEWS_EDITOR'                => 'Select editor',
        'SYSTEM_OPTIONS_NEWS_EDITOR_STD'            => 'WYSIWYG view',
        'SYSTEM_OPTIONS_NEWS_EDITOR_CLASSIC'        => 'HTML view',
        'SYSTEM_OPTIONS_NEWS_EDITOR_CSS'            => 'CSS classes in editor',
        'SYSTEM_OPTIONS_NEWS_EDITOR_FONTSIZE'       => 'Default editor font size',
        'SYSTEM_OPTIONS_NEWS_NEWUPLOADER'           => 'Use jQuery uploader',
        'SYSTEM_OPTIONS_ARCHIVE_LINK'               => 'Show archive link',
        'SYSTEM_OPTIONS_ACTIVECOMMENTTEMPLATE'      => 'Comment template',
        'SYSTEM_OPTIONS_COMMENTFORMTEMPLATE'        => 'Comment form template',
        'SYSTEM_OPTIONS_ANTISPAMQUESTION'           => 'Spam captcha question',
        'SYSTEM_OPTIONS_ANTISPAMANSWER'             => 'Spam captcha answer',
        'SYSTEM_OPTIONS_ACPARTICLES_LIMIT'          => 'ACP article list limit',
        'SYSTEM_OPTIONS_LOGIN_MAXATTEMPTS'          => 'Login auto-lock',
        
        'SYSTEM_OPTIONS_FLOODPROTECTION'            => 'Flood protection between two comments',
        'SYSTEM_OPTIONS_FLOODPROTECTION_0'          => 'none',
        'SYSTEM_OPTIONS_FLOODPROTECTION_10'         => '10 seconds',
        'SYSTEM_OPTIONS_FLOODPROTECTION_20'         => '20 seconds',
        'SYSTEM_OPTIONS_FLOODPROTECTION_30'         => '30 seconds',
        'SYSTEM_OPTIONS_FLOODPROTECTION_60'         => '60 seconds',
        'SYSTEM_OPTIONS_FLOODPROTECTION_90'         => '90 seconds',
        'SYSTEM_OPTIONS_FLOODPROTECTION_120'        => '2 minutes',
        'SYSTEM_OPTIONS_FLOODPROTECTION_300'        => '5 minutes',
        'SYSTEM_OPTIONS_FLOODPROTECTION_600'        => '10 minutes',
        'SYSTEM_OPTIONS_FLOODPROTECTION_900'        => '15 minutes',
        'SYSTEM_OPTIONS_FLOODPROTECTION_1800'       => '30 minutes',        
        
        'SYSTEM_OPTIONS_COMMENTEMAIL'               => 'Email address required',
        'SYSTEM_OPTIONS_COMMENT_APPROVE'            => 'Comment Approval required',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY'             => 'Send comment notification to',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY_GLOBAL'      => 'global email address',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY_AUTHOR'      => 'author email address',
        'SYSTEM_OPTIONS_COMMENT_NOTIFY_ALL'         => 'global and author email address',
        'SYSTEM_OPTIONS_COMMENT_ENABLED_GLOBAL'     => 'Comments are enabled',
        'SYSTEM_OPTIONS_COMMENT_MARKSPAM_PASTCHECK' => 'Automatic "Mark as Spam"',
        'SYSTEM_OPTIONS_REVISIONS_ENABLED'          => 'Revisions enabled',
        'SYSTEM_OPTIONS_NEWS_SORTING'               => 'Sort articles by',
        'SYSTEM_OPTIONS_NEWS_BYWRITTENTIME'         => 'Creation date',
        'SYSTEM_OPTIONS_NEWS_BYEDITEDTIME'          => 'Last change',
        'SYSTEM_OPTIONS_NEWS_BYINTERNALID'          => 'Internal ID',
        'SYSTEM_OPTIONS_NEWS_BYAUTHOR'              => 'Author',
        'SYSTEM_OPTIONS_NEWS_ORDERASC'              => 'ascending',
        'SYSTEM_OPTIONS_NEWS_ORDERDESC'             => 'descending',
        'SYSTEM_OPTIONS_NEWS_ENABLETRASH'           => 'Enabled article trash',
        'SYSTEM_OPTIONS_NEWS_ENABLEFEED'            => 'RSS feed is enabled',
        
        'SYSTEM_OPTIONS_EXTENDED_DEVUPDATES'        => 'Include developement relaeses in update check',
        
        'SYSTEM_OPTIONS_TWITTER_CONNECTION'         => 'Twitter connection',
        'SYSTEM_OPTIONS_TWITTER_CONNECT'            => 'Request API key and/or token',
        'SYSTEM_OPTIONS_TWITTER_DISCONNECT'         => 'Disconnect',
        'SYSTEM_OPTIONS_TWITTER_EVENTS'             => 'Create tweet on',
        'SYSTEM_OPTIONS_TWITTER_CONSUMER_KEY'       => 'Consumer Key (API Key)',
        'SYSTEM_OPTIONS_TWITTER_CONSUMER_SECRET'    => 'Consumer Secret (API Secret)',
        'SYSTEM_OPTIONS_TWITTER_USER_TOKEN'         => 'Access Token',
        'SYSTEM_OPTIONS_TWITTER_USER_SECRET'        => 'Access Token Secret',        
        'SYSTEM_OPTIONS_TWITTER_ACTIVE'             => 'Twitter connection is anbled! Connected with user "{{screenname}}".',
        'SYSTEM_OPTIONS_TWITTER_EVENTCREATE'        => 'On create',
        'SYSTEM_OPTIONS_TWITTER_EVENTUPDATE'        => 'On update',
        
        'SYSTEM_OPTIONS_SYSCHECK_CURRENT'           => 'Current value',
        'SYSTEM_OPTIONS_SYSCHECK_RECOMMEND'         => 'Recommended value',
        'SYSTEM_OPTIONS_SYSCHECK_STATUS'            => 'value OK?',
        'SYSTEM_OPTIONS_SYSCHECK_FPCMVERSION'       => 'FanPress CM version',
        'SYSTEM_OPTIONS_SYSCHECK_PHPVERSION'        => 'PHP version',
        'SYSTEM_OPTIONS_SYSCHECK_PHPMEMLIMIT'       => 'PHP memory limit',
        'SYSTEM_OPTIONS_SYSCHECK_PHPMAXEXECTIME'    => 'PHP max execution time'
    );