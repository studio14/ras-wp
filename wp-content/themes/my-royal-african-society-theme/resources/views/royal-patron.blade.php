{{--
  Template Name: Royal Patron Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.header-bg')
  @include('partials.sub-menu')

  <div class="custom-page--content">
    <div class="container" style="max-width: 1160px;padding-left:0px;">
      <div class="custom-page-content">
          @include('partials.mission-page')
        <div class="custom-page--info">
            <div class="summary" style="line-height: 150%; font-size: 16px;">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                the_content();
                endwhile; endif; ?>
            </div>
        </div>
      </div>

      <div class="tiled-image--bg">
          <div class="image-tiled-bg flex inline flex-wrap">
            <div class="w-1/2">
              <div class="image-bg">
                  <?php 
                    if ($group_images['image_one'] != null)
                    {
                  ?>
                  <img src="<?= $group_images['image_one'] ?>" alt="Royal-African-Society-Patron-Images">
                  <?php
                    }
                    if ($group_images['image_two'] != null)
                    {
                    ?>
                  <img src="<?= $group_images['image_two'] ?>" alt="Royal-African-Society-Patron-Images">
                  <?php 
                    }
                    ?>
              </div>
            </div>
            <div class="w-1/2">
              <div class="image-bg">
                  <?php
                    if ($group_images['image_three'] != null)
                    {
                    ?>
                  <img src="<?= $group_images['image_three'] ?>" alt="Royal-African-Society-Patron-Images">
                  <?php 
                    }
                    ?>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection
