<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">编辑关键词</h1>
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
						<h3 class="panel-title">表单</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10">
							<div class="form-group">
								<label class="control-label" for="name">关键词名称</label>
								<input type="text" class="form-control" id="name" name="name" value="<?php echo !empty($info['name']) ? $info['name'] : '' ?>">
								<p>可填写一个关键词或多个别名之间使用空格或逗号隔开, 不能使用大写字母!</p>
							</div>
							<div class="form-group">
								<label class="control-label" for="content">回复内容</label>
								<textarea class="form-control" id="content" name="content" ><?php echo !empty($info['content']) ? $info['content'] : '' ?></textarea>
								<p>例 : 恭喜您, 您领取的激活码是{},感谢您的参与.</p>
								<p>注:{}为占位符</p>
							</div>
							<div class="form-group">
								<label class="control-label" for="object">挂载对象</label>
								<select name="object" id="object" class="form-control">
									<?php foreach ($objectArr as $i => $val){?>
									<option value="<?php echo $i?>" <?php echo (int)$info['object'] === (int)$i ? 'selected' : '' ?>><?php echo $val?></option>
									<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" for="sort">排序(权重)</label>
								<input type="text" class="form-control" id="sort" name="sort" value="<?php echo !empty($info['sort']) ? $info['sort'] : '' ?>">
								<p>值越大越靠前!</p>
							</div>
							<div class="form-group">
								<label class="control-label" for="sort">"礼包活动"所选择的"礼包" 不能与"签到活动"及"抽奖活动"重复. 重复时"礼包活动"会得不到"礼包码"</label>
							</div>
						</div>
					</div>
				</div>
				
				
				
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-default " id="object_1" style="<?php echo $info['object'] == 1 ? '' : 'display:none'?>">
					<div class="panel-heading">
						<h3 class="panel-title">选项</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10">
							<?php $children = array();if ($info['children']){foreach ($info['children'] as $item){$children[$item['child_keyword_id']] = $item;}}?>
							<?php if ($keywordList){foreach ($keywordList as $item){if ($info['keyword_id'] == $item['keyword_id']){continue;}?>
							
							<div class="form-group">
                                <input type="text" name="children_sort[]" value="<?php echo $children && isset($children[$item['keyword_id']]) ? $children[$item['keyword_id']]['sort'] : 0?>" size="5">
                                <label class="control-label">
                                <input type="checkbox" name="children[]" value="<?php echo $item['keyword_id']?>" <?php echo $children && isset($children[$item['keyword_id']]) ? 'checked' : ''?>>
                                <?php echo $item['name']?>
                                </label>
							</div>
							<?php }}else{?>
							<div class="form-group">
							暂无记录
							</div>
							<?php }?>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default" id="object_2" style="<?php echo $info['object'] == 2 ? '' : 'display:none'?>">
					<div class="panel-heading">
						<h3 class="panel-title">选择礼包</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10">
							<?php if ($codeList){foreach ($codeList as $item){?>
							<div class="form-group">
                                <label class="control-label">
                                <input type="radio" name="object_id" value="<?php echo $item['code_id']?>" <?php echo $info['object'] == 2 && isset($info['object_id']) && $info['object_id'] == $item['code_id'] ? 'checked="checked"' : ''?>>
                                <?php echo $item['name']?>
                                (剩余量:<?php $code_last = (int)$item['total_count'] - (int)$item['send_count'];echo $code_last > 0 ? $code_last : 0?>)
                                </label>
							</div>
							<?php }}else{?>
							<div class="form-group">
							暂无记录
							</div>
							<?php }?>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default" id="object_3" style="<?php echo $info['object'] == 3 ? '' : 'display:none'?>">
					<div class="panel-heading">
						<h3 class="panel-title">选择签到</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10">
							<?php if ($signinList){foreach ($signinList as $item){?>
							<div class="form-group">
                                <label class="control-label">
                                <input type="radio" name="object_id" value="<?php echo $item['signin_id']?>" <?php echo $info['object'] == 3 && isset($info['object_id']) && $info['object_id'] == $item['signin_id'] ? 'checked="checked"' : ''?>>
                                <?php echo $item['name']?>
                                </label>
							</div>
							<?php }}else{?>
							<div class="form-group">
							暂无记录
							</div>
							<?php }?>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default" id="object_4" style="<?php echo $info['object'] == 4 ? '' : 'display:none'?>">
					<div class="panel-heading">
						<h3 class="panel-title">选择抽奖</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10">
							<?php if ($lotteryList){foreach ($lotteryList as $item){?>
							<div class="form-group">
                                <label class="control-label">
                                <input type="radio" name="object_id" value="<?php echo $item['lottery_id']?>" <?php echo $info['object'] == 4 && isset($info['object_id']) && $info['object_id'] == $item['lottery_id'] ? 'checked="checked"' : ''?>>
                                <?php echo $item['name']?>
                                </label>
							</div>
							<?php }}else{?>
							<div class="form-group">
							暂无记录
							</div>
							<?php }?>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default" id="object_5" style="<?php echo $info['object'] == 5 ? '' : 'display:none'?>">
					<div class="panel-heading">
						<h3 class="panel-title">选择文章</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10">
							<?php if ($articleList){foreach ($articleList as $item){?>
							<div class="form-group">
                                <label class="control-label">
                                <input type="radio" name="object_id" value="<?php echo $item['article_id']?>" <?php echo $info['object'] == 5 && isset($info['object_id']) && $info['object_id'] == $item['article_id'] ? 'checked="checked"' : ''?>>
                                <?php echo $item['title']?>
                                </label>
							</div>
							<?php }}else{?>
							<div class="form-group">
							暂无记录
							</div>
							<?php }?>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default" id="object_6" style="<?php echo $info['object'] == 6 ? '' : 'display:none'?>">
					<div class="panel-heading">
						<h3 class="panel-title">选择文章分类</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10">
							<?php if ($articleCategoryList){foreach ($articleCategoryList as $item){?>
							<div class="form-group">
                                <label class="control-label">
                                <input type="radio" name="object_id" value="<?php echo $item['category_id']?>" <?php echo $info['object'] == 6 && isset($info['object_id']) && $info['object_id'] == $item['category_id'] ? 'checked="checked"' : ''?>>
                                <?php echo $item['name']?>
                                </label>
							</div>
							<?php }}else{?>
							<div class="form-group">
							暂无记录
							</div>
							<?php }?>
						</div>
					</div>
					<?php $object_config = $info['object_config'] ? unserialize($info['object_config']) : ''?>
					<div class="panel-body">
						<div class="col-md-10">
							<div class="form-group">
								<label class="control-label" for="object_config_count">每次显示文章数</label>
								<input type="text" class="form-control" id="object_config_count" name="object_config[count]" value="<?php echo !empty($object_config['count']) ? $object_config['count'] : '5' ?>">
							</div>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default" id="object_7" style="<?php echo $info['object'] == 7 ? '' : 'display:none'?>">
					<div class="panel-heading">
						<h3 class="panel-title">选择红包</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-10">
							<?php if ($redpackList){foreach ($redpackList as $item){?>
							<div class="form-group">
                                <label class="control-label">
                                <input type="radio" name="object_id" value="<?php echo $item['redpack_id']?>" <?php echo $info['object'] == 7 && isset($info['object_id']) && $info['object_id'] == $item['redpack_id'] ? 'checked"checked"' : ''?>>
                                <?php echo $item['name']?>
                                </label>
							</div>
							<?php }}?>
						</div>
					</div>
				</div>
				
			</div>
			
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div class="col-md-10">
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
$(document).ready(function(){
	$("#object").change(function(){
		
		$("#object_1").parent().find(".panel").hide();

		var object = $("#object").val();
		if (object > 0)
		{
			$("#object_"+object).show();
		}
	});
});
</script>
    
<?php include APPPATH . "views/admin/_footer.php";?>