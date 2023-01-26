<?php


namespace App\Services;


use App\Constants\ConstantsGeneral;

class PayService
{

    protected $walletService;
    protected $transactionService;


    public function __construct(WalletService $walletService, TransactionService $transactionService)
    {
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
    }


    /**
     * Purchase an order
     * @param $user_wallet
     * @param $request
     */
    public function purchase($user_wallet, $request)
    {
        // Purchase User
        $this->walletService->withdraw($request, $user_wallet->user_id, 'buy');
        // Seller amount
        $request['amount'] = $this->sellerAmountAfterAdminRatio($request['amount']);
        // Sales Seller
        $this->walletService->deposit($request, $request['seller_id'], 'sales');
    }


    /**
     * Check wallet balance
     * @param $user_wallet
     * @param $request
     * @return bool
     */
    public function checkBalance($user_wallet, $request) : bool
    {
        if($request['amount'] > $user_wallet->balance) {
            $this->transactionService->failureTransaction($user_wallet, $request, 2, 'buy');
            return false;
        }
        return true;
    }


    /**
     * Get seller amount
     * @param $amount
     * @return float
     */
    public function sellerAmountAfterAdminRatio($amount) : float
    {
        return $amount - $this->adminAmountRatio($amount);
    }


    /**
     * Get admin amount
     * @param $amount
     * @return float
     */
    public function adminAmountRatio($amount) : float
    {
        return $amount * ConstantsGeneral::ADMIN_RATIO / 100;
    }


}
