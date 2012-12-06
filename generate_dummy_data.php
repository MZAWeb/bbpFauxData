<?php
/*
Plugin Name: Dummy Data
 Description: Generates dummy data
 Version: 0.1.2
 Author: Daniel Dvorkin
 Author URI: http://danieldvork.in
 License: GPLv2 or later

*/


class DummyData {

	public function __construct() {
		require_once 'lib/Faker/src/autoload.php';
	}

	public function generate_user() {
		$faker = Faker\Factory::create();

		$first = $faker->firstName;
		$last  = $faker->lastName;

		$user_data = array( 'user_pass'    => 'password',
		                    'user_login'   => sanitize_user( strtolower( $first . '.' . $last ) ),
		                    'display_name' => $first . ' ' . $last,
		                    'first_name'   => $first,
		                    'last_name'    => $last,
		                    'user_email'   => $faker->email

		);

		return wp_insert_user( $user_data );
	}

	public function generate_topic() {

	}

	public function get_random_existing_user_id() {
		global $wpdb;
		$sql = "SELECT id FROM $wpdb->users ORDER BY rand() LIMIT 1";
		$id  = $wpdb->get_var( $sql );
		return $id;
	}

	public function get_random_existing_forum_id() {
		global $wpdb;
		$sql = "SELECT id FROM $wpdb->posts WHERE post_type='forum' ORDER BY rand() LIMIT 1";
		$id  = $wpdb->get_var( $sql );
		return $id;
	}
}