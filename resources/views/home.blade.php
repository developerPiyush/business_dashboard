@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">


                    <li><a href="{{ route('business.index') }}" class="btn btn-info mb-2">Businesses</a></li>
                    <li><a href="{{ route('branch.index') }}" class="btn btn-info">Branches</a></li>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
