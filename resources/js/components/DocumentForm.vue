<template>
  <div class="card-body">
    I'm a DocumentForm.
  </div>
</template>

<script>
export default {
  name: 'DocumentForm',
  data () {
    return {
      document: null
    }
  },
  mounted () {
    console.log('DocumentForm mounted.')
  }
}
</script>
