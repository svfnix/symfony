var modalMediaManager = modalMediaManager || (function ($) {
        'use strict';

        // Creating modal dialog's DOM
        var $dialog;
        var $iframe;
        var $tool_bar;
        var $progress_bar;
        var $address_bar;

        function create(url){
            return $(
                '<div class="modal fade modal-media-manager" tabindex="-1" role="dialog" id="modal-media-manager">'+
                '   <div class="modal-dialog" role="document">'+
                '       <div class="modal-content">'+
                '           <div class="modal-header">'+
                '               <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>'+
                '               <div class="modal-title">مدیریت پرونده های چند رسانه ای</div>'+
                '           </div>'+
                '           <div class="modal-body"><iframe style="overflow-x:hidden; overflow-y:scroll;" id="modalMediaManagerFrame" src="' + url + '" width="100%" height="100%" frameborder="0"></iframe></div>'+
                '           <div class="modal-footer">'+
                '               <div class="modal-toolbar"><a href="javascript:void(0)" class="fa fa-bars toolbar-menu" data-toggle="dropdown"></a></div>'+
                '               <div class="modal-progress"></div>'+
                '               <div class="modal-address"></div>'+
                '           </div>'+
                '       </div>'+
                '   </div>'+
                '</div>');
        }

        return {

            show: function (url) {

                if($dialog !== undefined) {
                    modalMediaManager.hide();
                }

                // Configuring dialog
                $dialog = create(url);
                $dialog.modal();

                $iframe = $dialog.find('iframe');
                $tool_bar = $dialog.find('.modal-toolbar');
                $progress_bar = $dialog.find('.modal-progress');
                $address_bar = $dialog.find('.modal-address');

                $tool_bar.find('.toolbar-menu').click(function () {
                    modalMediaManager.toogleSidebar();
                })

            },
            hide: function () {
                $dialog.modal('hide');
            },
            showProgressBar: function () {
                $progress_bar.html('<img src="/images/loading/three-dots.svg" width="50px" />');
            },
            hideProgressBar: function () {
                $progress_bar.html('');
            },
            setAddress: function (address) {
                $address_bar.html(address);
            },
            toogleSidebar: function () {
                document.all.modalMediaManagerFrame.contentWindow.toggleSidebar();
            }
        };

    })(jQuery);
