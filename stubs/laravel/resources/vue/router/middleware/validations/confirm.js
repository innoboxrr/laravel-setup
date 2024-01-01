import isConfirm from '../utils/isConfirm.js'

export default function confirm( { next } ) {

	// Si el usuario NO está identificado
    if (isConfirm()) {
    	
    	return next();

    } else {

        // window.location.href = route.name('login');

        window.location.href = '/admin/confirm';

    }

}