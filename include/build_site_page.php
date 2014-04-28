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

<a href="" class="button-secondary">Randomize Settings</a>
<br/><br/>
<form>
<div id="asc_site_settings">
	<h3>Default Settings</h3>
	<div>
		<table class="asc_option_table" width="100%">
			<tbody>
			<tr>
				<th>Site Address</th>
				<td>
				<input name="blog[domain]" type="text" class="regular-text" title="Domain"><span class="no-break">.local.wordpress.dev</span>
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

	<h3>General Settings</h3>
	<div></div>
	
	<h3>Writing Settings</h3>
	<div></div>

	<h3>Reading Settings</h3>
	<div></div>

	<h3>Discussion Settings</h3>
	<div></div>

	<h3>Media</h3>
	<div></div>

	<h3>Permalinks</h3>
	<div></div>

	<h3>Themes</h3>
	<div></div>

	<h3>Plugins</h3>
	<div></div>
</div>
<br/>
<a href="" class="button-secondary">Randomize Settings</a>
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
<script>
	(function($) {
	    $(document).ready(function() {
	    	$('#asc_site_settings').accordion({
	    		collapsible: true,
	    		heightStyle: "content"
	    	});
	    	
	    });
	})(jQuery);
</script>