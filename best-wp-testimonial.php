<?php
/**
 * Plugin Name:       Best WP Testimonial
 * Plugin URI:        https://wordpress.org/plugins/best-wp-testimonial/
 * Description:       Best WP Testimonial is a WordPress plugin to display your client review or testimonial in your WordPress website.
 * Version:           1.0.4
 * Requires at least: 5.0
 * Author:            Hasibul Islam Badsha
 * Author URI:        https://www.e2softsolution.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bwpt
 */
 
 
 /**
 * bwpt enqueue styles
 */
function bwpt_enqueue_style() {
	
    wp_enqueue_style( 'owl.carousel', plugins_url( 'css/owl.carousel.min.css', __FILE__ ) );
	wp_enqueue_style( 'owl.theme', plugins_url( 'css/owl.theme.min.css', __FILE__ ) );
	wp_enqueue_style( 'bwpt-style', plugins_url( 'css/bwpt-style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'bwpt_enqueue_style' );


/**
 * bwpt enqueue scripts
 */
function bwpt_enqueue_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'owl.carousel', plugins_url( 'js/owl.carousel.min.js', __FILE__ ), array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'bwpt_enqueue_scripts' );


/**
 * Enqueue a custom stylesheet in the WordPress admin.
 */
function bwpt_enqueue_admin_style() {
    wp_enqueue_style( 'bwpt-admin-style', plugins_url( 'css/bwpt-admin-style.css', __FILE__ ), false, '1.0.0' );
	wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
	wp_enqueue_script( 'cp-active', plugins_url('/js/cp-active.js', __FILE__), array('jquery'), '', true );
}
add_action( 'admin_enqueue_scripts', 'bwpt_enqueue_admin_style' );


/**
 * bwpt custom post
 */
if ( ! function_exists('bwpt_custom_post_type') ) {
// Register Custom Post Type
function bwpt_custom_post_type() {
	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'bwpt' ),
		'singular_name'         => _x( 'Testimonial Type', 'Post Type Singular Name', 'bwpt' ),
		'menu_name'             => __( 'Testimonials', 'bwpt' ),
		'name_admin_bar'        => __( 'Post Type', 'bwpt' ),
		'archives'              => __( 'Item Archives', 'bwpt' ),
		'attributes'            => __( 'Item Attributes', 'bwpt' ),
		'parent_item_colon'     => __( 'Parent Item:', 'bwpt' ),
		'all_items'             => __( 'All Items', 'bwpt' ),
		'add_new_item'          => __( 'Add New Item', 'bwpt' ),
		'add_new'               => __( 'Add New', 'bwpt' ),
		'new_item'              => __( 'New Item', 'bwpt' ),
		'edit_item'             => __( 'Edit Item', 'bwpt' ),
		'update_item'           => __( 'Update Item', 'bwpt' ),
		'view_item'             => __( 'View Item', 'bwpt' ),
		'view_items'            => __( 'View Items', 'bwpt' ),
		'search_items'          => __( 'Search Item', 'bwpt' ),
		'not_found'             => __( 'Not found', 'bwpt' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'bwpt' ),
		'featured_image'        => __( 'Featured Image', 'bwpt' ),
		'set_featured_image'    => __( 'Set featured image', 'bwpt' ),
		'remove_featured_image' => __( 'Remove featured image', 'bwpt' ),
		'use_featured_image'    => __( 'Use as featured image', 'bwpt' ),
		'insert_into_item'      => __( 'Insert into item', 'bwpt' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'bwpt' ),
		'items_list'            => __( 'Items list', 'bwpt' ),
		'items_list_navigation' => __( 'Items list navigation', 'bwpt' ),
		'filter_items_list'     => __( 'Filter items list', 'bwpt' ),
	);
	$args = array(
		'label'                 => __( 'Testimonial Type', 'bwpt' ),
		'description'           => __( 'Testimonial Description', 'bwpt' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'testimonial', $args );
}
add_action( 'init', 'bwpt_custom_post_type', 0 );
}

/**
 * bwpt post loop
 */
function bwpt_testimonial_loop(){ 
ob_start(); ?>
<div id="testimonial-slider" class="owl-carousel">
  <?php 
	// WP_Query arguments
	$args = array(
		'post_type'              => array( 'testimonial' ),
		'post_status'            => array( 'publish' ),
	);
	
	// The Query
	$bwpt_query = new WP_Query( $args );
	
	// The Loop
	if ( $bwpt_query->have_posts() ) {
		while ( $bwpt_query->have_posts() ) {
			$bwpt_query->the_post();
			// do something
			?>
  <div class="testimonial">
    <div class="pic"> <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>" alt="<?php the_title(); ?>"> </div>
    <h3 class="title">
      <?php the_title(); ?>
    </h3>
    <p class="description">
      <?php the_excerpt();  ?>
    </p>
    <div class="testimonial-content">
      <div class="testimonial-profile">
        <h3 class="name"><?php echo get_post_meta( get_the_ID(), 'testi_name', true ); ?></h3>
        <span class="post"><?php echo get_post_meta( get_the_ID(), 'testi_desig', true ); ?></span> </div>
      <ul class="rating">
        <?php
                          $bwpt_client_review = get_post_meta( get_the_ID(), 'testi_rating', true );
						  if($bwpt_client_review ==1){
							  echo "<li class='fa fa-star'></li>";
						  }elseif($bwpt_client_review ==2){
							  echo "<li class='fa fa-star'></li><li class='fa fa-star'></li>";
						  }elseif($bwpt_client_review ==3){
							  echo "<li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fa fa-star'></li>";
						  }elseif($bwpt_client_review ==4){
							  echo "<li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fa fa-star'></li>";
						  }elseif($bwpt_client_review ==5){
							  echo "<li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fa fa-star'></li>";
						  }elseif($bwpt_client_review =="1.5"){
							  echo "<li class='fa fa-star'></li><li class='fas fa-star-half'></li>";
						  }elseif($bwpt_client_review =="2.5"){
							  echo "<li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fas fa-star-half'></li>";
						  }elseif($bwpt_client_review =="3.5"){
							  echo "<li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fas fa-star-half'></li>";
						  }elseif($bwpt_client_review =="4.5"){
							  echo "<li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fa fa-star'></li><li class='fas fa-star-half'></li>";
						  }else{
							  echo "no rating";
						  }
                          ?>
      </ul>
    </div>
  </div>
  <?php }
	} else {
		// no posts found
	}
	// Restore original Post Data
	wp_reset_postdata();
	?>
</div>
<?php }

/**
 * Remove auto paragraph
 */	
remove_filter('the_excerpt', 'wpautop');

/**
	jQuary Settings.
**/
function bwpt_testimonial_script(){?>
<script>
jQuery(document).ready(function(){
    jQuery("#testimonial-slider").owlCarousel({
        items:<?php $bwpt_display = get_option('bwpt_display'); if(!empty($bwpt_display)) {echo $bwpt_display;} else {echo "2";}?>,
        itemsDesktop:[1000,2],
        itemsDesktopSmall:[979,2],
        itemsTablet:[768,2],
        itemsMobile:[650,1],
        navigationText:["",""],
		pagination:false,
        autoPlay:<?php $bwpt_auto = get_option('bwpt_auto'); if(!empty($bwpt_auto)) {echo $bwpt_auto;} else {echo "false";}?>,
		navigation:<?php $bwpt_navigation = get_option('bwpt_navigation'); if(!empty($bwpt_navigation)) {echo $bwpt_navigation;} else {echo "true";}?>
    });
});
</script>
<?php }
add_action('wp_footer', 'bwpt_testimonial_script', 100);

/**
 * bwpt shortcode
 */	
function bwpt_testimonial_shortcode() {
    add_shortcode( 'BWPTTESTIMONIAL', 'bwpt_testimonial_loop' );
}
add_action( 'init', 'bwpt_testimonial_shortcode' );

/**
	Get all php file.
**/
foreach ( glob( plugin_dir_path( __FILE__ )."inc/*.php" ) as $php_file )
    include_once $php_file;
	
/**
	bwpt redirect to plugin settings page.
**/
register_activation_hook(__FILE__, 'bwpt_plugin_activate');
add_action('admin_init', 'bwpt_plugin_redirect');

function bwpt_plugin_activate() {
    add_option('bwpt_plugin_do_activation_redirect', true);
}

function bwpt_plugin_redirect() {
    if (get_option('bwpt_plugin_do_activation_redirect', false)) {
        delete_option('bwpt_plugin_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("edit.php?post_type=testimonial&page=bwpt-settings-page");
        }
    }
}
?>