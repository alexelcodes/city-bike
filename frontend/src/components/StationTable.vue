<template>
  <table class="table" v-if="stations.length > 0">
    <thead>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Address</th>
        <th>Capacity</th>
      </tr>
    </thead>
    <tbody>
      <StationRow v-for="station in stations" :station="station" :key="station.id"></StationRow>
    </tbody>
  </table>

  <no-results v-else>No stations found</no-results>
</template>

<script>
import StationRow from "@/components/StationRow.vue";

export default {
  components: {
    StationRow,
  },
  props: {
    stations: {
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

th:nth-child(2),
th:nth-child(3) {
  width: 35%;
}

@media (max-width: 794px) {
  th:last-child {
    display: none;
  }
}
</style>
