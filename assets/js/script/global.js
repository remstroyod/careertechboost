jQuery(function ( $ ) {

    'use strict';

    /******************************************************************
     * Home
     * @type {{init: Global.init, install: Global.install}}
     * @since 1.0
     * @author Alex Cherniy
     */
    var Global = {

        /**
         * Init
         */
        init: function () {

            this.install  = this.install(this)

        },

        /**
         * Install
         */
        install: function () {

            // $(document).on( 'click', '.overlay', this.close_modal_form)

        },

    }

    Global.init()

});
