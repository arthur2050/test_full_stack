<template>
  <div>
    <b-card
        title="Header of post"
        tag="article"
        style="max-width: 25rem;"
        class="mb-2"
    >
      <b-card-text ref="editsBlock">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        Aliquid amet architecto autem,
        blanditiis consequatur distinctio dolorum ducimus hic illum impedit,
        ipsa iusto officiis provident quam quasi, quo ratione repellat vel!
      </b-card-text>

      <b-form-input
          size="sm"
          v-model="commentText"
          placeholder="Введите комментарий"
          required
          @focus="focusCommentInput"
      ></b-form-input>
      <div class="mt-2 d-flex justify-content-start" v-if="showButtonsEdit">
        <b-button variant="primary" size="sm" @click="saveComment">Сохранить
          <b-spinner small v-if="saveLoading"></b-spinner>
        </b-button>
        <b-button variant="outline-secondary" @click="cancelComment" size="sm" class="ml-2">Отмена</b-button>
      </div>
      <comments-list :comments="comments"
                     :user="user"
                     @editComment="editComment"
                     @deleteComment="deleteComment"></comments-list>
    </b-card>
  </div>
</template>
<script>
import CommentsList from './CommentsList';

const commentUrl = 'comment';

export default {
  name: "Post",
  components: {
    CommentsList
  },
  data() {
    return {
      saveLoading: false,
      showButtonsEdit: false,
      commentText: null,
      comments: [],
      commentId: null,
      user: null,
    }
  },
  created() {
    this.user = {
      id: '1',
      name: 'testUser'
    };
    this.loadComments();
  },
  methods: {
    focusCommentInput() {
      this.showButtonsEdit = true;
    },
    cancelComment() {
      this.showButtonsEdit = false;
      this.commentText = '';
      this.commentId = null;
    },
    async saveComment() {
      this.saveLoading = true;
      try {
        let form = new FormData();
        let response;
        form.append('text', this.commentText);
        if (this.commentId !== null) {
          response = await this.axios.post(`${commentUrl}/edit/1/${this.commentId}`, form);
        } else response = await this.axios.post(`${commentUrl}/add/1`, form);

        console.log(response.data.success);
        await this.loadComments();
      } catch (e) {
        console.log(e);
      }
      this.commentText = '';
      this.saveLoading = false;
      this.showButtonsEdit = false;
      this.commentId = null;
    },
    async loadComments() {
      try {
        let response = await this.axios.get(`${commentUrl}/show/1`);
        this.comments = response.data.comments;
      } catch (e) {
        console.log(e);
      }
    },
    editComment(commentData) {
      this.commentId = commentData[0];
      this.commentText = commentData[1];
      this.focusCommentInput();
      window.editsblock = this.$refs.editsBlock;
      this.$refs.editsBlock.scrollIntoView();
    },
    async deleteComment(commentId) {
      try {
        let response = await this.axios.delete(`${commentUrl}/delete/1/${commentId}`);
        console.log(response.data.success);
        await this.loadComments();
      } catch (e) {
        console.log(e);
      }
    }
  }
}
</script>
<style scoped>
</style>