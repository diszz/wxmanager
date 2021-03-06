<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">生成礼包码</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
        	<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<div class="col-md-10">
							<div class="form-group">
								<label class="control-label" for="code_id">名称</label>
								<select class="form-control" id="code_id" name="code_id">
									<?php if ($codeList){?>
									<?php foreach ($codeList as $item){?>
									<option value="<?php echo $item['code_id']?>"><?php echo $item['name']?></option>
									<?php }}?>
								</select>
							</div>
							<div class="form-group">
	                            <label for="count">数据数</label>
	                            <input type="text" class="form-control" id="count" name="count" value="<?php echo !empty($olddata['count']) ? $olddata['count'] : '100' ?>" />
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