<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">签到管理
				<small>用户可通过点击自定义菜单或输入关键词进行使用, 需关联关键词</small></h1>
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
									<th width="20">ID</th>
									<th width="60">名称</th>
									<th width="100">是否连续</th>
									<th width="100">是否循环</th>
									<th width="100">是否发礼包</th>
									<th width="100">子项数</th>
									<th width="100">创建时间</th>
									<th width="100">操作</th>
									<th width="5"></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['signin_id']?></td>
									<td><?php echo $item['name']?></td>
									<td><?php echo $item['is_continue']?></td>
									<td><?php echo $item['is_loop']?></td>
									<td><?php echo $item['has_code']?></td>
									<td><?php echo $item['item_count']?></td>
									<td class="center"><?php echo date('Y-m-d H:i:s', $item['create_time'])?></td>
									<td>
										<a href="/admin/signin/edit?signin_id=<?php echo $item['signin_id']?>" class="btn">编辑</a>
										<a href="/admin/signin/del?signin_id=<?php echo $item['signin_id']?>" class="btn">删除</a>
									</td>
									<td></td>
								</tr>
								<?php }?>
								<tr class="odd">
									<td colspan="9">
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
									<td colspan="9" class="center">暂无结果</td>
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