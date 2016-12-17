var modalConfirm = modalConfirm || (function ($) {
        'use strict';

        // Creating modal dialog's DOM
        var $dialog;

        function create(){
            return $(
                '<div class="modal fade" tabindex="-1" role="dialog" id="modal-delete">'+
                '   <div class="modal-dialog" role="document">'+
                '       <div class="modal-content">'+
                '           <div class="modal-body">'+
                '               <button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                '               <span aria-hidden="true">×</span></button>'+
                '               <div class="modal-message"></div>'+
                '           </div>'+
                '           <div class="modal-footer"><button type="button" class="btn btn-confirm"/></div>'+
                '       </div>'+
                '   </div>'+
                '</div>');
        }

        return {

            show: function (message, action, type, callback) {

                if($dialog !== undefined) {
                    modalConfirm.hide();
                }

                // Configuring dialog
                $dialog = create();
                $dialog.find('.modal-message').html(message);
                $dialog.find('.btn-confirm').addClass('btn-' + type).html(action);

                if(typeof callback === 'function'){
                    $dialog.find('.btn-confirm').click(callback);
                } else {
                    $dialog.find('.modal-footer').remove();
                }

                $dialog.modal();

            },
            hide: function () {
                $dialog.modal('hide');
            },
            wait: function () {
                $dialog.find('.modal-footer').html('<img src="/images/loading/three-dots.svg" width="50px" />');
            },
            done: function () {
                $dialog.find('.modal-message').html('<span class="fs-16px"><i class="fa fa-check green margin-3px"/></span> عملیات با موفقیت انجام شد');
                $dialog.find('.modal-footer').remove();
            }
        };

    })(jQuery);