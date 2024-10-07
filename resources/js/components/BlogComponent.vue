<!-- resources/js/components/BlogComponent.vue -->
<template>
    <div>
        <h1>Blog Posts</h1>
        <button @click="showCreateForm">Create New Blog</button>
        
        <div v-if="blogs.length > 0">
            <ul>
                <li v-for="blog in blogs" :key="blog.id">
                    <h3>{{ blog.title }}</h3>
                    <img :src="`/storage/${blog.image}`" v-if="blog.image" alt="Blog Image" width="100">
                    <p>{{ blog.description }}</p>
                    <button @click="showEditForm(blog)">Edit</button>
                    <button @click="deleteBlog(blog.id)">Delete</button>
                </li>
            </ul>
        </div>
        <div v-else>
            <p>No blogs available.</p>
        </div>
        
        <!-- Create/Edit Form -->
        <div v-if="isFormVisible">
            <h2 v-if="isEditing">Edit Blog</h2>
            <h2 v-else>Create Blog</h2>
            <form @submit.prevent="isEditing ? updateBlog() : createBlog()">
                <input v-model="formData.title" placeholder="Title" required>
                <textarea v-model="formData.description" placeholder="Description" required></textarea>
                <input type="file" @change="onFileChange">
                <button type="submit">Save</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            blogs: [],
            isFormVisible: false,
            isEditing: false,
            formData: {
                id: null,
                title: '',
                description: '',
                image: null,
            },
        };
    },
    mounted() {
        this.fetchBlogs();
    },
    methods: {
        fetchBlogs() {
            axios.get('/api/blogs').then(response => {
                this.blogs = response.data;
            });
        },
        showCreateForm() {
            this.isFormVisible = true;
            this.isEditing = false;
            this.formData = {
                id: null,
                title: '',
                description: '',
                image: null,
            };
        },
        showEditForm(blog) {
            this.isFormVisible = true;
            this.isEditing = true;
            this.formData = { ...blog, image: null };
        },
        onFileChange(e) {
            this.formData.image = e.target.files[0];
        },
        createBlog() {
            const formData = new FormData();
            formData.append('title', this.formData.title);
            formData.append('description', this.formData.description);
            if (this.formData.image) {
                formData.append('image', this.formData.image);
            }

            axios.post('/api/blogs', formData)
                .then(response => {
                    this.blogs.push(response.data);
                    this.isFormVisible = false;
                });
        },
        updateBlog() {
            const formData = new FormData();
            formData.append('title', this.formData.title);
            formData.append('description', this.formData.description);
            if (this.formData.image) {
                formData.append('image', this.formData.image);
            }
            axios.post(`/api/blogs/${this.formData.id}`, formData)
                .then(response => {
                    const index = this.blogs.findIndex(blog => blog.id === this.formData.id);
                    this.$set(this.blogs, index, response.data);
                    this.isFormVisible = false;
                });
        },
        deleteBlog(id) {
            axios.delete(`/api/blogs/${id}`).then(() => {
                this.blogs = this.blogs.filter(blog => blog.id !== id);
            });
        }
    }
}
</script>
