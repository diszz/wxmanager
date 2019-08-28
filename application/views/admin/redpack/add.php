<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">添加红包活动</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<form role="form" method="post" action="" class="form">
        	<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">填写表单</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label" for="name"><i class="required">*</i>名称</label>
								<input class="form-control" id="name" name="name" value="<?php echo $olddata ? $olddata['name'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="key">小组KEY(选填)</label>
								<input class="form-control" id="key" name="key" value="<?php echo $olddata ? $olddata['key'] : ''?>" />
								<p class="help-block">同一小组只能得到一个红包码</p>
							</div>
							<div class="form-group">
								<label class="control-label" for="total_people"><i class="required">*</i>发放总人数</label>
								<input class="form-control" id="total_people" name="total_people" value="<?php echo $olddata ? $olddata['total_people'] : '75'?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="total_money"><i class="required">*</i>总金额, 单位分</label>
								<input class="form-control" id="total_money" name="total_money" value="<?php echo $olddata ? $olddata['total_money'] : '10000'?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="min_value"><i class="required">*</i>最小红包金额, 单位分</label>
								<input class="form-control" id="min_value" name="min_value" value="<?php echo $olddata ? $olddata['min_value'] : '100'?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="max_value"><i class="required">*</i>最大红包金额, 单位分</label>
								<input class="form-control" id="max_value" name="max_value" value="<?php echo $olddata ? $olddata['max_value'] : '200'?>" />
							</div>
							<div class="form-group">
								<label class="control-label"><i class="required">*</i>活动开始时间</label>
								<input class="form-control" placeholder="请选择开始时间" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="start_time" name="start_time" value="<?php echo !empty($olddata['start_time']) ? $olddata['start_time'] : date('Y-m-d H:i:s', strtotime(date('Y-m-d')))?>">
							</div>
							<div class="form-group">
								<label class="control-label"><i class="required">*</i>活动结束时间</label>
								<input class="form-control" placeholder="请选择结束时间" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="end_time" name="end_time" value="<?php echo !empty($olddata['end_time']) ? $olddata['end_time'] : date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime('+1 day'))))?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="send_type"><i class="required">*</i>发放方式</label>
								<select name="send_type" id="send_type" class="form-control">
									<option value="0" >本渠道发放</option>
									<option value="1" >其他渠道发放</option>
								</select>
								<p class="help-block">本渠道发放, 微信号执行发放和领取操作. 其他渠道发放, 微信号只执行领取操作</p>
							</div>
							<div class="form-group">
								<label class="control-label" for="status"><i class="required">*</i>状态</label>
								<select name="status" id="status" class="form-control">
									<?php foreach (getStatusArr() as $k => $v){?>
									<option value="<?php echo $k?>" <?php echo !empty($olddata) && $olddata['status'] == $k ? 'selected' : '' ?>><?php echo $v?></option>
									<?php }?>
								</select>
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
								<input class="form-control" id="send_name" name="send_name" value="<?php echo $olddata ? $olddata['send_name'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="wishing"><i class="required">*</i>红包祝福语</label>
								<input class="form-control" id="wishing" name="wishing" value="<?php echo $olddata ? $olddata['wishing'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="remark"><i class="required">*</i>备注信息</label>
								<input class="form-control" id="remark" name="remark" value="<?php echo $olddata ? $olddata['remark'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="logo_imgurl"><i class="required">*</i>商户logo的url</label>
								<input class="form-control" id="logo_imgurl" name="logo_imgurl" value="<?php echo $olddata ? $olddata['logo_imgurl'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="send_money">已送出总额, 单位分</label>
								<input class="form-control" id="send_money" name="send_money" value="<?php echo $olddata ? $olddata['send_money'] : '0'?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="send_people">已送出总人数</label>
								<input class="form-control" id="send_people" name="send_people" value="<?php echo $olddata ? $olddata['send_people'] : '0'?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="fetch_money">兑换金额</label>
								<input class="form-control" id="fetch_money" name="fetch_money" value="<?php echo $olddata ? $olddata['fetch_money'] : '0'?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="fetch_people">兑换人数</label>
								<input class="form-control" id="fetch_people" name="fetch_people" value="<?php echo $olddata ? $olddata['fetch_people'] : '0'?>" />
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div class="col-md-8">
								<button type="submit" class="btn btn-default">提交表单</button>
								<button type="reset" class="btn btn-default">Reset Button</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
        </div>
    </div>
    
<script type="text/javascript" src="/resource/admin/sb-admin/bower_components/jquery/src/datepicker/WdatePicker.js"></script>
<?php include APPPATH . "views/admin/_footer.php";?>