$(function(){
    
    $("#sbtn").click(function(){
        if(!$("body").hasClass("hide-y")){
            $("body").addClass("hide-y");
            $("#vi_container").stop().animate({
                right: "280px"
            },400);
            $("#sbtn").stop().animate({
                right: "280px"
            },400);
            
            $("#vc_sidebar").stop().animate({
                right: "0px"
            },400);
            $("#shade").addClass("shade");
        }else{
            $("#shade").removeClass("shade");
            $("#vi_container").stop().animate({
            right: "0px"
            },400);
            $("#sbtn").stop().animate({
                right: "0px"
            },400);
            $("#vc_sidebar").stop().animate({
                right: "-280px"
            },400);
            $("body").removeClass("hide-y");
        }
    });
    $("#shade").click(function(){
        
        $("#shade").removeClass("shade");
        $("#vi_container").stop().animate({
        right: "0px"
        },400);
        $("#sbtn").stop().animate({
                right: "0px"
            },400);
        $("#vc_sidebar").stop().animate({
            right: "-280px"
        },400);
        $("body").removeClass("hide-y");
    })
    
	
    

})