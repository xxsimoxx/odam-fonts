<?php

/**
 * Plugin Name: ODAM fonts and colors
 * Description: Adds legible fonts and background color selector to TwentySeventeen.
 * Version: 1.0.0
 * Author: Simone Fioravanti
 * Requires CP: 2.5
 * Requires PHP: 8.0
 */

class FontLister {
	static $font_arr = array();
}

const ODAM_DEFAULT_OPTIONS = [
  'body_font' => 'Alegreya+Sans',
  'title_font' => 'Alegreya+Sans',
  'heading_font' => 'Alegreya+Sans',
  'menu_font' => 'Alegreya+Sans',
  'bg_color' => '#ffffff',
];

$list = [
	'Alegreya Sans',
	'Atkinson Hyperlegible',
	'Atkinson Hyperlegible Next',
	'Atkinson Hyperlegible Mono',
	'Lexend Deca',
];

foreach ( $list as $font ) {
	FontLister::$font_arr[str_replace(' ', '+', $font)] = $font;
}


function odam_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'odam_section' , array(
		'title'      => esc_html__( 'ODAM', 'odam-fonts' ),
		'priority'   => 1000,
	));
}
add_action( 'customize_register', 'odam_customize_register' );


function odam_customize_body_font( $wp_customize ) {
	$wp_customize->add_setting( 'odam_theme_options[body_font]', array(
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => ODAM_DEFAULT_OPTIONS['body_font'],
	));
	$wp_customize->add_control( 'body_font', array(
		'label'     => esc_html__( 'Body font', 'odam-fonts' ),
		'section'   => 'odam_section',
		'settings'  => 'odam_theme_options[body_font]',
		'priority'  => 10,
		'type'      => 'select',
		'choices'   => FontLister::$font_arr
	));
}
add_action( 'customize_register', 'odam_customize_body_font' );

function odam_customize_title_font( $wp_customize ) {
	$wp_customize->add_setting( 'odam_theme_options[title_font]', array(
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => ODAM_DEFAULT_OPTIONS['title_font'],
	));
	$wp_customize->add_control( 'title_font', array(
		'label'     => esc_html__( 'Title font', 'odam-fonts' ),
		'section'   => 'odam_section',
		'settings'  => 'odam_theme_options[title_font]',
		'priority'  => 20,
		'type'      => 'select',
		'choices'   => FontLister::$font_arr
	));
}
add_action( 'customize_register', 'odam_customize_title_font' );

function odam_customize_heading_font( $wp_customize ) {
	$wp_customize->add_setting( 'odam_theme_options[heading_font]', array(
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => ODAM_DEFAULT_OPTIONS['heading_font'],
	));
	$wp_customize->add_control( 'heading_font', array(
		'label'     => esc_html__( 'Heading font', 'odam-fonts' ),
		'section'   => 'odam_section',
		'settings'  => 'odam_theme_options[heading_font]',
		'priority'  => 20,
		'type'      => 'select',
		'choices'   => FontLister::$font_arr
	));
}
add_action( 'customize_register', 'odam_customize_heading_font' );

function odam_customize_heading_menu_font( $wp_customize ) {
	$wp_customize->add_setting( 'odam_theme_options[menu_font]', array(
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => ODAM_DEFAULT_OPTIONS['menu_font'],
	));
	$wp_customize->add_control( 'menu_font', array(
		'label'     => esc_html__( 'Menu font', 'odam-fonts' ),
		'section'   => 'odam_section',
		'settings'  => 'odam_theme_options[menu_font]',
		'priority'  => 30,
		'type'      => 'select',
		'choices'   => FontLister::$font_arr
	));
}
add_action( 'customize_register', 'odam_customize_heading_menu_font' );

function odam_customize_background_color( $wp_customize ) {
	$wp_customize->add_setting( 'odam_theme_options[bg_color]', array(
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => ODAM_DEFAULT_OPTIONS['bg_color'],
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'page_background_color', array(
			'label'         => __('Page Background Color', 'odam-fonts'),
			'description'   => __('Set the color of the website background.', 'odam-fonts'),
			'section'       => 'odam_section',
			'settings'      => 'odam_theme_options[bg_color]',
			'priority'      => 60,
		)));
}
add_action( 'customize_register', 'odam_customize_background_color' );

$theme_options = get_option( 'odam_theme_options', ODAM_DEFAULT_OPTIONS);

if ( $theme_options ) {

	function odam_custom_fonts() {
		$theme_options = get_option( 'odam_theme_options', ODAM_DEFAULT_OPTIONS );
		echo '<style>';
			if ( isset( $theme_options[ 'body_font' ] ) && $theme_options[ 'body_font' ] != '' ) {
				echo 'body, button, input, select, textarea { font-family: "' . esc_html( urldecode( $theme_options[ 'body_font' ] ) ) . '" } ';
				echo 'input::-webkit-input-placeholder { font-family: "' . esc_html( urldecode( $theme_options[ 'body_font' ] ) ) . '"; } ';
				echo 'input::-moz-placeholder { font-family: "' . esc_html( urldecode( $theme_options[ 'body_font' ] ) ). '"; }';
				echo 'input:-ms-input-placeholder { font-family: "' . esc_html( urldecode( $theme_options[ 'body_font' ] ) ) . '"; } ';
				echo 'input::placeholder { font-family: "' . esc_html( urldecode( $theme_options[ 'body_font' ] ) ) . '"; } ';
			}
			if ( isset( $theme_options[ 'title_font' ] ) && $theme_options[ 'title_font' ] != '' ) {
				echo '.site-description, .entry-header h2.entry-title { font-family: "' . esc_html( urldecode( $theme_options[ 'title_font' ] ) ). '"; } ';
			}
			if ( isset( $theme_options[ 'heading_font' ] ) && $theme_options[ 'heading_font' ] != '' ) {
				echo 'h1, h2, h3, h4, h5, h6, p.site-title { font-family: "' . esc_html( urldecode( $theme_options[ 'heading_font' ] ) ) . '" } ';
			}
			if ( isset( $theme_options[ 'menu_font' ] ) && $theme_options[ 'menu_font' ] != '' ) {
				echo '.main-navigation .menu { font-family: "' . esc_html( urldecode( $theme_options[ 'menu_font' ] ) ) . '"; } ';
			}
			if ( isset( $theme_options[ 'bg_color' ] ) && $theme_options[ 'bg_color' ] != '' ) {
				echo '.site-content-contain { background-color: ' . esc_html( urldecode( $theme_options[ 'bg_color' ] ) ) . '; } ';
			}
			//
		echo '</style>';
	}
	add_action( 'wp_head', 'odam_custom_fonts' );

	function odam_load_fonts() {

		$theme_options = get_option( 'odam_theme_options', ODAM_DEFAULT_OPTIONS );

		$font_families = array();

		if ( isset( $theme_options[ 'body_font' ] ) && $theme_options[ 'body_font' ] != '' ) {
			$font_families[] = urldecode( $theme_options[ 'body_font' ] ) . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		}

		if ( isset( $theme_options[ 'title_font' ] ) && $theme_options[ 'title_font' ] != '' ) {
			$font_families[] = urldecode( $theme_options[ 'title_font' ] ) . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		}

		if ( isset( $theme_options[ 'heading_font' ] ) && $theme_options[ 'heading_font' ] != '' ) {
			$font_families[] = urldecode( $theme_options[ 'heading_font' ] ) . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		}

		if ( isset( $theme_options[ 'menu_font' ] ) && $theme_options[ 'menu_font' ] != '' ) {
			$font_families[] = urldecode( $theme_options[ 'menu_font' ] ) . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		}

		if ( count( $font_families ) > 0 ) {
			$query_args = array(
				'family' => rawurlencode( implode( '|', $font_families ) ),
				'subset' => rawurlencode( 'latin,latin-ext' ),
			);
			$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			wp_enqueue_style( 'odam_fonts', $font_url, array(), '1.0.0' );
		}

	}
	add_action( 'wp_enqueue_scripts', 'odam_load_fonts' );
}
