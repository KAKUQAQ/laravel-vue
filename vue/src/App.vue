<script setup>
import HelloWorld from './components/HelloWorld.vue'
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <!-- 顶部导航栏 -->
    <nav class="fixed w-full top-0 left-0 right-0 z-50 bg-gray-900 shadow-md">
      <div class="max-w-7xl mx-auto flex justify-between items-center h-16 px-6">
        <div class="text-2xl font-bold text-white">社区论坛</div>
        <div class="hidden md:flex space-x-6">
          <a href="#" class="text-white hover:text-gray-300 transition">首页</a>
          <a href="#" class="text-white hover:text-gray-300 transition">热门</a>
          <a href="#" class="text-white hover:text-gray-300 transition">游戏专区</a>
          <a href="#" class="text-white hover:text-gray-300 transition">攻略中心</a>
        </div>
        <div class="flex space-x-4">
          <a href="#" class="text-white hover:text-gray-300 transition">登录</a>
          <a href="#" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all shadow-md">
            注册
          </a>
        </div>
      </div>
    </nav>

    <!-- 页面主体 -->
    <main class="pt-20">
      <HelloWorld />
    </main>
  </div>
</template>
