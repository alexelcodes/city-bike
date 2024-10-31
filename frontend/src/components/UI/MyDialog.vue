<template>
  <div class="dialog" v-if="show">
    <div @click.stop class="dialog__content">
      <MyButton class="btn" @click="hideDialog">X</MyButton>
      <slot> </slot>
    </div>
  </div>
</template>

<script>
import dialogMixin from "@/mixins/dialogMixin.js";

export default {
  mixins: [dialogMixin],
};
</script>

<style scoped>
.dialog {
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.5);
  position: fixed;
  display: flex;
}

.dialog__content {
  margin: auto;
  background: white;
  border-radius: 12px;
  min-height: 50px;
  width: 400px;
  padding: 20px;
  font-size: 14px;
  display: flex;
  flex-direction: column;
}

.btn {
  padding: 3px;
  width: 26px;
  align-self: flex-end;
}

@media (max-width: 794px) {
  .dialog__content {
    width: 300px;
  }
}
</style>
