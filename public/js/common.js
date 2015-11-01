var BASE_URL = document.getElementById('BASE_URL').value;
var GET_ARTICLE_URL = BASE_URL + "article/main/get_article_list";
var GET_TOPIC_URL = BASE_URL + "article/main/get_topic_list";
var COMMENT_URL = BASE_URL + 'article/detail/write_comment';
var VOTE_URL = BASE_URL + 'article/detail/get_vote_list';
var ARGEE_URL = BASE_URL + 'article/detail/vote_article';
var DELETE_URL = BASE_URL + 'article/detail/delete_article';

//艺术家列表
var GET_ARTIST_LIST = BASE_URL + 'artist/main/get_artist_list';

//登录
var LOGIN_URL = BASE_URL + 'login';


var PHONE_LOGIN_URL = BASE_URL + "account/main/login_by_phone";
var EMAIL_LOGIN_URL = BASE_URL + "account/main/login_by_email";
var EMAIL_SIGNUP_URL = BASE_URL + "account/main/register_by_email";
var PHONE_SIGNUP_URL = BASE_URL + "account/main/register_by_phone";
var CHECK_PHONE_URL = BASE_URL + "account/main/check_phone";
var CHECK_EMAIL_URL = BASE_URL + "account/main/check_email";

//艺术品列表
var GET_PRODUCTION_URL = BASE_URL + 'production/main/get_production_list';

//提交文章
var POST_ARTICLE_URL = BASE_URL + 'article/publish/publish_article';

//获取文章
var GET_ARTICLE_BY_ID = BASE_URL + 'topic/publish/get_article/';

//更新文章
var UPDATE_ARTICLE = BASE_URL + 'article/publish/update_article';

//艺术作品
var GET_ARTIST_ARTS = BASE_URL + 'artist/detail/get_artist_production';

//获取购物车列表
var GET_CART_GOODS = BASE_URL + 'cart/main/get_good_list';

//获取购物车商品的数量
var GET_CART_GOODS_COUNT = BASE_URL + 'cart/main/get_cart_count';

//删除购物车商品
var REMOVE_CART_GOODS = BASE_URL + 'cart/main/remove_goods';

//添加购物车商品
var ADD_CART_GOODS = BASE_URL + 'cart/main/add_goods';


//艺术品点赞
var VOTE_PRODUCTION = BASE_URL + 'production/detail/like_production';

//手机验证码
var SEND_PHONE_CODE_URL = BASE_URL + 'account/main/validate_phone';

//专题页面
var TOPIC_URL = BASE_URL + 'topic';

//个人中心 - 喜欢列表(文章)
var GET_PERSONAL_LIKE_ARTICLE = BASE_URL + 'like/main/get_article_like_list';

//个人中心 - 喜欢列表(艺术品)
var GET_PERSONAL_LIKE_PRODUCTION = BASE_URL + 'like/main/get_production_like_list';

//个人中心 - 获取购买列表
var GET_PERSONAL_TRANSACTION = BASE_URL + 'transaction/main/get_transaction_list';

//个人中心 - 获取消息
var GET_NOTIFICATION = BASE_URL + 'notification/main/get_notification_list';

//客服消息
var BACKUP_MESSAGE = BASE_URL + 'conversation/custom/send_message_by_user';

//修改密码
var CHANGE_PWD = BASE_URL + 'account/setting/change_password';

/**
 * [trim 去掉字符串前后两端的空格]
 */
function trim(str) {
    return str.replace(/(^\s*)|(\s*$)/g, "");
}

/**
 * 获取url上get的参数
 * @param name
 * @returns {null}
 */
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return r[2];
    return null;
}


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


function alipay_poundage(total) {
    total = parseFloat(total);
    poundage = 0;

    if (total >= 0 && total <= 60000) {
        poundage = total * 0.012;
    } else if (total > 60000 && total <= 500000) {
        poundage = 60000 * 0.012 + (total - 60000) * 0.01;
    } else if (total > 500000 && total <= 1000000) {
        poundage = 60000 * 0.012 + (500000 - 60000) * 0.01 + (total - 500000) * 0.009;
    } else if (total > 1000000 && total <= 2000000) {
        poundage = 60000 * 0.012 + (500000 - 60000) * 0.01 + (1000000 - 500000) * 0.009 + (total - 1000000) * 0.008;
    } else if (total > 2000000) {
        poundage = 60000 * 0.012 + (500000 - 60000) * 0.01 + (1000000 - 500000) * 0.009 + (2000000 - 1000000) * 0.008 + (total - 2000000) * 0.007;
    }

    return Math.ceil(poundage);
}


