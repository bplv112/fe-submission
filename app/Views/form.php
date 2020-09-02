<?php
/**
 * Form HTML.
 *
 * @package fe-submission
 * @since 1.0.0
 */

?>

<main class="sui-wrap">

	<div class="sui-row">
		<div class="sui-col-md-6">
			<div class="sui-box">

				<div class="sui-box-header">
					<h2 class="sui-box-title">
					<?php esc_html_e( 'Front End Submission', 'fe-submission' ); ?></h2>
				</div>

				<div class="sui-box-body">
					<p><?php esc_html_e( 'Submit Guest posts.', 'fe-submission' ); ?></p>
				</div>

			</div>
		</div>
		<form method="POST" action="#" class="fes-post-form">
			<div class="sui-col-md-6">
				<div class="sui-box">

					<div class="sui-box-body">

						<!-- Post Title -->
						<div class="sui-form-field">

							<label for="fe-post-title" id="fe-post-title" class="sui-label"><?php esc_html_e( 'Post Title', 'fe-submission' ); ?></label>
							<input
								type="text"
								placeholder="<?php esc_html_e( 'Enter post title', 'fe-submission' ); ?>"
								id="fe-post-title"
								class="sui-form-control fe-post-title"
								name="fe-post-title"
								aria-labelledby="fe-post-title"
								aria-describedby="fe-post-title-error"
							/>
							<span id="fe-post-title-error" class="sui-error-message" style="display: none;" role="alert"></span>

						</div>

						<!-- Post Type -->
						<div class="sui-form-field">

							<label for="fe-post-type" id="fe-post-type-label" class="sui-label"><?php esc_html_e( 'Post Type', 'fe-submission' ); ?></label>
							<select id="fe-post-type" aria-labelledby="fe-post-type-label" class="sui-select">
								<?php
								$all_post_types = get_post_types( array( 'public' => true ), 'objects' ); //only get public posttypes for now.
								$avoid          = apply_filters( 'fes_post_type_exception', array( 'attachment' ) );// to avoid certain post types use this filter.

								foreach ( $all_post_types  as $val ) {
									if( in_array( $val->name, $avoid ) ) {
										continue;
									}
									echo '<option value="' . esc_html( $val->name ) .'">' . esc_html( $val->labels->singular_name ) . '</option>';
								}

								?>
							</select>


						</div>

						<!-- Post Content -->
						<div class="sui-form-field">

							<label class="sui-label sui-label-editor" for="emailmessage"><?php esc_html_e( 'Email body', 'fe-submission' ); ?></label>
							<?php wp_editor(
								'',
								'fe-post-content',
								array(
									'media_buttons'    => false,
									'textarea_name'    => 'fe-post-content',
									'editor_height'    => 192,
									'drag_drop_upload' => false,
									'editor_class'     => 'fe-post-content',
								)
							); ?>
							<span id="fe-post-content-error" class="sui-error-message" style="display: none;" role="alert"></span>
						</div>

						<!-- Submit button -->
						<div class="sui-form-field">
							<button
							type="submit"
							class="submit-post-fe"
							value="settings"
							class="sui-button sui-button-blue"
							>

								<span class="sui-loading-text">
									<i class="sui-icon-save" aria-hidden="true"></i>
									<?php esc_html_e( 'Submit Post', 'fe-submission' ); ?>
								</span>

								<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>

							</button>
						</div>

					</div>

				</div>
			</div>
			<?php wp_nonce_field( 'fes_submit_post', 'fes_submit_post_nonce' ); ?>
			<input type="hidden" name="action" value="fes_submit_post">
		</form>

	</div>
</main>
