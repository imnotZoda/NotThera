<!-- resources/views/employees/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Employee List</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->fname }}</td>
                        <td>{{ $employee->lname }}</td>
                        <td>{{ $employee->address }}</td>
                        <td>{{ $employee->phoneNum }}</td>
                        <td>{{ $employee->username }}</td>
                        <td>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
