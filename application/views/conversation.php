<!DOCTYPE <!DOCTYPE html>
<html>
 <head> 
  <meta charset="utf-8" /> 
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" /> 
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
  <meta name="format-detection" content="telephone=yes" /> 
  <meta name="msapplication-tap-highlight" content="no" /> 
  <script type="text/javascript" src="<?=base_url().'public/'?>js/j162.min.js"></script> 
  <link href="<?=base_url().'public/'?>css/common.css" type="text/css" rel="stylesheet" /> 
  <link href="<?=base_url().'public/'?>css/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" /> 
  <input id="BASE_URL" type="hidden" value="<?=base_url()?>">
 </head>
<body>
	<textarea></textarea>
</body>
	<script src="<?=base_url().'/public/js/jquery.flexText.min.js' ?>"></script>
	<script>
		$(function(){
			 $('textarea').flexText();
		});
	</script>
</html>