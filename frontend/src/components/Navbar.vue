<template>
  <div class="navbar__wrapper">
    <nav class="navbar container">
      <MyButton class="navbar__btn" @click="$router.push('/')" :class="{ active: isRouteActive('/') }">Home</MyButton>
      <div class="navbar__btns">
        <MyButton class="navbar__btn" @click="$router.push('/stations')"
          :class="{ active: isRouteActive('/stations') }">Stations</MyButton>
        <MyButton class="navbar__btn" @click="$router.push('/trips')" :class="{ active: isRouteActive('/trips') }">Trips
        </MyButton>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  computed: {
    currentRoute() {
      return this.$route.path;
    },
  },
  methods: {
    isRouteActive(path) {
      return this.currentRoute === path;
    },
  },
};
</script>

<style scoped>
.navbar__wrapper {
  background-color: #257bc9;
}

.navbar {
  display: flex;
  align-items: center;
  height: 8vh;
  font-size: 14px;
}

.navbar__btns {
  margin-left: auto;
  display: flex;
  justify-content: space-between;
  min-width: 180px;
}

.navbar__btn {
  min-width: 80px;
}

@media (max-width: 794px) {
  .navbar {
    font-size: 12px;
  }
}
</style>
