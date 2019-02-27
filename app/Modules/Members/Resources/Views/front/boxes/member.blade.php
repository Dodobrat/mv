@if(!empty($member))

    <div class="member-modal-content">
        <div class="row justify-content-center">

            <div class="col-12">
                <div class="member-modal-close"
                        onclick="closeMemberModal()">
                    &#10005;
                </div>
            </div>

            <div class="col-12">
                @if(!empty($member->profile_media->first()))
                    <img src="{{ $member->profile_media->first()->getPublicPath() }}" alt="" class="profile-pic">
                    @else
                    <img src="https://via.placeholder.com/150C/O https://placeholder.com/" alt="" class="profile-pic">
                @endif
            </div>

            <div class="col-12">
                <h1 class="member-name">{{ $member->name }}</h1>
            </div>

            <div class="col-12">
                <h3 class="member-position">{{ $member->position }}</h3>
            </div>

            <div class="col-12 pr-0 pr-md-2">
                <div class="member-bio">
                    {!! $member->bio !!}
                </div>
            </div>

        </div>

    </div>



    @endif