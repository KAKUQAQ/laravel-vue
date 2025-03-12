<template>
  <div class="flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-xl p-8 max-w-md w-full">
      <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">用户注册</h2>

      <!-- 用户名 -->
      <el-input v-model="name" type="text" placeholder="请输入用户名" class="mb-4" size="large" clearable />

      <!-- 邮箱 -->
      <el-input v-model="email" type="email" placeholder="请输入邮箱" class="mb-4" size="large" clearable />

      <!-- 密码 -->
      <el-input v-model="password" type="password" placeholder="请输入密码" show-password class="mb-4" size="large"
        clearable />

      <!-- 确认密码 -->
      <el-input v-model="confirmPassword" type="password" placeholder="请再次输入密码" show-password class="mb-4" size="large"
        clearable />

      <!-- 密码错误提示 -->
      <p v-if="passwordMismatch" class="text-red-500 text-sm mb-4">❌ 两次输入的密码不一致</p>

      <!-- 注册按钮 -->
      <el-button type="primary" size="large" class="w-full !bg-green-600 text-white hover:!bg-green-700 shadow-md"
        :disabled="passwordMismatch || isSubmitting" @click="register">
        注册
      </el-button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
      isSubmitting: false, // 防止重复提交
    };
  },
  computed: {
    // 计算属性：检测密码是否一致
    passwordMismatch() {
      return this.password !== this.confirmPassword && this.confirmPassword.length > 0;
    }
  },
  methods: {
    async register() {
      if (this.passwordMismatch) {
        return ElMessage.warning("❌ 两次输入的密码不一致");
      }

      if (this.isSubmitting) return;
      this.isSubmitting = true;

      try {
        // 1️⃣ **先获取 CSRF 令牌**
        await fetch("http://laravel-vue.local/sanctum/csrf-cookie", {
          method: "GET",
          credentials: "include",
        });

        // 2️⃣ **获取 `XSRF-TOKEN`**
        const xsrfToken = document.cookie
          .split("; ")
          .find((row) => row.startsWith("XSRF-TOKEN="))
          ?.split("=")[1];

        if (!xsrfToken) {
          ElMessage.error("❌ CSRF 令牌获取失败，请检查 `sanctum/csrf-cookie` 是否返回正确的 Cookie。");
          return;
        }

        // 3️⃣ **发送注册请求**
        const response = await fetch("http://laravel-vue.local/api/register", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-XSRF-TOKEN": decodeURIComponent(xsrfToken),
          },
          credentials: "include",
          body: JSON.stringify({
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.confirmPassword,
          }),
        });

        if (response.ok) {
          ElMessage.success("✅ 注册成功，请查看邮箱进行邮箱验证");
          this.$router.push("/verify-email");
        } else {
          const errorData = await response.json();
          ElMessage.error(`❌ 注册失败: ${errorData.message || "请检查输入"}`);
        }
      } catch (error) {
        console.error("注册请求失败:", error);
        ElMessage.error("❌ 网络错误，注册失败");
      } finally {
        this.isSubmitting = false;
      }
    }
  }
};
</script>