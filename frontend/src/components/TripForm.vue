<template>
  <form @submit.prevent="createTrip" class="form">
    <h3 class="form__header">New trip</h3>
    <label>Departure date and time</label>
    <MyInput class="input" v-model="trip.departure" type="datetime-local" required />
    <label>Return date and time</label>
    <MyInput class="input" v-model="trip.return" type="datetime-local" required />
    <select class="select" name="departure_station_id" v-model="trip.departure_station_id" @change="fetchStationName"
      required>
      <option value="" disabled selected>Select departure station id</option>
      <option v-for="option in stationIds" :key="option" :value="option">
        {{ option }}
      </option>
    </select>
    <MyInput class="input" v-model="trip.departure_station_name" type="text" placeholder="departure station name"
      required />
    <select class="select" name="return_station_id" v-model="trip.return_station_id" @change="fetchStationName"
      required>
      <option value="" disabled selected>Select return station id</option>
      <option v-for="option in stationIds" :key="option" :value="option">
        {{ option }}
      </option>
    </select>
    <MyInput class="input" v-model="trip.return_station_name" type="text" placeholder="return station name" required />
    <MyInput class="input" v-model="trip.distance" type="number" placeholder="distance in metres" min="10" required />
    <MyInput class="input" v-model="trip.duration" type="number" placeholder="duration in seconds" min="10" required />
    <MyButton class="btn-add" type="submit">Add trip</MyButton>
    <p v-show="error">Invalid inputs</p>
  </form>
</template>

<script>
import axiosInstance from "@/axios";

export default {
  data() {
    return {
      trip: {
        departure: "",
        return: "",
        departure_station_id: "",
        departure_station_name: "",
        return_station_id: "",
        return_station_name: "",
        distance: "",
        duration: "",
      },
      stations: [],
      error: false,
    };
  },
  methods: {
    createTrip() {
      this.$emit("add", this.trip);

      this.trip = {
        departure: "",
        return: "",
        departure_station_id: "",
        departure_station_name: "",
        return_station_id: "",
        return_station_name: "",
        distance: "",
        duration: "",
      };
    },
    async fetchStations() {
      try {
        // Send a GET request with parameters to the API using axios to fetch stations
        const response = await axiosInstance.get("stations/show", {
          params: {
            page: 1,
            limit: 0,
          },
        });

        // Update the stations array with the fetched stations data
        this.stations = response.data.data.stations;
      } catch (error) {
        console.log(error);
      }
    },
    async fetchStationName(event) {
      const selectedStationId = event.target.value;
      const selectName = event.target.name;

      const station = this.stations.find((st) => st.id === selectedStationId);
      if (station) {
        if (selectName === "departure_station_id") {
          this.trip.departure_station_name = station.name;
        } else if (selectName === "return_station_id") {
          this.trip.return_station_name = station.name;
        }
      }
    },
  },
  mounted() {
    this.fetchStations();
  },
  computed: {
    stationIds() {
      if (this.stations.length === 0) {
        return [];
      }
      return this.stations.map((st) => st.id);
    },
  },
};
</script>

<style scoped>
.form {
  display: flex;
  flex-direction: column;
  font-family: inherit;
}

.form__header {
  margin-bottom: 15px;
  color: #257bc9;
  font-size: 20px;
  text-align: center;
}

.form label {
  font-family: inherit;
  margin-left: 15px;
}

.input {
  margin-bottom: 15px;
}

.select {
  min-width: 30%;
  padding: 10px 15px;
  border: 2px solid #257bc9;
  border-radius: 5px;
  font-size: inherit;
  margin-bottom: 15px;
}

.btn-add {
  align-self: flex-end;
  margin-top: 15px;
}
</style>
