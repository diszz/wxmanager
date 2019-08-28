<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">同步菜单到线上</h1>
			</div>
			<!-- /.col-md-12 -->
		</div>
		<?php include APPPATH ."views/admin/_alert.php";?>
		<!-- /.row -->
        <div class="row">
        	<div class="col-md-4">
                    <div class="panel panel-default">
                    	<div class="panel-heading">线上菜单</div>
                    	<div class="panel-body">
                    	<nav class="navbar navbar-default" role="navigation" style="padding-top: 100px;border:1px dotted">
					  <div class="container-fluid">
					    <div class="collapse navbar-collapse">
	                    		<ul class="nav navbar-nav">
						      	<?php if ($menus){ ?>
						      	<?php foreach ($menus as $item){?>
						        <li <?php if (isset($item['sub_button']) && $item['sub_button']){ echo 'class="dropup"'; }?>>
						        	<?php if (isset($item['type']) && $item['type'] == 'click'){ ?>
						            <a href="javascript:;" <?php if (isset($item['sub_button']) && $item['sub_button']){ echo 'class="dropdown-toggle" data-toggle="dropdown"';} ?>><?php echo $item['name']?></a>
						            <?php }elseif(isset($item['type']) && $item['type'] == 'view'){?>
						            <a href="<?php echo $item['url']?>" target="_blank" <?php if (isset($item['sub_button']) && $item['sub_button']){ echo 'class="dropdown-toggle" data-toggle="dropdown"';} ?>><?php echo $item['name']?></a>
						            <?php }else{ ?>
						            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><?php echo $item['name']?></a>
						            <?php }?>
						        	<?php if (isset($item['sub_button']) && $item['sub_button']){?>
						        	<ul class="dropdown-menu" role="menu">
						        	<?php foreach ($item['sub_button'] as $item_){?>
						            <li>
						            	<?php if ($item_['type'] == 'click'){?>
						            	<a href="javascript:;"><?php echo $item_['name']?></a>
						            	<?php }else{?>
						            	<a href="<?php echo $item_['url']?>" target="_blank"><?php echo $item_['name']?></a>
						            	<?php }?>
						            </li>
						        	<?php }?>
						        	</ul>
						        	<?php }?>
						        </li>
						        <?php }?>
						        <?php }?>
						      </ul>
						      </div><!-- /.navbar-collapse -->
					  </div><!-- /.container-fluid -->
						</nav>
                        </div>
                    </div>
                    <!-- /.panel -->
            </div>
			<div class="col-md-4">
				<div class="panel panel-default">
                    <div class="panel-heading">新菜单</div>
                    <div class="panel-body">
		                <nav class="navbar navbar-default" role="navigation" style="padding-top: 100px;border:1px dotted">
						  <div class="container-fluid">
						    <div class="collapse navbar-collapse">
						      <ul class="nav navbar-nav">
						      	<?php if ($menuNewData)?>
						      	<?php foreach ($menuNewData as $item){?>
						        <li <?php if (isset($item['sub_button']) && $item['sub_button']){?> class="dropup" <?php }?>>
						        	<?php if (isset($item['type']) && $item['type'] == 'click'){?>
						            <a href="javascript:;" <?php if (isset($item['sub_button']) && $item['sub_button']){?> class="dropdown-toggle" data-toggle="dropdown" <?php }?>><?php echo  $item['name'] ?></a>
						            <?php }elseif(isset($item['type']) && $item['type'] == 'view'){?>
						            <a href="<?php echo  $item['url'] ?>" target="_blank" <?php if (isset($item['sub_button']) && $item['sub_button']){?> class="dropdown-toggle" data-toggle="dropdown" <?php }?>><?php echo  $item['name'] ?></a>
						            <?php }else{?>
						            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><?php echo  $item['name'] ?></a>
						            <?php ?>
						        	<?php if (isset($item['sub_button']) && $item['sub_button']){?>
						        	<ul class="dropdown-menu" role="menu">
						        	<?php foreach ($item['sub_button'] as $item_){?>
						            <li>
						            	
						            	<?php if ($item_['type'] == 'click'){?>
						            	<a href="javascript:;"><?php echo  $item_['name'] ?></a>
						            	<?php }else{?>
						            	<a href="<?php echo  $item_['url'] ?>" target="_blank"><?php echo  $item_['name'] ?></a>
						            	<?php }?>
						            </li>
						        	<?php }?>
						        	</ul>
						        	<?php }?>
						        </li>
						        <?php }?>
						        <?php }?>
						      </ul>
						    </div><!-- /.navbar-collapse -->
						  </div><!-- /.container-fluid -->
						</nav>
                	</div>
                </div>
               </div>
				
            </div>
            
            <div class="row">
            <div class="panel panel-default">
                    <div class="panel-body">
						<form action="" method="post" class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" name="submit" value="确定同步菜单" class="btn btn-default">
								|
								<a href="/admin/menu/">返回</a>
							</div>
						</div>
						</form>
					</div>
				</div>
            </div>
            
    </div>

<?php include APPPATH . "views/admin/_footer.php";?>