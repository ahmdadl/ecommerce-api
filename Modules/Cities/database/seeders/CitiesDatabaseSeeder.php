<?php

namespace Modules\Cities\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cities\Models\City;
use Modules\Governments\Models\Government;

class CitiesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citiesByGovernorate = [
            "Alexandria" => [
                ["en" => "Alexandria", "ar" => "الإسكندرية"],
                ["en" => "Borg El Arab", "ar" => "برج العرب"],
                ["en" => "Montaza", "ar" => "المنتزه"],
                ["en" => "El Amreya", "ar" => "العامرية"],
                ["en" => "Agami", "ar" => "العجمي"],
            ],
            "Aswan" => [
                ["en" => "Aswan", "ar" => "أسوان"],
                ["en" => "Kom Ombo", "ar" => "كوم أمبو"],
                ["en" => "Edfu", "ar" => "إدفو"],
                ["en" => "Abu Simbel", "ar" => "أبو سمبل"],
                ["en" => "Daraw", "ar" => "دراو"],
            ],
            "Asyut" => [
                ["en" => "Asyut", "ar" => "أسيوط"],
                ["en" => "Abnub", "ar" => "أبنوب"],
                ["en" => "Manfalut", "ar" => "منفلوط"],
                ["en" => "Dairut", "ar" => "ديروط"],
                ["en" => "El Qusiya", "ar" => "القوصية"],
            ],
            "Beheira" => [
                ["en" => "Damanhur", "ar" => "دمنهور"],
                ["en" => "Kafr El Dawwar", "ar" => "كفر الدوار"],
                ["en" => "Rosetta", "ar" => "رشيد"],
                ["en" => "Edku", "ar" => "إدكو"],
                ["en" => "Abu Hummus", "ar" => "أبو حمص"],
                ["en" => "Hosh Issa", "ar" => "حوش عيسى"],
            ],
            "Beni Suef" => [
                ["en" => "Beni Suef", "ar" => "بني سويف"],
                ["en" => "El Wasta", "ar" => "الواسطى"],
                ["en" => "Nasser", "ar" => "ناصر"],
                ["en" => "Beba", "ar" => "ببا"],
                ["en" => "Fashn", "ar" => "الفشن"],
            ],
            "Cairo" => [
                ["en" => "Cairo", "ar" => "القاهرة"],
                ["en" => "Nasr City", "ar" => "مدينة نصر"],
                ["en" => "Heliopolis", "ar" => "مصر الجديدة"],
                ["en" => "Maadi", "ar" => "المعادي"],
            ],
            "Dakahlia" => [
                ["en" => "Mansoura", "ar" => "المنصورة"],
                ["en" => "Mit Ghamr", "ar" => "ميت غمر"],
                ["en" => "Talkha", "ar" => "طلخا"],
                ["en" => "Belqas", "ar" => "بلقاس"],
                ["en" => "Sherbin", "ar" => "شربين"],
                ["en" => "Dikirnis", "ar" => "دكرنس"],
            ],
            "Damietta" => [
                ["en" => "Damietta", "ar" => "دمياط"],
                ["en" => "Ras El Bar", "ar" => "رأس البر"],
                ["en" => "Faraskur", "ar" => "فارسكور"],
                ["en" => "Kafr Saad", "ar" => "كفر سعد"],
                ["en" => "Zarqa", "ar" => "الزرقا"],
            ],
            "Faiyum" => [
                ["en" => "Faiyum", "ar" => "الفيوم"],
                ["en" => "Sinnuris", "ar" => "سنورس"],
                ["en" => "Ibshway", "ar" => "إبشواي"],
                ["en" => "Tamiya", "ar" => "طامية"],
                ["en" => "Yusuf El Siddiq", "ar" => "يوسف الصديق"],
            ],
            "Gharbia" => [
                ["en" => "Tanta", "ar" => "طنطا"],
                ["en" => "Mahalla El Kubra", "ar" => "المحلة الكبرى"],
                ["en" => "Zefta", "ar" => "زفتى"],
                ["en" => "Kafr El Zayat", "ar" => "كفر الزيات"],
                ["en" => "Samanoud", "ar" => "سمنود"],
            ],
            "Giza" => [
                ["en" => "Giza", "ar" => "الجيزة"],
                [
                    "en" => "6th of October City",
                    "ar" => "مدينة السادس من أكتوبر",
                ],
                ["en" => "Sheikh Zayed City", "ar" => "مدينة الشيخ زايد"],
                ["en" => "Imbaba", "ar" => "إمبابة"],
                ["en" => "El Hawamdeya", "ar" => "الحوامدية"],
            ],
            "Ismailia" => [
                ["en" => "Ismailia", "ar" => "الإسماعيلية"],
                ["en" => "Fayed", "ar" => "الفايد"],
                ["en" => "Qantara Sharq", "ar" => "القنطرة شرق"],
                ["en" => "Qantara Gharb", "ar" => "القنطرة غرب"],
                ["en" => "Tell El Kebir", "ar" => "تل الكبير"],
            ],
            "Kafr El Sheikh" => [
                ["en" => "Kafr El Sheikh", "ar" => "كفر الشيخ"],
                ["en" => "Desouk", "ar" => "دسوق"],
                ["en" => "Baltim", "ar" => "بلطيم"],
                ["en" => "Fuwah", "ar" => "فوه"],
                ["en" => "Metoubes", "ar" => "مطوبس"],
            ],
            "Luxor" => [
                ["en" => "Luxor", "ar" => "الأقصر"],
                ["en" => "Esna", "ar" => "إسنا"],
                ["en" => "Armant", "ar" => "أرمنت"],
                ["en" => "El Tod", "ar" => "الطود"],
                ["en" => "Qurna", "ar" => "القرنة"],
            ],
            "Matruh" => [
                ["en" => "Marsa Matruh", "ar" => "مرسى مطروح"],
                ["en" => "Siwa", "ar" => "سيوة"],
                ["en" => "El Alamein", "ar" => "العلمين"],
                ["en" => "Sallum", "ar" => "سلوم"],
                ["en" => "Dabaa", "ar" => "الضبعة"],
            ],
            "Minya" => [
                ["en" => "Minya", "ar" => "المنيا"],
                ["en" => "Mallawi", "ar" => "ملوي"],
                ["en" => "Samalut", "ar" => "سمالوط"],
                ["en" => "Maghaghah", "ar" => "مغاغة"],
                ["en" => "Beni Mazar", "ar" => "بني مزار"],
            ],
            "Monufia" => [
                ["en" => "Shibin El Kom", "ar" => "شبين الكوم"],
                ["en" => "Menouf", "ar" => "منوف"],
                ["en" => "Ashmoun", "ar" => "أشمون"],
                ["en" => "Sadat City", "ar" => "مدينة السادات"],
                ["en" => "Quesna", "ar" => "قويسنا"],
            ],
            "New Valley" => [
                ["en" => "Kharga", "ar" => "الخارجة"],
                ["en" => "Dakhla", "ar" => "الداخلة"],
                ["en" => "Farafra", "ar" => "الفرافرة"],
                ["en" => "Baris", "ar" => "باريس"],
                ["en" => "Mut", "ar" => "موط"],
            ],
            "North Sinai" => [
                ["en" => "Arish", "ar" => "العريش"],
                ["en" => "Sheikh Zuweid", "ar" => "الشيخ زويد"],
                ["en" => "Rafah", "ar" => "رفح"],
                ["en" => "Bir al-Abed", "ar" => "بئر العبد"],
                ["en" => "Hassana", "ar" => "الحسنة"],
            ],
            "Port Said" => [
                ["en" => "Port Said", "ar" => "بورسعيد"],
                ["en" => "Port Fouad", "ar" => "بور فؤاد"],
                ["en" => "El Manakh", "ar" => "المناخ"],
            ],
            "Qalyubia" => [
                ["en" => "Banha", "ar" => "بنها"],
                ["en" => "Qalyub", "ar" => "قليوب"],
                ["en" => "Shubra El Kheima", "ar" => "شبرا الخيمة"],
                ["en" => "Khanka", "ar" => "الخانكة"],
                ["en" => "Kafr Shukr", "ar" => "كفر شكر"],
            ],
            "Qena" => [
                ["en" => "Qena", "ar" => "قنا"],
                ["en" => "Nag Hammadi", "ar" => "نجع حمادي"],
                ["en" => "Dishna", "ar" => "دشنا"],
                ["en" => "Farshut", "ar" => "فرشوط"],
                ["en" => "Qift", "ar" => "قفط"],
            ],
            "Red Sea" => [
                ["en" => "Hurghada", "ar" => "الغردقة"],
                ["en" => "Safaga", "ar" => "سفاجا"],
                ["en" => "Marsa Alam", "ar" => "مرسى علم"],
                ["en" => "Ras Gharib", "ar" => "رأس غارب"],
                ["en" => "El Quseir", "ar" => "القصير"],
            ],
            "Sharhasia" => [
                ["en" => "Zagazig", "ar" => "الزقازيق"],
                [
                    "en" => "10th of Ramadan City",
                    "ar" => "مدينة العاشر من رمضان",
                ],
                ["en" => "Bilbeis", "ar" => "بلبيس"],
                ["en" => "Abu Hammad", "ar" => "أبو حماد"],
                ["en" => "Minya El Qamh", "ar" => "منيا القمح"],
                ["en" => "Faqous", "ar" => "فاقوس"],
            ],
            "Sohag" => [
                ["en" => "Sohag", "ar" => "سوهاج"],
                ["en" => "Girga", "ar" => "جرجا"],
                ["en" => "Akhmim", "ar" => "أخميم"],
                ["en" => "Tahta", "ar" => "طهطا"],
                ["en" => "Maragha", "ar" => "مراغة"],
            ],
            "South Sinai" => [
                ["en" => "El Tor", "ar" => "الطور"],
                ["en" => "Sharm El Sheikh", "ar" => "شرم الشيخ"],
                ["en" => "Dahab", "ar" => "دهب"],
                ["en" => "Nuweiba", "ar" => "نويبع"],
                ["en" => "Taba", "ar" => "طابا"],
            ],
            "Suez" => [
                ["en" => "Suez", "ar" => "السويس"],
                ["en" => "Ataqa", "ar" => "عطاقة"],
                ["en" => "Faisal", "ar" => "فيصل"],
            ],
        ];

        City::query()->delete();

        foreach ($citiesByGovernorate as $governorate => $cities) {
            foreach ($cities as $city) {
                $government = Government::where(
                    "title->en",
                    $governorate
                )->first();
                if ($government) {
                    City::create([
                        "title" => $city,
                        "government_id" => $government->id,
                    ]);
                }
            }
        }
    }
}
