<template>
  <div class="container">
    <div class="station" v-show="!isLoading">
      <StationInfo :station="station" v-if="!errorMessage"></StationInfo>
      <NoResults v-else>
        {{ errorMessage }}
      </NoResults>
    </div>
    <spinner v-show="isLoading"></spinner>
  </div>
</template>

<script>
import L from 'leaflet';
import StationInfo from "@/components/StationInfo.vue";
import axiosInstance from "@/axios.js";

export default {
  components: {
    StationInfo,
  },
  data() {
    return {
      station: {},          // Object to store station data received from the API
      isLoading: false,     // Boolean to indicate whether data is loading
      map: null,            // Leaflet map instance that will be rendered in the template
      marker: null,         // Leaflet marker instance representing the station’s location
      errorMessage: "",     // Error messages if data fetch fails
    };
  },
  methods: {
    // Asynchronously fetches station information using the station ID from the route parameters
    async fetchStationInfo() {
      // Start loading state to show spinner
      this.isLoading = true;
      try {
        // Fetch station info based on the ID from the route params
        const response = await axiosInstance.get("station/show", {
          params: {
            id: this.$route.params.id, // ID from the route parameters
          },
        });

        this.station = response.data.data; // Store the API response in station

        // Set the map view to the station's location
        this.map.setView([this.station.y, this.station.x], 13);
        // Add a marker for the station on the map
        this.marker = L.marker([this.station.y, this.station.x]).addTo(this.map);
      } catch (error) {
        this.errorMessage = error.response.data.reason; // Set error message on failure
      } finally {
        this.isLoading = false; // Hide loading spinner once data fetch is complete
      }
    },
  },
  mounted() {
    // Fetch the station info when the component is mounted
    this.fetchStationInfo();

    // Create a Leaflet map instance and set the initial view
    this.map = L.map("map").setView([0, 0], 13);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution:
        'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
    }).addTo(this.map); // Add the OpenStreetMap tile layer to the map

    // Assign the map instance to the global window object for debugging
    window.map = this.map;
  },
};
</script>

<style scoped>
.station {
  display: flex;
  justify-content: space-around;
  margin-top: 50px;
}

@media (max-width: 1222px) {
  .station {
    flex-direction: column;
    justify-content: center;
  }
}
</style>
