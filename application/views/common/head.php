<!DOCTYPE html>
<html lang="zh-cn">
	<head>

		<meta charset="utf-8" > 
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" > 
		<meta name="apple-mobile-web-app-capable" content="yes" > 
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" > 
		<meta name="format-detection" content="telephone=yes" > 
		<meta name="msapplication-tap-highlight" content="no" > 
		

		<!-- 导入 CSS -->
		<?php 
		foreach ($css as $value) {
			echo "<link rel='stylesheet' href='".base_url()."public/css/".$value."'>";
		}
		?>

		<!-- 导入 Javascript -->
		<?php
		foreach ($javascript as $value) {
			echo "<script src=".base_url().'public/js/'.$value."></script>";
		}
		?>

		<input id="BASE_URL" type="hidden" value="<?=base_url()?>">
	</head>
