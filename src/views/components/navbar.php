<header class="bg-white shadow-md sticky top-0 z-50 flex-shrink-0">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <div class="flex-shrink-0 flex items-center">
                <a href="index.php?page=home">
                    <img class="h-14 w-auto" src="<?php echo BASE_URL; ?>/images/manaoag-seal.png" alt="Manaoag Logo">
                </a>
                <div class="ml-4">
                    <a href="index.php?page=home" class="text-lg font-bold text-gray-800 hover:text-blue-600">Municipality of Manaoag</a>
                    <p class="text-sm text-gray-500">Province of Pangasinan</p>
                </div>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-6">
                <div class="relative group">
                    <button class="flex items-center text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        <span>Barangay Officials</span>
                        <i class="fa fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="absolute left-0 top-full w-48 bg-white rounded-md shadow-lg py-1 z-20 hidden group-hover:block">
                        <a href="index.php?page=mayor" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mayor</a>
                        <a href="index.php?page=vice-mayor" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Vice Mayor</a>
                        <a href="index.php?page=councilors" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Councilors</a>
                    </div>
                </div>

                <a href="index.php?page=spots" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Things to Do</a>
                <a href="index.php?page=guides" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Tour Guides</a>
                <a href="index.php?page=faqs" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">FAQs</a>
                <a href="index.php?page=useful_links" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Useful Links</a>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                <form action="index.php" method="GET" class="hidden sm:flex">
                    <input type="hidden" name="page" value="search">
                    <input type="text" name="q" placeholder="Search..." class="border border-gray-300 rounded-l-md py-2 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-r-md text-sm font-medium hover:bg-blue-700">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="relative group">
                        <button class="flex items-center text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            <span>Welcome, <?php echo htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'Guest')[0]); ?>!</span>
                            <i class="fa fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute right-0 top-full w-48 bg-white rounded-md shadow-lg py-1 z-20 hidden group-hover:block">
                            <a href="index.php?page=profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                            <a href="index.php?page=user_logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="hidden md:flex items-center space-x-2">
                        <a href="index.php?page=user_login" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="index.php?page=user_register" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">Register</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="flex md:hidden">
                <button id="mobile-menu-btn" class="text-gray-600 hover:text-blue-600 focus:outline-none">
                    <i class="fa fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-200 mt-2">
            <div class="flex flex-col space-y-2 mt-2">
                <form action="index.php" method="GET" class="flex mb-2">
                    <input type="hidden" name="page" value="search">
                    <input type="text" name="q" placeholder="Search..." class="flex-grow border border-gray-300 rounded-l-md py-2 px-3 text-sm">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md text-sm">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <span class="text-xs font-bold text-gray-400 uppercase mt-2">Officials</span>
                <a href="index.php?page=mayor" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Mayor</a>
                <a href="index.php?page=vice-mayor" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Vice Mayor</a>
                <a href="index.php?page=councilors" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Councilors</a>

                <span class="text-xs font-bold text-gray-400 uppercase mt-2">Explore</span>
                <a href="index.php?page=spots" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Things to Do</a>
                <a href="index.php?page=products" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Products</a>
                <a href="index.php?page=events" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Events</a>
                <a href="index.php?page=guides" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Tour Guides</a>
                <a href="index.php?page=faqs" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">FAQs</a>
                <a href="index.php?page=useful_links" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Useful Links</a>

                <div class="border-t border-gray-200 pt-2 mt-2">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="index.php?page=profile" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">My Profile</a>
                        <a href="index.php?page=user_logout" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-gray-50">Log Out</a>
                    <?php else: ?>
                        <a href="index.php?page=user_login" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Login</a>
                        <a href="index.php?page=user_register" class="block px-3 py-2 rounded-md text-base font-medium text-green-600 hover:bg-gray-50">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>
<main class="flex-grow">