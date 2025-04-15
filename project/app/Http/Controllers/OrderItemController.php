<?php

namespace App\Http\Controllers;

use App\Models\OrderItem; // Import the OrderItem model
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderItemController extends Controller
{
    /**
     * Display a listing of all order items.
     *
     * @return View
     */
    public function index(): View
    {
        // Get all order items from the database
        $orderItems = OrderItem::all();

        // Return the 'order_items.index' view with the list of order items
        return view('order_items.index', compact('orderItems'));
    }

    /**
     * Show the form for creating a new order item.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new order item
        return view('order_items.create');
    }

    /**
     * Store a newly created order item in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate incoming data from the create form
        $validatedData = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'book_id'  => 'required|integer|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'price'    => 'required|numeric',
        ]);

        // Create a new order item record with the validated data
        OrderItem::query()->create($validatedData);

        // Redirect to the order items index page with a success message
        return redirect()->route('order_items.index')->with('success', 'Order item created successfully.');
    }

    /**
     * Display the specified order item.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        // Find the order item by ID
        $orderItem = OrderItem::query()->find($id);

        // If the order item is not found, redirect back with an error message
        if (!$orderItem) {
            return redirect()->route('order_items.index')->with('error', 'Order item not found.');
        }

        // Return the view to display the order item details
        return view('order_items.show', compact('orderItem'));
    }

    /**
     * Show the form for editing the specified order item.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        // Find the order item by ID
        $orderItem = OrderItem::query()->find($id);

        // If the order item is not found, redirect back with an error message
        if (!$orderItem) {
            return redirect()->route('order_items.index')->with('error', 'Order item not found.');
        }

        // Return the edit form view with the order item data
        return view('order_items.edit', compact('orderItem'));
    }

    /**
     * Update the specified order item in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Find the order item by ID
        $orderItem = OrderItem::query()->find($id);

        // If the order item is not found, redirect with an error message
        if (!$orderItem) {
            return redirect()->route('order_items.index')->with('error', 'Order item not found.');
        }

        // Validate incoming data from the edit form
        $validatedData = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'book_id'  => 'required|integer|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'price'    => 'required|numeric',
        ]);

        // Update the order item record with the validated data
        $orderItem->update($validatedData);

        // Redirect to the order item's detail page with a success message
        return redirect()->route('order_items.show', $orderItem->id)->with('success', 'Order item updated successfully.');
    }

    /**
     * Remove the specified order item from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Find the order item by ID
        $orderItem = OrderItem::query()->find($id);

        // If the order item is not found, redirect back with an error message
        if (!$orderItem) {
            return redirect()->route('order_items.index')->with('error', 'Order item not found.');
        }

        // Delete the order item record from the database
        $orderItem->delete();

        // Redirect to the order items index page with a success message
        return redirect()->route('order_items.index')->with('success', 'Order item deleted successfully.');
    }
}
