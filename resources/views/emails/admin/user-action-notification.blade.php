<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Action Admin - {{ ucfirst($action) }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }
        .action-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .action-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .user-info {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 20px 0;
        }
        .action-summary {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .timestamp {
            color: #6c757d;
            font-size: 12px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="action-icon">
                @switch($action)
                    @case('block')
                        🚫
                        @break
                    @case('unblock')
                        ✅
                        @break
                    @case('delete')
                        🗑️
                        @break
                    @case('role_change')
                        👤
                        @break
                    @default
                        📝
                @endswitch
            </div>
            <h1>Action Admin Effectuée</h1>
            <p>Bonjour {{ $admin->name }},</p>
        </div>

        <div class="action-summary">
            <h3>Action : {{ ucfirst($action) }}</h3>
            <p><strong>Date :</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p><strong>Effectuée par :</strong> {{ $admin->name }} ({{ $admin->email }})</p>
        </div>

        <div class="user-info">
            <h3>Utilisateur concerné :</h3>
            <p><strong>Nom :</strong> {{ $user->name }}</p>
            <p><strong>Email :</strong> {{ $user->email }}</p>
            <p><strong>ID :</strong> {{ $user->id }}</p>
            <p><strong>Rôles :</strong> 
                @foreach($user->roles as $role)
                    <span style="background: #007bff; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px; margin: 2px;">{{ $role->name }}</span>
                @endforeach
            </p>
            <p><strong>Statut :</strong> 
                @if($user->is_blocked)
                    <span style="color: #dc3545;">🚫 Bloqué</span>
                @else
                    <span style="color: #28a745;">✅ Actif</span>
                @endif
            </p>
        </div>

        @if(!empty($actionDetails))
        <div class="action-details">
            <h3>Détails de l'action :</h3>
            @foreach($actionDetails as $key => $value)
                <p><strong>{{ ucfirst(str_replace('_', ' ', $key)) }} :</strong> {{ $value }}</p>
            @endforeach
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('admin.users.show', $user->id) }}" class="btn">Voir le profil utilisateur</a>
            <a href="{{ route('admin.users.index') }}" class="btn">Gestion des utilisateurs</a>
        </div>

        <div class="footer">
            <p>Cette notification a été envoyée automatiquement suite à une action administrative.</p>
            <p>Si vous n'êtes pas à l'origine de cette action, veuillez contacter immédiatement l'équipe technique.</p>
        </div>

        <div class="timestamp">
            Envoyé le {{ now()->format('d/m/Y à H:i:s') }}
        </div>
    </div>
</body>
</html>
