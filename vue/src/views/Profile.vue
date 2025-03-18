<template>
  <div class="max-w-5xl mx-auto p-6">
    <div class="flex flex-col md:flex-row gap-6 items-start">
      
      <!-- 左侧：头像 + 个人简介 -->
      <div class="w-full md:w-1/3">
        <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden">
          <!-- 头像 -->
          <div class="p-6 text-center">
            <img
              :src="avatarUrl"
              alt="用户头像"
              class="w-40 h-40 rounded-full mx-auto object-cover border-4 border-gray-300"
            />
          </div>
          
          <!-- 个人简介 -->
          <div class="bg-white p-6 text-center">
            <h3 class="text-lg font-semibold text-gray-900">Introduction</h3>
            <p class="text-gray-600">{{ userStore.user.bio || "A sint non quasi consequatur soluta aliquam." }}</p>
          </div>

          <!-- 加入时间 -->
          <div class="bg-white p-6 text-center border-t">
            <h4 class="text-md font-semibold text-gray-900">Joined on</h4>
            <p class="text-gray-600">{{ joinedDate }}</p>
          </div>
        </div>
      </div>

      <!-- 右侧：用户信息 + 话题列表 -->
      <div class="w-full md:w-2/3">
        <div class="bg-white shadow-md rounded-lg p-6">
          <h2 class="text-2xl font-bold text-gray-900">{{ userStore.user.name }}</h2>
          <p class="text-gray-700">{{ userStore.user.email }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mt-4">
          <!-- Tab 切换 -->
          <el-tabs v-model="activeTab">
            <el-tab-pane label="Posted" name="posted"></el-tab-pane>
            <el-tab-pane label="Replied" name="replied"></el-tab-pane>
          </el-tabs>

          <!-- 话题列表 -->
          <ul class="divide-y divide-gray-200">
            <li v-for="post in posts" :key="post.id" class="py-3">
              <a href="#" class="text-blue-600 hover:underline">{{ post.title }}</a>
              <span class="text-gray-500 text-sm"> · {{ post.replies }} replies · {{ post.timeAgo }}</span>
            </li>
          </ul>

          <!-- 分页 -->
          <div class="mt-4 flex justify-center">
            <el-pagination
              v-model:current-page="currentPage"
              :page-size="5"
              layout="prev, pager, next"
              :total="15"
            />
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'
import { useUserStore } from '../stores/user'

const userStore = useUserStore()
const activeTab = ref("posted")
const currentPage = ref(1)

onMounted(() => {
  userStore.fetchUser()
})

// 计算头像 URL
const avatarUrl = computed(() => {
  if (userStore.user && userStore.user.avatar) {
    return `http://laravel-vue.local/storage/${userStore.user.avatar}`
  }
  return 'http://laravel-vue.local/storage/avatar/1.png'
})

const joinedDate = computed(() => {
  if (!userStore.user?.created_at) return "N/A"; // 处理空值
  const date = new Date(userStore.user.created_at);
  return date.toISOString().split("T")[0]; // 提取 YYYY-MM-DD 部分
});

// 模拟帖子数据
const posts = ref([
  { id: 1, title: "Qui numquam minima accusantium voluptatem.", replies: 5, timeAgo: "4 days ago" },
  { id: 2, title: "Non nemo dolor ea qui dolores aspernatur assumenda.", replies: 13, timeAgo: "1 week ago" },
  { id: 3, title: "Fuga dolore tenetur ipsa eum ut alias fugit.", replies: 12, timeAgo: "2 weeks ago" },
  { id: 4, title: "Eum facere quibusdam ut veniam eos aspernatur doloremque.", replies: 12, timeAgo: "2 weeks ago" },
  { id: 5, title: "Nulla blanditiis nostrum qui corporis dignissimos voluptatem.", replies: 12, timeAgo: "2 weeks ago" }
])
</script>