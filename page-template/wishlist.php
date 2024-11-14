<?php 
/**
    * Template Name: Whishlist    
    * The template for displaying all pages
    *
    * This is the template that displays all pages by default.
    * Please note that this is the WordPress construct of pages
    * and that other 'pages' on your WordPress site may use a
    * different template.
    *
    * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
    *
    * @package sanas
*/
get_header();
get_sidebar('dashboard');
?>
  <div class="wl-dashboard-wrapper dashboard">
    <div class="container-fluid wl-dashboard-content">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="page-header">
            <h4 class="pageheader-title"><?php the_title(); ?></h4>
          </div>
        </div>
      </div>
<?php
global $wpdb;
$current_user_id = get_current_user_id();
$wishlist_items = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}sanas_wishlist WHERE user_id = %d",
        $current_user_id
    )
);
?>
      <div class="category-wishlist">
<?php
function get_sanas_card_category_ids($card_id) {
  $terms = wp_get_post_terms($card_id, 'sanas-card-category', array('fields' => 'ids'));
  if (!is_wp_error($terms) && !empty($terms)) {
      return $terms;
  }
  return [];
}
if (!empty($wishlist_items)) {
  ?>
        <div class="inner">
          <div class="row">
            <div class="category-list-outer col-xl-3 col-lg-3 col-md-4">
              <div class="category-sidebar">
                <div class="category-list">
                  <ul class="m-0">
                    <?php echo sanas_card_category_wishlist();?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="wishlist-outer col-xl-9 col-lg-9 col-md-8 pt-3 pb-3">
              
              <div class="wishlist-inner">
                <div class="row">
<?php
    foreach ($wishlist_items as $item) {
      $card_id = $item->card_id;
      $card_post = get_post($card_id);
      $terms = get_the_terms($card_id, 'sanas-card-category');
      $category_ids = get_sanas_card_category_ids($card_id);
    if (!empty($category_ids)) {
      $category_ids_string = implode(',', $category_ids);
    } else {
        echo 'No categories found for this card.';
    }


        if ($card_post) {
            $event_front_card_preview = get_post_meta($card_post->ID, 'event_front_card_preview', true);
            $event_back_card_preview = get_post_meta($card_post->ID, 'event_back_card_preview', true);
            
            
            $sanas_metabox = get_post_meta($card_post->ID, 'sanas_metabox', true);

            if (!empty($sanas_metabox)) {
                $meta_data = maybe_unserialize($sanas_metabox);
                $front_image_url = $meta_data['sanas_upload_front_Image']['url'] ?? 'No front image found';
                $back_image_url = $meta_data['sanas_upload_back_Image']['url'] ?? 'No back image found';

            ?>

            <div class="wishlist-box col-xxl-4 col-xl-5 col-lg-6 col-md-6 col-sm-6" data-category="<?php echo $category_ids_string; ?>">
                <div class="inner-box">
                    <a href="/user-dashboard/?dashboard=cover&card_id=<?php echo $card_post->ID; ?>" class="flip-container">
                        <div class="flipper">
                            <div class="front">
                                <img src="<?php echo esc_url($front_image_url); ?>" alt="template">
                            </div>
                            <div class="middel-card">
                                <img src="<?php echo esc_url($back_image_url); ?>" alt="template">
                            </div>
                            <div class="back">
                                <img src="<?php echo esc_url($back_image_url); ?>" alt="template">
                            </div>
                        </div>
                    </a>
                    <div class="lower-content">
                        <h4 class="text-capitalize"><?php echo esc_html(get_the_title($card_post->ID)); ?></h4>
                        <div class="delete-icon wishlist-delete-icon" data-card-id="<?php echo $card_id; ?>">
                            <i class="fa fa-trash"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            } else {
              echo 'You have no favorites yet. Start browsing our exclusive cards and save your favorites now!';
            }
        }
    }
?>
                </div>
              </div>
            </div>
          </div>
          </div>
<?php
} else {
  echo '<p>You have no favorites yet. Start browsing our exclusive cards and save your favorites now!</p>';
}
?>
      </div>

    </div>
  </div>
  <?php render_confirm_modal_html_alert(); ?>
  <script>
        document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.category-link');
    const wishlistBoxes = document.querySelectorAll('.wishlist-box');

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const selectedCategory = this.getAttribute('data-category');
            if (!selectedCategory) {
                wishlistBoxes.forEach(box => {
                    box.style.display = 'block';
                });
                return;
            }
            wishlistBoxes.forEach(box => {
                const boxCategories = box.getAttribute('data-category').split(',');
                if (boxCategories.includes(selectedCategory)) {
                    box.style.display = 'block';
                } else {
                    box.style.display = 'none';
                }
            });
        });
    });
});
    </script>
  <!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.category-link');
    const wishlistBoxes = document.querySelectorAll('.wishlist-box');

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const selectedCategory = this.getAttribute('data-category');
            if (!selectedCategory) {
                wishlistBoxes.forEach(box => {
                    box.style.display = 'block';
                });
                return;
            }
            wishlistBoxes.forEach(box => {
                const boxCategories = box.getAttribute('data-category').split(',');
                if (boxCategories.includes(selectedCategory)) {
                    box.style.display = 'block';
                } else {
                    box.style.display = 'none';
                }
            });
        });
    });
});

// jQuery(document).ready(function ($) {
//   jQuery(".wishlist-delete-icon").on("click", function (e) {
//     show_alert_message2('Remove from wishlist', 'Do you want to this card from My Favorites?','yes');
//     return;
//     e.preventDefault();
//     var $icon = $(this);
//     var cardId = $icon.data("card-id");

//     $.ajax({
//       url: sanas_ajax_object.ajax_url,
//       type: "POST",
//       data: {
//         action: "remove_from_wishlist",
//         card_id: cardId,
//         security: sanas_ajax_object.security,
//       },
//       success: function (response) {
//         if (response.success) {
//           location.reload();
//           // $icon.closest(".wishlist-box").remove();
//         } else {
//           console.log("Something went wrong. Please try again.");
//         }
//       },
//     });
//   });
// });
jQuery(document).ready(function ($) {
    // Function to show the modal
    function show_alert_message2(title, message) {
        $('#exampleModalLabel').text(title);
        $('#modal-body-text').text(message);
        $('#modal_html_alert').modal('show');
    }

    // When "Yes" button is clicked
    $('#modal-yes-button').on('click', function () {
        // Trigger the removal process
        proceedWithRemoval();
        $('#modal_html_alert').modal('hide');
    });

    // Function to handle the AJAX call for removal
    function proceedWithRemoval() {
        var $icon = $('.wishlist-delete-icon[data-card-id="' + currentCardId + '"]');

        $.ajax({
            url: sanas_ajax_object.ajax_url,
            type: "POST",
            data: {
                action: "remove_from_wishlist",
                card_id: currentCardId,
                security: sanas_ajax_object.security,
            },
            success: function (response) {
                if (response.success) {
                    location.reload();
                } else {
                    console.log("Something went wrong. Please try again.");
                }
            },
        });
    }

    // Keep track of the card ID for the current action
    var currentCardId;

    // Click handler for the delete icon
    $(".wishlist-delete-icon").on("click", function (e) {
        e.preventDefault();
        currentCardId = $(this).data("card-id");

        show_alert_message2('Remove from wishlist', 'Do you want to remove this card from My Favorites?');
    });
});


    </script> -->
<?php
get_footer('dashboard');