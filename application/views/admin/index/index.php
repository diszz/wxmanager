<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu_index.php";?>

	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">我的站点</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<a href="/admin/site/add">添加站点</a>
					</div>
				</div>
				<!-- /.panel -->
			</div>
        	<?php if ($site_arr){foreach ($site_arr as $site_id => $name){?>
        	<div class="col-lg-4">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo $name?></div>
					<div class="panel-body">
						<a href="/admin/site/edit?site_id=<?php echo $site_id?>">编辑</a>
						&nbsp;
						<a href="/admin/index/select_site?site_id=<?php echo $site_id?>">管理</a>
					</div>
				</div>
				<!-- /.panel -->
			</div>
			<?php }}else{?>
			<div class="col-lg-4">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						暂无站点
					</div>
				</div>
				<!-- /.panel -->
			</div>
			<?php }?>
        </div>
    </div>
    

<?php include APPPATH . "views/admin/_footer.php";?>