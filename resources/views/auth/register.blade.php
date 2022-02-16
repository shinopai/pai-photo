@extends('layouts.app')

@section('content')
@if ($errors->any())
<ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-center" role="alert">
    @foreach ($errors->all() as $err)
    <li>{{ $err }}</li>
    @endforeach
</ul>
@endif

<div class="bg-grey-lighter flex flex-col">
    <div class="container lg:w-2/3 mx-auto flex-1 flex flex-col items-center justify-center px-2 mt-10">
        <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
            <h1 class="mb-8 text-3xl text-center">Sign up</h1>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="text" class="block border border-grey-light w-full p-3 rounded mb-4" name="name" placeholder="Name" />

                <input type="text" class="block border border-grey-light w-full p-3 rounded mb-4" name="email" placeholder="Email" />

                <input type="password" class="block border border-grey-light w-full p-3 rounded mb-4" name="password" placeholder="Password" />
                <input type="password" class="block border border-grey-light w-full p-3 rounded mb-4" name="password_confirmation" placeholder="Confirm Password" />

                <button type="submit" class="w-full text-center py-3 rounded bg-green-500 text-white hover:bg-green-700 focus:outline-none my-1">Create Account</button>
            </form>
        </div>

        <div class="text-grey-dark mt-6">
            Already have an account?
            <a class="no-underline border-b border-blue text-blue" href="{{ route('login') }}">
                Login
            </a>
        </div>
    </div>
</div>
@endsection
