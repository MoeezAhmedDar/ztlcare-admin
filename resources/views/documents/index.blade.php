@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Recruitment Documents</h2>

    <div class="card p-4 shadow-sm">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="align-middle">Document Name</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($documents as $doc)
                    <tr>
                        <td class="align-middle">{{ $doc['name'] }}</td>
                        
                        <td class="text-center">
                            <a href="{{ route('download.document', $doc['pdf']) }}"
                            class="btn btn-danger btn-sm me-2" title="Download PDF">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                            
                            <a href="{{ route('download.document', $doc['word']) }}"
                            class="btn btn-success btn-sm" title="Download Word">
                                <i class="fas fa-file-word"></i> Word
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
