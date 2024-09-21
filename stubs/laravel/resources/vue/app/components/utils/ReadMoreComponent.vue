<template>
    <div>
        <div 
            class="content read-style" 
            :class="{'expanded': isExpanded}" 
            :style="contentStyle" 
            ref="content"
        >
            <div v-html="text"></div>
            <div class="fade-out" v-if="!isExpanded && shouldShowToggle"></div>
        </div>
        <a v-if="shouldShowToggle" href="#" @click.prevent="toggleReadMore" class="read-more-link">
            {{ isExpanded ? '- Read less' : '+ Read more' }}
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            text: {
                type: String,
                required: true,
            },
            limit: {
                type: Number,
                default: 300,
            },
        },
        data() {
            return {
                isExpanded: false,
                maxHeight: `${this.limit / 2}px`,
                shouldShowToggle: false,
            };
        },
        watch: {
            isExpanded(newVal) {
                this.adjustHeight(newVal);
            }
        },
        computed: {
            contentStyle() {
                return { maxHeight: this.maxHeight, transition: 'max-height 0.5s ease' };
            },
        },
        methods: {
            toggleReadMore() {
                this.isExpanded = !this.isExpanded;
            },
            adjustHeight(expanded) {
                const content = this.$refs.content;
                if (expanded) {
                    this.maxHeight = `${content.scrollHeight}px`;
                    this.$nextTick(() => {
                        content.scrollIntoView({ behavior: 'smooth' });
                    });
                } else {
                    this.maxHeight = `${this.limit / 2}px`;
                }
            },
            checkContentHeight() {
                const content = this.$refs.content;
                this.shouldShowToggle = content.scrollHeight > this.limit / 2;
            }
        },
        mounted() {
            this.adjustHeight(this.isExpanded);
            this.checkContentHeight();
        }
    };
</script>

<style scoped>
    .content {
        position: relative;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }
    .content.expanded {
        max-height: none;
    }
    .fade-out {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        background: linear-gradient(to top, white, rgba(255, 255, 255, 0));
    }
    .dark .fade-out {
        background: linear-gradient(to top, #1a1a1a, rgba(26, 26, 26, 0));
    }
    .read-more-link {
        display: block;
        margin-top: 10px;
        color: blue;
        cursor: pointer;
    }
    .dark .read-more-link {
        color: lightblue;
    }
</style>
