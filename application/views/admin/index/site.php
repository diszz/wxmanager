<?php include APPPATH . "views/admin/_header.php";?>
<?php include APPPATH . "views/admin/_menu.php";?>

    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">统计信息</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">交互记录统计图</div>
						<div class="panel-body">
                            <div id="chart_record"></div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">用户输入关键词热度统计图(根据过去7天内, 收集最多99条数据而成)</div>
						<div class="panel-body">
                            <div id="chart_keyword" style="height: 350px;"></div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">关键词与事件使用量统计图(根据过去7天内数据而成)</div>
						<div class="panel-body">
                            <div id="chart_type" style="height: 350px;"></div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        
    <!-- Morris Charts JavaScript -->
    <script src="/resource/admin/sb-admin/bower_components/raphael/raphael-min.js"></script>
    <script src="/resource/admin/sb-admin/bower_components/morrisjs/morris.min.js"></script>
    
    <script>
    <?php 
    $str = '';
    if($recordStatisticals){foreach ($recordStatisticals as $k => $v){
    	$str .= "{period: '".$k."',人数: '".$v."'},";
    }}
    $str = trim($str, ',');
    ?>
    $(function() {
        Morris.Area({
            element: 'chart_record',
            data: [<?php echo $str?>],
            xkey: 'period',
            ykeys: ['人数'],
            labels: ['参与次数'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });
    });

    </script>
    
    <script>
    <?php 
    $str = '';
    if($recordKeywordStat){foreach ($recordKeywordStat as $k => $v){
    	$str .= "{y: '".$k."',a: '".$v."'},";
    }}
    $str = trim($str, ',');
    ?>
    $(function() {

	    Morris.Bar({
	        element: 'chart_keyword',
	        data: [<?php echo $str?>],
	        xkey: 'y',
	        ykeys: ['a'],//['a','b'],
	        labels: ['关键词热度'],
	        hideHover: 'auto',
	        resize: true
	    });
    });

    </script>
    
    <script>
    <?php 
    $str = '';
    if($recordTypeStat){foreach ($recordTypeStat as $k => $v){
    	$str .= "{y: '".$k."',a: '".$v."'},";
    }}
    $str = trim($str, ',');
    ?>
    $(function() {

	    Morris.Bar({
	        element: 'chart_type',
	        data: [<?php echo $str?>],
	        xkey: 'y',
	        ykeys: ['a'],//['a','b'],
	        labels: ['使用量'],
	        hideHover: 'auto',
	        resize: true
	    });
    });

    </script>

<?php include APPPATH . "views/admin/_footer.php";?>