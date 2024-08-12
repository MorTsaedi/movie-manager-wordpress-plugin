<?php
/**
 * @package movieManager
 */
/**
 * Plugin Name: Movie manager
 * Plugin URI: https://github.com/MorTsaedi/wp-plugin
 * Description: this is a test plugin for my <b>dear</b> future CEO XD
 * Version: 1.0.0
 * Author: Morteza Saaedi
 * Author URI: https://saaedi.ir/
 * License: GPLv2
 * Text Domain: movie-manager
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die( 'hey, you cant access this file human!' );

// first we register custom post type(cpt) for movies:

function mm_register_movie_post_type() {
    $labels = array(
    'name'                  => _x( 'Movies', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Movie', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Movies', 'text_domain' ),
    'name_admin_bar'        => __( 'Movie', 'text_domain' ),
    'archives'              => __( 'Movie Archives', 'text_domain' ),
    'attributes'            => __( 'Movie Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Movie:', 'text_domain' ),
    'all_items'             => __( 'All Movies', 'text_domain' ),
    'add_new_item'          => __( 'Add New Movie', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Movie', 'text_domain' ),
    'edit_item'             => __( 'Edit Movie', 'text_domain' ),
    'update_item'           => __( 'Update Movie', 'text_domain' ),
    'view_item'             => __( 'View Movie', 'text_domain' ),
    'view_items'            => __( 'View Movies', 'text_domain' ),
    'search_items'          => __( 'Search Movie', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert into movie', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this movie', 'text_domain' ),
    'items_list'            => __( 'Movies list', 'text_domain' ),
    'items_list_navigation' => __( 'Movies list navigation', 'text_domain' ),
    'filter_items_list'     => __( 'Filter movies list', 'text_domain' ),
    );
    $args = array(
    'label'                 => __( 'Movie', 'text_domain' ),
    'description'           => __( 'Post Type Description', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail' ),
    'taxonomies'            => array( 'movie_category' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'menu_icon' => 'dashicons-video-alt2',
    );
    register_post_type( 'movie', $args );
    }
    add_action( 'init', 'mm_register_movie_post_type', 0 );

// Register custom taxonomy to connect movies and categories (its a 'many to many' relation) :
function mm_register_movie_taxonomy() {
    $labels = array(
    'name'                       => _x( 'Categories', 'Taxonomy General Name', 'text_domain' ),
    'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'text_domain' ),
    'menu_name'                  => __( 'Categories', 'text_domain' ),
    'all_items'                  => __( 'All Categories', 'text_domain' ),
    'parent_item'                => __( 'Parent Category', 'text_domain' ),
    'parent_item_colon'          => __( 'Parent Category:', 'text_domain' ),
    'new_item_name'              => __( 'New Category Name', 'text_domain' ),
    'add_new_item'               => __( 'Add New Category', 'text_domain' ),
    'edit_item'                  => __( 'Edit Category', 'text_domain' ),
    'update_item'                => __( 'Update Category', 'text_domain' ),
    'view_item'                  => __( 'View Category', 'text_domain' ),
    'separate_items_with_commas' => __( 'Separate categories with commas', 'text_domain' ),
    'add_or_remove_items'        => __( 'Add or remove categories', 'text_domain' ),
    'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
    'popular_items'              => __( 'Popular Categories', 'text_domain' ),
    'search_items'               => __( 'Search Categories', 'text_domain' ),
    'not_found'                  => __( 'Not Found', 'text_domain' ),
    'no_terms'                   => __( 'No categories', 'text_domain' ),
    'items_list'                 => __( 'Categories list', 'text_domain' ),
    'items_list_navigation'      => __( 'Categories list navigation', 'text_domain' ),
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
    register_taxonomy( 'movie_category', array( 'movie' ), $args );
    }
    add_action( 'init', 'mm_register_movie_taxonomy', 0 );

// Flush rewrite rules on activation
function mm_rewrite_flush() {
    mm_register_movie_post_type();
    mm_register_movie_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mm_rewrite_flush' );

// Hook into the template system
function mm_movie_template_include( $template ) {
    if ( is_singular( 'movie' ) ) {
        $plugin_template = plugin_dir_path( __FILE__ ) . 'templates/single-movie.php';
        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }
    return $template;
    }
add_filter( 'template_include', 'mm_movie_template_include' );

// Shortcode to display movies = [movie_list]
function mm_movie_list_shortcode() {
    $args = array(
    'post_type' => 'movie',
    'posts_per_page' => -1,
    );
    $query = new WP_Query( $args );
    $output = '<div class="movie-list">';
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $output .= '<div class="movie-item">';
            $output .= '<h2>' . get_the_title() . '</h2>';
            $output .= get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
            $output .= '<p>' . get_the_excerpt() . '</p>';
            $output .= '</div>';
        }
    } else {
        $output .= '<p>No movies found.</p>';
    }
    $output .= '</div>';
    wp_reset_postdata();
    return $output;
}
add_shortcode( 'movie_list', 'mm_movie_list_shortcode' );

// Register Widget
function mm_register_movie_count_widget() {
        register_widget( 'MM_Movie_Count_Widget' );
    }
add_action( 'widgets_init', 'mm_register_movie_count_widget' );

// Define Widget Class
class MM_Movie_Count_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
        'mm_movie_count_widget',
        __( 'Movie Count', 'text_domain' ),
        array( 'description' => __( 'A widget to display the number of movies', 'text_domain' ), )
        );
    }
    
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo $args['before_title'] . 'Movie Count' . $args['after_title'];
        $count = wp_count_posts( 'movie' )->publish;
        echo '<p>Total Movies: ' . $count . '</p>';
        echo $args['after_widget'];
    }
    }

// Shortcode to display movie count = [movie_count]
function mm_movie_count_shortcode() {
    $count = wp_count_posts( 'movie' )->publish;
    return '<p>Total Movies: ' . $count . '</p>';
    }
add_shortcode( 'movie_count', 'mm_movie_count_shortcode' );

// Add meta box for Director
function mm_add_movie_meta_boxes() {
    add_meta_box(
    'mm_movie_director',
    __( 'Director', 'text_domain' ),
    'mm_movie_director_callback',
    'movie',
    'normal',
    'high'
    );
    }
add_action( 'add_meta_boxes', 'mm_add_movie_meta_boxes' );
    
function mm_movie_director_callback( $post ) {
    wp_nonce_field( 'mm_save_movie_director', 'mm_movie_director_nonce' );
    $value = get_post_meta( $post->ID, '_mm_movie_director', true );
    echo '<label for="mm_movie_director">' . __( 'Director', 'text_domain' ) . '</label>';
    echo '<input type="text" id="mm_movie_director" name="mm_movie_director" value="' . esc_attr( $value ) . '" size="25" />';
    }
    
function mm_save_movie_director( $post_id ) {
    if ( ! isset( $_POST['mm_movie_director_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['mm_movie_director_nonce'], 'mm_save_movie_director' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( ! isset( $_POST['mm_movie_director'] ) ) {
        return;
    }
    $director = sanitize_text_field( $_POST['mm_movie_director'] );
    update_post_meta( $post_id, '_mm_movie_director', $director );
}
add_action( 'save_post', 'mm_save_movie_director' );

