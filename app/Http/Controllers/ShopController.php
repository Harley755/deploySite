<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class ShopController extends Controller
{
    public function store(ShopRequest $request)
    {


        $subdomain = strtolower($request->name);

        $shop = Shop::create([
            'name' => $subdomain,
            'user_id' => auth()->id(),
        ]);

        // Créer un sous-domaine et déployer le site
        $this->deployShop($shop);

        return redirect()->route('dashboard')->with('success', 'Boutique créée avec succès !');
    }


    private function deployShop(Shop $shop)
    {
        $subdomain = $shop->name . '.domain.xxx';
        $userName = $shop->user->name;
        $userEmail = $shop->user->email;
        $userAge = $shop->user->age;
        $nameShop = $shop->name;

        // Créer le répertoire pour le sous-domaine
        exec("sudo mkdir /var/www/html/laravel-shop-deployer/public/{$shop->name}");
        exec("sudo touch /var/www/html/laravel-shop-deployer/public/{$shop->name}/index.php");

        exec("sudo chmod 644 /var/www/html/laravel-shop-deployer/public/{$shop->name}/index.php");

        // Définir la configuration Apache
        $apacheConfig = "
            <VirtualHost *:80>
                ServerName $subdomain
                DocumentRoot /var/www/html/laravel-shop-deployer/public/{$shop->name}
                <Directory /var/www/html/laravel-shop-deployer/public/{$shop->name}>
                    AllowOverride All
                    Require all granted
                </Directory>
            </VirtualHost>
        ";

        // Exécuter le script Bash avec sudo pour créer le fichier de config et activer le site
        $escapedConfig = escapeshellarg($apacheConfig);
        exec("sudo /usr/local/bin/deploy_shop.sh \"$subdomain\" \"$escapedConfig\" \"$userName\" \"{$shop->name}\" \"$userEmail\" \"$userAge\"  ");
    }
}
