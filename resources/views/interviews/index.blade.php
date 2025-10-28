@extends('layouts.app')

@section('title', 'Interviews')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Interviews</h1>
    <a href="{{ route('interviews.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> New Interview</a>
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Candidate</th>
                        <th>Recruiter</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Questionnaire</th>
                        <th>Status</th>
                        <th>Outcome</th>
                        <th>Total Score</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interviews as $interview)
                        <tr>
                            <td>{{ $interview->candidate_name }}</td>
                            <td>{{ $interview->recruiter_name ?? '—' }}</td>
                            <td>{{ optional($interview->interview_date)->format('d M Y') ?? '—' }}</td>
                            <td>{{ $interview->location ?? '—' }}</td>
                            <td>
                                @if($interview->is_questionnaire_complete)
                                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Complete</span>
                                @else
                                    <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Pending</span>
                                @endif
                            </td>
                            <td><span class="badge badge-info text-uppercase">{{ $statusOptions[$interview->status] ?? ucfirst($interview->status) }}</span></td>
                            <td><span class="badge badge-secondary text-uppercase">{{ $outcomeOptions[$interview->outcome] ?? ucfirst($interview->outcome) }}</span></td>
                            <td>{{ $interview->total_score ?? '—' }}</td>
                            <td class="text-right">
                                <a href="{{ route('interviews.show', $interview) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('interviews.edit', $interview) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('interviews.export-pdf', $interview) }}" class="btn btn-sm btn-outline-success" title="Export PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <form action="{{ route('interviews.destroy', $interview) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this interview?');">
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
                            <td colspan="9" class="text-center py-4">No interviews yet. <a href="{{ route('interviews.create') }}">Create the first one.</a></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $interviews->links() }}
</div>
@endsection
