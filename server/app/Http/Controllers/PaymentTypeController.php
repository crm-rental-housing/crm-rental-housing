<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PaymentType;

class PaymentTypeController extends Controller
{
  public function index() {
		try {
			$payments = PaymentType::orderBy('name', 'asc')->get();
			return response()->json([
				'payment_types' => $payments
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось получить список способов оплаты'
			], 500);
		}
  }

	public function getOne($paymentId) {
		try {
			$payment = PaymentType::where('id', $paymentId)->first();
			if (!$payment) {
				return response()->json([
					'message' => 'Способа оплаты с таким ID не существует'
				], 400);
			}
			return response()->json([
				'payment_type' => $payment
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось получить данные о способе оплаты'
			], 500);
		}
	}

	public function add(Request $request) {
		try {
			$validatedData = $request->validate([
				'name' => ['required', 'string', 'min:4', 'max:20', 'unique:payment_types'],
				'description' => ['required', 'string', 'min:4', 'max:100']
			]);

			$payment = PaymentType::create([
				'name' => $validatedData['name'],
				'description' => $validatedData['description']
			]);
			return response()->json([
				'message' => 'Способ оплаты успешно добавлен'
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось добавить способ оплаты'
			], 400);
		}
	}

	public function update(Request $request, $paymentId) {
		try {
			$payment = PaymentType::where('id', $paymentId)->first();
			if (!$payment) {
				return response()->json([
					'message' => 'Способа оплаты с таким ID не существует'
				], 400);
			}

			$validatedData = $request->validate([
				'name' => ['required', 'string', 'min:4', 'max:20', Rule::unique('payment_types')->ignore($payment->id)],
				'description' => ['required', 'string', 'min:4', 'max:100']
			]);

			$payment->update($validatedData);
			return response()->json([
				'message' => 'Данные успешно обновлены'
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось обновить данные способа оплаты'
			], 400);
		}
	}

	public function delete($paymentId) {
		try {
			$payment = PaymentType::where('id', $paymentId)->first();
			if (!$payment) {
				return response()->json([
					'message' => 'Способа оплаты с таким ID не существует'
				], 400);
			}
			$payment->delete();
			return response()->json([
        'message' => 'Способ оплаты успешно удалена'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить способ оплаты',
      ], 500);
    }
	}
}
