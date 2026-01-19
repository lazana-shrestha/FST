@extends('layout')

@section('title','Employee Database')

@section('content')
<a href="index.php?action=create">Add Employee</a>

<ul>
@foreach ($employees as $e)
    <li>
        <strong>{{ $e['name'] }}</strong> – {{ $e['title'] }}

        <br>Skills:
        <ul>
        @foreach (explode(',', $e['skills']) as $skill)
            <li>{{ trim($skill) }}</li>
        @endforeach
        </ul>

        <a href="index.php?action=edit&id={{ $e['id'] }}">Edit</a> |
        <a href="index.php?action=delete&id={{ $e['id'] }}"
           onclick="return confirm('Are you sure?')">Delete</a>
    </li>
@endforeach
</ul>
@endsection
