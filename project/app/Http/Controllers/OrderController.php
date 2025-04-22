<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class OrderController extends Controller
{
    /**
     * Constructor: Apply the "check.role" middleware to all modifying actions.
     * These actions are reserved for users with admin or moderator roles.
     */
    public function __construct()
    {
        // Apply the 'check.role' middleware only to methods that update, delete, or modify order items.
        $this->middleware('check.role')->only(['update', 'destroy', 'storeItem', 'destroyItem']);
    }

    /**
     * Display a listing of orders for the authenticated user.
     *
     * @return View
     */
    public function index(): View
    {
        $user = auth()->user();

        // Retrieve orders for the logged-in user.
        // For guest orders, you may need a different mechanism.
        $orders = $user ? Order::query()->where('user_id', $user->id)->get() : collect();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the checkout form.
     * This page collects shipping and payment details.
     *
     * @return View
     */
    public function create(): View
    {
        return view('orders.create');
    }

    /**
     * Process checkout: Create an order from the items in the cart.
     *
     * This method validates shipping information and guest email (if user not logged in),
     * calculates the total amount using book prices and quantities from the session cart,
     * creates the order record along with its associated order items, and clears the cart.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function checkout(Request $request): RedirectResponse
    {
        // Validate checkout fields (for guest checkout, guest_email is required)
        $validated = $request->validate([
            'guest_email'         => 'required_without:auth|email',
            'shipping_name'       => 'required|string|max:255',
            'shipping_address'    => 'required|string|max:255',
            'shipping_city'       => 'required|string|max:100',
            'shipping_state'      => 'nullable|string|max:100',
            'shipping_postal_code'=> 'required|string|max:20',
            'shipping_country'    => 'required|string|max:100',
        ]);

        // Retrieve the cart from session
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $total = 0;
        $orderItemsData = [];

        // Loop over the cart items to calculate the total and prepare order items data
        foreach ($cart as $bookId => $quantity) {
            $book = Book::query()->find($bookId);
            if (!$book) {
                continue; // Skip missing books
            }
            $subtotal = $book->price * $quantity;
            $total += $subtotal;
            $orderItemsData[] = [
                'book_id'  => $bookId,
                'quantity' => $quantity,
                'price'    => $book->price,
            ];
        }

        if (empty($orderItemsData)) {
            return redirect()->back()->with('error', 'Your cart items are invalid.');
        }

        // Prepare order data
        $user = auth()->user();
        $orderData = [
            'order_date'         => now(),
            'total_amount'       => $total,
            'status'             => 'pending',
            'shipping_name'      => $validated['shipping_name'],
            'shipping_address'   => $validated['shipping_address'],
            'shipping_city'      => $validated['shipping_city'],
            'shipping_state'     => $validated['shipping_state'] ?? null,
            'shipping_postal_code' => $validated['shipping_postal_code'],
            'shipping_country'   => $validated['shipping_country'],
        ];

        if ($user) {
            $orderData['user_id'] = $user->id;
        } else {
            $orderData['guest_email'] = $validated['guest_email'];
        }

        // Create the order record
        $order = Order::query()->create($orderData);

        // Create order items for the order
        foreach ($orderItemsData as $itemData) {
            $itemData['order_id'] = $order->id;
            OrderItem::query()->create($itemData);
        }

        // Clear the cart
        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully.');
    }

    /**
     * Display the specified order along with its items.
     * Users can only view their own orders.
     *
     * @param Order $order
     * @return View|RedirectResponse
     */
    public function show(Order $order): View|RedirectResponse
    {
        $user = auth()->user();
        // If the order is associated with a user, ensure it belongs to the current user.
        if ($order->user_id && (!$user || $order->user_id !== $user->id)) {
            return redirect()->route('orders.index')
                ->with('error', 'Order not found or you are not authorized to view it.');
        }

        // Eager load order items
        $order->load('items');

        return view('orders.show', compact('order'));
    }

    /**
     * Update the specified order in storage.
     * This action is reserved for admin/moderator users.
     *
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $validatedData = $request->validate([
            'user_id'      => 'nullable|integer|exists:users,id',
            'guest_email'  => 'nullable|email',
            'order_date'   => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'status'       => 'nullable|string|in:pending,completed,canceled|max:50',
        ]);

        $order->update($validatedData);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     * This action is reserved for admin/moderator users.
     *
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Store a new order item for a specific order.
     * Only admin or moderator users are allowed to add items.
     *
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function storeItem(Request $request, Order $order): RedirectResponse
    {
        // Validate incoming data for creating an order item.
        $validatedData = $request->validate([
            'book_id'  => 'required|integer|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'price'    => 'required|numeric|min:0',
        ]);

        // Set the order_id in the validated data.
        $validatedData['order_id'] = $order->id;

        OrderItem::query()->create($validatedData);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order item added successfully.');
    }

    /**
     * Remove a specific order item from an order.
     * Only admin or moderator users are allowed to delete order items.
     *
     * @param Order $order
     * @param int $itemId
     * @return RedirectResponse
     */
    public function destroyItem(Order $order, int $itemId): RedirectResponse
    {
        $orderItem = $order->items()->find($itemId);
        if (!$orderItem) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Order item not found.');
        }

        $orderItem->delete();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order item deleted successfully.');
    }
    public function showDelivery()
    {
        return view('basket.delivery', ['step' => 1]);
    }

    public function showShippingPayment()
    {
        return view('basket.shipping-payment', ['step' => 2]);
    }
    public function storeShipping(Request $request)
    {
        $validated = $request->validate([
            'shipping' => 'required|string',
            'payment' => 'required|string',
        ]);

        // Store shipping and payment methods in session
        session()->put('shipping_details', $validated);
        return redirect()->route('checkout.summary');
    }
    public function storeDelivery(Request $request)
    {
        // Validate and store shipping info in session or DB
        session()->put('info', $request->only(['name', 'email', 'address', 'country']));
        return redirect()->route('checkout.shippingpayment');
    }
    public function showSummary()
    {
        $shipping = session('shipping');
        $cart = session('cart', []);
        return view('basket.summary', compact('shipping', 'cart'))->with('step', 3);
    }
    public function confirmOrder(Request $request)
    {
        $cart = session('cart', []);
        $shipping = session('shipping_details', []);
        $delivery = session('info', []);

        //  save into db

        session()->forget(['cart', 'shipping_details', 'delivery_info']);

        return redirect()->route('homepage')->with('success', 'Your order has been confirmed!');
    }

}
