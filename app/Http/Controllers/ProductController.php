<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {     
        $products = Product::all();
        return response()->json([ 
            'success' => true,
            'data' => $products     
        ], 200); // OK
    } 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        try {
            $request->validate([ 
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer' 
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bad Request: Invalid input',
                'errors' => $e->errors()
            ], 400); // Bad Request
        }

        $product = Product::create($request->all());
        return response()->json([ 
            'success' => true,
            'data' => $product
        ], 201); // Created
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {     
        $product = Product::find($id); 
        if (!$product) {
            return response()->json([
                'success' => false, 
                'message' => 'Product not found'
            ], 404); // Not Found
        }    

        return response()->json([  
            'success' => true, 
            'data' => $product     
        ], 200); // OK
    } 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {     
        $product = Product::find($id);
        
        if (!$product) { 
            return response()->json([
                'success' => false, 
                'message' => 'Product not found'
            ], 404); // Not Found
        }    

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bad Request: Invalid input',
                'errors' => $e->errors()
            ], 400); // Bad Request
        }
        
        $product->update($request->all());
        return response()->json([
            'success' => true,
            'data' => $product
        ], 200); // OK
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    { 
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false, 
                'message' => 'Product not found'
            ], 404); // Not Found
        } 
        
        $product->delete();
        return response()->json([
            'success' => true, 
            'message' => 'Product deleted successfully'
        ], 204); // No Content
    } 

    /**
     * Example of Unauthorized (401) Error
     */
    public function unauthorizedExample()
    {
        return response()->json([
            'success' => false, 
            'message' => 'Unauthorized access'
        ], 401); // Unauthorized
    }

    /**
     * Example of Forbidden (403) Error
     */
    public function forbiddenExample()
    {
        return response()->json([
            'success' => false, 
            'message' => 'Forbidden: You do not have access to this resource'
        ], 403); // Forbidden
    }

    /**
     * Example of Method Not Allowed (405) Error
     */
    public function methodNotAllowedExample()
    {
        return response()->json([
            'success' => false, 
            'message' => 'Method Not Allowed'
        ], 405); // Method Not Allowed
    }

    /**
     * Example of Accepted (202) Response
     */
    public function acceptedExample()
    {
        return response()->json([
            'success' => true, 
            'message' => 'Request accepted, processing in progress'
        ], 202); // Accepted
    }
}