<html>
<head>
	<title><?=$test?></title>
	<meta charset='utf-8'>
</head>

<body>
	<h1><?=$title?></h1>
	<form action="<?=base_url().'test/user/check_phone_action' ?>" method="post">
		<input type="text" name="phone">
	</form>
</body>
</html>