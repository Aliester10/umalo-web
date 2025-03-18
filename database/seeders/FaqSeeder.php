<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_faq')->insert([
            [
                'id' => 1,
                'questions' => 'Apa layanan utama yang ditawarkan oleh PT Umalo Sedia Tekno?',
                'answers' => 'PT Umalo Sedia Tekno menawarkan berbagai layanan, termasuk infrastruktur TI, integrasi IoT, kecerdasan buatan (AI), dan keamanan siber. Kami juga menyediakan solusi khusus seperti simulasi laboratorium dan sistem otomasi cerdas.'
            ],
            [
                'id' => 2,
                'questions' => 'Apa visi PT Umalo Sedia Tekno?',
                'answers' => 'Visi kami adalah menjadi pemimpin global dalam teknologi cerdas dan solusi TI, dengan fokus pada inovasi yang mentransformasi lanskap digital.'
            ],
            [
                'id' => 3,
                'questions' => 'Apa yang dimaksud dengan layanan "Integrasi IoT"?',
                'answers' => 'Layanan Integrasi IoT kami menghubungkan perangkat dan sistem secara pintar untuk meningkatkan otomatisasi, analisis data, dan efisiensi operasional di berbagai sektor.'
            ],
            [
                'id' => 4,
                'questions' => 'Bagaimana PT Umalo Sedia Tekno membantu dalam keamanan siber?', 
                'answers' => 'Kami menyediakan solusi keamanan siber yang dirancang untuk melindungi bisnis dari ancaman digital, menjaga integritas data, dan memastikan keamanan informasi dengan langkah-langkah keamanan yang canggih.'
            ],
            [
                'id' => 5,
                'questions' => 'Siapa yang bisa menggunakan layanan "Simulasi Laboratorium" dari PT Umalo Sedia Tekno ?',
                'answers' => 'Layanan simulasi laboratorium kami dirancang untuk peneliti, akademisi, kampus, universitas, dan profesional di berbagai bidang ilmiah. Solusi ini memungkinkan penelitian dan pengujian yang lebih akurat dan efisien, serta mendukung tujuan pendidikan di berbagai lembaga.'
            ],
            [
                'id' => 6,
                'questions' => 'Apa manfaat utama dari layanan "Kecerdasan Buatan" yang ditawarkan',
                'answers' => 'Solusi AI kami membantu bisnis dalam meningkatkan pengambilan keputusan, efisiensi operasional, dan pengalaman pelanggan melalui aplikasi kecerdasan buatan yang inovatif.'
            ],
            [
                'id' => 7,
                'questions' => 'Apa solusi yang paling diminati dari PT Umalo Sedia Tekno?',
                'answers' => 'Beberapa solusi yang paling diminati oleh pelanggan kami adalah simulasi laboratorium, otomasi cerdas, dan infrastruktur TI cerdas yang mendukung kinerja dan skalabilitas optimal di berbagai industri.'
            ]
        ]);
    }
}
