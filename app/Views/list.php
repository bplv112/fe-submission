<?php
/**
 * Form HTML.
 *
 * @package fe-submission
 * @since 1.0.0
 */

?>

<main class="sui-wrap" id="sui-content">

	<div class="sui-row">
		<div class="sui-col-md-6">
			<div class="sui-box">

				<div class="sui-box-header">
					<h2 class="sui-box-title">
					<?php echo esc_html__( 'Front End Submitted Posts', 'fe-submission' ); ?></h2>
				</div>

				<div class="sui-box-body">
					<p><?php echo esc_html__( 'View guest submitted posts.', 'fe-submission' ); ?></p>
				</div>

			</div>
		</div>
		<?php
		global $paged;
		$fes_paged            = isset( $_GET['fes-list-page'] ) ? absint( $_GET['fes-list-page'] ) : 1;
		$post_params['paged'] = $fes_paged;
		$fes_posts            = new \WP_Query( $post_params );
		$count                = $fes_posts->post_count;
		if( $count ) {
			if( $fes_posts->have_posts() ) :
		?>
				<table class="sui-table">
					<thead>
						<tr>
							<th><?php echo esc_html__( 'Post Title.', 'fe-submission' ); ?></th>
							<th><?php echo esc_html__( 'Post Author.', 'fe-submission' ); ?></th>
							<th><?php echo esc_html__( 'View/Edit.', 'fe-submission' ); ?></th>
						</tr>
					</thead>
						<tbody>
							<?php
								while( $fes_posts->have_posts() ) :
									$fes_posts->the_post();
							?>
									<tr>
										<td class="sui-table-item-title">
											<?php the_title(); ?>
										</td>
										<td>
											<?php echo esc_html( get_the_author() ); ?>
										</td>
										<td>
											<a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>">
												<?php echo esc_html__( 'View/Edit.', 'fe-submission' ); ?>
											</a>
										</td>
									</tr>
							<?php
								endwhile;
							?>

						</tbody>
				</table>
				<nav class="sui-pagination-wrap">
					<?php \FES\Classes\PostList::pagination( $fes_posts->max_num_pages ); ?>
				</nav>
				<?php
			endif;
			\wp_reset_postdata();
			?>
		<?php } else {?>
			<!--No post Message -->
			<div>
				<div class="sui-box sui-message sui-message-lg">
					<div class="sui-message-content">
						<h3 style="padding: 10px;"><?php echo esc_html__( 'Looks like there is no post to see', 'fe-submission' ); ?></h3>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</main>
