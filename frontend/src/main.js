import { createApp } from "vue"; // Import Vue's createApp function
import App from "./App.vue"; // Import the main App component
import router from "./router"; // Import the router configuration
import UIComponents from "@/components/UI"; // Import UI components

const app = createApp(App); // Create the Vue application instance

// Register UI components globally
Object.entries(UIComponents).forEach(([name, component]) => {
  app.component(name, component);
});

app.use(router); // Use the router in the app
app.mount("#app"); // Mount the app to the DOM
