OlixInstallerScriptBundle
=========================

Installe / Met à jour les packages Olix via un script depuis Composer

Pré-requis
----------

Pour pouvoir installer un composant via Composer, ajouter le package 
**sabinus52/olix-installer-script-composer** dans votre *composer.json*
de la clé `require` key.

Puis rajouter le script **OlixComposerScriptHandler::installOlixAssets**.

``` json
{
    "require": {
        "sabinus52/olix-installer-script-composer": "dev-master"
    },
    "scripts" : {
        "post-install-cmd" : [
            "Olix\\TestInstallerBundle\\OlixComposerScriptHandler::installOlixAssets"
        ],
        "post-update-cmd" : [
            "Olix\\TestInstallerBundle\\OlixComposerScriptHandler::installOlixAssets"
        ]
    }
}
```

Configuration
-------------

Pour choisir l'emplacement des assets, ajouter la clé `olix-assets-dir` dans la clé `extra`.

``` json
{
    "extra": {
        "olix-assets-dir" : "public"
    }
}
```
