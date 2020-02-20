<template>
  <div class="card shadow">
    <div class="card-header">
      Documents
      <b-btn
        v-if="show === 'list'"
        size="sm"
        variant="success"
        class="float-right"
        @click="show = 'form'"
      >
        Create document
      </b-btn>
      <b-btn
        v-if="show === 'form'"
        size="sm"
        variant="primary"
        class="float-right"
        @click="show = 'list'"
      >
        Back to list
      </b-btn>
    </div>
    <transition name="fade">
      <document-list v-if="show === 'list'" />
      <document-form v-if="show === 'form'" />
    </transition>
  </div>
</template>

<script>
import DocumentList from './DocumentList'
import DocumentForm from './DocumentForm'

export default {
  name: 'MainComponent',
  components: {
    DocumentList, DocumentForm
  },
  data () {
    return {
      show: 'list',
      mounted () {
        console.log('DocumentForm mounted.')
      }
    }
  }
}
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .3s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
