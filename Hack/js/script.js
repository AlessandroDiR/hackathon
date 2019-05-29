$(()=>{
    $('#collapse').collapse({
        toggle: false
    });

    $('.fa-bars, .fa-times').click(function(){
        $(this).toggleClass('fa-times fa-bars')
    });

    $(".collapse .nav-link").click(function(){

        var id = $(this).children("span[id]").attr("id");
        
        $.ajax({
            url:'ajax.php',
            type: 'post',
            data: { "id":id },
            success: function(data){
                $("#page-content").html(data);
            }
        })
    });
});