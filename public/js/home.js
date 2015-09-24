var BASE_URL = $("#BASE_URL").val();
var GET_COMMU_LIST_URL = BASE_URL +"home/main/get_user_community";
var FOLLOWING_URL = BASE_URL +"contacts/main/following"; 
var uid  = $("#userid").val();
var PAGE = 1;
var is_more = 1;
var jcrop_api;

window.onload = function() {
	loadcommu(0,uid);
	$("#loadmore").click(function(){
		loadcommu(PAGE,uid);
		PAGE++;
	});

	$("#gz-btn").click(function(){
		if($(this).hasClass('followed')){
			sweetAlert({
				title: "不再关注了?",
				text: "你将不会受到该用户的动态!",
			  	type: "warning",
			  	showCancelButton: true,
			  	confirmButtonColor: "#FCEE21",
			  	confirmButtonText: "是的",
			  	cancelButtonText: "取消",
			  	closeOnConfirm: false
			}, function(){
			   	if(following(uid)){
			   		swal("已取消关注!","success");
			  		$("#gz-btn").html('<i class="fa fa-plus"></i>关注').removeClass('followed');
			   	}
			});
		}else{
			if(following(uid)){
				$(this).html('<i class="fa fa-check"></i>已关注').addClass('followed');
			}
		}
	});
	// $("#talkto").click(function(){
	// 	sweetAlert({
	// 		title: "不再关注了?",
	// 		text: "你将不会受到该用户的动态!",
	// 	  	type: "warning",
	// 	  	showCancelButton: true,
	// 	  	confirmButtonColor: "#FCEE21",
	// 	  	confirmButtonText: "是的",
	// 	  	cancelButtonText: "取消",
	// 	  	closeOnConfirm: false
	// 	}, function(){
	// 	   	if(following(uid)){
	// 	   		swal("已取消关注!","success");
	// 	  		$("#gz-btn").html('<i class="fa fa-plus"></i>关注').removeClass('followed');
	// 	   	}
	// 	});
	// })
	$(".likebtn1 .support").click(function(){
		if($(this).parent().hasClass('focus')){
			$(this).parent().attr('class','likebtn1 blur');
		}else{
			$(this).parent().attr('class','likebtn1 focus');
		}
	});

	$("#image").css({'display':'none'});

	$('#head').hover(function(){
		$('#shadow').stop().fadeIn(200);
	}, function(){
		$('#shadow').stop().fadeOut(200);
	});

	//点击头像的事件
	$('#head').click(function(){
		$('#headpic').css({'display':'block'});
	});

	$("#save").click(function(){
        $('form').submit();
    });

    $("#cancel").click(function(){
    	$('#headpic').css({'display':'none'});

    	jcrop_api.destroy();

    	if($("#image").css('display') != 'none' ) {
    		$("#image").css({'display':'none'});
    	}

    	if($("#camera_warp").css('display') != 'block' ) {
    		$("#camera_warp").css({'display':'block'});
    	}

    	// $("#camera_warp").css({'display':'block'}); 
    });
}; 

function loadcommu(pageTemp, id){
	$.ajax({
		url: GET_COMMU_LIST_URL,
		async: false, 
        type: 'POST',
        data: {page : pageTemp, uid:id},
        success:function(data){
        	data = eval("("+data+")");
        	if(data == null || data == ""){
        		$("#loadmore").addClass('disable');
        		$("#loadmore").html("没有更多");
        		$("#loadmore").unbind();
        		return false;
        	}
        	for(var i = 0; i < data.length; i++){
        		var id 			= data[i].id;
        		var element = "";
        		var mediaid = data[i].media.id;
            	var name 	= data[i].name;
            	var intro   = data[i].intro;
            	var pic     = data[i].media.pic;
            	var post 	= data[i].post;
        		element = '<a href="<?=base_url()?>community/'+ id +'"><div class="box"><div class="user"><div class="head"><img src="'+ pic +'"></div><div class="name">'+ name +'</div><div class="intro">'+ intro +'</div></div></div></a>';
            	$("#qzlist #list").append(element);	
        		
            	
        	}
        }
	});
}
function following(pid){
	var success = 0;
	$.ajax({
		url: FOLLOWING_URL,
		async: false, 
        type: 'POST',
        data:{uid : pid},
        success : function(data){
        	alert(data);
        	data = eval("("+data+")");
        	//错误
            if(data.error != null)
            {	
            	sweetAlert("关注失败!", data.error, "error");
            	return false;
            }
            success = 1;
        }
	})
	return success;
} 

function jcrop_init(tar)
{
    $(tar).Jcrop({
        bgColor: 'black',
        bgOpacity: 0.4,
        boundary:2,
        setSelect: [100, 100, 300 ,300],  //设定4个角的初始位置
        aspectRatio: 1 / 1,
        onSelect: showCoords   //当选择完成时执行的函数
    }, function(){
    	jcrop_api = this;
    });    
}
function showCoords(c)
{
    $("#x").val(c.x);
    $("#y").val(c.y);
    $("#w").val(c.w);
    $("#h").val(c.h);
}
//检查裁剪宽度
function checkCoords()
{
    if (parseInt($('#w').val())){
        $("#img").val(img_src);
        return true;
    }
    alert('Please select a crop region then press submit.');
    return false;
}
function file_upload()
{
    var BASE_URL  = $("#BASE_URL").val();
    var UPLOAD_URL= BASE_URL+'publish/image/upload_headpic';
    $.ajaxFileUpload({
        url: UPLOAD_URL,
        fileElementId: 'upfile',
        dataType: 'JSON',
        type:'post',
        success: function (data) {
            $("#error_div").html("");
            if(data.error != null)
            {
                $("#error_div").html(data.error);
            }
            else
            {
                var path = data.filepath
                img_src  = path;
                $("#image").attr('src',BASE_URL+path);
                $('#image').css({'display':'block'});
                $("#camera_warp").css({'display':'none'});      
                // $("form").show();                      
                jcrop_init('#image');   
            }

        },
        error: function (data) {
            //alert('error');
        }
    });    
}