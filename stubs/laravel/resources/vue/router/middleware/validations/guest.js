import isAuth from '../utils/isAuth.js'

export default function guest( { next } ) {

	// Si el usuario está identificado
    if (isAuth()) {
    	
    	// Enviarlo al Dashboard
        window.location.href = '/admin';

    } else {

    	return next();

    }

}