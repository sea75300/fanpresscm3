var nkorgRssImport = function () {
    
    var self = this;
    var lastUrl = '';
    
    this.checkPath = function(feedPath) {

        if (feedPath == '' || feedPath == 'http://' || feedPath == 'https://' || this.lastUrl == feedPath) {
            return true;
        }

        fpcmJs.showLoader(true);

        var ajaxHandler = new fpcmAjaxHandler();
        
        this.lastUrl = feedPath;

        fpcmAjax.action = 'nkorg/rssimport/checkpath';
        fpcmAjax.data   = {
            feedPath: feedPath
        };
        fpcmAjax.execDone = 'nkorgRssImportObj.checkPathCallBack(fpcmAjax.result);';
        fpcmAjax.get();
    };
    
    this.checkPathCallBack = function(res) {
        
        fpcmJs.showLoader(false);
        
        res = JSON.parse(res);
        
        if (res.code === undefined || !res.code) {
            fpcmJs.addAjaxMassage('error', res.msg);
            self.lastUrl = '';
            return false;
        }

        fpcmJs.addAjaxMassage('notice', res.msg);
    }
};

var nkorgRssImportObj = new nkorgRssImport();

jQuery(document).ready(function () {

    jQuery('#rsspath').blur(function() {
        nkorgRssImportObj.checkPath(jQuery(this).val());
    });
    
});


    
