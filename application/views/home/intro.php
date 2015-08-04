<body>
    <?php 
    echo $sidebar;
    ?>
	<div id="vi_container" class="container">
		<div id="shade"></div>
		<?php 
	    echo $showcard;
	    ?>
		<div id="vi_content" class="content">
			<div id="vi_main" class="main width-100p">
				<div class="homeintro">
					<div class="title">
					<?php echo $user['name'];?>的介绍
					</div>
					<hr class="line2" />
					<div class="intro">
						<?php echo $intro['content'] ;?>
					</div>
					<div class="likeopt">
						<div class="likebtn1">
							<div class="support">
								
							</div>
							<div class="num">
								<a href="javascript:void(0);" class="link">12</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?=$footer?>
		</div>

	</div>
	<script type="text/javascript" src="<?=base_url().'public/'?>js/vc.js"></script>
	<script type="text/javascript" src="<?=base_url().'public/'?>js/home.js"></script>
</body>
<script type="text/javascript">
</script>
</html>