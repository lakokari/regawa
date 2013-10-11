$(document).ready(function(){
    $('div#btn-search').click(function(){
        $('input#search-input').toggle();
    });
    
    $('div#btn-menu-show').click(function(){
        $(this).next('ul').toggle();
    });
});
