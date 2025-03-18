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

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { apiRequest } from '../utils/api';
import { ElMessage } from 'element-plus';

const router = useRouter();

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const isSubmitting = ref(false);

const passwordMismatch = computed(
  () => {return password.value !== confirmPassword.value && confirmPassword.value.length > 0;});

async function register() {
  if (passwordMismatch.value) {
    return ElMessage.warning("❌ 两次输入的密码不一致");
  }
  if (isSubmitting.value) return
  isSubmitting.value = true;
  try {
    const response = await apiRequest("http://laravel-vue.local/api/register", {
      method: 'POST',
      body: JSON.stringify({
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: confirmPassword.value,
      }),
    });
    if (response.ok) {
      ElMessage.success('注册成功,请在登陆前验证邮箱');
      router.push('/verify-email');
    } else {
      const errorData = await response.json();
      ElMessage.error(`❌ 注册失败: ${errorData.message || '请检查账号或密码'}`);
    }
  } catch (error) {
    console.error('注册失败:', error);
    ElMessage.error("网络错误，注册失败");
  } finally {
    isSubmitting.value = false;
  }
}
</script>