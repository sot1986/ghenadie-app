<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Post } from '../../types/Resources/post';
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';

defineOptions({
  name: 'posts.list',
  inheritAttrs: false,
  layout: AuthenticatedLayout,
})

withDefaults(defineProps<{
  posts: Post[],
  deleted_posts: Post[],
}>(), {
  posts: () => [],
  deleted_posts: () => [],
})

function deletePost(id: number) {
  return router.delete(route('posts.destroy', id));
}

function restorePost(id: number) {
  return router.put(route('posts.restore', id));
}

function forceDelete(id: number) {
  return router.delete(route('posts.force-delete', id));
}

function specialPost(id: number) {
  return router.patch(route('posts.special', id), {
    special: 60,
  });
}
</script>

<template>
  <div>

    <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all posts.</p>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add post</button>
      </div>
    </div>
   <ul>
    <li v-for="post in posts" :key="post.id" class="flex">
      <div class="flex-1">
      <h4 class="text-xl">{{ post.title }}</h4>
      <p class="text-sm text-gray-500 line-clamp-2" >{{ post.body }}</p>
    </div>
    <div class="flex items-center p-2 gap-2">
      <button type="button" class="text-red-500 font-semibold text-xl" @click="deletePost(post.id)">X</button>
      <button type="button" class="text-blue-500" @click="specialPost(post.id)">S</button>
    </div>
    </li>
   </ul>
  </div>

  <div>
    <h2>Deleted Posts</h2>
    <ul>
      <li v-for="post in deleted_posts" class="flex items-center gap-x-2">
        <span class="flex-1">{{ post.title }}</span>
        <button type="button" @click="restorePost(post.id)" class="bg-green-500 p-1">R</button>
        <button type="button" @click="forceDelete(post.id)" class="text-red-500 font-semibold">X X</button>
      </li>
    </ul>
  </div>
  </div>
</template>
