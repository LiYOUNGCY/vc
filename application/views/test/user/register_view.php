<html>
<head>
	<title><?=$title?></title>
	<meta charset='utf-8'>
</head>

<body>
	<h1><?=$title?></h1>
	<form action="<?=base_url().'account/main/register_by_phone' ?>" method="post">
		Email: <input type="text" name="email"><br/>
		Phone: <input type="text" name="phone"> <br/>
		Password: <input type="password" name="pwd"> <br/>
		<input type="submit" value="Submit">
	</form>
</body>
</html>