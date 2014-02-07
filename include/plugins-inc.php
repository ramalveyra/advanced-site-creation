<strong>Search Avaiable Plugins: </strong> <input placeholder="Search plugins" type="search" id="plugins-search-input" class="plugins-search" value="<?php echo $this->search?>"><br /><br />
<?php wp_nonce_field( 'plugins-search', '_wpnonce_plugins-search' ) ?>
<?php 
	if(isset($this->paginate['plugins']) && !empty($this->paginate['plugins'])){
		$paginate = $this->paginate['plugins'];
		$position = 'top';
		$paginateclass='paginate-plugins';
		include 'paginate.php';
	}
?>
<?php if(!empty($this->allowedPlugins)):?>
<table class="wp-list-table widefat plugins" cellspacing="0">

<thead>
	<th scope="col" id="cb" class="manage-column column-cb check-column" style="">
		<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
		<input id="cb-select-all-1" type="checkbox">
	</th>
	<th scope="col" id="name" class="manage-column column-name" style="">Plugin</th>
	<th scope="col" id="description" class="manage-column column-description" style="">Description</th>
</thead>
<tfoot>
<th scope="col" id="cb" class="manage-column column-cb check-column" style="">
	<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
	<input id="cb-select-all-1" type="checkbox">
</th>
<th scope="col" id="name" class="manage-column column-name" style="">Plugin</th>
<th scope="col" id="description" class="manage-column column-description" style="">Description</th>
</tfoot>
<tbody id="the-list" class="inactive">

	<?php foreach($this->allowedPlugins as $key=>$plugin):?>
		<?php $plugin_id = substr($key,0,strpos($key, '/'))==''?$key:substr($key,0,strpos($key, '/'));?>
		<tr id="<?php echo $plugin_id?>">
			<th scope="row" class="check-column">
				<label class="screen-reader-text" for="checkbox_0">Select <?php echo $plugin['Name']?></label>
				<input type="checkbox" name="blog[checked-plugins][]" value="<?php echo $key;?>" >
			</th>
			<td class="plugin-title">
				<strong><?php echo $plugin['Name'];?></strong>
			</td>
			<td class="column-description desc">
				<div class="plugin-description"><p><?php echo substr($plugin['Description'],0,strpos($plugin['Description'],'.'))==''?$plugin['Description']:substr($plugin['Description'],0,strpos($plugin['Description'],'.'))?>.</p></div>
			</td>
		</tr>	
	<?php endforeach;?>

</tbody>

</table>
<?php 
	if(isset($this->paginate['plugins']) && !empty($this->paginate['plugins'])){
		$paginate = $this->paginate['plugins'];
		$position = 'bottom';
		$paginateclass='paginate-plugins';
		include 'paginate.php';
	}
?>
<?php else:?>
	<p>No Plugins found.</p>
<?php endif;?>