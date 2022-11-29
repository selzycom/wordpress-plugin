<?php

class WPSELZY_Form {

	const post_type = 'wpselzy_form';

	private static $found_items = 0;
	private static $current = null;

	private $id;
	private $name;
	private $title;
	private $locale;
	private $properties = [];
	private $unit_tag;
	private $responses_count = 0;
	private $scanned_form_tags;
	private $shortcode_atts = [];


	/**
	 * Returns count of forms found by the previous retrieval.
	 *
	 * @return int Count of forms.
	 */
	public static function count() {
		return self::$found_items;
	}


	/**
	 * Returns the form that is currently processed.
	 *
	 * @return WPSELZY_Form Current form object.
	 */
	public static function get_current() {
		return self::$current;
	}


	/**
	 * Registers the post type for forms.
	 */
	public static function register_post_type() {
		register_post_type( self::post_type, [
			'labels'          => [
				'name'          => __( 'Формы', 'selzy' ),
				'singular_name' => __( 'Форма', 'selzy' ),
			],
			'rewrite'         => false,
			'query_var'       => false,
			'public'          => false,
			'capability_type' => 'page',
			'capabilities'    => [
				'edit_post'          => 'wpselzy_edit_form',
				'read_post'          => 'wpselzy_read_form',
				'delete_post'        => 'wpselzy_delete_form',
				'edit_posts'         => 'wpselzy_edit_forms',
				'edit_others_posts'  => 'wpselzy_edit_forms',
				'publish_posts'      => 'wpselzy_edit_forms',
				'read_private_posts' => 'wpselzy_edit_forms',
			],
		] );
	}


	/**
	 * Retrieves form data that match given conditions.
	 *
	 * @param string|array $args Optional. Arguments to be passed to WP_Query.
	 *
	 * @return array Array of WPSELZY_Form objects.
	 */
	public static function find( $args = '' ) {
		$defaults = [
			'post_status'    => 'any',
			'posts_per_page' => - 1,
			'offset'         => 0,
			'orderby'        => 'ID',
			'order'          => 'ASC',
		];

		$args = wp_parse_args( $args, $defaults );

		$args['post_type'] = self::post_type;

		$q     = new WP_Query();
		$posts = $q->query( $args );

		self::$found_items = $q->found_posts;

		$objs = [];

		foreach ( (array) $posts as $post ) {
			$objs[] = new self( $post );
		}

		return $objs;
	}


	/**
	 * Returns a form data filled by default template contents.
	 *
	 * @param string|array $args Optional. Form options.
	 *
	 * @return WPSELZY_Form A new form object.
	 */
	public static function get_template( $args = '' ) {
		$args = wp_parse_args( $args, [
			'locale' => '',
			'title'  => __( 'Без названия', 'selzy' ),
		] );

		$locale = $args['locale'];
		$title  = $args['title'];

		if ( ! $switched = wpselzy_load_textdomain( $locale ) ) {
			$locale = determine_locale();
		}

		$form         = new self;
		$form->title  = $title;
		$form->locale = $locale;

		$properties = $form->get_properties();

		foreach ( $properties as $key => $value ) {
			$properties[ $key ] = WPSELZY_FormTemplate::get_default( $key );
		}

		$form->properties = $properties;

		$form = apply_filters( 'wpselzy_form_default_pack',
			$form, $args
		);

		if ( $switched ) {
			wpselzy_load_textdomain();
		}

		self::$current = $form;

		return $form;
	}


	/**
	 * Returns an instance of WPSELZY_Form.
	 *
	 * @return WPSELZY_Form A new form object.
	 */
	public static function get_instance( $post ) {
		$post = get_post( $post );

		if ( ! $post
		     or self::post_type != get_post_type( $post ) ) {
			return false;
		}

		return self::$current = new self( $post );
	}


	/**
	 * Generates a "unit-tag" for the given form ID.
	 *
	 * @return string Unit-tag.
	 */
	private static function generate_unit_tag( $id = 0 ) {
		static $global_count = 0;

		$global_count += 1;

		if ( in_the_loop() ) {
			$unit_tag = sprintf( 'wpselzy-f%1$d-p%2$d-o%3$d',
				absint( $id ),
				get_the_ID(),
				$global_count
			);
		} else {
			$unit_tag = sprintf( 'wpselzy-f%1$d-o%2$d',
				absint( $id ),
				$global_count
			);
		}

		return $unit_tag;
	}


	/**
	 * Constructor.
	 */
	private function __construct( $post = null ) {
		$post = get_post( $post );

		if ( $post
		     and self::post_type == get_post_type( $post ) ) {
			$this->id     = $post->ID;
			$this->name   = $post->post_name;
			$this->title  = $post->post_title;
			$this->locale = get_post_meta( $post->ID, '_locale', true );

			$properties = $this->get_properties();

			foreach ( $properties as $key => $value ) {
				if ( metadata_exists( 'post', $post->ID, '_' . $key ) ) {
					$properties[ $key ] = get_post_meta( $post->ID, '_' . $key, true );
				} elseif ( metadata_exists( 'post', $post->ID, $key ) ) {
					$properties[ $key ] = get_post_meta( $post->ID, $key, true );
				}
			}

			$this->properties = $properties;
		}

		do_action( 'wpselzy_form', $this );
	}


	/**
	 * Magic method for property overloading.
	 */
	public function __get( $name ) {
		$message = __( '<code>%1$s</code> property of a <code>WPSELZY_Form</code> object is <strong>no longer accessible</strong>. Use <code>%2$s</code> method instead.',
			'selzy' );

		if ( 'id' == $name ) {
			if ( WP_DEBUG ) {
				trigger_error(
					sprintf( $message, 'id', 'id()' ),
					E_USER_DEPRECATED
				);
			}

			return $this->id;
		} elseif ( 'title' == $name ) {
			if ( WP_DEBUG ) {
				trigger_error(
					sprintf( $message, 'title', 'title()' ),
					E_USER_DEPRECATED
				);
			}

			return $this->title;
		} elseif ( $prop = $this->prop( $name ) ) {
			if ( WP_DEBUG ) {
				trigger_error(
					sprintf( $message, $name, 'prop(\'' . $name . '\')' ),
					E_USER_DEPRECATED
				);
			}

			return $prop;
		}
	}


	/**
	 * Returns true if this form is not yet saved to the database.
	 */
	public function initial() {
		return empty( $this->id );
	}


	/**
	 * Returns the value for the given property name.
	 *
	 * @param string $name Property name.
	 *
	 * @return array|string|null Property value. Null if property doesn't exist.
	 */
	public function prop( $name ) {
		$props = $this->get_properties();

		return isset( $props[ $name ] ) ? $props[ $name ] : null;
	}


	/**
	 * Returns all the properties.
	 *
	 * @return array This form's properties.
	 */
	public function get_properties() {
		$properties = (array) $this->properties;

		$properties = wp_parse_args( $properties, [
			'form'         => '',
			'contact_list' => '',
		] );

		$properties = (array) apply_filters(
			'wpselzy_form_properties',
			$properties, $this
		);

		return $properties;
	}


	/**
	 * Updates properties.
	 *
	 * @param array $properties New properties.
	 */
	public function set_properties( $properties ) {
		$defaults = $this->get_properties();

		$properties = wp_parse_args( $properties, $defaults );
		$properties = array_intersect_key( $properties, $defaults );

		$this->properties = $properties;
	}


	/**
	 * Returns ID of this form.
	 *
	 * @return int The ID.
	 */
	public function id() {
		return $this->id;
	}


	/**
	 * Returns unit-tag for this form.
	 *
	 * @return string Unit-tag.
	 */
	public function unit_tag() {
		return $this->unit_tag;
	}


	/**
	 * Returns name (slug) of this form.
	 *
	 * @return string Name.
	 */
	public function name() {
		return $this->name;
	}


	/**
	 * Returns title of this form.
	 *
	 * @return string Title.
	 */
	public function title() {
		return $this->title;
	}


	/**
	 * Set a title for this form.
	 *
	 * @param string $title Title.
	 */
	public function set_title( $title ) {
		$title = strip_tags( $title );
		$title = trim( $title );

		if ( '' === $title ) {
			$title = __( 'Без названия', 'selzy' );
		}

		$this->title = $title;
	}


	/**
	 * Returns the locale code of this form.
	 *
	 * @return string Locale code. Empty string if no valid locale is set.
	 */
	public function locale() {
		if ( wpselzy_is_valid_locale( $this->locale ) ) {
			return $this->locale;
		} else {
			return '';
		}
	}


	/**
	 * Sets a locale for this form.
	 *
	 * @param string $locale Locale code.
	 */
	public function set_locale( $locale ) {
		$locale = trim( $locale );

		if ( wpselzy_is_valid_locale( $locale ) ) {
			$this->locale = $locale;
		} else {
			$this->locale = 'en_US';
		}
	}

	/**
	 * Generates HTML that represents a form.
	 *
	 * @param string|array $args Optional. Form options.
	 *
	 * @return string HTML output.
	 */
	public function form_html( $args = '' ) {
		$args = wp_parse_args( $args, [] );

		$this->shortcode_atts = $args;

		$this->unit_tag = self::generate_unit_tag( $this->id );

		$lang_tag = str_replace( '_', '-', $this->locale );

		if ( preg_match( '/^([a-z]+-[a-z]+)-/i', $lang_tag, $matches ) ) {
			$lang_tag = $matches[1];
		}

		/*$html = sprintf('<div %s>',
			wpselzy_format_atts(array(
				'role' => 'form',
				'class' => 'wpunisender',
				'id' => $this->unit_tag(),
				(get_option('html_type') == 'text/html') ? 'lang' : 'xml:lang'
				=> $lang_tag,
				'dir' => wpunisender_is_rtl($this->locale) ? 'rtl' : 'ltr',
			))
		);

		$html .= $this->form_hidden_fields();

		$html .= $this->title;

		$html .= '</div>';*/

		ob_start();
		$form         = json_decode( $this->prop( 'form' ), true );
		$contact_list = intval( $this->prop( 'contact_list' ) );
		require WPSELZY_PLUGIN_DIR . '/includes/form-view.php';

		return ob_get_clean();

//        return $html;
	}

	/**
	 * Returns a set of hidden fields.
	 */
	private function form_hidden_fields() {
		$hidden_fields = [
			'_wpunisender'                  => $this->id(),
			'_wpunisender_version'          => WPSELZY_VERSION,
			'_wpunisender_locale'           => $this->locale(),
			'_wpunisender_unit_tag'         => $this->unit_tag(),
			'_wpunisender_container_post'   => 0,
			'_wpunisender_posted_data_hash' => '',
		];

		if ( in_the_loop() ) {
			$hidden_fields['_wpunisender_container_post'] = (int) get_the_ID();
		}

		if ( $this->nonce_is_active() and is_user_logged_in() ) {
			$hidden_fields['_wpnonce'] = wpselzy_create_nonce();
		}

		$hidden_fields += (array) apply_filters(
			'wpunisender_form_hidden_fields', array()
		);

		$content = '';

		foreach ( $hidden_fields as $name => $value ) {
			$content .= sprintf(
				            '<input type="hidden" name="%1$s" value="%2$s" />',
				            esc_attr( $name ),
				            esc_attr( $value )
			            ) . "\n";
		}

		return '<div style="display: none;">' . "\n" . $content . '</div>' . "\n";
	}

	/**
	 * Returns true if nonce is active for this form.
	 */
	public function nonce_is_active() {
		$is_active = WPSELZY_VERIFY_NONCE;

		return (bool) apply_filters( 'wpselzy_verify_nonce', $is_active, $this );
	}

	/**
	 * Stores this form properties to the database.
	 *
	 * @return int The post ID on success. The value 0 on failure.
	 */
	public function save() {
		$title = wp_slash( $this->title );
		$props = wp_slash( $this->get_properties() );

		$post_content = implode( "\n", wpselzy_array_flatten( $props ) );

		if ( $this->initial() ) {
			$post_id = wp_insert_post( [
				'post_type'    => self::post_type,
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_content' => trim( $post_content ),
			] );
		} else {
			$post_id = wp_update_post( [
				'ID'           => (int) $this->id,
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_content' => trim( $post_content ),
			] );
		}

		if ( $post_id ) {
			foreach ( $props as $prop => $value ) {
				update_post_meta( $post_id, '_' . $prop,
					wpselzy_normalize_newline_deep( $value )
				);
			}

			if ( wpselzy_is_valid_locale( $this->locale ) ) {
				update_post_meta( $post_id, '_locale', $this->locale );
			}

			if ( $this->initial() ) {
				$this->id = $post_id;
				do_action( 'wpselzy_after_create', $this );
			} else {
				do_action( 'wpselzy_after_update', $this );
			}

			do_action( 'wpselzy_after_save', $this );
		}

		return $post_id;
	}


	/**
	 * Makes a copy of this form.
	 *
	 * @return WPSELZY_Form New form object.
	 */
	public function copy() {
		$new             = new self;
		$new->title      = $this->title . '_copy';
		$new->locale     = $this->locale;
		$new->properties = $this->properties;

		return apply_filters( 'wpselzy_copy', $new, $this );
	}


	/**
	 * Deletes this form.
	 */
	public function delete() {
		if ( $this->initial() ) {
			return;
		}

		if ( wp_delete_post( $this->id, true ) ) {
			$this->id = 0;

			return true;
		}

		return false;
	}


	/**
	 * Returns a WordPress shortcode for this form.
	 */
	public function shortcode( $args = '' ) {
		$args = wp_parse_args( $args, array() );

		$title = str_replace( [ '"', '[', ']' ], '', $this->title );

		$shortcode = sprintf(
			'[selzy-form id="%1$d" title="%2$s"]',
			$this->id,
			$title
		);

		return apply_filters( 'wpselzy_form_shortcode',
			$shortcode, $args, $this
		);
	}

	public function get_contact_lists() {
		$api_key = get_option( 'wpselzy_api_key' );
		$api     = new \Selzy\ApiWrapper\SelzyApi( $api_key );
		$json    = $api->getLists();
		$data    = json_decode( $json, true );
		if ( isset( $data['result'] ) ) {
			return $data['result'];
		}

		return [];
	}
}
