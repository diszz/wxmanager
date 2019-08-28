<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">菜单管理</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<div class="col-md-12">
                    <div class="panel panel-default">
                    	<div class="panel-heading">若正式生效, 请执行"同步"; 功能使用条件:订阅号必须通过微信认证, 服务号自动获得</div>
                    	<div class="panel-body">
                    		<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr class="success">
									<th>ID</th>
									<th>名称</th>
									<th>类型</th>
									<th>内容</th>
									<th>排序</th>
									<th>添加时间</th>
									<th>操作</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td rowspan="<?php echo !empty($item['children']) ? 2 : 1?>"><?php echo $item['menu_id']?></td>
									<td><?php echo $item['name']?></td>
									<td><?php echo $item['type']?></td>
									<td><?php echo $item['content']?></td>
									<td><?php echo $item['sort']?></td>
									<td class="center"><?php echo date('Y-m-d H:i:s', $item['create_time'])?></td>
									<td>
										<a href="/admin/menu/edit?menu_id=<?php echo $item['menu_id']?>">编辑</a>
										<a href="/admin/menu/del?menu_id=<?php echo $item['menu_id']?>">删除</a>
									</td>
									<td></td>
								</tr>
								
								<?php if (!empty($item['children'])){?>
								<tr class="odd ">
									<td colspan="6">
										<table class="table table-striped table-bordered table-hover">
										<thead>
											<tr class="success">
												<th>ID</th>
												<th>名称</th>
												<th>类型</th>
												<th>内容</th>
												<th>排序</th>
												<th>添加时间</th>
												<th>操作</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
										<?php foreach ($item['children'] as $item_){?>
										<tr class="odd ">
											<td><?php echo $item_['menu_id']?></td>
											<td><?php echo $item_['name']?></td>
											<td><?php echo $item_['type']?></td>
											<td><?php echo $item_['content']?></td>
											<td><?php echo $item_['sort']?></td>
											<td class="center"><?php echo date('Y-m-d H:i:s', $item_['create_time'])?></td>
											<td>
												<a href="/admin/menu/edit?menu_id=<?php echo $item_['menu_id']?>">编辑</a>
												<a href="/admin/menu/del?menu_id=<?php echo $item_['menu_id']?>">删除</a>
											</td>
											<td></td>
										</tr>
										<?php }?>
										</tbody>
										</table>
									</td>
									<td></td>
								</tr>
								<?php }?>
								<?php }?>
								<tr class="odd">
									<td colspan="8">
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