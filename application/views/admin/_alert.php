<?php if (!empty($message)){?>
<div class="alert alert-danger"><?php echo $message?></div>
<?php }?>

<!--错误的提示-->
<?php 
$errordata = $this->session->flashdata('error');
$message = '';
if (is_array($errordata))
{
	foreach ($errordata as $key => $item)
	{
		$message .= $item."<br />";
	}
}
else
{
	$message .= $errordata;
}
?>
<?php if ($message){?>
<div class="alert alert-danger"><?php echo $message?></div>
<?php }?>

<!--成功的提示-->
<?php 
$errordata = $this->session->flashdata('success');
$message = '';
if (is_array($errordata))
{
	foreach ($errordata as $key => $item)
	{
		$message .= $item."<br />";
	}
}
else
{
	$message .= $errordata;
}
?>
<?php if ($message){?>
<div class="alert alert-success"><?php echo $message?></div>
<?php }?>