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
                
            ), $atts ) );

            return $output;
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
        }

    } // class

endif; // class exists

?>