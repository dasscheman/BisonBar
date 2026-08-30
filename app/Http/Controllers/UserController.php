<?php

namespace App\Http\Controllers;

use App\Models\Calculations;
use App\Models\User;

class UserController extends Controller
{

    public function newInvoice(User $user)
    {
        $calculations = new Calculations($user);
        return view('pdf.invoice-template', ['user' => $user, 'calculations' => $calculations]);
    }
}
