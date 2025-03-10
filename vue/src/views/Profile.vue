<template>
    <div>
      <h2>个人信息</h2>
      <p v-if="user">欢迎，{{ user.name }}（{{ user.email }}）</p>
      <button @click="logout">退出登录</button>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return { user: null };
    },
    async mounted() {
      const response = await fetch("http://laravel-vue.local/api/user", {
        credentials: "include"
      });
  
      if (response.ok) {
        this.user = await response.json();
      }
    },
    methods: {
      async logout() {
        await fetch("http://laravel-vue.local/api/logout", {
          method: "POST",
          credentials: "include",
        });
        alert("✅ 退出成功");
        window.location.href = "/login"; // 退出后跳转到登录页
      }
    }
  };
  </script>
  