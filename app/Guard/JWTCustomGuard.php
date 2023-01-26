<?php


namespace App\Guard;


use App\Models\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;

class JWTCustomGuard implements Guard
{

    use GuardHelpers;

    /**
     * @var JWT $jwt
     */
    protected JWT $jwt;

    /**
     * @var Request $request
     */
    protected Request $request;

    /**
     * JWTGuard constructor.
     * @param JWT $jwt
     * @param Request $request
     */
    public function __construct(JWT $jwt, Request $request) {
        $this->jwt = $jwt;
        $this->request = $request;
    }

    public function user() {
        if (! is_null($this->user)) {
            return $this->user;
        }

        if ($this->jwt->setRequest($this->request)->getToken() && $this->jwt->check()) {

            $this->user = new User();
            $this->user->id = $this->getFromPayload('sub');
            $this->user->typ = $this->getFromPayload('typ');
            $this->user->comp = $this->getFromPayload('comp');
            $this->user->branchId = $this->getFromPayload('branchId');
            $this->user->appCode = $this->getFromPayload('appCode');
            $this->user->isAdmin = $this->getFromPayload('isAdmin');
            $this->user->plan = $this->getFromPayload('plan');
            $this->user->qyudApiKey = $this->getFromPayload('qyudApiKey');

            // Set data from custom claims
            return $this->user;
        }

        return null;
    }


    private function getFromPayload($key)
    {
        return $this->jwt->payload()->get($key);
    }

    public function validate(array $credentials = []) {

    }

}
