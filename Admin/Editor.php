<?php

namespace ZF_Features\Admin;

class Editor {

	/**
	 * Changes the first-row list of TinyMCE buttons.
	 *
	 * @param  array  $buttons   First-row list of buttons.
	 * @param  string $editor_id Unique editor identifier, e.g. 'content'.
	 * @return array Changed first-row list of buttons in the editor.
	 */
	public function mce_buttons( array $buttons, string $editor_id = '') {
		return $buttons;
	}


	/**
	 * Changes the second-row list of TinyMCE buttons.
	 *
	 * @param  array  $buttons   Second-row list of buttons.
	 * @param  string $editor_id Unique editor identifier, e.g. 'content'.
	 * @return array Changed second-row list of buttons in the editor.
	 */
	public function mce_buttons_2( array $buttons, string $editor_id = '' ) {
		// Add core buttons that are disabled by default.
		$buttons[] = 'sup';
		$buttons[] = 'sub';

		return $buttons;
	}


	/**
	 * Changes the third-row list of TinyMCE buttons.
	 *
	 * @param  array  $buttons   Third-row list of buttons.
	 * @param  string $editor_id Unique editor identifier, e.g. 'content'.
	 * @return array Changed third-row list of buttons in the editor.
	 */
	public function mce_buttons_3( array $buttons, string $editor_id = '' ) {
		return $buttons;
	}


	/**
	 * Changes the fourth-row list of TinyMCE buttons.
	 *
	 * @param  array  $buttons   Fourth-row list of buttons.
	 * @param  string $editor_id Unique editor identifier, e.g. 'content'.
	 * @return array Changed fourth-row list of buttons in the editor.
	 */
	public function mce_buttons_4( array $buttons, string $editor_id = '' ) {
		return $buttons;
	}


}
