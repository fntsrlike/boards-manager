$( function(){

    // Actions after login
    events.login = function( response ) {
        if ( response.success == true ) {
            $( '#modal_login form' ).trigger( 'reset' );
            $( '#modal_login' ).modal( 'hide' );
            views.updateTarget( 'navigation' );
        }
    };

    // Actions after register
    events.createUsers = function( response ) {
        if ( response.success == true ) {
            $( '#modal_register form' ).trigger( 'reset' );
            $( '#modal_register' ).modal( 'hide' );
            views.updateTarget( 'navigation' );
        }
    };

    // Actions after application
    events.createRecords = function( response ) {
        if ( response.success == true ) {
            $( '#tab_apply form' ).trigger( 'reset' );
            $( 'ul.nav a[href="#tab_map"]' ).tab( 'show' );

            // Todo: Use models instead refresh.
            views.updateTarget( 'map' );
            views.updateTarget( 'boards' );
            views.updateTarget( 'records' );
            models.readBoards( events.renderMap );
        }
    };

    // Create Records Table
    events.renderRecordsTable = function( response ) {
        var records;

        records = response.map( function( record ) {
            var t_today, t_from, t_end, tr_class;

            t_today  = new Date().getTime();
            t_from   = new Date( record.post_from ).getTime();
            t_end    = new Date( record.post_end ).getTime();
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

    // Create Boards Table
    events.renderBoardsTable = function( response ) {
        var boards;

        boards = response.map( function( board ) {
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

        $( '#tab_boards table tbody' ).html( boards );
    }

    // Render status of units of map.
    events.renderMap = function( response ) {
        $( '#tab_map a div' ).popover( 'destroy' );
        $( '#tab_map a div' ).removeClass( 'empty full' )

        response.map( function( board ) {
            var target;

            target = $( '#map-nchu a div[data-code="' + board.code + '"' );

            target.toggleClass( 'full', board.using_status );
            target.toggleClass( 'empty', !board.using_status );
        });

        events.renderMapPopover();
        listener.units();
    }

    // Render popover of units of map
    events.renderMapPopover = function() {
        var code_list, record_list, user_list;

        code_list   = '';
        record_list = '';
        user_list   = '';

        $( '#tab_map a div.full' ).each( function() {
            var code;

            code = $( this ).attr( 'data-code' );
            if ( code !== undefined ) {
                code_list = code_list + code + ',';
            }
        });

        from = $( '#map_date_form input[name="begin_date"]' ).val(),
        end  = $( '#map_date_form input[name="end_date"]' ).val(),
        url  = api.boards + '?list=' + code_list + '&from=' + from + '&end=' + end;

        models.get( url, function( boards ){

            boards.map( function( board ) {
                record_list += board.using_status + ',';
            });

            models.get( api.records + '?list=' + record_list, function( records ){
                records.map( function( record ) {
                    user_list += record.user_id + ',';
                });

                models.get( api.users + '?list=' + user_list, function( users ){
                    records.map( function( record, key ) {
                        users.map( function( user ) {
                            if ( record.user_id == user.id ) {
                                events.renderBoardPopover( boards[key], records[key], user );
                            }
                        });
                    });
                });
            });
        });
    }

    // Render popover of unit
    events.renderBoardPopover = function( board, record, user ) {
        var options, content, target;

        options = {},
        content = '',
        target  = $( '#tab_map a div[data-code="' + board.code + '"]' );

        if ( target.attr( 'aria-describedby' ) == undefined ) {
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

            target.popover( options );
        };
    }

    // Render sorting feature of tables
    events.renderTableSort = function() {
        var table;

        table = $( 'table' ).stupidtable({
            'date' : function( a, b ){
                var
                a_date = new Date( a ).getTime(),
                b_date = new Date( b ).getTime();

                return a_date - b_date;
            }
        });

        table.bind( 'aftertablesort', function( event, data ) {
            var th, arrow;

            th = $( this ).find( 'th' );
            th.find( '.arrow' ).remove();
            arrow = data.direction === 'asc' ? '↑' : '↓';
            th.eq( data.column ).append( '<span class="arrow">' + arrow + '</span>' );
        });
    }

    // Render map with arguments
    events.updateMap = function( form ) {
        var from, end, url;

        from = $( 'input[name="begin_date"]' , form ).val();
        end = $( 'input[name="end_date"]' , form ).val();
        url = api.boards + '?from=' + from + '&end=' + end;

        models.get( url, events.renderMap );
    }

    // Render records' table with arguments
    events.updateRecords = function( form ) {
        var args, from, end, code;

        args = {};
        from = $( 'input[name="begin_date"]' , form ).val();
        end  = $( 'input[name="end_date"]' , form ).val();
        code = $( 'select[name="code"]' , form ).val();

        if ( from != '' ){
            args.from = from;
        }
        if ( end != '' ){
            args.end = end;
        }
        if ( code != 'all' ) {
            args.board_list = code
        }

        $( '#tab_records table tbody' ).html( '' );
        models.readRecords( events.renderRecordsTable, args );
    }

    // Render boards' table with arguments
    events.updateBoards = function( form ) {
        var args, from, end;

        args = {};
        from = $( 'input[name="begin_date"]' , form ).val();
        end  = $( 'input[name="end_date"]' , form ).val();

        if ( from != '' ){
            args.from = from;
        }
        if ( end != '' ){
            args.end = end;
        }

        $( '#tab_boards table tbody' ).html( '' );

        models.readBoards( events.renderBoardsTable, args );
    }

    // Response events when we click unit
    events.unitClicked = function( unit ) {
        var args;

        if ( $( 'ul.nav a[href="#tab_apply"]' ).length <= 0 ) {
            alert( lang.map.unit.need_login );
            return;
        }

        if ( $( unit ).hasClass( 'full' ) ) {
            alert( lang.map.unit.applied )
            return;
        }

        args = {
            code : $( unit ).attr( 'data-code' ),
            from : $( '#map_date_form input[name="begin_date"]' ).val(),
            end  : $( '#map_date_form input[name="end_date"]' ).val()
        }

        events.fillForm( args );
        $( 'ul.nav a[href="#tab_apply"]' ).tab( 'show' );
        window.location.hash = 'tab_apply';
    }

    // Render form of application with data of clicked-unit
    events.fillForm = function( args ) {
        var form;

        form = $( '#tab_apply form' );

        $( 'select[name="code"]', form ).val( args.code );
        $( 'input[name="from"]', form ).val( args.from );
        $( 'input[name="end"]' , form ).val( args.end );
    }

});
