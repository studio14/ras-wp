<div class="top-header custom-border">
    <div class="container" style="max-width: 1160px;">
        <div class="top-header--container">
            @if (has_nav_menu('top_navigation'))
              {!! wp_nav_menu(['theme_location' => 'top_navigation', 'menu_class' => '']) !!}
            @endif
        </div>
    </div>
</div>