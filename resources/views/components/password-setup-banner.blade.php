@if (Auth::check() && Auth::user()->shouldShowPasswordReminder())
    <div id="password-banner"
        class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border border-blue-500/30 dark:border-blue-600/30 rounded-xl shadow-lg dark:shadow-xl mb-6 overflow-hidden">
        
        <!-- Animated background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-pulse"></div>
        </div>
        
        <!-- Security shield pattern -->
        <div class="absolute top-0 right-0 w-32 h-32 opacity-5">
            <svg class="w-full h-full text-white" fill="currentColor" viewBox="0 0 100 100">
                <path d="M50 10 L85 25 L85 65 Q85 80 50 90 Q15 80 15 65 L15 25 Z" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-col md:flex-row gap-4">
                <!-- Icon and Message -->
                <div class="flex-1 flex items-center min-w-0">
                    <div class="flex-shrink-0">
                        <div class="flex p-3 rounded-xl bg-white/20 dark:bg-white/10 backdrop-blur-sm border border-white/30 dark:border-white/20 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="ml-4 flex-1 min-w-0">
                        <div class="flex items-center space-x-3 mb-1">
                            <h3 class="text-sm font-semibold text-white dark:text-white">
                                Secure Your Account
                            </h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-400/20 text-yellow-100 border border-yellow-300/30">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Action Required
                            </span>
                        </div>
                        
                        <p class="text-white/90 dark:text-white/90">
                            <span class="block sm:hidden text-sm">
                                You signed up with Google. Add a password for enhanced security and backup access.
                            </span>
                            <span class="hidden sm:block text-sm">
                                You're currently using Google Sign-In. Setting up a password provides additional security 
                                and ensures you can access your account even if Google services are unavailable.
                            </span>
                        </p>
                        
                        <!-- Benefits list for larger screens -->
                        <div class="hidden lg:flex items-center space-x-6 mt-2 text-xs text-white/80">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Backup login method
                            </span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Enhanced security
                            </span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Universal access
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    <!-- Set Password Button -->
                    <a href="{{ route('password.setup.show') }}"
                        class="group inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-blue-700 dark:text-blue-800 bg-white dark:bg-gray-100 hover:bg-blue-50 dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-offset-blue-600 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Set Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Progress indicator -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/20 dark:bg-white/10">
            <div id="banner-progress" class="h-full bg-gradient-to-r from-yellow-400 to-yellow-300 transition-all duration-1000 ease-out" style="width: 0%"></div>
        </div>
    </div>

    <script>
        // Enhanced banner dismiss functionality
        function dismissBanner(permanent = false) {
            const banner = document.getElementById('password-banner');
            if (!banner) return;

            // Add sophisticated exit animation
            banner.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            banner.style.opacity = '0';
            banner.style.transform = 'translateY(-20px) scale(0.95)';
            banner.style.filter = 'blur(1px)';
        }

        function revertBannerAnimation(banner) {
            banner.style.opacity = '1';
            banner.style.transform = 'translateY(0) scale(1)';
            banner.style.filter = 'none';
        }

        function showToast(message, type = 'info') {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full opacity-0 ${
                type === 'error' ? 'bg-red-500 text-white' : 'bg-blue-500 text-white'
            }`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        ${type === 'error' ? 
                            '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />' :
                            '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />'
                        }
                    </svg>
                    <span class="text-sm font-medium">${message}</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
                toast.style.opacity = '1';
            }, 100);
            
            // Remove toast after 4 seconds
            setTimeout(() => {
                toast.style.transform = 'translateX(full)';
                toast.style.opacity = '0';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }, 4000);
        }

        // Progressive enhancement: Add progress animation
        document.addEventListener('DOMContentLoaded', function() {
            const progressBar = document.getElementById('banner-progress');
            if (progressBar) {
                let progress = 0;
                const increment = 0.5;
                const interval = setInterval(() => {
                    progress += increment;
                    progressBar.style.width = `${progress}%`;
                    
                    if (progress >= 100) {
                        clearInterval(interval);
                        // Add subtle glow effect when complete
                        progressBar.style.boxShadow = '0 0 10px rgba(255, 255, 0, 0.5)';
                    }
                }, 200);
            }
        });

        // Keyboard accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const banner = document.getElementById('password-banner');
                if (banner) {
                    dismissBanner();
                }
            }
        });

        // Auto-fade effect after extended viewing
        let bannerViewTime = 0;
        const fadeInterval = setInterval(() => {
            bannerViewTime += 1000;
            const banner = document.getElementById('password-banner');
            
            if (!banner) {
                clearInterval(fadeInterval);
                return;
            }
            
            // Start subtle fade after 45 seconds
            if (bannerViewTime > 45000) {
                banner.style.opacity = '0.85';
            }
            
            // More noticeable fade after 60 seconds
            if (bannerViewTime > 60000) {
                banner.style.opacity = '0.7';
            }
        }, 1000);
    </script>

    <style>
        /* Enhanced animations and transitions */
        @keyframes gentlePulse {
            0%, 100% { opacity: 0.1; }
            50% { opacity: 0.2; }
        }
        
        #password-banner .animate-pulse {
            animation: gentlePulse 3s ease-in-out infinite;
        }
        
        /* Backdrop blur support */
        @supports (backdrop-filter: blur(10px)) {
            #password-banner .backdrop-blur-sm {
                backdrop-filter: blur(10px);
            }
        }
        
        /* Focus visible enhancement */
        #password-banner button:focus-visible,
        #password-banner a:focus-visible {
            outline: 2px solid white;
            outline-offset: 2px;
        }
        
        /* Smooth hover transitions */
        #password-banner .group:hover svg {
            transition: transform 0.2s ease-in-out;
        }
    </style>
@endif