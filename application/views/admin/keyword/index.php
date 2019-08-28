<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">关联词管理</h1>
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
									<th width="5%">ID</th>
									<th width="10%">关键词名称</th>
									<th width="35%">回复内容</th>
									<th width="5%">类型</th>
									<th width="10%">挂载对象</th>
									<th width="5%">挂载对象ID</th>
									<th width="5%">排序</th>
									<th width="10%">添加时间</th>
									<th width="10%">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['keyword_id']?></td>
									<td><?php echo $item['name']?></td>
									<td><?php echo $item['content']?></td>
									<td><?php echo $item['type']?></td>
									<td><?php echo isset($objectArr[$item['object']]) ? $objectArr[$item['object']] : ''?></td>
									<td><?php echo isset($item['object_id']) ? $item['object_id'] : ''?></td>
									<td><?php echo $item['sort']?></td>
									<td class="center"><?php echo $item['create_time']?></td>
									<td>
										<a href="/admin/keyword/edit?keyword_id=<?php echo $item['keyword_id']?>">编辑</a>
										<a href="/admin/keyword/del?keyword_id=<?php echo $item['keyword_id']?>">删除</a>
									</td>
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