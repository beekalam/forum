<template>

    <div>
        <div v-if="signedIn">
            <div class="form-group">
        <textarea name="body" id="body" cols="30" rows="10"
                  class="form-control"
                  placeholder="Have something to say?"
                  required
                  v-model="body"></textarea>
            </div>
            <button type="submit"
                    class="btn btn-primary"
                    @click="addReply">Post
            </button>
        </div>

        <div class="text-center" v-else>
            <p>Please <a href="/login">sign in</a>to participate.</p>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['endpoint'],
        data() {
            return {
                body: '',
            };
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                console.log('in addreply');

                axios.post(this.endpoint, {body: this.body})
                    .then(({data}) => {
                        this.body = '';

                        flash('Your reply has been posted.');

                        this.$emit('created', data);

                    });
            }
        }
    }
</script>
