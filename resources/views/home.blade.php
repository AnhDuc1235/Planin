@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col font-sans bg-white text-gray-800">

    @include('layouts.navbar')

    <main class="flex-1">
        <div class="bg-white text-[#091E42]">
            @include('home.hero')
            @include('home.showcase')
            @include('home.features')
            @include('home.testimonials')
            @include('home.cta')
        </div>
    </main>

    @include('layouts.footer')

</div>
@endsection
