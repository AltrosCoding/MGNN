<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveRoleColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $roles = \App\Role::all();

            \App\User::all()->each(function ($user) use ($roles) {
                switch ($user->role) {
                    case 'admin':
                        $user->roles()->attach($roles->where('name', 'Admin')->first()->id);
                        break;
                    
                    case 'user':
                        $user->roles()->attach($roles->where('name', 'User')->first()->id);
                        break;
                    
                    case 'writer':
                        $user->roles()->attach($roles->where('name', 'Contributor')->first()->id);
                        break;
                    
                    case 'editor':
                        $user->roles()->attach($roles->where('name', 'Jr. Editor')->first()->id);
                        break;
                    
                    case 'seniorEditor':
                        $user->roles()->attach($roles->where('name', 'Sr. Editor')->first()->id);
                        break;
                }
            });
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 100);
        });
    }
}
