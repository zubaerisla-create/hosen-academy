<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SoftwareShopController extends Controller
{
    public function index()
    {
        $page_data['page_title'] = 'Hosen Software Shop - Enterprise Digital Solutions';
        $page_data['services'] = $this->getServicesData();
        return view('frontend.default.software_shop', $page_data);
    }

    public function service_details($slug)
    {
        $services = $this->getServicesData();

        if (!isset($services[$slug])) {
            abort(404);
        }

        $page_data['service'] = $services[$slug];
        $page_data['all_services'] = $services;
        $page_data['page_title'] = $services[$slug]['title'] . ' - Hosen Software Shop';

        return view('frontend.default.software_service_details', $page_data);
    }

    private function getServicesData()
    {
        return [
            'website-development' => [
                'title' => 'Website Development',
                'slug' => 'website-development',
                'icon' => 'fa-solid fa-globe',
                'color_class' => 'indigo',
                'bg_class' => 'bg-indigo-100',
                'text_class' => 'text-indigo',
                'tagline' => 'High-Performance Web Applications, Custom E-Commerce & Web Platforms',
                'summary' => 'Custom web application development, Laravel, React, Vue, WordPress, and RESTful API integrations built for scalability.',
                'description' => 'Hosen Software Shop engineers custom web applications that combine modern aesthetic design with rock-solid server-side performance. Whether you need an enterprise web portal, a high-converting e-commerce engine, or a custom SaaS product, our development team builds secure, SEO-optimized, and lightning-fast web solutions.',
                'features' => [
                    [
                        'title' => 'Custom Laravel & Framework Architecture',
                        'desc' => 'Clean MVC pattern, scalable database schemas, and modular code architecture built for enterprise security.'
                    ],
                    [
                        'title' => 'Single Page Apps (React & Vue.js)',
                        'desc' => 'Reactive, app-like user experiences with smooth transitions and fast asynchronous data loading.'
                    ],
                    [
                        'title' => 'RESTful & GraphQL API Integration',
                        'desc' => 'Seamless integration with third-party payment gateways, CRM systems, SMS gateways, and cloud APIs.'
                    ],
                    [
                        'title' => 'Responsive & Cross-Browser Excellence',
                        'desc' => 'Pixel-perfect responsive design tailored for mobile phones, tablets, laptops, and ultra-wide desktops.'
                    ],
                    [
                        'title' => 'SEO Optimization & Speed Tuning',
                        'desc' => 'Built with clean HTML5 semantic structure, structured data schema, Gzip compression, and Core Web Vitals optimization.'
                    ],
                    [
                        'title' => 'High Security & DDoS Protection',
                        'desc' => 'Protection against SQL injection, CSRF attacks, XSS vulnerabilities, and automated security hardening.'
                    ]
                ],
                'tech_stack' => ['PHP Laravel', 'React.js', 'Vue.js', 'WordPress', 'MySQL', 'Node.js', 'Tailwind CSS', 'Bootstrap 5', 'REST API', 'AWS Cloud'],
                'workflow' => [
                    '01' => ['title' => 'Requirement Gathering & Architecture Strategy', 'desc' => 'We analyze your business goals, target audience, and functional scope to design a custom database schema and system blueprint.'],
                    '02' => ['title' => 'UI/UX Design & Interactive Prototypes', 'desc' => 'Our design team crafts intuitive wireframes and Figma prototypes tailored to your brand identity.'],
                    '03' => ['title' => 'Core Development & Integration', 'desc' => 'Our engineering team writes clean, modular backend and frontend code with full security protocols.'],
                    '04' => ['title' => 'QA Testing, Security Audit & Deployment', 'desc' => 'Rigorous multi-device testing, speed audits, and zero-downtime deployment on your preferred server.']
                ]
            ],

            'mobile-app-development' => [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'icon' => 'fa-solid fa-mobile-screen-button',
                'color_class' => 'emerald',
                'bg_class' => 'bg-emerald-100',
                'text_class' => 'text-emerald',
                'tagline' => 'Native-Performance iOS & Android Mobile Apps Built with Flutter & React Native',
                'summary' => 'High-speed native and cross-platform mobile apps for Android and iOS with fluid UI and offline support.',
                'description' => 'We build powerful, intuitive, and high-speed mobile applications for iOS and Android. Using modern cross-platform technologies like Flutter and React Native, we deliver near-native performance from a single codebase—saving development time while offering a premium mobile user experience.',
                'features' => [
                    [
                        'title' => 'Cross-Platform Flutter & React Native',
                        'desc' => 'Dual Android and iOS deployment with native-level performance, smooth 60fps animations, and gesture support.'
                    ],
                    [
                        'title' => 'Push Notifications & Real-Time Sync',
                        'desc' => 'Firebase Push Notifications, WebSockets, and real-time data sync for messaging, order tracking, and alerts.'
                    ],
                    [
                        'title' => 'In-App Payments & Biometric Auth',
                        'desc' => 'Secure bKash, Nagad, Stripe, and Apple/Google Pay integrations along with Fingerprint/FaceID authentication.'
                    ],
                    [
                        'title' => 'Offline Data Caching',
                        'desc' => 'Local SQLite/Hive data storage ensuring seamless app performance even with poor internet connectivity.'
                    ]
                ],
                'tech_stack' => ['Flutter', 'Dart', 'React Native', 'Firebase', 'REST API', 'SQLite', 'iOS Swift', 'Android Kotlin'],
                'workflow' => [
                    '01' => ['title' => 'App Concept & User Flow Mapping', 'desc' => 'Defining user journeys, wireframes, and mobile interface design.'],
                    '02' => ['title' => 'UI/UX Prototyping', 'desc' => 'Designing modern touch-friendly iOS and Android interfaces.'],
                    '03' => ['title' => 'App Development & API Sync', 'desc' => 'Building Flutter/React Native code and connecting secure REST APIs.'],
                    '04' => ['title' => 'App Store & Play Store Publishing', 'desc' => 'Complete assistance with Google Play Store and Apple App Store deployment.']
                ]
            ],

            'custom-software-development' => [
                'title' => 'Custom Software Dev',
                'slug' => 'custom-software-development',
                'icon' => 'fa-solid fa-code-branch',
                'color_class' => 'purple',
                'bg_class' => 'bg-purple-100',
                'text_class' => 'text-purple',
                'tagline' => 'Tailored Software Engineering Built to Automate Complex Business Workflows',
                'summary' => 'Bespoke enterprise software systems engineered specifically to solve unique operational bottlenecks.',
                'description' => 'Off-the-shelf software often fails to meet unique operational needs. Hosen Software Shop specializes in building custom enterprise software solutions designed around your exact business rules, automation requirements, and workflow structures.',
                'features' => [
                    [
                        'title' => 'Tailored Business Logic & Workflows',
                        'desc' => 'Custom rules, automated approval flows, role-based access control, and specialized database models.'
                    ],
                    [
                        'title' => 'Scalable Cloud Architecture',
                        'desc' => 'Engineered to handle high concurrency, multi-tenant databases, and enterprise data processing.'
                    ],
                    [
                        'title' => 'Automated Reporting & Analytics',
                        'desc' => 'Interactive visual dashboards, PDF/Excel export, and automated daily/weekly email reports.'
                    ],
                    [
                        'title' => '100% Owned Source Code',
                        'desc' => 'You get full ownership of the intellectual property, source code, and deployment scripts.'
                    ]
                ],
                'tech_stack' => ['PHP Laravel', 'Python', 'Node.js', 'PostgreSQL', 'Redis', 'Docker', 'Microservices', 'Linux'],
                'workflow' => [
                    '01' => ['title' => 'Business Process Analysis', 'desc' => 'In-depth consultation to map current manual workflows and automation goals.'],
                    '02' => ['title' => 'System Architecture Blueprint', 'desc' => 'Designing database schemas, ER diagrams, and system security parameters.'],
                    '03' => ['title' => 'Iterative Development & Demos', 'desc' => 'Sprint-based development with regular milestone demonstrations.'],
                    '04' => ['title' => 'Deployment & Staff Training', 'desc' => 'Server setup, data migration, user manuals, and hands-on staff training.']
                ]
            ],

            'ready-made-software' => [
                'title' => 'Ready-Made Software',
                'slug' => 'ready-made-software',
                'icon' => 'fa-solid fa-box-archive',
                'color_class' => 'amber',
                'bg_class' => 'bg-amber-100',
                'text_class' => 'text-amber',
                'tagline' => 'Turnkey Web Scripts & Pre-Built Enterprise Systems Available for Immediate Setup',
                'summary' => 'Instant downloadable LMS, e-commerce templates, starter web scripts, and pre-configured business platforms.',
                'description' => 'Need a software solution launched today? Hosen Software Shop offers ready-made web scripts, complete LMS engines, e-commerce platforms, and management systems that are fully tested and ready for immediate deployment on your domain.',
                'features' => [
                    [
                        'title' => 'Instant Turnkey Deployment',
                        'desc' => 'Install and go live within hours with automated setup scripts and sample dummy data.'
                    ],
                    [
                        'title' => 'White-Label & Custom Branding',
                        'desc' => 'Easily replace logos, color palettes, site name, and currency settings from the admin panel.'
                    ],
                    [
                        'title' => 'Local Payment Gateways Included',
                        'desc' => 'Pre-integrated bKash, Nagad, Rocket, SSLCommerz, Shurjopay, and international gateways.'
                    ],
                    [
                        'title' => 'Full Source Code Access',
                        'desc' => 'Modifiable source code allowing your developer team to add custom features anytime.'
                    ]
                ],
                'tech_stack' => ['PHP Laravel', 'MySQL', 'Bootstrap 5', 'jQuery', 'bKash API', 'SSLCommerz', 'cPanel Installer'],
                'workflow' => [
                    '01' => ['title' => 'Select Product from Catalog', 'desc' => 'Choose your desired software script from Hosen Software Shop.'],
                    '02' => ['title' => 'License & File Access', 'desc' => 'Receive instant access to full zip source code, SQL database, and user docs.'],
                    '03' => ['title' => 'Domain & Server Installation', 'desc' => 'Free installation setup on your server by our technical team.'],
                    '04' => ['title' => 'Branding & Go Live', 'desc' => 'Update site logo, payment keys, and launch your platform immediately.']
                ]
            ],

            'business-systems-erp-crm' => [
                'title' => 'Business Systems (ERP/CRM)',
                'slug' => 'business-systems-erp-crm',
                'icon' => 'fa-solid fa-chart-line',
                'color_class' => 'blue',
                'bg_class' => 'bg-blue-100',
                'text_class' => 'text-blue',
                'tagline' => 'Integrated Enterprise Resource Planning, HR, Payroll, Inventory & Accounting Software',
                'summary' => 'Complete management software for HRM, Payroll, Inventory, Accounting, POS, and Customer Relationships.',
                'description' => 'Streamline company management, staff attendance, payroll calculations, inventory tracking, and client relationships with our robust ERP and CRM software suites designed for schools, institutes, agencies, and commercial enterprises.',
                'features' => [
                    [
                        'title' => 'HRM & Automated Payroll',
                        'desc' => 'Employee profiles, attendance tracking, leave management, salary slips, and tax deductions.'
                    ],
                    [
                        'title' => 'Inventory & Stock Control',
                        'desc' => 'Real-time stock monitoring, low stock alerts, supplier management, and purchase orders.'
                    ],
                    [
                        'title' => 'Financial Accounting & Invoicing',
                        'desc' => 'Income & expense tracking, automated invoice generation, profit/loss statements, and audit logs.'
                    ],
                    [
                        'title' => 'Role-Based Security & Audit Trail',
                        'desc' => 'Granular permission control for admins, managers, accountants, and staff members.'
                    ]
                ],
                'tech_stack' => ['PHP Laravel', 'Vue.js', 'MySQL', 'PDF Generator', 'Excel Exporter', 'SMS Gateway'],
                'workflow' => [
                    '01' => ['title' => 'Organization Audit', 'desc' => 'Understanding your company departments, roles, and accounting rules.'],
                    '02' => ['title' => 'ERP Configuration', 'desc' => 'Setting up chart of accounts, salary structures, and inventory categories.'],
                    '03' => ['title' => 'Data Migration', 'desc' => 'Importing existing Excel/legacy data into the new secure system.'],
                    '04' => ['title' => 'Staff Onboarding', 'desc' => 'Training your HR, accounts, and management teams.']
                ]
            ],

            'ecommerce-solutions' => [
                'title' => 'E-commerce Solutions',
                'slug' => 'ecommerce-solutions',
                'icon' => 'fa-solid fa-cart-shopping',
                'color_class' => 'rose',
                'bg_class' => 'bg-rose-100',
                'text_class' => 'text-rose',
                'tagline' => 'Scalable Multi-Vendor Marketplaces, High-Converting Shopping Carts & Payment Solutions',
                'summary' => 'Scalable multi-vendor marketplaces, mobile shopping apps, automated checkout, and delivery integration.',
                'description' => 'Build a thriving online retail store or multi-vendor marketplace with Hosen Software Shop. We provide end-to-end e-commerce development including product catalogs, discount engine, automated shipping calculations, local mobile wallet integration, and customer order management.',
                'features' => [
                    [
                        'title' => 'Multi-Vendor Marketplace Support',
                        'desc' => 'Vendor dashboards, product approval flow, automated commission split, and vendor payouts.'
                    ],
                    [
                        'title' => 'Seamless Checkout & Local Payments',
                        'desc' => 'bKash merchant checkout, Nagad, Cash on Delivery, SSLCommerz, and international cards.'
                    ],
                    [
                        'title' => 'Courier & Logistics Integration',
                        'desc' => 'Integration with Steadfast, Pathao, RedX courier APIs for automated order tracking.'
                    ],
                    [
                        'title' => 'Coupon & Discount Engine',
                        'desc' => 'Create category coupons, flash sales, buy-one-get-one offers, and referral points.'
                    ]
                ],
                'tech_stack' => ['Laravel E-com', 'React Frontend', 'Flutter App', 'bKash API', 'Steadfast Courier API', 'Redis Cache'],
                'workflow' => [
                    '01' => ['title' => 'Store Strategy & Category Architecture', 'desc' => 'Structuring product catalogs, shipping rules, and payment gateways.'],
                    '02' => ['title' => 'E-Com UI/UX Design', 'desc' => 'Crafting high-converting, mobile-first product pages and checkout flows.'],
                    '03' => ['title' => 'Payment & Courier API Setup', 'desc' => 'Connecting live merchant accounts for instant payments and auto-courier booking.'],
                    '04' => ['title' => 'Launch & Growth Support', 'desc' => 'Speed optimization, SSL setup, and store launch assistance.']
                ]
            ],

            'ui-ux-design' => [
                'title' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'icon' => 'fa-solid fa-pen-ruler',
                'color_class' => 'teal',
                'bg_class' => 'bg-teal-100',
                'text_class' => 'text-teal',
                'tagline' => 'User-Centric Interface Design, Wireframing & Interactive Prototype Engineering',
                'summary' => 'User-centric interface design, wireframing, Figma design systems, and interactive UI prototypes.',
                'description' => 'Great software starts with exceptional user experience. Our design studio crafts modern, accessible, and intuitive UI/UX designs for web platforms and mobile apps. We focus on clear navigation, visual hierarchy, and high conversion rates.',
                'features' => [
                    [
                        'title' => 'Figma Wireframes & Design Systems',
                        'desc' => 'Structured design systems with reusable components, color tokens, and typography rules.'
                    ],
                    [
                        'title' => 'Clickable Interactive Prototypes',
                        'desc' => 'Experience your app interface before writing a single line of code.'
                    ],
                    [
                        'title' => 'Mobile-First & Glassmorphism Aesthetics',
                        'desc' => 'Cutting-edge modern visual aesthetics tailored to elevate your brand image.'
                    ],
                    [
                        'title' => 'Developer-Ready Handoff',
                        'desc' => 'Complete Figma specs, SVG assets, CSS variables, and design tokens ready for development.'
                    ]
                ],
                'tech_stack' => ['Figma', 'Adobe XD', 'Illustrator', 'Design Systems', 'Micro-Animations', 'User Research'],
                'workflow' => [
                    '01' => ['title' => 'User Research & Wireframing', 'desc' => 'Understanding user personas, information architecture, and screen flows.'],
                    '02' => ['title' => 'Visual Design & Aesthetics', 'desc' => 'Designing high-fidelity UI screens in Figma.'],
                    '03' => ['title' => 'Interactive Prototyping', 'desc' => 'Connecting screens with micro-interactions and transitions.'],
                    '04' => ['title' => 'Developer Handoff', 'desc' => 'Exporting assets and component libraries for software engineers.']
                ]
            ],

            'maintenance-support' => [
                'title' => 'Website Maintenance & Support',
                'slug' => 'maintenance-support',
                'icon' => 'fa-solid fa-screwdriver-wrench',
                'color_class' => 'cyan',
                'bg_class' => 'bg-cyan-100',
                'text_class' => 'text-cyan',
                'tagline' => '24/7 Server Monitoring, Security Audits, Database Backups & Dedicated Maintenance',
                'summary' => '24/7 server monitoring, security auditing, database backup management, bug fixing, and updates.',
                'description' => 'Keep your digital assets running smoothly with zero downtime. Hosen Software Shop offers comprehensive technical maintenance, server optimization, malware cleanup, weekly backups, and dedicated developer support.',
                'features' => [
                    [
                        'title' => '24/7 Uptime & Server Monitoring',
                        'desc' => 'Continuous server health checks, CPU/RAM monitoring, and immediate downtime alerts.'
                    ],
                    [
                        'title' => 'Automated Weekly Database Backups',
                        'desc' => 'Automated off-site cloud backups to ensure your business data is never lost.'
                    ],
                    [
                        'title' => 'Security Patching & Malware Cleanup',
                        'desc' => 'Regular software framework updates, security hardening, and vulnerability scanning.'
                    ],
                    [
                        'title' => 'Dedicated Developer Support Hours',
                        'desc' => 'On-demand bug fixing, content updates, feature tweaks, and technical guidance.'
                    ]
                ],
                'tech_stack' => ['Linux Ubuntu', 'cPanel', 'AWS Cloud', 'SSL Certificates', 'MySQL Backup', 'Nginx/Apache'],
                'workflow' => [
                    '01' => ['title' => 'Initial Security & Speed Audit', 'desc' => 'Comprehensive inspection of your existing server, code, and SSL configuration.'],
                    '02' => ['title' => 'Automated Backup Setup', 'desc' => 'Configuring scheduled daily/weekly off-site backups.'],
                    '03' => ['title' => 'Proactive Monitoring', 'desc' => 'Real-time uptime tracking and automated incident response.'],
                    '04' => ['title' => 'Ongoing Helpdesk Support', 'desc' => 'Direct developer access via WhatsApp, Email, and Phone.']
                ]
            ]
        ];
    }
}
