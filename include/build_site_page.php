<style>
	.asc_option_table{
		
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
<h2><?php echo __('Advanced Site Creation: Build Site');?></h2>
<p> You can build a new site based on the settings you configured in <a href="#">Settings > Build Site Settings.</a> If you haven't configured the settings yet, It will use Wordpress default settings.</p>
<p> Press the 'Randomize Settings' button to generate random values for each settings. You can configure these values in <a href="#">Settings > Build Site Settings.</a> as well.</p>
<p> An option is available to Clone an existing site. An option is available as well to clone a site and apply the settings configured below.</p>

<a href="<?php echo network_admin_url('sites.php?page=asc_build_site&rand=true');?>" class="button-secondary">Randomize Settings</a>
<br/><br/>
<form method="post">
<div id="asc_site_settings">
	<h3>General Settings</h3>
	<div>
		<table class="asc_option_table" width="100%">
			<tbody>
			<tr>
				<th>Site Address</th>
				<td>
				<input name="blog[domain]" type="text" class="regular-text" title="Domain">
				<p>Only lowercase letters (a-z) and numbers are allowed.</p>			</td>
			</tr>
			<tr>
				<th scope="row">Site Title</th>
				<td><input name="blog[title]" type="text" class="regular-text" title="Title"></td>
			</tr>
			<tr>
				<th scope="row">Admin Email</th>
				<td><input name="blog[email]" type="text" class="regular-text" title="Email"></td>
			</tr>
			<tr>
				<td colspan="2">A new user will be created if the above email address is not in the database.<br>The username and password will be mailed to this email address.</td>
			</tr>
			<tr >
					<th scope="row">Domain Name</th>
					<td><input class="regular-text" type="text" title="Domain Name" name="blog[domain_name]"><p>Supply domain name that will be mapped to the site with the WordPress MU Domain Mapping plugin <br> <em>* WordPress MU Domain Mapping plugin must be activated</em></p></td>
			</tr>
		</tbody>
		</table>
	</div>

	<h3>Reading Settings</h3>
	<div>
		
		<table class="form-table">
			<tbody>
			<?php $posts_per_page = $this->build_site->getSiteSetting('posts_per_page');?>	
			<?php if($posts_per_page!==null):?>
			<tr>
				<th scope="row"><label for="posts_per_page">Blog pages show at most</label></th>
				<td>
				
				<input name="posts_per_page" type="number" step="1" min="1" id="posts_per_page" value="<?php echo $posts_per_page;?>" class="small-text"> posts</td>
			</tr>
			<?php endif;?>

			<?php $posts_per_rss = $this->build_site->getSiteSetting('posts_per_rss');?>	
			<?php if($posts_per_rss!==null):?>
			<tr>
			<th scope="row"><label for="posts_per_rss">Syndication feeds show the most recent</label></th>
			<td><input name="posts_per_rss" type="number" step="1" min="1" id="posts_per_rss" value="<?php echo $posts_per_rss;?>" class="small-text"> items</td>
			</tr>
			<?php endif;?>

			<?php $rss_use_excerpt = $this->build_site->getSiteSetting('rss_use_excerpt');?>	
			<?php if($rss_use_excerpt!==null):?>		
			<tr>
			<th scope="row">For each article in a feed, show </th>
			<td><fieldset><legend class="screen-reader-text"><span>For each article in a feed, show </span></legend>
			<p><label><input name="rss_use_excerpt" type="radio" value="0" <?php echo ($rss_use_excerpt==0)?'checked':""?>> Full text</label><br>
			<label><input name="rss_use_excerpt" type="radio" value="1" <?php echo ($rss_use_excerpt==1)?'checked':""?>> Summary</label></p>
			</fieldset></td>
			</tr>
			<?php endif;?>		

			<?php $blog_public = $this->build_site->getSiteSetting('blog_public');?>
			<?php if($blog_public!==null):?>
			<tr class="option-site-visibility">
			<th scope="row">Search Engine Visibility </th>
			<td><fieldset><legend class="screen-reader-text"><span>Search Engine Visibility </span></legend>
				<label for="blog_public"><input name="blog_public" type="checkbox" id="blog_public" value="0" <?php checked($blog_public,1)?>>
				Discourage search engines from indexing this site</label>
				<p class="description">It is up to search engines to honor this request.</p>
			</fieldset></td>
			</tr>
			<?php endif;?>

			</tbody>
			</table>
		</div>

		<h3>Discussion Settings</h3>
		<div>
			<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">Default article settings</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span>Default article settings</span></legend>
							<?php $default_pingback_flag = $this->build_site->getSiteSetting('default_pingback_flag');?>
							<?php if($default_pingback_flag!==null):?>
							<label for="default_pingback_flag">
							<input name="default_pingback_flag" type="checkbox" id="default_pingback_flag" value="1" <?php checked($default_pingback_flag,1)?>>
								Attempt to notify any blogs linked to from the article
							</label>
							<?php endif;?>
							<br>

							<?php $default_ping_status = $this->build_site->getSiteSetting('default_ping_status');?>
							<?php if($default_ping_status!==null):?>
							<label for="default_ping_status">
							<input name="default_ping_status" type="checkbox" id="default_ping_status" value="open" <?php checked ($default_ping_status,'open')?>>
							Allow link notifications from other blogs (pingbacks and trackbacks)
							</label>
							<?php endif;?>
							<br>

							<?php $default_comment_status = $this->build_site->getSiteSetting('default_comment_status');?>
							<?php if($default_comment_status!==null):?>
							<label for="default_comment_status">
							<input name="default_comment_status" type="checkbox" id="default_comment_status" value="open" <?php checked ($default_comment_status,'open')?>>
							Allow people to post comments on new articles</label>
							<br>
							<p class="description">(These settings may be overridden for individual articles.)</p>
							<?php endif;?>
						</fieldset>
					</td>
				</tr>
				
				<tr>
					<th scope="row">E-mail me whenever</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span>E-mail me whenever</span></legend>
							<?php $comments_notify = $this->build_site->getSiteSetting('comments_notify');?>
							<?php if($comments_notify!==null):?>
							<label for="comments_notify">
							<input name="comments_notify" type="checkbox" id="comments_notify" value="1" <?php checked ($comments_notify,1)?>>
							Anyone posts a comment </label>
							<?php endif;?>
							<br>

							<?php $moderation_notify = $this->build_site->getSiteSetting('moderation_notify');?>
							<?php if($moderation_notify!==null):?>
							<label for="moderation_notify">
							<input name="moderation_notify" type="checkbox" id="moderation_notify" value="1" <?php checked ($moderation_notify,1)?>>
							A comment is held for moderation </label>
							<?php endif;?>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>


	</div>

	<h3>Permalinks</h3>
	<div>
		<p>By default WordPress uses web <abbr title="Universal Resource Locator">URL</abbr>s which have question marks and lots of numbers in them; however, WordPress offers you the ability to create a custom URL structure for your permalinks and archives. This can improve the aesthetics, usability, and forward-compatibility of your links. A <a href="http://codex.wordpress.org/Using_Permalinks">number of tags are available</a>, and here are some examples to get you started.</p>
		<h4 class="title">Common Settings</h4>

		<?php
		$prefix = $blog_prefix = '';
		if ( ! got_url_rewrite() )
		$prefix = '/index.php';
		if ( is_multisite() && !is_subdomain_install() && is_main_site() )
		$blog_prefix = '/blog';
		if ( is_multisite() && !is_subdomain_install() && is_main_site() ) {
			$permalink_structure = preg_replace( '|^/?blog|', '', $permalink_structure );
			$category_base = preg_replace( '|^/?blog|', '', $category_base );
			$tag_base = preg_replace( '|^/?blog|', '', $tag_base );
		}

		$structures = array(
			0 => '',
			1 => $prefix . '/%year%/%monthnum%/%day%/%postname%/',
			2 => $prefix . '/%year%/%monthnum%/%postname%/',
			3 => $prefix . '/' . _x( 'archives', 'sample permalink base' ) . '/%post_id%',
			4 => $prefix . '/%postname%/',
		);
		?>

		<table class="form-table permalink-structure">
			<?php $permalink_structure = $this->build_site->getSiteSetting('permalink_structure');?>
			<?php if($permalink_structure!==null):?>
				<tr>
					<th><label><input name="selection" type="radio" value="" <?php checked('', $permalink_structure); ?>/> <?php _e('Default'); ?></label></th>
					<td><code><?php echo get_option('home'); ?>/?p=123</code></td>
				</tr>
				<tr>
					<th><label><input name="selection" type="radio" value="<?php echo esc_attr($structures[1]); ?>" <?php checked($structures[1], $permalink_structure);?>/> <?php _e('Day and name'); ?></label></th>
					<td><code><?php echo get_option('home') . $blog_prefix . $prefix . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . _x( 'sample-post', 'sample permalink structure' ) . '/'; ?></code></td>
				</tr>
				<tr>
					<th><label><input name="selection" type="radio" value="<?php echo esc_attr($structures[2]); ?>" <?php checked($structures[2], $permalink_structure);?>/> <?php _e('Month and name'); ?></label></th>
					<td><code><?php echo get_option('home') . $blog_prefix . $prefix . '/' . date('Y') . '/' . date('m') . '/' . _x( 'sample-post', 'sample permalink structure' ) . '/'; ?></code></td>
				</tr>
				<tr>
					<th><label><input name="selection" type="radio" value="<?php echo esc_attr($structures[3]); ?>" <?php checked($structures[3], $permalink_structure);?>/> <?php _e('Numeric'); ?></label></th>
					<td><code><?php echo get_option('home') . $blog_prefix . $prefix . '/' . _x( 'archives', 'sample permalink base' ) . '/123'; ?></code></td>
				</tr>
				<tr>
					<th><label><input name="selection" type="radio" value="<?php echo esc_attr($structures[4]); ?>" <?php checked($structures[4], $permalink_structure);?>/> <?php _e('Post name'); ?></label></th>
					<td><code><?php echo get_option('home') . $blog_prefix . $prefix . '/' . _x( 'sample-post', 'sample permalink structure' ) . '/'; ?></code></td>
				</tr>
			<?php endif?>
			<tr>
				<th>
					<label><input name="selection" id="custom_selection" type="radio" value="custom" <?php checked( !in_array($permalink_structure, $structures) ); ?> />
					<?php _e('Custom Structure'); ?>
					</label>
				</th>
				<td>
					<code><?php echo get_option('home') . $blog_prefix; ?></code>
					<input name="permalink_structure" id="permalink_structure" type="text" value="<?php echo esc_attr($permalink_structure); ?>" class="regular-text code" />
				</td>
			</tr>
		</table>
		<h4 class="title">Optional</h4>

		<p>If you like, you may enter custom structures for your category and tag <abbr title="Universal Resource Locator">URL</abbr>s here. For example, using <code>topics</code> as your category base would make your category links like <code>http://example.org/topics/uncategorized/</code>. If you leave these blank the defaults will be used.</p>
		<table class="form-table">
			<tbody>
				<?php $category_base = $this->build_site->getSiteSetting('category_base');?>
				<?php if($category_base!==null):?>
				<tr>
					<th><label for="category_base">Category base</label></th>
					<td> <input name="category_base" id="category_base" type="text" value="<?php echo esc_attr($category_base); ?>" class="regular-text code"></td>
				</tr>
				<?php endif?>
				<?php $tag_base = $this->build_site->getSiteSetting('tag_base');?>
				<?php if($tag_base!==null):?>
				<tr>
					<th><label for="tag_base">Tag base</label></th>
					<td> <input name="tag_base" id="tag_base" type="text" value="<?php echo esc_attr($tag_base); ?>" class="regular-text code"></td>
				</tr>
				<?php endif?>
			</tbody>
		</table>
	</div>
	<?php $themes = $this->build_site->getSiteSetting('themes');?>
	<?php if($themes!==null):?>
	<h3>Themes</h3>
	<div>
		<p>Select a theme that will be automatically set to the site.</p>
		<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><?php _e('Select Theme');?></th>
				<td>
					<select title="Theme" name="theme-id" id="theme-id-multi" style="width:50%">
						<?php if(!empty($this->build_site->_default_settings['themes']['values'])):?>
							<?php foreach($this->build_site->_default_settings['themes']['values'] as $theme):?>
							<?php if(in_array($theme['value'],$this->build_site->_user_settings['themes']['values'])):?>
								<option value="<?php echo $theme['value']?>" <?php selected($theme['value'],$themes)?>><?php echo $theme['text']?></option>	
							<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					</select>
				</td>
			</tr>
		</tbody>
		</table>
	</div>
	<?php endif;?>
	<?php $plugins = $this->build_site->getSiteSetting('plugins');?>
	<?php if($plugins!==null):?>

	<h3>Plugins</h3>
	<div>
		<p>Select the plugins that will be automatically activated to the site.</p>
		<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><?php _e('Select Plugins');?></th>
				<td>
					<select multiple title="plugins" name="plugins[]" id="plugins-multiselect" style="width:100%">
						<?php foreach($this->build_site->_default_settings['plugins']['values'] as $plugin):?>
						<?php if(in_array($plugin['value'],$this->build_site->_user_settings['plugins']['values'])):?>
							<option value="<?php echo $plugin['value']?>" selected><?php echo $plugin['text']?></option>	
						<?php endif;?>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
		</tbody>
		</table>
		<?php if($this->build_site->_user_settings['plugins']['is_rand']):?>
		<p><em>* Plugin settings will be randomized.</em></p>
		<?php endif;?>
	</div>
	<?php endif;?>
</div>
<br/>
<a href="<?php echo network_admin_url('sites.php?page=asc_build_site&rand=true');?>" class="button-secondary">Randomize Settings</a>
</div>
<br />
<h3>Build Site from Template</h3>
<table>
	<tbody>
		<tr valign="top">
			<td>
				<label><input name="create-site-from-template" type="checkbox" id="create-site-from-template" checked="checked"> Copy templates, plugins and settings from a site.</label>
			</td>
		</tr>
		<tr valign="top">
			<td>
				<label><input name="overwrite-clone-site-settings" type="checkbox" id="overwrite-clone-site-settings" checked="checked"> Overwrite cloned site settings. Copy templates, plugins and settings from a site but use the above settings instead.</label>
			</td>
		</tr>
	</tbody>
</table>
<br/>
<table class="asc_option_table">
			<tr>
				<th scope="row">Site template</th>
				<td>
					<select id="clone-site-template">
						<option value="">site-template.local.wordpress.dev</option>
					</select> 
				</td>
			</tr>
			<tr>
				<th scope="row">Site User</th>
				<td>
					<select id="clone-site-user">
					<option value="1">admin</option>
					</select> 
				</td>
			</tr>
</table>
<p><em>* For <strong>Plugins</strong>, unchecking the above clone options will activate plugins selected on the settings group.</em></p>
<input type="submit" name="submit" class="button-primary" value="Build New Site" /> 
</form>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function() {
	jQuery('.permalink-structure input:radio').change(function() {
		if ( 'custom' == this.value )
			return;
		jQuery('#permalink_structure').val( this.value );
	});
	jQuery('#permalink_structure').focus(function() {
		jQuery("#custom_selection").attr('checked', 'checked');
	});
});
//]]>
</script>
<script>
	(function($) {
	    $(document).ready(function() {
	    	$('#asc_site_settings').accordion({
	    		collapsible: true,
	    		heightStyle: "content"
	    	});
	    	$('#theme-id-multi, #plugins-multiselect').select2({width: '100%'});
	    });
	})(jQuery);
</script>