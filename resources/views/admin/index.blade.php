@extends('layouts.dashboard')
@section('content')
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{$pageTitle ?? $naturalPageTitle}}
                    </h3>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">

                </div>
            </div>
        </div>
        <div class="p-6">
        </div>
    </div>
@endsection
