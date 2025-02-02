#!/bin/bash

# Vérifier si les arguments sont fournis
if [ $# -ne 3 ]; then
    echo "Usage: $0 <nom_boutique> <user_name> <user_email> <user_age>"
    exit 1
fi

# Récupérer les arguments
NOM_BOUTIQUE=$1
USER_NAME=$2
USER_EMAIL=$3
USER_AGE=$4

# Sécuriser le nom de la boutique
NOM_BOUTIQUE=$(echo "$NOM_BOUTIQUE" | tr -cd 'a-zA-Z0-9_-')

# Définition des chemins
CHEMIN="/var/www/html/$NOM_BOUTIQUE"
CONFIG_PATH="/etc/apache2/sites-available/$NOM_BOUTIQUE.conf"

# Créer le répertoire de la boutique s'il n'existe pas
if [ ! -d "$CHEMIN" ]; then
    mkdir -p "$CHEMIN"
    chown www-data:www-data "$CHEMIN"
    chmod 775 "$CHEMIN"
fi

# Créer un fichier index.php avec les infos utilisateur
cat <<EOL > "$CHEMIN/index.php"
<?php
echo 'Nom: ' . '$USER_NAME' . '<br>';
echo 'Email: ' . '$USER_EMAIL' . '<br>';
echo 'Âge: ' . '$USER_AGE' . '<br>';
EOL

chown www-data:www-data "$CHEMIN/index.php"
chmod 664 "$CHEMIN/index.php"

# Création du fichier de configuration Apache
cat <<EOL > "$CONFIG_PATH"
<VirtualHost *:80>
    ServerName $NOM_BOUTIQUE.domain.xxx
    DocumentRoot $CHEMIN
    <Directory $CHEMIN>
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog \${APACHE_LOG_DIR}/$NOM_BOUTIQUE-error.log
    CustomLog \${APACHE_LOG_DIR}/$NOM_BOUTIQUE-access.log combined
</VirtualHost>
EOL

# Activer le site et recharger Apache
a2ensite "$NOM_BOUTIQUE.conf"
systemctl reload apache2

echo "Boutique $NOM_BOUTIQUE déployée avec succès."
