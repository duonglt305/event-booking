<?php


namespace DG\Dissertation\Api\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Authenticate extends BaseMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->authenticate($request);

        return $next($request);
    }


    /**
     * @param Request $request
     * @throws UnauthorizedHttpException
     */
    public function authenticate(Request $request)
    {
        $this->checkForToken($request);
        try {
            $id = $this->auth->parseToken()->getPayload()->get('sub');
            if (!auth('api')->byId($id)) {
                throw new UnauthorizedHttpException('jwt-auth', 'User not found');
            }
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }
    }


}
