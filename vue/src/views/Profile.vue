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
      // 1. 获取最新的 CSRF 令牌（可选，如果确定已经获取过且未过期，可省略这一步）
      await fetch("http://laravel-vue.local/sanctum/csrf-cookie", {
        method: "GET",
        credentials: "include",
      });

      // 2. 从 Cookie 中拿到 XSRF-TOKEN
      const xsrfToken = document.cookie
        .split("; ")
        .find(row => row.startsWith("XSRF-TOKEN="))
        ?.split("=")[1];

      // 3. 发起登出请求并携带 X-XSRF-TOKEN
      const response = await fetch("http://laravel-vue.local/api/logout", {
        method: "POST",
        headers: {
          "X-XSRF-TOKEN": decodeURIComponent(xsrfToken ?? ""),
        },
        credentials: "include",
      });

      if (response.ok) {
        alert("✅ 退出成功");
        window.location.href = "/login";
      } else {
        // 如果有报错信息可进一步打印
        console.error("Logout failed", await response.text());
      }
    }
  }
};
</script>