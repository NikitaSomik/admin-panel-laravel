<?php


namespace App\Service;


use App\Models\Company;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CompanyService
{

    public $modelCompany;

    public function __construct(Company $modelCompany)
    {
        $this->modelCompany = $modelCompany;
    }

    public function saveData($data)
    {
        $logo = '';
        if (isset($data['logo']) && !empty($data['logo'])) {
            $extension = $data['logo']->getClientOriginalExtension();
            $newName = uniqid();
            $path = 'images/' .$newName.'.'.$extension;
            Storage::disk('public')->put($path, File::get($data['logo']));
            $data['logo'] = $newName . '.' . $extension;
        }

        $this->modelCompany->create($data);
    }

    public function updateData($data)
    {
        $imageName = $data['hidden_image'];
        if (isset($data['logo']) && !empty($data['logo'])) {
            $rules = [
                'name'  =>  'required',
                'email' =>  'nullable|email|max:255',
                'logo'  =>  'image|max:2048',
                'website' => 'nullable|max:255'
            ];
            $error = Validator::make($data, $rules);
            if($error->fails()) {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $extension = $data['logo']->getClientOriginalExtension();
            $newName = uniqid();
            $path = 'images/' .$newName.'.'.$extension;
            Storage::disk('public')->put($path, File::get($data['logo']));
            $imageName = $newName . '.' . $extension;
        } else {
            $rules = ['name' => 'required'];

            $error = Validator::make($data, $rules);

            if($error->fails()) {
                return response()->json(['errors' => $error->errors()->all()]);
            }
        }

        $formData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'logo' => $imageName,
            'website' => $data['website']
        ];
        $this->modelCompany->find($data['hidden_id'])->update($formData);

        return response()->json(['success' => 'Data is successfully updated']);
    }

}
