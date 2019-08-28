<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑用户</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<form role="form" method="post" action="" class="form-horizontal">
        	<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">编辑用户资料</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-6">
							<div class="form-group ">
								<label class="control-label" for="nickname">昵称</label>
								<input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo $info['nickname']?>">
							</div>
							<div class="form-group ">
								<label class="control-label" for="nickname">头像</label>
								<img src="<?php echo $info['headimgurl']?>">
							</div>
							<div class="form-group ">
								<label class="control-label" for="nickname">Email</label>
								<input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo $info['nickname']?>">
							</div>
							<div class="form-group ">
								<label class="control-label" for="nickname">Email</label>
								<input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo $info['nickname']?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">我的小组</h3>
					</div>
					<div class="panel-body">
						<fieldset>
							<div class="form-group ">
								<div class="col-md-6">
									<label class="control-label" for="group_name">名称</label>
									<input type="text" class="form-control" id="group_name" name="group_name" value="<?php echo $groupInfo ? $groupInfo['name'] : ''?>">
								</div>
							</div>
							
						</fieldset>
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