<?php

namespace App\Http\Middleware;

use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Exceptions\UserException;
use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckAdminAccountMiddleware
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var MabaAccount $account */
        $account = $request->get('account');
        if (!$account) {
            UserException::throw("admin account could not be decoded", 2056);
        }
        $user = $this->user_repository->find($account->getUserId());
        $user->beginVerification()->checkRoleId(2)->verify();
        return $next($request);
    }
}
