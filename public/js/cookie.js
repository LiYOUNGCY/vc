
    function setcookie(name,value){
        var Days = 30;
        var exp  = new Date();
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = name + "="+ escape(value) + ";expires=" + exp.toGMTString()+ "; path=/artvc";
    }


    function getcookie(name){
        var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
        if(arr != null){
            return (arr[2]);
        }else{
            return null;
        }
    }


    function delcookie(name){
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=getcookie(name);
        if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    }
