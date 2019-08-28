<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑签到</h1>
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
						<h3 class="panel-title"></h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10">
							<div class="form-group">
								<label class="control-label" for="name">名称</label>
								<input type="text" class="form-control" id="name" name="name" value="<?php echo !empty($info['name']) ? $info['name'] : '' ?>" />
							</div>
							<div class="form-group">
								<label class="control-label" for="cycle">签到周期</label>
								<input type="text" class="form-control" id="cycle" name="cycle" value="<?php echo $info['cycle'] ?>" />
								<p class="help-block">两次签到的周期, 单位秒, 填0表无周期, 一般为1天即86400.</p>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
									<input type="checkbox" name="is_continue" value="1" <?php echo $info['is_continue'] ? 'checked' : ''?>> 是否连续执行
									</label>
									<p class="help-block">连续执行: 仅对多个次数的签到. 第1次签到后. 签到周期内不签到, 将失去第2次签到机会</p>
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
									<input type="checkbox" name="is_loop" value="1" <?php echo $info['is_loop'] ? 'checked' : ''?>> 是否循环执行
									</label>
									<p class="help-block">当前签到次数为: <?php echo $info['item_count']?>次. 即<?php echo $info['item_count']?>次签到后, 执行第1次签到. 以此类推</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">设置签到次数</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10" id="item_list">
							<?php if($signinCodeList){foreach ($signinCodeList as $k => $item){?>
							<div class="form-group">
								<h4>第<?php echo $k+1?>次签到</h4>
								<label class="control-label" for="name">正常时提示信息</label>
								<textarea name="success_word[]" rows="" cols="" class="form-control"><?php echo !empty($item['success_word']) ? $item['success_word'] : ''?></textarea>
								<label class="control-label" for="name">重复时提示信息</label>
								<textarea name="repeat_word[]" rows="" cols="" class="form-control"><?php echo !empty($item['repeat_word']) ? $item['repeat_word'] : ''?></textarea>
								<label class="control-label" for="name">选择礼包</label>
								<select name="code[]" class="form-control">
									<option value="">请选择, 不需设置则不选</option>
									<?php foreach ($codeList as $item1){?>
									<option value="<?php echo $item1['code_id']?>" <?php echo $item['code_id'] == $item1['code_id'] ? 'selected="true"' : ''?>><?php echo $item1['name']?></option>
									<?php }?>
								</select>
								<a onclick="del_item(this)" href="javascript:;" >删除此签到</a>
							</div>
							<?php }}?>
							
						</div>
						<div class="col-md-10">
							<div class="form-group">
								<a id="add_item" href="javascript:;" >增加一条签到</a>
							</div>
							<div class="form-group">
								<p class="help-block">
									说明:
									<br>
									{time} 适用于:没有达到下次签到时间, 重复时提示信息; 表距离下次签到时间. 如: 您签到重复了,距离下次签到时间{time}
									<br>
									{code} 适用于:有礼包码的签到, 正常提示信息; 表礼包码占位符. 如: 第一次签到,您获得的礼包码是{code}.
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
    
<div id="item_html" class="hide">
    <div class="form-group" >
		<h4>第_times_次签到</h4>
		<label class="control-label" for="name">正常时提示信息</label>
		<textarea name="success_word[]" rows="" cols="" class="form-control"></textarea>
		<label class="control-label" for="name">重复时提示信息</label>
		<textarea name="repeat_word[]" rows="" cols="" class="form-control"></textarea>
		<label class="control-label" for="name">选择礼包</label>
		<select name="code[]" class="form-control">
			<option value="">请选择, 不需设置则不选</option>
			<?php foreach ($codeList as $item1){?>
			<option value="<?php echo $item1['code_id']?>" ><?php echo $item1['name']?></option>
			<?php }?>
		</select>
		<a onclick="del_item(this)" href="javascript:;" >删除此签到</a>
	</div>
</div>
	
	
<script>

$().ready(function(){

$("#add_item").on('click', function(){

	var item_count = $("#item_list").children(".form-group").length;

	var item_html = $("#item_html").html();

	item_html = item_html.replace("_times_", item_count + 1);

	$("#item_list").append(item_html);
	
});

});

function del_item(t)
{
	$(t).parent().remove();
}


</script>
<?php include APPPATH . "views/admin/_footer.php";?>