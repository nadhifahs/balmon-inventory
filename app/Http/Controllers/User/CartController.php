<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $mainPageTitle = 'User Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Home User';

        $cart = Auth::user()
            ->cart()
            ->where('status', 'WAITING')
            ->first();
        if ($cart == null) {
            return redirect()
                ->route('rent.index')
                ->with('error', 'Tambahkan barang terlebih dahulu');
        }

        if ($request->ajax()) {
            $cartProduct = $cart
                ->cart_detail()
                ->with('product')
                ->whereStatus(null)
                ->select();
            return datatables()
                ->of($cartProduct)
                ->addIndexColumn()
                ->addColumn('action', function ($query) {
                    return $this->getActionColumn($query);
                })
                ->addColumn('delete', function ($query) {
                    return $this->getDeleteColumn($query);
                })
                ->rawColumns(['action', 'delete'])
                ->make(true);
        }

        return view('user.cart.index', compact('mainPageTitle', 'subPageTitle', 'pageTitle', 'cart'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required',
            'product_id' => 'required',
        ]);
        $product = Product::whereId($request->product_id)->first();
        $quantity = $product->quantity;

        if ($quantity < $request->quantity) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Failed Update Quantity, Stock Not Found');
        }

        $product->decrement('quantity', $request->quantity);

        $cart = Auth::user()
            ->cart()
            ->where('status', 'WAITING')
            ->first()
            ->cart_detail()
            ->updateOrCreate(
                [
                    'product_id' => $request->product_id,
                ],
                [
                    'quantity' => $request->quantity,
                ],
            );

        return redirect()
            ->route('cart.index')
            ->with('status', 'Successfully update product quantity');
    }

    public function destroy($id)
    {
        try {
            $dataCartDetail = CartDetail::whereId($id);
            Product::whereId($dataCartDetail->first()->product_id)
                ->first()
                ->increment('quantity', $dataCartDetail->first()->quantity);

            $dataCartDetail->delete();
            return redirect()
                ->route('cart.index')
                ->with('status', 'Successfully Delete Product from Cart');
        } catch (\Throwable $th) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Failed Delete Product from Cart');
        }
    }

    public function checkout()
    {
        Auth::user()->cart()->update([
            'rent_code' => Uuid::uuid4(),
            'status' => 'WAITING ACCEPTMENT'
        ]);

        return redirect()->route('rent.detail')->with('status', 'Success checkout, waiting acceptment!');
    }

    public function updateDocument(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'ref_code' => 'required',
            'ref_file' => 'required|max:1024|mimes:txt,pdf,doc',
            'rent_time' => 'required',
            'return_time' => 'required',
        ]);

        Cart::whereId($id)->update(
            array_merge($request->except('_token'), [
                'ref_file' => 'storage/' . $request->file('ref_file')->storePublicly('fileDoc'),
            ]),
        );

        return redirect()
            ->route('cart.index')
            ->with('status', 'Successfully update document');
    }

    public function getActionColumn($query)
    {
        $urlUpdate = route('cart.store');
        return '
        <form class="form-inline" method="POST" action="' .
            $urlUpdate .
            '">
        <div class="form-group mx-sm-3 mb-2">
        <label for="inputQTY" class="sr-only">Quantity</label>
            <input type="number" class="form-control" name="quantity" value="' .
            $query->quantity .
            '" id="inputQTY">
            <input type="hidden" class="form-control" name="product_id" value="' .
            $query->product_id .
            '">
            <input type="hidden" name="_token" value="' .
            csrf_token() .
            '" />
        </div>
        <button type="submit" class="btn btn-primary mb-2">Update</button>
        </form>
        ';
    }

    public function getDeleteColumn($query)
    {
        $deleteBtn = route('cart.destroy', $query->id);
        $ident = Str::random(10);
        return '<input form="form' .
            $ident .
            '" type="submit" value="Delete" class="mx-1 my-1 btn btn-sm btn-danger">
        <form id="form' .
            $ident .
            '" action="' .
            $deleteBtn .
            '" method="post">
        <input type="hidden" name="_token" value="' .
            csrf_token() .
            '" />
        <input type="hidden" name="_method" value="DELETE">
        </form>';
    }
}
