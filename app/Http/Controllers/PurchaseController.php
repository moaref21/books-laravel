<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Carbon\Carbon;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;
use App\models\Shopping;
use Illuminate\Support\Facades\Http;
class PurchaseController extends Controller
{
  

    function __construct() {
    
    }

   
    public function creditCheckout(Request $request) {
        $intent = auth()->user()->createSetupIntent();
        
        $userId = auth()->user()->id;
        $books = User::find($userId)->booksIncart;
        $total = 0;
        foreach($books as $book) {
            $total += $book->price * $book->pivot->number_of_coies;
        }
        return view('credit.checkout', compact('total', 'intent'));
    }
    public function purchase(Request $request)
    {
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');

        $userId = auth()->user()->id;
        $books = User::find($userId)->booksIncart;
        $total = 0;
        foreach($books as $book) {
            $total += $book->price * $book->pivot->number_of_coies;
        }

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($total * 100, $paymentMethod);
        } catch (\Exception $exception) {
            return back()->with('حصل خطأ أثناء شراء المنتج، الرجاء التأكد منمعلومات البطاقة', $exception->getMessage());
        }
        $this->sendOrderConfirmationMail($books, auth()->user());

        foreach($books as $book) {
            $bookPrice = $book->price;
            $purchaseTime = Carbon::now();
            $user->booksIncart()->updateExistingPivot($book->id, ['bought' => TRUE, 'price' => $bookPrice, 'created_at' => $purchaseTime]);
            $book->save();
        }
        return redirect('/cart')->with('message', 'تم شراء المنتج بنجاح');   
    }

 

}
