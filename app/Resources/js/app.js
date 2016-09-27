function switchPassword(obj){
    var $parent = $(obj).parent();
    $parent.append('<a href="javascript:void(0)" class="switch-password" data-target="' + obj + '">مشاهده رمز</a>');
    var $switch = $parent.find('.switch-password').first();
    $switch.on('click', function(){
        if($(this).data('switch-state') == 1){
            $(this).data('switch-state', 0).text('مشاهده رمز');
            $($(this).data('target')).attr('type', 'password');
        }else{
            $(this).data('switch-state', 1).text('عدم مشاهده رمز');
            $($(this).data('target')).attr('type', 'text');
        }
    });
}