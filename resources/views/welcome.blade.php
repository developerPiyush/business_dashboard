@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Businesses</h2>
        @if(count($businesses) > 0)
            <div class="row">
                @foreach ($businesses as $business)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">{{ $business->name }}</div>
                            <div class="card-body">
                                @foreach ($business->branches as $branch)
                                    <div class="card">
                                        <div class="card-header">{{ $branch->name }}</div>
                                        <div class="card-body">
                                            @if (is_array($branch->images))
                                                @foreach ($branch->images as $image)
                                                    <div class="card" style="width: 10rem;">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $branch->name }}"
                                                            class="card-img-top">
                                                    </div>
                                                @endforeach
                                            @endif
                                            <a href="{{ route('branch.showTimings', $branch->id) }}"
                                                class="btn btn-info btn-sm mt-2">Show Timings Available</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No businesses available at the moment.</p>
        @endif
    </div>
@endsection
