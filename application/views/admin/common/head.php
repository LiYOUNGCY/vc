<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Artvc</title>
    <script src="<?=base_url()?>/public/js/jquery.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url()?>public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=base_url()?>public/admin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=base_url()?>public/admin/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=base_url()?>public/admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        <!-- 导入 CSS -->
    <?php
    if(isset($css))
    {
        foreach ($css as $value) {
            echo "<link rel='stylesheet' href='".base_url()."public/admin/css/".$value."'>";
        }       
    } 

    ?>

    <!-- 导入 Javascript -->
    <?php
    if(isset($javascript))
    {
        foreach ($javascript as $value) {
            echo "<script src=".base_url().'public/admin/js/'.$value."></script>";
        }        
    }

    ?>

    <input id="BASE_URL" type="hidden" value="<?=base_url()?>" />   
    <input id="ADMIN" type="hidden" value="<?=base_url().ADMINROUTE?>" />

</head>