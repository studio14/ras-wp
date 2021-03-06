<section id="search">
    <div class="search-bg">
        <div class="container">
        <div class="search-container inline flex justify-center items-center content-center">
            <form action="{{ esc_url( home_url( '/' ) ) }}" role="search" method="get" class="search-form">
            <input type="search" class="search-field search-text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search through the Royal African Society Website'" placeholder="{!! esc_attr_x( 'Search through the Royal African Society Website', 'placeholder' ) !!}" value="{{ get_search_query() }}" name="s" />
            <button  type="submit" class="search-submit btn-search " value="{{ esc_attr_x( 'Search', 'submit button' ) }}" type="submit" class="btn-search">Search </button>
            </form>
        </div>
        </div>
    </div>
</section>