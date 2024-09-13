import { driver } from "driver.js";
import "driver.js/dist/driver.css";

export default function initDriver(params = {}) {
  const steps = [
    { 
      popover: { 
        title: 'Página de inicio',
        description: 'Esta es la página de inicio. Su principal función es mostrar la actividad del sitio. Es como tu feed de Facebook.',
        side: "left", 
        align: 'start' 
      }
    },
    {
      element: '#admin-left-sidebar',
      popover: {
        title: 'Barra de navegación principal',
        description: 'Este apartado tiene los accesos directos a las diferentes secciones de la aplicación.',
        position: 'right'
      }
    },
    {
      element: '#admin-top-navbar',
      popover: {
        title: 'Barra de navegación',
        description: 'En esta barra puedes observar el buscador, notificaciones y tu perfil.',
        position: 'bottom'
      }
    },
    {
      element: '#admin-right-sidebar',
      popover: {
        title: 'Accesos rápidos',
        description: 'Acceso rápido a ChatBot, Calendario, Grupos, Cursos, Reportes y si eres docente a un botón para Create un nuevo curso.',
        position: 'left'
      }
    },
    {
      element: '#start_sidebar_user',
      popover: {
        title: 'Perfil de usuario',
        description: 'Muestra el nombre, correo electrónico, país y fecha de afiliación del usuario autenticado.',
        position: 'right'
      }
    },
    {
      element: '#start_sidebar_user_profile_button',
      popover: {
        title: 'Ver perfil',
        description: 'Al dar clic en este botón, se mostrará el perfil del usuario autenticado.',
        position: 'right'
      }
    },
    {
      element: '#feed',
      popover: {
        title: 'Actividad',
        description: 'Muestra la actividad del sitio.',
        position: 'top'
      }
    },
    {
      element: '#fb_comments_component_toggle_button',
      popover: {
        title: 'Añadir comentario',
        description: 'Da clic para añadir un comentario.',
        position: 'top'
      }
    },
    { 
      popover: { 
        title: 'Fin',
        description: 'Esperamos que disfrutes de la aplicación.',
        side: "left", 
        align: 'start' 
      }
    },
  ];

  const driverObj = driver({
    showProgress: true,
    steps: steps
  });

  return driverObj;
}