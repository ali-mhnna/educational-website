<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instructor;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
        $instructors = [
            [
                'name' => 'د. أحمد محمد',
                'avatar' => 'instructors/instructor1.jpg',
                'bio' => 'خبير في تطوير تطبيقات الويب الحديثة مع أكثر من 10 سنوات من الخبرة في المجال. عمل على مشاريع كبيرة ومتنوعة.',
                'specialization' => 'تطوير الويب',
                'rating' => 4.9,
                'experience_years' => 10
            ],
            [
                'name' => 'د. سارة علي',
                'avatar' => 'instructors/instructor2.jpg',
                'bio' => 'متخصصة في لغة Python وتطبيقاتها في مجالات متعددة. حاصلة على دكتوراه في علوم الحاسوب.',
                'specialization' => 'البرمجة',
                'rating' => 4.7,
                'experience_years' => 8
            ],
            [
                'name' => 'د. محمد حسن',
                'avatar' => 'instructors/instructor3.jpg',
                'bio' => 'مصمم UI/UX محترف مع خبرة واسعة في تصميم تجارب المستخدم الاستثنائية.',
                'specialization' => 'تصميم الواجهات',
                'rating' => 4.9,
                'experience_years' => 12
            ],
            [
                'name' => 'م. خالد أحمد',
                'avatar' => 'instructors/instructor4.jpg',
                'bio' => 'مهندس قواعد بيانات معتمد مع خبرة عميقة في MySQL وإدارة قواعد البيانات الكبيرة.',
                'specialization' => 'قواعد البيانات',
                'rating' => 4.5,
                'experience_years' => 9
            ],
            [
                'name' => 'د. فاطمة حسن',
                'avatar' => 'instructors/instructor5.jpg',
                'bio' => 'خبيرة أمن سيبراني معتمدة، متخصصة في حماية الأنظمة والشبكات من الاختراقات.',
                'specialization' => 'الأمن السيبراني',
                'rating' => 4.8,
                'experience_years' => 11
            ],
            [
                'name' => 'د. عمر صالح',
                'avatar' => 'instructors/instructor6.jpg',
                'bio' => 'باحث في الذكاء الاصطناعي والتعلم العميق، له العديد من الأبحاث المنشورة عالمياً.',
                'specialization' => 'الذكاء الاصطناعي',
                'rating' => 4.9,
                'experience_years' => 15
            ],
            [
                'name' => 'أ. ليلى أحمد',
                'avatar' => 'instructors/instructor7.jpg',
                'bio' => 'خبيرة تسويق رقمي مع سجل حافل في بناء استراتيجيات تسويقية ناجحة للشركات.',
                'specialization' => 'التسويق الرقمي',
                'rating' => 4.6,
                'experience_years' => 7
            ],
            [
                'name' => 'د. نور الدين',
                'avatar' => 'instructors/instructor8.jpg',
                'bio' => 'مطور Full Stack متمرس، متخصص في بناء تطبيقات الويب المتقدمة باستخدام أحدث التقنيات.',
                'specialization' => 'تطوير الويب',
                'rating' => 4.7,
                'experience_years' => 9
            ],
        ];

        foreach ($instructors as $instructor) {
            Instructor::create($instructor);
        }
    }
}
