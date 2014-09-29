var host        = 'http://localhost:9527',
    models      = {},
    views       = {},
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

    views.getPopverTemp = function() {
        return '<div class="popover" style="min-width:300px;" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>';
    }

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
                '<td>' + board.using_status + '</td>' +
                '<td>' + board.created_at + '</td>' +
                '</tr>';
        }).join();

        $( '#tab_list table tr:last' ).after( boards );
    }

    events.map = function( response ) {
        response.map( function( board ) {
            var target = $( '#map-nchu a div[data-code="' + board.code + '"' );

            target.toggleClass( 'full', board.using_status );
            target.toggleClass( 'empty', !board.using_status );
        });
        events.map_units();
    }

    events.map_units = function() {
        $( "#tab_map a").map( function( key, unit ) {
            var code = $("div.full", unit).attr('data-code');
            if ( code !== undefined ) {
                console.log(code);
                models.get( api.boards + '/' + code, function( board ){
                    if ( board.using_status > 0 ) {
                        models.get( api.apply + '/' + board.using_status, function( record ){
                            models.get( api.users + '/' + record.user_id, function( user ){
                                events.boardPop(board, record, user);
                            });
                        });
                    }
                });

            }

        });
    }

    events.boardPop = function(board, record, user) {
        var
        options = {},
        content = '',
        target  = $('#tab_map a div[data-code="' + board.code + '"]');

        if ( target.attr('aria-describedby') == undefined ) {
            content = '' +
                'User: ' + user.title + ' (' + user.username + ')<br/>' +
                'Type: ' + record.event_type + '<br/>' +
                'Date: [ ' + record.post_from + ' ] - [ ' + record.post_end  + ' ]';

            options = {
                trigger: 'hover',
                placement: 'top',
                html: true,
                title: record.event_name,
                content: content,
                template: views.getPopverTemp()
            };

            target.popover(options);
        };
    }

    events.init = function() {
        controllers.listener();
        models.records(events.records);
        models.boards(events.boards);
        models.boards(events.map);
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
