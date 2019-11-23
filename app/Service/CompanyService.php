<?php


namespace App\Service;

use App\Models\Company;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyService
{

    public $modelCompany;

    public function __construct(Company $modelCompany)
    {
        $this->modelCompany = $modelCompany;
    }

    public function saveData($data)
    {
        $data['logo'] = (isset($data['logo']) && !empty($data['logo']))
            ? $this->saveFile($data['logo'])
            : '';

        $this->modelCompany->create($data);
    }

    public function updateData(array $data, int $id)
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
            $this->modelCompany->findOrFail($id)->update($formData);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'messages' => ['Model not found']
                ], 404)
            );
        }
    }

    public function saveFile($image)
    {
        $extension = $image->getClientOriginalExtension();
        $newName = uniqid();
        $path = 'images/' .$newName.'.'.$extension;
        Storage::disk('public')->put($path, File::get($image));
        $imageName = $newName . '.' . $extension;
        return $imageName;
    }

}
