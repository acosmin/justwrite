<?php

if( ! class_exists( 'JustWrite_Customizer_Control_P' ) ) {
	/**
	 * Information Customize Control
	 *
	 * All section widgets can extend this class
	 *
	 * @since 1.0.0
	 */
	class JustWrite_Customizer_Control_P extends WP_Customize_Control {

		/**
		 * Control type
		 *
		 * @access public
		 */
		public $type = 'p-control';

		/**
		 * Other needed vars
		 *
		 * @access public
		 */
		public $html;

		/**
		 * Render the control.
		 *
		 * @return string HTML code
		 * @access public
		 */
		public function render_content() {
            ?>
			<div class="justwrite-control-p">
				<?php
				echo wp_kses_post( $this->html );
				?>
			</div>
			<?php
		}
	}
}