/*
 * jQuery File Upload jQuery UI Plugin
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* jshint nomen:false */
/* global define, require, window */

;(function (factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // Register as an anonymous AMD module:
        define(['jquery', './jquery.fileupload-ui'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS:
        factory(require('jquery'));
    } else {
        // Browser globals:
        factory(window.jQuery);
    }
}(function ($) {
    'use strict';

    jQuery.widget('blueimp.fileupload', jQuery.blueimp.fileupload, {

        options: {
            processdone: function (e, data) {
                data.context.find('.start').button('enable');
            },
            progress: function (e, data) {
                if (data.context) {
                    data.context.find('.progress').progressbar(
                        'option',
                        'value',
                        parseInt(data.loaded / data.total * 100, 10)
                    );
                }
            },
            progressall: function (e, data) {
                var $this = jQuery(this);
                $this.find('.fileupload-progress')
                    .find('.progress').progressbar(
                        'option',
                        'value',
                        parseInt(data.loaded / data.total * 100, 10)
                    ).end()
                    .find('.progress-extended').each(function () {
                        jQuery(this).html(
                            ($this.data('blueimp-fileupload') ||
                                    $this.data('fileupload'))
                                ._renderExtendedProgress(data)
                        );
                    });
            }
        },

        _renderUpload: function (func, files) {
            var node = this._super(func, files),
                showIconText = jQuery(window).width() > 480;
            node.find('.progress').empty().progressbar();
            node.find('.start').button({
                icons: {primary: 'ui-icon-circle-arrow-e'},
                text: false
            });
            node.find('.cancel').button({
                icons: {primary: 'ui-icon-cancel'},
                text: false
            });
            if (node.hasClass('fade')) {
                node.hide();
            }
            return node;
        },

        _renderDownload: function (func, files) {
            var node = this._super(func, files),
                showIconText = jQuery(window).width() > 480;
            node.find('.delete').button({
                icons: {primary: 'ui-icon-trash'},
                text: showIconText
            });
            if (node.hasClass('fade')) {
                node.hide();
            }
            return node;
        },

        _startHandler: function (e) {
            jQuery(e.currentTarget).button('disable');
            this._super(e);
        },

        _transition: function (node) {
            var deferred = jQuery.Deferred();
            if (node.hasClass('fade')) {
                node.fadeToggle(
                    this.options.transitionDuration,
                    this.options.transitionEasing,
                    function () {
                        deferred.resolveWith(node);
                    }
                );
            } else {
                deferred.resolveWith(node);
            }
            return deferred;
        },

        _create: function () {
            this._super();
            this.element
                .find('.fileupload-buttonbar')
                .find('.fileinput-button').each(function () {
                    var input = jQuery(this).find('input:file').detach();
                    jQuery(this)
                        .button({icons: {primary: 'ui-icon-plusthick'}})
                        .append(input);
                })
                .end().find('.start')
                .button({icons: {primary: 'ui-icon-circle-arrow-e'}})
                .end().find('.cancel')
                .button({icons: {primary: 'ui-icon-cancel'}})
                .end().find('.delete')
                .button({icons: {primary: 'ui-icon-trash'}})
                .end().find('.progress').progressbar();
        },

        _destroy: function () {
            this.element
                .find('.fileupload-buttonbar')
                .find('.fileinput-button').each(function () {
                    var input = jQuery(this).find('input:file').detach();
                    jQuery(this)
                        .button('destroy')
                        .append(input);
                })
                .end().find('.start')
                .button('destroy')
                .end().find('.cancel')
                .button('destroy')
                .end().find('.delete')
                .button('destroy')
                .end().find('.progress').progressbar('destroy');
            this._super();
        }

    });

}));
