<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $lista_productos_all = Producto::orderBy('codigo', 'asc')
                ->get();

            return response()->json(
                [
                    'request_date_time' => date('Y-m-d H:i:s'),
                    'status' => 'éxito',
                    'message' => 'éxito al fetch listado de productos',
                    'data' => $lista_productos_all
                ],
                200,
                [],
                JSON_PRETTY_PRINT
            );

        } catch (\Exception $ex) {
            return response()->json(
                [
                'request_date_time' => date('Y-m-d H:i:s'),
                'status' => 'error',
                'data' => $ex->getMessage()
                ]
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $producto_request_body = $request->all();

            $producto_post = Producto::create($producto_request_body);

            return response()->json(
                [
                    'request_date_time' => date('Y-m-d H:i:s'),
                    'status' => 'éxito',
                    'message' => 'éxito al crear el producto',
                    'data' => $producto_post
                ],
                200,
                [],
                JSON_PRETTY_PRINT
            );

        } catch (\Exception $ex) {
            return response()->json(
                [
                'request_date_time' => date('Y-m-d H:i:s'),
                'status' => 'error al crear el producto',
                'data' => $ex->getMessage()
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $value)
    {
        try {
            $cad = '%' . $value . '%';

            $productos_search = Producto::where('codigo', 'LIKE', $cad)
                ->orWhere('nombre', 'LIKE', $cad)
                ->orWhere('descripcion', 'LIKE', $cad)
                ->orWhere('descripcion', 'LIKE', $cad)
                ->get();

            return response()->json([
                'status' => 'éxito',
                'message' => 'éxito al encontrar resultados de productos',
                'request_date_time' => date('Y-m-d H:i:s'),
                'data' => $productos_search
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $producto_to_update = Producto::findOrFail($id);

            $producto_to_update->update($request->all());

            return response()->json(
                [
                'request_date_time' => date('Y-m-d H:i:s'),
                'status' => 'éxito',
                'message' => 'éxito al actualizar el producto',
                'data' => $producto_to_update
                ],
                200,
                [],
                JSON_PRETTY_PRINT
            );

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $producto_to_delete = Producto::findOrFail($id);

            $producto_to_delete->delete();

            return response()->json([
                'status' => 'éxito',
                'message' => 'Producto eliminado correctamente',
                'request_date_time' => date('Y-m-d H:i:s')
            ]);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => $ex->getMessage()
            ]);
        }
    }
}
