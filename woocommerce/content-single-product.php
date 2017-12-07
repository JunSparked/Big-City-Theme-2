<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// get featured image
$featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'medium');

// get the current category this product is in
$current_cat = get_the_terms(get_the_ID(), 'product_cat');
$current_cat_name = $current_cat[0]->name;
$current_cat_id = $current_cat[0]->term_id;

// https://docs.woothemes.com/wc-apidocs/class-WC_Product.html
// other functions u can use with $product
$sku = $product->get_sku();

/*
// get upsell ids
// $upsell_ids = $product->get_upsells();
$upsells = get_post_meta( get_the_ID(), '_upsell_ids', true );
$args = array(
	'post_type'           => 'product',
	'posts_per_page'      => -1,
	'post__in'            => $upsells, // show only these product ids
);
$query = new WP_Query( $args );
$upsells = $query->posts;
*/

/*
// get crosssell ids
// $crosssell_ids = $product->get_cross_sells();
$crosssells = get_post_meta( get_the_ID(), '_crosssell_ids', true );
$args = array(
	'post_type'           => 'product',
	'posts_per_page'      => -1,
	'post__in'            => $crosssells, // show only these product ids
);
$query = new WP_Query( $args );
$crosssells = $query->posts;
*/

// get related products in same category ids
// $related_products = $product->get_related(10);
$args = array(
	'post_type'      => 'product',
	'posts_per_page' => 4,
	'post__not_in'   => array(get_the_ID()), // grab any product besides the current one
	'tax_query'      => array(
		array(
			'taxonomy' => 'product_cat',
			'terms'    => $current_cat_id, // using ids from above
		),
	),
);
$query = new WP_Query($args);
$related_products = $query->posts;

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="row">
		<div class="col-sm-12">
			<?php woocommerce_breadcrumb(); ?>
		</div><!-- col -->
	</div><!-- row -->

	<div class="row">
		<div class="col-sm-3">
			<?php
				/**
				 * woocommerce_before_single_product_summary hook
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' ); // default
				// or do your custom image below
			?>
<?php /*
			<?php if($featuredImage): ?>
				<a href="<?php echo $featuredImage[0]; ?>" itemprop="image" class="woocommerce-main-image zoom" title="" data-rel="prettyPhoto"><img src="<?php echo $featuredImage[0]; ?>" alt="<?php echo get_the_title(); ?>"></a>
			<?php else: ?>
			<img src="<?php echo home_url(); ?>/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="no image">
			<?php endif; ?>
*/ ?>
		</div><!-- /col -->
		<div class="col-sm-9">
			<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				//do_action( 'woocommerce_single_product_summary' );

				// or do your custom layout below
			?>
			<h1 itemprop="name"><?php echo the_title(); ?></h1>
			<?php if($sku): ?>
			<span class="sku p" itemprop="sku">SKU: <?php echo $sku; ?></span><br>
			<?php endif; ?>
			<?php woocommerce_template_single_price(); ?>
			<?php woocommerce_template_single_add_to_cart(); ?>
			<div class="product-content" itemprop="description"><?php echo the_content(); ?></div>
		</div><!-- /col -->

	</div><!-- row -->

	<?php if($related_products): ?>
	<div class="related-products products">
		<h2>More Products In <?php echo $current_cat_name; ?></h2>
		<div class="row">
		<?php
			foreach($related_products as $rp):
			$rpid = $rp->ID;
			$price = get_post_meta($rpid, '_price');
			$featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id($rpid), 'medium');
			$title = get_the_title($rpid);
		?>
			<div class="col-sm-3 product">
				<a href="<?php echo get_the_permalink($rpid); ?>">
					<?php if($featuredImage): ?>
					<img src="<?php echo $featuredImage[0]; ?>" alt="<?php echo $title; ?>">
					<?php else: ?>
					<img src="/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="no image">
					<?php endif; ?>
					<h2><?php echo $title; ?></h2>
					<?php if($price): ?>
					<span class="p product-price">$<?php echo $price[0]; ?></span>
					<?php endif; ?>
					<button class="button">View Product</button>
				</a>
			</div><!-- /item -->
		<?php endforeach; ?>
		</div><!-- /row -->
	</div><!-- related products-->
	<?php endif; ?>


</div><!-- /product -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
