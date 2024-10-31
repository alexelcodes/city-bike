<template>
  <div class="station__info">
    <h2 role="name" class="station__header">{{ station.name }}</h2>
    <p role="address" class="station-text">
      Address:<span>{{ station.address }}</span>
    </p>
    <p class="station-text" role="capacity">
      Capacity:<span>{{ station.capacity }}</span>
    </p>
    <ul class="station-text">
      Total number of journeys
      <li role="total_trips_start">
        starting from the station:<span>{{ station.total_start ?? 0 }}</span>
      </li>
      <li role="total_trips_end">
        ending at the station:<span>{{ station.total_end ?? 0 }}</span>
      </li>
    </ul>
    <ul class="station-text">
      The average distance of a journey
      <li role="average_distance_start">
        starting from the station:<span>{{ formattedAvgStart }} km</span>
      </li>
      <li role="average_distance_end">
        ending at the station:<span>{{ formattedAvgEnd }} km</span>
      </li>
    </ul>
  </div>
  <div class="station__location" id="map"></div>
</template>

<script>
export default {
  props: {
    station: {
      type: Object,
      required: true,
    },
  },
  computed: {
    formattedAvgStart() {
      return (this.station.avg_distance_start / 1000).toFixed(2);
    },
    formattedAvgEnd() {
      return (this.station.avg_distance_end / 1000).toFixed(2);
    },
  },
};
</script>

<style scoped>
.station__info {
  border: 2px solid #257bc9;
  width: 450px;
  height: fit-content;
  background-color: rgb(38 124 201 / 88%);
  border-radius: 15px;
  padding: 20px;
  color: #ffffff;
  font-size: 18px;
  margin: 0 auto;
}

.station__header {
  margin-bottom: 20px;
  text-align: center;
}

.station-text {
  margin-top: 12px;
}

.station-text span {
  margin-left: 10px;
}

.station-text li {
  margin-top: 8px;
  margin-left: 40px;
  list-style-type: circle;
}

.station__location {
  width: 550px;
  border: 2px solid #257bc9;
  border-radius: 15px;
  height: 450px;
  margin: 0 auto;
}

@media (max-width: 1222px) {
  .station__info {
    margin-bottom: 40px;
  }
}

@media (max-width: 794px) {
  .station__info {
    width: 300px;
    font-size: 14px;
  }

  .station-text {
    margin-top: 8px;
  }

  .station__location {
    width: 300px;
    height: 300px;
  }
}
</style>
