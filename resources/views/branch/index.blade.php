@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('branch.create') }}" class="btn btn-primary">Add Branch</a>
        <br><br>

        <table class="table table-striped" id="brach-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($branches as $branch)
                    <tr>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->address }}</td>

                        <td>
                            <a href="{{ route('branch.showTimings', $branch->id) }}" class="btn btn-info btn-sm">Show Timings</a>
                            <form action="{{ route('branch.destroy', [$branch->id]) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this branch?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No branches available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#brach-table').DataTable({
                "order": [
                    [0, 'asc']
                ],
                "searching": true,
            });
        });
    </script>
@endsection
