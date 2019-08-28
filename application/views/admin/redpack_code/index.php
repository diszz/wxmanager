<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">应用管理</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<div class="col-md-12">
                    <div class="panel panel-default">
                    	<div class="panel-heading">选择红包活动</div>
                    	<div class="panel-body">
                    		<div class="row">
                    		<div class="col-md-6">
                    		<div class="form-group">
	                    		<a href="/admin/redpack_code/index/" class="btn <?php echo !$cur_redpack ? 'btn-danger' : ''?>">全部</a>
	                    		<?php foreach ($redpackList as $item){?>
	                    		<a href="/admin/redpack_code/index/<?php echo $item['redpack_id']?>/<?php echo $cur_type?>" class="btn <?php echo $cur_redpack == $item['redpack_id'] ? 'btn-danger' : ''?>"><?php echo $item['name']?></a>
	                    		<?php }?>
                    		</div>
                    		<div class="form-group">
                    			<a href="/admin/redpack_code/index/<?php echo $cur_redpack?>/0" class="btn <?php echo $cur_type == '0' ? 'btn-danger' : ''?>">未送出</a>
                    			<a href="/admin/redpack_code/index/<?php echo $cur_redpack?>/1" class="btn <?php echo $cur_type == '1' ? 'btn-danger' : ''?>">已送出</a>
                    		</div>
                    		</div>
                    		<div class="col-md-6">
                    		<div class="form-group">
	                    		<?php if (!$file){?>
								<a href="/admin/redpack1/export_code?redpack_id=<?php echo $cur_redpack?>&type=<?php echo $cur_type?>" class="btn btn-primary" >把筛选的结果数据导出成excel文件</a>
	                    		<?php }elseif($file_exist){?>
	                    		<a href="<?php echo str_replace(ROOTPATH, '/', $file)?>" class="btn btn-success" target="_blank">下载excel文件</a>
	                    		<?php }else{?>
	                    		<a href="/admin/redpack_code/index/<?php echo $cur_redpack?>/<?php echo $cur_type?>?file=<?php echo base64_encode_($file)?>" class="btn btn-warning" >excel文件生成中, 点击刷新</a>
	                    		<?php }?>
                    		</div>
                    		</div>
                    	</div>
                    	<div class="panel-heading">
                            DataTables Tables
                        </div>
                    	<div class="panel-body">
                    		<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr class="success">
									<th width="20">ID</th>
									<th width="60">活动ID</th>
									<th width="100">活动码</th>
									<th width="100">金额(单位分)</th>
									<th width="100">状态</th>
									<th width="100">添加时间</th>
									<th width="100">操作</th>
									<th width="5"></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['redpack_code_id']?></td>
									<td><?php echo $item['redpack_id']?></td>
									<td><?php echo $item['content']?></td>
									<td><?php echo $item['money']?></td>
									<td><?php echo $item['status']?></td>
									<td class="center"><?php echo date('Y-m-d H:i:s', $item['create_time'])?></td>
									<td>
										<a href="/admin/redpack_code/edit?redpack_code_id=<?php echo $item['redpack_code_id']?>" class="btn">编辑</a>
										<a href="/admin/redpack_code/del?redpack_code_id=<?php echo $item['redpack_code_id']?>" class="btn">删除</a>
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