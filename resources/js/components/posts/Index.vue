<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card card-default mt-5">
          <div class="card-header text-center">POSTS</div>
          <div class="card-body">
            <router-link :to="{ name: 'create' }" class="btn btn-md btn-success">TAMBAH POST</router-link>
            <div class="table table-responsive mt-3">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>TITLE</th>
                    <th>KONTENT</th>
                    <th>AKSI</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="post in posts" :key="post.id">
                    <td>{{post.title}}</td>
                    <td>{{post.content}}</td>
                    <td class="text-center">
                      <router-link
                        :to="{ name :'edit',params : {id:post.id}}"
                        class="btn btn-sm btn-success"
                      >EDIT</router-link>
                      <button
                        @click.prevent="PostDelete(post.id)"
                        class="btn btn-sm btn-danger"
                      >HAPUS</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      posts: []
    };
  },
  created() {
    let uri = "http://127.0.0.1:8000/api/posts";
    this.axios.get(uri).then(response => {
      this.posts = response.data.data;
    });
  },
  methods: {
    PostDelete(id) {
      let uri = `http://127.0.0.1:8000/api/posts/${id}`;
      this.axios
        .delete(uri)
        .then(response => {
          this.posts.splice(this.posts.indexOf(id), 1);
        })
        .catch(error => {
          alert("system error");
        });
    }
  }
};
</script>