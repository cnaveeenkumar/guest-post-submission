<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/cnaveenkumar/
 * @since      1.0.0
 *
 * @package    Guest_Post_Submission
 * @subpackage Guest_Post_Submission/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Guest_Post_Submission
 * @subpackage Guest_Post_Submission/admin
 * @author     Naveen Kumar C <cnaveen777@gmail.com>
 */
class Guest_Post_Submission_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'init', array( $this,'register_guest_custom_post_type'), 10, 2 );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Guest_Post_Submission_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Guest_Post_Submission_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/guest-post-submission-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Guest_Post_Submission_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Guest_Post_Submission_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/guest-post-submission-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Register Guest Custom Post Type
	public function register_guest_custom_post_type() {
	
		$labels = array(
			'name'                  => _x( 'Guest Posts', 'Post Type General Name', 'guest-post-submission' ),
			'singular_name'         => _x( 'Guest Post', 'Post Type Singular Name', 'guest-post-submission' ),
			'menu_name'             => __( 'Guest Post', 'guest-post-submission' ),
			'name_admin_bar'        => __( 'Guest Post', 'guest-post-submission' ),
			'archives'              => __( 'Item Archives', 'guest-post-submission' ),
			'attributes'            => __( 'Item Attributes', 'guest-post-submission' ),
			'parent_item_colon'     => __( 'Parent Item:', 'guest-post-submission' ),
			'all_items'             => __( 'All Items', 'guest-post-submission' ),
			'add_new_item'          => __( 'Add New Item', 'guest-post-submission' ),
			'add_new'               => __( 'Add New', 'guest-post-submission' ),
			'new_item'              => __( 'New Item', 'guest-post-submission' ),
			'edit_item'             => __( 'Edit Item', 'guest-post-submission' ),
			'update_item'           => __( 'Update Item', 'guest-post-submission' ),
			'view_item'             => __( 'View Item', 'guest-post-submission' ),
			'view_items'            => __( 'View Items', 'guest-post-submission' ),
			'search_items'          => __( 'Search Item', 'guest-post-submission' ),
			'not_found'             => __( 'Not found', 'guest-post-submission' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'guest-post-submission' ),
			'featured_image'        => __( 'Featured Image', 'guest-post-submission' ),
			'set_featured_image'    => __( 'Set featured image', 'guest-post-submission' ),
			'remove_featured_image' => __( 'Remove featured image', 'guest-post-submission' ),
			'use_featured_image'    => __( 'Use as featured image', 'guest-post-submission' ),
			'insert_into_item'      => __( 'Insert into item', 'guest-post-submission' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'guest-post-submission' ),
			'items_list'            => __( 'Items list', 'guest-post-submission' ),
			'items_list_navigation' => __( 'Items list navigation', 'guest-post-submission' ),
			'filter_items_list'     => __( 'Filter items list', 'guest-post-submission' ),
		);
		$args = array(
			'label'                 => __( 'Guest Post', 'guest-post-submission' ),
			'description'           => __( 'Post Description', 'guest-post-submission' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 30,
			'show_in_admin_bar'     => true,
			'show_in_rest'			=> true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'guest_post', $args );
	
	}

}
