@extends('layouts.app')

@section('title', 'Job Applications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Job Applications</h1>
    <a href="{{ route('job-application.start') }}" class="btn btn-primary" target="_blank">
        <i class="fas fa-external-link-alt mr-1"></i> View Public Form
    </a>
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Candidate Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td>#{{ $application->id }}</td>
                            <td>{{ $application->forename }} {{ $application->surname }}</td>
                            <td>{{ $application->email ?? '—' }}</td>
                            <td>{{ $application->mobile_number ?? '—' }}</td>
                            <td>{{ $application->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $application->status === 'pending' ? 'warning' : ($application->status === 'approved' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'info')) }} text-uppercase">
                                    {{ str_replace('_', ' ', $application->status) }}
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.job-applications.show', $application) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.job-applications.export-pdf', $application) }}" class="btn btn-sm btn-outline-success" title="Export PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <form action="{{ route('admin.job-applications.destroy', $application) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this application?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No applications yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $applications->links() }}
</div>
@endsection
