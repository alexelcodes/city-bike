import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/Home.vue";
import Stations from "@/views/Stations.vue";
import Station from "@/views/Station.vue";
import Trips from "@/views/Trips.vue";
import NotFound from "@/views/NotFound.vue";

// Define the routes
const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/stations",
    name: "stations",
    component: Stations,
  },
  {
    path: "/stations/:id",
    name: "station",
    component: Station,
  },
  {
    path: "/trips",
    name: "trips",
    component: Trips,
  },
  {
    path: "/:catchAll(.*)", // Catch-all route for 404
    name: "not-found",
    component: NotFound,
  },
];

// Create the router instance
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
