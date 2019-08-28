<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑抽奖</h1>
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
								<label class="control-label" for="period">周期</label>
								<select name="period" class="form-control">
									<option value="">一天</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="odds">概率</label>
								<input type="text" class="form-control" id="odds" name="odds" value="<?php echo !empty($info['odds']) ? $info['odds'] : '' ?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="code_id">礼包</label>
								<select name="code_id" class="form-control">
									<option value="">请选择, 不需设置则不选</option>
									<?php foreach ($codeList as $item){?>
									<option value="<?php echo $item['code_id']?>" <?php echo !empty($info['code_id']) && $info['code_id'] == $item['code_id'] ? 'selected="true"' : ''?>><?php echo $item['name']?></option>
									<?php }?>
								</select>
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