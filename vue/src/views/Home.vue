<template>
    <div class="max-w-5xl mx-auto p-6">
      <h1 class="text-3xl font-bold mb-4">欢迎来到社区论坛</h1>
      <p class="text-lg text-gray-700">
        这是一个交流游戏、分享攻略的地方。快来加入讨论吧！
      </p>
  
      <div class="mt-6">
        <h2 class="text-2xl font-semibold">热门话题</h2>
        <ul class="mt-4">
          <li v-for="topic in topics" :key="topic.id" class="border-b py-2">
            <router-link :to="`/topic/${topic.id}`" class="text-blue-600 hover:underline">
              {{ topic.title }}
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        topics: [], // 存储热门话题
      };
    },
    async mounted() {
      const response = await fetch("http://laravel-vue.local/api/topics");
      if (response.ok) {
        this.topics = await response.json();
      }
    },
  };
  </script>
  