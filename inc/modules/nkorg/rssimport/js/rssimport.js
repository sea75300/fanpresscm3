var nkorgRssImport = function () {
    
    var self = this;

    this.checkPath = function(feedPath) {

        jQuery('.fpcm-rssimport-artids-row').remove();

        if (feedPath == '' || feedPath == 'http://' || feedPath == 'https://') {
            return true;
        }

        fpcmJs.showLoader(true);

        var ajaxHandler   = new fpcmAjaxHandler();
        fpcmAjax.action   = 'nkorg/rssimport/checkpath';
        fpcmAjax.data     = { feedPath: feedPath };
        fpcmAjax.execDone = 'nkorgRssImportObj.ajaxCallBack(fpcmAjax.result);';
        fpcmAjax.get();
    };
    
    this.importFeed = function(feedPath) {

        if (feedPath == '' || feedPath == 'http://' || feedPath == 'https://') {
            return true;
        }

        fpcmJs.showLoader(true);

        var selectedIds = jQuery('.fpcm-rssimport-artids:checked');
        var ids         = [];
        jQuery.each(selectedIds, function( key, obj ) {
            ids.push(jQuery(obj).val());
        });

        var selectedCatIds = jQuery('.fpcm-rssimport-catids:checked');
        var categoryIds    = [];
        jQuery.each(selectedCatIds, function( key, obj ) {
            categoryIds.push(jQuery(obj).val());
        });

        if (ids.length == 0 || categoryIds.length == 0) {
            fpcmJs.addAjaxMassage('error', 'SELECT_ITEMS_MSG');
            return false;
        }

        var ajaxHandler   = new fpcmAjaxHandler();
        fpcmAjax.action   = 'nkorg/rssimport/runimport';
        fpcmAjax.data     = { feedPath: feedPath, feedIds: ids, userid: jQuery('#userid').val(), categories: categoryIds };
        fpcmAjax.execDone = 'nkorgRssImportObj.ajaxCallBack(fpcmAjax.result);';
        fpcmAjax.get();
    };
    
    this.ajaxCallBack = function(res) {
        
        fpcmJs.showLoader(false);
        
        res = JSON.parse(res);
        
        if (res.code === undefined || !res.code) {
            fpcmJs.addAjaxMassage('error', res.msg);
            self.lastUrl = '';
            return false;
        }

        fpcmJs.addAjaxMassage('notice', res.msg);
        
        if (res.list === undefined) {
            return false;
        }
        
        self.processList(res.list);
    }
    
    this.processList = function(list) {
        var content = '';
        for (i = 0; i< list.length; i++) {
            var elem = list[i];
            
            content = '<tr class="fpcm-rssimport-artids-row">';
            content += '<td class="fpcm-ui-articlelist-open"><a href="' + elem.link + '" target="_blank" class="fpcm-ui-button fpcm-ui-button-blank fpcm-openlink-btn"></a></td>';
            content += '<td>' + elem.title + '</td>';
            content += '<td class="fpcm-td-select-row"><input class="fpcm-ui-input-checkbox fpcm-rssimport-artids" name="fpcm-rssimport-artids[]" value="' + elem.id + '" type="checkbox"></td>';
            content += '</tr>';
            jQuery('#feed-articles-list').append(content);

        }
        
        fpcmJs.assignButtons();

    };
};

var nkorgRssImportObj = new nkorgRssImport();

jQuery(document).ready(function () {

    jQuery('#rsspath').blur(function() {
        nkorgRssImportObj.checkPath(jQuery(this).val());
    });

    jQuery('#btnStartImport').click(function() {
        nkorgRssImportObj.importFeed(jQuery('#rsspath').val());
    });
    
});


    
