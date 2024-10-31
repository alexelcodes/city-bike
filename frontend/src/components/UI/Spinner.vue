<template>
  <span class="loader"></span>
</template>

<script>
export default {};
</script>

<style scoped>
.loader {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #257bc9;
  box-sizing: border-box;
  animation: animloader 1s linear infinite alternate;
}

@keyframes animloader {
  0% {
    box-shadow: -38px -6px, -14px 6px, 14px -6px;
  }

  33% {
    box-shadow: -38px 6px, -14px -6px, 14px 6px;
  }

  66% {
    box-shadow: -38px -6px, -14px 6px, 14px -6px;
  }

  100% {
    box-shadow: -38px 6px, -14px -6px, 14px 6px;
  }
}
</style>
