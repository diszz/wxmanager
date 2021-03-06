<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">删除</h1>
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
						<div class="col-md-8">
							<div class="form-group">
								<label class="control-label" for="name">金额</label>
								<p class="form-control-static"><?php echo $info['money']?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="name">接收者</label>
								<p class="form-control-static">
								<?php if (!empty($info['user_info'])){?>
								<a href="/admin/user/view?user_id=<?php echo $info['user_info']['user_id']?>"><img src="<?php echo weixin_avatar($info['user_info']['headimgurl'])?>"><?php echo $info['user_info']['nickname']?></a>
								<?php }else{?>
								未送出
								<?php }?>
								</p>
							</div>
							<div class="form-group">
								<label class="control-label" for="name">领取时间</label>
								<p class="form-control-static">
								<?php if (!empty($info['create_time'])){?>
								<?php echo date('Y-m-d H:i:s', $info['create_time'])?>
								<?php }else{?>
								未送出
								<?php }?>
								</p>
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