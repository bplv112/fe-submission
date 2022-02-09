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
					<?php echo esc_html__( 'Privacy Statements', 'fe-submission' ); ?></h2>
				</div>

			</div>
		</div>
		<form method="POST" action="#" class="fes-settings-form" enctype="multipart/form-data">
			<div class="sui-col-md-6">
				<div class="sui-box">

					<div class="sui-box-body">

						<!-- Post Content -->
						<div class="sui-form-field">

							<label class="sui-label sui-label-editor" for="fe-post-content-fr"><?php echo esc_html__( 'Privacy Content FR', 'fe-submission' ); ?></label>
							<?php wp_editor(
								$options['fr'],
								'fe-post-content-fr',
								array(
									'media_buttons'    => false,
									'textarea_name'    => 'fe-post-content-fr',
									'editor_height'    => 192,
									'drag_drop_upload' => false,
									'editor_class'     => 'fe-post-content',
								)
							); ?>
							<span id="fe-post-content-error" class="sui-error-message" style="display: none;" role="alert"></span>
						</div>

						<!-- Post Content -->
						<div class="sui-form-field">

							<label class="sui-label sui-label-editor" for="fe-post-content-fr"><?php echo esc_html__( 'Privacy Content en', 'fe-submission' ); ?></label>
							<?php wp_editor(
								$options['en'],
								'fe-post-content-en',
								array(
									'media_buttons'    => false,
									'textarea_name'    => 'fe-post-content-en',
									'editor_height'    => 192,
									'drag_drop_upload' => false,
									'editor_class'     => 'fe-post-content',
								)
							); ?>
							<span id="fe-post-content-error" class="sui-error-message" style="display: none;" role="alert"></span>
						</div>

						<!-- Post Title -->
						<div class="sui-form-field">

							<label for="fe-post-hook" id="fe-post-hook" class="sui-label"><?php echo esc_html__( 'Hook Name', 'fe-submission' ); ?></label>
							<input
								type="text"
								placeholder="<?php echo esc_html__( 'Enter post title', 'fe-submission' ); ?>"
								id="fe-post-hook"
								class="sui-form-control fe-post-hook"
								name="fe-post-hook"
								aria-labelledby="fe-post-hook"
								aria-describedby="fe-post-hook-error"
								value="<?php echo esc_html( $options['privacy_hook_name'] ); ?>"
							/>
							<span id="fe-post-hook-error" class="sui-error-message" style="display: none;" role="alert"></span>

						</div>

						<!-- Post Title -->
						<div class="sui-form-field">

							<label for="fe-enable-banner" id="fe-enable-banner" class="sui-label"><?php echo esc_html__( 'Enable Banner', 'fe-submission' ); ?></label>
							<input
								type="checkbox"
								id="fe-enable-banner"
								class="sui-form-control fe-enable-banner"
								name="fe-enable-banner"
								aria-labelledby="fe-enable-banner"
								aria-describedby="fe-enable-banner-error"
								<?php checked( '1', esc_html( $options['fe_enable_banner'] ) ); ?>
								value="1"
							/>
							<span id="fe-enable-banner-error" class="sui-error-message" style="display: none;" role="alert"></span>

						</div>

						<!-- Promo banner French -->
						<div class="sui-form-field">

							<label for="fe-post-hook" id="fe-post-hook" class="sui-label"><?php echo esc_html__( 'Promo banner French', 'fe-submission' ); ?></label>
							<div class="avatar-upload">
								<div class="avatar-edit">
									<div class="upload-btn-wrapper">
										<button class="btn"><?php echo esc_html__( 'Upload a file', 'fe-submission' ); ?></button>
										<input
										type="file"
										name="fe-post-image-fr"
										id="fe-post-image-fr"
										accept=".png, .jpg, .jpeg"
										class="fe-post-image-fr"
										/>
									</div>
								</div>
								<div class="avatar-preview">
									<div id="imagePreview-fr" style="background-image:url('<?php echo esc_html( $options['promo_banner_fr'] ); ?>')">
									</div>
								</div>
							</div>
							<span id="fe-post-image-fr-error" class="sui-error-message" style="display: none;"></span>

						</div>

						<!-- Promo banner EN -->
						<div class="sui-form-field">

							<label for="fe-post-hook" id="fe-post-hook" class="sui-label"><?php echo esc_html__( 'Promo banner Eng', 'fe-submission' ); ?></label>
							<div class="avatar-upload">
								<div class="avatar-edit">
									<div class="upload-btn-wrapper">
										<button class="btn"><?php echo esc_html__( 'Upload a file', 'fe-submission' ); ?></button>
										<input
										type="file"
										name="fe-post-image-en"
										id="fe-post-image-en"
										accept=".png, .jpg, .jpeg"
										class="fe-post-image-en"
										/>
									</div>
								</div>
								<div class="avatar-preview">
									<div id="imagePreview-en" style="background-image:url('<?php echo esc_html( $options['promo_banner_en'] ); ?>')">
									</div>
								</div>
							</div>
							<span id="fe-post-image-en-error" class="sui-error-message" style="display: none;"></span>

						</div>

						<input type="hidden" name="fe-options-save" value="1">
						<!-- Submit button -->
						<div class="sui-form-field">
							<button
							type="submit"
							value="settings"
							class="submit-post-fe sui-button button button-primary"
							id="submit-post-fe"
							>

								<span class="sui-loading-text">
									<i class="sui-icon-save" aria-hidden="true"></i>
									<?php echo esc_html__( 'Submit Post', 'fe-submission' ); ?>
									<i class="sui-loader" aria-hidden="true"></i>
								</span>
							</button>

						</div>

					</div>

				</div>
			</div>
			<?php wp_nonce_field( 'fes_submit_post', 'fes_submit_post_nonce' ); ?>
		</form>

	</div>
</main>
