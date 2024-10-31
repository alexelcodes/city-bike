<template>
  <div class="container">
    <h1 class="header" role="header"><span>City Bike Stations</span></h1>
    <div class="app__btns">
      <MyInput role="search" class="search" v-model="searchQuery" placeholder="Search station by name or address">
      </MyInput>
      <MySelect v-model="selectedSort" :options="sortOptions"></MySelect>
      <MyButton @click="showDialog">New station</MyButton>
    </div>
    <MyDialog v-model:show="dialogVisible">
      <StationForm @add="addStation" v-if="!isAdded"></StationForm>
      <p v-else class="message">New station has been added!</p>
    </MyDialog>
    <Pagination :totalPages="totalPages" :perPage="limit" :currentPage="page" @pagechanged="changePage"></Pagination>
    <StationTable :stations="searchedAndSortedStations" v-if="!isLoading"></StationTable>
    <Spinner v-else>Loading...</Spinner>
  </div>
</template>

<script>
import StationTable from "@/components/StationTable.vue";
import StationForm from "@/components/StationForm.vue";
import Pagination from "@/components/Pagination.vue";
import axiosInstance from "@/axios.js";

export default {
  components: {
    StationTable,
    Pagination,
    StationForm,
  },
  data() {
    return {
      stations: [],
      isLoading: false,
      dialogVisible: false,
      isAdded: false,
      selectedSort: "",
      searchQuery: "",
      page: 1,
      limit: 30,
      totalPages: 10,
      sortOptions: [
        { value: "id", name: "Id" },
        { value: "name", name: "Name" },
        { value: "address", name: "Address" },
        { value: "capacity", name: "Capacity" },
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
    async addStation(station) {
      try {
        const response = await axiosInstance.post("stations/create", station, {
          headers: {
            "Content-Type": "application/json",
          },
        });

        this.isAdded = true;
      } catch (error) {
        console.log(error.response.data);
      }
    },
    async fetchStations() {
      try {
        this.isLoading = true;

        const response = await axiosInstance.get("stations/show", {
          params: {
            page: this.page,
            limit: this.limit,
          },
        });
        this.totalPages = Math.ceil(response.data.data.entries / this.limit);

        this.stations = response.data.data.stations;
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },
  },
  mounted() {
    this.fetchStations();
  },
  computed: {
    sortedStations() {
      return [...this.stations].sort((st1, st2) => {
        if (this.selectedSort === "id" || this.selectedSort === "capacity") {
          return st1[this.selectedSort] - st2[this.selectedSort];
        }
        return st1[this.selectedSort]?.localeCompare(st2[this.selectedSort]);
      });
    },
    searchedAndSortedStations() {
      const regex = new RegExp(this.searchQuery.trim(), "i");
      return this.sortedStations.filter((station) => {
        return regex.test(station.name) || regex.test(station.address);
      });
    },
  },
  watch: {
    page() {
      this.fetchStations();
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
