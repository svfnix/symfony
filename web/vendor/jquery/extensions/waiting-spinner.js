var waitingSpinner = waitingSpinner || (function ($) {
        'use strict';

        // Creating modal dialog's DOM
        var $dialog = $(
            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
            '<div class="modal-dialog modal-sm">' +
            '<div style="text-align: center"><img src="/images/loading/loading-spinning-bubbles.svg"></div>' +
            '</div>' +
            '</div>');

        return {

            show: function () {
                // Opening dialog
                $dialog.modal();
            },

            hide: function () {
                $dialog.modal('hide');
            }
        };

    })(jQuery);