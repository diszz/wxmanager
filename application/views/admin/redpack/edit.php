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
								<input class="form-control" id="name" name="name" value="<?php echo $info ? $info['name'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="key">小组KEY(选填)</label>
								<input class="form-control" id="key" name="key" value="<?php echo !empty($info['key']) ? $info['key'] : ''?>" />
								<p class="help-block">同一小组只能得到一个红包码</p>
							</div>
							<div class="form-group">
								<label class="control-label" for="total_people"><i class="required">*</i>发放总人数</label>
								<input class="form-control" id="total_people" name="total_people" value="<?php echo $info ? $info['total_people'] : ''?>" />
								<span class="help-block"></span>
							</div>
							<div class="form-group">
								<label class="control-label" for="total_money"><i class="required">*</i>总金额, 单位分</label>
								<input class="form-control" id="total_money" name="total_money" value="<?php echo $info ? $info['total_money'] : ''?>" />
								<span class="help-block"></span>
							</div>
							<div class="form-group">
								<label class="control-label" for="min_value"><i class="required">*</i>最小红包金额, 单位分</label>
								<input class="form-control" id="min_value" name="min_value" value="<?php echo $info ? $info['min_value'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="max_value"><i class="required">*</i>最大红包金额, 单位分</label>
								<input class="form-control" id="max_value" name="max_value" value="<?php echo $info ? $info['max_value'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label"><i class="required">*</i>活动开始时间</label>
								<input class="form-control" placeholder="请选择开始时间" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="start_time" name="start_time" value="<?php echo !empty($info['start_time']) ? date('Y-m-d H:i:s', $info['start_time']) : date('Y-m-d H:i:s')?>">
							</div>
							<div class="form-group">
								<label class="control-label"><i class="required">*</i>活动结束时间</label>
								<input class="form-control" placeholder="请选择结束时间" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="end_time" name="end_time" value="<?php echo !empty($info['end_time']) ? date('Y-m-d H:i:s', $info['end_time']) : date('Y-m-d H:i:s')?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="send_type"><i class="required">*</i>发放方式</label>
								<select name="send_type" id="send_type" class="form-control">
									<option value="0" <?php echo !$info['send_type'] ? 'selected' : ''?>>本渠道发放</option>
									<option value="1" <?php echo $info['send_type'] ? 'selected' : ''?>>其他渠道发放</option>
								</select>
								<p class="help-block">本渠道发放, 微信号执行发放和领取操作. 其他渠道发放, 微信号只执行领取操作</p>
							</div>
							<div class="form-group">
								<label class="control-label" for="status"><i class="required">*</i>状态</label>
								<select name="status" id="status" class="form-control">
									<?php foreach (getStatusArr() as $k => $v){?>
									<option value="<?php echo $k?>" <?php echo !empty($info) && $info['status'] == $k ? 'selected' : '' ?>><?php echo $v?></option>
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
								<input class="form-control" id="send_name" name="send_name" value="<?php echo $info ? $info['send_name'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="wishing"><i class="required">*</i>红包祝福语</label>
								<input class="form-control" id="wishing" name="wishing" value="<?php echo $info ? $info['wishing'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="remark"><i class="required">*</i>备注信息</label>
								<input class="form-control" id="remark" name="remark" value="<?php echo $info ? $info['remark'] : ''?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="logo_imgurl"><i class="required">*</i>商户logo的url</label>
								<input class="form-control" id="logo_imgurl" name="logo_imgurl" value="<?php echo $info ? $info['logo_imgurl'] : ''?>" />
								<img src="<?php echo $info['logo_imgurl']?>" width="80">
							</div>
							<div class="form-group">
								<label class="control-label" for="send_money">已送出总额, 单位分</label>
								<input class="form-control" id="send_money" name="send_money" value="<?php echo $info ? $info['send_money'] : '0'?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="send_people">已送出总人数</label>
								<input class="form-control" id="send_people" name="send_people" value="<?php echo $info ? $info['send_people'] : '0'?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="fetch_money">兑换金额</label>
								<input class="form-control" id="fetch_money" name="fetch_money" value="<?php echo $info ? $info['fetch_money'] : '0'?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="fetch_people">兑换人数</label>
								<input class="form-control" id="fetch_people" name="fetch_people" value="<?php echo $info ? $info['fetch_people'] : '0'?>" />
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

    <script type="text/javascript">
<!--

// 1.丢弃小数部分,保留整数部分 
// js:parseInt(7/2) 

// 2.向上取整,有小数就整数部分加1 
// js: Math.ceil(7/2) 

// 3,四舍五入. 
// js: Math.round(7/2) 

// 4,向下取整 
// js: Math.floor(7/2)

$(function() {

	function check_total_people()
	{
		var total_people = $("#total_people").val();
		var total_money = $("#total_money").val();
		var min_value = $("#min_value").val();
		var max_value = $("#max_value").val();
	
		
		var total_people_max = Math.ceil(total_money / min_value);
		var total_people_min = parseInt(total_money / max_value);
	
		$("#total_people").parent().find(".help-block").html("发放人数必须在"+total_people_min+" ~ "+total_people_max+"之间");
		
		if (total_people > total_people_max || total_people < total_people_min)
		{
			$("#total_people").parent().addClass("has-error");
		}
		else
		{
			$("#total_people").parent().removeClass("has-error");
		}
	}

	function check_total_money()
	{
		var total_people = $("#total_people").val();
		var total_money = $("#total_money").val();
		var min_value = $("#min_value").val();
		var max_value = $("#max_value").val();
	
		
		var total_money_min = parseInt(total_people * min_value);
		var total_money_max = Math.ceil(total_people * max_value);
	
		$("#total_money").parent().find(".help-block").html("发放金额必须在"+total_money_min+" ~ "+total_money_max+"之间");
		
		if (total_money > total_money_max || total_money < total_money_min)
		{
			$("#total_money").parent().addClass("has-error");
		}
		else
		{
			$("#total_money").parent().removeClass("has-error");
		}
	}

	function check_min_value()
	{
		var total_people = $("#total_people").val();
		var total_money = $("#total_money").val();
		var min_value = $("#min_value").val();
		var max_value = $("#max_value").val();
	
		
		var value_max = Math.ceil(total_money / total_people);
		var value_min = parseInt(total_money / total_people);
	
		$("#total_money").parent().find(".help-block").html("发放金额必须在"+total_money_min+" ~ "+total_money_max+"之间");
		return ;
		
// 		if (total_money > total_money_max || total_money < total_money_min)
// 		{
// 			$("#total_money").parent().find(".help-block").addClass("");
// 		}
// 		else
// 		{

// 		}
	}

	function check_max_value()
	{
		var total_people = $("#total_people").val();
		var total_money = $("#total_money").val();
		var min_value = $("#min_value").val();
		var max_value = $("#max_value").val();
	
		
		var total_money_min = parseInt(total_people * min_value);
		var total_money_max = Math.ceil(total_people * max_value);
	
		$("#total_money").parent().find(".help-block").html("发放金额必须在"+total_money_min+" ~ "+total_money_max+"之间");
		return ;
		
		//if (total_money > total_money_max || total_money < total_money_min)
		//{
			
		//}
	}

	
	$("#total_people").focus(function(){
		check_total_people();
	}).blur(function(){
		check_total_people();
	});
	
	$("#total_money").focus(function(){
		check_total_money();
	}).blur(function(){
		check_total_money();
	});

	$("#min_value").focus(function(){
		check_total_people();
		check_total_money();
	}).blur(function(){
		check_total_people();
		check_total_money();
	});

	$("#max_value").focus(function(){
		check_total_people();
		check_total_money();
	}).blur(function(){
		check_total_people();
		check_total_money();
	});

});
//-->
</script>
    
    
    
<script type="text/javascript" src="/resource/admin/sb-admin/bower_components/jquery/src/datepicker/WdatePicker.js"></script>
<?php include APPPATH . "views/admin/_footer.php";?>