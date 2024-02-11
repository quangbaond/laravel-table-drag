<?php

namespace App\Http\Controllers;

use App\Models\OrderTable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $orderTables = OrderTable::all();

        $orderTables = $orderTables->toArray();
        $orderTables = $this->buildTree($orderTables);
        // covert to collection
        $orderTables = collect($orderTables);
        return view('welcome', compact('orderTables'));
    }

    private function buildTree(array $elements, $parentId = null): array
    {
        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] === $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                } else {
                    $element['children'] = [];
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public function update(Request $request, $childrenId)
    {
        $request->validate([
            'parent_id' => 'required|integer'
        ], [
            'parent_id.required' => 'Please select parent',
            'parent_id.integer' => 'Parent must be a number'
        ]);
        $orderTable = OrderTable::find($childrenId);
        $orderTable->parent_id = $request->parent_id;
        $orderTable->save();
        return response()->json(['message' => 'success']);
    }
}
