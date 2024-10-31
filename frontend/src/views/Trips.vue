<template>
  <div class="container">
    <h1 class="header" role="header"><span>City Bike Trips</span></h1>
    <div class="app__btns">
      <MyInput role="search" class="search" v-model="searchQuery" placeholder="Search trip"></MyInput>
      <MySelect v-model="selectedSort" :options="sortOptions"></MySelect>
      <MyButton class="add-btn" @click="showDialog">New trip</MyButton>
    </div>
    <MyDialog v-model:show="dialogVisible">
      <TripForm @add="addTrip" v-if="!isAdded"></TripForm>
      <p v-else class="message">New trip has been added!</p>
    </MyDialog>
    <Pagination :totalPages="totalPages" :perPage="limit" :currentPage="page" @pagechanged="changePage"></Pagination>
    <TripTable :trips="searchedAndSortedTrips" v-if="!isLoading"></TripTable>
    <Spinner v-else>Loading...</Spinner>
  </div>
</template>

<script>
import TripTable from "@/components/TripTable.vue";
import TripForm from "@/components/TripForm.vue";
import Pagination from "@/components/Pagination.vue";
import axiosInstance from "@/axios.js";

export default {
  components: {
    TripTable,
    TripForm,
    Pagination,
  },
  data() {
    return {
      trips: [],
      isLoading: false,
      dialogVisible: false,
      isAdded: false,
      selectedSort: "",
      searchQuery: "",
      page: 1,
      limit: 30,
      totalPages: 10,
      sortOptions: [
        { value: "departure_station_name", name: "Departure station" },
        { value: "return_station_name", name: "Return station" },
        { value: "distance", name: "Distance" },
        { value: "duration", name: "Duration" },
      ],
    };
  },
  methods: {
    changePage(pageNum) {
      this.page = pageNum;
    },
    showDialog() {
      this.dialogVisible = true;
      this.isAdded = false;
    },
    async addTrip(trip) {
      try {
        const response = await axiosInstance.post("trips/create", trip, {
          headers: {
            "Content-Type": "application/json",
          },
        });

        this.isAdded = true;
      } catch (error) {
        console.log(error.response.data);
      }
    },
    async fetchTrips() {
      try {
        this.isLoading = true;
        const response = await axiosInstance.get("trips/show", {
          params: {
            page: this.page,
            limit: this.limit,
          },
        });
        this.totalPages = Math.ceil(response.data.data.entries / this.limit);
        this.trips = response.data.data.trips;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },
  },
  mounted() {
    this.fetchTrips();
  },
  computed: {
    sortedTrips() {
      return [...this.trips].sort((trip1, trip2) => {
        if (
          this.selectedSort === "duration" ||
          this.selectedSort === "distance"
        ) {
          return trip1[this.selectedSort] - trip2[this.selectedSort];
        }
        return trip1[this.selectedSort]?.localeCompare(
          trip2[this.selectedSort]
        );
      });
    },
    searchedAndSortedTrips() {
      const regex = new RegExp(this.searchQuery.trim(), "i");
      return this.sortedTrips.filter((trip) => {
        return (
          regex.test(trip.departure_station_name) ||
          regex.test(trip.return_station_name)
        );
      });
    },
  },
  watch: {
    page() {
      this.fetchTrips();
    },
  },
};
</script>

<style scoped>
.search {
  width: 30%;
}

.app__btns {
  display: flex;
  justify-content: space-between;
  margin: 19px 0 15px;
  font-size: 14px;
  height: 43px;
}

.message {
  text-align: center;
  color: #257bc9;
  font-size: 18px;
  padding: 20px;
}

@media (max-width: 794px) {
  .app__btns {
    font-size: 12px;
    height: 38px;
  }
}
</style>
