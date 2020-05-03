</div>
<footer class="content-info">
  <div class="partners">
    <div class="container xxl:pl-container xxl:pr-container my-partners-container">
      <div class="flex inline partners-bg flex-col xl:flex-row mr-63 pt-12 xl:pt-0 pb-12 xl:pb-0">
        @foreach($get_clients as $client)
        <div class="item-2">
            <a href="<?= $client['client_link']['url'] ?>" target="<?= $client['client_link']['target'] ?>">
              <img class="mr-27" src="<?= $client['client_logo'] ?>" alt="African Affairs">
            </a>
        </div>
        @endforeach
        <!-- <div class="item-1">
          <a href="https://africanarguments.org" target="_blank">
            <img class="-mr-19" src="<?php bloginfo('template_directory'); ?>/assets/images/clients/AfricanArgument.png" alt="African Arguments">
          </a>
        </div>
        <div  class="item-4">
          <a href="http://africawrites.org" target="_blank">
            <img class="" src="<?php bloginfo('template_directory'); ?>/assets/images/clients/AfricaWrites.png" alt="African Writes">
          </a>
        </div>
        <div  class="item-3">
          <a href="http://filmafrica.org" target="_blank">
            <img class="" src="<?php bloginfo('template_directory'); ?>/assets/images/clients/FilmAfrica.png" alt="The Royal African Society">
          </a>
        </div> -->
      </div>
    </div>
  </div>
  <div class="newsletter">
    <div class="container xxl:pl-container xxl:pr-container my-newsletter-container">
      <div class="newsletter-bg">
        <div class="newsletter-title pt-48 mb-30">
          <h2> Newsletter sign-up</h2>
        </div>
        <div class="newsletter-form">
          <?php echo do_shortcode("[mc4wp_form id='986']"); ?>
        </div>
      </div>
    </div>
  </div>
    <?php 
      $footer_contents = $get_footers;
    ?>
  <div class="tell-a-story" style="background-image: url('<?= $footer_contents['big_banner_information']['featured_image'] ?>')">
    <div class="tell-a-story--bg xxl:container">
      <div class="flex h-165.37">
        <h2 class="max-w-447.75"><?= $footer_contents['big_banner_information']['banner_text'] ?></h2>
      </div>
      <a href="<?= $footer_contents['big_banner_information']['banner_button_link'] ?>" class="btn primary-button" target="_blank"><?= $footer_contents['big_banner_information']['banner_button_text'] ?> 
          <svg width="12" height="12" viewBox="0 0 6 9"  style="margin-left: 29px;" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L4 4.37037L1 8" stroke="white" stroke-width="2"/>
          </svg> 
      </a>
    </div>
  </div>
  <div class="container xxl:pl-container xxl:pr-container pl-10p pr-10p xxl:ml-0 mb-97 my-footer-bottom-container">
    <div class="my-footer-bottom-bg">
      <div class="flex mb-4 flex-wrap">
          <div class="w-full xl:w-463-6 xl:mr-69 float-left">
            <div class="content mt-78">
              <div class="title">
                <h2>Our Mission</h2>
              </div>
              <div class="text-content mt-29">
                <p><?= $footer_contents['footer_our_mission_text'] ?></p>
              </div>
            </div>
        </div>
          <div class="w-full xl:w-19-5p float-left">
            <div class="content mt-78">
                <div class="title">
                  <h2>Contact Us</h2>
                </div>
                <div class="text-content mt-29">
                  <p class="mb-5"><span>e-mail</span><br>
                    <?= $footer_contents['contact_information']['email']; ?></p>
                  <p class="mb-5 xl:max-w-176"><span>address</span><br>
                    <?= $footer_contents['contact_information']['address']; ?>
                  </p>
                </div>
              </div>
          </div>
          <div class="w-full xl:w-19-5p float-left">
            <div class="content mt-78">
                <div class="title">
                  <h2>Quick Links</h2>
                </div>
              </div>
              <div class="bottom-fotter-link--bg mt-29">
                  @if (has_nav_menu('footer_widget_navigation'))
                    {!! wp_nav_menu(['theme_location' => 'footer_widget_navigation', 'menu_class' => 'bottom-fotter-link']) !!}
                  @endif
              </div>
          </div>
          <div class="w-full xl:w-13p float-left">
            <div class="content mt-78">
                <div class="title">
                  <h2>Follow Us</h2>
                </div>
                <div class="social-links-bg mt-29 flex-col">
                  <div class="lg:inline xl:flex mb-20 lg:ml-31 ml-0 footer-links">
                    <?php 
                        if ($footer_contents['social_information']['twitter'] !=='') {
                      ?>
                      <a href="<?= $footer_contents['social_information']['twitter'] ?>" class="mr-13" target="_blank" rel="noopener noreferrer">
                        <svg width="34" height="34" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <rect width="44" height="44" fill="url(#pattern0)"/>
                          <defs>
                          <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                          <use xlink:href="#image0" transform="scale(0.0025)"/>
                          </pattern>
                          <image id="image0" width="400" height="400" xlink:href="data:image/png;base64,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"/>
                          </defs>
                          </svg>                                          
                      </a>
                      <?php 
                        }
                        if ($footer_contents['social_information']['facebook'] !== '') {
                          ?>
                          <a href="<?= $footer_contents['social_information']['facebook'] ?>" class="mr-22" target="_blank" rel="noopener noreferrer">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.675 0H1.325C0.593 0 0 0.593 0 1.325V22.676C0 23.407 0.593 24 1.325 24H12.82V14.706H9.692V11.084H12.82V8.413C12.82 5.313 14.713 3.625 17.479 3.625C18.804 3.625 19.942 3.724 20.274 3.768V7.008L18.356 7.009C16.852 7.009 16.561 7.724 16.561 8.772V11.085H20.148L19.681 14.707H16.561V24H22.677C23.407 24 24 23.407 24 22.675V1.325C24 0.593 23.407 0 22.675 0V0Z" fill="white"/>
                                </svg>                      
                          </a>
                      <?php 
                        }
                        if ($footer_contents['social_information']['instagram'] != '') {
                        
                      ?>
                       <a href="<?= $footer_contents['social_information']['instagram'] ?>" class="mr-22" target="_blank" rel="noopener noreferrer">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.163C15.204 2.163 15.584 2.175 16.85 2.233C20.102 2.381 21.621 3.924 21.769 7.152C21.827 8.417 21.838 8.797 21.838 12.001C21.838 15.206 21.826 15.585 21.769 16.85C21.62 20.075 20.105 21.621 16.85 21.769C15.584 21.827 15.206 21.839 12 21.839C8.796 21.839 8.416 21.827 7.151 21.769C3.891 21.62 2.38 20.07 2.232 16.849C2.174 15.584 2.162 15.205 2.162 12C2.162 8.796 2.175 8.417 2.232 7.151C2.381 3.924 3.896 2.38 7.151 2.232C8.417 2.175 8.796 2.163 12 2.163ZM12 0C8.741 0 8.333 0.014 7.053 0.072C2.695 0.272 0.273 2.69 0.073 7.052C0.014 8.333 0 8.741 0 12C0 15.259 0.014 15.668 0.072 16.948C0.272 21.306 2.69 23.728 7.052 23.928C8.333 23.986 8.741 24 12 24C15.259 24 15.668 23.986 16.948 23.928C21.302 23.728 23.73 21.31 23.927 16.948C23.986 15.668 24 15.259 24 12C24 8.741 23.986 8.333 23.928 7.053C23.732 2.699 21.311 0.273 16.949 0.073C15.668 0.014 15.259 0 12 0V0ZM12 5.838C8.597 5.838 5.838 8.597 5.838 12C5.838 15.403 8.597 18.163 12 18.163C15.403 18.163 18.162 15.404 18.162 12C18.162 8.597 15.403 5.838 12 5.838ZM12 16C9.791 16 8 14.21 8 12C8 9.791 9.791 8 12 8C14.209 8 16 9.791 16 12C16 14.21 14.209 16 12 16ZM18.406 4.155C17.61 4.155 16.965 4.8 16.965 5.595C16.965 6.39 17.61 7.035 18.406 7.035C19.201 7.035 19.845 6.39 19.845 5.595C19.845 4.8 19.201 4.155 18.406 4.155Z" fill="white"/>
                          </svg>                      
                        </a>
                      <?php 
                        }
                        
                        ?>
                  </div>
                  <div class="lg:inline xl:flex mb-20 lg:ml-31 ml-0 footer-links">
                    <?php 

                        if ($footer_contents['social_information']['mixcloud']) {
                    ?>
                      <a href="<?= $footer_contents['social_information']['mixcloud'] ?>" class="mr-22" target="_blank" rel="noopener noreferrer">
                          <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0)">
                            <path d="M31.0958 27.0045C30.8907 27.0039 30.6895 26.948 30.5135 26.8425C30.3375 26.737 30.1933 26.586 30.096 26.4053C29.9988 26.2246 29.9522 26.021 29.9611 25.8161C29.97 25.6111 30.0341 25.4123 30.1467 25.2408C31.1922 23.6909 31.7404 21.8677 31.7404 19.9722C31.7404 18.0767 31.1922 16.2534 30.1467 14.7008C30.0637 14.5779 30.0058 14.4398 29.9763 14.2945C29.9468 14.1491 29.9463 13.9994 29.9747 13.8539C30.0031 13.7083 30.06 13.5698 30.142 13.4463C30.224 13.3228 30.3296 13.2166 30.4527 13.1339C30.5756 13.0506 30.7137 12.9923 30.8592 12.9625C31.0047 12.9326 31.1546 12.9317 31.3004 12.9599C31.4462 12.988 31.585 13.0447 31.7089 13.1266C31.8328 13.2085 31.9393 13.314 32.0223 13.4371C33.318 15.3735 34.0065 17.6523 34 19.9821C34.0061 22.3114 33.3175 24.5897 32.0223 26.5257C31.929 26.684 31.7951 26.8146 31.6345 26.904C31.4739 26.9934 31.2923 27.0384 31.1086 27.0343L31.0958 27.0045ZM27.8517 25.1714C27.6264 25.1712 27.4066 25.1025 27.2212 24.9744C27.0978 24.8941 26.9917 24.7899 26.9092 24.6678C26.8268 24.5458 26.7697 24.4084 26.7413 24.2639C26.7129 24.1194 26.7137 23.9707 26.7439 23.8265C26.774 23.6823 26.8328 23.5457 26.9167 23.4246C27.6103 22.411 27.9794 21.2104 27.9749 19.9821C27.9749 18.7709 27.6094 17.5809 26.9167 16.5382C26.5653 16.0282 26.6985 15.3284 27.2212 14.9869C27.744 14.6455 28.4353 14.7744 28.7881 15.3057C29.7279 16.6913 30.2316 18.3263 30.2345 20.0005C30.2345 21.7019 29.7358 23.3155 28.7881 24.6968C28.689 24.8551 28.5508 24.9852 28.3867 25.0745C28.2227 25.1639 28.0384 25.2094 27.8517 25.2068V25.1714ZM22.5675 15.0379C22.3455 12.8252 21.3094 10.7738 19.6602 9.28197C18.011 7.79011 15.8663 6.96414 13.6425 6.96436C11.7717 6.96685 9.94815 7.55265 8.42589 8.6402C6.90362 9.72775 5.75836 11.2629 5.14958 13.0319C2.24967 13.4598 0 15.9644 0 18.9834C0.00374848 20.582 0.641051 22.114 1.77226 23.2436C2.90348 24.3732 4.43635 25.0084 6.035 25.0099H21.488C22.8256 25.0099 24.1086 24.4794 25.0557 23.5347C26.0027 22.5901 26.5365 21.3084 26.5398 19.9708C26.5398 17.5539 24.8398 15.538 22.5661 15.0408V15.0379H22.5675ZM21.488 22.7531H6.03925C5.03925 22.7527 4.08009 22.3564 3.37153 21.6508C2.66296 20.9451 2.26266 19.9876 2.25817 18.9876C2.26042 17.9869 2.66 17.0281 3.36905 16.322C4.0781 15.6158 5.03857 15.2202 6.03925 15.2221C7.04508 15.2221 7.99567 15.6259 8.71108 16.3285C8.8152 16.4341 8.93927 16.5179 9.07607 16.5752C9.21286 16.6324 9.35967 16.6619 9.50796 16.6619C9.65624 16.6619 9.80305 16.6324 9.93985 16.5752C10.0767 16.5179 10.2007 16.4341 10.3048 16.3285C10.7298 15.9021 10.7298 15.1796 10.3048 14.7348C9.53414 13.9709 8.57292 13.4275 7.52108 13.1609C8.05282 11.9892 8.91075 10.9956 9.99229 10.2987C11.0738 9.60177 12.3332 9.23111 13.6198 9.23102C15.3991 9.23476 17.1045 9.94305 18.3629 11.2009C19.6213 12.4588 20.3303 14.1639 20.3348 15.9432C20.3348 16.6685 20.2286 17.3684 19.9948 18.0484C19.9411 18.2186 19.9273 18.399 19.9547 18.5755C19.9821 18.752 20.0498 18.9197 20.1526 19.0657C20.2554 19.2117 20.3906 19.332 20.5475 19.4173C20.7044 19.5025 20.8789 19.5503 21.0573 19.5571C21.2923 19.5573 21.5214 19.4835 21.7121 19.3462C21.9028 19.2089 22.0455 19.015 22.1198 18.7921C22.2686 18.3459 22.3748 17.8996 22.4386 17.4321C22.9616 17.6356 23.4114 17.9916 23.7297 18.4539C24.048 18.9161 24.2201 19.4634 24.2236 20.0246C24.2258 20.7654 23.9339 21.4768 23.4119 22.0025C22.89 22.5282 22.1806 22.8252 21.4398 22.8282L21.488 22.7531Z" fill="white"/>
                            </g>
                            <defs>
                            <clipPath id="clip0">
                            <rect width="34" height="34" fill="white"/>
                            </clipPath>
                            </defs>
                            </svg>
                        </a>
                      <?php 
                        }

                        if ($footer_contents['social_information']['youtube']) {
                        ?>
                      <a href="<?= $footer_contents['social_information']['youtube'] ?>" class="mr-22" target="_blank" rel="noopener noreferrer">
                          <svg width="20" height="24" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.652 0H4.092L5.08 3.702L5.996 0H7.45L5.785 5.505V9.262H4.354V5.505L2.652 0V0ZM9.246 2.373C8.127 2.373 7.385 3.113 7.385 4.208V7.557C7.385 8.761 8.014 9.388 9.246 9.388C10.268 9.388 11.072 8.705 11.072 7.557V4.208C11.072 3.139 10.275 2.373 9.246 2.373ZM9.777 7.5C9.777 7.872 9.587 8.146 9.245 8.146C8.894 8.146 8.691 7.859 8.691 7.5V4.321C8.691 3.947 8.863 3.67 9.22 3.67C9.61 3.67 9.777 3.939 9.777 4.321V7.5ZM14.506 2.43V7.616C14.351 7.81 14.006 8.128 13.759 8.128C13.488 8.128 13.421 7.942 13.421 7.668V2.43H12.151V8.14C12.151 8.815 12.357 9.36 13.038 9.36C13.422 9.36 13.956 9.16 14.506 8.507V9.261H15.776V2.43H14.506ZM16.709 16.288C16.261 16.288 16.168 16.603 16.168 17.051V17.71H17.237V17.05C17.238 16.61 17.145 16.288 16.709 16.288ZM12.006 16.328C11.922 16.371 11.839 16.437 11.756 16.526V20.581C11.855 20.687 11.95 20.763 12.043 20.81C12.24 20.91 12.528 20.917 12.662 20.743C12.732 20.651 12.767 20.502 12.767 20.294V16.935C12.767 16.715 12.724 16.549 12.638 16.435C12.491 16.242 12.218 16.221 12.006 16.328ZM16.833 11.133C14.229 10.956 5.767 10.956 3.167 11.133C0.353 11.325 0.021 13.025 0 17.5C0.021 21.967 0.35 23.675 3.167 23.867C5.767 24.044 14.229 24.044 16.833 23.867C19.647 23.675 19.979 21.974 20 17.5C19.979 13.033 19.65 11.325 16.833 11.133ZM4.509 21.819H3.146V14.279H1.736V12.999H5.918V14.279H4.508V21.819H4.509ZM9.355 21.819H8.145V21.101C7.922 21.366 7.69 21.568 7.449 21.706C6.797 22.08 5.902 22.071 5.902 20.751V15.313H7.111V20.301C7.111 20.563 7.174 20.739 7.433 20.739C7.669 20.739 7.997 20.436 8.144 20.252V15.313H9.354V21.819H9.355ZM14.012 20.471C14.012 21.276 13.711 21.902 12.906 21.902C12.463 21.902 12.094 21.74 11.757 21.319V21.819H10.536V12.999H11.757V15.839C12.03 15.506 12.401 15.231 12.833 15.231C13.719 15.231 14.013 15.98 14.013 16.862V20.471H14.012ZM18.483 18.719H16.169V19.947C16.169 20.435 16.211 20.857 16.697 20.857C17.208 20.857 17.238 20.513 17.238 19.947V19.495H18.483V19.984C18.483 21.237 17.945 21.997 16.67 21.997C15.515 21.997 14.924 21.155 14.924 19.984V17.063C14.924 15.934 15.67 15.149 16.761 15.149C17.922 15.149 18.482 15.887 18.482 17.063V18.719H18.483Z" fill="white"/>
                            </svg>                      
                        </a>
                      <?php 
                        }
                      ?>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  @include('partials.bottom-footer')
    <!-- The Modal -->
  
</footer>
<!-- Get minor updates and patch fixes within a major version -->
<script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15/dist/smooth-scroll.polyfills.min.js"></script>
<script>
  var scroll = new SmoothScroll('a[href*="#"]', {
    speed: 800,
    speedAsDuration: true,
});
var body = new SmoothScroll('body', {
    speed: 500,
    speedAsDuration: true,
});
</script> 
  <!--Modal-->

