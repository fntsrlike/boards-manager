var host        = 'http://localhost:9527',
    models      = {},
    views       = {};
    controllers = {},
    events      = {}, 
    api         = {};

api = {
    views    : host + '/api/views',
    users    : host + '/api/users',
    apply    : host + '/api/records',
    boards   : host + '/api/boards',
    register : host + '/register',
    login    : host + '/login'
};

$( function(){

    views.getView = function( name ) {
        $.get( api.views + '?name=' + name, function( data ) {
            return data;
        }, 'html');
    }

    views.updateView = function( target, name ) {
        $.get( api.views + '?name=' + name, function( data ) {
            target.replaceWith( data );
        }, 'html');
    };

    views.updateNavigation = function() {
        views.updateView( $( '#navigation' ), 'navigation');
    };

    views.updateLoginModal = function() {
        views.updateView( $( '#modalLogin' ), 'login');
    };

    views.updateRegister =  function() {
        views.updateView( $( '#modal_register' ), 'register');
    };

    views.updateMap = function() {
        views.updateView( $( '#tab_map' ), 'map');
    }

    views.updateList = function() {
        views.updateView( $( '#tab_list' ), 'list');
    }

    views.updateRecords = function() {
        views.updateView( $( '#tab_records' ), 'records');
    }

    models.post = function( url, selector, callback ) {
        $.post( url , $( selector ).serialize()).done( function( data ) {
            callback(data);
        });
    }

    models.get = function( url, callback ) {
        $.get( url ).done( function( data ) {
            callback(data);
        });
    }

    models.login = function( callback ) {
        models.post( api.login, "#modal_login form", callback );        
    };

    models.register = function( callback ) {
        models.post( api.register, "#modal_register form", callback );
    };

    models.apply = function( callback ) {
        models.post( api.apply, "#tab_apply form", callback );    
    };

    models.records = function( callback ) {
        models.get( api.apply, callback );
    };

    models.boards = function( callback ) {
        models.get( api.boards, callback );
    };

    events.register = function( response ) {
        if ( response.success == true ) {
            $( "#modal_register form" ).trigger("reset");
            $( "#modal_register" ).modal('hide');
            views.updateNavigation();
        }
    };

    events.login = function( response ) {
        if ( response.success == true ) {
            $( "#modal_login form" ).trigger("reset");
            $( "#modal_login" ).modal('hide');
            views.updateNavigation();
        }
    };

    events.apply = function( response ) {
        if ( response.success == true ) {
            $( "#tab_apply form" ).trigger("reset");
            $( "#tab_map" ).tab('show')
            views.updateMap();
        }
    };

    events.records = function( response ) {
        var records = response.map( function( record ) {
            return '<tr>' +
                '<td>' + record.id + '</td>' + 
                '<td>' + record.user_id + '</td>' + 
                '<td>' + record.event_name + '</td>' + 
                '<td>' + record.event_type + '</td>' + 
                '<td>' + record.board_id + '</td>' + 
                '<td>' + record.post_from + ' to ' + record.post_end + '</td>' + 
                '<td>' + record.created_at + '</td>' + 
                '</tr>';
        }).join();

        $( '#tab_records table tr:last' ).after( records );
    }

    events.boards = function( response ) {
        var boards = response.map( function( board ) {
            return '<tr>' +
                '<td>' + board.code + '</td>' + 
                '<td>' + board.type + '</td>' + 
                '<td>' + board.description + '</td>' + 
                '<td>' + board.isUsing + '</td>' + 
                '<td>' + board.created_at + '</td>' + 
                '</tr>';
        }).join();

        $( '#tab_list table tr:last' ).after( boards );
    }

    events.init = function() {
        controllers.listener();
        models.records(events.records);
        models.boards(events.boards);
    }

    controllers.listener = function() {
        $( "#modal_register form" ).submit( function( event ){
            event.preventDefault();
            models.register( events.register );
        });

        $( "#modal_login form" ).submit( function( event ){
            event.preventDefault();
            models.login( events.login );
        });

        $( "#tab_apply form" ).submit( function( event ){
            event.preventDefault();
            models.apply( events.apply );
        });
    };

    events.init();

});