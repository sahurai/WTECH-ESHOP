<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     *
     * @return View
     */
    public function index(): View
    {
        // Get all orders from the database
        $orders = Order::all();

        // Return the 'orders.index' view with the list of orders
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new order
        return view('orders.create');
    }

    /**
     * Store a newly created order in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate incoming data from the create form
        $validatedData = $request->validate([
            'user_id'      => 'required|integer|exists:users,id',
            'order_date'   => 'nullable|date',
            'total_amount' => 'required|numeric',
            'status'       => 'nullable|string|max:50',
        ]);

        // If order_date is not provided, set current timestamp
        if (empty($validatedData['order_date'])) {
            $validatedData['order_date'] = now();
        }

        // Create a new order record with the validated data
        Order::query()->create($validatedData);

        // Redirect to the orders index page with a success message
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified order.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        // Find the order by ID
        $order = Order::query()->find($id);

        // If the order is not found, redirect back with an error message
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        // Return the view to display the order details
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        // Find the order by ID
        $order = Order::query()->find($id);

        // If the order is not found, redirect back with an error message
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        // Return the edit form view with the order data
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Find the order by ID
        $order = Order::query()->find($id);

        // If the order is not found, redirect with an error message
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        // Validate incoming data from the edit form
        $validatedData = $request->validate([
            'user_id'      => 'required|integer|exists:users,id',
            'order_date'   => 'nullable|date',
            'total_amount' => 'required|numeric',
            'status'       => 'nullable|string|max:50',
        ]);

        // Update the order record with the validated data
        $order->update($validatedData);

        // Redirect to the order's detail page with a success message
        return redirect()->route('orders.show', $order->id)->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Find the order by ID
        $order = Order::query()->find($id);

        // If the order is not found, redirect back with an error message
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        // Delete the order record from the database
        $order->delete();

        // Redirect to the orders index page with a success message
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
