<?php
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}
?>
<div class="qodef-no-tab-wrapper qodef-options-custom qodef-page-v4-variation-swatches qodef-exclude-panel-from-saving">
	<div class="row">
		<?php
		do_action( 'qode_variation_swatches_for_woocommerce_action_framework_custom_page_content', $page_slug ?? '' );
		?>
	</div>
</div>
