<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/cnaveenkumar/
 * @since      1.0.0
 *
 * @package    Guest_Post_Submission
 * @subpackage Guest_Post_Submission/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Guest_Post_Submission
 * @subpackage Guest_Post_Submission/public
 * @author     Naveen Kumar C <cnaveen777@gmail.com>
 */
class Guest_Post_Submission_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'wp_ajax_nopriv_create_post_using_ajax', array( $this, 'create_post_using_ajax' ) );
		add_action( 'wp_ajax_create_post_using_ajax', array( $this, 'create_post_using_ajax' ) );

		add_shortcode( 'guestpostform', array( $this, 'display_guest_post_creation_form' ) );
		add_shortcode( 'guestpostblog', array( $this, 'display_all_posts' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/guest-post-submission-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/guest-post-submission-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name,'guest_post_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}
	/**
	 * Create Form Field
	 */
	public function display_guest_post_creation_form(){
		ob_start();

		if( !is_user_logged_in() ):
            wp_die('You are not allowed to access this page');
            return;
            exit;
        endif;

		/**
		 * Get all registered post types
		 */
		$args = array(
		'public'   => true,
		'_builtin' => false
		);

		$output = 'objects'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'

		$post_types = get_post_types( $args, $output, $operator ); 
		?>
		<div class="gps-form-wrapper">
			<h1>Add New Post</h1>
			<form action="" method="POST" name="gps-form" id="gps-form" enctype="multipart/form-data" autocomplete="off">
				<?php wp_nonce_field( 'guest_post_action' ); ?>
				<div class="input-group">
					<label for="txt_title">Post Title</label>
					<input type="text" name="txt_title" id="txt_title" placeholder="Post Title">
				</div>
				<div class="input-group">
					<label for="txt_post_type">Choose Post Type</label>
					<select name="txt_post_type" id="txt_post_type">
						<option value="">-----</option>
						<?php foreach( $post_types as $post_type ){ ?>
						<option value="<?php echo esc_attr( $post_type->name ); ?>"><?php echo esc_html( $post_type->label ); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="input-group">
					<label for="txt_description">Description</label>
					<?php
					$content   = '';
					$editor_id = 'txt_description';
					$media_buttons  = array( 'media_buttons' => false );
					wp_editor( $content, $editor_id, $media_buttons );
					?>
				</div>
				<div class="input-group">
					<label for="txt_excerpt">Excerpt</label>
					<textarea name="txt_excerpt" id="txt_excerpt" placeholder="Short Description"></textarea>
				</div>
				<div class="input-group">
					<label for="txt_featured_image">Featured Image</label>
					<?php wp_nonce_field( 'txt_featured_image', 'txt_featured_image_nonce' ); ?>
					<input type="file" name="txt_featured_image" id="txt_featured_image">
				</div>
				<div class="input-group">
					<input type="submit" name="txt_submit" id="txt_submit" value="Submit" class="gps-btn-submit">
				</div>
			</form>
		</div>
		<div class="success-message"></div>
		<?php 
		return ob_get_clean();
	}
	/**
	 * Insert Post
	 */
	public function create_post_using_ajax(){
		ob_clean();

		//check user is logged in
		if( !is_user_logged_in() ):
            return;
            exit;
        endif;
		
		if ( ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'],'guest_post_action') && $_POST['action'] == 'create_post_using_ajax' ) {
			
			$gps_post_title		= wp_strip_all_tags( $_POST['gps_post_title'] );
			$gps_post_type		= sanitize_text_field( $_POST['gps_post_type'] );
			$gps_post_content 	= wp_kses_post( $_POST['gps_post_content'] );
			$gps_post_excerpt 	= sanitize_textarea_field( $_POST['gps_post_excerpt'] );
			$gps_author_id 		= get_current_user_id();
			$gps_post_status	= "draft";

			$gps_post = array(
				'post_title'   => $gps_post_title,
				'post_content' => $gps_post_content,
				'post_excerpt' => $gps_post_excerpt,
				'post_status'  => $gps_post_status,
				'post_type'    => $gps_post_type,
				'post_author'  => $gps_author_id
			);

			// Insert the post into the database
			$gps_post_insert_id = wp_insert_post( $gps_post );

			if ( isset( $_POST['txt_featured_image_nonce'] ) && wp_verify_nonce( $_POST['txt_featured_image_nonce'], 'txt_featured_image') ) {
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
				$attachment_id = media_handle_upload('txt_featured_image', $gps_post_insert_id );
				set_post_thumbnail($gps_post_insert_id, $attachment_id);
				if ( is_wp_error( $attachment_id ) ) {
					echo "Issue uploading media";
				}
			}

			if( $gps_post_insert_id ){
				$to      = get_option( 'admin_email' );
				$subject = 'Guest Post/Page Moderation';
				$body    = 'New Post/page have been successfully created by Guest user.';
				$headers = array( 'Content-Type: text/html; charset=UTF-8' );
				$mail	 = wp_mail( $to, $subject, $body, $headers );
			}

		}else{
			echo "<p class='error'>Something went wrong please try again.</p>";
		}
		
		wp_die();
	}
	/**
	 * Display All Posts
	 */
	public function display_all_posts(){
		ob_start();

		// Get logged-in user id.
		$gps_author_id = get_current_user_id();

		// Get custom post types.
		$args = array(
			'public'   => true,
			'_builtin' => false,
		);
		$output     = 'names';
		$operator   = 'and';
		$gps_post_types = get_post_types( $args, $output, $operator );

		$gps_paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		// The Query
		$gps_query = new WP_Query(
			array(
				'post_type'      => $gps_post_types,
				'author'         => $gps_author_id,
				'posts_per_page' => 10,
				'paged'          => $gps_paged,
			)
		);
		if( $gps_query->have_posts() ){ ?>
			
			<div class="gpsblogWrapper">
				<!-- the loop -->
				<?php while( $gps_query->have_posts() ){ $gps_query->the_post();  ?>
					<div class="gpsblog__item">
						<h3><?php echo get_the_title(); ?></h3>
						<?php the_excerpt(); ?>
						<a href="<?php echo get_permalink(); ?>" class="btn-readmore">Read More</a>
					</div>
				<?php } ?>
				<!-- the loop -->
			</div>
			<!-- pagination here -->
			<div class="gps-panination-section">
				<?php $maximum = 999;
				echo paginate_links(
					array(
						'base'    => str_replace( $maximum, '%#%', get_pagenum_link( $maximum ) ),
						'format'  => '?paged=%#%',
						'current' => max( 1, get_query_var( 'paged' ) ),
						'total'   => $gps_query->max_num_pages,
					)
				); ?>
			</div>
			<!-- pagination here -->

		<?php }else{ ?>
			<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?>
		<?php }
		wp_reset_postdata();
		return ob_get_clean();
	}

}
