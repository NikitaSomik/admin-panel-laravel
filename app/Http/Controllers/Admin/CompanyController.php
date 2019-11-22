<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Service\CompanyService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


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

        return view('adminlte.company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
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
        return response()->json(['success' => 'Data Added successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
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
     * @throws HttpResponseException
     */
    public function edit($id): JsonResponse
    {
        try {
            $data = $this->modelCompany->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'messages' => ['Model not found']
                ], 404)
            );
        }

        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCompany $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StoreCompany $request, $id): JsonResponse
    {
        $this->companyService->updateData($request->all());
        return response()->json(['success' => 'Data is successfully updated'], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @throws HttpResponseException
     */
    public function destroy($id)
    {
        try {
            $data = $this->modelCompany->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'messages' => ['Model not found']
                ], 404)
            );
        }
        $data->delete();
    }
}
