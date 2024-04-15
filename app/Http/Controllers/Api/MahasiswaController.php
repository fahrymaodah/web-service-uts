<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Helpers\ApiFormatter;

use App\Models\MahasiswaModel;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = MahasiswaModel::orderby('mahasiswa_id', 'ASC')->get();

        $response = ApiFormatter::createJson(200, 'Get Data Success', $mahasiswa);
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function create(Request $request)
    {
        try {
            $params = $request->all();

            $validator = Validator::make($params, 
                [
                    'nim'   => 'required|unique:mahasiswa,mahasiswa_nim|max:20',
                    'nama'  => 'required',
                ],
                [
                    'nim.required'  => 'Mahasiswa Nim is required',
                    'nim.unique'    => 'Mahasiswa Nim is not unique',
                    'nim.max'       => 'Mahasiswa Nim must not exceed 20 characters',
                    'nama.required' => 'Mahasiswa Name is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                return response()->json($response)->header('Content-Type', 'application/json');
            }

            $mahasiswa = [
                'mahasiswa_nim'     => $params['nim'],
                'mahasiswa_nama'    => $params['nama'],
            ];

            $data = MahasiswaModel::create($mahasiswa);
            $createdMahasiswa = MahasiswaModel::find($data->mahasiswa_id);

            $response = ApiFormatter::createJson(200, 'Create mahasiswa success', $createdMahasiswa);
            return response()->json($response)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response)->header('Content-Type', 'application/json');
        }
    }

    public function detail($id)
    {
        try {
            $mahasiswa = MahasiswaModel::find($id);

            if (is_null($mahasiswa)) {
                $response = ApiFormatter::createJson(404, 'Data not found');
                return response()->json($response)->header('Content-Type', 'application/json');
            }

            $response = ApiFormatter::createJson(200, 'Get detail mahasiswa success', $mahasiswa);
            return response()->json($response)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(400, $e->getMessage());
            return response()->json($response)->header('Content-Type', 'application/json');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $params = $request->all();

            $preMahasiswa = MahasiswaModel::find($id);
            if(is_null($preMahasiswa)){
                return ApiFormatter::createJson(404, 'Data not found');
            }

            $validator = Validator::make($params, 
                [
                    'nim'   => 'required|unique:mahasiswa,mahasiswa_nim,'.$id.',mahasiswa_id|max:20',
                    'nama'  => 'required',
                ],
                [
                    'nim.required'  => 'Mahasiswa Nim is required',
                    'nim.unique'    => 'Mahasiswa Nim is not unique',
                    'nim.max'       => 'Mahasiswa Nim must not exceed 20 characters',
                    'nama.required' => 'Mahasiswa Name is required',
                ]
            );

            if ($validator->fails()) {
                $response = ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all());
                return response()->json($response)->header('Content-Type', 'application/json');
            }

            $mahasiswa = [
                'mahasiswa_nim'     => $params['nim'],
                'mahasiswa_nama'    => $params['nama'],
            ];

            $preMahasiswa->update($mahasiswa);
            $updatedMahasiswa = $preMahasiswa->fresh();

            $response = ApiFormatter::createJson(200, 'Update mahasiswa success', $updatedMahasiswa);
            return response()->json($response)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response)->header('Content-Type', 'application/json');
        }
    }

    public function delete($id)
    {
        try {
            $mahasiswa = MahasiswaModel::find($id);
            
            if (is_null($mahasiswa)){
                $response = ApiFormatter::createJson(404, 'Data not found');
                return response()->json($response)->header('Content-Type', 'application/json');
            }

            $mahasiswa->delete();

            $response = ApiFormatter::createJson(200, 'Delete mahasiswa success');
            return response()->json($response);
        } catch (\Exception $e) {
            $response = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());
            return response()->json($response);
        }
    }
}
