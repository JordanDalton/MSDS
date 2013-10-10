// Get the site url (https compatible)
var siteURL = "https:" == document.location.protocol
            ? "https://" + document.location.host   + '/' 
            : "http://"  + document.location.host   + '/';

// :: AutoComplete Disablement
$( 'input' ).filter( ':text' ).attr( 'autocomplete', 'off' );