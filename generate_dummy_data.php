<?php
/*
Plugin Name: Dummy Data
 Description: Generates dummy data
 Version: 0.1.2
 Author: Daniel Dvorkin
 Author URI: http://danieldvork.in
 License: GPLv2 or later

*/


class bbpFauxData {

	private $faker;

	public function __construct() {
		require_once 'lib/Faker/src/autoload.php';
		$this->faker = Faker\Factory::create();
	}

	public function generate_user() {

		if ( !function_exists( 'wp_hash_password' ) ) {
			_doing_it_wrong( 'bbpFauxData->generate_user()', "This function should be called after plugins_loaded", '0.1' );
			return false;
		}

		$first = $this->faker->firstName;
		$last  = $this->faker->lastName;

		$user_data = array( 'user_pass'    => 'password',
		                    'user_login'   => sanitize_user( strtolower( $first . '.' . $last ) ),
		                    'display_name' => $first . ' ' . $last,
		                    'first_name'   => $first,
		                    'last_name'    => $last,
		                    'user_email'   => $this->faker->safeEmail

		);

		$ret = wp_insert_user( $user_data );

		unset( $user_data );

		return $ret;
	}


	public function generate_forum() {

		$date = $this->faker->dateTimeBetween( $startDate = '-4 years', $endDate = '-3 years' );

		$forum = array( 'post_author'    => $this->get_random_existing_user_id(),
		                'post_title'     => ucwords( $this->faker->word ),
		                'post_date'      => $date->format( 'Y-m-d H:i:s' ) );

		$ret = bbp_insert_forum( $forum, array() );

		unset( $topic );

		return $ret;

	}

	public function generate_topic() {

		$forum     = $this->get_random_existing_forum_id();
		$date      = $this->faker->dateTimeBetween( $startDate = '-3 years', $endDate = 'now' );
		$text_size = $this->faker->numerify( $string = '###' );
		if ( $text_size < 20 )
			$text_size = 500;

		$topic = array( 'post_parent'    => $forum,
		                'post_author'    => $this->get_random_existing_user_id(),
		                'post_content'   => $this->faker->text( $maxNbChars = $text_size ),
		                'post_title'     => $this->faker->sentence,
		                'post_date'      => $date->format( 'Y-m-d H:i:s' ) );

		$meta = array( 'author_ip' => $this->faker->ipv4, 'forum_id' => $forum, );

		$ret = bbp_insert_topic( $topic, $meta );

		unset( $topic );
		unset( $meta );

		return $ret;

	}

	public function generate_reply() {

		$topic     = $this->get_random_existing_topic_id();
		$min_date  = get_post_field( 'post_date', $topic );
		$forum     = bbp_get_topic_forum_id( $topic );
		$date      = $this->faker->dateTimeBetween( $startDate = $min_date, $endDate = 'now' );
		$text_size = $this->faker->numerify( $string = '###' );
		if ( $text_size < 20 )
			$text_size = 500;

		$reply = array( 'post_parent'    => $topic,
		                'post_author'    => $this->get_random_existing_user_id(),
		                'post_content'   => $this->faker->text( $maxNbChars = $text_size ),
		                'post_date'      => $date->format( 'Y-m-d H:i:s' ) );

		$meta = array( 'author_ip' => $this->faker->ipv4, 'forum_id'  => $forum, 'topic_id'  => $topic );

		$ret = bbp_insert_reply( $reply, $meta );

		unset( $reply );
		unset( $meta );

		return $ret;
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

	public function get_random_existing_topic_id() {
		global $wpdb;
		$sql = "SELECT id FROM $wpdb->posts WHERE post_type='topic' ORDER BY rand() LIMIT 1";
		$id  = $wpdb->get_var( $sql );
		return $id;
	}
}
