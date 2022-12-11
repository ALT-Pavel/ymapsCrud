import { createWebHistory, createRouter } from "vue-router";

import Home from '../pages/Home';
import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Markers from '../components/Markers';
import AddMarker from '../components/AddMarker';
import EditMarker from '../components/EditMarker';

export const routes = [{
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'markers',
        path: '/markers',
        component: Markers
    },
    {
        name: 'addmarker',
        path: '/markers/add',
        component: AddMarker
    },
    {
        name: 'editmarker',
        path: '/markers/edit/:id',
        component: EditMarker
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;