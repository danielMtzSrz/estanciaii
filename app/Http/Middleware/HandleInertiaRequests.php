<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\User;

class HandleInertiaRequests extends Middleware
{

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'breadcrumbItems' => fn () => $request->session()->get('breadcrumbItems'),
            'flash' => [
                'detail' => fn () => $request->session()->get('detail'),
                'severity' => fn () => $request->session()->get('severity'),
                'summary' => fn () => $request->session()->get('summary'),
                'life' => fn () => $request->session()->get('life')
            ],
            'toast' => $request->session()->get('toast'),
            'auth' => function () {
                $user = auth()->user();
                return $user ? [
                    'roles' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions()->pluck('name')
                ] : null;
            },
            'auth.user' => fn () => $request->user()
                ? $request->user()->only('id', 'name', 'email')
                : null,
        ]);
    }
}
