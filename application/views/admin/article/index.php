<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">文章管理
				<small>用户可通过点击自定义菜单或输入关键词进行使用, 需关联关键词</small>
				</h1>
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
                    		<a href="/admin/article/index/" class="btn <?php echo !$category_id ? 'btn-danger' : ''?>">全部</a>
                    		<?php if($categoryList){foreach ($categoryList as $item){?>
                    		<a href="/admin/article/index/<?php echo $item['category_id']?>" class="btn <?php echo $category_id == $item['category_id'] ? 'btn-danger' : ''?>"><?php echo $item['name']?></a>
                    		<?php }}?>
                    	</div>
                    	<div class="panel-heading"></div>
                    	<div class="panel-body">
                    		<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr class="success">
									<th width="5%">ID</th>
									<th width="15%">图片</th>
									<th width="15%">标题</th>
									<th width="10%">作者</th>
									<th width="15%">描述</th>
									<th width="5%">排序</th>
									<th width="5%">阅读量</th>
									<th width="5%">评论量</th>
									<th width="5%">点赞量</th>
									<th width="10%">时间</th>
									<th width="10%">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['article_id']?></td>
									<td><?php echo $item['icon'] ? '<img src="'.$item['icon'].'" width="150"/>' : ''?></td>
									<td><a href="<?php echo $item['url']?>" target="_blank"><?php echo $item['title']?></a></td>
									<td><?php echo $item['author']?></td>
									<td><?php echo $item['desc']?></td>
									<td><?php echo $item['sort']?></td>
									<td><?php echo !empty($item['view_count']) ? $item['view_count'] : 0?></td>
									<td><?php echo !empty($item['comment_count']) ? $item['comment_count'] : 0?></td>
									<td><?php echo !empty($item['favorite_count']) ? $item['favorite_count'] : 0?></td>
									<td class="center"><?php echo $item['create_time']?></td>
									<td>
										<a href="<?php echo $item['url']?>" target="_blank">访问</a>
										<a href="/admin/article/edit?article_id=<?php echo $item['article_id']?>">编辑</a>
										<a href="/admin/article/del?article_id=<?php echo $item['article_id']?>">删除</a>
									</td>
								</tr>
								<?php }?>
								<tr class="odd">
									<td colspan="11">
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
									<td colspan="11" class="center">暂无结果</td>
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