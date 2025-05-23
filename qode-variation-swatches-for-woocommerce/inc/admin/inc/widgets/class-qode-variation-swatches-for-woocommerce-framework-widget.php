<?php
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

abstract class Qode_Variation_Swatches_For_WooCommerce_Framework_Widget extends WP_Widget {
	private $widget_base;
	private $widget_name;
	private $widget_description;
	public $widget_options;
	public $control_options;
	public $option_atts;

	public function __construct() {
		$this->map_widget();
		parent::__construct( $this->get_base(), $this->get_name(), $this->get_widget_options(), $this->get_control_options() );
	}

	public function get_base() {
		return $this->widget_base;
	}

	public function set_base( $widget_base ) {
		$this->widget_base = $widget_base;
	}

	public function get_name() {
		return $this->widget_name;
	}

	public function set_name( $widget_name ) {
		$this->widget_name = $widget_name;
	}

	public function get_description() {
		return $this->widget_description;
	}

	public function set_description( $widget_description ) {
		$this->widget_options['description'] = $widget_description;
	}

	public function get_widget_options() {
		return $this->widget_options;
	}

	public function get_widget_option( $key ) {
		return $this->widget_options[ $key ];
	}

	public function set_widget_option( $params ) {
		$key = $params['name'];

		$this->widget_options[ $key ] = $params;
	}

	public function get_control_options() {
		return $this->control_options;
	}

	public function get_control_option( $key ) {
		return $this->control_options[ $key ];
	}

	public function set_control_option( $params ) {
		$key                           = $params['name'];
		$this->control_options[ $key ] = $params;
	}

	private function set_widget_option_atts() {
		$option_atts = array();
		foreach ( $this->get_widget_options() as $name => $option ) {
			$default_value        = isset( $option['default_value'] ) ? $option['default_value'] : '';
			$option_atts[ $name ] = $default_value;
		}

		return $option_atts;
	}

	public function get_option_atts() {
		return $this->option_atts;
	}

	public function generate_string_params( $atts ) {
		$params = array();

		if ( is_array( $atts ) && count( $atts ) ) {
			foreach ( $atts as $key => $value ) {
				if ( '' !== $value ) {
					$params[] = $key . "='" . esc_attr( $value ) . "'";
				}
			}
		}

		return implode( ' ', $params );
	}

	public function import_shortcode_options( $params ) {
		$shortcode_base = isset( $params['shortcode_base'] ) ? $params['shortcode_base'] : '';
		$exclude        = isset( $params['exclude'] ) ? $params['exclude'] : array();
		$include        = isset( $params['include'] ) ? $params['include'] : array();

		$framework_root = qode_variation_swatches_for_woocommerce_framework_get_framework_root();
		$shortcodes     = $framework_root->get_shortcodes()->get_shortcodes();
		if ( array_key_exists( $shortcode_base, $shortcodes ) ) {
			$shortcode         = $shortcodes[ $shortcode_base ];
			$shortcode_options = $shortcode->get_options();

			if ( ! empty( $shortcode_options ) && is_array( $shortcode_options ) ) {
				if ( ! empty( $exclude ) ) {
					if ( ! array_key_exists( 'custom_class', $exclude ) ) {
						$exclude[] = 'custom_class';
					}

					$options_to_return = array_diff_key( $shortcode_options, array_flip( $exclude ) );
				} elseif ( ! empty( $include ) ) {
					$options_to_return = array_intersect_key( $shortcode_options, array_flip( $include ) );
				} else {
					$options_to_return = $shortcode_options;
				}

				if ( ! empty( $options_to_return ) ) {
					foreach ( $options_to_return as $option ) {
						$visibility = isset( $option['visibility'] ) ? $option['visibility'] : array();

						if ( isset( $visibility['map_for_widget'] ) && false === $visibility['map_for_widget'] ) {
							continue;
						}

						$this->set_widget_option( $option );
					}

					return true;
				}
			}
		}

		return false;
	}

	abstract public function map_widget();

	public function register() {
		register_widget( get_class( $this ) );
	}

	public function form( $instance ) {
		if ( is_array( $this->widget_options ) && count( $this->widget_options ) ) { ?>
			<?php
			foreach ( $this->widget_options as $option ) {
				$class           = array();
				$dependency_data = array();

				if ( ! empty( $option['dependency'] ) ) {
					$class[] = 'qodef-dependency-holder';

					if ( array_key_exists( 'show', $option['dependency'] ) ) {
						$new_dependency = array();
						foreach ( $option['dependency']['show'] as $key => $value ) {
							$value['option_name']   = $key;
							$key                    = $this->get_field_name( $key );
							$new_dependency[ $key ] = $value;
						}
						$option['dependency']['show'] = $new_dependency;
					}
					if ( array_key_exists( 'hide', $option['dependency'] ) ) {
						$new_dependency = array();
						foreach ( $option['dependency']['hide'] as $key => $value ) {
							$value['option_name']   = $key;
							$key                    = $this->get_field_name( $key );
							$new_dependency[ $key ] = $value;
						}
						$option['dependency']['hide'] = $new_dependency;
					}
					$show     = array_key_exists( 'show', $option['dependency'] ) ? qode_variation_swatches_for_woocommerce_framework_return_widget_dependency_options_array( $instance, $option['dependency']['show'], true ) : array();
					$hide     = array_key_exists( 'hide', $option['dependency'] ) ? qode_variation_swatches_for_woocommerce_framework_return_widget_dependency_options_array( $instance, $option['dependency']['hide'] ) : array();
					$relation = array_key_exists( 'relation', $option['dependency'] ) ? $option['dependency']['relation'] : 'and';

					$class[]         = qode_variation_swatches_for_woocommerce_framework_return_dependency_classes( $show, $hide );
					$dependency_data = qode_variation_swatches_for_woocommerce_framework_return_dependency_data( $show, $hide, $relation );
				}

				if ( ! empty( $option['title'] ) || ( isset( $option['name'] ) && ! empty( $option['name'] ) ) ) {
					$class[] = isset( $option['field_type'] ) ? 'qodef-widget-field--' . $option['field_type'] : '';
					$class   = implode( ' ', $class );
					?>
					<p class="<?php echo esc_attr( $class ); ?>" <?php qode_variation_swatches_for_woocommerce_inline_attrs( $dependency_data, true ); ?>>
						<?php if ( ! empty( $option['title'] ) ) : ?>
							<label for="<?php echo esc_attr( $this->get_field_id( $option['name'] ) ); ?>">
								<?php echo esc_html( $option['title'] ); ?>:
							</label>
						<?php endif; ?>
						<?php
						if ( isset( $option['name'] ) && ! empty( $option['name'] ) ) {
							$option['type']     = 'widget';
							$option['instance'] = $instance;
							$option['widget']   = $this;

							$field = new Qode_Variation_Swatches_For_WooCommerce_Framework_Field_Mapper( $option );
							$field->render();
						}
						?>
						<?php if ( ! empty( $option['description'] ) ) : ?>
							<span class="qodef-field-description">
								<?php echo wp_kses_post( $option['description'] ); ?>
							</span>
						<?php endif; ?>
					</p>
				<?php } ?>
			<?php } ?>
		<?php } else { ?>
			<p><?php esc_html_e( 'There are no options for this widget.', 'qode-variation-swatches-for-woocommerce' ); ?></p>
			<?php
		}
	}

	public function load_assets() {
		return false;
	}

	public function widget( $args, $instance ) {
		$this->option_atts = $this->set_widget_option_atts();
		$atts              = qode_variation_swatches_for_woocommerce_framework_map_shortcode_fields( $this->get_option_atts(), $instance );

		$this->load_assets();

		echo wp_kses_post( $args['before_widget'] );
		if ( isset( $instance['widget_title'] ) && ! empty( $instance['widget_title'] ) ) {
			echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['widget_title'] ) . wp_kses_post( $args['after_title'] );
		}
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo qode_variation_swatches_for_woocommerce_framework_wp_kses_html( 'html', $this->render( $atts ) );
		echo wp_kses_post( $args['after_widget'] );
	}

	abstract public function render( $atts );
}
