$(function(){
    // Response events when we click unit
    events.unitClicked = function( unit ) {
        var args;

        if ( $( unit ).hasClass( 'full' ) ) {
            $( '#modal_record_modify' ).modal( 'show' );
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
    };

    events.updateUsers = function( form ) {
        var args;

        args = {};

        $( '#tab_users table tbody' ).html( '' );

        models.readUsers( events.renderUsersTable, args );
    };

    events.renderUsersTable = function( response ) {
        var users, tr_class;

        tr_class = '';

        users = response.map( function( user ) {

            return '<tr class="' + tr_class + '">' +
                '<td>' + user.id + '</td>' +
                '<td>' + user.username + '(' + user.title + ')' + '</td>' +
                '<td>' + user.phone + '</td>' +
                '<td>' + user.roles + '</td>' +
                '</tr>';
        }).join();

        $( '#tab_users table tbody' ).html( users );

        events.excuteHook( hooks.renderUsersTable );
    };

    controllers.management = function() {

        // Clean older click listener
        $( '#tab_map .unit' ).off( 'click' );

        // Build mangement mod click listener
        listener.units();

        $( '#tab_users form' ).submit( function( event ){
            event.preventDefault();
            events.updateUsers( this );
        });

        hooks.renderBoardsTable.push( function(){
            $( '#tab_boards table tr' ).click( function( event ) {
                event.preventDefault();
                $( '#modal_board_modify' ).modal( 'show' );
            });
        });

        hooks.renderUsersTable.push( function(){
            $( '#tab_users table tbody tr' ).click( function( event ) {
                event.preventDefault();
                $( '#modal_user_modify' ).modal( 'show' );
            });
        });

        hooks.renderRecordsTable.push( function(){
            $( '#tab_records tr' ).click( function( event ) {
                event.preventDefault();
                $( '#modal_record_modify' ).modal( 'show' );
            });
        });

        console.log('Management Mode Loaded!')
    };

    controllers.management();
});
