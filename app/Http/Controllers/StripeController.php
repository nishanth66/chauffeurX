<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Exception\InvalidRequestException;
use Cartalyst\Stripe\Exception\MissingParameterException;
use Cartalyst\Stripe\Exception\ServerErrorException;
use Cartalyst\Stripe\Exception\StripeException;
use Cartalyst\Stripe\Exception\UnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

use Illuminate\Support\Facades\Input;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Api\Subscriptions;
use Cartalyst\Stripe\Exception\NotFoundException;
use Stripe\Error\Card;
use Illuminate\Support\Facades\Auth;
class StripeController extends Controller
{
    public function __construct()
    {

    }

    public function payWithStripe()
    {
        if (!Auth::check())
        {
            return redirect('login');
        }

    }

    public function postPaymentWithStripe(Request $request)
    {

        $stripe = Stripe::make(env('STRIPE_SECRET'));

        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
            'zip' => 'required',
        ],
            [
                'card_no.required' => 'Card Number is required',
                'ccExpiryMonth.required' => 'Expiry Month is required',
                'ccExpiryYear.required' => 'Expiry year is required',
                'cvvNumber.required' => 'CVV Number is required',
                'zip.required' => 'zipcode is required',
            ]
        );
        if ($validator->fails()) {
            Flash::error();
            return redirect('stripe');
        }
        try {
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $request->get('card_no'),
                    'exp_month' => $request->get('ccExpiryMonth'),
                    'exp_year' => $request->get('ccExpiryYear'),
                    'cvc' => $request->get('cvvNumber'),
                ],
            ]);
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect('stripe');
        } catch (CardErrorException $ex) {
            Flash::error($ex->getMessage());
            return redirect('stripe');
        } catch (NotFoundException $ex) {
            Flash::error($ex->getMessage());
            return redirect('stripe');
        } catch (InvalidRequestException $ex) {
            Flash::error($ex->getMessage());
            return redirect('stripe');
        } catch (MissingParameterException $ex) {
            Flash::error($ex->getMessage());
            return redirect('stripe');
        } catch (ServerErrorException $ex) {
            Flash::error($ex->getMessage());
            return redirect('stripe');
        } catch (StripeException $ex) {
            Flash::error($ex->getMessage());
            return redirect('stripe');
        } catch (\Exception $ex) {
            Flash::error($ex->getMessage());
            return redirect('stripe');
        }
    }
}