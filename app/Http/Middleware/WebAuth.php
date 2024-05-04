<?php

namespace App\Http\Middleware;

use App\Services\JWTService;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebAuth
{
    protected JWTService $tokenService;

    public function __construct(JWTService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization') ?: $request->cookie('X-Pius-Auth');

        if (!$token) {
            return redirect('login');
        }

        try {
            $decodedToken = $this->tokenService->decodeToken($token);
            $roles = $decodedToken->roles;

            if (isset($decodedToken->expired) && strtotime($decodedToken->expired) < time()) {
                $refreshToken = $decodedToken->refresh ?? null;
                $newToken = $this->tokenService->refreshToken($refreshToken);

                if ($newToken) {
                    return redirect($request->fullUrl())->header('Authorization', $newToken)->cookie('X-Pius-Auth', $newToken);
                } else {
                    return redirect('login');
                }
            }

            if ($this->userHasPermission($roles, $request->path())) {
                return $next($request);
            } else {
                return response()->view('errors.403', [], 403);
            }
        } catch (ExpiredException $e) {
            return response()->view('errors.401', ['message' => 'Token expired'], 401);
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return response()->view('errors.401', ['message' => 'Unauthorized'], 401);
        }
    }

    private function userHasPermission($roles, $endpoint): bool
    {
        return str_starts_with($endpoint, '/moderator') && contains($roles, 'admin') || contains($roles, 'user');
    }
}
