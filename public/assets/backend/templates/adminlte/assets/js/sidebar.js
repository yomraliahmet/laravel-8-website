jQuery.expr[':'].Contains = function(a, i, m) {
    return jQuery(a).text().toUpperCase()
        .indexOf(m[3].toUpperCase()) >= 0;
};

$(document).ready(function(){
    $("#filterinput").change(function(){
        var deger = $(this).val();
        if(deger)
        {
            $("#list li:not(:Contains('"+deger+"'))").slideUp();
            $("#list li:Contains(" + deger + ")").slideDown();
        }
        else
        {
            $("#list li").slideDown();
        }
        return false;
    }).keyup( function () {
        $(this).change();
    });


    $(".nav-sidebar li.has-treeview a").on("click", function(e){
        if (e.which) {
            var key = 'open_'+$(this).data("id");
            $(this).toggleClass("active");
            if(sessionStorage.getItem(key)){
                sessionStorage.removeItem(key);
            }else{
                sessionStorage.setItem(key, 1);
            }
        }
    });

    $(".nav-sidebar li.has-treeview").each(function(k,e){
        var key = 'open_'+$(e).children("a").data("id");
        if(sessionStorage.getItem(key)){
            $(e).toggleClass("menu-open");
            $(e).children("a").toggleClass("active");
        }
    });

});
