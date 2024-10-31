<div class="wrap">
<p><?php 

echo "<h2>" . __( 'Runners Log - Stats and Graph' ) . "</h2>"; ?></p>
<h3>Below the graphs you'll find the code you need to use in a page, post or template to insert a simular graph as shown.</h3>

<p><?php if (function_exists(runners_log)) echo runners_log(); ?></p>
<div class="block-content">In pages or posts use: <code>[runners_log]</code> in a template</div> 

<p><?php if (function_exists(runners_log_basic)) echo runners_log_basic(); ?></p>
<div class="block-content">In pages or posts use: <code>[runners_log_basic]</code> in a template</div>

<p><?php if (function_exists(runners_log_graph)) echo runners_log_graph(); ?></p>
<div class="block-content">In pages or posts use: <code>[runners_log_graph]</code> in a template</div> 

<p><?php if (function_exists(runners_log_pie_distance)) echo runners_log_pie_distance(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_pie_distance]</code> in a template</div> 

<p><?php if (function_exists(runners_log_pie_hours)) echo runners_log_pie_hours(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_pie_hours]</code>  in a template</div> 

<p><?php if (function_exists(runners_log_pie_calories)) echo runners_log_pie_calories(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_pie_calories]</code>  in a template</div> 

<p><?php if (function_exists(runners_log_bar_distance)) echo runners_log_bar_distance(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_bar_distance]</code> in a template</div> 

<p><?php if (function_exists(runners_log_bar_hours)) echo runners_log_bar_hours(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_bar_hours]</code> in a template</div> 

<p><?php if (function_exists(runners_log_bar_calories)) echo runners_log_bar_calories(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_bar_calories]</code> in a template</div> 

<p><?php if (function_exists(runners_log_graphmini_distance)) echo runners_log_graphmini_distance(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_graphmini_distance]</code> in a template</div> 

<p><?php if (function_exists(runners_log_graphmini_hours)) echo runners_log_graphmini_hours(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_graphmini_hours]</code> in a template</div> 

<p><?php if (function_exists(runners_log_graphmini_calories)) echo runners_log_graphmini_calories(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_graphmini_calories]</code> in a template</div> 

<p><?php if (function_exists(runners_log_garminmap)) echo runners_log_garminmap(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_garminmap]</code> in a template</div> 

<p><?php if (function_exists(runners_log_weather)) echo runners_log_weather(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_weather]</code> in a template</div> 

<p><?php if (function_exists(runners_log_weather_footer)) echo runners_log_weather_footer(); ?></p>
<div class="block-content">In pages or posts use:<code>[runners_log_weather_footer]</code> in a template</div> 

</div>
