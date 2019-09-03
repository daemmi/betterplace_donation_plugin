=== Betterplace Donation Plugin ===
Contributors: daemmi
Donate link: https://profiles.wordpress.org/daemmi
Tags: betterplace, donation
Tested up to: 5.2.1
Requires at least: 3.8.0
Requires PHP: 5.2.0
Stable tag: 1.0.0
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html

Show you donations from Betterplace

== Description ==

Show you donations from Betterplace

= Features =
shortcodes:
1. better-dc-donation-counter
    - animation - [1] (bool)
        1. 1 - on
        2. 0 - off

    - min - [0] (numeric)
        Start value of the amount 

    - max - [20000] (numeric)
        Maximum value of the donation, equal to 100% of the animation
    
    - donations - [0] (numeric)
        Current amount of donation set by hand

    - height - [donations] (string)
        1. donations - The height of the animation image will be calculated by 
            the values from max and donations
        2. XX% - Set the height manual in percentage 

    - offset - [0] (numeric)
        A offset wich will be added to the donations amount.

    - project_id - [null] (numeric)
        - If a Betterplace project id is set the donations value will be taken 
            from the Betterplace database via api and given id.

    - width - [null] (bool)
        1. 1 - on, the animation will be in width and not height. The setting for height will be used for the width
        2. 0 - off

    - scale_box_class - [null] (string)
        Class for the outer div for own css styles

    - scale_content_class - [null] (string) 
        Class for the inner div for own css styles

    - image - [1] (bool)
        1. 1 - shows images in scale divs
        2. 0 - no images

    - content - [1] (bool)
        1. 1 - shows donation content in scale div
        2. 0 - no content

    - only_numeric - [0] (bool)
        1. 1 - shows only the donation amount and counts up
        2. 0 - normal animation

== Installation ==

This section describes how to install and use the plugin.

1. Install automatically through the `Plugins` menu and `Add New` button (or upload the entire `betterplace_donation_counter` folder to the `/wp-content/plugins/` directory)
2. Activate the plugin
6. Use the shortcodes in a post or page to show your donations

== Screenshots ==

== Frequently Asked Questions ==

== Changelog ==

= 1.0.3 (2019-09-03) =
* first release