<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ActionWithEmployee;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class EmployeeController extends Controller
{
    public $companyModel;
    public $employeeModel;

    public function __construct(
        Company $companyModel,
        Employee $employeeModel
    )
    {
        $this->companyModel = $companyModel;
        $this->employeeModel = $employeeModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws \Exception
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of($this->employeeModel->with('company')->get())
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('adminlte.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ActionWithEmployee $request
     * @return Response
     */
    public function store(ActionWithEmployee $request)
    {
        $this->employeeModel->create($request->all());
        return response()->json(['success' => 'Data Added successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     */
    public function edit($id): JsonResponse
    {
        try {
            $data['employee'] = $this->employeeModel->with('company')->findOrFail($id);
            $data['companies'] = DB::table('companies')->select('id', 'name')->get();

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
     * @param ActionWithEmployee $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ActionWithEmployee $request, $id): JsonResponse
    {
        try {
            $this->employeeModel->findOrFail($id)->update($request->all());
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'messages' => ['Model not found']
                ], 404)
            );
        }

        return response()->json(['success' => 'Data is successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        try {
            $data = $this->employeeModel->findOrFail($id);
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
