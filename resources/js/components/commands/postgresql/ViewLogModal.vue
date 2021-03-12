<template>
<div class="modal fade" id="actionModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <div class="container">
            <span v-html="logView"></span>
            <span v-if="!logView" class="empty">
                <i class="fas fa-meh-rolling-eyes fa-4x px-2"></i> Empty log...
            </span>
          </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        name: 'ViewLogModal',
        props: {
            logView: String
        }
    }
</script>

<style scoped>
.empty {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
