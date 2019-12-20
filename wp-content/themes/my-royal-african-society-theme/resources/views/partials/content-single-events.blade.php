<section id="events-details">
        <div class="container flex flex-col">
            <div class="events-title-bg">
                <div class="title">
                    <h2>{!! get_the_title() !!}</h2>
                    <hr/>
                </div>
            </div>
            <div class="events-info-details-bg w:full">
                <div class="events-info-bg flex justify-left">
                    <div class="events-schedule mr-0 lg:mr-77 pt-55">
                        <div class="events-when-bg">
                            <div class="events-when">
                                <h2 class="events-title">When:</h2>
                            </div>
                            <div class="events-when-info">
                                <p class="events-date"><?= get_field('events_date') ?></p> 
                                <p class="events-time"><?= get_field('events_starting_time'); ?> - <?= get_field('events_ending_time'); ?> </p>
                            </div>
                            <div class="events-calender">
                                <a href="<?= get_field('add_to_calender_link'); ?>" class="calender-p" target="_blank">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5871 2.12807H11.1775V1.89549C11.1775 1.43241 10.7727 1.05573 10.2753 1.05573C9.7763 1.05573 9.37047 1.43257 9.37047 1.89549V2.12807H7.82442V1.89549C7.82442 1.43241 7.41911 1.05573 6.92101 1.05573C6.42221 1.05573 6.01638 1.43257 6.01638 1.89549V2.12807H4.47033V1.89549C4.47033 1.43241 4.06502 1.05573 3.56692 1.05573C3.06864 1.05573 2.66333 1.43257 2.66333 1.89549V2.12807H1.25871C1.11573 2.12807 1 2.23579 1 2.36851V12.8971C1 13.0298 1.11573 13.1375 1.25871 13.1375H12.5873C12.7302 13.1375 12.846 13.0298 12.846 12.8971V2.36851C12.8458 2.23579 12.7301 2.12807 12.5871 2.12807ZM9.88772 1.89549C9.88772 1.69769 10.0616 1.5366 10.2751 1.5366C10.4872 1.5366 10.6599 1.69769 10.6599 1.89549V3.01593C10.6599 3.21389 10.4872 3.37498 10.2751 3.37498C10.0616 3.37498 9.88772 3.21389 9.88772 3.01593V1.89549ZM6.5338 1.89549C6.5338 1.69769 6.70748 1.5366 6.92101 1.5366C7.13384 1.5366 7.307 1.69769 7.307 1.89549V3.01593C7.307 3.21389 7.13384 3.37498 6.92101 3.37498C6.70748 3.37498 6.5338 3.21389 6.5338 3.01593V1.89549ZM3.18075 1.89549C3.18075 1.69769 3.35391 1.5366 3.56692 1.5366C3.77975 1.5366 3.95291 1.69769 3.95291 1.89549V3.01593C3.95291 3.21389 3.77975 3.37498 3.56692 3.37498C3.35409 3.37498 3.18075 3.21389 3.18075 3.01593V1.89549ZM12.3284 12.6565H1.51725V2.60879H2.66316V3.01577C2.66316 3.47901 3.06847 3.85569 3.56675 3.85569C4.06485 3.85569 4.47016 3.47885 4.47016 3.01577V2.60879H6.01621V3.01577C6.01621 3.47901 6.42204 3.85569 6.92083 3.85569C7.41894 3.85569 7.82425 3.47885 7.82425 3.01577V2.60879H9.3703V3.01577C9.3703 3.47901 9.7763 3.85569 10.2751 3.85569C10.7727 3.85569 11.1773 3.47885 11.1773 3.01577V2.60879H12.3282V12.6565H12.3284Z" fill="#EF6D1D" stroke="#EF6D1D" stroke-width="0.5"/>
                                    <path d="M10.0586 6.07928C9.94525 5.99865 9.78278 6.01837 9.69586 6.12416L6.46561 10.0471L4.3266 7.60268C4.23657 7.49962 4.07341 7.48407 3.96268 7.56774C3.85178 7.65157 3.83505 7.80305 3.92525 7.90595L6.27106 10.587C6.32021 10.6432 6.39386 10.6758 6.47182 10.6758C6.47303 10.6758 6.4744 10.6758 6.47561 10.6758C6.55478 10.6747 6.62911 10.6399 6.67723 10.5814L10.1069 6.41637C10.1936 6.31106 10.1721 6.16007 10.0586 6.07928Z" fill="#EF6D1D" stroke="#EF6D1D" stroke-width="0.5"/>
                                </svg>       
                                &nbsp; Add to Calender </a>
                            </div>
                        </div>
                        <div class="events-when-bg">
                                <div class="events-when">
                                    <h2 class="events-title">Location:</h2>
                                </div>
                                <div class="events-when-info max-w-208">
                                    <p class="events-date">
                                        <?=  get_field('events_location'); ?>    
                                    </p> 
                                </div>
                        </div>
                        <div class="events-when-bg">
                                <div class="events-when">
                                    <h2 class="events-title">Admission:</h2>
                                </div>
                                <div class="events-when-info max-w-208">
                                    <p class="events-date">£<?= get_field('events_ticket_price'); ?></p> 
                                </div>
                        </div>
                        <div class="events-button-link">
                            <a href="<?= get_field('events_link'); ?>" class="btn btn-primary text-white" target="_blank"> Register 
                                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1L4 4.37037L1 8" stroke="white" stroke-width="2"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="events-info-breakdown w:full">
                        <div class="events-featured-image">
                            <img src="{{ get_the_post_thumbnail_url() }}" alt="Featured Image For {!! get_the_title() !!}" />
                        </div>
                        <div class="events-contents-bg">
                            <div class="events-contents">
                                    <?= the_content(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="navigations flex justify-center items-center contents-center text-center">
                    <div>
                        <a href="javascript:void(0);" onclick="window.history.back()"> 
                            <svg  class="svg" width="6" height="11" viewBox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.8583 0L6 1.2925L2.2915 5.5L6 9.7075L4.8583 11L0 5.5L4.8583 0Z" fill="#EF6D1D"/>
                            </svg>        
                        Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>