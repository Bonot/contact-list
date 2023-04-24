import Cookie from 'js-cookie';

export default (to,from,next) => {
    if (to.path === '/') {
        return next();
    }

    const cookie = Cookie.get('token');

    if (!cookie && to.path != '/login') {
        return next('/login');
    }
    
    if (cookie && to.path === '/login') {
        return next('/');
    }

    return next();
}
