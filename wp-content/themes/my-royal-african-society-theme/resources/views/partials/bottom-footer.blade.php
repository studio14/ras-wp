<div class="footer-bottom desktop:pl-container responsive-wrap">
  <div class="footer-bottom-background content-between flex-col">
    <div class="flex-col flex md:flex-row"> 
        <p>&copy; <?php echo date('Y'); ?> Royal African Society (RAS) - All Right Reserved.
        </p>
        <div class="bottom-fotter-link--bg">
            @if (has_nav_menu('bottom_navigation'))
              {!! wp_nav_menu(['theme_location' => 'bottom_navigation', 'menu_class' => 'bottom-fotter-link mt-5 md:mt-0']) !!}
            @endif
        </div>
    </div>
    <p class="mt-4 credits">
      Designed By  <a href="http://studio14online.co.uk/" target="_bank" class="ml-1"> Studio 14 </a>
    </p>
  </div>
  <p>
      
  </p>
</div>