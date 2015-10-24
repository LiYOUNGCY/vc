<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=base_url()?>">Artvc主页</a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <?= $user['name'] ?>
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>

            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?= base_url() ?>"><i class="fa fa-user fa-fw"></i>返回首页</a>
                </li>
                <li><a href="<?= base_url() ?>setting"><i class="fa fa-gear fa-fw"></i>个人设置</a>
                </li>
                <li class="divider"></li>
                <li><a href="<?= base_url().ADMINROUTE ?>main/logout" id="logout"><i class="fa fa-sign-out fa-fw"></i>注销</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <!--弹出提示层-->
    <div id="alert_group">
        <div class="alert alert-success alert-dismissable" style="position:fixed;z-index:999;width:100%;display:none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
        <div class="alert alert-danger alert-dismissable" style="position:fixed;z-index:999;width:100%;display:none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

        </div>
    </div>
    <!-- /弹出提示层-->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li style="display:none;">
                    <a href="index.html"><i class="fa fa-dashboard fa-fw"></i>基本信息</a>
                </li>
                <li>
                    <a href="#">用户管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>user/u">信息管理</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>user/a">权限管理</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>user/index/r">用户组管理</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#">文章管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>article">文章管理</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>article/index/article_tag">标签管理</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#">专题管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>topic">专题管理</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>topic/who">送礼的标签</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>topic/where">装修的标签</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>topic/when">收藏的标签</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="<?= base_url().ADMINROUTE ?>artist">艺术家管理</a>
                </li>

                <li>
                    <a href="#">艺术品管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>production/p">艺术品</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>production/frame">裱</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>production/medium">题材</a>
                        </li>
                        <li style="display:none;">
                            <a href="<?= base_url().ADMINROUTE ?>production/categories">种类</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>production/style">风格</a>
                        </li>
                        <li>
                            <a href="<?= base_url().ADMINROUTE ?>production/price">价格分类</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="<?= base_url().ADMINROUTE ?>slider">轮播管理</a>
                </li>
                <li style="display:none;">
                    <a href="#"><i class="fa fa-sitemap fa-fw"></i>网站设置<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#">信息设置</a>
                        </li>
                        <li>
                            <a href="#">反馈</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="<?= base_url().ADMINROUTE ?>Customer">在线客服</a>
                    <!-- /.nav-second-level -->
                </li>
                <li style="display:none;">
                    <a href="#"><i class="fa fa-files-o fa-fw"></i>数据统计<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="active" href="blank.html">1</a>
                        </li>
                        <li>
                            <a href="login.html">2</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
