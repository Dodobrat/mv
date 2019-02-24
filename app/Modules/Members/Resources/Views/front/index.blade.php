@extends('layouts.app')
@section('content')

<div class="meet-the-team-section">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            @foreach($members as $member)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 member-card-container px-1 py-1">
                    <div class="card member-card">
                        @if($member->thumbnail_media->isNotEmpty())
                            <img class="card-img member-card-img"
                                 src="{{ $member->thumbnail_media->first()->getPublicPath() }}"
                                 alt="">
                        @else
                            <img class="card-img member-card-img"
                                 src="https://via.placeholder.com/150C/O https://placeholder.com/"
                                 alt="">
                        @endif
                        <div class="card-img-overlay">
                            @if($member->profile_media->isNotEmpty())
                                <img class="profile-pic"
                                     src="{{ $member->profile_media->first()->getPublicPath() }}"
                                     alt="">
                            @else
                                <img class="profile-pic"
                                     src="https://via.placeholder.com/150C/O https://placeholder.com/"
                                     alt="">
                            @endif
                            <div class="custom-card-text">
                                {!! $member->bio !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-box">
                        <h5 class="card-title">{{ $member->name }}</h5>

                        <p class="card-text">{{ $member->position }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>



@endsection