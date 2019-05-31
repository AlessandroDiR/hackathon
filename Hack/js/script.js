$(()=>{
    $('.collapse').collapse({
        toggle: false
    });

	var resize = true;
			
	$(".bars").click(function(){
		$(this).toggleClass("active");
		$(".menu").toggleClass("open");
		
		var screen = $(window).width(),
		menu = resize ? 300 : 0;
		
		$(".main-body").css("width", screen-menu+"px");
		console.log(screen, menu);
		
		resize = !resize ? true : false;
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
