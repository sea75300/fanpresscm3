/**
 * FanPress CM AJAX Framework
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
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
        jQuery.ajax({
            url         : self.ajaxPath + self.action + (self.query ? '&' + self.query : ''),
            type        : self.method.toUpperCase(),
            data        : self.data,
            async       : self.async
        })
        .done(function(result) {
            self.result = result;
            if (typeof self.execDone == 'string') {
                eval(self.execDone);
            }
        })
        .fail(function() {
            alert(fpcmAjaxErrorMessage);
            if (typeof self.execFail == 'string') {
                eval(self.execFail);
            }
        });        
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
        return JSON.parse(data);
    };
    
    this.toJSON = function(data) {
        
        var isArray = data instanceof Array ? true : false;
        var isObject = data instanceof Object ? true : false;
        if (!isArray || !isObject) {
            return '';
        }
        
        return JSON.stringify(data);
    };

}