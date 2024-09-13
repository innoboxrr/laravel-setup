<template>
    <div v-highlight>
        <div class="bg-white rounded-xl shadow-sm p-4 mb-4 text-sm font-medium border-1 dark:bg-slate-800">
            <div class="flex items-center gap-3">
                <div
                    class="flex-1 bg-slate-100 hover:bg-opacity-80 transition-all rounded-lg cursor-pointer dark:bg-slate-900"
                    tabindex="0"
                    aria-expanded="false"
                    @click="showEditor = true">
                    <div id="fb_comments_component_toggle_button" class="py-2.5 text-center dark:text-white">
                        {{ toggleButtonText }}
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div
                v-for="comment in comments"
                :key="comment.id"
                class="bg-white rounded-xl shadow-sm border-1 text-sm font-medium dark:bg-slate-800 mb-4">
                <div class="flex gap-3 sm:p-4 p-2.5 text-sm font-medium">
                    <a href="#">
                        <img
                            :src="comment?.user?.avatar_url"
                            :alt="comment?.user?.name"
                            class="w-9 h-9 rounded-full">
                    </a>
                    <div class="flex-1">
                        <a href="#">
                            <h4 class="text-black dark:text-white">
                                {{ comment?.user?.name  }}
                            </h4>
                        </a>
                        <div class="text-xs text-gray-500 dark:text-white/80">
                            {{ age(comment.created_at) }} 
                        </div>
                    </div>
                    <div
                        v-if="comment.user?.id === $store.getters['authPages/userId']"
                        class="-mr-1 relative">
                        <dropdown-button-component
                            :items="[
                                {
                                    type: 'event',
                                    event: editComment,
                                    params: comment,
                                    label: 'Editar'
                                },
                                {
                                    type: 'event',
                                    event: deleteComment,
                                    params: comment,
                                    label: 'Eliminar',
                                    class: 'block px-4 py-2 text-sm text-red-500 hover:bg-red-100'
                                }
                            ]"/>
                    </div>
                </div>
                <div class="sm:px-4 p-2.5 pt-0">
                    <div 
                        class="font-normal dark:text-white" 
                        v-html="comment.content"></div>
                </div>
                <div
                    v-if="comment.replies.length > 0"
                    class="sm:p-4 p-2.5 border-t border-gray-100 font-normal space-y-3 dark:border-slate-700/40 hide-scrollbar xl:max-h-[300px] xl:overflow-auto">
                    <div 
                        v-for="reply in comment.replies" 
                        :key="reply.id" 
                        class="flex items-start gap-3">
                        <div class="flex-shrink-0"> 
                            <a href="#">
                                <img 
                                    :src="reply?.user?.avatar_url" 
                                    :alt="reply?.user?.name" 
                                    class="w-6 h-6 mt-1 rounded-full">
                            </a>
                        </div>
                        <div class="flex-1 overflow-x-auto">
                            <a href="#" class="text-black font-medium inline-block dark:text-white">
                                {{ reply.user.name }}
                            </a>
                            <div class="mt-0.5 dark:text-white comment" v-html="reply.content"></div>
                        </div>
                        <div 
                            v-if="reply.user.id === $store.getters['authPages/userId']" 
                            class="flex-shrink-0"> 
                            <dropdown-button-component
                                :items="[
                                    {
                                        type: 'event',
                                        event: editComment,
                                        params: reply,
                                        label: 'Editar'
                                    },
                                    {
                                        type: 'event',
                                        event: deleteComment,
                                        params: reply,
                                        label: 'Eliminar',
                                        class: 'block px-4 py-2 text-sm text-red-500 hover:bg-red-100'
                                    }
                                ]"/>
                        </div>
                    </div>
                </div>
                <div class="sm:px-4 sm:py-3 p-2.5 border-t border-gray-100 flex items-center gap-1 dark:border-slate-700/40">
                    <img
                        :src="$store.getters['authPages/userAvatar']"
                        :alt="$store.getters['authPages/userName']"
                        :uk-tooltip="`title: Publicar como: ${$store.getters['authPages/userName']}; pos: top`"
                        class="w-6 h-6 rounded-full">
                    <div class="flex-1 relative overflow-hidden h-10">
                        <input
                            placeholder="Agregar comentario..."
                            class="w-full resize-none !bg-transparent px-4 py-2 focus:!border-transparent focus:!ring-transparent dark:text-white border-0"
                            aria-haspopup="true"
                            aria-expanded="false"
                            v-model="comment.reply_content" />
                    </div>
                    <button
                        type="submit"
                        class="text-sm rounded-full py-1.5 px-3.5 bg-secondery dark:text-white"
                        @click="createReply(comment)">
                        Enviar
                    </button>
                </div>
            </div>
            <button
                v-if="has_more"
                class="w-full py-2 text-sm font-medium text-gray-600 rounded-lg dark:text-gray-200 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 transition-all"
                @click="fetchComment">
                Cargar más comentarios
            </button>
        </div>
        <modal-component
            ref="modalRef"
            id="commentModalComponent"
            :open="showEditor"
            @close="showEditor = false"
            :title="action === 'create' ? 'Añadir comentario' : 'Editar comentario'"
            :large-modal="true">
            <template v-slot:body>
                <div class="pb-5 px-5">
                    <editor-input-component
                        v-if="showEditor"
                        :extra-config="extraEditorConfig"
                        id="commentContentEditor"
                        name="comment_content"
                        :menubar="false"
                        :height="400"
                        :file="true"
                        :uploadUrl="fileUploadUrl"
                        :on-file-upload-success="handleFileUploadSuccess"
                        plugins="advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking table directionality template codesample"
                        toolbar="insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media codesample "
                        validators="required"
                        v-model="comment_content" />
                    <div class="flex justify-end">
                        <button
                            v-if="action === 'create'"
                            type="button"
                            class="button bg-blue-500 text-white py-2 px-12 text-[14px] rounded-lg"
                            @click="createComment">
                            Publicar comentario
                        </button>
                        <button
                            v-else
                            type="button"
                            class="button bg-blue-500 text-white py-2 px-12 text-[14px] rounded-lg"
                            @click="updateComment">
                            Actualizar comentario
                        </button>
                    </div>
                </div>
            </template>
        </modal-component>
    </div>
</template>

<script>
    // import '/public/vendor/tinymce/plugins/mention/mentions.css';
    import { EditorInputComponent } from 'innoboxrr-form-elements';
    import {
        indexModel as indexCommentModel,
        createModel as createCommentModel,
        updateModel as updateCommentModel,
        deleteModel as deleteCommentModel
     } from '@models/comment'

    export default {

        components: {
            EditorInputComponent
        },

        props: {
            toggleButtonText: {
                type: String,
                default: 'Añadir comentario'
            },
            commentableType: {
                type: String,
                required: true
            },
            commentableId: {
                type: Number,
                required: true
            },
            externalFilters: {
                type: Object,
                default: () => ({})
            },
        },

        data() {
            return {
                action: 'create', // create | update
                showEditor: false,
                comments: [],
                comment: {}, // comment to update
                comment_content: '',
                has_more: false,
                page: 1,
            }
        },

        async mounted() {
            await this.fetchData();
        },

        computed: {
            extraEditorConfig() {
                return {
                    /*
                    external_plugins: {
                        'mention': 'http://orlab.test/vendor/tinymce/plugins/mention/mine_plugin.js',
                        // 'mentions': 'http://orlab.test/vendor/tinymce/plugins/mention/tiny_plugin.js'
                    },

                    mention_format: function(user) {
                        return `<span class="mention">@${user.name}</span>`;
                    },

                    mention_fetch: async function(query, callback) {
                        let res = await indexUserModel({
                            paginate: 0,
                            loader: false,
                            name: query
                        });
                        callback(res.data);
                    },

                    mentions_fetch: async (query, success) => {
                        // Fetch your full user list from the server and cache locally
                        let res = await indexUserModel({
                            paginate: 0,
                            loader: false,
                            name: query
                        });

                        users = res.data.slice(0, 10);

                        console.log(users);

                        // Where the user object must contain the properties `id` and `name`
                        // but you could additionally include anything else you deem useful.
                        success(users);
                    }
                    */
                }
            }
        },

        methods: {

            async fetchData() {
                await this.fetchComment();
                this.comment_content = '';
                this.showEditor = false;
                this.action = 'create';
            },

            async fetchComment() {
                let res = await indexCommentModel({
                    page: this.page,
                    paginate: 20,
                    load_user: 1,
                    load_replies: 1,
                    not_replies: 1,
                    commentable_type: this.commentableType,
                    commentable_id: this.commentableId,
                    ...this.externalFilters
                });
                this.comments = this.comments.concat(res.data);
                this.has_more = res.links.next != null;
                this.page++;
            },

            showEditorComponent() {
                setTimeout(() => {
                    this.showEditor = true;
                }, 2500);
            },

            async createComment() {
                let res = await createCommentModel({
                    commentable_type: this.commentableType,
                    commentable_id: this.commentableId,
                    content: this.comment_content
                });
                this.alert('success');
                this.comments = [];
                this.page = 1;
                await this.fetchData(); // Pending. Update only the new comment
            },

            async createReply(comment) {
                let res = await createCommentModel({
                    commentable_type: 'App\\Models\\Comment',
                    commentable_id: comment.id,
                    content: comment.reply_content
                });
                this.alert('success');
                this.comments = [];
                this.page = 1;
                await this.fetchData(); // Pending. Update only the new comment
            },

            editComment(comment) {
                this.action = 'update';
                this.comment = comment;
                this.comment_content = comment.content;
                this.showEditor = true;
            },

            async updateComment() {
                let res = await updateCommentModel(this.comment.id,{
                    content: this.comment_content
                });
                this.alert('success');
                this.comments = [];
                this.page = 1;
                await this.fetchData(); // Pending. Update only the reply
            },

            async deleteComment(comment) {
                await deleteCommentModel(comment);
                this.alert('success');
                this.comments = [];
                this.page = 1;
                await this.fetchData(); // Pending. Update only the reply
            },

        }

    }

</script>

<style scoped>

    .comment {
        word-break: break-word;
    }

</style>
