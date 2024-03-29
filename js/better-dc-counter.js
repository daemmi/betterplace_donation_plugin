var better_dc_counter = better_dc_counter || {};

// global variables
better_dc_counter = {
    height: {}, 
    min_val: {}, 
    cur_val: {},
    index: {},
    width: {},
    runed: {},
    only_numeric: {},
};

jQuery( function ( $ ) {
    
    //run through all elements
    $( '.counter-wrap' ).each( function ( index ) {
        //get the variables from each element
        var id = $( this ).attr('id');
        better_dc_counter.height[id]        = window["counter_params" + id].height;
        better_dc_counter.min_val[id]       = window["counter_params" + id].min;
        better_dc_counter.cur_val[id]       = window["counter_params" + id].current; 
        better_dc_counter.width[id]         = window["counter_params" + id].width; 
        better_dc_counter.only_numeric[id]  = window["counter_params" + id].only_numeric; 
        better_dc_counter.index[id]         = index; 
        better_dc_counter.runed[id]         = 0;
        
        //fill the elements if animation is off
        if( better_dc_counter.width[id] == 1 ) {
            $( '#' + id ).find( '#counter-fill-wrap.simple' )
                .width( better_dc_counter.height[id] ); 
        } else {
            $( '#' + id ).find( '#counter-fill-wrap.simple' )
                .height( better_dc_counter.height[id] ); 
        }
        
        //check if elemt is in viewport
        if( element_scrolled( '#' + id  ) ) {
            // run animation
            setTimeout( function() {
                run( id );
            }, 500 );
        }
        
        //check if user scrolled into element and elemt gets in viewport
        $( window ).scroll( function() {
            if( element_scrolled( '#' + id  ) ) {
                // run animation
                run( id );
                
            }
        } );
        
        //animation function
        function run( id ) {
            if( better_dc_counter.runed[id] == 0 ) {
                better_dc_counter.runed[id] = 1;
                
                    count_up( id, better_dc_counter.min_val[id], better_dc_counter.cur_val[id] );

                    if( better_dc_counter.width[id] == 1 ) {
                        $( '#' + id ).find( '#counter-fill-wrap.animated' )
                            .animate( { width: better_dc_counter.height[id] }, 5000 ); 
                    } else {
                        $( '#' + id ).find( '#counter-fill-wrap.animated' )
                            .animate( { height: better_dc_counter.height[id] }, 5000 ); 
                    }
            }
        }        
        
        // This is then function used to detect if the element is scrolled into view
        function element_scrolled( elem ) {
            var doc_view_top = $( window ).scrollTop();
            var doc_view_bottom = doc_view_top + $( window ).height();
            var elem_bottom = $( elem ).offset().top + $( elem ).height() / 2;
            return ( ( elem_bottom <= doc_view_bottom ) && ( elem_bottom >= doc_view_top ) );
        }
        
    } );

    //function to count up the donation value
    function count_up( id, current_val, max_val ) {
        var increment = ( max_val - 10 ) / 62;
        if ( increment < 1 ) {
                increment = 1;
        }
        setInterval( function() {
                if( current_val < max_val ) {
                    if( ( current_val + increment ) < ( max_val - 10 ) ) {
                        current_val = Math.floor( current_val + increment );
                    } else if( ( current_val + 1 ) < max_val ) {
                        current_val++;
                    } else {
                        current_val = max_val;
                    }
                    if( better_dc_counter.only_numeric[id] == 0 ) {
                        $( '#' + id ).find( 'span.counter-value').text(current_val);
                    } else {
                        $( 'span#' + id + '.counter-value-only').text(current_val);
                    }
                }
            },
            50
        );
    }

} ); // closure