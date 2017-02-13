var modalMediaManager = modalMediaManager || (function ($) {
        'use strict';

        // Creating modal dialog's DOM
        var $dialog;

        function create(){
            return $(
                '<div class="modal fade modal-media-manager" tabindex="-1" role="dialog" id="modal-media-manager">'+
                '   <div class="modal-dialog" role="document">'+
                '       <div class="modal-content">'+
                '           <div class="modal-body">'+
                '               <button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                '               <span aria-hidden="true">×</span></button>'+
                '               <div class="modal-message"></div>'+
                '           </div>'+
                '           <div class="modal-footer"></div>'+
                '       </div>'+
                '   </div>'+
                '</div>');
        }

        return {

            show: function () {

                if($dialog !== undefined) {
                    modalMediaManager.hide();
                }

                // Configuring dialog
                $dialog = create();
                $dialog.modal();

            },
            hide: function () {
                $dialog.modal('hide');
            },
        };

    })(jQuery);