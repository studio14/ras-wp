<div class="events-content">
    <div class="container events-filter-bg">
    <div class="events-filter flex justify-between align-center items-center">
      <div class="events-filter-section-1 inline flex flex-row justify-between">
            <label for="show_input">Show</label>
            <select name="show_all" id="show_input">
                <option value="">All </option>
            </select>
           <label for="dateFrom">From</label>
           <select name="show_from" id="dateFrom" onselect="selectMonthYear('3', '2019')">
                <option value="7/2019">July 2019 </option>
                <option value="6/2019">June 2019 </option>
                <option value="5/2019">May 2019 </option>
            </select>
        </div>
    </div>
      <div class="latest-news">
      <div class="">
        <div class="latest-news-container" style="max-width: 100%;">
          <?php if (is_sticky()) { ?>
          <div class="latest-news-featured">
                  <div class="latest-news-featured-bg">
                      <div class="w-full flex flex-row">
                          <div class="">
                              <a href="{{ get_permalink() }}"><img src="{{ get_the_post_thumbnail_url() }}" alt="Royal-African-Societ-Blog_title"></a>
                          </div>
                          <div class="w-1/3 feat_blog_details flex">
                              <div class="text-content-bg flex flex-col">
                                  <div class="date">
                                      <p>{{ the_time('d/n/Y') }}</p>
                                  </div>
                                  <div class="title">
                                      <a href="{{ get_permalink() }}"><h2>{!! App\limit_character(html_entity_decode(get_the_title()), '35') !!}</h2></a>
                                  </div>
                                  <div class="content">
                                      <p>@php the_excerpt() @endphp</p>
                                  </div>
                                  <div class="secondary-button-bg mt-13 w-193.42 h-54 w-full">
                                      <div class="button">
                                        <a href="{{ get_permalink() }}" class="text-secondary flex justify-center items-center align-center">read more 
                                        </a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          <?php } else { ?>
          <div class="news-content flex inline">
            <?php if (is_sticky()) { ?>
            <div class="w-blogitemswidth">
              <div class="news-cotent-bg">
                <div class="news-content-featured-bg">
                  <a href="{{ get_permalink() }}"><img src="{{ get_the_post_thumbnail_url() }}" alt="Royal-African-Societ-Blog_title"></a>
                  <div class="blog-cat-bg">
                    <div class="blog-cat-tag">
                      <p class="blog-text">RAS News</p>
                    </div>
                  </div>
                </div>
                <div class="news-content-info">
                  <div class="news-content-title">
                    <a href="{{ get_permalink() }}">{!! App\limit_character(get_the_title(), '35') !!}</a>
                  </div>
                  <div class="news-content-summary">
                    <p>@php the_excerpt() @endphp</p>
                  </div>
                  <div class="news-read-more flex inline">
                    <p><a href="{{ get_permalink() }}" class="read-more-link">Read more  
                      <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M5.42426 5.42426C5.65858 5.18995 5.65858 4.81005 5.42426 4.57574L1.60589 0.757359C1.37157 0.523045 
                      0.991674 0.523045 0.757359 0.757359C0.523045 0.991674 0.523045 1.37157 0.757359 1.60589L4.15147 5L0.757359 
                      8.39411C0.523045 8.62843 0.523045 9.00833 0.757359 9.24264C0.991674 9.47696 1.37157 9.47696 1.60589 9.24264L5.42426 
                      5.42426ZM4 5.6H5V4.4H4V5.6Z" fill="#123234"/>
                    </svg>
                  </a></p>
                    <p class="date"><span>{{ the_time('d/n/Y') }}</span></p>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>