=== Subpagelister ===
Contributors: kimannwall, strangerstudios
Tags: theme, shortcode, content, index, table of contents
Requires at least: 4.0
Tested up to: 4.7.3
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Dynamic content organization with flexible display options.

== Description ==

Shows a list of subpages, with display options for content or excerpts, buttons and links, featured images, and layout. Enter the shortcode [subpagelist] in any page to generate the list. An example shortcode and all shortcode attributes are displayed below:

= Example Subpagelist Shortcode =
[subpagelist exclude="3,5" layout="3col" link="true" orderby="title" order="ASC" show="excerpt" thumbnail="thumbnail"]

= Shortcode Attributes Include: =
* exclude: A comma-separated list of the page IDs to exclude from display. (default: none)
* layout: Set this attribute if you would like to list the pages in columns; accepts "2col", "3col" or "4col". (default: 1 column)
* link: Hyperlink the page title; accepts "true" or "false". (default: true)
* link_text: The "more link" text to display. Accepts "your custom text". (default: "(more...)")
* orderby: Accepts any orderby parameter as [defined in the codex](https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters). (default: menu_order)
* order: Accepts ASC or DESC as [defined in the codex](https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters). (default: ASC)
* post_parent: Override the parent page ID to pull in a different list of subpages; accepts any page ID. (default: current page ID)
* show: Display "excerpt", "content", or "none". (default: excerpt)
* show_children: Optionally display an unordered list of the child page's children; accepts "true" or "false". (default: false)
* thumbnail: Optionally show the subpage's featured image; accepts "thumbnail", "medium", "large" or "false". (default: false)
* thumbnail_align: Optionally force the alignment of the featured image. Leave blank to inherit the suggest alignment for the given layout; accepts "center", "left", "right", "none". (default: false)

== Installation ==

= Download, Install and Activate =
In your WordPress admin, go to Plugins > Add New to install Subpagelister, or:

1. Download the latest version of the plugin.
2. Unzip the downloaded file to your computer.
3. Upload the /subpagelister/ directory to the /wp-content/plugins/ directory of your site.
4. Activate the plugin through the 'Plugins' menu in WordPress.

= Start Using the Shortcodes =
Browse the Subpagelister documentation to see all shortcode attributes and to view sample shortcode demos.

[View Documentation](http://strangerstudios.com/subpagelister/)

== Screenshots ==
1. Sample shortcode output of [subpagelist link="button" link_text="Keep Reading" orderby="title" show="excerpt" thumbnail="medium" thumbnail_align="left"]
2. Sample shortcode output of [subpagelist layout="3col" link="button" link_text="Keep Reading" orderby="title" show="none" thumbnail="medium"]
3. Sample shortcode output of [subpagelist layout="2col" orderby="title" show="excerpt" thumbnail="true"]

== Frequently Asked Questions ==

= Where can I find Subpagelister documentation? =
For help setting up and configuring the Subpagelister plugin, please refer to [documentation](http://strangerstudios.com/subpagelister/).

== Changelog ==

= 1.0 =
Initial Release
