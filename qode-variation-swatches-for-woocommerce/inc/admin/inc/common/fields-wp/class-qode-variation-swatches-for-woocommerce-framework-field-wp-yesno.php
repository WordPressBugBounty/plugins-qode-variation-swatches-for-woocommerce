<?php
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}
class Qode_Variation_Swatches_For_WooCommerce_Framework_Field_WP_YesNo extends Qode_Variation_Swatches_For_WooCommerce_Framework_Field_WP_Type {

	public function render_field() {
		?>
		<div class="qodef-yesno qodef-field" data-option-name="<?php echo esc_attr( $this->name ); ?>" data-option-type="yesno">
			<input type="radio" id="<?php echo esc_attr( $this->params['id'] ); ?>-yes" name="<?php echo esc_attr( $this->name ); ?>" value="yes" <?php echo 'yes' === esc_attr( $this->params['value'] ) ? 'checked' : ''; ?>/>
			<label for="<?php echo esc_attr( $this->name ); ?>-yes">
				<?php esc_html_e( 'Yes', 'qode-variation-swatches-for-woocommerce' ); ?>
			</label>
			<input type="radio" id="<?php echo esc_attr( $this->params['id'] ); ?>-no" name="<?php echo esc_attr( $this->name ); ?>" value="no" <?php echo 'no' === esc_attr( $this->params['value'] ) ? 'checked' : ''; ?>/>
			<label for="<?php echo esc_attr( $this->name ); ?>-no">
				<?php esc_html_e( 'No', 'qode-variation-swatches-for-woocommerce' ); ?>
			</label>
		</div>
		<?php
	}
}
