@extends('layouts.app')

@section('content')
  {{-- @include('partials.page-header') --}}
  @include('partials.content-search-form')
<section id="404page" class="notfound">
  <div class="container">
      <div class="not-found-bg">
        <div class="not-found-title">
          <h1>Sorry, the page you requested could not be found.</h1>
          <p>You can use our search form above to quickly find what you were looking for</p>
        </div>
      </div>
    </div>
</section>
    
@endsection
