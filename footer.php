<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sanas
 */
wp_footer(); 
do_action('sanas_get_login');
sanas_render_modal_html_alert();
?>
<footer>
      <div class="container-xl container-fluid">
        <div class="row">
          <div class="footer-column col-md-3 col-sm-3 col-lg-2 col-xl-2 footer-item">
            <div class="footer-widget logo-widget">
              <div class="logo">
                <a href="index.html"> <img width="126" height="58" src="<?php echo get_template_directory_uri(); ?>/assets/img/Sana__s_Hub.png.svg" alt="logo"></a>
              </div>
            </div>
          </div>
          <div class="footer-column col-md-3 col-sm-4 col-lg-2 col-xl-2 footer-item">      
            <h4> Category</h4>
            <?php
            wp_nav_menu(
                    array(
                        'theme_location'  => 'sanas-footer-menu',
                        'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                        'fallback_cb'     => false,
                        'menu_class'      => 'footer-link',
                        'link_class'   => 'nav-header hidden',
                        'walker' => new Footer_Walker_Nav_Menu()
                    )
                );
             ?>            
          </div>
          <div class="footer-column col-md-3 col-sm-4 col-lg-2 col-xl-2 footer-item">
            <h4>Planning</h4>
            <ul class="footer-link">
              <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Guest List</a></li>
              <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Budget</a></li>
              <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Vendor</a></li>
              <li><a href="#"><i class="fa-solid fa-chevron-right"></i>To Do List</a></li>
              <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Wishlist</a></li>
            </ul>
          </div>
          <div class="footer-column col-md-3 col-sm-3 col-lg-2 col-xl-2 footer-item">
            <h4>Support</h4>
            <ul class="footer-link">
              <li><a class="login-in" href="javascript:">Member Login</a></li>
              <li><a href="#">Contact Us</a></li>
            </ul>
          </div>
          <div class="footer-column col-md-6 col-sm-9 col-lg-4 col-xl-4 footer-item">
            <div class="footer-widget newsletter-widget">
              <h4>Newsletter</h4>
              <p class="text">Subscribe to our newsletter to receive exclusive offers and
                wedding tips</p>
              <div class="newsletter-form">
                <form action="#">
                  <div class="form-group">
                    <input type="email" name="email" value="" placeholder="Email Address" required="">
                    <button type="submit" class="submit-btn">GO</button>
                  </div>
                </form>
              </div>
              <ul class="social-box">
                <li><a href="https://www.facebook.com/" class="fab fa-facebook-f" target="_blank"></a></li>
                <li><a href="https://www.twitter.com/" class="fab fa-twitter" target="_blank"></a>
                </li>
                <li><a href="https://www.linkedin.com/" class="fab fa-linkedin-in" target="_blank"></a></li>
                <li><a href="https://www.instagram.com/" class="fab fa-instagram" target="_blank"></a></li>
                <li><a href="https://www.pinterest.com/" class="fab fa-pinterest-p" target="_blank"></a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-5 col-md-8 col-sm-12">
            <div class="tag-line">
              <a href="https://www.sanashub.com/" target="_blank">Vendors - Get Listed Today</a>
            </div>
          </div>
        </div>
        <div class="copy-right text-center">
          <p> © 2024 <a href="#">Sana's Hub</a> All Rights Reserved <a href="#">Terms of Use</a> <a href="#">Privacy
              Policy</a> </p>
        </div>
      </div>
    </footer>
</body>
</html>