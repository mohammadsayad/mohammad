<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_title = procard_get_option('blog_title', esc_html__('Blog', 'procard-fa'));
$blog_list_categories = procard_get_option('blog_list_categories', true);

// Header
get_header();
?>

<section class="pt-page">
	<div class="section-inner custom-page-content">

		<div class="page-header color-1">

			<?php
			if( is_category() ){
				$title = sprintf( esc_html__('"%s" Category Archive', 'procard-fa'), single_cat_title('', false) );
			}
			else if( is_tag() ){
				$title = sprintf( esc_html__('"%s" Tag Archive', 'procard-fa'), single_tag_title('', false) );
			}
			else if( is_author() ){
				$title = sprintf( esc_html__('"%s" Author Archive', 'procard-fa'), get_the_author_meta( 'display_name', $wp_query->query_vars['author'] ) );
			}
			else if( is_day() ){
				$title = sprintf( esc_html__('"%s" Day Archive', 'procard-fa'), get_the_date('j F Y') );
			}
			else if( is_month() ){
				$title = sprintf( esc_html__('"%s" Month Archive', 'procard-fa'), get_the_date('F Y') );
			}
			else if( is_year() ){
				$title = sprintf( esc_html__('"%s" Year Archive', 'procard-fa'), get_the_date('Y') );
			}
			else if( is_search() ){
				$title = sprintf( esc_html__('Search Results For "%s"', 'procard-fa'), get_search_query() );
			}
			else if( is_archive() ){
				$title = esc_html__('Archive', 'procard-fa');
			}
			else{
				$title = $blog_title;
			}
			
			if($title != ''){
				echo '<h2>'.$title.'</h2>';
			}
			?>

		</div>

		<div class="page-content padding-equal">

			<?php if( have_posts() ){ ?>
			<div class="blog-masonry two-columns">

				<?php
				while( have_posts() ){
					the_post();
				?>

				<div class="item">
					<div class="blog-card">

						<?php if( has_post_thumbnail() ){ ?>
						<div class="media-block">
							<a href="<?php the_permalink() ?>">
								<img class="post-image img-responsive" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'blog-thumb') ?>" alt="">
								<div class="mask"></div>
								<div class="post-date"><span class="day"><?php the_time('j') ?></span><span class="month"><?php the_time('F') ?></span><span class="year"><?php the_time('Y') ?></span></div>
							</a>
						</div>
						<?php } ?>

						<div class="post-info">
							
							<?php
							if( !has_post_thumbnail() ){
								echo '<div class="post-date-inline">'.get_the_time('j F Y').'</div>';
							}
							?>

							<?php if($blog_list_categories && has_category()){ ?>
							<div class="category">
								<?php the_category(' '.esc_html_x(',', 'separator', 'procard-fa').' ') ?>
							</div>
							<?php } ?>

							<?php if( get_the_title() != '' ){ ?>
							<h4 class="blog-item-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
							<?php } ?>

						</div>

					</div>
				</div>

				<?php } ?>

			</div>
			<?php
			}
			else{
				if( is_search() ){
					esc_html_e('No Results Found', 'procard-fa');
				}
				else{
					esc_html_e("There's Nothing to Show", 'procard-fa');
				}
			}
			?>

			<?php
			$pages = paginate_links(array(
				'type' => 'array',
				'next_text' => '<i class="fa fa-angle-'.(is_rtl() ? 'left' : 'right').'"></i>',
				'prev_text' => '<i class="fa fa-angle-'.(is_rtl() ? 'right' : 'left').'"></i>',
			));

			if( $pages ){
			?>

			<div class="pagination-container">
				<ul class="pagination-custom">
					<?php
					foreach($pages as $page){
						echo '<li>'.$page.'</li>';
					}
					?>
				</ul>
			</div>

			<?php
			}
			?>

		</div>

	</div>
</section>

<?php
// Footer
get_footer();
?>