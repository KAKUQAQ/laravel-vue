<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const user = ref(null);

// 获取当前登录用户
async function fetchUser() {
  const response = await fetch("http://laravel-vue.local/api/user", {
    credentials: "include",
  });

  if (response.ok) {
    user.value = await response.json();
  }
}

// 退出登录
async function logout() {
  await fetch("http://laravel-vue.local/api/logout", {
    method: "POST",
    credentials: "include",
  });

  user.value = null;
  router.push("/login"); // 退出后跳转到登录页
}

// 页面加载时获取用户信息
onMounted(fetchUser);
</script>

<template>
  <div class="">
    <!-- 顶部导航栏 -->
    <nav class="fixed w-full top-0 left-0 right-0 z-50 bg-gray-900 shadow-md">
      <div class="max-w-7xl mx-auto flex justify-between items-center h-16 px-6">
        <div class="text-2xl font-bold text-white">社区论坛</div>

        <!-- 导航菜单 -->
        <div class="hidden md:flex space-x-6">
          <router-link to="/" class="text-white hover:text-gray-300 transition">首页</router-link>
          <router-link to="/topics" class="text-white hover:text-gray-300 transition">热门</router-link>
          <router-link to="/games" class="text-white hover:text-gray-300 transition">游戏专区</router-link>
          <router-link to="/guides" class="text-white hover:text-gray-300 transition">攻略中心</router-link>
        </div>

        <!-- 右侧用户菜单 -->
        <div class="flex space-x-4">
          <template v-if="user">
            <router-link to="/profile" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
              个人中心
            </router-link>
            <button @click="logout" class="bg-yellow-600 transition">
              退出
            </button>
          </template>
          <template v-else>
            <router-link to="/login" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
              登录
            </router-link>
            <router-link to="/register" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
              注册
            </router-link>
          </template>
        </div>
      </div>
    </nav>

    <!-- 页面主体 -->
    <main class="pt-20">
      <router-view></router-view>
    </main>
  </div>
</template>
