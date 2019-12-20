<div class="sub-menu-detail-list" id="sub-menu">
        <div class="menu-sticky">
            <div class="scroll-mobile-menu" style="max-width: 1160px; width: 100%;">
            <ul>
                <?php echo App\get_custom_current_submenu(1, 'submenu'); ?>

            </ul>
            </div>
        </div>
    </div>
<script type="text/javascript">
    // $(document).ready( function() {
    //     $.scrollTrack();
    //     window.scrollBy(0, 500);
    
    // });
    
    
    // $.scrollTrack = function(seconds, expiredays) {
    //     if (typeof seconds === 'undefined') seconds = 2;
    //     if (typeof expiredays === 'undefined') expiredays = 1;
    
    //     var position = $.cookie('position');
    //     if (typeof position === 'undefined') {
    //     position = 0;
    //     $.cookie('position',position,{expires: expiredays});
    //     }
    //     window.scrollBy(0, 500);
    
    //     setInterval(function() {
    //     var position = $.cookie('position');
    //     if (this.scrollY == position) return;
    //     position = this.scrollY;
    //     $.cookie('position',position,{expires: expiredays});
    //     },1000*seconds);
    
    //     };
</script>