<template>

    <div :id="'reply-'+id" class="card" style="margin-top:8px">
        <div class="card-header">
            <div class="level">
                <h6 class="flex">
                    <a :href="'/profiles/' + data.owner.name"
                       class="flex"
                       v-text="data.owner.name">
                    </a>
                    said <span v-text="ago"></span>
                </h6>

                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>

            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-outline-primary btn-xs btn-link" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        <!--        @can('update',$reply)-->
        <div class="card-footer level" v-if="canUpdate">
            <button class="btn btn-primary btn-xs mr-1" @click="editing = true">Edit</button>
            <button class="btn btn-danger btn-xs mr-1" @click="destroy">Delete</button>
        </div>
        <!--        @endcan-->
    </div>

</template>

<script>
    import Favorite from "./Favorite";
    import moment from "moment";

    export default {
        props: ['data'],

        components: {Favorite},

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body
            };
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
            },
            ago() {
                return moment(this.data.created_at).fromNow() + "...";
            },
        },

        methods: {

            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);

            }
        }


    }

</script>
