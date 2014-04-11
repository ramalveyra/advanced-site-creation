<?php if ( isset($_GET['update']) ) {
			$messages = array();
			if ( 'added' == $_GET['update'] )
				$messages[] = sprintf( __( 'Site added. <a href="%1$s">Visit Dashboard</a> or <a href="%2$s">Edit Site</a>' ), esc_url( get_admin_url( absint( $_GET['id'] ) ) ), network_admin_url( 'site-info.php?id=' . absint( $_GET['id'] ) ) );
		}
?>
<div class="wrap">
<h2 id="add-new-site"><?php _e('Add New Site') ?></h2>
<?php
if ( ! empty( $messages ) ) {
	foreach ( $messages as $msg )
		echo '<div id="message" class="updated"><p>' . $msg . '</p></div>';
} ?>
<form method="post" action="<?php echo $form_action; ?>" id="add-site-advanced-frm">
<?php wp_nonce_field( 'add-blog', '_wpnonce_add-blog' ) ?>
	<table class="form-table">
		<tr class="form-field form-required">
			<th scope="row"><?php _e( 'Site Address' ) ?></th>
			<td>
			<?php if ( is_subdomain_install() ) { ?>
				<input name="blog[domain]" type="text" class="regular-text" title="<?php esc_attr_e( 'Domain' ) ?>"/><span class="no-break">.<?php echo preg_replace( '|^www\.|', '', $current_site->domain ); ?></span>
			<?php } else {
				echo $current_site->domain . $current_site->path ?><input name="blog[domain]" class="regular-text" type="text" title="<?php esc_attr_e( 'Domain' ) ?>"/>
			<?php }
			echo '<p>' . __( 'Only lowercase letters (a-z) and numbers are allowed.' ) . '</p>';
			?>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row"><?php _e( 'Site Title' ) ?></th>
			<td><input name="blog[title]" type="text" class="regular-text" title="<?php esc_attr_e( 'Title' ) ?>"/></td>
		</tr>
		<tr class="form-field form-required default-site-creation" style="display:none;">
			<th scope="row"><?php _e( 'Admin Email' ) ?></th>
			<td><input name="blog[email]" type="text" class="regular-text" title="<?php esc_attr_e( 'Email' ) ?>"/></td>
		</tr>
		<tr class="form-field">
			<td colspan="2"><?php _e( 'A new user will be created if the above email address is not in the database.' ) ?><br /><?php _e( 'The username and password will be mailed to this email address.' ) ?></td>
		</tr>
	</table>
	<h3 style="width:100%"><?php _e('Advanced Site Settings')?></h3>
	<p><em><?php _e('Select the advanced settings you want to be applied to a new sites');?></em></p>
	<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><?php _e('Domain Name');?></th>
				<td><input class="regular-text" type="text" title="Domain Name" name="blog[domain_name]"><p><?php echo __('Supply domain name that will be mapped to the site with the WordPress MU Domain Mapping plugin')?> <br> <em><?php echo __('* WordPress MU Domain Mapping plugin must be activated')?></em></p></td>
			</tr>
		</tbody>
	</table>
	<h3 style="width:100%"><?php _e('Customize Site')?></h3>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php _e('Clone site')?></th>
				<td>
					<label><input name="create-site-from-template" type="checkbox" id="create-site-from-template" checked="checked"> <?php echo __('Copy templates, plugins and settings from a site')?>.</label>
				</td>
			</tr>
		</tbody>
	</table>

	<div id="clone-site-options">
	<?php wp_nonce_field( 'clone-site', '_wpnonce_clone-site' ) ?>
	<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><?php _e('Site template');?></th>
				<td>
					<select id="clone-site-template" style="width: 50%;">
						<?php // loop through blogs and echo them
						if ($subdomain_install) {
							foreach ($the_blogs as $a_blog) {
								echo "<option value=\"$a_blog->blog_id\">$a_blog->domain</option>";
							}
						} else { 
							foreach ($the_blogs as $a_blog) {
								echo "<option value=\"$a_blog->blog_id\">$a_blog->path</option>";
							}
						}
						?>
					</select> <br> <em><?php echo __('Select site as template. New site will have the same theme, plugins and settings of this source site.')?></em></p></td>
			</tr>
			<tr class="form-field form-required">
				<th scope="row"><?php _e('Site User');?></th>
				<td>
					<select id="clone-site-user" style="width: 50%;">
						<?php // loop through users and echo them
						foreach ($the_users as $a_user) {
							echo "<option value=\"$a_user->ID\">$a_user->user_login</option>";
						}
						?>
					</select> <br> <em><?php echo __('Select the user who will become the admin for the new site.')?></em></p></td>
			</tr>
			<tr class="form-field">
				<td>
					<pre id="clone-log"></pre>
				</td>
			</tr>
		</tbody>
	</table>
	</div>

	<div id="default-site-options" style="display: none;"> <!-- site creation option-->
	<?php switch($this->network_settings['themedisplay']){
		case 'dropdown':?>
		<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><?php _e('Select Theme');?></th>
				<td>
					<select title="Theme" name="theme-id" id="theme-id-multi" style="width:50%">
					<option></option>
						<?php if(!empty($this->themes)):?>
							<?php foreach($this->themes as $theme):?>
							<option value="<?php echo $theme->get_stylesheet();?>"><?php echo $theme->display('Name');?></option>	
							<?php endforeach;?>
						<?php endif;?>
					</select>
				</td>
			</tr>
		</tbody>
		</table>
		<?php break;?>
		<?php default:?>
			<h4 style="width:100%;font-size:14px"><?php _e('Site Theme');?></h4>
			<p><?php _e('Select a theme for the site')?> </p>
			<div class="theme-browser rendered">
			<?php include('theme-inc.php');?>
			</div>
			<input type="hidden" name="theme-id" id="theme-id" value="" />
	<?php break;}?>

	<?php switch($this->network_settings['plugindisplay']){
		case 'multi-select':?>
		<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><?php _e('Select Plugins');?></th>
				<td>
					<select multiple title="plugins" name="blog[checked-plugins][]" id="plugins-multiselect" style="width:100%">

						<?php if(!empty($this->allowedPlugins)):?>
							<?php foreach($this->allowedPlugins as $key=>$plugin):?>
							<?php $plugin_id = substr($key,0,strpos($key, '/'))==''?$key:substr($key,0,strpos($key, '/'));?>
							<option value="<?php echo $key;?>"><?php echo $plugin['Name'];?></option>	
							<?php endforeach;?>
						<?php endif;?>
					</select>
				</td>
			</tr>
		</tbody>
		</table>
		<?php break;?>
		<?php default:?>
		<h4 style="width:100%;font-size:14px"><?php _e('Plugins');?></h4>
		<p><?php _e('Select Plugins you want to add to the site');?> </p>
		<div class="plugins-browser">
			<?php include('plugins-inc.php');?>
		</div>
		<?php break;}?>

	<h3 style="width:100%"><?php _e('New Site Custom Settings')?></h3>
	<p><em><?php _e('Select custom settings that will be applied to the newly created site');?></em></p>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php echo __('Default article settings')?></th>
				<td>
					<label><input name="blog[disable_comments]" type="checkbox" id="blog[disable_comments]" > <?php echo __('Disable comments &amp; pingbacks/trackbacks')?>.</label>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php echo __('Default site post/page')?></th>
				<td>
					<label><input name="blog[remove_default_postpage]" type="checkbox" id="blog[remove_default_postpage]" > <?php echo __('Remove "Hello World" post and "Sample Page" added by Wordpress')?>.</label>
				</td>
			</tr>
		</tbody>
	</table>
	</div><!-- end site creation option -->
	<div class="preloader" style="display:none;"><img src="<?php echo ASC_PLUGIN_URL?>include/ajax-loader.gif" /></div>
	<?php submit_button( __('Add Site'), 'primary', 'add-site' ); ?>
	</form>
</div>