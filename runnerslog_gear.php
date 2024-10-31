<?php
/* Code Based on WP-Task-Manager
//Plugin URI: http://thomas.lepetitmonde.net/en/index.php/projects/wordpress-task-manager
//Description: Integrate in Wordpress, a small task manager system. The plugin is very young, so you should be kind with him.
//Author: Thomas Genin
//Author URI: http://thomas.lepetitmonde.net/
//Version: 1.2
*/

/* Define constant for the gear-list */
define('DIRECTORY_NAME'				,'runners-log');
define('IMG_DIRECTORY'				,'../wp-content/plugins/'.DIRECTORY_NAME.'/Images/');
define('ADM_IMG_DIRECTORY'				,'../wp-admin/images/');
define('JS_DIRECTORY'				,'../wp-content/plugins/'.DIRECTORY_NAME.'/Js/');
define('OPTION_DATE_FORMAT'			,'gear_manager_date_format');

//Functions related to being able to insert an image in the gear-list
	function wp_gear_manager_admin_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('jquery');
	}
	
	function wp_gear_manager_admin_styles() {
		wp_enqueue_style('thickbox');
	}
	add_action('admin_print_scripts', 'wp_gear_manager_admin_scripts');
	add_action('admin_print_styles', 'wp_gear_manager_admin_styles');

	function wp_gear_manager_page_dispatcher(){
		if (isset($_POST['gear'])) 
			$_GET['gear']=$_POST['gear'];

		$gear = filter_input(INPUT_GET,'gear',FILTER_SANITIZE_STRING);	
		switch ($gear) {
			default:
	   		case 'all':
	   			wp_gear_manager_view_all_task();
	    		break;
	    		
	   		case 'new':
				wp_gear_manager_page_new_task();
				break;

	    }
	}

	function wp_gear_manager_page_new_task(){
		global $gear_plugIn_base_url,$wpdb;  

		$msg = '';
		$go 	= filter_input( INPUT_POST, 'go', FILTER_SANITIZE_STRING );
		$action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING);
		
		if( isset( $go ) ){
			$error[0] = false;
			
			$day 		 = filter_input( INPUT_POST, 'day', FILTER_SANITIZE_NUMBER_INT );
			$description = filter_input( INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS );
			$month 		 = filter_input( INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT );
			$brand		 = filter_input( INPUT_POST, 'brand', FILTER_SANITIZE_STRING );
			$name 		 = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
			$price 		 = filter_input( INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT );
			$distance 	 = filter_input( INPUT_POST, 'distance', FILTER_SANITIZE_NUMBER_INT );
			$year 		 = filter_input( INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT );
			$gearimage 	 = filter_input( INPUT_POST, 'upload_image' );
			
			if( empty( $brand ) ){
				$error['brand'] = true;
				$error[0] = true;
				$msg .= '<span style="color:red">The&nbsp;<b>Brand</b>&nbsp;of the gear must be set.</span><br/>';
			}
			if( empty( $name ) ){
				$error['name'] = true;
				$error[0] = true;
				$msg .= '<span style="color:red">The&nbsp;<b>Name</b>&nbsp;of the gear must be set.</span><br/>';
			}
			if( empty( $description ) ){
				$error['description'] = true;
				$error[0]=true;
				$msg .= '<span style="color:red">The&nbsp;<b>Description</b>&nbsp;of the gear must be set.</span><br/>';
			}
			if( $day == '###' ){
				$error['day'] = true;
				$error[0] = true;
				$msg .= '<span style="color:red">The&nbsp;<b>Day</b>&nbsp;of the gear must be set.</span><br/>';
			}			
			if( $month == '###' ){
				$error['month'] = true;
				$error[0] = true;
				$msg .= '<span style="color:red">The&nbsp;<b>Month</b>&nbsp;of the gear must be set.</span><br/>';
			}	
			if( !is_numeric($year) || strlen($year) != 4 ){
				$error['year'] = true;
				$error[0] = true;
				$msg .= '<span style="color:red">The&nbsp;<b>Year</b>&nbsp;of the gear must be set correctly.</span><br/>';
			}
		
			//let's insert the gear in the database
			if( ! $error[0] ){
				$table = $wpdb->prefix."gear";
				
				//UPDATE Gear
				if( isset($_POST['id'])){
					$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
					$wpdb->update($table, array(	'gear_brand' => $brand,
													'gear_name' => $name,
													'gear_desc' => $description,
													'gear_price' => $price,
													'gear_image' => $gearimage,
													'gear_distance' => $distance,
													'gear_dateTo' => "$year-$month-$day") , 
											array('gear_id' => $id) );
					$msg .= '<span style="color:green; background-color:#9ECA98">Gear correctly updated.</span>';
											
				}else{
					$wpdb->insert($table, array(	'gear_brand' => $brand,
													'gear_name' => $name,
													'gear_desc' => $description,
													'gear_price' => $price,
													'gear_image' => $gearimage,
													'gear_distance' => $distance,
													'gear_dateTo' => "$year-$month-$day") );
					$msg .= '<span style="color:green; background-color:#9ECA98">Gear correctly added.</span>';
					$id = $wpdb->get_var('SELECT LAST_INSERT_ID()');
				}
				$msg .= '&nbsp;&nbsp;&nbsp;'.wp_gear_manager_bouton_panel().'<br/><hr/><br/>';
			}
		}	
		if( isset($action) && $action = 'edit'){
			$id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
			$table = $wpdb->prefix."gear";
			$query = "SELECT gear_id,gear_brand,gear_name,gear_desc,gear_price,gear_distance,gear_image,DAY(gear_dateTo) as `day`,MONTH(gear_dateTo) as `month`, YEAR(gear_dateTo) as `year` FROM $table WHERE gear_id = $id LIMIT 1;";
			$res = $wpdb->get_row($query);

			$day 		 = filter_var( $res->day,FILTER_SANITIZE_NUMBER_INT );
			$description = filter_var( $res->gear_desc, FILTER_SANITIZE_STRING );
			$month 		 = filter_var( $res->month, FILTER_SANITIZE_NUMBER_INT );
			$name 		 = filter_var( $res->gear_name, FILTER_SANITIZE_STRING );
			$brand 		 = filter_var( $res->gear_brand, FILTER_SANITIZE_STRING );
			$price 		 = filter_var( $res->gear_price, FILTER_SANITIZE_NUMBER_INT );
			$gearimage 	 = $res->gear_image;
			$distance	 = filter_var( $res->gear_distance, FILTER_SANITIZE_NUMBER_INT );
			$year 		 = filter_var( $res->year, FILTER_SANITIZE_NUMBER_INT );	
			$id 		 = filter_var( $res->gear_id, FILTER_SANITIZE_NUMBER_INT );			
		}
		
		if( isset($id) )
			echo '<h1>Edit Gear Item</h1>';
		else	
			echo '<h1>Add Gear Item</h1>';
		?>
		<br/>
		<div><?php echo $msg; ?></div>
		<script type="text/javascript" src="<?php echo JS_DIRECTORY;?>calendar.js"></script>
		<div>
			<form method="post" action="<?php echo $gear_plugIn_base_url.'&amp;gear=new' ?>">
				<table>
					<tr <?php if( isset($error['brand']) ) echo 'style="background-color:#D41346;"'?>>
						<td>Brand</td>
						<td><input type="text" name="brand" size="58" value="<?php if( isset($brand) ) echo $brand;?>"/><span class="description"> Eg. New Balance</span></td>
					</tr>
					<tr <?php if( isset($error['name']) ) echo 'style="background-color:#D41346;"'?>>
						<td>Name</td>
						<td><input type="text" name="name" size="58" value="<?php if( isset($name) ) echo $name;?>"/><span class="description"> Eg. NB 1224</span></td>
					</tr>
					<tr <?php if( isset($error['description']) ) echo 'style="background-color:#D41346;"'?>>
						<td>Description</td>
						<td><textarea name="description" rows="8" cols="52"><?php if( isset($description) ) echo $description;?></textarea></td>
					</tr>
					<tr>
						<td>Price</td>
						<td><input type="text" name="price" size="12" value="<?php if( isset($price) ) echo $price;?>"/><span class="description"> Currency isnt supported</span></td>
					</tr>
					<tr <?php if( isset($error['distance']) ) echo 'style="background-color:#D41346;"'?>>
						<td>Distance</td>
						<td><input type="text" name="distance" size="12" value="<?php if( isset($distance) ) echo $distance;?>"/><span class="description"> Enter a start distance if the item is used. Further distances is calculated</span></td>
					</tr>
					<tr <?php if( isset($error['day']) || isset($error['month']) || isset($error['year']) ) echo 'style="background-color:#D41346;"'?>>
						<td>Bought</td>
						<td>Day: <input name="day" id="day" value="<?php echo $day;?>" size="2" type="text"> Month:<input name="month" id="month" value="<?php echo $month;?>" size="2" type="text"> Year: <input name="year" id="year" value="<?php echo $year;?>" size="4" type="text">
							<a href="#" onclick="cal.showCalendar('anchor9'); return false;" title="cal.showCalendar('anchor9'); return false;" name="anchor9" id="anchor9"><img src="<?php echo IMG_DIRECTORY?>calendar.png"/></a>
						</td>
					</tr>
					<script language="JavaScript">
					jQuery(document).ready(function() {

					jQuery('#upload_image_button').click(function() {
					formfield = jQuery('#upload_image').attr('name');
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
					return false;
					});

					window.send_to_editor = function(html) {
					imgurl = jQuery('img',html).attr('src');
					jQuery('#upload_image').val(imgurl);
					tb_remove();
					}

					});
					</script>
					<tr valign="top">
						<td>Upload Image</td>
							<td><label for="upload_image">
								<input id="upload_image" type="text" size="36" name="upload_image" value="<?php echo $gearimage; ?>" />
								<input id="upload_image_button" type="button" value="Upload Image" />
								<br />Enter an URL or upload an image for the banner.
								</label>
							</td>
					</tr>
				</table>
				<br/>
<?php 
				if( isset( $id) )
					echo "<input type='hidden' name='id' value='$id'/>";
?>
				<input type="submit" value="<?php if( isset($id) ) echo 'Update'; else echo 'Add Item';?>" name="go"/>&nbsp;&nbsp;&nbsp;
				<input type="reset" value="Clear" />&nbsp;&nbsp;&nbsp;
				<?php echo wp_gear_manager_bouton_panel();?>
			</form>
		</div>
		<div id="wptm_calendar" style="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>
		<style>
			.TESTcpYearNavigation,.TESTcpMonthNavigation{
				background-color:#6677DD;text-align:center;vertical-align:center;text-decoration:none;color:#FFFFFF;font-weight:bold;
			}
			.TESTcpDayColumnHeader,.TESTcpYearNavigation,.TESTcpMonthNavigation,.TESTcpCurrentMonthDate,.TESTcpCurrentMonthDateDisabled,
			.TESTcpOtherMonthDate,.TESTcpOtherMonthDateDisabled,.TESTcpCurrentDate,.TESTcpCurrentDateDisabled,.TESTcpTodayText,
			.TESTcpTodayTextDisabled,.TESTcpText{font-family:arial;font-size:8pt;}
			TD.TESTcpDayColumnHeader{text-align:right;border:solid thin #6677DD;border-width:0 0 1 0;}
			.TESTcpCurrentMonthDate,.TESTcpOtherMonthDate,.TESTcpCurrentDate{text-align:right;text-decoration:none;}
			.TESTcpCurrentMonthDateDisabled,.TESTcpOtherMonthDateDisabled,.TESTcpCurrentDateDisabled{color:#D0D0D0;text-align:right;text-decoration:line-through;}
			.TESTcpCurrentMonthDate{color:#6677DD;font-weight:bold;}
			.TESTcpCurrentDate{color: #FFFFFF;font-weight:bold;}
			.TESTcpOtherMonthDate{color:#808080;}
			TD.TESTcpCurrentDate{color:#FFFFFF;background-color: #6677DD;border-width:1;border:solid thin #000000;}
			TD.TESTcpCurrentDateDisabled{border-width:1;border:solid thin #FFAAAA;}
			TD.TESTcpTodayText,TD.TESTcpTodayTextDisabled{border:solid thin #6677DD;border-width:1 0 0 0;}
			A.TESTcpTodayText,SPAN.TESTcpTodayTextDisabled{height:20px;}
			A.TESTcpTodayText{color:#6677DD;font-weight:bold;}
			SPAN.TESTcpTodayTextDisabled{color:#D0D0D0;}
			.TESTcpBorder{border:solid thin #6677DD;}
		</style>
		
		<script language="JavaScript">
			var cal = new CalendarPopup("wptm_calendar");
			cal.setCssPrefix("TEST");
			
			cal.setReturnFunction("setMultipleValues");
			function setMultipleValues(y,m,d) {jQuery("#day").val(d);jQuery("#month").val(m);jQuery("#year").val(y);}
		</script>		
<?php 
	}
	
	
	function wp_gear_manager_view_all_task(){
	    global $gear_plugIn_base_url,$wpdb;
		$table = $wpdb->prefix."gear";
		
		$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
		$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
		
		if( isset( $_GET['view']) )
			$view = filter_input(INPUT_GET,'view',FILTER_SANITIZE_STRING);
		else
			$view = 'active';
		
		if( isset( $action ) ){
			switch($action){
				case 'valid':
					wp_gear_manager_gear_is_done( $id);
					$msg = "<span style='color:green; background-color:#9ECA98'>Gear accomplish !</span>";
					break;
				case 'unvalid':
					wp_gear_manager_gear_un_done( $id );
					$msg = "<span style='color:green; background-color:#9ECA98'>Gear back to work !</span>";
					break;
				case 'edit':
					break;
				case 'delete':
					wp_gear_manager_gear_delete($id );
					break;
				default:
					break; 
			}
		}
?>
		<div class="wrap">
		<h2>Runners Log - Gear List</h2>
        <h2><span style="color: rgb(255, 0, 0);"><span style="background-color: rgb(255, 255, 0);">ALART</span></span><span style="background-color: rgb(255, 255, 0);">: </span><span style="color: rgb(0, 128, 0);"><span style="background-color: rgb(255, 255, 0);">The Gear Manager is still a beta version. Data might be deleted in a comming release!</span></span></h2>
		<div><?php $msg; ?></div>
		<div>
			View:&nbsp;
<?php
			if( 'all' == $view )
				echo "<b>All</b>";
			else
				echo "<a href='$gear_plugIn_base_url&amp;gear=all&amp;view=all'>All</a>";
			
			echo '&nbsp;&nbsp;';
			
			if(  'active' == $view || empty( $view) )
				echo '<b>In use</b>';
			else
				echo "<a href='$gear_plugIn_base_url&amp;gear=all&amp;view=active'>In use</a>";

			echo '&nbsp;&nbsp;';
			
			if ('done' == $view )
				echo '<b>Not in use</b>';
			else
				echo "<a href='$gear_plugIn_base_url&amp;gear=all&amp;view=done'>Not in use</a>";
			
			echo '<br/><br/>';
				
			//prepare query
				$query = "SELECT T.gear_id,T.gear_brand,T.gear_name,T.gear_desc,T.gear_price,T.gear_image,T.gear_distance,T.gear_dateTo,T.gear_isDone FROM $table T ";				
				
		switch($view){
			default:
			case 'active':
				$query .= ' WHERE gear_isDone = 0 ORDER BY gear_id;';
				break;
				
			case 'done':
				$query .= ' WHERE gear_isDone = 1 ORDER BY gear_id;';
				break;
				
			case 'all':
				$query .= ' ORDER BY gear_id;';				
				break;
		}
		$list_task = $wpdb->get_results($query, ARRAY_A);
		$format_lang = get_option(OPTION_DATE_FORMAT);
		if($list_task) {
?>
			<div class="clear"></div>
				<table class="widefat">
				  <thead>
					<tr>
						<th><img src="<?php echo ADM_IMG_DIRECTORY;?>comment-grey-bubble.png"></img></th>
						<th>Id</th>
						<th>Image</th>
						<th>Brand</th>
						<th>Name(model)</th>
						<th>Price</th>
						<th>Distance</th>
						<th>Bought</th>
						<th>Age</th>
						<th>In use</th>
						<th>Edit</th>
						<th>Del</th>
					</tr>
				  </thead>
				  <tfoot>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				  </tfoot>
<?php
			foreach ($list_task as $gear){
				
				$description = filter_var($gear['gear_desc'],FILTER_SANITIZE_STRING);
				$id = filter_var($gear['gear_id'],FILTER_SANITIZE_NUMBER_INT);
				$isDone = filter_var($gear['gear_isDone'],FILTER_SANITIZE_NUMBER_INT);
				$brand = filter_var($gear['gear_brand'],FILTER_SANITIZE_STRING);
				$name = filter_var($gear['gear_name'],FILTER_SANITIZE_STRING);
				$price = filter_var($gear['gear_price'],FILTER_SANITIZE_NUMBER_INT);
				$gearimage = $gear['gear_image'];
				$distance = filter_var($gear['gear_distance'],FILTER_SANITIZE_NUMBER_INT);
				$dateTo = filter_var($gear['gear_dateTo'],FILTER_SANITIZE_STRING);
				$age = 	ROUND(((time() - strtotime($dateTo))/(60*60*24)),0);
				if ($age <= '1') {
					$age_text = 'day';
				} else {
					$age_text = 'days';
				}
?>
				
				<tr onclick="displayDescription(<?php echo $id; ?>)" style="
<?php 				
				if( (0 == $isDone) ) {
					echo 'color:green;';
					} else {
					echo 'color:red;';
					}
?>
				">
					<td><img id="img<?php echo $id; ?>" src="<?php echo IMG_DIRECTORY;?>plus16.png"/></td>
					<td><?php echo $id; ?></td>
					<td><a href="<?php echo $gearimage; ?>" class="thickbox" title="Name: <?php echo $name; ?> Brand: <?php echo $brand; ?>" rel="gearimages"><img src="<?php echo $gearimage; ?>" alt="" width="24" height="24"></a></td>
					<td><?php echo $brand; ?></td>
					<td><?php echo $name; ?></td>
					<td><?php if ($price == '') { echo "-"; } else { echo $price; }?></td>
					<td><?php if ($distance == '') { echo "Brand New"; } else { echo $distance; }?></td>
					<td><?php echo mysql2date( $format_lang, $dateTo ); ?></td>
					<td><?php echo $age; ?> <?php echo $age_text; ?></td>
					<td><?php echo wp_gear_manager_display_action( $id, $isDone, $view );  ?></td>
					<td><?php echo wp_gear_manager_display_edit_task( $id, $view ); ?></td>
					<td><?php echo wp_gear_manager_display_delete_task( $id, $view ); ?></td>
				</tr>
				<tr id="desc<?php echo $id; ?>" style="display:none">
					<td></td>
					<td colspan="5"><i><?php echo $description; ?></i></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
<?php
			}
?>
				</table>
				<br class="clear"/>
<?php 
		}else{
			echo "<p>No gear in the list</p>";
		}
		echo '<br/>'.wp_gear_manager_bouton_new();
?>		</div>
		<script>
			function displayDescription( id ){
				var elem = document.getElementById( 'desc'+id );
				var img = document.getElementById( 'img'+id );
				if( elem.style.display == 'none' )
				{
					elem.style.display = '';
					img.src = "<?php echo IMG_DIRECTORY; ?>minus16.png";
				}else{
					elem.style.display = 'none';
					img.src = "<?php echo IMG_DIRECTORY; ?>plus16.png";					
				}
			}
		</script>
<?php
	}
	
	function wp_gear_manager_display_action( $id, $isdone, $view){
		global $gear_plugIn_base_url;
		
		if( 0 == $isdone)
			return '<a href="'.$gear_plugIn_base_url.'&amp;gear=all&action=valid&id='.$id.'&view='.$view.'" title="Click to say that the gear as not in use"><img src="'.IMG_DIRECTORY.'tick.png" alt="Make gear done"/></a>';
		else if( 1 == $isdone)
			return '<a href="'.$gear_plugIn_base_url.'&amp;gear=all&action=unvalid&id='.$id.'&view='.$view.'" title="To put back the gear in use"><img src="'.IMG_DIRECTORY.'lock.png" alt="Make gear active again"/></a>';
		else
			return '<img src="'.IMG_DIRECTORY.'alert.png" alt="Error, can\'t get the status" title="Error, can\'t get the status"/>';
	}
	
	function wp_gear_manager_display_edit_task($id, $view)
	{
		global $gear_plugIn_base_url;
		return '<a href="'.$gear_plugIn_base_url.'&amp;gear=new&action=edit&id='.$id.'&view='.$view.'" title="Edit the gear"><img src="'.IMG_DIRECTORY.'edit.png" alt="Edit gear"/></a>';	
	}
	
	function wp_gear_manager_display_delete_task($id, $view)
	{
		global $gear_plugIn_base_url;
		return '<a href="'.$gear_plugIn_base_url.'&amp;gear=all&action=delete&id='.$id.'&view='.$view.'" title="Delete the gear, can\' be undone"><img src="'.IMG_DIRECTORY.'cross.png" alt="Delete Gear"/></a>';	
	}	
		
	function wp_gear_manager_gear_is_done($id){
		global $wpdb;
		$table = $wpdb->prefix."gear";
		$wpdb->update($table, array( 'gear_isDone' => 1), array('gear_id' => $id ) );
	}
	
	function wp_gear_manager_gear_un_done($id){
		global $wpdb;
		$table = $wpdb->prefix."gear";
		$wpdb->update($table, array( 'gear_isDone' => 0), array('gear_id' => $id ) );
	}	
	
	function wp_gear_manager_gear_delete($id){
		global $wpdb;
		$table = $wpdb->prefix."gear";
		$query = "DELETE FROM $table WHERE gear_id= $id LIMIT 1;";
		$wpdb->query($query);
	}	
	
	function wp_gear_manager_bouton_new(){
		global $gear_plugIn_base_url;
		return '<a href="'.$gear_plugIn_base_url.'&amp;gear=new"><input type="button" value="Add Gear Item" /></a>';
	}
	
	function wp_gear_manager_bouton_panel(){
		global $gear_plugIn_base_url;
		return '<a href="'.$gear_plugIn_base_url.'&amp;gear=all"><input type="button" value="Manage Gear List" /></a>';
	}
	
?>
