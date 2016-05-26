var nkorgRssImport = function () {
    
    var self = this;

    this.checkPath = function(feedPath) {

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

        var ajaxHandler   = new fpcmAjaxHandler();
        fpcmAjax.action   = 'nkorg/rssimport/runimport';
        fpcmAjax.data     = { feedPath: feedPath };
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
    }
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


    
