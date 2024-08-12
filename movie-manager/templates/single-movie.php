<?php
/**
 * @package movieManager
 */

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly.
}

// single movie page:

get_header();
if ( have_posts() ) :
while ( have_posts() ) : the_post(); ?>
<div class="movie-detail">
<h1><?php the_title(); ?></h1>
<?php the_post_thumbnail( 'large' ); ?>
<p><?php the_content(); ?></p>
<p><strong>Category:</strong> <?php the_terms( get_the_ID(), 'movie_category' ); ?></p>


<p><strong>Director:</strong> <?php echo get_post_meta( get_the_ID(), 'director', true ); ?></p>
</div>
<?php endwhile;
endif;
get_footer();