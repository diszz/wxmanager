<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">签到用户管理</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<div class="col-md-12">
                    <div class="panel panel-default">
                    	<div class="panel-heading">选择签到</div>
                    	<div class="panel-body">
                    		<div class="row">
                    		<div class="col-md-6">
                    		<div class="form-group">
	                    		<a href="/admin/signin_record/index/" class="btn <?php echo !$cur_signin ? 'btn-danger' : ''?>">全部</a>
	                    		<?php foreach ($signinList as $item){?>
	                    		<a href="/admin/signin_record/index/<?php echo $item['signin_id']?>" class="btn <?php echo $cur_signin == $item['signin_id'] ? 'btn-danger' : ''?>"><?php echo $item['name']?></a>
	                    		<?php }?>
                    		</div>
                    		</div>
                    		<div class="col-md-6">
                    		<div class="form-group">
	                    		<?php if (!$file){?>
								<a href="/admin/signin_record/export_code?code_id=<?php echo $cur_signin?>" class="btn btn-primary" >把筛选的结果数据导出成excel文件</a>
	                    		<?php }elseif($file_exist){?>
	                    		<a href="<?php echo str_replace(ROOTPATH, '/', $file)?>" class="btn btn-success" target="_blank">下载excel文件</a>
	                    		<?php }else{?>
	                    		<a href="/admin/signin_record/index/<?php echo $cur_signin?>?file=<?php echo base64_encode_($file)?>" class="btn btn-warning" >excel文件生成中, 点击刷新</a>
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
									<th width="60">礼包ID</th>
									<th width="100">获得者</th>
									<th width="100">获得奖励id</th>
									<th width="100">标注</th>
									<th width="100">奖励发放结果</th>
									<th width="100">奖励发放原因</th>
									<th width="100">添加时间</th>
									<th width="100">操作</th>
									<th width="5"></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['signin_record_id']?></td>
									<td><?php echo $item['signin_id']?></td>
									<td><?php echo $item['openid']?></td>
									<td><?php echo $item['code_id']?></td>
									<td><?php echo $item['message']?></td>
									<td><?php echo isset($item['code_send_result']) ? $item['code_send_result'] : ''?></td>
									<td><?php echo isset($item['code_send_reason']) ? $item['code_send_reason'] : ''?></td>
									<td class="center"><?php echo date('Y-m-d H:i:s', $item['create_time'])?></td>
									<td>
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