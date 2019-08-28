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
						<div class="col-md-8">
							<div class="form-group">
	                            <label for="file">红包名称</label>
	                            <p class="form-control-static"><?php echo $info['name']?></p>
                            </div>
							<div class="form-group">
								<label class="control-label" for="total_people">发放总人数</label>
								<p class="form-control-static" ><?php echo $info['total_people'] ?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="total_money">总金额, 单位分</label>
								<p class="form-control-static" ><?php echo $info['total_money'] ?></p>
							</div>
                            <div class="form-group">
								<label class="control-label" for="min_value">最小红包金额, 单位分</label>
								<p class="form-control-static" ><?php echo $info['min_value'] ?></p>
							</div>
							<div class="form-group">
								<label class="control-label" for="max_value">最大红包金额, 单位分</label>
								<p class="form-control-static" ><?php echo $info['max_value'] ?></p>
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
								<button type="submit" class="btn btn-info">确定清空红包?</button>
								<button type="button" class="btn btn-info" onclick="window.location.reload();">刷新页面</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
        </div>
    </div>

<?php include APPPATH . "views/admin/_footer.php";?>