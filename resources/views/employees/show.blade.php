<!-- resources/views/managers/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Employee Details</h1>

    <ul>
        <li><strong>ID:</strong> {{ $employee->id }}</li>
        <li><strong>First Name:</strong> {{ $employee->fname }}</li>
        <li><strong>Last Name:</strong> {{ $employee->lname }}</li>
        <li><strong>Phone Number:</strong> {{ $employee->phoneNum }}</li>
        <li><strong>Address:</strong> {{ $employee->address }}</li>
        <li><strong>Username:</strong> {{ $employee->username }}</li>
        <li><strong>Address:</strong> {{ $employee->address }}</li>
        <li><strong>Profile Image:</strong> <img src="{{ asset('images/employees/' . $employee->images) }}" alt="Profile Image"></li>
    </ul>

    <a href="{{ route('employees.index') }}" class="btn btn-primary">Back</a>
@endsection
