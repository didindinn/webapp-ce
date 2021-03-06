@extends ('layouts.master-with-sidebar')

@section ('layout-main-classes', 'container limit-container-width')
@section ('layout-body-classes', 'mt-5 pt-3 mb-3')

@section('javascripts')
<script src="{{ mix('/js/mix/spaces.bundle.js') }}"></script>
@endsection

@section ('sidebar-content')
<div class="context-header">
<a href="#">
    <div class="avatar-container" style="min-height: 50px">
    </div>
    <div class="sidebar-context-title">
        {{ $project->name }}
    </div>
</a>
</div>
@include('projects.elements.sidebar')
@endsection

@section('javascripts')
<script src="{{ mix('/js/mix/projects.bundle.js') }}"></script>
@endsection

@section ('content')
<h1 class="h2" style="font-weight: 300">
<svg class="svg-inline--fa fa-box-alt fa-w-14" aria-hidden="true" data-prefix="fal" data-icon="box-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M447.9 176c0-10.6-2.6-21-7.6-30.3l-49.1-91.9c-4.3-13-16.5-21.8-30.3-21.8H87.1c-13.8 0-26 8.8-30.4 21.9L7.6 145.8c-5 9.3-7.6 19.7-7.6 30.3C.1 236.6 0 448 0 448c0 17.7 14.3 32 32 32h384c17.7 0 32-14.3 32-32 0 0-.1-211.4-.1-272zm-87-112l50.8 96H286.1l-12-96h86.8zM192 192h64v64h-64v-64zm49.9-128l12 96h-59.8l12-96h35.8zM87.1 64h86.8l-12 96H36.3l50.8-96zM32 448s.1-181.1.1-256H160v64c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32v-64h127.9c0 74.9.1 256 .1 256H32z"></path></svg>
    {{ $space->name }}
</h1>

<div class="row">
    <div class="col-12"><p class="lead has-emoji">
        <span class="badge badge-warning py-2 px-2 mr-1"><i class="far fa-lock-alt"></i></span>{{ $project->name }} by <a href="/profiles/{{ $project->user->profile->id }}">{{ $project->user->profile->name }}</a>
    </p></div>
</div>
<div class="row">
    <div class="col-12">
        <space-browser space-id="{{ $space->id }}" path="{{ $path }}" parent-path="{{ $path == '' ? null : dirname(Request::url()) }}"></space-browser>
    </div>
</div>

@endsection
