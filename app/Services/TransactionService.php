<?php


namespace App\Services;


use App\Constants\ConstantsGeneral;
use App\Http\Traits\ApiResponse;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    use ApiResponse;

    protected $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function getTransactions()
    {
        return $this->mainQuery()->paginate(ConstantsGeneral::PAGINATION_ITEMS_COUNT);
    }


    /**
     * Store Transaction Data In DB
     * @param $wallet
     * @param $amount
     * @param int $type
     * @param int $status
     * @param string $description
     * @param int|null $order_id
     * @param null $balance
     */
    public function storeTransaction($wallet, $amount, int $type, int $status, string $description, int $order_id = null, $balance = null)
    {
        // Get description transaction
        $description = DB::table('descriptions')->where('key', $description)->first();
        // Set transaction data
        $transaction = [
            'wallet_id' => $wallet->id,
            'user_id' => $wallet->user_id,
            'amount' => $amount,
            'type' => $type,
            'description_id' => $description->id,
            'balance' => $balance ?? $wallet->balance,
            'order_id' => $order_id,
            'status' => $status,
        ];

        $this->model->create($transaction);
    }


    /**
     * Make failure transaction
     * @param $user_wallet
     * @param $request
     * @param $type
     * @param $desc
     */
    public function failureTransaction($user_wallet, $request, $type, $desc)
    {
        $this->storeTransaction($user_wallet, $request['amount'], $type, 0, $desc, $request['order_id'] ?? null);
    }


    /**
     * Get key from array
     * @param $value
     * @param $array
     * @return bool|false|int|string
     * @throws \ErrorException
     */
    public function getIndex($value, $array)
    {
        $index = array_search($value, $array);
        if($index === false) {
            $this->throwException('The index not available');
        }
        return $index;
    }

    public function mainQuery()
    {
        return $this->model->latest('transactions.id')
            ->where('transactions.user_id', auth()->id())
            ->where('description_translations.locale', app()->getLocale())
            ->join('description_translations', 'transactions.description_id', 'description_translations.description_id')
            ->select('transactions.*', 'description_translations.description');
    }

}
