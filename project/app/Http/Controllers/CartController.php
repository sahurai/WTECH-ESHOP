<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{
    /**
     * Display the current user's cart.
     *
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        // Retrieve the cart from session (structure: [book_id => quantity])
        $cart = session()->get('cart', []);

        // Get book details for books in the cart. Use keyBy() for convenient lookups.
        $books = [];
        if (!empty($cart)) {
            $books = Book::query()->whereIn('id', array_keys($cart))->get()->keyBy('id');
        }
        $totalPrice=0;
        foreach ($cart as $bookId => $quantity) {
            if (isset($books[$bookId])) {
                $totalPrice += $books[$bookId]->price * $quantity;
            }
        }

        // Return the cart view with the cart data and associated books.
        return view('basket.basket', compact('cart', 'books','totalPrice'));
    }

    /**
     * Add a book to the cart.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function add(Request $request): RedirectResponse
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'book_id'  => 'required|integer|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($validated['book_id']);
  
        $cart = session()->get('cart', []);

        // Get current quantity of this book in the cart (if any)
        $existingQty = $cart[$book->id] ?? 0;

        // Calculate new total quantity
        $totalQty = $existingQty + $validated['quantity'];

        // Prevent adding more items than available in stock
        if ($totalQty > $book->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Not enough books in stock.']);
        }


        // Add or update the book quantity in the cart
        $cart[$book->id] = $totalQty;
        session()->put('cart', $cart);
    
        return redirect()->back()->with('success', 'Book added to cart.');
    }

    /**
     * Update the quantity of a specific book in the cart.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(Request $request): RedirectResponse
    {
        // Validate incoming data.
        $validated = $request->validate([
            'book_id'  => 'required|integer|exists:books,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$validated['book_id']])) {
            if ((int)$validated['quantity'] === 0) {
                unset($cart[$validated['book_id']]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Book removed from cart.');
            }
             // Update quantity
            $cart[$validated['book_id']] = $validated['quantity'];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully.');
        }

        return redirect()->back()->with('error', 'Book not found in cart.');
    }

    /**
     * Remove a specific book from the cart.
     *
     * @param int $bookId
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function remove(int $bookId): RedirectResponse
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$bookId])) {
            unset($cart[$bookId]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Book removed from cart.');
        }
        return redirect()->back()->with('error', 'Book not found in cart.');
    }

    /**
     * Clear the entire cart.
     *
     * @return RedirectResponse
     */
    public function clear(): RedirectResponse
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared.');
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
