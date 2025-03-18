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
        :disabled="isSubmitting"
      >
        登录
      </el-button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../stores/user';
import { ElMessage } from 'element-plus';

const router = useRouter();
const userStore = useUserStore();

const email = ref('');
const password = ref('');
const rememberMe = ref(false);
const isSubmitting = ref(false);

const savedEmail = localStorage.getItem('rememberedEmail');
if (savedEmail) {
  email.value = savedEmail;
  rememberMe.value = true;
}

async function login() {
  if (isSubmitting.value) return;
  isSubmitting.value = true;
  try {await userStore.login(email.value, password.value, rememberMe.value);
    ElMessage.success('登录成功');
    if (userStore.user && userStore.user.email_verified_at) {
      router.push('/profile');
    } else {
      router.push('/verify-email');
    }
  } catch (error) {
    console.error('登录失败:', error);
    ElMessage.error(`登录失败: ${error.message || "请检查账号或密码"}`);
  } finally {
    isSubmitting.value = false;}
}
</script>
