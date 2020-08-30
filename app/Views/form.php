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
							class="sui-form-control"
							name="fe-post-title"
							aria-labelledby="fe-post-title"
							aria-describedby="fe-post-title-error"
						/>
						<span id="fe-post-title-error" class="sui-error-message" style="display: none;" role="alert"></span>

					</div>

					<!-- Post Content -->
					<div class="sui-form-field">

						<label class="sui-label sui-label-editor" for="emailmessage"><?php esc_html_e( 'Email body', 'fe-submission' ); ?></label>
						<?php wp_editor(
							'',
							'fe-post-content',
							array(
								'media_buttons'    => false,
								'textarea_name'    => 'fe_post_content',
								'editor_height'    => 192,
								'drag_drop_upload' => false,
							)
						); ?>

					</div>

				</div>

			</div>
		</div>

	</div>
</main>
