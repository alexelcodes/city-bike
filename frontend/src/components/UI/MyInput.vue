<template>
  <input :value="modelValue" @input="updateInput" :required="required" type="text" class="input" />
</template>

<script>
export default {
  props: {
    modelValue: [String, Number],
    required: Boolean,
  },
  methods: {
    updateInput(event) {
      this.$emit("update:modelValue", event.target.value);
    },
  },
};
</script>

<style scoped>
.input {
  padding: 10px 15px;
  border: 2px solid #257bc9;
  border-radius: 5px;
  font-size: inherit;
}
</style>
