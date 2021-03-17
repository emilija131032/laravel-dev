import Admin from './components/Admin';
import Register from './components/Register';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Admin
    },
    {
        name: 'sign-up',
        path: '/sign-up',
        component: Register
    }
];
