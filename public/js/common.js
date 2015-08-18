
var BASE_URL = document.getElementById('BASE_URL').value;
var GET_ARTICLE_URL = BASE_URL + "article/main/get_article_list";
var COMMENT_URL = BASE_URL + 'article/detail/write_comment';
var VOTE_URL = BASE_URL + 'article/detail/get_vote_list';
var ARGEE_URL = BASE_URL + 'article/detail/vote_article';
var DELETE_URL = BASE_URL + 'article/detail/delete_article';
var LOGIN_URL = BASE_URL + 'login';

/**
 * [trim 去掉字符串前后两端的空格]
 */
function trim(str)
{
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
