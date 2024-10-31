<template>
  <div class="no-results" role="status">
    <img src="@/assets/no-results.png" alt="no results" />
    <p>
      <slot></slot>
    </p>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.no-results {
  text-align: center;
}

.no-results p {
  margin-top: 20px;
  color: #257bc9;
  font-size: 24px;
}

@media (max-width: 794px) {
  .no-results img {
    width: 70px;
  }

  .no-results p {
    font-size: 16px;
  }
}
</style>
