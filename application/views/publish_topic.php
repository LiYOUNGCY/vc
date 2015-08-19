<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <div class="container">
        <div class="content edit">
            <form class="list" method="post" action="<?= base_url() ?>artist/publish/publish_artist">
                <div class="item">
                    <label for="title">专题标题：</label>
                    <input id="title" type="text">
                </div>
                <div class="item">
                    <label for="introduction">专题导语：</label>
                    <textarea id="introduction" rows="5"></textarea>
                </div>
                <div class="item">
                    <h3>作品列表</h3>
                </div>
                <div class="item">
                    <div class="production">
                        <div class="group">
                            <i class="fa fa-trash-o fa-fw" title="删除"></i>
                            <i class="fa fa-angle-up" title="上移"></i>
                            <i class="fa fa-angle-down" title="下移"></i>
                        </div>
                        <div class="item">
                            <label for="">作品标题：</label>
                            <input type="text">
                        </div>
                        <div class="item">

                            <label>作品的介绍语：</label>
                            <textarea rows="5"></textarea>
                        </div>
                        <div class="image">
                            <img src="<?= base_url() ?>public/img/nrjpinzl4.jpg-w720.jpg">
                        </div>

                    </div>
                </div>

                <div class="item" style="text-align: center">
                    <i id="show_list" class="fa fa-plus"></i>
                </div>
                <div class="options">
                    <div class="btn preview">预览</div>
                    <div class="btn cancel">取消</div>
                    <div id="save" class="btn save">保存</div>
                </div>
            </form>


            <div id="production" class="production_list hidden">

                <div class="list">
                    <i id="close" class="fa fa-close" style="font-size: 24px; float:right; cursor: pointer;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $(function () {
        $('#show_list').click(function () {
            $('#production').removeClass('hidden');
        });

        $('#close').click(function () {
            $('#production').addClass('hidden');
        });
    });
</script>
</html>