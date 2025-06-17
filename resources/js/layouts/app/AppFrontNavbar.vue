<template>
    <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow">
        <!-- Utility Bar -->
        <div class="bg-gray-800 text-white text-sm py-2">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <div class="font-medium tracking-wide">INSTANT DOWNLOAD ON ALL PURCHASES</div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <span class="mr-2">Language:</span>
                        <select class="bg-gray-700 text-white text-xs rounded px-1 py-0.5 border border-gray-600">
                            <option>English</option>
                            <option>Spanish</option>
                            <option>French</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <span class="mr-2">Currency:</span>
                        <select class="bg-gray-700 text-white text-xs rounded px-1 py-0.5 border border-gray-600">
                            <option>USD ($)</option>
                            <option>EUR (€)</option>
                            <option>GBP (£)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo -->
            <div class="text-2xl font-bold text-blue-600">DigitalMarket</div>
            
            <!-- Primary Navigation -->
            <ul class="hidden md:flex space-x-6">
                <li><a href="/" class="hover:text-blue-600 font-medium">Home</a></li>
                <li><a href="#templates" class="hover:text-blue-600 font-medium">Templates</a></li>
                <li><a href="#plugins" class="hover:text-blue-600 font-medium">Plugins</a></li>
                <li><a href="#ui-kits" class="hover:text-blue-600 font-medium">UI Kits</a></li>
                <li><a href="#tutorials" class="hover:text-blue-600 font-medium">Tutorials</a></li>
                <li><a href="/about" class="hover:text-blue-600 font-medium">About</a></li>
                <li><a href="/contact" class="hover:text-blue-600 font-medium">Contact</a></li>
            </ul>
            
            <!-- Icons -->
            <div class="flex items-center space-x-4">
                <button class="text-gray-600 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <a href="/login" class="text-gray-600 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
                <button class="text-gray-600 hover:text-blue-600 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                </button>
                
                <!-- Mobile menu button -->
                <button class="md:hidden text-gray-600 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>
    </header>
    <!-- Spacer to account for fixed header -->
    <div class="h-32"></div>
</template>

<script setup lang="ts">
// ...
</script>
