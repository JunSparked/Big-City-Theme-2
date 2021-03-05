<?php 
/*
Template Name: News
*/
get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <hr class="news-hr">
            <h1><?php echo the_title(); ?></h1>
            <p><?php echo get_the_date( 'F j, Y' ); ?></p>
            <?php echo the_post_thumbnail( 'full', array( 'class' => 'news-featured-image' )); ?>
        </div>
        
        <div class="col-md-8 my-5">
            <?php the_content(); ?>
        </div>

        <div class="col-md-4 my-5">
            <h4>Related Topics</h4>
            <?php
            $term    = get_queried_object();
            $term_id = ( isset( $term->term_id ) ) ? (int) $term->term_id : 0;

            $categories = get_categories( array(
                'taxonomy'   => 'category', 
                'orderby'    => 'name',
                'parent'     => 0,
                'hide_empty' => 0,
            ) );
            ?>
                <?php
                foreach ( $categories as $category ) 
                {
                    $cat_ID        = (int) $category->term_id;
                    $category_name = $category->name;

                    $cat_class = ( $cat_ID == $term_id ) ? 'active' : 'not-active'; 
                    
                    if ( strtolower( $category_name ) != 'uncategorized' )
                    {
                        echo '<a href="" class="cat-button">';
                        printf( '%3$s',
                            esc_attr( $cat_class ),
                            esc_url( get_category_link( $category->term_id ) ),
                            esc_html( $category->name )
                        );
                    }
                }?>
            </a>  
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Related Articles</h3>
        </div>
        <?php
        $args = array(
            'post_type' => 'news',
            'posts_per_page' => '3',
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); ?>
                <div class="col-md-4 mt-2 mb-5 news-container">
                    <a href="<?php echo get_permalink();  ?>">
                        <?echo get_the_post_thumbnail( $post_id, 'full', ); ?>
                        <h4 class="mt-3 mb-0">
                            <?php $title = get_the_title(); echo mb_strimwidth($title, 0, 25, '...');?>
                        </h4>
                        <div class="mb-3">
                            <?php $content = get_the_content(); echo mb_strimwidth($content, 0, 200, '...');?>
                        </div>
                    </a>
                </div>
                <?
            }
        } else {
            // no posts found
        }
        wp_reset_postdata(); ?>
    </div>
</div>

<a href="">
    <div class="black-background py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="white">Let’s start your next project <i class="fas fa-arrow-right float-right white"></i></h1>
                </div>
            </div>
        </div>
    </div>
</a>

<?php get_footer(); ?>