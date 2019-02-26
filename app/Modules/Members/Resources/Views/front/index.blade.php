@extends('layouts.app')
@section('content')

<div class="meet-the-team-section">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            @foreach($members as $member)
                <div class="col-lg-4 col-md-5 col-sm-6 col-12 member-card-container py-2">
                    <div class="member-info">
                        @if($member->thumbnail_media->isNotEmpty())
                            <img class="member-img"
                                 src="{{ $member->thumbnail_media->first()->getPublicPath() }}"
                                 alt="">
                        @else
                            <img class="member-img"
                                 src="https://via.placeholder.com/150C/O https://placeholder.com/"
                                 alt="">
                        @endif
                        <div class="card-box">
                            <div class="text-container">
                                <h5 class="card-title">{{ $member->name }}</h5>
                                <p class="card-text">{{ $member->position }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>






<div id="member-modal" class="member-modal">
    <div class="member-modal-content">

    </div>
</div>



@endsection