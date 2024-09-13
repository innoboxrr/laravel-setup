export const loadLayout = (layouts, layoutName) => {
    let layout;

    // Buscar la ruta que contenga el layoutName justo antes de `layout.js`
    for (const path in layouts) {
        if (path.includes(`/${layoutName}/layout.js`)) {
            layout = layouts[path];
            break;
        }
    }

    // Si no se encontró el layout, cargar el layout por defecto
    if (!layout) {
        for (const path in layouts) {
            if (path.includes(`/default/layout.js`)) {
                layout = layouts[path];
                break;
            }
        }
    }

    // Si no se encontró el layout por defecto, lanzar un error
    if (!layout) {
        throw new Error(`No se pudo encontrar el layout ${layoutName} ni el layout por defecto.`);
    }

    return layout.default;
};
