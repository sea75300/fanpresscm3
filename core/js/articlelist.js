/**
 * FanPress CM Article list Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.articlelist = {

    init: function() {
        
        fpcm.ui.checkboxradio('.fpcm-ui-massedit-categories .fpcm-ui-input-checkbox', {
            icon: false
        });
        
        fpcm.articlelist.initArticleSearch();
        fpcm.articlelist.clearArticleCache();
    },
    
    assignActions: function() {

        var articleActions = {
            newtweet: 'newtweet',
            massedit: 'massedit'
        }
        
        var action = jQuery('#actionsaction').val();

        if (action == articleActions.massedit) {
            fpcm.articlelist.articleActionsMassEdit();
            fpcm.ui.removeLoaderClass(this);
            return -1;
        }

        if (action == articleActions.newtweet) {
            fpcm.articlelist.articleActionsTweet();
            fpcm.ui.removeLoaderClass(this);
            return -1;
        }
        
        return true;
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

            var size = fpcm.ui.getDialogSizes();

            fpcm.ui.dialog({
                id      : 'articles-search',
                dlWidth: size.width,
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
        fpcm.ui.confirmDialog({
            clickYes: function() {
                var articleIds = fpcm.ui.getCheckboxCheckedValues('.fpcm-list-selectbox');
                if (articleIds.length == 0) {
                    fpcm.ui.showLoader(false);
                    return false;
                }

                fpcm.articlelist.execNewTweet(articleIds);
                jQuery(this).dialog('close');
            },
            clickNo: function() {
                jQuery(this).dialog('close');
            }
        });

    },
    
    articleActionsMassEdit: function() {

        fpcm.ui.selectmenu('.fpcm-ui-input-select-massedit', {
            width: '100%',
            appendTo: '#fpcm-dialog-articles-massedit'
        });

        fpcm.ui.datepicker('.fpcm-full-width-date', {
            minDate: fpcmArticlSearchMinDate
        });

        var size = fpcm.ui.getDialogSizes();

        fpcm.ui.dialog({
            id       : 'articles-massedit',
            dlWidth  : size.width,
            resizable: true,
            title    : fpcm.ui.translate('masseditHeadline'),
            dlButtons  : [
                {
                    text: fpcm.ui.translate('masseditSave'),
                    icon: "ui-icon-check",
                    click: function() {

                        fpcm.ui.confirmDialog({
                            clickYes: function() {

                                var articleIds = fpcm.ui.getCheckboxCheckedValues('.fpcm-list-selectbox');
                                if (articleIds.length == 0) {
                                    fpcm.ui.showLoader(false);
                                    return false;
                                }

                                var mefields = jQuery('.fpcm-ui-input-massedit');
                                var params = {
                                    fields: {},
                                    ids   : fpcm.ajax.toJSON(articleIds)
                                };

                                jQuery.each(mefields, function (key, obj) {
                                    var objVal  = jQuery(obj).val();
                                    var objName = jQuery(obj).attr('name'); 
                                    params.fields[objName] = objVal;
                                });

                                params.fields.categories = fpcm.ui.getCheckboxCheckedValues('.fpcm-ui-input-massedit-categories');
                                fpcm.articlelist.execMassEdit(params);

                                jQuery(this).dialog('close');
                                
                            },
                           
                            clickNo: function() {
                                jQuery(this).dialog('close');
                            }
                        });
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
            },
            dlOnClose: function( event, ui ) {
                fpcm.ui.showLoader(false);
            }
        });

        return false;
    },
    
    execNewTweet: function(articleIds) {

        fpcm.ajax.post('articles/tweet', {
            data    : {
                ids : fpcm.ajax.toJSON(articleIds)
            },
            async   : false,
            execDone: function(result) {

                jQuery('#actionsaction').prop('selectedIndex',0);
                jQuery('#actionsaction').selectmenu('refresh');

                fpcm.ui.showLoader(false);
                result = fpcm.ajax.fromJSON(fpcm.ajax.getResult('articles/tweet'));
                if (result.notice != 0) {
                    fpcmJs.addAjaxMassage('notice', result.notice);
                }

                if (result.error != 0) {
                    fpcmJs.addAjaxMassage('error', result.error);
                }

            }
        });

    },

    execMassEdit: function(params) {
        fpcm.ajax.post('articles/massedit', {
            data     : params,
            execDone : function () {

                var res = fpcm.ajax.fromJSON(fpcm.ajax.getResult('articles/massedit'));

                if (res.code == 1) {
                    fpcmJs.relocate(window.location.href);
                    return true;
                }

                fpcm.ui.addMessage({
                    type : 'error',
                    id   : 'fpcm-articles-massedit',
                    icon : 'exclamation-triangle',
                    txt  : fpcm.ui.translate('masseditSaveFailed')
                }, true);

            }
        });
    },

    clearArticleCache: function() {
        
        jQuery('.fpcm-article-cache-clear').click(function() {
            
            var obj = jQuery(this);
            
            var cache = obj.attr('data-cache') ? obj.attr('data-cache') : '';
            var objid = obj.attr('data-objid') ? obj.attr('data-objid') : 0;

            fpcmJs.clearCache({
                cache: cache,
                objid: objid
            });
            
            return false;
        });

    }
};