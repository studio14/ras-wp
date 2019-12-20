<div class="top-header custom-border">
    <div class="container" style="max-width: 1160px;">
        <div class="top-header--container">
            <?php if(has_nav_menu('top_navigation')): ?>
              <?php echo wp_nav_menu(['theme_location' => 'top_navigation', 'menu_class' => '']); ?>

            <?php endif; ?>
        </div>
    </div>
</div>