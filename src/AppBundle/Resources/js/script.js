function showPassword(obj){
    $(obj).find('.password-key').first().data('obj', obj).on('click', function(){
        if($(this).data('switch-state') == 1){
            $(this).data('switch-state', 0).removeClass('fa-code').addClass('fa-hashtag');
            $($(this).data('obj')).find('.form-control').first().attr('type', 'password');
        }else{
            $(this).data('switch-state', 1).removeClass('fa-hashtag').addClass('fa-code');
            $($(this).data('obj')).find('.form-control').first().attr('type', 'text');
        }
    });
}