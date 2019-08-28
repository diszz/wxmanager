<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">导入EXCEL词库</h1>
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
						<h3 class="panel-title">表单</h3>
					</div>
					<div class="panel-body">
						<fieldset>
							<div class="form-group">
								<div class="col-md-6">
	                            	<label for="file">选择导入的文件, 格式为.xls,.xlsx的excel</label>
	                            	<input type="file" id="file" name="file" >
                            	</div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6">
	                            	<label for="excel_name">关键词栏</label>
	                            	<select id="excel_name" name="excel_name" class="form-control">
	                            		<option value="0">A</option>
	                            		<option value="1">B</option>
	                            		<option value="2">C</option>
	                            		<option value="3">D</option>
	                            		<option value="4">E</option>
	                            		<option value="5">F</option>
	                            		<option value="6">G</option>
	                            		<option value="7">H</option>
	                            		<option value="8">I</option>
	                            		<option value="9">J</option>
	                            		<option value="10">K</option>
	                            		<option value="11">L</option>
	                            		<option value="12">M</option>
	                            		<option value="13">N</option>
	                            	</select>
                            	</div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6">
	                            	<label for="excel_content">内容栏</label>
	                            	<select id="excel_content" name="excel_content" class="form-control">
	                            		<option value="0">A</option>
	                            		<option value="1">B</option>
	                            		<option value="2">C</option>
	                            		<option value="3">D</option>
	                            		<option value="4">E</option>
	                            		<option value="5">F</option>
	                            		<option value="6">G</option>
	                            		<option value="7">H</option>
	                            		<option value="8">I</option>
	                            		<option value="9">J</option>
	                            		<option value="10">K</option>
	                            		<option value="11">L</option>
	                            		<option value="12">M</option>
	                            		<option value="13">N</option>
	                            	</select>
                            	</div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6">
	                            	<label for="excel_children_start">选项开始栏</label>
	                            	<select id="excel_children_start" name="excel_children_start" class="form-control">
	                            		<option value="0">A</option>
	                            		<option value="1">B</option>
	                            		<option value="2">C</option>
	                            		<option value="3">D</option>
	                            		<option value="4">E</option>
	                            		<option value="5">F</option>
	                            		<option value="6">G</option>
	                            		<option value="7">H</option>
	                            		<option value="8">I</option>
	                            		<option value="9">J</option>
	                            		<option value="10">K</option>
	                            		<option value="11">L</option>
	                            		<option value="12">M</option>
	                            		<option value="13">N</option>
	                            	</select>
                            	</div>
                            </div>
                            
						</fieldset>
					</div>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div class="col-md-8">
								<button type="submit" class="btn btn-info">提交表单</button>
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