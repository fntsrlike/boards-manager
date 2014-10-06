$( function(){

    // Reuseful listener
    listener.units = function() {
        $( '#tab_map .unit' ).click( function( event ) {
            event.preventDefault();
            events.unitClicked( this );
        });
    }

    // Only use once after we loading pages.
    listener.init = function() {
        $( '#modal_login form' ).submit( function( event ){
            event.preventDefault();
            models.login( events.login );
        });

        $( '#modal_register form' ).submit( function( event ){
            event.preventDefault();
            models.createUsers( events.createUsers );
        });

        $( '#tab_apply form' ).submit( function( event ){
            event.preventDefault();
            models.createRecords( events.createRecords );
        });

        $( '#tab_boards form' ).submit( function( event ){
            event.preventDefault();
            events.updateBoards( this );
        });

        $( '#map_date_form' ).submit( function( event ){
            event.preventDefault();
            events.updateMap( this );
        })

        $( '#records_form' ).submit( function( event ){
            event.preventDefault();
            events.updateRecords( this );
        })

        listener.units();
    };

    // Hash url with tab page
    controllers.route = function() {
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

    // Initialization of JavaScript of site.
    controllers.init = function() {
        models.readRecords( events.renderRecordsTable );
        models.readBoards( events.renderBoardsTable );
        models.readBoards( events.renderMap );

        events.renderTableSort();

        lang    = i18n[ config.i18n ];

        $( '*[data-toggle="tooltip"]' ).tooltip( {delay: { 'show': 300, 'hide': 100 }} );

        if ( config.sweetAlert == true ) {
            window.alert = sweetAlert;
        }

        listener.init()
    }

    // Exxcuting
    controllers.route();
    controllers.init();

});
