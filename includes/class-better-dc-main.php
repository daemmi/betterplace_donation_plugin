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
            error_log('id:  ' . print_r( $height, true) . "\n", 3,  'C:\wamp64\www\Jonasunterwegs\error.log');
            
            $id = uniqid();
            $current = $donations;
            $current = $current + $offset;
            $counter_params = array(
                 'min' => $min,
                 'current' => $current,
                 'max' => $max,
                 'height' => $height
            );

            wp_enqueue_script( 'better-dc-counter' );
            wp_localize_script( 'better-dc-counter', 'counter_params' . $id, $counter_params );

            $output = '<div class="counter-wrap" id="' . $id . '">' . 
                            '<div id="counter"';
            if ( 1 == $animation ) {
                    $output .= ' class="animated"';
            }
            $output .= '>' .
                                   '<img id="counter-bg" alt="Donation Counter" src="' . BETTER_DC_RELPATH . 'img/counter-bg.png" />' .
                                   '<div id="counter-fill-wrap"';
                                   if ( 1 == $animation ) {
                                           $output .= ' class="animated"';
                                   } else {
                                           $output .= ' class="simple"';
                                   }
                                   $output .= '>' .
                                           '<img id="counter-fill" alt="Donation Counter" src="' . BETTER_DC_RELPATH . 'img/counter-fill.png" />' .
                                   '</div>' .
                                   '<div id="counter-value-wrap">' .
                                           '<span id="counter-value">' . $min . '</span>' .
                                           '<br /><span class="counter-money">' . _x( 'Euros', 'Donation Counter', 'better-dc' ) . '</span>' .
                                   '</div>' .
                           '</div>' .
                   '</div>';

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
        }

    } // class

endif; // class exists

?>