<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">查看微信用户</h1>
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
						<h3 class="panel-title"></h3>
					</div>
					<div class="panel-body">
						<div class="col-md-6">
							<div class="form-group ">
								<label class="control-label" for="nickname">OPENID</label>
								<p class="form-control-static"><?php echo $info['openid']?></p>
							</div>
							<div class="form-group ">
								<label class="control-label" for="nickname">昵称</label>
								<p class="form-control-static"><?php echo !empty($info['nickname']) ? $info['nickname'] : '无昵称'?></p>
							</div>
							<div class="form-group ">
								<label class="control-label" for="nickname">头像</label>
								<p class="form-control-static">
								<?php if (!empty($info['headimgurl'])){?>
								<img src="<?php echo weixin_user_avatar($info['headimgurl'])?>">
								<?php }else{?>
								无头像
								<?php }?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"></h3>
					</div>
					<div class="panel-body">
						<fieldset>
						
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