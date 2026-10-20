<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Procedure;
use Illuminate\Http\Request;

/**
 * A procedure is a titled script of SELECT queries ("select_queries", separated by ";") that the SQL
 * tab runs in order to follow a process step by step.
 */
class ProcedureController extends Controller
{
    /** Words that must not appear in a procedure (outside quotes): it is read-only by design. */
    private const FORBIDDEN = '/\b(insert|update|delete|drop|alter|truncate|create|grant|revoke|merge|call|copy|into)\b/i';

    public function index(Request $request)
    {
        $query = Procedure::query();

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('select_queries', 'like', '%' . $search . '%');
            });
        }

        return response()->json(
            $query->orderByDesc('id')->paginate($request->integer('per_page', 50))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'select_queries' => 'required|string',
        ]);

        $this->assertReadOnly($data['select_queries']);

        return response()->json(Procedure::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Procedure::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $procedure = Procedure::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'select_queries' => 'sometimes|required|string',
        ]);

        if (isset($data['select_queries'])) {
            $this->assertReadOnly($data['select_queries']);
        }

        $procedure->update($data);

        return response()->json($procedure);
    }

    public function destroy($id)
    {
        Procedure::findOrFail($id)->delete();

        return response()->json(null, 204);
    }

    /** 422 unless every statement is a SELECT (or WITH ... SELECT) that changes nothing. */
    private function assertReadOnly(string $script): void
    {
        $statements = $this->statements($script);

        if (!$statements) {
            $this->reject('Add at least one SELECT query.');
        }

        foreach ($statements as $i => $statement) {
            $n = $i + 1;
            // quoted text (strings, identifiers) is not code: blank it before checking keywords
            $code = preg_replace('/\'(?:[^\']|\'\')*\'|"(?:[^"]|"")*"|`[^`]*`/s', "''", $statement);

            if (!preg_match('/^\s*(select|with)\b/i', $code)) {
                $this->reject("Query $n must start with SELECT (or WITH).");
            }
            if (preg_match(self::FORBIDDEN, $code, $m)) {
                $this->reject("Query $n contains \"" . strtoupper($m[1]) . '" - procedures can only read data.');
            }
        }
    }

    /** Splits on ";" outside quotes and drops comments and empty statements. */
    private function statements(string $script): array
    {
        $statements = [];
        $current = '';
        $quote = null;
        $length = strlen($script);

        for ($i = 0; $i < $length; $i++) {
            $char = $script[$i];
            $next = $script[$i + 1] ?? '';

            if ($quote) {
                $current .= $char;
                if ($char === $quote) {
                    if ($next === $quote) { // doubled quote: still inside the string
                        $current .= $next;
                        $i++;
                    } else {
                        $quote = null;
                    }
                }
                continue;
            }

            if ($char === '-' && $next === '-') { // line comment
                $end = strpos($script, "\n", $i);
                $i = $end === false ? $length : $end;
                continue;
            }
            if ($char === '/' && $next === '*') { // block comment
                $end = strpos($script, '*/', $i + 2);
                $i = $end === false ? $length : $end + 1;
                continue;
            }
            if ($char === "'" || $char === '"' || $char === '`') {
                $quote = $char;
                $current .= $char;
                continue;
            }
            if ($char === ';') {
                if (trim($current) !== '') {
                    $statements[] = trim($current);
                }
                $current = '';
                continue;
            }

            $current .= $char;
        }

        if (trim($current) !== '') {
            $statements[] = trim($current);
        }

        return $statements;
    }

    private function reject(string $message): void
    {
        throw \Illuminate\Validation\ValidationException::withMessages(['select_queries' => [$message]]);
    }
}
