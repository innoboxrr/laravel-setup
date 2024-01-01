import isAuth from '../utils/isAuth.js'

export default function auth( { next } ) {

	// Si el usuario NO está identificado
    if (isAuth()) {
    	
    	return next();

    } else {

        // window.location.href = route.name('login');

        let redirectUrl = encodeURIComponent(location.href);

        window.location.href = '/auth/login?redirect=' + redirectUrl;

    }

}