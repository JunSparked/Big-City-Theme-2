<?php get_header(); ?>


<section class="basic-content py-40">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1><?php echo the_title(); ?></h1>
				<?php echo the_content(); ?>
			</div><!-- col -->
		</div><!-- row -->
	</div><!-- /container -->
</section><!-- /basic content -->

<?php get_footer(); ?>