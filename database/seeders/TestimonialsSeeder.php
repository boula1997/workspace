<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
        $title_en = ["Omar Mohamed",
                     "Mohamed Ahmed",
                     "Alia Emad",
                     "Sherif Atef",
                     "Dalia Samir"];

        $subtitle_en = ["Customer,USA",
                        "Customer,USA",
                        "Customer,USA",
                        "Customer,USA",
                        "Customer,USA"];

        $description_en = ["<p>I had the pleasure of working with the team at Blanko Tech company for my website project, and I couldn't be happier with the results. From start to finish, they demonstrated a high level of professionalism, expertise, and dedication</p>",

        "<p> The team at Blanko Tech company took the time to understand my vision and goals for the website. They listened attentively to my requirements and provided valuable insights and suggestions to enhance the overall user experience. Their communication throughout the project was excellent, and they kept me updated on the progress regularly</p>",

        "<p>I was impressed by their technical skills and attention to detail. The website they created for me not only looks stunning but also functions flawlessly. They ensured that the site is responsive, optimized for search engines, and user-friendly. The design is modern, visually appealing, and aligned perfectly with my brand identity</p>",

        "<p>What sets Blanko Tech company apart is their commitment to customer satisfaction. They went above and beyond to address any concerns or modifications I had, and they were always prompt in their responses. Their customer service is truly exceptional.</p>",

        "<p>I highly recommend Blanko Tech company to anyone in need of professional web development services. They are a talented and reliable team that delivers outstanding results. Working with them has been a pleasure, and I look forward to collaborating with them again in the future</p>"];

        
        $title_ar = ["عمر محمد",
                     "محمد احمد",
                     " علياء عماد",
                     "شريف عاطف",
                     " داليا سمير"];

        $subtitle_ar =[ "العميل، الولايات المتحدة الأمريكية",
                        "العميل، الولايات المتحدة الأمريكية",
                        "العميل، الولايات المتحدة الأمريكية",
                        "العميل، الولايات المتحدة الأمريكية",
                        "العميل، الولايات المتحدة الأمريكية",];

        $description_ar =["<p> لقد كان من دواعي سروري العمل مع فريق شركة بلانكو تك في مشروع موقع الويب الخاص بي، ولم أستطع أن أكون أكثر سعادة بالنتائج. لقد أظهروا، منذ البداية وحتى النهاية، مستوىً عالٍ من الاحترافية والخبرة والتفاني </p>",

                            "<p>استغرق فريق شركة بلانكو تك الوقت الكافي لفهم رؤيتي وأهدافي للموقع. لقد استمعوا باهتمام لمتطلباتي وقدموا رؤى واقتراحات قيمة لتعزيز تجربة المستخدم الشاملة. كان تواصلهم طوال المشروع ممتازًا، وأبقوني على اطلاع دائم بالتقدم المحرز بانتظام.</p>",

                            "<p>لقد تأثرت بمهاراتهم الفنية واهتمامهم بالتفاصيل. موقع الويب الذي أنشأوه لي لا يبدو مذهلاً فحسب، بل يعمل أيضًا بشكل لا تشوبه شائبة. لقد تأكدوا من أن الموقع سريع الاستجابة ومُحسّن لمحركات البحث وسهل الاستخدام. التصميم حديث وجذاب بصريًا ويتوافق تمامًا مع هوية علامتي التجارية.</p>",

                            "<p>ما يميز شركة بلانكو تك هو التزامها برضا العملاء. لقد ذهبوا إلى أبعد من ذلك لمعالجة أي مخاوف أو تعديلات كانت لدي، وكانوا دائمًا سريعين في ردودهم. خدمة العملاء الخاصة بهم استثنائية حقًا.</p>",

                            "<p>أوصي بشدة بشركة بلانكو تك لأي شخص يحتاج إلى خدمات تطوير الويب الاحترافية. إنهم فريق موهوب وموثوق يحقق نتائج رائعة. لقد كان العمل معهم ممتعًا، وأتطلع إلى التعاون معهم مرة أخرى في المستقبل</p>"];
 
        $image=["images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp",
                "images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp",
                "images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp",
                "images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp",
                "images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp"];
       

        for ($i = 0; $i < count($title_ar); $i++) {
            $Testimonial = Testimonial::create([
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
            ]);
            $Testimonial->file()->create(["url"=>$image[$i]]);
          }
    }
}
