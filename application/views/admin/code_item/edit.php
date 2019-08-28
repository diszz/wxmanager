<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑礼包码</h1>
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
								<label class="control-label" for="code_id">选择礼包</label>
								<select name="code_id" class="form-control">
									<?php foreach ($codeList as $item){?>
									<option value="<?php echo $item['code_id']?>" <?php echo $item['code_id'] == $info['code_id'] ? 'selected' : ''?>><?php echo $item['name']?></option>
									<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="content">礼包码</label>
								<input type="text" class="form-control" id="content" name="content" value="<?php echo !empty($info['content']) ? $info['content'] : '' ?>" />
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