<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Read-only history of finance changes (fees, accountants, accounts).
 */
class FinanceLogController extends Controller
{
    private const MODELS = ['Fee', 'Accountant', 'Account'];

    public function __construct()
    {
        $this->middleware('permission:finance-log-list');
    }

    public function index(Request $request)
    {
        $filters = $request->validate([
            'model' => 'nullable|in:' . implode(',', self::MODELS),
            'event' => 'nullable|in:created,updated,deleted',
            'admin_id' => 'nullable|integer',
            'record' => 'nullable|integer',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
        ]);

        $logs = AuditLog::query()
            ->whereIn('model', self::MODELS)
            ->when($filters['model'] ?? null, fn ($q, $model) => $q->where('model', $model))
            ->when($filters['event'] ?? null, fn ($q, $event) => $q->where('event', $event))
            ->when($filters['admin_id'] ?? null, fn ($q, $adminId) => $q->where('admin_id', $adminId))
            ->when($filters['record'] ?? null, fn ($q, $record) => $q->where('model_id', $record))
            ->when($filters['from'] ?? null, fn ($q, $from) => $q->where('created_at', '>=', Carbon::parse($from)->startOfDay()))
            ->when($filters['to'] ?? null, fn ($q, $to) => $q->where('created_at', '<=', Carbon::parse($to)->endOfDay()))
            ->orderByDesc('id')
            ->paginate(50)
            ->withQueryString();

        // Everyone who appears in the finance history, for the filter list.
        $admins = AuditLog::query()
            ->whereIn('model', self::MODELS)
            ->whereNotNull('admin_id')
            ->selectRaw('admin_id, MAX(admin_name) as admin_name')
            ->groupBy('admin_id')
            ->orderBy('admin_name')
            ->get();

        return view('admin.crud.finance-logs.index', [
            'logs' => $logs,
            'admins' => $admins,
            'filters' => $filters,
            'models' => self::MODELS,
        ]);
    }
}
