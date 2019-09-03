var better_dc = better_dc || {};

// global variables
better_dc = {
    height: {}, 
    min_val: {}, 
    cur_val: {},
    index: {},
    width: {},
}

jQuery( function ( $ ) {
    
    $( '.counter-wrap' ).each( function ( index ) {
        var id = $( this ).attr('id');
        better_dc.height[id] = window["counter_params" + id].height;
        better_dc.min_val[id] = window["counter_params" + id].min;
        better_dc.cur_val[id] = window["counter_params" + id].current; 
        better_dc.width[id] = window["counter_params" + id].width; 
        better_dc.index[id] = index;

        setTimeout( function() {
            count_up( id, better_dc.min_val[id], better_dc.cur_val[id] );
            if( better_dc.width[id] == 1 ) {
                $( '#' + id ).find( '#counter-fill-wrap.animated' )
                    .animate( { width: better_dc.height[id] }, 5000 ); 
            } else {
                $( '#' + id ).find( '#counter-fill-wrap.animated' )
                    .animate( { height: better_dc.height[id] }, 5000 ); 
            }

        }, 975 );
        
        if( better_dc.width[id] == 1 ) {
            $( '#' + id ).find( '#counter-fill-wrap.simple' )
                .width( better_dc.height[id] ); 
        } else {
            $( '#' + id ).find( '#counter-fill-wrap.simple' )
                .height( better_dc.height[id] ); 
        }
        
    } );

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
                    $( '#' + id ).find( 'span#counter-value').text(current_val);
                }
            },
            50
        );
    }

} ); // closure