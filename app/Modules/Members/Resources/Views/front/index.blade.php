@extends('layouts.app')
@section('content')

<div class="meet-the-team-section">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            @foreach($members as $member)
                <div class="col-lg-4 col-md-5 col-sm-6 col-12 member-card-container py-2">
                    <div class="member-info"
                         onclick="openMemberModal( '{{ $member->id }}','{{ route('members.getMember') }}')"
                         data-aos="zoom-in"
                         data-aos-delay="300">
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

    <div class="aspin">
        <div class="spinner"></div>
    </div>

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
                    $(".aspin").show();
                },

                success: function (result) {
                    if (result.errors.length != 0) {
                        $(".aspin").hide();
                        $(".error-box").show();

                        $.each(result.errors, function (key, value) {
                            $('.error').html(result.errors);
                        });

                        setTimeout(function(){
                            $(".error-box").slideUp(300);
                        }, 3000);
                    } else {
                        $(".aspin").hide();
                        memberModal.style.right = '0';
                        memberModal.innerHTML = result.member_modal;
                    }
                }
            });
        }
    </script>
@endsection