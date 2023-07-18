<?php
namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
    public function boot()
    {
        $this->registerPolicies();
        //Passport::routes();

        // Mandatory to define Scope
        Passport::tokensCan([
            'admin' => [
                'List/Add/Edit/Delete Users',
                'List/Add/Edit/Delete Categories',
                'List/Add/Edit/Delete Products'
            ],

            'basic' => [
                'List Users',
                'List Categories',
                'List Products',
            ]
        ]);

        Passport::setDefaultScope([
            'basic'
        ]);
    }
}