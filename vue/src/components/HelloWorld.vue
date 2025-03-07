<script setup>
import { ref } from 'vue'
import { ElMessage } from 'element-plus'

// 游戏分类
const categories = ref([
  '全部', 'MMORPG', '动作游戏', '射击游戏', '策略游戏', '卡牌游戏', '体育游戏'
])
const selectedCategory = ref('全部')

// 帖子数据
const posts = ref([
  { 
    id: 1, title: '欢迎来到我们的论坛', author: '管理员', date: '2024-03-20', 
    replies: 5, likes: 12, views: 156, image: 'https://picsum.photos/300/200?random=1'
  },
  { 
    id: 2, title: '论坛使用指南', author: '管理员', date: '2024-03-20', 
    replies: 3, likes: 8, views: 89, image: 'https://picsum.photos/300/200?random=2'
  },
  { 
    id: 3, title: '分享一下大家的使用体验', author: '用户01', date: '2024-03-20', 
    replies: 8, likes: 15, views: 234, image: 'https://picsum.photos/300/200?random=3'
  }
])

// 发布新帖相关
const dialogVisible = ref(false)
const formRef = ref(null)
const form = ref({ title: '', content: '' })
const rules = {
  title: [{ required: true, message: '请输入标题', trigger: 'blur' }],
  content: [{ required: true, message: '请输入内容', trigger: 'blur' }]
}

const handleSubmit = async () => {
  if (!formRef.value) return
  await formRef.value.validate((valid) => {
    if (valid) {
      ElMessage.success('发布成功')
      dialogVisible.value = false
      form.value = { title: '', content: '' }
    }
  })
}
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- 游戏分类导航 -->
    <div class="mb-8 bg-gray-900 rounded-xl p-4 flex items-center space-x-6 overflow-x-auto">
      <span class="text-gray-300 font-medium whitespace-nowrap">游戏分类：</span>
      <div class="flex space-x-4">
        <button 
          v-for="category in categories" 
          :key="category"
          @click="selectedCategory = category"
          :class="[
            'px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200',
            selectedCategory === category 
              ? 'bg-green-600 text-white shadow-md' 
              : 'bg-gray-200 text-gray-700 hover:bg-green-600 hover:text-white'
          ]"
        >
          {{ category }}
        </button>
      </div>
    </div>

    <!-- 帖子列表 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div 
        v-for="post in posts" 
        :key="post.id" 
        class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
      >
        <img :src="post.image" :alt="post.title" class="w-full h-48 object-cover rounded-t-2xl">
        <div class="p-6">
          <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">{{ post.title }}</h3>
          <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
            <span class="flex items-center">
              <el-icon><UserFilled /></el-icon>
              {{ post.author }}
            </span>
            <span>{{ post.date }}</span>
          </div>
          <el-button type="text" class="text-green-600 hover:text-green-700">查看详情</el-button>
        </div>
      </div>
    </div>

    <!-- 发布新帖按钮 -->
    <div class="flex justify-center mt-8">
      <el-button type="primary" @click="dialogVisible = true" class="!bg-green-600 hover:!bg-green-700 !border-none px-6 py-3">
        发布新帖
      </el-button>
    </div>

    <!-- 发布新帖对话框 -->
    <el-dialog v-model="dialogVisible" title="发布新帖" width="50%" class="!max-w-2xl !rounded-2xl">
      <el-form ref="formRef" :model="form" :rules="rules" label-width="80px" class="mt-4">
        <el-form-item label="标题" prop="title">
          <el-input v-model="form.title" placeholder="请输入标题" class="!rounded-lg focus:!border-green-500 hover:!border-green-500" />
        </el-form-item>
        <el-form-item label="内容" prop="content">
          <el-input v-model="form.content" type="textarea" :rows="6" placeholder="请输入内容" class="!rounded-lg focus:!border-green-500 hover:!border-green-500" />
        </el-form-item>
      </el-form>
      <template #footer>
        <div class="flex justify-end gap-4">
          <el-button @click="dialogVisible = false" class="!border-gray-300 hover:!border-gray-400 !text-gray-600">取消</el-button>
          <el-button type="primary" @click="handleSubmit" class="!bg-green-600 hover:!bg-green-700 !border-none">发布</el-button>
        </div>
      </template>
    </el-dialog>
  </div>
</template>
