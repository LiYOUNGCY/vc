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
    <input type="hidden" id="customer_id" name="customer_id" value="<?= $customer_id ?>">
    <?php echo $footer; ?>
</div>
</body>
<script>
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

    $(function () {

        autosize($('textarea'));
        var user_id = $('#user_id').val();
        var customid = $('#customer_id').val();

        //请求个人信息
        var myself = new Object();
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

                myself.name = data.name;
                myself.avatar = data.pic;
            },
            error: function (data) {
                console.log(data);
            }
        });

        //请求客服MM的信息，并发第一句话
        $.ajax({
            url: BASE_URL + 'account/main/get_info_by_id',
            type: 'post',
            data: {
                id: customid
            },
            dataType: 'json',
            success: function (data) {
                insert_left_msg(data.name, data.pic, '您好，我是'+data.name+'，请问有什么可以帮到您？', getTime());
            },
            error: function (data) {
                console.log(data);
            }
        });

        var yunba = new Yunba({
            server: 'sock.yunba.io', port: 3000, appkey: '55bc441c14ec0a7d21a70c5a'
        });

        yunba.init(function (success) {
            if (success) {
                yunba.connect_by_customid(user_id, function (success, msg, sessionid) {

                    if (success) {
                        console.log('你已成功连接到消息服务器，会话ID：' + sessionid);

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

        $('.send').click(function () {
            var message = $('#msg').val();
            myself.message = message;
            var time = '2015-09-15 19:59:03';
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
        });

        /**
         * 获取服务器时间
         */
        function getTime() {
            var time = '';

            $.ajax({
                url: BASE_URL + 'account/main/get_time',
                type: 'post',
                dataType: 'json',
                async: false,
                success: function (data) {
                    console.log(data);
                    time = data.time;
                }
            });

            return time;
        }
    });
</script>
</html>
