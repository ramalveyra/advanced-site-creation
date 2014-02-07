# Advanced Site Creation Settings [Multisite]

This plugin is used to extend the default "Site > Add New" functionality in Wordpress Multisite.

Upon installation and activation, this plugin will add a new option - "Sites > Add New (Advanced)" option.

This updated menu will contain the advance site creation features.

Features include:
- Automatically use domain mapping for the site using the Wordpress MU Domain mapping plugin
- Automatically set a theme for the new site
- Automatically activate plugins for the new site

## Plugin requirements
1. Wordpress Multisite must be enabled.
    - Wordpress MU must be enabled to use this plugin see http://codex.wordpress.org/Create_A_Network on how to enable Wordpress MU.
    - Super admin previliges are needed to use the plugin
2. WordPress MU Domain Mapping must be installed and setup.
    - The plugin's domain mapping feature is linked to this plugin and must be installed/activated first for the plugin to work. See http://ottopress.com/2010/wordpress-3-0-multisite-domain-mapping-tutorial/ on how to install and set it up.

## Installation
1. Copy the plugin directory into your `wp-content/plugins` directory
2. Login as the super admin user.
3. Make sure you are inside the Network admin by navigation to "My Sites > Network Admin > Dashboard".
3. Navigate to the "Plugins" dashboard page.
3. Activate this plugin.

## Plugin use
After the plugin has been installed and activated, you should be able to see an updated site creation page via "Sites > Add New (Advanced)".

"Site Address", "Site Title" and "Admin Email" are still required fields.

Domain Name
- value entered on this field will create a new domain mapping entry
- use valid addresses e.g. test.co, sample.wordpress.dev etc.
- leaving the field blank will just create a site without any mapped domain

Themes
- Themes under "Themes > Installed Themes" will automatically be included to the list of themes.
- Select a theme by clicking on the desired theme you want the new site to use upon creation. An "Active" status will be displayed when a theme is selected.
- If there are no themes selected, the new site will use the default wordpress mu theme setup.
- You can change the way how the Themes list is displayed by changing the plugin settings (see Settings).

Plugins
- Plugins under "Plugins > Installed Plugins" will automatically be included to the list of plugins that can be activated.
- Select the plugins you want to be automatically activated on the new site by checking them.
- You can change the way how the Plugin list is displayed by changing the plugin settings (see Settings).

After the site has been successfully created, checked whether the configurations are correct for the newly created site.

If you have setup a domain name to be mapped, go to "Settings > Domains" to see if has been configured.

Depending the setup you made for domain name, check the newly created site by accessing its url.

You could also check if the plugins were activated correctly by logging into the site's dashboard. You may need to login as admin or superuser or you may need to setup some multisite users and access to view the dashboard.

## Plugin Settings
You can customise the way items are displayed on the plugin by going to "Settings > Advanced Site Creation Settings".

Avaliable Settings:
- Remove default site creation: Select this if you want to remove the default "Add New" for site creation.
- Theme Selection
 - Select "Default" to view the themes as a list with theme screenshot (you can search a theme by using the search box)
    - When this is selected, you can limit the number of themes listed per page by supplying it to the "Themes Per Page" option. This will be ignored if the option as "dropdown" is selected instead.
 - As dropdown. The themes will be displayed as a dropdown options.
- Plugin Selection
 - Select "Default" to view list of available plugins with description. You search the plugin by using the search box.
    - You can limit the number of Plugins per page by supplying the limits on "Plugins per page" option. This will be ignored if "multi-value" is selected instead.
 - Selecting "Multi value" will show the list of plugins inside a multi value select box. 

##Contributors
[@ramalveyra](https://github.com/ramalveyra)
