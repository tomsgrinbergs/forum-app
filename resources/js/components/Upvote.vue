<template>
    <div class="flex justify-between items-center">
        <div>Upvotes: {{ upvotesCount }}</div>
        <button
            v-if="isAuthenticated && !alreadyUpvoted"
            type="button"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            @click="submit"
        >
            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Upvote
        </button>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    props: {
        upvoteUrl: {
            type: String,
            required: true,
        },
        isAuthenticated: {
            type: Boolean,
            required: true,
        },
        initUpvotesCount: {
            type: Number,
            required: true,
        },
        initAlreadyUpvoted: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            loading: false,
            upvotesCount: this.initUpvotesCount,
            alreadyUpvoted: this.initAlreadyUpvoted,
        }
    },
    methods: {
        submit() {
            if (this.loading) {
                return
            }

            this.loading = true

            axios.post(this.upvoteUrl)
                .then((response) => {
                    this.upvotesCount = response.data.upvotesCount
                    this.alreadyUpvoted = true
                })
                .catch(error => console.error(error))
                .then(() => this.loading = false)
        },
    },
}
</script>
