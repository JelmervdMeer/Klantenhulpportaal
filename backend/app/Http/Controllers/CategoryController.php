<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Toon alle categorieën
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return response()->json([
            'categories' => $categories
        ]);
    }



    /**
     * Nieuwe categorie maken
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255|unique:categories,name',

            'description' => 'nullable|string'

        ]);



        $category = Category::create([

            'name' => $validated['name'],

            'description' => $validated['description'] ?? null

        ]);



        return response()->json([

            'message' => 'Categorie aangemaakt.',

            'category' => $category

        ], 201);

    }





    /**
     * Categorie aanpassen
     */
    public function update(Request $request, Category $category)
    {

        $validated = $request->validate([

            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,

            'description' => 'nullable|string'

        ]);



        $category->update([

            'name' => $validated['name'],

            'description' => $validated['description'] ?? null

        ]);



        return response()->json([

            'message' => 'Categorie aangepast.',

            'category' => $category

        ]);

    }





    /**
     * Categorie verwijderen
     */
    public function destroy(Category $category)
    {

        $category->delete();



        return response()->json([

            'message' => 'Categorie verwijderd.'

        ]);

    }

}