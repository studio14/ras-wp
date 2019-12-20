<?php $__env->startSection('content'); ?>
    <section id="events">
        <div class="container events-container">
            <div class="events-title-bg flex text-left justify-left">
                <div class="title">
                    <h2><?= $page_title; ?></h2>
                    <hr/>
                </div>
            </div>
            <div class="events-desc-bg flex text-left justify-left">
                <div class="desc">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                    the_content();
                    endwhile; endif; ?>
                </div>
            </div>
            <div class="events-content">
                <div class="events-filter-bg">
                    <div class="events-filter flex flex-wrap justify-between align-center items-center">
                        <?php
                            $args = array('post_type' => 'events_manager');
                            $query = new WP_Query($args);
                        ?>
                        <?php $args = array(
                            'type'            => 'monthly',
                            'limit'           => '',
                            'format'          => 'custom', 
                            'before'          => '',
                            'after'           => '',
                            'show_post_count' => 1,
                            'echo'            => 1,
                            'order'           => 'DESC',
                            'post_type'     => 'events_manager'
                        );
                         ?>
                        <div class="events-filter-section-1 inline mb-30 flex flex-row justify-between">
                            <label for="show_input">Show</label>
                            <select name="show_all" id="show_input" onchange="loadType(this.value, 'category', '<?php if(isset($_GET[\'date\']) && $_GET[\'date\'] != \'\') echo \'date=\'.$_GET[\'date\'] ?>);");">
                                <option value=""><?php echo esc_attr( __( 'All' ) ); ?> </option>
                                <?php 
                                $events_categories = get_terms(array('taxonomy' => 'events_category', 'parent' => 0, 'hide_empty' => true ));
                                foreach ($events_categories as $events_category) {
                                ?>
                                <option value="<?= $events_category->slug ?>" <?php if(isset($_GET['category']) && $events_category->slug == $_GET['category'] ) echo 'selected' ?> ><?= $events_category->name ?></option>
                                <?php } ?>
                            </select>
                           <label for="dateFrom">From</label>
                           <?php 
                               
                           ?>
                           <select name="show_from" id="dateFrom" onchange="loadType(this.value, 'date', '<?php if(isset($_GET[\'category\']) && $_GET[\'category\'] != \'\') echo \'category=\'.$_GET[\'category\'] ?>);">
                                <option value=""><?php echo esc_attr( __( 'All' ) ); ?> </option>
                                <?php wp_get_archives( $args ); ?>
                            </select>
                        </div>
                        <div class="events-filter-section-2  mb-30 inline flex flex-row justify-between">
                            <div class="grid grid_sort inline flex flex-row justify-center items-center active" id="grid">
                                <a href="<?php echo get_page_link('1054'); ?>" class="inline flex flex-row justify-center items-center">
                                    <svg width="23" height="20" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.31204 0H1.43735C0.643213 0 0 0.678115 0 1.51365V4.54095C0 5.37724 0.643213 6.0546 1.43735 6.0546H4.31204C5.10618 6.0546 5.74939 5.37724 5.74939 4.54095V1.51365C5.74939 0.678115 5.10618 0 4.31204 0ZM4.31204 4.54095H1.43735V1.51365H4.31204V4.54095Z" fill="#333333"/>
                                        <path d="M12.933 0H10.0584C9.26429 0 8.62109 0.678115 8.62109 1.51365V4.54095C8.62109 5.37724 9.26429 6.0546 10.0584 6.0546H12.933C13.7264 6.0546 14.3704 5.37724 14.3704 4.54095V1.51365C14.3704 0.678115 13.7264 0 12.933 0ZM12.933 4.54095H10.0584V1.51365H12.933V4.54095Z" fill="#333333"/>
                                        <path d="M21.562 0H18.6873C17.8932 0 17.25 0.678115 17.25 1.51365V4.54095C17.25 5.37724 17.8932 6.0546 18.6873 6.0546H21.562C22.3555 6.0546 22.9994 5.37724 22.9994 4.54095V1.51365C22.9994 0.678115 22.3555 0 21.562 0ZM21.562 4.54095H18.6873V1.51365H21.562V4.54095Z" fill="#333333"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.31204 9.08191H1.43735C0.643213 9.08191 0 9.75927 0 10.5956V13.6229C0 14.4591 0.643213 15.1365 1.43735 15.1365H4.31204C5.10618 15.1365 5.74939 14.4591 5.74939 13.6229V10.5956C5.74939 9.76002 5.10618 9.08191 4.31204 9.08191ZM4.31204 13.6229H1.43735V10.5956H4.31204V13.6229Z" fill="#333333"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9331 9.08191H10.0584C9.26431 9.08191 8.62109 9.75927 8.62109 10.5956V13.6229C8.62109 14.4591 9.26431 15.1365 10.0584 15.1365H12.9331C13.7266 15.1365 14.3705 14.4591 14.3705 13.6229V10.5956C14.3705 9.76002 13.7266 9.08191 12.9331 9.08191ZM12.9331 13.6229H10.0584V10.5956H12.9331V13.6229Z" fill="#333333"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.562 9.08191H18.6873C17.8932 9.08191 17.25 9.75927 17.25 10.5956V13.6229C17.25 14.4591 17.8932 15.1365 18.6873 15.1365H21.562C22.3555 15.1365 22.9994 14.4591 22.9994 13.6229V10.5956C22.9994 9.76002 22.3555 9.08191 21.562 9.08191ZM21.562 13.6229H18.6873V10.5956H21.562V13.6229Z" fill="#333333"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.31204 18.164H1.43735C0.643213 18.164 0 18.8414 0 19.6776V22.7049C0 23.5412 0.643213 24.2186 1.43735 24.2186H4.31204C5.10618 24.2186 5.74939 23.5412 5.74939 22.7049V19.6776C5.74939 18.8421 5.10618 18.164 4.31204 18.164ZM4.31204 22.7049H1.43735V19.6776H4.31204V22.7049Z" fill="#333333"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9331 18.164H10.0584C9.26431 18.164 8.62109 18.8414 8.62109 19.6776V22.7049C8.62109 23.5412 9.26431 24.2186 10.0584 24.2186H12.9331C13.7266 24.2186 14.3705 23.5412 14.3705 22.7049V19.6776C14.3705 18.8421 13.7266 18.164 12.9331 18.164ZM12.9331 22.7049H10.0584V19.6776H12.9331V22.7049Z" fill="#333333"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.562 18.164H18.6873C17.8932 18.164 17.25 18.8414 17.25 19.6776V22.7049C17.25 23.5412 17.8932 24.2186 18.6873 24.2186H21.562C22.3555 24.2186 22.9994 23.5412 22.9994 22.7049V19.6776C22.9994 18.8421 22.3555 18.164 21.562 18.164ZM21.562 22.7049H18.6873V19.6776H21.562V22.7049Z" fill="#333333"/>
                                    </svg>
                                    <h2>Grid</h2> 
                                </a> 
                            </div>
                            <div class="grid calender_sort inline flex flex-row justify-center items-center" id="calender">
                            <a href="<?php echo get_page_link('9'); ?>" class="inline flex flex-row justify-center items-center">
                                <svg width="23" height="20" viewBox="0 0 23 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.7228 12.1729H19.2018V11.7016C19.2018 10.7633 18.4778 10 17.5882 10C16.6959 10 15.9701 10.7636 15.9701 11.7016V12.1729H13.205V11.7016C13.205 10.7633 12.4802 10 11.5893 10C10.6973 10 9.97149 10.7636 9.97149 11.7016V12.1729H7.20647V11.7016C7.20647 10.7633 6.4816 10 5.59077 10C4.69964 10 3.97476 10.7636 3.97476 11.7016V12.1729H1.46269C1.20698 12.1729 1 12.3912 1 12.6601V33.9943C1 34.2632 1.20698 34.4815 1.46269 34.4815H21.7231C21.9788 34.4815 22.1858 34.2632 22.1858 33.9943V12.6601C22.1855 12.3912 21.9785 12.1729 21.7228 12.1729ZM16.8951 11.7016C16.8951 11.3008 17.2061 10.9744 17.5879 10.9744C17.9673 10.9744 18.2761 11.3008 18.2761 11.7016V13.972C18.2761 14.3731 17.9673 14.6995 17.5879 14.6995C17.2061 14.6995 16.8951 14.3731 16.8951 13.972V11.7016ZM10.8969 11.7016C10.8969 11.3008 11.2075 10.9744 11.5893 10.9744C11.97 10.9744 12.2797 11.3008 12.2797 11.7016V13.972C12.2797 14.3731 11.97 14.6995 11.5893 14.6995C11.2075 14.6995 10.8969 14.3731 10.8969 13.972V11.7016ZM4.90014 11.7016C4.90014 11.3008 5.20983 10.9744 5.59077 10.9744C5.97141 10.9744 6.2811 11.3008 6.2811 11.7016V13.972C6.2811 14.3731 5.97141 14.6995 5.59077 14.6995C5.21014 14.6995 4.90014 14.3731 4.90014 13.972V11.7016ZM21.2601 33.5068H1.92506V13.147H3.97446V13.9717C3.97446 14.9103 4.69933 15.6736 5.59047 15.6736C6.48129 15.6736 7.20617 14.91 7.20617 13.9717V13.147H9.97118V13.9717C9.97118 14.9103 10.697 15.6736 11.589 15.6736C12.4799 15.6736 13.2047 14.91 13.2047 13.9717V13.147H15.9698V13.9717C15.9698 14.9103 16.6959 15.6736 17.5879 15.6736C18.4778 15.6736 19.2015 14.91 19.2015 13.9717V13.147H21.2598V33.5068H21.2601Z" fill="#333333" stroke="#333333" stroke-width="0.5"/>
                                <path d="M17.0338 0.658676C16.8311 0.50061 16.5406 0.539262 16.3851 0.746665L10.608 8.43756L6.78256 3.64529C6.62154 3.44323 6.32974 3.41274 6.13172 3.57678C5.93338 3.74113 5.90346 4.0381 6.06478 4.23984L10.2601 9.49595C10.348 9.60625 10.4797 9.67004 10.6191 9.67004C10.6213 9.67004 10.6238 9.67004 10.6259 9.67004C10.7675 9.66784 10.9004 9.59965 10.9865 9.48495L17.1202 1.31954C17.2753 1.11308 17.2368 0.817057 17.0338 0.658676Z" fill="#333333" stroke="#333333" stroke-width="0.5"/>
                            </svg>
                                <h2>
                                    Calender</h2>
                            </a>
                            </div>
                        </div>
                    </div>

                    <div class="events-show grid">
                        <div class="events-show-grid">
                            <div class="container flex flex-wrap flex-row">
                            <?php
                                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                                $terms = $_GET['category'] ? $_GET['category'] : '';
                                $args = array('post_type' => 'events_manager', 'posts_per_page' => 4, 'paged' => $paged,);
                                $terms = $_GET['category'] ? $_GET['category'] : '';
                                if ( $terms != '' ) {
                                    $args['tax_query'] = [
                                        [
                                            'taxonomy' => 'events_category',
                                            'field' => 'slug',
                                            'terms' => $terms,
                                            'current_category' => 1,
                                        ]
                                    ];
                                }
                                $date = $_GET['date'] ? $_GET['date'] : '';
                                if ( $date != '' ) {
                                    $args['date_query'] = [
                                        [
                                            'year'  => date('Y', $date),
                                            'month' => date('m', $date),
                                        ]
                                    ];
                                }
                                $query = new WP_Query($args);
                                $postCount = 0;
                                while($query -> have_posts()) : $query -> the_post();
                                $postCount++;
                                $events_date = get_post_meta($query->post->ID, 'events_date');
                                $events_link = get_post_meta($query->post->ID, 'events_link');
                                $events_location = get_post_meta($query->post->ID, 'events_location');
                                $events_ticket_price = get_post_meta($query->post->ID, 'events_ticket_price');
                                $events_starting_time = get_post_meta($query->post->ID, 'events_starting_time');
                                $events_ending_time = get_post_meta($query->post->ID, 'events_ending_time');
                                $events_permalink = get_the_permalink($query->post->ID);
                                $terms = wp_get_post_terms( $query->post->ID, 'events_category' );
                                $category = $terms[0]->name;
                                $featuredImageUrl = get_the_post_thumbnail_url($query->post->ID);
                                $membersonly = get_post_meta($query->post->ID, 'members_only');
                                if ($membersonly[0] !== '1') {

                            ?>
                                <?php if ($postCount == 1) { ?>
                                        <div class="item item-1" style="background: url(<?= $featuredImageUrl ?>) no-repeat;width: 100%;max-width: 65.66%;background-size: cover;">
                                            <div class="events-list-item flex">
                                                    <div class="event-single-content flex items-center justify-center contents-center">
                                                        <div class="events-single-header-bg w-full mr-63 ml-63">
                                                            <div class="events-single-header flex justify-between">
                                                                <div class="events-date">
                                                                    <p class="text-white">When- <?= date('d/n/y', time($events_date[0])) ?></p>
                                                                </div>
                                                                <div class="events-cat">
                                                                    <p class="text-white"><?= $category; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="events-title-header-bg mt-16">
                                                                <div class="events-title-header max-w-400.55">
                                                                    <a href="<?= $events_permalink; ?>">
                                                                        <h2 class="text-white">
                                                                            <?= the_title(); ?> 
                                                                        </h2>
                                                                    </a>
                                                                </div>
                                                                <div class="events-description-bg mt-29">
                                                                    <div class="events-description max-w-419.97">
                                                                        <p class="text-white"><?php the_excerpt();?> </p>
                                                                    </div>
                                                                    <div class="event-readmore mt-34">
                                                                        <div class="button"><a href="<?= $events_permalink; ?>" class="text-white flex justify-center items-center align-center">read more </a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                <?php } else  { ?>
                                    <div class="item item-2" style="background: url(<?= $featuredImageUrl ?>) no-repeat;width: 100%;max-width: 32.05%;background-size: cover;">
                                        <div class="events-list-item flex">
                                            <div class="event-single-content flex items-center justify-center contents-center">
                                                    <div class="events-single-header-bg w-full mr-63 ml-63">
                                                        <div class="events-single-header flex justify-between">
                                                            <div class="events-date">
                                                                <p class="text-white">When- <?= date('d/n/y', time($events_date[0])) ?> </p>
                                                            </div>
                                                            <div class="events-cat">
                                                                <p class="text-white"><?= $category; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="events-title-header-bg mt-16">
                                                            <div class="events-title-header max-w-239.22">
                                                                <a href="<?= $events_permalink; ?>">
                                                                    <h2 class="text-white">
                                                                        <?= the_title(); ?>
                                                                    </h2>
                                                                </a>
                                                            </div>
                                                            <div class="events-description-bg mt-29">
                                                                <div class="event-readmore mt-34">
                                                                    <div class="button"><a href="<?= $events_permalink; ?>" class="text-white flex justify-center items-center align-center">read more </a></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                <?php 
                                }      
                                   }
                                    endwhile; ?>
                            </div>
                        </div>
                        {!! App\pagination($query->max_num_pages, 'events') !!}
                </div>
            </div>
        </div>

    </section>
    <script type="text/javascript">
        function loadType(value, type, custom) {
           link = '';
           if (custom != '') 
           {
               link += custom + '&'+ value ?  '?' + type + '=' + value : '';
           }
           else {
               link += value ? '?' + type + '=' + value : './';
           }
            document.location.href = link;
            
        }
    </script>
@endsection
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>