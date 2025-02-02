<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;

class ShopController extends Controller
{
    public function store(ShopRequest $request)
    {
        // $shop = Shop::create($request->validated() + ['user_id' => auth()->id()]);

        // $this->deployerSite($request->name, auth()->user());

        $contenu = "
            <?php
            echo 'Nom: ' .  '<br>';
        ";
        exec("mkdir /var/www/html/$request->name");
        exec("touch /var/www/html/$request->name/index.php");
        file_put_contents("/var/www/html/$request->name/index.php", $contenu);

        $hostsEntry = "127.0.1.1       $request->name.domaine.xxx";
        exec("echo '$hostsEntry' | sudo tee -a /etc/hosts");

        return redirect("http://{$request->name}.domaine.xxx");
    }

    public function show($shop)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();

        dd($shop);

        return view('shop.show', compact('shop'));
    }
}
