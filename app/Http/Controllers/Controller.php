<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

abstract class Controller
{
    protected function deployerSite($nomBoutique, $user)
    {
        // Sécuriser le nom de la boutique
        $nomBoutique = escapeshellarg($nomBoutique);
        Log::info("boutique ", (array)$nomBoutique);

        // Créer le répertoire de la boutique
        $chemin = "/var/www/html/$nomBoutique";
        if (!file_exists($chemin)) {
            exec("sudo mkdir /var/www/html/$nomBoutique");
            exec("sudo touch /var/www/html/$nomBoutique/index.php");
        }


        // Créer un fichier index.php simple
        $contenu = "
        <?php
        echo 'Nom: ' . '{$user->name}' . '<br>';
        echo 'Email: ' . '{$user->email}' . '<br>';
        echo 'Âge: ' . '{$user->age}' . '<br>';
    ";
        file_put_contents("$chemin/index.php", $contenu);

        // Créer la configuration Apache
        $template = "
        <VirtualHost *:80>
            ServerName $nomBoutique.domain.xxx
            DocumentRoot $chemin
            <Directory $chemin>
                AllowOverride All
                Require all granted
            </Directory>
        </VirtualHost>
    ";


        file_put_contents("/etc/apache2/sites-available/$nomBoutique.conf", $template);

        // Activer le site et recharger Apache
        exec("sudo a2ensite $nomBoutique.conf");
        exec("sudo systemctl reload apache2");
    }

    // protected function deployerSite($nomBoutique, $user)
    // {
    //     // Chemin du répertoire de la boutique
    //     $chemin = storage_path("app/public/boutiques/$nomBoutique");

    //     // Créer le répertoire de la boutique
    //     if (!file_exists($chemin)) {
    //         mkdir($chemin, 0755, true); // 0755 : permissions pour le répertoire
    //     }

    //     // Créer un fichier index.php simple
    //     $contenu = "
    // <?php
    // echo 'Nom: ' . '{$user->name}' . '<br>';
    // echo 'Email: ' . '{$user->email}' . '<br>';
    // echo 'Âge: ' . '{$user->age}' . '<br>';
    // ";
    //     file_put_contents("$chemin/index.php", $contenu);
    // }
}
