<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used(get_the_ID());

$show_navigation = get_post_meta(get_the_ID(), '_et_pb_project_nav', true);

?>

<div id="main-content">
	<?php if (!$is_page_builder_used) : ?>
		<?php
		$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

		if (empty($featured_img_url)) {
			$featured_img_url = get_template_directory_uri() . '-child/assets/images/header-banner.svg';
		}
		?>

		<div class="header_section" style="background-image: url(<?php echo esc_url($featured_img_url); ?>);">
			<section class="header_module">
				<div class="header_content_container">
					<div class="header-content">
						<h1 class="header_content_title"><?php the_title(); ?></h1>
					</div>
				</div>
			</section>
		</div>

		<div class="container">
			<div id="content-area" class="clearfix">

				<?php endif; ?>

				<?php while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php if (!$is_page_builder_used) : ?>

							<div class="et_main_title">
								<h1 class="entry-title"><?php the_title(); ?></h1>
								<span class="et_project_categories"><?php echo get_the_term_list(get_the_ID(), 'project_category', '', ', '); ?></span>
							</div>

							<?php
							$thumb = '';

							$width = (int) apply_filters('et_pb_portfolio_single_image_width', 1080);
							$height = (int) apply_filters('et_pb_portfolio_single_image_height', 9999);
							$classtext = 'et_featured_image';
							$titletext = get_the_title();
							$alttext = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
							$thumbnail = get_thumbnail($width, $height, $classtext, $alttext, $titletext, false, 'Projectimage');
							$thumb = $thumbnail["thumb"];

							$page_layout = get_post_meta(get_the_ID(), '_et_pb_page_layout', true);

							if ('' !== $thumb)
								print_thumbnail($thumb, $thumbnail["use_timthumb"], $alttext, $width, $height);
							?>

						<?php endif; ?>

						<div class="entry-content">
							<?php
							the_content();

							if (!$is_page_builder_used)
								wp_link_pages(array('before' => '<div class="page-links">' . esc_html__('Pages:', 'Divi'), 'after' => '</div>'));
							?>
						</div>

						<?php if (!$is_page_builder_used || ($is_page_builder_used && 'on' === $show_navigation)) : ?>

							<div class="nav-single clearfix">
								<span class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">' . et_get_safe_localization(_x('&larr;', 'Previous post link', 'Divi')) . '</span> %title'); ?></span>
								<span class="nav-next"><?php next_post_link('%link', '%title <span class="meta-nav">' . et_get_safe_localization(_x('&rarr;', 'Next post link', 'Divi')) . '</span>'); ?></span>
							</div>

						<?php endif; ?>

					</article>

					<?php
					if (!$is_page_builder_used && comments_open() && 'on' === et_get_option('divi_show_postcomments', 'on'))
						comments_template('', true);
					?>
				<?php endwhile; ?>

				<?php if (!$is_page_builder_used) : ?>


				<?php
					if (in_array($page_layout, array('et_full_width_page', 'et_no_sidebar'))) {
						et_pb_portfolio_meta_box();
					}
				?>
			</div>
		</div>

	<?php endif; ?>

</div>

<?php

get_footer();
