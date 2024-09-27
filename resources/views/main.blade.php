@extends('layout.app')
@section('content')
    <nav class="bg-gray-800 p-4">
        <div class="flex justify-between items-center">
            <a href="{{ route('main') }}" class="text-white text-lg">Todo App</a>
            <div>
                <a href="{{ url('categories') }}" class="text-white mx-2">Categories</a>
                <a href="javascript:void(0);" class="text-white mx-2">{{ Auth()->user()->name }}</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="bg-red-500 text-white py-2 px-4 rounded-lg">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-6 p-4">
        <div id="app">
            <script>
                {{--window.authToken = '{{ $token }}';--}}
            </script>
        </div>
    </div>
@endsection
