@extends('layouts.app')
@section('content')

@foreach($workflow as $work)

    <section class="workflow-section">
        @if(!empty($work->media->first()))
            <img src="{{ $work->media->first()->getPublicPath() }}" alt="" class="workflow-img">
        @else
            <img src="https://via.placeholder.com/500C/O https://placeholder.com/" alt="" class="workflow-img">
        @endif
        <div class="workflow-desc">
            {!! $work->description !!}
        </div>
    </section>

@endforeach

@endsection