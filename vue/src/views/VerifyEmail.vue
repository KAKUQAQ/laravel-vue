<template>
    <div class="p-6 bg-white rounded shadow-md max-w-md mx-auto mt-10">
      <h2 class="text-2xl font-bold mb-4">邮箱验证</h2>
  
      <p v-if="userEmail" class="mb-4">
        我们已经向你的邮箱
        <strong class="text-blue-600">{{ userEmail }}</strong>
        发送了一封验证邮件，请前往邮箱查收并点击验证链接。
      </p>
      <p v-else class="mb-4">
        无法获取用户邮箱信息，请先登录后再尝试。
      </p>
  
      <!-- 重新发送验证邮件按钮 -->
      <el-button
        class="mt-2"
        type="primary"
        size="large"
        :loading="isSending"
        :disabled="!userEmail"
        @click="resendVerificationEmail"
      >
        重新发送验证邮件
      </el-button>
  
      <!-- 发送成功提示 -->
      <el-alert
        v-if="reSentSuccess"
        class="mt-4"
        type="success"
        title="验证邮件已重新发送，请查看邮箱"
        show-icon
      />
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        userEmail: "",        // 用于显示的当前用户邮箱
        isSending: false,     // “重新发送验证邮件” 按钮的 loading 状态
        reSentSuccess: false, // 是否提示“发送成功”
      };
    },
    async mounted() {
      // 组件挂载后，尝试获取当前登录用户信息
      try {
        const response = await fetch("http://laravel-vue.local/api/user", {
          credentials: "include", // 携带Cookie或其他登录信息
        });
        if (response.ok) {
          const data = await response.json();
          this.userEmail = data.email || "";
        } else {
          console.error("获取用户信息失败:", response.status);
        }
      } catch (error) {
        console.error("获取用户信息异常:", error);
      }
    },
    methods: {
      async resendVerificationEmail() {
        if (!this.userEmail) return; // 没有邮箱说明用户未登录
  
        this.isSending = true;
        this.reSentSuccess = false;
  
        try {
          // 1. 获取 Sanctum CSRF Cookie（如果后端需要）
          await fetch("http://laravel-vue.local/sanctum/csrf-cookie", {
            method: "GET",
            credentials: "include",
          });
  
          // 2. 解析 XSRF-TOKEN
          const xsrfToken = document.cookie
            .split("; ")
            .find((row) => row.startsWith("XSRF-TOKEN="))
            ?.split("=")[1];
          if (!xsrfToken) {
            this.$message.error("无法获取 CSRF 令牌，请检查后端设置");
            return;
          }
  
          // 3. 调用后端“重新发送验证邮件”接口
          const response = await fetch("http://laravel-vue.local/api/email/verification-notification", {
            method: "POST",
            headers: {
              "X-XSRF-TOKEN": decodeURIComponent(xsrfToken),
            },
            credentials: "include",
          });
  
          if (response.ok) {
            this.reSentSuccess = true;
          } else {
            this.$message.error("验证邮件发送失败，请稍后再试。");
          }
        } catch (error) {
          console.error("发送验证邮件异常:", error);
          this.$message.error("网络异常，发送失败。");
        } finally {
          this.isSending = false;
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* 可以在这里加入你需要的额外定制样式 */
  /* 也可直接使用Tailwind类名配合Element Plus组件 */
  </style>
  