# Guide d'Onboarding - Système de Tutoriel

## Vue d'ensemble

Ce système d'onboarding permet d'ajouter des tutoriels interactifs avec des overlays explicatifs, des points d'intérêt avec flèches et des explications contextuelles dans toute l'application.

## Fonctionnalités

- ✅ **Overlays explicatifs** sur l'interface
- ✅ **Points d'intérêt avec flèches** 
- ✅ **Explications contextuelles**
- ✅ **Navigation entre les étapes**
- ✅ **Bouton d'aide flottant**
- ✅ **Démarrage automatique** pour les nouveaux utilisateurs
- ✅ **Persistance** de l'état (localStorage)
- ✅ **Responsive** et accessible

## Structure des fichiers

```
app/
├── Helpers/
│   └── OnboardingHelper.php          # Logique métier des tours
├── Http/Controllers/
│   └── OnboardingController.php      # API pour l'onboarding
└── Providers/
    └── OnboardingServiceProvider.php # Enregistrement du helper

resources/views/
├── components/
│   ├── onboarding-tour.blade.php     # Composant principal du tour
│   └── onboarding-button.blade.php   # Bouton d'aide
└── layouts/
    └── app.blade.php                 # Layout avec intégration

routes/
└── web.php                          # Routes de l'API
```

## Utilisation

### 1. Définir les étapes d'un tour

Dans `OnboardingHelper.php`, ajoutez vos tours :

```php
public static function getTourSteps($tourId): array
{
    $tours = [
        'mon-tour' => [
            [
                'target' => '.ma-classe-css',
                'title' => 'Titre de l\'étape',
                'description' => 'Description détaillée de cette étape',
                'position' => 'bottom' // top, bottom, left, right
            ],
            // ... autres étapes
        ]
    ];
    
    return $tours[$tourId] ?? [];
}
```

### 2. Ajouter les classes CSS dans vos vues

```html
<div class="ma-classe-css">
    <!-- Votre contenu -->
</div>
```

### 3. Intégrer dans une page

Le système s'intègre automatiquement dans le layout principal. Pour une page spécifique :

```php
@php
use App\Helpers\OnboardingHelper;
@endphp

<x-onboarding-tour tourId="mon-tour" :autoStart="true" />
<x-onboarding-button tourId="mon-tour" />

<script>
    {!! OnboardingHelper::generateTourScript('mon-tour') !!}
</script>
```

## API Endpoints

### Marquer un tour comme vu
```http
POST /onboarding/mark-seen
Content-Type: application/json

{
    "tour_id": "mon-tour"
}
```

### Vérifier si un tour a été vu
```http
GET /onboarding/has-seen?tour_id=mon-tour
```

### Obtenir les étapes d'un tour
```http
GET /onboarding/steps?tour_id=mon-tour
```

### Réinitialiser un tour
```http
POST /onboarding/reset
Content-Type: application/json

{
    "tour_id": "mon-tour"
}
```

## Tours disponibles

### 1. `welcome` - Tour d'accueil
- **Navigation principale** (`.main-navigation`)
- **Recherche rapide** (`.search-bar`)
- **Menu utilisateur** (`.user-menu`)

### 2. `dashboard` - Tableau de bord
- **Statistiques** (`.stats-cards`)
- **Commandes récentes** (`.recent-orders`)
- **Actions rapides** (`.quick-actions`)

### 3. `products` - Page produits
- **Filtres** (`.filters`)
- **Grille de produits** (`.product-grid`)
- **Liste de souhaits** (`.wishlist-button`)

### 4. `cart` - Panier
- **Articles du panier** (`.cart-items`)
- **Résumé** (`.cart-summary`)
- **Bouton de commande** (`.checkout-button`)

### 5. `profile` - Profil utilisateur
- **Informations personnelles** (`.profile-info`)
- **Adresses** (`.addresses`)
- **Sécurité** (`.security-settings`)

## Personnalisation

### Styles CSS

Les styles sont inclus dans le composant `onboarding-tour.blade.php`. Vous pouvez les personnaliser :

```css
.tour-highlight {
    /* Style de surbrillance */
}

.onboarding-button {
    /* Style du bouton d'aide */
}
```

### Positions des tooltips

- `top` : Au-dessus de l'élément
- `bottom` : En-dessous de l'élément
- `left` : À gauche de l'élément
- `right` : À droite de l'élément

### Démarrage automatique

Pour qu'un tour démarre automatiquement, ajoutez-le dans `OnboardingHelper::shouldAutoStart()` :

```php
public static function shouldAutoStart($tourId, $userId = null): bool
{
    $autoStartTours = ['welcome', 'mon-tour'];
    return in_array($tourId, $autoStartTours);
}
```

## Fonctions JavaScript

### Démarrer un tour
```javascript
startTour('mon-tour');
```

### Fermer un tour
```javascript
closeTour('mon-tour');
```

### Événements
```javascript
document.addEventListener('tour-completed', function(e) {
    console.log('Tour terminé:', e.detail.tourId);
});
```

## Bonnes pratiques

1. **Sélecteurs CSS** : Utilisez des classes spécifiques pour cibler les éléments
2. **Descriptions** : Soyez concis mais informatif
3. **Étapes** : Limitez à 3-5 étapes par tour
4. **Positions** : Choisissez la position qui évite les chevauchements
5. **Tests** : Testez sur différents écrans et navigateurs

## Dépannage

### Le tour ne s'affiche pas
- Vérifiez que l'élément cible existe dans le DOM
- Vérifiez que la classe CSS est correcte
- Vérifiez la console pour les erreurs JavaScript

### Le tour ne démarre pas automatiquement
- Vérifiez que le tour est dans `$autoStartTours`
- Vérifiez que l'utilisateur est connecté
- Vérifiez que la route correspond au tour

### Problèmes de positionnement
- Vérifiez que l'élément cible est visible
- Ajustez la position du tooltip si nécessaire
- Testez sur mobile

## Évolutions futures

- [ ] Stockage en base de données
- [ ] Statistiques d'utilisation
- [ ] Tours conditionnels selon le rôle
- [ ] Support des images dans les tooltips
- [ ] Animations personnalisées
- [ ] Support multilingue 

---

## Rôles et droits principaux

- **Admin** : gestion totale du site, accès à toutes les fonctionnalités, attribution des rôles.
- **Vendeur** : dashboard dédié, gestion de ses produits (CRUD), accès à ses commandes, notifications, mail de bienvenue automatique.
- **Client** : navigation, achat, suivi commandes, notifications.
- **Livreur** : accès à ses livraisons, planning, marquage des commandes livrées.

---

## Nouveautés et sécurité
- Dashboard vendeur moderne et sécurisé (/vendeur/dashboard)
- Attribution automatique du rôle à la création
- Système de permissions granulaire (Spatie)
- Sécurisation des routes par middleware
- Mail de bienvenue vendeur automatisé

---

Consultez DOCUMENTATION.md pour le détail complet des logiques métiers et des flux. 