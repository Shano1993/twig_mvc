<?php

namespace App\Controller;

class HomeController extends Controller
{
    public function home()
    {
        $amount = 15424512.1545;
        $this->render('home/home.html.twig', [
            'user' => 'John',
            'hobbies' => ['One', 'Two', 'Three', 'Four', 'Five'],
            'sleep' => ['Volontier', 'Souvent', 'Le plus possible', 'Oh oui'],
            'amount' => $amount,
        ]);
    }
}