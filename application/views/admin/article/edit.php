<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑文章</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<form role="form" method="post" action="" class="form">
        	<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label" for="title">标题</label>
								<input type="text" class="form-control" id="title" name="title" value="<?php echo !empty($info['title']) ? $info['title'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="category_id">分类</label>
								<select name="category_id" class="form-control">
									<?php foreach ($categoryList as $item){?>
									<option value="<?php echo $item['category_id']?>" <?php echo !empty($info['category_id']) && $info['category_id'] == $item['category_id'] ? 'selected' : '' ?>><?php echo $item['name']?></option>
									<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="desc">描述</label>
								<textarea class="form-control" id="desc" name="desc" ><?php echo !empty($info['desc']) ? $info['desc'] : '' ?></textarea>
							</div>
							<div class="form-group">
								<label class="control-label" for="icon">图片</label>
								<input type="text" class="form-control" id="icon" name="icon" value="<?php echo !empty($info['icon']) ? $info['icon'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="url">地址</label>
								<input type="text" class="form-control" id="url" name="url" value="<?php echo !empty($info['url']) ? $info['url'] : '' ?>">
								<div class="checkbox">
								<label>
									<input type="checkbox" id="is_redirect" name="is_redirect" value="1" <?php echo !empty($info['is_redirect']) ? 'checked' : '' ?>>跳转地址
								</label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label" for="sort">排序</label>
								<input type="text" class="form-control" id="sort" name="sort" value="<?php echo !empty($info['sort']) ? $info['sort'] : '' ?>">
							</div>
							<div class="form-group">
								<label class="control-label" for="share_desc">分享描述</label>
								<textarea class="form-control" id="share_desc" name="share_desc" ><?php echo !empty($info['share_desc']) ? $info['share_desc'] : '' ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">内容</h3>
					</div>
					<div class="panel-body">
						<textarea class="form-control" id="content" name="content" ><?php echo !empty($info['attribute']['content']) ? $info['attribute']['content'] : '' ?></textarea>
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
    
<script charset="utf-8" src="/resource/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/resource/kindeditor/lang/zh_CN.js"></script>
<script>
//关闭过滤模式，保留所有标签
KindEditor.options.filterMode = false;
KindEditor.ready(function(K) {
window.editor = K.create('#content', {
	//filterMode : true,
	//cssPath : '/css/index.css',
	uploadJson : '/admin/index/uploadfile_to_cdn',
	fileManagerJson : '/admin/index/file_manager_json',
	allowFileManager : true,
	afterCreate : function() {
		var self = this;
		K.ctrl(document, 13, function() {
			self.sync();
			K('form[name=example]')[0].submit();
		});
		K.ctrl(self.edit.doc, 13, function() {
			self.sync();
			K('form[name=example]')[0].submit();
		});
	}
});
});

//取得HTML内容
//html = editor.html();

// 同步数据后可以直接取得textarea的value
//editor.sync();
//html = document.getElementById('editor_id').value; // 原生API
//html = K('#editor_id').val(); // KindEditor Node API
//html = $('#editor_id').val(); // jQuery

// 设置HTML内容
//editor.html('HTML内容');
</script>
<?php include APPPATH . "views/admin/_footer.php";?>