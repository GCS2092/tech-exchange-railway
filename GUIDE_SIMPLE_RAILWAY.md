# 🚀 GUIDE SIMPLE - Mettre votre site en ligne avec Railway

## 📋 **ÉTAPES SIMPLES (Suivez dans l'ordre)**

### **ÉTAPE 1 : Créer un compte Railway** 
1. **Ouvrez votre navigateur**
2. **Tapez** : `railway.app`
3. **Cliquez sur "Login"** (en haut à droite)
4. **Cliquez sur "Login with GitHub"**
5. **Autorisez Railway** à accéder à vos repos GitHub

### **ÉTAPE 2 : Créer votre projet**
1. **Cliquez sur "New Project"** (bouton bleu)
2. **Cliquez sur "Deploy from GitHub repo"**
3. **Sélectionnez votre repo** : `GCS2092/mon-site-cosmetique`
4. **Railway va automatiquement détecter** que c'est un projet Laravel

### **ÉTAPE 3 : Ajouter une base de données**
1. **Dans votre projet Railway**, cliquez sur **"New"**
2. **Sélectionnez "Database"** → **"PostgreSQL"**
3. **Railway crée automatiquement** la base de données
4. **Notez les informations** (host, port, database, username, password)

### **ÉTAPE 4 : Configurer les variables d'environnement**
1. **Dans votre projet Railway**, allez dans **"Settings"** → **"Variables"**
2. **Ajoutez ces variables** (une par une) :

```
APP_NAME=TechExchange
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:9wLahAWln+1u0Pt9ESq1/IrXY23RLltO2RQOBXzddMk=
APP_URL=https://votre-app.railway.app
```

3. **Pour la base de données**, Railway vous donne automatiquement :
```
DB_CONNECTION=pgsql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe_railway
```

### **ÉTAPE 5 : Attendre le déploiement**
1. **Railway va automatiquement** :
   - Installer PHP et Node.js
   - Installer les dépendances
   - Construire votre site
   - Démarrer votre application

2. **Votre site sera disponible** sur : `https://votre-app.railway.app`

### **ÉTAPE 6 : Configurer la base de données**
1. **Dans Railway**, allez dans **"Deployments"**
2. **Cliquez sur votre déploiement**
3. **Ouvrez la console** (bouton "Console")
4. **Tapez ces commandes** :
```
php artisan migrate --force
php artisan db:seed --class=CompleteDatabaseSeeder
```

## 🎉 **C'EST FINI !**

Votre site TechExchange est maintenant en ligne !

**URL de votre site** : `https://votre-app.railway.app`

## 🔧 **Si vous avez des problèmes :**

### **Erreur 500** :
- Vérifiez que toutes les variables d'environnement sont bien ajoutées
- Vérifiez que APP_KEY est correct

### **Base de données** :
- Vérifiez que les variables DB_* sont correctes
- Exécutez les migrations dans la console

### **Assets manquants** :
- Vérifiez que npm run build s'exécute
- Regardez les logs de déploiement

## 💰 **Coûts :**
- **Gratuit** : 500h/mois (environ 16h/jour)
- **Payant** : $5/mois pour usage illimité

## 📞 **Besoin d'aide ?**
- Regardez les logs dans Railway → Deployments → Logs
- Consultez la documentation : `RAILWAY_DEPLOYMENT_GUIDE.md`

## 🎯 **Prochaines étapes (optionnelles) :**
1. **Configurer Google OAuth** (pour la connexion Google)
2. **Configurer Flutterwave** (pour les paiements)
3. **Configurer PayPal** (pour les paiements)
4. **Ajouter un nom de domaine** personnalisé

---

**Votre site est prêt ! 🚀**
