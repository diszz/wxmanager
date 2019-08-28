<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">清空数据</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
        	<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">清空表单</h3>
					</div>
					<div class="panel-body">
						<fieldset>
							<div class="form-group">
								<div class="col-md-6">
	                            	<label for="file">确定清空词库及其对应关系?</label>
	                            	<input type="hidden" id="file" name="file" >
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
								<button type="submit" class="btn btn-info">提交表单</button>
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