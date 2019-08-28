<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu_index.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">管理站点</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<div class="col-md-12">
                    <div class="panel panel-default">
                    	<div class="panel-heading">
                            DataTables Tables
                        </div>
                    	<div class="panel-body">
                    		<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr class="success">
									<th>ID</th>
									<th>名称</th>
									<th>appid</th>
									<th>appsecret</th>
									<th>token</th>
									<th>通讯状态</th>
									<th>上次通讯时间</th>
									<th>创建用户</th>
									<th>用户组</th>
									<th>添加时间</th>
									<th>操作</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['site_id']?></td>
									<td><?php echo $item['name']?></td>
									<td><?php echo $item['appid']?></td>
									<td><?php echo $item['appsecret']?></td>
									<td><?php echo $item['token']?></td>
									<td><?php echo $item['connect_status']?></td>
									<td><?php echo $item['connect_last_time']?></td>
									<td class="center"><?php echo date('Y-m-d H:i:s', $item['create_time'])?></td>
									<td>
										<a href="/admin/index/select?site_id=<?php echo $item['site_id']?>">管理</a>
										<a href="/admin/site/edit?site_id=<?php echo $item['site_id']?>">编辑</a>
										<a href="/admin/site/del?site_id=<?php echo $item['site_id']?>">删除</a>
									</td>
									<td></td>
								</tr>
								<?php }?>
								<tr class="odd">
									<td colspan="12">
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
									<td colspan="12" class="center">暂无结果</td>
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