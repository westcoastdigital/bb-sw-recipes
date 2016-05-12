<?php get_header(); ?>

<div class="container">
	<div class="row">
		
		<?php FLTheme::sidebar('left'); ?>
		
		<div class="fl-content <?php FLTheme::content_class(); ?>">
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

            <header class="fl-post-header">
                <h1 class="fl-post-title" itemprop="headline">
                    <?php the_title(); ?>
                    <?php edit_post_link( _x( 'Edit', 'Edit post link text.', 'fl-automator' ) ); ?>
                </h1>
            </header><!-- .fl-post-header -->
                    
            <?php echo rwmb_meta( 'description' ); ?>

            
            <div class="panel panel-default col-md-2 col-xs-6">
                <div class="panel-body text-center">                    
                    <?php echo rwmb_meta( 'prep' ) . '<small>Mins</small>'; ?>
                    <p><small>To prep</small></p>
                </div>
            </div>
           
            
            <div class="panel panel-default col-md-2 col-xs-6">
                <div class="panel-body text-center">                    
                    <?php echo rwmb_meta( 'cook' ) . '<small>Mins</small>'; ?>
                    <p><small>To cook</small></p>
                </div>
            </div>
            
            <div class="panel panel-default col-md-2 col-xs-6">
                <div class="panel-body text-center">                    
                    <?php echo rwmb_meta( 'ingredient-qty' ); ?>
                    <p><small>Ingredients</small></p>
                </div>
            </div>
            
            <div class="panel panel-default col-md-2 col-xs-6">
                <div class="panel-body text-center">                    
                    <?php echo rwmb_meta( 'difficulty' ); ?>
                    <p><small>Difficulty</small></p>
                </div>
            </div>
            
            <div class="panel panel-default col-md-2 col-xs-6">
                <div class="panel-body text-center">                    
                    <?php echo rwmb_meta( 'servings' ); ?>
                    <p><small>Servings</small></p>
                </div>
            </div>

            <?php if ( has_post_thumbnail() ) { ?>
                <div class="fl-post-thumb">
                    <?php the_post_thumbnail('large', array('itemprop' => 'image')); ?>
                </div>
            <?php } ?>
            
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#recipe-ingredients">Ingredients</a></li>
              <li><a data-toggle="tab" href="#recipe-steps">Instructions</a></li>
              <li><a data-toggle="tab" href="#recipe-notes">Notes</a></li>
            </ul>

            <div class="tab-content">
              <div id="recipe-ingredients" class="tab-pane fade in active">
                <h3>Ingredients</h3>
                  <ul>
                      <?php $ingredients = rwmb_meta( 'ingredient' ); 
                        foreach($ingredients as $ingredient) {
                                echo '<li>' . $ingredient . '</li>';
                        } ?>
                  </ul>
              </div>
              <div id="recipe-steps" class="tab-pane fade">
                <h3>Instructions</h3>
                  <ol>
                      <?php $instructions = rwmb_meta( 'instruction' ); 
                        foreach($instructions as $instruction) {
                                echo '<li>' . $instruction . '</li>';
                        } ?>
                  </ol>
              </div>
              <div id="recipe-notes" class="tab-pane fade">
                <h3>Notes</h3>
                <?php echo rwmb_meta( 'note' ); ?>
              </div>
            </div>
			<?php endwhile; endif; ?>
		</div>
		
		<?php FLTheme::sidebar('right'); ?>
		
	</div>
</div>

<?php get_footer(); ?>