<style>
	.asc_option_table{
		width: 100%;
		border-collapse: collapse;
    	
	}
	.asc_option_table tr th {
		text-align: left;font-size: 12px;
		background: #ddd;padding: 6px;
		border:1px solid #ccc;
	}
	.asc_option_table tr td{
		border: 1px solid #ccc;
		padding: 6px;
	}
	.asc_option_table tr td.label{
		width: 20%;
	}
	.asc_option_table tr td.values{
		width: 50%;
	}
	.ui-widget-content{
		background:#f1f1f1 !important; 
		
	}

</style>
<div class="wrap">
<h2><?php echo __('Advanced Site Creation: Build Site Settings');?></h2>
<p><?php echo __('This page enables you to build the settings you want to be available for a new site. These settings will be available when the "Create Site from Built Settings" is selected. You can also set random settings values for site creation.');?></p>

<p><strong>* Include on site creation</strong> - <em>Check this if you want the setting to be available during site creation. Otherwise it will use Wordpress default values.</em></p>

<p><strong>* Randomize</strong> - <em>Check this if you want the plugin to generate random values of a setting. Add/Remove the values for each setting you want to be available when applying the randomize command.</em></p>
<form name="asc_build_site_settings_frm" action="<?php echo network_admin_url('settings.php?page=asc_build_site_settings');?>" method="post">
<div id="accordion">
<h3>Reading Settings</h3>
<div>
	<h4>Blog pages show at most</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>posts_per_page</em></td>
		<td class="values">
			Min: <input name="posts_per_page_min" type="number" step="1" min="1" id="posts_per_page_min" value="<?php echo $this->build_site->getSettings('min','posts_per_page');?>" class="small-text"/>
			Max: <input name="posts_per_page_max" type="number" step="1" min="1" id="posts_per_page_max" value="<?php echo $this->build_site->getSettings('max','posts_per_page');?>" class="small-text"/> posts
		</td>
		<td><input name="posts_per_page_is_included" type="checkbox" id="posts_per_page_is_included" value="1" <?php if($this->build_site->getSettings('is_included','posts_per_page')==TRUE){echo 'checked';}?>></td>
		<td><input name="posts_per_page_is_rand" type="checkbox" id="posts_per_page_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','posts_per_page')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>

	<h4>Syndication feeds show the most recent</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>posts_per_rss</em></td>
		<td class="values">
			Min: <input name="posts_per_rss_min" type="number" step="1" min="1" id="posts_per_rss_min" value="<?php echo $this->build_site->getSettings('min','posts_per_rss');?>" class="small-text"/>
			Max: <input name="posts_per_rss_max" type="number" step="1" min="1" id="posts_per_rss_max" value="<?php echo $this->build_site->getSettings('max','posts_per_rss');?>" class="small-text"/> items
		</td>
		<td><input name="posts_per_rss_is_included" type="checkbox" id="posts_per_rss_is_included" value="1" <?php if($this->build_site->getSettings('is_included','posts_per_rss')==TRUE){echo 'checked';}?>></td>
		<td><input name="posts_per_rss_is_rand" type="checkbox" id="posts_per_rss_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','posts_per_rss')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>


	<h4>For each article in a feed, show</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>rss_use_excerpt</em></td>
		<td class="values">
			<?php $rss_use_excerpt = $this->build_site->getSettings('values','rss_use_excerpt');?>
			<select name="rss_use_excerpt[]" id="rss_use_excerpt" multiple>
				<?php foreach($rss_use_excerpt as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
				<?php endforeach;?>	
			</select>
		</td>
		<td><input name="rss_use_excerpt_is_included" type="checkbox" id="rss_use_excerpt_is_included" value="1" <?php if($this->build_site->getSettings('is_included','rss_use_excerpt')==TRUE){echo 'checked';}?>></td>
		<td><input name="rss_use_excerpt_is_rand" type="checkbox" id="rss_use_excerpt_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','rss_use_excerpt')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>


	<h4>Search Engine Visibility</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>blog_public</em></td>
		<td class="values">
			<p>Discourage search engines from indexing this site</p>
			<?php $blog_public = $this->build_site->getSettings('values','blog_public');?>
			<select name="blog_public[]" id="blog_public" multiple>
				<?php foreach($blog_public as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
				<?php endforeach;?>	
			</select> <br/>
			<p><em>It is up to search engines to honor this request.</em></p>
		</td>
		<td><input name="blog_public_is_included" type="checkbox" id="blog_public_is_included" value="1" <?php if($this->build_site->getSettings('is_included','blog_public')==TRUE){echo 'checked';}?>></td>
		<td><input name="blog_public_is_rand" type="checkbox" id="blog_public_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','blog_public')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>
</div>

<h3>Discussion Settings</h3>
<div>
	<h4>Default article settings</h4>
	<p><em>These are grouped settings. When 'randomize' is selected, it will generate combinations containing the below settings. 
	   <br/>Remove allowed values if you want to force a setting to display/randomize a default value.</em>
	</p>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>default_pingback_flag</em></td>
			<td class="values">
				<?php $default_pingback_flag = $this->build_site->getSettings('values','default_pingback_flag');?>
				<select name="default_pingback_flag[]" id="default_pingback_flag" multiple>
					<?php foreach($default_pingback_flag as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
					<?php endforeach;?>
				</select> <br/>
				<p><em>Attempt to notify any blogs linked to from the article</em></p>
			</td>
			<td><input name="default_pingback_flag_is_included" type="checkbox" id="default_pingback_flag_is_included" value="1" <?php if($this->build_site->getSettings('is_included','default_pingback_flag')==TRUE){echo 'checked';}?>></td>
			<td><input name="default_pingback_flag_is_rand" type="checkbox" id="default_pingback_flag_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','default_pingback_flag')==TRUE){echo 'checked';}?>></td>
		</tr>
		<tr>
			<td class="label"><em>default_ping_status</em></td>
			<td class="values">
				<?php $default_ping_status = $this->build_site->getSettings('values','default_ping_status');?>
				<select name="default_ping_status[]" id="default_ping_status" multiple>
					<?php foreach($default_ping_status as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
					<?php endforeach;?>
				</select> <br/>
				<p><em>Allow link notifications from other blogs (pingbacks and trackbacks)</em></p>
			</td>
			<td><input name="default_ping_status_is_included" type="checkbox" id="default_ping_status_is_included" value="1" <?php if($this->build_site->getSettings('is_included','default_ping_status')==TRUE){echo 'checked';}?>></td>
			<td><input name="default_ping_status_is_rand" type="checkbox" id="default_ping_status_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','default_ping_status')==TRUE){echo 'checked';}?>></td>
		</tr>
		<tr>
			<td class="label"><em>default_comment_status</em></td>
			<td class="values">
				<?php $default_comment_status = $this->build_site->getSettings('values','default_comment_status');?>
				<select name="default_comment_status[]" id="default_comment_status" multiple>
					<?php foreach($default_comment_status as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
					<?php endforeach;?>
				</select> <br/>
				<p><em>Allow people to post comments on new articles</em></p>
			</td>
			<td><input name="default_comment_status_is_included" type="checkbox" id="default_comment_status_is_included" value="1" <?php if($this->build_site->getSettings('is_included','default_comment_status')==TRUE){echo 'checked';}?>></td>
			<td><input name="default_comment_status_is_rand" type="checkbox" id="default_comment_status_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','default_comment_status')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>

	<h4>E-mail me whenever</h4>
	<p><em>These are grouped settings. When 'randomize' is selected, it will generate combinations containing the below settings. 
	   <br/>Remove allowed values if you want to force a setting to display/randomize a default value.</em>
	</p>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>comments_notify</em></td>
			<td class="values">
				<?php $comments_notify = $this->build_site->getSettings('values','comments_notify');?>
				<select name="comments_notify[]" id="comments_notify" multiple>
					<?php foreach($comments_notify as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
					<?php endforeach;?>
				</select> <br/>
				<p><em>Anyone posts a comment</em></p>
			</td>
			<td><input name="comments_notify_is_included" type="checkbox" id="comments_notify_is_included" value="1" <?php if($this->build_site->getSettings('is_included','comments_notify')==TRUE){echo 'checked';}?>></td>
			<td><input name="comments_notify_is_rand" type="checkbox" id="comments_notify_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','comments_notify')==TRUE){echo 'checked';}?>></td>
		</tr>
		<tr>
			<td class="label"><em>moderation_notify</em></td>
			<td class="values">
				<?php $moderation_notify = $this->build_site->getSettings('values','moderation_notify');?>
				<select name="moderation_notify[]" id="moderation_notify" multiple>
					<?php foreach($moderation_notify as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
					<?php endforeach;?>
				</select> <br/>
				<p><em>Users must be registered and logged in to comment (Signup has been disabled. Only members of this site can comment.)</em></p>
			</td>
			<td><input name="moderation_notify_is_included" type="checkbox" id="moderation_notify_is_included" value="1" <?php if($this->build_site->getSettings('is_included','moderation_notify')==TRUE){echo 'checked';}?>></td>
			<td><input name="moderation_notify_is_rand" type="checkbox" id="moderation_notify_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','moderation_notify')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>
</div>
<h3>Permalinks</h3>
<div>
	<h4>Common Settings</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>permalink_structure</em></td>
			<td class="values">
				<?php $permalink_structure = $this->build_site->getSettings('values','permalink_structure');?>
				<select name="permalink_structure[]" id="permalink_structure" multiple>
					<?php foreach($permalink_structure as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
					<?php endforeach;?>
				</select>
			</td>
			<td><input name="permalink_structure_is_included" type="checkbox" id="permalink_structure_is_included" value="1" <?php if($this->build_site->getSettings('is_included','permalink_structure')==TRUE){echo 'checked';}?>></td>
			<td><input name="permalink_structure_is_rand" type="checkbox" id="permalink_structure_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','permalink_structure')==TRUE){echo 'checked';}?>></td>
		</tr>
		<tr>
			<td class="label"><em>custom_selection</em></td>
			<td class="values">
				<p>Custom values for permalink_structure</p>
				<textarea rows="5" id="permalink_structure_custom" name="permalink_structure_custom"><?php echo $this->build_site->getSettings('values','permalink_structure_custom');?></textarea>
			</td>
			<td><input name="permalink_structure_custom_is_included" type="checkbox" id="permalink_structure_custom_is_included" value="1" <?php if($this->build_site->getSettings('is_included','permalink_structure_custom')==TRUE){echo 'checked';}?>></td>
			<td><input name="permalink_structure_custom_is_rand" type="checkbox" id="permalink_structure_custom_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','permalink_structure_custom')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>

	<h4>Optional</h4>
	<p>If you like, you may enter custom structures for your category and tag URLs here. For example, using topics as your category base would make your category links like http://example.org/topics/uncategorized/. If you leave these blank the defaults will be used.</p>
	<h4>Category Base</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>category_base</em></td>
			<td class="values">
				<textarea rows="5" id="category_base" name="category_base"><?php echo $this->build_site->getSettings('values','category_base');?></textarea>
			</td>
			<td><input name="category_base_is_included" type="checkbox" id="category_base_is_included" value="1" <?php if($this->build_site->getSettings('is_included','category_base')==TRUE){echo 'checked';}?>></td>
			<td><input name="category_base_is_rand" type="checkbox" id="category_base_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','category_base')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>
	<h4>Tag Base</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>tag_base</em></td>
			<td class="values">
				<textarea rows="5" id="tag_base" name="tag_base"><?php echo $this->build_site->getSettings('values','tag_base');?></textarea>
			</td>
			<td><input name="tag_base_is_included" type="checkbox" id="tag_base_is_included" value="1" <?php if($this->build_site->getSettings('is_included','tag_base')==TRUE){echo 'checked';}?>></td>
			<td><input name="tag_base_is_rand" type="checkbox" id="tag_base_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','tag_base')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>
</div>

<h3>Themes</h3>
<div>
	<h3>Allowed Themes</h3>
	<p><em>Select the themes you would like to be available during site creation</em></p>
	<table class="asc_option_table">
		<tr>
			<th>Avaiable Themes</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr>
		<tr>
			<td>
				<?php $themes = $this->build_site->getSettings('values','themes');?>
				<select name="themes[]" id="themes" multiple style="width:100%;">
					<?php foreach($themes as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
					<?php endforeach;?>
				</select>
			</td>
			<td><input name="themes_is_included" type="checkbox" id="themes_is_included" value="1" <?php if($this->build_site->getSettings('is_included','themes')==TRUE){echo 'checked';}?>></td>
			<td><input name="themes_is_rand" type="checkbox" id="themes_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','themes')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>
</div>

<h3>Plugins</h3>
<div>
	<h3>Allowed Plugins</h3>
	<p><em>Select the plugins you would like to be available during site creation.<br/>
	NOTE: Network enabled plugins are not included on this list as they are already activated, though if you choose to randomize settings, it will randomize them as well.</em></p>

	<table class="asc_option_table">
		<tr>
			<th>Avaiable Plugins</th>
			<th>Include on site creation</th>
			<th>Randomize Settings</th>
		</tr>
		<tr>
			<td>
				<?php $plugins = $this->build_site->getSettings('values','plugins');?>
				<select name="plugins[]" id="plugins" multiple style="width:100%;">
					<?php foreach($plugins as $option):?>
					<option value="<?php echo $option['value']?>" <?php if(!isset($option['excluded'])){echo 'selected';}?>> <?php echo $option['text']?> </option>
					<?php endforeach;?>
				</select>
			</td>
			<td><input name="plugins_is_included" type="checkbox" id="plugins_is_included" value="1" <?php if($this->build_site->getSettings('is_included','plugins')==TRUE){echo 'checked';}?>></td>
			<td><input name="plugins_is_rand" type="checkbox" id="plugins_is_rand" value="1" <?php if($this->build_site->getSettings('is_rand','plugins')==TRUE){echo 'checked';}?>></td>
		</tr>
	</table>
</div>

</div><!-- end Accordion -->
<br/>
<input type="hidden" name="build_site_settings_page_POST" value="Y" />
<input type="submit" name="submit" class="button-primary" value="Save Settings" /> 
</form>
</div>
<script>
	(function($) {
	    $(document).ready(function() {
	    	$('#accordion').accordion({
	    		collapsible: true,
	    		heightStyle: "content"
	    	});
	    	$("#start_of_week").select2({width: '100%'});
	    	$("#default_post_format").select2({width: '100%'});
	    	$('#use_smilies, #use_balanceTags').select2({width: 'element'});
	    	$('#rss_use_excerpt').select2({width: '100%'});
	    	$('#blog_public').select2({width: '100%'});
	    	$('#default_pingback_flag, #default_ping_status, #default_comment_status').select2({width: '100%'});
	    	$('#require_name_email, #comment_registration, #close_comments_for_old_posts, #thread_comments, #thread_comments_depth').select2({width: '100%'});
	    	$('#page_comments, #default_comments_page, #comment_order').select2({width: '100%'});
	    	$('#comments_notify, #moderation_notify').select2({width: '100%'});
	    	$('#comment_moderation, #comment_whitelist').select2({width: '100%'});
	    	$('#show_avatars').select2({width: '100%'});
	    	$('#avatar_rating').select2({width: '100%'});
	    	$('#avatar_default').select2({width: '100%'});
	    	$('#thumbnail_crop').select2({width: '100%'});
	    	$('#permalink_structure').select2({width: '100%'});
	    	$('#themes, #plugins').select2({width: '100%'});
	    });
	})(jQuery);
</script>