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
        post_data: null,
        url : '/path/to/server',
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
                    file.click();
                    e.stopPropagation();
                    e.preventDefault();
                });

                $(file).on('change', function(e){
                    var length = e.target.files.length;
                    if (length) {
                        var form_data = new FormData();
                        form_data.append($(file).attr('name'), e.target.files[0]);
                        form_data.append('data', self.options.post_data);
                        self.uploadFile(form_data);
                    }
                });
            });
        });
    };

    SimplifiedUploader.prototype.uploadFile = function(form_data) {
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
                self.options.success(responseData);
            },

            error: function(e){
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
    };

    return new SimplifiedUploader();
}));