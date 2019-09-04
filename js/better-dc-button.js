var better_dc_button = better_dc_button || {};

// global variables
better_dc_button = {
    redirect_link: {}, 
    button_id: {}, 
};

jQuery( function ( $ ) {
    
    $( '.better-dc-button' ).each( function ( index ) {
       //get the variables from each element
        
        var id = $( this ).attr('id');
        
        if ( id.indexOf( '-' ) != -1 ) {
           alert("There is a '-' in your button id! Please use an id without any '-' chars!");
           return;
        }
        
        if("button_params" + id in window){ 
            better_dc_button.redirect_link[id]     = window["button_params" + id].redirect_link;
            better_dc_button.button_id[id]         = window["button_params" + id].button_id;
        } else {
           return;
        }
        
        $('#' + better_dc_button.button_id[id]).click(function(){
            location.replace( better_dc_button.redirect_link[id] );	
        } );
    } );

} ); // closure