{{--
  Template Name: History Template
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
          <div class="history-dates">
          @foreach($history_details as $history_detail)
            <div class="year-title flex accordion">
              <h2 class="year">{!! $history_detail['title'] !!}</h2>
              <svg class="arrow" width="22" height="12" viewBox="0 0 22 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M21 2L11.3704 10L1 2" stroke="black" stroke-width="3"/>
                </svg>   
            </div>
          <div class="year-content panel" >
            <div class="text-base leading-history font-light">
                {!! $history_detail['description'] !!}
            </div>
          </div>
          @endforeach
        </div>
        </div>
      </div>
    </div>
  </div>
@endsection
