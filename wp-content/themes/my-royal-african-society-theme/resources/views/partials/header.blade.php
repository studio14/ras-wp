<header class="banner">
    @include('partials.top-header')
  <nav class="mycontainer flex flex-row justify-between items-center mobile-menu-container">
    <div class="mobile-menu-diff container flex" style="max-width: 1160px;width: 100vw;z-index: 999">
    <a href="<?php echo home_url(); ?>" class='site_logo'>
      <img src="<?php bloginfo('template_directory'); ?>/assets/images/logo/logo-<?php if(get_post_type() == 'events' || is_search() || is_category() || is_404() || is_page(['contact-us', 'event', 'terms-of-use', 'events', 'search', 9]) || is_single() || is_page_template(['views/events-details.blade.php', 'views/events-grid.blade.php', 'views/events-calender.blade.php',  'views/search.blade.php', 'views/page-blog.blade.php', 'views/partials/content-search.blade.php', 'views/404.blade.php',  'views/footer-pages.blade.php'])) echo 'dark'; else echo 'white' ?>.png" class="desktop_menu_logo" alt="Royal-African-Society-Logo">
      <img src="<?php bloginfo('template_directory'); ?>/assets/images/logo/logo-white.png" alt="Royal-African-Society-Logo" class='mobile_menu_logo' style='display: none;'>
    </a>
    <div id="menuToggle" class="block laptop-menu:hidden" style="margin-top: -5px;">
        <button id="togglebutton" class="hamburger hamburger--collapse" type="button"
              aria-label="Menu" aria-controls="navigation" aria-expanded="true/false">
        <span class="hamburger-box <?php if(get_post_type() == 'events' || is_search() || is_category() || is_404() || is_page(['contact-us', 'terms-of-use', 'events', 'event', 'search', '9']) || is_single() || is_page_template(['views/events-details.blade.php', 'views/events-grid.blade.php', 'views/events-calender.blade.php',  'views/search.blade.php', 'views/page-blog.blade.php', 'views/partials/content-search.blade.php', 'views/404.blade.php',  'views/footer-pages.blade.php'])) echo 'others'; else echo 'home_mobile_menu' ?>">
          <span class="hamburger-inner"></span>
        </span>
      </button>
        <div id="mySidenav" class="sidenav" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/homebanner.png);background-position: center;background-repeat: no-repeat;">
           <div class="sidenav-bg">
            <div class="top-menu-menu static-mobile">
                @if (has_nav_menu('mobile_navigation'))
                  {!! wp_nav_menu(['theme_location' => 'mobile_navigation', 'menu_class' => $nav. " ", 'items_class' => 'text-black']) !!}
                @endif
              </div>
            </div>
        </div>
      </div>
    <div class="laptop-menu:block hidden nav-primary <?php $nav = ''; if (get_post_type() == 'events' || is_search() || is_category() || is_404() || is_page(['contact-us', 'terms-of-use', 'events', 'event', 'search', 9]) || is_single() || is_page_template(['views/events-details.blade.php', 'views/events-grid.blade.php', 'views/events-calender.blade.php',  'views/search.blade.php', 'views/partials/content-search.blade.php', 'views/404.blade.php',  'views/page-blog.blade.php', 'views/footer-pages.blade.php'])) $nav = 'navitem'; else $nav = 'nav'; ?>">
      <div class="">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => $nav. " ", 'items_class' => 'text-black']) !!}
        @endif
      </div>
    </div>
    </div>
  </nav>
</header>
