@extends('layouts.app')
@section('content')

@foreach($contacts as $contact)

    <div class="contacts-section">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-7 col-md-10 col-sm-11 col-11 desc">
                <div class="contact-description" data-aos="fade-right" data-aos-delay="500">
                    {!! $contact->description !!}
                </div>
            </div>
            <div class="col-lg-5 col-md-10 col-sm-10 col-11">
                <div class="contact-email" data-aos="zoom-in" data-aos-delay="500">
                    <h4 class="contact-email-title">
                        {{ trans('contacts::front.contact_us') }}
                    </h4>
                    <form class="contact-email-form" method="POST" action="{{ route('contacts.store') }}" data-url="{{ route('contacts.store') }}">
                        {{ csrf_field() }}
                        <div class="row py-4">
                            <div class="col-12">
                                <div class="contact-email-name-field {{ $errors->has('names') ? ' has-error' : '' }}">
                                    <input class="field name"
                                           id="name_{{ $contact->id }}"
                                           type="text"
                                           name="name"
                                           placeholder="{{ trans('contacts::front.name') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-email-phone-field {{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <input class="field phone"
                                           id="phone_{{ $contact->id }}"
                                           type="text"
                                           name="phone"
                                           placeholder="{{ trans('contacts::front.phone') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-email-email-field {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input class="field email"
                                           id="email_{{ $contact->id }}"
                                           type="email"
                                           name="email"
                                           placeholder="{{ trans('contacts::front.email') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-email-comment-field {{ $errors->has('comment') ? ' has-error' : '' }}">
                                    <textarea class="comment" id="comment_{{ $contact->id }}" type="text" name="comment" placeholder="{{ trans('contacts::front.comment') }}" required></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">

                        <button type="button"
                                class="submit-btn"
                                id="ajaxSubmitCon_{{$contact->id}}">
                            {{trans('contacts::front.send')}}
                        </button>

                    </form>
                </div>
            </div>
        </div>
        <div class="row justify-content-center align-items-center small-info" data-aos="fade-up" data-aos-delay="500">
            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                <p class="contact-label">{{ trans('contacts::front.address') }}</p>
                <p class="contact-address" title="{{ trans('index::front.copy') }}">
                    {{ $contact->address }}
                </p>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                <p class="contact-label">{{ trans('contacts::front.email') }}</p>
                <p class="contact-mail" title="{{ trans('index::front.copy') }}">
                    {{ $contact->email }}
                </p>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                <p class="contact-label">{{ trans('contacts::front.phone') }}</p>
                <p class="contact-phone" title="{{ trans('index::front.copy') }}">
                    {{ $contact->phone }}
                </p>
            </div>
        </div>


            <div id="map"></div>
            <script>
                function initMap() {
                    let destination = {lat: parseFloat("{{ $contact->lat }}") , lng: parseFloat("{{ $contact->lng }}")};
                    let options = {
                        zoom: 16,
                        center: destination,
                        styles: [
                            {"elementType": "geometry", "stylers": [{"color": "#f5f5f5"}]},
                            {"elementType": "labels.icon", "stylers": [{"visibility": "off"}]},
                            {"elementType": "labels.text.fill", "stylers": [{"color": "#616161"}]},
                            {"elementType": "labels.text.stroke", "stylers": [{"color": "#f5f5f5"}]},
                            {
                                "featureType": "administrative.land_parcel",
                                "elementType": "labels.text.fill",
                                "stylers": [{"color": "#bdbdbd"}]
                            },
                            {"featureType": "poi", "elementType": "geometry", "stylers": [{"color": "#eeeeee"}]},
                            {"featureType": "poi", "elementType": "labels.text.fill", "stylers": [{"color": "#757575"}]},
                            {"featureType": "poi.park", "elementType": "geometry", "stylers": [{"color": "#e5e5e5"}]},
                            {"featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [{"color": "#9e9e9e"}]},
                            {"featureType": "road", "elementType": "geometry", "stylers": [{"color": "#ffffff"}]},
                            {
                                "featureType": "road.arterial",
                                "elementType": "labels.text.fill",
                                "stylers": [{"color": "#757575"}]
                            },
                            {"featureType": "road.highway", "elementType": "geometry", "stylers": [{"color": "#dadada"}]},
                            {
                                "featureType": "road.highway",
                                "elementType": "labels.text.fill",
                                "stylers": [{"color": "#616161"}]
                            },
                            {"featureType": "road.local", "elementType": "labels.text.fill", "stylers": [{"color": "#9e9e9e"}]},
                            {"featureType": "transit.line", "elementType": "geometry", "stylers": [{"color": "#e5e5e5"}]},
                            {"featureType": "transit.station", "elementType": "geometry", "stylers": [{"color": "#eeeeee"}]},
                            {"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#c9c9c9"}]},
                            {"featureType": "water", "elementType": "labels.text.fill", "stylers": [{"color": "#9e9e9e"}]}
                        ],
                        mapTypeControlOptions: {
                            mapTypeIds: ['roadmap', 'styled_map']
                        },
                    };
                    map = new google.maps.Map(document.getElementById('map'),options);
                    let marker = new google.maps.Marker({
                        position:{lat: parseFloat("{{ $contact->lat }}") , lng: parseFloat("{{ $contact->lng }}")},
                        map: map,
                    });

                    let infoWindow = new google.maps.InfoWindow({
                        content: `
               <p style="padding: 10px;
                        margin: 0;
                        font-size: 18px;
                        text-transform: uppercase;
                        font-weight: 400;">
                    {{ $contact->working_time }}
                            </p>
`
                    });

                    marker.addListener('click', function () {
                        infoWindow.open(map, marker);
                    })
                }
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ Settings::get('google_map_api_key') }}&callback=initMap" type="text/javascript"></script>

    </div>
    
@endforeach

@endsection


