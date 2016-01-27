// Model implementation
var GalleryItem = function(id, thumbnail, image) {
    this.id = id;
    this.thumbnail = thumbnail;
    this.imageUrl = image;
};

// Model items list
var GalleryItems = ko.observableArray();
GalleryItems.extend({ notify: 'always' });

(function($) {
    $.fn.gallerize = function(options) {
        var defaults = {
            delete_url:'/path/to/server',
            edit_url: '/path/to/server',
            update_url: '/path/to/server',
            delete_success: function(e) {},
            delete_error: function(e) {},
            update_success: function(e) {},
            update_error: function(e) {}
        };
        var settings = $.extend( {}, defaults, options );
        var element = $(this);

        $(element).css('opacity', 0);
        $(element).transition({
            'opacity': 1, duration: 350, 'ease': 'in'
        });

        // Show remove dialog
        $(element).find('.remove').on('click', function(){
            bootbox.dialog({
                message: "Remove element?",
                buttons: {
                    cancel: {
                        label: "Cancel",
                        className: "btn-default"
                    },
                    danger: {
                        label: "Yes, remove",
                        className: "btn-danger",
                        callback: function() {
                            var item = element;
                            $(item).transition({
                                'opacity': 0,
                                'width' : 0,
                                'scale': 0,
                                easing: 'out',
                                duration: 350
                            },
                            function(){
                                $(item).remove();
                                $.ajax({
                                    url: settings.delete_url,
                                    type:'DELETE',
                                    success: function(a) {
                                        settings.delete_success(a);
                                    },
                                    error: function(e) {
                                        settings.delete_error(e);
                                    }
                                });
                            });
                        }
                    }
                }
            });
        });

        // Show image meta dialog
        $(element).find('.edit').on('click', function(){
            bootbox.dialog({
                message: $('<div id="imageEditor"><div class="dialog-loading">Please wait while loading ...</div><div class="dialog-content"></div></div>'),
                title: "Edit picture data",
                ajax: true,
                buttons: {
                    cancel: {
                        label: "Cancel",
                        className: "btn-default"
                    },
                    okbutton: {
                        label: "Save",
                        className: "btn-success",
                        callback: function() {
                            $('#imageEditor').find('form').submit();
                            return false;
                        }
                    }
                }
            })
            .on('shown.bs.modal', function() {
                $.ajax({
                    url: settings.edit_url,
                    type:'GET',
                    success: function(e) {
                        var editor = $('#imageEditor');
                        editor.find('.dialog-loading').hide();
                        editor.find('.dialog-content').css('height', 40);
                        editor.find('.dialog-content').html(e);

                        editor.find('#META_FRM').ajaxForm({
                            success: function() {
                                bootbox.hideAll();
                            },
                            error: function(e) {
                                bootbox.hideAll();
                                bootbox.alert(e.responseText);
                            }
                        });

                        editor.find('.dialog-content').transition({height: 110}, 350);
                    },
                    error: function(xhr) {
                        bootbox.hideAll();
                        bootbox.alert('<h4>Error!</h4><p>'+xhr.responseText+'</p>');
                    }
                });
            });
        });

        return this;
    }
}(jQuery));