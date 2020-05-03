{{--
  Template Name: Council Template
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
          <div class="summary our-team-bg">
            <div class="w-full">
                <div class="our-team flex inline flex-wrap justify-between">
                    @foreach($get_councils as $get_council)
                    <div class="team-content w-full lg:w-1/2 max-w-teamwidth">
                        <div class="team_image max-h-teamwidth" style="background-image: url({!! $get_council['featured_image'] !!})">
                            <div class="team_hover"></div>
                        </div>
                        <div class="team_details">
                            <h2 class="team_name">
                                {!! $get_council['title'] !!}
                            </h2>
                            <p class="team_position">
                                {!! $get_council['position'] !!}
                            </p>
                            <a href="https://twitter.com/<?= $get_council['twitter_handle'] ?>" class="team_twitter_info" target='_blank'>
                                {!! $get_council['twitter_handle'] !!}
                            </a>
                        </div>
                        <div class="team_info">
                          <p class="team_info_p" style="line-height: 150%; font-size: 16px;">
                              {!! $get_council['description'] !!}
                          </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
@endsection