<?php
/* 
	Plugin Name: Cranleigh Custom Taxonomies
	Plugin URI: http://www.cranleigh.org
	Description: Activate this plugin to add all relevant custom taxonomies for Cranleigh School websits.
	Author: Fred Bradley
	Author URI: http://fred.im/
	Version: 1
*/
class Cranleigh_Custom_Tax {
	
	function __construct() {
		$taxonomies = array();
		$taxonomies['subjects'] = (object) array("singular" => "Subject", "plural" => "Subjects");
		$taxonomies['sports'] = (object) array("singular" => "Sport", "plural" => "Sports");
		$this->taxonomies = (object)$taxonomies;
		
		$this->install_on_post_types = array( 'staff','page','post', 'attachment');
		
		register_activation_hook(__FILE__, array($this, 'activate'));
		add_action('init', array($this, 'register_taxonomy'));
	}
	
	function get_terms($tax=null) {
		if ($tax=="subjects"):
			$roles = array(
				"Art",
				"Biology",
				"Business Studies",
				"Chemistry",
				"Classics", 
				"Design",
				"Computing", 
				"Digital Literacy",
				"Drama", 
				"Economics", 
				"English", 
				"Geography", 
				"History",
				"Mathematics",
				"Modern Languages", 
				"Music", 
				"Physical Education", 
				"Physics", 
				"Politics", 
				"PSHEE", 
				"Religion & Philosphy"
			);
		elseif ($tax=="sports"):	
			$roles = array(
				"Athletics",
				"Climbing",
				"Badmington",
				"Cricket",
				"Cross Country", 
				"Fives",
				"Football", 
				"Golf",
				"Hockey", 
				"Netball", 
				"Riding", 
				"Rounders", 
				"Rugby",
				"Swimming",
				"Squash", 
				"Tennis", 
				"Water Polo", 
				"Diet & Nutrition", 
				"Strength & Conditioning", 
			);
		endif;
		
		foreach($roles as $role):
			$insert[] = wp_insert_term($role, $tax, array("description"=>"All items related to ".$role.", be that staff, news, pages, etc"));
		endforeach;
		
	}
	
	function insert_initial_terms() {
		$this->register_taxonomy();
		foreach ($this->taxonomies as $tax=>$taxonomy):
			$this->get_terms($tax);
		endforeach;
	}
	function activate() {
		$this->insert_initial_terms();
	}
	
	function register_taxonomy() {
		foreach($this->taxonomies as $tax_name => $taxonomy):
			$labels = array(
				'name'                       => _x( $taxonomy->plural, 'Taxonomy General Name', 	'text_domain' ),
				'singular_name'              => _x( $taxonomy->singular, 'Taxonomy Singular Name', 	'text_domain' ),
				'menu_name'                  => __( $taxonomy->plural, 								'text_domain' ),
				'all_items'                  => __( 'All '.$taxonomy->plural, 						'text_domain' ),
				'parent_item'                => __( 'Parent '.$taxonomy->singular, 					'text_domain' ),
				'parent_item_colon'          => __( 'Parent '.$taxonomy->plural.':', 				'text_domain' ),
				'new_item_name'              => __( 'New '.$taxonomy->singular, 					'text_domain' ),
				'add_new_item'               => __( 'Add New '.$taxonomy->singular, 				'text_domain' ),
				'edit_item'                  => __( 'Edit '.$taxonomy->singular, 					'text_domain' ),
				'update_item'                => __( 'Update '.$taxonomy->singular, 					'text_domain' ),
				'view_item'                  => __( 'View '.$taxonomy->singular, 					'text_domain' ),
				'separate_items_with_commas' => __( 'Separate '.$taxonomy->plural.' with commas', 	'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove '.$taxonomy->plural, 			'text_domain' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 					'text_domain' ),
				'popular_items'              => __( 'Popular '.$taxonomy->plural, 					'text_domain' ),
				'search_items'               => __( 'Search '.$taxonomy->plural, 					'text_domain' ),
				'not_found'                  => __( 'Not Found', 									'text_domain' ),
				'no_terms'                   => __( 'No '.$taxonomy->plural, 						'text_domain' ),
				'items_list'                 => __( $taxonomy->plural.' list',						'text_domain' ),
				'items_list_navigation'      => __( $taxonomy->plural.' list navigation', 			'text_domain' ),
			);
			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => false,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => false,
				'rewrite'						=> array(
					"slug" => "tagged/".strtolower($taxonomy->plural),
				)
			);
			register_taxonomy( $tax_name, $this->install_on_post_types, $args );	
		endforeach;
	}	
}

$custom_tax = new Cranleigh_Custom_Tax();