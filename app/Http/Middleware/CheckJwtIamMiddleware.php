<?php

namespace App\Http\Middleware;

use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Service\JwtManagerInterface;
use App\Exceptions\UserException;
use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckJwtIamMiddleware
{
    private JwtManagerInterface $jwt_manager;
    public UserAccount $account;

    /**
     * @param JwtManagerInterface $jwt_manager
     */
    public function __construct(JwtManagerInterface $jwt_manager)
    {
        $this->jwt_manager = $jwt_manager;
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
        $jwt = $request->bearerToken();
        if (!$jwt) {
            UserException::throw('Token is not sent', 901);
        }
        $account = $this->jwt_manager->decode($jwt);
        $request->attributes->add(['account' => $account]);

        return $next($request);
    }
}
