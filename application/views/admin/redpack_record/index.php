<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">红包记录列表</h1>
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
                    		<div class="col-md-9">
                    		<div class="form-group">
	                    		<a href="/admin/redpack_record/index/" class="btn <?php echo !$cur_redpack ? 'btn-danger' : ''?>">全部</a>
	                    		<?php foreach ($redpackList as $item){?>
	                    		<a href="/admin/redpack_record/index/<?php echo $item['redpack_id']?>/<?php echo $cur_status?>" class="btn <?php echo $cur_redpack == $item['redpack_id'] ? 'btn-danger' : ''?>"><?php echo $item['name']?></a>
	                    		<?php }?>
                    		</div>
                    		<div class="form-group">
                    			<a href="/admin/redpack_record/index/<?php echo $cur_redpack?>/0" class="btn <?php echo $cur_status == '0' ? 'btn-danger' : ''?>">正常状态</a>
                    			<a href="/admin/redpack_record/index/<?php echo $cur_redpack?>/1" class="btn <?php echo $cur_status == '1' ? 'btn-danger' : ''?>">异常状态</a>
                    		</div>
                    		</div>
                    		<div class="col-md-3">
                    		<div class="form-group">
	                    		<?php if (!$file){?>
								<a href="/admin/redpack_record/export_record?redpack_id=<?php echo $cur_redpack?>&status=<?php echo $cur_status?>" class="btn btn-primary" >把筛选的结果数据导出成excel文件</a>
	                    		<?php }elseif($file_exist){?>
	                    		<a href="<?php echo str_replace(ROOTPATH, '/', base64_decode_($file))?>" class="btn btn-success" target="_blank">下载excel文件</a>
	                    		<?php }else{?>
	                    		<a href="/admin/redpack_record/index/<?php echo $cur_redpack?>/<?php echo $cur_status?>?file=<?php echo $file?>&file_=<?php echo base64_decode_($file) ?>" class="btn btn-warning" >excel文件生成中, 点击刷新</a>
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
									<th width="5%">ID</th>
									<th width="15%">红包ID</th>
									<th width="15%">获得者</th>
									<th width="15%">金额</th>
									<th width="10%">支付号</th>
									<th width="7%">红包码</th>
									<th width="15%">时间</th>
									<?php if ($cur_status == 1){?>
									<th width="10%">错误号</th>
									<th width="10%">错误内容</th>
									<?php }?>
									<th width="15%">操作</th>
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['redpack_record_id']?></td>
									<td><?php echo $item['redpack_id'] ?></td>
									<td>
										<a href="/admin/user/view?user_id=<?php echo $item['user_info']['user_id']?>">
											<?php if (!empty($item['user_info']['headimgurl'])){?>
											<img src="<?php echo weixin_user_avatar($item['user_info']['headimgurl'])?>">
											<?php }?>
											<?php echo $item['user_info']['nickname']?>
										</a>
									</td>
									<td><?php echo $item['money']?></td>
									<td><?php echo $item['mch_billno']?></td>
									<td><?php echo !empty($item['redpack_code']) ? $item['redpack_code'] : ''?></td>
									<td class="center"><?php echo date('Y-m-d H:i:s', $item['create_time'])?></td>
									<?php if ($cur_status == 1){?>
									<td><?php echo !empty($item['errno']) ? $item['errno'] : ''?></td>
									<td><?php echo !empty($item['error']) ? $item['error'] : ''?></td>
									<?php }?>
									<td>
									</td>
									<td></td>
								</tr>
								<?php }?>
								<tr class="odd">
									<td colspan="10">
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
									<td colspan="10" class="center">暂无结果</td>
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