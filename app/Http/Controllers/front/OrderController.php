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
        $orders = Order::with(['store:id,name,slug', 'user:id,name'])
                       ->where('user_id', $user->id)
                       ->orderBy('created_at', 'DESC')
                       ->paginate(5);
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
            abort(403, __('Unauthorized to access this order.'));
        }

        // Load the order with products and pivot data (order_item)
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
            abort(403, __('Unauthorized to update this order.'));
        }

        // Ensure the order item belongs to the order
        if ($orderItem->order_id !== $order->id) {
            abort(403, __('The item is not associated with this order.'));
        }

        // Validate the quantity
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        // Update the order item quantity
        $orderItem->update(['quantity' => $request->quantity]);

        // Recalculate the order total
        $this->recalculateOrderTotal($order);

        return redirect()->route('orders.show', $order->id)->with('success', __('Quantity updated successfully.'));
    }

    /**
     * Remove an item from the order and delete the order if empty.
     *
     * @param \App\Models\Order $order
     * @param \App\Models\OrderItem $orderItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyItem(Order $order, OrderItem $orderItem)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, __('Unauthorized to delete this item.'));
        }

        // Ensure the order item belongs to the order
        if ($orderItem->order_id !== $order->id) {
            abort(403, __('The item is not associated with this order.'));
        }

        // Delete the order item
        $orderItem->delete();

        // Check if the order has any remaining items
        if ($order->items()->count() === 0) {
            // Delete the order and associated addresses
            $order->addresses()->delete();
            $order->delete();
            return redirect()->route('orders.index')->with('success', __('Order deleted because it has no items.'));
        }

        // Recalculate the order total
        $this->recalculateOrderTotal($order);

        return redirect()->route('orders.show', $order->id)->with('success', __('Item deleted successfully.'));
    }

    /**
     * Delete the specified order.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, __('Unauthorized to delete this order.'));
        }

        // Delete associated order items and addresses
        $order->items()->delete();
        $order->addresses()->delete();
        $order->delete();

        return redirect()->route('orders.index')->with('success', __('Order deleted successfully.'));
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
