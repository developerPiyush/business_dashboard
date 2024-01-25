<h2>Business Details</h2>

<h3>Branches</h3>
<ul>
    @foreach($branches as $branch)
        <li>{{ $branch->name }} - {{ $branch->address }}</li>
    @endforeach
</ul>
