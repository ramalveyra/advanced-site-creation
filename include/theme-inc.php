<strong>Installed Themes:</strong> <input placeholder="Search theme" type="search" id="theme-search-input" class="theme-search" value="<?php echo $this->search?>"><br /><br />
<?php wp_nonce_field( 'theme-search', '_wpnonce_theme-search' ) ?>
<?php 
	if(isset($this->paginate['themes']) && !empty($this->paginate['themes'])){
		$paginate = $this->paginate['themes'];
		$position = 'top';
		$paginateclass='paginate-themes';
		include 'paginate.php';
	}
?>
<div class="themes">
	<?php if(!empty($this->themes)):?>
		<?php foreach($this->themes as $theme):?>
			<div class="theme" id="<?php echo $theme->get_stylesheet();?>">
				<div class="theme-screenshot">
					<img src="<?php echo $theme->get_screenshot()?>">
				</div>
				<h3 class="theme-name" id="<?php echo $theme->get_stylesheet();?>-name"><?php echo $theme->display('Name');?></h3>
			</div>
		<?php endforeach;?>
	<?php else:?>
		<p>No themes found.</p>
	<?php endif;?>
</div>
<br class="clear">
<?php 
	
	if(isset($this->paginate['themes']) && !empty($this->paginate['themes'])){
		$paginate = $this->paginate['themes'];
		$position = 'bottom'; 
		$paginateclass='paginate-themes';
		$action = 'get_themes_ajax';
		include 'paginate.php';
	}
?>
