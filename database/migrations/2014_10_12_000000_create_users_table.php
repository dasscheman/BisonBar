<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('role_id')->default(1);
            $table->string('pay_key')->nullable();
            $table->smallInteger('automatic_payment')->default(0);
            $table->string('mollie_customer_id')->nullable();
            $table->decimal('mollie_amount')->nullable();
            $table->decimal('hard_limit')->default(-20);
            $table->decimal('rise_limit')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('blocked_at', 0)->nullable();
            $table->timestamp('last_login_at', 0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });


        $users = DB::table('user')->get();
        foreach ($users as $user) {
            $profile = DB::table('profile')->where('user_id', $user->id)->first();
            $data = [
                'id' => $user->id,
                'name' => $profile->name,
                'email' => $user->email,
                'password' => $user->password_hash,
                'pay_key' => $user->pay_key,
                'automatic_payment' => 0,
                'mollie_customer_id' => $user->mollie_customer_id,
                'mollie_amount' => $user->mollie_bedrag,
                'hard_limit' => $profile->limit_hard,
                'rise_limit' => $profile->limit_ophogen,
                'email_verified_at' => $user->confirmed_at,
                'blocked_at' => $user->blocked_at,
                'last_login_at' => $user->last_login_at,
                'deleted_at' => $user->blocked_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
            if($user->automatische_betaling) {
                $data['automatic_payment'] = 1;
            }
            \App\Models\User::create($data);

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('la_users');
    }
}
