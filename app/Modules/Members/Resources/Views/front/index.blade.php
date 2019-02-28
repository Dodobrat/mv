@extends('layouts.app')
@section('content')

<div class="meet-the-team-section">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            @foreach($members as $member)
                <div class="col-lg-4 col-md-5 col-sm-6 col-12 member-card-container py-2">
                    <div class="member-info"
                         onclick="openMemberModal( '{{ $member->id }}','{{ route('members.getMember') }}')"
                        data-aos="fade-up">
                        @if($member->thumbnail_media->isNotEmpty())
                            <img class="member-img"
                                 src="{{ $member->thumbnail_media->first()->getPublicPath() }}"
                                 alt="">
                        @else
                            <img class="member-img"
                                 src="https://via.placeholder.com/150C/O https://placeholder.com/"
                                 alt="">
                        @endif
                            @if($member->profile_media->isNotEmpty())
                            <img class="member-p-img"
                                 src="{{ $member->profile_media->first()->getPublicPath() }}"
                                 alt="">
                        @else
                            <img class="member-p-img"
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

<svg class="spinner" viewBox="0 0 50 50">
    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
</svg>

@endsection

@section('member')
    <script>
        let memberModal = document.getElementById('member-modal');

        window.addEventListener('click', function (e) {
            if (e.target == memberModal){
                memberModal.style.right = '-100vw';
            }
        });

        function closeMemberModal() {
            memberModal.style.right = '-100vw';
            // window.history.pushState({}, "", '/');
            // document.querySelector('body').style.overflowY = 'auto';
        }
        function openMemberModal(id, url) {
            let memberId = id;
            let memberUrl = url;

            $.ajaxSetup({
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: memberUrl,
                method: 'post',
                data: {
                    member_id: memberId,
                },
                beforeSend: function () {
                    $(".spinner").show();
                },

                success: function (result) {
                    if (result.errors.length != 0) {
                        $(".spinner").hide();
                        $(".error-box").show();

                        $.each(result.errors, function (key, value) {
                            $('.error').html(result.errors);
                        });

                        setTimeout(function(){
                            $(".error-box").slideUp(300);
                        }, 3000);
                    } else {
                        $(".spinner").hide();
                        // window.history.pushState({}, "", '/' + projectSlug);
                        // $(memberModal).slideDown(300);
                        memberModal.style.right = '0';
                        // document.querySelector('body').style.overflowY = 'hidden';
                        memberModal.innerHTML = result.member_modal;
                    }
                }
            });
        }
    </script>
@endsection