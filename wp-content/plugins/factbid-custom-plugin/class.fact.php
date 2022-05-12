<?php

class Fact {
	/**
	 * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
	 * @static
	 */
	public static function plugin_activation() {

		global $wpdb; 
		$db_table_name = 'ct_profile';  // table name
		$charset_collate = $wpdb->get_charset_collate();

		 //Check to see if the table exists already, if not, then create it
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		 {
		 	
			$sql1 = "CREATE TABLE $db_table_name (
			`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`id_user` int(10) UNSIGNED NOT NULL,
			`profile` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`profile`)),
			`post_status` enum('None','Pending','Approved') NOT NULL,
			`post_date` datetime NOT NULL,
			`post_request` text NOT NULL,
			`verify_url` varchar(255) NOT NULL,
			`verified` enum('Unverified','Link posted','Link Valid') NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			COMMIT";

		   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		   dbDelta( $sql1 );
		   add_option( 'test_db_version', $test_db_version );
		 }
		 $db_table_name = 'ct_factbid';  // table name
		$charset_collate = $wpdb->get_charset_collate();

		 //Check to see if the table exists already, if not, then create it
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		 {
		 	
			$sql2 = "CREATE TABLE $db_table_name (
			`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`id_factbid` decimal(10,2) NOT NULL,
			`id_factbid_parent` decimal(10,2) DEFAULT NULL,
			`id_user` int(11) NOT NULL,
			`post_id` int(11) NOT NULL,
			`type` char(2) NOT NULL,
			`nobid` int(11) NOT NULL,
			`visibility` enum('1','2','3') NOT NULL,
			`status` enum('1','2','3','4','5','6') NOT NULL,
			`topics` enum('1','2','3') NOT NULL,
			`country` char(2) NOT NULL,
			`language` char(2) NOT NULL,
			`priority` int(11) DEFAULT NULL,
			`bids_count` int(11) DEFAULT NULL,
			`bids_total` int(11) DEFAULT NULL,
			`bids_accepted` int(11) DEFAULT NULL,
			`bids_paid` int(11) DEFAULT NULL,
			`claims_total` int(11) DEFAULT NULL,
			`view_count` int(11) DEFAULT NULL,
			`comment_count` int(11) DEFAULT NULL,
			`thumbs_up` int(11) DEFAULT NULL,
			`thumbs_down` int(11) DEFAULT NULL,
			`title` varchar(150) NOT NULL,
			`subtitle` varchar(1000) DEFAULT NULL,
			`result_claimed` text DEFAULT NULL,
			`result_unclaimed` text DEFAULT NULL,
			`claims_acceptable` text DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

		   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		   dbDelta( $sql2 );
		   add_option( 'test_db_version', $test_db_version );
		 }


		$db_table_name = 'ct_fact_thumbs';  // table name
		$charset_collate = $wpdb->get_charset_collate();

		 //Check to see if the table exists already, if not, then create it
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		 {
		 	
			$sql3 = "CREATE TABLE $db_table_name (
			`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`id_user` int(11) NOT NULL,
			`post_id` int(11) NOT NULL,
			`thumbs` int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

		   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		   dbDelta( $sql3 );
		   add_option( 'test_db_version', $test_db_version );
		 }

		$db_table_name = 'ct_bid';  // table name
		$charset_collate = $wpdb->get_charset_collate();
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		 {
		 	
			$sql4 = "CREATE TABLE $db_table_name (
			`id_bid` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`id_bid_next` bigint(20) UNSIGNED DEFAULT NULL,
			`id_bid_prev` bigint(20) UNSIGNED DEFAULT NULL,
			`id_factbid` decimal(10,2) NOT NULL,
			`id_user` bigint(20) UNSIGNED NOT NULL,
			`date` datetime NOT NULL,
			`date_accepted` datetime DEFAULT NULL,
			`date_received` datetime DEFAULT NULL,
			`amount` int(11) NOT NULL,
			`comments` varchar(255) NOT NULL,
			`status` enum('1','2','3') NOT NULL,
			`verify_url` varchar(255) DEFAULT NULL,
			`verified` enum('1','2','3','4','5') DEFAULT NULL,
			`visibility` enum('1','2','3') NOT NULL,
			`conditions` text NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

		   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		   dbDelta( $sql4 );
		   add_option( 'test_db_version', $test_db_version );
		 }

		$db_table_name = 'ct_claim'; 
		$charset_collate = $wpdb->get_charset_collate();
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		 {
		 	
			$sql5 = "CREATE TABLE $db_table_name (
			`id_claim` bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`id_user` int(11) NOT NULL,
			`id_factbid` decimal(10,2) NOT NULL,
			`post_id` int(11) NOT NULL,
			`status` enum('Creating','Pending','Spam','Offensive','Completed','Inactive') NOT NULL,
			`verify_url` int(11) NOT NULL,
			`verified` enum('Unverified','Link posted','Link Valid','Link Verified','Invalid') NOT NULL,
			`visibility` enum('1','2','3') NOT NULL,
			`payment_method` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payment_method`)),
			`bidders_accepted` int(11) NOT NULL,
			`bidders_paid` int(11) NOT NULL,
			`total_paid` int(11) NOT NULL,
			`bidders_rejected` int(11) NOT NULL,
			`bidders_pending` int(11) NOT NULL,
			`view_count` int(11) NOT NULL,
			`comment_count` int(11) NOT NULL,
			`thumbs_up` int(11) NOT NULL,
			`thumbs_down` int(11) NOT NULL,
			`title` varchar(150) NOT NULL,
			`subtitle` varchar(1000) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

		   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		   dbDelta( $sql5 );
		   add_option( 'test_db_version', $test_db_version );
		 }
		 $db_table_name = 'ct_response'; 
		$charset_collate = $wpdb->get_charset_collate();
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		 {
		 	
			$sql6 = "CREATE TABLE $db_table_name (
			`id_response` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`id_response_next` int(11) DEFAULT NULL,
			`id_response_prev` int(11) DEFAULT NULL,
			`id_bid` int(11) NOT NULL,
			`id_claim` int(11) NOT NULL,
			`id_factbid` decimal(10,2) NOT NULL,
			`id_user` int(11) NOT NULL,
			`status` enum('Accepted','Rejected','Pending','Paid') NOT NULL,
			`comments` text NOT NULL,
			`payment_method` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payment_method`)),
			`amount_paid` int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

		   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		   dbDelta( $sql6 );
		   add_option( 'test_db_version', $test_db_version );
		 }

		$db_table_name = 'ct_votes'; 
		$charset_collate = $wpdb->get_charset_collate();
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		{
		
			$sql7 = "CREATE TABLE $db_table_name (
			`id_vote` int(11) NOT NULL,
			`id_user` int(11) NOT NULL,
			`datetime` datetime NOT NULL,
			`id_response` int(11) NOT NULL,
			`id_bid` int(11) NOT NULL,
			`id_claim` int(11) NOT NULL,
			`id_factbid` decimal(10,2) NOT NULL,
			`vote` enum('thumbs up','thumbs down') NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql7 );
			add_option( 'test_db_version', $test_db_version );
		}

		$db_table_name = 'ct_newsletter'; 
		$charset_collate = $wpdb->get_charset_collate();
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		{
			
			$sql8 = "CREATE TABLE $db_table_name (
			`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`email` varchar(255) NOT NULL,
			`created` datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql8 );
			add_option( 'test_db_version', $test_db_version );
		}

		$db_table_name = 'ct_factbidreporting'; 
		$charset_collate = $wpdb->get_charset_collate();
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		{
			
			$sql9 = "CREATE TABLE $db_table_name (
			`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`id_user` int(10) UNSIGNED NOT NULL,
			`id_factbid` decimal(10,2) NOT NULL,
			`content` varchar(1000) NOT NULL,
			`created` datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql9 );
			add_option( 'test_db_version', $test_db_version );
		}

		$db_table_name = 'ct_profilerating';  // table name
		$charset_collate = $wpdb->get_charset_collate();

		//Check to see if the table exists already, if not, then create it
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		{

			$sql2 = "CREATE TABLE $db_table_name (
			`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`id_profile` int(11) NOT NULL,
			`id_user` int(11) NOT NULL,
			`rating` int(11) NOT NULL,
			`date` datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql2 );
			add_option( 'test_db_version', $test_db_version );
		}
		

	}

	public function update_optionfields(){
	    $type_array = array(
	        "Select",
	        "Query",
	        "Theory"
	    );
	    $visibility_array = array(
	        "Select",
	        "Show Profile",
	        "Claimants",
	        "Anonymous"
	    );
	    $status_array = array(
	        "Select",
	        "Creating",
	        "Pending",
	        "Spam",
	        "Offensive",
	        "Completed",
	        "Inactive"
	    );
	    $topics_array = array(
	        "Select",
	        "Covid",
	        "Politics",
	        "Religion"
	    );
	    $priority_array = array(
	        1,
	        2,
	        3
	    );
	    update_option("fact_bid_type", $type_array);
	    update_option("fact_bid_visibility", $visibility_array);
	    update_option("fact_bid_status", $status_array);
	    update_option("fact_bid_topics", $topics_array);
	    update_option("fact_bid_priority", $priority_array);
	}
	

}
