$( function(){

    // GET method
    models.get = function( url, callback ) {
        $.get( url ).done( function( data ) {
            callback( data );
        });
    }

    // POST method with serialize data
    models.post = function( url, selector, callback ) {
        $.post( url , $( selector ).serialize()).done( function( data ) {
            callback( data );
        });
    }

    // Login
    models.login = function( callback ) {
        models.post( api.login, '#modal_login form', callback );
    };

    // Register
    models.createUsers = function( callback ) {
        models.post( api.users, '#modal_register form', callback );
    };

    // Apply a poster
    models.createRecords = function( callback ) {
        models.post( api.records, '#tab_apply form', callback );
    };

    // Get records data
    models.readRecords = function( callback, args ) {
        if ( typeof( args ) === 'undefined' ) args = {};
        models.get( api.records + '?' + $.param( args ), callback );
    };

    // Get boards data
    models.readBoards = function( callback, args ) {
        if ( typeof( args ) === 'undefined' ) args = {};
        models.get( api.boards + '?' + $.param( args ), callback );
    };
});
