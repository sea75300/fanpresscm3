/**
 * FanPress CM javascript comment editor functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmEditor = function () {
    
    this.initTinyMceComment = function() {
        tinymce.init({
            selector              : "textarea",
            skin                  : "fpcm",
            theme                 : "modern",
            language              : fpcmTinyMceLang,
            plugins               : fpcmTinyMcePlugins,
            toolbar1              : fpcmTinyMceToolbar,
            menubar               : false,
            relative_urls         : false,
            image_advtab          : true,
            resize                : true,
            convert_urls          : true,
            browser_spellcheck    : true,
            autoresize_min_height : '250',
            setup : function(ed) { 
                ed.on('init', function() {
                    this.getBody().style.fontSize = '14px';
                    jQuery(this.iframeElement).removeAttr('title');
                });
            }                
        });    
    }
};

jQuery(document).ready(function() {    
    fpcmEditor = new fpcmEditor();   
});