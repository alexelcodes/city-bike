<template>
  <tr>
    <td role="id">{{ station.id }}</td>
    <td role="name" class="station__name" @click="$router.push(`/stations/${station.id}`)">
      {{ station.name }}
    </td>
    <td role="address">{{ station.address }}</td>
    <td role="capacity">{{ station.capacity }}</td>
  </tr>
</template>

<script>
export default {
  props: {
    station: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
td,
th {
  text-align: center;
  padding: 4px;
  border: 1px solid #d7d6d6;
  font-size: 16px;
  color: #072052;
}

tr {
  height: 30px;
}

tr:nth-child(even) {
  background: #b2cfeb;
}

.station__name:hover {
  color: #257bc9;
  cursor: pointer;
}

@media (max-width: 794px) {
  td:last-child {
    display: none;
  }
}
</style>
