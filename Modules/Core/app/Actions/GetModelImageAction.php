<?php

namespace Modules\Core\Actions;

final class GetModelImageAction
{
    public static function forCategory(string $title): string
    {
        return self::categoryImages()[$title] ?? "";
    }

    public static function forBrand(string $title): string
    {
        return self::brandImages()[$title] ?? "";
    }

    public static function forProduct(string $title): array
    {
        return self::productImages()[$title] ?? [];
    }

    public static function forBanner(string $title): string
    {
        return self::bannerImages()[$title] ?? "";
    }

    private static function categoryImages(): array
    {
        return [
            "Smartphones" =>
                "https://images.ctfassets.net/wcfotm6rrl7u/2sDJE99xaUTEDxrkiopmtK/a904ab61ba56ccee349cf4f95c1eef40/HMD_Smartphones-Catalogue-OG_Image.jpg",
            "Tablets" =>
                "https://static.independent.co.uk/2024/11/01/16/best-tablets-1-november-2024.jpg?width=1200&height=630&fit=crop",
            "Smart Watches" =>
                "https://istarmax.com/wp-content/uploads/2024/04/Starmax-Product-Range-Summer-2024-2.png",
            "Portable Audio" =>
                "https://s.yimg.com/ny/api/res/1.2/UdtLQ36tLxdqT9zor6D8yQ--/YXBwaWQ9aGlnaGxhbmRlcjt3PTY0MDtoPTMyMA--/https://o.aolcdn.com/hss/storage/midas/26d0c8bcee1fa2a6e3549a99653e6e11/202425263/080415-audio-1200.jpg",
            "Mobile Accessories" => "https://tv-it.com/storage/mobility.jpg",
            "Tablet Accessories" =>
                "https://southport.in/cdn/shop/files/samsung-india-electronics-acc-gray-samsung-galaxy-tab-s6-book-cover-keyboard-with-trackpad-ej-dt860ujeg-8806090163739-40927033852163.jpg?v=1687865671",
        ];
    }

    private static function brandImages(): array
    {
        return [
            "Apple" =>
                "https://logo.com/image-cdn/images/kts928pd/production/4429bc095f6ddb190c0457f215d2d625959aae87-1600x900.png?w=1920&q=72&fm=webp",
            "Samsung" =>
                "https://download.logo.wine/logo/Samsung/Samsung-Logo.wine.png",
            "Huawei" =>
                "https://toppng.com/uploads/preview/huawei-logo-png-2454x800-11735760101u3eucateaa.webp",
            "Honor" =>
                "https://logowik.com/content/uploads/images/honor7358.logowik.com.webp",
            "Xiaomi" =>
                "https://logowik.com/content/uploads/images/xiaomi-2021-new4988.jpg",
            "Motorola" =>
                "https://download.logo.wine/logo/Motorola_Mobility/Motorola_Mobility-Logo.wine.png",
            "Tecno" =>
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQnQrloETz2rwO4TZm6uFmHPzXVi8GfdpQmAw&s",
        ];
    }

    private static function productImages(): array
    {
        return [
            "iPhone 16 Pro" => [
                "https://www.apple.com/newsroom/images/2024/09/apple-debuts-iphone-16-pro-and-iphone-16-pro-max/article/Apple-iPhone-16-Pro-hero-geo-240909_inline.jpg.large.jpg", //
                "https://m.media-amazon.com/images/I/617ZhMUCvIL._AC_UF894,1000_QL80_.jpg", //
                "https://www.apple.com/newsroom/images/2024/09/apple-debuts-iphone-16-pro-and-iphone-16-pro-max/article/Apple-iPhone-16-Pro-finish-lineup-240909_big.jpg.large.jpg", //
            ],
            "iPhone 16" => [
                "https://m.media-amazon.com/images/I/713SsA7gftL.jpg", //
                "https://m.media-amazon.com/images/I/617ZhMUCvIL._AC_UF894,1000_QL80_.jpg", //
                "https://www.apple.com/newsroom/images/2024/09/apple-debuts-iphone-16-pro-and-iphone-16-pro-max/article/Apple-iPhone-16-Pro-finish-lineup-240909_big.jpg.large.jpg", //
            ],
            "Galaxy Z Fold 6" => [
                "https://images.samsung.com/eg/smartphones/galaxy-z-fold6/buy/kv_global_MO_v3.jpg?imbypass=true", //
                "https://m.media-amazon.com/images/I/61896OtgvGL._AC_SL1500_.jpg", //
                "https://smartkoshk.com/cdn/shop/files/Galaxy-Z-Fold-6-Egypt-1.png?v=1727721250&width=1946", //
            ],
            "Galaxy S25 Ultra" => [
                "https://smartkoshk.com/cdn/shop/files/Galaxy-S25-Ultra.png?v=1740496427", //
                "https://media.assettype.com/thenewsminute/2024-09-30/e3suii7y/3hdr.png?w=1200&h=675&auto=format%2Ccompress&fit=max&enlarge=true", //
                "https://images.samsung.com/eg/smartphones/galaxy-s25-ultra/images/galaxy-s25-ultra-features-one-ui-visual-mo.jpg?imbypass=true", //
            ],
            "Galaxy A56" => [
                "https://m.media-amazon.com/images/I/51pziIc-xnL.jpg", //
                'https://images.samsung.com/is/image/samsung/p6pim/eg/feature/165977027/eg-feature-fresh-new-look-545652363?$FB_TYPE_A_MO_JPG$', //
                "https://i.ytimg.com/vi/-oSgESecpTw/sddefault.jpg", //
            ],
            "Mate 60 Pro" => [
                "https://m.media-amazon.com/images/I/7195XFw5j+L._AC_SL1500_.jpg", //
                "https://cdn.kalvo.com/uploads/img/gallery/54877-huawei-mate-60-pro-7.jpg", //
            ],
            "Pura 70" => [
                "https://m.media-amazon.com/images/I/51J-nlpO+aL.jpg", //
                "https://www.smcyberzone.com/_ipx/f_webp/https://www.smcyberzone.com/app/uploads/2024/05/CYBERZONE-WEBSITE-UPLOAD-1080-%C3%97-1080-px-2024-05-23T151431.923.png", //
                "https://www.vopmart.com/media/catalog/product/cache/ee14c5ab36c97d39d331f867fa3bee63/h/b/hbn-al00.jpg", //
            ],
            "Magic 6 Pro" => [
                "https://cdn.sheeel.com/catalog/product/cache/074f467fdf747a38ab5e8f88243fd86f/v/r/vrtl10385.jpg", //
                "https://images-cdn.ubuy.com.eg/675e4cd59842bb4fa47dfc99-honor-magic-6-pro-16gb-1tb-snapdragon-8.jpg", //
            ],
            "X7c" => [
                "https://2b.com.eg/media/catalog/product/cache/661473ab953cdcdf4c3b607144109b90/h/o/honor-x7c-white-1.jpg", //
                "https://dream.ps/wp-content/uploads/2024/11/honor-x7c-3.png", //
            ],
            "Xiaomi 15 Ultra" => [
                "https://i02.appmifile.com/869_operator_sg/19/02/2025/8ef3aa5e5645d64a9e182ecc84e8d365.png", //
                "https://telfonak.com/wp-content/uploads/2025/03/xiaomi15-ultra.webp", //
            ],
            "Redmi Note 13" => [
                "https://m.media-amazon.com/images/I/51xTkm8N0fL.jpg", //
                "https://tv-it.com/storage/shada/mobiles/note-13-black-p1.webp", //
                "https://m.media-amazon.com/images/I/61vFWIksgcL._AC_SL1500_.jpg", //
            ],
            "Edge 50 Neo" => [
                "https://rukminim3.flixcart.com/image/850/1000/xif0q/mobile/c/q/s/edge-50-neo-pb330006in-motorola-original-imah4pxa4szzfgsv.jpeg?q=90&crop=false", //
                "https://cdn.kalvo.com/uploads/img/gallery/64351-motorola-edge-50-neo-4.jpg", //
            ],
            "Moto G15" => [
                "https://qaranphone.com/wp-content/uploads/2024/12/Motorola-Moto-G15.webp", //
                "https://cdn.kalvo.com/uploads/img/gallery/67625-motorola-moto-g15-3.jpg", //
            ],
            "Camon 40" => [
                "https://qaranphone.com/wp-content/uploads/2025/03/Tecno-Camon-40-Pro-4G.jpg", //
                "https://qaranphone.com/wp-content/uploads/2025/03/Tecno-Camon-40.jpg", //
            ],
            "Spark 20" => [
                "https://f.nooncdn.com/p/pnsku/N70036172V/45/_/1704804290/6c4e853c-cfab-4052-a60c-2cfd9c3cf956.jpg?width=800", //
                "https://f.nooncdn.com/p/pnsku/N70023997V/45/_/1703771466/db1f1671-d87f-47b8-8de3-d00f762c1ec6.jpg?width=800", //
            ],
            "iPhone 15 Pro Max" => [
                "https://www.apple.com/newsroom/images/2023/09/apple-unveils-iphone-15-pro-and-iphone-15-pro-max/tile/Apple-iPhone-15-Pro-lineup-hero-230912.jpg.news_app_ed.jpg",
                "https://btech.com/media/catalog/product/cache/c64e2f67722328f4d4a2e547df543b2f/i/p/iphone-15-pro-blue_titanium_5.jpg",
            ],
            "iPad Pro 13-inch" => [
                "https://m.media-amazon.com/images/I/71WDvFBhtdL._AC_UF894,1000_QL80_.jpg",
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT9NleLUqxgo5o_X7G8wn1Wv8HMceIpg5p2GQ&s",
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT62Hm0apIxh8EwHhr48dc1TvuqyeeLXWH3_g&s",
            ],
            "iPad Air 11-inch" => [
                "https://m.media-amazon.com/images/I/71qTQTXYy5L.jpg",
                "https://m.media-amazon.com/images/I/71TIfKvgG3L._UF894,1000_QL80_.jpg",
            ],
            "Apple Watch Series 10" => [
                "https://m.media-amazon.com/images/I/818YeN6qoQL._AC_UF894,1000_QL80_DpWeblab_.jpg",
                "https://m.media-amazon.com/images/I/61ywb9wya9L._UF894,1000_QL80_.jpg",
            ],
            "Apple Watch Ultra 2" => [
                "https://cdsassets.apple.com/live/7WUAS350/images/tech-specs/111832-watch-ultra-2.png",
                "https://m.media-amazon.com/images/I/81+Gh+vFd1L.jpg",
            ],
            "Galaxy Watch 6 Classic" => [
                "https://m.media-amazon.com/images/I/61d3qY2J1AL.jpg",
                "https://m.media-amazon.com/images/I/81Dm65eja8L.jpg",
            ],
            "Galaxy Watch 7" => [
                "https://m.media-amazon.com/images/I/81Dm65eja8L.jpg",
                "https://m.media-amazon.com/images/I/61d3qY2J1AL.jpg",
            ],
            "AirPods Pro 2" => [
                "https://2b.com.eg/media/catalog/product/cache/661473ab953cdcdf4c3b607144109b90/h/p/hp630-min.jpg",
                "https://m.media-amazon.com/images/I/61s5nQASNkL._UF894,1000_QL80_.jpg",
            ],
            "AirPods 4" => [
                "https://m.media-amazon.com/images/I/61s5nQASNkL._UF894,1000_QL80_.jpg",
                "https://2b.com.eg/media/catalog/product/cache/661473ab953cdcdf4c3b607144109b90/h/p/hp630-min.jpg",
            ],
        ];
    }

    private static function bannerImages(): array
    {
        return [
            "Discover the Latest Smartphones" =>
                "https://static0.howtogeekimages.com/wordpress/wp-content/uploads/2024/08/phone-colors.jpg",
            "Unleash Your Mobile Experience" =>
                "https://phonecorridor.com/wp-content/uploads/Best-Phones-to-Buy-Under-500K-to-800k.jpg",
            "Stay Connected with Top Brands" =>
                "https://s.yimg.com/ny/api/res/1.2/DZg9.ESiyjasLRi1nRjRBA--/YXBwaWQ9aGlnaGxhbmRlcjt3PTEyMDA7aD02NzU-/https://media.zenfs.com/en/android_police_756/b3218d6583aeb737479af3037a7da40f",
        ];
    }
}
