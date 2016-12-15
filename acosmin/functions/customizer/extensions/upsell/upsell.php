<?php
/**
 * Upsell Buttons for Customizer
 */

class AC_Upsell_Section extends WP_Customize_Section {

	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'ac-upsell-section';

	/**
	 * Custom button text to output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $pro_text = '';
	public $docs_text = '';

	/**
	 * Custom pro button URL.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $pro_url = '';
	public $docs_url = '';

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function json() {
		$json = parent::json();

		$json['pro_text'] = $this->pro_text;
		$json['pro_url']  = esc_url( $this->pro_url );
		$json['docs_text'] = $this->docs_text;
		$json['docs_url']  = esc_url( $this->docs_url );

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	protected function render_template() { ?>

		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

			<h3 class="accordion-section-title">
				{{ data.title }}

				<# if ( data.pro_text && data.pro_url ) { #>
					<a href="{{ data.pro_url }}" class="button button-primary alignleft ac_upsell_pro" target="_blank">{{ data.pro_text }}</a>
				<# } #>

				<# if ( data.docs_text && data.docs_url ) { #>
					<a href="{{ data.docs_url }}" class="button button-secondary alignright ac_upsell_docs" target="_blank">{{ data.docs_text }}</a>
				<# } #>
			</h3>
		</li>
	<?php }
}
