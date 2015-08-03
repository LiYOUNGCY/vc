<body>
    <?php 
    echo $sidebar;
    ?>
    <input type="hidden" id="userid" value="<?=$people['id']?>">
	<div id="vi_container" class="container">
		<div id="shade"></div>
		<?php 
	    echo $showcard;
	    ?>
		<div id="vi_content" class="content">
			<div id="vi_main" class="main width-100p">
				<div id="qzlist" class="qzlist">
				<div class="theqz" id="theqz">
					<div class="qzinfo" id="qzinfo">
						<?php if(isset($media)){ ?>
							<div class="head">
								<img src="<?php echo $people['pic']; ?>">
							</div>
							<div class="name">
								<h3><?=$media['name'];?></h3>
							</div>
							<div class="intro">
								<p>
									<i class="fa fa-quote-left fa-2x pull-left">
										
									</i>
									<?=$media['intro'];?>
								</p>
							</div>
							<div class="infob">
								<i class="fa fa-comments" title="帖子数">
									
								</i>
								<?=$media['post'];?>
								<a href="<?=base_url().'community/'.$media['id']?>">
									<div class="btn">
										进入圈子
										<i class="fa fa-arrow-right" style="margin:0 0 0 5px;">
											
										</i>
									</div>
								</a>
							</div>	
						<?php }?>
					</div>
				</div>
				<div class="title">
					<?php echo $people['name'];?>关注的圈子
				</div>
				<div id="list" class="list">
					
				</div>
				<div id="loadmore" class="loadmore">
					加载更多
				</div>
				</div>
			</div>
			<?=$footer?>
		</div>
	</div>

</body>
<script type="text/javascript" src="<?=base_url().'public/'?>js/vc.js"></script>
<script type="text/javascript" src="<?=base_url().'public/'?>js/home.js"></script>
<script type="text/javascript">
	

</script>
</html>