@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Recruitment Documents</h2>

    <div class="card p-4 shadow-sm">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Document Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $doc)
                    <tr>
                        <td>{{ $doc['name'] }}</td>
                        <td>
                            <a href="{{ asset('storage/documents/' . $doc['file']) }}" 
                               class="btn btn-primary btn-sm" 
                               target="_blank" 
                               download>
                                Download
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
