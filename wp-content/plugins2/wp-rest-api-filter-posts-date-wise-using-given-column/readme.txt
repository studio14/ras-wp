=== WP REST API - Filter posts date wise using given column ===
Contributors: vigneshsundar
Tags: post filter, wordpress rest api, filter modified posts, wordpress api, filters
Requires at least: 4.7
Tested up to: 4.8.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

== Description ==
In WordPress 4.7, Posts cannot be filtered based on `modified`, `modified_gmt`, `date_gmt` fields.
Using this plugin we can specify the column(any of `date`, `date_gmt`, `modified`, `modified_gmt`) as query parameter `date_query_column` to query against value(s) given in `before` and/or `after` query parameters.

= Usage =

Use the `date_query_column` parameter on any post endpoint such as `/wp/v2/posts` or `/wp/v2/pages` in combination with `before` and/or `after` parameter.

`
/wp-json/wp/v2/posts?after=2017-11-08T13:07:09&date_query_column=modified
`
