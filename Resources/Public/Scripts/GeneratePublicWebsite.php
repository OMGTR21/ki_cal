<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<style>
			* {
					font-family: "Calibri Light", Calibri, Arial, sans-serif;
			}
			body {
					background: transparent;
					font-size: 40px;
					color: black;
			}
			p {
					font-weight: 100;
					display: inline;
					position: relative;
			}
			#company {
					font-weight: bold;
					color: black!important;
					font-size: 50px;
					font-family: Arial;
			}
	</style>
</head>


<body>
	<?php

		$screenimage_database = mysqli_connect('localhost', 'screenimage', 'v7YUPAwrCehDGB3S', 'dev_screenimage');
		$all_public_entries = getEntries();
		$layout_welcome_id = getLayoutID("welcome", $screenimage_database);
		$layout_standby_id = getLayoutID("standby", $screenimage_database);

		// Check if some entries were found
		if(mysqli_num_rows($all_public_entries) > 0) {

			generateHTML($all_public_entries);

			// Change default layout to welcome
			echo "<script>console.log('Change layout to welcome.')</script>";
			$query_change_current_layout = "UPDATE `dev_screenimage`.`display` SET `defaultlayoutid` = '" . $layout_welcome_id . "' WHERE `display`.`display` LIKE '%Haupteingang%'";
		}else {

			// Change default layout back to standby
			echo "<script>console.log('No entries for today where found. - Change layout to standby')</script>";
			$query_change_current_layout = "UPDATE `dev_screenimage`.`display` SET `defaultlayoutid` = '" . $layout_standby_id . "' WHERE `display`.`display` LIKE '%Haupteingang%'";
		}

		// Update layout
		// if ($query_change_current_layout != "") {
    //     if (mysqli_query($screenimage_database, $query_change_current_layout)) {
    //         echo '<script> console.log("Default layout successful updated."); </script>';
    //     } else {
    //         echo '<script> console.log("Error while updating the default layout."); </script>';
    //     }
    // }


	?>
</body>

</html>

<?php

function getEntries() {

	$host = "127.0.0.1";
	$username = "typo3";
	$password = "p56uWTe4uvUZfWsf";
	$database = "dev_typo3";
	$query_get_all_entries = "SELECT * FROM `tx_kical_domain_model_entry` WHERE `public` = 1 AND `entry_date` = '" . date("Y-m-d") . "'";

	$database_connection = mysqli_connect($host, $username, $password, $database);
	return $database_connection->query($query_get_all_entries);
}

function getLayoutID($layout_name, $screenimage_database) {

	$layout_query = "SELECT `layoutid` from `layout` WHERE `layout` LIKE '%" . $layout_name . "%' LIMIT 1";
	$layout_ID = $screenimage_database->query($layout_query);

	//Get id from standby layout
	while ($row = mysqli_fetch_array($layout_ID)) {
			$id = $row['layoutid'];
	}

	return $id;
}

function generateHTML($all_public_entries) {

	while($entry = mysqli_fetch_assoc($all_public_entries)) {

		// There needs to be at least one company / visitor
		if($entry["company"] !== "" || $entry["visitor"] !== "") {

			// Check if the entry has a visitor but no company
			if($entry["company"] == "" && $entry["visitor"] !== "") {
					echo "<p id='company'>" . $entry["visitor"] . "</p><br />";
			}

			// Check if the entry has a company but no visitor
			if($entry["company"] !== "" && $entry["visitor"] == "") {
					echo "<p id='company'>" . $entry["company"] . "</p><br />";
			}

			// Check if the entry has a company and a visitor
			if($entry["company"] !== "" && $entry["visitor"] !== "") {
					echo "<p id='company'>" . $entry["company"] . "</p><br />
					<p>" . $entry["visitor"] . "</p><br />";
			}

			// Check if the entry has a start time
			if($entry["start_time"] !== "00:00:00") {
					echo "<p>" . $entry["start_time"] . "</p>";
			}

			// Check if the entry has a contact
			if($entry["contact"] !== "") {
				if($entry["start_time"] == "00:00:00") {
					echo "<p>" . $entry["contact"] . "</p><br /><br />";
				}else {
					echo "<p>, " . $entry["contact"] . "</p><br /><br />";
				}
			}
		}
	}
}

 ?>
