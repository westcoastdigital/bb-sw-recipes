<?php get_header(); ?>

<div class="container">
	<div class="row">
		
		<?php FLTheme::sidebar('left'); ?>
		
		<div class="fl-content <?php FLTheme::content_class(); ?>">
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            
            <div class="panel panel-default">
                <div class="panel-header">                    
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title('<h3>', '</h3>'); ?></a>
                    <small>
                            <em><?php echo get_the_term_list( $post->ID, 'seasons', 'Seasons: ', ', ', '' ); ?></em> | 
                            <em><?php echo get_the_term_list( $post->ID, 'meals', 'Meals: ', ', ', '' ); ?></em> | 
                            <em><?php echo get_the_term_list( $post->ID, 'recipe-tags', 'Tags: ', ', ', '' ); ?></em>
                        </small>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <?php if ( has_post_thumbnail() ) { ?>
                        <div class="fl-post-thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium', array('itemprop' => 'image')); ?></a>
                        </div>
                    <?php } ?>
                    </div>
                    <div class="col-sm-6">
                        <small>Prep Time: <?php echo rwmb_meta( 'prep' ) . '<small> Mins</small>'; ?></small><br />
                        <small>Cook Time: <?php echo rwmb_meta( 'cook' ) . '<small> Mins</small>'; ?></small><br />
                        <small>Diificulty: <?php echo rwmb_meta( 'difficulty' ); ?></small>
                        <hr>
                        <?php echo rwmb_meta( 'description' ); ?>
                    </div>
                </div>
            </div>

			<?php endwhile; endif; ?>
		</div>
		
		<?php FLTheme::sidebar('right'); ?>
		
	</div>
</div>

<?php get_footer(); ?>