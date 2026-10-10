@extends('admin.layouts.master')

@php
    $formatValue = function ($value) {
        if ($value === null || $value === '') {
            return '—';
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        return is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string) $value;
    };
    $eventClass = ['created' => 'success', 'updated' => 'warning', 'deleted' => 'danger'];
@endphp

@section('content')
    <div class="content-wrapper">
        <div class="container p-3">
            <section class="content pt-2">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title fw-bold">@lang('general.finance_logs')</h1>
                        </div>

                        <div class="card-body">
                            {{-- Filters --}}
                            <form method="GET" action="{{ route('finance-logs.index') }}" class="row g-2 mb-3">
                                <div class="col-md-2">
                                    <label class="form-label small">@lang('general.log_record_type')</label>
                                    <select name="model" class="form-control">
                                        <option value="">@lang('general.log_all')</option>
                                        @foreach ($models as $model)
                                            <option value="{{ $model }}" @selected(($filters['model'] ?? '') === $model)>{{ $model }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">@lang('general.log_action')</label>
                                    <select name="event" class="form-control">
                                        <option value="">@lang('general.log_all')</option>
                                        @foreach (['created', 'updated', 'deleted'] as $event)
                                            <option value="{{ $event }}" @selected(($filters['event'] ?? '') === $event)>@lang('general.log_' . $event)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">@lang('general.log_who')</label>
                                    <select name="admin_id" class="form-control">
                                        <option value="">@lang('general.log_all')</option>
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->admin_id }}" @selected((string) ($filters['admin_id'] ?? '') === (string) $admin->admin_id)>{{ $admin->admin_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label small">@lang('general.log_record_id')</label>
                                    <input type="number" name="record" min="1" value="{{ $filters['record'] ?? '' }}" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">@lang('general.log_from')</label>
                                    <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">@lang('general.log_to')</label>
                                    <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="form-control">
                                </div>
                                <div class="col-md-1 d-flex align-items-end gap-1">
                                    <button type="submit" class="btn btn-primary w-100">@lang('general.log_filter')</button>
                                </div>
                                @if (array_filter($filters))
                                    <div class="col-12">
                                        <a href="{{ route('finance-logs.index') }}" class="small">@lang('general.log_reset')</a>
                                    </div>
                                @endif
                            </form>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>@lang('general.log_when')</th>
                                            <th>@lang('general.log_who')</th>
                                            <th>@lang('general.log_action')</th>
                                            <th>@lang('general.log_record')</th>
                                            <th>@lang('general.log_changes')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($logs as $log)
                                            <tr>
                                                <td class="text-nowrap">{{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
                                                <td>
                                                    @if ($log->admin_id)
                                                        <div class="fw-bold">{{ $log->admin_name }}</div>
                                                        <div class="small text-muted">{{ $log->admin_email }}</div>
                                                    @else
                                                        <div class="fw-bold">@lang('general.log_system')</div>
                                                    @endif
                                                    <div class="small text-muted">{{ $log->channel }}{{ $log->ip_address ? ' · ' . $log->ip_address : '' }}</div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $eventClass[$log->event] ?? 'secondary' }}">@lang('general.log_' . $log->event)</span>
                                                </td>
                                                <td class="text-nowrap">
                                                    <a href="{{ route('finance-logs.index', ['model' => $log->model, 'record' => $log->model_id]) }}" title="@lang('general.log_history_of_record')">
                                                        {{ $log->model }} #{{ $log->model_id }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($log->event === 'updated')
                                                        @foreach ($log->new_values ?? [] as $field => $newValue)
                                                            <div class="small">
                                                                <span class="fw-bold">{{ $field }}</span>:
                                                                <span class="text-danger text-decoration-line-through">{{ $formatValue($log->old_values[$field] ?? null) }}</span>
                                                                &rarr;
                                                                <span class="text-success">{{ $formatValue($newValue) }}</span>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        @foreach (($log->event === 'created' ? $log->new_values : $log->old_values) ?? [] as $field => $value)
                                                            <div class="small"><span class="fw-bold">{{ $field }}</span>: {{ $formatValue($value) }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">@lang('general.log_empty')</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $logs->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
