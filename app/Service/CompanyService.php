<?php


namespace App\Service;

use App\Models\Company;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyService
{
    public $companyModel;

    public function __construct(Company $companyModel)
    {
        $this->companyModel = $companyModel;
    }

    public function saveData($data): void
    {
        $data['logo'] = (isset($data['logo'])
            && !empty($data['logo']))
            ? $this->saveFile($data['logo'])
            : '';

        $this->companyModel->create($data);
    }

    public function updateData(array $data, int $id): void
    {
        $imageName = (isset($data['logo']) && !empty($data['logo']))
            ? $this->saveFile($data['logo'])
            : $data['hidden_image'];

        $formData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'logo' => $imageName,
            'website' => $data['website']
        ];

        try {
            $this->companyModel->findOrFail($id)->update($formData);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'messages' => ['Model not found']
                ], 404)
            );
        }
    }

    public function saveFile($image): string
    {
        $newName = uniqid();
        $extension = $image->getClientOriginalExtension();
        $path = 'images/' .$newName.'.'.$extension;
        Storage::disk('public')->put($path, File::get($image));
        $imageName = $newName . '.' . $extension;
        return $imageName;
    }

    public function delete(int $id)
    {
        try {
            $data = $this->companyModel->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'messages' => ['Model not found']
                ], 404)
            );
        }

        if ($path = $data->logo) {
            $this->deleteFileFromStorage($path);
        }

        $data->delete();
    }

    public function deleteFileFromStorage(string $path): void
    {
        $logoPath = '/images/' . $path;
        $existFile = Storage::disk('public')->exists($logoPath);

        if ($existFile) {
            Storage::disk('public')->delete($logoPath);
        }
    }
}
