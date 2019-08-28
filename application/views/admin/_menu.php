<?php $siteInfo = get_siteinfo();?>

		<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <?php include APPPATH . "views/admin/_navbar.php";?>
            

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu" style="padding-bottom: 30px">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="/admin/index"><i class="fa fa-dashboard fa-fw"></i> 面板</a>
                        </li>
                        <li>
                            <a href="/admin/index/site"><i class="fa fa-dashboard fa-fw"></i> 站点首页</a>
                        </li>
                        <li class="list-group-item disabled"></li>
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> 关键词管理(智能机器人)</a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/keyword/index">关键词列表</a>
                                </li>
                                <li>
                                    <a href="/admin/keyword/add">添加关键词</a>
                                </li>
                                <li>
                                    <a href="/admin/keyword/import">导入词库</a>
                                </li>
                                <li>
                                    <a href="/admin/keyword/clean">清空词库</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                            	<i class="fa fa-dashboard fa-fw"></i> 素材管理
	                            <?php if ($siteInfo['verify']){?>
	                            <span class="label label-success" title="已认证,功能可用">认证</span>
	                            <?php }else{?>
	                            <span class="label label-danger" title="未认证,功能不可用">认证</span>
	                            <?php }?>
                            </a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="#/admin/sendToAll/index">列表</a>
                                </li>
                                <li>
                                    <a href="#/admin/sendToAll/add">添加</a>
                                </li>
                            </ul>
                        </li>
                        <!--  必须通过微信认证 -->
                        <li>
                            <a href="#">
                            	<i class="fa fa-dashboard fa-fw"></i> 群发管理
	                            <?php if ($siteInfo['verify']){?>
	                            <span class="label label-success" title="已认证,功能可用">认证</span>
	                            <?php }else{?>
	                            <span class="label label-danger" title="未认证,功能不可用">认证</span>
	                            <?php }?>
                            </a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="#/admin/sendToAll/index">列表</a>
                                </li>
                                <li>
                                    <a href="#/admin/sendToAll/add">添加</a>
                                </li>
                            </ul>
                        </li>
                        
                        <!--  订阅号必须通过微信认证, 服务号自动获得 -->
                        <li class="list-group-item disabled"></li>
                        <li>
                            <a href="#">
                            	<i class="fa fa-dashboard fa-fw"></i> 菜单管理
                            	<?php if ($siteInfo['type'] || $siteInfo['verify']){?>
	                            <span class="label label-success" title="服务号或已认证,功能可用">服务|认证</span>
	                            <?php }else{?>
	                            <span class="label label-danger" title="非服务号且未认证,功能不可用">服务|认证</span>
	                            <?php }?>
                            </a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/menu/index">列表</a>
                                </li>
                                <li>
                                    <a href="/admin/menu/add">添加</a>
                                </li>
                                <li>
                                    <a href="/admin/menu/online">同步</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="list-group-item disabled"></li>
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> 文章分类管理</a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/article_category/index">列表</a>
                                </li>
                                <li>
                                    <a href="/admin/article_category/add">添加</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> 文章管理</a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/article/index">列表</a>
                                </li>
                                <li>
                                    <a href="/admin/article/add">添加</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="list-group-item disabled"></li>
                        <li>
                            <a href="#">
                            	<i class="fa fa-dashboard fa-fw"></i> 红包管理
                            	<?php if ($siteInfo['type'] && $siteInfo['verify'] && $siteInfo['pay_status']){?>
	                            <span class="label label-success" title="服务号且已认证,功能可用">服务&认证</span>
	                            <?php }else{?>
	                            <span class="label label-danger" title="非服务号或未认证,功能不可用">服务&认证</span>
	                            <?php }?>
                            </a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/redpack/index">列表</a>
                                </li>
                                <li>
                                    <a href="/admin/redpack/add">添加</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                            	<i class="fa fa-dashboard fa-fw"></i> 红包码管理
                            </a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/redpack_code/index">列表</a>
                                </li>
                                <li>
                                    <a href="/admin/redpack_code/add">添加</a>
                                </li>
                                <li>
                                    <a href="/admin/redpack_code/import">导入</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/admin/redpack_record/">
                            	<i class="fa fa-dashboard fa-fw"></i> 红包记录列表
                            </a>
                        </li>
                        
                        <li class="list-group-item disabled"></li>
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> 礼包管理</a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/code/index">列表</a>
                                </li>
                                <li>
                                    <a href="/admin/code/add">添加</a>
                                </li>
                                <li>
                                    <a href="/admin/code/make">生成</a>
                                </li>
                                <li>
                                    <a href="/admin/code/import">导入</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> 礼包码管理</a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/code_item/index">列表</a>
                                </li>
                                <li>
                                    <a href="/admin/code_item/add">添加</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="list-group-item disabled"></li>
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> 签到管理</a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/signin/index">列表</a>
                                </li>
                                <li>
                                    <a href="/admin/signin/add">添加</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                        	<a href="/admin/signin_user"><i class="fa fa-dashboard fa-fw"></i> 签到用户管理</a>
                        </li>
                        <li>
                        	<a href="/admin/signin_record"><i class="fa fa-dashboard fa-fw"></i> 签到记录管理</a>
                        </li>
                        
                        <li class="list-group-item disabled"></li>
                        <li>
                            <a href="/admin/user/">
                            	<i class="fa fa-dashboard fa-fw"></i> 微信用户管理
                            </a>
                        </li>
                        <li class="list-group-item disabled"></li>
                        <li>
                            <a href="/admin/client_record/">
                            	<i class="fa fa-dashboard fa-fw"></i> 公众号交互记录
                            </a>
                        </li>
                        
                        <!-- 
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> 抽奖管理</a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="/admin/lottery/index">列表</a>
                                </li>
                                <li>
                                    <a href="/admin/lottery/add">添加</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                        	<a href="/admin/lottery_user"><i class="fa fa-dashboard fa-fw"></i> 抽奖用户管理</a>
                        </li>
                        <li>
                        	<a href="/admin/lottery_record"><i class="fa fa-dashboard fa-fw"></i> 抽奖记录管理</a>
                        </li>
                        <li class="list-group-item disabled"></li>
                         -->
                        <!-- 
                        <li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="icons.html"> Icons</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                        </li>
                         -->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>