@extends('layouts.app')

@section('content')
  {{-- @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @while (have_posts()) @php the_post() @endphp
    @include('partials.content-'.get_post_type())
  @endwhile

  {!! get_the_posts_navigation() !!} --}}
  <section id="events">
      <div class="container events-container">
          <div class="container events-title-bg flex text-left justify-left">
              <div class="title" style="max-width: 454px;">
                  <h2>{!! App::title() !!}</h2>
                  <hr/>
              </div>
          </div>
            <?php if (have_posts()) {
                $postCount = 1;
            ?>
            @php
            the_post();
                @include('partials.content-'.get_post_type());
            @endphp
            <?php 
                }
                else {
            ?>
            <div class="events-content no-news">
                <div class="container flex justify-center flex-col items-center items-center">
                    <h2> Sorry, No News Available Here. </h2>
                    <a href="<?php echo home_url(); ?>" class="" style="border-radius: 80px;">Go home          
                    </a>
                </div>
            </div>
            <?php 
                }
            ?>
  </section>
@endsection
