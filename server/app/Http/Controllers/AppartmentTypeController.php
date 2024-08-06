<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AppartmentType;

class AppartmentTypeController extends Controller
{
  public function index() {
    try {
      $types = AppartmentType::orderBy('value', 'asc')->get();
      return response()->json([
        'appartment_types' => $types
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить список типов квартир'
      ], 500);
    }
  }

  public function add(Request $request) {
    try {
      $validatedData = $request->validate([
        'value' => 'required|string|max:20|unique:appartment_types',
        'description' => 'required|string|max:100'
      ]);

      $type = AppartmentType::create([
        'value' => $validatedData['value'],
        'description' => $validatedData['description'],
      ]);
      return response()->json([
        'message' => 'Тип успешно добавлен'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось добавить тип'
      ], 400);
    }
  }

  public function update(Request $request, $typeId) {
    try {
      $type = AppartmentType::where('id', $typeId)->first();
      if (!$type) {
        return response()->json([
          'message' => 'Типа квартир с таким ID не существует'
        ], 400);
      }

      $validatedData = $request->validate([
        'value' => ['required', 'string', 'max:20', Rule::unique('appartment_types')->ignore($type->id)],
        'description' => 'required|string|max:100'
      ]);

      $type->update($validatedData);
      return response()->json([
        'message' => 'Данные успешно обновлены'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось обновить данные'
      ], 400);
    }
  }

  public function delete($typeId) {
    try {
      $type = AppartmentType::where('id', $typeId)->first();
      if (!$type) {
        return response()->json([
          'message' => 'Типа квартир с таким ID не существует'
        ], 400);
      }

      $type->delete();
      return response()->json([
        'message' => 'Успешно удалено'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить'
      ], 500);
    }
  }
}
