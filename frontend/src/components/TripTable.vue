<template>
  <table class="table" v-if="trips.length > 0">
    <thead>
      <tr>
        <th>Departure station</th>
        <th>Return station</th>
        <th>Distance (km)</th>
        <th>Duration (m)</th>
      </tr>
    </thead>
    <tbody>
      <TripRow v-for="trip in trips" :trip="trip" :key="trip.id"></TripRow>
    </tbody>
  </table>
  <NoResults v-else>No trips found</NoResults>
</template>

<script>
import TripRow from "@/components/TripRow.vue";

export default {
  components: {
    TripRow,
  },
  props: {
    trips: {
      type: Array,
      required: true,
    },
  },
};
</script>

<style scoped>
.table {
  font-size: 14px;
  font-weight: normal;
  border: none;
  border-collapse: collapse;
  width: 100%;
  white-space: nowrap;
  background-color: white;
}

th {
  text-align: center;
  padding: 4px;
  border-right: 1px solid #787998;
  font-size: 14px;
  width: 10%;
}

thead th {
  background: #257bc9;
  color: #ffffff;
  height: 40px;
  font-size: 16px;
}

th:first-child,
th:nth-child(2) {
  width: 35%;
}

@media (max-width: 794px) {

  th:nth-child(3),
  th:nth-child(4) {
    display: none;
  }
}
</style>
