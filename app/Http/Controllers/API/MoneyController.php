<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MoneyDebt;
use App\Models\MoneyIncome;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MoneyController extends Controller
{
    private const MAX_AMOUNT = 999999999999.99;

    /**
     * GET /money?month=2026-11
     * The signed-in admin's income for that month (null when not set) and their fixed debts.
     */
    public function index(Request $request)
    {
        try {
            $data = $request->validate([
                'month' => 'required|date_format:Y-m',
            ]);
            $adminId = auth('admin-api')->id();

            $income = MoneyIncome::where('admin_id', $adminId)->where('month', $data['month'])->first();

            return successResponse([
                'month'  => $data['month'],
                'income' => $income?->amount,
                'debts'  => MoneyDebt::where('admin_id', $adminId)->orderBy('id')->get(),
            ]);
        } catch (ValidationException $e) {
            return failedResponse($e->validator->errors()->first());
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * PUT /money/income
     * Sets the income for a month; an empty amount removes it.
     */
    public function saveIncome(Request $request)
    {
        try {
            $data = $request->validate([
                'month'  => 'required|date_format:Y-m',
                'amount' => 'nullable|numeric|min:0|max:' . self::MAX_AMOUNT,
            ]);
            $adminId = auth('admin-api')->id();

            if ($data['amount'] === null) {
                MoneyIncome::where('admin_id', $adminId)->where('month', $data['month'])->delete();
                return successResponse(['month' => $data['month'], 'income' => null]);
            }

            $income = MoneyIncome::updateOrCreate(
                ['admin_id' => $adminId, 'month' => $data['month']],
                ['amount' => $data['amount']]
            );

            return successResponse(['month' => $income->month, 'income' => $income->amount]);
        } catch (ValidationException $e) {
            return failedResponse($e->validator->errors()->first());
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /money/debts
     */
    public function storeDebt(Request $request)
    {
        try {
            $data = $request->validate([
                'name'   => 'required|string|max:255',
                'amount' => 'required|numeric|min:0|max:' . self::MAX_AMOUNT,
            ]);

            return successResponse(MoneyDebt::create($data + ['admin_id' => auth('admin-api')->id()]));
        } catch (ValidationException $e) {
            return failedResponse($e->validator->errors()->first());
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * DELETE /money/debts/{id}
     */
    public function destroyDebt($id)
    {
        try {
            MoneyDebt::where('admin_id', auth('admin-api')->id())->findOrFail($id)->delete();
            return successResponse([]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return failedResponse('This debt no longer exists.');
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }
}
