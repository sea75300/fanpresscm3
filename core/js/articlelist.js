/**
 * FanPress CM UI Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2016, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.articlelist = {

    load: function() {

        jQuery('.fpcm-tabs-articles-headers a').click(function () {

            jQuery('#fpcmarticlesopensearch').show();
            jQuery('#fpcmarticleslistaddnew').show();
            jQuery('#btnClearTrash').hide();

            var tabId = jQuery(this).attr('data-tabid');

            if (tabId > 1) {
                jQuery('#fpcmarticlesopensearch').hide();
            }
            
            if (tabId == 3) {
                jQuery('#fpcmarticleslistaddnew').hide();
                jQuery('#btnClearTrash').show();
            }

            fpcmJs.assignButtons();
        });

    },
    
    initArticleSearch: function() {
        jQuery('#fpcmarticlesopensearch').click(function () {

            fpcm.ui.selectmenu('.fpcm-ui-input-select-articlesearch', {
                width: '100%',
                appendTo: '#fpcm-dialog-articles-search'
            });

            fpcm.ui.datepicker('.fpcm-full-width-date', {
                minDate: fpcmArticlSearchMinDate
            });

            fpcm.ui.dialog({
                id      : 'articles-search',
                dlWidth: 700,
                dlHeight: 375,
                resizable: true,
                title    : fpcm.ui.translate('searchHeadline'),
                dlButtons  : [
                    {
                        text: fpcm.ui.translate('searchStart'),
                        icon: "ui-icon-check",
                        click: function() {                            
                            var sfields = jQuery('.fpcm-articles-search-input');
                            var sParams = {
                                mode: fpcmArticleSearchMode,
                                filter: {}
                            };
                            
                            jQuery.each(sfields, function( key, obj ) {
                                var objVal  = jQuery(obj).val();
                                var objName = jQuery(obj).attr('name');                                
                                sParams.filter[objName] = objVal;
                            });

                            fpcmJs.startSearch(sParams);
                            jQuery(this).dialog('close');
                        }
                    },                    
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick" ,                        
                        click: function() {
                            jQuery(this).dialog('close');
                        }
                    }                            
                ],
                dlOnOpen: function( event, ui ) {
                    jQuery('#text').focus();
                }
            });

            return false;
        });

    },
    
    articleActionsTweet: function() {

        var articleIds = [];
        jQuery('.fpcm-list-selectbox:checked').map(function (idx, item) {
            articleIds.push(jQuery(item).val());
        });

        if (articleIds.length == 0) {
            fpcmJs.showLoader(false);
            return false;
        }

        fpcmAjax.action     = 'articles/tweet';
        fpcmAjax.data       = {ids: fpcmAjax.toJSON(articleIds)};
        fpcmAjax.execDone   = "fpcm.articlelist.articleActionsTweetCallback(fpcmAjax.result);";
        fpcmAjax.async      = false;
        fpcmAjax.post();
        fpcmAjax.reset();  

    },

    articleActionsTweetCallback: function(result) {

        jQuery('#actionsaction').prop('selectedIndex',0);
        jQuery('#actionsaction').selectmenu('refresh');

        self.showLoader(false);
        
        result = fpcmAjax.fromJSON(result);
        if (result.notice != 0) {
            fpcmJs.addAjaxMassage('notice', result.notice);
        }

        if (result.error != 0) {
            fpcmJs.addAjaxMassage('error', result.error);
        }

    }
    
}

jQuery(document).ready(function() {

    fpcm.articlelist.load();
    fpcm.articlelist.initArticleSearch();

});