/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(function($){
    var container = $('#top-menu').find('ul > li');
    container.hover(function(){
        var _this = this;
        var menu_below = $(_this).find('>ul');
        if (menu_below.length > 0) {
            $(_this).find('> a').addClass('hovered');
            menu_below.show();
        }
    }, function(){
        var _this = this;
        var menu_below = $(_this).find('>ul');
        if (menu_below.length > 0) {
            $(_this).find('> a').removeClass('hovered');
            menu_below.hide();
        }
    });
});
