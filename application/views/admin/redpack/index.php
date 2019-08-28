<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">红包活动管理</h1>
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
									<th width="10%">红包活动名称</th>
									<th width="5%">小组KEY</th>
									<th width="10%">发送者</th>
									<th width="10%">最小/最大金额</th>
									<th width="10%">资金</th>
									<th width="10%">用户人数</th>
									<th width="10%">开始/结束时间</th>
									<th width="15%">操作</th>
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($list){foreach ($list as $item){?>
								<tr class="odd ">
									<td><?php echo $item['name']?><br /><?php echo $item['redpack_id']?></td>
									<td><?php echo !empty($item['key']) ? $item['key'] : ''?></td>
									<td><?php echo $item['send_name']?><br/><?php if ($item['logo_imgurl']){?><img src="<?php echo $item['logo_imgurl']?>" width="60"><?php }?></td>
									<td>
										最小额:<?php echo $item['min_value']?><br>
										最大额:<?php echo $item['max_value']?>
									</td>
									<td>
										领取额:<?php echo $item['fetch_money']?><br>
										已发额:<?php echo $item['send_money']?><br>
										<span class="label label-warning">生成额:<?php echo $item['make_money']?></span><br>
										设置额:<?php echo $item['total_money']?>
									</td>
									<td>
										领取数:<?php echo $item['fetch_people']?><br>
										已发数:<?php echo $item['send_people']?><br>
										<span class="label label-warning">生成数:<?php echo $item['make_code']?></span><br>
										设置数:<?php echo $item['total_people']?>
									</td>
									<td><?php echo date('Y-m-d H:i:s', $item['start_time'])?><br /><?php echo date('Y-m-d H:i:s', $item['end_time'])?></td>
									<td>
										<a href="/admin/redpack/view?redpack_id=<?php echo $item['redpack_id']?>" class="btn">查看</a>
										<?php if (empty($item['make_money'])){?>
										<a href="/admin/redpack/edit?redpack_id=<?php echo $item['redpack_id']?>" class="btn">编辑</a>
										<a href="/admin/redpack/make_code?redpack_id=<?php echo $item['redpack_id']?>" class="btn">生成码</a>
										<a href="/admin/redpack/del?redpack_id=<?php echo $item['redpack_id']?>" class="btn">删除</a>
										<?php }else{?>
										<a href="/admin/redpack_code/index/<?php echo $item['redpack_id']?>" class="btn">导出</a>
										<a href="/admin/redpack/clean_code?redpack_id=<?php echo $item['redpack_id']?>" class="btn">清空码</a>
										<?php }?>
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