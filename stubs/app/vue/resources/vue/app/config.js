/**
 * Las rutas del módulo de LaraPack que sólo ve un administrador, por su nombre.
 *
 * Proteger la ruta de primer nivel protege también sus hijas (el detalle y la
 * edición), porque la guarda mira toda la cadena de rutas. Un modelo que añadas
 * y quieras reservar al administrador se apunta aquí.
 */
export const adminOnly = [
    'AdminUsers',
]
