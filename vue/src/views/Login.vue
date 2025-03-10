<template>
    <div class="flex items-center justify-center">
      <div class="bg-white shadow-lg rounded-xl p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">用户登录</h2>
  
        <!-- 邮箱输入框 -->
        <el-input
          v-model="email"
          type="email"
          placeholder="请输入邮箱"
          class="mb-4"
          size="large"
          clearable
          :class="'focus:!border-green-500 hover:!border-green-500 transition-all duration-200'"
        />
  
        <!-- 密码输入框 -->
        <el-input
          v-model="password"
          type="password"
          placeholder="请输入密码"
          show-password
          class="mb-4"
          size="large"
          clearable
          :class="'focus:!border-green-500 hover:!border-green-500 transition-all duration-200'"
        />
  
        <!-- 记住账号 & 忘记密码 -->
        <div class="flex justify-between items-center mb-6">
          <el-checkbox v-model="rememberMe" class="text-gray-700">记住账号</el-checkbox>
          <a href="#" class="text-green-600 hover:underline text-sm">忘记密码？</a>
        </div>
  
        <!-- 登录按钮 -->
        <el-button
          type="primary"
          size="large"
          class="w-full btn !bg-green-600 text-white hover:!bg-green-700 transition-all duration-200 shadow-md"
          @click="login"
        >
          登录
        </el-button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return { 
        email: "", 
        password: "", 
        rememberMe: false 
      };
    },
    mounted() {
      // **仅记住邮箱，不保存密码**
      const savedEmail = localStorage.getItem("rememberedEmail");
      if (savedEmail) {
        this.email = savedEmail;
        this.rememberMe = true;
      }
    },
    methods: {
      async login() {
        // 1️⃣ 先请求 Sanctum CSRF 令牌
        await fetch("http://laravel-vue.local/sanctum/csrf-cookie", {
          credentials: "include"
        });
  
        // 2️⃣ 发送登录请求
        const response = await fetch("http://laravel-vue.local/api/login", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          credentials: "include",
          body: JSON.stringify({ email: this.email, password: this.password }),
        });
  
        if (response.ok) {
          ElMessage.success("✅ 登录成功");
  
          // 记住账号逻辑（不保存密码！）
          if (this.rememberMe) {
            localStorage.setItem("rememberedEmail", this.email);
          } else {
            localStorage.removeItem("rememberedEmail");
          }
  
          this.$router.push("/profile"); // 跳转到用户主页
        } else {
          ElMessage.error("❌ 登录失败，请检查账号或密码");
        }
      }
    }
  };
  </script>
  