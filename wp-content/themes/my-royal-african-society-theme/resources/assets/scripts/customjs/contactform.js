document.addEventListener( 'wpcf7submit', function( event ) {
    const inputs = event.detail.inputs;
    
    for ( var i = 0; i < inputs.length; i++ ) {
        var element = document.getElementById(inputs[i].name);
        var checkthrough = element.getAttribute('aria-required');
        if (checkthrough) {
            element.classList.add('error');
        }
    }
}, false );
