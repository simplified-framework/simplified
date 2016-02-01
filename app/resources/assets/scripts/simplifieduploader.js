(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node. Does not work with strict CommonJS, but
        // only CommonJS-like environments that support module.exports,
        // like Node.
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.simplifiedUploader = factory(root.jQuery);
    }
}(this, function ($) {
    function SimplifiedUploader(options) {
        this.init();

        // options
        this.options = $.extend({}, this.constructor.defaults);
        this.option(options);
    }

    SimplifiedUploader.defaults = {
        configured: false,
        post_data: null,
        url : '/path/to/server',
        accept: '*.*',
        success: function(e) {},
        error: function(e) {}
    };

    SimplifiedUploader.prototype.init = function() {
        var self = this;
        $(document).ready(function(){
            $('.simplified-uploader').each(function(i, e){
                var droparea = $(e).find('.droparea');
                var file = $(droparea).parent().find('.file-input');

                $(droparea).on('click', function(e){
                    // sanitize settings
                    types = self.options.accept.replace(/;/g, ',');
                    if (types != "*.*") {
                        types = types.replace(/\*./g, '.');
                    }

                    // set accepted file types
                    $(file).attr('accept', types);

                    // TODO take option from settings
                    //$(file).attr('multiple', true);

                    // trigger file click
                    file.click();
                    e.stopPropagation();
                    e.preventDefault();
                });

                $(file).on('change', function(e){
                    var length = e.target.files.length;
                    if (length) {

                        // sanitize settings
                        var accept = self.options.accept;
                        var types;
                        if (accept != "*.*") {
                            if (accept.charAt(accept.length-1) == ';')
                                accept = accept.substring(0, accept.length-1);
                            types = accept.replace(/;/g, ',');
                            types = types.replace(/\*./g, '.');
                            types = types.split(/,/);
                        } else {
                            types = accept;
                        }

                        var name = e.target.files[0].name;
                        var ext  = name.substring(name.lastIndexOf('.'), name.length);

                        // prevent upload of other than accepted file types
                        if (accept != '*.*' && $.inArray(ext, types) == -1) {
                            $(file).val('');
                            bootbox.alert('Filename <b>' + name + '</b> is not allowed to upload');
                            return false;
                        }

                        if (self.options.configured == false) {
                            $(file).val('');
                            bootbox.alert('Error: Uploader is not configured.');
                            return false;
                        }

                        var form_data = new FormData();
                        form_data.append($(file).attr('name'), e.target.files[0]);
                        form_data.append('data', self.options.post_data);
                        self.uploadFile(form_data, file);
                    }
                });
            });
        });
    };

    SimplifiedUploader.prototype.uploadFile = function(form_data, file) {
        var self = this;
        $.ajax({
            url: self.options.url,  //Server script to process data
            type: 'POST',
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',function(ev){
                        var percent  = 0,
                            position = (ev.loaded || ev.position),
                            total 	 = ev.total;

                        if (ev.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                    }, false); // For handling the progress of the upload
                }
                return myXhr;
            },

            //Ajax events
            success: function(responseData){
                $(file).val('');
                self.options.success(responseData);
            },

            error: function(e){
                $(file).val('');
                self.options.error(e);
            },

            // Form data
            data: form_data,

            // Options to tell jQuery not to process data
            // or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });
    };

    SimplifiedUploader.prototype.option = function(options) {
        $.extend(this.options, options);
        if (this.options.url != '/path/to/server')
            this.options.configured = true;
    };

    return new SimplifiedUploader();
}));