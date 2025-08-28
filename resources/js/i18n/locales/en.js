export default {

    dashboard: 'Dashboard',
    orders: 'Orders',
    stockCheckRequests: 'Stock Check Reqs',
    quoteRequests: 'Quote Reqs',
    reservations: 'Reservations',
    customers: 'Customers',
    bulletin: 'Bulletin',
    categories: 'Categories',
    category: 'Category',
    content_system: 'Content System',
    products: 'Products',
    roles: 'Roles',
    users: 'Users',
    // Added for layouts and dashboards
    restaurants: 'Restaurants',
    tenants: 'Restaurants',
    settings: 'Settings',
    logout: 'Logout',
    profile: 'Profile',
    role: 'Role',
    about: 'About',
    // normalized keys for layouts
    contact: 'Contact',
    reservation: 'Reservation',
    // alias kept if used elsewhere
    Contact: 'Contact',
    privacy: 'Privacy',
    terms: 'Terms',
    aboutText: 'We provide comprehensive restaurant management solutions to help businesses grow and succeed in the modern digital age.',
    passwordChange: 'Password Change',
    restaurantSettings: 'Restaurant Settings',
    notifications: 'Notifications',
    subscribers: 'Subscribers',
    emailSetting: 'Email Settings',
    contactReqs: 'Contact Requests',
    stockCheck: 'Stock Check',
    logoutSuccess: 'Logged Out Successfully',
    youHaveBeenLoggedOut: 'You have been logged out of your account.',
    changeLanguage: 'Change Language',
    businessEmail: 'Business Email',
    // Footer & Cart additions for tenant frontend layout
    cart: {
        title: 'Your Cart',
        total: 'Total:',
        checkout: 'Checkout',
        empty: 'Your cart is empty.'
    },

    //Main Home Page
    welcome: 'Welcome to Restro Manage',
    subtitle: 'Your Ultimate Restaurant Management Solution',
    getStarted: 'GET STARTED',
    learnMore: 'LEARN MORE',
    whyChoose: 'Why Choose Restro Manage?',


    // Home Page

    about_us: 'About US',
    // Tenant About Page
    about: {
        title: 'About Us',
        subtitle: 'We are dedicated to revolutionizing the restaurant industry through innovative digital solutions.',
        description: 'Our platform provides comprehensive restaurant management tools that help businesses streamline their operations, increase efficiency, and deliver exceptional customer experiences. From order management to analytics, we offer everything you need to succeed in today\'s competitive market.',
        stat1: { value: '1000+', label: 'Restaurants Served' },
        stat2: { value: '98%', label: 'Customer Satisfaction' },
        whyChoose: 'Why Choose Us',
        features: {
            innovation: { title: 'Innovation', desc: 'Cutting-edge technology to keep you ahead of the competition' },
            support: { title: 'Support', desc: '24/7 dedicated support to help you succeed' },
            reliability: { title: 'Reliability', desc: 'Secure and stable platform you can count on' }
        }
    },

    // Navigation\
    nav: {
        home: 'Home',
        features: 'Features',
        pricing: 'Pricing',
        contact: 'Contact',
        login: 'Login',
        register: 'Register',
        users: 'Users',
        roles_permissions: 'Roles & Permissions',
        restaurants: 'Restaurants',
        logout: 'Logout',
        profile: 'Profile',
        foodOrdering: 'Food Ordering',
        restaurantServices: 'Restaurant Services',
        pricing: 'Pricing',
        getAccess: 'Get Access Now'
    },
    topbar: {
        email: 'Email',
        phone: import.meta.env.VITE_CONTACT_PHONE || '+1 234 567 8900',
        language: 'Language'
    },
    footer: {
        aboutUs: 'About Us',
        contactUs: 'Contact',
        privacy: 'Privacy Policy',
        terms: 'Terms of Service',
        location: 'Our location',
        designedBy: 'Designed & Developed by NetOPZ',
        aboutText: 'We provide comprehensive restaurant management solutions to help businesses grow and succeed in the modern digital age.',
        quickLinks: {
            quickLinks: 'Quick Links',
            title: 'Quick Links',
            features: 'Features',
            pricing: 'Pricing',
        },
        contactInfo: 'Contact Info',
        address: import.meta.env.VITE_CONTACT_ADDRESS || '123 Business Street, NY 10001',
        phone: import.meta.env.VITE_CONTACT_PHONE || '+1 234 567 8900',
        hours: import.meta.env.VITE_CONTACT_HOURS || 'Mon - Fri: 9:00 AM - 6:00 PM',
        copyright: '© 2024 Restaurant Management System. All rights reserved.',
        about: {
            title: 'About Us',
            description: 'We provide comprehensive restaurant management solutions to help businesses grow and succeed in the modern digital age.'
        },
        contact: {
            title: 'Contact Info',
            address: import.meta.env.VITE_CONTACT_ADDRESS || '123 Business Street, NY 10001',
            phone: import.meta.env.VITE_CONTACT_PHONE || '+1 234 567 8900',
            hours: import.meta.env.VITE_CONTACT_HOURS || 'Mon - Fri: 9:00 AM - 6:00 PM'
        }
    },
    // Home
    // Privacy Page
    privacy: {
        title: 'Privacy Policy',
        lastUpdated: 'Last updated: March 2024',
        section1Title: '1. Information We Collect',
        section1Intro: 'We collect information that you provide directly to us, including:',
        section1Item1: 'Name and contact information',
        section1Item2: 'Restaurant details and business information',
        section1Item3: 'Payment information',
        section1Item4: 'Usage data and preferences',
        section2Title: '2. How We Use Your Information',
        section2Intro: 'We use the information we collect to:',
        section2Item1: 'Provide and maintain our services',
        section2Item2: 'Process your transactions',
        section2Item3: 'Send you important updates and notifications',
        section2Item4: 'Improve our services and develop new features',
        section2Item5: 'Protect against fraud and unauthorized access',
        section3Title: '3. Information Sharing',
        section3Intro: 'We do not sell your personal information. We may share your information with:',
        section3Item1: 'Service providers who assist in our operations',
        section3Item2: 'Professional advisors and consultants',
        section3Item3: 'Law enforcement when required by law',
        section4Title: '4. Data Security',
        section4Intro: 'We implement appropriate technical and organizational measures to protect your personal information, including:',
        section4Item1: 'Encryption of sensitive data',
        section4Item2: 'Regular security assessments',
        section4Item3: 'Access controls and authentication',
        section4Item4: 'Secure data storage and transmission',
        section5Title: '5. Your Rights',
        section5Intro: 'You have the right to:',
        section5Item1: 'Access your personal information',
        section5Item2: 'Correct inaccurate information',
        section5Item3: 'Request deletion of your information',
        section5Item4: 'Opt-out of marketing communications',
        section6Title: '6. Contact Us',
        section6Intro: 'If you have any questions about this Privacy Policy, please contact us at:',
        email: 'Email',
        phone: 'Phone',
        address: 'Address'
    },
    home: {
        // Hero Section
        hero: {
            title: 'Build Your Restaurant Website in Minutes',
            subtitle: 'Create a beautiful website for your restaurant. No coding needed. Get online orders, table bookings, and manage your business all in one place.',
        getStarted: 'GET STARTED',
            learnMore: 'LEARN MORE'
        },

        // About Section
        about: {
            title: 'All-in-One Restaurant Platform',
            subtitle: 'We help restaurants grow their business online. Build a website, take orders, manage bookings, and connect with customers - all from one simple platform.',
            heading: 'Everything Your Restaurant Needs',
            description1: 'We understand that running a restaurant is hard work. That\'s why we built a platform that makes it easy to go online. You don\'t need to be a tech expert or spend thousands on website development. Our simple tools let you create a professional website in minutes.',
            description2: 'Whether you want to take online orders, let customers book tables, or just show your menu to the world, we\'ve got you covered. You can use our free subdomain or connect your own custom domain. No hosting fees, no complicated setup - just focus on your food while we handle the tech.',
            readMore: 'Read More'
        },

        // Features Section
        whyChoose: 'Why Choose Our Platform?',
        features: {
            quickSetup: {
                title: 'Quick Setup',
                description: 'Get your restaurant website online in just 5 minutes. No coding skills needed. Just fill in your details and you\'re ready to go.'
            },
            mobileFriendly: {
                title: 'Mobile Friendly',
                description: 'Your website works perfectly on phones, tablets, and computers. Customers can order food and book tables from any device.'
            },
            easyManagement: {
                title: 'Easy Management',
                description: 'Update your menu, manage orders, and track your business from one simple dashboard. Everything you need in one place.'
            }
        },

        // Services Section
        services: {
            title: 'What We Offer',
            subtitle: 'Everything you need to run your restaurant online',
            websiteBuilder: {
                title: 'Website Builder',
                description: 'Create a beautiful website for your restaurant in minutes. Use our free subdomain or connect your own custom domain.'
            },
            onlineOrdering: {
                title: 'Online Ordering',
                description: 'Let customers order food directly from your website. Accept payments online and manage orders easily.'
            },
            tableReservations: {
                title: 'Table Reservations',
                description: 'Customers can book tables online. Manage your restaurant\'s availability and reservations from your dashboard.'
            },
            inventoryManagement: {
                title: 'Inventory Management',
                description: 'Track your stock levels and place bulk orders from manufacturers. Never run out of ingredients again.'
            }
        },

        // Platform Benefits Section
        platformBenefits: {
            title: 'One Platform, Everything You Need',
            subtitle: 'Stop using multiple apps and websites. Manage your entire restaurant business from one place.',
            noHostingFees: {
                title: 'No Hosting Fees',
                description: 'Use our free subdomain or connect your own domain. No monthly hosting costs.'
            },
            mobileReady: {
                title: 'Mobile Ready',
                description: 'Your website works perfectly on all devices - phones, tablets, and computers.'
            },
            onlinePayments: {
                title: 'Online Payments',
                description: 'Accept credit cards, digital wallets, and cash payments from your customers.'
            },
            businessReports: {
                title: 'Business Reports',
                description: 'Track your sales, orders, and customer data to grow your business smarter.'
            }
        },

        // How It Works Section
        howItWorks: {
            title: 'How to Create Your Restaurant Website',
            subtitle: 'Get your restaurant online in just 3 simple steps',
            step1: {
                title: 'Enter Your Restaurant Name',
                description: 'If your restaurant is already on Google, just enter the name and we\'ll automatically import all your information - address, phone, hours, and more.'
            },
            step2: {
                title: 'Customize Your Website',
                description: 'Add your menu, photos, and customize the design to match your restaurant\'s style. No coding required - just drag and drop.'
            },
            step3: {
                title: 'Start Taking Orders',
                description: 'Your website is live! Start accepting online orders, table bookings, and grow your business immediately.'
            },
            cta: 'Start Building Your Website'
        },

        // Google Integration Section
        googleIntegration: {
            title: 'Already on Google? We\'ll Import Everything',
            subtitle: 'If your restaurant is already listed on Google, we can automatically import all your information. No need to type everything again!',
            features: [
                'Restaurant name and description',
                'Address and contact information',
                'Opening hours and business days',
                'Photos and customer reviews',
                'Category and cuisine type'
            ],
            cta: 'Try Google Import'
        },

        // Features Comparison Section
        comparison: {
            title: 'Everything You Need to Succeed Online',
            subtitle: 'Compare our platform with traditional website development',
            traditional: {
                title: 'Traditional Website Development',
                features: [
                    'Costs $3,000 - $10,000+',
                    'Takes 2-6 months to build',
                    'Monthly hosting fees ($20-100)',
                    'Need to hire developers',
                    'Difficult to update content'
                ]
            },
            ourPlatform: {
                title: 'Our Restaurant Platform',
                features: [
                    'Start for free, no setup costs',
                    'Ready in 5 minutes',
                    'No hosting fees',
                    'No technical skills needed',
                    'Easy to update anytime'
                ]
            }
        },

        // Customer Success Section
        customerSuccess: {
            title: 'Restaurants Love Our Platform',
            subtitle: 'See how other restaurants are growing their business with us',
            testimonials: [
                {
                    name: 'Pizza Palace',
                    text: 'We increased our online orders by 300% in just 2 months. The website setup was so easy!'
                },
                {
                    name: 'Café Delight',
                    text: 'Table reservations are now automated. No more phone calls during busy hours!'
                },
                {
                    name: 'Burger House',
                    text: 'The inventory management feature helps us never run out of ingredients. Game changer!'
                }
            ]
        },

        // FAQ Section
        faq: {
            title: 'Frequently Asked Questions',
            subtitle: 'Everything you need to know about our platform',
            questions: [
                {
                    question: 'How much does it cost to create a restaurant website?',
                    answer: 'You can start for free! We offer a free plan with basic features. Premium plans start at just $29/month and include advanced features like online ordering, table reservations, and inventory management.'
                },
                {
                    question: 'Can I use my own domain name?',
                    answer: 'Yes! You can use our free subdomain (yourrestaurant.ourplatform.com) or connect your own custom domain (yourrestaurant.com). No additional hosting fees required.'
                },
                {
                    question: 'How long does it take to set up?',
                    answer: 'If your restaurant is on Google, we can import all your information automatically and you\'ll have a basic website in just 5 minutes. You can then customize it further at your own pace.'
                },
                {
                    question: 'Do I need technical skills?',
                    answer: 'Not at all! Our platform is designed to be user-friendly. You can create and manage your website using simple drag-and-drop tools. No coding knowledge required.'
                }
            ]
        },

        // Recent Restaurants Section
        recentRestaurants: {
            title: 'Recent Registered Restaurants',
            subtitle: 'Discover amazing restaurants that have recently joined our platform',
            viewRestaurant: 'View Restaurant',
            viewAllRestaurants: 'View All Restaurants'
        },

        // Reservation Section
        reservation: {
            title: 'Make a Reservation',
            subtitle: 'Book your table online and enjoy a great dining experience',
            contact: {
                call: 'Call us: +1 234 567 8900',
                // hours: 'Open: Mon-Sun 11:00 AM - 10:00 PM'
            },
            form: {
                name: 'Your Name',
                email: 'Email Address',
                guests: 'Number of Guests',
                bookNow: 'Book Now'
            }
        },

        // Call to Action Section
        cta: {
            title: 'Ready to grow your restaurant online?',
            subtitle: 'Join thousands of restaurants that are already using our platform to increase their sales and reach more customers.',
            startFreeTrial: 'START FREE TRIAL',
            noCreditCard: 'No Credit Card Required',
            getStarted: 'GET STARTED'
        }
    },

    // Tenant Reservation Page
    reservation: {
        title: 'Reservation',
        subtitle: 'We provide free, secure and instantly confirmed online reservation.',
        formTitle: 'Book a table online. Details will reach in your email.',
        fullName: 'Full Name*',
        fullNameTip: 'Enter your full name',
        phoneNumber: 'Phone Number*',
        phoneNumberTip: 'Enter your phone number',
        email: 'Email*',
        emailTip: 'Enter your email address',
        date: 'Date*',
        dateTip: 'Select reservation date',
        time: 'Time*',
        timeTip: 'Select reservation time',
        guests: 'Guests*',
        guestsTip: 'Number of guests',
        message: 'Message',
        messageTip: 'Add any special requests or notes',
        processing: 'Processing...',
        submit: 'MAKE RESERVATION'
    },

    // Food Ordering Page
    foodOrdering:
    {
        // Hero Section
        hero: {
            title: 'Complete Restaurant Management System',
            subtitle: 'Everything you need to run your restaurant online. Take orders, manage tables, organize your menu, and grow your business - all from one simple platform.',
            startFreeTrial: 'Start Free Trial',
            learnMore: 'Learn More'
        },

        // Features Overview
        featuresOverview: {
            title: 'Everything Your Restaurant Needs',
            subtitle: 'Manage your entire restaurant business from one simple dashboard',
            onlineOrdering: {
                title: 'Online Ordering',
                description: 'Let customers order food directly from your website. Accept payments online and manage orders easily.'
            },
            tableReservations: {
                title: 'Table Reservations',
                description: 'Customers can book tables online. Manage your restaurant\'s availability and reservations from your dashboard.'
            },
            menuManagement: {
                title: 'Menu Management',
                description: 'Organize your menu with categories and items. Control what\'s visible and sort everything easily.'
            },
            userManagement: {
                title: 'User Management',
                description: 'Manage your staff with different roles and permissions. Control who can do what in your system.'
            }
        },

        // Online Ordering System
        onlineOrdering: {
            title: 'Online Food Ordering System',
            subtitle: 'Turn your restaurant into an online business. Let customers order food from your website and grow your sales.',
                    feature1: 'Customers can browse your menu and place orders online',
        feature2: 'Accept credit cards, digital wallets, and cash payments',
        feature3: 'Get instant notifications when new orders come in',
        feature4: 'Track order status and manage delivery times',
        feature5: 'View order history and customer details'
        },

        // Table Reservation System
        tableReservation: {
            title: 'Table Reservation System',
            subtitle: 'Stop taking phone calls for reservations. Let customers book tables online and manage your restaurant\'s availability easily.',
                    feature1: 'Customers can book tables for specific dates and times',
        feature2: 'Set your restaurant\'s opening hours and available tables',
        feature3: 'Get instant notifications for new reservations',
        feature4: 'Manage table availability in real-time',
        feature5: 'Send confirmation emails to customers automatically'
        },

        // Menu Management System
        menuManagement: {
            title: 'Smart Menu Management',
            subtitle: 'Organize your menu with categories and items. Control what customers see on your website.',
            categoryManagement: {
                title: 'Category Management',
                feature1: 'Create menu categories (Appetizers, Main Course, Desserts, etc.)',
                feature2: 'Sort categories in any order you want',
                feature3: 'Activate or deactivate entire categories',
                feature4: 'When you deactivate a category, all items in it become hidden'
            },
            itemManagement: {
                title: 'Item Management',
                feature1: 'Add food items under each category',
                feature2: 'Set prices, descriptions, and photos for each item',
                feature3: 'Sort items within each category',
                feature4: 'Mark items as available or unavailable',
                feature5: 'Update menu anytime without technical help'
            },
            smartControl: {
                title: 'Smart Control',
                description: 'When you deactivate a category, all items in that category automatically become invisible to customers on your website.'
            }
        },

        // User and Role Management
        userManagement: {
            title: 'User and Role Management',
            subtitle: 'Control who can access your system and what they can do',
            roles: {
                admin: {
                    title: 'Admin Role',
                    description: 'Full access to everything - manage menu, orders, reservations, users, and system settings.'
                },
                manager: {
                    title: 'Manager Role',
                    description: 'Can manage orders, reservations, and menu items. Cannot change system settings or user roles.'
                },
                staff: {
                    title: 'Staff Role',
                    description: 'Can view orders and reservations. Limited access for basic restaurant operations.'
                }
            },
            control: {
                title: 'What You Can Control:',
                feature1: 'Create different user roles with specific permissions',
                feature2: 'Add or remove staff members easily',
                feature3: 'Control who can see orders, manage menu, or change settings',
                feature4: 'Track who made what changes in your system'

            },
            security: {
                title: 'Security Features:',
                feature1: 'Secure login for all users',
                feature2: 'Password protection for sensitive areas',
                feature3: 'Activity logs to track all changes',
                feature4: 'Easy to remove access when staff leaves'
            }
        },

        // How It Works
        howItWorks: {
            title: 'How It Works',
            subtitle: 'Get your restaurant online in just 3 simple steps',
            step1: {
                title: 'Set Up Your Menu',
                description: 'Create categories and add your food items. Upload photos and set prices. Organize everything the way you want.'
            },
            step2: {
                title: 'Configure Settings',
                description: 'Set your opening hours, table availability, and payment options. Add your staff members with appropriate roles.'
            },
            step3: {
                title: 'Start Taking Orders',
                description: 'Your restaurant is now online! Start accepting food orders and table reservations from customers immediately.'
            }
        },

        // Call to Action
        cta: {
            title: 'Ready to Transform Your Restaurant?',
            subtitle: 'Join thousands of restaurants that are already using our platform to increase their sales and reach more customers.',
            startFreeTrial: 'Start Free Trial',
                    contactSales: 'Contact Sales'
        }

    },

    // Restaurant Services Page
    restaurantServices: {
        hero: {
            title: 'Everything Your Restaurant Needs to Succeed Online',
            subtitle: 'Get a complete restaurant management system that includes your own website, online ordering, table reservations, menu management, and much more. Everything you need to grow your restaurant business.',
            startFreeTrial: 'Start Free Trial',
            viewAllServices: 'View All Services'
        },
        mainServices: {
            title: 'Complete Restaurant Management Platform',
            subtitle: 'One platform, everything you need to run your restaurant online and grow your business',
            websiteBuilder: {
                title: 'Your Own Restaurant Website',
                subtitle: 'Get a professional website for your restaurant with your own domain name or use our free subdomain.',
                feature1: 'Professional design that matches your restaurant\'s style',
                feature2: 'Mobile-friendly - works perfectly on phones and tablets',
                feature3: 'No hosting fees - we handle everything',
                feature4: 'Easy to update menu, photos, and information',
                feature5: 'SEO optimized to help customers find you online'
            },
            onlineOrdering: {
                title: 'Online Food Ordering System',
                subtitle: 'Let customers order food directly from your website. Accept payments online and manage orders easily.',
                feature1: 'Customers can browse your menu and place orders 24/7',
                feature2: 'Accept credit cards, digital wallets, and cash payments',
                feature3: 'Get instant notifications when new orders come in',
                feature4: 'Track order status and manage delivery times',
                feature5: 'View order history and customer details'
            },
            tableReservation: {
                title: 'Table Reservation System',
                subtitle: 'Stop taking phone calls for reservations. Let customers book tables online and manage your availability.',
                feature1: 'Customers can book tables for specific dates and times',
                feature2: 'Set your restaurant\'s opening hours and available tables',
                feature3: 'Get instant notifications for new reservations',
                feature4: 'Manage table availability in real-time',
                feature5: 'Send confirmation emails to customers automatically'
            },
            menuManagement: {
                title: 'Smart Menu Management',
                subtitle: 'Organize your menu with categories and items. Control what customers see on your website.',
                feature1: 'Create menu categories (Appetizers, Main Course, etc.)',
                feature2: 'Add food items with prices, descriptions, and photos',
                feature3: 'Sort categories and items in any order you want',
                feature4: 'Activate or deactivate categories and items',
                feature5: 'Update menu anytime without technical help'
            }
        },
        additionalServices: {
            title: 'More Services to Help Your Business',
            subtitle: 'Additional tools and features to make running your restaurant easier',
            userManagement: {
                title: 'User & Role Management',
                subtitle: 'Control who can access your system and what they can do.',
                feature1: 'Create different user roles (Admin, Manager, Staff)',
                feature2: 'Set specific permissions for each role',
                feature3: 'Add or remove staff members easily',
                feature4: 'Track who made what changes'
            },
            inventoryManagement: {
                title: 'Inventory Management',
                subtitle: 'Keep track of your ingredients and supplies.',
                feature1: 'Track ingredient quantities and costs',
                feature2: 'Get alerts when items are running low',
                feature3: 'Generate purchase orders automatically',
                feature4: 'Monitor food costs and waste'
            },
            analytics: {
                title: 'Analytics & Reports',
                subtitle: 'Get insights into your business performance.',
                feature1: 'Sales reports and revenue tracking',
                feature2: 'Popular menu items analysis',
                feature3: 'Customer order history',
                feature4: 'Business performance insights'
            },
            paymentProcessing: {
                title: 'Payment Processing',
                subtitle: 'Accept all types of payments from your customers.',
                feature1: 'Credit and debit card payments',
                feature2: 'Digital wallets (PayPal, Apple Pay, etc.)',
                feature3: 'Cash on delivery option',
                feature4: 'Secure payment processing'
            },
            customerManagement: {
                title: 'Customer Management',
                subtitle: 'Build relationships with your customers.',
                feature1: 'Customer database and profiles',
                feature2: 'Order history for each customer',
                feature3: 'Loyalty program features',
                feature4: 'Customer feedback and reviews'
            },
            mobileApp: {
                title: 'Mobile App',
                subtitle: 'Manage your restaurant from anywhere.',
                feature1: 'Mobile app for restaurant owners',
                feature2: 'View and manage orders on the go',
                feature3: 'Update menu and settings remotely',
                feature4: 'Real-time notifications'
            }
        },
        pricing: {
            title: 'Simple, Transparent Pricing',
            subtitle: 'No hidden fees, no complicated pricing. Choose the plan that works for your restaurant.',
            feature1: 'Start for free with basic features',
            feature2: 'Upgrade anytime as your business grows',
            feature3: 'No setup fees or long-term contracts',
            feature4: 'Cancel anytime with no penalties',
            viewPricingPlans: 'View Pricing Plans'
        },
        cta: {
            title: 'Ready to Transform Your Restaurant?',
            subtitle: 'Join thousands of restaurants that are already using our platform to increase their sales and reach more customers.',
            startFreeTrial: 'Start Free Trial',
            contactSales: 'Contact Sales'
        }
    },

    // Auth
    auth: {
        login: {
            title: 'Login to your account',
            email: 'Email Address',
            password: 'Password',
            remember: 'Remember me',
            submit: 'Sign In',
            forgot: 'Forgot Password?',
            noAccount: 'Don\'t have an account?',
            register: 'Register now'
        },
        register: {
            title: 'Register your restaurant',
            restaurantName: 'Restaurant Name',
            domain: 'Domain Name',
            email: 'Email Address',
            phone: 'Phone Number',
            password: 'Password',
            confirmPassword: 'Confirm Password',
            address: 'Address',
            street: 'Street',
            postalCode: 'Postal Code',
            city: 'City',
            state: 'State',
            country: 'Country',
            county: 'County',
            submit: 'Register',
            haveAccount: 'Already have an account?',
            login: 'Login here'
        }
    },

    // Dashboard
    main_dashboard: {
        dashboard: 'Dashboard',
        stats: {
            totalTenants: 'Total Restaurants',
            activeTenants: 'Active Restaurants',
            pendingTenants: 'Pending Approvals',
            suspendedTenants: 'Suspended Restaurants',
            totalUsers: 'Total Users',
            totalRoles: 'Total Roles',
            totalPermissions: 'Total Permissions',
            activeUsers: 'Active Users Today'
        },
        quickActions: {
            title: 'Quick Actions',
            manageTenants: 'Manage Restaurants',
            manageUsers: 'Manage Users',
            manageRoles: 'Manage Roles',
            clearCache: 'Clear Cache'
        }
    },
    dashboard: {
        recentTenants: 'Recent Restaurants',
        systemStats: 'System Statistics'
    },
    common: {
        viewAll: 'View All'
    },

    // Tenants
    tenants: {
        list: {
            title: 'Restaurants',
            name: 'Name',
            domain: 'Domain',
            owner: 'Owner',
            status: 'Status',
            actions: 'Actions'
        },
        status: {
            active: 'Active',
            pending: 'Pending',
            suspended: 'Suspended',
            trial: 'Trial',
            inactive: 'Inactive'
        },
        filters: {
            searchPlaceholder: 'Search restaurants...',
            allStatus: 'All Status'
        },
        empty: {
            title: 'No Restaurants Found',
            filtered: 'No restaurants match your search criteria. Try adjusting your filters.',
            noData: 'There are no restaurants registered yet.'
        },
        actions: {
            view: 'View',
            edit: 'Edit',
            delete: 'Delete',
            approve: 'Approve',
            suspend: 'Suspend',
            activate: 'Activate'
        }
    },

    // Common
    common: {
        save: 'Save',
        cancel: 'Cancel',
        close: 'Close',
        delete: 'Delete',
        edit: 'Edit',
        create: 'Create',
        description: 'Description',
        usersCount: 'Users Count',
        search: 'Search',
        submit: 'Submit',
        actions: 'Actions',
        confirm: 'Confirm',
        success: 'Success',
        error: 'Error',
        loading: 'Loading...',
        noData: 'No data available',
        update: 'Update'
    },
    // Tenant contact/login helpers
    welcomeBack: 'Welcome!',
    contactSubtitle: "GOT A QUESTION? WE'LL GIVE YOU STRAIGHT ANSWER",
    getInTouch: 'Get In Touch',
    nameTip: 'Enter your full name.',
    yourName: 'Your Name',
    emailTip: 'Enter a valid email address.',
    yourEmail: 'you@email.com',
    phoneTip: 'Enter your phone number.',
    yourPhoneNumber: 'Your Phone Number',
    subject: 'Subject',
    subjectTip: 'What is your message about?',
    message: 'Message',
    messageTip: 'Type your message here.',
    yourMessage: 'Your message...',
    // Users module generic labels
    name: 'Name',
    status: 'Status',
    created: 'Created',
    createdAt: 'Created At',
    deleted: 'Deleted',
    active: 'Active',
    noRole: 'No Role',
    selectRole: 'Select Role',
    usersLeaveBlank: 'Leave blank to keep current password',
    userDetails: 'User Details',

    // Messages
    messages: {
        confirmDelete: 'Are you sure you want to delete this item?',
        deleteSuccess: 'Item deleted successfully',
        savingChanges: 'Saving changes...',
        changesSaved: 'Changes saved successfully',
        errorOccurred: 'An error occurred',
        sessionExpired: 'Your session has expired. Please login again.',
        unauthorized: 'You are not authorized to perform this action.'
    },

    // Roles
    roles_module: {
        title: 'Roles & Permissions',
        description: 'Manage system roles and their permissions',
        addNew: 'Add New Role',
        editRole: 'Edit Role',
        addRole: 'Add New Role',
        noRolesFound: 'No roles found',
        noPermissionsFound: 'No permissions found',
        more: 'more',
        columns: {
            name: 'Role Name',
            permissions: 'Permissions',
            actions: 'Actions'
        },
        form: {
            name: 'Role Name',
            permissions: 'Permissions'
        },
        messages: {
            created: 'Role created successfully',
            updated: 'Role updated successfully',
            deleted: 'Role deleted successfully',
            saveFailed: 'Failed to save role',
            deleteFailed: 'Failed to delete role',
            initFailed: 'Failed to initialize roles',
            confirmDelete: 'Confirm Delete',
            deleteWarning: 'Are you sure you want to delete this role?'
        }
    },

    // Stock Check
    stock_check: {
        title: 'Stock Check Request(s)',
        description: 'We provide free, secure and instantly confirmed online checking of stocks.',
        reservation_title: 'Check stock for a product.',
        full_name: 'Full Name*',
        full_name_tip: 'Enter your full name',
        phone_number: 'Phone Number*',
        phone_number_tip: 'Enter your phone number',
        email: 'Email*',
        email_tip: 'Enter your email address',
        select_product: 'Select Product*',
        select_product_tip: 'Select product to check stock',
        quantity: 'Quantity*',
        quantity_tip: 'Enter quantity to check',
        processing: 'Processing...',
        check_stock: 'CHECK STOCK'
    },

    // Tenant Dashboard Components
    tenant_dashboard: {
        // Bulletin
        bulletin: {
            title: 'Bulletin Board',
            discountNews: 'Discount News',
            discount: 'Discount (in %)',
            discountTooltip: 'Enter your discount percentage.',
            discountPlaceholder: 'Discount %',
            saveDiscount: 'Save Discount',
            discountUpdated: 'Discount updated successfully',
            failedToSave: 'Failed to save discount'
        },

        // Categories
        categories: {
            title: 'Manage Categories',
            deletedCategories: 'Deleted Categories',
            addCategory: 'Add Category',
            editCategory: 'Edit Category',
            search: 'Search',
            searchPlaceholder: 'Search by name or description',
            status: 'Status',
            allStatus: 'All',
            active: 'Active',
            inactive: 'Inactive',
            allCategories: 'All Categories',
            noCategoriesFound: 'No Categories Found',
            noCategoriesMessage: 'No categories match your search criteria. Try adjusting your filters.',
            showingEntries: 'Showing {from} to {to} of {total} entries',
            viewCategoryDetails: 'Category Details',
            deletedCategoriesTitle: 'Deleted Categories',
            noDeletedCategoriesFound: 'No deleted categories found.',
            categoryUpdated: 'Category Updated',
            categoryCreated: 'Category Created',
            tableHeaders: {
                name: 'Name',
                description: 'Description',
                parent: 'Parent',
                status: 'Status',
                sortOrder: 'Sort Order',
                createdAt: 'Created At',
                deletedAt: 'Deleted At',
                action: 'Action',
                actions: 'Actions'
            },
            form: {
                namePlaceholder: 'Category Name',
                descriptionPlaceholder: 'Category Description',
                imagePlaceholder: 'Image URL',
                activeLabel: 'Active'
            },
            view: {
                name: 'Name',
                description: 'Description',
                parent: 'Parent',
                status: 'Status',
                sortOrder: 'Sort Order',
                image: 'Image',
                createdAt: 'Created At',
                deletedAt: 'Deleted At',
                none: 'None'
            },
            modal: {
                cancel: 'Cancel',
                create: 'Create',
                update: 'Update',
                close: 'Close'
            },
            actions: {
                view: 'View',
                edit: 'Edit',
                delete: 'Delete',
                restore: 'Restore',
                hardDelete: 'Permanently Delete'
            },
            statusBadges: {
                active: 'Active',
                inactive: 'Inactive'
            },
            messages: {
                confirmDelete: 'Are you sure you want to delete this category?',
                confirmHardDelete: 'Are you sure you want to permanently delete this category? This action cannot be undone.',
                deleteSuccess: 'Category deleted successfully',
                restoreSuccess: 'Category restored successfully',
                hardDeleteSuccess: 'Category permanently deleted',
                updateSuccess: 'Category updated successfully',
                createSuccess: 'Category created successfully',
                saveFailed: 'Failed to save category',
                deleteFailed: 'Failed to delete category',
                hardDeleteFailed: 'Failed to permanently delete category',
                restoreFailed: 'Failed to restore category'
            },
            orderUpdated: 'Order updated',
            orderUpdateFailed: 'Failed to update order'
        },

        // CMS
        cms: {
            title: 'Content Management System',
            pages: 'Pages',
            addPage: 'Add Page',
            editPage: 'Edit Page',
            managePages: 'Manage Pages',
            deletedPages: 'Deleted Pages',
            pageTitle: 'Page Title',
            pageContent: 'Page Content',
            pageSlug: 'Page Slug',
            pageStatus: 'Page Status',
            published: 'Published',
            draft: 'Draft',
            savePage: 'Save Page',
            pageSaved: 'Page saved successfully',
            pageDeleted: 'Page deleted successfully',
            search: 'Search',
            searchPlaceholder: 'Search by title or keyword',
            menu: 'Menu',
            allMenus: 'All Menus',
            status: 'Status',
            all: 'All',
            active: 'Active',
            inactive: 'Inactive',
            keyword: 'Keyword',
            order: 'Order',
            createdAt: 'Created At',
            actions: 'Actions',
            noPagesFound: 'No Pages Found',
            noPagesMessage: 'No pages match your search criteria. Try adjusting your filters.',
            noContent: 'No content',
            noMenu: 'No Menu',
            showing: 'Showing',
            to: 'to',
            entries: 'entries',
            pageDetails: 'Page Details',
            title: 'Title',
            content: 'Content',
            deletedAt: 'Deleted At',
            action: 'Action',
            noDeletedPagesFound: 'No deleted pages found.',
            restore: 'Restore',
            cancel: 'Cancel',
            create: 'Create',
            update: 'Update',
            close: 'Close'
        },

        // Contact Requests
        contact_requests: {
            title: 'Contact Requests',
            noRequests: 'No Contact Requests',
            noRequestsMessage: 'No contact requests found.',
            search: 'Search',
            searchPlaceholder: 'Search by name, email, phone, subject, or message',
            columns: 'Columns',
            selectAll: '(Select All)',
            ok: 'OK',
            cancel: 'Cancel',
            action: 'Action',
            copyEmail: 'Copy Email',
            copyPhone: 'Copy Phone',
            viewDetails: 'View Details',
            view: 'View',
            showing: 'Showing',
            to: 'to',
            of: 'of',
            entries: 'entries',
            detailsModalTitle: 'Contact Request Details',
            close: 'Close',
            tableHeaders: {
                name: 'Name',
                email: 'Email',
                phone: 'Phone',
                subject: 'Subject',
                message: 'Message',
                date: 'Date',
                status: 'Status',
                actions: 'Actions'
            },
            status: {
                new: 'New',
                read: 'Read',
                replied: 'Replied',
                closed: 'Closed'
            },
            actions: {
                view: 'View',
                markAsRead: 'Mark as Read',
                reply: 'Reply',
                close: 'Close'
            }
        },

        // Customers
        customers: {
            title: 'Customers',
            addCustomer: 'Add Customer',
            editCustomer: 'Edit Customer',
            search: 'Search Customers',
            searchPlaceholder: 'Search by name, email, or phone',
            noCustomers: 'No Customers Found',
            noCustomersMessage: 'No customers match your search criteria.',
            status: 'Status',
            all: 'All',
            active: 'Active',
            inactive: 'Inactive',
            columns: 'Columns',
            apply: 'Apply',
            showing: 'Showing',
            to: 'to',
            of: 'of',
            entries: 'entries',
            copyEmail: 'Copy Email',
            customerDetails: 'Customer Details',
            id: 'ID',
            uniqueId: 'Unique ID',
            name: 'Name',
            email: 'Email',
            phone: 'Phone',
            deviceInfo: 'Device Info',
            address: 'Address',
            createdAt: 'Created At',
            createdBy: 'Created By',
            updatedAt: 'Updated At',
            updatedBy: 'Updated By',
            noCustomerDetails: 'No customer details available.',
            close: 'Close',
            tableHeaders: {
                name: 'Name',
                email: 'Email',
                phone: 'Phone',
                orders: 'Orders',
                totalSpent: 'Total Spent',
                lastOrder: 'Last Order',
                status: 'Status',
                actions: 'Actions'
            },
            customerForm: {
                name: 'Full Name',
                email: 'Email Address',
                phone: 'Phone Number',
                address: 'Address',
                save: 'Save Customer',
                update: 'Update Customer'
            },
            messages: {
                customerCreated: 'Customer created successfully',
                customerUpdated: 'Customer updated successfully',
                customerDeleted: 'Customer deleted successfully'
            }
        },

        // Email Settings
        email_settings: {
            title: 'Email Settings',
            smtpSettings: 'SMTP Settings',
            businessEmailSettings: 'Business Email Settings',
            smtpHost: 'SMTP Host',
            smtpPort: 'SMTP Port',
            smtpUsername: 'SMTP Username',
            smtpPassword: 'SMTP Password',
            smtpEncryption: 'Encryption',
            testEmail: 'Test Email',
            sendTestEmail: 'Send Test Email',
            saveSettings: 'Save Settings',
            settingsSaved: 'Email settings saved successfully',
            testEmailSent: 'Test email sent successfully',
            testEmailFailed: 'Failed to send test email',
            mailDriver: 'Mail Driver',
            mailDriverTooltip: 'Usually smtp. Ask your email provider if unsure.',
            mailDriverPlaceholder: 'e.g. smtp',
            mailHost: 'Mail Host',
            mailHostTooltip: 'The mail server address, e.g. smtp.yourdomain.com',
            mailHostPlaceholder: 'e.g. netopz.com',
            mailPort: 'Mail Port',
            mailPortTooltip: 'Usually 465 (SSL), 587 (TLS), or 25. Ask your provider.',
            mailPortPlaceholder: 'e.g. 465',
            mailUsername: 'Mail Username',
            mailUsernameTooltip: 'The email address or username for your mail account.',
            mailUsernamePlaceholder: 'e.g. info@netopz.com',
            mailPassword: 'Mail Password',
            mailPasswordTooltip: 'The password for your mail account. Keep it secure.',
            mailPasswordPlaceholder: 'Your mail password',
            mailEncryption: 'Mail Encryption',
            mailEncryptionTooltip: 'Usually ssl or tls. Ask your provider if unsure.',
            mailEncryptionPlaceholder: 'e.g. ssl',
            mailFromName: 'Mail From Name',
            mailFromNameTooltip: 'The name that will appear as the sender in outgoing emails.',
            mailFromNamePlaceholder: 'e.g. Your Restaurant Name',
            businessEmail: 'Business Email',
            businessEmailTooltip: 'The email address that will appear as sender/receiver.',
            businessEmailPlaceholder: 'e.g. info@netopz.com'
        },

        // Orders
        orders: {
            title: 'Orders',
            search: 'Search Orders',
            searchPlaceholder: 'Search by order number, customer name, or email',
            columns: 'Columns',
            apply: 'Apply',
            email: 'Email',
            phone: 'Phone',
            copyTrackingId: 'Copy Tracking ID',
            off: 'off',
            viewDetails: 'View Details',
            showingEntries: 'Showing {from} to {to} of {total} entries',
            orderDate: 'Order Date',
            orderDetails: 'Order Details',
            orderNumber: 'Order Number',
            trackingId: 'Tracking ID',
            customerName: 'Customer Name',
            customerEmail: 'Customer Email',
            customerPhone: 'Customer Phone',
            deliveryAddress: 'Delivery Address',
            paymentStatus: 'Payment Status',
            createdAt: 'Created At',
            changeStatus: 'Change Status',
            status: 'Status',
            orderItems: 'Order Items',
            product: 'Product',
            quantity: 'Quantity',
            unitPrice: 'Unit Price',
            total: 'Total',
            subtotal: 'Subtotal',
            discount: 'Discount',
            finalTotal: 'Final Total',
            filters: {
                status: 'Status',
                dateRange: 'Date Range',
                allStatus: 'All Status'
            },
            status: {
                pending: 'Pending',
                confirmed: 'Confirmed',
                preparing: 'Preparing',
                ready: 'Ready',
                delivered: 'Delivered',
                cancelled: 'Cancelled'
            },
            noOrders: 'No Orders Found',
            noOrdersMessage: 'No orders match your search criteria.',
            tableHeaders: {
                orderNumber: 'Order #',
                customer: 'Customer',
                items: 'Items',
                total: 'Total',
                status: 'Status',
                date: 'Date',
                actions: 'Actions'
            },
            orderDetails: {
                orderInfo: 'Order Information',
                customerInfo: 'Customer Information',
                items: 'Order Items',
                total: 'Total Amount',
                status: 'Order Status'
            },
            actions: {
                view: 'View',
                confirm: 'Confirm',
                updateStatus: 'Update Status',
                cancel: 'Cancel Order'
            }
        },

        // Products
        products: {
            title: 'Products',
            addProduct: 'Add Product',
            editProduct: 'Edit Product',
            search: 'Search Products',
            searchPlaceholder: 'Search by name, description, or category',
            deletedProducts: 'Deleted Products',
            columns: 'Columns',
            selectAll: '(Select All)',
            ok: 'OK',
            cancel: 'Cancel',
            none: 'None',
            showing: 'Showing',
            to: 'to',
            entries: 'entries',
            productDetails: 'Product Details',
            productName: 'Product Name',
            selectCategory: 'Select Category',
            addCategory: 'Add Category',
            costPrice: 'Cost Price',
            stockQuantity: 'Stock Quantity',
            minStockLevel: 'Min Stock Level',
            productDescription: 'Product Description',
            update: 'Update',
            create: 'Create',
            close: 'Close',
            noDeletedProducts: 'No deleted products found.',
            restore: 'Restore',
            categoryName: 'Category Name',
            description: 'Description',
            add: 'Add',
            productUpdated: 'Product updated',
            productCreated: 'Product created',
            error: 'Error',
            failedToSaveProduct: 'Failed to save product',
            areYouSure: 'Are you sure?',
            thisWillMoveProductToDeletedList: 'This will move the product to deleted list.',
            yesDeleteIt: 'Yes, delete it!',
            thisWillPermanentlyDeleteProduct: 'This will permanently delete the product.',
            yesDeletePermanently: 'Yes, delete permanently!',
            orderUpdated: 'Order updated',
            failedToUpdateOrder: 'Failed to update order',
            categoryAdded: 'Category added',
            failedToAddCategory: 'Failed to add category',
            filters: {
                category: 'Category',
                status: 'Status',
                priceRange: 'Price Range',
                allCategories: 'All Categories',
                allStatus: 'All Status'
            },
            status: {
                active: 'Active',
                inactive: 'Inactive',
                outOfStock: 'Out of Stock'
            },
            noProducts: 'No Products Found',
            noProductsMessage: 'No products match your search criteria.',
            tableHeaders: {
                image: 'Image',
                name: 'Name',
                category: 'Category',
                price: 'Price',
                status: 'Status',
                stock: 'Stock',
                actions: 'Actions'
            },
            productForm: {
                name: 'Product Name',
                description: 'Description',
                category: 'Category',
                price: 'Price',
                stock: 'Stock Quantity',
                image: 'Product Image',
                status: 'Status',
                save: 'Save Product',
                update: 'Update Product'
            },
            messages: {
                productCreated: 'Product created successfully',
                productUpdated: 'Product updated successfully',
                productDeleted: 'Product deleted successfully',
                imageUploaded: 'Image uploaded successfully'
            }
        },

        // Quote Requests
        quote_requests: {
            title: 'Quote Requests',
            noRequests: 'No Quote Requests',
            noRequestsMessage: 'No quote requests found.',
            tableHeaders: {
                customer: 'Customer',
                product: 'Product',
                quantity: 'Quantity',
                message: 'Message',
                date: 'Date',
                status: 'Status',
                actions: 'Actions'
            },
            status: {
                new: 'New',
                quoted: 'Quoted',
                accepted: 'Accepted',
                rejected: 'Rejected'
            },
            actions: {
                view: 'View',
                provideQuote: 'Provide Quote',
                accept: 'Accept',
                reject: 'Reject'
            }
        },

        // Reservations
        reservations: {
            title: 'Reservations List',
            search: 'Search',
            searchPlaceholder: 'Search by name, email, phone, date, or message',
            columns: 'Columns',
            selectAll: '(Select All)',
            ok: 'OK',
            cancel: 'Cancel',
            action: 'Action',
            viewDetails: 'View Details',
            showing: 'Showing',
            to: 'to',
            of: 'of',
            entries: 'entries',
            noReservations: 'No Reservations Found',
            noReservationsMessage: 'No reservations match your search criteria. Try adjusting your filters.',
            detailsTitle: 'Reservation Details',
            close: 'Close',
            name: 'Name',
            phone: 'Phone',
            guests: 'Guests',
            email: 'Email',
            date: 'Date',
            time: 'Time',
            message: 'Message',
            createdAt: 'Created At',
            failedToFetch: 'Failed to fetch reservations.'
        },

        // Stock Check Requests
        stock_check_requests: {
            title: 'Stock Check Requests',
            noRequests: 'No Stock Check Requests Found',
            tableHeaders: {
                name: 'Name',
                email: 'Email',
                phone: 'Phone',
                product: 'Product',
                quantity: 'Quantity',
                createdAt: 'Created At'
            }
        },

        // Subscribers
        subscribers: {
            title: 'Subscribers List',
            search: 'Search',
            searchPlaceholder: 'Search by email',
            noSubscribers: 'No Subscribers Found',
            noSubscribersMessage: 'No subscribers match your search criteria. Try adjusting your filters.',
            tableHeaders: {
                email: 'Email',
                createdAt: 'Created At'
            },
            copyEmail: 'Copy Email',
            showing: 'Showing',
            to: 'to',
            of: 'of',
            entries: 'entries'
        },

        // Users
        users: {
            title: 'Manage Users',
            addUser: 'Add User',
            editUser: 'Edit User',
            search: 'Search',
            searchPlaceholder: 'Search by name or email',
            role: 'Role',
            allRoles: 'All Roles',
            status: 'Status',
            all: 'All',
            statusActive: 'Active',
            statusDeleted: 'Deleted',
            noRole: 'No Role',
            created: 'Created',
            tableHeaders: {
                name: 'Name',
                email: 'Email',
                role: 'Role',
                status: 'Status',
                createdAt: 'Created At',
                actions: 'Actions'
            },
            leaveBlankToKeepPassword: 'Leave blank to keep current password',
            passwordMin8: 'Password (min 8 characters)',
            selectRole: 'Select Role',
            cancel: 'Cancel',
            update: 'Update',
            create: 'Create',
            userDetails: 'User Details',
            name: 'Name',
            email: 'Email',
            createdAt: 'Created At',
            deletedAt: 'Deleted At',
            close: 'Close',
            userUpdated: 'User Updated',
            userCreated: 'User Created',
            error: 'Error',
            failedToSaveUser: 'Failed to save user',
            areYouSure: 'Are you sure?',
            softDeleteWarning: 'This will soft delete the user. They won\'t be able to login but their data will be preserved.',
            yesDeleteIt: 'Yes, delete it!',
            userDeleted: 'User Deleted',
            failedToDeleteUser: 'Failed to delete user',
            areYouAbsolutelySure: 'Are you absolutely sure?',
            hardDeleteWarning: 'This will permanently delete the user. This action cannot be undone!',
            yesPermanentlyDelete: 'Yes, permanently delete!',
            userPermanentlyDeleted: 'User Permanently Deleted',
            failedToPermanentlyDeleteUser: 'Failed to permanently delete user',
            userRestored: 'User Restored',
            failedToRestoreUser: 'Failed to restore user'
        },

        // Roles
        roles: {
            title: 'Roles & Permissions',
            description: 'Manage system roles and their permissions',
            addNew: 'Add New Role',
            editRole: 'Edit Role',
            addNewRole: 'Add New Role',
            noRolesFound: 'No Roles Found',
            noRolesMessage: 'There are no roles registered yet.',
            addFirstRole: 'Add First Role',
            users: 'Users',
            permissions: 'Permissions',
            more: 'more',
            cancel: 'Cancel',
            update: 'Update',
            create: 'Create',
            noPermissionsFound: 'No permissions found',
            tableHeaders: {
                name: 'Role Name',
                description: 'Description',
                users: 'Users Count',
                permissions: 'Permissions',
                actions: 'Actions'
            },
            form: {
                namePlaceholder: 'Role Name*',
                nameTooltip: 'Enter a descriptive name for this role (e.g. Manager, Waiter)',
                descriptionPlaceholder: 'Description (optional)',
                descriptionTooltip: 'Describe the responsibilities or scope of this role (optional)',
                permissions: 'Permissions',
                permissionsTooltip: 'Select the permissions this role should have',
                selectAll: 'Select All',
                selectAllTooltip: 'Select or deselect all permissions'
            },
            messages: {
                roleCreated: 'Role created successfully',
                roleUpdated: 'Role updated successfully',
                roleDeleted: 'Role deleted successfully',
                confirmDelete: 'Are you sure you want to delete this role?',
                deleteWarning: "You won't be able to revert this!",
                loadPermissionsFailed: 'Failed to load permissions',
                saveFailed: 'Failed to save role',
                deleteFailed: 'Failed to delete role'
            }
        },

        // Settings
        settings: {
            title: 'Settings',
            generalSettings: 'General Settings',
            restaurantInfo: 'Restaurant Information',
            restaurantName: 'Restaurant Name',
            description: 'Description',
            address: 'Address',
            phone: 'Phone',
            email: 'Email',
            website: 'Website',
            openingHours: 'Opening Hours',
            currency: 'Currency',
            logo: 'Logo',
            uploadLogo: 'Upload Logo',
            logoRequirements: 'Logo must be less than 2MB and in image format',
            saveSettings: 'Save Settings',
            settingsSaved: 'Settings saved successfully',
            logoUploaded: 'Logo uploaded successfully',
            basicInformation: 'Basic Information',
            businessName: 'Business Name',
            businessNameTooltip: 'Enter your restaurant\'s business name.',
            logoTooltip: 'Upload your restaurant\'s logo. Recommended size: 200x200px. Max size: 2MB.',
            logoRequirements: 'Recommended size: 200x200px. Max size: 2MB',
            emailTooltip: 'Your restaurant\'s main email address. This is used for notifications and contact.',
            phoneTooltip: 'Your restaurant\'s main phone number.',
            locationInformation: 'Location Information',
            addressTooltip: 'Full address of your restaurant.',
            city: 'City',
            cityTooltip: 'City where your restaurant is located.',
            state: 'State',
            stateTooltip: 'State or province of your restaurant.',
            postalCode: 'Postal Code',
            postalCodeTooltip: 'Postal or ZIP code for your restaurant\'s address.',
            country: 'Country',
            countryTooltip: 'Country where your restaurant is located.',
            placeId: 'Place ID',
            placeIdTooltip: 'Google Maps Place ID (optional, for advanced integrations).',
            pickupTimeRange: 'Pickup Time Range',
            pickupTimeRangeTooltip: 'Time range for order pickups (e.g., 9:00 AM - 10:00 PM).',
            latitude: 'Latitude',
            latitudeTooltip: 'Latitude coordinate for your restaurant (optional).',
            longitude: 'Longitude',
            longitudeTooltip: 'Longitude coordinate for your restaurant (optional).',
            systemSettings: 'System Settings',
            currencyTooltip: 'Select the currency for your restaurant\'s transactions.',
            timezone: 'Timezone',
            timezoneTooltip: 'Select your restaurant\'s timezone.',
            timezoneUTC: 'UTC',
            timezoneEastern: 'Eastern Time',
            timezoneCentral: 'Central Time',
            timezoneMountain: 'Mountain Time',
            timezonePacific: 'Pacific Time',
            dateFormat: 'Date Format',
            dateFormatTooltip: 'Choose how dates are displayed in your system.',
            dateFormatYMD: 'YYYY-MM-DD',
            dateFormatMDY: 'MM/DD/YYYY',
            dateFormatDMY: 'DD/MM/YYYY',
            timeFormat: 'Time Format',
            timeFormatTooltip: 'Choose how times are displayed in your system.',
            timeFormat24: '24-hour (HH:mm:ss)',
            timeFormat12: '12-hour (hh:mm:ss AM/PM)',
            status: 'Status',
            statusTooltip: 'Toggle to activate or deactivate your restaurant in the system.',
            statusActive: 'Active',
            statusInactive: 'Inactive',
            socialMediaLinks: 'Social Media Links',
            facebookLink: 'Facebook Link',
            facebookLinkTooltip: 'Your restaurant\'s Facebook page URL.',
            twitterLink: 'Twitter Link',
            twitterLinkTooltip: 'Your restaurant\'s Twitter profile URL.',
            linkedinLink: 'LinkedIn Link',
            linkedinLinkTooltip: 'Your restaurant\'s LinkedIn page URL.',
            googlePlusLink: 'Google Plus Link',
            googlePlusLinkTooltip: 'Your restaurant\'s Google Plus page URL (if any).',
            instagramLink: 'Instagram Link',
            instagramLinkTooltip: 'Your restaurant\'s Instagram profile URL.',
            descriptionLabel: 'Description',
            descriptionTooltip: 'A short description of your restaurant, cuisine, or specialties.'
        }
    },

    // Common dashboard elements
    dashboard_common: {
        loading: 'Loading...',
        noData: 'No data available',
        search: 'Search',
        filter: 'Filter',
        actions: 'Actions',
        save: 'Save',
        cancel: 'Cancel',
        delete: 'Delete',
        edit: 'Edit',
        view: 'View',
        create: 'Create',
        update: 'Update',
        confirm: 'Confirm',
        success: 'Success',
        error: 'Error',
        warning: 'Warning',
        info: 'Information',
        yes: 'Yes',
        no: 'No',
        close: 'Close',
        back: 'Back',
        next: 'Next',
        previous: 'Previous',
        submit: 'Submit',
        reset: 'Reset',
        apply: 'Apply',
        clear: 'Clear',
        select: 'Select',
        choose: 'Choose',
        upload: 'Upload',
        download: 'Download',
        export: 'Export',
        import: 'Import',
        refresh: 'Refresh',
        reload: 'Reload',
        add: 'Add',
        remove: 'Remove',
        duplicate: 'Duplicate',
        copy: 'Copy',
        paste: 'Paste',
        cut: 'Cut',
        undo: 'Undo',
        redo: 'Redo',
        print: 'Print',
        share: 'Share',
        settings: 'Settings',
        preferences: 'Preferences',
        profile: 'Profile',
        logout: 'Logout',
        login: 'Login',
        register: 'Register',
        forgotPassword: 'Forgot Password',
        resetPassword: 'Reset Password',
        changePassword: 'Change Password',
        updateProfile: 'Update Profile',
        notifications: 'Notifications',
        messages: 'Messages',
        inbox: 'Inbox',
        sent: 'Sent',
        drafts: 'Drafts',
        trash: 'Trash',
        archive: 'Archive',
        markAsRead: 'Mark as Read',
        markAsUnread: 'Mark as Unread',
        reply: 'Reply',
        forward: 'Forward',
        compose: 'Compose',
        send: 'Send',
        saveAsDraft: 'Save as Draft',
        discard: 'Discard',
        publish: 'Publish',
        unpublish: 'Unpublish',
        approve: 'Approve',
        reject: 'Reject',
        activate: 'Activate',
        deactivate: 'Deactivate',
        enable: 'Enable',
        disable: 'Disable',
        show: 'Show',
        hide: 'Hide',
        expand: 'Expand',
        collapse: 'Collapse',
        maximize: 'Maximize',
        minimize: 'Minimize',
        fullscreen: 'Fullscreen',
        exitFullscreen: 'Exit Fullscreen',
        zoomIn: 'Zoom In',
        zoomOut: 'Zoom Out',
        fitToScreen: 'Fit to Screen',
        actualSize: 'Actual Size',
        rotate: 'Rotate',
        flip: 'Flip',
        crop: 'Crop',
        resize: 'Resize',
        move: 'Move',
        align: 'Align',
        distribute: 'Distribute',
        group: 'Group',
        ungroup: 'Ungroup',
        lock: 'Lock',
        unlock: 'Unlock',
        protect: 'Protect',
        unprotect: 'Unprotect',
        share: 'Share',
        unshare: 'Unshare',
        invite: 'Invite',
        remove: 'Remove',
        block: 'Block',
        unblock: 'Unblock',
        follow: 'Follow',
        unfollow: 'Unfollow',
        subscribe: 'Subscribe',
        unsubscribe: 'Unsubscribe',
        like: 'Like',
        unlike: 'Unlike',
        favorite: 'Favorite',
        unfavorite: 'Unfavorite',
        bookmark: 'Bookmark',
        unbookmark: 'Remove Bookmark',
        rate: 'Rate',
        review: 'Review',
        comment: 'Comment',
        reply: 'Reply',
        report: 'Report',
        flag: 'Flag',
        spam: 'Spam',
        delete: 'Delete',
        restore: 'Restore',
        archive: 'Archive',
        move: 'Move',
        copy: 'Copy',
        duplicate: 'Duplicate',
        rename: 'Rename',
        sort: 'Sort',
        filter: 'Filter',
        search: 'Search',
        find: 'Find',
        replace: 'Replace',
        selectAll: 'Select All',
        deselectAll: 'Deselect All',
        invertSelection: 'Invert Selection',
        clearSelection: 'Clear Selection',
        selectInverse: 'Select Inverse',
        selectNone: 'Select None',
        selectVisible: 'Select Visible',
        selectHidden: 'Select Hidden',
        selectLocked: 'Select Locked',
        selectUnlocked: 'Select Unlocked',
        selectProtected: 'Select Protected',
        selectUnprotected: 'Select Unprotected',
        selectShared: 'Select Shared',
        selectUnshared: 'Select Unshared',
        selectInvited: 'Select Invited',
        selectRemoved: 'Select Removed',
        selectBlocked: 'Select Blocked',
        selectUnblocked: 'Select Unblocked',
        selectFollowed: 'Select Followed',
        selectUnfollowed: 'Select Unfollowed',
        selectSubscribed: 'Select Subscribed',
        selectUnsubscribed: 'Select Unsubscribed',
        selectLiked: 'Select Liked',
        selectUnliked: 'Select Unliked',
        selectFavorited: 'Select Favorited',
        selectUnfavorited: 'Select Unfavorited',
        selectBookmarked: 'Select Bookmarked',
        selectUnbookmarked: 'Select Unbookmarked',
        selectRated: 'Select Rated',
        selectUnrated: 'Select Unrated',
        selectReviewed: 'Select Reviewed',
        selectUnreviewed: 'Select Unreviewed',
        selectCommented: 'Select Commented',
        selectUncommented: 'Select Uncommented',
        selectReplied: 'Select Replied',
        selectUnreplied: 'Select Unreplied',
        selectReported: 'Select Reported',
        selectUnreported: 'Select Unreported',
        selectFlagged: 'Select Flagged',
        selectUnflagged: 'Select Unflagged',
        selectSpammed: 'Select Spammed',
        selectUnspammed: 'Select Unspammed'
    }
};
