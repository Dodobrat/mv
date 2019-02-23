@extends('layouts.app')
@section('content')

    <div class="page-cover">
        <div class="page-cover-img rellax"
             @if(!empty(Settings::getFile('contacts_header_image')))
             style="background-image: url('{{ Settings::getFile('contacts_header_image') }}')"
             @else
             style="background-image: url('{{ asset('img/slider-1.jpg') }}');"
                @endif data-rellax-speed="3">
            <div class="container rellax" data-rellax-speed="-5">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-8 col-md-10 col-sm-12 col-12" data-aos="fade-up">
                        <h2 class="page-title">{{ trans('contacts::front.contacts') }}</h2>
                        <div class="page-lead">
                            @if(!empty(Administration::getStaticBlock('contacts')))
                                {!! Administration::getStaticBlock('contacts') !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--<div class="contacts-section" data-aos="fade up">--}}
        {{--<div class="container">--}}
            {{--<div class="row justify-content-center align-items-center">--}}
                {{--<h2 class="contacts-section-title">--}}
                    {{--Изпратете ни имейл--}}
                {{--</h2>--}}
            {{--</div>--}}
            {{--<div class="row justify-content-center align-items-center">--}}
                {{--<form class="contact-section-form" action="#" method="post">--}}

                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


        {{--<div class="section" data-aos="fade-up">--}}
            {{--<div class="container">--}}
                {{--<div class="row justify-content-center">--}}
                    {{--<div class="col-md-10 p-5 form-wrap">--}}
                        {{--<form action="#">--}}
                            {{--<div class="row mb-4">--}}
                                {{--<div class="form-group col-md-4">--}}
                                    {{--<label for="name" class="label">Name</label>--}}
                                    {{--<div class="form-field-icon-wrap">--}}
                                        {{--<span class="icon ion-android-person"></span>--}}
                                        {{--<input type="text" class="form-control" id="name">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-4">--}}
                                    {{--<label for="email" class="label">Email</label>--}}
                                    {{--<div class="form-field-icon-wrap">--}}
                                        {{--<span class="icon ion-email"></span>--}}
                                        {{--<input type="email" class="form-control" id="email">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-4">--}}
                                    {{--<label for="phone" class="label">Phone</label>--}}
                                    {{--<div class="form-field-icon-wrap">--}}
                                        {{--<span class="icon ion-android-call"></span>--}}
                                        {{--<input type="text" class="form-control" id="phone">--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="form-group col-md-12">--}}
                                    {{--<label for="message" class="label">Message</label>--}}
                                    {{--<textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<input type="submit" class="btn btn-primary btn-outline-primary btn-block" value="Submit">--}}
                                    {{--<!-- <p><a href="#" class="btn btn-primary btn-outline-primary btn-sm">Read More</a></p> -->--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div> <!-- .section -->--}}

        {{--<div class="map-wrap" id="map"  data-aos="fade"></div>--}}


    @endsection