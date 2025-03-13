<?php
/**
 * Title: Comments
 * Slug: iltheme/comments
 * Description: Comments area with comments list, pagination, and comment form.
 * Categories: text
 * Block Types: core/comments
 */

?>
<!-- wp:comments {"className":"wp-block-comments-query-loop","style":{"spacing":{"margin":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}}} -->
<div class="wp-block-comments wp-block-comments-query-loop" style="margin-top:var(--wp--preset--spacing--70);margin-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:heading -->
	<h2 class="wp-block-heading"><?php esc_html_e( 'Comments', 'iltheme' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:comments-title {"level":2,"fontSize":"medium"} /-->
	<!-- wp:comment-template -->
	<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-group" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group">
			<!-- wp:avatar {"size":50} /-->
			<!-- wp:group -->
			<div class="wp-block-group">
				<!-- wp:comment-date /-->
				<!-- wp:comment-author-name /-->
				<!-- wp:comment-content /-->
				<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<div class="wp-block-group wp-block-button">
					<!-- wp:comment-edit-link /-->
					<!-- wp:comment-reply-link { "className": "wp-block-button__link wp-element-button reply__link" } /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
	<!-- /wp:comment-template -->

	<!-- wp:comments-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
	<!-- wp:comments-pagination-previous /-->
	<!-- wp:comments-pagination-next /-->
	<!-- /wp:comments-pagination -->

	<!-- wp:post-comments-form /-->
</div>
<!-- /wp:comments -->
