{{--
  Template Name: Become A Member Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.header-bg')
  @include('partials.sub-menu')

  <div class="custom-page--content">
    <div class="membership container">
      <div class="flex-col md:flex-row custom-page-content">
        <div class="custom-page-title ">
          <h2>{!! App::title() !!} </h2>
          <hr>
        </div>
        <div class="custom-page--info flex-col md:flex-row mt-97 md:mt-0">
          <div class="summary mb-44" style="line-height: 150%; font-size: 16px;">
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
              the_content();
              endwhile; endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="membership-pricing bg-membership-color mt-0 pt-0 xl:pt-86 pb-86 flex justify-around content-center text-center align-center items-center">
    <div class="container block lg:flex flex-col lg:flex-row w-full justify-center mt-24 lg:mt-0">
    @foreach($get_membership_pricings as $get_membership_pricing)
      @if ($loop->iteration%2 === 0) 
          <div class="w-full md:w-1/2 lg:w-auto md:float-right">
            <div class="pricing-item bg-white text-center items-center">
              <div class="title">
                <p  class="text-secondary">{!! $get_membership_pricing['title'] !!}</p>
              </div>
              <div class="price-tag">
                <h2  class="text-secondary">£{!! $get_membership_pricing['price'] !!}</h2>
              </div>
              <div class="price-desc">
                <p class="text-secondary text-left">
                    {!! $get_membership_pricing['description'] !!}   
                </p>
              </div>
              <div class="price-button">
                <a class="btn bg-custom-bg text-secondary" href="{!! $get_membership_pricing['page_link'] !!}">Find Out More</a>
              </div>
            </div>
          </div>
        @else 
          <div class="w-full md:w-1/2 lg:w-auto md:float-right">
            <div class="pricing-item bg-primary text-center items-center">
              <div class="title">
                <p  class="text-white">{!! $get_membership_pricing['title'] !!}</p>
              </div>
              <div class="price-tag">
                <h2  class="text-white">£{!! $get_membership_pricing['price'] !!}</h2>
              </div>
              <div class="price-desc">
                <p class="text-white text-left">
                    {!! $get_membership_pricing['description'] !!}   
                </p>
              </div>
              <div class="price-button">
                <a class="btn bg-custom-bg text-secondary" href="{!! $get_membership_pricing['page_link'] !!}">Find Out More</a>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </div>
  </div>
  
  
  <style>
    footer {
      margin-top: 145px !important;
    }
  </style>
@endsection
