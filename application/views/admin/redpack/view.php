<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑红包活动</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<form role="form" method="post" action="" class="form" enctype="multipart/form-data">
        	<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">填写表单</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label" for="name"><i class="required">*</i>名称</label>
								<p class="help-block"><?php echo $info ? $info['name'] : ''?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="key">小组KEY(选填)</label>
								<p class="help-block"><?php echo !empty($info['key']) ? $info['key'] : ''?></p>
								<p class="help-block">同一小组只能得到一个红包码</p>
							</div>
							<div class="form-group">
								<label class="control-label" for="total_people"><i class="required">*</i>发放总人数</label>
								<p class="help-block"><?php echo $info ? $info['total_people'] : ''?></p>
								<span class="help-block"></span>
							</div>
							<div class="form-group">
								<label class="control-label" for="total_money"><i class="required">*</i>总金额, 单位分</label>
								<p class="help-block"><?php echo $info ? $info['total_money'] : ''?></p>
								<span class="help-block"></span>
							</div>
							<div class="form-group">
								<label class="control-label" for="min_value"><i class="required">*</i>最小红包金额, 单位分</label>
								<p class="help-block"><?php echo $info ? $info['min_value'] : ''?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="max_value"><i class="required">*</i>最大红包金额, 单位分</label>
								<p class="help-block"><?php echo $info ? $info['max_value'] : ''?></p>
							</div>
							<div class="form-group">
								<label class="control-label"><i class="required">*</i>活动开始时间</label>
								<p class="help-block"><?php echo !empty($info['start_time']) ? date('Y-m-d H:i:s', $info['start_time']) : date('Y-m-d H:i:s')?></p>
							</div>
							<div class="form-group">
								<label class="control-label"><i class="required">*</i>活动结束时间</label>
								<p class="help-block"><?php echo !empty($info['end_time']) ? date('Y-m-d H:i:s', $info['end_time']) : date('Y-m-d H:i:s')?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="send_type"><i class="required">*</i>发放方式</label>
								<p class="help-block"><?php echo !$info['send_type'] ? '本渠道发放' : '其他渠道发放'?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="status"><i class="required">*</i>状态</label>
								<p class="help-block"><?php echo getStatusVal($info['status'])?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">填写表单</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label" for="send_name"><i class="required">*</i>红包发送者</label>
								<p class="help-block"><?php echo $info ? $info['send_name'] : ''?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="wishing"><i class="required">*</i>红包祝福语</label>
								<p class="help-block"><?php echo $info ? $info['wishing'] : ''?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="remark"><i class="required">*</i>备注信息</label>
								<p class="help-block"><?php echo $info ? $info['remark'] : ''?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="logo_imgurl"><i class="required">*</i>商户logo的url</label>
								<p class="help-block"><img src="<?php echo $info['logo_imgurl']?>" width="80"></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="send_money">已送出总额, 单位分</label>
								<p class="help-block"><?php echo $info ? $info['send_money'] : '0'?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="send_people">已送出总人数</label>
								<p class="help-block"><?php echo $info ? $info['send_people'] : '0'?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="fetch_money">领取金额</label>
								<p class="help-block"><?php echo $info ? $info['fetch_money'] : '0'?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="fetch_people">领取人数</label>
								<p class="help-block"><?php echo $info ? $info['fetch_people'] : '0'?></p>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			
			</form>
        </div>
    </div>

    
<?php include APPPATH . "views/admin/_footer.php";?>