<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Appartment;

class AppartmentController extends Controller
{
  public function index() {
    try {
      $appartments = Appartment::orderBy('appartment_number', 'asc')->get(); // или User::all()
      return response()->json([
        'appartments' => $appartments
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить список квартир',
      ], 500);
    }
  }

  public function getEntityAppartments($entityId) {
    try {
      $appartments = Appartment::where('project_id', $entityId)->get();
      return response()->json([
        'appartments' => $appartments,
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить данные объекта',
      ], 500);
    }
  }

  public function getOne($appartmentId) {
    try {
      $appartment = Appartment::where('id', $appartmentId)->first();
      if (!$appartment) {
        return response()->json([
          'message' => "Квартиры с таким ID не существует"
        ]);
      }
      return response()->json([
        'data' => [
          'appartment' => $appartment
        ]
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить данные квартиры',
      ], 500);
    }
  }

  public function add(Request $request) {
    try {
      $validatedData = $request->validate([
        'price' => 'required|integer',
        'entrance_number' => 'required|integer',
        'floor_number' => 'required|integer',
        'appartment_number' => 'required|integer|unique:appartments',
        'rooms_number' => 'required|integer',
        'total_area' => 'required|integer',
        'kitchen_area' => 'required|integer',
        'repair_type' => 'required|string|max:30',
        'type_id' => 'required|integer',
        'entity_id' => 'required|integer',
      ]);

      $appartment = Appartment::create([
        'price' => $validatedData['price'],
        'entrance_number' => $validatedData['entrance_number'],
        'floor_number' => $validatedData['floor_number'],
        'appartment_number' => $validatedData['appartment_number'],
        'rooms_number' => $validatedData['rooms_number'],
        'total_area' => $validatedData['total_area'],
        'kitchen_area' => $validatedData['kitchen_area'],
        'repair_type' => $validatedData['repair_type'],
        'type_id' => $validatedData['type_id'],
        'entity_id' => $validatedData['entity_id'],
      ]);
    
      return response()->json([
        'message' => 'Квартира успешно добавлена',
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось добавить квартиру',
      ], 400);
    }
  }

  public function update(Request $request, $appartmentId) {
    try {
      $appartment = Appartment::where('id', $appartmentId)->first();
      if (!$appartment) {
        return response()->json([
          'message' => "Квартиры с таким ID не существует"
        ]);
      }

      $validatedData = $request->validate([
        'price' => 'required|integer',
        'entrance_number' => 'required|integer',
        'floor_number' => 'required|integer',
        'appartment_number' => ['required', 'integer', Rule::unique('appartments')->ignore($appartment->id)],
        'rooms_number' => 'required|integer',
        'total_area' => 'required|integer',
        'kitchen_area' => 'required|integer',
        'repair_type' => 'required|string|max:30',
        'type_id' => 'required|integer',
        'entity_id' => 'required|integer',
      ]);
      
      $appartment->update($validatedData);
      return response()->json([
        'message' => 'Данные квартиры успешно обновлены'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось обновить данные квартиры'
      ], 400);
    }
  }

  public function delete($appartmentId) {
    try {
      $appartment = Appartment::where('id', $appartmentId)->first();
      if (!$appartment) {
        return response()->json([
          'message' => "Квартиры с таким ID  не существует"
        ]);
      }
      $appartment->delete();
      return response()->json([
        'message' => 'Квартира успешно удалена'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить квартиру',
      ], 500);
    }
  }
}
