@component('mail::message')
# Alerte Stock Faible

Le stock du produit **{{ $product->name }}** est passé sous le seuil critique.

- Stock restant : **{{ $product->quantity }}**
- Prix : {{ number_format($product->price, 2) }} FCFA

@component('mail::button', ['url' => url('/admin/products/' . $product->id . '/edit')])
Gérer le produit
@endcomponent

Merci de réapprovisionner ce produit rapidement pour éviter la rupture de stock.

@endcomponent 