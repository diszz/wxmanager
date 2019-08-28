<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">论坛资源列表</h1>
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
									<th width="50">ID</th>
									<th width="200">图片</th>
									<th width="100">作者名称</th>
									<th width="150">链接</th>
									<th width="150">标题</th>
									<th width="200">描述</th>
									<th width="150">操作</th>
									<th width="5"></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['post_id']?></td>
									<td><?php echo $item['icon'] ? '<img src="'.$item['icon'].'" width="150"/>' : ''?></td>
									<td><a href="<?php echo $item['url']?>" target="_blank"><?php echo $item['title']?></a></td>
									<td><a href="<?php echo $item['author_url']?>" target="_blank"><?php echo $item['author']?></a></td>
									<td><?php echo $item['title']?></td>
									<td><?php echo $item['desc']?></td>
									<td>
										<?php if ($item['is_import']){?>
										已收录
										<?php }else{?>
										<a href="/admin/article_category/addpost?post_id=<?php echo $item['post_id']?>&category_id=<?php echo $category_id?>&offset=<?php echo $pagination['offset']?>" class="btn">收录</a>
										<?php }?>
									</td>
									<td></td>
								</tr>
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
									<td colspan="8" class="center">暂无结果</td>
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