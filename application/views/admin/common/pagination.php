<div class="row">
	<div class="col-sm-6">
		<div class="dataTables_info" id="sample-table-2_info">
			共<?=$count;?>条数据
		</div>
	</div>
	<div class="col-sm-6">
		<ul class="pagination">

			<?php 
			if($page - 1 < 0)
			{?>
			<li class="prev disabled">	
				<a href="javascript:void(0);">
					<<
				</a>
			</li>												
			<?php
			}else{
			?>	
			<li>	
				<a href="<?=$pageurl.intval($page-1)?>">
					<<
				</a>
			</li>											
			<?php }?>

			<?php
				$count = ceil($count/$limit);
				for($i = 0; $i < $count; $i++){	
			?>

			<?php if($i == $page){?>
				<li class="active">
					<a href="javascript:void(0);">
			<?php } else{?>
				<li>
					<a href="<?=$pageurl.$i?>">
			<?php }?><?=$i+1?>										
					</a>
				</li>

			<?php }?>
				
			<?php 
			if($page + 1 >= $count)
			{
			?>
			<li class="prev disabled">	
				<a href="javascript:void(0);">
					>>
				</a>
			</li>												
			<?php
			}else{
			?>	
			<li>	
				<a href="<?=$pageurl.intval($page+1)?>">
					>>
				</a>
			</li>											
			<?php }?>

		</ul>
	</div>
</div>