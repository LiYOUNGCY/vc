<body>
<div class="container">
    <a class="link" href="">
        <h3>管理中心</h3>
    </a>》
    <a class="link" href="">
        <h3>客服中心</h3>
    </a>

    <div class="wrap">
        <div class="contacts">
            <div class="list" id="contacts">
                <!--                    <div class="avatar">-->
                <!--                        <img src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150911/14419469971106.png"-->
                <!--                             alt="">-->
                <!---->
                <!--                        <div class="name">Miss CC</div>-->
                <!--                    </div>-->
            </div>
        </div>
        <div class="conversation-list" style="display: none;">
            <div class="title">MISS CC</div>
            <div class="list">
                <div class="message left">
                    <div class="avatar"><img
                            src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150911/14419469971106.png"
                            alt="">

                        <div class="name">Miss CC</div>
                    </div>
                    <div class="content">
                        你好，我是维C小姐，有什么可以帮到你？
                        <div class="time">2015-09-14 17:06:53</div>
                    </div>
                </div>
                <?php for ($i = 0; $i < 20; $i++) { ?>
                    <div class="message right">
                        <div class="avatar">
                            <img
                                src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150911/14419469971106.png"
                                alt="">

                            <div class="name">Rache</div>
                        </div>
                        <div class="content">
                            新屋装修用了米黄色的墙，不知道这幅艺术画是否合适？
                            <div class="time">2015-09-14 17:07:35</div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="form-inline">
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                <button type="button" class="btn btn-success">发送</button>
            </div>
        </div>
    </div>

    <input type="hidden" id="user_id" name="user_id" value="<?= $user['id'] ?>">
</div>
</body>
<!--云巴-->
<script type="text/javascript" src="<?= base_url() ?>public/js/yunba/socket.io-1.3.5.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>public/js/yunba/yunba-js-sdk.js"></script>
<script>
    var yunba = new Yunba({
        server: 'sock.yunba.io', port: 3000, appkey: '55bc441c14ec0a7d21a70c5a'
    });

    var myself = new Object();

    function backup_message(uid) {
        $.ajax({
            url: BACKUP_MESSAGE,
            type: 'post',
            data: {
                cid: myself.id,
                uid: uid,
                msg: myself.message,
                time: myself.time
            },
            success: function (data) {
                console.log(data);
            }
        });
    }

    /**
     * 切换对话
     */
    function shift() {
        var id = $(this).attr('id');
        id = id.substr(5, id.length);

        $('#contacts > .avatar').each(function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            }
        });

        //Add Class
        $(this).addClass('active');

        $('.conversation-list').each(function () {
            $(this).hide();
        });

        $('#conversation-' + id).show();
    }

    function send_msg() {
        var message = $(this).parent().find('input').val();
        //清空消息
        $(this).parent().find('input').val('');
        var alias = $(this).parent().parent().attr('id');
        alias = alias.substr(13, alias.length);
        console.log(alias);

        var time = getTime();
        myself.time = time;
        myself.message = message;

        yunba.publish_to_alias({
            'alias': alias,
            'msg': JSON.stringify(myself)
        }, function (success, msg) {
            if (!success) {
                console.log(msg);
            }
            else {
                console.log('发送消息成功');
                insert_right_msg(alias, myself.name, myself.avatar, message, time);
            }
        });

        backup_message(alias);
    }


    function get_user_in_contacts(id) {
        return $('#user-' + id);
    }

    /**
     * 新建对话
     * @param id
     * @param name
     * @param avatar 头像
     */
    function insert_contacts(id, name, avatar) {
        var $box = $('<div class="avatar" id="user-' + id + '">' +
            '<img src="' + avatar + '" alt="">' +
            '<div class="name">' + name + '</div>' +
            '</div>');

        //注册点击事件
        $box.click(shift);
        $('#contacts').append($box);


        $box = $('<div class="conversation-list" id="conversation-' + id + '">' +
            '<div class="title">' + name + '</div>' +
            '<div class="list" ></div>' +
            '<div class="form-inline">' +
            '<input type="text" class="form-control" id="exampleInputEmail1" placeholder="">' +
            '<button type="button" class="btn btn-success">发送</button>' +
            '</div>' +
            '</div>');


        $('.wrap').append($box);
        //注册滚动条事件
        $box.find('.list').perfectScrollbar();
        //注册发送事件
        $box.find('button').click(send_msg);
        $box.hide();

    }

    function insert_left_msg(id, name, avatar, msg, time) {
        var $box = $('<div class="message left">' +
            '<div class="avatar"><img src="' + avatar + '" alt="">' +
            '<div class="name">' + name + '</div>' +
            '</div>' +
            '<div class="content">' + msg +
            '<div class="time">' + time + '</div>' +
            '</div>' +
            '</div>');

        $('#conversation-' + id + ' > .list').append($box);
    }

    function insert_right_msg(id, name, avatar, msg, time) {
        var $box = $('<div class="message right">' +
            '<div class="avatar">' +
            '<img src="' + avatar + '"' + 'alt="">' +

            '<div class="name">' + name + '</div>' +
            '</div>' +
            '<div class="content">' + msg +
            '<div class="time">' + time + '</div>' +
            '</div>' +
            '</div>');

        $('#conversation-' + id + ' > .list').append($box);
    }

    $(function () {
        $('.list').each(function () {
            $(this).perfectScrollbar();
        });

        var user_id = $('#user_id').val();
        console.log(user_id);

        //获取个人资料
        $.ajax({
            url: BASE_URL + 'account/main/get_info_by_id',
            type: 'post',
            data: {
                id: user_id
            },
            dataType: 'json',
            async: false,
            success: function (data) {
                myself.id = user_id;
                myself.name = data.name;
                myself.avatar = data.pic;
            },
            error: function (data) {
                console.log(data);
            }
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
                                console.log('设置alias成功, alias:' + user_id);

                                yunba.set_message_cb(function (data) {
                                    console.log(data);
                                    obj = eval('(' + data.msg + ')');
                                    var contact = get_user_in_contacts(obj.id);
                                    console.log(contact);
                                    if (contact.length === 0) {
                                        insert_contacts(obj.id, obj.name, obj.avatar);
                                        insert_left_msg(obj.id, obj.name, obj.avatar, obj.message, obj.time);
                                        $('#user-' + obj.id).addClass('active');
                                    }
                                    else {
                                        insert_left_msg(obj.id, obj.name, obj.avatar, obj.message, obj.time);
                                    }

                                });
                            }
                        });
                    } else {
                        console.log(msg);
                    }
                });

            }
        });
    });
</script>