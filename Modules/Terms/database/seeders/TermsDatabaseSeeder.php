<?php

namespace Modules\Terms\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Terms\Models\Term;

class TermsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $termsAndConditions = [
            [
                "title" => [
                    "en" => "1. Introduction",
                    "ar" => "1. المقدمة",
                ],
                "content" => [
                    "en" => '<p>Welcome to ShopEase ("Company", "we", "our", "us"). These Terms and Conditions ("Terms", "Terms and Conditions") govern your relationship with the ShopEase website and services (the "Service") operated by ShopEase Inc.</p>
                   <p>Please read these Terms and Conditions carefully before using our Service. Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users, and others who access or use the Service.</p>
                   <p>By accessing or using the Service, you agree to be bound by these Terms. If you disagree with any part of the terms, then you may not access the Service.</p>',
                    "ar" => '<p>مرحبًا بكم في ShopEase ("الشركة"، "نحن"، "خاصتنا"، "لنا"). تحكم هذه الشروط والأحكام ("الشروط"، "الشروط والأحكام") علاقتك مع موقع ShopEase والخدمات ("الخدمة") التي تديرها شركة ShopEase Inc.</p>
                   <p>يرجى قراءة هذه الشروط والأحكام بعناية قبل استخدام خدمتنا. يعتمد وصولك إلى الخدمة واستخدامك لها على قبولك لهذه الشروط والامتثال لها. تنطبق هذه الشروط على جميع الزوار والمستخدمين وغيرهم ممن يصلون إلى الخدمة أو يستخدمونها.</p>
                   <p>باستخدامك للخدمة أو الوصول إليها، فإنك توافق على الالتزام بهذه الشروط. إذا كنت لا توافق على أي جزء من الشروط، فلا يجوز لك الوصول إلى الخدمة.</p>',
                ],
            ],
            [
                "title" => [
                    "en" => "2. Purchases",
                    "ar" => "2. المشتريات",
                ],
                "content" => [
                    "en" => '<p>If you wish to purchase any product or service made available through the Service ("Purchase"), you may be asked to supply certain information relevant to your Purchase including, without limitation, your credit card number, the expiration date of your credit card, your billing address, and your shipping information.</p>
                   <p>You represent and warrant that: (i) you have the legal right to use any credit card(s) or other payment method(s) in connection with any Purchase; and that (ii) the information you supply to us is true, correct, and complete.</p>
                   <p>By submitting such information, you grant us the right to provide the information to third parties for purposes of facilitating the completion of Purchases.</p>',
                    "ar" => '<p>إذا كنت ترغب في شراء أي منتج أو خدمة متاحة من خلال الخدمة ("الشراء")، قد يُطلب منك تقديم معلومات معينة ذات صلة بالشراء بما في ذلك، على سبيل المثال لا الحصر، رقم بطاقة الائتمان وتاريخ انتهاء صلاحيتها وعنوان الفواتير ومعلومات الشحن.</p>
                   <p>أنت تعلن وتضمن أن: (1) لديك الحق القانوني في استخدام أي بطاقات ائتمان أو طرق دفع أخرى فيما يتعلق بأي عملية شراء؛ وأن (2) المعلومات التي تقدمها لنا صحيحة ودقيقة وكاملة.</p>
                   <p>بإرسال هذه المعلومات، فإنك تمنحنا الحق في توفير المعلومات لأطراف ثالثة لتسهيل إتمام عمليات الشراء.</p>',
                ],
            ],
            [
                "title" => [
                    "en" => "3. Refunds and Returns",
                    "ar" => "3. الاسترجاع والاسترداد",
                ],
                "content" => [
                    "en" => '<p>We issue refunds for Purchases within 30 days of the original purchase date. To be eligible for a return, your item must be unused and in the same condition that you received it. It must also be in the original packaging.</p>
                   <p>Several types of goods are exempt from being returned. Perishable goods such as food, flowers, newspapers, or magazines cannot be returned. We also do not accept products that are intimate or sanitary goods, hazardous materials, or flammable liquids or gases.</p>
                   <p>To complete your return, we require a receipt or proof of purchase. Please do not send your purchase back to the manufacturer. There are certain situations where only partial refunds are granted (if applicable).</p>',
                    "ar" => '<p>نقوم بإصدار استرداد الأموال للمشتريات خلال 30 يومًا من تاريخ الشراء الأصلي. لكي يكون المنتج مؤهلاً للاسترجاع، يجب أن يكون غير مستخدم وبالحالة نفسها التي استلمته بها. ويجب أن يكون أيضًا في العبوة الأصلية.</p>
                   <p>هناك عدة أنواع من السلع معفاة من الإرجاع. لا يمكن إرجاع السلع القابلة للتلف مثل الطعام والزهور والصحف أو المجلات. كما أننا لا نقبل المنتجات التي تعد من المستلزمات الشخصية أو الصحية أو المواد الخطرة أو السوائل أو الغازات القابلة للاشتعال.</p>
                   <p>لإتمام عملية الاسترجاع، نطلب إيصالًا أو إثباتًا على الشراء. يرجى عدم إرسال مشترياتك إلى الشركة المصنعة. هناك حالات معينة يتم فيها منح استرداد جزئي فقط (إن وجد).</p>',
                ],
            ],
            [
                "title" => [
                    "en" => "4. Intellectual Property",
                    "ar" => "4. الملكية الفكرية",
                ],
                "content" => [
                    "en" => '<p>The Service and its original content, features, and functionality are and will remain the exclusive property of ShopEase Inc. and its licensors. The Service is protected by copyright, trademark, and other laws of both the United States and foreign countries. Our trademarks and trade dress may not be used in connection with any product or service without the prior written consent of ShopEase Inc.</p>
                   <p>All content included on this site, such as text, graphics, logos, button icons, images, audio clips, digital downloads, data compilations, and software, is the property of ShopEase Inc. or its content suppliers and protected by international copyright laws.</p>',
                    "ar" => '<p>الخدمة ومحتواها الأصلي وميزاتها ووظائفها هي وستبقى ملكًا حصريًا لشركة ShopEase Inc. والجهات المرخصة لها. الخدمة محمية بموجب قوانين حقوق النشر والعلامات التجارية وقوانين أخرى في الولايات المتحدة والدول الأجنبية. لا يجوز استخدام علاماتنا التجارية وهوية علامتنا التجارية فيما يتعلق بأي منتج أو خدمة دون موافقة كتابية مسبقة من ShopEase Inc.</p>
                   <p>جميع المحتويات المدرجة في هذا الموقع، مثل النصوص والرسومات والشعارات وأيقونات الأزرار والصور ومقاطع الصوت والتنزيلات الرقمية وتجميعات البيانات والبرامج، هي ملك لشركة ShopEase Inc. أو موردي المحتوى الخاص بها ومحمية بموجب قوانين حقوق النشر الدولية.</p>',
                ],
            ],
            [
                "title" => [
                    "en" => "5. Termination",
                    "ar" => "5. الإنهاء",
                ],
                "content" => [
                    "en" => '<p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>
                   <p>Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service.</p>
                   <p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>',
                    "ar" => '<p>يجوز لنا إنهاء حسابك أو تعليقه فورًا، دون إشعار مسبق أو مسؤولية، لأي سبب كان، بما في ذلك على سبيل المثال لا الحصر إذا انتهكت الشروط.</p>
                   <p>عند الإنهاء، سينتهي حقك في استخدام الخدمة على الفور. إذا كنت ترغب في إنهاء حسابك، يمكنك ببساطة التوقف عن استخدام الخدمة.</p>
                   <p>جميع أحكام الشروط التي يجب أن تبقى سارية بعد الإنهاء بحكم طبيعتها ستبقى سارية، بما في ذلك على سبيل المثال لا الحصر أحكام الملكية وبنود إخلاء المسؤولية والتعويض والحد من المسؤولية.</p>',
                ],
            ],
            [
                "title" => [
                    "en" => "Contact Information",
                    "ar" => "معلومات الاتصال",
                ],
                "content" => [
                    "en" =>
                        "<p>If you have any questions about these Terms, please contact us at support@shopease.example.com</p>",
                    "ar" =>
                        "<p>إذا كان لديك أي أسئلة حول هذه الشروط، يرجى الاتصال بنا على support@shopease.example.com</p>",
                ],
            ],
        ];

        Term::query()->delete();

        foreach ($termsAndConditions as $term) {
            Term::create([...$term, "is_active" => true]);
        }
    }
}
