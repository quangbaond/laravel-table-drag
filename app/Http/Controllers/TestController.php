<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        // response pagination bootstrap table

        $order = \App\Models\OrderTable::query();
        if ($request->has('sort') && $request->sort) {
            $order->orderBy($request->sort, $request->order ?? 'asc');
        }

        if ($request->has('offset') && $request->offset) {
            $order->offset($request->offset);
        }


        if ($request->has('search') && $request->search) {
            $order->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('limit') && $request->limit) {
            $order->paginate($request->limit);
        }

        $order = $order->paginate(10);

        $row = [];

        foreach ($order as $key => $value) {
            $row[] = [
                'id' => $value->id,
                'pid' => $value->pid,
                'status' => $value->status,
                'name' => $value->name,
            ];
        }
        $total = $order->total();
        $totalNotFiltered = $order->total();

        return response()->json(
            [
                'total' => $total,
                'totalNotFiltered' => $totalNotFiltered,
                'rows' => $row
            ]
            // $order
        );
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'parentId' => 'required|integer'
        ], [
            'parentId.required' => 'Parent ID is required',
            'parentId.integer' => 'Parent ID must be an integer'
        ]);

        $order = \App\Models\OrderTable::find($id);
        if ($order) {
            $parent = $request->parentId;
            $order->pid = $parent;
            if ($parent == $order->id) {
                return response()->json(
                    ['message' => 'Parent ID cannot be the same as the ID'],
                    400
                );
            }
            $order->status = 1;
            $order->save();
            return response()->json(
                ['message' => 'Order updated successfully'],
                200
            );
        }

        return response()->json(
            ['message' => 'Order not found'],
            404
        );
    }
}
