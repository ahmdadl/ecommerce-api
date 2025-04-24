<?php

namespace Modules\PageMetas\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PageMetas\Models\PageMeta;

class PageMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // pages: /, contact-us, privacy-policy, terms-and-conditions, shop, categories, brands, tags, faq, login, register, reset-password, forgot-password, profile, change-password, addresses, orders, order-details, cart, compare-lists, wishlist, order-track
        $pages = [
            [
                "page_url" => "home",
                "title" => [
                    "en" => "Home",
                    "ar" => "الصفحة الرئيسية",
                ],
                "description" => [
                    "en" =>
                        "Discover the best deals on our eCommerce platform!",
                    "ar" => "اكتشف أفضل العروض على منصتنا التجارية!",
                ],
                "keywords" => ["Home", "eCommerce", "Shopping"],
            ],
            [
                "page_url" => "contact-us",
                "title" => [
                    "en" => "Contact Us",
                    "ar" => "اتصل بنا",
                ],
                "description" => [
                    "en" =>
                        "Get in touch with our support team for any inquiries.",
                    "ar" => "تواصل مع فريق الدعم لأي استفسارات.",
                ],
                "keywords" => ["Contact", "Support", "Help"],
            ],
            [
                "page_url" => "privacy-policy",
                "title" => [
                    "en" => "Privacy Policy",
                    "ar" => "سياسة الخصوصية",
                ],
                "description" => [
                    "en" => "Learn how we protect your personal information.",
                    "ar" => "تعرف على كيفية حماية معلوماتك الشخصية.",
                ],
                "keywords" => ["Privacy", "Policy", "Data Protection"],
            ],
            [
                "page_url" => "terms-and-conditions",
                "title" => [
                    "en" => "Terms and Conditions",
                    "ar" => "الشروط والأحكام",
                ],
                "description" => [
                    "en" =>
                        "Understand the terms governing the use of our website.",
                    "ar" => "فهم الشروط التي تحكم استخدام موقعنا.",
                ],
                "keywords" => ["Terms", "Conditions", "Agreement"],
            ],
            [
                "page_url" => "shop",
                "title" => [
                    "en" => "Shop",
                    "ar" => "المتجر",
                ],
                "description" => [
                    "en" => "Browse our wide range of products.",
                    "ar" => "تصفح مجموعتنا الواسعة من المنتجات.",
                ],
                "keywords" => ["Shop", "Products", "Store"],
            ],
            [
                "page_url" => "categories",
                "title" => [
                    "en" => "Categories",
                    "ar" => "الفئات",
                ],
                "description" => [
                    "en" => "Explore products by categories.",
                    "ar" => "استكشف المنتجات حسب الفئات.",
                ],
                "keywords" => ["Categories", "Product Types", "Browse"],
            ],
            [
                "page_url" => "brands",
                "title" => [
                    "en" => "Brands",
                    "ar" => "العلامات التجارية",
                ],
                "description" => [
                    "en" => "Shop from your favorite brands.",
                    "ar" => "تسوق من علاماتك التجارية المفضلة.",
                ],
                "keywords" => ["Brands", "Manufacturers", "Labels"],
            ],
            [
                "page_url" => "tags",
                "title" => [
                    "en" => "Tags",
                    "ar" => "الوسوم",
                ],
                "description" => [
                    "en" => "Find products by specific tags.",
                    "ar" => "ابحث عن المنتجات باستخدام الوسوم.",
                ],
                "keywords" => ["Tags", "Filters", "Search"],
            ],
            [
                "page_url" => "faq",
                "title" => [
                    "en" => "FAQ",
                    "ar" => "الأسئلة الشائعة",
                ],
                "description" => [
                    "en" => "Answers to frequently asked questions.",
                    "ar" => "إجابات على الأسئلة الشائعة.",
                ],
                "keywords" => ["FAQ", "Questions", "Help"],
            ],
            [
                "page_url" => "login",
                "title" => [
                    "en" => "Login",
                    "ar" => "تسجيل الدخول",
                ],
                "description" => [
                    "en" =>
                        "Access your account to manage orders and preferences.",
                    "ar" => "قم بالوصول إلى حسابك لإدارة الطلبات والتفضيلات.",
                ],
                "keywords" => ["Login", "Sign In", "Account"],
            ],
            [
                "page_url" => "register",
                "title" => [
                    "en" => "Register",
                    "ar" => "التسجيل",
                ],
                "description" => [
                    "en" => "Create an account to enjoy exclusive benefits.",
                    "ar" => "أنشئ حسابًا للاستمتاع بالمزايا الحصرية.",
                ],
                "keywords" => ["Register", "Sign Up", "Account Creation"],
            ],
            [
                "page_url" => "reset-password",
                "title" => [
                    "en" => "Reset Password",
                    "ar" => "إعادة تعيين كلمة المرور",
                ],
                "description" => [
                    "en" =>
                        "Reset your password to regain access to your account.",
                    "ar" => "أعد تعيين كلمة المرور لاستعادة الوصول إلى حسابك.",
                ],
                "keywords" => [
                    "Reset Password",
                    "Password Recovery",
                    "Account",
                ],
            ],
            [
                "page_url" => "forgot-password",
                "title" => [
                    "en" => "Forgot Password",
                    "ar" => "نسيت كلمة المرور",
                ],
                "description" => [
                    "en" => "Recover your account by resetting your password.",
                    "ar" => "استعد حسابك عن طريق إعادة تعيين كلمة المرور.",
                ],
                "keywords" => ["Forgot Password", "Recovery", "Account"],
            ],
            [
                "page_url" => "profile",
                "title" => [
                    "en" => "Profile",
                    "ar" => "الملف الشخصي",
                ],
                "description" => [
                    "en" => "Manage your personal information and settings.",
                    "ar" => "إدارة معلوماتك الشخصية وإعداداتك.",
                ],
                "keywords" => ["Profile", "Account", "Settings"],
            ],
            [
                "page_url" => "change-password",
                "title" => [
                    "en" => "Change Password",
                    "ar" => "تغيير كلمة المرور",
                ],
                "description" => [
                    "en" => "Update your password for enhanced security.",
                    "ar" => "قم بتحديث كلمة المرور لزيادة الأمان.",
                ],
                "keywords" => ["Change Password", "Security", "Account"],
            ],
            [
                "page_url" => "addresses",
                "title" => [
                    "en" => "Addresses",
                    "ar" => "العناوين",
                ],
                "description" => [
                    "en" => "Manage your shipping and billing addresses.",
                    "ar" => "إدارة عناوين الشحن والفوترة الخاصة بك.",
                ],
                "keywords" => ["Addresses", "Shipping", "Billing"],
            ],
            [
                "page_url" => "orders",
                "title" => [
                    "en" => "Orders",
                    "ar" => "الطلبات",
                ],
                "description" => [
                    "en" => "View and manage your order history.",
                    "ar" => "عرض وإدارة سجل طلباتك.",
                ],
                "keywords" => ["Orders", "Order History", "Purchases"],
            ],
            [
                "page_url" => "order-details",
                "title" => [
                    "en" => "Order Details",
                    "ar" => "تفاصيل الطلب",
                ],
                "description" => [
                    "en" => "Check the details of your specific orders.",
                    "ar" => "تحقق من تفاصيل طلباتك المحددة.",
                ],
                "keywords" => ["Order Details", "Purchase", "Tracking"],
            ],
            [
                "page_url" => "cart",
                "title" => [
                    "en" => "Cart",
                    "ar" => "سلة التسوق",
                ],
                "description" => [
                    "en" =>
                        "Review and proceed to checkout with your selected items.",
                    "ar" => "راجع وعاين للدفع مع العناصر المختارة.",
                ],
                "keywords" => ["Cart", "Shopping Cart", "Checkout"],
            ],
            [
                "page_url" => "compare-lists",
                "title" => [
                    "en" => "Compare Lists",
                    "ar" => "قوائم المقارنة",
                ],
                "description" => [
                    "en" => "Compare products to make informed decisions.",
                    "ar" => "قارن المنتجات لاتخاذ قرارات مدروسة.",
                ],
                "keywords" => ["Compare", "Product Comparison", "Lists"],
            ],
            [
                "page_url" => "wishlist",
                "title" => [
                    "en" => "Wishlist",
                    "ar" => "قائمة الأمنيات",
                ],
                "description" => [
                    "en" => "Save your favorite products for later.",
                    "ar" => "احفظ منتجاتك المفضلة لوقت لاحق.",
                ],
                "keywords" => ["Wishlist", "Favorites", "Save"],
            ],
            [
                "page_url" => "order-track",
                "title" => [
                    "en" => "Order Tracking",
                    "ar" => "تتبع الطلب",
                ],
                "description" => [
                    "en" => "Track the status of your orders in real-time.",
                    "ar" => "تتبع حالة طلباتك في الوقت الفعلي.",
                ],
                "keywords" => ["Order Tracking", "Shipment", "Delivery"],
            ],
        ];

        PageMeta::query()->delete();

        foreach ($pages as $pageMeta) {
            PageMeta::create($pageMeta);
        }
    }
}
