    //toggle show and hide years
    const action = document.querySelector('.toggle');

    function displayToggle() {
        const index = this.getAttribute('data-columns')
        const element = document.querySelector('.toggle_content'+index);
        element.classList.toggle('hidden');
    }

    action.addEventListener('click', displayToggle, false);

    function goNext() {
        $('html, body').animate({
            scrollTop: $('#our-pillars').offset().top,
        }, 2000); 
    }

    action.addEventListener('click', goNext, false);