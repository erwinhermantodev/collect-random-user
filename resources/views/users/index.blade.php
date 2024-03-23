<!-- resources/views/users/index.blade.php -->
@extends('layouts.app')

@section('content')
<h1>User Records</h1>
<h2>Total User Records: {{ $totalUserCount }}</h2>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->age }}</td>
            <td>{{ $user->gender }}</td>
            <td>{{ $user->created_at }}</td>
            <td>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection