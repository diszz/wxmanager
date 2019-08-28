

//------------------------------------------------------------------------
//打开提示模态框
var alert_modal_hide_num = 0;
function alert_modal_callback (num)
{
	if (alert_modal_hide_num != num)
	{
		return ;
	}
	
	if ($("#alert_modal").is(":hidden"))
	{
		return ;
	}
	else
	{
		$('#alert_modal').modal('hide');
	}
}

//提示模态框
function alert_modal(title, content, ttl)
{
	$("#alert_modal").find("#alert_title").html(title);
	$("#alert_modal").find("#alert_content").html(content);
	
	$('#alert_modal').modal();
	
	alert_modal_hide_num = alert_modal_hide_num + 1;
	
	if (typeof(ttl) == "undefined")
	{
		ttl = 3500;
	}
	
	//1秒后自动关闭
	setTimeout("alert_modal_callback("+ alert_modal_hide_num +")", ttl);
}

//---------------------------------------------------------------------------

//刷新今天的活动列表
var refresh_activity_lock = false;
function refreshActivityList()
{
	if (refresh_activity_lock)
	{
		return ;
	}
	refresh_activity_lock = true;
	
	var data = {};
	$.post('/index/irefresh_activity',data, function(rst){
		//console.log(data.time); //  2pm
		
		if (rst.errno)
		{
			alert_modal(rst.errno, rst.message);
			refresh_activity_lock = false;
			return ;
		}
		else
		{
			var list = rst.data;
			
			var html = '';
			var htmlitem = $("#today_activity_item").html();
			$.each(list, function(k,v){
				
				var htmlitem_ = htmlitem;
				html += htmlitem_.replace('_activity_id_', v.activity_id).replace('_user_count_', v.user_count).replace('_word_name_', v.word_info.name);
			});
			$("#today_activity_list").html(html);
			refresh_activity_lock = false;
			return ;
		}
		
	}, "json");
}

//---------------------------------------------------------

$(document).ready(function(){

//点击按钮刷新活动列表
$("#refresh_activity").click(function(){
	refreshActivityList();
	
	//打开提示模态框
	alert_modal('success', '刷新完成', 2000);
});

//点击添加词条
var add_word_lock = false;
$("#add_word_submit").click(function(){
	var add_word_name = $("#add_word_modal").find("#add_word_name").val();
	var data = {};
	data.name = add_word_name;
	
	if (add_word_lock)
	{
		return ;
	}
	add_word_lock = true;
	
	$.post('/index/iadd_word',data, function(rst){
		//console.log(data.time); //  2pm
		
		if (rst.errno)
		{
			add_word_lock = false;
			alert_modal(rst.errno, rst.message);
			
			return ;
		}
		else
		{
			//刷新今天活动区列表
			refreshActivityList();
			
			add_word_lock = false;
			
			//关闭模态框
			$('#add_word_modal').modal('hide');
			
			//打开提示模态框
			alert_modal(rst.message, rst.message, 4000);
			
			return ;
		}
		
	}, "json");
	
});


//点击参与活动
var join_activity_lock = false;
$(".join_activity").live("click", function(){
	var _this = this;
	var activity_id = $(_this).attr("data-activity_id");
	
	var data = {};
	data.activity_id = activity_id;
	
	if (join_activity_lock)
	{
		return ;
	}
	join_activity_lock = true;
	
	$.post('/index/ijoin_activity',data, function(rst){
		//console.log(data.time); //  2pm
		
		if (rst.errno)
		{
			join_activity_lock = false;
			alert_modal(rst.errno, rst.message);
			return ;
		}
		else
		{
			var activityInfo = rst.data.activity_info;
			var refresh = rst.data.refresh;
			
			if (refresh)
			{
				//刷新今天活动区列表
				refreshActivityList();
			}
			else
			{
				//统计数+1
				$(_this).find(".activity_count").html(activityInfo['user_count']);
			}
			
			join_activity_lock = false;
			
			//关闭模态框
			$('#add_word_modal').modal('hide');
			
			//打开提示模态框
			if (refresh)
			{
				alert_modal(rst.message, rst.message, 4000);
			}
			else
			{
				alert_modal(rst.message, rst.message, 2000);
			}
			
			return ;
		}
		
	}, "json");
	
});


});



