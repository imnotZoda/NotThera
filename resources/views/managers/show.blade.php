<!-- resources/views/managers/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Manager Details</h1>

    <ul>
        <li><strong>ID:</strong> {{ $manager->id }}</li>
        <li><strong>First Name:</strong> {{ $manager->fname }}</li>
        <li><strong>Last Name:</strong> {{ $manager->lname }}</li>
        <li><strong>Phone Number:</strong> {{ $manager->phoneNum }}</li>
        <li><strong>Address:</strong> {{ $manager->address }}</li>
        <li><strong>Username:</strong> {{ $manager->username }}</li>
        <li><strong>Address:</strong> {{ $manager->address }}</li>
        <li><strong>Profile Image:</strong> <img src="{{ asset('images/managers/' . $manager->images) }}" alt="Profile Image"></li>
    </ul>

    <a href="{{ route('managers.index') }}" class="btn btn-primary">Back</a>
@endsection
