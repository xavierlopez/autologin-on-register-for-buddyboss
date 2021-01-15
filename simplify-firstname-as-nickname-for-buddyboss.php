<?php

/*
 * Plugin Name: Simplify Fistname as Nickname for BuddyBoss
 * Author: Xavier Lopez
 * Author URI: https://xavierlopez.dev
 * Version: 1.0.0
 * Description: This plugin simplifies the process of registration of a new user by removing the 'First Name' field.
 * License: GPLv2
 * Last Modified: Jan 05, 2020
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Enqueuing css.
 */
add_action('wp_enqueue_scripts', function () {
        $plugin_dir = '/wp-content/plugins/simplify-firstname-as-nickname-for-buddyboss/';
        wp_register_style( 'bb-simplify-style', $plugin_dir."assets/style.css" );
        wp_enqueue_style( 'bb-simplify-style' );
    }
);


/**
 * Use the username as display name.
 */
function xavierlopez_inject_username_as_fullname() {
    $_POST['field_1'] = $_POST['field_3'];
 
}
add_action( 'bp_signup_pre_validate', 'xavierlopez_inject_username_as_fullname' );


/**
 * Disable client side required attribute in input field to avoid failing of form submission.
 * All modern browsers will not submit if a field is marked as required and does not have the value.
 *
 * @param array  $atts input field attributes.
 * @param string $field_name field name.
 *
 * @return array
 */

function xavierlopez_disable_fullname_required_attributes( $atts, $field_name ) {
 
    global $field;
    
    // Default value '1' will work for most people.
    $fullname_field_id = 1;
 
    if ( $field && $fullname_field_id !== $field->id ) {
        return $atts;
    }
 
    foreach ( $atts as $key => $value ) {
        if ( 'required' === $value ) {
            unset( $atts[ $key ] );
            break;
        }
    }
    return $atts;
}
add_filter( 'bp_get_form_field_attributes', 'xavierlopez_disable_fullname_required_attributes', 10, 2 );