<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
CSF::createMetabox('sanas_metabox',array(
	'title'		=> esc_html__('Metabox Options','sanas'),
	'post_type'	=> array('sanas_card'),
	'show_restore'=> true,
	'context'	=> 'advanced',
));
CSF::createSection('sanas_metabox',array(
	'title'		=> esc_html__('canvas Image','sanas'),
	'icon'		=> 'fas fa-arrow-up',
	'fields'	=> array(
        array(
			'id'		=> 'sanas_front_canavs_image',
			'title'		=> esc_html__('Front Image Data','sanas'),
			'type'		=> 'textarea',
		),
		 array(
			'id'		=> 'sanas_back_canavs_image',
			'title'		=> esc_html__('Back Image Data','sanas'),
			'type'		=> 'textarea',  
		),
	array(
	  'id'		=> 'sanas_cover_call',
	  'type'     => 'callback',
	  'function' => 'sanas_cover_callback_function',
	),	
	array(
	  'id'		=> 'sanas_back_call',
	  'type'     => 'callback',
	  'function' => 'sanas_back_callback_function',
	),			 
	),
));
CSF::createSection('sanas_metabox',array(
	'title'		=> esc_html__('Upload Front Image','sanas'),
	'icon'		=> 'fas fa-arrow-up',
	'fields'	=> array(
		array(
			'id'		=> 'sanas_upload_front_Image',
			'title'		=> esc_html__('Upload Fornt Image','sanas'),
			'type'		=> 'media',
			'preview'=> true,
			'preview_size'=> 'full',
		),
	),
));
CSF::createSection('sanas_metabox',array(
	'title'		=> esc_html__('Upload Back Image','sanas'),
	'icon'		=> 'fas fa-arrow-up',
	'fields'	=> array(
		array(
			'id'		=> 'sanas_upload_back_Image',
			'title'		=> esc_html__('Upload Back Image','sanas'),
			'type'		=> 'media',
			'preview'=> true,
			'preview_size'=> 'full',
		),
	),
));
CSF::createSection('sanas_metabox',array(
	'title'		=> esc_html__('Card Back Ground','sanas'),
	'icon'		=> 'fas fa-arrow-up',
	'fields'	=> array(
		array(
			'id'		=> 'sanas_bg_color',
			'title'		=> esc_html__('Card BG Color','sanas'),
			'type'		=> 'color',
		),
	),
));




CSF::createMetabox('sanas_metabox_home',array(
	'title'		=> esc_html__('Home Options','sanas'),
	'post_type'	=> array('sanas_card'),
	'show_restore'=> true,
	'context'	=> 'advanced',
	'data_type'	=> 'unserialize ',
));

CSF::createSection('sanas_metabox_home',array(
	'fields'	=> array(
		array(
			'id'		=> 'sanas_show_homepage',
			'title'		=> esc_html__('Display Home Page','sanas'),
			'type'		=> 'switcher',
		),
		array(
			'id'		=> 'sanas_bestloved_homepage',
			'title'		=> esc_html__('Best Loved On Home Page','sanas'),
			'type'		=> 'switcher',
		),		
	),
));


if( class_exists( 'CSF' ) ) {


	$meta_prefix = 'card_category_meta';

	//
	// Create taxonomy options
	CSF::createTaxonomyOptions( $meta_prefix, array(
	'taxonomy'  => 'sanas-card-category',
	'data_type' => 'unserialize', // The type of the database save options. `serialize` or `unserialize`
	) );


// Create a section
  CSF::createSection( $meta_prefix, array(
    'fields' => array(

      array(
        'id'    => 'card_category_front_gallery',
        'type'  => 'gallery',
        'title' => 'Front Template Images in Gallery',
      ),
     array(
        'id'    => 'card_category_back_gallery',
        'type'  => 'gallery',
        'title' => 'Back Template Images in Gallery',
      )
	  ,
	  array(
		 'id'    => 'card_category_cover_image',
		 'type'  => 'media',
		 'title' => 'Card Category Cover Image',
		 'preview' => true,
		 'preview_size' => 'full',
	   )
     ,
     array(
        'id'    => 'card_category_home',
        'type'  => 'switcher',
        'title' => 'Checked To Display on Home Page',
      )
     ,
     array(
        'id'    => 'card_category_personalize',
        'type'  => 'switcher',
        'title' => 'Checked To Display on Personalize Card',
      )
    )
 ) );

}

function sanas_cover_callback_function() {

	$post_id=get_the_ID();
	$cover_url = site_url('/user-dashboard/?dashboard=cover&card_id=' . $post_id );

  echo '<div class="csf-title"><h4>Cover Page Design</h4></div>';
  echo '<div class="csf-fieldset"><a href="'.$cover_url.'" target="blank">Click To Design Front</a></div><div class="clear"></div>';


}

function sanas_back_callback_function() {

	$post_id=get_the_ID();
	$back_url = site_url('/user-dashboard/?dashboard=details&card_id=' . $post_id );

  echo '<div class="csf-title"><h4>Back Page Design</h4></div>';
  echo '<div class="csf-fieldset"><a href="'.$back_url.'" target="blank">Click To Design Back Page</a></div>';

}