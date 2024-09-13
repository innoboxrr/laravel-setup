import { driver } from "driver.js";
import "driver.js/dist/driver.css";

export default function initDriver(params = {}) {
  const steps = [
    { 
      popover: { 
        title: 'Bienvenido a Orlab', 
        description: 'este es un recorrido guiado por la aplicación, para que puedas conocerla mejor.', 
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
    }
  ];

  const driverObj = driver({
    showProgress: true,
    steps: steps
  });

  return driverObj;
}