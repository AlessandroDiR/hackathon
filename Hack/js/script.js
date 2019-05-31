$(()=>{
    $('[tooltip]').tooltip();

    $('.collapse').collapse({
        toggle: false
    });
			
	$(".bars").click(function(){
		$(this).toggleClass("active");
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

    $(".read-article").click(function(){
        $("input[name='text']").val($(this).attr("data-url"));
        $("form").submit();
    });
});