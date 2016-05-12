<?php
/**
 * Plugin Name: Beaverlodge Recipes
 * Plugin URI: https://www.beaverlodgehq.com
 * Description: Add a recipe post type and module to use with Beaver Builder Plugin.
 * Version: 1.0
 * Author: Beaverlodge HQ
 * Author URI: https://www.beaverlodgehq.com
 */


function sw_load_metabox_plugins() {
    if( !class_exists( 'RW_Meta_Box' ) ) {
        include( plugin_dir_path( __FILE__ ) . '/assets/meta-box/meta-box.php');
        include( plugin_dir_path( __FILE__ ) . '/assets/meta-box-tabs/meta-box-tabs.php');
    }
}
add_action( 'init', 'sw_load_metabox_plugins' );

function get_recipe_template($single_template) {
     global $post;

     if ($post->post_type == 'recipes') {
          $single_template = dirname( __FILE__ ) . '/single-recipes.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_recipe_template' );

function get_recipe_archive_template( $archive_template ) {
     global $post;

     if ( is_post_type_archive ( 'recipes' ) ) {
          $archive_template = dirname( __FILE__ ) . '/archive-recipes.php';
     }
     return $archive_template;
}

add_filter( 'archive_template', 'get_recipe_archive_template' ) ;

if ( ! function_exists('sw_recipe_post_type') ) {

// Register Custom Post Type
function sw_recipe_post_type() {

	$labels = array(
		'name'                  => _x( 'Recipes', 'Post Type General Name', 'sw-recipes' ),
		'singular_name'         => _x( 'Recipe', 'Post Type Singular Name', 'sw-recipes' ),
		'menu_name'             => __( 'Recipes', 'sw-recipes' ),
		'name_admin_bar'        => __( 'Recipe', 'sw-recipes' ),
		'archives'              => __( 'Recipe Archives', 'sw-recipes' ),
		'parent_item_colon'     => __( 'Parent Recipe:', 'sw-recipes' ),
		'all_items'             => __( 'All Recipes', 'sw-recipes' ),
		'add_new_item'          => __( 'Add New Recipe', 'sw-recipes' ),
		'add_new'               => __( 'Add New', 'sw-recipes' ),
		'new_item'              => __( 'New Recipe', 'sw-recipes' ),
		'edit_item'             => __( 'Edit Recipe', 'sw-recipes' ),
		'update_item'           => __( 'Update Recipe', 'sw-recipes' ),
		'view_item'             => __( 'View Recipe', 'sw-recipes' ),
		'search_items'          => __( 'Search Recipe', 'sw-recipes' ),
		'not_found'             => __( 'Not found', 'sw-recipes' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sw-recipes' ),
		'featured_image'        => __( 'Recipe Image', 'sw-recipes' ),
		'set_featured_image'    => __( 'Set recipe image', 'sw-recipes' ),
		'remove_featured_image' => __( 'Remove recipe image', 'sw-recipes' ),
		'use_featured_image'    => __( 'Use as recipe image', 'sw-recipes' ),
		'insert_into_item'      => __( 'Insert into recipe', 'sw-recipes' ),
		'uploaded_to_this_item' => __( 'Uploaded to this recipe', 'sw-recipes' ),
		'items_list'            => __( 'Recipes list', 'sw-recipes' ),
		'items_list_navigation' => __( 'Recipes list navigation', 'sw-recipes' ),
		'filter_items_list'     => __( 'Filter recipes list', 'sw-recipes' ),
	);
	$args = array(
		'label'                 => __( 'Recipe', 'sw-recipes' ),
		'description'           => __( 'Recipes', 'sw-recipes' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'comments' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-carrot',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'recipes', $args );

}
add_action( 'init', 'sw_recipe_post_type', 0 );

}


function sw_recipe_metaboxes( $meta_boxes )
{

	$meta_boxes[] = array(
		'title'     => __( 'Recipe Information', 'sw-recipes' ),
        'post_types' => array( 'recipes' ),
        'context'    => 'normal',
        'priority'   => 'high',

		'tabs'      => array(
			'descriptions'    => array(
				'label' => __( 'Description', 'sw-recipes' ),
				'icon'  => 'dashicons-edit', 
			),
			'ingredients' => array(
				'label' => __( 'Ingredients', 'sw-recipes' ),
				'icon'  => 'dashicons-carrot',
			),
			'instructions'  => array(
				'label' => __( 'Instructions', 'sw-recipes' ),
				'icon'  => 'dashicons-list-view',
			),
			'notes'    => array(
				'label' => __( 'Notes', 'sw-recipes' ),
				'icon'  => 'dashicons-paperclip', 
			),
		),

		'tab_style' => 'box',

		'tab_wrapper' => true,
		'fields'    => array(
			array(
				'name'  => __( 'Recipe Description', 'sw-recipes' ),
				'id'    => 'description',
				'type'  => 'wysiwyg',
				'tab'   => 'descriptions',
			),
			array(
				'name'  => __( 'Ingredient Items', 'sw-recipes' ),
				'id'    => 'ingredient',
				'type'  => 'text',
				'tab'   => 'ingredients',
				'clone' => 'true',
				'sort_clone' => 'true',
			),
			array(
				'name'  => __( 'Recipe Steps', 'sw-recipes' ),
				'id'    => 'instruction',
				'type'  => 'text',
				'tab'   => 'instructions',
				'clone' => 'true',
				'sort_clone' => 'true',
			),
			array(
				'name'  => __( 'Prep Time (mins)', 'sw-recipes' ),
				'id'    => 'prep',
				'type'  => 'number',
				'size'  => 30,
				'tab'   => 'notes',
			),
			array(
				'name'  => __( 'Cook Time (mins)', 'sw-recipes' ),
				'id'    => 'cook',
				'type'  => 'number',
				'size'  => 30,
				'tab'   => 'notes',
			),
			array(
				'name'  => __( 'Ingredient Count', 'sw-recipes' ),
				'id'    => 'ingredient-qty',
				'type'  => 'number',
				'size'  => 30,
				'min'  => 0,
				'step'  => 1,
				'tab'   => 'notes',
			),
			array(
				'name'  => __( 'Servings', 'sw-recipes' ),
				'id'    => 'servings',
				'type'  => 'number',
				'size'  => 30,
				'min'  => 0,
				'step'  => 1,
				'tab'   => 'notes',
			),
			array(
				'name'  => __( 'Difficulty', 'sw-recipes' ),
				'id'    => 'difficulty',
				'type'  => 'radio',
                'options'   => array(
                    'Children'  => __( 'Children', 'sw-recipes' ),
                    'Easy'  => __( 'Easy', 'sw-recipes' ),
                    'Medium'  => __( 'Medium', 'sw-recipes' ),
                    'Hard'  => __( 'Hard', 'sw-recipes' ),
                    'Extreme'  => __( 'Extreme', 'sw-recipes' ),
                ),
				'tab'   => 'notes',
			),
			array(
				'name'  => __( 'Recipe Notes', 'sw-recipes' ),
				'id'    => 'note',
				'type'  => 'textarea',
				'tab'   => 'notes',
			),
		),
	);
	$meta_boxes[] = array(
		'title'  => __( 'Recipe Gallery', 'sw-recipes' ),
        'post_types' => array( 'recipes' ),
        'context'    => 'side',
        'priority'   => 'low',
		'fields' => array(
			array(
				'id'               => 'image_advanced',
				'name'             => __( 'Images', 'sw-recipes' ),
				'type'             => 'image_advanced',
				'force_delete'     => false,
			),
		),
	);
	
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'sw_recipe_metaboxes' );

if ( ! function_exists( 'sw_recipe_seasons' ) ) {

// Register Custom Taxonomy
function sw_recipe_seasons() {

	$labels = array(
		'name'                       => _x( 'Seasons', 'Taxonomy General Name', 'sw-recipes' ),
		'singular_name'              => _x( 'Season', 'Taxonomy Singular Name', 'sw-recipes' ),
		'menu_name'                  => __( 'Seasons', 'sw-recipes' ),
		'all_items'                  => __( 'All Seasons', 'sw-recipes' ),
		'parent_item'                => __( 'Parent Season', 'sw-recipes' ),
		'parent_item_colon'          => __( 'Parent Season:', 'sw-recipes' ),
		'new_item_name'              => __( 'New Season', 'sw-recipes' ),
		'add_new_item'               => __( 'Add New Season', 'sw-recipes' ),
		'edit_item'                  => __( 'Edit Season', 'sw-recipes' ),
		'update_item'                => __( 'Update Season', 'sw-recipes' ),
		'view_item'                  => __( 'View Season', 'sw-recipes' ),
		'separate_items_with_commas' => __( 'Separate seasons with commas', 'sw-recipes' ),
		'add_or_remove_items'        => __( 'Add or remove seasons', 'sw-recipes' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sw-recipes' ),
		'popular_items'              => __( 'Popular Seasons', 'sw-recipes' ),
		'search_items'               => __( 'Search Seasons', 'sw-recipes' ),
		'not_found'                  => __( 'Not Found', 'sw-recipes' ),
		'no_terms'                   => __( 'No seasons', 'sw-recipes' ),
		'items_list'                 => __( 'Seasons list', 'sw-recipes' ),
		'items_list_navigation'      => __( 'Seasons list navigation', 'sw-recipes' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'seasons', array( 'recipes' ), $args );

}
add_action( 'init', 'sw_recipe_seasons', 0 );

}

if ( ! function_exists( 'sw_recipe_meal' ) ) {

// Register Custom Taxonomy
function sw_recipe_meal() {

	$labels = array(
		'name'                       => _x( 'Meals', 'Taxonomy General Name', 'sw-recipes' ),
		'singular_name'              => _x( 'Meal', 'Taxonomy Singular Name', 'sw-recipes' ),
		'menu_name'                  => __( 'Meals', 'sw-recipes' ),
		'all_items'                  => __( 'All Meals', 'sw-recipes' ),
		'parent_item'                => __( 'Parent Meal', 'sw-recipes' ),
		'parent_item_colon'          => __( 'Parent Meal:', 'sw-recipes' ),
		'new_item_name'              => __( 'New Meal', 'sw-recipes' ),
		'add_new_item'               => __( 'Add New Meal', 'sw-recipes' ),
		'edit_item'                  => __( 'Edit Meal', 'sw-recipes' ),
		'update_item'                => __( 'Update Meal', 'sw-recipes' ),
		'view_item'                  => __( 'View Meal', 'sw-recipes' ),
		'separate_items_with_commas' => __( 'Separate meals with commas', 'sw-recipes' ),
		'add_or_remove_items'        => __( 'Add or remove meals', 'sw-recipes' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sw-recipes' ),
		'popular_items'              => __( 'Popular Meals', 'sw-recipes' ),
		'search_items'               => __( 'Search Meals', 'sw-recipes' ),
		'not_found'                  => __( 'Not Found', 'sw-recipes' ),
		'no_terms'                   => __( 'No meals', 'sw-recipes' ),
		'items_list'                 => __( 'Meals list', 'sw-recipes' ),
		'items_list_navigation'      => __( 'Meals list navigation', 'sw-recipes' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'meals', array( 'recipes' ), $args );

}
add_action( 'init', 'sw_recipe_meal', 0 );

}

if ( ! function_exists( 'sw_recipe_tag' ) ) {

// Register Custom Taxonomy
function sw_recipe_tag() {

	$labels = array(
		'name'                       => _x( 'Recipe Tags', 'Taxonomy General Name', 'sw-recipes' ),
		'singular_name'              => _x( 'Recipe Tag', 'Taxonomy Singular Name', 'sw-recipes' ),
		'menu_name'                  => __( 'Recipe Tags', 'sw-recipes' ),
		'all_items'                  => __( 'All Recipe Tags', 'sw-recipes' ),
		'parent_item'                => __( 'Parent Recipe Tag', 'sw-recipes' ),
		'parent_item_colon'          => __( 'Parent Recipe Tag:', 'sw-recipes' ),
		'new_item_name'              => __( 'New Recipe Tag', 'sw-recipes' ),
		'add_new_item'               => __( 'Add New Recipe Tag', 'sw-recipes' ),
		'edit_item'                  => __( 'Edit Recipe Tag', 'sw-recipes' ),
		'update_item'                => __( 'Update Recipe Tag', 'sw-recipes' ),
		'view_item'                  => __( 'View Recipe Tag', 'sw-recipes' ),
		'separate_items_with_commas' => __( 'Separate tags with commas', 'sw-recipes' ),
		'add_or_remove_items'        => __( 'Add or remove tags', 'sw-recipes' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sw-recipes' ),
		'popular_items'              => __( 'Popular Recipe Tags', 'sw-recipes' ),
		'search_items'               => __( 'Search Recipe Tags', 'sw-recipes' ),
		'not_found'                  => __( 'Not Found', 'sw-recipes' ),
		'no_terms'                   => __( 'No Recipe Tags', 'sw-recipes' ),
		'items_list'                 => __( 'Recipe Tags list', 'sw-recipes' ),
		'items_list_navigation'      => __( 'Recipe Tags list navigation', 'sw-recipes' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'recipe-tags', array( 'recipes' ), $args );

}
add_action( 'init', 'sw_recipe_tag', 0 );

}
