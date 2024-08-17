<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Deal;
use App\Models\Appartment;

class DealController extends Controller
{
  public function index($companyId) {
    if (auth()->user()->role->value !== 'ADMIN' || auth()->user()->company_id !== $companyId) {
      return response()->json([
        'message' => 'У вас нет прав для просмотра этого ресурса'
      ], 400);
    }

    $deals = [];
    foreach(Deal::where('company_id', $companyId)->cursor() as $deal) {
      $deals[] =[
        'client' => [
          'first' => $deal->cilent->info ? $deal->info->first_name : null,
          'last' => $deal->cilent->info ? $deal->info->last_name : null,
          'email' => $deal->client->email,
        ],
        'employee' => [
          'first' => $deal->employee->info ? $deal->info->first_name : null,
          'last' => $deal->employee->info ? $deal->info->last_name : null,
          'email' => $deal->employee->email,
        ],
        'company' => $deal->company->name,
        'appartment' => [
          'address' => [
            'city' => $deal->appartment->entity->city,
            'street' => $deal->appartment->entity->street,
            'house' => $deal->appartment->entity->house,
          ],
          'floor' => $deal->appartment->floor_number,
          'entrance' => $deal->appartment->entrance_number,
          'number' => $deal->appartment->appartment_number,
        ],
        'payment_type' => $deal->payment_type->value,
      ];
    }

    if (empty($deals)) {
      return response()->json([
        'message' => 'В данной компании еще не было сделок'
      ]);
    }

    return response()->json([
      'deals' => $deals,
    ]);
  }

  public function getDeals() {
    $user = auth()->user();
    $deals = [];
    foreach(Deal::where('employee_id', $user->id)->cursor() as $deal) {
      $deals[] =[
        'client' => [
          'first' => $deal->cilent->info ? $deal->info->first_name : null,
          'last' => $deal->cilent->info ? $deal->info->last_name : null,
          'email' => $deal->client->email,
        ],
        'employee' => [
          'first' => $deal->employee->info ? $deal->info->first_name : null,
          'last' => $deal->employee->info ? $deal->info->last_name : null,
          'email' => $deal->employee->email,
        ],
        'company' => $deal->company->name,
        'appartment' => [
          'address' => [
            'city' => $deal->appartment->entity->city,
            'street' => $deal->appartment->entity->street,
            'house' => $deal->appartment->entity->house,
          ],
          'floor' => $deal->appartment->floor_number,
          'entrance' => $deal->appartment->entrance_number,
          'number' => $deal->appartment->appartment_number,
        ],
        'payment_type' => $deal->payment_type->value,
      ];
    }

    if (empty($deals)) {
      return response()->json([
        'message' => 'У данного пользователя еще не было сделок'
      ]);
    }

    return response()->json([
      'deals' => $deals,
    ]);
  }

  public function getOne($dealId) {
    $deal = Deal::where('id', $dealId)->first();
    if (
      auth()->user()->id !== $deal->employee_id || 
      auth()->user()->id !== $deal->client_id || 
      auth()->user()->role->value !== 'ADMIN'
    ) {
      return response()->json([
        'message' => 'У вас нет прав на просмотр данного ресурса'
      ], 400);
    }

    return response()->json([
      'deal' => [
        'client' => [
          'first' => $deal->cilent->info ? $deal->info->first_name : null,
          'last' => $deal->cilent->info ? $deal->info->last_name : null,
          'email' => $deal->client->email,
        ],
        'employee' => [
          'first' => $deal->employee->info ? $deal->info->first_name : null,
          'last' => $deal->employee->info ? $deal->info->last_name : null,
          'email' => $deal->employee->email,
        ],
        'company' => $deal->company->name,
        'appartment' => [
          'address' => [
            'city' => $deal->appartment->entity->city,
            'street' => $deal->appartment->entity->street,
            'house' => $deal->appartment->entity->house,
          ],
          'floor' => $deal->appartment->floor_number,
          'entrance' => $deal->appartment->entrance_number,
          'number' => $deal->appartment->appartment_number,
        ],
        'payment_type' => $deal->payment_type->value,
      ],
    ]);
  }

  public function add(Request $request) {
    $validatedData = Validator::make($request->all(), [
      'client_id' => 'required',
      'appartment_id' => 'required'
    ]);

    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод'
      ], 400);
    }
    $client = User::where('id', $request['client_id'])->first();
    if (!$client) {
      return response()->json([
        'message' => 'Клиента с таким ID не существует'
      ], 404);
    }
    if ($client->role->value !== 'USER') {
      return response()->json([
        'message' => 'Невозможно заключить сделку с сотрудником системы'
      ], 400);
    }
    $payment_type_id = Appartment::where('id', $request['appartment_id'])->first()->entity->payment_type->id;
    if (!$payment_type_id) {
      return response()->json([
        'message' => 'Квартиры с таким ID не существует'
      ], 404);
    }
    Deal::create([
      'client_id' => $client->id,
      'employee_id' => auth()->user()->id,
      'company_id' => auth()->user()->company_id,
      'appartment_id' => $request['appartment_id'],
      'payment_type_id' => $payment_type_id,
    ]);

    return response()->json([
      'message' => 'Сделка успешно заключена'
    ]);
  }

  public function update(Request $request, $dealId) {
    $deal = Deal::where('id', $dealId)->first();
    if (!$deal) {
      return response()->json([
        'message' => 'Сделки с таким ID не существует'
      ], 404);
    }

    if (auth()->user()->id !== $deal->employee_id || auth()->user()->role->value !== 'ADMIN') {
      return response()->json([
        'message' => 'У вас нет прав на редактирование данного ресурса'
      ], 400);
    }

    $validatedData = Validator::make($request->all(), [
      'client_id' => 'required',
      'appartment_id' => 'required'
    ]);

    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод'
      ], 400);
    }

    $client = User::where('id', $request['client_id'])->first();
    if (!$client) {
      return response()->json([
        'message' => 'Клиента с таким ID не существует'
      ], 404);
    }
    if ($client->role->value !== 'USER') {
      return response()->json([
        'message' => 'Невозможно заключить сделку с сотрудником системы'
      ], 400);
    }
    
    $appartment = Appartment::where('id', $request['appartment_id'])->first();
    if (!$appartment) {
      return response()->json([
        'message' => 'Квартиры с таким ID не существует'
      ], 404);
    }
    $newDeal = [
      'client_id' => $client->id,
      'employee_id' => $deal->employee_id,
      'company_id' => $deal->company_id,
      'appartment_id' => $appartment->id,
      'payment_type_id' => $deal->payment_type_id,
    ];

    $deal->update($newDeal);
    return response()->json([
      'message' => 'Сделка успешно обновлена'
    ]);
  }

  public function delete($dealId) {
    $deal = Deal::where('id', $dealId)->first();
    if (!$deal) {
      return response()->json([
        'message' => 'Сделки с таким ID не существует'
      ], 404);
    }

    if (auth()->user()->id !== $deal->employee_id || auth()->user()->role->value !== 'ADMIN') {
      return response()->json([
        'message' => 'У вас нет прав на удаление данного ресурса'
      ], 400);
    }

    $delete->delete();
    return response()->json([
      'message' => 'Сделка успешно удалена'
    ]);
  }
}
