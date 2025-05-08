<template>
  <div class="container">
    <h1 role="header" class="header">
      <span>Welcome to City Bike!</span>
    </h1>
    <p class="text">
      <span>
        Here, you can search through all city bike stations in Helsinki and
        Espoo and view information about each station. The station data is
        provided by Helsinki Region Transport (HSL).
      </span>
      <span>
        Additionally, you can explore all the journeys taken during the summer
        of 2021. The journey data is owned by City Bike Finland.
      </span>
      <span>
        You also have the option to add your own stations and journeys.
      </span>
    </p>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.text {
  color: #257bc9;
  background-color: #f9faf8;
  font-size: 22px;
  margin-top: 40px;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 10px 10px 10px 10px #9bb2c4;
}

.text span {
  display: inline-block;
  margin-bottom: 20px;
}

@media (max-width: 794px) {
  .text {
    font-size: 16px;
  }
}
</style>
