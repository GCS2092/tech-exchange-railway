@extends('emails.layouts.email')

@section('content')
<div style="max-width: 800px; margin: 0 auto; font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    
    <!-- En-tête -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px 10px 0 0; text-align: center;">
        <h1 style="margin: 0; font-size: 28px; font-weight: bold;">📊 Rapport Bimensuel</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">
            État de la boutique - {{ $reportData['period']['start'] }} au {{ $reportData['period']['end'] }}
        </p>
    </div>

    <!-- Contenu principal -->
    <div style="background: white; padding: 30px; border-radius: 0 0 10px 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <!-- Salutation -->
        <p style="font-size: 16px; color: #333; margin-bottom: 25px;">
            Bonjour <strong>{{ $admin->name }}</strong>,
        </p>
        
        <p style="font-size: 16px; color: #666; margin-bottom: 30px;">
            Voici le rapport bimensuel complet de l'état de votre boutique pour les {{ $reportData['period']['days'] }} derniers jours.
        </p>

        <!-- Statistiques des stocks -->
        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #28a745;">
            <h2 style="color: #28a745; margin: 0 0 20px 0; font-size: 22px;">📦 État des Stocks</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #007bff;">{{ $reportData['stocks']['total_products'] }}</div>
                    <div style="color: #666; font-size: 14px;">Produits total</div>
                </div>
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #28a745;">{{ $reportData['stocks']['active_products'] }}</div>
                    <div style="color: #666; font-size: 14px;">Produits actifs</div>
                </div>
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;">{{ $reportData['stocks']['low_stock_count'] }}</div>
                    <div style="color: #666; font-size: 14px;">Stock faible</div>
                </div>
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #dc3545;">{{ $reportData['stocks']['out_of_stock_count'] }}</div>
                    <div style="color: #666; font-size: 14px;">Rupture de stock</div>
                </div>
            </div>

            @if($reportData['stocks']['low_stock_products']->count() > 0)
                <h3 style="color: #333; margin: 20px 0 10px 0; font-size: 18px;">⚠️ Produits en stock faible :</h3>
                <div style="background: white; border-radius: 6px; overflow: hidden;">
                    @foreach($reportData['stocks']['low_stock_products']->take(5) as $product)
                        <div style="padding: 12px 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong style="color: #333;">{{ $product->name }}</strong>
                                <div style="color: #666; font-size: 14px;">{{ $product->category->name ?? 'Sans catégorie' }}</div>
                            </div>
                            <div style="color: #dc3545; font-weight: bold;">{{ $product->quantity }} restant(s)</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Statistiques des commandes -->
        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #007bff;">
            <h2 style="color: #007bff; margin: 0 0 20px 0; font-size: 22px;">🛒 Commandes (14 derniers jours)</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px;">
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #007bff;">{{ $reportData['orders']['total'] }}</div>
                    <div style="color: #666; font-size: 14px;">Total commandes</div>
                </div>
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #28a745;">{{ $reportData['orders']['completed'] }}</div>
                    <div style="color: #666; font-size: 14px;">Livrées</div>
                </div>
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;">{{ $reportData['orders']['pending'] }}</div>
                    <div style="color: #666; font-size: 14px;">En cours</div>
                </div>
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #dc3545;">{{ $reportData['orders']['cancelled'] }}</div>
                    <div style="color: #666; font-size: 14px;">Annulées</div>
                </div>
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #6f42c1;">{{ $reportData['orders']['completion_rate'] }}%</div>
                    <div style="color: #666; font-size: 14px;">Taux de réussite</div>
                </div>
            </div>
        </div>

        <!-- Revenus -->
        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #28a745;">
            <h2 style="color: #28a745; margin: 0 0 20px 0; font-size: 22px;">💰 Revenus (14 derniers jours)</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <div style="background: white; padding: 20px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 28px; font-weight: bold; color: #28a745;">{{ number_format($reportData['revenue']['total'], 0) }} FCFA</div>
                    <div style="color: #666; font-size: 14px;">Chiffre d'affaires total</div>
                </div>
                <div style="background: white; padding: 20px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 28px; font-weight: bold; color: #007bff;">{{ number_format($reportData['revenue']['average_per_order'], 0) }} FCFA</div>
                    <div style="color: #666; font-size: 14px;">Panier moyen</div>
                </div>
            </div>
        </div>

        <!-- Utilisateurs -->
        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #6f42c1;">
            <h2 style="color: #6f42c1; margin: 0 0 20px 0; font-size: 22px;">👥 Utilisateurs</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #6f42c1;">{{ $reportData['users']['total'] }}</div>
                    <div style="color: #666; font-size: 14px;">Total utilisateurs</div>
                </div>
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #28a745;">{{ $reportData['users']['new'] }}</div>
                    <div style="color: #666; font-size: 14px;">Nouveaux (14j)</div>
                </div>
                <div style="background: white; padding: 15px; border-radius: 6px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 24px; font-weight: bold; color: #007bff;">{{ $reportData['users']['active'] }}</div>
                    <div style="color: #666; font-size: 14px;">Actifs (14j)</div>
                </div>
            </div>
        </div>

        <!-- Top produits -->
        @if($reportData['top_products']->count() > 0)
            <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #fd7e14;">
                <h2 style="color: #fd7e14; margin: 0 0 20px 0; font-size: 22px;">🏆 Top 5 Produits les Plus Vendus</h2>
                
                <div style="background: white; border-radius: 6px; overflow: hidden;">
                    @foreach($reportData['top_products'] as $index => $product)
                        <div style="padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center;">
                                <div style="background: #fd7e14; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 15px;">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <strong style="color: #333;">{{ $product->name }}</strong>
                                    <div style="color: #666; font-size: 14px;">{{ $product->category->name ?? 'Sans catégorie' }}</div>
                                </div>
                            </div>
                            <div style="color: #fd7e14; font-weight: bold; font-size: 18px;">{{ $product->total_sold }} vendu(s)</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recommandations -->
        <div style="background: #fff3cd; padding: 25px; border-radius: 8px; border-left: 4px solid #ffc107;">
            <h2 style="color: #856404; margin: 0 0 15px 0; font-size: 20px;">💡 Recommandations</h2>
            
            <ul style="color: #856404; margin: 0; padding-left: 20px;">
                @if($reportData['stocks']['low_stock_count'] > 0)
                    <li style="margin-bottom: 8px;">⚠️ <strong>{{ $reportData['stocks']['low_stock_count'] }} produit(s)</strong> en stock faible - pensez à réapprovisionner</li>
                @endif
                
                @if($reportData['stocks']['out_of_stock_count'] > 0)
                    <li style="margin-bottom: 8px;">🚨 <strong>{{ $reportData['stocks']['out_of_stock_count'] }} produit(s)</strong> en rupture de stock - réapprovisionnement urgent</li>
                @endif
                
                @if($reportData['orders']['completion_rate'] < 80)
                    <li style="margin-bottom: 8px;">📈 Taux de réussite des commandes à {{ $reportData['orders']['completion_rate'] }}% - analyser les causes d'annulation</li>
                @endif
                
                @if($reportData['users']['new'] > 0)
                    <li style="margin-bottom: 8px;">👥 <strong>{{ $reportData['users']['new'] }} nouveaux utilisateurs</strong> - excellent pour la croissance</li>
                @endif
                
                <li style="margin-bottom: 8px;">📊 Continuez à surveiller les performances des produits vedettes</li>
            </ul>
        </div>

        <!-- Pied de page -->
        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="color: #666; font-size: 14px; margin: 0;">
                Ce rapport est généré automatiquement toutes les deux semaines.<br>
                Pour plus de détails, connectez-vous à votre tableau de bord administrateur.
            </p>
        </div>
    </div>
</div>
@endsection
