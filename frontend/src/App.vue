<template>
  <div class="app">
    <Navbar />
    <div class="content">
      <router-view />
    </div>
    <FooterBlock />
  </div>
</template>

<script>
import Navbar from "@/components/Navbar.vue";
import FooterBlock from "@/components/FooterBlock.vue";

export default {
  components: { Navbar, FooterBlock },
};
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.app {
  background: linear-gradient(rgb(255 255 255 / 60%), rgb(255 255 255 / 60%)),
    url("@/assets/bg.png"), repeat;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.content {
  flex: 1 0 auto;
}

.container {
  max-width: 1170px;
  margin: 0 auto;
  padding: 0 20px;
}

.header {
  text-align: center;
  margin-top: 20px;
}

.header span {
  color: #257bc9;
  background-color: #f9faf8;
}

@media (max-width: 794px) {
  .header span {
    font-size: 20px;
  }
}
</style>