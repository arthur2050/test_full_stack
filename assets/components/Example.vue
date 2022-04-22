<template>
  <div>
    <p>This is an example of a new components in VueJs</p>
    <button @click="showExample">touch me</button>
  </div>
</template>
<script>
export default {
  name: "example",
  methods: {
    showExample() {
      alert('I can\'t believe it');
    }
  }
}
</script>
<style scoped>
</style>