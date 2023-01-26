<?php


namespace App\Services;

use App\Models\Wallet;

class WalletService
{

    protected $model;

    protected $transactionService;

    public function __construct(Wallet $model, TransactionService $transactionService)
    {
        $this->model = $model;
        $this->transactionService = $transactionService;
    }


    /**
     * Get the user balance of the wallet
     * @return mixed
     */
    public function balanceWallet()
    {
        return auth()->user()->balance();
    }


    /**
     * Deposit in wallet
     * @param $request
     * @param int $user_id
     * @param string $desc
     * @param int $status
     */
    public function deposit($request, int $user_id, string $desc, int $status = 1)
    {
        $wallet = $this->walletByUserId($user_id);
        $wallet->increment('balance', $request['amount']);
        $this->actionWallet($request, $wallet, $desc, 1, $status);
    }


    /**
     * Withdraw from wallet
     * @param $request
     * @param int $user_id
     * @param string $desc
     * @param int $status
     */
    public function withdraw($request, int $user_id, string $desc, int $status = 1)
    {
        $wallet = $this->walletByUserId($user_id);
        $wallet->decrement('balance', $request['amount']);
        $this->actionWallet($request, $wallet, $desc, 2, $status);
    }

    /**
     * Make an action in wallet
     * @param $request
     * @param $wallet
     * @param $desc
     * @param $type
     * @param int $status
     */
    public function actionWallet($request, $wallet, $desc, $type, $status = 1)
    {
        $this->transactionService->storeTransaction(
            $wallet,
            $request['amount'],
            $type,
            $status,
            $desc,
            $request['order_id'] ?? null,
            $request['balance'] ?? null
        );
    }


    /**
     * Get wallet by user id
     * @param $user_id
     * @return mixed
     */
    public function walletByUserId($user_id)
    {
        return $this->model->wallet($user_id);
    }

}
