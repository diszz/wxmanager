<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu_index.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">添加用户</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<form role="form" method="post" action="" class="form-horizontal">
        	<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<fieldset>
							<div class="form-group ">
								<div class="col-md-6">
									<label class="control-label" for="email">Email</label>
									<input type="text" class="form-control" id="email" name="email" value="">
								</div>
							</div>
							<div class="form-group ">
								<div class="col-md-6">
									<label class="control-label" for="password">密码</label>
									<input type="text" class="form-control" id="password" name="password" value="">
								</div>
							</div>
							<div class="form-group ">
								<div class="col-md-6">
									<label class="control-label" for="is_superadmin">超级管理员</label>
									<div class="input-group">
									<label class="radio-inline">
									<input type="radio" name="is_superadmin" id="is_superadmin" value="0" >非
									</label>
									<label class="radio-inline">
									<input type="radio" name="is_superadmin" id="is_superadmin" value="1" >是
								    </label>
								    </div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">选择站点</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-6">
							<?php if (check_auth('manager') && $siteList){foreach ($siteList as $item){?>
							<div class="form-group">
                                <label class="control-label">
                                <input type="checkbox" name="site_ids[]" value="<?php echo $item['site_id']?>" >
                                <?php echo $item['name']?>
                                </label>
							</div>
							<?php }}?>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div class="col-md-8">
								<button type="submit" class="btn btn-primary">提交表单</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
        </div>
    </div>

<?php include APPPATH . "views/admin/_footer.php";?>