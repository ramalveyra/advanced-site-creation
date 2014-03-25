<div class="wrap">
<h2><?php echo __('Advanced Site Creation: Settings');?></h2>
<p><?php echo __('Select the settings you want to be applied when creating a new site.');?></p>
<?php 
	if(isset($_POST['network_settings_save'])):?>
	<div id="message" class="updated"><p><strong><?php _e('Settings saved.')?></strong></p></div>	
<?php endif;?>
<form method="post">
	<?php
		//create nonce hidden field for security
		wp_nonce_field( 'save-network-settings', 'asc-settings-network-plugin' );
	;?>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php echo __('Remove default site creation')?></th>
				<td>
					<label><input name="network_settings[removedefaultadd]" type="checkbox" id="network_settings[removedefaultadd]" <?php checked( $removedefaultadd, 'on' ); ?>> <?php echo __('Remove the default "Sites > Add New" from the menu and use the Advance site creation')?>.</label>
				</td>
			</tr>
		</tbody>
	</table>
	<h3><?php _e('Theme selection settings');?></h3>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php _e('Show themes list as')?></th>
				<td>
					<label><input name="network_settings[themedisplay]" type="radio" id="network_settings[themedisplay1]" value="default" <?php if(!isset($this->network_settings['themedisplay'])){echo "checked";}?> <?php checked( 'default', $this->network_settings['themedisplay'], true )?>> <?php _e('Default.  Display themes as list including a theme\'s preview');?></label><br/>
					<label><input name="network_settings[themedisplay]" type="radio" id="network_settings[themedisplay2]" value="dropdown" <?php checked( 'dropdown', $this->network_settings['themedisplay'], true )?>> <?php _e('As dropdown.  Themes are selected via dropdown option.');?></label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Themes Per Page')?></th>
				<td>
					<input type="number" step="1" min="1" max="999" class="screen-per-page" name="network_settings[themesperpage]" id="network_settings[themesperpage]" maxlength="3" value="<?php echo isset($this->network_settings['themesperpage'])?$this->network_settings['themesperpage']:10?>">
					<p class="description"><?php _e('Limit the number of themes displayed per page when "Default" list view is selected.')?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<h3><?php _e('Plugin selection settings');?></h3>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php _e('Show plugins list as')?></th>
				<td>
					<label><input name="network_settings[plugindisplay]" type="radio" id="network_settings[plugindisplay1]" value="default" <?php if(!isset($this->network_settings['plugindisplay'])){echo "checked";}?> <?php checked( 'default', $this->network_settings['plugindisplay'], true )?>> <?php _e('Default.  Display plugins as a list with plugin description.');?></label><br/>
					<label><input name="network_settings[plugindisplay]" type="radio" id="network_settings[plugindisplay2]" value="multi-select" <?php checked( 'multi-select', $this->network_settings['plugindisplay'], true )?>> <?php _e('Multi-Value Select .  Plugins can be activated by selecting them on a multi-value select field.');?></label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Plugins Per Page')?></th>
				<td>
					<input type="number" step="1" min="1" max="999" class="screen-per-page" name="network_settings[pluginsperpage]" id="network_settings[pluginsperpage]" maxlength="3" value="<?php echo isset($this->network_settings['pluginsperpage'])?$this->network_settings['pluginsperpage']:10?>">
					<p class="description"><?php _e('Limit the number of plugins displayed per page when "Default" view is selected.')?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit"><input type="submit" name="network_settings_save" id="network_settings_save" class="button button-primary" value="<?php _e('Save Changes');?>"></p>
</form>
</div>
