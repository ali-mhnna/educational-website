<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'تطوير تطبيقات الويب الكاملة',
                'description' => 'تعلم بناء تطبيقات ويب حديثة باستخدام أحدث التقنيات',
                'price' => 99.99,
                'rating' => 4.8,
                'image' => 'https://images.unsplash.com/photo-1516116216624-53e697fedbea?w=500',
                'instructor_id' => 1, 
                'is_featured' => true
            ],
            [
                'title' => 'أساسيات البرمجة بلغة Python',
                'description' => 'ابدأ رحلتك في عالم البرمجة مع بايثون',
                'price' => 79.99,
                'rating' => 4.6,
                'image' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?w=500',
                'instructor_id' => 2, 
                'is_featured' => true
            ],
            [
                'title' => 'تصميم واجهات المستخدم UI/UX',
                'description' => 'احترف تصميم واجهات جذابة وسهلة الاستخدام',
                'price' => 89.99,
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=500',
                'instructor_id' => 3,
                'is_featured' => true
            ],
            [
                'title' => 'قواعد البيانات MySQL',
                'description' => 'تعلم إدارة قواعد البيانات بشكل احترافي',
                'price' => 69.99,
                'rating' => 4.5,
                'image' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=500',
                'instructor_id' => 4, 
                'is_featured' => false
            ],
            [
                'title' => 'تطوير تطبيقات الموبايل',
                'description' => 'تعلم بناء تطبيقات iOS و Android',
                'price' => 109.99,
                'rating' => 4.7,
                'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=500',
                'instructor_id' => 1, 
                'is_featured' => false
            ],
            [
                'title' => 'الأمن السيبراني',
                'description' => 'تعلم حماية الأنظمة والشبكات من الاختراقات',
                'price' => 119.99,
                'rating' => 4.8,
                'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=500',
                'instructor_id' => 5, 
                'is_featured' => false
            ],
            [
                'title' => 'الذكاء الاصطناعي وتعلم الآلة',
                'description' => 'ادخل إلى عالم الذكاء الاصطناعي والتعلم العميق',
                'price' => 129.99,
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=500',
                'instructor_id' => 6, 
                'is_featured' => false
            ],
            [
                'title' => 'التسويق الرقمي',
                'description' => 'احترف التسويق عبر الإنترنت ووسائل التواصل',
                'price' => 74.99,
                'rating' => 4.6,
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500',
                'instructor_id' => 7, 
                'is_featured' => false
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}