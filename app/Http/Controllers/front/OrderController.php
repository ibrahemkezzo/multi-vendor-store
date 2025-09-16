<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Order::with(['store:id,name', 'user:id,name'])->where('user_id', $user->id)->paginate(5);
        return view('front.orders.index', ['orders' => $orders]);
    }

    /**
     * Display the specified order with its products.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بالوصول إلى هذا الطلب.');
        }

        // Load the order with products and order items
        $order->load('products:id,slug,name,description,image');

        return view('front.orders.show', compact('order'));
    }

    /**
     * Update the quantity of an order item.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @param \App\Models\OrderItem $orderItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateItem(Request $request, Order $order, OrderItem $orderItem)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتحديث هذا الطلب.');
        }

        // Ensure the order item belongs to the order
        if ($orderItem->order_id !== $order->id) {
            abort(403, 'العنصر غير مرتبط بهذا الطلب.');
        }

        // Validate the quantity
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        // Update the order item quantity
        $orderItem->update(['quantity' => $request->quantity]);

        // Recalculate the order total
        $this->recalculateOrderTotal($order);

        return redirect()->route('orders.show', $order->id)->with('success', 'تم تحديث الكمية بنجاح.');
    }

    /**
     * Remove an item from the order.
     *
     * @param \App\Models\Order $order
     * @param \App\Models\OrderItem $orderItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyItem(Order $order, OrderItem $orderItem)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بحذف هذا العنصر.');
        }

        // Ensure the order item belongs to the order
        if ($orderItem->order_id !== $order->id) {
            abort(403, 'العنصر غير مرتبط بهذا الطلب.');
        }

        // Delete the order item
        $orderItem->delete();

        // Recalculate the order total
        $this->recalculateOrderTotal($order);

        return redirect()->route('orders.show', $order->id)->with('success', 'تم حذف العنصر بنجاح.');
    }

    /**
     * Recalculate the order total after updating or deleting an item.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    protected function recalculateOrderTotal(Order $order)
    {
        $total = $order->items()->sum(DB::raw('price * quantity'));
        $order->update([
            'total' => $total + $order->tax + $order->shipping - $order->discount,
        ]);
    }
}
