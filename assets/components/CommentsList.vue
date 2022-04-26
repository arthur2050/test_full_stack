<template>
  <div>
    <div class="mt-4" v-for="comment in comments">
      <div class="d-flex justify-content-between"><span>{{ comment.text }}</span>
        <b-dropdown size="sm" variant="true" toggle-class="text-decoration-none" no-caret>
          <template #button-content>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-chevron-down" viewBox="0 0 16 16">
              <path fill-rule="evenodd"
                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
            </svg>
          </template>
          <b-dropdown-item-button @click="$emit('editComment',[comment.id,comment.text])">Редактировать</b-dropdown-item-button>
          <b-dropdown-item-button @click="showDialogDelete(comment.id)">Удалить</b-dropdown-item-button>
        </b-dropdown>
      </div>
      <div class="text-left font-weight-lighter">
        <b-avatar variant="secondary" size="sm"></b-avatar>
        <span class="comment-user-name">{{ user.name }} <span class="font-italic">{{ comment.updatedAt }}</span></span>
      </div>
    </div>
  </div>

</template>

<script>
export default {
  name: "CommentsList",
  props: {
    user: {
      type: Object,
      required: true
    },
    comments: {
      type: Array,
      required: true
    }
  },
  methods: {
    showDialogDelete(commentId) {
      this.boxTwo = ''
      this.$bvModal.msgBoxConfirm('Вы уверены, что хотите удалить комментарий', {
        title: 'Пожалуйста подтвердите действие',
        size: 'sm',
        buttonSize: 'sm',
        okVariant: 'danger',
        okTitle: 'YES',
        cancelTitle: 'NO',
        footerClass: 'p-2',
        hideHeaderClose: false,
        centered: true
      })
          .then(value => {
            if (value === true) {
              this.$emit('deleteComment', commentId);
            }
          })
          .catch(err => {
            console.log(err);
          })
    }
  }
}
</script>

<style scoped>
.comment-user-name {
  display: inline-block !important;
  margin-left: 5px !important;
}
</style>