<?php

namespace Modules\PrivacyPolicies\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PrivacyPolicies\Models\PrivacyPolicy;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $privacySections = [
            [
                "title" => [
                    "en" => "Personal Information",
                    "ar" => "المعلومات الشخصية",
                ],
                "content" => [
                    "en" => '<p>We may collect personal information that you voluntarily provide to us when you:</p>
                   <ul>
                     <li>Register on our website</li>
                     <li>Place an order</li>
                     <li>Subscribe to our newsletter</li>
                     <li>Participate in contests, surveys, or promotions</li>
                     <li>Contact our customer service team</li>
                   </ul>
                   <p>This information may include your name, email address, postal address, phone number, and payment information.</p>',
                    "ar" => '<p>قد نجمع المعلومات الشخصية التي تقدمها لنا طواعية عندما:</p>
                   <ul>
                     <li>تسجل في موقعنا الإلكتروني</li>
                     <li>تقدم طلب شراء</li>
                     <li>تشترك في نشرتنا البريدية</li>
                     <li>تشارك في المسابقات أو الاستطلاعات أو العروض الترويجية</li>
                     <li>تتواصل مع فريق خدمة العملاء لدينا</li>
                   </ul>
                   <p>قد تتضمن هذه المعلومات اسمك وعنوان بريدك الإلكتروني وعنوانك البريدي ورقم هاتفك ومعلومات الدفع.</p>',
                ],
            ],
            [
                "title" => [
                    "en" => "Automatically Collected Information",
                    "ar" => "المعلومات التي يتم جمعها تلقائياً",
                ],
                "content" => [
                    "en" => '<p>When you visit our website, our servers may automatically log standard data provided by your web browser. This may include your device\'s IP address, browser type and version, pages you visit, time and date of your visit, time spent on each page, and other details about your visit.</p>
                   <p>Additionally, if you use our website, we may collect information about your device including the type of device, unique device ID, operating system, and mobile network information.</p>',
                    "ar" => '<p>عند زيارتك لموقعنا الإلكتروني، قد يقوم خوادمنا تلقائياً بتسجيل البيانات القياسية التي يوفرها متصفح الويب الخاص بك. قد يشمل ذلك عنوان IP لجهازك ونوع المتصفح وإصداره والصفحات التي تزورها ووقت وتاريخ زيارتك والوقت الذي تقضيه في كل صفحة وتفاصيل أخرى عن زيارتك.</p>
                   <p>بالإضافة إلى ذلك، إذا كنت تستخدم موقعنا الإلكتروني، فقد نجمع معلومات عن جهازك بما في ذلك نوع الجهاز ومعرف الجهاز الفريد ونظام التشغيل ومعلومات شبكة الجوال.</p>',
                ],
            ],
            [
                "title" => [
                    "en" => "How We Use Your Information",
                    "ar" => "كيف نستخدم معلوماتك",
                ],
                "content" => [
                    "en" => '<p>We use the information we collect for various business purposes, including:</p>
                   <ul>
                     <li>To provide and maintain our services</li>
                     <li>To process and fulfill your orders</li>
                     <li>To send you order confirmations and updates</li>
                     <li>To provide customer support</li>
                     <li>To communicate with you about products, services, promotions, and events</li>
                     <li>To personalize your experience and deliver content relevant to your interests</li>
                     <li>To improve our website and services</li>
                     <li>To detect, prevent, and address technical issues or fraudulent activities</li>
                   </ul>',
                    "ar" => '<p>نستخدم المعلومات التي نجمعها لأغراض تجارية مختلفة، بما في ذلك:</p>
                   <ul>
                     <li>تقديم خدماتنا والحفاظ عليها</li>
                     <li>معالجة طلباتك وإتمامها</li>
                     <li>إرسال تأكيدات الطلبات والتحديثات لك</li>
                     <li>تقديم دعم العملاء</li>
                     <li>التواصل معك حول المنتجات والخدمات والعروض الترويجية والفعاليات</li>
                     <li>تخصيص تجربتك وتقديم محتوى ذو صلة باهتماماتك</li>
                     <li>تحسين موقعنا الإلكتروني وخدماتنا</li>
                     <li>الكشف عن المشكلات الفنية أو الأنشطة الاحتيالية ومنعها ومعالجتها</li>
                   </ul>',
                ],
            ],
            [
                "title" => [
                    "en" => "Cookies and Tracking Technologies",
                    "ar" => "ملفات تعريف الارتباط وتقنيات التتبع",
                ],
                "content" => [
                    "en" => '<p>We use cookies and similar tracking technologies to track activity on our website and store certain information. Cookies are files with a small amount of data which may include an anonymous unique identifier.</p>
                   <p>You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our website.</p>
                   <p>We use the following types of cookies:</p>
                   <ul>
                     <li>Essential cookies: Necessary for the website to function properly</li>
                     <li>Preference cookies: Enable the website to remember your preferences</li>
                     <li>Analytics cookies: Help us understand how visitors interact with our website</li>
                     <li>Marketing cookies: Used to track visitors across websites to display relevant advertisements</li>
                   </ul>',
                    "ar" => '<p>نستخدم ملفات تعريف الارتباط وتقنيات التتبع المماثلة لتتبع النشاط على موقعنا الإلكتروني وتخزين معلومات معينة. ملفات تعريف الارتباط هي ملفات تحتوي على كمية صغيرة من البيانات التي قد تتضمن معرّفاً فريداً مجهولاً.</p>
                   <p>يمكنك توجيه متصفحك لرفض جميع ملفات تعريف الارتباط أو للإشارة عند إرسال ملف تعريف الارتباط. ومع ذلك، إذا لم تقبل ملفات تعريف الارتباط، فقد لا تتمكن من استخدام بعض أجزاء موقعنا الإلكتروني.</p>
                   <p>نستخدم أنواع ملفات تعريف الارتباط التالية:</p>
                   <ul>
                     <li>ملفات تعريف الارتباط الأساسية: ضرورية لكي يعمل الموقع الإلكتروني بشكل صحيح</li>
                     <li>ملفات تعريف الارتباط التفضيلية: تمكن الموقع الإلكتروني من تذكر تفضيلاتك</li>
                     <li>ملفات تعريف الارتباط التحليلية: تساعدنا على فهم كيفية تفاعل الزوار مع موقعنا الإلكتروني</li>
                     <li>ملفات تعريف الارتباط التسويقية: تُستخدم لتتبع الزوار عبر المواقع لعرض إعلانات ذات صلة</li>
                   </ul>',
                ],
            ],
            [
                "title" => [
                    "en" => "Third-Party Disclosure",
                    "ar" => "الإفصاح لأطراف ثالثة",
                ],
                "content" => [
                    "en" => '<p>We may share your information with third parties in certain situations, including:</p>
                   <ul>
                     <li>Business Partners: We may share your information with our business partners to offer you certain products, services, or promotions.</li>
                     <li>Service Providers: We may share your information with third-party vendors, service providers, contractors, or agents who perform services for us or on our behalf.</li>
                     <li>Legal Requirements: We may disclose your information where required to do so by law or in response to valid requests by public authorities.</li>
                     <li>Business Transfers: We may share or transfer your information in connection with, or during negotiations of, any merger, sale of company assets, financing, or acquisition of all or a portion of our business.</li>
                   </ul>',
                    "ar" => '<p>قد نشارك معلوماتك مع أطراف ثالثة في حالات معينة، بما في ذلك:</p>
                   <ul>
                     <li>الشركاء التجاريون: قد نشارك معلوماتك مع شركائنا التجاريين لتقديم منتجات أو خدمات أو عروض ترويجية معينة لك.</li>
                     <li>مقدمو الخدمات: قد نشارك معلوماتك مع بائعي الجهات الخارجية أو مقدمي الخدمات أو المقاولين أو الوكلاء الذين يؤدون خدمات لنا أو نيابة عنا.</li>
                     <li>المتطلبات القانونية: قد نكشف عن معلوماتك عندما يقتضي القانون ذلك أو استجابة لطلبات صالحة من السلطات العامة.</li>
                     <li>عمليات نقل الأعمال: قد نشارك أو ننقل معلوماتك فيما يتعلق بأي اندماج أو بيع لأصول الشركة أو تمويل أو استحواذ على كل أو جزء من أعمالنا أو خلال مفاوضات حول ذلك.</li>
                   </ul>',
                ],
            ],
            [
                "title" => [
                    "en" => "Your Rights",
                    "ar" => "حقوقك",
                ],
                "content" => [
                    "en" => '<p>Depending on your location, you may have certain rights regarding your personal information, including:</p>
                   <ul>
                     <li>The right to access the personal information we have about you</li>
                     <li>The right to request correction of inaccurate personal information</li>
                     <li>The right to request deletion of your personal information</li>
                     <li>The right to object to processing of your personal information</li>
                     <li>The right to data portability</li>
                     <li>The right to withdraw consent</li>
                   </ul>
                   <p>To exercise these rights, please contact us using the information provided in the "Contact Us" section below.</p>',
                    "ar" => '<p>اعتماداً على موقعك، قد يكون لديك حقوق معينة فيما يتعلق بمعلوماتك الشخصية، بما في ذلك:</p>
                   <ul>
                     <li>الحق في الوصول إلى المعلومات الشخصية التي لدينا عنك</li>
                     <li>الحق في طلب تصحيح المعلومات الشخصية غير الدقيقة</li>
                     <li>الحق في طلب حذف معلوماتك الشخصية</li>
                     <li>الحق في الاعتراض على معالجة معلوماتك الشخصية</li>
                     <li>الحق في قابلية نقل البيانات</li>
                     <li>الحق في سحب الموافقة</li>
                   </ul>
                   <p>لممارسة هذه الحقوق، يرجى الاتصال بنا باستخدام المعلومات المقدمة في قسم "اتصل بنا" أدناه.</p>',
                ],
            ],
            [
                "title" => [
                    "en" => "Data Security",
                    "ar" => "أمن البيانات",
                ],
                "content" => [
                    "en" =>
                        "<p>We have implemented appropriate technical and organizational security measures designed to protect the security of any personal information we process. However, please also remember that we cannot guarantee that the internet itself is 100% secure.</p>",
                    "ar" =>
                        "<p>لقد قمنا بتنفيذ تدابير أمنية فنية وتنظيمية مناسبة مصممة لحماية أمان أي معلومات شخصية نقوم بمعالجتها. ومع ذلك، يرجى تذكر أننا لا نستطيع ضمان أن الإنترنت نفسه آمن بنسبة 100٪.</p>",
                ],
            ],
            [
                "title" => [
                    "en" => 'Children\'s Privacy',
                    "ar" => "خصوصية الأطفال",
                ],
                "content" => [
                    "en" =>
                        "<p>Our website is not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact us.</p>",
                    "ar" =>
                        "<p>موقعنا الإلكتروني غير مخصص للأطفال دون سن 13 عاماً. نحن لا نجمع معلومات شخصية من الأطفال دون سن 13 عاماً عن علم. إذا كنت والداً أو وصياً وأدركت أن طفلك قد زودنا بمعلومات شخصية، يرجى الاتصال بنا.</p>",
                ],
            ],
            [
                "title" => [
                    "en" => "Changes to This Privacy Policy",
                    "ar" => "تغييرات على سياسة الخصوصية هذه",
                ],
                "content" => [
                    "en" => '<p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date at the top of this Privacy Policy.</p>
                   <p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>',
                    "ar" => '<p>قد نقوم بتحديث سياسة الخصوصية الخاصة بنا من وقت لآخر. سنخطرك بأي تغييرات عن طريق نشر سياسة الخصوصية الجديدة على هذه الصفحة وتحديث تاريخ "آخر تحديث" في أعلى سياسة الخصوصية هذه.</p>
                   <p>ينصح بمراجعة سياسة الخصوصية هذه بشكل دوري لأي تغييرات. تصبح التغييرات التي تطرأ على سياسة الخصوصية هذه سارية عند نشرها على هذه الصفحة.</p>',
                ],
            ],
            [
                "title" => [
                    "en" => "Contact Us",
                    "ar" => "اتصل بنا",
                ],
                "content" => [
                    "en" => '<p>If you have any questions about this Privacy Policy, please contact us:</p>
                   <ul>
                     <li>By email: privacy@stylehub.example.com</li>
                     <li>By phone: +1 (555) 123-4567</li>
                     <li>By mail: StyleHub Inc., 123 Fashion Street, Suite 100, New York, NY 10001</li>
                   </ul>',
                    "ar" => '<p>إذا كان لديك أي أسئلة حول سياسة الخصوصية هذه، يرجى الاتصال بنا:</p>
                   <ul>
                     <li>عبر البريد الإلكتروني: privacy@stylehub.example.com</li>
                     <li>عبر الهاتف: 1 (555) 123-4567+</li>
                     <li>عبر البريد: StyleHub Inc.، 123 شارع الموضة، جناح 100، نيويورك، نيويورك 10001</li>
                   </ul>',
                ],
            ],
        ];

        PrivacyPolicy::query()->delete();

        foreach ($privacySections as $privacyPolicy) {
            PrivacyPolicy::create([...$privacyPolicy, "is_active" => true]);
        }
    }
}
