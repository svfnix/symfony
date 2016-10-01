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