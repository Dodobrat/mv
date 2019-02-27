@foreach($projects as $project)

    <div class="card portfolio-grid-item endless-pagination" data-aos="zoom-in">
        <a id="modal-btn"
           onclick="openModal( '{{ $project->id }}','{{ route('projects.getProject') }}','{{ $project->slug }}')">
            @if($project->media->isNotEmpty())
                <img src="{{ $project->media->first()->getPublicPath() }}" class="card-img-top" alt="...">
            @else
                <img src="https://via.placeholder.com/150C/O https://placeholder.com/" class="card-img-top" alt="...">
            @endif
        </a>
        <div class="overlay">
            <h4 class="card-overlay-title">
                {{ $project->title }}
                <br>
                <span class="card-overlay-second">
                    {!! $project->description !!}
                </span>
            </h4>

        </div>

    </div>

@endforeach

@section('project')

    <script>
        let modal = document.querySelector('#my-modal');
        function closeModal() {
            $(modal).slideUp(300);
            // window.history.pushState({}, "", '/');
            document.querySelector('body').style.overflowY = 'auto';
        }
        function openModal(id, url, slug) {
            let projectId = id;
            let projectUrl = url;
            // let projectSlug = slug;
            $.ajaxSetup({
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: projectUrl,
                method: 'post',
                data: {
                    project_id: projectId,
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
                        $(modal).slideDown(500);
                        document.querySelector('body').style.overflowY = 'hidden';
                        modal.innerHTML = result.project_modal;
                    }
                }
            });
        }
    </script>

    @endsection