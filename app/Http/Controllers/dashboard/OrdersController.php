<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $query = Order::with(['store:id,name', 'user:id,name']);

        // إذا الأدمن عنده متجر → عرض الطلبات الخاصة بمتجره فقط
        if ($user->store_id) {
            $query->where('store_id', $user->store_id);
        }

        $orders = $query->orderBy('created_at', 'DESC')->paginate(10);

        return view('dashboard.order.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

  /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['store:id,name', 'user:id,name', 'items'])->findOrFail($id);

        // Check if the user has permission to view this order
        if (Auth::user()->store_id && $order->store_id !== Auth::user()->store_id) {
            abort(403, __('Unauthorized to access this order.'));
        }

        return view('dashboard.order.show', ['order' => $order]);
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with(['items'])->findOrFail($id);

        // Check if the user has permission to edit this order
        if (Auth::user()->store_id && $order->store_id !== Auth::user()->store_id) {
            abort(403, __('Unauthorized to update this order.'));
        }

        $stores = Store::select('id', 'name')->get();
        $items = $order->items->pluck('product_name')->join(', ') ?: __('No items');

        return view('dashboard.order.edit', ['order' => $order, 'stores' => $stores, 'items' => $items]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        // Check if the user has permission to update this order
        if (Auth::user()->store_id && $order->store_id !== Auth::user()->store_id) {
            abort(403, __('Unauthorized to update this order.'));
        }

        // Validate the request
        $request->validate([
            'number' => 'required|string|max:255|unique:orders,number,' . $id,
            'store_id' => 'required|exists:stores,id',
            'payment_status' => 'required|in:pending,paid,failed',
            'status' => 'required|in:pending,processing,delivering,completed,canceled,refunded',
        ]);

        // Update the order
        $order->update([
            'number' => $request->number,
            'store_id' => $request->store_id,
            'payment_status' => $request->payment_status,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.orders.index')->with('success', __('Order updated successfully.'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        // Check if the user has permission to delete this order
        if (Auth::user()->store_id && $order->store_id !== Auth::user()->store_id) {
            abort(403, __('Unauthorized to delete this order.'));
        }

        // Delete associated order items and addresses
        $order->items()->delete();
        $order->addresses()->delete();
        $order->delete();

        return redirect()->route('dashboard.orders.index')->with('success', __('Order deleted successfully.'));
    }
}
