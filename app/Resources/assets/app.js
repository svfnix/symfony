function showPassword(obj){
    $(obj).find('.password-key').first().data('obj', obj).on('click', function(){
        if($(this).data('switch-state') == 1){
            $(this).data('switch-state', 0).removeClass('fa-eye').addClass('fa-eye-slash');
            $($(this).data('obj')).find('.form-control').first().attr('type', 'password');
        }else{
            $(this).data('switch-state', 1).removeClass('fa-eye-slash').addClass('fa-eye');
            $($(this).data('obj')).find('.form-control').first().attr('type', 'text');
        }
    });
}

$(function() {
    $(".enter_submit").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            $($(this).data('submit')).click();
            return false;
        } else {
            return true;
        }
    });
});