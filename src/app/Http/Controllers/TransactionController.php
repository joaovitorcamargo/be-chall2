<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
  /**
   * @var Transaction
  */
  protected $transaction;

  public function __construct(Transaction $transaction)
  {
    $this->transaction = $transaction;
  }

  /**
   * @param Request $request
   * @return JsonResponse
  */
  public function saveSale(Request $request): JsonResponse
  {
    try {
      $payload = $this->requestValidate($request);

      if (!is_float($payload['price'])) {
        throw new Exception('The price is not float');
      }

      $this->transaction->saveSale($payload);

    }catch(Exception | RequestException $e) {
      return response()->json([
        'error' => $e->getMessage()
      ], 500);
    }

    return response()->json([
      'message' => 'Successfully registered transaction',
      'data'=> [
        'transactionId' => $this->transaction->getTransactionId($payload['transactionId'])
      ]
    ], 200);
  }

  /**
   * @param Request $request
   * @return mixed[]
  */
  private function requestValidate(Request $request): array
  {
    $requestValidated = $this->validate($request, [
      'productId' => 'required|integer',
      'userId' => 'required|integer',
      'price' => 'required|numeric',
      'date' => 'required|date'
    ]);

    $payload['date'] = Carbon::parse($requestValidated['date'])->format('Y-m-d');

    $payload = array_merge($requestValidated, ['transactionId' => Str::random(50)]);

    return $payload;
  }
}
