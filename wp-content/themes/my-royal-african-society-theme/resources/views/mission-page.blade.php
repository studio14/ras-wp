{{--
  Template Name: Mission Template
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
          <div class="summary" style="line-height: 24px; font-size: 16px;">
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
              the_content();
              endwhile; endif; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection
