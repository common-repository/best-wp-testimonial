<?php
/**
 * Adds a submenu page under a custom post type parent.
 */
function register_bwpt_settings_page() {
    add_submenu_page(
        'edit.php?post_type=testimonial',
        __( 'Settings', 'bwpt' ),
        __( 'Settings', 'bwpt' ),
        'manage_options',
        'bwpt-settings-page',
        'elements_bwpt_settings_page'
    );
}
add_action('admin_menu', 'register_bwpt_settings_page');
 
/**
 * Display callback for the submenu page.
 */
function elements_bwpt_settings_page() { 
    ?>

<div class="wrap bwpt-warp">
  <div class="bwpt-main-body">
    <h2>
      <?php echo esc_attr(__('Testimonial Settings')); ?>
    </h2>
    <form action="options.php" method="post">
      <div class="clsrFX"></div>
      <?php wp_nonce_field('update-options'); ?>
      <label name="color_theme" for="color_theme" ><?php echo esc_attr(__('Color Theme:')); ?></label>
      <input type="text" name="color_theme" value="<?php echo get_option( 'color_theme' ); ?>" class="color-picker"/>
      <div class="clsrFX"></div>
      <label name="hover_color" for="hover_color" ><?php echo esc_attr(__('Hover Color:')); ?></label>
      <input type="text" name="hover_color" value="<?php echo get_option( 'hover_color' ); ?>"class="color-picker" />
      <div class="clsrFX"></div>
      <label name="bwpt_display" for="bwpt_display" ><?php echo esc_attr(__('Display Post:')); ?></label>
      <input type="text" name="bwpt_display" value="<?php echo get_option( 'bwpt_display' ); ?>" />
      <div class="clsrFX"></div>
      <label for="bwpt_auto"><?php echo esc_attr(__('Auto Play:')); ?></label>
      <select name="bwpt_auto" id="bwpt_auto">
      	<option value="true" <?php if( get_option('bwpt_auto') == 'true'){ echo 'selected="selected"'; } ?>>YES</option>
        <option value="false" <?php if( get_option('bwpt_auto') == 'false'){ echo 'selected="selected"'; } ?>>NO</option>
      </select>
      <div class="clsrFX"></div>
      <label for="bwpt_navigation"><?php echo esc_attr(__('Display Navigation:')); ?></label>
      <select name="bwpt_navigation" id="bwpt_navigation">
      	<option value="true" <?php if( get_option('bwpt_navigation') == 'true'){ echo 'selected="selected"'; } ?>>YES</option>
        <option value="false" <?php if( get_option('bwpt_navigation') == 'false'){ echo 'selected="selected"'; } ?>>NO</option>
      </select>
      <div class="clsrFX"></div>
      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="color_theme, hover_color, bwpt_display, bwpt_auto, bwpt_navigation" />
      <input type="submit" name="submit" value="<?php _e( 'Save Changes', 'bwpt' ); ?>" class="button" />
      <div class="clsrFX"></div>
    </form>
  </div>
  <div class="bwpt-sidebar">
    <h3><?php echo esc_attr(__('About the Author')); ?></h3>
    <p>I'm <strong><a href="https://www.upwork.com/freelancers/~01bf79370d989b2033" target="_blank">S M Hasibul Islam</a></strong>, a <strong><a href="http://www.e2softsolution.com/" target="_blank">Web Developer, Expert WordPress Developer</a></strong>. I'm regularly available for interesting freelance projects. If you ever need my help, do not hesitate to get in touch <a href="https://www.upwork.com/freelancers/~01bf79370d989b2033" target="_blank">me</a>.<br />
      <strong>Skype:</strong> cse.hasib<br />
      <strong>Mail:</strong> cse.hasib@gmail.com<br />
  </div>
</div>
<?php
}
?>