/**
 * FanPress CM AJAX Framework
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @deprecated FPCM 3.5
 */

var fpcmAjaxHandler = function () {

    var self = this;

    self.ajaxPath       = fpcmAjaxActionPath;
    self.action         = '';
    self.query          = false;
    self.method         = 'POST';
    self.async          = true;
    self.data           = [];
    self.workData       = false;
    self.result         = [];
    self.execDone       = false;
    self.execFail       = false;

    this.exec = function() {
        
        console.warn('Using "fpcmAjaxHandler.exec/get/post" class is deprecated as of version 3.5! Use fpcm.ajax.exec/get/post instead.');
        
        fpcm.ajax.exec(self.action, {
            method      : self.method,
            async       : self.async,
            data        : self.data,
            execDone    : self.execDone,
            execFail    : self.execFail,
            workData    : self.workData
        }, self);
      
    };

    this.get = function() {
        self.method = 'get';
        self.exec();
    };

    this.post = function() {
        self.method = 'post';
        self.exec();
    };
    
    this.reset = function() {
        
        console.warn('Using "fpcmAjaxHandler.reset" class is deprecated as of version 3.5!');
        
        self.ajaxPath       = fpcmAjaxActionPath;
        self.action         = '';
        self.query          = false;
        self.method         = 'POST';
        self.async          = true;
        self.data           = [];
        self.workData       = false;
        self.execDone       = false;
        self.execFail       = false;            
    };

    this.fromJSON = function(data) {
        
        console.warn('Using "fpcmAjaxHandler.fromJSON" class is deprecated as of version 3.5!');
        
        return fpcm.ajax.fromJSON(data);
    };

    this.toJSON = function(data) {
        
        console.warn('Using "fpcmAjaxHandler.toJSON" class is deprecated as of version 3.5!');
        
        return fpcm.ajax.toJSON(data);
    };

}

/**
 * FanPress CM AJAX Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @since FPCM 3.5
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.ajax = {
    
    result   : [],
    workData : [],
    
    exec: function(action, params, _legacy) {

        if (!params) {
            params = {};
        }

        if (!params.method) {
            params.method = 'POST';
        }

        if (!params.async) {
            params.async = true;
        }

        if (!params.data) {
            params.data = [];
        }

        if (!params.execDone) {
            params.execDone = false;
        }

        if (!params.execFail) {
            params.execFail = false;
        }

        if (params.workData) {
            fpcm.ajax.workData[action] = params.workData;
        }

        jQuery.ajax({
            url         : fpcmAjaxActionPath + action,
            type        : params.method.toUpperCase(),
            data        : params.data,
            async       : params.async
        })
        .done(function(result) {

            if (result.search('FATAL ERROR:') === 3) {
                console.log(fpcm.ui.translate('ajaxErrorMessage'));
                console.log('ERROR MESSAGE: ' + errorThrown);
            }

            if (result.cmd !== undefined) {
                eval(result.cmd);
                return true;
            }

            fpcm.ajax.result[action] = result;
            
            if (_legacy) {
                _legacy.result = result;
            }

            if (typeof params.execDone == 'string') {
                eval(params.execDone);
            }

            if (typeof params.execDone == 'function') {
                params.execDone.call();
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(fpcm.ui.translate('ajaxErrorMessage'));
            console.log('ERROR MESSAGE: ' + errorThrown);

            if (typeof params.execFail == 'string') {
                eval(params.execFail);
            }

            if (typeof params.execFail == 'function') {
                params.execFail.call();
            }
        });   

    },
    
    get: function(action, params) {
        
        if (!params) {
            params = {};
        }
        
        params.method = 'GET';
        fpcm.ajax.exec(action, params);
    },
    
    post: function(action, params) {

        if (!params) {
            params = {};
        }

        params.method = 'POST';
        fpcm.ajax.exec(action, params);
    },

    getResult: function(action) {
        return fpcm.ajax.result[action] ? fpcm.ajax.result[action] : null;
    },

    getWorkData: function(action) {
        return fpcm.ajax.workData[action] ? fpcm.ajax.workData[action] : null;
    },

    fromJSON: function(data) {
        
        if (data instanceof Object || data instanceof Array) {
            return data;
        }

        return JSON.parse(data);
    },
    
    toJSON: function(data) {

        var isArray = data instanceof Array ? true : false;
        var isObject = data instanceof Object ? true : false;
        if (!isArray || !isObject) {
            return '';
        }

        return JSON.stringify(data);
    }
    
};