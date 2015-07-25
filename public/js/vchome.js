$(function(){
    
    $("#sbtn").click(function(){
        if(!$("body").hasClass("hide-y")){
            $("body").addClass("hide-y");
            $("#vi_container").stop().animate({
                right: "280px"
            },400);
            $("#sbtn").stop().animate({
                right: "281px"
            },400);
            
            $("#vc_sidebar").stop().animate({
                right: "0px"
            },400);
            $("#shade").addClass("shade").animate({
                left: "-280px"
            });
        }else{
            $("#shade").removeClass("shade").animate({
                left: "0px"
            });
            $("#vi_container").stop().animate({
            right: "0px"
            },400);
            $("#sbtn").stop().animate({
                right: "0px"
            },400);
            $("#vc_sidebar").stop().animate({
                right: "-280px"
            },400,function(){
                $("#lop").css({height:0});
            });
            $("body").removeClass("hide-y");
        }
    });
    $("#shade").click(function(){
        
        $("#shade").removeClass("shade").animate({
                left: "0px"
            });;
        $("#vi_container").stop().animate({
        right: "0px"
        },400);
        $("#sbtn").stop().animate({
                right: "0px"
            },400);
        $("#vc_sidebar").stop().animate({
            right: "-280px"
        },400,function(){
            $("#lop").css({height:0});
        });
        $("body").removeClass("hide-y");
    })
    
	
    $("#showlang").click(function(){
        if($("#lop").height() == 0){
            $("#lop").animate({
                height:"40px"
            },100);
        }else{
            $("#lop").animate({
                height:0
            },100);
        }
    })
})