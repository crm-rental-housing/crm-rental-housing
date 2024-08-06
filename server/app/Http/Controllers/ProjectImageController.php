<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectImage;
use App\Models\Project;

class ProjectImageController extends Controller
{
  public function index($projectId) {
		try {
			$images = PaymentType::where('project_id', $projectId)->get();
			return response()->json([
				'images' => $images
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось получить список изображений проекта'
			], 500);
		}
  }

	public function add(Request $request, $projectId) {
		try {
			$validatedData = $request->validate([
				'image' => ['required', 'string', 'unique:project_images'],
			]);

			$imageURL = $request->file('image')->store('images', 'public');

			$image = ProjectImage::create([
				'image_url' => $imageURL,
				'project_id' => $projectId
			]);
			return response()->json([
				'message' => 'Изображение успешно добавлено'
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось добавить изображение'
			], 400);
		}
	}

	public function delete($imageId) {
		try {
			$image = ProjectImage::where('id', $imageId)->first();
			if (!$image) {
				return response()->json([
					'message' => 'Изображения с таким ID не существует'
				], 400);
			}
			Storage::disk('public')->delete($image->image_url);
			$image->delete();
			return response()->json([
        'message' => 'Изображение успешно удалено'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить изображение',
      ], 500);
    }
	}
}
