@extends('layouts.template')

@section('content')
<div class="container py-4">
    
    {{-- Header avec filtre --}}
    <div class="glass-panel p-4 mb-5 shadow-sm d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Historique des présences</h2>
            <p class="text-muted small mb-0">Consultez l'état de présence quotidien de vos équipes</p>
        </div>
        
        <form method="GET" action="{{ route('pointages.suivi') }}" class="d-flex gap-2">
            <div class="input-group input-group-sm shadow-sm">
                <span class="input-group-text border-0 bg-white"><i class="bi bi-calendar3"></i></span>
                <input type="date" name="date" class="form-control border-0 px-3" value="{{ request('date') }}" style="min-width: 160px;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm px-4 rounded-3 shadow-sm">Filtrer</button>
        </form>
    </div>

    {{-- Boucle des Dates --}}
    <div class="history-timeline">
        @foreach($dates as $date)
            <div class="date-card mb-4">
                <div class="date-header d-flex align-items-center mb-3">
                    <div class="date-badge">
                        <span class="day">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
                        <span class="month">{{ \Carbon\Carbon::parse($date)->translatedFormat('M') }}</span>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0 fw-bold text-dark">{{ ucfirst(\Carbon\Carbon::parse($date)->translatedFormat('l d F Y')) }}</h4>
                        <span class="badge bg-light text-muted border">
                            @php 
                                $presentCount = collect($employees)->filter(fn($e) => isset($presences[$date][$e->id]) && $presences[$date][$e->id])->count();
                            @endphp
                            {{ $presentCount }} présent(s) sur {{ count($employees) }}
                        </span>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-uppercase tiny fw-bold text-muted">
                                    <th class="ps-4" style="width: 60%">Employé</th>
                                    <th class="text-center">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-initials me-3">
                                                    {{ strtoupper(substr($employee->nom, 0, 1)) }}{{ strtoupper(substr($employee->prenom, 0, 1)) }}
                                                </div>
                                                <span class="fw-semibold text-dark">{{ $employee->nom }} {{ $employee->prenom }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if(isset($presences[$date][$employee->id]) && $presences[$date][$employee->id])
                                                <span class="status-pill present">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Présent
                                                </span>
                                            @else
                                                <span class="status-pill absent">
                                                    <i class="bi bi-x-circle-fill me-1"></i> Absent
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $dates->links('pagination::simple-bootstrap-5') }}
    </div>
</div>

<style>
    /* Global */
    body { background-color: #f8fafc; font-family: 'Inter', -apple-system, sans-serif; }
    .tiny { font-size: 0.7rem; letter-spacing: 0.05rem; }

    /* Glass Panel */
    .glass-panel {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    /* Date Badge (Calendrier style) */
    .date-badge {
        background: white;
        border-radius: 12px;
        width: 55px;
        height: 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border-top: 4px solid #4361ee;
    }
    .date-badge .day { font-size: 1.2rem; font-weight: 800; color: #1e293b; line-height: 1; }
    .date-badge .month { font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; }

    /* Avatars */
    .avatar-initials {
        width: 35px;
        height: 35px;
        background: #eef2ff;
        color: #4361ee;
        font-size: 0.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    /* Status Pills */
    .status-pill {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    .status-pill.present { background: #dcfce7; color: #166534; }
    .status-pill.absent { background: #fee2e2; color: #991b1b; }

    /* Table Adjustments */
    .table thead th { border: none; }
    .table tbody tr { transition: background 0.2s; }
    .table tbody tr:hover { background-color: #f1f5f9; }

    /* Custom Input */
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        border-color: #4361ee;
    }
</style>
@endsection