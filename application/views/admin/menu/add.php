<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">添加菜单</h1>
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
						<h3 class="panel-title">填写资料</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="name">名称</label>
								<input type="text" class="form-control" id="name" name="name" value="<?php echo !empty($olddata['name']) ? $olddata['name'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="appsecret">按钮类型</label>
								<select id="type" name="type" class="form-control" autocomplete="off">
									<option value="click" selected="selected">点击事件</option>
									<option value="link">链接地址</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">设定值</label>
								<div id="content_click">
								<select name="content_click" class="form-control" autocomplete="off">
									<?php if ($keywordList){foreach ($keywordList as $item){?>
									<option value="<?php echo $item['name']?>"><?php echo $item['name']?></option>
									<?php }}?>
								</select>
								</div>
								<div class="hidden" id="content_link">
									<textarea name="content_link" placeholder="" class="form-control"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label" for="parent_id">父菜单</label>
								<select id="parent_id" name="parent_id" class="form-control" autocomplete="off">
									<option value="" selected="selected">无</option>
									<?php if ($menuList){foreach ($menuList as $item){?>
									<option value="<?php echo $item['menu_id']?>"><?php echo $item['name']?></option>
									<?php }}?>
								</select>
							</div>
							<div class="form-group">
								<label for="sort" class="control-label"> 排序 </label>
								<input type="text" id="sort" name="sort" value="0" class="form-control"/>
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
    
<script>

$().ready(function(){

	$("#type").change(function(){
		var type = $(this).val();
		if (type == 'click')
		{
			$("#content_click").removeClass('hidden');
			$("#content_link").addClass('hidden');
		}
		else
		{
			$("#content_click").addClass('hidden');
			$("#content_link").removeClass('hidden');
		}
	});

});
</script>
<?php include APPPATH . "views/admin/_footer.php";?>