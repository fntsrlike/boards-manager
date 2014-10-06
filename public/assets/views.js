$( function(){

    // Get views
    views.get = function( name ) {
        $.get( api.views + '?name=' + name, function( data ) {
            return data;
        }, 'html' );
    }

    // Get views and instread current one, finally excute callback function
    views.update = function( target, name, callback ) {
        $.get( api.views + '?name=' + name, function( data ) {
            target.replaceWith( data );
            if ( typeof(callback) !== 'undefined' ) {
                callback();
            }
        }, 'html' );
    };

    // Update view with tab name
    views.updateTarget = function( tabName ) {
        var hash, callback;

        hash = {
            'navigation'    : '#navigation',
            'map'           : '#tab_map',
            'boards'        : '#tab_boards',
            'records'       : '#tab_records',
            'login'         : '#modalLogin',
            'register'      : '#modal_register'
        };

        callback = {
            'map' : listener.units
        };

        if ( hash[tabName] === undefined ) {
            console.log( 'Error Tab Name: ' + tabName );
            return;
        }

        views.update( $( hash[tabName] ), tabName, callback[tabName]);
    }

    // Prover template
    views.getPopverTemp = function() {
        return '<div class="popover" style="min-width:300px;" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>';
    }
});
