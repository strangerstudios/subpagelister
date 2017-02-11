=== Subpagelister ===
Contributors: kimannwall, strangerstudios
Tags: theme, shortcode, content, index, table of contents
Requires at least: 4.0
Tested up to: 4.7.3
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shows a list of a given page’s subpages, with optional excerpt, link, button, and images.

== Description ==

Enter the shortcode [subpagelist] in any page or post to generate the list. An example shortcode an all shortcode attributes are displayed below:

= Example Subpagelist Shortcode =
[subpagelist exclude="3,5" layout="3col" link="true" orderby="title" order="ASC" show="excerpt" thumbnail="thumbnail"]

= Shortcode Attributes Include: =
<ul>
	<li>exclude: A comma-separated list of the page IDs to exclude from display. (default: none)</li>
	<li>layout: Set this attribute if you would like to list the pages in columns; accepts "2col", "3col" or "4col". (default: 1 column)</li>
	<li>link: Hyperlink the page title; accepts "true" or "false". (default: true)</li>
	<li>orderby: Accepts any orderby parameter as <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters">defined in the codex</a>. (default: menu_order)</li>
	<li>order: Accepts ASC or DESC as <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters">defined in the codex</a>. (default: ASC)</li>
	<li>post_parent: Override the parent page ID to pull in a different list of subpages; accepts any page ID. (default: current page ID)</li>
	<li>show: Display "excerpt", "content", or "none". (default: excerpt)</li>
	<li>show_children: Optionally display an unordered list of the child page's children; accepts "true" or "false". (default: none)</li>
	<li>thumbnail: Optionally hide or show the subpage's featured image; accepts "thumbnail", "medium", "large" or "false". (default: false)</li>
</ul>

== Installation ==

= Download, Install and Activate =
In your WordPress admin, go to Plugins > Add New to install Subpagelister, or:

1. Download the latest version of the plugin.
2. Unzip the downloaded file to your computer.
3. Upload the /subpagelister/ directory to the /wp-content/plugins/ directory of your site.
4. Activate the plugin through the 'Plugins' menu in WordPress.

= Start Using the Shortcodes =
Browse the Subpagelister documentation to see all shortcode attributes, and to view sample shortcode demos.

[View Documentation](http://strangerstudios.com/plugins/subpagelister/)

== Screenshots ==
1. Screen
 
== Frequently Asked Questions ==

= Where can I find Subpagelister documentation? =
For help setting up and configuring the Memberlite Shortcodes plugin, please refer to [documentation](http://strangerstudios.com/plugins/subpagelister/).

== Changelog ==

= 1.0 =
Initial Release
