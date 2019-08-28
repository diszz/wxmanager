<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">微信用户管理
				<small>未认证只能看到用户OPENID, 已认证可看到用户全部资料</small></h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<div class="col-md-12">
                    <div class="panel panel-default">
                    	<div class="panel-heading"></div>
                    	<div class="panel-body">
                    		<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr class="success">
									<th>用户ID</th>
									<th>OPENID</th>
									<th>昵称</th>
									<th>性别</th>
									<th>城市</th>
									<th>省份</th>
									<th>国家</th>
									<th>头像</th>
									<th>关注时间</th>
									<th>唯一值</th>
									<th>码统计数</th>
									<th>签到统计数</th>
									<th>红包统计数</th>
									<th>创建时间</th>
									<th>操作</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['user_id']?></td>
									<td><?php echo $item['openid']?></td>
									<td><?php echo $item['nickname']?></td>
									<td><?php echo $item['sex']?></td>
									<td><?php echo $item['city']?></td>
									<td><?php echo $item['province']?></td>
									<td><?php echo $item['country']?></td>
									<td><?php echo $item['headimgurl']?></td>
									<td><?php echo $item['subscribe_time']?></td>
									<td><?php echo $item['unionid']?></td>
									<td><?php echo $item['attribute']['code_count']?></td>
									<td><?php echo $item['attribute']['signin_count']?></td>
									<td><?php echo $item['attribute']['redpack_count']?></td>
									<td class="center"><?php echo date('Y-m-d', $item['create_time'])?></td>
									<td>
										<a href="/admin/user/view?user_id=<?php echo $item['user_id']?>">查看</a>
										<a href="/admin/user/del?user_id=<?php echo $item['user_id']?>">删除</a>
									</td>
									<td></td>
								</tr>
								<?php }?>
								<tr class="odd">
									<td colspan="16">
										<ul class="pagination">
										<li class="disabled"><a href="#">显示 <?php echo $pagination['now'];?> 条</a></li>
										<li class="disabled"><a href="#">总共：<?php echo $pagination['total'];?> 条</a></li>
										</ul>
										<ul class="pagination">
										<?php echo $pagination['pages']?>
										</ul>
									</td>
								</tr>
								<?php }else{?>
								<tr class="odd ">
									<td colspan="16" class="center">暂无结果</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						
                        </div>
                    </div>
                    <!-- /.panel -->
                    
                </div>
        </div>
    </div>

<?php include APPPATH . "views/admin/_footer.php";?>