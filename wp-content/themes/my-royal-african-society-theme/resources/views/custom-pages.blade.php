{{--
  Template Name: Custom Page Template
--}}

@extends('layouts.app')

@section('content')
  <div class="custom-page--bg" style="background-image: url({!! App\get_post_featured_image() !!})">
    <div class="container">
      <div class="custom-page-container">
        <div class="custom-page-title">
          <h6>The Royal African Society </h6>
        </div>
      </div>
    </div>
    <div class="sub-menu-list">
        {!! App\get_current_submenu('primary_navigation') !!}
    </div>
  </div>

  <div class="custom-page--content">
    <div class="container" style="max-width: 1160px;padding-left:0px;">
      <div class="custom-page-content">
        <div class="custom-page-title">
          <h2>Our Mission and Values </h2>
          <hr>
        </div>
        <div class="custom-page--info">
          <div class="summary">
            <p>The Royal African Society is a membership organisation that provides opportunities for people to connect, 
              celebrate and engage critically with a wide range of topics and ideas about Africa today. Through our events, 
              publications and digital channels we share insight, instigate debate and facilitate mutual understanding between
               the UK and Africa. We amplify African voices and interests in academia, 
              business, politics, the arts and education, reaching a network of more than one million people globally. </p>
          </div>
          <div class="title">
            <h2>Mission Statement</h2>
          </div>
          <div class="content">
            <p>In the period up to 1914, and the outbreak of the second world war, membership of the society continued to grow; 
              from two subscribers to the journal in 1901, namely, the foreign office and the colonial office to 473 members and journal subscribers, 
              including 24 life members – and the Alake of Abeokuta as an honorary member. The subjects in the journal ranged from considerations 
              of education in native tongue to the taxation system in Northern Nigeria – and in tone often reflected the conflicting perception 
              of Africa and Africans amongst members of the society, often validating Africans as worthy of respect but advocating the careful 
              guidance of Europeans, as in this excerpt of a lecture given By a Mr. J Cathcart Wason, M.P. on <b>‘The Importance of West Africa’</b><br /><br />
               – 
              Among our members are people from a variety of cultural and professional backgrounds, both Africans and non-Africans, including business 
              leaders, eminent academics, politicians, civil servants, 
              teachers and students, health professionals, journalists and writers, artists and musicians.</p>
          </div>
          <div class="title">
              <h2>Core Values</h2>
            </div>
            <div class="content" style="margin-bottom: 0px;">
              <p>In the period up to 1914, and the outbreak of the second world war, membership of the society continued to grow; 
                from two subscribers to the journal in 1901, namely, the foreign office and the colonial office to 473 members and journal subscribers, 
                including 24 life members – and the Alake of Abeokuta as an honorary member. The subjects in the journal ranged from considerations 
                of education in native tongue to the taxation system in Northern Nigeria – and in tone often reflected the conflicting perception 
                of Africa and Africans amongst members of the society, often validating Africans as worthy of respect but advocating the careful 
                guidance of Europeans, as in this excerpt of a lecture given By a Mr. J Cathcart Wason, M.P. on <b>‘The Importance of West Africa’</b><br /><br />
              </p>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
