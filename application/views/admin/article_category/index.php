<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">文章分类</h1>
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
									<th width="5%">ID</th>
									<th width="20%">分类名称</th>
									<th width="5%">排序</th>
									<th width="30%">论坛资源</th>
									<th width="20%">时间</th>
									<th width="20%">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['category_id']?></td>
									<td><?php echo $item['name']?></td>
									<td><?php echo $item['sort']?></td>
									<td><?php echo !empty($item['bbs_source_url']) ? $item['bbs_source_url'] : ''?></td>
									<td class="center"><?php echo $item['create_time']?></td>
									<td>
										<?php if (!empty($item['bbs_source_url'])){?>
										<a href="/admin/article_category/source/<?php echo $item['category_id']?>">资源列表</a>
										<?php }?>
										<a href="/admin/article_category/edit?category_id=<?php echo $item['category_id']?>">编辑</a>
										<a href="/admin/article_category/del?category_id=<?php echo $item['category_id']?>">删除</a>
									</td>
								</tr>
								<?php }?>
								<tr class="odd">
									<td colspan="6">
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
									<td colspan="6" class="center">暂无结果</td>
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