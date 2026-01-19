@extends('layout')

@section('title','Edit Employee')

@section('content')
<form method="post" action="index.php?action=update">
    <input type="hidden" name="id" value="{{ $employee['id'] }}">

    <input name="name" value="{{ $employee['name'] }}"><br><br>
    <input name="title" value="{{ $employee['title'] }}"><br><br>
    <input name="skills" value="{{ $employee['skills'] }}"><br><br>

    <button>Update</button>
</form>
@endsection
