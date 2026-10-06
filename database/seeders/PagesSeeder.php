<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{   
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // English Data
        $title_en = [
        "Creating Websites for small and big businesses",
        "About US",
        "We provide the best Web solutions",
        "Our latest Portfolio for your choice",
        "How it works",
        "Know more about our web solutions",
        "We have professional skilled",
        "Expert Team",
        "Contact",
        "We are here to answer your questions 24/7"
    ];

        $subtitle_en = [
        "Best Web Solutions",
        "We are a web development company.",
        null,
        "Portfolio Templates",
        "Work Process",
        "Questions that may come to your mind",
        "Professional Skill",
        "Meet with our expert",
        "Get in touch",
        "Need for it solution services" ];

        $description_en = [
        "<p>We are experienced in creating websites that can serve your business and meet all your requirements</p>",

        "<p>Welcome to Blanko Tech, a leading web development company committed to delivering exceptional digital experiences. With a passion for creativity and technical expertise, we specialize in crafting custom web solutions that help businesses thrive in the digital world. At Blanko Tech, we understand the power of a well-designed website. It serves as the digital storefront for your brand, connecting you with your target audience and driving growth. Our team of skilled web developers, designers, and digital strategists work collaboratively to create engaging, user-centric websites that leave a lasting impression.</p>",
        
        "<p>We offer a comprehensive range of web development services to help businesses   establish a strong online presence and achieve their digital goals. With a team of highly skilled professionals, we combine creativity, technical expertise, and industry best practices to deliver exceptional web solutions. Here are some of the services we provide</p>",
        
        "<p>We take great pride in the diverse range of projects we have successfully delivered for our clients. Our portfolio showcases our expertise in web development, design, and digital solutions. Here are a few highlights</p>",

        "<p>Our work process is designed to keep our clients involved, informed, and satisfied throughout each stage of the project. Here's an overview of our work process</p>",

        "<p>If you have more questions, We're here to help! Feel free to contact us, and our team will be happy to provide you with further information and address any specific concerns you may have</p>",

        null,

        "<p>we have assembled a team of highly skilled and passionate professionals who are dedicated to delivering exceptional web development solutions</p>",

        "<p>We value open and transparent communication with our clients. Whether you have a question, a project idea, or simply want to learn more about our web development services, our team is here to assist you</p>",

        "<p>Dcidunt eget semper nec quam. Sed hendrerit. acfelis Nunc egestas augue atpellentesque laoreet</p>",
        null ];


        // Arabic Data
        $title_ar = [
            "إنشاء مواقع ويب للشركات الكبيرة و الصغيرة",
            "معلومات عنا",
            "نحن نقدم أفضل حلول الويب",
            "سابقة اعمالنا ",
            "كيف نعمل",
            "اعرف المزيد عن حلول الويب لدينا",
            "لدينا مهارة مهنية",
            "فريق العمل",
            "تواصل معنا ",
            "نحن هنا للإجابة على أسئلتك على مدار اليوم"
        ];
    
            $subtitle_ar = [
            "أفضل حلول برمجة الويب",
            "نحن شركة برمجة مواقع ويب ",
            null,
            "سابقة الأعمال",
            "آلية العمل",
            "الأسئلة التي قد تتبادر إلى ذهنك",
            "مهارة احترافية",
            "تعرف على فريق العمل",
            "ابقى على تواصل",
            "تحتاج إلى خدمات الحل"];
    
            $description_ar = [
            "ً<p>نحن من ذوي الخبرة في إنشاء مواقع الويب التي يمكن أن تخدم أعمالك وتلبي جميع متطلباتك</p>",
    
            "<p>مرحبًا بكم في شركة بلانكو تك، الشركة الرائدة في مجال تطوير الويب والملتزمة بتقديم تجارب رقمية استثنائية. بفضل شغفنا بالإبداع والخبرة التقنية، نحن متخصصون في صياغة حلول الويب المخصصة التي تساعد الشركات على الازدهار في العالم الرقمي. في بلانكو تك، نحن نفهم قوة موقع الويب المصمم جيدًا. إنها بمثابة واجهة متجر رقمية لعلامتك التجارية، حيث تربطك بجمهورك المستهدف وتدفع النمو. يعمل فريقنا من مطوري الويب والمصممين والاستراتيجيين الرقميين المهرة بشكل تعاوني لإنشاء مواقع ويب جذابة تركز على المستخدم وتترك انطباعًا دائمًا.</p>",
            
            "<p>نحن نقدم مجموعة شاملة من خدمات تطوير الويب لمساعدة الشركات على تأسيس تواجد قوي عبر الإنترنت وتحقيق أهدافها الرقمية. مع فريق من المهنيين ذوي المهارات العالية، فإننا نجمع بين الإبداع والخبرة الفنية وأفضل ممارسات الصناعة لتقديم حلول ويب استثنائية. وهنا بعض من الخدمات التي نقدمها</p>",
            
            "<p>نحن نفخر بالمجموعة المتنوعة من المشاريع التي نجحنا في تسليمها لعملائنا. تعرض  سابقة اعمالنا خبرتنا في تطوير الويب والتصميم والحلول الرقمية</p>",
    
            "<p>تم تصميم الية العمل لدينا لإبقاء عملائنا مشاركين ومطلعين وراضين طوال كل مرحلة من مراحل المشروع. وفيما يلي نظرة عامة على عملية عملنا</p>",

            "<p>إذا كان لديك المزيد من الأسئلة، نحن هنا للمساعدة! لا تتردد في الاتصال بنا، وسيكون فريقنا سعيدًا بتزويدك بمزيد من المعلومات ومعالجة أي مخاوف محددة قد تكون لديك</p>",
            null,
            "<p>لقد قمنا بتجميع فريق من المهنيين ذوي المهارات العالية والحماس الذين يكرسون جهودهم لتقديم حلول استثنائية لتطوير الويب</p>",

            "<p>نحن نقدر التواصل المفتوح والشفاف مع عملائنا. سواء كان لديك سؤال، أو فكرة مشروع، أو ببساطة تريد معرفة المزيد حول خدمات تطوير الويب لدينا، فإن فريقنا موجود لمساعدتك</p>",
            
            "<p>Dcidunt eget semper nec quam. Sed hendrerit. acfelis Nunc egestas augue atpellentesque laoreet</p>",
            null];    

            $identifiers=["home-banner","about-us","service-section",
                          "portfolio-section","process-section","faq-section",
                          "skills-section","team-section","contact-section","solution-section"];  

             $images=[  ["images/6Uc5BhjmQJtfneedg6lKQ4U0Mh4SHOs5OAd8StZd.webp",],
                        ["images/dbfWCgbV5jglKcWKTYT6SeIsuAsQxCQ4GGDLHXex.webp"],
                        null,
                        null,
                        null,
                        ["images/8dTGgGdIWqURKxo2SYehtgjCL3AKeSKmINcUVMyy.webp"],
                        ["images/l2K1cEb5wcsPVzhHhj2OWNcQXBPKKrofxrfhgu5W.webp",
                         "images/khyVZVtSks0zZfm3NQAA3496oI8ovcN3rzKD9rX4.webp",
                         "images/NzpSLncvvrosX4WqGDJLZtWvY3Xrvxzw6saO8xr6.webp"],
                        null,
                        null,
                        null
                    ];
       

        for ($i = 0; $i < count($title_ar); $i++) {
            $page = Page::create([
                'ar' => [
                    'title' => $title_ar[$i],
                    'description' => $description_ar[$i],
                    'subtitle' => $subtitle_ar[$i],
                   
                ],
                'en' => [
                    'title' => $title_en[$i],
                    'description' => $description_en[$i],
                    'subtitle' => $subtitle_en[$i],
                   
                ],
                'identifier'=>$identifiers[$i]
            ]);

            if(isset($images[$i]))
            foreach($images[$i] as $image)
            $page->file()->create(["url"=>$image]);
     }
    }
}
