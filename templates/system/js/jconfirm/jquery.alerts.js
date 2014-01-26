// jQuery Alert Dialogs Plugin
//
// Version 1.1
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 14 May 2009
//
// Visit http://abeautifulsite.net/notebook/87 for more information
//
// Usage:
//                jAlert( message, [title, callback] )
//                jConfirm( message, [title, callback] )
//                jPrompt( message, [value, title, callback] )
//
// History:
//
//                1.00 - Released (29 December 2008)
//
//                1.01 - Fixed bug where unbinding would destroy all resize events
//
// License:
//
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC.
//
(function(jQuery)
{
    jQuery.alerts =
    {
        // These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time

        verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
        horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
        repositionOnResize: true,           // re-centers the dialog on window resize
        overlayOpacity: .01,                // transparency level of overlay
        overlayColor: '#FFF',               // base color of overlay
        draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
        okButton: '&nbsp;OK&nbsp;',         // text for the OK button
        cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
        dialogClass: null,                  // if specified, this class will be applied to all dialogs

        // Public methods

        alert: function(message, title, callback)
        {
            if( title == null )
                title = 'Alert';
            jQuery.alerts._show(title, message, null, 'alert', function(result)
            {
                if( callback )
                    callback(result);
            });
        },

        confirm: function(message, title, callback)
        {
            if( title == null )
                title = 'Confirm';
            jQuery.alerts._show(title, message, null, 'confirm', function(result)
            {
                if( callback )
                    callback(result);
            });
        },

        prompt: function(message, value, title, callback)
        {
            if( title == null )
                title = 'Prompt';
            jQuery.alerts._show(title, message, value, 'prompt', function(result)
            {
                if( callback )
                    callback(result);
            });
        },

        info: function(message, title, callback)
        {
            if( title == null )
                title = 'Info';
            jQuery.alerts._show(title, message, null, 'info', function(result)
            {
                if( callback )
                    callback(result);
            });
        },

        // Private methods

        _show: function(title, msg, value, type, callback)
        {
            jQuery.alerts._hide();
            jQuery.alerts._overlay('show');

            switch( type )
            {
                case 'info':
                    jQuery("BODY").append(
                      '<div id="popup_container">' +
                        '<a id="popup_close">Закрыть &times;</a>' +
                        '<div id="popup_cont_inner">' +
                            '<div id="popup_title"></div>' +
                            '<div id="popup_content">' +
                                '<div id="popup_message"></div>' +
                            '</div>' +
                        '</div>' +
                      '</div>');
                    break;

                default:
                    jQuery("BODY").append(
                      '<div id="popup_container">' +
                        '<h1 id="popup_title"></h1>' +
                        '<div id="popup_content">' +
                            '<div id="popup_message"></div>' +
                        '</div>' +
                      '</div>');
                    break;
            }

            if( jQuery.alerts.dialogClass )
                jQuery("#popup_container").addClass(jQuery.alerts.dialogClass);

            // IE6 Fix
            //var pos = (jQuery.browser.msie && parseInt(jQuery.browser.version) <= 6 ) ? 'absolute' : 'fixed';
            var pos = 'fixed';

            jQuery("#popup_container").css({
                position: pos,
                zIndex: 99999,
                padding: 0,
                margin: 0
            });

            jQuery("#popup_title").text(title);
            jQuery("#popup_content").addClass(type);
            jQuery("#popup_message").text(msg);
            jQuery("#popup_message").html( jQuery("#popup_message").text().replace(/\n/g, '<br />') );

            jQuery("#popup_container").css({
                minWidth: jQuery("#popup_container").outerWidth(),
                maxWidth: jQuery("#popup_container").outerWidth()
            });

            jQuery.alerts._reposition();
            jQuery.alerts._maintainPosition(true);

            switch( type )
            {
                case 'info':
                    jQuery("#popup_close").click( function() {
                        jQuery.alerts._hide();
                        callback(true);
                    });
                    jQuery("#popup_close").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 )
                            jQuery("#popup_close").trigger('click');
                    });
                    setTimeout( function()
                    {
                        jQuery("#popup_close").trigger('click');
                    }, 3000);
                    break;

                case 'alert':
                    jQuery("#popup_message").after('<div id="popup_panel"><input type="button" value="' + jQuery.alerts.okButton + '" id="popup_ok" /></div>');
                    jQuery("#popup_ok").click( function() {
                        jQuery.alerts._hide();
                        callback(true);
                    });
                    jQuery("#popup_ok").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 )
                            jQuery("#popup_ok").trigger('click');
                    });
                    break;
                    
                case 'confirm':
                    jQuery("#popup_message").after('<div id="popup_panel"><input type="button" value="' + jQuery.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + jQuery.alerts.cancelButton + '" id="popup_cancel" /></div>');
                    jQuery("#popup_ok").click( function() {
                        jQuery.alerts._hide();
                        if( callback )
                            callback(true);
                        });
                    jQuery("#popup_cancel").click( function() {
                        jQuery.alerts._hide();
                        if( callback )
                            callback(false);
                    });
                    jQuery("#popup_ok").focus();
                    jQuery("#popup_ok, #popup_cancel").keypress( function(e) {
                        if( e.keyCode == 13 )
                            jQuery("#popup_ok").trigger('click');
                        if( e.keyCode == 27 )
                            jQuery("#popup_cancel").trigger('click');
                    });
                    break;

                case 'prompt':
                    jQuery("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + jQuery.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + jQuery.alerts.cancelButton + '" id="popup_cancel" /></div>');
                    jQuery("#popup_prompt").width( jQuery("#popup_message").width() );
                    jQuery("#popup_ok").click( function() {
                        var val = jQuery("#popup_prompt").val();
                        jQuery.alerts._hide();
                        if( callback )
                            callback( val );
                    });
                    jQuery("#popup_cancel").click( function() {
                        jQuery.alerts._hide();
                        if( callback )
                            callback( null );
                    });
                    jQuery("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
                        if( e.keyCode == 13 )
                            jQuery("#popup_ok").trigger('click');
                        if( e.keyCode == 27 )
                            jQuery("#popup_cancel").trigger('click');
                    });
                    if( value )
                        jQuery("#popup_prompt").val(value);
                    jQuery("#popup_prompt").focus().select();
                    break;
            }

            // Make draggable
            if( jQuery.alerts.draggable ) {
                try {
                    jQuery("#popup_container").draggable({ handle: jQuery("#popup_title") });
                    jQuery("#popup_title").css({ cursor: 'move' });
                } catch(e) { /* requires jQuery UI draggables */ }
            }
        },

        _hide: function()
        {
            jQuery("#popup_container").remove();
            jQuery.alerts._overlay('hide');
            jQuery.alerts._maintainPosition(false);
        },

        _overlay: function(status)
        {
            switch( status )
            {
                case 'show':
                    jQuery.alerts._overlay('hide');
                    jQuery("BODY").append('<div id="popup_overlay"></div>');
                    jQuery("#popup_overlay").css({
                        position: 'absolute',
                        zIndex: 99998,
                        top: '0px',
                        left: '0px',
                        width: '100%',
                        height: jQuery(document).height(),
                        background: jQuery.alerts.overlayColor,
                        opacity: jQuery.alerts.overlayOpacity
                    });
                    break;

                case 'hide':
                    jQuery("#popup_overlay").remove();
                    break;
            }
        },

        _reposition: function()
        {
            var top = ((jQuery(window).height() / 2) - (jQuery("#popup_container").outerHeight() / 2)) + jQuery.alerts.verticalOffset;
            var left = ((jQuery(window).width() / 2) - (jQuery("#popup_container").outerWidth() / 2)) + jQuery.alerts.horizontalOffset;
            if( top < 0 )
                top = 0;
            if( left < 0 )
                left = 0;

            // IE6 fix
            //if( jQuery.browser.msie && parseInt(jQuery.browser.version) <= 6 ) top = top + jQuery(window).scrollTop();

            jQuery("#popup_container").css({
                top: top + 'px',
                left: left + 'px'
            });
            jQuery("#popup_overlay").height( jQuery(document).height() );
        },

        _maintainPosition: function(status)
        {
            if( jQuery.alerts.repositionOnResize )
            {
                switch(status)
                {
                    case true:
                        jQuery(window).bind('resize', jQuery.alerts._reposition);
                        break;
                    case false:
                        jQuery(window).unbind('resize', jQuery.alerts._reposition);
                        break;
                }
            }
        }
    }

    // Shortuct functions
    jAlert = function(message, title, callback)
    {
        jQuery.alerts.alert(message, title, callback);
    }
    jConfirm = function(message, title, callback)
    {
        jQuery.alerts.confirm(message, title, callback);
    };
    jPrompt = function(message, value, title, callback)
    {
        jQuery.alerts.prompt(message, value, title, callback);
    };
    jInfo = function(message, title, callback)
    {
        jQuery.alerts.info(message, title, callback);
    }

})(jQuery);