<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu_index.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">添加站点</h1>
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
						<h3 class="panel-title">填写资料</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-9">
							<div class="form-group">
								<label class="control-label" for="name">名称</label>
								<input type="text" class="form-control" id="name" name="name" value="<?php echo !empty($olddata['name']) ? $olddata['name'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="name">appid</label>
								<input type="text" class="form-control" id="appid" name="appid" value="<?php echo !empty($olddata['appid']) ? $olddata['appid'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="appsecret">appsecret</label>
								<input type="text" class="form-control" id="appsecret" name="appsecret" value="<?php echo !empty($olddata['appsecret']) ? $olddata['appsecret'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="token">token</label>
								<input type="text" class="form-control" id="token" name="token" value="<?php echo !empty($olddata['token']) ? $olddata['token'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="token">类型</label>
								<select name="type" class="form-control">
									<option value="0" >订阅号</option>
									<option value="1" <?php echo !empty($olddata['type']) ? 'selected' : '' ?>>服务号</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="token">认证情况</label>
								<select name="verify" class="form-control">
									<option value="0" >未认证</option>
									<option value="1" <?php echo !empty($olddata['verify']) ? 'selected' : '' ?>>已认证</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div class="col-md-9">
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