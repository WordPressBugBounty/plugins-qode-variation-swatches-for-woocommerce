<?php
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

class Qode_Variation_Swatches_For_WooCommerce_Framework_Field_Widget_Select extends Qode_Variation_Swatches_For_WooCommerce_Framework_Field_Widget_Type {

	public function render() {
		?>
		<select class="qodef-widget-field widefat" id="<?php echo esc_attr( $this->params['id'] ); ?>"
				data-option-type="selectbox" data-option-name="<?php echo esc_attr( $this->params['name'] ); ?>"
				name="<?php echo esc_attr( $this->params['name'] ); ?>">
			<?php
			foreach ( $this->options as $option_key => $option_value ) {
				$option_selected = '';
				if ( $this->params['value'] === $option_key ) {
					$option_selected = 'selected';
				}
				?>
				<option <?php echo esc_attr( $option_selected ); ?> value="<?php echo esc_attr( $option_key ); ?>">
					<?php echo esc_attr( $option_value ); ?>
				</option>
			<?php } ?>
		</select>
		<?php
	}
}
