<template>
    <div>
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">{{ title }}</h1>
        </div>

        <div ref="registration">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                title: ''
            }
        },
    }
</script>
