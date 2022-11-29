<?php

class WPSELZY_FormTemplate {

	public static function get_default( $prop = 'form' ) {
		if ( 'form' == $prop ) {
			$template = self::form();
		} else {
			$template = null;
		}

		return apply_filters( 'wpselzy_default_template', $template, $prop );
	}

	public static function form() {
		$template = "";

		return trim( $template );
	}

}