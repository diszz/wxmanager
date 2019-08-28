<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu_index.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑站点</h1>
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
						<h3 class="panel-title">编辑应用资料</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-9">
							<div class="form-group">
								<label class="control-label" for="name">ID</label>
								<p class="form-control-static"><?php echo $info ? $info['site_id'] : ''?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="name">名称</label>
								<input type="text" class="form-control" id="name" name="name" value="<?php echo !empty($info['name']) ? $info['name'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="name">appid</label>
								<input type="text" class="form-control" id="appid" name="appid" value="<?php echo !empty($info['appid']) ? $info['appid'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="appsecret">appsecret</label>
								<input type="text" class="form-control" id="appsecret" name="appsecret" value="<?php echo !empty($info['appsecret']) ? $info['appsecret'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="token">token</label>
								<input type="text" class="form-control" id="token" name="token" value="<?php echo !empty($info['token']) ? $info['token'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="token">类型</label>
								<select name="type" class="form-control">
									<option value="0" >订阅号</option>
									<option value="1" <?php echo !empty($info['type']) ? 'selected' : '' ?>>服务号</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="token">认证情况</label>
								<select name="verify" class="form-control">
									<option value="0" >未认证</option>
									<option value="1" <?php echo !empty($info['verify']) ? 'selected' : '' ?>>已认证</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="token">接口对接地址</label>
								<?php $site_domain = get_setting('site_domain');?>
								<?php if ($site_domain){?>
								<p class="form-control-static"><?php echo trim($site_domain, '/')?>/client/<?php echo $info['site_id'] ?></p>
								<?php }else{?>
								<p class="form-control-static">您没有设置站点域名, 请先设置.</p>
								<?php }?>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">微信红包设置</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-9">
							<div class="form-group">
								<label class="control-label">API密钥的值</label>
								<input class="form-control" id="pay_api_key" name="pay_api_key" value="<?php echo !empty($info['pay_api_key']) ? $info['pay_api_key'] : ''?>">
								<p class="help-block"></p>
							</div>
							<div class="form-group">
								<label class="control-label">微信支付分配的商户号</label>
								<input class="form-control" id="pay_mch_id" name="pay_mch_id" value="<?php echo !empty($info['pay_mch_id']) ? $info['pay_mch_id'] : ''?>">
								<p class="help-block"></p>
							</div>
							<div class="form-group">
								<label class="control-label">启用状态</label>
								<select name="pay_status">
									<?php foreach (getStatusArr() as $k => $v){?>
									<option value="<?php echo $k?>" <?php echo !empty($info['pay_status']) && $info['pay_status'] == $k ? 'selected' : ''?>><?php echo $v?></option>
									<?php }?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">微信设置demo</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-9">
							<div class="form-group">
								<img class="img-responsive" alt="" src="/resource/images/mp_config_demo.png">
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

<?php include APPPATH . "views/admin/_footer.php";?>