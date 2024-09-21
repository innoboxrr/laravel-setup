import isAdmin from '../utils/isAdmin.js'

export default function admin( { next } ) {
	// Si el usuario NO está identificado
    if (isAdmin()) {
    	return next();
    } else {
        window.location.href = '/';
    }
}