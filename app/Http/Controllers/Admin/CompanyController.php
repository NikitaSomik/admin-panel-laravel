<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ModelNotPresentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompany;
use App\Http\Requests\UpdateCompany;
use App\Models\Company;
use App\Service\CompanyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class CompanyController extends Controller
{
    public $modelCompany;
    public $companyService;

    public function __construct(
        Company $modelCompany,
        CompanyService $companyService
    )
    {
        $this->modelCompany = $modelCompany;
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('adminlte.company.index');
    }

    public function getAllCompanies()
    {
        if (request()->ajax()) {
            return datatables()->of($this->modelCompany->all())
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompany $request
     * @return JsonResponse
     */
    public function store(StoreCompany $request): JsonResponse
    {
        $this->companyService->saveData($request->only('name', 'email', 'logo', 'website'));
        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function edit($id): JsonResponse
    {
        try {
            $data = $this->modelCompany->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Model not found', $e->getCode());
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->companyService->updateData($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            $data = $this->modelCompany->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Model not found', $e->getCode());
        }
        $data->delete();
    }
}
