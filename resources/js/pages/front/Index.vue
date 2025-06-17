<template>
    <AppIndexLayout>
        <div class="container mx-auto">
            <!-- Hero Section -->
            <section class="relative mb-16 overflow-hidden rounded-lg">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-800 opacity-90"></div>
                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=2850&q=80" 
                     alt="Dashboard Preview" 
                     class="absolute inset-0 w-full h-full object-cover mix-blend-overlay">
                <div class="relative z-10 px-8 py-24 md:py-32 flex flex-col items-center text-center text-white">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">Build Powerful Dashboards, Faster</h1>
                    <p class="text-xl md:text-2xl mb-8 max-w-3xl">30% Off The Complete UI Kit</p>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-8 py-4 rounded-lg text-lg transition transform hover:scale-105 shadow-lg">
                        GET THE KIT
                    </button>
                </div>
            </section>

            <!-- Feature Bar (Trust & Value Signals) -->
            <section class="mb-16 bg-white rounded-lg shadow-md py-10 px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Instant Access -->
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-blue-100 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Instant Access</h3>
                        <p class="text-gray-600">Receive your files immediately after purchase. No waiting.</p>
                    </div>
                    
                    <!-- Dedicated Support -->
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-green-100 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Dedicated Support</h3>
                        <p class="text-gray-600">Gain access to our expert team and detailed documentation.</p>
                    </div>
                    
                    <!-- Satisfaction Guarantee -->
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-yellow-100 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Satisfaction Guarantee</h3>
                        <p class="text-gray-600">If you're not satisfied, request a full refund within 30 days.</p>
                    </div>
                </div>
            </section>

            <!-- Product Grid (New Arrivals) -->
            <section id="templates" class="mb-16">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold">New Arrivals</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View All</a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <div v-for="product in digitalProducts" :key="product.id" class="bg-white rounded-lg shadow-md overflow-hidden group">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden">
                            <img :src="product.product_image_preview" :alt="product.product_name" class="w-full h-56 object-cover transition duration-300 group-hover:scale-105">
                            
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-70 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <div class="flex space-x-2">
                                    <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Live Preview</a>
                                    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Add to Cart</button>
                                </div>
                            </div>
                            
                            <!-- Status Badge -->
                            <div v-if="product.status_badges" class="absolute top-2 left-2">
                                <span v-for="badge in product.status_badges" :key="badge" 
                                      class="inline-block px-2 py-1 text-xs font-semibold rounded mr-1"
                                      :class="{
                                          'bg-blue-500 text-white': badge === 'New',
                                          'bg-red-500 text-white': badge === 'Sale',
                                          'bg-purple-500 text-white': badge === 'Featured'
                                      }">
                                    {{ badge }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-5">
                            <h3 class="text-lg font-semibold mb-2">{{ product.product_name }}</h3>
                            
                            <!-- Compatibility Tags -->
                            <div class="flex flex-wrap mb-3">
                                <span v-for="tag in product.compatibility_tags" :key="tag" 
                                      class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                    {{ tag }}
                                </span>
                            </div>
                            
                            <!-- Price -->
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-blue-600">${{ product.price.toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Content Module (Tutorials & Resources) -->
            <section id="tutorials" class="mb-16">
                <h2 class="text-3xl font-bold mb-8">Tutorials & Resources</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <div v-for="resource in tutorials" :key="resource.id" class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img :src="resource.image" :alt="resource.title" class="w-full h-48 object-cover">
                        <div class="p-5">
                            <h3 class="text-xl font-semibold mb-2">{{ resource.title }}</h3>
                            <p class="text-gray-600 mb-4">{{ resource.description }}</p>
                            <a :href="resource.link" class="text-blue-600 hover:text-blue-800 font-medium">Read More →</a>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="#" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        Explore All Resources
                    </a>
                </div>
            </section>
        </div>
    </AppIndexLayout>
</template>

<script setup lang="ts">
import AppIndexLayout from '@/layouts/app/AppFrontLayout.vue';

// Digital Products for the Product Grid
const digitalProducts = [
    {
        id: 1,
        product_name: 'Pro Analytics Dashboard UI Kit',
        compatibility_tags: ['Figma', 'Sketch', 'Adobe XD'],
        price: 59.99,
        product_image_preview: 'https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&w=800&q=80',
        status_badges: ['New', 'Featured']
    },
    {
        id: 2,
        product_name: 'E-commerce Admin Template',
        compatibility_tags: ['Figma', 'HTML/CSS', 'React'],
        price: 79.99,
        product_image_preview: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
        status_badges: ['Sale']
    },
    {
        id: 3,
        product_name: 'Social Media UI Components',
        compatibility_tags: ['Figma', 'Sketch'],
        price: 39.99,
        product_image_preview: 'https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?auto=format&fit=crop&w=800&q=80',
        status_badges: ['New']
    },
    {
        id: 4,
        product_name: 'Crypto Dashboard Template',
        compatibility_tags: ['Figma', 'React', 'Vue'],
        price: 89.99,
        product_image_preview: 'https://images.unsplash.com/photo-1605792657660-596af9009e82?auto=format&fit=crop&w=800&q=80',
        status_badges: []
    },
    {
        id: 5,
        product_name: 'Mobile App UI Kit',
        compatibility_tags: ['Figma', 'Sketch', 'Flutter'],
        price: 49.99,
        product_image_preview: 'https://images.unsplash.com/photo-1555774698-0b77e0d5fac6?auto=format&fit=crop&w=800&q=80',
        status_badges: ['Sale']
    },
    {
        id: 6,
        product_name: 'Responsive Portfolio Template',
        compatibility_tags: ['HTML/CSS', 'WordPress'],
        price: 29.99,
        product_image_preview: 'https://images.unsplash.com/photo-1522542550221-31fd19575a2d?auto=format&fit=crop&w=800&q=80',
        status_badges: []
    },
    {
        id: 7,
        product_name: 'SaaS Landing Page Template',
        compatibility_tags: ['Figma', 'HTML/CSS', 'React'],
        price: 39.99,
        product_image_preview: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
        status_badges: ['New']
    },
    {
        id: 8,
        product_name: 'Data Visualization Components',
        compatibility_tags: ['React', 'Vue', 'Angular'],
        price: 69.99,
        product_image_preview: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80',
        status_badges: ['Featured']
    },
];

// Tutorials and Resources for the Content Module
const tutorials = [
    {
        id: 1,
        title: 'Getting Started with Our UI Kit',
        description: 'Learn how to set up and use our UI components in your next project.',
        image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80',
        link: '#'
    },
    {
        id: 2,
        title: 'Building a Dashboard in 30 Minutes',
        description: 'Follow this step-by-step guide to create a professional dashboard quickly.',
        image: 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80',
        link: '#'
    },
    {
        id: 3,
        title: 'Free Resources for Designers',
        description: 'Download our collection of free design resources and templates.',
        image: 'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?auto=format&fit=crop&w=800&q=80',
        link: '#'
    }
];
</script>

<style scoped>
.container {
    max-width: 1200px;
}
</style>
