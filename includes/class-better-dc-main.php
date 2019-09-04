<?php

/**
 * BETTER_DC class.
 *
 * This class holds all BETTER_DC components.
 *
 * @package Betterplace Donation Plugin
 * @since 1.0
 */

if ( ! class_exists( 'BETTER_DC' ) ) :

//                error_log('id:  ' . print_r( $donation, true) . "\n", 3,  'C:\wamp64\www\Jonasunterwegs\error.log');
    class BETTER_DC {

        /**
        * Shortcode handler for
        * donation counter
        *
        * @since 1.0
        * @access public
        */
        public function donation_counter( $atts = '' ) {
    
            extract( shortcode_atts( array(
                'animation' => 1,
                'min' => 0,
                'max' => 200000,
                'donations' => 0,
                'height' => 'donations',
                'offset' => 0,
                'project_id' => null,
                'width' => 0,
                'scale_box_class' => null,
                'scale_content_class' => null,
                'image' => 1,
                'content' => 1,
                'only_numeric' => 0,
                'static_img_link' => BETTER_DC_RELPATH . 'img/counter-bg.png',
                'animated_img_link' => BETTER_DC_RELPATH . 'img/counter-fill.png',
            ), $atts ) );

            if( $project_id != null ) {
                // URL-Zusammenbau für den API-Call
                $url = "https://api.betterplace.org/de/api_v4/projects/" . $project_id . ".json";

    //		$url = "https://TEST.org/de/api_v4/projects/" . $project_id . "json";

                $header = get_headers($url, 1);

                if ($header[0] != 'HTTP/1.0 200 OK'){
                        // echo "Fehlerhafter Link";
                        return "Fehlerhafter Link";
                }

                $datei = file_get_contents($url);

                if (!$datei) {
                        // echo "Datei konnte nicht geöffnet werden.";
                        return "Datei konnte nicht geöffnet werden.";
                }

                // JSON-Parsing
                $json_decoder = json_decode($datei);
                $donations = $json_decoder->donated_amount_in_cents / 100;
            }
            
            if( $height == 'donations' ) {
                $height = $donations * 100 / $max;
                if( $height > 100 ) {
                    $height = 100;
                }
                
                $height = '' . $height . '%';
            }
            
            $id = uniqid();
            $current = $donations;
            $current = $current + $offset;
            $counter_params = array(
                'min' => $min,
                'current' => $current,
                'max' => $max,
                'height' => $height,
                'width' => $width,
                'only_numeric' => $only_numeric,
            );

            wp_enqueue_script( 'better-dc-counter' );
            wp_localize_script( 'better-dc-counter', 'counter_params' . $id, $counter_params );
            
            if( $only_numeric == 0 ) { 
                $output =   '<div class="counter-wrap" id="' . $id . '">' . 
                                '<div id="counter" class="' . $scale_box_class . ' ';
                                if ( 1 == $animation ) {
                                        $output .= 'animated ';
                                }
                                if ( 1 == $width ) {
                                        $output .= 'width ';
                                }
                                $output .= '">';
                                    if ( 1 == $image ) {
                                        $output .=  '<img id="counter-bg" alt="Donation Counter" src="' . $static_img_link . '" />';
                                    }
                                    $output .= '<div id="counter-fill-wrap"';
                                    if ( 1 == $animation ) {
                                        $output .= ' class="animated ';
                                    } else {
                                        $output .= ' class="simple ';
                                    }
                                    $output .= $scale_content_class . '">';
                                    if ( 1 == $image ) {
                                        $output .= '<img id="counter-fill" alt="Donation Counter" src="' . $animated_img_link . '" />';
                                    }
                                    $output .= '</div>';
                                    if ( 1 == $content ) {
                                        $output .= '<div id="counter-value-wrap">' .
                                                        '<span class="counter-value">' . $min . '</span>' .
                                                        '<br /><span class="counter-money">' . _x( 'Euros', 'Donation Counter', 'better-dc' ) . '</span>' .
                                                    '</div>';
                                    }
                                $output .= '</div>' .
                            '</div>';
            } else {
                $output =   ' <span id="' . $id . '" class="counter-value-only counter-wrap">' . $min . '</span> ';
//                $output =   '<div class="counter-wrap only-numeric-wrap" id="' . $id . '"> <span class="counter-value">' . $min . '</span> </div>';
            }

            return $output;
       }  

        /**
        * Shortcode handler for
        * donation button
        *
        * @since 1.0
        * @access public
        */
        public function donation_button( $atts = '' ) {
    
            extract( shortcode_atts( array(
                'client_id'             => null,
                'project_id'            => null,
                'button_id'             => null,
                'donation_client_ref'   => null,
            ), $atts ) );
            
            $error = 0;
            $error_text = '';
            if( $button_id == null ) {
                $error_text .= "No Button ID! (button_id='') <br>";
                $error = 1;
            } 
            if ( $client_id == null ) {
                $error_text .= "No client id! (client_id='') <br>";
                $error = 1;
            } 
            if ( $project_id == null ) {
                $error_text .= "No project id! (project_id='') <br>";
                $error = 1;
            } 
            if ( $donation_client_ref == null ) {
                $error_text .= "No donation client reference! (donation_client_ref='') <br>";
                $error = 1;
            }
            if ( $error != 0 ) {
                return $error_text;
            }
            
            //check if in button id is a - char, it will break with this 
            if ( strpos( $button_id, '-' ) !== false ) {
                return "There is a '-' in your button id! Please use an id without any '-' chars!";
            }
                        
            //create the redirect link
            $final_donation_client_ref = '&donation_client_reference=' . $donation_client_ref . '_' . uniqid();
            $redirect_link = 'https://www.betterplace.org/de/projects/' . $project_id . '/client_donations/new?client_id=' . $client_id . $final_donation_client_ref;
            
            $button_params = array(
                'redirect_link' => $redirect_link,
                'button_id' => $button_id,
            );

            wp_enqueue_script( 'better-dc-button' );
            wp_localize_script( 'better-dc-button', 'button_params' . $button_id, $button_params );

            return ;
       }  

        /**
        * Shortcode handler for
        * donation redirect handling
        *
        * @since 1.0
        * @access public
        */
        public function donation_redirect_handling( $atts = '' ) {
    
            extract( shortcode_atts( array(
                'donation_client_ref'   => null,
                'redirect_link'         => null,   
                'debug'                 => 0,
            ), $atts ) );
            
            $error = 0;
            $error_text = '';
            if( $donation_client_ref == null ) {
                $error_text .= "No donation client reference! (donation_client_ref='test1, test2') <br>";
                $error = 1;
            } 
            if ( $redirect_link == null ) {
                $error_text .= "No redirect link! (client_id='link1, link2') <br>";
                $error = 1;
            } 
            if ( $error != 0 ) {
                return $error_text;
            }
            
            // Create our array of values
            // First, sanitize the data and remove white spaces
            $no_whitespaces = preg_replace( '/\s*,\s*/', ',', filter_var( $donation_client_ref, FILTER_SANITIZE_STRING ) ); 
            $donation_client_ref_array = explode( ',', $no_whitespaces );
            $no_whitespaces = preg_replace( '/\s*,\s*/', ',', filter_var( $redirect_link, FILTER_SANITIZE_STRING ) ); 
            $redirect_link_array = explode( ',', $no_whitespaces );
            
            if( isset( $_GET['status'] ) && isset( $_GET['donation_client_reference'] ) && 
                    isset( $_GET['amount'] ) && isset( $_GET['donation_token'] ) && 
                    ( $_GET['status'] == 'DONATION_COMPLETE' ) ){
                
                $donation_client_reference = $_GET['donation_client_reference'];
                $amount = $_GET['amount'];
                $donation_token = $_GET['donation_token'];
                
                $donation_client_reference_teile = explode("_", $donation_client_reference);
                $donation_client_reference = $donation_client_reference_teile[0];
                
                if ( !in_array( $donation_client_reference, $donation_client_ref_array ) ) {
                    return "There was a technical issue!";
                }
                
                $key = array_search( $donation_client_reference, $donation_client_ref_array );
                $redirect = $redirect_link_array[$key];
                
                wp_enqueue_script( 'better-dc-redirect' );
                wp_localize_script('better-dc-redirect', 'app_vars', array(
                        'url' => $redirect
                        )
                );
            }

            return ;
       }  

        /**
         * PHP5 style constructor
         *
         * @since 1.0
         * @access public
         */
        public function __construct() {
            add_shortcode( 'better-dc-donation-counter', array( &$this, 'donation_counter' ) );
            add_shortcode( 'better-dc-donation-button', array( &$this, 'donation_button' ) );
            add_shortcode( 'better-dc-donation-redirect-handling', array( &$this, 'donation_redirect_handling' ) );
        }

    } // class

endif; // class exists

?>