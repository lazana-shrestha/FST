@extends('layout')

@section('title','Create Employee')

@section('content')
<form method="post" action="index.php?action=store">
    <input name="name" placeholder="Name" required><br><br>
    <input name="title" placeholder="Job Title" required><br><br>
    <input name="skills" placeholder="Skills (comma separated)" required><br><br>
    <button>Save</button>
</form>
@endsection
