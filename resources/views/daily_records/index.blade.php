
@extends('layouts.app')

@section('content')
<h1>Daily Records</h1>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Male Avg Count</th>
            <th>Female Avg Count</th>
            <th>Male Avg Age</th>
            <th>Female Avg Age</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dailyRecords as $dailyRecord)
        <tr>
            <td>{{ $dailyRecord->data }}</td>
            <td>{{ $dailyRecord->male_count }}</td>
            <td>{{ $dailyRecord->female_count }}</td>
            <td>{{ $dailyRecord->male_avg_age }}</td>
            <td>{{ $dailyRecord->female_avg_age }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection