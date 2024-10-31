=== Runners Log ===
Contributors: frold, michaellasmanis, TheRealEyeless
Donate link: http://www.liljefred.dk
Tags: plugin, sport, training, running, activity log, fitness, stats, statistics, garmin, VDOT, BMI, calculator, Training Zones, Race Time Calculator, Training Pace, Body Mass Index, gear, gear management
Requires at least: 2.7
Tested up to: 4.9.8
Requires PHP: 5.2.4
Stable tag: 3.9.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin let you convert your blog into a training log and let you track your activities. You get advance statistics and running related calculators. See screenshots.

== Description ==
This plugin let you convert your blog into a training log and let you track your activities. You get advance statistics and running related calculators. See screenshots.

Track your distance, pulse, calories or time and get the graphs you want. We support area-, bar-, column-, line-, pie-, 3dpie-, donutpie-, scatter-graph or table. You can get data for a given month or a whole given year. See screenshots.

You'r able to use a variety of calculators; Training Zones Calculator, VDOT calculator, V02max-Calculator, Race Time Calculator, Training Pace Calculator, Body Mass Index Calculator, Calculate Predicted effect of change in weight.

You can add graphs using Google Chart see FAQ for howto use it.

== Installation ==
This section describes how to install the plugin and get it working.

1. Copy all files to `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use this short code `[runners_log_basic]` in a post or page. 
Alternativly place this `<?php if (function_exists(runners_log_basic)) echo runners_log_basic(); ?>` in your templates to have basic statistics. It gives you data like: 
	* Meters: 8500
    * Time: 00:49:59
    * Km/hour: 10.2
    * Min/km: 05:52 minutes
    * Puls average: 172 bpmis 86% of Max HR and 80% of HRR
    * Calories: 654 C
    * Garmin Connect Link: http://connect.garmin.com/activity/id
	* 2009: 693.7 km based on 122 runs with an avg of 5.69 km
	* 2010: 727.9 km based on 85 runs with an avg of 8.56 km
	* 2011: 539.3 km based on 70 runs with an avg of 7.7 km
	* 2012: 131.4 km based on 30 runs with an avg of 4.38 km
	* 2013: 100.0 km based on 10 runs with an avg of 10.00 km
	* At all: 2292.1 km based on 351 runs with an avg of 6.53 km
	* ~embed garmin connect map~
4. See FAQ to learn how to use the supported short codes.

== Frequently Asked Questions ==

= The supported short codes examples =
	`[runners_log_basic]
	[runnerslog type="pie" month="1" year="2010"][/runnerslog]
	[runnerslog type="3dpie" month="2" year="2010"][/runnerslog]
	[runnerslog type="donutpie" month="3" year="2010" ][/runnerslog]
	[runnerslog type="column" month="4" year="2010" ][/runnerslog]
	[runnerslog type="line" month="5" year="2010"][/runnerslog]
	[runnerslog type="bar" month="6" year="2010"][/runnerslog]
	[runnerslog type="area" month="7" year="2010"][/runnerslog]
	[runnerslog type="scatter" month="8" year="2010"][/runnerslog]
	[runnerslog type="table" month="September" year="2010"][/runnerslog]
	[runnerslog type="pie" year="2010"][/runnerslog]
	[runnerslog type="3dpie" year="2010"][/runnerslog]
	[runnerslog type="donutpie" year="2010" ][/runnerslog]
	[runnerslog type="column" year="2010" ][/runnerslog]
	[runnerslog type="line" year="2010"][/runnerslog]
	[runnerslog type="bar" year="2010"][/runnerslog]
	[runnerslog type="area" year="2010"][/runnerslog]
	[runnerslog type="scatter" year="2010"][/runnerslog]
	[runnerslog type="table" year="2010"][/runnerslog]
	[runnerslog type="pie" format="p" month="1" year="2010"][/runnerslog]
	[runnerslog type="3dpie" format="p" month="2" year="2010"][/runnerslog]
	[runnerslog type="donutpie" format="p" month="3" year="2010"][/runnerslog]
	[runnerslog type="column" format="p" month="4" year="2010"][/runnerslog]
	[runnerslog type="line" format="p" month="5" year="2010"][/runnerslog]
	[runnerslog type="bar" format="p" month="6" year="2010"][/runnerslog]
	[runnerslog type="area" format="p" month="7" year="2010"][/runnerslog]
	[runnerslog type="scatter" format="p" month="10" year="2010"][/runnerslog]
	[runnerslog type="table" format="p" month="oct" year="2010"][/runnerslog]
	[runnerslog type="pie" format="p" year="2010"][/runnerslog]
	[runnerslog type="3dpie" format="p" year="2010"][/runnerslog]
	[runnerslog type="donutpie" format="p" year="2010" ][/runnerslog]
	[runnerslog type="column" format="p" year="2010" ][/runnerslog]
	[runnerslog type="line" format="p" year="2010"][/runnerslog]
	[runnerslog type="bar" format="p" year="2010"][/runnerslog]
	[runnerslog type="area" format="p" year="2010"][/runnerslog]
	[runnerslog type="scatter" format="p" year="2010"][/runnerslog]
	[runnerslog type="table" format="p" year="2010"][/runnerslog]
	[runnerslog type="pie" format="t" month="1" year="2010"][/runnerslog]
	[runnerslog type="3dpie" format="t" month="2" year="2010"][/runnerslog]
	[runnerslog type="donutpie" format="t" month="3" year="2010"][/runnerslog]
	[runnerslog type="column" format="t" month="4" year="2010"][/runnerslog]
	[runnerslog type="line" format="t" month="5" year="2010"][/runnerslog]
	[runnerslog type="bar" format="t" month="6" year="2010"][/runnerslog]
	[runnerslog type="area" format="t" month="7" year="2010"][/runnerslog]
	[runnerslog type="scatter" format="t" month="10" year="2010"][/runnerslog]
	[runnerslog type="table" format="t" month="oct" year="2010"][/runnerslog]
	[runnerslog type="pie" format="t" year="2010"][/runnerslog]
	[runnerslog type="3dpie" format="t" year="2010"][/runnerslog]
	[runnerslog type="donutpie" format="t" year="2010" ][/runnerslog]
	[runnerslog type="column" format="t" year="2010" ][/runnerslog]
	[runnerslog type="line" format="t" year="2010"][/runnerslog]
	[runnerslog type="bar" format="t" year="2010"][/runnerslog]
	[runnerslog type="area" format="t" year="2010"][/runnerslog]
	[runnerslog type="scatter" format="t" year="2010"][/runnerslog]
	[runnerslog type="table" format="t" year="2010"][/runnerslog]
	[runnerslog type="pie" format="c" month="1" year="2010"][/runnerslog]
	[runnerslog type="3dpie" format="c" month="2" year="2010"][/runnerslog]
	[runnerslog type="donutpie" format="c" month="3" year="2010"][/runnerslog]
	[runnerslog type="column" format="c" month="4" year="2010"][/runnerslog]
	[runnerslog type="line" format="c" month="5" year="2010"][/runnerslog]
	[runnerslog type="bar" format="c" month="6" year="2010"][/runnerslog]
	[runnerslog type="area" format="c" month="7" year="2010"][/runnerslog]
	[runnerslog type="scatter" format="c" month="10" year="2010"][/runnerslog]
	[runnerslog type="table" format="c" month="oct" year="2010"][/runnerslog]
	[runnerslog type="pie" format="c" year="2010"][/runnerslog]
	[runnerslog type="3dpie" format="c" year="2010"][/runnerslog]
	[runnerslog type="donutpie" format="c" year="2010" ][/runnerslog]
	[runnerslog type="column" format="c" year="2010" ][/runnerslog]
	[runnerslog type="line" format="c" year="2010"][/runnerslog]
	[runnerslog type="bar" format="c" year="2010"][/runnerslog]
	[runnerslog type="area" format="c" year="2010"][/runnerslog]
	[runnerslog type="scatter" format="c" year="2010"][/runnerslog]
	[runnerslog type="table" format="c" year="2010"][/runnerslog]
	[runners_log_gchart type="pie" format="d" year="2010" month="May" color="224499" width="600" height="300"]`

= Howto use [runnerslog] Google Chart (new api) =
Eg: `[runnerslog format="d|t|p|c" type="area|bar|column|line|pie|3dpie|donutpie|scatter|table"] year="" month=""]`

	*Type: area, bar, column, line, pie, 3dpie, donutpie, scatter, table
	*Format: d="distance", t="time", c="calories", p="pulse"
	*Year: 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019
	*Month: Jan, Feb, Marts, April, May, June, July, Aug, Sep, Oct, Nov, Dec

You have to select at least Format and Type. Format is the data you like on your chart. It can be either d, t, p or c for distance, time, pulse or calories. Type is the type of chart you would like to have your data in. I can be eirher area, bar, column, line, pie, 3dpie, donutpie, scatter os as table. Year is the year you want data from. Month could be set if you only want data from a specific month, if not set it will be for the whole month ordered by month. Play around with the options and you will understand. :)

= Howto use [runners_log_gchart] Google Chart (old api) =
Eg: `[runners_log_gchart type="pie" format="d" year="2010" month="May" color="224499" width="600" height="300"]`

    *Type: bar, graph, pie, 3dpie
    *Format: d="distance", ds="distance sum", ts="time sum",  cs="calories sum", p="pulse average"
    *Year: 2009, 2010, 2011, 2012
    *Month: Jan, Feb, Marts, April, May, June, July, Aug, Sep, Oct, Nov, Dec
    *Color: Is the color scheme used eg: "224499" for the html color #224499
    *Width: The width of the chart: Default: 475 pixel
    *Height: The height of the chart: Default: 250 pixel

= Howto use [runners_log_basic] =
To have the basic information about your posted course like:

    `* Meters: 8500
    * Time: 00:49:59
    * Km/hour: 10.2
    * Min/km: 05:52 minutes
    * Puls average: 172 bpmis 86% of Max HR and 80% of HRR
    * Calories: 654 C
    * Garmin Connect Link: http://connect.garmin.com/activity/id
    * Km in 2009: 693.7 km based on 122 runs with an avg of 5.69 km
    * Km in 2010: 100.8 km based on 12 runs with an avg of 8.4 km
	* ~embed garmin connect map~`

Use this short code `[runners_log_basic]` in a post or page. 

Alternativly place `<?php if (function_exists(runners_log_basic)) echo runners_log_basic(); ?>` in your template.

= I only want my graphs to show up in a special category =
If you only want your graphs to show up in the category "training" with the category ID = 6 then use it like this eg in single.php:

`<?php if ( in_category('6') ): ?>
<?php if (function_exists(runners_log_basic)) echo runners_log_basic(); ?>
<?php endif; ?>`

= I only want my graphs to show up in a special page =
If you only want your graphs to show up in the page with the name "Training Stats" then use it like this eg. in page.php:
BE WARE: <?php if (function_exists(runners_log_basic)) echo runners_log_basic(); ?> only works in categories

`<?php if (is_page('Training Stats')) { ?>
<?php if (function_exists(runners_log_basic)) echo runners_log_basic(); ?>
<?php } ?>`

= Gear Manager =
I would like to thanks Thomas Genin for his plugin WP-Task-Manager which the Gear Manager is based on.

Plugin URI: http://thomas.lepetitmonde.net/en/index.php/projects/wordpress-task-manager
Description: Integrate in Wordpress, a small task manager system. The plugin is very young, so you should be kind with him.
Author: Thomas Genin
Author URI: http://thomas.lepetitmonde.net/
Version: 1.2

== Screenshots ==
1. Show the RunnersLog MetaBox
2. The Settings in Admin
3. an example of using `[runners_log_basic]`
4. The Pie chart. An example of using `[runnerslog type="pie" month="1" year="2010"][/runnerslog]`
5. The 3dPie Chart An example of using `[runnerslog type="3dpie" month="2" year="2010"][/runnerslog]`
6. The Donut Pie Chart. An example of using `[runnerslog type="donutpie" month="3" year="2010" ][/runnerslog]`
7. The Column Chart. An example of using `[runnerslog type="column" month="4" year="2010" ][/runnerslog]`
8. The Line Chart with intervals. An example of using `[runnerslog type="line" month="5" year="2010"][/runnerslog]`
9. The Bar Chart. An example of using `[runnerslog type="bar" month="6" year="2010"][/runnerslog]`
10. The Area Chart. An example of using `[runnerslog type="area" month="7" year="2010"][/runnerslog]`
11. The Scatter Chart. An example of using `[runnerslog type="scatter" month="8" year="2010"][/runnerslog]`
12. The Table Chart. You can sort by Month and Time in this example. An example of using `[runnerslog type="table" month="September" year="2010"][/runnerslog]`
13. Menu Options from Dashboard
14. Heart Rate Training Zones Calculator
15. VDOT and Training Zone Calculator
16. V02max Calculator
17. Race Time Calculator
18. Predicted effect of change in weight
19. Converter Toolbox
20. Embed Garmin Connect Map in [runners_log_basic] and/or an example of using [runners_log_garminmap]
21. Geat Manager Menu
22. Gear Manager
23. Add new Gear to the Gear Manager
24. Pulsavg for a whole year using Google Chart. (Type: bar)
25. Pulsavg for a whole year using Google Chart. (Type: graph)
26. Pulsavg a given month using Google Chart. (Type: 3dpie)
27. Pulsavg a given month using Google Chart. (Type: pie)
28. Google Chart

== Changelog ==

= 1.0.0 =
* Initial Release

= 1.0.1 =
* Fixing Screenshots

= 1.0.2 =
* Fixing Screenshots again

= 1.0.3 =
* Fixing if ( category ID = 6 ) { and moved it to templates. This way its easier to upgrade Runners Log

= 1.0.4 =
* More info to readme.txt

= 1.0.5 =
* Optimazing code
* Added 2010 to runners_log_basic()

= 1.0.6 =
* Added the number of run per year and avg per run like: Km in 2009: 693.7 km based on 122 runs with an avg of 5.69 km
* New runners_log_basic() screenshot
* In runners_log_bar_hours() runhours is rounded to 2 instead of 4 decimals

= 1.0.7 =
* The jared^ release

= 1.0.8 =
* Added WP version check
* Now check is $hms, $meters is empty or not
* Added GPL licens
* Changed all templates tags to include if function exist
* Update readme

= 1.5.1 =
* JA - Added support to hide/disable GarminConnectLink
* JA - Added Runners Log write panel for post screen
* JA - Started to add support for Miles
* FL - Ended Miles support
* FL - Added a new field called Calories
* FL - Added support to hide/disable Calories thanks to JA
* FL - Added runners_log_graphmini_calories(), runners_log_pie_calories(), runners_log_bar_calories()
* FL - Renamed runners_log_graphmini_km() to runners_log_graphmini_distance()
* FL - Renamed runners_log_pie_km() to runners_log_pie_distance()
* FL - Renamed runners_log_bar_km() to runners_log_bar_distance()
* FL - Database updater that rename the old custom fields to match the new one
* FL - New screenshots
* FL - Readme update
* FL - Added support to hide/disable Pulse Average

= 1.6.0 =
* FL - Added short codes support

= 1.6.5 =
* FL - Adding Runners Log to its own side box
* FL - New field in Admin: Resting Heart Rate
* FL - New field in Admin: Maximum Heart Rate
* FL - New field in Admin: Unit Type: Either metric or english
* FL - New field in Admin: Height: Either centimeters or feet+inch(es)
* FL - New field in Admin: Weight: Either kilograms or pounds
* FL - New field in Admin: Age
* FL - New field in Admin: Gender
* FL - Adding Graphs and Stats to Admin
* FL - Heart Rate Training Zone Calculator
* FL - Edit runnerslog_basic to show data like: Puls average: 162 is 81% of Max HR and 74% of HRR
* FL - Body Mass Index Calculator
* FL - Weight Change Effect Calculator
* FL - V02max Calculator
* FL - Training Pace Calculator
* FL - Moved calculators to a Includes folder

= 1.6.6 =
* FL - Fix spelling error in pulsavg: bpmis 
* FL - Fixing unclosed <li> tag in pulsavg in runners_log_basic
* FL - Tested up to: 2.9.2

= 1.6.7 =
* FL - Fixed bug reported by klojo and fixed by klojo. You are now able to use [runners_log_basic] twice.
* FL - Fixed some typos
* FL - Added Coverter Toolbox including: Calculate Speed, Calculate Race Time, Calculate Distance, Convert speed to min per distance

= 1.6.8 =
* FL - Fixed missing include of converter toolbox file
* ML - Stats page throws error with zero data http://wordpress.org/support/topic/367176?replies=3

= 1.8.0 =
* FL - Wordpress 3.0 validated
* FL - runnerslog_admin.php spell checking and more
* FL - Includes/runnerslog_stats_graphs.php minor spelling fixes
* FL - Includes/runnerslog_training_zones.php fixed Heart Rate Training Zones (Elite)
* FL - Includes/runnerslog_v02mac.php minor style changes
* FL - Includes/runnerslog_vdot_race_time.php minor spelling fixes
* FL - Includes/runnerslog_vdot_training_pace.php minor spelling fixes
* FL - Includes/runnerslog_body_mass_index.php minor spelling fixes and style changes
* FL - Includes/runnerslog_weight_change_effect.php minor style changes
* FL - Includes/runnerslog_converter_toolbox fixed to remember data i all fields

= 1.8.1 =
* FL - Added settings for [runners_log_basic] Now you can set what to show
* FL - Pulse spelling error in [runners_log_basic]
* FL - Added embed Garmin Connect map to [runners_log_basic] and you can enable or disable it
* FL - Added a new shortcode [runners_log_garminmap] which let you insert a embed map of you route. The map is based on the path in "Garmin Connect Link"

= 1.8.2 =
* FL - Added more options to the plugin control panel like a link to setting, FAQ, Support and a link to Share where you use this plugin
* FL - Added Km at all to [runners_log_basic]
* FL - Minor changes to runnerslog_metabox.php

= 1.8.5 =
* FL - Fixing minor bug in the bar-charts in runnerslog.php
* FL - By request by TheRealEyeless http://wordpress.org/support/topic/347464/page/2?replies=47 added a whole new tag [runners_log year="2010" month="May" type="pie"]. See FAQ for howto use it.

= 2.0.2 =
* FL - Added a Gear List Manager Based on Thomas Genin WP-Task-Manager v.1.2.
* TR - Weather support
* TR - [runners_log_weather] Using the meta-style like [runners_log_basic]
* FL - [runners_log_weather_footer] - to put the weather data in the footer of the post or page. Thanks to Weather Postin' Plugin By bigdawggi

= 2.0.5 =
* FL - Added 2011 support

= 2.2 =
* FL - Added Google Chart suppport. See Faq and Screenshots

= 2.2.1 =
*FL - Google Chart: Better color palettes
*FL - Google Chart: Markers for the type bar
*FL - Serious bug fix thanks to salathe @ #php @ freenode: http://wordpress.org/support/topic/plugin-runners-log-shots-screen-of-death-after-plugin-upgrade

= 2.2.2 =
*FL - Added a new option "Cadence"

= 2.2.5 =
*FL Crash tested with Wordpress 3.1

= 3.0.0 =
* TR - Multilanguage support
* TR - German Language files
* FL - Danish Language files
* FL - English language fixes
* FL - tested with Wordpress 3.3

= 3.0.1 =
* FL - Bugfix http://wordpress.org/support/topic/plugin-runners-log-runners_log_pie_hours?replies=1

= 3.1.0 =
* FL - Roll back so we no longer supports multi language!
* FL - Added support for 2012: http://wordpress.org/support/topic/764998

= 3.2.0 =
* FL - Minor bug fixs regarding the old multilanguage function
* FL - Fixed bug in runnerslog_stats_graphs.php resulting in not printing all graphs
* FL - Fixed minor bug in running related calculators
* FL - Tested in WP 3.4

= 3.5.0 =
* FL - Tested in WP 3.5
* FL - Added support for 2013

= 3.9.0 =
***ADDED***
* FL - Total recode of the graph shortcode and use of the newest Google Chart Code: https://developers.google.com/chart/interactive/docs/
* FL - Support the periode from 2013-2019 - a major needed support :) 
* FL - QTag for the new chart function
* FL - [runnerslog] new tag for graphs
* FL - New Settings Icon

***DELETED***
* FL - Weather function outdeted and deleted from this version and the shortcodes: [runners_log_weather], [runners_log_weather_footer]
* FL - pChart outdated and so are these shortcodes: [runners_log_graph], [runners_log_pie_distance], [runners_log_pie_hours], [runners_log_pie_calories],  [runners_log_bar_distance], [runners_log_bar_hours], [runners_log_bar_calories], [runners_log_graphmini_distance], [runners_log_graphmini_hours], [runners_log_graphmini_calories]
* FL - Unittype runnerslog_unittype - make no sense as we have the runnerslog_distancetype
* FL - runnerslog_stats_graphs - as no need for that page - use the FAQ

= 3.9.2 =
* FL - minor fixed background, folders, icon

== Upgrade Notice ==

= 1.0.0 =
This was the initial release Januar 1st 2010

= 1.0.5 =
This was release Januar 2nd 2010

= 1.0.6 =
This was release Januar 3rd 2010

= 1.0.8 =
This was release Januar 2010

= 1.5.1 =
This is a major update with renaming the custom fields and adding admin support.

= 1.6.0 = 
The short codes release

= 1.6.5 =
The calculator release. Februar 2010.

= 1.6.7 =
The Converter Toolbox release. Februar 21th 2010.

= 1.6.8 =
Marts 3rd 2010 

= 1.8.1 =
June 27th 2010 

= 1.8.2 =
June 30th 2010

= 1.8.5 =
July 20th 2010

= 2.0.2 =
November 16th 2010

= 2.0.5 =
January 8th 2011

= 2.2 =
February 9th 2011

= 2.2.1 =
February 11th 2011

= 2.2.5 =
Marts 27th

= 3.0.0 =
Januar 2012

= 3.0.1 =
Februar 2012

= 3.1.0 =
Ultimo Marts 2012

= 3.2.0 =
Ultimo June 2012

= 3.5.0 =
Ultimo December 2012

= 3.9.0 =
August 2018

= 3.9.2 =
August 2018

== To Do ==
* gear list (started)
* auto import data from garmin connect 
* add chill factor calc
* add graph for your weight and track your weight 
* add full support for translation
* add combo graphs eg distance vs time, time vs pulse etc 