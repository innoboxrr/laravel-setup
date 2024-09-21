import { driver } from "driver.js";
import "driver.js/dist/driver.css";

export default function initDriver(params = {}) {
  const steps = [
    { 
      element: '#app-logo', 
      popover: { 
        title: 'Chat', 
        description: 'Here is the code example showing animated tour. Let\'s walk you through it.', 
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