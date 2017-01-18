<?php
    /**
     * Messages language file
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array(
        'LOGIN_FAILED'                  => 'Your username or password was wrong. Please try again.',
        'LOGIN_FAILED_DISABLED'         => 'The entered username has been disabled.',
        'LOGIN_REQUIRED'                => 'Please log in to access this page!',
        'LOGIN_PASSWORD_RESET'          => 'Password reset has been successful. Please check your e-mail for further information.',
        'LOGIN_PASSWORD_RESET_FAILED'   => 'An error occurred during password reset!',
        'LOGIN_ATTEMPTS_MAX'            => 'Your login has been locked for {{lockedtime}} minutes on {{lockeddate}} because you entered your login data {{logincount}} times.',
        'PERMISSIONS_REQUIRED'          => 'You have no permissions to access this page!',
        'VIEW_NOT_FOUND'                => 'View with name {{viewname}} not found!',
        'AJAX_REQUEST_ERROR'            => 'An error occurred during the last action! Check the JavaScript log of your browser for further information.',
        'AJAX_REPONSE_ERROR'            => 'The server response was invalid! Check the JavaScript log of your browser and PHP log for further information.',
        'ERROR_IP_LOCKED'               => 'You IP address has been locked for this action. Contact the site administration for further information.',
        'CACHE_CLEARED_OK'              => 'Cache has been clear!',
        'CONFIRM_MESSAGE'               => 'Do you want to proceed with this action?',
        'SELECT_ITEMS_MSG'              => 'Please select an action or elements!',
        'SEARCH_WAITMSG'                => 'Please wait at least 10 second before you start a new search.',
        'RSSFEED_DISABLED'              => 'The RSS feed is disabled. Please contact the site owner for further information.',
        'MAINTENANCE_MODE_ENABLED'      => 'Maintenance mode is currently enabled. This function or service is not available at the moment.',
        'CSRF_INVALID'                  => 'The CSRF token is invalid. The action was not executed!',
        'SESSION_TIMEOUT'               => 'Your current session has reached it maximum life time. Do you want to proceed to login screen? (select "no" to stay on this site)',
        
        'SAVE_SUCCESS_ADDUSER'          => 'The user has been saved!',
        'SAVE_SUCCESS_USER_DISABLE'     => 'The user has been disabled!',
        'SAVE_SUCCESS_USER_ENABLE'      => 'The user has been enabled!',
        'SAVE_SUCCESS_ADDROLL'          => 'The user roll has been saved!',
        'SAVE_SUCCESS_ADDCATEGORY'      => 'The category has been saved!',
        'SAVE_SUCCESS_EDITUSER'         => 'Changed to the user has been saved!',
        'SAVE_SUCCESS_EDITUSER_PROFILE' => 'Changed on your profile has been saved!',
        'SAVE_SUCCESS_RESETPROFILE'     => 'The user settings have been reset to default!',
        'SAVE_SUCCESS_EDITROLL'         => 'Changed to the user roll has been saved!',
        'SAVE_SUCCESS_EDITCATEGORY'     => 'Changed to the category has been saved!',
        'SAVE_SUCCESS_OPTIONS'          => 'Configuration changes has been saved!',
        'SAVE_SUCCESS_PERMISSIONS'      => 'Permission changes has been saved!',
        'SAVE_SUCCESS_SMILEY'           => 'The smiley has been saved!',
        'SAVE_SUCCESS_IPADDRESS'        => 'The ip address has been saved!',
        'SAVE_SUCCESS_WORDBAN'          => 'The censored text has been saved!',
        'SAVE_SUCCESS_UPLOADPHP'        => 'Success uploading files!<br>{{filenames}}',
        'SAVE_SUCCESS_TEMPLATE'         => 'Success saving templates!<br>{{filenames}}',
        'SAVE_SUCCESS_ARTICLE'          => 'The article has been saved!',
        'SAVE_SUCCESS_ARTICLE_APPROVAL' => 'The article has been saved but has to be approved!',
        'SAVE_SUCCESS_ARTICLEPINN'      => 'The article(s) were un/pinned!',
        'SAVE_SUCCESS_ARTICLEAPPROVAL'  => 'The article approval has been changed!',
        'SAVE_SUCCESS_ARTICLEARCHIVE'   => 'The article(s) were archived!',
        'SAVE_SUCCESS_ARTICLERESTORE'   => 'The article(s) were restored!',
        'SAVE_SUCCESS_ARTICLENEWTWEET'  => 'New tweets were created!<br>{{titles}}',
        'SAVE_SUCCESS_ARTICLECOMMENTS'  => 'Comments for articles were en/disabled!',
        'SAVE_SUCCESS_ARTICLEREVRESTORE'=> 'Article revision has been restored!',
        'SAVE_SUCCESS_COMMENT'          => 'The comments has been saved!',
        'SAVE_SUCCESS_APPROVEMENT'      => 'The approval status for comments were changed!',
        'SAVE_SUCCESS_PRIVATE'          => 'The private status for comments were changed!',
        'SAVE_SUCCESS_SPAMMER'          => 'The spam status for comments were changed!',
        'SAVE_SUCCESS_UPLOADMODULE'     => 'The module package file has been uploaded!',
        'SAVE_SUCCESS_UPLOADTPLFILE'    => 'The template file has been uploaded!',
        'SAVE_SUCCESS_APPROVAL_SAVE'    => 'To approve this article, click the save button!',
        
        'SAVE_FAILED_USER'              => 'Unable to save the user!',
        'SAVE_FAILED_USER_PROFILE'      => 'Unable to save the user profile settings!',
        'SAVE_FAILED_USER_EXISTS'       => 'The give username does already exists!',
        'SAVE_FAILED_USER_EMAIL'        => 'A valid email address is required!',
        'SAVE_FAILED_USER_PROFILEEMAIL' => 'A have to insert a valid email address!',
        'SAVE_FAILED_USER_DISABLE'      => 'Unable to disable the user!',
        'SAVE_FAILED_USER_DISABLE_OWN'  => 'You cannot disable your own account!',
        'SAVE_FAILED_USER_DISABLE_LAST' => 'Unable to disable the last user!',
        'SAVE_FAILED_USER_ENABLE'       => 'Unable to enable the user!',
        'SAVE_FAILED_ROLL'              => 'Unable to save the user roll!',
        'SAVE_FAILED_CATEGORY'          => 'Unable to save the category!',                
        'SAVE_FAILED_PASSWORD_SECURITY' => 'Your password requires at least six digits including upper and lower case letters and numbers!',
        'SAVE_FAILED_PASSWORD_MATCH'    => 'The given passwords do not match',
        'SAVE_FAILED_USER_SECURITY'     => 'The given username is highly dangerous and cannot be used!',
        'SAVE_FAILED_OPTIONS'           => 'Unable to save configuration changes!',
        'SAVE_FAILED_PERMISSIONS'       => 'Unable to save permissions for user roll with id {{rollid}}!',
        'SAVE_FAILED_SMILEY'            => 'Unable to save the smiley!',
        'SAVE_FAILED_IPADDRESS'         => 'Unable to save the IP address!',
        'SAVE_FAILED_WORDBAN'           => 'Unable to create censored text!',
        'SAVE_FAILED_UPLOADPHP'         => 'An error occurred while uploading files!<br>{{filenames}}',
        'SAVE_FAILED_TEMPLATE'          => 'An error occurred while saving templates!<br>{{filenames}}',
        'SAVE_FAILED_TEMPLATE_CF_URLMISSING' => 'Unable to save comment form template, because {{submitUrl}} replacement is missing!',
        'SAVE_FAILED_ARTICLE'           => 'Unable to save the article!',
        'SAVE_FAILED_ARTICLE_EMPTY'     => 'Please insert an article title and text before save it!',
        'SAVE_FAILED_ARTICLEPINN'       => 'Unable to un/pin the article!',
        'SAVE_FAILED_ARTICLEARCHIVE'    => 'Unable to archive the article!',
        'SAVE_FAILED_ARTICLERESTORE'    => 'Unable to restore the article!',
        'SAVE_FAILED_ARTICLENEWTWEET'   => 'Unable to create tweets for articles!<br>{{titles}}',
        'SAVE_FAILED_ARTICLECOMMENTS'   => 'Unable to en/disable comments!',
        'SAVE_FAILED_ARTICLEREVRESTORE' => 'Unable to restore article revision!',
        'SAVE_FAILED_ARTICLEAPPROVAL'   => 'Unable to change article approvals!',
        'SAVE_FAILED_COMMENT'           => 'Unable to save comment!',
        'SAVE_FAILED_APPROVEMENT'       => 'Unable to change comment approval status!',
        'SAVE_FAILED_PRIVATE'           => 'Unable to change comment private status!',
        'SAVE_FAILED_SPAMMER'           => 'Unable to change comment spam status!',
        'SAVE_FAILED_UPLOADMODULE'      => 'An error occurred while uploading module package file!',
        'SAVE_FAILED_UPLOADTPLFILE'     => 'An error occurred while uploading the template file!',
        
        'DELETE_SUCCESS_USERS'          => 'The users were deleted!',
        'DELETE_SUCCESS_ROLL'           => 'The user rolls were deleted!',
        'DELETE_SUCCESS_CATEGORIES'     => 'The categories were deleted!',
        'DELETE_SUCCESS_FILES'          => 'The files were deleted!<br>{{filenames}}',
        'DELETE_SUCCESS_NEWTHUMBS'      => 'New thumbnails were created!<br>{{filenames}}',
        'DELETE_SUCCESS_RENAME'         => 'Renaming file {{filename1}} to {{filename2}} has been successful!',
        'DELETE_SUCCESS_SMILEYS'        => 'The smileys were deleted!',
        'DELETE_SUCCESS_IPADDRESS'      => 'The IP address were deleted!',
        'DELETE_SUCCESS_WORDBAN'        => 'The censored texts were deleted!',
        'DELETE_SUCCESS_ARTICLE'        => 'The articles were deleted!',
        'DELETE_SUCCESS_REVISIONS'      => 'The revisions were deleted!',
        'DELETE_SUCCESS_TRASH'          => 'Trash has been cleared successfully!',
        'DELETE_SUCCESS_COMMENTS'       => 'The comments were deleted!',
        
        'DELETE_FAILED_USERS'           => 'Unable to delete the users!',
        'DELETE_FAILED_USERS_OWN'       => 'You cannot delete your own user account!',
        'DELETE_FAILED_USERS_LAST'      => 'You cannot delete the last user account!',
        'DELETE_FAILED_ROLL'            => 'Unable to delete users rolls!',
        'DELETE_FAILED_CATEGORIES'      => 'Unable to delete categories!',
        'DELETE_FAILED_NEWTHUMBS'       => 'Unable to create new image thumbnails!<br>{{filenames}}',
        'DELETE_FAILED_FILES'           => 'Unable to delete selected files!<br>{{filenames}}',
        'DELETE_FAILED_RENAME'          => 'Unable to rename {{filename1}} to {{filename2}}!',
        'DELETE_FAILED_SMILEYS'         => 'Unable to delete selected smileys!',
        'DELETE_FAILED_IPADDRESS'       => 'Unable to delete IP-address!',
        'DELETE_FAILED_WORDBAN'         => 'Unable to delete censored texts!',
        'DELETE_FAILED_ARTICLE'         => 'Unable to delete selected articles!',
        'DELETE_FAILED_REVISIONS'       => 'Unable to delete article revisions!',
        'DELETE_FAILED_TRASH'           => 'An error occurred clearing trash!',
        'DELETE_FAILED_COMMENTS'        => 'Unable to delete selected comments!',
        
        'LOAD_FAILED_ARTICLE'           => 'The requested article was not found.',
        'LOAD_FAILED_COMMENT'           => 'The requested comment was not found.',
        'LOAD_FAILED_USER'              => 'The requested user was not found.',
        'LOAD_FAILED_ROLL'              => 'The requested user roll was not found.',
        'LOAD_FAILED_CATEGORY'          => 'The requested category was not found.',
        'LOAD_FAILED_WORDBAN'           => 'The requested censored text was not found.',
        
        'UPDATE_VERSIONCHECK_NEW'       => 'FanPress CM version <i>{{version}}</i> is available! <a class="fpcm-ui-button fpcm-start-update fpcm-ui-actions-genreal fpcm-loader" href="{{versionlink}}">Click here</a> to start update process.',
        'UPDATE_VERSIONCHECK_CURRENT'   => 'Your version of FanPress CM is <strong>up to date</strong>!',
        'UPDATE_VERSIONCHECK_NOTES'     => 'Release notes and further information for system and module updates can be found in "Recent FanPress CM news".',
        'UPDATE_VERSIONCECK_FILEDB_ERR' => 'Mismatch of version information in file system and database. <a class="fpcm-ui-button fpcm-ui-actions-genreal fpcm-loader" href="{{versionlink}}">Click here</a> to execute updater.',
        'UPDATE_NOTAUTOCHECK'           => 'Automatic update check failed! <a class="fpcm-ui-button fpcm-updatecheck-manual" href="#">Check manually</a>',
        'UPDATE_WRITEERROR'             => 'The <strong>version.php</strong> file in FanPress CM root folder is not writable. This may affect other files of your installation too.<br>'.
                                           'This can be caused by wrong file permissions. Please check/change permissions of - in case - all files until this message disappears after page reload.<br>'.
                                           'In case you\'re unable to do so, contact you host for further help.',
        
        'UPDATE_MODULECHECK_NEW'         => 'Module updates are available. <a class="fpcm-ui-button fpcm-loader" href="?module=modules/list">Show updates</a>',
        'UPDATE_MODULECHECK_CURRENT'     => 'All installed modules are <strong>up to date</strong>!',
        'UPDATE_MODULECHECK_FAILED'      => 'Update check for installed modules failed!',
        
        'PACKAGES_FAILED_REMOTEFILE'     => 'Error while connecting to package server!',
        'PACKAGES_FAILED_LOCALFILE'      => 'Unable to create local package file!',
        'PACKAGES_FAILED_LOCALWRITE'     => 'An error occurred while writing into local package file!',
        'PACKAGES_FAILED_LOCALEXISTS'    => 'Local package file was not found!',
        'PACKAGES_FAILED_HASHCHECK'      => 'Integrity check of package file failed. Hash values do not match!',
        'PACKAGES_FAILED_ZIPOPEN'        => 'Unable to open package file!',
        'PACKAGES_FAILED_ZIPEXTRACT'     => 'Unable to extract package file!',
        'PACKAGES_FAILED_FILESCOPY'      => 'Unable to copy package file content to its destination folder!',
        'PACKAGES_FAILED_GENERAL'        => 'An general error occurred while processing the package file!',
        'PACKAGES_FAILED_ADDITIONAL'     => 'An error occurred while processing additional package steps!',

        'PACKAGES_SUCCESS_DOWNLOAD'     => '<span class="fa fa-cloud-download fpcm-ui-booltext-yes fa-fw fa-lg"></span> Download of package file has been successful.',
        'PACKAGES_SUCCESS_EXTRACT'      => '<span class="fa fa-file-archive-o fpcm-ui-booltext-yes fa-fw fa-lg"></span> Extracting package file has been successful.',
        'PACKAGES_SUCCESS_COPY'         => '<span class="fa fa-random fpcm-ui-booltext-yes fa-fw fa-lg"></span> Copy of package file content has been successful.',
        'PACKAGES_SUCCESS_ADDITIONAL'   => '<span class="fa fa-refresh fpcm-ui-booltext-yes fa-fw fa-lg"></span> Execution of additional package steps has been successful!',
        'PACKAGES_SUCCESS_LOGDONE'      => '<span class="fa fa-file-text-o fpcm-ui-booltext-yes fa-fw fa-lg"></span> Update of package manager log successfully!',
        
        'PACKAGES_RUN_DOWNLOAD'         => 'Download of package {{pkglink}}...',
        'PACKAGES_RUN_EXTRACT'          => 'Extracting package...',
        'PACKAGES_RUN_COPY'             => 'Copy package content to destination folder...',
        'PACKAGES_RUN_ADDITIONAL'       => 'Processing additional package steps...',
        
        'UPDATES_SUCCESS'               => 'The update of FanPress CM has been successful!',
        'UPDATES_FAILED'                => '<span class="fa fa-minus-square fpcm-ui-booltext-noyes fa-fw fa-lg"></span> The update of FanPress CM was NOT successful!',
                
        'LOGS_CLEARED_LOG_OK'           => 'Selected system log has been cleared!',
        'LOGS_CLEARED_LOG_FAILED'       => 'Unable to clear selected system log!',
        
        'MODULES_SUCCESS_ENABLE'        => 'Selected modules were enabled.',
        'MODULES_SUCCESS_DISABLE'       => 'Selected modules were disabled.',
        'MODULES_SUCCESS_INSTALL'       => '<span class="fa fa-check-square fpcm-ui-booltext-yes fa-fw fa-lg"></span> Selected modules were installed.',
        'MODULES_SUCCESS_UNINSTALL'     => 'Selected modules were removed successfully.',
        'MODULES_SUCCESS_UPDATE'        => '<span class="fa fa-check-square fpcm-ui-booltext-yes fa-fw fa-lg"></span> The module has been updated successfully.',
        
        'MODULES_FAILED_ENABLE'         => 'Unable to enable selected modules.',
        'MODULES_FAILED_DISABLE'        => 'Unable to disable selected modules.',
        'MODULES_FAILED_INSTALL'        => '<span class="fa fa-minus-square fpcm-ui-booltext-noyes fa-fw fa-lg"></span> Unable to install selected modules.',
        'MODULES_FAILED_UNINSTALL'      => 'Unable to uninstall selected modules.',
        'MODULES_FAILED_UPDATE'         => '<span class="fa fa-minus-square fpcm-ui-booltext-noyes fa-fw fa-lg"></span> Unable to update module.',
        'MODULES_FAILED_TEMPKEYS'       => 'No selected modules found for installation.',
        'MODULES_FAILED_DEPENCIES'      => 'Unfulfilled dependencies for module!',
        'MODULES_FAILED_LANGUAGE'       => 'Language pack for current system language is missing!',
        
        'PUBLIC_FAILED_CAPTCHA'         => 'Your captcha answer was wrong!',
        'PUBLIC_FAILED_NAME'            => 'Please insert your name!',
        'PUBLIC_FAILED_EMAIL'           => 'Please insert your email-address!',
        'PUBLIC_FAILED_FLOOD'           => 'Please wait at least {{seconds}} seconds before you create another comment!',
        'PUBLIC_ARTICLE_PINNED'         => 'This article is pinned and therefore is displayed before any other article.'
    );

?>