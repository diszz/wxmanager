<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑礼包</h1>
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
						<h3 class="panel-title">编辑表单</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-8">
							<div class="form-group">
								<label class="control-label" for="name">名称</label>
								<input type="text" class="form-control" id="name" name="name" value="<?php echo !empty($info['name']) ? $info['name'] : '' ?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="total_count">总量</label>
								<input type="text" class="form-control" id="total_count" name="total_count" value="<?php echo isset($info['total_count']) ? $info['total_count'] : '' ?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="send_count">已发放量</label>
								<input type="text" class="form-control" id="send_count" name="send_count" value="<?php echo isset($info['send_count']) ? $info['send_count'] : '' ?>" />
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