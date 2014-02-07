<div class="tablenav <?php echo $position?>">
	<div class="tablenav-pages"><span class="displaying-num"><?php echo $paginate['total']?> items</span>
	<span class="pagination-links <?php echo $paginateclass;?>"><a class="first-page<?php echo $paginate['current_page']==1?' disabled':''?>" title="Go to the first page" href="javascript:void(0);">«</a>
	<a class="prev-page<?php echo $paginate['current_page']==1?' disabled':''?>" title="Go to the previous page" href="javascript:void(0);">‹</a>
	<span class="paging-input">
		<input type="hidden" class="current-page-count" value="<?php echo $paginate['current_page']?>" />
		<?php if($position=='top'):?>
		<input class="current-page" title="Current page" type="text" name="paged" value="<?php echo $paginate['current_page']?>" size="1">
		<?php else:?>
			<span class="current-page"><?php echo $paginate['current_page']?></span>
		<?php endif;?>
		 of <span class="total-pages"><?php echo $paginate['pages']?>
	</span>
	</span>
	<a class="next-page<?php echo $paginate['current_page']==$paginate['pages']?' disabled':''?>"  title="Go to the next page" href="javascript:void(0);">›</a>
	<a class="last-page<?php echo $paginate['current_page']==$paginate['pages']?' disabled':''?>"  title="Go to the last page" href="javascript:void(0);">»</a></span></div>
	<br class="clear">
</div>
<br/>