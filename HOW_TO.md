#Intégrer le code de Lead Generator Enchantier

Deux possibilités :

1. Insertion dans une zone du template (widget de demande de devis seulement)
2. Insertion dans une page ou un article

## 1. Insertion dans une zone du template (widget de demande de devis seulement)

Reportez-vous à l'onglet "Apparence / Widgets" de votre menu Wordpress pour associer le widget de demande de devis à une zone de votre template (maquette ci-dessous)

![Démo Widget](/wp-content/plugins/lead-generator-by-enchantier/img/3.maquette-insertion-widget-template.jpg)


## 2. Insertion dans une page ou un article

Nous vous proposons 2 types de widget pour la génération de leads : "Chiffrage & Mise en relation" et "Demande de devis" (cf. présentation ici : [http://www.enchantier.com/info/affiliation.php](http://www.enchantier.com/info/affiliation.php))
Pour voir apparaitre l'un ou l'autre de ces widgets sur certaines pages ou dans certains articles, copiez/collez l'un ou l'autre de ces codes :

- Pour le widget "Demande de devis" (Formulaire de demande de devis très simple et rapide) :
copiez/collez le code suivant :  

```
    [widget_lead_enchantier]
```

- Pour le widget "Chiffrage & Mise en relation" (Outil de chiffrage avec bouton de mise en relation OU accès aux formulaires de demande de devis) :
copiez/collez le code suivant :  

```
    [widget_lead_enchantier widget_type="widget_full"]
```

## 3. Félicitations, votre widget EnChantier est publié !

- Une fois votre widget publié, accédez à l'onglet ["Réglages Fins"](/wp-admin/admin.php?page=setup_EnChantier) : 

Associez chaque url de votre site qui diffuse le widget de demande de devis à un formulaire précis (vous proposerez ainsi un formulaire "demande de devis parquet" sur votre article traitant de parquet).
Choisissez d’afficher le widget de demande devis en mode "Partenaire EnChantier.com" ou en marque blanche. 
