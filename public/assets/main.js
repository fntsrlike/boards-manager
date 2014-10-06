var host        = 'http://localhost:9527',
    models      = {},
    views       = {},
    controllers = {},
    events      = {},
    api         = {};

window.alert = sweetAlert;

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
            var
            t_today  = new Date().getTime(),
            t_from   = new Date(record.post_from).getTime(),
            t_end    = new Date(record.post_end).getTime(),
            tr_class = '';

            if ( t_end < t_today ) {
                tr_class = 'text-muted';
            } else if ( t_from < t_today ) {
                tr_class = 'text-danger';
            } else {
                tr_class = 'text-primary';
            }

            return '<tr class="' + tr_class + '">' +
                '<td>' + record.id + '</td>' +
                '<td>' + record.user_title + ' (' + record.username + ')</td>' +
                '<td>' + record.event_name + '</td>' +
                '<td>' + record.event_type_name + '</td>' +
                '<td>' + record.board_code + '</td>' +
                '<td>' + record.post_from + '</td>' +
                '<td>' + record.post_end + '</td>' +
                '<td>' + record.created_at + '</td>' +
                '</tr>';
        }).join();

        $( '#tab_records table tbody' ).html( records );
    }

    events.boards = function( response ) {
        var boards = response.map( function( board ) {
            var status, details, tr_class;

            status = board.using_status ? 'Using (' + board.using_status + ')' : 'Empty';
            details = board.using_status ? board.using_status : '';
            tr_class = board.using_status ? 'text-danger' : 'text-primary';

            return '<tr class="' + tr_class + '">' +
                '<td>' + board.code + '</td>' +
                '<td>' + board.type + '</td>' +
                '<td>' + board.description + '</td>' +
                '<td>' + status + '</td>' +
                '</tr>';
        }).join();

        $( '#tab_list table tbody' ).html( boards );
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
        var
        code_list   = '',
        record_list = '',
        user_list   = '';

        $( "#tab_map a div.full").each( function() {
            var code = $(this).attr('data-code');
            if ( code !== undefined ) {
                code_list = code_list + code + ',';
            }
        });

        from = $( '#map_date_form input[name="begin_date"]' ).val(),
        end = $( '#map_date_form input[name="end_date"]' ).val(),
        url = api.boards + '?list=' + code_list + '&from=' + from + '&end=' + end;

        models.get( url, function( boards ){

            boards.map( function( board ) {
                record_list += board.using_status + ',';
            });

            models.get( api.apply + '?list=' + record_list, function( records ){
                records.map( function( record ) {
                    user_list += record.user_id + ',';
                });

                models.get( api.users + '?list=' + user_list, function( users ){
                    records.map( function( record, key ) {
                        users.map( function( user ) {
                            if ( record.user_id == user.id ) {
                                events.boardPop(boards[key], records[key], user);
                            }
                        });
                    });
                });
            });
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

    events.url = function() {
        var hash = window.location.hash;
        hash && $( 'ul.nav a[href="' + hash + '"]' ).tab( 'show' );
        $( '.navbar-nav a' ).click( function ( event ) {
            var scrollmem;

            $( this ).tab( 'show' );
            scrollmem = $( 'body' ).scrollTop();
            window.location.hash = this.hash;
            $( 'html,body' ).scrollTop( scrollmem );
        });
    }

    events.tablesort = function() {
        var table;

        table = $( 'table' ).stupidtable({
            "date" : function( a, b ){
                var
                a_date = new Date( a ).getTime(),
                b_date = new Date( b ).getTime();

                return a_date - b_date;
            }
        });

        table.bind('aftertablesort', function (event, data) {
            var th, arrow;

            th = $(this).find("th");
            th.find(".arrow").remove();
            arrow = data.direction === "asc" ? "↑" : "↓";
            th.eq(data.column).append('<span class="arrow">' + arrow +'</span>');
        });
    }


    events.applyForm = function( args ) {
        console.log( args );
        var form = $( '#tab_apply form' );

        $( 'select[name="code"]', form ).val( args.code );
        $( 'input[name="from"]', form ).val( args.from );
        $( 'input[name="end"]' , form ).val( args.end );

    }

    events.init = function() {
        controllers.listener();
        models.records(events.records);
        models.boards(events.boards);
        models.boards(events.map);
        events.url();
        events.tablesort();

        $('*[data-toggle="tooltip"]').tooltip({delay: { "show": 300, "hide": 100 }});
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

        $( "#tab_list form" ).submit( function( event ){
            event.preventDefault();
            var
            from = $( 'input[name="begin_date"]' , this ).val(),
            end = $( 'input[name="end_date"]' , this ).val(),
            url = api.boards + '?from=' + from + '&end=' + end;
            $( '#tab_list table tbody' ).html('');

            models.get( url, events.boards );
        });

        $( '#map_date_form' ).submit( function( event ){
            event.preventDefault();
            var
            from = $( 'input[name="begin_date"]' , this ).val(),
            end = $( 'input[name="end_date"]' , this ).val(),
            url = api.boards + '?from=' + from + '&end=' + end;

            $( '#tab_map a div' ).popover( 'destroy' );
            $( '#tab_map a div ').removeClass( "empty full" )
            models.get( url, events.map );
        })

        $( '#records_form' ).submit( function( event ){
            event.preventDefault();
            console.log('click');
            var
            params = {};
            from = $( 'input[name="begin_date"]' , this ).val(),
            end  = $( 'input[name="end_date"]' , this ).val(),
            code = $( 'select[name="code"]' , this ).val(),
            url = api.apply;


            if ( from != '' ){
                params.from = from;
            }
            if ( end != '' ){
                params.end = end;
            }
            if ( code != 'all' ) {
                params.board_list = code
            }
            url += '?' + jQuery.param( params );
            console.log(url);

            $( '#tab_records table tbody' ).html('');
            models.get( url, events.records );
        })

        $( '.unit' ).click( function( event ) {
            event.preventDefault();
            var args;

            if ( $( this ).hasClass('empty') ) {
                if ( 0 < $( 'ul.nav a[href="#tab_apply"]' ).length ) {
                    events.applyForm( args = {
                        code : $( this ).attr( 'data-code' ),
                        from : $( '#map_date_form input[name="begin_date"]' ).val(),
                        end  : $( '#map_date_form input[name="end_date"]' ).val()
                    });
                    $( 'ul.nav a[href="#tab_apply"]' ).tab( 'show' );
                    window.location.hash = 'tab_apply';
                }
                else {
                    alert( 'You should login before apply!');
                }
            }
            else {
                alert( 'This board is applied.');
            }
        });
    };

    events.init();

});