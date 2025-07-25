import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { Provider } from 'react-redux';
import store from './store';
import App from './App';
import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import { useSelector } from 'react-redux';
import Home from './pages/Home';
import Products from './pages/Products';
import Cart from './pages/Cart';
import Checkout from './pages/Checkout';
import Orders from './pages/Orders';
import Profile from './pages/Profile';
import Login from './pages/Login';
import Register from './pages/Register';
import AdminDashboard from './pages/admin/Dashboard';
import AdminOrders from './pages/admin/Orders';
import AdminProducts from './pages/admin/Products';
import AdminUsers from './pages/admin/Users';

window.Alpine = Alpine;
Alpine.start();

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    },
});

// Composant pour gérer les routes protégées
function AppRoutes() {
    const isAuthenticated = useSelector(state => state.auth.isAuthenticated);
    const userRole = useSelector(state => state.auth.user?.role);

    return (
        <Routes>
            {/* Public Routes */}
            <Route path="/" element={<Home />} />
            <Route path="/products" element={<Products />} />
            <Route path="/cart" element={<Cart />} />
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />

            {/* Protected Routes */}
            {isAuthenticated && (
                <>
                    <Route path="/checkout" element={<Checkout />} />
                    <Route path="/orders" element={<Orders />} />
                    <Route path="/profile" element={<Profile />} />
                </>
            )}

            {/* Admin Routes */}
            {isAuthenticated && userRole === 'admin' && (
                <>
                    <Route path="/admin/dashboard" element={<AdminDashboard />} />
                    <Route path="/admin/orders" element={<AdminOrders />} />
                    <Route path="/admin/products" element={<AdminProducts />} />
                    <Route path="/admin/users" element={<AdminUsers />} />
                </>
            )}
        </Routes>
    );
}

const root = ReactDOM.createRoot(document.getElementById('app'));
root.render(
    <React.StrictMode>
        <Provider store={store}>
            <BrowserRouter>
                <AppRoutes />
            </BrowserRouter>
        </Provider>
    </React.StrictMode>
);