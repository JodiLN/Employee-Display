<?php get_header(); ?>
<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php the_title('<h1 class="ed-title">','</h1>'); ?>
			<div class="ed-release"><?php esc_html_e('First Name:', 'ed-domain'); ?> <strong><?php esc_html_e($post->first_name, 'ed-domain'); ?></strong></div>
			<div class="ed-content">
				<div class="ed-left">
					<img class="feat-img-single" src="<?php echo $image[0]; ?>">
				</div>
				<div class="ed-right">
					<h3><?php esc_html_e('Bio', 'ed-domain'); ?></h3>
					<?php esc_html_e($post->details); ?>
					<br><br><hr>
					<h3><?php esc_html_e('employee Info', 'ed-domain'); ?></h3>
					<ul class="employee-info">
						<?php if($post->job_title) : ?>
							<li><strong><?php esc_html_e('Job Title: ', 'ed-domain'); ?><?php esc_html_e($post->job_title, 'ed-domain'); ?></li>
						<?php endif; ?>
						<?php if($post->last_name) : ?>
							<li><strong><?php esc_html_e('Last Name: ', 'ed-domain'); ?> <?php esc_html_e($post->last_name, 'ed-domain'); ?></li>
						<?php endif; ?>
					</ul>
				</div>
				<div class="clr"></div>
			</div>
		</article>
	</main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
