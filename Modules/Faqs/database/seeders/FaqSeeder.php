<?php

namespace Modules\Faqs\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Faqs\Models\Faq;
use Modules\Faqs\Models\FaqCategory;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqData = [
            [
                "title" => [
                    "en" => "Orders & Shipping",
                    "ar" => "الطلبات والشحن",
                ],
                "faqs" => [
                    [
                        "question" => [
                            "en" => "How can I track my order?",
                            "ar" => "كيف يمكنني تتبع طلبي؟",
                        ],
                        "answer" => [
                            "en" =>
                                "You can track your order by logging into your account and visiting the 'Order History' section. Alternatively, you can use the tracking number provided in your shipping confirmation email.",
                            "ar" =>
                                'يمكنك تتبع طلبك عن طريق تسجيل الدخول إلى حسابك وزيارة قسم "سجل الطلبات". بدلاً من ذلك، يمكنك استخدام رقم التتبع المقدم في بريد تأكيد الشحن الإلكتروني.',
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "What shipping methods do you offer?",
                            "ar" => "ما هي طرق الشحن التي تقدمونها؟",
                        ],
                        "answer" => [
                            "en" =>
                                "We offer standard shipping (3-5 business days), express shipping (1-2 business days), and next-day delivery options. Shipping costs vary based on your location and the selected shipping method.",
                            "ar" =>
                                "نقدم الشحن القياسي (3-5 أيام عمل)، والشحن السريع (1-2 أيام عمل)، وخيارات التوصيل في اليوم التالي. تختلف تكاليف الشحن بناءً على موقعك وطريقة الشحن المختارة.",
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "Do you ship internationally?",
                            "ar" => "هل تقومون بالشحن دوليًا؟",
                        ],
                        "answer" => [
                            "en" =>
                                "Yes, we ship to over 50 countries worldwide. International shipping typically takes 7-14 business days, depending on the destination and customs processing.",
                            "ar" =>
                                "نعم، نشحن إلى أكثر من 50 دولة حول العالم. عادةً ما يستغرق الشحن الدولي من 7 إلى 14 يوم عمل، حسب الوجهة ومعالجة الجمارك.",
                        ],
                    ],
                    [
                        "question" => [
                            "en" =>
                                "How long will it take to receive my order?",
                            "ar" => "كم من الوقت سيستغرق استلام طلبي؟",
                        ],
                        "answer" => [
                            "en" =>
                                "Domestic orders typically arrive within 3-5 business days with standard shipping. Express shipping delivers within 1-2 business days. Please note that processing time (1-2 days) is not included in these estimates.",
                            "ar" =>
                                "عادةً ما تصل الطلبات المحلية خلال 3-5 أيام عمل مع الشحن القياسي. يتم التوصيل بالشحن السريع خلال 1-2 أيام عمل. يرجى ملاحظة أن وقت المعالجة (1-2 أيام) غير مشمول في هذه التقديرات.",
                        ],
                    ],
                ],
            ],
            [
                "title" => [
                    "en" => "Returns & Refunds",
                    "ar" => "الإرجاع والاسترداد",
                ],
                "faqs" => [
                    [
                        "question" => [
                            "en" => "What is your return policy?",
                            "ar" => "ما هي سياسة الإرجاع الخاصة بكم؟",
                        ],
                        "answer" => [
                            "en" =>
                                "We accept returns within 30 days of delivery. Items must be in their original condition with tags attached. Some products like intimate apparel and personalized items cannot be returned for hygiene and customization reasons.",
                            "ar" =>
                                "نقبل الإرجاع خلال 30 يومًا من التسليم. يجب أن تكون الأغراض في حالتها الأصلية مع البطاقات مرفقة. لا يمكن إرجاع بعض المنتجات مثل الملابس الداخلية والأغراض المخصصة لأسباب تتعلق بالنظافة والتخصيص.",
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "How do I initiate a return?",
                            "ar" => "كيف يمكنني بدء عملية الإرجاع؟",
                        ],
                        "answer" => [
                            "en" =>
                                "To initiate a return, log into your account, go to 'Order History', select the order containing the item you wish to return, and follow the return instructions. You'll receive a return shipping label via email.",
                            "ar" =>
                                'لبدء الإرجاع، سجّل الدخول إلى حسابك، انتقل إلى "سجل الطلبات"، اختر الطلب الذي يحتوي على الغرض الذي ترغب في إرجاعه، واتبع تعليمات الإرجاع. ستتلقى بطاقة شحن الإرجاع عبر البريد الإلكتروني.',
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "When will I receive my refund?",
                            "ar" => "متى سأستلم استرداد أموالي؟",
                        ],
                        "answer" => [
                            "en" =>
                                "Once we receive and inspect your return (typically 2-3 business days after receipt), we'll process your refund. It may take an additional 5-10 business days for the refund to appear in your account, depending on your payment method.",
                            "ar" =>
                                "بمجرد استلامنا وفحص الإرجاع (عادةً 2-3 أيام عمل بعد الاستلام)، سنقوم بمعالجة استرداد أموالك. قد يستغرق الأمر من 5 إلى 10 أيام عمل إضافية حتى يظهر الاسترداد في حسابك، حسب طريقة الدفع.",
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "Do you offer exchanges?",
                            "ar" => "هل تقدمون خدمة الاستبدال؟",
                        ],
                        "answer" => [
                            "en" =>
                                "Yes, we offer exchanges for different sizes or colors of the same item. You can request an exchange through the return process by selecting 'Exchange' instead of 'Return' and specifying your preferred replacement.",
                            "ar" =>
                                'نعم، نقدم الاستبدال لأحجام أو ألوان مختلفة لنفس الغرض. يمكنك طلب الاستبدال من خلال عملية الإرجاع بشرط اختيار "استبدال" بدلاً من "إرجاع" وتحديد البديل المفضل لديك.',
                        ],
                    ],
                ],
            ],
            [
                "title" => [
                    "en" => "Product Information",
                    "ar" => "معلومات المنتج",
                ],
                "faqs" => [
                    [
                        "question" => [
                            "en" => "How do I find my size?",
                            "ar" => "كيف أجد مقاسي؟",
                        ],
                        "answer" => [
                            "en" =>
                                "We provide detailed size guides on each product page. You can find measurements and fit recommendations to help you select the right size. If you're between sizes, we generally recommend sizing up.",
                            "ar" =>
                                "نوفر أدلة مقاسات مفصلة على صفحة كل منتج. يمكنك العثور على القياسات وتوصيات الملاءمة لمساعدتك في اختيار المقاس المناسب. إذا كنت بين مقاسين، نوصي عادةً باختيار المقاس الأكبر.",
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "Are your products ethically sourced?",
                            "ar" => "هل منتجاتكم مصدرها أخلاقي؟",
                        ],
                        "answer" => [
                            "en" =>
                                "Yes, we are committed to ethical sourcing. All our suppliers adhere to fair labor practices, and we regularly audit our supply chain to ensure compliance with our ethical standards.",
                            "ar" =>
                                "نعم، نحن ملتزمون بالتزويد الأخلاقي. يلتزم جميع موردينا بممارسات العمل العادلة، ونقوم بتدقيق سلسلة التوريد الخاصة بنا بانتظام لضمان الامتثال لمعاييرنا الأخلاقية.",
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "Do you offer gift wrapping?",
                            "ar" => "هل تقدمون خدمة تغليف الهدايا؟",
                        ],
                        "answer" => [
                            "en" =>
                                'Yes, we offer gift wrapping services for an additional $5 per item. You can select this option during checkout and include a personalized message for the recipient.',
                            "ar" =>
                                "نعم، نقدم خدمات تغليف الهدايا مقابل 5 دولارات إضافية لكل غرض. يمكنك اختيار هذا الخيار أثناء الدفع وإدراج رسالة مخصصة للمستلم.",
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "How do I care for my purchased items?",
                            "ar" => "كيف أعتني بالأغراض التي اشتريتها؟",
                        ],
                        "answer" => [
                            "en" =>
                                "Care instructions are provided on each product page and included with your purchase. Generally, we recommend following the specific care label attached to each item for best results.",
                            "ar" =>
                                "يتم توفير تعليمات العناية على صفحة كل منتج ومرفقة مع عملية الشراء. بشكل عام، نوصي باتباع ملصق العناية المحدد المرفق مع كل غرض للحصول على أفضل النتائج.",
                        ],
                    ],
                ],
            ],
            [
                "title" => [
                    "en" => "Account & Payment",
                    "ar" => "الحساب والدفع",
                ],
                "faqs" => [
                    [
                        "question" => [
                            "en" => "How do I create an account?",
                            "ar" => "كيف أنشئ حسابًا؟",
                        ],
                        "answer" => [
                            "en" =>
                                "You can create an account by clicking the 'Account' icon in the top right corner of our website and selecting 'Register'. You'll need to provide your email address and create a password.",
                            "ar" =>
                                'يمكنك إنشاء حساب بالنقر على أيقونة "الحساب" في الزاوية اليمنى العليا من موقعنا الإلكتروني واختيار "تسجيل". ستحتاج إلى تقديم عنوان بريدك الإلكتروني وإنشاء كلمة مرور.',
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "What payment methods do you accept?",
                            "ar" => "ما هي طرق الدفع التي تقبلونها؟",
                        ],
                        "answer" => [
                            "en" =>
                                "We accept all major credit cards (Visa, Mastercard, American Express, Discover), PayPal, Apple Pay, Google Pay, and Shop Pay. We also offer installment payment options through Affirm and Klarna.",
                            "ar" =>
                                "نقبل جميع بطاقات الائتمان الرئيسية (فيزا، ماستركارد، أمريكان إكسبريس، ديسكفر)، باي بال، أبل باي، جوجل باي، وشوب باي. كما نقدم خيارات الدفع بالتقسيط من خلال أفيرم وكلارنا.",
                        ],
                    ],
                    [
                        "question" => [
                            "en" => "Is my payment information secure?",
                            "ar" => "هل معلومات الدفع الخاصة بي آمنة؟",
                        ],
                        "answer" => [
                            "en" =>
                                "Yes, we use industry-standard encryption and security measures to protect your payment information. We are PCI DSS compliant and never store your full credit card details on our servers.",
                            "ar" =>
                                "نعم، نستخدم التشفير وتدابير الأمان القياسية في الصناعة لحماية معلومات الدفع الخاصة بك. نحن متوافقون مع معيار PCI DSS ولا نخزن تفاصيل بطاقتك الائتمانية الكاملة على خوادمنا.",
                        ],
                    ],
                    [
                        "question" => [
                            "en" =>
                                "Can I save my payment information for future purchases?",
                            "ar" =>
                                "هل يمكنني حفظ معلومات الدفع الخاصة بي لعمليات الشراء المستقبلية؟",
                        ],
                        "answer" => [
                            "en" =>
                                "Yes, you can save your payment information securely in your account for faster checkout in the future. You can manage your saved payment methods in the 'Payment Methods' section of your account.",
                            "ar" =>
                                'نعم، يمكنك حفظ معلومات الدفع الخاصة بك بأمان في حسابك لتسريع عملية الدفع في المستقبل. يمكنك إدارة طرق الدفع المحفوظة في قسم "طرق الدفع" في حسابك.',
                        ],
                    ],
                ],
            ],
        ];

        foreach ($faqData as $categoryData) {
            // Create the FAQ category
            $category = FaqCategory::create([
                "title" => $categoryData["title"],
            ]);

            // Create the FAQs for this category
            foreach ($categoryData["faqs"] as $faq) {
                Faq::create([
                    "faq_category_id" => $category->id,
                    "question" => $faq["question"],
                    "answer" => $faq["answer"],
                ]);
            }
        }
    }
}
