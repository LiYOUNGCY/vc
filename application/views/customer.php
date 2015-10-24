<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <div class="conversation-list">
        <div class="list" id="list">
            <!--            <div class="message left">-->
            <!--                <div class="avatar"><img-->
            <!--                        src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150911/14419469971106.png"-->
            <!--                        alt="">-->
            <!---->
            <!--                    <div class="name">Miss CC</div>-->
            <!--                </div>-->
            <!--                <div class="content">-->
            <!--                    你好，我是维C小姐，有什么可以帮到你？-->
            <!--                    <div class="time">2015-09-14 17:06:53</div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="message right">-->
            <!--                <div class="avatar">-->
            <!--                    <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150911/14419469971106.png"-->
            <!--                         alt="">-->
            <!---->
            <!--                    <div class="name">Rache</div>-->
            <!--                </div>-->
            <!--                <div class="content">-->
            <!--                    新屋装修用了米黄色的墙，不知道这幅艺术画是否合适？-->
            <!--                    <div class="time">2015-09-14 17:07:35</div>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
        <div class="input-box clearfix">
            <textarea name="msg" id="msg" tabindex="0" rows='1' placeholder=""></textarea>

            <div class="btn send">发送</div>
        </div>
    </div>

    <input type="hidden" id="user_id" name="user_id" value="<?= $user['id'] ?>">
    <!--    <input type="hidden" id="customer_id" name="customer_id" value="--><?php //= $customer_id ?><!--">-->
    <?php echo $footer; ?>
</div>
</body>
<script>
    var yunba = new Yunba({
        server: 'sock.yunba.io', port: 3000, appkey: '55bc441c14ec0a7d21a70c5a'
    });

    //请求个人信息
    var myself = new Object();
    var user_id = $('#user_id').val();
    var customid;


    function insert_left_msg(name, avatar, msg, time) {
        var $box = $('<div class="message left">' +
            '<div class="avatar"><img src="' + avatar + '" alt="">' +
            '<div class="name">' + name + '</div>' +
            '</div>' +
            '<div class="content">' + msg +
            '<div class="time">' + time + '</div>' +
            '</div>' +
            '</div>');

        $('#list').append($box);
    }

    function insert_right_msg(name, avatar, msg, time) {
        var $box = $('<div class="message right">' +
            '<div class="avatar">' +
            '<img src="' + avatar + '"' + 'alt="">' +

            '<div class="name">' + name + '</div>' +
            '</div>' +
            '<div class="content">' + msg +
            '<div class="time">' + time + '</div>' +
            '</div>' +
            '</div>');

        $('#list').append($box);
    }

    var ids, j = 0, i = 0;
    var online = [];

    function work(data) {
        console.log(data);
        if (data.success) {
            if (data.data == 'online') {
                online.push(ids[i].id);
                console.log('在线' + ids[i].id);
            }
            else {
                console.log('不在线' + ids[i].id);
            }

        }
        else {
            console.log('不在线' + ids[i].id);
        }

        if (i + 1 < ids.length) {
            console.log('[i]:' + i);
            i++;
            yunba.get_state(ids[i].id, work)
        }
        else {
            if (online.length == 0) {
                console.log('无在线客服');
                function jump(count) {
                    window.setTimeout(function () {
                        count--;
                        if (count > 0) {
                            $('#num').attr('innerHTML', count);
                            jump(count);
                        } else {
                            window.location.href = BASE_URL;
                        }
                    }, 1000);
                }

                jump(3);
                swal({
                    title: "Tips",
                    text: "客服姐姐还没上线哦，三秒后将跳转到首页",
                    timer: 2000
                });
            }
            else {
                var random = Math.floor(Math.random() * online.length);
                console.log('随机的id为 ： ' + random);
                customid = online[random];

                console.log('customid:' + customid);


                //请求客服MM的信息，并发第一句话
                $.ajax({
                    url: BASE_URL + 'account/main/get_info_by_id',
                    type: 'post',
                    data: {
                        id: customid
                    },
                    dataType: 'json',
                    success: function (data) {
                        insert_left_msg(data.name, data.pic, '您好，我是' + data.name + '，请问有什么可以帮到您？', getTime());
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }

    }

    /**
     * 获取所有的客服，并检查在线状态，并随机分配一个客服
     */
    function get_customers() {


        $.ajax({
            url: BASE_URL + 'conversation/main/get_customer_id',
            type: 'post',
            dataType: 'json',
            async: false,
            success: function (data) {
                console.log(data);
                ids = data;
            }
        });

//        check_online();

        console.log('ids.length:' + ids.length);

        yunba.get_state(ids[i].id, work);


        console.log('在线的人：' + online);
    }

    $(function () {

        autosize($('textarea'));

//        get_customers();

        $.ajax({
            url: BASE_URL + 'account/main/get_info_by_id',
            type: 'post',
            data: {
                id: user_id
            },
            dataType: 'json',
            async: false,
            success: function (data) {
                console.log(data);
                myself.id = user_id;
                myself.name = data.name;
                myself.avatar = data.pic;

            },
            error: function (data) {
                console.log(data);
            }
        });

        function backup_message() {
            $.ajax({
                url: BACKUP_MESSAGE,
                type: 'post',
                data: {
                    sender: myself.id,
                    cid: customid,
                    uid: myself.id,
                    msg: myself.message,
                    time: myself.time
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }


        yunba.init(function (success) {
            if (success) {
                yunba.connect_by_customid(user_id, function (success, msg, sessionid) {

                    if (success) {
                        console.log('你已成功连接到消息服务器，会话ID：' + sessionid);

                        customid = get_customers();
                        console.log('customid:' + customid);

                        yunba.set_alias({'alias': user_id}, function (data) {
                            if (!data.success) {
                                console.log(data.msg);
                            }
                            else {
                                console.log('设置alias成功');

                                yunba.set_message_cb(function (data) {
                                    console.log(data);
                                    obj = eval('(' + data.msg + ')');
                                    insert_left_msg(obj.name, obj.avatar, obj.message, obj.time);
                                });
                            }
                        });
                    } else {
                        console.log(msg);
                    }
                });

            }
        });

        function send() {
            var message = $('#msg').val();
            //清空消息
            $('#msg').val('');
            myself.message = message;
            var time = getTime();
            myself.time = time;

            yunba.publish_to_alias({
                'alias': customid,
                'msg': JSON.stringify(myself)
            }, function (success, msg) {
                if (!success) {
                    console.log(msg);
                }
                else {
                    console.log('发送消息成功');
                    insert_right_msg(myself.name, myself.avatar, message, time);
                }
            });

            backup_message();
        }

        $('.send').click(send);

        $(document).keypress(function (e) {
            // 回车键事件
            if (e.which == 13) {
                send();
                e.preventDefault();
            }
        });
    });
</script>
</html>
