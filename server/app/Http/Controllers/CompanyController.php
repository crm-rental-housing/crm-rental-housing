<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Company;

class CompanyController extends Controller
{
  public function index() {
    try {
      $companies = Company::orderBy('name', 'asc')->get(); // или Company::all()
      return response()->json([
        'companies' => $companies
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить список компаний',
      ], 400);
    }
  }

	public function getOne($companyId) {
		try {
			$company = Company::where('id', $companyId)->first();
			if (!$company) {
				return response()->json([
					'message' => 'Компаниии с таким ID не существует'
				], 404);
			}
			return response()->json([
				'company' => $company
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось получить данные компании'
			], 500);
		}
	}

	public function add(Request $request) {
		try {
			$validatedData = $request->validate([
				'name' => 'required|string|min:4|max:30|unique:companies',
				'description' => 'required|string|min:8|max:100',
				'email' => 'required|string|email|unique:companies',
				'phone_number' => 'required|string|min:6|max:12|unique:companies'
			]);
	
			$company = Company::create([
				'name' => $validatedData['name'],
				'description' => $validatedData['description'],
				'email' => $validatedData['email'],
				'phone_number' => $validatedData['phone_number'],
			]);
			return response()->json([
				'message' => 'Компания успешно добавлена'
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось добавить новую компанию'
			], 400);
		}
	}

	public function update(Request $request, $companyId) {
		try {
			$company = Company::where('id', $companyId)->first();
			if (!$company) {
				return response()->json([
					'message' => 'Компаниии с таким ID не существует'
				], 404);
			}
			// Дополнить или переделать
			if (auth()->user()->company->id !== $companyId || auth()->user()->role->value !== 'ADMIN') {
				return response()->json([
					'message' => 'У вас нет прав на обновление данных компании'
				], 400);
			}
			$validatedData = $request->validate([
				'name' => ['required', 'string', 'min:4', 'max:30', Rule::unique('companies')->ignore($company->id)],
				'description' => ['required', 'string', 'min:10', 'max:100'],
				'email' => ['required', 'string', 'email', Rule::unique('companies')->ignore($company->id)],
				'phone_number' => ['required', 'string', 'min:6', 'max:12', Rule::unique('companies')->ignore($company->id)],
			]);

			$company->update($validatedData);
			return response()->json([
				'message' => 'Данные успешно обновлены'
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось обновить данные'
			], 400);
		}
	}

	public function delete($companyId) {
		try {
			$company = Company::where('id', $companyId)->first();
			if (!$company) {
				return response()->json([
					'message' => 'Компаниии с таким ID не существует'
				], 404);
			}
			// Дополнить или переделать
			if (auth()->user()->company->id !== $companyId || auth()->user()->role->value !== 'ADMIN') {
				return response()->json([
					'message' => 'У вас нет прав на удаление компании'
				], 400);
			}
			$company->delete();
			return response()->json([
        'message' => 'Компания успешно удалена'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить компанию',
      ], 500);
    }
	}
}
