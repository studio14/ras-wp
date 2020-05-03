{{--
  Template Name: Become a Partner (No Menu) Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.header-bg')
  @include('partials.sub-menu')

  <div class="custom-page--content">
    <div class="container" style="max-width: 1160px;padding-left:0px;">
      <div class="custom-page-content">
        <div class="custom-page--info">
          <div class="content mb-44" style="line-height: 150%; font-size: 16px;">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            the_content();
            endwhile; endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
