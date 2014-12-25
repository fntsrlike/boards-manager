$( function(){

    // GET method
    models.get = function( url, callback ) {
        $.get( url ).done( function( data ) {
            callback( data );
        });
    };

    // POST method with serialize data
    models.post = function( url, selector, callback ) {
        $.post( url , $( selector ).serialize()).done( function( data ) {
            callback( data );
        });
    };

    // PUT method with serialize data
    models.put = function( url, selector, callback ) {
        $.ajax({
            url: url,
            type: 'PUT',
            data: $( selector ).serialize()
        }).success( function( data ) {
            callback( data );
        });
    };

    // DELETE method with serialize data
    models.delete = function( url, selector, callback ) {
        $.ajax({
            url: url,
            type: 'DELETE',
            data: $( selector ).serialize()
        }).success( function( data ) {
            callback( data );
        });
    };

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

    // Get boards data
    models.readUsers = function( callback, args ) {
        if ( typeof( args ) === 'undefined' ) args = {};
        models.get( api.users + '?' + $.param( args ), callback );
    };

    models.updateBoards = function( callback ) {
        id =
        models.put( api.boards + '/' + $('#boardModifyId'), 'modal_boards_modify form', callback );
    };

    models.updateUsers = function( callback ) {
        models.put( api.users + '/' + $('#userModifyId'), 'modal_users_modify form', callback );
    };

    models.updateRecords = function( callback ) {
        models.put( api.records + '/' + $('#recordModifyId'), 'modal_records_modify form', callback );
    };
});
