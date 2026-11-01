<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TransferText;
use Illuminate\Http\Request;

/**
 * Text sent from one device to another through the SQL tab's Transfer modal. Not tied to a database
 * credential: every device logged in to the same account sees the same list.
 */
class TransferTextController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            TransferText::query()->orderByDesc('id')->paginate($request->integer('per_page', 50))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        return response()->json(TransferText::create($data), 201);
    }

    public function destroy($id)
    {
        TransferText::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
