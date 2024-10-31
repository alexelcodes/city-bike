<template>
  <tr>
    <td role="departure" class="station__name" @click="$router.push(`/stations/${trip.departure_station_id}`)">
      {{ trip.departure_station_name }}
    </td>
    <td role="return" class="station__name" @click="$router.push(`/stations/${trip.return_station_id}`)">
      {{ trip.return_station_name }}
    </td>
    <td role="distance">{{ formattedDistance }}</td>
    <td role="duration">{{ formattedDuration }}</td>
  </tr>
</template>

<script>
export default {
  props: {
    trip: {
      type: Object,
      required: true,
    },
  },
  computed: {
    formattedDuration() {
      const duration = this.trip.duration / 60;
      const min = Math.floor(duration);
      const sec = Math.round((duration - min) * 60);

      if (min > 0) {
        return `${min} m ${sec} s`;
      } else {
        return `${sec} s`;
      }
    },
    formattedDistance() {
      return (this.trip.distance / 1000).toFixed(2);
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

.station__name:hover {
  color: #257bc9;
  cursor: pointer;
}

tr {
  height: 30px;
}

tr:nth-child(even) {
  background: #b2cfeb;
}

@media (max-width: 794px) {

  td:nth-child(3),
  td:nth-child(4) {
    display: none;
  }
}
</style>
