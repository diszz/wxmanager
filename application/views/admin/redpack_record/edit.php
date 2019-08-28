<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑应用</h1>
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
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label" for="card_id">卡券ID</label>
								<select name="card_id" id="card_id" class="form-control">
									<?php foreach ($cardList as $item){?>
									<option value="<?php echo $item['card_id']?>" <?php echo !empty($info['card_id']) && $info['card_id'] == $item['card_id'] ? 'selected' : '' ?>><?php echo $item['card_name']?></option>
									<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="post_id">帖子ID</label>
								<select name="post_id" id="post_id" class="form-control">
									<?php foreach ($postList as $item){?>
									<option value="<?php echo $item['post_id']?>" <?php echo !empty($info['post_id']) && $info['post_id'] == $item['post_id'] ? 'selected' : '' ?>><?php echo $item['name']?></option>
									<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="status">状态</label>
								<select name="status" id="status" class="form-control">
									<?php foreach (getStatusArr as $k => $v){?>
									<option value="<?php echo $v?>" <?php echo !empty($info['status']) && $info['status'] == $item['status'] ? 'selected' : '' ?>><?php echo $v?></option>
									<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="desc">内容</label>
								<textarea class="form-control" id="desc" name="desc" ><?php echo !empty($info['desc']) ? $info['desc'] : '' ?></textarea>
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