<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Route;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $p_gate)
    {
        $this->registerPolicies($p_gate);

		$p_gate->define("edit-route",function(User $p_user,Route $p_route){
			
			return $p_route->id_user==$p_user->id || $p_user->isAdmin(); 
			
		});
        //
    }
}
